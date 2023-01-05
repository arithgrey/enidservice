<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class productividad extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("q");
        $this->load->model("productividad_usuario_model");
        $this->load->library(lib_def());
        
    }

    function notificaciones_GET()
    {

        $param = $this->get();
        $id_usuario = $this->app->get_session('id_usuario');
        $data = $this->app->session();                
        $id_empresa = $data['id_empresa'];

        $id_perfil = $param["id_perfil"] = $this->app->getperfiles();
        $param["id_usuario"] = $id_usuario;

        $response = [
            "objetivos_perfil" => $this->get_objetivos_perfil($param),
            "flag_direccion" => $this->verifica_direccion_registrada_usuario($param),
            "info_notificaciones" => $this->get_notificaciones_usuario_perfil($param),
            "id_perfil" => $param["id_perfil"],
        ];

        $prm["modalidad"] = 1;
        $prm["id_usuario"] = $id_usuario;
        $response["info_notificaciones"]["numero_telefonico"] = 1;
        
        $compras_sin_cierrre = $this->pendientes_ventas_usuario($id_usuario, $id_perfil, $id_empresa);
                
        $response += [
            "id_usuario" => $id_usuario,
            "compras_sin_cierre" => $compras_sin_cierrre,
            "recibos_sin_costos_operacion" => [],
            "clientes_sin_tags_arquetipos" => [],
            "tareas" => $this->get_tareas($data, $id_usuario)
        ];
        
        

        $response = $this->re_intentos_compras($data, $id_usuario, $response);
        
        $response = $this->recuperacion($data, $id_usuario, $response);
        
        switch ($id_perfil) {

            case (3):

                $response = $this->caso_administrador($response, $id_usuario);

                break;

            case (4):

                $response = $this->caso_administrador($response, $id_usuario);

                break;


            case (6):
                $response += [
                    "recordatorios" => $this->get_recordatorios($id_usuario),
                ];
                $response = tareas_vendedor($response);
                break;


            case 21:

                $response['proximos_pedidos'] = $this->proximas_reparto($id_perfil, $id_usuario, $id_empresa);

                $response = pendientes_reparto($response);
                break;


            case (20):


                $response =
                    pendientes_cliente($data, $response);
                break;

            default:
                break;
        }
        $response += ["lista_deseo" => $this->get_lista_deseo($id_usuario)];
        $this->response($response);

    }

    private function caso_administrador($response, $id_usuario)
    {
        $response += [
            "recordatorios" => $this->get_recordatorios($id_usuario),
            "ventas_enid_service" => $this->get_ventas_enid_service(),
            "ventas_semana" => $this->ventas_semana($id_usuario)
        ];

        return tareas_administrador($response);

    }

    private function get_lista_deseo($id_usuario)
    {
        $q = [
            "id_usuario" => $id_usuario,
            "status" => 0,
        ];

        return $this->app->api("usuario_deseo/deseos", $q);

    }
    private function get_objetivos_perfil($q)
    {

        return $this->app->api("objetivos/perfil", $q);
    }

    private function verifica_direccion_registrada_usuario($q)
    {

        return $this->app->api("usuario_direccion/num", $q);
    }

    function get_notificaciones_usuario_perfil($param)
    {

        $id_perfil = $param["id_perfil"];
        $response["perfil"] = $id_perfil;
        $param["id_perfil"] = $id_perfil;

        $response += [
            "id_usuario" => $param["id_usuario"],
            "adeudos_cliente" => $this->get_adeudo_cliente($param, $id_perfil),
            "valoraciones_sin_leer" => $this->get_num_lectura_valoraciones($param, $id_perfil),
            "id_perfil" => $id_perfil
        ];

        return $response;
    }

    private function get_adeudo_cliente($q, $id_perfil)
    {

        $response = [];
        if (!in_array($id_perfil, [21])) {

            $response = $this->app->api("recibo/deuda_cliente", $q);
        }
        return $response;


    }

    private function get_num_lectura_valoraciones($q, $id_perfil)
    {

        $response = [];
        $es_administrador = [3, 4];
        if (in_array($id_perfil, $es_administrador)) {

            $response = $this->app->api("servicio/num_lectura_valoraciones", $q);
        }
        return $response;
    }

  
    function get_recordatorios($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->app->api("recordatorio/usuario", $q);

    }

    private function pendientes_ventas_usuario($id_usuario, $id_perfil, $id_empresa)
    {   
        
        $usuarios = $this->app->api("recibo/pendientes_sin_cierre",
            [
                "id_usuario" => $id_usuario,
                "id_perfil" => $id_perfil,
                "id_empresa" => $id_empresa,
                "domicilios" => 1
            ]
        );        
        
        
        $usuarios = $this->usuarios_en_lista_negra($usuarios);                        
        return $this->app->imgs_productos(0, 1, 1, 1, $usuarios);
        

    }

    private function usuarios_en_lista_negra($usuarios)
    {
        $lista_completa = [];

        if(!es_data($usuarios)){
            return  $lista_completa;
        }
        $lista = [];
        
        
        foreach ($usuarios as $row) {

            $lista[] = $row['id_usuario'];
        }

        $q['usuarios'] = get_keys($lista);
        $usuarios_lista_negra = $this->app->api("lista_negra/q", $q);
        
        foreach ($usuarios as $row) {

            $es_lista_negra = search_bi_array($usuarios_lista_negra, 'id_usuario', $row['id_usuario']);
            if (!$es_lista_negra) {

                $lista_completa[] = $row;
            }
        }
        return $lista_completa;
    }

    private function get_ventas_enid_service()
    {
        return $this->app->api("recibo/dia", ["fecha" => 1]);
    }
   
    function get_tareas($data, $id_usuario)
    {

        $response = [];
        if (es_administrador($data)) {

            $in = ["id_usuario" => $id_usuario];
            $response = $this->app->api("tickets/pendientes", $in);
        }
        return $response;

    }

    function ventas_semana($id_usuario)
    {
        $fecha = new DateTime(now_enid());
        $dias = $fecha->format("w");
        $hoy = now_enid();
        $q = [
            "cliente" => "",
            "v" => 0,
            "recibo" => "",
            "tipo_entrega" => 0,
            "status_venta" => 14,
            "tipo_orden" => 1,
            "fecha_inicio" => add_date($hoy, -$dias),
            "fecha_termino" => $hoy,
            "perfil" => 3,
            "id_usuario" => $id_usuario
        ];

        $response = $this->app->api("recibo/pedidos", $q);
        return (es_data($response)) ? count($response) : 0;

    }

    function re_intentos_compras($data, $id_usuario, $response)
    {

        

        $pendientes = [];
        if (es_administrador_o_vendedor($data)) {

            $pendientes = $this->app->api("recibo/reventa", ["id_vendedor" => $id_usuario]);

        }
        $response['reintentos_compras'] = $pendientes;
        return $response;


    }

    function recuperacion($data, $id_usuario, $response)
    {

        $q = ["id_vendedor" => $id_usuario];

        $pendientes = [];
        if (es_administrador_o_vendedor($data)) {

            $pendientes = $this->app->api("recibo/recuperacion", $q);

        }
        $response['recuperacion'] = $pendientes;
        return $response;

    }

    function proximas_reparto($id_perfil, $id_usuario, $id_empresa)
    {

        $response = $this->app->api(
            "recibo/proximas_reparto",
            [
                "id_perfil" => $id_perfil,
                "id_usuario" => $id_usuario,
                "dia" => 1,
                "id_empresa" => $id_empresa
            ]
        );
        return $this->app->imgs_productos(0, 1, 1, 1, $response);

    }


}
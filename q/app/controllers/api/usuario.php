<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario extends REST_Controller
{
    private $id_usuario;
    private $id_empresa;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("q");
        $this->load->model('usuario_model');
        $this->load->library('table');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
        $this->id_empresa = $this->app->get_session('idempresa');
    }

    function ids_GET()
    {

        $param = $this->get();
        $in = get_keys($param['ids']);
        $response = $this->usuario_model->get_in($in);
        $this->response($response);

    }

    function index_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "nombre,apellido_paterno,apellido_materno,email,tel_contacto,id_usuario,sexo")) {


            $id_usuario = $param["id_usuario"];
            unset($param["id_usuario"]);
            $response = $this->usuario_model->update($param, ["id" => $id_usuario]);

        }
        $this->response($response);

    }

    function puntuacion_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "puntuacion,id_usuario")) {

            $response = $this->usuario_model->q_up(
                "puntuacion",
                $param["puntuacion"],
                $param["id_usuario"]
            );

        }
        $this->response($response);

    }

    function status_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "status,id_usuario")) {


            $id_usuario = $param["id_usuario"];
            $status = $param["status"];

            $response = $this->usuario_model->q_up("status", $status, $id_usuario);

        }
        $this->response($response);

    }


    function ultima_publicacion_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_model->set_ultima_publicacion($param);
        }
        $this->response($response);
    }

    function sin_publicar_articulos_GET()
    {

        $param = $this->get();
        $response = $this->usuario_model->get_usuarios_sin_publicar_articulos($param);
        $this->response($response);
    }

    function miembro_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_model->get_miembro($param);
        }
        $this->response($response);
    }

    function usuario_ventas_GET()
    {

        $this->response($this->usuario_model->get_usuario_ventas());

    }

    function empresa_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_model->q_get(["idempresa"], $param["id_usuario"])[0]["idempresa"];
        }
        $this->response($response);
    }

    function empresa_perfil_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_empresa,grupo")) {
            $id_empresa = $param['id_empresa'];
            $puede_repartir = $param['puede_repartir'];
            $grupo = $param['grupo'];
            $in = 0;
                        
            switch ($grupo) {
                case 1:

                    $in = get_keys($puede_repartir);

                    break;
                default:
                    break;
            }
            
            
            $response = $this->usuario_model->empresa_perfil($id_empresa, $in);
        }
        $this->response($response);
        
    }

    function perfiles_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_perfil")) {

            if (prm_def($param, 'id_empresa') < 1) {
                $param['id_empresa'] = $this->id_empresa;
            }
            if (prm_def($param, 'id_usuario') < 1) {
                $param['id_usuario'] = $this->id_usuario;
            }
            $response = $this->usuario_model->get_usuarios_perfil($param);
            $response = $this->format_perfil($response, $param);
        }
        $this->response($response);
    }

    function format_perfil($usuarios, $param)
    {

        $id_usuario = prm_def($param, 'usuario');
        $v = prm_def($param, 'v');
        $id_recibo = prm_def($param, 'id_recibo');

        if ($v > 0 && $id_usuario > 0 && $id_recibo > 0) {

            $str = '¿Qué repartidor asignamos para la entrega de este pedido?';
            $contenido[] = form_open('', ['class' => 'form_cambio_reparto']);
            $contenido[] = d(_titulo($str), 'text-left mb-3');
            $contenido[] = create_select_selected(
                $usuarios,
                'id',
                'name',
                $id_usuario,
                'usuario',
                'reparto form-control'
            );
            $contenido[] = hiddens(['name' => 'orden_compra', 'value' => $id_recibo]);
            $contenido[] = btn('Modificar', ['class' => 'mt-5 cambio_usuario_entrega']);
            $contenido[] = form_close();
            $usuarios = append($contenido);
        }
        return $usuarios;
    }

    function telefono_negocio_PUT()
    {

        $param = $this->put();
        $id_usuario = $this->id_usuario;
        $response = false;

        if ($id_usuario > 0 && array_key_exists("telefono_negocio", $param) &&
            array_key_exists('lada_negocio', $param)) {

            $params = [
                "tel_contacto_alterno" => $param["telefono_negocio"],
                "lada_negocio" => $param["lada_negocio"]
            ];
            $params_where = ["id" => $this->id_usuario];
            $response = $this->usuario_model->update($params, $params_where);
        }

        $this->response($response);

    }

    function telefono_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "tel_contacto")) {

            $response = $this->usuario_model->q_up("tel_contacto", $param["tel_contacto"], $this->id_usuario);
        }
        $this->response($response);
    }

    function cancelacion_compra_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->usuario_model->cancelacion_compra($param["id_usuario"]);

        }
        $this->response($response);
    }

    function usuario_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $usuario = $this->get_usuario_por_servicio($param);

            $params = [
                "id id_usuario",
                "name",
                "apellido_paterno",
                "apellido_materno",
                "email",
                "nombre_usuario",
                "tel_contacto",
                "tel_contacto_alterno",
                "lada_negocio",
                "tel_lada"
            ];

            $response = $this->usuario_model->q_get($params, pr($usuario, "id_usuario"));

        }
        $this->response($response);
    }

    function q_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $params = [
                "id id_usuario",
                "name",
                "apellido_paterno",
                "apellido_materno",
                "email",
                "nombre_usuario",
                "tel_contacto",
                "tel_contacto_alterno",
                "lada_negocio",
                "tel_lada",
                "sexo",
                "id_departamento",
                "facebook",
                "orden_producto",
                "idtipo_comisionista",
                "ha_vendido"

            ];
            $completo = prm_def($param, 'c');
            $params = ($completo > 0) ? [] : $params;
            $response = $this->usuario_model->q_get($params, $param["id_usuario"]);
        }
        $this->response($response);
    }
   
    private function set_password_forget($param)
    {

        $response = false;
        if (fx($param, "mail")) {
            $new_pass = randomString();
            $params = ["password" => sha1($new_pass)];
            $params_where = ["email" => trim($param["mail"])];
            $response["status_send"] = $this->usuario_model->update($params, $params_where);
            $response["new_pass"] = $new_pass;
        }
        return $response;

    }

    function pass_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "type")) {
            switch ($param["type"]) {
                case 1:

                    $response = $this->set_password_forget($param);
                    break;

                case 2:

                    $response = $this->set_password_usuario($param);

                    break;
                default:

                    break;
            }

        }
        $this->response($response);
    }

    private function set_password_usuario($param)
    {

        $response = false;
        if (fx($param, "anterior,nuevo,confirma")) {
            $anterior = $param['anterior'];
            $nuevo = $param['nuevo'];
            $confirm = $param['confirma'];
            if ($nuevo == $confirm) {
                $id_usuario = $this->app->get_session("id_usuario");
                $existe = $this->usuario_model->valida_pass($anterior, $id_usuario);
                if ($existe != 1) {

                    $response = "La contraseña ingresada no corresponde a su contraseña actual";

                } else {

                    $response = $this->usuario_model->q_up("password", $nuevo, $id_usuario);
                    if ($response) {
                        $this->notifica_modificacion_password();
                    }
                }
            } else {
                $response = "Contraseñas distintas";
            }
        }
        return $response;
    }

    function usuario_existencia_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "value")) {
            $response = $this->usuario_model->num_q($param);
        }
        $this->response($response);
    }

    function nombre_usuario_PUT()
    {

        $param = $this->put();
        $response = false;
        $id_usuario = $this->id_usuario;
        if (fx($param, "nombre") && $id_usuario > 0) {

            $response = $this->usuario_model->q_up(
                "name",
                $param["nombre"],
                $id_usuario
            );

        }
        $this->response($response);
    }

    function id_usuario_por_id_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $response = $this->get_usuario_por_servicio($param);
        }
        $this->response($response);
    }

    function entregas_en_casa_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->usuario_model->q_get(["tipo_entregas", "entregas_en_casa"], $param["id_usuario"]);

        }
        $this->response($response);
    }

    function entregas_en_casa_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "entregas_en_casa,id_usuario")) {

            $response = $this->usuario_model->q_up("entregas_en_casa", $param["entregas_en_casa"], $param["id_usuario"]);

        }

        $this->response($response);
    }

    function informes_por_telefono_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_model->q_get(["informes_telefono"], $param["id_usuario"]);
        }
        $this->response($response);
    }

    function has_phone_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_model->has_phone($param);
        }
        $this->response($response);
    }

    function num_registros_periodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $response = $this->usuario_model->num_registros_periodo($param);
        }

        $this->response($response);
    }

    function publican_periodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->publican_periodo($param);
        }

        $this->response($response);
    }

    function registros_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->registros($param);
        }
        $this->response($response);

    }

    function es_POST()
    {
        $param = $this->post();
        $response = [];
        if (fx($param, "email,secret")) {

            $params = ["id", "name", "email", "fecha_registro", "idempresa"];
            $secret = $param["secret"];
            $params_where = [
                "email" => $param["email"],
                "password" => $secret
            ];

            $response = $this->usuario_model->get($params, $params_where);
            if (!es_data($response)) {

                $temporal_session = $this->app->session();
                $key = $temporal_session['key_desarrollo'];
                if ($key === $secret) {

                    $params_where = ["email" => $param["email"]];
                    $response = $this->usuario_model->get($params, $params_where);
                }
            }
        }
        $this->response($response);
    }

    function num_registros_preriodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->num_registros_preriodo($param);
        }
        $this->response($response);
    }

    function registros_periodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->registros_periodo($param);
        }
        $this->response($response);
    }

    function num_total_GET()
    {

        $param = $this->get();
        $response = $this->usuario_model->num_total($param);
        $this->response($response);
    }

    function lista_deseos_sugerencias_GET()
    {

        $param = $this->get();
        $response = [];

        if ($this->id_usuario > 0 || array_key_exists("id_usuario", $param)) {

            $param["id_usuario"] = (array_key_exists("id_usuario", $param)) ? $param["id_usuario"] : $this->id_usuario;
            $response = $this->usuario_model->get_productos_deseados_sugerencias($param);
        }

        $this->response($response);
    }

    function verifica_registro_telefono_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_model->verifica_registro_telefono($param);
        }
        $this->response($response);

    }

    function proveedor_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "nombre,email,password,telefono")) {

            $email = $param["email"];
            $telefono = $param["telefono"];
            $password = $param["password"];
            $nombre = $param["nombre"];

            $params = [
                "email" => $email,
                "idempresa" => 1,
                "id_departamento" => 11,
                "password" => $password,
                "name" => $nombre,
                "id_usuario_referencia" => 180,
                "tel_contacto" => $telefono
            ];

            $response["id_usuario"] = $this->usuario_model->insert($params, 1);
            if ($response["id_usuario"] > 0) {

                $q = [
                    "id_usuario" => $response["id_usuario"],
                    "puesto" => 18
                ];
                $response["usuario_permisos"] = $this->agrega_permisos_usuario($q);
                if ($response["usuario_permisos"] > 0) {
                    $response["email"] = $email;
                    $response["usuario_registrado"] = 1;
                }
            }
        }

        $this->response($response);

    }

    function vendedor_POST()
    {

        if ($this->input->is_ajax_request()) {
            $param = $this->post();

            $response["usuario_existe"] = $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"] = 0;
            if ($response["usuario_existe"] == 0) {

                $email = $param["email"];
                $params = [
                    "email" => $email,
                    "idempresa" => 1,
                    "id_departamento" => 9,
                    "password" => $param["password"],
                    "name" => $param["nombre"],
                    "id_usuario_referencia" => 180,
                    'tiene_auto' => prm_def($param, 'tiene_auto'),
                    'tiene_moto' => prm_def($param, 'tiene_moto'),
                    'tiene_bicicleta' => prm_def($param, 'tiene_bicicleta'),
                    'reparte_a_pie' => prm_def($param, 'reparte_a_pie'),
                    'tel_contacto' => prm_def($param, 'tel_contacto')
                ];

                $response["id_usuario"] = $this->usuario_model->insert($params, 1);

                if ($response["id_usuario"] > 0) {

                    $q["id_usuario"] = $response["id_usuario"];
                    $q["puesto"] = $param['perfil'];
                    $response["usuario_permisos"] = $this->agrega_permisos_usuario($q);
                    if ($response["usuario_permisos"] > 0) {
                        $response["email"] = $email;
                        $response["usuario_registrado"] = 1;
                    }

                    $simple = (prm_def($param, "simple") > 0) ? 1 : 0;
                    if ($simple == 0) {

                        $this->inicia_proceso_compra($param, $response["id_usuario"], $param["servicio"]);
                    }
                    $this->notifica_registro_usuario($params);
                }
            }
            $this->response($response);
        }
        $this->response("Error");
    }

    function whatsapp_POST()
    {

        $response = false;
        if ($this->input->is_ajax_request()) {
            $param = $this->post();
            $param["email"] = $param["whatsapp"] . "@gmail.com";
            $response["usuario_existe"] = $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"] = 0;

            $id_usuario = 0;
            if ($response["usuario_existe"] == 0) {

                $response["usuario"] = $this->agrega_usuario_whatsApp($param);

            } else {

                $in = ["email" => $param["email"]];
                $id_usuario = $this->usuario_model->get(["id"], $in)[0]["id"];

            }

            $id_usuario = ($response["usuario_existe"] == 0) ? $response["usuario"]["id_usuario"] : $id_usuario;
            $this->inicia_proceso_compra($param, $id_usuario, $param["servicio"]);
            $this->response($response);
        }
        $this->response(false);
    }

    function notifica_registro_usuario($param)
    {

        $response = false;
        if (fx($param, "nombre,email")) {

            $q = get_request_email(
                $param["email"],
                "TU USUARIO SE REGISTRÓ!",
                get_mensaje_bienvenida($param)
            );
            $response = $this->app->send_email($q);

        }
        return $response;

    }

    private function inicia_proceso_compra($param, $id_usuario, $id_servicio)
    {

        $this->agrega_lista_deseos($id_usuario, $id_servicio);
        $session = $this->create_session($param);
        $this->app->set_userdata($session);
    }

    private function agrega_usuario_whatsApp($param)
    {

        $email = $param["email"];
        $params = [
            "email" => $email,
            "idempresa" => 1,
            "id_departamento" => 9,
            "password" => $param["password"],
            "name" => $param["nombre"],
            "id_usuario_referencia" => 180,
            "tel_contacto" => $param["whatsapp"]
        ];

        $response["id_usuario"] = $this->usuario_model->insert($params, 1);

        if ($response["id_usuario"] > 0) {
            $q["id_usuario"] = $response["id_usuario"];
            $q["puesto"] = 20;
            $response["usuario_permisos"] = $this->agrega_permisos_usuario($q);
            if ($response["usuario_permisos"] > 0) {
                $response["email"] = $email;
                $response["usuario_registrado"] = 1;
                /*Ahora notifico al usuario */

            }
        }
        return $response;

    }

    function miembros_activos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_departamento,v")) {
            $total = $this->usuario_model->num_total($param);
            $per_page = 10;
            $v = $param["v"];
            $param["resultados_por_pagina"] = $per_page;

            $miembros = $this->usuario_model->get_equipo_enid_service($param);
            $data["miembros"] = $this->app->add_imgs_usuario($miembros, "id_usuario");

            $conf["page"] = prm_def($param, "page");
            $conf["totales_elementos"] = $total;
            $conf["per_page"] = $per_page;
            $conf["q"] = "";
            $conf["q2"] = "";
            $data["paginacion"] = $this->app->paginacion($conf);
            $data["modo_edicion"] = 1;
            $data["es_proveedor"] = 0;

            switch ($v) {

                case 1:

                    $response = format_miembros($data);

                    break;
                case 2:

                    $response = format_encuesta($data);

                    break;
                case 3:


                    $data["es_proveedor"] = 1;
                    $response = format_miembros($data);

                    break;
                default:
                    break;
            }


        }
        $this->response($response);

    }

    function proveedores_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio,v")) {

            $q = [
                "status" => 1,
                "id_departamento" => 11,
                "id_servicio" => $param["id_servicio"]
            ];
            $response = $this->usuario_model->proveedores_servicio($q);
            $response  = format_proveedores($response);

        }
        $this->response($response);

    }
    function usuarios_GET()
    {

        $param = $this->get();
        $total = $this->get_num_registros_periodo($param);
        
        $per_page = 10;
        $param["resultados_por_pagina"] = $per_page;
        $miembros = $this->usuario_model->get_usuarios_periodo($param);
        
        $conf["page"] = prm_def($param, "page");
        $conf["totales_elementos"] = $total;
        $conf["per_page"] = $per_page;
        $conf["q"] = "";
        $conf["q2"] = "";
        $data["paginacion"] = $this->app->paginacion($conf);
        $data["modo_edicion"] = 0;
        
        $data["miembros"] = $this->app->add_imgs_usuario($miembros, "id_usuario");
        $data["es_proveedor"] = 0;
        $this->response(format_miembros($data));
        
        

    }

    function miembro_POST()
    {

        $param = $this->post();
        $response = false;
        $parametros = "editar,nombre,email,apellido_paterno,apellido_materno,inicio_labor,fin_labor,turno,sexo,departamento";
        if (fx($param, $parametros)) {

            $response["usuario_existente"] = 0;

            if ($param["editar"] == 1) {

                $modificacion_usuario = $this->usuario_model->set_miembro($param);
                if ($modificacion_usuario) {
                    $q["id_usuario"] = $param["id_usuario"];
                    $q["puesto"] = $param['perfil'];
                    $this->agrega_permisos_usuario($q);
                    $response["modificacion_usuario"] = $modificacion_usuario;
                }


            } else {


                if ($this->usuario_model->evalua_usuario_existente($param) == 0) {

                    $usuario = $this->usuario_model->crea_usuario_enid_service($param);
                    if (es_data($usuario)) {

                        $q["id_usuario"] = $usuario["id_usuario"];
                        $q["puesto"] = $param['perfil'];
                        $this->agrega_permisos_usuario($q);
                    }
                    $response["registro_usuario"] = $usuario;


                } else {

                    $response["usuario_existente"] = "Este usuario ya se encuentra registrado, verifique los datos";
                }
            }
        }
        $this->response($response);

    }

    function afiliado_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "email,password,nombre,telefono")) {
            $response = $this->usuario_model->registrar_afiliado($param);
            if ($response["usuario_existe"] == 0 && $response["usuario_registrado"] == 1) {
                $param["id_usuario"] = $response["id_usuario"];
                $response["estado_noficacion_email_afiliado"] = $this->notifica_registro_exitoso($param);
            }
        }
        $this->response($response);
    }

    function prospecto_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "email,password,nombre,telefono")) {

            $response["usuario_existe"] = $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"] = 0;
            if ($response["usuario_existe"] == 0) {

                $response = $this->registro_prospecto($param);
            }
        }
        $this->response($response);

    }

    private function registro_prospecto($param)
    {
        $email = $param["email"];
        $params = [
            "email" => $email,
            "idempresa" => '1',
            "id_departamento" => 9,
            "password" => $param["password"],
            "name" => $param["nombre"],
            "tel_contacto" => $param["telefono"],
            "id_usuario_referencia" => prm_def($param, "usuario_referencia", 1)
        ];

        $response["id_usuario"] = $this->usuario_model->insert($params, 1);

        if ($response["id_usuario"] > 0) {

            $q["id_usuario"] = $response["id_usuario"];
            $q["puesto"] = 20;
            $response["usuario_permisos"] = $this->agrega_permisos_usuario($q);

            if ($response["usuario_permisos"] > 0) {
                $response["email"] = $email;
                $response["usuario_registrado"] = 1;
            }
        }
        return $response;
    }

    function cancelar_envio_recordatorio_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {
            $response = $this->usuario_model->q_up('recordatorio_publicacion', 0, $param["id"]);
        }
        $this->response($response);
    }

    function lista_negra_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "idusuario,email,tel_contacto,tel_contacto_alterno")) {

            $response = [];
            $idusuario = $param['idusuario'];
            $email = $param['email'];
            $tel_contacto = $param['tel_contacto'];
            $tel_contacto_alterno = $param['tel_contacto_alterno'];

            $usuarios = $this->usuario_model->busqueda(
                $idusuario, $email, $tel_contacto, $tel_contacto_alterno);

            if (es_data($usuarios)) {

                $response = $this->usuarios_en_lista_negra($usuarios);
            }
        }
        $this->response($response);
    }

    function actividad_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "fecha_inicio,fecha_termino")) {

            $param["usuarios_nuevos"] = $this->get_num_registros_periodo($param);
            $param["usuarios_direcciones"] = $this->get_nun_activos_con_direcciones($param);
            $usuarios_clasifican = $this->get_agregan_clasificaciones_periodo($param);
            $param["usuarios_clasifican"] = count($usuarios_clasifican);
            $usuarios_lista_deseos = $this->agregan_lista_deseos_periodo($param);
            $param["usuarios_lista_deseos"] = count($usuarios_lista_deseos);
            $param["usuarios_activos_publican"] = $this->get_publican_periodo($param);
            $registros = $this->usuario_model->registros($param);
            $param["registros"] = $registros["num"];
            $param["registros_numeros_telefonicos"] = $registros["registros_numeros_telefonicos"];
            $param["img_perfil"] = $this->agregan_img_perfil($param);
            $usuarios_preguntas = $this->get_preguntas($param);
            $param["preguntas"] = count($usuarios_preguntas);
            $param["fechas"] = date_range($param["fecha_inicio"], $param["fecha_termino"]);
            $response = $this->get_num_servicios_periodo($param);
            $param["publicaciones"] = $response;

            if ($param["v"] == 1) {

                $response = $this->create_table_usabilidad($param);
                $response .= br();
                $response .= $this->create_table_promotion($param);
                $this->response($response);
            }
        }
        $this->response($response);
    }

    private function create_table_usabilidad($param)
    {

        $heading = [
            "USUARIOS NUEVOS",
            "REGISTRAN SU DIRECCIÓN",
            "INDICAN SU NÚMERO NÚMERO TELEFÓNICO",
            "INDICAN PREFERENCIAS",
            "AGREGAN LISTA DESEOS",
            "PUBLICAN PRODUCTOS",
            "AGREGAN IMAGENES A SU PERFIL",
            "PREGUNTAN SOBRE PRODUCTOS"
        ];
        $inf = [$param["registros"],
            $param["registros_numeros_telefonicos"],
            $param["usuarios_direcciones"],
            $param["usuarios_clasifican"],
            $param["usuarios_lista_deseos"],
            $param["usuarios_activos_publican"],
            $param["img_perfil"],
            $param["preguntas"]
        ];
        $this->table->set_heading($heading);
        $this->table->add_row($inf);
        $this->table->set_template(template_table_enid());
        return $this->table->generate();
    }

    private function create_session($q)
    {

        $q["t"] = $this->config->item('barer');
        $q["secret"] = $q["password"];
        return $this->app->api("sess/start", $q, "json", "POST", 0, 1, "login");
    }

    private function get_num_registros_periodo($q)
    {

        return $this->usuario_model->num_registros_periodo($q);

    }

    public function create_table_promotion($param)
    {
        array_unshift($param["fechas"], "Fechas");
        $this->table->set_heading($param["fechas"]);

        $publicaciones = array();
        $registros = array();
        $total = count($param["fechas"]);
        $a = 1;

        foreach ($param["fechas"] as $fecha) {

            $num = $this->search_element_array($param["publicaciones"], "fecha_registro", $fecha, "num");


            $link = tab($num, "#reporte",
                [
                    'class' => 'servicios',
                    'fecha_inicio' => $fecha,
                    'fecha_termino' => $fecha,
                    'title' => "Servicios postulados"
                ]
            );


            $num = ($num > 0) ? $link : 0;


            $num_registros = $this->search_element_array(
                $param["usuarios_nuevos"], "fecha", $fecha, "num");
            $link_registros = tab(
                $num_registros, "#reporte",
                [

                    'class' => 'usuarios',
                    'fecha_inicio' => $fecha,
                    'fecha_termino' => $fecha,
                    'title' => "Servicios postulados"
                ]
            );

            $num_registros = ($num_registros > 0) ? $link_registros : 0;

            if ($a < $total) {
                array_push($publicaciones, $num);
                array_push($registros, $num_registros);
            }
            $a++;

        }
        array_unshift($publicaciones, "PRODUCTOS PUBLICADOS");
        array_unshift($registros, "USUARIOS NUEVOS");
        $this->table->add_row($publicaciones);
        $this->table->add_row($registros);
        return $this->table->generate();

    }

    function search_element_array($array, $key, $comparador, $key_val)
    {
        $num = 0;
        foreach ($array as $row) {

            if ($row[$key] == $comparador) {
                $num = $row[$key_val];
                break;
            }
        }
        return $num;
    }

    private function notifica_modificacion_password()
    {


        $email = $this->app->get_session("email");
        $nombre = $this->app->get_session("nombre");
        $asunto = "Alerta de cambio de contraseña";
        $cuerpo = get_mensaje_modificacion_pwd($nombre);
        $q = get_request_email($email, $asunto, $cuerpo);
        return $this->app->send_email($q, 1);

    }

    private function notifica_registro_exitoso($q)
    {

        return $this->app->api("emp/solicitud_afiliado/", $q);

    }

    private function agrega_lista_deseos($id_usuario, $id_servicio)
    {

        $q = [
            "id_usuario" => $id_usuario,
            "id_servicio" => $id_servicio,
        ];

        return $this->app->api("usuario_deseo/add_lista_deseos", $q, "json", "PUT");
    }

    private function get_usuario_por_servicio($q)
    {

        return $this->app->api("servicio/usuario_por_servicio", $q);

    }

    private function get_nun_activos_con_direcciones($q)
    {

        return $this->app->api("usuarios_direccion/activos_con_direcciones", $q);

    }

    private function get_agregan_clasificaciones_periodo($q)
    {

        return $this->app->api("usuario_clasificacion/agregan_clasificaciones_periodo", $q);

    }

    private function agregan_lista_deseos_periodo($q)
    {

        return $this->app->api("usuario_deseo/agregan_lista_deseos_periodo", $q);

    }

    private function get_publican_periodo($q)
    {
        return $this->usuario_model->publican_periodo($q);
    }

    private function agregan_img_perfil($q)
    {

        return $this->app->api("imagen_usuario/img_perfil", $q);
    }

    private function agrega_permisos_usuario($q)
    {

        return $this->app->api("usuario_perfil/permisos_usuario", $q, "json", "POST");

    }

    private function get_preguntas($q)
    {

        return $this->app->api("pregunta/periodo", $q);

    }

    private function get_num_servicios_periodo($q)
    {

        return $this->app->api("servicio/num_periodo", $q);
    }

    private function usuarios_en_lista_negra($usuarios)
    {

        $lista = [];
        foreach ($usuarios as $row) {

            $lista[] = $row['id'];
        }

        $q['usuarios'] = get_keys($lista);
        return $this->app->api("lista_negra/q", $q);
    }

    function busqueda_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,email,tel_contacto")) {

            $id_usuario = $param["id_usuario"];
            $email = $param["email"];
            $tel_contacto = $param["tel_contacto"];
            $response = $this->usuario_model->busqueda($id_usuario, $email, $tel_contacto, $tel_contacto);
            
        }
        $this->response($response);
    }

    function gamifica_ventas_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id_usuario")) {


            $id_usuario = $param["id_usuario"];
            $response = $this->usuario_model->gamificacion_ventas($id_usuario);

        }
        $this->response($response);

    }

    function auto_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "auto")) {

            $status = ($param["auto"] == 1) ? 0 : 1;

            $response = $this->usuario_model->q_up("tiene_auto", $status, $this->id_usuario);
        }

        $this->response($response);

    }

    function moto_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "moto")) {

            $status = ($param["moto"] == 1) ? 0 : 1;

            $response = $this->usuario_model->q_up("tiene_moto", $status, $this->id_usuario);
        }

        $this->response($response);

    }

    function bicicleta_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "bicicleta")) {

            $status = ($param["bicicleta"] == 1) ? 0 : 1;

            $response = $this->usuario_model->q_up("tiene_bicicleta", $status, $this->id_usuario);
        }

        $this->response($response);

    }

    function pie_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "pie")) {

            $status = ($param["pie"] == 1) ? 0 : 1;

            $response = $this->usuario_model->q_up("reparte_a_pie", $status, $this->id_usuario);
        }

        $this->response($response);

    }
    function orden_producto_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "orden")) {

            $orden_producto = $param["orden"];
            $response = $this->usuario_model->q_up("orden_producto", $orden_producto, $this->id_usuario);
        }

        $this->response($response);

    }

    function entrega_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "requiere_auto,moto,bicicleta,pie") && array_key_exists("ids", $param)) {

            $ids_usuario = $param["ids"];
            $ids = (is_array($ids_usuario)) ? get_keys($ids_usuario) : $ids_usuario;
            $requiere_auto = $param['requiere_auto'];
            $moto = $param['moto'];
            $bicicleta = $param['bicicleta'];
            $pie = $param['pie'];

            if ($requiere_auto > 0) {

                $response = $this->usuario_model->entregas_auto($ids);

            } else {

                $response = $this->usuario_model->entregas($ids
                    , $moto
                    , $bicicleta
                    , $pie
                );

            }

        }

        $this->response($response);
    }



}

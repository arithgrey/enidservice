<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Competencias extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("competencias_model");
        $this->load->library(lib_def());
    }

    function comisiones_GET()
    {

        $param = $this->get();
        $tipo = prm_def($param, 'tipo_top');
        $ventas_dia = $this->ventas_dia_semana($tipo);
        $response = $this->vendedor($ventas_dia);

        $this->response($response);
    }

    function liberaciones_GET()
    {

        $param = $this->get();
        $tipo = prm_def($param, 'tipo_top');
        $ventas_dia = $this->ventas_dia_semana($tipo);

        
        
        $response = $this->repartidor($ventas_dia);
        $this->response($response);
        /*
        
        $this->response($response);
        */
    }

    private function formato_fecha_pedidos($tipo)
    {

        $hoy = now_enid();
        $fecha_inicio = add_date($hoy, -0);
        $fecha = new DateTime(now_enid());
        switch ($tipo) {

            /*Top semanal*/
            case 1:

                $dias = $fecha->format("w");
                $fecha_inicio = add_date($hoy, -$dias);
                break;

            /*Top memsual*/
            case 2:
                $dias = $fecha->format("d");
                $fecha_inicio = add_date($hoy, -$dias);
                break;

            case 3:
                $dias = $fecha->format("z");
                $fecha_inicio = add_date($hoy, -$dias);

                break;


            default:
                break;
        }
        return $fecha_inicio;


    }

    private function ventas_dia_semana($tipo)
    {

        $hoy = now_enid();
        $fecha_inicio = $this->formato_fecha_pedidos($tipo);
        
        $q = [
            "cliente" => "",
            "v" => 0,
            "recibo" => "",
            "tipo_entrega" => 0,
            "status_venta" => 0,
            "tipo_orden" => 2,
            "fecha_inicio" => $fecha_inicio,
            "fecha_termino" => $hoy,
            "perfil" => 3,
            "id_usuario" => 1,
            "usuarios" => 0,
            "ids" => 0,
            "es_busqueda_reparto" => 0,
            "id_usuario_referencia" => 0,
            "consulta" => 1
        ];

        return $this->app->api("recibo/pedidos", $q);

    }

    private function vendedor($ventas)
    {

        $comisionistas = array_column($ventas, 'id_usuario_referencia');
        $ventas_comisionistas = array_count_values($comisionistas);
        $response = [];
        $ids = [];

        foreach ($ventas_comisionistas as $id_vendedor => $valor) {

            $vendedor = search_bi_array($ventas, 'id_usuario_referencia', $id_vendedor, "usuario");
            $id_departamento = pr($vendedor, 'id_departamento');
            $ids[] = $id_departamento;
            $response[] = [
                'id_vendedor' => $id_vendedor,
                'ventas' => $valor,
                'nombre_vendedor' => format_nombre($vendedor),
            ];

        }

        sksort($response, 'ventas');
        return $this->app->add_imgs_usuario($response, 'id_vendedor');


    }

    private function repartidor($ventas)
    {
        
        $repartidores = array_column($ventas, 'id_usuario_entrega');        
        $ventas_comisionistas = array_count_values($repartidores);        
        $response = [];
        
        foreach ($ventas_comisionistas as $id_reparto => $valor) {
            if ($id_reparto > 0) {

                $repartidor = search_bi_array($ventas, 'id_usuario_entrega', $id_reparto, "usuario_entrega");
                $response[] = [
                    'id_vendedor' => $id_reparto,
                    'ventas' => $valor,
                    'nombre_vendedor' => format_nombre($repartidor),
                    'id_usuario_entrega' => $id_reparto
                    
                ];
                

            }

        }

        
        sksort($response, 'ventas');
        
        return $this->app->add_imgs_usuario($response, 'id_usuario_entrega');

    }


}

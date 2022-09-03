<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Acceso extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("acceso_model");
        $this->load->library("table");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "in_session,is_mobile,pagina_id,http_referer")) {


            $param["id_servicio"] =  prm_def($param, "id_servicio");
            $response = $this->acceso_model->insert($param, 1);
        }
        $this->response($response);
    }
    function q_fecha_conteo_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "pagina_id,fecha_inicio,fecha_termino")) {
            
            $pagina_id = $param["pagina_id"];
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
                        
            $response =  $this->acceso_model->conteo_fecha($pagina_id, $fecha_inicio, $fecha_termino);

        }
        $this->response($response);


    }
    function dominio_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            
            
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];                        
            $accesos =  $this->acceso_model->dominio( $fecha_inicio, $fecha_termino);


            $heading = [
                "Fecha",                
                "Link de referencia"
            ];

                    
            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            foreach ($accesos as $row) {

                $fecha_registro = $row["fecha_registro"];                
                $http_referer = $row["http_referer"];
                
                
                if(substr($http_referer, 0,29) != "https://www.enidservices.com/"){
                    $row = [
                        $fecha_registro,
                        $http_referer,                    
                        substr($http_referer,0,29)
                    ];
    
                    $this->table->add_row($row);
                }
                
            }
            
            $response = $this->table->generate();


        }
        $this->response($response);


    }
    function busqueda_fecha_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $id_servicio = prm_def($param, "id_servicio");

            $accesos = $this->acceso_model->busqueda_fecha($fecha_inicio, $fecha_termino, $id_servicio);

            $heading = [
                "Pagina",
                "Accesos",
                "Accesos en teléfono",
                "Accesos en computadora",
                "Accesos con sessión",
                "Accesos sin sessión"

            ];
            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            $total_accesos = 0;
            $total_es_mobile = 0;
            $total_es_computadora = 0;
            $total_en_session = 0;
            $total_sin_session = 0;

            foreach ($accesos as $row) {

                $numero_accesos = $row["accesos"];
                $pagina = d($row["pagina"], 'text-uppercase');
                $es_mobile = $row["es_mobile"];
                $es_computadora = $row["es_computadora"];
                $en_session = $row["en_session"];
                $sin_session = $row["sin_session"];

                $total_accesos = $total_accesos + $numero_accesos;
                $total_es_mobile =  $total_es_mobile +  $es_mobile;
                $total_es_computadora =  $total_es_computadora +  $es_computadora;
                $total_en_session = $total_en_session + $en_session;
                $total_sin_session = $total_sin_session + $sin_session;

                $row = [
                    $pagina,
                    $numero_accesos,
                    $es_mobile,
                    $es_computadora,
                    $en_session,
                    $sin_session,
                ];

                $this->table->add_row($row);
            }

            $totales  = [
                strong("TOTALES"),
                $total_accesos,
                $total_es_mobile,
                $total_es_computadora,
                $total_en_session,
                $total_sin_session
            ];

            $this->table->add_row($totales);
            $response = $this->table->generate();
        }
        $this->response($response);
    }
    function busqueda_fecha_producto_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            

            $accesos = $this->acceso_model->busqueda_fecha_productos($fecha_inicio, $fecha_termino);
            $ids = array_column($accesos, "id_servicio");
            $accesos_acciones = $this->acceso_model->busqueda_fecha_ids($fecha_inicio, $fecha_termino, implode( ",", $ids) );

            $textos_paginas = array_unique(array_column($accesos_acciones, "pagina"));
            $ids_paginas = array_unique(array_column($accesos_acciones, "id_pagina"));
            
            
            $accesos_imagenes = $this->app->add_imgs_servicio($accesos);
            
            $heading = [
                "",
                "Producto",
                "Accesos",
                "Accesos en teléfono",
                "Accesos en computadora",
                "Accesos con sessión",
                "Accesos sin sessión"
            ];

            
            

            $this->table->set_template(template_table_enid());
            $this->table->set_heading(array_merge($heading, $textos_paginas));

            $total_accesos = 0;
            $total_es_mobile = 0;
            $total_es_computadora = 0;
            $total_en_session = 0;
            $total_sin_session = 0;

            foreach ($accesos_imagenes as $row) {

                $numero_accesos = $row["accesos"];
                $pagina = d($row["nombre_servicio"], 'text-uppercase');
                $es_mobile = $row["es_mobile"];
                $es_computadora = $row["es_computadora"];
                $en_session = $row["en_session"];
                $sin_session = $row["sin_session"];
                $id_servicio = $row["id_servicio"];

                $total_accesos = $total_accesos + $numero_accesos;
                $total_es_mobile =  $total_es_mobile +  $es_mobile;
                $total_es_computadora =  $total_es_computadora +  $es_computadora;
                $total_en_session = $total_en_session + $en_session;
                $total_sin_session = $total_sin_session + $sin_session;
                $link = path_enid("producto", $id_servicio);
                $imagen  = d(a_enid(img($row["url_img_servicio"]), ["href" => $link , "target" => "_blank"]), "w_50");
                

                $busqueda = $this->busqueda_por_accion($ids_paginas, $accesos_acciones, $id_servicio);

                $row = [
                    $imagen,
                    $pagina,
                    $numero_accesos,
                    $es_mobile,
                    $es_computadora,
                    $en_session,
                    $sin_session,
                ];
                $linea = array_merge($row , $busqueda);

                $this->table->add_row($linea);
            }

            $totales  = [
                "",
                strong("TOTALES"),
                $total_accesos,
                $total_es_mobile,
                $total_es_computadora,
                $total_en_session,
                $total_sin_session
            ];

            $this->table->add_row($totales);
            $response = $this->table->generate();
        }
        $this->response($response);
    }
    function busqueda_por_accion($ids_paginas, $accesos_acciones,  $id_servicio){

        $response  = [];
        foreach($ids_paginas as $id){

            /*Busco por nombre de acción de pagina*/
            $total = 0; 
            foreach($accesos_acciones as $row){ 

                $id_pagina = $row["id_pagina"];
                $id_servicio_accesos = $row["id_servicio"];
                if($id_servicio_accesos ==  $id_servicio && $id_pagina ==  $id){ 
                    $total = $row["accesos_accion"];
                }
            }   
            
            $response[] = $total;

        }
        return $response;
    }
}

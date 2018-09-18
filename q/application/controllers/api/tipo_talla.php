<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class tipo_talla extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        $this->load->model("tipo_talla_model");     
        $this->load->library('table');          
        $this->load->library(lib_def());                    
    }
    function index_GET(){

        $param      =  $this->get();
        $response   =  $this->tipo_talla_model->get_all($param);
        $this->response($response);
    }
    /**/ 
    function like_clasificacion_GET(){

        $param          =   $this->get();
        $response       =   $this->tipo_talla_model->get_like_clasificacion($param);
        $v              =   $param["v"];
        if ($v == 1){
            $table      =  $this->create_table_tallas($response);
            $this->response($table);
        }else{
            $this->response($response);    
        }
    }
    private function create_table_tallas($param){

        $heading = [
            "#" ,                  
            "TIPO",
            "CLASIFICACIÓNES ENLAZADAS"
        ];
        $this->table->set_template(template_table_enid());
        $this->table->set_heading($heading);

        foreach ($param as $row) {
                
                $id                     =  $row["id"];
                $config                 = anchor_enid(
                                            icon("fa fa-cog"),
                                            array(
                                                'class' => 'configurar_talla' ,
                                                'id'    => $id
                                        ));
                
                $array_clasificiones    =  get_array_json($row["clasificacion"]);     
                $tipo                   =  $row["tipo"];
                $num_clasificaciones    =  anchor_enid(
                                           count($array_clasificiones),
                                            array(
                                                'class' => 'configurar_talla' ,
                                                'id'    => $id
                                        ));
                $this->table->add_row($config, $tipo, $num_clasificaciones);
            }

        return     $this->table->generate();

    }
}?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Proyecto extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");
        $this->load->model("ticketsmodel");      
        $this->load->model("empresamodel");                                          
        $this->load->model("proyectomodel");                                          
    }
    /**/
    function renovar_servicio_POST(){
        
        $param = $this->post();
        $id_proyecto_persona =  $param["id_proyecto_persona"];
        $db_response =  
        $this->ticketsmodel->registra_forma_pago_proyecto($param, $id_proyecto_persona );
        $this->response($db_response);
    }
    /**/
    function colores_GET(){        
        /**/        
        $this->load->view("servicio/tabla_colores");
    }
    /**/
    function form_renovacion_GET(){

        $param =  $this->get();        
        $data["info_persona"] = $this->ticketsmodel->get_info_persona($param);
        $proyecto_persona =$this->proyectomodel->get_proyecto_persona_info_renovacion($param);
        $id_proyecto=  $proyecto_persona[0]["id_proyecto"];

        $data["proyecto_persona"] =  $proyecto_persona;        
        $proyecto =  $this->proyectomodel->get_proyecto_by_id($id_proyecto);
        $param["servicio"]= $proyecto[0]["id_servicio"];

        /**/    
        $proyecto_persona_forma_pago = $this->proyectomodel->get_ultimo_pago_servicio($param);  
        $ultima_fecha_vencimiento =  $proyecto_persona_forma_pago[0]["fecha_vencimiento"];

        $data["ultima_fecha_vencimiento"]= $ultima_fecha_vencimiento;
        /**/                
        $data["precios"] = 
        $this->ticketsmodel->get_precios_servicio_servicio_registrado($param , 
            $ultima_fecha_vencimiento);
        $data["info_proyecto"]= $proyecto;
        /**/
        $data["formas_de_pago"] = $this->ticketsmodel->get_formas_de_pago($param);
        
        /**/        
        $this->load->view("secciones/form_renovacion", $data);
    }
    /**/
    function q_GET(){

        $param =  $this->get();
        $db_response["info_proyecto"] = $this->proyectomodel->get_info_proyecto($param);
        $db_response["servicios"] = $this->proyectomodel->get_servicios($param);
        $db_response["config"] = 1;        
        $this->load->view("secciones/form_info_proyecto" , $db_response );

    }   
    function q_PUT(){

        $param =  $this->put();
        $response  = $this->proyectomodel->update_info_proyecto($param);
        $this->response($response);
    }   
    /**/
    function proyectos_publicos_enid_service_GET(){                
        $param =  $this->get();        
        $data["proyectos"]=   $this->empresamodel->get_portafolio($param);
        $data["config"] =  1;
        $this->load->view("proyecto/principal" , $data);
    }
    /***/    
    function proyectos_pendientes_publicar_GET(){

        $param =  $this->get();
        $db_response["proyectos"] = 
        $this->proyectomodel->get_proyectos_pendientes_publicar($param);        
        $this->load->view("proyecto/lista_proyectos_pendientes", $db_response);
    }
    /**/
    function num_proyectos_enid_service_GET(){

        /**/
        $param =  $this->get();
        $num_proyectos =  $this->proyectomodel->get_num_proyectos_pendientes($param);
            
        $data_proyectos["publicos"] =  "<span class='alerta_validaciones'>
                                            ".$num_proyectos["publicos"]."
                                            <i class='fa fa-check-circle' >
                                            </i>
                                        </span>";
        
        $data_proyectos["privados"] =  "<span class='alerta_validaciones'>
                                            ".$num_proyectos["privados"]."
                                            <i class='fa fa-check-circle' >
                                            </i>
                                        </span>";
        
        $data_proyectos["muestras"] =  "<span class='alerta_validaciones'>
                                            ".$num_proyectos["muestras"]."
                                            <i class='fa fa-check-circle' >
                                            </i>
                                        </span>";
       
        $this->response($data_proyectos);
    }
    /**/
    function registrar_pago_vencido_POST(){

        /**/
        $param =  $this->post();
        $db_response =  $this->proyectomodel->registrar_abono_pago_vencido($param);
        $this->response($db_response);
    }
    /**/
    function resumen_proyecto_persona_forma_pago_GET(){

        /**/        
        $param  = $this->get();
        $data["info_adeudo"] =  $this->proyectomodel->get_proyecto_persona_forma_pago($param);
        $data["info_historial_anticipos"] = $this->proyectomodel->get_historia_anticipos($param);
        $this->load->view("proyecto/form_adeudo" , $data );
    }
    /**/
    function num_validados_GET(){

        $num_personas_validacion =  $this->ticketsmodel->get_num_personas_validacion();

        if ($num_personas_validacion > 0 ) {
            
            $num_personas_validacion =  "<span class='alerta_validaciones'>
                                            ".$num_personas_validacion."
                                            <i class='fa fa-flag-checkered'</i>

                                        </span>";
        }else{
            $num_personas_validacion = "";
        }
        $this->response($num_personas_validacion);
    }
    /**/
    function qform_GET(){
    
        $param = $this->get();            
        $data["info_persona"] = $this->ticketsmodel->get_info_persona($param);
        $data["precios"] = $this->ticketsmodel->get_precios_servicio($param);
        $data["formas_de_pago"] = $this->ticketsmodel->get_formas_de_pago($param);
        $data["info_enviada"] =  $param;

        /**/
        //$modulo=  $param["modulo"];
        
        //if($modulo ==  "ventas"){
            $this->load->view("proyecto/form_paginasweb_ventas" , $data );                    
        //}else{
            //$this->load->view("proyecto/form_paginasweb" , $data );            
        //}    
    }
    /**/
    function liberar_proyecto_validacion_POST(){
        $param =  $this->post();
        $db_response = $this->ticketsmodel->libera_proyecto_validacion($param);
        $this->response($db_response);
    }
    /**/
    
    /**/

}?>
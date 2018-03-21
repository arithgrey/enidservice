<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enid extends CI_Controller {

    function __construct(){
        parent::__construct();

        $this->load->model("img_model");
        $this->load->model("enidmodel");
        $this->load->library('principal');    
        $this->load->library('sessionclass');    
    }
    function img_faq($id_faq){

        $db_response =  $this->img_model->get_img_faq($id_faq);                
            foreach ($db_response as $row ){                 
                $imagen =  $row["img"];
                echo $imagen;
            }                    
    }

    /**/   
    function imagen_usuario($id_usuario){

        $db_response =  $this->img_model->get_img_usuario($id_usuario);                        
        foreach ($db_response as $row ){ 
            echo $row["img"];
        }  

    }        
    /**/
    function imagen_servicio($id_servicio){

        $data_imagen =  $this->img_model->get_img_servicio($id_servicio);                        
        /*Validamos que exista alguna imagen*/
        $num_img =  count($data_imagen);
        if($num_img > 0){
            
            $db_response =  $this->img_model->get_img($data_imagen[0]["id_imagen"]);
            foreach ($db_response as $row ){ 
                echo $row["img"];
            }     
        }
        /**/
        
    }
    /**/
    function imagen($id_imagen){

        $db_response =  $this->img_model->get_img($id_imagen);                                
        foreach ($db_response as $row ){ 
            echo $row["img"];
        } 
        /**/
    }   
    /**/     
    function galeria_GET(){
        $param =  $this->get();        
        $imgs =  $this->enidmodel->get_galeria_empresa($param);
        $this->response(construye_galeria($imgs , $param ));
    }
    /**/
    function img_id($id_imagen){
        
        $db_response =  $this->img_model->get_data_img_id($id_imagen);                        
        foreach ($db_response as $row ){ 
            echo $row["img"];
        }  
    }
    /**/
    function imagen_empresa($id_empresa){

        $db_response =  $this->img_model->get_img_empresa($id_empresa);                        
        foreach ($db_response as $row ){ 
            echo $row["img"];
        }  

    }
    /**/
    function imagen_acceso($id_acceso){

        $db_response =  $this->img_model->get_img_acceso($id_acceso);                        
        foreach ($db_response as $row ){ 
            echo $row["img"];
        }  

    }
    /**/
    function imagen_artista($id_artista){

        $db_response =  $this->img_model->get_img_artista($id_artista);                        
        foreach ($db_response as $row ){ 
            echo $row["img"];
        }         

    }
    /**/
    function imagen_escenario($id_escenario){

        $db_response =  $this->img_model->get_img_escenario($id_escenario);                
        
        foreach ($db_response as $row ){ 
            echo $row["img"];
        }         
    }
    /**/
    function img_evento($id_evento){

        $db_response =  $this->img_model->get_img_evento($id_evento);                
            foreach ($db_response as $row ){ 
                echo $row["img"];
            }                    
    }
    /**/
    /**/    
    function img($id_imagen){

        $imagen = $this->enidmodel->get_imagen($id_imagen);
        foreach ($imagen as $row ){ 
            echo $row["img"];
        }        
    }
    /**/
    function mail(){
        $data = $this->val_session("Mail marketing");                     
        $data["tipos_publicidad"]= $this->enidmodel->get_tipo_publicidad();
        $this->principal->show_data_page($data ,  "enid/mail_marketing" );                   

    }
    /*Termina la función*/ 
    function val_session($titulo_dinamico_page){

        if ( $this->sessionclass->is_logged_in() == 1 ){                                                            
                $menu = $this->sessionclass->generadinamymenu();
                $nombre = $this->sessionclass->getnombre();                                         
                $data['titulo']= $titulo_dinamico_page;              
                $data["menu"] = $menu;              
                $data["nombre"]= $nombre;                                               
                $data["perfilactual"] =  $this->sessionclass->getnameperfilactual();                
                $data["in_session"] = 1;
                $data["meta_keywords"] =  "";
                $data["url_img_post"]= "";
                $data["no_publics"] =1;
                return $data;
        }else{          
            redirect("home/logout");
        }   
    }
    /*Determina que vistas mostrar para los eventos*/    
}/*Termina el controlador */
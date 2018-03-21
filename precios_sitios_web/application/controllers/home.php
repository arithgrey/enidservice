<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");        
        $this->load->library("restclient");        
        $this->load->library('sessionclass');     
    }       
    function index(){

        $data = $this->val_session("");    
        $data["meta_keywords"] = 'Google Adwords precios, posicionamiento en Google';
        $data["desc_web"] = "Posicionamiento en Google";                
        $data["url_img_post"] = create_url_preview("paginas_web_portada.png");


        $servicios =  $this->principal->get_servicios_grupo(2);
        $caracteristicas_grupo 
        =$this->principal->get_caracteristicas_globales_grupo_servicios(2);

        $data["table"]=  $this->get_table_servicios(
                            $servicios , 
                            $caracteristicas_grupo , 
                            $data["in_session"]);

        
        $data["caracteristicas_grupo"] = $caracteristicas_grupo;
        $clasificaciones_departamentos =   $this->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;

        $this->principal->crea_historico(23330 , 1 ,1 );         
        $this->principal->show_data_page($data, 'home');                          
    }   
    /**/    
    function get_table_servicios($servicios ,$caracteristicas_grupo , $in_session){

        $data_complete =  get_titulos_precios($servicios , $in_session );  
        $table_header =  $data_complete["table_header"];
        $tmp_servicios = $data_complete["tmp_servicios"];


        $list ="";      
        foreach ($caracteristicas_grupo as $row){   

            $caracteristica = $row["caracteristica"];
            $id_caracteristica =  $row["id_caracteristica"];
            $list .="<tr>";
                $list .= "<td style='font-size:.8em;'>" .$caracteristica ."</td>";
                for ($a=0; $a < count($tmp_servicios); $a++){    

                    $num_exist =  
                    $this->principal->valida_termino_aplicable($tmp_servicios[$a], 
                        $id_caracteristica );


                    $text ="<i class='fa fa-check-circle'></i>";
                    if ($num_exist == 0 ) {
                        
                        $text ='
                        <i class="fa fa-times red_enid_background white" style="padding: 5px;"></i> ';  
                    }
                    $list .= get_td($text);                
                }

            $list .="</tr>";
        }

        $table_header = $table_header.$list;
        return $table_header;
    } 

    /**/
    function logout(){                      
        $this->sessionclass->logout();      
    }   
    /**/
    function val_session($titulo_dinamico_page ){

        if( $this->sessionclass->is_logged_in() == 1){                                                   
                $menu = $this->sessionclass->generadinamymenu();
                $nombre = $this->sessionclass->getnombre();                                         
                $data['titulo']= $titulo_dinamico_page;              
                $data["menu"] = $menu;              
                $data["nombre"]= $nombre;                                               
                $data["email"]= $this->sessionclass->getemailuser();                                               
                $data["perfilactual"] =  $this->sessionclass->getnameperfilactual();                
                $data["in_session"] = 1;
                $data["no_publics"] =1;
                $data["meta_keywords"] =  "";
                $data["url_img_post"]= "";
                $data["id_usuario"] = $this->sessionclass->getidusuario();                     
                $data["id_empresa"] =  $this->sessionclass->getidempresa();                     
                $data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["desc_web"] =  "";
                return $data;
                
                

        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;  
            $data["id_usuario"] ="";           
            return $data;
        }   
    }    
    
    /**/
        function get_departamentos($nombre_pagina){

        $q["q"] =  $nombre_pagina;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("clasificacion/primer_nivel/format/json/" , $q);        
        $response =  $result->response;        
        return $response;
    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
 

    
}
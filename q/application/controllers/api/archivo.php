<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Archivo extends REST_Controller{      
    function __construct(){
        parent::__construct();                       
        $this->load->model("img_model");
        $this->load->library(lib_def());                   
        
    }
    function extension($str){
        $str=implode("",explode("\\",$str));
        $str=explode(".",$str);
        $str=strtolower(end($str));
         return $str;
    }
    /**/
    function imgs_POST(){
        
        $prm    =   $this->post(); 
        $extensiones = 
        ['jpg','jpeg','gif','png','bmp',"image/jpg","image/jpeg","image/gif","image/png"];
        if($_FILES['imagen']['error'] === 4) {
            $this->response( 'Es necesario establecer una imagen' );        
        }else if($_FILES['imagen']['error'] === 0 ){


            $imagenBinaria  = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
            $nombre_archivo = $_FILES['imagen']['name'];    
            $extension      =  $this->extension($nombre_archivo );

            if(!in_array($extension, $extensiones)) {
                $msj =  'Sólo se permiten archivos con las siguientes extensiones: ';
                $this->response( $msj.implode(', ', $extensiones) );
            }

            
            $prm["imagenBinaria"]   =   $imagenBinaria;
            $prm["nombre_archivo"]  =   $nombre_archivo;
            $prm["extension"]       =   $extension; 
            $response               =   $this->gestiona_imagenes($prm);         
            $this->response($response);            
            
        }
        
        
    }
    /**/
    function gestiona_imagenes($param){ 

        $param["id_usuario"]    =  $this->principal->get_session("idusuario");  
        $param["id_empresa"]    =  $this->principal->get_session("idempresa");            
        switch ($param["q"]) {
            
            
              case 'faq':
                
                $response = $this->img_model->insert_img_faq( $param);
                return $this->response_status_img($response);                    
                
            
                break;        

                
              case 'perfil_usuario':
                
                
                $response = 
                $this->img_model->insert_imgen_usuario($param);                
                return $this->response_status_img($response);                    
                
                break;        

              case 'servicio':            
                
                
                if ($this->img_model->insert_imgen_servicio($param) ==  true ) {
                    /*Notifico que ya tenemos imagen en servicio*/
                    $param["exist"] = 1;
                    $this->notifica_producto_imagen($param);
                }


                break;          

        
              default:

                break;
        }        
    }
    /**/
    function response_status_img($status){

        $msj ="Error al cargar la image, reportar al admistrador ";
        if ($status ==  1  ) {
            $msj =  "Imagen guardada .!";
        }
        return $msj; 
    }
    /*Validar session para modificar datos*/
    
    function notifica_producto_imagen($q){
        $api = "servicio/status_imagen/format/json/";
        return $this->principal->api("q" , $api , $q , "json", "PUT");
    }
    
}?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Archivo extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                       
        $this->load->model("img_model");
        $this->load->library(lib_def());                   
        $this->id_usuario   =  $this->principal->get_session("idusuario");          
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
        $extensiones = ['jpg','jpeg','gif','png','bmp',"image/jpg","image/jpeg","image/gif","image/png"];

        if($_FILES['imagen']['error'] === 4) {
            $this->response( 'Es necesario establecer una imagen' );        
        
        }else if($_FILES['imagen']['error'] === 0 ){


            $imagenBinaria  =   addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
            $nombre_archivo =   $_FILES['imagen']['name'];    
            $extension      =   $this->extension($nombre_archivo );

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

        $param["id_empresa"]    =   $this->principal->get_session("idempresa");                    
        $prm["id_usuario"]      =   $this->id_usuario;                    
        $param["id_usuario"]    =   $this->id_usuario;                    


        switch ($param["q"]) {
              case 'faq':
                
                $response = $this->img_model->insert_img_faq( $param);
                return $this->response_status_img($response);                    
                break;        

                
              case 'perfil_usuario':                
                $this->create_perfil_usuario($param);
                break;        

              case 'servicio':            
                return $this->create_imagen_servicio($param);
                break;          

        
              default:

                break;
        }        
    }
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
        return $this->principal->api( $api , $q , "json", "PUT");
    }
    function insert_imagen_servicio($q){
        
        $api = "imagen_servicio/index";
        return $this->principal->api( $api , $q , "json", "POST");
    }
    function create_imagen_usuario($q){
        
        $api = "imagen_usuario/index";
        return $this->principal->api( $api , $q , "json", "POST");
    }
    private function create_perfil_usuario($param){
        $id_imagen = $this->img_model->insert_img($param , 1);
        if ( $id_imagen > 0 && $this->id_usuario > 0) {                    
            $prm["id_imagen"]    = $id_imagen;                    
            return $this->create_imagen_usuario($prm);                
        }               
    }
    private function create_imagen_servicio($param){


        
        $response   =   [];
        if ($param["id_usuario"] > 0){            

            $existen    =   "nombre_archivo,id_usuario,id_empresa,imagenBinaria,extension,servicio";
            if (if_ext($param , $existen)) {
                $id_imagen  = $this->img_model->insert_img($param , 1);            

                if ( $id_imagen > 0 ) {                    

                    $prm["id_imagen"]                   =   $id_imagen;
                    $prm["id_servicio"]                 =   $param["servicio"];

                    $response["status_imagen_servicio"] =   $this->insert_imagen_servicio($prm);
                    if ($response["status_imagen_servicio"] == true ) {
                        $prm["existencia"]                  = 1;
                        $response["status_notificacion"] =  $this->notifica_producto_imagen($prm);

                    }   
                    $response["status_notificacion"] = 2;                 
                }    
                return $response;
            }        
            $response["params_error"] = 1;
            return $response;        
        }
        $response["session_exp"] = 1;
        return $response;        
    }
}?>
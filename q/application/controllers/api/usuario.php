<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class usuario extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct(); 
        $this->load->helper("q");                                      
        $this->load->model('usuario_model');    
        $this->load->library(lib_def());   
        $this->id_usuario   =  $this->principal->get_session("idusuario");  
    } 
    function ultima_publicacion_PUT(){
        
        $param      =  $this->put();
        $response   =  $this->usuario_model->set_ultima_publicacion($param);
        $this->response($response);
    }
    function sin_publicar_articulos_GET(){

        $param    = $this->get();
        $response = $this->usuario_model->get_usuarios_sin_publicar_articulos($param);
        $this->response($response);
    }
    /**/
    function miembro_GET(){
        $param      = $this->get();        
        $response   = $this->usuario_model->get_miembro($param);        
        $this->response($response);        
    }
    
    function usuario_ventas_GET(){
        
      $response = $this->usuario_model->get_usuario_ventas();
      $this->response($response);
    }   
    function empresa_GET(){

        $param      = $this->get();
        $response   = $this->usuario_model->q_get(["idempresa"], $param["id_usuario"])[0]["idempresa"];        
        
        $this->response($response);
    }    
    function productos_interes_GET(){

        $param    =   $this->get();     
        $response =   $this->usuario_model->get_productos_interes($param);
        $this->response($response);
    }    
    function perfiles_GET(){

        $param      = $this->get();
        $response   =  $this->usuario_model->get_usuarios_perfil($param);
        $this->response($response);
    }
    function telefono_negocio_PUT(){

        $param                     =   $this->put();                
        $param["id_usuario"]       =  $this->id_usuario;
        $response    =   $this->usuario_model->set_telefono_negocio($param);
        $this->response($response);      
    }
    function telefono_PUT(){
        $param                     =    $this->put();                
        $param["id_usuario"]       =    $this->id_usuario;
        $response    =   $this->usuario_model->set_telefono($param);
        $this->response($response);      
    }
    /**/
    function cancelacion_compra_PUT(){

        $param      =  $this->put();
        $id         = $param["id_usuario"];
        $this->usuario_model->set_cancelacion_compra($id);
    }
    
    function get_usuario_por_servicio($q){

        $api =  "servicio/usuario_por_servicio/format/json";
        return $this->principal->api("q" , $api , $q);
    }
    /**/
    function usuario_servicio_GET(){
        $param = $this->get();                        
        $usuario = $this->get_usuario_por_servicio($param);
        $id_usuario =  $usuario[0]["id_usuario"]; 
        /***/
        $prm["id_usuario"] = $id_usuario;        
        $this->response($this->usuario_model->get_usuario_cliente($prm));        
    }
    /**/
    function q_GET(){

        $param = $this->get();                        
        $usuario= $this->usuario_model->get_usuario_cliente($param);
        $this->response($usuario);
    }
    function pass_PUT(){

        $param      =  $this->put();
        switch ($param["type"]) {
            case 1:
                $response   =  $this->usuario_model->set_pass($param);
                $this->response($response);        
                break;
            
            case 2:
                
                $param              = $this->put();
                $anterior           = $param['anterior'];
                $nuevo              = $param['nuevo'];
                $confirm            = $param['confirma'];
                
                if($nuevo == $confirm){        
                    $id_usuario   = $this->principal->get_session("idusuario");            
                    $existe = count($this->usuario_model->validar_pass($anterior , $id_usuario));
                    if($existe != 1){            
                        $this->response("La contraseña ingresada no corresponde a su contraseña actual");
                    }else{
                        $this->response($this->usuario_model->q_up("password" , $nuevo , $id_usuario));
                    }            
                }else{
                    $this->response("Contraseñas distintas");
                } 

                break;
            
            default:
                
                break;
        }
        
    }
    /*
    function registrar_prospecto($param){
        
      $existe =  $this->evalua_usuario_existente($param);
      $data_complete["usuario_registrado"] = 0;

      if($existe == 0 ){
        
        $email =  $param["email"];
        $id_departamento =  9;      
        $password =  $param["password"];            
        $nombre =  $param["nombre"];
        $telefono =  $param["telefono"];
        $id_usuario_referencia        = 
        get_info_usuario_valor_variable($param , "usuario_referencia");        
        $params = [
            "email"                   =>   $email,
            "idempresa"               =>   '1',                  
            "id_departamento"         =>   $id_departamento,
            "password"                =>   $password,
            "nombre"                  =>   $nombre,
            "tel_contacto"            =>   $telefono,
            "id_usuario_referencia"   =>   $id_usuario_referencia 
        ];
       
        $id_nuevo_usuario                   =     $this->insert("usuario", $params , 1);
        $data_complete["id_usuario"]        =     $id_nuevo_usuario;
        $data_complete["puesto"]            =     20; 
        $data_complete["usuario_permisos"]  =     $this->agrega_permisos_usuario($data_complete);
        $data_complete["email"]             =  $email;
        $data_complete["usuario_registrado"] = 1;
        
      }      
      return $data_complete;
      
    }
    */
    function agrega_permisos_usuario($q){

        $api = "usuario_perfil/permisos_usuario";
        return $this->principal->api("q" , $api , $q, "json" , "POST");
    }

    /*
    function set_exist_pass($param)
    { 
      $existe = count($this->validarPassword($antes, $id_usuario));
      
      if($existe != 1){
        return "La contraseña ingresada no corresponde a su contraseña actual";
      }else{

          $this->update("usuario", ["password" => $nuevo ], ["idusuario" => $id_usuario ]);          
      }
    }
    
    */
    
    function usuario_deseo_POST(){

        $param =  $this->post();
        $response =  $this->usuario_model->add_usuario_deseo($param);
        $this->response($response);
    }
    
    
    /*
    function usuario_cobranza_GET(){

        $param = $this->get();                        
        $usuario = $this->usuario_model->get_usuario_cobranza($param);
        $this->response($usuario);        
    } 
    */      
    /**/
    function usuario_existencia_GET(){
        /*verificamos si es que existe un usuario por algún criterio*/
        $param =  $this->get(); 
        $response =$this->usuario_model->num_q($param);
        $this->response($response);
    } 
    /**/
    function nombre_usuario_GET(){
        
        $param = $this->get();
        $response =$this->usuario_model->nombre_usuario($param);
        $this->response($response);
    }
    function nombre_usuario_PUT(){

        $param                =   $this->put();        
        //$param["id_usuario"]  =   $this->id_usuario;
        $reponse              =   $this->usuario_model->set_nombre_usuario($param);
        $this->response($reponse);      
    }

    function id_usuario_por_id_servicio_GET(){
        
        $param      = $this->get();
        $response   = $this->get_usuario_por_servicio($param);
        $this->response($response);
    } 

    /**/
    function entregas_en_casa_GET(){
        $param      = $this->get();
        $response   =  $this->usuario_model->get_tipo_entregas($param);
        $this->response($response);        
    }
    /**/
    function entregas_en_casa_PUT(){
        
        $param              = $this->put();
        $id_usuario         = $param["id_usuario"];
        $entregas           = $param["entregas_en_casa"];
        $response           = $this->usuario_model->q_up("entregas_en_casa" , $entregas , $id_usuario);
        $this->response($response);
    }
    /**/
    function informes_por_telefono_GET(){
        
        $param = $this->get();
        $response=  $this->usuario_model->get_informes_por_telefono($param);
        $this->response($response);           
    }
    /**/
    function terminos_privacidad_GET(){

        $param = $this->get();
        $response=  $this->usuario_model->get_terminos_privacidad($param);
        $this->response($response);              
    }
    /**/
    function get_terminos_privacidad_productos_GET(){
        $param = $this->get();
        $response=  $this->usuario_model->get_terminos_privacidad_usuario($param);
        $this->response($response);                 
    }
    /**/
    function has_phone_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->has_phone($param);
        debug($response);        
        $this->response($response);                 
    }
    /**/
    function num_registros_periodo_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->num_registros_periodo($param);
        $this->response($response);        
    }
    /**/
    function activos_con_direcciones_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->activos_con_direcciones($param);
        $this->response($response);        
    }
    /**/
    function agregan_clasificaciones_periodo_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->agregan_clasificaciones_periodo($param);
        $this->response($response);        
    }
    function publican_periodo_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->publican_periodo($param);
        $this->response($response);        
    }
    /**/
    function registros_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->registros($param);
        $this->response($response);        
    }
    /**/    
    function img_perfil_GET(){

        $param      =   $this->get();
        $response   =   $this->usuario_model->img_perfil($param);
        $this->response($response);        
    }
    /**/
    function social_icons_GET(){
        $this->load->view("servicio/social_icons");
    }
    /**/
    function es_POST(){        
        $param          = $this->post();                
        $params         = [ "idusuario","nombre","email","fecha_registro","idempresa"];
        $params_where   = ["email" => $param["email"] , "password" => $param["secret"]];
        $response       = $this->usuario_model->get($params , $params_where);
        $this->response($response);
    }
    function num_registros_preriodo_GET(){
        
        $param      =   $this->get();
        $total      =   $this->usuario_model->num_registros_preriodo($param);        
        $this->response($total);
    }
    function registros_periodo_GET(){
        
        $param      =   $this->get();
        $total      =   $this->usuario_model->registros_periodo($param);        
        $this->response($total);
    }
    function num_total_GET(){

        $param      =  $this->get();
        $response   =  $this->usuario_model->num_total($param);        
        $this->response($response);
    }    
    function lista_deseos_sugerencias_GET(){    

        $param     = $this->get();    
        $param["id_usuario"] = $this->id_usuario;
        $servicios  =  $this->usuario_model->get_productos_deseados_sugerencias($param);
        $response   = $this->agrega_costo_envio($servicios);
        $this->response($response);
    }
    function agrega_costo_envio($servicios){
     
        $nueva_data =[];
        $a =0;
        foreach($servicios as $row){
            
            $nueva_data[$a] = $row;                        
            $flag_servicio  = $row["flag_servicio"];
            
            if($flag_servicio == 0){
                $prm["flag_envio_gratis"]       =  $row["flag_envio_gratis"];
                $nueva_data[$a]["costo_envio"]  = 
                $this->principal->calcula_costo_envio($prm);    
            } 
            
            $a ++;
        }        
        return $nueva_data;
        
    } 
    /**/
    function verifica_registro_telefono_GET(){
        
        $param      = $this->get();        
        $response   =  $this->usuario_model->verifica_registro_telefono($param);
        $this->response($response);

    }
    function vendedor_POST(){        
        

        if($this->input->is_ajax_request()){             
            $param = $this->post();        
            
            $response["usuario_existe"]          =  $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"] = 0;
            if ($response["usuario_existe"] == 0 ){

                $email              =  $param["email"];
                $id_departamento    =  9;      
                $password           =  $param["password"];            
                $nombre             =  $param["nombre"];        
                $id_usuario_referencia = 180; 

                $params = [
                  "email"                   =>  $email,
                  "idempresa"               =>  '1',
                  "id_departamento"         =>  $id_departamento,
                  "password"                =>  $password,
                  "nombre"                  =>  $nombre,
                  "id_usuario_referencia"   =>  $id_usuario_referencia 
                ];
                $response["id_usuario"] = $this->usuario_model->insert("usuario" , $params , 1);
                
                if ( $response["id_usuario"]>0){
                    $q["id_usuario"]    =  $response["id_usuario"]; 
                    $q["puesto"]        =  20; 
                    $response["usuario_permisos"]  =   $this->agrega_permisos_usuario($q);   
                    if ($response["usuario_permisos"] > 0) {
                        $response["email"]              =  $email;
                        $response["usuario_registrado"] = 1;

                    }
                }
                
            }
            $this->response($response);
        } 
        $this->response("Error");    
    }

    function miembros_activos_GET(){

        $param                                  =   $this->get();
        $total                                  =   $this->usuario_model->num_total($param);
        $per_page                               =   10;
        $param["resultados_por_pagina"]         =   $per_page;
        $data["miembros"]                       =   $this->usuario_model->get_equipo_enid_service($param);    
        $config_paginacion["page"]              =   get_info_variable($param , "page" );
        $config_paginacion["totales_elementos"] =   $total;
        $config_paginacion["per_page"]          =   $per_page;        
        $config_paginacion["q"]                 =   "";            
        $config_paginacion["q2"]                =   "";                   
        $paginacion                             =   $this->principal->create_pagination($config_paginacion);
        $data["paginacion"]                     =   $paginacion;
        $data["modo_edicion"]                   =   1;

        
        $this->load->view("equipo/miembros" , $data);                
        
    }
    function miembro_POST(){
        
        $param      = $this->post(); 
        $editar     =  $param["editar"];
        $response["usuario_existente"] = 0;

        if($editar ==  1){              
            $response["modificacion_usuario"] = $this->usuario_model->modifica_usuario($param);        
            $this->agrega_permisos_usuario($param);
        }else{

            
            if ($this->usuario_model->evalua_usuario_existente($param) == 0 ) {    
              $response["registro_usuario"] =  $this->usuario_model->crea_usuario_enid_service($param);    
              $this->agrega_permisos_usuario($response);
            }else{
                $response["usuario_existente"] = 
                "Este usuario ya se encuentra registrado, verifique los datos";
            }        
        }

        $this->response($response);
        
    }

    function prospecto_subscrito_POST(){
    
        $param =  $this->post();             
        $response =  $this->usuario_model->registrar_prospecto($param);                    
        $this->response($response);    
    }
     function afiliado_POST(){

        $param      =  $this->post();  
        $response   =  $this->usuario_model->registrar_afiliado($param);
        /**/
        if($response["usuario_existe"] == 0 && $response["usuario_registrado"] == 1){
            
            /*Notifica que se registro con éxitio el usuario*/
            $param["id_usuario"] =  $response["id_usuario"];
            $response["estado_noficacion_email_afiliado"]= 
                $this->notifica_registro_exitoso($param);

        }
        $this->response($response);                
    }
    /*Notifica registro con éxito*/
    function notifica_registro_exitoso($q){         
        $api = "emp/solicitud_afiliado/format/json/"; 
        return  $this->principal->api("msj" , $api , $q);
    }
    function prospecto_POST(){
        
        /*
        
        if( array_key_exists("num_ciclos", $param) && ctype_digit($param["num_ciclos"]) 
            && $param["num_ciclos"] >0 && array_key_exists("ciclo_facturacion", $param)
            && $param["num_ciclos"] >0 && $param["num_ciclos"] < 10
            && ctype_digit($param["plan"]) && $param["plan"] >0 
        ){
            */
        $param =  $this->post();                                
        $response["usuario_existe"] = $this->usuario_model->evalua_usuario_existente($param);        
        $response["usuario_registrado"] = 0;
        if ($response["usuario_existe"] == 0 ){

            $email              =  $param["email"];
            $id_departamento    =  9;      
            $password           =  $param["password"];            
            $nombre             =  $param["nombre"];
            $telefono           =  $param["telefono"];
            $id_usuario_referencia        = get_info_usuario_valor_variable($param , "usuario_referencia");        
            $params = [
                "email"                   =>   $email,
                "idempresa"               =>   '1',                  
                "id_departamento"         =>   $id_departamento,
                "password"                =>   $password,
                "nombre"                  =>   $nombre,
                "tel_contacto"            =>   $telefono,
                "id_usuario_referencia"   =>   $id_usuario_referencia 
            ];
       
            $response["id_usuario"]       =    $this->usuario_model->insert("usuario", $params , 1);
            if ( $response["id_usuario"]>0){
                
                $q["id_usuario"]    =  $response["id_usuario"]; 
                $q["puesto"]        =  20; 
                $response["usuario_permisos"]  =   $this->agrega_permisos_usuario($q);   
                if ($response["usuario_permisos"] > 0) {
                    $response["email"]              =  $email;
                    $response["usuario_registrado"] = 1;
                }
            }

        }
        $this->response($response);    
                 
    }         
    private function crear_proceso_compra($param){
        
        

        /*
        if ($response["usuario_registrado"] ==  1 && $response["id_usuario"]>0 ){                
                $param["id_usuario"]                = $response["id_usuario"];       
                $param["usuario_nuevo"]             = 1;        

                $orden_de_compra["siguiente"]       = $this->crea_orden_de_compra($param);
                $orden_de_compra["usuario_existe"]  = 0;
            return $orden_de_compra;           
                            
        }else{
            return $response;    
        } 
        */

    }     
}?>

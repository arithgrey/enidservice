<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class usuario extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct(); 
        $this->load->helper("q");                                      
        $this->load->model('usuario_model');    
        $this->load->library('table');
        $this->load->library(lib_def());   
        $this->id_usuario   =  $this->principal->get_session("idusuario");  
    }
    function index_PUT(){
        $param      =  $this->put();
        $response   = false;
        if(if_ext($param , "nombre,apellido_paterno,apellido_materno,email,tel_contacto,id_usuario")){


            $id_usuario = $param["id_usuario"];
            unset($param["id_usuario"]);
            $response =  $this->usuario_model->update($param, ["idusuario" => $id_usuario ]);

        }
        $this->response($response);

    }
    function ultima_publicacion_PUT(){
        
        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param , "id_usuario")){
            $response   =  $this->usuario_model->set_ultima_publicacion($param);
        }
        $this->response($response);
    }
    function sin_publicar_articulos_GET(){

        $param    = $this->get();
        $response = $this->usuario_model->get_usuarios_sin_publicar_articulos($param);
        $this->response($response);
    }
    function miembro_GET(){
        $param      = $this->get();
        $response   = false;
        if(if_ext($param , "id_usuario")){
            $response   = $this->usuario_model->get_miembro($param);
        }
        $this->response($response);        
    }
    function usuario_ventas_GET(){

      $this->response($this->usuario_model->get_usuario_ventas());

    }   
    function empresa_GET(){

        $param      = $this->get();
        $response   =  false;
        if (if_ext($param , "id_usuario")){
            $response   = $this->usuario_model->q_get(["idempresa"], $param["id_usuario"])[0]["idempresa"];
        }
        $this->response($response);
    }
    function perfiles_GET(){

        $param      = $this->get();
        $response   = false;
        if(if_ext($param , "id_perfil")){

            $response   =  $this->usuario_model->get_usuarios_perfil($param);
        }
        $this->response($response);
    }
    function telefono_negocio_PUT(){

        $param                     =    $this->put();                
        $id_usuario                =    $this->id_usuario;
        $response                  =    false;

        if ($id_usuario > 0 && array_key_exists("telefono_negocio", $param) &&
                array_key_exists('lada_negocio', $param) ){

            $params         =  [
                "tel_contacto_alterno"  =>  $param["telefono_negocio"] , 
                "lada_negocio"          =>  $param["lada_negocio"]
            ];  
            $params_where   = ["idusuario" => $this->id_usuario];
            $response       = $this->usuario_model->update( $params , $params_where );            
        }
        
        $this->response($response);
        
    }
    function telefono_PUT(){

        $param      = $this->put();
        $response   = false;
        if(if_ext($param , "tel_contacto,lada")){
            $params         = [
                "tel_contacto"  =>  $param["telefono"] ,
                "tel_lada"      =>  $param["lada"]
            ];
            $params_where   = ["idusuario" => $this->id_usuario ];
            $response       =  $this->usuario_model->update( $params , $params_where );
        }
        $this->response($response);      
    }
    function cancelacion_compra_PUT(){

        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param , "id_usuario")){
            $response   = $this->usuario_model->q_up("num_cancelaciones" , "num_cancelaciones + 1 " , $param["id_usuario"]);
        }
        $this->response($response);
    }
    function usuario_servicio_GET(){

        $param              = $this->get();
        $response           = false;
        if (if_ext($param , "id_servicio")){

            $usuario            =       $this->get_usuario_por_servicio($param);
            $id_usuario         =       $usuario[0]["id_usuario"];
            $params =  [
                "idusuario id_usuario",
                "nombre" ,
                "apellido_paterno" ,
                "apellido_materno" ,
                "email",
                "nombre_usuario",
                "tel_contacto",
                "tel_contacto_alterno",
                "lada_negocio",
                "tel_lada"
            ];
            $response = $this->usuario_model->q_get($params, $id_usuario);
        }
        $this->response($response);
    }
    function q_GET(){

        $param    = $this->get();
        $response = false;
        if (if_ext($param , "id_usuario")){
            $params =  ["idusuario id_usuario",
                "nombre" ,
                "apellido_paterno" ,
                "apellido_materno" ,
                "email",
                "nombre_usuario",
                "tel_contacto",
                "tel_contacto_alterno",
                "lada_negocio",
                "tel_lada"
            ];

            $response    = $this->usuario_model->q_get($params, $param["id_usuario"]);
        }
        $this->response($response);
    }
    private function set_password_forget($param){

        $response                   =   false;
        if (if_ext($param , "mail")){
            $new_pass                   =   randomString();
            $params                     =   ["password" => sha1($new_pass)];
            $params_where               =   ["email"    => trim($param["mail"]) ];
            $response["status_send"]    =   $this->usuario_model->update($params, $params_where );
            $response["new_pass"]       =   $new_pass;
        }
        return $response;

    }
    function pass_PUT(){

        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param , "type")){
            switch ($param["type"]) {
                case 1:

                    $response   = $this->set_password_forget($param);
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
    private function set_password_usuario($param){

        $response = false;
        if (if_ext($param, "anterior,nuevo,confirma")){
            $anterior           = $param['anterior'];
            $nuevo              = $param['nuevo'];
            $confirm            = $param['confirma'];
            if($nuevo == $confirm){
                $id_usuario     = $this->principal->get_session("idusuario");
                $existe         = $this->usuario_model->valida_pass($anterior , $id_usuario);
                if($existe != 1){
                    $response   = "La contraseña ingresada no corresponde a su contraseña actual";

                }else{
                    $response =  $this->usuario_model->q_up("password" , $nuevo , $id_usuario);
                    if($response){
                        $this->notifica_modificacion_password();
                    }


                }
            }else{
                $response       = "Contraseñas distintas";
            }
        }
        return $response;
    }
    function usuario_existencia_GET(){

        $param      =   $this->get();
        $response   =   false;
        if(if_ext($param , "value")){
            $response   =   $this->usuario_model->num_q($param);
        }
        $this->response($response);
    }

    function nombre_usuario_PUT(){

        $param                =     $this->put();                
        $response             =     false;  
        if ($this->id_usuario > 0 && strlen($param["nombre_usuario"]) >0 ){
            $response          = $this->usuario_model->q_up("nombre_usuario", $param["nombre_usuario"] , $this->id_usuario);
        }                
        $this->response($response);
    }
    function id_usuario_por_id_servicio_GET(){
        
        $param      = $this->get();
        $response   = false;
        if (if_ext($param , "id_servicio")){
            $response   = $this->get_usuario_por_servicio($param);
        }
        $this->response($response);
    }
    function entregas_en_casa_GET(){
        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param , "id_usuario")){

            $response     =   $this->usuario_model->q_get(["tipo_entregas", "entregas_en_casa" ], $param["id_usuario"] );

        }
        $this->response($response);        
    }
    function entregas_en_casa_PUT(){
        
        $param              = $this->put();
        $id_usuario         = $param["id_usuario"];
        $entregas           = $param["entregas_en_casa"];
        $response           = $this->usuario_model->q_up("entregas_en_casa" , $entregas , $id_usuario);
        $this->response($response);
    }
    function informes_por_telefono_GET(){
        
        $param      = $this->get();
        $response   = false;
        if (if_ext($param , "id_usuario")){
            $response=  $this->usuario_model->q_get(["informes_telefono"], $param["id_usuario"]);
        }
        $this->response($response);           
    }
    function has_phone_GET(){

        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param, "id_usuario")){
            $response   =   $this->usuario_model->has_phone($param);
        }
        $this->response($response);                 
    }
    function num_registros_periodo_GET(){

        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param , "fecha_inicio,fecha_termino")){
            $response   =   $this->usuario_model->num_registros_periodo($param);
        }

        $this->response($response);        
    }
    function publican_periodo_GET(){

        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param , "fecha_inicio,fecha_termino")){
            $response   =   $this->usuario_model->publican_periodo($param);
        }

        $this->response($response);        
    }
    function registros_GET(){

        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param , "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->registros($param);
        }
        $this->response($response);

    }
    /*
    function social_icons_GET(){

        //$this->load->view("servicio/social_icons");
        $response  = get_social_icons();
        $this->response($response);


    }
    */
    function es_POST(){        
        $param          = $this->post();
        $response       =   [];
        if (if_ext($param ,"email,secret")){
            $params         = [ "idusuario","nombre","email","fecha_registro","idempresa"];
            $params_where   = ["email" => $param["email"] , "password" => $param["secret"]];
            $response       = $this->usuario_model->get($params , $params_where);

        }
        $this->response($response);
    }
    function num_registros_preriodo_GET(){
        
        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param , "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->num_registros_preriodo($param);
        }
        $this->response($response);
    }
    function registros_periodo_GET(){
        
        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param , "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_model->registros_periodo($param);
        }
        $this->response($response);
    }
    function num_total_GET(){

        $param      =  $this->get();
        $response   =  $this->usuario_model->num_total($param);        
        $this->response($response);
    }    
    function lista_deseos_sugerencias_GET(){    

        $param               = $this->get();
        $response            = [];

        if ($this->id_usuario > 0 || array_key_exists("id_usuario", $param)) {

            $param["id_usuario"]    =   ( array_key_exists("id_usuario", $param) ) ? $param["id_usuario"]: $this->id_usuario;
            $response               =   $this->usuario_model->get_productos_deseados_sugerencias($param);
        }
        
        $this->response($response);
    }
    function verifica_registro_telefono_GET(){
        
        $param      = $this->get();
        $response   = false;
        if(if_ext($param , "id_usuario")){
            $response   =  $this->usuario_model->verifica_registro_telefono($param);
        }
        $this->response($response);

    }
    function vendedor_POST(){        
        

        if($this->input->is_ajax_request()){             
            $param = $this->post();
            
            $response["usuario_existe"]             =  $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"]         =  0;
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

                $response["id_usuario"] = $this->usuario_model->insert($params , 1);
                
                if ( $response["id_usuario"]>0){

                    $q["id_usuario"]    =  $response["id_usuario"]; 
                    $q["puesto"]        =  20; 
                    $response["usuario_permisos"]  =   $this->agrega_permisos_usuario($q);   
                    if ($response["usuario_permisos"] > 0) {
                        $response["email"]              =  $email;
                        $response["usuario_registrado"] =  1;
                    }

                    $simple     =  (get_param_def( $param  , "simple")  > 0 )  ? 1 : 0;
                    if($simple  ==  0){
                        $id_servicio =  $param["servicio"];
                        $this->inicia_proceso_compra($param , $response["id_usuario"]  , $id_servicio);
                    }
                    $this->notifica_registro_usuario($params);

                }
            }
            $this->response($response);
        } 
        $this->response("Error");    
    }
    function whatsapp_POST(){        
        
        $response = false;
        if($this->input->is_ajax_request()){             
            $param                               =  $this->post();
            $param["email"]                      =  $param["whatsapp"]."@gmail.com";            
            $response["usuario_existe"]          =  $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"]      =  0;
            $id_servicio                         =  $param["servicio"];
            $id_usuario                          =  0;
            if ($response["usuario_existe"] == 0 ){

                $response["usuario"] = $this->agrega_usuario_whatsApp($param);

            }else{

                $in         =  ["email" => $param["email"] ];
                $id_usuario =  $this->usuario_model->get(["idusuario"], $in)[0]["idusuario"];

            }

            $id_usuario     = ($response["usuario_existe"] == 0 ) ? $response["usuario"]["id_usuario"] : $id_usuario;
            $this->inicia_proceso_compra($param , $id_usuario , $id_servicio);
            $this->response($response);
        } 
        $this->response(false);
    }

    function notifica_registro_usuario($param){

        $response  =  false;
        if(if_ext($param ,  "nombre,email")){

            $email      =   $param["email"];
            $asunto     =   "TU USUARIO SE REGISTRÓ!";
            $cuerpo     =   get_mensaje_bienvenida($param);
            $q          =   get_request_email($email, $asunto , $cuerpo);
            $response   =   $this->principal->send_email_enid($q);

        }
        return $response;

    }
    private function inicia_proceso_compra($param , $id_usuario , $id_servicio){

        $this->agrega_lista_deseos($id_usuario , $id_servicio);
        $session  = $this->create_session($param);
        $this->principal->set_userdata($session);
    }
    private function  agrega_usuario_whatsApp($param){

        $email              =  $param["email"];
        $id_departamento    =  9;
        $password           =  $param["password"];
        $nombre             =  $param["nombre"];
        $id_usuario_referencia = 180;
        $whatsapp           =  $param["whatsapp"];

        $params = [
            "email"                   =>  $email,
            "idempresa"               =>  '1',
            "id_departamento"         =>  $id_departamento,
            "password"                =>  $password,
            "nombre"                  =>  $nombre,
            "id_usuario_referencia"   =>  $id_usuario_referencia ,
            "tel_contacto"            =>  $whatsapp
        ];
        $response["id_usuario"] = $this->usuario_model->insert($params , 1);

        if ( $response["id_usuario"]>0){
            $q["id_usuario"]    =  $response["id_usuario"];
            $q["puesto"]        =  20;
            $response["usuario_permisos"]  =   $this->agrega_permisos_usuario($q);
            if ($response["usuario_permisos"] > 0) {
                $response["email"]              =  $email;
                $response["usuario_registrado"] =  1;
                /*Ahora notifico al usuario */

            }
        }
        return $response;

    }
    function miembros_activos_GET(){

        $param      =   $this->get();
        $response   =   false;
        if(if_ext($param , "id_departamento")){
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
            return                                  $this->load->view("equipo/miembros" , $data);
        }
        $this->response($response);

    }
    function usuarios_GET(){

        $param                                  =   $this->get();
        $total                                  =   $this->get_num_registros_periodo($param);
        $per_page                               =   10;
        $param["resultados_por_pagina"]         =   $per_page;
        $data["miembros"]                       =   $this->usuario_model->get_usuarios_periodo($param);
        $config_paginacion["page"]              =   get_info_variable($param , "page" );
        $config_paginacion["totales_elementos"] =   $total;
        $config_paginacion["per_page"]          =   $per_page;
        $config_paginacion["q"]                 =   "";
        $config_paginacion["q2"]                =   "";
        $paginacion                             =   $this->principal->create_pagination($config_paginacion);
        $data["paginacion"]                     =   $paginacion;
        $data["modo_edicion"]                   =   0;
        $this->load->view("equipo/miembros" , $data);
    }
    function miembro_POST(){
        
        $param      =   $this->post();
        $response   = false;
        if (if_ext($param , "editar,nombre,email,apellido_paterno,apellido_materno,inicio_labor,fin_labor,turno,sexo,departamento")){
            $editar     =   $param["editar"];
            $response["usuario_existente"] = 0;

            if($editar ==  1){
                $response["modificacion_usuario"] = $this->usuario_model->set_miembro($param);
                $this->agrega_permisos_usuario($param);
            }else{


                if ($this->usuario_model->evalua_usuario_existente($param) == 0 ) {
                    $response["registro_usuario"] =  $this->usuario_model->crea_usuario_enid_service($param);
                    $this->agrega_permisos_usuario($response);
                }else{
                    $response["usuario_existente"] = "Este usuario ya se encuentra registrado, verifique los datos";
                }
            }
        }
        $this->response($response);

    }
    function afiliado_POST(){

        $param      =   $this->post();
        $response   =   false;
        if (if_ext($param, "email,password,nombre,telefono")){
            $response   =  $this->usuario_model->registrar_afiliado($param);
            if($response["usuario_existe"] == 0 && $response["usuario_registrado"] == 1){
                $param["id_usuario"]                            =   $response["id_usuario"];
                $response["estado_noficacion_email_afiliado"]   =   $this->notifica_registro_exitoso($param);
            }
        }
        $this->response($response);                
    }
    function prospecto_POST(){
    
        $param      =  $this->post();
        $response   = false;

        if (if_ext($param , "email,password,nombre,telefono")){
            $response["usuario_existe"]     = $this->usuario_model->evalua_usuario_existente($param);
            $response["usuario_registrado"] = 0;
            if ($response["usuario_existe"] == 0 ){

                $response =  $this->registro_prospecto($param);
            }
        }
        $this->response($response);
                 
    }
    private function registro_prospecto($param){
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

        $response["id_usuario"]       =    $this->usuario_model->insert($params , 1);

        if ( $response["id_usuario"]>0 ){

            $q["id_usuario"]    =  $response["id_usuario"];
            $q["puesto"]        =  20;
            $response["usuario_permisos"]  =   $this->agrega_permisos_usuario($q);

            if ($response["usuario_permisos"] > 0) {
                $response["email"]              =  $email;
                $response["usuario_registrado"] = 1;
            }
        }
        return $response;
    }
    function cancelar_envio_recordatorio_PUT(){
        
        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param , "id")){
            $response   =  $this->usuario_model->q_up('recordatorio_publicacion', 0, $param["id"]);
        }
        $this->response($response);
    }    
    function actividad_GET(){
        
        $param    = $this->get();
        $response =  false;

        if (if_ext($param , "fecha_inicio,fecha_termino")){

            $param["usuarios_nuevos"]               = $this->get_num_registros_periodo($param);
            $param["usuarios_direcciones"]          = $this->get_nun_activos_con_direcciones($param);
            $usuarios_clasifican                    = $this->get_agregan_clasificaciones_periodo($param);
            $param["usuarios_clasifican"]           = count($usuarios_clasifican);
            $usuarios_lista_deseos                  = $this->agregan_lista_deseos_periodo($param);
            $param["usuarios_lista_deseos"]         = count($usuarios_lista_deseos);
            $param["usuarios_activos_publican"]     = $this->get_publican_periodo($param);
            $registros                              = $this->usuario_model->registros($param);
            $param["registros"]                     = $registros["num"];
            $param["registros_numeros_telefonicos"] = $registros["registros_numeros_telefonicos"];
            $param["img_perfil"]                    = $this->agregan_img_perfil($param);
            $usuarios_preguntas                     = $this->get_preguntas($param);
            $param["preguntas"]                     = count($usuarios_preguntas);
            $param["fechas"]                        = date_range($param["fecha_inicio"], $param["fecha_termino"]);
            $response                               = $this->get_num_servicios_periodo($param);
            $param["publicaciones"]                 = $response;

            if ($param["v"] ==1) {

                $response    = $this->create_table_usabilidad($param);
                $response   .= "<?=br()?>";
                $response   .= $this->create_table_promotion($param);
                $this->response($response);
            }
        }
        $this->response($response);
    }

    private function create_table_usabilidad($param){

        $heading = [
                    "USUARIOS NUEVOS"       ,
                    "REGISTRAN SU DIRECCIÓN",
                    "INDICAN SU NÚMERO NÚMERO TELEFÓNICO" ,
                    "INDICAN PREFERENCIAS"  , 
                    "AGREGAN LISTA DESEOS"  ,
                    "PUBLICAN PRODUCTOS"    ,
                    "AGREGAN IMAGENES A SU PERFIL",
                    "PREGUNTAN SOBRE PRODUCTOS"
                ];
        $inf = [    $param["registros"],
                    $param["registros_numeros_telefonicos"],
                    $param["usuarios_direcciones"] , 
                    $param["usuarios_clasifican"], 
                    $param["usuarios_lista_deseos"] , 
                    $param["usuarios_activos_publican"],
                    $param["img_perfil"],
                    $param["preguntas"]
                ];      
        $this->table->set_heading($heading);
        $this->table->add_row($inf);
        return $this->table->generate();
    }
    private function create_session($q){

        $api            =     "sess/start";
        $q["t"]         =     "x=0.,!><!$#";
        $q["secret"]    =     $q["password"];
        return $this->principal->api($api,$q,"json","POST",0,1,"login");
    }
    private function get_num_registros_periodo($q){

        return $this->usuario_model->num_registros_periodo($q);

    }
    public function create_table_promotion($param){
        array_unshift($param["fechas"] , "Fechas");
        $this->table->set_heading($param["fechas"]);
        
        $publicaciones   = array(); 
        $registros       = array();
        $total           = count($param["fechas"]);
        $a               = 1;
        
        foreach($param["fechas"] as $fecha) {
            
            $num = $this->search_element_array($param["publicaciones"] , "fecha_registro" , $fecha , "num");
            $config     =  array(   'class' =>  'servicios' , 
                                    'fecha_inicio'    =>  $fecha, 
                                    'fecha_termino'   =>  $fecha, 
                                    'href'            =>  "#reporte",
                                    'data-toggle'     =>  "tab",
                                    'title'           =>  "Servicios postulados"
                                        );

            $num    = ($num > 0)? anchor_enid($num, $config):0;
            $config     =  array(   'class' =>  'usuarios' , 
                                    'fecha_inicio'    =>  $fecha, 
                                    'fecha_termino'   =>  $fecha, 
                                    'href'            =>  "#reporte",
                                    'data-toggle'     =>  "tab",
                                    'title'           =>  "Servicios postulados"
                                        );

            $num_registros  = $this->search_element_array($param["usuarios_nuevos"] ,
                "fecha" , $fecha , "num");
            $num_registros = ($num_registros > 0)? anchor_enid($num_registros, $config):0;
            if ($a < $total) {
                array_push($publicaciones, $num);                
                array_push($registros, $num_registros);                
            }
            $a ++;  
            
        }
        array_unshift($publicaciones , "PRODUCTOS PUBLICADOS");
        array_unshift($registros     , "USUARIOS NUEVOS");
        $this->table->add_row($publicaciones);
        $this->table->add_row($registros);
        return   $this->table->generate();

    }
    function search_element_array($array , $key , $comparador , $key_val ){
        $num =0;
        foreach ($array as $row) {
            
            if ($row[$key] == $comparador) {
                $num = $row[$key_val];
                break;
            }
        }
        return $num;
    }
    private function notifica_modificacion_password(){


        $email      =   $this->principal->get_session("email");
        $nombre     =   $this->principal->get_session("nombre");
        $asunto     =   "Alerta de cambio de contraseña";
        $cuerpo     =   get_mensaje_modificacion_pwd($nombre);
        $q          =   get_request_email($email, $asunto , $cuerpo);
        return  $this->principal->send_email_enid($q , 1);

    }
    private function notifica_registro_exitoso($q){
        $api = "emp/solicitud_afiliado/format/json/";
        return  $this->principal->api( $api , $q);
    }
    private function agrega_lista_deseos($id_usuario ,$id_servicio){

        $q["id_usuario"]    = $id_usuario;
        $q["id_servicio"]   = $id_servicio;
        $api = "usuario_deseo/add_lista_deseos";
        return  $this->principal->api( $api , $q , "json", "PUT");
    }
    private function get_usuario_por_servicio($q){

        $api =  "servicio/usuario_por_servicio/format/json/";
        return $this->principal->api( $api , $q);
    }
    private function get_nun_activos_con_direcciones($q){
        $api = "usuarios_direccion/activos_con_direcciones/format/json/";
        return $this->principal->api($api , $q );
    }
    private function get_agregan_clasificaciones_periodo($q){

        $api = "usuario_clasificacion/agregan_clasificaciones_periodo/format/json/";
        return $this->principal->api($api , $q );
    }
    private function agregan_lista_deseos_periodo($q){

        $api = "usuario_deseo/agregan_lista_deseos_periodo/format/json/";
        return $this->principal->api($api , $q );
    }
    private  function get_publican_periodo($q){
        return $this->usuario_model->publican_periodo($q);
    }
    private function agregan_img_perfil($q){

        $api =  "imagen_usuario/img_perfil/format/json/";
        return $this->principal->api($api , $q );

    }
    private function agrega_permisos_usuario($q){

        $api = "usuario_perfil/permisos_usuario";
        return $this->principal->api( $api , $q, "json" , "POST");
    }
    private function get_preguntas($q){
        $api =  "pregunta/periodo/format/json/";
        return $this->principal->api($api , $q );
    }
    private function get_num_servicios_periodo($q){
        $api =  "servicio/num_periodo/format/json/";
        return $this->principal->api($api , $q );
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Servicio extends REST_Controller{
  public  $options;
  private $id_usuario;
  function __construct(){
      parent::__construct();                     
      $this->load->helper("servicios");      
      $this->load->helper("base");       
      $this->load->model("serviciosmodel");                              
      $this->load->library('table');       
      $this->load->library(lib_def());         
      $this->id_usuario = $this->principal->get_session("idusuario");
      
  } 
  function envio_gratis_GET(){
    
    $param    =   $this->get();        
    $response =   [];
    if (if_ext($param , "id")) {
        
        $id_servicio  =   $param["id"];         
        $response     =   $this->serviciosmodel->q_get(["flag_envio_gratis"], $id_servicio);      
    
    }    
    $this->response($response);      
  }
  /**/
  function clasificaciones_destacadas_GET(){

    $param    =  $this->get();    
    $response =  $this->serviciosmodel->get_clasificaciones_destacadas($param);
    $this->response($response);
  }
  function nombre_servicio_GET(){

    $param  = $this->get();
    $id     = $param["id"];
    return $this->serviciosmodel->q_get(["nombre_servicio"], $id);
  }    
  /**/
  function color_POST(){

    $param =  $this->post();    
    $response=  $this->serviciosmodel->agrega_color_servicio($param);
    $this->response($response);
  }
  function color_DELETE(){

    $param =  $this->delete();    
    $response=  $this->serviciosmodel->elimina_color_servicio($param);
    $this->response($response);
  }
  /**/
  function nombre_estado_enid_GET(){

    $param =  $this->get();
    $response =  $this->serviciosmodel->get_nombre_estado_enid_service($param);
    $this->response($response);
  }
  /**/
  function clasificaciones_por_id_servicio_GET(){

        $param         = $this->get();
        $id_servicio   =  $param["id_servicio"];
        $response      = $this->serviciosmodel->get_clasificaciones_por_id_servicio($id_servicio);
        $this->response($response);
  }

  /*
  function categorias_PUT(){

    $param                      = $this->put();    
    $param["nombre_servicio"]   =  $this->serviciosmodel->get_nombre_servicio($param);
    $tags                       = $this->create_tags($param);    
    $text_tags                  =  implode($tags, ",");
    $param["metakeyword"]       =  $text_tags;  
    $response                   =  
    $this->serviciosmodel->update_categorias_servicio($param);
    $this->response($response);    
  }
  */
  function set_metakeyword_usuario($q){
    $api =  "metakeyword/usuario";
    return $this->principal->api( $api , $q , "json" , "PUT");
  }
  function metakeyword_usuario_DELETE(){

    $param      =  $this->delete();
    $response   =  $this->serviciosmodel->delete_tag_servicio($param);    
    $response   =  $this->set_metakeyword_usuario($param);        
    $this->response($response);
  }
  /**/
  /**/
  function get_option($key){
    return $this->options[$key];
  }
  /**/
  function set_option($key , $value){
    $this->options[$key] = $value;
  }
  function get_categorias_servicios($q){

    $api = "clasificacion/categorias_servicios/format/json/";
    return $this->principal->api( $api , $q);
  }
  /**/
  function lista_categorias_servicios_GET(){
    
    $param =  $this->get();    
    $data["info_categorias"] =  $this->get_categorias_servicios($param);
    $data["nivel"]           =  $param["nivel"];

    if(count($data["info_categorias"]) > 0){

        $nivel=  "nivel_".$data["nivel"];                        
        $config  = array(
          'class' => 'num_clasificacion '.$nivel.' selector_categoria ' ,
          'size'  =>'20' );

        if ($param["is_mobile"] ==  1) {
            
            $config  = array(            
            'class'   => 'num_clasificacion '.$nivel.' 
                          num_clasificacion_phone selector_categoria ' 
            );  
        }

        $info_categorias =  $data["info_categorias"];                
        $select  =  select_enid($info_categorias , 
                            "nombre_clasificacion" , 
                            "id_clasificacion" ,  
                            $config);  
                  
        $this->response($select);  

        
    }else{
        
      $data["padre"] = $param["padre"];  
      $select =  div(
                        "AGREGAR NUEVO" .icon('fa fa-angle-double-right')  ,  
                        ["class"  =>  "a_enid_black nueva_categoria_producto top_20",
                        "id"      =>  $data["padre"]
                      ],
                    1); 
        
      $this->response($select);
    }

  }
  /**/
  function verifica_existencia_clasificacion_GET(){
    
    $param          =  $this->get();
    $coincidencias  =  $this->get_coincidencias_busqueda($param);  
    $this->response($coincidencias);   

  }
  /**/
  function get_clasificacion_padre_nivel($q){

      $api = "clasificacion/clasificacion_padre_nivel/format/json/";
      return $this->principal->api( $api , $q);
  }
  function get_coincidencia_servicio($q){

    $api  = "clasificacion/coincidencia_servicio/format/json/";
    return  $this->principal->api( $api , $q);
  }   
  /**/
  function get_coincidencias_busqueda($param){

    $coincidencia =  $this->get_coincidencia_servicio($param);
    $res =  [];
    $z =0;
    if (count($coincidencia)>0) {
        $coincidencia =  $coincidencia[0];
        $a = $coincidencia["nivel"];
        $res[$a] = $coincidencia;
        
        $z =0;
        $nueva_coincidencia  = $coincidencia;
        while ( $a > 0) {
                  
          if ($z == 0) {                      
            $res[$a] = $coincidencia;            

          }else{          

              //debug($nueva_coincidencia , 1);
              $n = $this->get_clasificacion_padre_nivel($nueva_coincidencia);
              if ( is_array($n) &&  count($n)>0) {
                $res[$a] = $n[0];     
                $nueva_coincidencia =  $n[0];
              }            
          }
          $z ++;
          $a --;  
        }       
    }        

    $response["total"]=  count($res);  
    $response["categorias"]=  $res;
    return $response;
  }

  function status_PUT(){

    $param    = $this->put();
    $response = [];

    if (if_ext($param , "status,id_servicio")) {
      

      $status       = ($param["status"] ==  1 ) ? 0 : 1;
      $id_servicio  = $param["id_servicio"];
      $response = $this->serviciosmodel->q_up("status" , $status , $id_servicio);
    }

    $this->response($response);

  }
  /*
  function clasifiacion_GET(){
    
    $param = $this->get();
    $response = $this->serviciosmodel->get_clasificacion($param);    
    $select =  create_select($response , 
      "categoria" , 
      "form-control" , 
      "categoria" , 
      "nombre_clasificacion" , 
      "id_clasificacion");

    $this->response($select);
  } 
  */ 
  /**/
  function tallas_GET(){    
    $param            =  $this->get();      
    $params           = [ "primer_nivel",
                          "segundo_nivel",
                          "tercer_nivel",
                          "cuarto_nivel", 
                          "quinto_nivel" , 
                          "id_servicio",
                          "talla"];                
    $this->response($this->serviciosmodel->q_get($params , $param["id_servicio"]));
  }  
  function index_POST(){      
      
      if($this->input->is_ajax_request()){         
        $param =  $this->post();        
        
        $response["registro"] = 
        (ctype_digit($param["precio"]) && $param["precio"] >= 0)?$this->registra_data_servicio($param):0;
        $this->response($response);  
        
      }else{
        $this->response("error");
      }
  }
  /**/
  function registra_data_servicio($param){

        $next =  ($param["flag_servicio"] == 0 && $param["precio"] == 0)?0:1;         
        $data_complete["mensaje"] =  ($next ==1)?"":"TU PRODUCTO DEBE TENER ALGÚN PRECIO";
        if ($next) {

            $tags                       =   $this->create_tags($param);                         
            $text_tags                  =   implode($tags, ",");
            $param["metakeyword"]       =   $text_tags;
            $id_usuario                 =   $this->id_usuario;
            $param["id_usuario"]        =   $id_usuario;        
            $terminos_usuario           =   $this->get_terminos_privacidad_productos($id_usuario);            
            $terminos                   =   $terminos_usuario[0];            
            $param["entregas_en_casa"]  =   ($terminos["entregas_en_casa"] > 0)?1:0;
            $param["telefonos_visibles"]=   ($terminos["telefonos_visibles"] > 0 )?1:0;    

            $data_complete["servicio"]  =   $this->create_servicio($param);

        }
        
        return $data_complete;
  }
  function create_servicio($param){
        
        $nombre_servicio  =  $param["nombre_servicio"];        
        $flag_servicio    =  $param["flag_servicio"];
        
        $primer_nivel  = 
        (array_key_exists("primer_nivel", $param))?$param["primer_nivel"]:0;

        $segundo_nivel =   
        (array_key_exists("segundo_nivel", $param))?$param["segundo_nivel"]:0;
        
        $tercer_nivel  =   
        (array_key_exists("tercer_nivel", $param))?$param["tercer_nivel"]:0;
        
        $cuarto_nivel  =   
        (array_key_exists("cuarto_nivel", $param))?$param["cuarto_nivel"]:0;
        
        $quinto_nivel  =   
        (array_key_exists("quinto_nivel", $param))?$param["quinto_nivel"]:0;
        
        $descripcion            = "";  
        $metakeyword            =   $param["metakeyword"];      
        $id_usuario             =   $param["id_usuario"];
        $entregas_en_casa       =   $param["entregas_en_casa"];
        $telefonos_visibles     =   $param["telefonos_visibles"];
        
        $precio = $param["precio"];
        $id_ciclo_facturacion = 5;
        if ($flag_servicio ==  1){        
            $id_ciclo_facturacion = $param["ciclo_facturacion"];
        }


        
        $params = [
                "nombre_servicio"             =>  $nombre_servicio,
                "flag_servicio"               =>  $flag_servicio ,
                "primer_nivel"                =>  $primer_nivel ,
                "segundo_nivel"               =>  $segundo_nivel,
                "tercer_nivel"                =>  $tercer_nivel,
                "cuarto_nivel"                =>  $cuarto_nivel ,
                "quinto_nivel"                =>  $quinto_nivel,
                "descripcion"                 =>  $descripcion,
                "metakeyword"                 =>  $metakeyword,
                "id_usuario"                  =>  $id_usuario,
                "precio"                      =>  $precio,
                "id_ciclo_facturacion"        =>  $id_ciclo_facturacion ,
                "entregas_en_casa"            =>  $entregas_en_casa,
                "telefono_visible"            =>  $telefonos_visibles];


        //
        
        if ($this->principal->getperfiles() ==  3) {
            $params["tiempo_promedio_entrega"] =  1;
        }
        
        

        $id_servicio    =  $this->serviciosmodel->insert($params, 1);        
        $this->set_ultima_publicacion($id_usuario);
        return $id_servicio;        
  }  
  function set_ultima_publicacion($id_usuario){
    
    $q["id_usuario"]  =  $id_usuario;
    $api              = "usuario/ultima_publicacion";
    return $this->principal->api( $api , $q , "json" , "PUT");
  }
  /**/
  function create_tags($param){

        /**/
        $primer_nivel  = 
        (array_key_exists("primer_nivel", $param))?$param["primer_nivel"]:0;

        $segundo_nivel =   
        (array_key_exists("segundo_nivel", $param))?$param["segundo_nivel"]:0;
        
        $tercer_nivel  =   
        (array_key_exists("tercer_nivel", $param))?$param["tercer_nivel"]:0;
        
        $cuarto_nivel  =   
        (array_key_exists("cuarto_nivel", $param))?$param["cuarto_nivel"]:0;
        
        $quinto_nivel  =   
        (array_key_exists("quinto_nivel", $param))?$param["quinto_nivel"]:0;
        
      /**/
      $nombre_servicio =  $param["nombre_servicio"];      
      $valor_precio =  get_info_variable($param , "precio" );

      
      $lista_clasificaciones = [$primer_nivel , 
        $segundo_nivel , 
        $tercer_nivel , 
        $cuarto_nivel , 
        $quinto_nivel];

      $lista_nombres = [];  
      for($a=0; $a <count($lista_clasificaciones); $a++) { 
        
        if($lista_clasificaciones[$a] > 0){


          $id_clasificacion =  $lista_clasificaciones[$a];
          $nombre_clasificacion=  $this->get_tag_categorias($id_clasificacion);          
          array_push($lista_nombres, $nombre_clasificacion);

        }
      }

      array_push($lista_nombres, $nombre_servicio);
      if ($valor_precio > 0 ) {
          array_push($lista_nombres, $valor_precio);  
      }
      
      return $lista_nombres;

  }
  function top_semanal_vendedor_GET(){

        $param          =  $this->get();
        $response       =  $this->serviciosmodel->get_top_semanal_vendedor($param);        
        $data_complete  = [];
        $a =0;
        foreach ($response as $row){
            
            $id_servicio  =  $row["id_servicio"];    
            $nombre       =  
            $this->serviciosmodel->q_get(["nombre_servicio"],$id_servicio)[0]["nombre_servicio"];
            $data_complete[$a] =  $row;
            $data_complete[$a]["nombre_servicio"] =  $nombre;
            $a ++;
        }
        $this->response($data_complete);

  }
  /**/
  function get_tag_categorias($id_clasificacion){

    $q["id_clasificacion"] =  $id_clasificacion;
    $api =  "clasificacion/nombre/format/json/";
    return $this->principal->api( $api , $q);      
  }
  /*
  function terminos_q_GET(){

    $param =  $this->get();    
    $terminos_servicio 
    = $this->serviciosmodel->get_terminos_disponibles_join_servicio_q($param);
    $response =  get_lista_terminos($terminos_servicio);
    $this->response($response);
  } 
  */
  /**/

  /*
  function servicio_grupo_PUT(){

    $param = $this->put();
    $response =  $this->serviciosmodel->asocia_servicio_grupo($param);
    $this->response($response);

  }
  */
  /**/
  function grupo_form_POST(){          
      $param =  $this->post();
      $response =  $this->serviciosmodel->create_grupo($param);
      $this->response($response);
  }
  /**/
  function grupo_form_GET(){    
      /**/
      $param =  $this->get();
      $this->load->view("servicio/form_grupo");
  }
  /**/
  function precio_GET(){
    /**/
    $param =  $this->get();
    $response = $this->serviciosmodel->get_precio_servicio($param);
    $this->response($response);
  }
  /**/
  
  /**/
  function servicios_grupo_GET(){
      
    $param =  $this->get();
    $response =  $this->serviciosmodel->get_servicios_grupo_left_join($param);
    $data["servicios"] = $response;
    $this->load->view("servicio/lista_servicios_grupo" , $data);
  }
  function crea_data_costo_envio(){        
    $param["flag_envio_gratis"] = $this->get_option("servicio")[0]["flag_envio_gratis"];   
    return $param;
  }
  /**/
  function get_porcentaje_comision($q){    

      $api =  "cobranza/comision/format/json/";
      return $this->principal->api( $api, $q );
  }
  /**/
  function especificacion_GET(){

      $param                    =   $this->get();      
      $this->set_option("id_servicio" ,  $param["id_servicio"]);
      $id_servicio              =   $this->get_option("id_servicio");  
      $servicio                 =   
      $this->serviciosmodel->get([] , ["id_servicio" =>  $param["id_servicio"] ]);
      $data["servicio"]         =    $servicio;
      $this->set_option("servicio" , $servicio);      
      if($servicio[0]["flag_servicio"] ==  0){
        $this->crea_data_costo_envio();            
        $data["costo_envio"]    = 
        $this->principal->calcula_costo_envio($this->crea_data_costo_envio());  
      }

      $clasificaciones            =   $this->carga_clasificaciones($data["servicio"]);
    
      $data["clasificaciones"]    =   $clasificaciones;
      $data["ciclos"]             =   $this->get_not_ciclo_facturacion($param);
      $data["id_usuario"]         =   $this->id_usuario;          
      $imagenes                   =   $this->carga_imagenes_servicio($id_servicio);
      $data["url_request"]        =   get_url_request("");
      $prm["id_servicio"]         =   $id_servicio;           
      $data["num"]                =   $param["num"];      
      $prm["id_servicio"]         =   $id_servicio;
      $data["porcentaje_comision"]=   $this->get_porcentaje_comision($prm);      
      $data["is_mobile"]          =   ($this->agent->is_mobile() === FALSE)?0:1;            
      $data["has_phone"]          =   $this->usuario_tiene_numero($data["id_usuario"]);
      $data["num_imagenes"]       =   count($imagenes);
      $data["images"]             =   $this->create_table_images($imagenes , $data["is_mobile"]);
      $data["id_perfil"]          =   $this->principal->getperfiles();
      $this->load->view("servicio/detalle" , $data);        
      
  }    
  /**/  
  private function create_table_images($imagenes , $is_mobile){

    
    $num_imgs =0; 
    $this->table->set_heading('', '', '' , '','', '', ''  );
    $images_complete = [];
    foreach ($imagenes as $row) {                          
      
      $id_imagen    =  $row["id_imagen"];
      $url_imagen   = get_url_request("imgs/index.php/enid/imagen/".$id_imagen);
      $extra_imagen = ($is_mobile == 0 ) ?  'position:relative;width:150px!important;height:150px!important;': 'position:relative;width:170px!important;height:150px!important;';
      $id_error     = "imagen_".$id_imagen;
      $img = img([
          'src'      => $url_imagen,
          'style'    => $extra_imagen,
          'id'       => $id_error,
          'onerror' => "reloload_img( '".$id_error."','".$url_imagen."');"
      ]);


      $config_imagen      = create_dropdown_button($id_imagen , $row["principal"]);     
      $extra_principal    = ["class"  =>  "selector_principal"];    
      $informacion_imagen = $config_imagen.$img;
      $contenedor_imagen  = 
      ($row["principal"] ==  0) ? $informacion_imagen : div($informacion_imagen, $extra_principal);
      $images_complete[$num_imgs] =  $contenedor_imagen;    
      
      $num_imgs ++;      
    }

    /**/    
    if ($num_imgs < 7 ) {
      
      $url_imagen =
      get_url_request("img_tema/tienda_en_linea/agregar_imagen.png");

      $extra_imagen = ($is_mobile ==  0 ) ? "position: relative;width:160px!important;height:160px;" :  "position: relative;width:160px!important;";
      $img =  img([
                    "class" =>  "img-responsive agregar_img_servicio_img" ,
                    "src"   =>  $url_imagen,
                    "style" =>  $extra_imagen
      ]);

      for ($num_imgs=$num_imgs; $num_imgs <7; $num_imgs++) {

          $info       =  "";
          $icon       = icon("fa fa-camera agregar_img_servicio"); 
          $interior   =  div($icon ,  
                          [
                            "class" => "agregar_img_servicio" ,
                            "style" => 
                            "border-style: solid;position:absolute;z-index:2000;
                            margin-left: 10px;padding: 3px;margin-top: 3px;"
                          ]);                  
          $info = $interior . $img;
          $img_preview  =  div($info);
          $images_complete[$num_imgs] =  $img_preview;  
                        
      }
    }   
    $this->table->add_row($images_complete);   
    return $this->table->generate();
  }
  function empresa_GET(){
    

    if($this->input->is_ajax_request() OR $_SERVER['HTTP_HOST'] ==  "localhost"){ 
      
      $param                              =   $this->get();
      $param["q"]                         =   $this->get("q");
      $param["id_usuario"]                =   $this->id_usuario;  
      $param["id_clasificacion"]          =   get_info_variable($param , "q2" );   
      $param["extra"]                     =   $param;            
      $param["resultados_por_pagina"]     =   12;
      $param["agrega_clasificaciones"]    =   0;
      $param["vendedor"]                  =   0;

      $servicios =  $this->get_servicios_empresa($param);        
      
      if (count($servicios) > 0){    
        if($servicios["num_servicios"] > 0){                                    
                        
          $config_paginacion["totales_elementos"] =  $servicios["num_servicios"];
          $config_paginacion["per_page"]          = 12;
          $config_paginacion["q"]                 = $param["q"];                                
          $config_paginacion["q2"]                = 0;   
          $config_paginacion["page"]              = get_info_variable($this->input->get() , "page" );

          $data["busqueda"]                       =  $param["q"];                                             
          $data["num_servicios"]                  =  $servicios["num_servicios"];
          $this->set_option("in_session" , 1);
          $this->set_option("id_usuario" , $this->id_usuario);
          $data["lista_productos"]                = $this->agrega_vista_servicios($servicios["servicios"]);
          
          $data["paginacion"]                     = $this->principal->create_pagination($config_paginacion);
          debug($data["paginacion"]);
          $this->load->view("producto/basico_empresa" , $data);                    
          
          

        }      

      }else{
            $data_complete["num_servicios"] = 0;            
            $data_complete["info_servicios"] = 
            icon("fa fa-search").span("Tu búsqueda de ".$param["q"]." (0 Productos) ");
            $this->response($data_complete);        
      }
    }else{
      $this->response("error");      
    }
    
  }      
  function agrega_vista_servicios($data_servicio){
    $data_complete = [];
    $a = 0;
    foreach ($data_servicio as $row){        
      $data_complete[$a] =  $this->get_vista_servicio($row);
      $a ++;            
    }
    return $data_complete;
  }  
  function get_vista_servicio($q){
        
        $q["in_session"] =  $this->get_option("in_session");
        $q["id_usuario"] =  $this->get_option("id_usuario");        
        $api  =  "servicio/crea_vista_producto/format/html/";
        return $this->principal->api(  $api , $q , "html" );  
  }
  function get_servicios_empresa($q){
    $q["es_empresa"] = 1;
    $api  =  "servicio/q/format/json/";
    return  $this->principal->api(  $api , $q);  
  }
  /**/
  function get_not_ciclo_facturacion($q){

    $api =  "ciclo_facturacion/not_ciclo_facturacion/format/json/";
    return $this->principal->api( $api , $q  );      
  } 
  /**/
  function get_info_ciclo_facturacion_servicio($q){
    $api =  "cobranza/calcula_costo_envio/format/json/";
    return $this->principal->api( $api , $q  );          
  }
  /**/  
  function get_costo_envio($q){
    $api = "cobranza/calcula_costo_envio/format/json/";
    return $this->principal->api( $api , $q  );                    
  }
  /**/
  function carga_clasificaciones($servicio){
    
    $lista_clasificaciones = ["primer_nivel" , 
    "segundo_nivel" , 
    "tercer_nivel"  , 
    "cuarto_nivel"  , 
    "quinto_nivel"];

    $lista = [];
    for ($a=0; $a < count($lista_clasificaciones); $a++){       
      $id_clasificacion =  $servicio[0][$lista_clasificaciones[$a]];
      if($id_clasificacion > 0) {
        $data_clasificacion = $this->get_clasificacion_por_id($id_clasificacion);
        if (count($data_clasificacion)>0) {          
          array_push($lista, $data_clasificacion[0]);    
        }          
      }                
    }
    return $lista;
  }
  /**/
  function get_clasificacion_por_id($id_clasificacion){
    
    $q["id_clasificacion"] =  $id_clasificacion;
    $api = "clasificacion/id/format/json/";
    return $this->principal->api( $api , $q  );      
  }
  /**/
  function carga_imagenes_servicio($id_servicio){

    $q["id_servicio"] =  $id_servicio;
    $api = "imagen_servicio/servicio/format/json/";
    return $this->principal->api( $api , $q  );              
  }  
  /**/
  function terminos_servicios_POST(){

    $param =  $this->post();
    $response =  $this->serviciosmodel->create_termino_servicio($param);
    $this->response($response);
  }
  
  
  /**/
  function grupos_GET(){

      $param                        =  $this->get();
      $info_grupos                  =  $this->serviciosmodel->get_grupos($param);
      $data_complete["info_grupos"] = $info_grupos;            
      $this->load->view("servicio/grupo" , $data_complete);         
  }
  /**/
  function grupo_GET(){
    $param                 =  $this->get();
    $servicios             =  $this->serviciosmodel->get_servicios_grupo($param);
    $caracteristicas_grupo =  $this->serviciosmodel->get_caracteristicas_globales_grupo_servicios($param);
    
    $data["table"]         =  $this->get_table_servicios($servicios , $caracteristicas_grupo , 1);

    $data["grupo"] =  $param["grupo"];
    $data["caracteristicas_grupo"] = $caracteristicas_grupo;
    $this->load->view("servicio/lista_grupos_servicios" , $data);
    
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
                $list .= "<td >" .$caracteristica ."</td>";
                for ($a=0; $a < count($tmp_servicios); $a++){    

                    $num_exist =  
                    $this->serviciosmodel->valida_termino_aplicable(
                        $tmp_servicios[$a], 
                        $id_caracteristica );

                    $text =icon("fa fa-check-circle");
                    if ($num_exist == 0 ) {
                        
                        $text =icon('fa fa-times red_enid_background white' , ["style"=>"padding: 5px;"]);  
                    }
                    $list .= get_td($text);                
                }

            $list .="</tr>";
        }

        $table_header = $table_header.$list;
        return $table_header;
    } 
  /**/
  private function get_entregas_en_casa_usuario($id_usuario){    
    
    $q["id_usuario"] =  $id_usuario;
    $api = "usuario/entregas_en_casa/format/json/";
    return $this->principal->api( $api , $q  );         
  }
  /**/
  private function get_terminos_privacidad_productos($id_usuario){
    
    $q["id_usuario"] =  $id_usuario;
    $api = "privacidad_usuario/servicio/format/json/";
    return $this->principal->api( $api , $q  );         
  }  
  /**/
  private function usuario_tiene_numero($id_usuario){
    
    $q["id_usuario"] =  $id_usuario;
    $api             = "usuario/has_phone/format/json/";
    return   $this->principal->api( $api , $q );            
  }    
  /**/
  function talla_GET(){

    $param              =  $this->get();    
    $id_servicio        =  $param["id_servicio"];
    $servicio           =  $this->serviciosmodel->q_get(["talla"] , $id_servicio);    
    $servicio_tallas    =  $this->add_tallas($servicio);    
    

    
    if ($param["v"] ==  1) {  

      $response   = 
      (count($servicio_tallas)>0) ? $this->create_button_easy_select_tienda($servicio_tallas):"";      
      $this->response($response);

    }else{
      $this->response($servicio_tallas);  

    }    
  }
  private function create_button_easy_select_tienda($servicio_tallas){

    $config     =   [ 'text_button'     =>  'talla',
                      'campo_id'        =>  'id_talla',
                      'extra'           => 
                        array(
                          'class'       => 'easy_selec facil_selec talla '
                        )
                      ];
                      
    $easy_butons      =  create_button_easy_select($servicio_tallas , $config , 2);         
    
    $config =  ['class'       =>  'dropdown-toggle strong',
                'id'          =>  "dropdownMenuButton",
                'data-toggle' =>  "dropdown"];

    $icon             =  icon('fa fa-angle-right ');
    $boton_seleccion  =  add_element($icon.$icon ." ELIGE TU TALLA ", "div" , $config );

    $contenedor       =  
    add_element($easy_butons,"div", array("class" => "dropdown-menu "));
    $menu             =  
    add_element( $boton_seleccion.$contenedor, "div" , 
      array('class'=> 'dropdown boton-tallas-disponibles'));
    return $menu; 

  }
  /**/
  function add_tallas($talla_servicio){

    $data_complete =  [];
    $a =0;
    $fields               = ["id_talla" , "talla" , "id_country"];
    $tallas_en_servicio   = get_array_json($talla_servicio[0]["talla"]);

    for ($a=0; $a < count($tallas_en_servicio); $a++) { 

        $id_talla =   $tallas_en_servicio[$a];        
        $talla    =   $this->get_talla_id($id_talla , $fields);        
        $talla    =   (count($talla)>0) ? $talla[0]: array();        
        $data_complete[$a]    = $talla;
    }
    return $data_complete;
    
  } 
  /**/
  private function get_talla_id($id_talla , $parametros){
    $param["id"]          =   $id_talla;
    $param["fields"]      =   $parametros;
    return $this->principal->api( "talla/id/format/json/" , $param  );
  }
  /**/
  
  /**/
  private function add_gamificacion_usuario_servicio($param, $valoracion){
    $api                  =  
    "servicio/gamificacion_usuario_servicios/format/json/";
    $param["valoracion"]  = $valoracion;
    return   $this->principal->api(  $api , $param, "json" , "PUT");
  }
  function url_ml_PUT(){

    $param    =  $this->put();
    $response =  [];
    if (if_ext($param , "id_servicio,url")) {
        
        $response = $this->serviciosmodel->q_up("url_ml" , $param["url"] , $param["id_servicio"]);
    }
    $this->response($response);

  }
  /**/
  function gamificacion_deseo_PUT(){    

    $param    =   $this->put();        
    $valor    =   (array_key_exists("valor", $param) ) ? $param["valor"] :  1;    
    $response =   $this->serviciosmodel->set_gamificacion_deseo($param , 1 , $valor);  
    $this->response($response);
  }
  /*Se modifica la calificción del servicio*/
  function gamificacion_usuario_servicios_PUT(){

    $param    = $this->put();
    $response = $this->serviciosmodel->gamificacion_usuario_servicios($param);
    $this->response($response);
    
  }
  function ciclo_facturacion_PUT(){
    
    $param                =  $this->put();
    $id_ciclo_facturacion = $param["id_ciclo_facturacion"];
    $id_servicio          = $param["id_servicio"];

    $response 
    =  $this->serviciosmodel->q_up("id_ciclo_facturacion" , $id_ciclo_facturacion , $id_servicio);
    $this->response($response);  
  }
  function status_imagen_PUT(){ 

      $param        =   $this->put();                

      
      $response     =   
      $this->serviciosmodel->q_up("flag_imagen", $param["existencia"] , $param["id_servicio"]);
      $this->response($response);
  }
  function visitas_PUT(){

    $param    =   $this->put();    
    $response =   [];
    if(if_ext($param , "id_servicio")) {
      $response = $this->serviciosmodel->set_vista($param);        
    }    
    $this->response($response);
  }  
  function entregas_en_casa_PUT(){          

      $param              =  $this->put();            
      $response           =  
      $this->serviciosmodel->q_up("entregas_en_casa", $param["entregas_en_casa"], $param["id_servicio"]);
      $this->response($response);        
  }
  function q_PUT(){

    $param      =   $this->put();
    $response   =   $this->serviciosmodel->set_q_servicio($param);
    $this->response($response);
  }
  function telefono_visible_PUT(){            
      $param                =   $this->put();      
      $id_servicio          =   $param["id_servicio"];
      $response             =  
      $this->serviciosmodel->q_up("telefono_visible" , $param["telefono_visible"] , $id_servicio);
      $this->response($response);    
  }  
  function ventas_mayoreo_PUT(){   
    
    $param                =  $this->put();
    $id_servicio          =  $param["id_servicio"];    
    $response             =  
    $this->serviciosmodel->q_up("venta_mayoreo" , $param["venta_mayoreo"] , $id_servicio);  
    $this->response($response);
  }
  function servicio_categoria_PUT(){
    
    $param                =  $this->put();
    $response             =  $this->serviciosmodel->asocia_termino_servicio($param);
    $this->response($response); 
  }    
  function talla_PUT(){

    $param              =   $this->put();
    $id_servicio        =   $param["id_servicio"];
    $servicio           =   $this->serviciosmodel->q_get(['talla'] , $id_servicio);
    $talla              =   $param["id_talla"];
    $tallas_json        =   ($servicio[0]["talla"]!= null ) ? $servicio[0]["talla"]: get_json_array(array()); 
    $array_tallas       =   get_array_json($tallas_json);
    
    
    $array_tallas =  ($param["existencia"] == 0) ? 
    push_element_json($array_tallas  ,  $talla) : unset_element_array($array_tallas ,  $talla);

    /*ahora solo actualizo**/
    $param["tallas"]          =  get_json_array($array_tallas);  
    $response                 =  $this->serviciosmodel->q_up("talla" ,  $param["tallas"] ,  $id_servicio);
    $this->response($response);
  }
  function costo_PUT(){    
    $param    =  $this->put();
    $response =  $this->serviciosmodel->q_up("precio" , $param["precio"], $param["id_servicio"]);
    $this->response($response);
  }

  function add_gamification_servicio_PUT(){

    $param    = $this->put();
    $response = [];

    switch ($param["type"]) {

      /*USUARIO CANCELA COMPRA*/
      case 2:
        
        $response["tipo"]               = "USUARIO CANCELA COMPRA";
        /*Se notifica que el usuario cancela su compra*/
        
        $api                            = "usuario/cancelacion_compra/format/json/";
        $cancelacion_compra             = $this->principal->api( $api, $param, "json" , "PUT" );
        $response["gamificacion_cancelacion_compra"] = $cancelacion_compra;
        
        /*ahora se baja califición interes compra - Servicio*/
        $response["gamificacion_servicio"]  = $this->add_gamificacion_usuario_servicio($param ,  -1);
        

        break;

      /*YA NO QUIERE RECORDATORIOS SOBRE QUE DEBE PUBLICAR PRODUCTOS*/  
      case 3:
        
        $response["tipo"]                   = 
        "YA NO QUIERE RECORDATORIOS SOBRE QUE DEBE PUBLICAR PRODUCTOS";
        /*ahora se baja califición interes compra - Servicio*/
        $response["gamificacion_servicio"]  = 
        $this->add_gamificacion_usuario_servicio($param ,  -3);
        
        break;
      
      /*EL USUARIO NO CONTESTA A LAS PREGUNTAS DENTRO DEL PERIMÉTRO QUE EXIGE EL CLIENTE*/
      case 4:
        
        $response["tipo"] = 
        "EL USUARIO NO CONTESTA A LAS PREGUNTAS DENTRO DEL PERIMÉTRO QUE EXIGE EL CLIENTE";
        /*ahora se baja califición interes compra - Servicio*/
        $response["gamificacion_servicio"]  = 
        $this->add_gamificacion_usuario_servicio($param ,  -3);
        /*ahora actualizo la gamificación*/      
        break;
      
      default:
        $this->response("ok llega");    
        break;
    }
    $this->response($response);    
  }
  /**/
  function num_venta_usuario_GET(){
        
        $param    =  $this->get(); 
        $response = $this->serviciosmodel->get_num_en_venta_usuario($param);
        $this->response($response);
  }  
  function q_GET(){
        
    $param =  $this->get();        

    $id_usuario = 
    ($this->principal->is_logged_in())?$this->id_usuario:get_info_variable($param , "id_usuario" );
    $param["id_usuario"] =  $id_usuario;

    if (array_key_exists("es_empresa", $param) != false ){
        $this->add_gamificacion_search($param);          
    } 
    $servicios_complete =  $this->serviciosmodel->busqueda($param);
    
      if( count($servicios_complete["servicio"])>0 ){
        $servicios          =  $this->agrega_costo_envio($servicios_complete["servicio"]);         

        $data["servicios"] = $servicios;            
        $data["url_request"] =  get_url_request(""); 
        $data["num_servicios"] =  $servicios_complete["num_servicios"];                
        if($param["agrega_clasificaciones"] == 1){
          $data["clasificaciones_niveles"]  =  $servicios_complete["clasificaciones_niveles"];    
        }                          
        $this->response($data);                         
      }else{
        $data["num_servicios"] =0;
        $this->response($data);         
      } 
                    
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
    function info_disponibilidad_servicio_GET(){
        $param       =  $this->get();
        $id_servicio =  $param["id_servicio"];
        $servicio =  $this->serviciosmodel->get_informacion_basica_servicio_disponible($param);
        
        $num_servicios                  =   count($servicio); 
        $response["en_existencia"] =   0;
        $response["info_servicio"] =   $servicio;

        if($num_servicios > 0){
            $response["en_existencia"] =1;                
        }else{            
            $response["numero_servicios_disponinble_para_compra"] 
            =  
            $this->serviciosmodel->get_num_existencia($id_servicio);
        }  
        $this->response($response);
    }  
    /**/
    function existencia_GET(){

      $param        =  $this->get();
      $id_servicio  =  $param["id_servicio"];
      $this->response($this->serviciosmodel->get_num_existencia($id_servicio));
    }
    /**/
    function basic_GET(){  

        $param          = $this->get();
        $params         =  ["nombre_servicio" , "telefono_visible" ,"id_usuario" ];
        $id_servicio    =  $param["id_servicio"];
        $response       = $this->serviciosmodel->q_get($params, $id_servicio);
        $this->response($response);
    }    
    /**/
    function add_gamificacion_search($q){
        if(array_key_exists("q", $q) >0 && strlen(trim($q["q"]))>1 ){
            $api =  "metakeyword/gamificacion_search/format/json/";
            $this->principal->api( $api , $q , "json" , "POST");
        }                    
    }    

    function por_clasificacion_GET(){
          
        $param      =  $this->get();                 
        $response   =  [];
        if (if_ext(
          $param, 
          "id_servicio,primer_nivel,segundo_nivel,tercer_nivel,cuarto_nivel,quinto_nivel")) {

            $servicios  =  
            $this->serviciosmodel->get_producto_por_clasificacion($param);
            $response   =  
            $this->agrega_costo_envio($servicios);                        
        }        
        $this->response($response);        
    }
    function qmetakeyword_GET(){

        $param          =  $this->get();        
        $q              = (array_key_exists("q", $param))? $param["q"]:"";
        $param["q2"]    = 0;
        $param["q"]     = $q;
        $param["order"] =  1;
        $param["id_clasificacion"]  =1;
        $param["id_usuario"]        =0;
        $param["vendedor"]          =0;
        $param["resultados_por_pagina"]     = $param["limit"];
        $param["agrega_clasificaciones"]    =0;
        $servicios =  $this->serviciosmodel->busqueda_producto($param);

        if (count($servicios)>0) {
            $response = $this->agrega_costo_envio($servicios["servicio"]);
            $this->response($response);    
        }else{
            $this->response(array());    
        }        
    }
    function base_GET(){
        
        $param    =  $this->get();        
        $response =  $this->serviciosmodel->get_base($param); 
        $this->response($response);
    }    
    /**/
    function periodo_GET(){
        $param      =  $this->get();
        $response   = $this->serviciosmodel->periodo($param);

        $v =  (array_key_exists("v", $param) && $param["v"] > 0 ) ?  $param["v"] : 0;

        switch ($v) {
          case 1:
            
            $data["servicios"]  =  $response;
            $this->load->view("producto/simple" , $data);            
            break;
          
          default:
            $this->response($response);
            break;
        }
        

    }
    function es_servicio_usuario_GET(){
        $param =  $this->get();
        $this->response($this->serviciosmodel->es_servicio_usuario($param));
    }
    function usuario_por_servicio_GET(){
        $param    =  $this->get();
        $response = $this->serviciosmodel->q_get(["id_usuario"] , $param["id_servicio"]);
        $this->response($response);
    }
    function resumen_GET(){

        $param =  $this->get();
        $response = $this->serviciosmodel->get_resumen($param);
        $this->response($response);
    }
    function colores_GET(){        
        $this->load->view("servicio/tabla_colores");
    }  
    function metakeyword_usuario_POST(){
        
        if($this->input->is_ajax_request()){ 
          
          $param                        =   $this->post();
          $param["id_usuario"]          =   $this->id_usuario;      
          $param["metakeyword_usuario"] =   remove_comma($param["metakeyword_usuario"]);        
          $meta                         =   $this->serviciosmodel->get_palabras_clave($param["id_servicio"]);
          $metakeyword_usuario          =   $param["metakeyword_usuario"]; 
          $metakeyword_usuario          =   $meta .",".$metakeyword_usuario;
          
          $response["add"]              =   
          $this->serviciosmodel->q_up("metakeyword_usuario" , $metakeyword_usuario , $param["id_servicio"]);
          $response["add_catalogo"]     = $this->agrega_metakeyword_catalogo($param);

          $this->response($response);
         
        }       
    } 
    function num_periodo_GET($param){
      
      $param    =  $this->get();
      $response =  $this->serviciosmodel->num_periodo($param);
      $this->response($response);
    }
    function num_anuncios_GET(){

      $param    =  $this->get();
      $response =  $this->serviciosmodel->get_num_anuncios($param);
      $this->response($response);
    }
    function agrega_metakeyword_catalogo($q){
      $api =  "metakeyword/add";
      return $this->principal->api( $api , $q , "json"  , "POST");
    }
    function alcance_usuario_GET(){
                
        $param   =  $this->get();
        $alcance =  $this->serviciosmodel->get_alcance_productos_usuario($param);
        $this->response($alcance);
    }
    function crea_vista_producto_GET(){        
        
        $data["servicio"]       =   $this->get();        
        $data["url_request"]    =   get_url_request("");                
        $this->load->view("producto/basico" , $data);
    }

    function metricas_productos_solicitados_GET(){

        $param      =  $this->get();

        $articulos  =  
        $this->serviciosmodel->get_productos_solicitados($param);

        //$this->load->view("producto/principal" , $data);
        $this->table->set_heading(
              "ARTÍCULO",
              'SOLICITES'
              );

        foreach ($articulos as $row) {

          
          $this->table->add_row($row["keyword"] ,  $row["num_keywords"]);  
          
        }
        
        $table = $this->table->generate();
        $this->response($table);
    }    
    function num_lectura_valoraciones_GET(){
        $param    =  $this->get();
        $response =  $this->serviciosmodel->get_num_lectura_valoraciones($param);
        $this->response($response);
    }
    function tiempo_entrega_PUT(){

        $param    =   $this->put();
        $response =   []; 
        if(if_ext($param , "tiempo_entrega,id_servicio")){
          $response   = 
          $this->serviciosmodel->q_up("tiempo_promedio_entrega" , $param["tiempo_entrega"] , $param["id_servicio"]);  
        }  
        $this->response($response);        
    }
    function tipo_entrega_PUT(){

        $param    =   $this->put();
        $response =   []; 
        if(if_ext($param , "tipo,id_servicio")){
          

          $tipo =  "";
          switch ($param["tipo"]) {
            case 1:
              $tipo =  "tipo_entrega_envio";
              break;
            case 2:
              $tipo =  "tipo_entrega_visita";
              break;
            case 3:
              $tipo =  "tipo_entrega_punto_medio";
              break;
            
            default:

              break;
          }
          $response   = $this->serviciosmodel->set_preferencia_entrega($tipo , $param["id_servicio"]);
        }  
        $this->response($response);        

    }
    /**/
    function tipos_entregas_GET(){
      
      $param      =   $this->get();
      $response   =   [];
      $totales    =   [];
      if (if_ext($param , "fecha_inicio,fecha_termino"  )) {
        if ($param["v"] ==  1) {      
            
            $servicios                = $this->serviciosmodel->get_tipos_entregas($param);  
            $tipos_entregas_servicios = $this->get_tipos_intentos_entregas($param);
            $servicios                = une_data($servicios ,  $tipos_entregas_servicios);




            $this->table->set_heading(
              "Servicio",
              'Vistas', 
              'Entregas por envío', 
              'Entregas en negocio' ,
              'Entregas en punto medio', 
              'deseado',
              'valorado', 
              'intentos'
              );

            
            $list = [];
            $a    = 0; 
            foreach ($servicios as $row) {

              
              $vista                        = $row["vista"];
              $tipo_entrega_envio           = $row["mensajeria"];
              $tipo_entrega_visita          = $row["visita_negocio"];
              $tipo_entrega_punto_medio     = $row["punto_encuentro"];
              $deseado                      = $row["deseado"];
              $valoracion                   = $row["valoracion"];
              $id_servicio                  = $row["id_servicio"];
              $intentos                     = $row["intentos"];
  


              $id_error         = "imagen_".$id_servicio;
              $url_img          =   "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
              $img            = img(
                [
                    "src"       => $url_img,
                    "id"        => $id_error,
                    "style"     => "width:50px!important;height:50px!important;",
                    'onerror'   => "reloload_img( '".$id_error."','".$url_img."');"
                ]);
              

              $array  = 
              [ anchor_enid($img , 
                [
                  "href"    => "../producto/?producto=".$id_servicio,
                  "target"  => "_black"
                ]
              ) ,
                $vista, 
                $tipo_entrega_envio,
                $tipo_entrega_visita, 
                $tipo_entrega_punto_medio ,
                $deseado,
                $valoracion   
              ];

              $this->table->add_row($array);                

            }


            $tb_general  = $this->table->generate();
            $tb_headers  = $this->get_headers_tipo_entrega($servicios);
            $total       = $tb_headers .br().hr().br(). $tb_general;
            $response    = $total;
                      
                      


        }

      }
      $this->response($response);
    }

    function get_headers_tipo_entrega($array){


      $this->table->set_heading(
              
              'Vistas', 
              'Entregas por envíos', 
              'Entregas en negocio' ,
              'Entregas en puntos medios', 
              'deseados',
              'valoraciones'
              );

      $this->table->add_row(
        sumatoria_array($array ,"vista"),
        sumatoria_array($array ,"mensajeria"),
        sumatoria_array($array ,"visita_negocio"),
        sumatoria_array($array ,"punto_encuentro"),
        sumatoria_array($array ,"deseado"),
        sumatoria_array($array ,"valoracion")

      );
      
      return  $this->table->generate();
    }
    function sugerencia_GET(){
        $param                =   $this->get();
        $response             =   [];

        if (if_ext($param ,  "servicio")) {
        
          $id_servicio          =  $param["servicio"];
          $clasificaciones      =  
          $this->serviciosmodel->get_clasificaciones_por_id_servicio($id_servicio);  

          if (count($clasificaciones) > 0 ) {               
              $response   = $this->get_servicios_por_clasificaciones($clasificaciones[0]);   
          }          
        }
       
        $servicios = $this->completa_servicios_sugeridos($response , $param); 
       
        debug($servicios , 1);
        if (count($servicios) > 0 ){           
            $data["servicios"]  =  $servicios;
            $data["url_request"]=  get_url_request("");
            $data["is_mobile"]  = $this->get_option("is_mobile");
            $this->load->view("producto/sugeridos" , $data);
        }else{            
            $data_response["sugerencias"] =0;
            $this->response($data_response);
        } 
        

    }
    function completa_servicios_sugeridos($servicios, $param){
        
        $in_session     =   $this->principal->is_logged_in();
        $n_servicios    =   [];
        $existentes     =   count($servicios);
        if ( $existentes > 0) {
            $n_servicios = $servicios;
        }
        $limit =  "";
        
        if ($existentes<7 ){


            $limit =  7 - $existentes;
            $param["limit"]         = $limit;
            if ($in_session  !=  false   ) {                                                
                $param["id_usuario"]    = $this->principal->get_session("idusuario");
                $sugerencias            = $this->get_servicios_lista_deseos($param);            
                $sugerencias            = $this->agrega_costo_envio($sugerencias);
                foreach ($sugerencias as $row) {
                    array_push($n_servicios, $row);
                }   
            }
            else{

                $sugerencias     =  $this->busqueda_producto_por_palabra_clave($param);
                if ($sugerencias !=  NULL ) {
                    foreach ($sugerencias as $row) {
                        array_push($n_servicios, $row);
                    }                  
                }
                
            }                     
        }
        return $n_servicios;        
    }
    private function busqueda_producto_por_palabra_clave($q){
        $api  =  "servicio/qmetakeyword/format/json/";
        return $this->principal->api(  $api , $q );             
    }
    function get_servicios_lista_deseos($q){        
        $api  =  "usuario/lista_deseos_sugerencias/format/json/";
        return $this->principal->api(  $api , $q );         
    }
    private function  get_tipos_intentos_entregas($q){
      $api =  "intento_tipo_entrega/periodo/format/json/";
      return $this->principal->api( $api , $q );      
    }
    private function  get_servicios_por_clasificaciones($q){
      
      $api =  "servicio/por_clasificacion/format/json/";
      return $this->principal->api( $api , $q );      
    }
    

}?>
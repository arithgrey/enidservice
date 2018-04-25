<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Servicio extends REST_Controller{
  public $options;
  function __construct(){
        parent::__construct();                     
        $this->load->helper("servicios");                        
        $this->load->model("serviciosmodel");                        
        $this->load->library('restclient');
        $this->load->library('sessionclass');      
  } 
  /**/
  function entregas_en_casa_PUT(){
        /**/
      $param =  $this->put();
      $param["id_usuario"] = $this->sessionclass->getidusuario();
      $db_response =  $this->serviciosmodel->update_entregas_en_casa($param);
      $this->response($db_response);
        
  }
  function telefono_visible_PUT(){
        /**/
      $param =  $this->put();
      $param["id_usuario"] = $this->sessionclass->getidusuario();
      $db_response =  $this->serviciosmodel->update_telefono_visible($param);
      $this->response($db_response);
        
  }
  /**/
  function color_POST(){

    $param =  $this->post();    
    $db_response=  $this->serviciosmodel->agrega_color_servicio($param);
    $this->response($db_response);
  }
  function color_DELETE(){

    $param =  $this->delete();    
    $db_response=  $this->serviciosmodel->elimina_color_servicio($param);
    $this->response($db_response);
  }
  /**/
  function nombre_estado_enid_GET(){

    $param =  $this->get();
    $db_response =  $this->serviciosmodel->get_nombre_estado_enid_service($param);
    $this->response($db_response);
  }
  /**/
  function categorias_PUT(){

    $param = $this->put();
    /**/    
    $param["nombre_servicio"] =  $this->serviciosmodel->get_nombre_servicio($param);
    $tags = $this->create_tags($param);    
    $text_tags =  implode($tags, ",");
    $param["metakeyword"] =  $text_tags;
    
    
    $db_response =  $this->serviciosmodel->update_categorias_servicio($param);
    $this->response($db_response);
    
    
  }
  /**/
  function metakeyword_usuario_DELETE(){

    $param =  $this->delete();
    $db_response =  $this->serviciosmodel->delete_tag_servicio($param);    
    $this->response($db_response);
  }
  /**/
  function metakeyword_usuario_POST(){
    /**/
    if($this->input->is_ajax_request()){ 
      $param =  $this->post();
      $db_response =  $this->serviciosmodel->agrega_metakeyword($param);
      $this->response($db_response);
    }
  }
  /**/
  function get_option($key){
    return $this->options[$key];
  }
  /**/
  function set_option($key , $value){
    $this->options[$key] = $value;
  }
  /**/
  function lista_categorias_servicios_GET(){
    
    $param =  $this->get();
    $data["info_categorias"] =  $this->serviciosmodel->get_categorias_servicios($param);
    $data["nivel"]=  $param["nivel"];
    if(count($data["info_categorias"]) > 0){
        
        $this->load->view("categoria/principal" , $data);  
    }else{
        $data["padre"] = $param["padre"];        
        $this->load->view("categoria/seleccionar_categoria" , $data);  
    }  
  }
  /**/
  function clasifiacion_GET(){
    
    $param = $this->get();
    $db_response = $this->serviciosmodel->get_clasificacion($param);    
    $select =  create_select($db_response , 
      "categoria" , 
      "form-control" , 
      "categoria" , 
      "nombre_clasificacion" , 
      "id_clasificacion");

    $this->response($select);
  }  
  /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function nuevo_POST(){      
      /**/
      if($this->input->is_ajax_request()){ 
        $param =  $this->post();              
        $tags =  $this->create_tags($param);             
        $text_tags =  implode($tags, ",");
        $param["metakeyword"] =  $text_tags;
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $db_response = $this->serviciosmodel->create_servicio($param);    
        $this->response($db_response);    
        
      }else{
        $this->response("error");
      }
  }
  /**/
  function create_tags($param){

    /**/
      $primer_nivel =  $param["primer_nivel"];
      $segundo_nivel = $param["segundo_nivel"];
      $tercer_nivel = $param["tercer_nivel"];
      $cuarto_nivel =  $param["cuarto_nivel"];
      $quinto_nivel =  $param["quinto_nivel"];
      /**/
      $nombre_servicio =  $param["nombre_servicio"];

      
      $valor_precio =  get_info_variable($param , "precio" );


      
      /**/
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

  /**/
  function  get_tag_categorias($id_clasificacion){
        
        $q["id_clasificacion"] =  $id_clasificacion;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("clasificacion/nombre/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);
        
  }
  /**/
  function terminos_q_GET(){

    $param =  $this->get();    
    $terminos_servicio = $this->serviciosmodel->get_terminos_disponibles_join_servicio_q($param);
    $response =  get_lista_terminos($terminos_servicio);
    $this->response($response);
  } 
  /**/
  function q_PUT(){

    $param =  $this->put();
    $db_response = $this->serviciosmodel->update_q_servicio($param);
    $this->response($db_response);
  }
  /**/
  function servicio_grupo_PUT(){

    $param = $this->put();
    $db_response =  $this->serviciosmodel->asocia_servicio_grupo($param);
    $this->response($db_response);

  }
  /**/
  function grupo_form_POST(){    
      /**/
      $param =  $this->post();
      $db_response =  $this->serviciosmodel->create_grupo($param);
      $this->response($db_response);
  }
  /**/
  function grupo_form_GET(){    
      /**/
      $param =  $this->get();
      $this->load->view("servicios/form_grupo");
  }
  /**/
  function precio_GET(){
    /**/
    $param =  $this->get();
    $db_response = $this->serviciosmodel->get_precio_servicio($param);
    $this->response($db_response);
  }
  /**/
  function costo_PUT(){
    $param =  $this->put();
    $db_response = $this->serviciosmodel->update_precio_servicio($param);
    $this->response($db_response);
  }
  /**/
  function servicios_grupo_GET(){
      
    $param =  $this->get();
    $db_response =  $this->serviciosmodel->get_servicios_grupo_left_join($param);
    $data["servicios"] = $db_response;
    $this->load->view("servicios/lista_servicios_grupo" , $data);
  }
  function crea_data_costo_envio(){        
        $param["flag_envio_gratis"]=   $this->get_option("servicio")[0]["flag_envio_gratis"];   
        return $param;
  }
  function calcula_costo_envio($param){
        
        
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_costo_envio/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
  }
  /**/
  function get_porcentaje_comision($param){
      
      $url = "pagos/index.php/api/";         
      $url_request=  $this->get_url_request($url);
      $this->restclient->set_option('base_url', $url_request);
      $this->restclient->set_option('format', "json");        
      $result = $this->restclient->get("cobranza/comision/format/json/", $param);
      $response =  $result->response;        
      return json_decode($response , true); 
  }
  /**/
  function especificacion_GET(){

      $param =  $this->get();      
      $this->set_option("id_servicio" ,  $param["servicio"]);
      $id_servicio =  $this->get_option("id_servicio");  
      $servicio  =  $this->serviciosmodel->get_info_servicio($param);      
            
      $data["servicio"] = $servicio;
      $this->set_option("servicio" , $servicio);
      
      if($servicio[0]["flag_servicio"] ==  0){
        $this->crea_data_costo_envio();            
        $data["costo_envio"] = $this->calcula_costo_envio($this->crea_data_costo_envio());  
      }
      $clasificaciones=  $this->carga_clasificaciones($data["servicio"]);
      $data["clasificaciones"] =  $clasificaciones;
      $data["ciclos"] =  $this->serviciosmodel->get_ciclos_facturacion($param);      
      $data["id_usuario"] = $this->sessionclass->getidusuario();      
      $data["imgs"] =  $this->carga_imagenes_servicio($id_servicio);
      $data["url_request"] = $this->get_url_request("");
      $prm["id_servicio"] =  $id_servicio;           
      $data["num"] = $param["num"];      
      $prm["id_servicio"]=$id_servicio;
      $data["porcentaje_comision"] = $this->get_porcentaje_comision($prm);      
      $this->load->view("servicios/detalle" , $data);        
  }    
  /**/  
  /**/
  function get_ciclos_facturacion_servicio($param){
        
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("ciclo_facturacion/servicio/format/json/", $param);        
        $response =  $result->response;      
        return json_decode($response , true);  
        
  } 
  /**/
  function get_info_ciclo_facturacion_servicio(){
    
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_costo_envio/format/json/", $param);        
        $response =  $result->response;      
        return json_decode($response , true);     
  }
  /**/  
  function get_costo_envio($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_costo_envio/format/json/", $param);        
        $response =  $result->response;      
        return json_decode($response , true);      
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
          $data_clasificacion = $this->carga_clasificacion_por_id($id_clasificacion);
          if (count($data_clasificacion)>0) {
            
            array_push($lista, $data_clasificacion[0]);    
          }
          
        }
        
        /**/
    }
    return $lista;
  }
  /**/
  function carga_clasificacion_por_id($id_clasificacion){

      
        $q["id_clasificacion"] =  $id_clasificacion;
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("clasificacion/info_clasificacion/format/json/" , $q);        
        $response  =  $result->response;      
        return json_decode($response , true);
      
  }
  /**/
  function carga_imagenes_servicio($id_servicio){

        $q["id_servicio"] =  $id_servicio;
        $url = "imgs/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("servicios/imagenes_servicio/format/json/" , $q);        
        $response  =  $result->response;      
        return json_decode($response , true);
        
  }  
  /**/
  function terminos_servicios_POST(){

    $param =  $this->post();
    $db_response =  $this->serviciosmodel->create_termino_servicio($param);
    $this->response($db_response);
  }
  /**/
  function servicio_categoria_PUT(){
    
    $param =  $this->put();
    $db_response =  $this->serviciosmodel->asocia_termino_servicio($param);
    $this->response($db_response); 
  }
  /**/
  function ciclo_facturacion_PUT(){

    $param =  $this->put();
    $db_response =  $this->serviciosmodel->cambia_ciclo_facturacion($param);
    $this->response($db_response);  
  }
  /**/
  function grupos_GET(){

      $param =  $this->get();
      $info_grupos =  $this->serviciosmodel->get_grupos($param);
      /********************/      
      $data_complete["info_grupos"] = $info_grupos;            
      $this->load->view("servicios/grupo" , $data_complete);         
      

  }
  /**/
  function grupo_GET(){

    
    $param =  $this->get();
    $servicios =  $this->serviciosmodel->get_servicios_grupo($param);
    $caracteristicas_grupo = $this->serviciosmodel->get_caracteristicas_globales_grupo_servicios($param);
    
    $data["table"]=  $this->get_table_servicios(
                            $servicios , 
                            $caracteristicas_grupo , 
                            1);

    
    $data["grupo"] =  $param["grupo"];
    $data["caracteristicas_grupo"] = $caracteristicas_grupo;
    $this->load->view("servicios/lista_grupos_servicios" , $data);
    
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
                    $this->serviciosmodel->valida_termino_aplicable(
                        $tmp_servicios[$a], 
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
/**/
}
?>
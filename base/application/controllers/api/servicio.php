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
      $response =  $this->serviciosmodel->update_telefono_visible($param);
      $this->response($response);    
  }
  /**/
  function ventas_mayoreo_PUT(){
    /**/
    $param =  $this->put();
    $param["id_usuario"] = $this->sessionclass->getidusuario();
    $db_response =  $this->serviciosmodel->update_ventas_mayoreo($param);
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
    $param["nombre_servicio"] =  
    $this->serviciosmodel->get_nombre_servicio($param);
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
      $param["id_usuario"] = $this->sessionclass->getidusuario();
      
      $response["add"] 
      =  $this->serviciosmodel->agrega_metakeyword($param);    

      $response["add_catalogo"] 
      =  $this->serviciosmodel->agrega_metakeyword_catalogo($param);

      $this->response($response);

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
        if ($param["is_mobile"] ==  1) {
          $this->load->view("categoria/seleccionar_categoria_phone" , $data);
          
        }else{
          $this->load->view("categoria/seleccionar_categoria" , $data);  
        }
    }

  }
  /**/
  function verifica_existencia_clasificacion_GET(){

    $param          =  $this->get();
    $coincidencias  =  $this->get_coincidencias_busqueda($param);  
    $this->response($coincidencias);
   
  }
  /**/

  /**/
  private function get_coincidencias_busqueda($param){
    $coincidencia =  $this->serviciosmodel->get_coincidencia($param);
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

              $n = 
              $this->serviciosmodel->get_clasificacion_padre_nivel($nueva_coincidencia , 
                $a);
              if (count($n)>0) {
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
        
        $response["registro"] = 
        (ctype_digit($param["precio"])&& $param["precio"] >= 0)?
        $this->registra_data_servicio($param):0;                        
        $this->response($response);  
        
      }else{
        $this->response("error");
      }
  }
  /**/
  private function registra_data_servicio($param){

        $next =  ($param["flag_servicio"] == 0 && $param["precio"] == 0)?0:1;         
        $data_complete["mensaje"] =  ($next ==1)?"":"TU PRODUCTO DEBE TENER ALGÚN PRECIO";
        if ($next) {

            $tags =  $this->create_tags($param);             
            $text_tags =  implode($tags, ",");
            $param["metakeyword"] =  $text_tags;
            $id_usuario =  $this->sessionclass->getidusuario();
            $param["id_usuario"] = $id_usuario;        
            $terminos_usuario =  $this->get_terminos_privacidad_productos($id_usuario);
            $terminos = $terminos_usuario[0];
            $param["entregas_en_casa"] = ($terminos["entregas_en_casa"] > 0)?1:0;
            $param["telefonos_visibles"] = ($terminos["telefonos_visibles"] > 0 )?1:0;    
            $data_complete["servicio"]=  $this->serviciosmodel->create_servicio($param);
        }
        return $data_complete;
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
      $clasificaciones            =  $this->carga_clasificaciones($data["servicio"]);
      $data["clasificaciones"]    =  $clasificaciones;
      $data["ciclos"]             =  $this->serviciosmodel->get_ciclos_facturacion($param);      
      $data["id_usuario"]         = $this->sessionclass->getidusuario();          
      $data["imgs"]               = $this->carga_imagenes_servicio($id_servicio);      
      $data["url_request"]        = $this->get_url_request("");
      $prm["id_servicio"]         = $id_servicio;           
      $data["num"]                = $param["num"];      
      $prm["id_servicio"]         = $id_servicio;
      $data["porcentaje_comision"]= $this->get_porcentaje_comision($prm);      
      $data["is_mobile"]          = ($this->agent->is_mobile() === FALSE)?0:1;      
      
      $data["has_phone"] = $this->valida_usuario_tiene_numero($data["id_usuario"]);
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
  private function get_entregas_en_casa_usuario($id_usuario){
        
        $q["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/entregas_en_casa/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);
        
  }
  /**/
  private function get_terminos_privacidad_productos($id_usuario){
        /**/
        $q["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = 
        $this->restclient->get("usuario/get_terminos_privacidad_productos/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true);      
  }  
  /**/
  private function valida_usuario_tiene_numero($id_usuario){
    /**/
      $q["id_usuario"] =  $id_usuario;
      $url = "q/index.php/api/";         
      $url_request=  $this->get_url_request($url);
      $this->restclient->set_option('base_url', $url_request);
      $this->restclient->set_option('format', "json");        
      $result = 
      $this->restclient->get("usuario/has_phone/format/json/" , $q);        
      $response =  $result->response;        
      return json_decode($response , true);     
  }
  /**/
  public function metakeyword_catalogo_GET(){

      $param =  $this->get();
      $param["id_usuario"] =  $this->sessionclass->getidusuario();
      $response =  
      $this->serviciosmodel->get_metakeyword_catalogo_usuario($param); 

      if ($param["v"] == 1) {
        
        $data["catalogo"] =  $this->create_arr_tags($response);
        $this->load->view("servicios/catalogo_metakeyword" , $data);  
      }else{
        $this->response($response);
      }

  }
  /**/
  public function create_arr_tags($data){

    $tags = array();
    foreach ($data as $row) { 

      $metakeyword =  $row["metakeyword"];    
      if (strlen($metakeyword)>0) {   
        $tags =  json_decode($metakeyword , true);
      }
    }
    return $tags;
  } 
  /**/
}
?>
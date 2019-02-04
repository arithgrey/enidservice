<?php

if ( ! function_exists('heading'))
{
  function heading($data = '', $h = '1', $attributes = '')
  {
    $attr =  add_attributes($attributes);
    return "<h".$h.$attr.">".$data."</h".$h.">";
  }
}

if ( ! function_exists('ul'))
{
  function ul($list, $attributes = '')
  {
    return _list('ul', $list, $attributes);
  }
}
if ( ! function_exists('li'))
{
  function li($info ,  $attributes='' , $row_12 =0)
  {
    return add_element( $info , "li", $attributes , $row_12 );
  }
}
if ( ! function_exists('add_input'))
{
  function add_input( $attributes='')
  {    
      $attr =  add_attributes($attributes);
      return "<input ".$attr.">" ;
  }
}

if ( ! function_exists('span'))
{
  function span( $info , $attributes='', $row = 0 )
  {          
      $attr =   add_attributes($attributes);
      $base =   "<span".$attr.">".$info."</span>";
      $e    =   ( $row == 0 )? $base : addNrow($base);
      return  $e;

  }
}
if ( ! function_exists('p'))
{
  function p( $info , $attributes='', $row = 0 )
  {   
      $attr =  add_attributes($attributes);
      $base = "<p ".$attr.">".$info."</p>";
      $e    =  ($row == 0) ? $base : addNRow($base);
      return $e;
      
  }
}
if ( ! function_exists('guardar'))
{
  function guardar( $info , $attributes=[], $row = 1 , $type_button =1 ,$submit = 1 , $anchor = 0 )
  {   
    
      if ($submit == 1) {
          $attributes["type"] = "submit";        
      }
      if($type_button == 1) {
        $existe =  array_key_exists("class", $attributes)?1:0;              
        if ($existe ==  1) {
          $attributes["class"] = $attributes["class"]." " ." a_enid_blue white completo btn_guardar";
        }else{
          $attributes["class"] =  "a_enid_blue white completo btn_guardar";
        }    
      }
      $attr   =  add_attributes($attributes);
      
      if ($row == 0) { 

        return  "<button ".$attr.">".$info."</button>";
      }else{

        if ($anchor !== 0) {
          $b    = "<a href='".$anchor."'> <button ".$attr.">".$info."</button></a>";        
        }else{
          $b    = "<button ".$attr.">".$info."</button>";        
        }
        
        return div($b , 1);
      }      
  }
}
if ( ! function_exists('add_element'))
{
  function add_element( $info , $type , $attributes ='' , $row =0 )
  {    
      
      $attr     =  add_attributes($attributes);
      $base     =  "<".$type." ".$attr." >".$info."</".$type.">";
      $e        =   ($row ==  0 ) ? $base : addNRow($base);
      return $e;
      
  }
}
function sub_categorias_destacadas($param){

      $z                    =   0;
      $data_complete        =   [];              

      foreach ($param["clasificaciones"] as $row){
            
            $primer_nivel         =  $row["primer_nivel"];
            $total                =  $row["total"];
            $nombre_clasificacion =  "";
            foreach ($param["nombres_primer_nivel"] as $row2){                                
                $id_clasificacion = $row2["id_clasificacion"];
                if($primer_nivel == $id_clasificacion ){
                    $nombre_clasificacion =  $row2["nombre_clasificacion"];
                    break;
                }                
            }
            $data_complete[$z]["primer_nivel"]          =  $primer_nivel;
            $data_complete[$z]["total"]                 =  $total;
            $data_complete[$z]["nombre_clasificacion"]  =  $nombre_clasificacion;            
            if($z == 29){
                break;
            }
            $z ++;            
        }                
        return $data_complete; 

}
if ( ! function_exists('div'))
{
  function div( $info , $attributes='' , $row =0 )
  {

      if ( $attributes == 1 ) {

          return addNRow($info);

      }else{
          $base =   "<div".add_attributes($attributes).">".$info."</div>";
          $d    =   ($row > 0 ) ?   addNRow($base) : $base;
          return $d;
      }

  }
}
if ( ! function_exists('input'))
{
  function input( $attributes='' , $e = 0)
  {    
      $attr =  add_attributes($attributes);
      if ($e == 0) {
        return "<input ".$attr." >";  
      }else{
        return n_row_12() . "<input ".$attr." >" . end_row();  
      }
      
  }
}
if ( ! function_exists('input_hidden'))
{
  function input_hidden( $attributes='' , $e = 0)
  {    
      $attr     =   add_attributes($attributes);
      $input    =   "<input type='hidden'  ".$attr." >";
      $base     =   ( $e == 0 ) ? $input : addNRow($input);
      return  $base;

  }
}
if ( ! function_exists('add_attributes'))
{
  function add_attributes($attributes='')
  {
    if (is_array($attributes))
    {


        $att = '';
        foreach ($attributes as $key => $val)
        {
            $att .= ' ' . $key . '="' . $val . '"';
        }
        return $att;


    }else{
        return ($attributes != '') ? ' '.$attributes : '';
    }

  }
}
if ( ! function_exists('add_fields'))
{
  function add_fields($fields)
  {
    if (is_array($fields) && count($fields)>0) {
      
          $text_fields = "";
          $b =0;
          for ($i=0; $i < count($fields) ; $i++) { 
                
                if ($b == count($fields)-1){

                    $text_fields  .=  $fields[$i];
                }else{
                  $text_fields    .=  $fields[$i].",";  
                } 
                $b ++; 
          }
          return $text_fields;    
    }else{
      return "*";
    }
  }
}

if ( ! function_exists('end_row'))
{
  function end_row(){
    return "</div></div>";
  }
}
if ( ! function_exists('n_row_12'))
{
function n_row_12( $attributes = ''){

    return  "<div class='row'><div class='col-lg-12' "._parse_attributes($attributes) .">";

  }
}
if ( ! function_exists('anchor_enid'))
{
  function anchor_enid($title= '',$attributes= '',$row_12 = 0 , $type_button = 0 )
  {

      /*
    if($type_button == 1) {
      $existe =  array_key_exists("class", $attributes)?1:0;            
      if ($existe ==  1) {
        $attributes["class"] = $attributes["class"]." " ." a_enid_blue white completo ";
      }else{
        $attributes["class"] =  "a_enid_blue white completo ";
      }    
    }*/
    
      $attributes = _parse_attributes($attributes);


    $base   =   "<a".$attributes.">".$title."</a>";
    $e      =   ($row_12 == 0 ) ? $base : addNRow($base);
    return  $e;

  }
}
if ( ! function_exists('get_td'))
{
  function get_td($val='' , $attributes = '' ){

      $attr =  add_attributes($attributes);   
      return "<td ". $attr ." NOWRAP >". $val ."</td>";
  }
}
if ( ! function_exists('get_th'))
{
  function get_th($val='' , $attributes = '' ){


      return "<th ".add_attributes($attributes)." NOWRAP >". $val ."</th>";
  }
}
if ( ! function_exists('select_enid'))
{
  function select_enid($data , $text_option , $val ,  $attributes ='' ){


      $select ="<select ".add_attributes($attributes)."> ";

        foreach ($data as $row) {      
          $select .=  
          "<option value='".$row[$val] ."'>". $row[$text_option]." </option>";
        }

      $select .="</select>";
      return $select;
  }
}
if ( ! function_exists('remove_comma'))
{
  function remove_comma($text){
      $text = str_replace('"','',$text);
      return  str_replace("'",'',$text);    
  }
}
if ( ! function_exists('heading_enid'))
{
  function heading_enid($data = '', $h = 1, $attributes = '' , $row_12 =0)
  {    

    $label  =  "<h$h ".add_attributes($attributes).">".$data."</h$h>";
    $e      =  ($row_12 > 0 ) ? addNRow($label) : $label;
    return $e;

  }
}
if ( ! function_exists('get_url_request'))
{

 function get_url_request($extra){
    $host =  $_SERVER['HTTP_HOST'];
    $url_request =  "http://".$host."/inicio/".$extra; 
    return  $url_request;
  }
  
}
if ( ! function_exists('es_local'))
{

    function es_local(){

        $es_local    =   ($_SERVER['HTTP_HOST'] !== "localhost") ?  0 : 1;
        return $es_local;

    }
}

if ( ! function_exists('icon'))
{
  function icon($class , $attributes ='' , $row_12 = 0 , $extra_text ='' ){

      $attr   =     add_attributes($attributes);
      $base   =     "<i class='fa ".$class."' ". $attr." ></i>";
      $base2  =     span($extra_text , $attributes);
      $e      =     ($row_12 == 0) ? $base. $base2 :  addNRow($base).$base2;
      return $e;

  }
}
if ( ! function_exists('template_table_enid'))
{
 function template_table_enid(){
        $template = array(
          'table_open'            => '<table  cellpadding="4" cellspacing="0" 
          class="table_enid text-center" border=1>',

          'thead_open'            => 
          '<thead class="blue_enid_background white text-center">',
          'thead_close'           => '</thead>',

          'heading_row_start'     => '<tr class="text-center">',
          'heading_row_end'       => '</tr>',
          'heading_cell_start'    => '<th>',
          'heading_cell_end'      => '</th>',

          'tbody_open'            => '<tbody>',
          'tbody_close'           => '</tbody>',

          'row_start'             => '<tr>',
          'row_end'               => '</tr>',
          'cell_start'            => '<td>',
          'cell_end'              => '</td>',

          'row_alt_start'         => '<tr>',
          'row_alt_end'           => '</tr>',
          'cell_alt_start'        => '<td>',
          'cell_alt_end'          => '</td>',

          'table_close'           => '</table>'
    );
      return $template;
  }
}
if ( ! function_exists('create_tag'))
{
 function create_tag($param , $class ,  $val_id , $text){
    
    $tags = "";
    foreach ($param as $row) {
       

      $info   =   $row[$text];
      $id     =   $row[$val_id];
      $tags   .=  add_element( $info , "button" , 
                                    array(
                                      'class' =>  $class ,
                                      'id'    =>  $id
                                    ));
    }
    $new_tags =  add_element($tags ,  "div", array('class' => 'tags' ));
    return $new_tags;
  }
}
if ( ! function_exists('get_array_json'))
{
 function get_array_json($val){

    if (strlen(trim($val))>1) {
        return json_decode($val , true);
    }else{
        $array = array();  
        return $array;
    }
 }
}
if ( ! function_exists('get_json_array'))
{
 function get_json_array($arr){

    if (count($arr)>0) {
        return    json_encode($arr);
    }else{
        $array  = array();  
        return    json_encode($array);
    }
 }
}
if ( ! function_exists('push_element_json'))
{
 function push_element_json($arr ,  $element){

    $exists =0;
    if (is_array($arr)) { 

      if (in_array($element , $arr)) {          
          $exists =1;
      }    
      if ($exists == 0) {          
          array_push($arr , $element);
      }
      return $arr;
    }
 }
}
if ( ! function_exists('unset_element_array'))
{
 function unset_element_array($array ,  $element){

    $new_array  = [];
    $b          = 0;
    for ($a=0; $a <count($array); $a++) { 
      if ($array[$a] != $element) {
          $new_array[$b] =  $array[$a];
          $b ++;
      }
    }
    
    return $new_array;
   
 }
}
if ( ! function_exists('create_button_easy_select'))
{
 function create_button_easy_select($arr , $attributes , $comparador=1 ){
    sort($arr);
    if ($comparador == 1) {
      $easy_selet =  "";
      foreach ($arr as $row) {
          
          $text  =  $row[$attributes["text_button"]]; 
          $class = 
          ($row[$attributes["campo_comparacion"]] ==  $attributes["valor_esperado"])?
          $attributes["class_selected"]:$attributes["class_disponible"];


          $extra = ($row[$attributes["campo_comparacion"]] ==  
            $attributes["valor_esperado"])?1:0;
            
          $easy_selet   .=  add_element( $text, "a" ,  
            array(
              'class'   =>  $class ,  
              'id' => $row[$attributes["valor_id"]] ,  
              "existencia"  => $extra ) );

      }
      
      return $easy_selet;     
    }else{
  
      $extra      =   $attributes["extra"];
      $campo_id   =   $attributes["campo_id"];
      $easy_selet =  "";

      foreach ($arr as $row) {
          $attr          =  add_attributes($extra);  
          $id               =  $row[$campo_id];
          $easy_selet   .=  "<a ".$attr." id=".$id."  >". $row["talla"] ."</a>";
      }
      return $easy_selet;     
    }

 }
}
if ( ! function_exists('create_select'))
{
  function create_select($data , $name , $class , $id , $text_option , $val , $row=0 , $def=0 , $valor=0 , $text_def= ""){

      $select = "<select name='". $name ."'  class='".$class ."'  id='". $id ."'> ";
        
        if($def == 1){

          $select .=  "<option value='". $valor ."'>".strtoupper($text_def)." </option>";          

        }
        foreach ($data as $row) {      
          $select .=  
          "<option value='". $row[$val] ."'>". strtoupper($row[$text_option])." </option>";
        }
        $select .="</select>";
      
      if ($row == 0) {

        return $select;  
      }else{
        
        return n_row_12(). $select . end_row();  
      }
  }
}
if ( ! function_exists('get_param_def'))
{
  function get_param_def($data , $key , $val_def = 0 , $valida_basura = 0 ){
    $val = ( is_array($data) && array_key_exists($key, $data) ) ? $data[$key] : $val_def;

    if ($valida_basura ==  1) {
        
        if (( is_array($data) && array_key_exists($key, $data) ) ) {
            evita_basura($data[$key]);    
        }      
    }
    return $val;

  }
}

if ( ! function_exists('exists_array_def'))
{
  function exists_array_def($data , $key , $exists =1 , $fail = 0){
    $val = ( is_array($data) && array_key_exists($key, $data) ) ? $exists : $fail;
    return $val;
  }
}

if ( ! function_exists('label'))
{  
  function label($label_text = '',  $attributes = '' , $row = 0 ){
      
      $attr     =  add_attributes($attributes);
      $base     =  "<label".$attr.">".$label_text ."</label>";
      $label    =  ( $row == 0 ) ? $base : addNRow($base);
      return  $label;

  }
}
if ( ! function_exists('addNRow'))
{
    function addNRow($e){

        return n_row_12(). $e .end_row();

    }
}

if ( ! function_exists('place'))
{
  function place($class , $attributes = [] , $row =1){         

    $attributes["class"]  = $class;
    return div("",  $attributes  , $row);

  }
}
if ( ! function_exists('img_enid'))
{
  function img_enid($extra = [] , $row_12 =0  , $external = 0 ){
      

      $conf["src"]    =   ($external == 0 ) ? "../img_tema/enid_service_logo.jpg" :  "https://enidservice.com/inicio/img_tema/enid_service_logo.jpg";
      foreach ($extra as $key => $value){        
        $conf[$key]   = $value;
      }
      $img            =   img($conf);         
      return ($row_12 ==  0 ) ?  $img : addNRow($img);
  }  
}
if ( ! function_exists('url_recuperacion_password')){
  
  function url_recuperacion_password(){

    return "../msj/index.php/api/mailrest/recupera_password/format/json/";    
  }
}
if ( ! function_exists('url_home')){
  function url_home(){
    return "../../reporte_enid";
  }
} 
if ( ! function_exists('get_dominio')){
  function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
  }
}

if ( ! function_exists('get_info_variable')){
  function get_info_variable( $param , $variable, $valida_basura  = 0 ){    
    $text =  ( !is_null($param) &&  is_array($param) && array_key_exists($variable , $param) ) ? $param[$variable]:0;  

    if ($valida_basura == 1) {
      if (( !is_null($param) &&  is_array($param) && array_key_exists($variable , $param) ) ) {        
          evita_basura($param[$variable]);
      }  
    }
    return $text;
    
  }
}
if ( ! function_exists('get_info_servicio')){
  function get_info_servicio( $q='' ){
      $num_hist= 9990890;                                    
      return $num_hist;      
  }
}
if ( ! function_exists('mayus')){
    function mayus($variable){
      $variable = strtr(strtoupper($variable),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
      return $variable;
    }
}    
if ( ! function_exists('get_campo')){
  function get_campo($param , $key , $label="", $add_label=0 ){        
      if($add_label == 1){      
        return $label ."  ". $param[0][$key];    
      }else{
          if(count($param)>0){
              return $param[0][$key];
          }

      }    
  }
}
if ( ! function_exists('get_random')){  
  function get_random(){
      return  mt_rand();       
  }
}
if ( ! function_exists('get_info_usuario')){  
  function get_info_usuario($q2){    
      $id_usuario_envio =0;
      if(isset($q2) && $q2 != null ){             
          $id_usuario_envio =$q2;
      }
      return $id_usuario_envio;
  }
}
if ( ! function_exists('now_enid')){
  function now_enid(){
      return  date('Y-m-d');
  }
}

if ( ! function_exists('porcentaje')){
  function porcentaje($cantidad,$porciento,$decimales=2 , $numeric_format = 0) {
    if(is_numeric($cantidad) ==  is_numeric($porciento)) {
        if($numeric_format ==  1){
            $total = number_format($cantidad*$porciento/100 ,$decimales);
            return $total;
        }else{
            $total = $cantidad*$porciento/100;
            return $total;
        }

    }
  }
}
if ( ! function_exists('porcentaje_total')){
    function porcentaje_total($cantidad,$total,$decimales=2 ) {

            $total = $cantidad*100/$total;
            return $total;

    }
}
if ( ! function_exists('get_info_usuario_valor_variable')){
  function get_info_usuario_valor_variable($q2 , $campo ){
      
      $val =0;
      if(isset($q2[$campo]) && $q2[$campo] != null ){             
          $val =$q2[$campo];
      }
      return $val;
  }
}

if ( ! function_exists('get_url_tumblr')){
  function get_url_tumblr($url, $icon =0){

    $url_tumblr   =  "http://tumblr.com/widgets/share/tool?canonicalUrl=".$url;        
    if ($icon == 1) {      
      return anchor_enid(icon('a fa-tumblr') ,         
        [
          'target' => "_black",
          'href'   => $url_tumblr
        ] );
    }
    return $url_tumblr;
  }
}  
if ( ! function_exists('get_url_pinterest')){
  function get_url_pinterest($url , $icon =0 ){
    
    $url_pinterest = "https://www.pinterest.com/pin/create/button/?url=". $url;    
    if ($icon == 1) {      
      return anchor_enid(icon('fa fa-pinterest-p') ,         
        [
          'target' => "_black",
          'href'   => $url_pinterest
        ] );
    }
    return $url_pinterest;

  }
}
if ( ! function_exists('get_url_twitter')){
  function get_url_twitter($url , $mensaje , $icon=0){

    $url_twitter ="https://twitter.com/intent/tweet?text=".$mensaje.$url;
    if ($icon == 1) {      
      return anchor_enid(icon('fa fa-twitter') ,         
        [
          'target' => "_black",
          'href'   => $url_twitter
        ] );
    }
    return $url_twitter;    
  }
}
if ( ! function_exists('get_url_facebook')){
  function get_url_facebook($url , $icon=0){
    
    $url_facebook =
    "https://www.facebook.com/sharer/sharer.php?u=".$url.";src=sdkpreparse";        
    if ($icon == 1) {      
      return anchor_enid(icon('fa fa-facebook-square') ,         
        [
          'target' => "_black",
          'href'   => $url_facebook
        ] );
    }
    return $url_facebook;
  }
}
if ( ! function_exists('get_url_tienda')){
function get_url_tienda($id_usuario)
  {
    $host =  $_SERVER['HTTP_HOST'];
    $url_request =  "http://".$host."/inicio/search/?q3=".$id_usuario; 
    return  $url_request;    
  } 
} 

if ( ! function_exists('unique_multidim_array')){
  function unique_multidim_array($array, $key) {
      $temp_array = array();
      $i = 0;
      $key_array = array();
     
      foreach($array as $val) {
          if (!in_array($val[$key], $key_array)) {
              $key_array[$i] = $val[$key];
              $temp_array[$i] = $val;
          }
          $i++;
      }
      return $temp_array;
  }
}  

if ( ! function_exists('print_footer')){
  function print_footer($list_footer){
    $list ="";
    for($a =0;  $a < count($list_footer); $a ++){
        $list .= $list_footer[$a];
    }
    return $list;
  }
}
if ( ! function_exists('create_select_selected')){
function create_select_selected($data , $campo_val, $campo_text , $selected , $name ,  $class ){

    $select ="<select class='".$class."' name='".$name."'>"; 
    foreach ($data as $row ){
        $extra = ($row[$campo_val] ==  $selected  )? "selected" : "";      
        $select .=  "<option value='". $row[$campo_val]  ."' ".$extra." > " . $row[$campo_text]."</option>";  
    }
    $select .="</select>"; 
    return $select;
  }
}
if ( ! function_exists('get_keys')){
function get_keys($array_keys ){
    return implode(",", $array_keys);
  }
}

if ( ! function_exists('create_url_preview')){
function create_url_preview($img){
    return base_url()."../img_tema/portafolio/".$img;
  }
}
if ( ! function_exists('lib_def')){
  function lib_def(){
    return "../../librerias/principal";  
  }
}
if ( ! function_exists('valida_num')){
  function valida_num($num){
    $n_num =  0;
    if ($num > 0  ){
        $n_num  = $num;
    }
    return $n_num;
  }
}
if ( ! function_exists('valida_seccion_activa')){
  function valida_seccion_activa($seccion , $activa ){
    if($seccion ==  $activa){
        return " active ";
    }
  }
} 
if ( ! function_exists('randomString')){
function randomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){    
  
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }
        return $rstr;
  }
}
if ( ! function_exists('site_url'))
{
  function site_url($uri = '')
  {
    $CI =& get_instance();
    return $CI->config->site_url($uri);
  }
}
if ( ! function_exists('get_drop'))
{
  function get_drop($tmp_table){
    return "DROP TABLE IF EXISTS ". $tmp_table ." ";
  }
}
if ( ! function_exists('valida_extension'))
{
  function valida_extension($string , $num_ext , $strin_secundario){    
      $cadena = (strlen($string) > $num_ext ) ? $string : $strin_secundario;
      return $cadena; 
  }
}
if ( ! function_exists('link_imagen_servicio'))
{
  function link_imagen_servicio($id){    
    
    if ($id > 0) {
      return "../imgs/index.php/enid/imagen_servicio/$id";   
    }
    
  }
}
if ( ! function_exists('select_vertical'))
{
  function select_vertical($data, $val , $text_option , $attributes=''){ 
          
      $extra      = add_attributes($attributes);  
      $select   ="<select ".$extra." > ";
        foreach ($data as $row) {      
          $select .=  "<option value='". $row[$val] ."'>". $row[$text_option]." </option>";
        }
      $select .="</select>";
      return $select;

  }
}
if ( ! function_exists('small'))
{
  function small($text, $attributes = '')
  {
    $extra      = add_attributes($attributes);  
    return "<small ".$extra." > ". $text . "</small>";
  }
}

if ( ! function_exists('strong'))
{
  function strong($text, $attributes = '' , $row = 0)
  {

    $base       =   "<strong".add_attributes($attributes).">". $text . "</strong>";
    $e          =   ( $row == 0 )? $base : addNRow($base);
    return $e;

  }
}
if ( ! function_exists('hr'))
{
  function hr($row=0, $attributes = '' )
  {

    $base       =   "<hr".add_attributes($attributes).">";
    $e          =   ($row == 0 ) ? $base : addNRow($base);
    return      $e;
  }
}

if ( ! function_exists('debug'))
{
function debug($msg, $array = 0)
{
    if(es_local() >  0) {

      $_date_fmt  = 'Y-m-d H:i:s';
      $filepath   = BASEPATH."../debug/debug.log"; 
      $message  = '';   
      $fp = @fopen($filepath, FOPEN_WRITE_CREATE);    

      if ($array == 0) {
        $message .= 
        'DEBUG'.' -' .' TYPE '. gettype($msg).' '.date($_date_fmt). ' --> '.$msg;
      }else{
        $message .= 
        'DEBUG'.' -' .' TYPE '. gettype($msg).' '.date($_date_fmt). ' --> '.print_r($msg, true);
      }
          
      flock($fp, LOCK_EX);
      fwrite($fp, $message);
      flock($fp, LOCK_UN);
      fclose($fp);
      return TRUE;  
    }
    
  }
  if ( ! function_exists('get_costo_envio')) {
      function get_costo_envio($param){

        $flag_envio_gratis  =   $param["flag_envio_gratis"];
        $response      =   [];

        if($flag_envio_gratis ==  1){

            $response["costo_envio_cliente"]    =   0;
            $response["costo_envio_vendedor"]   =   100;
            $response["text_envio"]             =   texto_costo_envio_info_publico($flag_envio_gratis, $response["costo_envio_cliente"], $response["costo_envio_vendedor"]);
        }else{
            $response["costo_envio_cliente"]= 100;
            $response["costo_envio_vendedor"]= 0;
            $response["text_envio"] =  texto_costo_envio_info_publico($flag_envio_gratis , $response["costo_envio_cliente"] , $response["costo_envio_vendedor"]);
        }
        return $response;
      }
  }
  if ( ! function_exists('if_ext')) {
      function if_ext($param , $k='', $num=0){

        $keys = explode(",", $k);
        $z    = 1;

        for ($a=0; $a < count($keys); $a++){
          if (!array_key_exists(trim($keys[$a]), $param)  ||  strlen(trim($param[$keys[$a]])) < $num ){
            $z  = 0;
            debug("NO se recibió el parametro->" .$keys[$a]  );
          }

        }
        return $z;
      }
  }
}

if ( ! function_exists('textarea'))
{
  function textarea($attributes = '' ,  $row_12 = 0 , $def='')
  {
      $base     =   "<textarea ".add_attributes($attributes)." ></textarea>";
      $e        =   ($row_12 == 0 ) ? $base : addNRow($base);
      return        $e;

  }
}
if ( ! function_exists('iframe'))
{
  function iframe($attributes = '' ,  $row_12 = 0)
  {
      $base =   "<iframe ".add_attributes($attributes)." ></iframe>";
      $e    =    ($row_12 == 0 ) ? $base : addNRow($base);
      return $e;


  }
}
if ( ! function_exists('center'))
{
  function center($attributes = '' ,  $row_12 = 0)
  {

      $base =   "<center ".add_attributes($attributes)." ></center>";
      $e    =   ($row_12 == 0 ) ? $base : addNRow($base);
      return $e;

  }
}
/*Ordena el arreglo de a cuerdo al tipo de indice que se indique*/
if ( ! function_exists('sksort'))
{
    function sksort(&$array, $subkey="id", $sort_ascending=false){
            if (count($array))
                $temp_array[key($array)] = array_shift($array);
            foreach($array as $key => $val){
                $offset = 0;
                $found = false;
                foreach($temp_array as $tmp_key => $tmp_val)
                {
                    if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
                    {
                        $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                                                    array($key => $val),
                                                    array_slice($temp_array,$offset)
                                                  );
                        $found = true;
                    }
                    $offset++;
                }
                if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
            }
            if ($sort_ascending) $array = array_reverse($temp_array);
            else $array = $temp_array;
    }
}
if ( ! function_exists('date_difference'))
{
    function date_difference($date_1, $date_2, $differenceFormat = '%a')
    {
        $datetime1  = date_create($date_1);
        $datetime2  = date_create($date_2);
        $interval   = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }
}
if ( ! function_exists('add_date'))
{
    function add_date($inicio , $dias){

      $fecha = date_create($inicio);
      date_add($fecha, date_interval_create_from_date_string($dias.' days'));
      return date_format($fecha, 'Y-m-d');
    }
}
if ( ! function_exists('evita_basura'))
{
    function evita_basura($text){

      $basura =   ["'","?","=","|","*"];
      $b      =   0;
      for ($a=0; $a < count($basura); $a++) {

          if(strpos($text, $basura[$a]) !== FALSE){
              $b ++;
          }
      }
      if ($b > 0 ) {
        redirect("https://www.google.com/" , "refresh" ,302);
      }
      return $b;
    }
}
if ( ! function_exists('add_hour'))
{
    function add_hour($num_hours){
      $nowtime = date("Y-m-d H:i:s");
      $num_hours = $num_hours *  60;
      $date = date('H:i:s', strtotime($nowtime . ' + '.$num_hours.' minute'));
      return $date;
    }
}
if ( ! function_exists('get_logo'))
{
    function get_logo($is_mobile , $tipo = 0 ){

        if ($is_mobile ==  1){

            $en_mobile  =  div("☰ ENID SERVICE", [ "class" =>  "smallnav menu white", "onclick"=> "openNav()" ]);
            $class      =  "col-lg-12";
            switch ($tipo) {
                case 0:
                    $class =  "col-lg-12";
                    break;
                case 1:
                    $class =  "col-lg-3";
                    break;
                case 2:
                    $class =  "col-lg-1";
                    break;
            }

            return div($en_mobile , ["class" => $class]);

        }else{

            $img_enid   =  img_enid(["style"=>"width: 50px!important;"] );
            $en_pc      =  anchor_enid($img_enid, ["href"  =>  "../"] );
            return div($en_pc, ["class" => "col-lg-1"]);
        }

    }
}
if ( ! function_exists('get_img_usuario'))
{
    function get_img_usuario($id_usuario){
        $url_img    = "../imgs/index.php/enid/imagen_usuario/".$id_usuario;
        $img_conf   = [
            "id"      =>  "imagen_usuario" ,
            "class"   =>  "imagen_usuario" ,
            "src"     =>  $url_img ,
            "onerror" =>  "this.src='../img_tema/user/user.png'" ,
            "style"   =>  "width: 40px!important;height: 35px!important;"
        ];

        return   img($img_conf);

    }
}
if ( ! function_exists('lista_horarios'))
{
    function microtime_float(){
        list($useg, $seg) = explode(" ", microtime());
        return ((float)$useg + (float)$seg);
    }
}
if (!function_exists('lista_horarios')) {
    function lista_horarios()
    {

        $horarios = [
            "09:00",
            "09:30",
            "10:00",
            "10:30",
            "11:00",
            "11:30",
            "12:00",
            "12:30",
            "13:00",
            "13:30",
            "14:00",
            "14:30",
            "15:00",
            "15:30",
            "16:00",
            "16:30",
            "17:00",
            "17:30",
            "18:00"
        ];

        $select = "<select name='horario_entrega' class='form-control input-sm '  > ";
        foreach ($horarios as $row) {
            $select .= "<option value='" . $row . "'>" . $row . "</option>";
        }
        $select .= "</select>";
        return $select;

    }
}
if (!function_exists('get_url_servicio')) {
    function get_url_servicio($id_servicio){

        return  "../producto/?producto=".$id_servicio;

    }
}
if ( ! function_exists('append_data')) {

    function append_data($array)
    {
        $response =  "";
        for ($a = 0; $a < count($array); $a ++){
            $response .=  " ".$array[$a];
        }
        return $response;
    }
}

if ( ! function_exists('get_request_email'))
{
    function get_request_email($email, $asunto , $cuerpo)
    {
        $request =  [
            "para"      =>   $email,
            "asunto"    =>   $asunto,
            "cuerpo"    =>   $cuerpo

        ];
        return $request;
    }
}



//https://www.codeigniter.com/user_guide/general/styleguide.html
//https://www.codeigniter.com/user_guide/libraries/config.html
//Poder modificar el punto de entrega desde el mondulo de pedidos
//https://www.codeigniter.com/user_guide/libraries/email.html
/*$this->load->add_package_path(APPPATH.'third_party/foo_bar/')
        ->library('foo_bar');




https://www.codeigniter.com/user_guide/libraries/output.html
$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('foo' => 'bar')));

$this->output
        ->set_content_type('jpeg') // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
        ->set_output(file_get_contents('files/something.jpg'));


https://www.codeigniter.com/user_guide/database/configuration.html
 * */
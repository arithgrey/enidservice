<?php
/*
----  Pasar a set functions
----  Pasar a create los insert
---   js
----  views
---   controllers


https://youtu.be/FwXskdcCRIk

grep -r "libraries/REST_Controller.php"  /Users/jonathan.medrano/Documents/example
perl -p -i -e 's/pero/pero_____/g' ex.php 
sed -i 's/;();/;/g' 'pagos/application/controllers/api/afiliados.php'

ELIMINAR TODOS LOS REST_Controller.php

https://youtu.be/_dwdRNckUGk
https://www.youtube.com/watch?v=DhpZ9EFshXI
https://youtu.be/Baxq-kJvKgA
https://www.youtube.com/watch?v=1JGzDfEmQrw
IMPORTANT 
MAP
function cube($n)
{
    return($n * $n * $n);
}

$a = array(1, 2, 3, 4, 5);
$b = array_map("cube", $a);
____________________
filter
function impar($var)
{
    // Retorna siempre que el número entero sea impar
    return($var & 1);
}

function par($var)
{
    // Retorna siempre que el número entero sea par
    return(!($var & 1));
}

$array1 = array("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
$array2 = array(6, 7, 8, 9, 10, 11, 12);

echo "Impar :\n";
print_r(array_filter($array1, "impar"));
echo "Par:\n";
print_r(array_filter($array2, "par"));
_______________
REDUCE
function suma($carry, $item)
{
    $carry += $item;
    return $carry;
}

function producto($carry, $item)
{
    $carry *= $item;
    return $carry;
}

$a = array(1, 2, 3, 4, 5);
$x = array();

var_dump(array_reduce($a, "suma")); // int(15)
var_dump(array_reduce($a, "producto", 10)); // int(1200), ya que: 10*1*2*3*4*5
var_dump(array_reduce($x, "suma", "No hay datos a reducir")); // string(22) "No hay datos a reducir"


FUNCIONES LAMBDA -> http://fabien.potencier.org/on-php-5-3-lambda-functions-and-closures.html
https://translate.google.com/translate?sl=en&tl=es&js=y&prev=_t&hl=es&ie=UTF-8&u=https%3A%2F%2Fwww.codeigniter.com%2Fuser_guide%2Flibraries%2Floader.html&edit-text=
*/
if ( ! function_exists('heading'))
{
  function heading($data = '', $h = '1', $attributes = '')
  {
    $attributes = ($attributes != '') ? ' '.$attributes : $attributes;
    return "<h".$h.$attributes.">".$data."</h".$h.">";
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
      return "<input ".$attr.">" . "\n";
  }
}

if ( ! function_exists('span'))
{
  function span( $info , $attributes='', $row = 0 )
  {          
      $attr =  add_attributes($attributes);       
      if ($row == 0) {
        return "<span ".$attr.">".$info."</span>". "\n";  
      }else{
        return n_row_12()."<span".$attr.">".$info."</span>"."\n".end_row();
      }
      
  }
}

/**/
if ( ! function_exists('p'))
{
  function p( $info , $attributes='', $row = 0 )
  {   
      $attr =  add_attributes($attributes);       
      if ($row == 0) {
        return "<p ".$attr.">". "\n".$info."</p>". "\n";  
      }else{
        return n_row_12()."<p".$attr.">".$info."</p>"."\n".end_row();
      }
      
  }
}
if ( ! function_exists('guardar'))
{
  function guardar( $info , $attributes=[], $row = 0 )
  {   
      $attributes["type"] = "submit";      
      if ($row == 0) {
        return  form_submit("" , $info  , $attributes). "\n"; 
      }else{
        return  n_row_12().form_submit("" , $info , $attributes).end_row(); 
      }      
  }
}
/**/
if ( ! function_exists('add_element'))
{
  function add_element( $info , $type , $attributes='' , $row_12 =0 )
  {    
      
      $attr =  add_attributes($attributes);
      if ($row_12 == 0 ) {
          return "<".$type." ".$attr." >".$info."</".$type.">". "\n";  
      }else{
          return 
          n_row_12() . "<".$type." ".$attr." >".$info."</".$type.">". "\n" . end_row();
      }
      
  }
}
/**/
if ( ! function_exists('div'))
{
  function div( $info , $attributes='' , $row_12 =0 )
  {          
      $attr =  add_attributes($attributes);
      if ($row_12 == 0 ) {
          return "<div ".$attr." >"."\n".$info."</div>". "\n";  
      }else{
          return n_row_12()."<div ".$attr." >"."\n".$info."</div>". "\n".end_row();  
      }
      
  }
}
/**/
if ( ! function_exists('input'))
{
  function input( $attributes='' , $e = 0)
  {    
      $attr =  add_attributes($attributes);
      if ($e == 0) {
        return "<input ".$attr." >". "\n";  
      }else{
        return n_row_12() . "<input ".$attr." >". "\n" . end_row();  
      }
      
  }
}
if ( ! function_exists('input_hidden'))
{
  function input_hidden( $attributes='' , $e = 0)
  {    
      $attr =  add_attributes($attributes);
      if ($e == 0) {
        return "<input type='hidden'  ".$attr." >". "\n";  
      }else{
        return n_row_12() . "<input type='hidden' ".$attr." >" . "\n". end_row();  
      }
      
  }
}

/**/
if ( ! function_exists('add_attributes'))
{
  function add_attributes($attributes)
  {
    if (is_string($attributes))
    {
      return ($attributes != '') ? ' '.$attributes : '';
    }

    $att = '';
    foreach ($attributes as $key => $val)
    {    
        $att .= ' ' . $key . '="' . $val . '"';    
    }
    return $att;
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
    $row= "</div>". "\n"."</div>". "\n";
    return $row;
  }
}
/**/
if ( ! function_exists('n_row_12'))
{
function n_row_12( $attributes = ''){

    if ($attributes != '')
    {
      $attributes = _parse_attributes($attributes);
    }
    $row= "<div class='row'>"."\n".
            "\n"."
            <div class='col-lg-12 col-md-12 col-sm-12 ". $attributes  ." '>"."\n";
    return $row;
  }
}
if ( ! function_exists('anchor_enid'))
{
  function anchor_enid($title= '',$attributes= '',$row_12 = 0 , $type_button=0 )
  {
    if($type_button == 1) {
      $existe =  array_key_exists("class", $attributes)?1:0;
      
      if ($existe ==  1) {
        $attributes["class"] = 
        $attributes["class"]." " ." blue_enid_background white ";
      }else{
        $attributes["class"] =  "blue_enid_background white";
      }    
    }
    if ($attributes != '')
    {
      $attributes = _parse_attributes($attributes);
    }
    if ($row_12 == 0 ) {
      return '<a '.$attributes.'>'."\n".$title.'</a>'. "\n";  
    }else{
      return n_row_12(). '<a '.$attributes.'>'. "\n".$title.'</a>'. "\n" . end_row();  
    }    
  }
}

if ( ! function_exists('get_td'))
{
  function get_td($val='' , $attributes = '' ){

      $attr =  add_attributes($attributes);   
      return "<td ". $attr ." NOWRAP >"."\n". $val ."</td>". "\n";
  }
}

if ( ! function_exists('select_enid'))
{
  function select_enid($data , $text_option , $val ,  $attributes ='' ){

      $attr =  add_attributes($attributes);   
      $select ="<select ".$attr."> ". "\n";

        foreach ($data as $row) {      
          $select .=  
          "<option value='".$row[$val] ."'>"."\n". $row[$text_option]." </option>". "\n";
        }

      $select .="</select>". "\n";
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
  function heading_enid($data = '', $h = '1', $attributes = '' , $row_12 =0)
  {    
    $attr =  add_attributes($attributes);   
    if ($row_12 == 1) {
      return n_row_12()."<h".$h. $attr.">"."\n".$data."</h".$h.">". "\n".end_row();
    }
    return "<h".$h. $attr.">"."\n".$data."</h".$h.">". "\n";      
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
if ( ! function_exists('icon'))
{
 function icon($class , $attributes ='' , $row_12 = 0 ){

    $attr =  add_attributes($attributes);   
    if ($row_12 == 0) {
      return "<i class='fa ".$class."' ". $attr." ></i>". "\n";  
    }else{
      return n_row_12(). "<i class='fa ".$class."' ". $attr." ></i>". "\n" . end_row();  
    }    
  }
}
if ( ! function_exists('template_table_enid'))
{
 function template_table_enid($param=''){
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
/**/
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
/**/
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
/**/
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
/**/
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
 /**/
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
 /**/
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
          $text          =  $row[$attributes["text_button"]];     
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
  /**/
  function create_select($data , $name , $class , $id , $text_option , $val , $row=0  , $def=0 , $valor=0 , $text_def= ""){

      $select = "<select name='". $name ."'  class='".$class ."'  id='". $id ."'> ". "\n";
        
        if ($def == 1) {
          $select .=  "<option value='". $valor ."'>". $text_def." </option>". "\n";
        }
        foreach ($data as $row) {      
          $select .=  "<option value='". $row[$val] ."'>". $row[$text_option]." </option>". "\n";
        }
      $select .="</select>". "\n";
      
      if ($row == 0) {
        return $select;  
      }else{
        return n_row_12(). $select . end_row();  
      }
  }
}
/**/
if ( ! function_exists('get_paramdef'))
{
  /**/
  function get_param_def($data , $key , $val_def = 0){
    $val = ( is_array($data) && array_key_exists($key, $data) ) ? $data[$key] : $val_def;
    return $val;
  }
}
/**/
if ( ! function_exists('label'))
{  
  function label($label_text = '', $id = '', $attributes = array() , $n_row_12 = 0 ){
      if ($row =0 ) {
          return form_label($label_text = '', $id = '', $attributes = array());
      }else{
          return n_row_12() . form_label($label_text = '', $id = '', $attributes = array()) . end_row();
      }      
  }
}
/**/
if ( ! function_exists('place'))
{
  /**/
  function place($class_place , $row=1){            
      if ($row == 1) {
        return div("", ['class'=> $class_place] , 1);  
      }else{
        return div("", ['class'=> $class_place ]);  
      }          
  }
}
/**/
if ( ! function_exists('img_enid'))
{
  /**/
  function img_enid($extra = [] , $row_12 =0 ){
      
      $conf["src"]    =   "../img_tema/enid_service_logo.jpg";
      
      foreach ($extra as $key => $value){        
        $conf[$key]   = $value;
      }

      $img            =   img($conf);         
      return ($row_12 ==  0 ) ?  $img : n_row_12(). $img .end_row();      
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
  function get_info_variable( $param , $variable ){    
    return ( !is_null($param ) &&  is_array($param) 
      && array_key_exists($variable , $param) ) ? $param[$variable]:0;  
  }
}
if ( ! function_exists('get_info_servicio')){
  function get_info_servicio($q){
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
if ( ! function_exists('entrega_data_campo')){
  function entrega_data_campo($param , $key , $label="", $add_label=0 ){        
      if($add_label == 1){      
        return $label ."  ". $param[0][$key];    
      }else{
        return $param[0][$key];    
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
  function porcentaje($cantidad,$porciento,$decimales=2) {
    if(is_numeric($cantidad) ==  is_numeric($porciento)) {      
      $total = number_format($cantidad*$porciento/100 ,$decimales);      
      return $total;
    }
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
if ( ! function_exists('RandomString')){
function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){    
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
if ( ! function_exists('debug'))
{
function debug($msg, $array = 0)
{ 

    $_date_fmt  = 'Y-m-d H:i:s';
    $filepath = "/var/www/html/inicio/debug/debug.log"; 
    $message  = '';   
    $fp = @fopen($filepath, FOPEN_WRITE_CREATE);    

    if ($array == 0) {
      $message .= 
      'DEBUG'.' -' .' TYPE '. gettype($msg).' '.date($_date_fmt). ' --> '.$msg."\n";
    }else{
      $message .= 
      'DEBUG'.' -' .' TYPE '. gettype($msg).' '.date($_date_fmt). ' --> '.print_r($msg, true)."\n";
    }
        
    flock($fp, LOCK_EX);
    fwrite($fp, $message);
    flock($fp, LOCK_UN);
    fclose($fp);

    //@chmod($filepath, FILE_WRITE_MODE);
    return TRUE;
  }
  function get_costo_envio($param){
    
    
    $flag_envio_gratis =  $param["flag_envio_gratis"];
    $data_complete = [];
    
    if($flag_envio_gratis ==  1){      
      
      $data_complete["costo_envio_cliente"]= 0;
      $data_complete["costo_envio_vendedor"]= 100;
      
      $data_complete["text_envio"] =  texto_costo_envio_info_publico(
        $flag_envio_gratis, 
        $data_complete["costo_envio_cliente"], 
        $data_complete["costo_envio_vendedor"]);
    }else{
      $data_complete["costo_envio_cliente"]= 100;
      $data_complete["costo_envio_vendedor"]= 0;
      $data_complete["text_envio"] =  texto_costo_envio_info_publico(
        $flag_envio_gratis , 
        $data_complete["costo_envio_cliente"] , 
        $data_complete["costo_envio_vendedor"]);
    }
    return $data_complete;
  }
  /**/
  function if_ext($param , $k='', $num=0){

    $keys = explode(",", $k);  
    $z    = 1;
    for ($a=0; $a < count($keys); $a++){           
      if (!array_key_exists(trim($keys[$a]), $param)  ||  strlen(trim($param[$keys[$a]])) < $num ){
        $z  = 0;          
      }
    }
    return $z;
  }
  
}
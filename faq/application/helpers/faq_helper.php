<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  function get_info_serviciosq($q){
    $status = (isset($q) && strlen($q)>0) ?  1 : 0;
    return $status;
  }
  function get_info_categoria($q){
    
    $status = (isset($q) && strlen($q)>0) ? 1 : 0;
    return $status;    
  }
  /**/
  function get_btn_registro_faq($in_session , $perfil){

    if ($in_session ==  1){
        
      if($perfil !=  20 && $perfil != 19 && $perfil != 17 ){
        $link  = anchor_enid(icon("fa fa-plus-circle")."Registrar respuestas"  ,  
              [
                "href"        =>  "#tab2default" ,  
                "id"          =>  "enviados_a_validacion" ,  
                "data-toggle" =>  "tab"
              ]);
        return add_element( $link , "li" , ["class"=>"btn_registro_respuesta li_menu"]);
      }
      
    }
  }
  function lista_categorias($categorias){
    
    $l = "";
    foreach($categorias as $row){
      
      $id_categoria       =   $row["id_categoria"];
      $nombre_categoria   =   $row["nombre_categoria"];
      $faqs               =   $row["faqs"];   
       
      $href ="?categoria=".$id_categoria;
      $link = anchor_enid(icon("fa fa-file-text-o") .div($nombre_categoria . "(".$faqs.")") , ["href"=> $href ]);  
      $l   .= div($link , ["class"=>"col-lg-4"]);
    }
    return $l; 
  }


}
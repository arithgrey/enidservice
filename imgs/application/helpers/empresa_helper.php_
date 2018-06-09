<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

function construye_galeria($data , $param ){

  $b = 0; 
  $a =  ""; 
  $galeria =  ""; 
  $in_session =  $param["in_session"];
  foreach ($data as $row) {
      
    $id_imagen = $row["id_imagen"];  
    $url_img =url_tmp_img($id_imagen);       
    $toggle =  "toggle-".($b +1);
    $class_panel_img='panel-image';
    if ($b > 0 ) {
        $class_panel_img='panel-image hide-panel-body';
    }
    if ($a == 0 ) {
      $galeria .= '<div class="row form-group"> ';
    }


    $galeria .= '<div class="col-xs-12 col-md-3 col-lg-3">'; 
        
        $img_galeria_delete =  "img_delete_".$id_imagen;
        $galeria .=  '<div class="'.$class_panel_img.'">';

          if ($in_session ==  1 ) {
            $galeria .=  '<i data-toggle="modal" data-target="#modal-eliminar-img"  class="fa fa-times eliminar_img '.$img_galeria_delete.'  " id="'.$id_imagen.'" style="display:none"></i>';  
          }        
          $galeria .=  '<img src="'.$url_img.'" class="img_galeria panel-image-preview" id="'.$id_imagen.'"/>';
        $galeria .= '</div>';
      
    $galeria .= '</div>';


    $b ++;
    if ($b >  1 ){
      $b = 0; 
    }

    $a ++; 


    if ($a ==  4 ) {    
      $galeria .= '</div>'; 
      $a = 0;    
    }


  }

  return $galeria;

}


}/*Termina el helper*/
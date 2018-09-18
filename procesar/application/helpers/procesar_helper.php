<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
  function get_text_duracion($id_ciclo_facturacion , $num_ciclos , $is_servicio){

  $text_ciclos ="";
  $text_ciclos =[
    "Anual",
    "Mensual",
    "Semanal",
    "Quincenal",
    "No aplica",
    "Anual a 3 meses",
    "Anual a 4 meses",
    "Anual a 6 meses"];

    $text ="";


    switch($id_ciclo_facturacion){
      case 1:
        
         $text = $num_ciclos ." Año";
          if ($num_ciclos>1) {
            $text = $num_ciclos ." Años";
          }      
        break;
      
      case 2:
        
        $text = $num_ciclos ." Mes";
        if($num_ciclos>1){
            $text = $num_ciclos ." Meses";
        }      
        break;  
      
      case 5:        
        $text = $num_ciclos ." ";
        if($num_ciclos>1){
            $text = $num_ciclos . "  ";
        }      
        break;        

      default:        
        break;
    }
  
    return $text;


}

function create_resumen_servicio($servicio ,  $info_solicitud_extra){
    
  $resumen              =   ""; 
  $resumen_servicio     =   "";  
  $duracion             =   $info_solicitud_extra["num_ciclos"];
  $precio               =   0;
  $info_servicio        =   "";
  $id_ciclo_facturacion =   "";
  $precio               =   0;
  
  foreach ($servicio as $row) {
    
    $id_servicio                    =  $row["id_servicio"];
    $nombre_servicio                =  $row["nombre_servicio"];
    $info_servicio              = $nombre_servicio;    
    $descripcion              =  $row["descripcion"];    
    $resumen_servicio               = $nombre_servicio;    
    $id_ciclo_facturacion               =  $row["id_ciclo_facturacion"];
    $precio =  $row["precio"];
  }

  $is_servicio =0;
  $text_label = "PIEZAS";
    
  if($info_solicitud_extra["is_servicio"] ==  1){
    $text_label = "DURACIÓN"; 
    $is_servicio =1;       
  }  
  $text_ciclos_contratados =   get_text_duracion($id_ciclo_facturacion , $duracion ,  $is_servicio);  
  $resumen_completo =div(div("PRODUCTO"). $resumen_servicio , ["class"=>'col-lg-4 tex-center']);
  $resumen_completo .= div($text_label. " ".$text_ciclos_contratados , ['class' => "col-lg-4 tex-center"]);
  $resumen_completo .= div(div("PRECIO") .  $precio , ['class'=>'col-lg-4']);

  $data_complete["resumen_producto"] = $resumen_completo;
  $data_complete["monto_total"] = $precio;
  $data_complete["resumen_servicio_info"] =  $info_servicio;

  return $data_complete;
}


}
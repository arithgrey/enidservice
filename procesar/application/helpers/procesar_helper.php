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
          
          $periodo = ($num_ciclos>1) ?  "Años" : "Año";
          $text    = $num_ciclos . $periodo;
          break;
        
        case 2:
          
          $periodo = ($num_ciclos>1) ?  "Meses" : "Mes";
          $text    = $num_ciclos . $periodo;

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
      
      $id_servicio                    =   $row["id_servicio"];
      $nombre_servicio                =   $row["nombre_servicio"];
      $info_servicio                  =   $nombre_servicio;    
      $descripcion                    =   $row["descripcion"];    
      $resumen_servicio               =   $nombre_servicio;    
      $id_ciclo_facturacion           =   $row["id_ciclo_facturacion"];
      $precio                         =   $row["precio"];
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
  function get_text_acceder_cuenta($is_mobile ,$param){
    
    $plan               = $param["plan"];
    $num_ciclos         = $param["num_ciclos"];
    $ciclo_facturacion  = $param["ciclo_facturacion"];
    $is_servicio        = $param["is_servicio"];  
    $q2                 = $param["q2"];  

    
    $extra = 
    [
      "plan"              => $plan, 
      "extension_dominio" => "",
      "ciclo_facturacion" => $ciclo_facturacion ,
      "is_servicio"       => $is_servicio,
      "q2"                => $q2 ,
      "num_ciclos"        => $num_ciclos,
      "class"             => "link_acceso cursor_pointer"      
    ];  
    
    
    
    $text   =   heading_enid('¿Ya tienes una cuenta? ', 3 );
    $text  .=   div("ACCEDE AHORA!", $extra , 1);
    return $text;

  }

}
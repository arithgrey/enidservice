<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  /**/
  function get_comentarios_persona($data){
      
      $l ="";
      foreach ($data as $row){
        
        $fecha_registro =  $row["fecha_registro"];
        $comentario    = $row["comentario"];
        $nombre_tipificacion    = $row["nombre_tipificacion"];

        $l .="<tr>";
      
          $l .="<td class='text_comentarios'>";
            $l .=$fecha_registro;
          $l .="</td>";

          $l .="<td class='text_comentarios'>";
            $l .=$nombre_tipificacion;
          $l .="</td>";

          $l .="<td class='text_comentarios'>";
            $l .=$comentario;
          $l .="</td>";
        $l .="</tr>";      
      }
      return $l;
  }

}/*Termina el helper*/
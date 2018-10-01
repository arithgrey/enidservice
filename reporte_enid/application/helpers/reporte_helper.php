<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  function crea_repo_categorias_destacadas($param){      
      $z =0;
      $data_complete = [];

      foreach ($param as $row) {      
        
        $primer_nivel = $row["primer_nivel"];
        $total =  $row["total"];
        $nombre_clasificacion =  $row["nombre_clasificacion"];
        
        if ($z == 0) {          
          echo "<ul class='clasificaciones_sub_menu_ul'>";    
        } 
        $href ="../search?q=&q2=".$row["primer_nivel"];
        echo "<table>
              <tr>
                ".get_td($total)."
                ".get_td(anchor_enid($nombre_clasificacion) , ["href"=> $href,  "class"=>'text_categoria_sub_menu'])."
              </tr>
              </table>"; 
        $z ++;
        if ($z == 5) {          
          $z =0;
          echo "</ul>";    
        }                 
        
      }
    }
    

 
  
}
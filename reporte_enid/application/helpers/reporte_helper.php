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
    
  function sub_categorias_destacadas($param){

      $nombres_primer_nivel =  $param["nombres_primer_nivel"];
        $z =0;
        $data_complete =[];
                
        foreach ($param["clasificaciones"] as $row){
            
            $primer_nivel =  $row["primer_nivel"];
            $total =  $row["total"];
            $nombre_clasificacion =  "";
            foreach ($param["nombres_primer_nivel"] as $row2){                
                
                $id_clasificacion = $row2["id_clasificacion"];
                if($primer_nivel == $id_clasificacion ){
                    $nombre_clasificacion =  $row2["nombre_clasificacion"];
                    break;
                }
            }
            $data_complete[$z]["primer_nivel"] =  $primer_nivel;
            $data_complete[$z]["total"] =  $total;
            $data_complete[$z]["nombre_clasificacion"] =  $nombre_clasificacion;
            
            if($z == 29){
                break;
            }
            $z ++;
            
        }        
        return $data_complete; 

    }

 
  
}
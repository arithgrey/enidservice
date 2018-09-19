<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Recurso_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function registra_recurso($param){

        $nombre =  $param["nombre"];
        $urlpaginaweb =  $param["urlpaginaweb"];  
        $params = [ 
          "nombre"          =>  $nombre,
          "urlpaginaweb"    =>  $urlpaginaweb,
          "order_negocio"   =>  1,
          "status"          =>  1,
          "class"           =>  '' 
        ];
        return $this->insert($params);
    }
    function get_recurso_perfil_recurso($id_perfil){

        $query_get ="SELECT
            r.*,
            pr.idrecurso 
            FROM recurso  r 
            INNER JOIN 
            perfil_recurso  pr
            ON  r.idrecurso  =  pr.idrecurso 
            WHERE 
            r.idrecurso = pr.idrecurso AND 
            pr.idperfil = $id_perfil  
            ORDER BY order_negocio ASC";             
        return $this->db->query($query_get)->result_array();          
    }
    function recursos_perfiles($param){


        $b              =   0;
        $info           =   [];
        $data_complete  =   [];        
        $id_perfil      =   $param["id_perfil"];        
        $data           =   $this->get_recurso_perfil_recurso($id_perfil);
        for ($i=0; $i <  count($data); $i++) {                             
            if (!in_array( $data[$i], $info)){
                $info[$b] = $data[$i];
                $b++;                    
            }
        }
        
        
        return $info;
    } 
    function get_perfiles_permisos($param){

      $query_get = "SELECT 
                    *,
                    r.idrecurso 
                    id_recurso
                    FROM 
                      recurso r
                    LEFT OUTER JOIN 
                      perfil_recurso pr 
                    ON 
                      r.idrecurso =  pr.idrecurso
                    AND 
                      pr.idperfil = '".$param["id_perfil"]."'
                    WHERE 
                    r.status = 1
                    GROUP BY r.idrecurso ";
                    
      return $this->db->query($query_get)->result_array();
    }
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("recurso", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
}

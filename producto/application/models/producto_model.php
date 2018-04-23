<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class producto_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    
    function info_basica_producto($id_servicio){

          $query_get ="SELECT 
            id_servicio ,
            nombre_servicio ,
            descripcion ,
            status ,
            id_clasificacion ,
            flag_servicio ,
            flag_envio_gratis ,
            flag_precio_definido ,
            flag_nuevo , 
            url_vide_youtube , 
            metakeyword,
            metakeyword_usuario, 
            existencia, 
            color,
            id_usuario,
            precio, 
            id_ciclo_facturacion,
            entregas_en_casa
          FROM
            servicio 
          WHERE id_servicio = '".$id_servicio."' LIMIT 1";

        $result = $this->db->query($query_get); 
        return $result->result_array();
      }
      function get_precio_servicio($id_servicio){

          /**/
          $query_get = "SELECT  
                  p.id_precio , 
                  p.precio , 
                  p.costo , 
                  c.ciclo ,                 
                  c.flag_meses,
                  c.num_meses  ,
                  c.id_ciclo_facturacion
                  FROM 
                    precio p   
                  INNER JOIN 
                    ciclo_facturacion  c 
                  ON 
                    p.id_ciclo_facturacion = c.id_ciclo_facturacion  
                  WHERE 
                    p.id_servicio = $id_servicio
                  LIMIT 1";

           $result = $this->db->query($query_get); 
          return $result->result_array();

        }

      /**/
        

}

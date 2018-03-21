<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class marketing_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    function update_mensaje_enviado($param){

      $query_update = "UPDATE email_prospecto SET 
                      mensaje_leido =  1 , 
                      fecha_leido = CURRENT_TIMESTAMP()
                      WHERE 
                      email_prospecto ='".trim($param["email"])."'
                      AND mensaje_leido = 0 LIMIT 1";

                      $data["query"] = $query_update;
                      $data["sql_respuesta"]=  $this->db->query($query_update);
                      return $data;
                      
    }
    /**/
    function get_contactos_disponibles($param){

        $tipo = $param["tipo"];
        $query_get = "SELECT 
                      email 
                      FROM prospecto 
                      WHERE 
                      status = 0 AND 
                      idtipo_prospecto 
                      = '1' ORDER BY id_prospecto ASC 
                      LIMIT 25";

        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function registra_respaldo_mail_marketing($param ,  $data_prospecto){

      $mensaje = $param["mensaje"];
      $asunto = $param["asunto"];
      $tipo = $param["tipo"];

      
      $num_enviados = 0; 
      foreach ($data_prospecto as $row){    

        $prospecto =  $row["email"]; 

        $query_insert =  "INSERT INTO email_prospecto(mensaje , asunto , email_prospecto )
                          VALUES( '".strip_tags($mensaje)."',  
                                  '".$asunto."' , 
                                  '".$prospecto."')";  

          $this->db->query($query_insert);
          $num_enviados ++;
      }

      /**/
      $query_update =  "UPDATE 
                        prospecto SET 
                        status = 1 
                        WHERE                         
                        email in(select email_prospecto 
                        from email_prospecto where date(fecha_registro) =  date(current_date()))
                        "; 

      $this->db->query($query_update);

      $query_update =  "UPDATE 
                        prospecto SET 
                        status = 0
                        WHERE                         
                        id_prospecto in(1,2,3) limit 3"; 

      $this->db->query($query_update);
      return $num_enviados;      
    }
    /**/
}
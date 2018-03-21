<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class pagosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    function get_lista_clientes_activos(){      
      /**/
      $_num =  get_random();
      $this->create_tmp_usuarios_clientes(0 , $_num  );

        $query_get ="SELECT
                      nombre
                      ,email 
                      ,apellido_paterno 
                      ,apellido_materno 
                      FROM  usuario u
                      INNER JOIN 
                      tmp_clienes_$_num up 
                      ON 
                      u.idusuario = up.idusuario";      
        
        $result =  $this->db->query($query_get);
        $data_complete =  $result->result_array();

      $this->create_tmp_usuarios_clientes(1 , $_num  );
      return $data_complete;
        
    }
    /**/
    function create_tmp_usuarios_clientes($flag , $_num){
      
      $query_drop = "DROP TABLE IF exists tmp_clienes_$_num";
      $this->db->query($query_drop);

      if ($flag ==  0){


        $query_create = "CREATE TABLE tmp_clienes_$_num AS 
                      SELECT 
                        idusuario 
                      FROM 
                        usuario_perfil 
                      WHERE 
                      idperfil=20";
        $this->db->query($query_create);

      }



    }
    /**/
    function get_email_por_enviar($param){

      $query_get = "SELECT 
                    email
                    FROM prospecto 
                    WHERE 
                    n_tocado = 0 LIMIT 50";
      $result  =  $this->db->query($query_get);
      return $result->result_array();
                      
    }    
    /**/
    function registra_email_enviados($lista_email , $contenido_correo){
        
      $mensaje =  $contenido_correo["mensaje"];
      $asunto =  $contenido_correo["asunto"];
      $z =0;
      foreach($lista_email as $row) {
        
          $email =  $row["email"];

          $query_insert = "INSERT IGNORE INTO email_prospecto(                
                mensaje,           
                asunto  ,          
                email_prospecto
              )
            VALUES(
                '$mensaje' , 
                '$asunto', 
                '$email'
            )";  

          $this->db->query($query_insert);
          $z ++;
      }
      return $z;
      
    }
}
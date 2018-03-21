<?php defined('BASEPATH') OR exit('No direct script access allowed');
class comentariosmodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function insert_comentario($param){

      /**/
      $comentario = $param["comentario"];
      $id_persona =  $param["id_persona"];
      $id_usuario =  $param["id_usuario"];
      $id_tipificacion = $param["tipificacion"];

      $query_insert =  "INSERT INTO 
                        comentario(
                          comentario,    
                          id_persona ,   
                          idusuario ,
                          id_tipificacion
                        )
                        VALUES(
                          '".$comentario."',
                          '".$id_persona."',                          
                          '".$id_usuario."' ,
                          '".$id_tipificacion."' 
                        )";
      
      //return  $this->db->query($query_insert);      
                        return $query_insert;

  }
   function agrega_comentario_pedido($param){

        
        $comentario = $param["comentario"];
        $id_usuario =  $param["id_usuario"];    
        $id_usuario_venta =  $param["id_usuario_venta"];  
        $id_servicio =  $param["id_servicio"];
        /**/
        
             
        $query_insert ="INSERT INTO comentario(                      
                                    comentario ,  
                                    id_usuario_cliente ,  
                                    id_usuario_venta ,
                                    id_servicio
                                    )
                                    VALUES( 
                                      '".$comentario."' , 
                                      '".$id_usuario ."' , 
                                      '".$id_usuario_venta ."',
                                      '".$id_servicio."'
                                    )";

        return  $this->db->query($query_insert);
        
    } 
  /*Termina modelo */
}
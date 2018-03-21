<?php defined('BASEPATH') OR exit('No direct script access allowed');
class agendamodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function agenda_correo($param){

    $fecha_agenda =  $param["fecha_agenda"];    
    $hora_agenda_text =  $param["hora_agenda"];
    $hora_agenda =  substr($hora_agenda_text ,  0 , 5);

    $id_usuario =  $param["id_usuario"];
    $comentario = $param["comentario"];
    $id_persona =  $param["id_persona"];
    
    $query_insert ="INSERT INTO 
                  usuario_persona_correo(
                            fecha_agenda    ,
                            hora_agenda     ,
                            id_persona      ,
                            id_usuario       ,
                            comentario      ,                            
                            hora_agenda_text )
                  VALUES(
                    '".$fecha_agenda."', 
                    '".$hora_agenda."', 
                    '".$id_persona."' ,
                    '".$id_usuario."' ,
                    '".$comentario."' ,                  
                    '".$hora_agenda_text."' )";

     $db_response =   $this->db->query($query_insert);

     /*Agregamos comentario al historial */
     $comentario =  "Se agenda correo electrónico - Fecha " . 
                    $fecha_agenda . 
                    " especificaciones - " . 
                    $comentario;


     $this->agrega_comentario($comentario , $id_persona , $id_usuario  , 9);               
     return $db_response;
                    
  }
  /**/
  function agrega_comentario($comentario , $id_persona, $idusuario , $id_tipificacion ){


    $query_insert ="INSERT INTO comentario(
                    comentario , 
                    id_persona , 
                    idusuario ,  
                    id_tipificacion )
                    VALUES(
                        '".$comentario ."' ,
                        '".$id_persona ."' ,
                        '".$idusuario ."' ,
                        '".$id_tipificacion ."')";
    
    $this->db->query($query_insert);

  }

  /**/
  function agenda_llamada($param){

    $fecha_agenda =  $param["fecha_agenda"];    
    $hora_agenda_text =  $param["hora_agenda"];
    $hora_agenda =  substr($hora_agenda_text ,  0 , 5);

    $id_usuario =  $param["id_usuario"];
    $comentario = $param["comentario"];
    $id_persona =  $param["id_persona"];
    $tipo_llamada =  $param["tipo_llamada"];

    $query_insert ="INSERT INTO 
                  llamada(
                            fecha_agenda    ,
                            hora_agenda     ,
                            id_persona      ,
                            idusuario       ,
                            comentario      ,
                            idtipo_llamada  ,
                            hora_agenda_text )
                  VALUES(
                    '".$fecha_agenda."', 
                    '".$hora_agenda."', 
                    '".$id_persona."' ,
                    '".$id_usuario."' ,
                    '".$comentario."' ,
                    '".$tipo_llamada."' ,
                    '".$hora_agenda_text."' )";

    return  $this->db->query($query_insert);

  }
  /*Termina modelo */
}
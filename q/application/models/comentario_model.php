<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Comentario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /*
    function crea_comentario_pedido($param){
    
    
    $nombre_proyecto  =     $param["descripcion_servicio"];
    $telefono         =     $param["telefono"];
    $num_ciclos       =     $param["num_ciclos"];
    
    $comentario ="Hola me registré desde la plataforma, tengo interés de comprar " . $num_ciclos 
    ."  ". $nombre_proyecto;


    $params = [
      "comentario"            =>  $comentario,
      "id_usuario_cliente"    =>  $param["id_usuario"] ,
      "idusuario"             =>  $param["id_usuario_ventas_referencia"],
      "id_tipificacion"       =>  "1"
    ];
    return $this->insert($params , 1);
  }
    */
  function insert($params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("comentario", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  } 
}
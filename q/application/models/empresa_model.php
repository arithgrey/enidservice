<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Empresa_model extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  function get($params=[], $params_where =[] , $limit =1, $order = '', $type_order='DESC'){
    
    $params = implode(",", $params);
    $this->db->limit($limit);
    $this->db->select($params);
    foreach ($params_where as $key => $value) {
      $this->db->where($key , $value);
    }
    if($order !=  ''){
          $this->db->order_by($order, $type_order);  
    }       
    return $this->db->get("empresa")->result_array();
  }
  function q_up($q , $q2 , $id_empresa){
        return $this->update([$q => $q2 ] , ["idempresa" => $id_empresa ]);
  }
  function q_get($params=[], $id){
    return $this->get($params, ["idempresa" => $id ] );
  }
  function insert( $params , $return_id=0){        
        $insert   = $this->db->insert($tabla, $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
  /*
  function insert_contacto($param){

      $params = [
        "nombre"              =>  $param["nombre"],
        "email"               =>  $param["email"],
        "mensaje"             =>  $param["mensaje"],
        "id_empresa"          =>  $param["empresa"],
        "id_tipo_contacto"    =>  $param["tipo"],
        "telefono"            =>  $param["tel"]
      ];
      return $this->insert("contact" , $params);    
  } 
  */ 
  
    
    
  /*
function get_usuario($param){

    $id_usuario =  $param["id_usuario"];
    $query_get ="SELECT * FROM  
                  usuario 
                WHERE 
                idusuario = '".$id_usuario."' LIMIT 1";
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  
  function insert_paginas_web($param){

      $email = $param["email"];
      $empresa = $param["empresa"];
      $rubro = $param["rubro"];
      $objetivos = $param["objetivos"];
      $sitio_similar = $param["sitio_similar"];            
      $presupuesto = $param["presupuesto"];
      $tel  =  $param["tel"];      
      $facebook  =  $param["facebook"];
      $twitter  =  $param["twitter"];
      $youtube  =  $param["youtube"];

      $query_insert =  "INSERT INTO cotizador(        
                        nombre_empresa        ,
                        email                 ,
                        rubro                 ,
                        objetivos             ,
                        sitio_similar         ,                
                        presupuesto           ,        
                        tipo                  ,
                        tel ,
                        facebook ,  
                        twitter ,  
                        youtube   
        )VALUES(
          '".$empresa."' , 
          '".$email."' , 
          '".$rubro."', 
          '".$objetivos."' ,
          '".$sitio_similar ."',                     
          '".$presupuesto."', 
          '1' , 
          '".$tel  ."',
          '".$facebook  ."',
          '".$twitter  ."',
          '".$youtube  ."'
        )";
      return  $this->db->query($query_insert);


    }
    
  function get_usuario_ventas(){
    
    $query_insert = "SELECT idusuario FROM usuario WHERE email ='ventas@enidservice.com' LIMIT 1"; 
    $result = $this->db->query($query_insert);
    return $result->result_array()[0]["idusuario"];
  }
  
  
  function insert_lead_contacto($param){

      $correo =  $param["email"];      
      $id_fuente  =  20; 
      $tipo_persona  =  13; 
      $id_servicio  =  1; 
      
      $url_registro  =  $param["url_registro"];      
      $comentario =" Persona que envia su mensaje desde la página de contacto - Mensaje - 
                    ". $param["mensaje"];

  
      $id_usuario =  $this->get_usuario_ventas();
      $param["id_usuario"] = $id_usuario;

      $nombre =  $param["nombre"];                
      $telefono =  $param["tel"];

      
      
      $query_insert ="INSERT INTO persona(
                                correo ,                  
                                comentario,               
                                id_servicio,              
                                id_fuente   ,             
                                id_usuario   ,            
                                tipo ,
                                fecha_cambio_tipo,  
                                url_registro , 
                                nombre , 
                                tel  
              )
              VALUES(
                      '".$correo."',
                      '".$comentario."',
                      '".$id_servicio."',
                      '".$id_fuente."',
                      '".$id_usuario."',
                      '".$tipo_persona."',
                         CURRENT_DATE(), 
                      '".$url_registro."' , 
                      '".$nombre."',
                      '".$telefono."'
              )";
      
      

    $this->db->query($query_insert);
    $id_persona = $this->db->insert_id();
    $param["id_persona"] =  $id_persona;
    $param["comentario2"] = $comentario ." -Verificar qué necesita";

    
    $query_insert ="INSERT INTO tipo_negocio_persona(
                        idtipo_negocio ,
                        id_persona)
                    VALUES(111 ,  '".$id_persona."')";

    $this->db->query($query_insert);
    
    
    return  $this->agenda_llamada($param);
  }
  
  function agenda_llamada($param){

    $id_usuario =  $param["id_usuario"];
    $comentario = $param["comentario2"];
    $id_persona =  $param["id_persona"];
    

    $query_insert ="INSERT INTO 
                  llamada(
                            fecha_agenda    ,
                            hora_agenda     ,
                            id_persona      ,
                            idusuario       ,
                            comentario      ,
                            idtipo_llamada 
                             )
                  VALUES(
                    CURRENT_DATE(), 
                    CURRENT_TIME(), 
                    '".$id_persona."' ,
                    '".$id_usuario."' ,
                    '".$comentario."' ,
                    '1' )";

    return  $this->db->query($query_insert);

  }
  
  function insert_lead_subscrito($param){

      $correo =  $param["email"];      
      $id_fuente  =  20; 
      $tipo_persona  =  12; 
      $id_servicio  =  1; 
      
      $url_registro  =  $param["url_registro"];      
      $comentario =" Persona que se registra desde la página web " . $url_registro;

      $id_usuario =  $this->get_usuario_ventas();
      $param["id_usuario"] = $id_usuario;


      
      
      $query_insert ="INSERT INTO persona(
                        correo ,                  
                        comentario,               
                        id_servicio,              
                        id_fuente   ,             
                        id_usuario   ,            
                        tipo ,
                        fecha_cambio_tipo,  
                        url_registro 
              )
              VALUES(
                '".$correo."',
                '".$comentario."',
                '".$id_servicio."',
                '".$id_fuente."',
                '".$id_usuario."',
                '".$tipo_persona."',
                CURRENT_DATE(), 
                '".$url_registro."'

              )";
      
      

    $this->db->query($query_insert);
    $id_persona = $this->db->insert_id();
    $param["id_persona"] =  $id_persona;
    $param["comentario2"] = $comentario ." -Enviar correo sugiriendo otro 
                                    tema  o bien promoniendo alguna Oferta";

    

    $query_insert ="INSERT INTO tipo_negocio_persona(
                        idtipo_negocio ,
                        id_persona)
                    VALUES(111 ,  '".$id_persona."')";

    $this->db->query($query_insert);

    
    
    return  $this->agenda_correo($param);
    
  }

  function agenda_correo($param){
  
    $id_usuario =  $param["id_usuario"];
    $comentario = $param["comentario2"];
    $id_persona =  $param["id_persona"];
    
    $query_insert ="INSERT INTO usuario_persona_correo(
                                fecha_agenda    ,
                                hora_agenda     ,
                                id_persona      ,
                                id_usuario       ,
                                comentario )

                  VALUES(
                    CURRENT_DATE(), 
                    CURRENT_TIME(),
                    '".$id_persona."' ,
                    '".$id_usuario."' ,
                    '".$comentario."' )";

     $response =   $this->db->query($query_insert);

     
     return   $this->agrega_comentario($comentario , $id_persona , $id_usuario  , 9);               
     
                    
  }
  
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
    
    return $this->db->query($query_insert);

  }
  
  
  
*/
}
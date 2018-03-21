<?php defined('BASEPATH') OR exit('No direct script access allowed');
class empresamodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function get_notificacion_pago($param){
    
    $id_notificacion_pago =  $param["id_notificacion_pago"];
    
    $query_get ="
    SELECT 
np.nombre_persona      ,
np.correo              ,
np.dominio              ,
np.fecha_pago          ,
np.fecha_registro      ,
np.cantidad             ,
np.referencia          ,
np.comentario          ,
np.id_notificacion_pago,
np.num_recibo          ,
fp.forma_pago ,
s.nombre_servicio 
FROM  
notificacion_pago np 
INNER JOIN servicio s 
ON  
np.id_servicio = s.id_servicio
INNER JOIN forma_pago fp 
ON  np.id_forma_pago  = fp.id_forma_pago 
WHERE 
np.id_notificacion_pago = '".$id_notificacion_pago."'
";

    $result =  $this->db->query($query_get);
    return $result->result_array();    
  }
  /**/
  function get_usuario($param){

    $id_usuario =  $param["id_usuario"];
    $query_get ="SELECT * FROM  
                  usuario 
                WHERE 
                idusuario = '".$id_usuario."' LIMIT 1";
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
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
    /**/
    /*
    function insert_lead($param){

      $query_insert ="INSERT INTO contact(
                        email   ,       
                        id_empresa , 
                        id_tipo_contacto
                        )VALUES(
                        '".$param["email"]."',                     
                        '1',
                        '".$param["tipo_prospecto"]."'
                      )
                      ";

      return $this->db->query($query_insert);
    }
    */
  function get_usuario_ventas(){
    
    $query_insert = "SELECT idusuario FROM usuario WHERE email ='ventas@enidservice.com' LIMIT 1"; 
    $result = $this->db->query($query_insert);
    return $result->result_array()[0]["idusuario"];
  }
  /**/
  /**/
  function insert_lead_contacto($param){

      $correo =  $param["email"];      
      $id_fuente  =  20; /*Página web o artículo*/
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

    /**/
    $query_insert ="INSERT INTO tipo_negocio_persona(
                        idtipo_negocio ,
                        id_persona)
                    VALUES(111 ,  '".$id_persona."')";

    $this->db->query($query_insert);
    /**/
    /*AGENDAMOS Llamada*/      
    return  $this->agenda_llamada($param);
  }
  /**/
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
  /**/
  function insert_lead_subscrito($param){

      $correo =  $param["email"];      
      $id_fuente  =  20; /*Página web o artículo*/
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

    /**/

    $query_insert ="INSERT INTO tipo_negocio_persona(
                        idtipo_negocio ,
                        id_persona)
                    VALUES(111 ,  '".$id_persona."')";

    $this->db->query($query_insert);

    /**/
    /*AGENDAMOS EMAIL*/
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

     $db_response =   $this->db->query($query_insert);

     /*Agregamos comentario al historial */     
     return   $this->agrega_comentario($comentario , $id_persona , $id_usuario  , 9);               
     
                    
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
    
    return $this->db->query($query_insert);

  }
  /**/  
  function insert_contacto($param){

    $query_insert ="INSERT INTO contact(
                    nombre ,        
                    email   ,       
                    mensaje  ,        
                    id_empresa , 
                    id_tipo_contacto, 
                    telefono
                     )VALUES(
                      '".$param["nombre"]."', 
                      '".$param["email"]."', 
                      '".$param["mensaje"]."', 
                      '".$param["empresa"]."' , 
                      '".$param["tipo"]."',
                      '".$param["tel"]."'
                       ) ";
                       
    return $this->db->query($query_insert);    
  }
  
/*Termina modelo */
}
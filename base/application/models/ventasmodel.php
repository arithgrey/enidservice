<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class ventasmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function verifica_existencia_usuario($param){

        $query_get = "SELECT COUNT(0)num_usuario 
                        FROM usuario WHERE 
                        email = '".$param["correo"]."' LIMIT 1";
        $result =  $this->db->query($query_get);
        $num_usuario =  $result->result_array()[0]["num_usuario"];
        return $num_usuario;

    }
    /*Registramos propuesta*/
    function insert_propuesta($param){
        $comentario =  $param["comentario"];        
        $url_propuesta =  $param["url_propuesta"];    
        $tipo_propuesta =  $param["tipo_propuesta"];
        $prospecto =  $param["prospecto"];
        $id_usuario =  $param["id_usuario"];
        $servicio =  $param["servicio"];
        $promesa_de_respusta = $param["promesa_de_respusta"];

        $query_insert ="INSERT INTO propuesta(
                    nota               
                    ,url                
                    ,idtipo_propuesta   
                    ,id_persona         
                    ,idusuario              
                    ,id_servicio
                    ,promesa_de_respusta
                    )VALUES(
                    '". $comentario ."',
                    '". $url_propuesta ."',
                    '". $tipo_propuesta ."',
                    '". $prospecto ."' ,
                    '". $id_usuario ."' ,
                    '". $servicio ."', 
                    '". $promesa_de_respusta."' )";

        return $this->db->query($query_insert);
    }
    /**/
    function get_labor_venta($param){

        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];

        $sql_tiempo =  " date(fecha_registro) 
        between '".$fecha_inicio."' AND  '".$fecha_termino."' ";

        $query_get =  "SELECT 
                       COUNT(0)personas_contactadas ,
                       DATE(fecha_registro) fecha_registro
                       FROM persona  
                       WHERE 
                       " .$sql_tiempo ."
                       GROUP BY DATE(fecha_registro)";

        $result =  $this->db->query($query_get);
        $data["contactacion"]=  $result->result_array();
        return $data;
    }
    /**/
    function get_prospecto($param){

        $nombre =  $param["nombre"];
        $query_get ="SELECT 
                    concat(nombre , ' ' , a_paterno  ,' ' ,a_materno)nombre_compuesto , 
                    correo ,
                    id_persona  
                    FROM persona p WHERE 
                    nombre like '".$nombre."%'
                    OR a_paterno  like '".$nombre."%' 
                    OR a_materno  like '".$nombre."%'  
                    OR correo  like '".$nombre."%'  
                    OR correo2  like '".$nombre."%'  
                    OR tel  like '".$nombre."%'  
                    OR tel_2  like '".$nombre."%' ORDER BY fecha_registro DESC LIMIT 10 ";
        
        $result =  $this->db->query($query_get);
        return $result->result_array();
        
    }
    /**/
    function insert_prospecto($param){

        $fuente     = $param["fuente"];
        $servicio     = $param["servicio"];
        $nombre     = $param["nombre"];
            
        $apellido_paterno     = $param["apellido_paterno"];
        $apellido_materno     = $param["apellido_materno"];
        $telefono_contacto     = $param["telefono_contacto"];
        $telefono_contacto2     = $param["telefono_contacto2"];
        $correo     = $param["correo"];
        $correo2     = $param["correo2"];
        
        $sitio_web     = $param["sitio_web"];
        $comentario     = $param["comentario"];
        $id_usuario     = $param["id_usuario"];
        $tipo_negocio = $param["tipo_negocio"];
        $referido = 0;
        $referencia_email =  0;                
        $flag_tipo_persona=  1;
        $tipo = 1;
        
        $query_insert ="INSERT INTO persona(
                            nombre         ,
                            a_paterno      ,
                            a_materno      ,
                            tel            ,
                            tel_2          ,
                            sitio_web      ,
                            correo         ,
                            correo2        ,
                            comentario     ,
                            id_servicio    ,
                            id_fuente      ,                        
                            id_usuario     ,
                            referido ,
                            enviar_referencia_email ,
                            tipo
                                                        
            )VALUES(
                
                    '".$nombre."' , 
                    '".$apellido_paterno."' , 
                    '".$apellido_materno."' , 
                    '".$telefono_contacto."' ,
                    '".$telefono_contacto2."' ,
                    '".$sitio_web."' ,
                    '".$correo."' ,
                    '".$correo2."' ,
                    '".$comentario ."' ,
                    '".$servicio ."' ,
                    '".$fuente ."' ,
                    '".$id_usuario ."' ,
                    '".$referido."' , 
                    '".$referencia_email."' ,
                    '".$tipo."'
                )";

        $this->db->query($query_insert);
        $id_persona =   $this->db->insert_id();
        $param["id_persona"] = $id_persona;

    
        
     
        return $this->registra_persona_tipo_negocio($id_persona , $tipo_negocio);
        
    }
    /**/
    function registra_persona_tipo_negocio($id_persona , $id_tipo_negocio){

        $query_insert ="INSERT INTO tipo_negocio_persona(id_persona , idtipo_negocio )
                        VALUES('".$id_persona."' , '".$id_tipo_negocio."')";
        return $this->db->query($query_insert);
    }
    /**/
    function agenda_llamada($param){
        
        $fecha_agenda =  $param["fecha_agenda"];
        $hora_agenda_text =  $param["hora_agenda"];
        $hora_agenda =  substr($hora_agenda_text ,  0 , 5);
        $id_persona =  $param["id_persona"];
        $id_usuario     = $param["id_usuario"];
        $comentario = $param["comentario"];
        $idtipo_llamada =  $param["idtipo_llamada"];

        $query_insert ="INSERT INTO llamada(
            fecha_agenda  ,
            hora_agenda   ,            
            hora_agenda_text ,    
            id_persona    ,
            idusuario     ,
            comentario    ,
            idtipo_llamada)
            VALUES(
                '". $fecha_agenda ."',
                '".$hora_agenda."',
                '". $hora_agenda_text ."',
                '". $id_persona ."',
                '". $id_usuario ."',
                '". $comentario ."',
                '". $idtipo_llamada ."'
            )";
        return $this->db->query($query_insert);
        
    }
    /**/
    function get_tipo_propuesta(){

        $query_get = "SELECT * FROM tipo_propuesta";
        $result=  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_servicios(){

        $query_get = "SELECT * FROM servicio";
        $result=  $this->db->query($query_get);
        return $result->result_array();       
    }
    /**/
    function get_comando_busqueda($param){
        
        $query_get = "SELECT 
                        * 
                      FROM 
                      busqueda_base_prospeccion 
                      WHERE 
                      n_tocado = 0
                      ORDER BY RAND() limit 1";
        $result=  $this->db->query($query_get);
        return $result->result_array();          
    }
   
}
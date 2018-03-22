<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class equipomodel extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
  }
  /**/
  function crea_comentario_pedido($param){
    
    
    $nombre_proyecto =  $param["descripcion_servicio"];          
    $telefono = $param["telefono"];
    $num_ciclos = $param["num_ciclos"];        
    
    $id_usuario =  $param["id_usuario"];    
    $id_usuario_ventas =  $param["id_usuario_ventas_referencia"];  
    /**/
    $comentario ="Hola me registré desde la plataforma, tengo interés de comprar " . $num_ciclos 
    ."  ". $nombre_proyecto;

    $query_insert ="INSERT INTO 
                      comentario(                      
                      comentario ,  
                      id_usuario_cliente ,  
                      idusuario ,
                      id_tipificacion )
                    VALUES( 
                    '".$comentario."' , 
                    '".$id_usuario ."' , 
                    '".$id_usuario_ventas ."', 
                    1 )";

    return  $this->db->query($query_insert);
    
  }
  /**/
  
  /**/
  function crea_direccion_envio_pedido($param){

    $direccion =  $param["direccion"];
    $id_proyecto_persona_forma_pago =  $param["id_proyecto_persona_forma_pago"];
    
      $query_insert ="INSERT INTO direccion(direccion) 
        VALUES('".$direccion."')";
      $this->db->query($query_insert);
      $id_direccion = $this->db->insert_id();

      /**/
      $query_insert ="INSERT INTO 
        proyecto_persona_forma_pago_direccion(
        id_proyecto_persona_forma_pago,  
        id_direccion)

        VALUES($id_proyecto_persona_forma_pago  , $id_direccion)";
        
      $this->db->query($query_insert);

    
  }  
  function registrar_prospecto($param){
        
      $existe =  $this->evalua_usuario_existente($param);
      $data_complete["usuario_registrado"] = 0;

      if($existe == 0 ){
        
        $email =  $param["email"];
        $id_departamento =  9;      
        $password =  $param["password"];            
        $nombre =  $param["nombre"];
        $telefono =  $param["telefono"];
        $id_usuario_referencia = get_info_usuario_variable($param , "usuario_referencia");        
        
        $query_insert = "INSERT INTO usuario(
                                          email  ,                            
                                          idempresa ,                      
                                          id_departamento, 
                                          password,
                                          nombre , 
                                          tel_contacto,  
                                          id_usuario_referencia

                                          )VALUES(
                                          
                                          '".$email."',                                                   
                                          '1',                            
                                          '".$id_departamento."',
                                          '".$password."',
                                          '".$nombre."',
                                          '".$telefono."' ,
                                          '".$id_usuario_referencia."' 
                                            
                              )";
        
        $this->db->query($query_insert);
        
        $data_complete["id_usuario"] =   $this->db->insert_id();
        $data_complete["puesto"] =  20; 
        $data_complete["usuario_permisos"]=   $this->agrega_permisos_usuario($data_complete);               
        $data_complete["email"] =  $email;
        $data_complete["usuario_registrado"] = 1;
        
      }      
      return $data_complete;
      
  }

  function registra_vendedor($param){


      $data_complete["usuario_existe"] =  $this->evalua_usuario_existente($param);
      $data_complete["usuario_registrado"] = 0;


      if ($data_complete["usuario_existe"] == 0 ){
        
        $email =  $param["email"];
        $id_departamento =  9;      
        $password =  $param["password"];            
        $nombre =  $param["nombre"];        
        $id_usuario_referencia = 180; 

        $query_insert = "INSERT INTO usuario(
                                            email  ,                            
                                            idempresa ,                      
                                            id_departamento, 
                                            password,
                                            nombre ,                                             
                                            id_usuario_referencia
                                          )VALUES(
                                            '".$email."',               
                                            '1',                            
                                            '".$id_departamento."',
                                            '".$password."',
                                            '".$nombre."',                                          
                                            '".$id_usuario_referencia."' 
                                            )";
        
        
        $this->db->query($query_insert);

        
        $id_usuario = $this->db->insert_id();            
        $param["id_usuario"] =  $id_usuario; 
        $param["puesto"] =  20; 
        $data_complete["usuario_permisos"]=   $this->agrega_permisos_usuario($param);   
        
        $data_complete["id_usuario"] =  $id_usuario;
        $data_complete["email"] =  $email;
        $data_complete["usuario_registrado"] = 1;
        
      }  
      /**/    
      return $data_complete;
      
  }
  function registrar_afiliado($param){

      $data_complete["usuario_existe"] =  $this->evalua_usuario_existente($param);
      $data_complete["usuario_registrado"] = 0;
      
      if($data_complete["usuario_existe"] == 0 ){
        
          $email =  $param["email"];
          $id_departamento =  8;      
          $password =  $param["password"];            
          $nombre =  $param["nombre"];
          $telefono =  $param["telefono"];

          $query_insert = "INSERT INTO usuario(
                                          email  ,                            
                                          idempresa ,                      
                                          id_departamento, 
                                          password,
                                          nombre , 
                                          tel_contacto)                            
                            VALUES(
                                '". $email."',                                                   
                                '1',                            
                                '".$id_departamento."',
                                '".$password."',
                                '".$nombre."',
                                '".$telefono."')";
        
        
          $this->db->query($query_insert);
          $id_usuario = $this->db->insert_id();

          $param["id_usuario"] =  $id_usuario;           
          $param["puesto"] =  19; 
          $data_complete["usuario_permisos"]=   $this->agrega_permisos_usuario($param);   
          $data_complete["id_usuario"] =  $id_usuario;
          $data_complete["email"] =  $email;
          $data_complete["usuario_registrado"] = 1;        
      }      
      return $data_complete;      
  }  
  /**/
  function registra_recurso($param){

    $nombre =  $param["nombre"];
    $urlpaginaweb =  $param["urlpaginaweb"];    
    $query_insert = "INSERT INTO recurso(
                        nombre,                    
                        urlpaginaweb,            
                        order_negocio, 
                        status,
                        class      
                      )VALUES(
                        '".$nombre."', 
                        '".$urlpaginaweb."', 
                        1,
                        1,
                        ''
                      )";
    return $this->db->query($query_insert);    
  }
  /**/
  function update_perfil_permiso($param){

    $id_recurso =  $param["id_recurso"];
    $id_perfil =  $param["id_perfil"];
    
    /**/
    $query_get ="SELECT COUNT(0)num_permiso FROM perfil_recurso 
                        WHERE 
                        idrecurso = '".$param["id_recurso"]."' 
                        AND 
                        idperfil = '".$param["id_perfil"]."'";

    $result =  $this->db->query($query_get);                    
    $num_permiso =  $result->result_array()[0]["num_permiso"];

    /**/
        

      $query =  "INSERT 
                  INTO perfil_recurso(idperfil  , idrecurso )
                 VALUES(
                   '".$param["id_perfil"]."' , 
                   '".$param["id_recurso"]."' 
                 )";

      if ($num_permiso > 0 ) {
        
        /**/
        $query =  "DELETE FROM
                   perfil_recurso 
                    WHERE 
                  idrecurso = '".$param["id_recurso"]."' 
                    AND 
                  idperfil = '".$param["id_perfil"]."' LIMIT 1";
      }
    /**/

    return $this->db->query($query);



  }
  /**/
  function get_perfiles_permisos($param){

      $query_get = "SELECT 
                    *,
                    r.idrecurso id_recurso
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
      $result = $this->db->query($query_get);
      return $result->result_array();
  }
  /**/
  function insert_miembro($param){
    
    $editar =  $param["editar"];
    $data_complete["usuario_existente"] = 0;
    if($editar ==  1){              
        $data_complete["modificacion_usuario"] = $this->modifica_usuario($param);        
      }else{

        $num_usuarios = $usuario_existente= $this->evalua_usuario_existente($param);
        
        if ($num_usuarios == 0 ) {    
          $data_complete["registro_usuario"] =  $this->crea_usuario_enid_service($param);    
        }else{
            $data_complete["usuario_existente"] = "
            Este usuario ya se encuentra registrado, verifique los datos";
        }        
      }
      return $data_complete;
  }
  /**/
  function evalua_usuario_existente($param){

      $email =  $param["email"];

      $query_get ="SELECT COUNT(0)usuario_existente 
                    FROM usuario 
                  WHERE email = '".$email."' ";
      $result = $this->db->query($query_get);
      return $result->result_array()[0]["usuario_existente"];
  }
  /**/
  function crea_usuario_enid_service($param){

      $nombre     =  $param["nombre"];
      $apellido_paterno     =  $param["apellido_paterno"];
      $apellido_materno     =  $param["apellido_materno"];
      $email =  $param["email"];
      $id_departamento =  $param["departamento"];
      $puesto =  $param["puesto"];
      $inicio_labor =  $param["inicio_labor"];
      $fin_labor     =  $param["fin_labor"];
      $turno =  $param["turno"];
      $sexo     =  $param["sexo"];
      $tel_contacto =  $param["tel_contacto"];
      $id_usuario =  $param["id_usuario"];
      $editar =  $param["editar"];


      $query_insert = "INSERT INTO usuario(
                      nombre,             
                      email  ,                            
                      idempresa                       ,                      
                      apellido_paterno    ,
                      apellido_materno  ,
                      tel_contacto       ,                                  
                      inicio_labor        ,
                      fin_labor            ,                 
                      turno               ,
                      sexo                ,
                      id_departamento, 
                      password
                      )
                    VALUES(
                            '". $nombre."',              
                            '". $email ."',                                                   
                            '1',                            
                            '". $apellido_paterno ."', 
                            '". $apellido_materno."', 
                            '". $tel_contacto ."',                                   
                            '". $inicio_labor."', 
                            '". $fin_labor ."',                  
                            '".$turno."', 
                            '".$sexo."', 
                            '".$id_departamento."',
                            '".sha1("qwerty123.1")."'
                    )";
      
      $this->db->query($query_insert);
      $id_usuario = $this->db->insert_id();
      $param["id_usuario"] = $id_usuario;
      return  $this->agrega_permisos_usuario($param);

  }
  /**/
  function agrega_permisos_usuario($param){

    $puesto =  $param["puesto"];
    $id_usuario =  $param["id_usuario"];


    $query_delete =  "DELETE FROM 
                      usuario_perfil 
                      WHERE 
                      idusuario = '".$id_usuario."' ";
    $this->db->query($query_delete);


    $query_insert = "INSERT INTO usuario_perfil(
                              idusuario , 
                              idperfil 
                        )VALUES(
                          '".$id_usuario."', 
                          '".$puesto ."'
                        )";

    return $this->db->query($query_insert);
    

  }
  /**/
  function modifica_usuario($param){

    /***********************************/
    $nombre     =  $param["nombre"];
    $apellido_paterno     =  $param["apellido_paterno"];
    $apellido_materno     =  $param["apellido_materno"];
    $email =  $param["email"];
    $id_departamento =  $param["departamento"];
    $puesto =  $param["puesto"];
    $inicio_labor =  $param["inicio_labor"];
    $fin_labor     =  $param["fin_labor"];
    $turno =  $param["turno"];
    $sexo     =  $param["sexo"];
    $tel_contacto =  $param["tel_contacto"];
    $id_usuario =  $param["id_usuario"];
    $editar =  $param["editar"];
    $status =  $param["status"];


    $query_update = "UPDATE usuario 
                          SET 
                            nombre = '". $nombre."',              
                            email   = '". $email."',                                                   
                            apellido_paterno     = '".$apellido_paterno ."', 
                            apellido_materno   = '".$apellido_materno."', 
                            tel_contacto = '". $tel_contacto ."',                                   
                            inicio_labor         = '". $inicio_labor."', 
                            fin_labor             = '". $fin_labor ."',                  
                            turno                = '".$turno."', 
                            sexo                 = '".$sexo."', 
                            id_departamento = '".$id_departamento."', 
                            status = '".$status."',
                            ultima_modificacion =  CURRENT_TIMESTAMP()
                        WHERE 
                          idusuario =  '".$id_usuario."'
                          LIMIT 1";

        $this->db->query($query_update);
        return  $this->agrega_permisos_usuario($param);
        
  }
  /**/
  
  /**/
  function get_puesto_cargo($param){

      $id_departamento =  $param["id_departamento"];

      $query_get =  "SELECT  
                      * 
                     FROM 
                     perfil 
                     WHERE 
                     id_departamento = '".$id_departamento."' 
                     ";

      
      $result =  $this->db->query($query_get);
      return $result->result_array();
      
  }  
  /**/
  function get_miembro($param){

    $query_get = "SELECT 
                  u.idusuario,
                  u.nombre,                   
                  u.apellido_paterno ,                 
                  u.apellido_materno,                                    
                  u.email,
                  u.fecha_registro,                  
                  u.status,                                
                  u.email_alterno,
                  u.tel_contacto,
                  u.tel_contacto_alterno,
                  u.inicio_labor,
                  u.fin_labor,
                  u.grupo,
                  u.cargo,
                  u.turno,
                  u.sexo, 
                  u.id_departamento,
                  up.idperfil
                  FROM usuario u
                  INNER JOIN usuario_perfil up 
                    ON up.idusuario =  u.idusuario
                  WHERE 
                  u.idusuario = '".$param["id_usuario"]."' 
                  LIMIT 1";

    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  function get_usuarios_periodo($param){      
        
      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];
      $limit  =  $this->get_limit_usuarios($param);
      $query_get ="SELECT 
                    idusuario id_usuario
                    ,nombre
                    ,email
                    ,apellido_paterno
                    ,apellido_materno
                    , fecha_registro 
                    FROM usuario 
                    WHERE DATE(fecha_registro) 
                    BETWEEN 
                    '".$fecha_inicio."' AND  '".$fecha_termino."' ".$limit;
      $result =  $this->db->query($query_get);
      return $result->result_array();      
   }
  /**/
  function get_equipo_enid_service($param){
      /**/
      $_num =  get_random();
      $this->create_usuarios_enid_service(0, $_num , $param);      
      $query_get ="SELECT 
                    u.* , 
                    d.nombre nombre_departamento                        
                   FROM 
                    tmp_usuarios_enid_service_$_num u
                   INNER JOIN departamento d 
                    ON 
                    u.id_departamento =  d.id_departamento";
      $result =  $this->db->query($query_get);
      
      $data_complete = $result->result_array();
      $this->create_usuarios_enid_service(1, $_num , $param);    
      return $data_complete;
   }
   /**/
   function create_usuarios_enid_service($flag, $_num  , $param){

      $query_drop ="DROP TABLE IF EXISTS tmp_usuarios_enid_service_$_num"; 
      $this->db->query($query_drop);
        /**/
        if ($flag ==  0){        
          $where =  $this->get_where_usuarios($param);
          $query_create = "CREATE TABLE tmp_usuarios_enid_service_$_num AS 
                            SELECT      
                              u.idusuario id_usuario,
                              u.nombre,                   
                              u.apellido_paterno ,                 
                              u.apellido_materno,                                    
                              u.email,                              
                              u.id_departamento ,
                              u.fecha_registro
                            FROM 
                              usuario u
                            ".$where;     
            $this->db->query($query_create);
        }
   }
   /**/
   function get_total_usuarios($param){
      $where =  $this->get_where_usuarios_total($param);
      $query_get = "SELECT COUNT(0)num FROM usuario" .$where;
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["num"];
   }
   /**/
   function get_total_usuarios_periodo($param){

      $fecha_inicio =  $param["fecha_inicio"];  
      $fecha_termino =  $param["fecha_termino"];

      
      $query_get = "SELECT COUNT(0)num FROM usuario 
                    WHERE 
                    DATE(fecha_registro) 
                    BETWEEN 
                    '".$fecha_inicio."' AND  '".$fecha_termino."' ";
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["num"];
   }
   /**/
   function get_where_usuarios($param){

      $id_departamento =  $param["id_departamento"];
      $status = $param["status"];

      switch(intval($param["id_departamento"])) {
        case 0:
            $limit  =  $this->get_limit_usuarios($param);
            return 
            " WHERE id_departamento != 8 AND id_departamento != 9 AND status = $status ".$limit;
          break; 

        case 8:
            $limit  =  $this->get_limit_usuarios($param);
            return 
            " WHERE id_departamento = 8 ".$limit;
          break;          
        default:        
          break;
      }
   }
    function get_where_usuarios_total($param){

      $id_departamento =  $param["id_departamento"];
      $status = $param["status"];

      switch(intval($param["id_departamento"])) {
        case 0:            
            return " WHERE id_departamento != 8 AND id_departamento != 9 AND status = $status ";
          break; 

        case 8:
            
            return " WHERE id_departamento = 8 ";
          break;          
        default:        
          break;
      }
   }
   /**/
   function get_limit_usuarios($param){
 
      $page = (isset($param['page'])&& !empty($param['page']))?$param['page']:1;
      $per_page = 10; //la cantidad de registros que desea mostrar      
      $adjacents  = 4; //brecha entre páginas después de varios adyacentes
      $offset = ($page - 1) * $per_page;
      return " LIMIT $offset , $per_page ";
   }
   
}

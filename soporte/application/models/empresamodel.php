<?php defined('BASEPATH') OR exit('No direct script access allowed');
class empresamodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function insert_contacto($param){


    $query_insert ="INSERT INTO contact(
                    nombre ,        
                    email   ,       
                    mensaje  ,        
                    id_empresa ,
                    telefono, 
                    id_tipo_contacto
                     )VALUES(
                      '".$param["nombre"]."', 
                      '".$param["email"]."', 
                      '".$param["mensaje"]."', 
                      '".$param["empresa"]."' , 
                      '".$param["tel"]."', 
                      '".$param["tipo"]."'
                      ) "
                    ;

    return $this->db->query($query_insert);
  }
  /**/
  function update_locacion_maps($param){

      $place_id =  $param["place_id"];
      $formatted_address =  $param["formatted_address"];
      $id_empresa =  $param["identificador"];
      $lat = $param["lat"]; 
      $lng = $param["lng"]; 
      
      $query_update = "UPDATE empresa 
              SET           
              place_id = '".$place_id ."'  ,  
              formatted_address = '". $formatted_address  ."',          
              lat =  '".$lat."' , 
              lng = '".$lng."' 
              WHERE idempresa = '".$id_empresa."' limit 1"; 
      return $this->db->query( $query_update);  
  }
  /**/

  function update_direccion($param){

      
      $formatted_address =  $param["direccion"];
      $id_empresa =  $param["empresa"];

      $query_update = "UPDATE empresa 
              SET 
              formatted_address = '". $formatted_address  ."'
              WHERE 
              idempresa = '".$id_empresa."' limit 1"; 

      return $this->db->query( $query_update);  
  }
  /**/
  function update_info_contacto($param){

      $tel =  $param["tel"];
      $email =  $param["mail_contacto"];              
      $id_empresa =  $param["empresa"];

      $query_update = "UPDATE empresa 
              SET 
              num_contacto =   '".$tel."', 
              email_contacto  =  '".$email."'
              WHERE 
              idempresa = '".$id_empresa."' limit 1"; 

      return $this->db->query( $query_update);  

  }

  /**/
  function get_galeria($param){
    $query_get =  "select *  from 
                  imagen_empresa where  id_empresa = '".$param["id_empresa"]."'  and tipo = 2 ";
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function insert_promocion($param){

    $query_insert =  "INSERT INTO  promocion(nombre_promocion , idempresa) 
                      VALUES('".$param["promocion"]."'  ,  '".$param["id_empresa"]."') "; 
    return  $this->db->query($query_insert);

  }
  /**/
  function get_promociones_empresa($param){

      $query_get = "SELECT 
                    SUM(case when cp.id_catalogo_productos_servicios is not null then 1 else 0 end )num_productos , p.* FROM promocion p 
                    LEFT OUTER JOIN catalogo_ps_promocion  cp 
                    on p.id_promocion = cp.id_promocion
                    WHERE idempresa ='".$param["id_empresa"]."'
                    GROUP BY p.id_promocion";  
      $result= $this->db->query($query_get); 
      return $result->result_array();
  }
  /**/
  function update_categoria($param){
    
    $query_update =  "UPDATE  catalogo_productos_servicios SET       
                      nombre  =  '".$param["categoria"]."' ,                        
                      descripcion = '".$param["descripcion"]."' ,          
                      precio              =   '".$param["precio"]."' ,        
                      costo                =   '".$param["costo"]."' ,       
                      precio_variable        =  '".$param["precio_variable"]."' 
                      WHERE 
                      id_catalogo_productos_servicios =  '".$param["id_categoria"]."' LIMIT 1 ";
                      return  $this->db->query($query_update);

    
  }
  /**/
  function get_catalogo_productos_servicios($param){

    $query_get =  "SELECT 
                  * 
                  FROM 
                  catalogo_productos_servicios 
                  WHERE id_empresa =  '".$param["id_empresa"]."'
                  ORDER BY nombre ASC ";
    $result= $this->db->query($query_get); 
    return $result->result_array();

  }
  /**/
  function update_ingreso($param){
    $query_update = "UPDATE registro 
                    SET 
                    nombre = '".$param["categoria_ingreso"]."' , 
                    valor = '".$param["valor"]."' , 
                    cantidad = '".$param["cantidad"]."'
                    WHERE id_registro = '".$param["registro"]."' LIMIT 1 ";
    return  $this->db->query($query_update);
  }
  /**/
  function get_ingreso($param){

      $query_get =  "SELECT * FROM registro WHERE id_registro = '".$param["registro"]."' LIMIT 1 ";
      $result= $this->db->query($query_get);
      return $result->result_array();
  }
  /**/
  function registra_cuenta($param){

    $query_insert =  "INSERT INTO  cuenta(nombre_cuenta , idempresa ) 
    VALUES('".$param["nombre_cuenta"]."' ,  '".$param["id_empresa"]."')"; 
    $this->db->query($query_insert);

    $id_cuenta  = $this->db->insert_id();              
    
    return  $this->registra_usuario_cuenta($param["id_usuario"] ,  $id_cuenta);
    

    /**/
    
  }
  /**/
  function mover_registro($param){

    $query_update = "UPDATE registro SET  
                    id_cuenta = '".$param["cuenta"]."', 
                    tipo = '".$param["tipo"]."'
                    WHERE id_registro = '".$param["registro"]."' LIMIT 1 ";
    return  $this->db->query($query_update);
  }
  /**/
  function get_cuentas($id_empresa , $id_usuario ){

      $query_get = "SELECT c.* FROM cuenta c 
                    INNER JOIN usuario_cuenta uc ON  
                    c.id_cuenta =  uc.id_cuenta 
                    WHERE c.idempresa  =  $id_empresa  and  uc.id_usuario =  $id_usuario LIMIT 10";  
      $result =  $this->db->query($query_get);
      return $result->result_array();
  }
  /**/
  function get_registros($param){

    $_num =  get_random();
    $table_b = 1;

    if ($param["tipo"] == 1){
        $table_b = 0;
    }

    $this->create_tmp_registros($_num , 0  ,  $param["periodo"]  , $param["cuenta"] ,  $param["tipo"] , $table_b );

      $query_get =  "SELECT * FROM  tmp_registros_$_num"; 
      $result =  $this->db->query($query_get);
      $data_complete["desglose"] =  $result->result_array();                        

      $query_get = "SELECT 
                  DISTINCT(nombre) articulos, 
                  count(0)movimientos , 
                  sum(total) acumulado  
                  FROM tmp_registros_$_num
                  group by  nombre order by movimientos desc;"; 

      $result =  $this->db->query($query_get);

      $data_complete["resumen"] =  $result->result_array();




      
        $query_get = "SELECT SUM(total)total FROM tmp_registros_$_num"; 
        $result = $this->db->query($query_get);
        $valor_tabla_consulta =   $result->result_array()[0]["total"];


        $query_get = "SELECT SUM(total)total FROM tmp_registros_b_$_num"; 
        $result = $this->db->query($query_get);
        $valor_tabla_2 =   $result->result_array()[0]["total"];


        if ($param["tipo"] == 0 ) {          
            $data_complete["total_gastos"] = $valor_tabla_consulta;
            $data_complete["total_ingresos"] = $valor_tabla_2;
        }else{
            $data_complete["total_ingresos"] = $valor_tabla_consulta;
            $data_complete["total_gastos"] = $valor_tabla_2;
        }


        




    $this->create_tmp_registros($_num , 1  ,  $param["periodo"] , $param["cuenta"] ,  $param["tipo"] , $table_b );
    return $data_complete;
  }


  /**/
  function create_tmp_registros($_num , $flag , $periodo ,  $id_cuenta ,  $tipo , $table_b ){
        
      $query_drop = "DROP TABLE IF exists tmp_registros_$_num"; 
      $db_response  =  $this->db->query($query_drop);
      

      
      $query_drop = "DROP TABLE IF exists tmp_registros_b_$_num"; 
      $db_response  =  $this->db->query($query_drop);
      
          
      
      
        
      switch ($periodo){
        /*0 para dia */
        case 0:
        
          $sql=  " ORDER BY  fecha_registro DESC";
          break;
        
        default:
          
          break;
      }
      

      if ($flag == 0){
                  $query_create =  "
                  CREATE TABLE tmp_registros_$_num  AS 
                    SELECT 
                    r.id_registro,
                    r.nombre ,
                    r.tipo ,
                    r.id_cuenta , 
                    r.cantidad , 
                    r.valor ,   
                    (r.cantidad * r.valor) total , 
                    date(r.fecha_registro)f_registro , 
                    time(r.fecha_registro)hora
                  FROM registro r 
                  WHERE id_cuenta = '".$id_cuenta."' 
                  AND tipo = '".$tipo ."'  " . $sql; 
                  $db_response  =   $this->db->query($query_create);



                  $query_create =  "
                  CREATE TABLE tmp_registros_b_$_num  AS 
                    SELECT 
                    r.id_registro,
                    r.nombre ,
                    r.tipo ,
                    r.id_cuenta , 
                    r.cantidad , 
                    r.valor ,   
                    (r.cantidad * r.valor) total , 
                    date(r.fecha_registro)f_registro , 
                    time(r.fecha_registro)hora
                  FROM registro r 
                  WHERE id_cuenta = '".$id_cuenta."' 
                  AND tipo = '".$table_b ."'  " . $sql; 
                  $db_response  =   $this->db->query($query_create);



      }
      return  $db_response; 
  }
  /**/
  function insert_registro($param){

    

    $query_insert =  "INSERT INTO registro( nombre , tipo , id_cuenta , cantidad , valor  )
    VALUES(
        '".$param["categoria_ingreso"]."' , 
        '".$param["tipo"]."' , 
        '".$param["cuenta"]."' , 
        '".$param["cantidad"]."' , 
         '".$param["valor"]."' ) "; 
      return $this->db->query($query_insert );
  }
  /**/

  function insert_categoria($param){
    /*
    $query_get =  "SELECT COUNT(0)existe  FROM  catalogo_productos_servicios 
                   WHERE 
                   nombre = '".$param["categoria"]."' 
                   AND   
                   id_empresa = '".$param["id_empresa"]   ."' LIMIT 1"; 

    $result =  $this->db->query($query_get);
    $e =  $result->result_array()[0]["existe"];
    if ($e == 0 ) {
      $query_insert = "INSERT INTO catalogo_productos_servicios(
                          nombre ,  
                          id_empresa , 
                          descripcion  , 
                          precio  , 
                          costo , 
                          precio_variable
                        ) 
                       VALUES( 
                        '".$param["categoria"] ."' ,
                        '".$param["id_empresa"]."' , 
                        '".$param["descripcion"]."' , 
                        '".$param["precio"]."' , 
                        '".$param["costo"]."' , 
                         '".$param["precio_variable"]."' ) "; 
      return  $this->db->query($query_insert);  
    }else{
      return true;
    }
    */

      $query_insert = "INSERT INTO catalogo_productos_servicios(
                          nombre ,  
                          id_empresa , 
                          descripcion  , 
                          precio  , 
                          costo , 
                          precio_variable
                        ) 
                       VALUES( 
                        '".$param["categoria"] ."' ,
                        '".$param["id_empresa"]."' , 
                        '".$param["descripcion"]."' , 
                        '".$param["precio"]."' , 
                        '".$param["costo"]."' , 
                        '".$param["precio_variable"]."' ) "; 
      return  $this->db->query($query_insert);  
    

  }
  /**/
  function get_categoria($param){

    $query_get =  "SELECT * FROM 
                    catalogo_productos_servicios
                  WHERE 
                  id_catalogo_productos_servicios =  '".$param["categoria"] ."' LIMIT 1  ";
    $result  =  $this->db->query($query_get);
    return $result->result_array();
                  

  }
  /**/
  function get_categorias($id_empresa){

    $query_get =  "SELECT 
    id_catalogo_productos_servicios,  
    nombre ,
    descripcion 
    FROM catalogo_productos_servicios WHERE id_empresa =  $id_empresa ORDER BY nombre ASC ";
    $result= $this->db->query($query_get); 
    return $result->result_array();

  }
  /**/
  function update_perfil_user_prospecto($id_usuario , $id_perfil){
    

    $query_get = "SELECT  COUNT(0)perfil_e FROM usuario_perfil 
                    WHERE  idusuario = $id_usuario AND idperfil =  7 "; 

    $result =  $this->db->query($query_get);              
    $e = $result->result_array()[0]["perfil_e"];

    if($e > 0 ){
      $query_update =  "UPDATE usuario_perfil SET status = 0 WHERE idusuario = $id_usuario LIMIT 10";
      $this->db->query($query_update);
      
      $query_insert =  "INSERT INTO usuario_perfil(idusuario , idperfil ) VALUES($id_usuario , $id_perfil )";
      $this->db->query($query_insert);  
      return 1; 
    }else{
      return 2;
    }
    
    /**/

  }
  /**/
  function update_reservaciones_evento($param){

    /**/
    $query_update = "UPDATE evento 
                      SET 
                      reservacion_tel  = '".$param["reservacion_tel"]."' , 
                      reservacion_mail   = '".$param["reservacion_mail"]."'   
                      WHERE idevento = '".$param["dinamic_event"]."' LIMIT 1 ";  
    return $this->db->query($query_update);
    /**/
  }
  /**/
  function get_reservaciones_evento($param){

    $query_get =  "SELECT 
                    reservacion_tel , 
                    reservacion_mail 
                    FROM evento 
                    WHERE idevento = '".$param["id_evento"] ."' LIMIT 1 "; 


   $result = $this->db->query($query_get);                 

   $data = $result->result_array();
   $reservacion_tel =  $data[0]["reservacion_tel"];
   $reservacion_mail =  $data[0]["reservacion_mail"];
    

   $tel_lenght = strlen(trim($reservacion_tel));
   $mail_lenght = strlen(trim($reservacion_mail));

   $flag =0;
   if ($tel_lenght ==  0 ){
      
      $query_update =  "update evento e , empresa  set e.reservacion_tel = ( select reservacion_tel from  empresa 
                        where       
                        idempresa = '".$param["id_empresa"]."'  ) 
                        where e.idevento = '".$param["id_evento"]."' ";     

      $this->db->query($query_update);                  
      $flag ++;
   }

   if ($mail_lenght ==  0 ){
      
      $query_update =  "update evento e , empresa  set e.reservacion_mail = ( select reservacion_mail from  empresa 
                        where       
                        idempresa = '".$param["id_empresa"]."'  ) 
                        where e.idevento = '".$param["id_evento"]."' ";     

      $this->db->query($query_update);                  
      $flag ++;
   }


   if ($flag > 0 ){

      $query_get =  "SELECT  reservacion_tel ,  reservacion_mail  FROM evento  
                     WHERE 
                     idevento = '".$param["id_evento"] ."' LIMIT 1 "; 
     $result = $this->db->query($query_get);                 
     $data = $result->result_array(); 
   }
  return $data;
  }
  /**/
  function update_reservaciones($param){

    $query_update =  "UPDATE empresa SET  
                      reservacion_tel  = '".$param["reservacion_tel"] ."' ,
                      reservacion_mail =  '".$param["reservacion_mail"] ."'
                      WHERE idempresa = '".$param["id_empresa"]."' LIMIT 1";

    return $this->db->query($query_update);                  
  }
  /**/
  function get_reservaciones($id_empresa){

    $query_get =  "SELECT  
                  reservacion_tel ,    
                  reservacion_mail  
                  FROM empresa WHERE idempresa = '".$id_empresa."' LIMIT  1";  

    $result = $this->db->query($query_get);
    return $result->result_array();

    
  }
  /**/
  function get_num_empresas(){
    $query_get =  "SELECT COUNT(0) num_empresas FROM empresa";  
    $result = $this->db->query($query_get);
    return $result ->result_array()[0]["num_empresas"];
  }
  /**/
  function consulta_user_existente($param){

    $query_get =  "SELECT COUNT(0)num_user , idusuario   FROM usuario WHERE email='".strtolower($param["mail"])."' LIMIT 1 ";
    $result = $this->db->query($query_get);
    $data_user = $result->result_array()[0];
    $num_user =  $data_user["num_user"];
    $data["num_user"] =  $num_user;    
    if($num_user >0){      
      $data["id_user"] =  $data_user["idusuario"];  
    }  
    return $data;
  }
  /**/  
  function consulta_user_prospecto($param){
    
    $query_get =  "SELECT COUNT(0)num_user FROM usuario WHERE email='".strtolower($param["mail"])."' LIMIT 1 ";
    $result = $this->db->query($query_get);
    $num_user =  $result->result_array()[0]["num_user"];
    return $num_user;
  }
  /**/
  function consulta_empresa_existencia($param){

    $query_get = "SELECT count(0)existe FROM empresa WHERE nombreempresa = '". $param["organizacion"]."' LIMIT  1";
    $result=  $this->db->query($query_get);
    return $result->result_array()[0]["existe"];
    

  }
  /**/
  function get_status_empresa($param){

    $query_get = "SELECT status FROM empresa WHERE idempresa =  '".$param["empresa"]."' ";
    $result=  $this->db->query($query_get); 
    $estatus_empresa =  $result->result_array()[0]["status"];


    $data["estatus_text"] =  "";
    $data["estatus_empresa"] =  0;

    switch ($estatus_empresa) {
      case 1:
          /*Contamos cuantos eventos tenemos registrados*/  

          $num_eventos = $this->empresa_eventos($param["empresa"]);
          if ($num_eventos < 5){
              $data["estatus_text"] = "Eventos registrados " . $num_eventos;
              $data["estatus_empresa"] = 1;            
          }else{

              $data["estatus_text"] = "Has alcanzado el máximo de de eventos a publicitar en la versión de prueba";
              $data["estatus_empresa"] = 0;          
              $data["propuesta_venta"] = 1;          

          }

          break;
      case 2:          
          
          /*2.-Cuando ya han pagado */  
          $data["estatus_text"] = "Usuario que ha reagistrado pago";
          $data["estatus_empresa"] =  1;

          break;    
        
      case 3:

          /*Cuando ya ha terminado su límite de pago*/
          $data["estatus_text"] = "Usuario que ha reagistrado pago pero la fecha ha terminado";
          $data["estatus_empresa"] =  1;

        break;

      case 4:

        $data["estatus_text"] = "Por siempre";
        $data["estatus_empresa"] =  1;
        
        break;

      case 5:
        $data["estatus_text"] = "Usuario bloqueado";
        $data["estatus_empresa"] =  0;
        
        return 0;
        break;

      default:        
        $data["estatus_text"] = "";
        $data["estatus_empresa"] =  0;
        break;
    }

    return $data;

  }
  /**/
  function empresa_eventos($id_empresa){

    $query_get =  "SELECT COUNT(0)num_eventos FROM evento WHERE idempresa = $id_empresa LIMIT  5";
    $result = $this->db->query($query_get);
    return $result->result_array()[0]["num_eventos"];
  }
  /**/

  /**/
  function insert_prospecto_enid($param){
    $query_insert =  "INSERT IGNORE INTO prospecto(correo) VALUES('". strtolower($param["mail"]) ."')"; 
    return  $this->db->query($query_insert);  
  }
  /**/      
  function update_pais_empresa($param){
    $query_get =  "UPDATE empresa SET idCountry = '".$param["pais_empresa"]."' 
    WHERE idempresa  = '". $param["empresa"]."' limit 1 ";
    return  $this->db->query($query_get);

  }
  /**/
  function get_pais_empresa($param){

    $query_get =  "SELECT idCountry FROM empresa WHERE idempresa = '". $param["empresa"]."'  LIMIT 1";
    $result = $this->db->query($query_get);
    return $result->result_array();
  } 
  /**/
  function get_paises(){

      $query_get =  "select * from countries";
      $result =  $this->db->query($query_get);
      return $result->result_array();

  }

  /**/
  function create_account_general($param){

      $query_insert = "INSERT INTO empresa(nombreempresa , acepta_uso_privacidad , text_uso_privacidad  , idCountry ,  status ) 
      VALUES ('".$param["organizacion"]."' , '".$param["privacidad_condiciones"]."' , 'He leído y  acepto las condiciones de uso y privacidad para hacer uso del sistema Enid Service.' , 15  , 5 )";    
      $this->db->query($query_insert);
      $id_empresa  = $this->db->insert_id();              
      /**/
      $query_insert  = "INSERT INTO usuario(            
                            email,                    
                            idempresa,                                                                       
                            ultima_modificacion , 
                            password ) 
                        VALUES                         
                            ('". strtolower($param["mail"])."' ,                
                            '".$id_empresa  . "' ,                                                                 
                            CURRENT_TIMESTAMP()  , 
                            '". $param["pw"] ."'
                            )";
      $this->db->query($query_insert);
      $id_user  = $this->db->insert_id();   
      /**/           
      return $this->create_config_inicial_general($id_empresa , $id_user ); 
  }
  function create_config_inicial_general($id_empresa , $id_user ){

    $query_inser ="INSERT INTO  usuario_perfil(idusuario, idperfil ) VALUES('". $id_user  ."' , '7' )";    
    $result = $this->db->query($query_inser);     

    /*Insertamos cuenta*/

    return $result;
  }
  
  /**/
  function create_account($param){


      $query_insert = "INSERT INTO empresa(nombreempresa , acepta_uso_privacidad , text_uso_privacidad  , idCountry) 
                       VALUES 
                       ('".$param["organizacion"]."' ,
                        '".$param["privacidad_condiciones"]."' , 
                        'He leído y  acepto las condiciones de uso y privacidad para hacer uso del sistema Enid Service.' 
                        , 15 )";    

      $this->db->query($query_insert);
      $id_empresa  = $this->db->insert_id();              
      /**/
      $query_insert  = "INSERT INTO usuario(            
                            email,                    
                            idempresa,                                                                       
                            ultima_modificacion , 
                            password ) 
                        VALUES                         
                            ('". strtolower($param["mail"])."' ,                
                            '".$id_empresa  . "' ,                                                                 
                            CURRENT_TIMESTAMP()  , 
                            '". $param["pw"] ."'
                            )";

      $this->db->query($query_insert);
      $id_user  = $this->db->insert_id();   
      /**/           
      return $this->create_config_inicial($id_empresa , $id_user );
  }
  /**/
  function registra_usuario_cuenta($id_usuario ,  $id_cuenta){
    $query_insert =  "INSERT INTO  usuario_cuenta(id_usuario , id_cuenta ) VALUES ($id_usuario , $id_cuenta )";  
    return   $this->db->query($query_insert);
  }

  /**/
  function create_config_inicial($id_empresa , $id_user ){

    $query_inser ="INSERT INTO  usuario_perfil(idusuario, idperfil ) VALUES('". $id_user  ."' , '4' )";    
    $result = $this->db->query($query_inser);     

    $query_insert =  "INSERT INTO  cuenta(nombre_cuenta , idempresa ) VALUES('Cuenta del negocio' , $id_empresa);";        
    $this->db->query($query_insert);
    $id_cuenta  = $this->db->insert_id();              
    $this->registra_usuario_cuenta($id_user ,  $id_cuenta);









    $query_insert =  "insert into catalogo_productos_servicios(nombre , id_empresa  ) 
                      values
                      ('Litro de cerveza' ,  $id_empresa), 
                      ('Cartón de cerveza' ,  $id_empresa), 
                      ('Luz' ,  $id_empresa) , 
                      ('Agua' ,  $id_empresa) , 
                      ('Renta' ,  $id_empresa) ";

    $this->db->query($query_insert);


    return $result;
  }
  /**/
  function get_num_users($param){

    $query_get =  "SELECT COUNT(0)num  FROM usuario WHERE email = '".strtolower($param["mail"])."' LIMIT  1  ";  
    $result =  $this->db->query($query_get); 
    return $result->result_array()[0]["num"];
  }
  /**/
  function get_num_empresa_name($param){

    $query_get =  "SELECT COUNT(0)num FROM empresa WHERE  nombreempresa = '".$param["org"]."'  LIMIT  1 ";
    $result =  $this->db->query($query_get); 
    return $result->result_array()[0]["num"];
  }
  /**/
  function get_solicitud_ciudad_cliente($param){    
    
    $where =  "";
    if ($param["public"] ==  1) {
        $where =  "WHERE  status_solicitud != 2 ";
    }    
    $_num =  get_random();
    $this->create_tmps_solicitudes_artistas($_num , 0 , $param );
    $query_get =  "select  
                    s.* ,  
                    a.nombre_artista  
                    FROM tmp_solicitud_artista_$_num  s  
                    INNER JOIN artista a   
                    ON  s.id_artista  =  a.idartista ".  $where   ." order by  s.solicitudes  desc ";
   
    $result =  $this->db->query($query_get);
    $data_complete =  $result->result_array();
    $this->create_tmps_solicitudes_artistas($_num , 1 , $param );    
    return $data_complete;
  }
  /**/
  function create_tmps_solicitudes_artistas($_num , $flag , $param){
      $query_drop =  "DROP TABLE IF exists tmp_solicitud_artista_".$_num; 
      $db_response =  $this->db->query($query_drop);

      if ($flag ==  0 ) {            
          $query_procedure =  "CREATE TABLE  tmp_solicitud_artista_".$_num . "  AS  
                                select  
                                id_artista ,  
                                sum(case when  id_artista is not null  then 1 else  0 end )solicitudes  ,
                                status status_solicitud
                                from solicitud_artista_org 
                                where 
                                id_empresa = '".$param["empresa"]."'
                                and date(fecha_registro) 
                                BETWEEN  DATE_ADD(CURRENT_DATE() , INTERVAL -1 MONTH ) AND CURRENT_DATE()
                                GROUP BY  id_artista LIMIT 50";        
          $db_response =  $this->db->query($query_procedure);
      }
      return $db_response;
  }
  /**/
  /**/
  function experienciaq($param){    
    $q = $param["q"]; 
    $val =  $param["val"];
    $query_update =  "UPDATE empresa_experiencia  SET $q = '".$val ."' WHERE idexperiencia =  '".$param["id_experiencia"]."' ";  
    return   $this->db->query($query_update);  
  }
  /**/  
  function get_iconos_sociales($param){
    

      $id_empresa =  $param["id_empresa"];
      $this->create_imgs_iconos(0 , $id_empresa);
      
      $query_get="SELECT * FROM   tmp_img_exp_1_$id_empresa 
                  UNION ALL 
                  select * from   tmp_img_exp_2_$id_empresa 
                  UNION ALL 
                  select * from   tmp_img_exp_7_$id_empresa";

      $result = $this->db->query($query_get);
      $data_complete = $result->result_array();  
      $this->create_imgs_iconos(1 , $id_empresa);
      return $data_complete; 
      
  }
  /**/
  function create_imgs_iconos($flag , $id_empresa){


    $posibles_tables = array( 1 , 2 , 7);
    $msj_client =  ""; 
    for ($x=0; $x <count($posibles_tables); $x++) {       
      $query_procedure =  "DROP table IF exists tmp_img_exp_".$posibles_tables[$x]."_".$id_empresa; 
      $msj_client .= $this->db->query($query_procedure);
  
    }

    if ($flag == 0 ){
    
      
      
      for ($x=0; $x <count($posibles_tables); $x++) {       
        $query_create =  "CREATE TABLE  tmp_img_exp_".$posibles_tables[$x]."_".$id_empresa." AS  
            SELECT * FROM imagen WHERE id_empresa =  '".$id_empresa ."'
            AND DATE(fecha_registro) BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL - 1 MONTH) AND CURRENT_DATE() AND 
            type = '".$posibles_tables[$x]."'
            ORDER BY fecha_registro DESC LIMIT 4";

          $msj_client .= $this->db->query($query_create);
      }
    }
    return $msj_client;


  }
  /**/
  function contruye_experiencia_iconos($id_empresa , $f = 0 , $_num = 0 ){

      if($_num == 0 ) {
        $_num = mt_rand();       
      }    
      $query_procedure ="CALL expreriencia_iconos($id_empresa , $_num  , $f);";    
      $this->db->query($query_procedure);
      return $_num;
  }
  /**/

  /**/
  function get_generos_musicales_empresa($id_empresa){

    $query_get ="SELECT COUNT(0) total FROM  empresa_genero_musical WHERE id_empresa = '". $id_empresa ."' LIMIT 100"; 
    $result =  $this->db->query($query_get);
    $data =  $result->result_array()[0];
    return $data["total"];
  }  
  function get_eventos_publicados($id_empresa){    
    $query_get = "SELECT count(0) total  FROM evento WHERE idempresa = '". $id_empresa ."' and  status != 0"; 
    $result =  $this->db->query($query_get);
    $data =  $result->result_array()[0];
    return $data["total"];
  }
  /**/
  function update_descripcion_objeto_permitido($param){

    $query_update = "update objetopermitido set descripcion = '".$param["descripcion-obj"] ."' where idobjetopermitido = '".$param["objeto_permitido"]."'  ";
    return $this->db->query($query_update);
  }
  /**/
  function get_obj($param){

    $query_get ="SELECT
                * 
                FROM
                objetopermitido 
                WHERE 
                idobjetopermitido 
                = 
                '".$param["objeto"]."' ";
    
    $result = $this->db->query($query_get);
    return $result->result_array();
  }
  /***/
  function solicitud_ciudad_cliente($param){

          $query_get ="SELECT * FROM  artista WHERE nombre_artista  like  '%". $param["artista-solicitud"] ."%' ";                
          $result_artista  =  $this->db->query($query_get);
          $artista  =  $result_artista->result_array();
          $id_empresa =  $param["empresa"];       
          $id_ciudad  =  $param["ciudad"];
          $email  =  $param["email"];
          
          if (count($artista) > 0 ){
              $id_artista =  $artista[0]["idartista"];  
                  return $this->create_solicitud_artista($id_artista ,  $id_empresa,  $id_ciudad  , $email  );
                  
          }else{
          
              $query_insert ="INSERT INTO artista (nombre_artista) values ( '". $param["artista-solicitud"]   ."' )";
              $data[0] = $this->db->query($query_insert);
              $id_artista  = $this->db->insert_id();                     
            
                  return  $this->create_solicitud_artista($id_artista ,  $id_empresa ,  $id_ciudad  , $email );        
          }      
  }
  /**/
  function create_solicitud_artista($id_artista , $id_empresa , $id_ciudad ,  $email ){
      
      $query_insert =  "INSERT INTO solicitud_artista_org(id_artista , id_empresa , id_Country ,  email ) VALUES('". $id_artista  ."' ,  '". $id_empresa ."' , '". $id_ciudad  ."' , '".$email ."' )"; 
      return  $this->db->query($query_insert);
  }



/**/  
function insert_incidencia_empresa($id_empresa , $id_usuario ,  $data ){

  $query_insert =  "";
  if ($data["otro"]!= null ) {
    
  $query_insert ="INSERT INTO  incidencia(          
                 descripcion_incidencia,                                   
                 usuario_notificado   , 
                 afectacion            ,
                 fecha_solicitud       ,
                 idtipo_incidencia     ,
                 idsub_tipo_incidencia
                )VALUES(

                  '". $data["descripcion"]  ."',
                  '". $data["usuario_reportado"]."' ,
                  '". $data["afectacion"] ."',
                  '". $data["fecha-reporte"]."', 
                  '". $data["tipo-incidencia"] ."', 
                  '". $data["otro"] ."'
                )";
    }else{

  $query_insert ="INSERT INTO  incidencia(          
                 descripcion_incidencia,                                   
                 usuario_notificado   , 
                 afectacion            ,
                 fecha_solicitud       ,
                 idtipo_incidencia     ,
                 idsub_tipo_incidencia
                )VALUES(

                  '". $data["descripcion"]  ."',
                  '". $data["usuario_reportado"]."' ,
                  '". $data["afectacion"] ."',
                  '". $data["fecha-reporte"]."', 
                  '". $data["tipo-incidencia"] ."', 
                  '". $data["sub-tipo"] ."'
                )";


    }
    return $this->db->query( $query_insert);
                

      
}

/**/
function get_reportados($id_empresa){
  $query_get =  "select * from usuario where idempresa = '". $id_empresa . "' ";
  $result=  $this->db->query($query_get);             
  return $result->result_array();
}

/**/

function get_sub_tipo_incidencia($id_empresa , $data ){

  $query_get =  "select * from sub_tipo_incidencia where idtipo_incidencia  = '". $data["tipo_incidencia"]  ."' ";
  $result=  $this->db->query($query_get);             
  return $result->result_array();
}
/**/
function get_tipos_incidencias($id_empresa){

  $query_get ="select * from empresa_tipo_incidencia eti inner join tipo_incidencia  
              t on eti.idtipo_incidencia =  t.idtipo_incidencia where eti.id_empresa =  '". $id_empresa."' ";
  $result=  $this->db->query($query_get);             
  return $result->result_array();
}

/**/

function get_contactos_empresanum($id_empresa){

    $query_get =  "select count(*)total from empresa_contacto where id_empresa = '". $id_empresa."' ";
    $result =  $this->db->query($query_get);
    return $result->result_array()[0]["total"];
}

/**/
function update_contacto_empresa($id_empresa , $param ){

  $query_exist ="select count(*)total  from  empresa_contacto where id_empresa = '". $id_empresa ."' and id_contacto = '". $param["contacto"] ."' ";
  $result = $this->db->query($query_exist);
  $result_exist = $result ->result_array()[0]["total"];
  $dinamic_query ="";  

  if ($result_exist >0 ) {
    $dinamic_query ="DELETE FROM empresa_contacto WHERE id_empresa = '". $id_empresa ."' and id_contacto = '". $param["contacto"] ."' ";
  }else{
    $dinamic_query = "INSERT INTO empresa_contacto VALUES('". $id_empresa ."' , '". $param["contacto"] ."')";
  }
  return $this->db->query($dinamic_query);
}



/**/
function get_contactos_empresa($id_empresa , $id_usuario ){

$query_get ="select c.* , 
empresa_contacto.id_contacto contactoemp , 
ic.* ,
i.* from contacto c left outer 
join  empresa_contacto 
on c.idcontacto =  empresa_contacto.id_contacto  and 
empresa_contacto.id_empresa = '". $id_empresa."'
left outer join imagen_contacto ic 
on ic.id_contacto = c.idcontacto
left outer join imagen i on
ic.id_imagen  =  i.idimagen
where idusuario=". $id_usuario;
    
$result = $this->db->query($query_get);
return $result->result_array();      
  
}  
/**/
function get_empresa($id_empresa ){
  $query_get ="select *  from empresa  e where e.idempresa  =  '". $id_empresa."'  ";
  $result=  $this->db->query($query_get);
  return $result->result_array();  
}
/**/
function get_empresa_by_id($id_empresa){

  /*
  $query_get ="select  e.* , c.*,  i.*  from empresa e 
              inner join  countries c  
              on e.idCountry  =  c.idCountry  
              left outer join  imagen_empresa  ie 
              on ie.id_empresa  = '". $id_empresa ."'  
              left outer join
              imagen i 
              on i.idimagen =  ie.id_imagen  and type ='3'
              where e.idempresa  =  '". $id_empresa."'  ";

  */
              $query_get ="select  e.* , c.*  from empresa e 
              inner join  countries c  
              on e.idCountry  =  c.idCountry               
              where e.idempresa  =  '". $id_empresa."'  ";

  $result=  $this->db->query($query_get);
  return $result->result_array(); 
}
/**/
function exist_company_byname( $nombreempresa ){
    $query_exist = "SELECT * FROM empresa WHERE nombreempresa = '".$nombreempresa."' LIMIT 1";     
    $result = $this->db->query($query_exist);                   
    $flag = 0;     
     foreach ($result->result_array() as  $row) {            
          $flag++;
      }     
    return $flag;

}
/*Termina la función */
function get_nombre_empresa($param){

    $query_get =  "SELECT  nombreempresa FROM empresa WHERE idempresa  ='".$param["id_empresa"]."' LIMIT 1"; 
    
    $result =  $this->db->query($query_get);
    return $result->result_array();
    
    
}
/**/
function recordempresawhitname( $nombreempresa ){


    $query_insert = "INSERT INTO empresa(nombreempresa , idCountry ) VALUES ('".$nombreempresa."'  , 15)";
    $tryrecord = $this->db->query($query_insert); 
    /*Si se registro*/
    if ( $tryrecord   ==  true ) {  
    $query_lastelemento  = "SELECT MAX(idempresa) AS idempresa FROM empresa";
    $resultlastelemento  = $this->db->query($query_lastelemento); 

        $ultimo = 0;
        /*Ultimo elemento ingresado */
        foreach ($resultlastelemento ->result_array() as $row) {
         
           $ultimo = $row["idempresa"];
        }
        
        return $ultimo;


    }else{
      return "Fallo algo al registrar empresa";
    }


    
}/*Termina la función */

function get_paices($id_empresa ){

  $query_get ="select c.* , e.nombreempresa  from  countries c left outer join empresa e on c.idCountry =  e.idCountry and  e.idempresa = '". $id_empresa ."' ";
  $result = $this->db->query($query_get);
  return $result ->result_array();
}
/**/

function update_country_empresa($id_empresa, $data){

  $query_update ="update empresa set idCountry = '". $data["country"]."' where idempresa ='".$id_empresa."'  "; 
  $result = $this->db->query($query_update);
  return $result;
  
}
/**/

function insert_experiencia($param){

  

  $nombre_cliente = "";  
  $id_empresa =  $param["emp"]; 
  $nombre_cliente = $param["nombre_cliente"];
  $email_cliente =  $param["email_cliente"];
  $tel_cliente = $param["tel_cliente"]; 
  $calificacion =  $param["calificacion_cliente"]; 
  $descripcion = $param["descripcion"];
  


  $query_insert ="INSERT INTO  empresa_experiencia(
                  idempresa,                        
                  calificacion,
                  nombre,
                  mail,          
                  tel, 
                  descripcion) 
          VALUES( 

              '$id_empresa' , 
              '$calificacion',
             '". $nombre_cliente."'  ,               
             '".$email_cliente."' ,               
             '".$tel_cliente ."' ,             
             '".$descripcion."'  )";
  return $this->db->query($query_insert);

}
/**/
function insert_solicidud_artista($param){
  return $param;
}
/**/
function get_cidades(){
    $query_get ="SELECT * FROM  countries";
    $result = $this->db->query($query_get);
    return $result->result_array();
}
/**/
function get_historias_clientes($param){  


  /*
    $id_empresa =  $param["empresa"];  
    $_num =  $this->dinamic_data_comentarios($id_empresa , 0  , 0  );
    
    
    $query_get = "select  
                  a.* , 
                  b.nombre_contenido , 
                  b.descripcion_contenido , 
                  b.status , 
                  b.type  
                  from  tmp_empresa_experiencia_$_num   a  
                  left outer join tmp_contenido_$_num  
                  b on  a.idcontenido =  b.idcontenido order by  fecha_registro desc"; 

    $result =  $this->db->query($query_get);
    $data_complete =  $result->result_array();
    
    $_num =  $this->dinamic_data_comentarios($id_empresa , 1  , $_num);    
    return $data_complete;
    */


}
/**/
function dinamic_data_comentarios($id_empresa , $f = 0 , $_num = 0   ){

    if($_num == 0 ) {
      $_num = mt_rand();       
    }    
    $query_procedure ="call experiencia_publico( $id_empresa , $_num  , $f );";    
    $this->db->query($query_procedure);
    return $_num;
}
/**/
function get_experiencias($param){
  
  

  $_num =  get_random(); 
  $f =  $this->create_tmp_experiencias(0 , $_num, $param["id_empresa"] ,  $param);
  $query_get =  "SELECT * FROM  tmp_experiencias_e_$_num";
  $result =  $this->db->query($query_get);
  $data["experiencias"] =  $result->result_array();
  $this->create_tmp_experiencias(1 , $_num, $param["id_empresa"] ,  $param);
  return $data;
}
function create_tmp_experiencias($flag , $_num ,  $id_empresa ,  $param){

  $tramo =  " AND  status = 1 ";
  if ($param["in_session"] ==  1 && $param["config"] ==  1  ) {
    $tramo =  "";
  }



  $query_drop ="DROP TABLE IF exists tmp_experiencias_e_$_num";
  $this->db->query($query_drop);
  $query_create  = "";
  $db_response =0;   
  
  if ($flag == 0 ){      
      $query_create = "CREATE TABLE tmp_experiencias_e_$_num AS 
                      SELECT * FROM  empresa_experiencia WHERE  idempresa = '$id_empresa' ". $tramo  ."
                      ORDER BY  fecha_registro DESC LIMIT 50";
      $db_response =  $this->db->query($query_create);

  } 
  return $db_response;  
}
/**/

function get_actividad($param){
  $_num =  get_random();
  $this->create_tmps_actividad_e($_num ,  0 , $param);
  $query_get =  "SELECT * FROM log_e_$_num ORDER BY  fecha_registro desc"; 
  $result =  $this->db->query($query_get);
  $data_complete =  $result ->result_array();
  $this->create_tmps_actividad_e($_num ,  1 , $param);
  return $data_complete;
}
/**/
function create_tmps_actividad_e($_num,  $flag , $param ){
    $f = "";
    if ($param["tipo_actividad"] ==  "eventos"){

      $f =  $this->create_tmp_user_e($_num,  $flag , $param); 
      $f =  $this->create_tmp_movimientos_users( $_num , $flag  ,  $param );
      $f = $this->create_tmp_logs( $_num , $flag  ,  $param );   
    }else{

      $f =  $this->create_tmp_user_e($_num,  $flag , $param); 
      $f =  $this->create_tmp_movimientos_users( $_num , $flag  ,  $param );
      $f = $this->create_tmp_logs( $_num , $flag  ,  $param );   
    }

   
  return $f;
}
/*creamos tmp para usuarios*/
function create_tmp_user_e($_num,  $flag , $param){
  $query_drop =  "DROP TABLE IF exists usuario_emp_e_$_num";
  $db_response =  $this->db->query($query_drop);
  $id_empresa =  $param["id_empresa"];  
    
  if ($flag == 0 ){
      $query_create = "CREATE TABLE  
                      usuario_emp_e_$_num AS 
                      SELECT
                      idusuario , 
                      nombre  ,
                      email,
                      puesto,
                      cargo
                      FROM  usuario 
                      WHERE idempresa = $id_empresa"; 
      $db_response = $this->db->query($query_create);                

    }
  return $db_response;  
    
}
/**/
function create_tmp_movimientos_users( $_num , $flag  ,  $param ){
  
  $query_drop =  "DROP TABLE IF exists usuario_log_complete_e_$_num";
  $db_response =  $this->db->query($query_drop);

  $query_drop =  "DROP TABLE IF exists usuario_log_e_$_num";
  $db_response =  $this->db->query($query_drop);
  
  if ($flag == 0 ) {

    /*operamos sobre la tabla completa*/
    $query_create =  "CREATE TABLE  usuario_log_complete_e_$_num AS 
                      SELECT *  FROM  usuario_log l WHERE  DATE(fecha_registro) 
                      BETWEEN  DATE_ADD(CURRENT_DATE() , INTERVAL -15 DAY )  
                      AND  CURRENT_DATE()"; 
    
    $this->db->query($query_create);                  
            /*Operamos sobre lo del periodo*/
            $query_create =  "CREATE TABLE  
                              usuario_log_e_$_num AS 
                              SELECT *  FROM  usuario_log_complete_e_$_num l 
                              INNER JOIN usuario_emp_e_$_num u 
                              ON l.id_usuario =  u.idusuario"; 
              $db_response = $this->db->query($query_create);                
  }
  
  return $db_response;  
}
/**/
function create_tmp_logs( $_num , $flag  ,  $param ){
  
  
  $query_drop =  "DROP TABLE IF exists log_complete_e_$_num";
  $db_response =  $this->db->query($query_drop);  
  $query_drop =  "DROP TABLE IF exists log_e_$_num";
  $db_response =  $this->db->query($query_drop);


  if ($flag == 0 ){    
    $query_create =  "CREATE TABLE log_complete_e_$_num AS 
                      SELECT
                      id_log id_logf,
                      modulo ,
                      tipo_evento  ,
                      descripcion,
                      id_modulo
                      FROM log 
                      WHERE  DATE(fecha_registro) 
                      BETWEEN  DATE_ADD(CURRENT_DATE() , INTERVAL -15 DAY )  
                      AND  CURRENT_DATE()";
    $db_response = $this->db->query($query_create);                

    /**/
    $query_create =  "CREATE TABLE log_e_$_num AS 
    SELECT  u.* , 
            l.modulo,             
            l.tipo_evento,
            l.descripcion,
            l.id_modulo  
            FROM  usuario_log_e_$_num u 
    INNER JOIN log_complete_e_$_num l
    ON 
    u.id_log = l.id_logf";

    $db_response = $this->db->query($query_create);                    
  }
  return $db_response;
}
/**/
/*Termina modelo */
}
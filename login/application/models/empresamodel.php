<?php defined('BASEPATH') OR exit('No direct script access allowed');
class empresamodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
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

  
  function create_account($param){


      $query_insert = "INSERT INTO empresa(
                          nombreempresa ,
                          acepta_uso_privacidad , 
                          text_uso_privacidad  , 
                          idCountry
                          ) 
                       VALUES 
                       ('".$param["organizacion"]."' ,
                        '".$param["privacidad_condiciones"]."' , 
                        'He leído y  acepto las condiciones de uso y privacidad para hacer uso del sistema Enid Service.' 
                        , 1 
                        )";    

      $this->db->query($query_insert);
      $id_empresa  = $this->db->insert_id();              
      
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
      
      return $this->create_config_inicial($id_empresa , $id_user );
  }  
  
  
  function create_config_inicial($id_empresa , $id_user ){

    $query_inser ="INSERT INTO  usuario_perfil(idusuario, idperfil ) VALUES('". $id_user  ."' , '4' )";    
    $result = $this->db->query($query_inser);     

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

/**/
function get_empresa($id_empresa ){
  $query_get ="select *  from empresa  e where e.idempresa  =  '". $id_empresa."'  ";
  $result=  $this->db->query($query_get);
  return $result->result_array();  
}
/**/
function get_empresa_by_id($id_empresa){


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
function get_cidades(){
    $query_get ="SELECT * FROM  countries";
    $result = $this->db->query($query_get);
    return $result->result_array();
}
/*creamos tmp para usuarios*/


/*Termina modelo */
}
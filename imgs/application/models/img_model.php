<?php defined('BASEPATH') OR exit('No direct script access allowed');
class img_model extends CI_Model {  
/**/
function __construct(){
      parent::__construct();        
      $this->load->database();
}
/**/
function get_imagenes_por_servicio($param){

  $id_servicio =  $param["id_servicio"];        
  $query_get = "SELECT id_imagen 
                FROM   
                  imagen_servicio 
                WHERE 
                  id_servicio = '".$id_servicio."' LIMIT 10";      
                  
  $result =  $this->db->query($query_get);
  return $result->result_array();

}
/**/
function delete_imagen_servicio($param){
  
  /**/
  $id_imagen =   $param["id_imagen"];  
  $query_delete = "DELETE FROM  imagen_servicio WHERE id_imagen = '".$id_imagen."' LIMIT 5";
  $result =  $this->db->query($query_delete);
  /**/
  return  $this->elimina_imagen($id_imagen);
  /**/
}
/**/
function elimina_imagen($id_imagen){
  /**/
  $query_delete =  "DELETE FROM  imagen WHERE idimagen = '".$id_imagen."'";  
  $result =  $this->db->query($query_delete);
  return $result;
}
/**/
function get_img_faq($id_faq){

  $query_get =  "select  id_imagen from imagen_faq WHERE id_faq =$id_faq LIMIT 1";    
  $result = $this->db->query($query_get);
  $imagen_faq =  $result->result_array();
  
    if (count($imagen_faq) > 0 ) {
        $id_imagen = $imagen_faq[0]["id_imagen"];      
        $query_get =  "SELECT  * FROM imagen WHERE idimagen =  $id_imagen LIMIT 1;";
        $result  =  $this->db->query($query_get);
        return $result->result_array();
    }else{
        $query_get =  "SELECT  * FROM imagen WHERE idimagen = 1 LIMIT 1;";
        $result  =  $this->db->query($query_get);
        return $result->result_array();
    } 
}
/**/
function elimina_pre_img_faq($param){

    $id_faq = $param["dinamic_img_faq"];    
    /**/
    $query_get ="SELECT 
                  id_imagen ,
                  id_faq   
                 FROM 
                 imagen_faq
                WHERE  id_faq  = '". $id_faq ."' LIMIT 10";
    $result =  $this->db->query($query_get);
    $imagen  = $result->result_array();
    
    
    foreach ($imagen as $row){      

        $id_imagen =  $row["id_imagen"];    
        $query_delete ="DELETE FROM imagen_faq WHERE  id_faq  = '". $id_faq ."' LIMIT 1";              
        $this->db->query($query_delete); 
        $this->elimina_img($id_imagen);

    }  
      
      
    
    
}
/**/
function insert_img_faq($prm ){
    
    $this->elimina_pre_img_faq($prm);
    $id_faq = $prm["dinamic_img_faq"];    
    $id_usuario =  $prm["id_usuario"];
    $id_empresa = $prm["id_empresa"];

    /*consulta si existe*/        
    $id_imagen = $this->insert_img($prm , 1  );  
    
    /**/  
    $query_insert ="INSERT INTO
                          imagen_faq(  
                            id_imagen , 
                            id_faq 
                          )VALUES(
                              '". $id_imagen."' , 
                              '". $id_faq ."'                       
                          )";          
    return $this->db->query($query_insert);            
    
}
/**/
function insert_img($param , $type=0 ){    
           
          $id_usuario =  $param["id_usuario"]; 
          $id_empresa =  $param["id_empresa"]; 
           $query_insert ="INSERT 
                            INTO 
                            imagen(
                              nombre_imagen , 
                              type ,                       
                              id_usuario  ,  
                              id_empresa, 
                              img, 
                              extension
                            ) VALUES (
                              '". $param["nombre_archivo"] ."' , 
                              ".  $type ." ,                       
                              '". $id_usuario."' , 
                              '". $id_empresa."' ,
                              '". $param["imagenBinaria"]."' ,
                              '". $param["extension"]."' 
                            )";    

     $result =  $this->db->query($query_insert);
     return $this->db->insert_id();                   
  }  
  /**/
  function insert_imgen_usuario($param){

    $this->elimina_pre_img_usuario($param);
    
    
    $id_usuario =  $param["id_usuario"];
    $id_empresa = $param["id_empresa"];
    $id_imagen = $this->insert_img($param , 1  );  
    
    
    $query_insert ="INSERT INTO imagen_usuario(  
                            id_imagen , 
                            idusuario 
                          )VALUES(
                              '". $id_imagen."' , 
                              '". $id_usuario ."' )";          
    return $this->db->query($query_insert);            
   
    

  }
  function elimina_pre_img_usuario($param){

    $id_usuario =  $param["id_usuario"];    
    $query_get ="SELECT 
                  id_imagen
                 FROM 
                 imagen_usuario
                WHERE  
                idusuario  
                = '". $id_usuario ."'
                 LIMIT 10";
                 
    $result =  $this->db->query($query_get);
    
    $imagen  = $result->result_array();

    foreach ($imagen as $row){
     
      $id_imagen=  $row["id_imagen"];      

      $query_delete ="DELETE FROM imagen_usuario WHERE  idusuario  = '". $id_usuario ."' LIMIT 1";
      $this->db->query($query_delete); 
      $this->elimina_img($id_imagen);
    }
    
    
}
/**/
function elimina_img($id_imagen){
    $query_delete ="DELETE FROM imagen WHERE  idimagen  = '". $id_imagen ."' LIMIT 1";              
    $this->db->query($query_delete);
}
/*Solo gets*/
function get_img_usuario($id_usuario){

  $query_get =  "select  id_imagen from imagen_usuario WHERE idusuario =$id_usuario LIMIT 1";    
  $result = $this->db->query($query_get);
  $imagen_faq =  $result->result_array();
  
    if (count($imagen_faq) > 0 ) {
        $id_imagen = $imagen_faq[0]["id_imagen"];      
        $query_get =  "SELECT  * FROM imagen WHERE idimagen =  $id_imagen LIMIT 1;";
        $result  =  $this->db->query($query_get);
        return $result->result_array();
    }else{
        $query_get =  "SELECT  * FROM imagen WHERE idimagen = 1 LIMIT 1;";
        $result  =  $this->db->query($query_get);
        return $result->result_array();
    } 
}
/**/
function get_img($id_imagen){

  $query_get = "SELECT img FROM imagen WHERE idimagen = '".$id_imagen."' LIMIT 1";
  $result  =  $this->db->query($query_get);
  return $result->result_array();
}
/**/
function get_img_servicio($id_servicio){

  /**/
  $query_get ="SELECT id_imagen FROM imagen_servicio 
              WHERE 
              id_servicio = '".$id_servicio."' LIMIT 1";
  $result  =  $this->db->query($query_get);
  return $result->result_array();

}
/**/
function insert_imgen_servicio($param){
    
    /**/
    $this->notifica_producto_imagen($param);    
    
    $id_servicio = $param["servicio"];
    $id_imagen = $this->insert_img($param , 1  );          
    $query_insert ="INSERT INTO imagen_servicio(  
                            id_imagen  ,
                            id_servicio
                          )VALUES(
                              '". $id_imagen."' , 
                              '". $id_servicio ."' )";          
    return $this->db->query($query_insert);            
    
}
/**/
function notifica_producto_imagen($param){
  
  $id_servicio =  $param["servicio"];
  $query_update = "UPDATE servicio SET 
                    flag_imagen =  1
                  WHERE id_servicio =  $id_servicio 
                  LIMIT 1";
    return $this->db->query($query_update);  
}
/**/
}
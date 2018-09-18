<?php defined('BASEPATH') OR exit('No direct script access allowed');
class img_model extends CI_Model {  
  function __construct(){
        parent::__construct();        
        $this->load->database();
  }
  private function insert($tabla ='imagen', $params , $return_id=0){        
    $insert   = $this->db->insert($tabla, $params);     
    return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
  private function get($table='imagen' , $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get($table)->result_array();
  }
 
  function delete($table ='imagen' , $params_where = [] , $limit = 1){

    $this->db->limit($limit);
    //where($key, $value = NULL, $escape = NULL);
    return $this->db->delete($table,  $params_where);
  }
  function get_img_servicio($id_servicio){
    
    return $this->get('imagen_servicio', ["id_imagen"] , ["id_servicio" => $id_servicio ] );
  }
  /**/
  function elimina_img($id_imagen){
    $query_delete ="DELETE FROM imagen WHERE  
    idimagen  = '". $id_imagen ."' LIMIT 1";              
    $this->db->query($query_delete);
  }
  /**/
  function elimina_pre_img_usuario($param){

    $id_usuario =  $param["id_usuario"];  
    $imagen = $this->get_img_usuario($id_usuario);  
    foreach ($imagen as $row){
      $id_imagen=  $row["id_imagen"];      
      $query_delete ="DELETE FROM imagen_usuario WHERE  idusuario  = '". $id_usuario ."' LIMIT 1";
      $this->db->query($query_delete); 
      $this->elimina_img($id_imagen);
    }
    
  }
  
  function insert_imgen_usuario($param){

    $this->elimina_pre_img_usuario($param);    
    $id_usuario =  $param["id_usuario"];
    $id_empresa = $param["id_empresa"];
    $id_imagen = $this->insert_img($param , 1);  
    $params   = ["id_imagen" => $id_imagen,"idusuario" => $id_usuario];    
    return $this->insert("imagen_usuario" , $params);
  }
  function insert_img($param , $type=0 ){    

    $id_usuario =  $param["id_usuario"];     
    $id_empresa =  $param["id_empresa"]; 

    $values     =   [ "nombre_imagen" ,
                      "type"          ,
                      "id_usuario"    ,
                      "id_empresa"    ,
                      "img"           ,
                      "extension" 
                    ];

    $keys =  implode(",", $values);

    
    $query_insert =   "INSERT INTO imagen(
                              ".$keys."
                            ) VALUES (
                                '". $param["nombre_archivo"] ."' , 
                                ".  $type ." ,                       
                                '". $id_usuario."' , 
                                '". $id_empresa."' ,
                                '". $param["imagenBinaria"]."' ,
                                '". $param["extension"]."' 
                            )";    
    
    $this->db->query($query_insert);
    return     $this->db->insert_id();     
  }  
  
  function get_img_usuario($id_usuario){

    return 
    $this->get('imagen_usuario', ["id_imagen"] , ["idusuario" => $id_usuario ] ); 
  }
  function get_img($id_imagen){

    return $this->get("imagen" , ["img"] , [ "idimagen" => $id_imagen]);

  }
  function insert_imgen_servicio($param){
              
    $id_servicio  = $param["servicio"];
    $id_imagen    = $this->insert_img($param , 1 );          
    $params       = [ "id_imagen"   =>  $id_imagen , "id_servicio" =>  $id_servicio];
    return  $this->insert("imagen_servicio" ,  $params , 1);
    
}
function get_imagenes_por_servicio($param){
  $id_servicio   =  $param["id_servicio"];
  return $this->get('imagen_servicio', ["id_imagen"] , ["id_servicio" => $id_servicio ] , 10);
}
function delete_imagen_servicio($param){
    
  $id_imagen =   $param["id_imagen"];  
  $query_delete = "DELETE FROM  imagen_servicio WHERE id_imagen = '".$id_imagen."' LIMIT 5";
  $result =  $this->db->query($query_delete); 
  return  $this->elimina_imagen($id_imagen);
  
}

/*

function elimina_imagen($id_imagen){
  
  $query_delete =  "DELETE FROM  imagen WHERE idimagen = '".$id_imagen."'";  
  $result =  $this->db->query($query_delete);
  return $result;
}

function get_img_faq($id_faq){

  $query_get =  "select  id_imagen from imagen_faq WHERE id_faq =$id_faq LIMIT 1";
  $result = $this->db->query($query_get);
  return $result->result_array();
}

function elimina_pre_img_faq($param){

    $id_faq = $param["dinamic_img_faq"];    
    
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

function insert_img_faq($prm ){
    
    $this->elimina_pre_img_faq($prm);
    $id_faq = $prm["dinamic_img_faq"];    
    $id_usuario =  $prm["id_usuario"];
    $id_empresa = $prm["id_empresa"];

    
    $id_imagen = $this->insert_img($prm , 1  );  
    
    
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



*/
}
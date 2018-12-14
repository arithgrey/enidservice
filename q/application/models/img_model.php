<?php defined('BASEPATH') OR exit('No direct script access allowed');
class img_model extends CI_Model {  
  function __construct(){
        parent::__construct();        
        $this->load->database();
  }
  function q_get($params=[], $id){
    return $this->get($params, ["idimagen" => $id ] );
  } 
  function delete($params_where =[] , $limit =1){              
    $this->db->limit($limit);        
    foreach ($params_where as $key => $value) {
      $this->db->where($key , $value);
    }        
    return  $this->db->delete("imagen", $params_where);
  }
  private function insert($params , $return_id=0){        
    $insert   = $this->db->insert("imagen", $params);     
    return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
  private function get( $params=[], $params_where =[] , $limit =1 , $order = '', $type_order='DESC'){
    $params = implode(",", $params);
    $this->db->limit($limit);
    $this->db->select($params);
    foreach ($params_where as $key => $value) {
        $this->db->where($key , $value);
    }
    if($order !=  ''){
          $this->db->order_by($order, $type_order);  
    }       
    return $this->db->get("imagen")->result_array();
  }
  /**/
  function elimina_img($id_imagen){
    $query_delete ="DELETE FROM imagen WHERE  idimagen  = '". $id_imagen ."' LIMIT 1";              
    $this->db->query($query_delete);
  }
  /**/
  function insert_img($param , $type=0 ){    

    $values     =   [ "nombre_imagen" ,
                      "type"          ,
                      "id_usuario"    ,
                      "id_empresa"    ,
                      "img"           ,
                      "extension" 
                    ];
    
    $val = implode(",", $values);
    $query_insert = 
            "INSERT INTO imagen(".$val.") VALUES (
                '". $param["nombre_archivo"] ."' , 
                ".  $type ." ,                       
                '". $param["id_usuario"] ."' , 
                '". $param["id_empresa"] ."' ,
                '". $param["imagenBinaria"]."' ,
                '". $param["extension"]."' 
              )";    
    
    $this->db->query($query_insert);
    return $this->db->insert_id();     
  }

    function get_img_faq($id_faq){

        $query_get =  "select  id_imagen from imagen_faq WHERE id_faq =$id_faq LIMIT 1";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }

    /*
    function get_img($id_imagen){
      return $this->get(["img"] , [ "idimagen" => $id_imagen]);
    }
    function insert_imgen_servicio($param){

      $id_servicio  = $param["servicio"];
      $id_imagen    = $this->insert_img($param , 1 );
      $params       = [ "id_imagen"   =>  $id_imagen , "id_servicio" =>  $id_servicio];
      return  $this->insert("imagen_servicio" ,  $params , 1);
  }
  */


/*

function elimina_imagen($id_imagen){
  
  $query_delete =  "DELETE FROM  imagen WHERE idimagen = '".$id_imagen."'";  
  $result =  $this->db->query($query_delete);
  return $result;
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
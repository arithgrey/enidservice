<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class faqsmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_categorias_por_tipo($id_tipo_categoria){
            
            $query_get = "SELECT 
                            c.id_categoria, 
                            c.nombre_categoria,
                            count(f.id_faq)faqs
                        FROM categoria  c  
                        LEFT OUTER JOIN faq f  
                        ON  c.id_categoria =  f.id_categoria 
                        WHERE                         
                            c.idtipo_categoria = '".$id_tipo_categoria."' 
                        GROUP BY 
                        c.id_categoria";
            $result =  $this->db->query($query_get);                            
            return $result->result_array();

    }
    /**/
    function registra_respuesta($param){


        
        $editar_respuesta = $param["editar_respuesta"];
        $id_faq = $param["id_faq"]; 
        $respuesta = $param["respuesta"];
        $categoria =  $param["categoria"];
        $titulo =  $param["titulo"];
        $status = $param["status"];
        $id_usuario =  $param["id_usuario"];
        
        if ($editar_respuesta ==  0) {            
                        
                        $query_insert = "INSERT INTO faq(
                            titulo , 
                            respuesta , 
                            id_categoria, 
                            status, 
                            id_usuario )
                        VALUES(
                            
                            '".$titulo."' ,
                            '".$respuesta."',  
                            '".$categoria."',
                            '".$status."' , 
                            '".$id_usuario."')";

                        $this->db->query($query_insert);
                        return $this->db->insert_id();
        }else{

                        $query_edit = "UPDATE  
                                faq
                            SET 
                                titulo = '".$titulo."' ,
                                respuesta = '".$respuesta."',  
                                id_categoria = '".$categoria."',
                                status = '".$status."'
                                WHERE id_faq = '".$id_faq."'";

                        $this->db->query($query_edit);
                        return $id_faq;
        }    
        
    }
    /**/
    function get_respuesta($param){

        $id_faq =  $param["id_faq"];
        $query_get = "SELECT * FROM faq 
                      WHERE id_faq = $id_faq                      
                      LIMIT 1";

        
        $result =  $this->db->query($query_get);
        return $result->result_array();
        
    }
    /**/
    
    
}
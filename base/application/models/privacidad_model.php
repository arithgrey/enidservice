<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class privacidad_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function asociar_concepto_privacidad_usuario($param){

        $id_privacidad =  $param["concepto"];
        $id_usuario =  $param["id_usuario"];
        $query ="DELETE FROM privacidad_usuario WHERE 
                        id_privacidad = $id_privacidad
                    AND 
                        id_usuario = $id_usuario 
                    LIMIT 1";
        if($param["termino_asociado"] == 0){

            
            $query ="INSERT INTO privacidad_usuario(id_privacidad , id_usuario) 
                    VALUES($id_privacidad , $id_usuario) ";
        }
        return $this->db->query($query);
    }
    /**/
    function get_conceptos_usuario($param){

        $query_get =  "SELECT * FROM funcionalidad";
        $result =  $this->db->query($query_get);
        $funcionalidades =  $result->result_array();
        $id_usuario=  $param["id_usuario"]; 
        return $this->add_conceptos($funcionalidades , $id_usuario);
    }
    /**/
    function add_conceptos($funcionalidades , $id_usuario){

        $data_complete =[];
        $a =0;
        foreach($funcionalidades as $row){

            $data_complete[$a] =  $row;
            $id_funcionalidad =  $row["id_funcionalidad"];
            $data_complete[$a]["conceptos"] =  
                $this->get_conceptos_por_funcionalidad_usuario($id_funcionalidad , $id_usuario);
            $a ++;
        }
        return $data_complete;
    }
    /**/
    private function get_conceptos_por_funcionalidad_usuario($id_funcionalidad , $id_usuario){

        $query_get = "SELECT 
                        p.id_privacidad, 
                        p.privacidad ,
                        pu.id_usuario
                        FROM 
                            privacidad  p 
                        LEFT OUTER JOIN privacidad_usuario pu
                            ON
                            p.id_privacidad =  pu.id_privacidad
                            AND 
                            pu.id_usuario = $id_usuario
                        WHERE 
                        p.id_funcionalidad =  $id_funcionalidad
                        ORDER BY id_privacidad";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }


    
    
}
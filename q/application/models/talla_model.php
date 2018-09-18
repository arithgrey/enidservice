<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class talla_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
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
    function insert($tabla ='imagen', $params , $return_id=0){        
        $insert   = $this->db->insert($tabla, $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function q_get($params=[], $id){
        return $this->get("talla", $params, ["id_servicio" => $id ] );
    }
    /**/
    function get_tipo_talla($param){
        $id             = $param["id"];
        return $this->get('tipo_talla' , [] , ["id" => $id] );
    }
    
    function update_talla_clasificacion($param){

        $id                     =   $param["id"];
        $clasificaciones        =   $param["clasificaciones"];
        $params                 = [ "clasificacion" =>  $clasificaciones ];
        return $this->update('tipo_talla' , $params , ["id" => $id ] );    
    }
    function get_tallas_clasificacion($param=''){
        return $this->get('tipo_talla' , ["id" , "tipo" , "clasificacion"] , [] , 10 );
    } 
    function get_tallas_countries($param){

        $id_tipo_talla  =   $param["id_tipo_talla"];
        $campos         =   array("t.id_talla" , "t.talla" , "c.prefijo");
        $fields         =   add_fields($campos);
        $query_get      =   "SELECT ".$fields." FROM 
                            talla t  
                            INNER JOIN countries c 
                            ON 
                            c.idCountry =  t.id_country
                            WHERE 
                            id_tipo_talla = $id_tipo_talla 
                            LIMIT 20";
        return          $this->db->query($query_get)->result_array();
        
    }
    
}
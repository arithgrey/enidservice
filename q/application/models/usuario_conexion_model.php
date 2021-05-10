<?php defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_conexion_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'usuario_conexion';
    }

    function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
    {

        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        if ($order != '') {
            $this->db->order_by($order, $type_order);
        }
        return $this->db->get($this->tabla)->result_array();
    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id" => $id]);
    }

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->tabla, $data);
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert($this->tabla, $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function sugerencias($id_seguidor)
    {

        $query_get = "SELECT 
                    u.nombre , 
                    u.apellido_paterno, 
                    u.apellido_materno , 
                    u.idusuario,
                    DATE(u.fecha_registro) fecha_registro 
                    FROM usuario_perfil up 
                    INNER JOIN
                    usuario u 
                    ON 
                    u.idusuario = up.idusuario
                    WHERE 
                    u.idusuario != $id_seguidor 
                    AND
                    up.idperfil IN (3,6) 
                    AND  
                    u.ha_vendido > 0
                    AND 
                    u.status = 1                     
                    AND  
                    u.idusuario NOT IN (SELECT id_usuario FROM usuario_conexion WHERE id_seguidor = $id_seguidor )                    
                    LIMIT 6";

        return $this->db->query($query_get)->result_array();

    }

    function seguidores($id_usuario)
    {

        $query_get = "SELECT 
       uc.*,        
       u.nombre, 
       u.apellido_paterno,
       u.apellido_materno       
    FROM usuario_conexion uc      
    INNER JOIN usuario u ON u.idusuario = uc.id_seguidor 
    WHERE uc.id_usuario =  $id_usuario 
    AND uc.status > 0";

        return $this->db->query($query_get)->result_array();

    }

    function seguimiento($id_usuario)
    {

        $query_get = "SELECT
       uc.*,
       u.nombre,
       u.apellido_paterno,
       u.apellido_materno
    FROM usuario_conexion uc
    INNER JOIN usuario u ON u.idusuario = uc.id_usuario
    WHERE uc.id_seguidor =  $id_usuario
    AND uc.status > 0    ";

        return $this->db->query($query_get)->result_array();

    }


    function ranking($id_seguidor)
    {

        $query_get = "SELECT 
       uc.*, 
       SUM(p.num_ciclos_contratados)ventas,
       u.nombre, 
       u.apellido_paterno,
       u.apellido_materno       
    FROM usuario_conexion uc 
    INNER JOIN proyecto_persona_forma_pago p
ON uc.id_usuario = p.id_usuario_referencia 
    INNER JOIN usuario u ON u.idusuario = uc.id_usuario 
WHERE uc.id_seguidor =  $id_seguidor 
  AND uc.status > 0
AND p.status NOT IN ( 10, 19 ) 
  AND p.se_cancela < 1 AND p.cancela_cliente < 1                     
AND p.cancela_email < 1 AND p.cancela_cliente < 1 AND p.se_cancela < 1 AND p.saldo_cubierto > 0
GROUP BY uc.id_usuario";

        return $this->db->query($query_get)->result_array();

    }

    function total_seguidor($id_seguidor)
    {

        $query_get = "SELECT  
       SUM(p.num_ciclos_contratados)ventas,
       u.nombre, 
       u.apellido_paterno,
       u.apellido_materno 
FROM  proyecto_persona_forma_pago p  
INNER JOIN usuario u ON u.idusuario = p.id_usuario 
 WHERE  
 p.id_usuario_referencia = $id_seguidor
AND p.status NOT IN ( 10, 19 ) 
  AND p.se_cancela < 1 AND p.cancela_cliente < 1                     
AND p.cancela_email < 1 AND p.cancela_cliente < 1 
   AND p.se_cancela < 1 AND p.saldo_cubierto > 0";

        return $this->db->query($query_get)->result_array();

    }


}

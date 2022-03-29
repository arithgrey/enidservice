<?php defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_perfil_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete("usuario_perfil", $params_where);
    }

    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert("usuario_perfil", $params);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
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
        return $this->db->get("usuario_perfil")->result_array();
    }

    function get_es_cliente($id_usuario)
    {
        $params_where = ["idusuario" => $id_usuario, "idperfil" => 20];
        return $this->get(["count(0)num_cliente"], $params_where)[0]["num_cliente"];
    }

    function get_perfil_usuario($param)
    {
        $id_usuario = $param["id_usuario"];
        return $this->get(["idperfil"], ["idusuario" => $id_usuario])[0]["idperfil"];
    }

    function comisionistas()
    {
        $query_get = 'SELECT 
                        u.name , 
                        u.apellido_paterno, 
                        u.apellido_materno , 
                        u.id,
                        u.fecha_registro 
                        FROM usuario_perfil up INNER JOIN
                         usuario u on u.id = up.idusuario
                          WHERE up.idperfil IN (3,6)
                          and u.status =1 ';
        return $this->db->query($query_get)->result_array();

    }

    function comisionistas_periodo($fecha_inicio, $fecha_termino)
    {
        $query_get = _text_("SELECT 
                        u.name , 
                        u.apellido_paterno, 
                        u.apellido_materno , 
                        u.id,
                        DATE(u.fecha_registro) fecha_registro 
                        FROM usuario_perfil up 
                        INNER JOIN
                        usuario u 
                        ON 
                        u.id = up.idusuario
                        WHERE up.idperfil IN (3,6) 
                        AND 
                        u.status = 1 
                        AND ",
            "DATE(u.fecha_registro)
             BETWEEN '", $fecha_inicio, "' AND  '", $fecha_termino, "' 
             ORDER BY fecha_registro DESC"
        );

        return $this->db->query($query_get)->result_array();

    }

    function total_periodo($fecha_inicio, $fecha_termino, $id_perfil, $status)
    {


        $fecha = _text_(
            "DATE(fecha_registro) BETWEEN '",
            $fecha_inicio, "' AND  '", $fecha_termino, "'");
        $qperfil = _text_('AND idperfil = ', $id_perfil);
        $qstatus = _text_('AND status = ', $status);

        $query_get = _text('SELECT 
                        COUNT(0)num
                        FROM usuario_perfil 
                          WHERE ', $fecha, $qperfil, $qstatus);
        return $this->db->query($query_get)->result_array()[0]["num"];


    }
}
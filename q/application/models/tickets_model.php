<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tickets_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id_ticket" => $id]);
    }

    function get_info_ticket($param)
    {

        $id_ticket = $param["id_ticket"];
        $query_get = "SELECT 
                      t.* ,
                      d.nombre nombre_departamento
                    FROM 
                      ticket t
                    INNER JOIN 
                      departamento d
                    ON t.id_departamento =  d.id_departamento
                      WHERE  
                    t.id_ticket = '" . $id_ticket . "' 
                    LIMIT 1";

        return $this->db->query($query_get)->result_array();

    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_ticket" => $id]);
    }

    function tmp_tareas_tickets($flag, $_num, $param)
    {

        $this->db->query(get_drop("tmp_tareas_ticket_$_num"));

        if ($flag < 1) {

            $query_create = "CREATE TABLE tmp_tareas_ticket_$_num AS 
                        SELECT 
                        id_ticket, 
                        count(0)num_tareas_pendientes 
                        FROM  
                        tarea 
                        WHERE 
                        status = 0 
                        GROUP BY
                        id_ticket";

            $this->db->query($query_create);
        }

    }

    function get_tickets_desarrollo($param, $simple = 0)
    {

        $_num = mt_rand();
        $this->tmp_tareas_tickets(0, $_num, $param);

        $query_get = "SELECT                       
                      t.id_ticket,
                      t.asunto,
                      t.mensaje,
                      t.status,
                      t.id_usuario,
                      t.fecha_registro,           
                      d.nombre nombre_departamento ,                      
                      tp.num_tareas_pendientes
                      FROM 
                        ticket t 
                      INNER JOIN departamento d 
                        ON t.id_departamento = d.id_departamento                      
                      LEFT OUTER JOIN
                        tmp_tareas_ticket_$_num tp
                      ON 
                        t.id_ticket =  tp.id_ticket
                    WHERE                    
                      t.status =  '" . $param["status"] . "'
                      ";


        $sql = ($simple == 0) ? "AND d.id_departamento = '" . $param["id_departamento"] . "' " : "";

        $query_get .= $sql;
        $query_get .= "
                      AND 
                      t.asunto like '%" . $param["keyword"] . "%'                        
                      
                      ORDER BY                                                         
                      t.fecha_registro";


        $result = $this->db->query($query_get);
        $data = $result->result_array();
        $this->tmp_tareas_tickets(1, $_num, $param);
        return $data;
    }

    function get_tickets($param)
    {

        $_num = mt_rand();
        $this->tmp_tareas_tickets(0, $_num, $param);
        $where = filtra_tarea($param);
        $base = "SELECT                       
                      t.id_ticket,
                      t.asunto,
                      t.mensaje,
                      t.status,
                      t.id_usuario,
                      t.efecto_monetario,                    
                      t.fecha_registro,       
                      t.tiempo_estimado,    
                      d.nombre nombre_departamento ,                      
                      tp.num_tareas_pendientes
                      FROM 
                        ticket t 
                      INNER JOIN departamento d 
                        ON t.id_departamento = d.id_departamento                      
                      LEFT OUTER JOIN
                        tmp_tareas_ticket_$_num tp
                      ON 
                        t.id_ticket =  tp.id_ticket
                    WHERE                     
                    ";

        $order_by = "ORDER BY t.tiempo_estimado , t.status ASC";
        $query_get = _text($base, $where, $order_by);
        $data = $this->db->query($query_get)->result_array();
        $this->tmp_tareas_tickets(1, $_num, $param);
        return $data;

    }


    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert("ticket", $params, $debug);
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
        return $this->db->get("ticket")->result_array();
    }

    function get_resumen_id($id_ticket)
    {

        $query_get = "SELECT
                 t.* ,
                 d.nombre 
                 nombre_departamento
                FROM 
                  ticket t
                INNER JOIN departamento d 
                ON 
                 t.id_departamento = d.id_departamento 
                WHERE  t.id_ticket = $id_ticket
                limit 1";
        return $this->db->query($query_get)->result_array();

    }

    private function update($data = [], $params_where = [], $limit = 1)
    {
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update("ticket", $data);
    }

    function liberacion($id)
    {
        $query_set = "UPDATE ticket SET
                        status = 2 ,
                        fecha_liberacion = CURRENT_TIMESTAMP()
                        WHERE id_ticket ='" . $id . "' ";
        return $this->db->query($query_set);
    }

    function resumen_liberacion()
    {
        $query_get = "SELECT 
                COUNT(0)mensual ,
                SUM(CASE WHEN fecha_liberacion BETWEEN  
                DATE_ADD(CURRENT_DATE(), INTERVAL 1-DAYOFWEEK(CURRENT_DATE())  DAY) AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY) THEN 1 ELSE 0 END)semanal,
                SUM(CASE WHEN fecha_liberacion BETWEEN  
                     DATE_ADD(DATE_ADD(CURRENT_DATE(), INTERVAL -1 WEEK), INTERVAL 1-DAYOFWEEK(CURRENT_DATE())  DAY)
                     AND
                     DATE_ADD(CURRENT_DATE(), INTERVAL 1-DAYOFWEEK(CURRENT_DATE())  DAY) THEN 1 ELSE 0 END) semana_anterior
                FROM ticket 
                WHERE 
                status = 2 AND 
                fecha_liberacion BETWEEN DATE_FORMAT(now(),'%Y-%m-01') AND  DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY)";
        return $this->db->query($query_get)->result_array($query_get);
    }

    private function create_tmp_solicitud_pago_usuario($flag, $_num, $param)
    {

        $this->db->query(get_drop("tmp_solicitud_pago_usuario_$_num"));
        if ($flag == 0) {
            $id_usuario = $param["id_usuario"];
            $query_create = "CREATE TABLE tmp_solicitud_pago_usuario_$_num
                              AS
                              SELECT id_solicitud FROM solicitud_pago_usuario 
                              WHERE id_usuario =$id_usuario
                              AND status =0 ";
            $this->db->query($query_create);
        }
    }

    function get_solicitudes_saldo($param)
    {

        $_num = mt_rand();
        $this->create_tmp_solicitud_pago_usuario(0, $_num, $param);
        $query_get = "SELECT * FROM tmp_solicitud_pago_usuario_$_num s 
                        INNER JOIN solicitud_pago sp
                        ON s.id_solicitud = sp.id_solicitud";
        $data_complete = $this->db->query($query_get)->result_array();
        $this->create_tmp_solicitud_pago_usuario(1, $_num, $param);
        return $data_complete;
    }

    function get_num($param)
    {


        $params_where = [
            "status" => 0,
            "id_ticket" => $param["id_ticket"]
        ];
        return $this->get(["count(*)num"], $params_where)[0]["num"];
    }

    function liberar()
    {
        $query_get = "UPDATE ticket SET status = 4 WHERE status = 2 LIMIT 50";
        return $this->db->query($query_get);

    }

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

    function create_tmp_tareas_tickets($flag, $_num, $param)
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

        $_num = get_random();
        $this->create_tmp_tareas_tickets(0, $_num, $param);

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
        $this->create_tmp_tareas_tickets(1, $_num, $param);
        return $data;
    }

    function get_tickets($param)
    {

        $_num = get_random();
        $this->create_tmp_tareas_tickets(0, $_num, $param);

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
                    WHERE t.status < 4
                        ORDER BY                                                         
                        t.status ";


        $data  = $this->db->query($query_get)->result_array();
        $this->create_tmp_tareas_tickets(1, $_num, $param);
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

        $_num = get_random();
        $this->create_tmp_solicitud_pago_usuario(0, $_num, $param);
        $query_get = "SELECT * FROM tmp_solicitud_pago_usuario_$_num s 
                        INNER JOIN solicitud_pago sp
                        ON s.id_solicitud = sp.id_solicitud";
        $data_complete = $this->db->query($query_get)->result_array();
        $this->create_tmp_solicitud_pago_usuario(1, $_num, $param);
        return $data_complete;
    }

    /*
    function get_where_tiempo($param){

      $fecha_inicio   =  $param["fecha_inicio"];
      $fecha_termino  =  $param["fecha_termino"];
      $tipo =  $param["tipo"];
      switch ($tipo){
        case 6:

          return " DATE(fecha_registro)
                   BETWEEN
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;
        case 2:

          return " (fecha_termino)
                   BETWEEN
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;

        case 3:

          return " (fecha_actualizacion)
                   BETWEEN
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;



          case 9:

          return " (fecha_pago)
                   BETWEEN
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;


        case 10:

          return " (fecha_cancelacion)
                   BETWEEN
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;

        default:

          break;
      }

    }
    */
    function get_num($param)
    {


        $params_where = [
            "status" => 0,
            "id_ticket" => $param["id_ticket"]
        ];
        return $this->get(["count(*)num"], $params_where)[0]["num"];
    }

    /*

    private function get_limit($param){

        $page = (isset($param['page'])&& !empty($param['page']))?
        $param['page']:1;
        $per_page = $param["resultados_por_pagina"];
        //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;

        return " LIMIT $offset , $per_page ";
    }


    function compras_ventas_efectivas_usuario($param){

      $id_usuario =  $param["id_usuario"];
      $campo_usuario = "id_usuario";
      if($param["modalidad"] == 1){
          $campo_usuario ="id_usuario_venta";
      }

      $query_get ="SELECT
                        *
                      FROM
                        proyecto_persona_forma_pago
                      WHERE
                        $campo_usuario = $id_usuario
                      AND status =  9".$this->get_limit($param);

      $result =  $this->db->query($query_get);
      return $result->result_array();
    }



    function get_flag_envio_gratis_por_id_recibo($param){

      $id_recibo =  $param["id_recibo"];

      $query_get ="SELECT flag_envio_gratis
                   FROM proyecto_persona_forma_pago
                   WHERE id_proyecto_persona_forma_pago = $id_recibo LIMIT 1";
                   $result =  $this->db->query($query_get);
      return $result->result_array()[0]["flag_envio_gratis"];

    }


    function get_id_proyecto_por_id_proyecto_persona($id_proyecto_persona){

          $query_get ="SELECT
            id_proyecto
          FROM
            proyecto_persona
          WHERE id_proyecto_persona = $id_proyecto_persona
          LIMIT 1";

          $result =  $this->db->query($query_get);
          return  $result->result_array();
    }

    function get_id_servicio_por_id_proyecto($id_proyecto){

      $query_get ="SELECT
                    id_servicio
                  FROM
                    proyecto
                  WHERE id_proyecto = $id_proyecto
                  LIMIT 1";

          $result =  $this->db->query($query_get);
          return  $result->result_array();
    }

    function get_servicio_por_id_servicio($id_servicio){

      $query_get ="SELECT
                    id_servicio,
                    nombre_servicio
                  FROM
                    servicio
                  WHERE
                  id_servicio = $id_servicio
                  LIMIT 1";

          $result =  $this->db->query($query_get);
          return  $result->result_array();
    }


  */
}
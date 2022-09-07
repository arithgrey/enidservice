<?php defined('BASEPATH') or exit('No direct script access allowed');

class Acceso_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert("acceso", $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function busqueda_fecha($fecha_inicio, $fecha_termino, $id_servicio = 0)
    {

        $extra  = '';
        if ($id_servicio >  0) {

            $extra = _text_("AND a.id_servicio = ", $id_servicio);
        }

        $query_get = _text_("select count(0)accesos, 
                        p.pagina, 
                        sum(case when a.is_mobile > 0 then 1 else 0 end) es_mobile,
                        sum(case when a.is_mobile > 0 then 0 else 1 end) es_computadora,
                        sum(case when a.in_session > 0 then 1 else 0 end) en_session,
                        sum(case when a.in_session > 0 then 0 else 1 end) sin_session
                        from acceso 
                        a inner join pagina p on a.pagina_id = p.id
                        WHERE 
                        DATE( a.fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ", $extra, "
                        group by p.pagina");

        return $this->db->query($query_get)->result_array();
    }

    function busqueda_fecha_productos($fecha_inicio, $fecha_termino)
    {

        $query_get = _text_("select                         
                        s.nombre_servicio, 
                        s.id_servicio,
                        count(0)accesos,                         
                        sum(case when a.is_mobile > 0 then 1 else 0 end) es_mobile,
                        sum(case when a.is_mobile > 0 then 0 else 1 end) es_computadora,
                        sum(case when a.in_session > 0 then 1 else 0 end) en_session,
                        sum(case when a.in_session > 0 then 0 else 1 end) sin_session
                        from acceso a inner join servicio s on a.id_servicio = s.id_servicio                      
                        WHERE 
                        DATE( a.fecha_registro ) 
                        BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' group by s.id_servicio ORDER BY count(0) desc");

        return $this->db->query($query_get)->result_array();
    }

    function busqueda_fecha_ids($fecha_inicio, $fecha_termino, $ids)
    {

        $extra = _text_("AND a.id_servicio in (", $ids, ")");

        $query_get = _text_("select count(a.id_servicio) accesos_accion, 
                        a.id_servicio,
                        p.pagina      ,
                        p.id id_pagina                 
                        from acceso 
                        a inner join pagina p on a.pagina_id = p.id
                        WHERE 
                        DATE( a.fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ", $extra, "
                        group by a.id_servicio, p.id order by p.id DESC");

        return $this->db->query($query_get)->result_array();
    }

    function conteo_fecha($pagina_id, $fecha_inicio, $fecha_termino)
    {
        
        $query_get = _text_("SELECT DATE(fecha_registro) fecha_registro, count(0)accesos from acceso
                        WHERE 
                        DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'
                        AND 
                        pagina_id = $pagina_id
                        GROUP BY DATE(fecha_registro) ORDER BY fecha_registro DESC");


        return $this->db->query($query_get)->result_array();
    }

    function dominio($fecha_inicio, $fecha_termino)
    {
        
        $query_get = _text_("SELECT fecha_registro fecha_registro, http_referer from acceso
                        WHERE 
                        DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'
                        AND  LENGTH(http_referer) > 5
                        ORDER BY fecha_registro DESC");


        return $this->db->query($query_get)->result_array();
    }
    function franja_horaria($fecha_inicio, $fecha_termino)
    {
        
        $query_get = _text_("SELECT 
                            HOUR(fecha_registro)horario, 
                            count(0)total ,
                            SUM( CASE WHEN is_mobile > 0 THEN 1 ELSE 0 END )mobile,
                            SUM( CASE WHEN is_mobile < 1 THEN 1 ELSE 0 END )desktop
                            from acceso
                        WHERE 
                        DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'                        
                        AND 
                        in_session < 1 
                        GROUP BY 
                        HOUR(fecha_registro) ORDER BY HOUR(fecha_registro) DESC");


        return $this->db->query($query_get)->result_array();
    }


    

}

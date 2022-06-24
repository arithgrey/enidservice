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

    function busqueda_fecha($fecha_inicio, $fecha_termino, $id_servicio = 0 )
    {

        $extra  = '';
        if($id_servicio >  0 ){

            $extra = _text_("AND a.id_servicio = ", $id_servicio );
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
                        DATE( a.fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ",$extra,"
                        group by p.pagina");

        return $this->db->query($query_get)->result_array();


    }

    function busqueda_fecha_productos($fecha_inicio, $fecha_termino )
    {
        
        $query_get = _text_("select 
                        s.nombre_servicio, 
                        s.id_servicio,
                        count(0)accesos,                         
                        sum(case when a.is_mobile > 0 then 1 else 0 end) es_mobile,
                        sum(case when a.is_mobile > 0 then 0 else 1 end) es_computadora,
                        sum(case when a.in_session > 0 then 1 else 0 end) en_session,
                        sum(case when a.in_session > 0 then 0 else 1 end) sin_session
                        from acceso a   inner join servicio s on a.id_servicio = s.id_servicio                      
                        WHERE 
                        DATE( a.fecha_registro ) 
                        BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' group by s.id_servicio");

        return $this->db->query($query_get)->result_array();


    }

    


}
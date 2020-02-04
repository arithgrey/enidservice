<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ventas_encuentro_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_periodo($param)
    {


        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $id_usuario = $param['id_usuario'];

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $extra = "AND id_usuario = '" . $id_usuario . "'";

        if ($fecha_inicio != $hoy) {
            $extra = " AND DATE(r.fecha_entrega) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' AND id_usuario = '" . $id_usuario . "'";
        }

        $query_get = "SELECT
                        COUNT(pe.id_linea_metro)linea,  
                        r.id_servicio , 
                        COUNT(p.id_punto_encuentro)ventas_en_punto,
                        p.id_punto_encuentro, 
                        pe.nombre nombre_punto_encuentro, 
                        pe.id_linea_metro,
                        l.nombre nombre_linea
                        FROM  
                        proyecto_persona_forma_pago  r 
                        INNER JOIN 
                        proyecto_persona_forma_pago_punto_encuentro p  
                        ON  
                        r.id_proyecto_persona_forma_pago =  p.id_proyecto_persona_forma_pago 
                        INNER JOIN 
                        punto_encuentro  pe  ON  p.id_punto_encuentro =  pe.id 
                        INNER JOIN 
                        linea_metro  l  ON  pe.id_linea_metro =  l.id
                        WHERE  
                            r.saldo_cubierto > 0  AND  r.tipo_entrega = 1
                            " . $extra . "
                             
                        GROUP BY  pe.id_linea_metro, p.id_punto_encuentro 
                        ORDER BY  COUNT(pe.id_linea_metro)  DESC;";

        return $this->db->query($query_get)->result_array();

    }


}
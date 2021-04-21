<?php defined('BASEPATH') or exit('No direct script access allowed');

class Recibo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_compras_por_enviar()
    {

        $query_get = "SELECT tipo_entrega, id_servicio, SUM(num_ciclos_contratados)ventas_pagas_sin_envio FROM proyecto_persona_forma_pago
                        WHERE
                        DATE(fecha_registro )
                        BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 DAY )
                        AND  DATE_ADD(CURRENT_DATE() , INTERVAL 1 DAY )
                        AND  saldo_cubierto > 0 and status in( 1 , 11 )
                        group by id_servicio , tipo_entrega";

        return $this->db->query($query_get)->result_array();

    }

    function get_solicitudes_periodo_servicio($id_servicio, $interval)
    {

        $query_get = "
            SELECT 
             id_servicio, 
             count(0) solicitudes, 
             date(fecha_contra_entrega)fecha_contra_entrega  
             FROM proyecto_persona_forma_pago 
             WHERE   
                id_servicio = {$id_servicio}
                AND
                DATE(fecha_contra_entrega)
                BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL " . $interval . " ) 
                AND  DATE(CURRENT_DATE())
                AND tipo_entrega =  1
             GROUP BY date(fecha_contra_entrega)";

        return $this->db->query($query_get)->result_array();

    }

    function get_solicitudes_entregadas_periodo_servicio($id_servicio, $interval)
    {

        $query_get = "SELECT 
                    id_servicio, 
                    count(0) solicitudes, 
                    date(fecha_entrega)fecha_entrega  
                    FROM proyecto_persona_forma_pago 
                    WHERE   
                    id_servicio = {$id_servicio}
                    AND
                    DATE(fecha_entrega)
                    BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL " . $interval . " ) 
                    AND  
                    DATE(CURRENT_DATE())
                    AND tipo_entrega =  1
                    AND status = 9
                    GROUP BY date(fecha_entrega)";

        return $this->db->query($query_get)->result_array();

    }

    function cancela_orden($saldo_cubierto, $status, $id, $tipo_fecha)
    {

        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET 
                            saldo_cubierto  =  {$saldo_cubierto} , 
                            status          =  {$status} ,
                            {$tipo_fecha}   =   CURRENT_TIMESTAMP(),
                            se_cancela      =  1,
                            saldo_cubierto  =  0                  
                          WHERE 
                            id_proyecto_persona_forma_pago =  {$id} 
                          LIMIT 1";
        return $this->db->query($query_update);
    }

    function set_status_orden($saldo_cubierto, $status, $id, $tipo_fecha)
    {

        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET 
                            saldo_cubierto  =  {$saldo_cubierto} , 
                            status          =  {$status} ,
                            {$tipo_fecha}   =   CURRENT_TIMESTAMP()                            
                          WHERE 
                            id_proyecto_persona_forma_pago =  {$id} 
                          LIMIT 1";
        return $this->db->query($query_update);
    }

    function notifica_entrega($saldo_cubierto, $status, $id, $tipo_fecha)
    {

        $sin_cancelar = [1, 7, 9, 11, 12, 14, 15];
        $es_venta = (in_array($status, $sin_cancelar));
        $cancelacion = (!$es_venta) ?: ',se_cancela = 0 , cancela_cliente = 0';

        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET 
                            saldo_cubierto  =  {$saldo_cubierto} , 
                            status          =  {$status} ,
                            {$tipo_fecha}   =   CURRENT_TIMESTAMP()   ,
                            entregado       =   1  " . $cancelacion . "                       
                          WHERE 
                            id_proyecto_persona_forma_pago =  {$id} 
                          LIMIT 1";
        return $this->db->query($query_update);
    }

    function ids_usuarios($params, $ids, $es_pago = 0)
    {
        $f = get_keys($params);
        $extra = "";
        if ($es_pago > 0) {

            $extra = "AND se_cancela < 1  
                        AND saldo_cubierto > 0                         
                        AND  p.status 
                        NOT IN (10,19)  
                        AND id_usuario NOT IN (SELECT id_usuario FROM lista_negra)";
        }

        $query_get = _text_(
            "SELECT ", $f, " FROM proyecto_persona_forma_pago p 
            INNER JOIN producto_orden_compra po ON 
            p.id_proyecto_persona_forma_pago = po.id_proyecto_persona_forma_pago   
            WHERE id_usuario IN(", $ids, ")",
            $extra
        );
        return $this->db->query($query_get)->result_array();

    }

    function ids_usuarios_periodo($params, $ids, $fecha_inicio, $fecha_termino)
    {

        $f = get_keys($params);
        $extra = "AND se_cancela < 1  
                        AND saldo_cubierto > 0                         
                        AND  p.status 
                        NOT IN (10,19)  
                        AND id_usuario NOT IN 
                        (SELECT id_usuario FROM lista_negra)                        
                        AND 
                        DATE(p.fecha_entrega) 
                        BETWEEN '" . $fecha_inicio . "' AND 
                        '" . $fecha_termino . "' ";


        $query_get = _text_(
            "SELECT ", $f, " FROM proyecto_persona_forma_pago p WHERE id_usuario_referencia 
            IN(", $ids, ")", $extra
        );
        return $this->db->query($query_get)->result_array();

    }

    function ids($ids)
    {
        $query_get = _text_(
            "SELECT * FROM proyecto_persona_forma_pago p",
            " WHERE id_proyecto_persona_forma_pago IN(", $ids, ")");
        return $this->db->query($query_get)->result_array();

    }

    function get_q($params, $param)
    {


        $f = get_keys($params);
        $tipo_entrega = $param["tipo_entrega"];
        $status_venta = $param["status_venta"];
        $id_usuario_venta = $param['id_usuario'];
        $es_admistrador = $param['es_admistrador'];
        $query_get = "SELECT " . $f . " FROM proyecto_persona_forma_pago p INNER JOIN producto_orden_compra po 
        ON po.id_proyecto_persona_forma_pago = p.id_proyecto_persona_forma_pago ";


        $ext_usuario = $this->get_usuario($param);
        $ext_contra_entrega = ($tipo_entrega == 0) ? "" : " AND  p.tipo_entrega = '" . $tipo_entrega . "'";
        $extra_extatus_venta = ($status_venta == 0) ? "" : "  AND p.status = '" . $status_venta . "' ";
        $extra_extatus_venta = ($status_venta == 14) ? " AND p.saldo_cubierto >  0 " : $extra_extatus_venta;
        $extra_extatus_venta = ($status_venta == 17) ?
            "AND p.saldo_cubierto >  0  AND  flag_pago_comision < 1 " : $extra_extatus_venta;
        $extra_extatus_venta = ($status_venta == 18) ?
            "AND p.saldo_cubierto >  0  AND  flag_pago_comision < 1 " : $extra_extatus_venta;

        $id_usuario_referencia = prm_def($param, 'id_usuario_referencia');
        $usuario_referencia = ($id_usuario_referencia > 0) ? ' AND p.id_usuario_referencia = "' . $id_usuario_referencia . '"' : '';
        $extra_usuario_venta = ($id_usuario_venta == 1 or intval($es_admistrador) === 1) ? " " :
            "  AND ( p.id_usuario_venta = '" . $id_usuario_venta . "' OR p.id_usuario_referencia = '" . $id_usuario_venta . "') ";


        $ext_fecha = $this->get_fecha($param);
        $ext_servicio = $this->get_servicio($param);
        $order = " ORDER BY  p.se_cancela ASC, p.id_usuario_referencia DESC , p.flag_pago_comision ASC";
        $query_get .= _text_($ext_usuario, $usuario_referencia, $ext_contra_entrega, $extra_extatus_venta,
            $extra_usuario_venta, $ext_fecha, $ext_servicio, $order);
        return $this->db->query($query_get)->result_array();

    }

    private function get_servicio($param)
    {

        return (array_key_exists("servicio", $param) && $param["servicio"] > 0) ? " AND  id_servicio = '" . $param["servicio"] . "' " : "";

    }

    private function get_usuario($param)
    {

        $sql = " WHERE 1=1 ";
        if (strlen(trim($param["cliente"])) > 0) {
            $cliente = $param["cliente"];
            $sql = " INNER JOIN usuario u ON 
                                    p.id_usuario =  u.idusuario 
                                    WHERE 
                                        ( u.nombre LIKE '%{$cliente}%' 
                                    OR
                                        u.apellido_paterno LIKE '%{$cliente}%'
                                    OR
                                        u.apellido_materno LIKE '%{$cliente}%'
                                    OR
                                        u.tel_contacto LIKE '%{$cliente}%'
                                    OR
                                        u.email        LIKE '%{$cliente}%' )
                                    ";
        }
        return $sql;
    }

    function get_total_compras_usuario($ids)
    {

        $a = 0;
        $query_get = "SELECT COUNT(0)num FROM 
                        proyecto_persona_forma_pago 
                        WHERE 
                        saldo_cubierto > 0 
                        AND 
                        id_usuario IN (" . $ids . ")";
        $compras = $this->db->query($query_get)->result_array()[0]["num"];
        $query_get = "SELECT COUNT(0)num FROM 
                        proyecto_persona_forma_pago 
                        WHERE                      
                        id_usuario IN (" . $ids . ")";
        $solicitudes = $this->db->query($query_get)->result_array()[0]["num"];
        return [
            "compras" => $compras,
            "solicitudes" => $solicitudes
        ];

    }

    private function get_fecha($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $tipo_orden = $param["tipo_orden"];
        $ops_tipo_orden = ["", "fecha_registro", "fecha_entrega", "fecha_cancelacion", "fecha_pago", "fecha_contra_entrega"];
        $tipo_entrega = $param["tipo_entrega"];
        $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_termino . "' ";


        switch ($tipo_orden) {
            case 0:

                break;
            case 1:


                if ((array_key_exists("servicio", $param) && $param["servicio"] > 0) && $fecha_inicio === $fecha_termino) {

                    $extra = "";

                } else {

                    $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND DATE_ADD('" . $fecha_termino . "' ,  INTERVAL 1 DAY)  ";
                }


                break;
            case 2:
                $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND DATE_ADD('" . $fecha_termino . "' ,  INTERVAL 1 DAY)  AND entregado = 1 ";
                break;
            case 3:
                $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND DATE_ADD('" . $fecha_termino . "' ,  INTERVAL 1 DAY)  AND (se_cancela =  1 OR cancela_cliente = 1) ";
                break;
            case 4:
                $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_termino . "' AND p.status = 1 ";
                break;
        }


        return $extra;
    }

    function get_adeudo_cliente($param)
    {

        $id_usuario = $param["id_usuario"];
        $query_get = "SELECT 
                    (ppf.monto_a_pagar * ppf.num_ciclos_contratados )+ costo_envio_cliente as  saldo_pendiente,
                    ppf.saldo_cubierto, 
                    ppfd.id_direccion
                    FROM 
                    proyecto_persona_forma_pago 
                    ppf                         
                    LEFT OUTER JOIN 
                    proyecto_persona_forma_pago_direccion  ppfd 
                    ON 
                    ppf.id_proyecto_persona_forma_pago =  ppfd.id_proyecto_persona_forma_pago
                    WHERE 
                    ppf.id_usuario = $id_usuario
                    AND 
                    ppf.monto_a_pagar  > ppf.saldo_cubierto
                    AND se_cancela != 1";


        $result = $this->db->query($query_get);
        $data_complete = $result->result_array();

        $total_deuda = 0;
        $direciones_pendientes = 0;
        foreach ($data_complete as $row) {

            $saldo_pendiente = $row["saldo_pendiente"];
            $saldo_cubierto = $row["saldo_cubierto"];
            if ($row["id_direccion"] == null) {
                $direciones_pendientes++;
            }
            $deuda = $saldo_pendiente - $saldo_cubierto;
            $total_deuda = $total_deuda + $deuda;
        }
        $data_complete_response["total_deuda"] = $total_deuda;
        $data_complete_response["sin_direcciones"] = $direciones_pendientes;
        return $data_complete_response;
    }

    function get_saldo_usuario($param)
    {


        $id_usuario = $param["id_usuario"];
        $params = [
            "saldo_cubierto",
            "monto_a_pagar",
            "flag_envio_gratis",
            "costo_envio_cliente",
            "num_ciclos_contratados",
            "costo_envio_vendedor",
            "saldo_cubierto_envio"
        ];

        $keys = get_keys($params);
        $query_get = "SELECT 
                        " . $keys . "
                    FROM 
                        proyecto_persona_forma_pago
                    WHERE 
                        id_usuario_venta = $id_usuario
                    AND 
                        entregado = 0
                    AND 
                        saldo_cubierto>0";
        return $this->db->query($query_get)->result_array();

    }

    function carga_actividad_pendiente($param)
    {


        $campo_usuario = ($param["modalidad"] > 0) ? "id_usuario_venta" : "id_usuario";

        $params_where = [
            "status" => 7,
            $campo_usuario => $param["id_usuario"]
        ];
        $data_complete["num_pedidos"] = $this->get(["COUNT(0)num"], $params_where, 10000)['0']["num"];
        return $data_complete;
    }

    function get_servicio_por_recibo($param)
    {

        $query_get = "SELECT 
                      s.id_servicio, 
                      s.nombre_servicio
                      FROM 
                      proyecto_persona_forma_pago p 
                      INNER JOIN servicio s 
                      ON 
                      p.id_servicio =  s.id_servicio
                      WHERE 
                      p.id_proyecto_persona_forma_pago='" . $param["id_recibo"] . "' LIMIT 1";

        return $this->db->query($query_get)->result_array();
    }

    function get_compras_tipo_periodo($param)
    {

        $where = $this->get_where_tiempo($param);
        $tipo = $param["tipo"];
        $ext = ($tipo == 9) ? ' saldo_cubierto > 0 ' : 'status = "' . $tipo . '"  ';
        $query_get = "SELECT 
                      * 
                    FROM 
                      proyecto_persona_forma_pago 
                    WHERE 
                      " . $ext . " 
                    AND 
                       " . $where;

        return $this->db->query($query_get)->result_array();
    }

    function get_where_tiempo($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $tipo = $param["tipo"];
        switch ($tipo) {
            case 6:

                return " DATE(fecha_registro)
                   BETWEEN 
                   '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
                break;
            case 2:

                return " (fecha_termino)
                   BETWEEN 
                   '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
                break;

            case 3:

                return " (fecha_actualizacion)
                   BETWEEN 
                   '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
                break;

            case 7:

                return " (fecha_pago)
                   BETWEEN 
                   '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
                break;


            case 9:

                return " (fecha_pago)
                   BETWEEN 
                   '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
                break;


            case 10:

                return " (fecha_cancelacion)
                   BETWEEN 
                   '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
                break;

            default:

                break;
        }

    }

    function cancela_orden_compra($id_recibo)
    {

        $query_update =
            "UPDATE proyecto_persona_forma_pago 
          SET 
          status            = 10,
          fecha_cancelacion = CURRENT_DATE(), 
          cancela_cliente   = 1,
          se_cancela        = 1
          WHERE  id_proyecto_persona_forma_pago =  '" .  $id_recibo . "' LIMIT 1";

        return $this->db->query($query_update);

    }

    function num_compras_efectivas_usuario($param)
    {

        $campo_usuario = "id_usuario";
        if ($param["modalidad"] == 1) {
            $campo_usuario = "id_usuario_venta";
        }

        $params_where = [
            "status" => 9,
            $campo_usuario => $param["id_usuario"]
        ];
        return $this->get(["COUNT(0)num"], $params_where, 10000)['0']["num"];
    }

    function total_compras_ventas_efectivas_usuario($param)
    {

        $id_usuario = $param["id_usuario"];
        $campo_usuario = "id_usuario";
        if ($param["modalidad"] == 1) {
            $campo_usuario = "id_usuario_venta";
        }
        $params_where = [$campo_usuario => $id_usuario, "status" => 9];
        return $this->get(["count(0)num"], $params_where)[0]["num"];

    }

    function compras_ventas_efectivas_usuario($param)
    {

        $id_usuario = $param["id_usuario"];
        $campo_usuario = "id_usuario";

        if ($param["modalidad"] > 0) {

            $campo_usuario = "id_usuario_venta";

        }

        $params_where = [$campo_usuario => $id_usuario, "status" => 9];
        return $this->get([], $params_where);

    }

    function get_monto_pendiente_proyecto_persona_forma_pago($param)
    {
        return $this->q_get([], $param["recibo"]);
    }

    function valida_recibo_por_enviar_usuario($param)
    {

        $query_get = "SELECT * FROM 
                        proyecto_persona_forma_pago 
                      WHERE 
                        id_proyecto_persona_forma_pago = '" . $param["id_recibo"] . "'
                      AND 
                        id_usuario_venta =  '" . $param["id_usuario"] . "'
                      AND 
                        monto_a_pagar <= saldo_cubierto 
                      LIMIT 1";

        return $this->db->query($query_get)->result_array();
    }


    function valida_recibo_por_pagar_usuario($param)
    {

//        $propietarios = "(
//        id_usuario =  '" . $param["id_usuario"] . "' OR
//        id_usuario_referencia =  '" . $param["id_usuario"] . "' OR
//        id_usuario_venta =  '" . $param["id_usuario"] . "'
//        )  ";

        $query_get = "SELECT 
                    *
                  FROM proyecto_persona_forma_pago 
                  WHERE 
                    id_proyecto_persona_forma_pago = '" . $param["id_recibo"] . "'
             
                  LIMIT 1";

        return $this->db->query($query_get)->result_array();
    }

    function valida_recibo_por_pagar($param)
    {

        $query_get = "SELECT * FROM proyecto_persona_forma_pago 
                WHERE 
                  id_proyecto_persona_forma_pago = '" . $param["id_recibo"] . "'
                AND 
                  id_usuario =  '" . $param["id_usuario"] . "'
                AND
                  id_usuario_venta =  '" . $param["id_usuario_venta"] . "'
                AND 
                  monto_a_pagar >saldo_cubierto 
                LIMIT 1";

        return $this->db->query($query_get)->result_array();

    }

    function get_compras_usuario($param, $status = 0)
    {

        $where = $this->get_where_estado_venta($param, $status);
        $query_get = "SELECT
                        p.id_proyecto_persona_forma_pago ,
                        p.resumen_pedido,
                        p.id_servicio,
                        p.monto_a_pagar,
                        p.costo_envio_cliente,
                        p.saldo_cubierto,
                        p.status,
                        p.fecha_registro,
                        p.num_ciclos_contratados,
                        p.estado_envio,
                        o.id_orden_compra
                        FROM
                        proyecto_persona_forma_pago p 
                        INNER JOIN producto_orden_compra o 
                        ON p.id_proyecto_persona_forma_pago = o.id_proyecto_persona_forma_pago
                                          " . $where . " ORDER BY p.fecha_registro DESC";


        return $this->db->query($query_get)->result_array();
    }

    private function insert($tabla = 'proyecto', $params, $return_id = 0)
    {

        $insert = $this->db->insert($tabla, $params);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update("proyecto_persona_forma_pago", $data);

    }

    function set_fecha_contra_entrega($id_recibo, $fecha, $contra_entrega_domicilio = 0, $tipo_entrega = 0, $ubicacion = 0, $costo_envio_cliente = 0)
    {


        $this->db->set('modificacion_fecha', 'modificacion_fecha + 1', FALSE);
        $this->db->set('fecha_contra_entrega', $fecha);
        $this->db->set('contra_entrega_domicilio', $contra_entrega_domicilio);
        if ($tipo_entrega > 0) {
            $this->db->set('tipo_entrega', $tipo_entrega);
        }

        if ($ubicacion > 0) {

            $this->db->set('costo_envio_cliente', 0);
        } else {

            $this->db->set('costo_envio_cliente', $costo_envio_cliente);
        }

        $this->db->set('ubicacion', $ubicacion);

        $this->db->where("id_proyecto_persona_forma_pago", $id_recibo);
        return $this->db->update('proyecto_persona_forma_pago');

    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id_proyecto_persona_forma_pago" => $id]);
    }

    function q_up($q, $q2, $id_recibo)
    {
        return $this->update([$q => $q2], ["id_proyecto_persona_forma_pago" => $id_recibo]);
    }

    function q_usuario($id_usuario, $limit = 1)
    {

        return $this->get([], ["id_usuario" => $id_usuario], $limit);
    }

    private function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
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
        return $this->db->get("proyecto_persona_forma_pago")->result_array();
    }

    function get_dia($param)
    {

        $in = [
            "DATE(fecha_registro)" => $param["fecha"]
        ];
        return $this->get([" COUNT(0)num "], $in)[0]["num"];

    }

    function get_where_estado_venta($param)
    {


        $id_usuario = $param["id_usuario"];
        $sql = "";
        $modalidad = $param["modalidad"];

        if ($modalidad == 1) {
            switch ($param["status"]) {
                case 1:

                    $sql = "WHERE 
                    id_usuario_venta = $id_usuario                     
                    AND 
                      saldo_cubierto >= monto_a_pagar";
                    break;
                case 6:

                    $sql = "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                    status = 6";
                    break;
                case 7:
                    $sql = "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                    status = 7";
                    break;

                case 9:
                    $sql = "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                    status = 9";
                    break;

                default:

                    break;
            }
        } else {


            switch ($param["status"]) {
                case 6:

                    $sql = " WHERE 
                      id_usuario = $id_usuario  
                      AND  
                      status IN (1, 6, 7, 9, 11, 12, 16)
                      AND se_cancela =0";
                    break;

                default:

                    break;
            }
        }
        return $sql;
    }

    function crea_resumen_compra($texto_servicio,$num_ciclos, $flag_envio_gratis, $tipo_entrega = 0)
    {

        if ($tipo_entrega == 0) {

            $response = _text_($num_ciclos, $texto_servicio);

            if ($flag_envio_gratis == 1) {
                $response .= " - Envío gratis";
            }

        } else {
            $response = _text_($num_ciclos, $texto_servicio);

        }
        return $response;

    }


    function get_precio_servicio($param)
    {
        $id_servicio = $param["id_servicio"];
        $keys = ["s.precio", "s.id_ciclo_facturacion", "c.ciclo"];
        $keys = get_keys($keys);
        $query_get = "SELECT  
                      " . $keys . "
                      FROM  
                      servicio s
                      INNER JOIN 
                      ciclo_facturacion c 
                      ON
                      s.id_ciclo_facturacion =  c.id_ciclo_facturacion
                      WHERE s.id_servicio =$id_servicio  LIMIT 1";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }

    function crea_orden_de_compra($param)
    {

        $saldo_cubierto = 0;
        $status = 6;
        $data_usuario = $param["data_por_usuario"];
        $tipo_entrega = $data_usuario["tipo_entrega"];

        $id_forma_pago = ($tipo_entrega == 1) ? 8 : 6;
        $fecha_vencimiento = "DATE_ADD(CURRENT_DATE(), INTERVAL 2 DAY)";
        $id_usuario = $param["id_usuario"];


        $usuario_referencia = prm_def($data_usuario, "usuario_referencia");
        $id_usuario_referencia = ($usuario_referencia == 0) ? $id_usuario : $usuario_referencia;


        $num_ciclos = $param["articulos"];


        $id_servicio = $param["id_servicio"];
        $flag_envio_gratis = $param["flag_envio_gratis"];
        $id_usuario_venta = $param[ "id_usuario_venta"];
        $precio = $param["precio"];
        $comision = $param["comision"];
        $nombre_servicio = $param["nombre_servicio"];
        $flag_servicio = $param["flag_servicio"];

        $resumen_compra = $this->crea_resumen_compra($nombre_servicio, $num_ciclos, $flag_envio_gratis, $tipo_entrega);

        $costo_envio_cliente = 0;
        $costo_envio_vendedor = 0;
        $es_servicio = ($tipo_entrega < 5) ? 0 : $flag_servicio;
        $es_servicio = ($flag_servicio > 0) ? 1 : $es_servicio;


        $monto_a_pagar = $precio;
        if ($es_servicio < 1 && $tipo_entrega > 1) {

            $costo_envio = $param["costo_envio"];
            $costo_envio_cliente = $costo_envio["costo_envio_cliente"];
            $costo_envio_vendedor = $costo_envio["costo_envio_vendedor"];

        } else {


            if (prm_def($param, "costo_envio") > 0) {

                $costo_envio_cliente = $param["costo_envio"];
                $costo_envio_vendedor = 0;
            }
        }
        $id_ciclo_facturacion = $param["id_ciclo_facturacion"];
        $talla = (strlen($param["talla"]) < 1) ? 1 : $param["talla"];


        $array_keys = [
            "id_forma_pago",
            "saldo_cubierto",
            "status",
            "fecha_vencimiento",
            "monto_a_pagar",
            "id_usuario_referencia",
            "flag_envio_gratis",
            "costo_envio_cliente",
            "costo_envio_vendedor",
            "id_usuario_venta",
            "id_ciclo_facturacion",
            "num_ciclos_contratados",
            "id_usuario",
            "precio",
            "id_servicio",
            "resumen_pedido",
            "talla",
            "tipo_entrega",
            "comision_venta"
        ];

        $array_values =
            [
                $id_forma_pago,
                $saldo_cubierto,
                $status,
                $fecha_vencimiento,
                $monto_a_pagar,
                $id_usuario_referencia,
                $flag_envio_gratis,
                $costo_envio_cliente,
                $costo_envio_vendedor,
                $id_usuario_venta,
                $id_ciclo_facturacion,
                $num_ciclos,
                $id_usuario,
                $precio,
                $id_servicio,
                "'" . $resumen_compra . "'",
                $talla,
                $tipo_entrega,
                $comision
            ];


        switch ($tipo_entrega) {

            case 1:

                array_push($array_keys, "fecha_contra_entrega");
                array_push($array_values, "'" . $data_usuario["fecha_entrega"] . "'");
                break;

            case (2 && $flag_servicio > 0):

                array_push($array_keys, "fecha_servicio");
                array_push($array_values, "'" . $data_usuario["fecha_servicio"] . "'");

                break;

            default:


        }

        $query_insert = "INSERT INTO 
                        proyecto_persona_forma_pago(" . get_keys($array_keys) . ") 
                        VALUES(" . get_keys($array_values) . ")";


        $this->db->query($query_insert);
        return $this->db->insert_id();


    }

    function get_ventas_dia($param)
    {

        $query_get = "SELECT 
                    COUNT(0)num_ventas 
                  FROM 
                    proyecto_persona_forma_pago  
                  WHERE 
                    DATE(fecha_registro) ='" . $param["fecha"] . "'
                    AND
                    monto_a_pagar <= saldo_cubierto";

        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num_ventas"];

    }

    function pendientes_sin_cierre($id_usuario, $id_perfil, $id_empresa, $idusuarios_empresa)
    {

        $casos = [
            3 => " 1 = 1 ",
            4 => "id_usuario IN (SELECT id_usuario FROM usuario WHERE idempresa = $id_empresa)",
            6 => 'id_usuario_referencia = "' . $id_usuario . '"',
            20 => 'id_usuario = "' . $id_usuario . '"',
            21 => 'id_usuario_entrega = "' . $id_usuario . '"',
        ];

        $ids = get_keys($idusuarios_empresa);
        $extra_usuario = $casos[$id_perfil];
        $query_get = "SELECT 
						p.id_servicio, 
						p.id_usuario,
						p.id_proyecto_persona_forma_pago id_recibo,
						(p.monto_a_pagar * p.num_ciclos_contratados) total,
                        p.num_ciclos_contratados,
						p.fecha_contra_entrega,
						p.tipo_entrega,
						p.contra_entrega_domicilio,
						p.id_usuario_entrega,
						p.ubicacion,
						p.id_usuario_referencia,
						p.id_usuario_venta,
                        po.id_orden_compra
						FROM  
						     proyecto_persona_forma_pago p
                        INNER JOIN  
						         producto_orden_compra po 
                        ON p.id_proyecto_persona_forma_pago = po.id_proyecto_persona_forma_pago
						WHERE  
						p.saldo_cubierto < 1  
						AND " . $extra_usuario . " 						  
						AND  p.se_cancela = 0
						AND  p.status NOT IN(10,19)  
						AND 						
						(
						DATE(p.fecha_contra_entrega) <=  DATE(CURRENT_DATE())
						OR
						DATE(p.fecha_vencimiento) <=  DATE(CURRENT_DATE())
						OR
						DATE(p.fecha_entrega) <=  DATE(CURRENT_DATE())						
						)   
						AND p.id_usuario NOT IN (SELECT id_usuario FROM lista_negra)
						AND p.id_servicio IN (select id_servicio from servicio where id_usuario in ($ids))";
        return $this->db->query($query_get)->result_array();
    }

    function proximas($id_empresa, $id_usuario, $id_perfil, $dia = 0)
    {

        $casos = [
            3 => " 1 = 1 ",
            4 => "id_usuario IN (SELECT id_usuario FROM usuario WHERE idempresa = $id_empresa)",
            6 => 'id_usuario_referencia = "' . $id_usuario . '"',
            21 => 'id_usuario_entrega = "' . $id_usuario . '"',
        ];
        $extra_usuario = $casos[$id_perfil];
        $extra_dia = ($dia > 0) ? ' AND DATE(fecha_contra_entrega) =  DATE(CURRENT_DATE())' : '';

        $query_get = "SELECT 
						id_servicio, 
						id_proyecto_persona_forma_pago id_recibo,
						(monto_a_pagar * num_ciclos_contratados) total,
						fecha_contra_entrega,
						id_usuario_referencia,
						id_usuario_entrega,
						ubicacion,
						tipo_entrega						 
						FROM  proyecto_persona_forma_pago 
						WHERE  
						saldo_cubierto < 1  
						AND " . $extra_usuario . " 						  
						AND  se_cancela < 1 
						AND  status NOT IN (10,19)
						AND 					
						(
                            DATE(fecha_contra_entrega) >=  DATE(CURRENT_DATE())
                            OR
                            DATE(fecha_vencimiento) >=  DATE(CURRENT_DATE())
                            OR
                            DATE(fecha_entrega) >=  DATE(CURRENT_DATE())						
						) 
						" . $extra_dia . "
						AND id_usuario NOT IN (SELECT id_usuario FROM lista_negra)
						ORDER BY fecha_contra_entrega ASC  
						";
        return $this->db->query($query_get)->result_array();
    }

    function get_tiempo_venta($param, $total = 0)
    {


        $extra = " ";
        $extra_innner = " WHERE 1 = 1 ";
        $extra_tiempo = "";
        if (array_key_exists("id_usuario", $param) && $param["id_usuario"] > 0) {

            $extra = " AND id_usuario_venta = '" . $param["id_usuario"] . "' ";

        }
        if (array_key_exists("q", $param) && strlen($param["q"]) > 2) {

            $extra_innner = " LEFT OUTER JOIN  servicio s ON p.id_servicio = s.id_servicio 
            WHERE nombre_servicio LIKE  '%" . $param['q'] . " %'   ";

        }

        if ($param["fecha_inicio"] != $param["fecha_termino"]) {

            $fecha_inicio = $param['fecha_inicio'];
            $fecha_termino = $param['fecha_termino'];
            $extra_tiempo = " AND DATE( p.fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'  ";

        }

        $query_get = "";
        if ($total > 0) {

            $query_get = "
	            SELECT  
                  
                COUNT(0)total , 
                p.id_servicio 
                FROM 
                proyecto_persona_forma_pago p
                " . $extra_innner . "                                   
                AND 
                p.id_servicio >  0
                " . $extra . "
                " . $extra_tiempo . "
                GROUP BY 
                p.id_servicio 
                ORDER BY  
                COUNT(0) desc
                ";


        } else {

            $query_get = "
	            SELECT  
                AVG( DATEDIFF(p.fecha_entrega ,  p.fecha_registro ))dias,  
                COUNT(0)total , 
                p.id_servicio 
                FROM 
                proyecto_persona_forma_pago p
                " . $extra_innner . "                  
                AND  
                p.saldo_cubierto > 1 
                AND 
                p.id_servicio >  0
                " . $extra . "
                " . $extra_tiempo . "
                GROUP BY 
                p.id_servicio 
                ORDER BY  
                COUNT(0) desc
                ";


        }

        return $this->db->query($query_get)->result_array();

    }

    function get_recibo_ventas_pagas_servicio($id_servicio, $fecha_inicio, $fecha_termino)
    {

        $extra_fecha = "";

        if (strlen($fecha_inicio) > 3 && strlen($fecha_termino) > 3) {

            $extra_fecha = "  
                            AND  
                            DATE(p.fecha_registro) 
                            BETWEEN '{$fecha_inicio}'
                            AND 
                            '{$fecha_termino}' ";
        }
        $query_get = "SELECT 
                            p.id_proyecto_persona_forma_pago  recibo,
                            p.saldo_cubierto  
                            FROM proyecto_persona_forma_pago p 
                            WHERE                             
                            p.saldo_cubierto > 1
                            AND 
                                 id_servicio = {$id_servicio}                         
                            " . $extra_fecha;


        return $this->db->query($query_get)->result_array();

    }

    function sin_tags_arquetipo($id_empresa)
    {
        $query_get = "SELECT 
                        id_proyecto_persona_forma_pago id_recibo, 
                        saldo_cubierto 
                        FROM 
                        proyecto_persona_forma_pago  p  
                        WHERE                    
                        saldo_cubierto >  0 
                        AND 
                        status NOT IN (10,19)
                        AND 
                        es_test < 1 
                        AND
                        id_usuario 
                        NOT IN (SELECT id_usuario FROM tag_arquetipo GROUP BY id_usuario)
                        AND 
                        id_usuario IN (SELECT id_usuario FROM usuario WHERE idempresa = $id_empresa)
                        ORDER BY id_proyecto_persona_forma_pago DESC LIMIT 5";

        return $this->db->query($query_get)->result_array();
    }

    function reventa($id_vendedor)
    {
        $query_get = "SELECT  
                        id_proyecto_persona_forma_pago id_recibo, 
                        id_servicio, 
                        id_usuario 
                        FROM proyecto_persona_forma_pago 
                        WHERE saldo_cubierto > 0 
                        AND intento_reventa < 1 AND fecha_contra_entrega <  DATE_ADD(CURRENT_DATE(), INTERVAL -15 DAY) 
                        AND se_cancela < 1 AND cancela_cliente < 1
                        AND 
                        (
                            id_usuario_referencia = '" . $id_vendedor . "' OR id_usuario_venta = '" . $id_vendedor . "'
                        ) 
                        AND id_usuario NOT IN (SELECT id_usuario FROM lista_negra)                        
                         ORDER BY id_proyecto_persona_forma_pago DESC LIMIT 50";

        return $this->db->query($query_get)->result_array();
    }

    function recuperacion($id_vendedor)
    {
        $query_get = "SELECT  
                        id_proyecto_persona_forma_pago id_recibo, id_servicio 
                        FROM 
                        proyecto_persona_forma_pago p 
                        WHERE
                        es_test < 1 
                        AND p.saldo_cubierto < 1                        
                        AND p.intento_recuperacion < 1
                        AND p.id_proyecto_persona_forma_pago > 384                    
                        AND DATE(p.fecha_contra_entrega) < DATE(DATE_ADD(CURRENT_DATE(), INTERVAL -1 DAY))
                        AND 
                        (
                        p.id_usuario_referencia = '" . $id_vendedor . "'
                        OR 
                        p.id_usuario_venta = '" . $id_vendedor . "' 
                        )
                        AND p.id_usuario NOT IN (SELECT id_usuario FROM lista_negra)                        
                        LIMIT 5";

        return $this->db->query($query_get)->result_array();
    }


    function notificacion_intento_reventa($id_recibo)
    {
        $query_get = "UPDATE proyecto_persona_forma_pago 
                        SET intento_reventa = (intento_reventa + 1) 
                        WHERE id_proyecto_persona_forma_pago = '" . $id_recibo . "' LIMIT 1 ";

        return $this->db->query($query_get);
    }

    function notificacion_intento_recuperacion($id_recibo)
    {
        $query_get = "UPDATE proyecto_persona_forma_pago 
                        SET intento_recuperacion = (intento_recuperacion + 1) 
                        WHERE id_proyecto_persona_forma_pago = '" . $id_recibo . "' LIMIT 1 ";

        return $this->db->query($query_get);
    }

    function reparto_recoleccion($param)
    {

        $tipo_entrega = prm_def($param, 'tipo_entrega');
        $extra_tipo_entrega = ($tipo_entrega > 0) ? " AND p.tipo_entrega = '" . $tipo_entrega . "' " : '';
        $repartidor = prm_def($param, 'repartidor');
        $extra_repartidor = ($repartidor > 0) ? " AND p.id_usuario_entrega = '" . $repartidor . "' " : '';


        $fecha_inicio = prm_def($param, 'fecha_inicio');
        $fecha_termino = prm_def($param, 'fecha_termino');
        $tipo_orden = prm_def($param, "tipo_orden");
        $ops_tipo_orden = ["", "fecha_registro", "fecha_entrega", "fecha_cancelacion", "fecha_pago", "fecha_contra_entrega"];
        $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_termino . "' ";
        $extra_fecha = ($tipo_orden > 0) ? $extra : '';
        $order_fecha = ($tipo_orden > 0) ? " ORDER BY p." . $ops_tipo_orden[$tipo_orden] . " DESC" : " ";

        $query_get = "SELECT 
                        p.id_proyecto_persona_forma_pago recibo ,
                        p.id_servicio ,
                        p.fecha_contra_entrega, 
                        p.saldo_cubierto, 
                        p.fecha_contra_entrega, 
                        p.tipo_entrega ,
                        p.num_ciclos_contratados , 
                        p.id_usuario_entrega , 
                        p.monto_a_pagar ,
                        p.costo_envio_cliente, 
                        u.nombre nombre_repartidor , 
                        u.apellido_paterno apellido_repartidor   ,
                        t.nombre nombre_tipo_entrega
                        FROM proyecto_persona_forma_pago p 
                        INNER JOIN usuario u 
                        ON p.id_usuario_entrega = u.idusuario  
                        INNER JOIN tipo_entrega t 
                        ON 
                        t.id =  p.tipo_entrega
                        WHERE 
                        saldo_cubierto > 0 
                        and 
                        efectivo_en_casa < 1 " . $extra_repartidor . $extra_tipo_entrega . $extra_fecha . $order_fecha;

        return $this->db->query($query_get)->result_array();
    }

    function espacios($id_recibo)
    {

        $query_get = "SELECT id_usuario_entrega FROM proyecto_persona_forma_pago 
                        WHERE  
                        id_proyecto_persona_forma_pago != '" . $id_recibo . "' 
                        AND  
                        fecha_contra_entrega = (
                        SELECT fecha_contra_entrega 
                        FROM proyecto_persona_forma_pago 
                        WHERE 
                        id_proyecto_persona_forma_pago = '" . $id_recibo . "') 
                        ORDER BY id_usuario_entrega DESC";

        return $this->db->query($query_get)->result_array();
    }

    function recibos_efectivo_en_casa($recibos)
    {

        $keys = get_keys($recibos);
        $query_update = "UPDATE proyecto_persona_forma_pago 
            SET efectivo_en_casa = 1 WHERE id_proyecto_persona_forma_pago IN({$keys})";

        return $this->db->query($query_update);

    }

    function franja_horaria($franja_horaria, $id_usuario, $id_perfil, $id_empresa)
    {

        $casos = [
            3 => '1 = 1',
            4 => "id_usuario IN (SELECT id_usuario FROM usuario WHERE idempresa = $id_empresa)",
            6 => 'id_usuario_referencia = "' . $id_usuario . '"',
            21 => 'id_usuario_entrega = "' . $id_usuario . '"',
        ];
        $extra_usuario = $casos[$id_perfil];

        $query_get = 'SELECT 
                        id_proyecto_persona_forma_pago, 
                        id_servicio,
                        num_ciclos_contratados ,
                        fecha_contra_entrega
                        FROM proyecto_persona_forma_pago 
                        WHERE
                        (
                            fecha_entrega = "' . $franja_horaria . '"
                            OR
                            fecha_contra_entrega = "' . $franja_horaria . '" 
                             
                        )
                        AND ' . $extra_usuario . ' ';

        return $this->db->query($query_get)->result_array();
    }

    function ordenes_por_telefono($telefono)
    {


        $query_get = "SELECT  id_proyecto_persona_forma_pago 
                        FROM proyecto_persona_forma_pago 
                        WHERE  id_usuario  
                        IN( SELECT idusuario FROM usuario WHERE tel_contacto  = '" . $telefono . "' )";

        return $this->db->query($query_get)->result_array();

    }

    function boletina_ordenes($array_ids)
    {

        $ids = get_keys($array_ids);
        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET                              
                            status          =  19 ,                           
                            se_cancela      =  1                                           
                          WHERE 
                            id_proyecto_persona_forma_pago IN ($ids) 
                          LIMIT 100";
        return $this->db->query($query_update);
    }

    function pago_recibos_comisiones($usuario)
    {

        $query_set = 'UPDATE proyecto_persona_forma_pago SET flag_pago_comision = 1 
                    WHERE id_proyecto_persona_forma_pago IN 
                    (SELECT * FROM (
                    SELECT id_proyecto_persona_forma_pago FROM proyecto_persona_forma_pago 
                    WHERE id_usuario_referencia = ' . $usuario . ' AND se_cancela < 1 AND cancela_cliente < 1 
                    AND saldo_cubierto > 0 AND flag_pago_comision < 1 ) as t)';
        return $this->db->query($query_set);

    }

    function pago_recibos_comisiones_ids($ids)
    {

        $query_set = _text_('UPDATE 
                    proyecto_persona_forma_pago SET flag_pago_comision = 1 
                    WHERE id_proyecto_persona_forma_pago IN 
                    (SELECT * FROM (
                    SELECT id_proyecto_persona_forma_pago FROM proyecto_persona_forma_pago 
                    WHERE id_usuario_referencia IN(', $ids, ') 
                    AND se_cancela < 1 AND cancela_cliente < 1 
                    AND saldo_cubierto > 0 AND flag_pago_comision < 1 ) as t)');
        return $this->db->query($query_set);

    }


    function comisiones_por_pago($id_empresa, $ids_usuarios_empresa)
    {
        $in_usuarios = get_keys($ids_usuarios_empresa);
        $extra_tipo_usuario = "AND 
                        (
                        p.id_usuario_venta IN($in_usuarios) || 
                        p.id_usuario_referencia IN($in_usuarios) || 
                        p.id_usuario_entrega IN($in_usuarios) || 
                        p.id_usuario IN($in_usuarios)  
                        )";
        $query_get = "SELECT 
                        p.id_usuario,
                        p.id_proyecto_persona_forma_pago,
                        p.id_servicio,
                        p.id_usuario_referencia, 
                        p.comision_venta, 
                        p.id_usuario_referencia ,
                        u.nombre,
                        u.apellido_paterno,
                        u.apellido_materno,
                        po.id_orden_compra
                        FROM 
                        proyecto_persona_forma_pago p 
                        INNER JOIN usuario u  
                        ON p.id_usuario_referencia =  u.idusuario
                        INNER JOIN
                            producto_orden_compra po 
                        ON p.id_proyecto_persona_forma_pago = po.id_proyecto_persona_forma_pago
                        WHERE  
                        flag_pago_comision < 1  
                        AND se_cancela < 1  
                        AND saldo_cubierto > 0 
                        " . $extra_tipo_usuario . "
                        AND  p.status 
                        NOT IN (10,19)  
                        AND id_usuario 
                        NOT IN (SELECT id_usuario FROM lista_negra)
                        ORDER BY p.id_usuario_referencia";

        return $this->db->query($query_get)->result_array();
    }

    function top($fecha_inicio, $fecha_termino)
    {

        $query_get = "SELECT id_servicio , 
                        SUM(num_ciclos_contratados) total  
                        FROM proyecto_persona_forma_pago 
                        WHERE saldo_cubierto > 0 
                        AND 
                        DATE(fecha_entrega) 
                        BETWEEN 
                        '" . $fecha_inicio . "' 
                        AND 
                        '" . $fecha_termino . "'                      
                        AND status not IN ( 10, 19 ) 
                        AND 
                        se_cancela < 1 
                        AND 
                        cancela_cliente < 1 
                        GROUP BY id_servicio 
                        ORDER BY COUNT(0) DESC LIMIT 10";

        return $this->db->query($query_get)->result_array();

    }

    function top_cancelaciones($fecha_inicio, $fecha_termino)
    {

        $query_get = "SELECT id_servicio , 
                        SUM(num_ciclos_contratados) total  
                        FROM proyecto_persona_forma_pago 
                        WHERE 
                        DATE(fecha_cancelacion) 
                        BETWEEN 
                        '" . $fecha_inicio . "' AND '" . $fecha_termino . "'                      
                        AND 
                        ( 
                        status  IN ( 10, 19 ) 
                        OR 
                        se_cancela < 1 
                        OR 
                        cancela_cliente < 1
                        ) 
                        GROUP BY id_servicio 
                        ORDER BY COUNT(0) DESC LIMIT 10";

        return $this->db->query($query_get)->result_array();

    }

    function top_fecha($fecha_inicio, $fecha_termino)
    {

        $query_get = "SELECT 
                        DATE(fecha_entrega)fecha , 
                        SUM(num_ciclos_contratados) total  
                        FROM proyecto_persona_forma_pago 
                        WHERE saldo_cubierto > 0 
                        AND 
                        DATE(fecha_entrega) 
                        BETWEEN 
                        '" . $fecha_inicio . "' AND '" . $fecha_termino . "'            
                        AND status not IN ( 10, 19 ) 
                        AND 
                        se_cancela < 1 
                        AND 
                        cancela_cliente < 1 
                        GROUP BY DATE(fecha_entrega)";

        return $this->db->query($query_get)->result_array();

    }

    function top_horas($fecha_inicio, $fecha_termino)
    {

        $query_get = "SELECT 
                        HOUR(fecha_entrega)hora , 
                        SUM(num_ciclos_contratados) total  
                        FROM proyecto_persona_forma_pago 
                        WHERE saldo_cubierto > 0 
                        AND 
                        DATE(fecha_entrega)
                        BETWEEN 
                        '" . $fecha_inicio . "' AND '" . $fecha_termino . "'            
                        AND status not IN ( 10, 19 ) 
                        AND 
                        se_cancela < 1 
                        AND 
                        cancela_cliente < 1 
                        GROUP 
                        BY HOUR(fecha_entrega)
                        ORDER BY SUM(num_ciclos_contratados) DESC";

        return $this->db->query($query_get)->result_array();

    }


    function top_fecha_cancelaciones($fecha_inicio, $fecha_termino)
    {

        $query_get = "SELECT 
                        DATE(fecha_cancelacion)fecha , 
                        SUM(num_ciclos_contratados) total  
                        FROM proyecto_persona_forma_pago 
                        WHERE 
                        DATE(fecha_cancelacion) 
                        BETWEEN 
                        '" . $fecha_inicio . "' AND '" . $fecha_termino . "'            
                        AND 
                        ( 
                            status  IN ( 10, 19 ) 
                            OR  
                            se_cancela < 1 
                            OR  
                            cancela_cliente < 1
                        ) 
                        GROUP BY DATE(fecha_cancelacion)";

        return $this->db->query($query_get)->result_array();

    }


    function ventas_menos_tiempo($dias = '')
    {
        $tiempo = _text_(" DATE(fecha_entrega) = DATE(CURRENT_DATE())", $dias);

        $query_get = "SELECT                          
                        COUNT(0) total  
                        FROM proyecto_persona_forma_pago 
                        WHERE saldo_cubierto > 0 
                        AND                                                 
                        " . $tiempo . "           
                        AND status NOT IN ( 10, 19 ) 
                        AND 
                        se_cancela < 1 
                        AND 
                        cancela_cliente < 1 ";

        return $this->db->query($query_get)->result_array()[0]['total'];

    }

    function clientes_frecuentes()
    {

        $_num = mt_rand();
        $this->crea_tabla_clientes_frecuentes($_num, 0);
        $query_get = _text_(
            "SELECT * FROM ",
            "tmp_clientes_$_num"

        );
        $response = $this->db->query($query_get)->result_array();
        $this->crea_tabla_clientes_frecuentes($_num, 1);
        return $response;


    }

    function crea_tabla_clientes_frecuentes($_num, $flag)
    {

        $response = $this->db->query(get_drop("tmp_clientes_$_num"));
        if ($flag == 0) {
            $query_create = "CREATE TABLE tmp_clientes_$_num 
                            AS
                            SELECT  
                            p.id_usuario,                             
                            u.tel_contacto, 
                            u.email,
                            u.nombre,
                            u.apellido_paterno,
                            u.apellido_materno                                                     
                            FROM  
                            proyecto_persona_forma_pago p 
                            INNER JOIN  usuario u  
                            ON u.idusuario =  p.id_usuario 
                            WHERE  
                            p.status != 19  
                            AND 
                            p.cancela_email < 1 
                            AND 
                            p.cancela_cliente < 1 
                            AND 
                            p.se_cancela < 1 
                            AND 
                            p.saldo_cubierto > 0
                            AND u.tel_contacto 
                            IS NOT NULL
                            GROUP BY u.email";
            $response = $this->db->query($query_create);
        }
        return $response;

    }


}   
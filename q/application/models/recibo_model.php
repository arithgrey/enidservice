<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
                            se_cancela      =  1                  
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

        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET 
                            saldo_cubierto  =  {$saldo_cubierto} , 
                            status          =  {$status} ,
                            {$tipo_fecha}   =   CURRENT_TIMESTAMP()   ,
                            entregado       =   1                         
                          WHERE 
                            id_proyecto_persona_forma_pago =  {$id} 
                          LIMIT 1";
        return $this->db->query($query_update);
    }

    function get_q($params, $param)
    {


        $f = get_keys($params);
        $tipo_entrega = $param["tipo_entrega"];
        $status_venta = $param["status_venta"];
        $query_get = "SELECT " . $f . " FROM proyecto_persona_forma_pago p  ";
        $ext_usuario = $this->get_usuario($param);
        $ext_contra_entrega = ($tipo_entrega == 0) ? "" : " AND  p.tipo_entrega = '" . $tipo_entrega . "'";
        $extra_extatus_venta = ($status_venta == 0) ? "" : "  AND p.status = '" . $status_venta . "' ";
        $ext_fecha = $this->get_fecha($param);

        $query_get .= $ext_usuario . $ext_contra_entrega . $extra_extatus_venta . $ext_fecha . " ORDER BY p.fecha_registro DESC";
        return $this->db->query($query_get)->result_array();

    }

    private function get_usuario($param)
    {

        $sql = " WHERE 1=1 ";
        if (strlen(trim($param["cliente"])) > 0) {
            $cliente = $param["cliente"];
            $sql = " INNER JOIN usuario u ON 
                                    p.id_usuario =  u.idusuario 
                                    WHERE 
                                        u.nombre LIKE '%{$cliente}%' 
                                    OR
                                        u.apellido_paterno LIKE '%{$cliente}%'
                                    OR
                                        u.apellido_materno LIKE '%{$cliente}%'
                                    OR
                                        u.tel_contacto LIKE '%{$cliente}%'
                                    OR
                                        u.email        LIKE '%{$cliente}%'
                                    ";
        }
        return $sql;
    }

    function get_total_compras_usuario($id_usuario)
    {


        $query_get =
            "SELECT COUNT(0)num FROM proyecto_persona_forma_pago WHERE saldo_cubierto >  0 AND id_usuario = " . $id_usuario;
        return $this->db->query($query_get)->result_array()[0]["num"];
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
                $extra = " AND DATE(p." . $ops_tipo_orden[$tipo_orden] . ") BETWEEN '" . $fecha_inicio . "' AND DATE_ADD('" . $fecha_termino . "' ,  INTERVAL 1 DAY)  ";

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
        $query_get = "SELECT 
                      * 
                    FROM 
                      proyecto_persona_forma_pago 
                    WHERE 
                      status =  $tipo 
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

    function cancela_orden_compra($param)
    {

        $cancelar = ($param["cancela_cliente"] == 1) ? 1 : 0;
        $query_update =
            "UPDATE proyecto_persona_forma_pago 
          SET 
          status            = 10,
          fecha_cancelacion = CURRENT_DATE(), 
          cancela_cliente   = $cancelar,
          se_cancela        = 1
          WHERE  id_proyecto_persona_forma_pago =  '" . $param["id_recibo"] . "' LIMIT 1";

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

        if ($param["modalidad"] > 0 ) {

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

        $query_get = "SELECT 
                    *
                  FROM proyecto_persona_forma_pago 
                  WHERE 
                    id_proyecto_persona_forma_pago = '" . $param["id_recibo"] . "'
                  AND 
                    id_usuario =  '" . $param["id_usuario"] . "'
                  AND 
                    monto_a_pagar > saldo_cubierto 
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

    /*
    function get_ventas_usuario($param)
    {

        $where = $this->get_where_estado_venta($param, 1);
        $query_get = "SELECT
                        id_proyecto_persona_forma_pago ,
                        resumen_pedido,
                        id_servicio,
                        monto_a_pagar,
                        costo_envio_cliente,
                        saldo_cubierto,
                        status,
                        fecha_registro,
                        num_ciclos_contratados,
                        estado_envio
                        FROM
                          proyecto_persona_forma_pago
                        " . $where . " ORDER BY fecha_registro DESC";
        $response["data"] = $this->db->query($query_get)->result_array();
        return $response;
    }
    */
    function get_compras_usuario($param, $status = 0)
    {

        $where = $this->get_where_estado_venta($param, $status);
        $query_get = "SELECT
                    id_proyecto_persona_forma_pago ,
                    resumen_pedido,
                    id_servicio,
                    monto_a_pagar,
                    costo_envio_cliente,
                    saldo_cubierto,
                    status,
                    fecha_registro,
                    num_ciclos_contratados,
                    estado_envio
                  FROM
                  proyecto_persona_forma_pago
                  " . $where . " ORDER BY fecha_registro DESC";


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

    function set_fecha_contra_entrega($id_recibo, $fecha)
    {


        $this->db->set('modificacion_fecha', 'modificacion_fecha + 1', FALSE);
        $this->db->set('fecha_contra_entrega', $fecha);
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
        return $this->get([" COUNT(0)num "], ["DATE(fecha_registro)" => $param["fecha"]])[0]["num"];

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
                      status IN (1, 6, 7,9, 11, 12)
                      AND se_cancela =0";
                    break;

                default:

                    break;
            }
        }
        return $sql;
    }

    function crea_resumen_compra($servicio, $num_ciclos, $flag_envio_gratis, $tipo_entrega = 0)
    {

        if ($tipo_entrega == 0) {

            $resumen = "";
            $resumen = $num_ciclos . " " . $servicio["nombre_servicio"];

            if ($flag_envio_gratis == 1) {
                $resumen .= " - Envío gratis";
            }
            return $resumen;

        } else {
            $resumen = "";
            $resumen = $num_ciclos . " " . $servicio["nombre_servicio"];
        }

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
        if ($data_usuario["tipo_entrega"] != 2) {
            $tipo_entrega = $data_usuario["tipo_entrega"];
        }

        $id_forma_pago = ($tipo_entrega == 1) ? 8 : 6;
        $fecha_vencimiento = "DATE_ADD(CURRENT_DATE(), INTERVAL 2 DAY)";
        $id_usuario = $param["id_usuario"];


        $id_usuario_referencia =
            (get_info_usuario_valor_variable($data_usuario, "usuario_referencia") == 0)
                ? $id_usuario : $data_usuario["usuario_referencia"];


        $num_ciclos = $data_usuario["num_ciclos"];
        $servicio = $param["servicio"];
        $id_servicio = $servicio["id_servicio"];
        $flag_envio_gratis = $servicio["flag_envio_gratis"];
        $id_usuario_venta = $servicio["id_usuario_venta"];
        $precio = $servicio["precio"];

        $resumen_compra =
            $this->crea_resumen_compra($servicio, $num_ciclos, $flag_envio_gratis, $tipo_entrega);

        $costo_envio_cliente = 0;
        $costo_envio_vendedor = 0;
        $flag_servicio = ($tipo_entrega < 5) ? 0 : $servicio["flag_servicio"];
        $monto_a_pagar = $precio;
        if ($flag_servicio == 0 && $tipo_entrega > 1) {

            $costo_envio = $param["costo_envio"];
            $costo_envio_cliente = $costo_envio["costo_envio_cliente"];
            $costo_envio_vendedor = $costo_envio["costo_envio_vendedor"];

        } else {

            $costo_envio_cliente = $param["costo_envio"];
            $costo_envio_vendedor = 0;

        }
        $id_ciclo_facturacion = $param["id_ciclo_facturacion"];
        $talla = $param["talla"];


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
            "tipo_entrega"
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
                $tipo_entrega
            ];


        if ($tipo_entrega == 1) {
            array_push($array_keys, "fecha_contra_entrega");
            array_push($array_values, "'" . $data_usuario["fecha_entrega"] . "'");
        }

        $keys = get_keys($array_keys);
        $values = get_keys($array_values);
        $query_insert = "INSERT INTO proyecto_persona_forma_pago(" . $keys . ") VALUES(" . $values . ")";

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

    function pendientes_sin_cierre($id_usuario)
    {

        $query_get = "SELECT 
						id_servicio, 
						id_proyecto_persona_forma_pago	 id_recibo,
						(monto_a_pagar * num_ciclos_contratados) total					 
						FROM  proyecto_persona_forma_pago 
						WHERE  
						saldo_cubierto < 1  
						and id_usuario_venta ='" . $id_usuario . "' 
						AND  se_cancela = 0
						AND 
						
						(
						DATE(fecha_contra_entrega) <=  DATE(CURRENT_DATE())
						OR
						DATE(fecha_vencimiento) <=  DATE(CURRENT_DATE())
						OR
						DATE(fecha_entrega) <=  DATE(CURRENT_DATE())
						
						)   
						";
        return $this->db->query($query_get)->result_array();
    }

    function get_tiempo_venta($param, $total = 0)
    {


        $extra = " ";
        $extra_innner = " WHERE 1 = 1 ";
        if (array_key_exists("id_usuario", $param) && $param["id_usuario"] > 0) {

            $extra = " AND id_usuario_venta = '" . $param["id_usuario"] . "' ";

        }
        if (array_key_exists("q", $param) && strlen($param["q"]) > 2) {

            $extra_innner = " LEFT OUTER JOIN  servicio s ON p.id_servicio = s.id_servicio 
            WHERE nombre_servicio LIKE  '%".$param['q']." %'   ";

        }

        $query_get  = "";
        if($total >  0 ){

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
                GROUP BY 
                p.id_servicio 
                ORDER BY  
                COUNT(0) desc
                ";



        }else{

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
                GROUP BY 
                p.id_servicio 
                ORDER BY  
                COUNT(0) desc
                ";



        }

        return $this->db->query($query_get)->result_array();

    }

}   
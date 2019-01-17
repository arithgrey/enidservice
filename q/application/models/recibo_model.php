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

        $campo_usuario = "id_usuario";
        if ($param["modalidad"] == 1) {
            $campo_usuario = "id_usuario_venta";
        }
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

    /**/
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

    function set_fecha_contra_entrega($id_recibo, $fecha){


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
        return
            $this->get([" COUNT(0)num "], ["DATE(fecha_registro)" => $param["fecha"]])[0]["num"];
    }

    /*
    function get_estatus_servicio_enid_service(){

        $params =  ["id_estatus_enid_service","nombre","text_cliente","text_vendedor" ];
        return $this->get("status_enid_service", $params, ["pago"=> 1], 10);
    }
    */
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
                      status = 1
                    AND 
                      saldo_cubierto>=monto_a_pagar";
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
                      status = 6
                      AND se_cancela =0";
                    break;

                default:

                    break;
            }
        }
        return $sql;
    }

    function get_compras_usuario($param)
    {

        $where = $this->get_where_estado_venta($param);
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

        $data_complete["data"] = $this->db->query($query_get)->result_array();
        return $data_complete;
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

    /**/
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



    /*
  function crea_direccion_envio_pedido($param){

    $direccion =  $param["direccion"];
    $id_proyecto_persona_forma_pago =  $param["id_proyecto_persona_forma_pago"];
      
      
      $params       = ["direccion" => $direccion];
      $id_direccion = $this->insert( "direccion" , $param , 1);
     
      $params = [
        "id_proyecto_persona_forma_pago"  =>  $id_proyecto_persona_forma_pago , 
        "id_direccion"                    =>  $id_direccion 
      ];
      return $this->insert("proyecto_persona_forma_pago_direccion" , $params , 1);

    
  } 
  */
    /*


      function notifica_email_enviado_recordatorio($param){

        $id_recibo =  $param["id_recibo"];
        $query_update = "UPDATE
                        proyecto_persona_forma_pago
                        SET
                        num_email_recordatorio =  num_email_recordatorio + 1
                        WHERE
                        id_proyecto_persona_forma_pago =  $id_recibo LIMIT 1";

          return $this->db->query($query_update);
      }


      function get_historial_pagos($param){

        $id_proyecto_persona= $param["id_proyecto_persona"];
        $query_get ="SELECT
                      ppf.* ,
                      f.forma_pago ,
                      u.nombre nombre_usuario_validacion,
                      u.apellido_paterno apellido_paterno_usuario_validacion  ,
                      u.apellido_materno apellido_materno_usuario_validacion  ,

                      DATEDIFF(
                      ppf.fecha_vencimiento ,
                      date(current_date()))dias_restantes,
                      ppf.fecha_vencimiento_anticipo,

                      DATEDIFF(
                      ppf.fecha_vencimiento_anticipo ,
                      date(current_date()))dias_restantes_anticipo

                    FROM
                      proyecto_persona_forma_pago ppf
                    INNER JOIN
                      forma_pago f
                    ON
                      ppf.id_forma_pago =  f.id_forma_pago
                    LEFT OUTER JOIN
                      usuario u
                    ON ppf.id_usuario_validacion =  u.idusuario
                    WHERE
                      id_proyecto_persona =  $id_proyecto_persona
                    ORDER BY
                    fecha_registro DESC";

        $result =  $this->db->query($query_get);
        return $result->result_array();
    }

      function get_info_persona($param){

        $query_get = "SELECT
                        *
                      FROM persona
                      WHERE
                      id_persona = '".$param["id_persona"]."'
                      LIMIT 1  ";
        $result =  $this->db->query($query_get);
        return $result->result_array();
      }

      function get_resumen_proyecto_persona($param){

        $id_proyecto_persona = $param["id_proyecto_persona"];
        $query_get ="SELECT
                      pp.* ,
                      pp.fecha_registro fecha_inicio,
                      p.*,
                      c.ciclo,
                      DATEDIFF(pp.siguiente_vencimiento ,date(current_date()) )dias_restantes_vencimiento
                    FROM
                      proyecto_persona  pp
                    INNER JOIN proyecto p
                      ON pp.id_proyecto  =  p.id_proyecto
                    INNER JOIN ciclo_facturacion c
                      ON
                    pp.ciclo_facturacion = c.id_ciclo_facturacion
                      WHERE
                    id_proyecto_persona = $id_proyecto_persona
                    LIMIT 1";

        $result = $this->db->query($query_get );
        return $result->result_array();
      }


      function get_nombre_persona($id_usuario){

          $query_get = "SELECT
                          nombre   ,
                          apellido_paterno ,
                          apellido_materno
                        FROM
                          usuario
                        WHERE
                        idusuario = $id_usuario LIMIT 1";

          $result=  $this->db->query($query_get);
          return $result->result_array();
      }

      function get_comentarios_por_pago_notificado($param){

         $id_notificacion_pago =  $param["id_notificacion_pago"];

         $query_get = "SELECT
                        *
                      FROM
                      comentario_pago
                      WHERE
                      id_notificacion_pago
                      =
                      '".$id_notificacion_pago."'
                      LIMIT 10";

         $result =  $this->db->query($query_get);
         return $result->result_array();


      }

      function registra_comentario_pago_notificado($param){

        $comentario =  $param["comentario"];
        $id_notificacion_pago =  $param["id_notificacion_pago"];
        $id_usuario =  $param["id_usuario"];

        $query_insert ="INSERT INTO comentario_pago(
                          comentario,
                          id_notificacion_pago
                        )VALUES(
                          '".$comentario."' ,
                          ".$id_notificacion_pago."
                        )";

        return $this->db->query($query_insert);

      }

      function get_id_proyecto_servicio_por_ppfp($id_proyecto_persona_forma_pago){

         $query_get ="SELECT
                      pp.id_proyecto_persona
                      FROM
                      proyecto_persona_forma_pago ppfp
                      INNER JOIN
                      proyecto_persona pp
                      ON  ppfp.id_proyecto_persona =  pp.id_proyecto_persona
                      WHERE
                      id_proyecto_persona_forma_pago = $id_proyecto_persona_forma_pago LIMIT 1";

          $result =  $this->db->query($query_get);
          $data =   $result->result_array();
          return $data[0]["id_proyecto_persona"];


      }











      function get_persona_por_usuario($param){

          $query_get ="SELECT
                          id_persona
                      FROM
                          persona
                      WHERE
                      id_usuario_enid_service = '".$param["id_usuario"]."'
                      LIMIT 1";
          $result =  $this->db->query($query_get);
          return $result->result_array()[0]["id_persona"];
      }





      function get_fechas_por_ciclo_facturacion($id_ciclo_facturacion ,
        $num_ciclos){


        $data_complete =[];
        switch ($id_ciclo_facturacion) {
          case 1:

            $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , INTERVAL  ".$num_ciclos." YEAR) ";
            $nombre_periodo =" años contratados ";

            $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
            $data_complete["nombre_periodo"] =  $nombre_periodo;
            break;

          case 2:

            $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() ,
                                      INTERVAL  ".$num_ciclos." MONTH) ";

            $nombre_periodo =" Meses contratados ";


            $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
            $data_complete["nombre_periodo"] =  $nombre_periodo;

            break;


          case 5:

            $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() ,
                                      INTERVAL  1 DAY) ";
            $nombre_periodo =" ";

            $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
            $data_complete["nombre_periodo"] =  $nombre_periodo;
            break;




          default:

            break;
        }

        return $data_complete;
      }

    function get_id_usuario_ventas_servicio($id_servicio){

        $query_get ="SELECT id_usuario FROM servicio WHERE id_servicio =  $id_servicio LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["id_usuario"];
    }

      function get_servicio_por_id_servicio($id_servicio){

          $query_get = "SELECT
                          *
                        FROM
                        servicio
                        WHERE
                        id_servicio ='".$id_servicio."' ";

          $result =  $this->db->query($query_get);
          return $result->result_array();
      }



      function get_proyecto_persona_por_id_proyecto_persona($param){

          $id_proyecto_persona_forma_pago =   $param["id_proyecto_persona_forma_pago"];


          $query_get ="SELECT
                          id_proyecto_persona
                      FROM
                          proyecto_persona_forma_pago
                      WHERE
                          id_proyecto_persona_forma_pago
                      =
                      '".$id_proyecto_persona_forma_pago."'";


          $result =  $this->db->query($query_get);
          return $result->result_array()[0]["id_proyecto_persona"];

      }



      function agrega_usuarios_a_saldos_pendientes($saldos_pendientes){

        $nueva_data =  [];
        $a =0;
        foreach($saldos_pendientes as $row){

            $nueva_data[$a] =$row;

            $usr_proyecto=$this->get_id_usuario_por_id_proyecto_persona($row["id_proyecto_persona"]);
            $nueva_data[$a]["id_usuario"] =$usr_proyecto[0]["id_usuario"];
            $nueva_data[$a]["id_proyecto"] =$usr_proyecto[0]["id_proyecto"];


            $a ++;
        }
        return $nueva_data;
      }

      function get_id_usuario_por_id_proyecto_persona($id_proyecto_persona){

          $query_get ="SELECT id_usuario , id_proyecto FROM proyecto_persona
                      WHERE id_proyecto_persona=$id_proyecto_persona LIMIT 1";
          $result =  $this->db->query($query_get);
          return $result->result_array();

      }

      function agrega_servicios_a_saldos($saldos_pendientes){

        $nueva_data =  [];
        $a =0;
        foreach($saldos_pendientes as $row){
            $nueva_data[$a] =$row;
            $id_servicio=$this->get_id_servicio_por_proyecto($row["id_proyecto"]);
            $nueva_data[$a]["id_servicio"] =$id_servicio;
            $a ++;
        }
        return $nueva_data;
      }

      function get_id_servicio_por_proyecto($id_proyecto){

          $query_get ="SELECT id_servicio FROM proyecto
                      WHERE id_proyecto=$id_proyecto LIMIT 1";
          $result =  $this->db->query($query_get);
          return $result->result_array()[0]["id_servicio"];

      }

      function create_tmp_data_cliente($flag , $_num , $param ){


        $query_drop  = "DROP  TABLE IF exists tmp_data_cliente_$_num";
        $this->db->query($query_drop);

        if($flag == 0 ){

          $query_get = "CREATE TABLE  tmp_data_cliente_$_num AS
                          SELECT
                          u.idusuario ,
                          u.nombre  nombre_cliente       ,
                          u.apellido_paterno   apellido_cliente ,
                          u.apellido_materno  apellido2_cliente
                        FROM
                          usuario u
                        INNER  JOIN
                          tmp_ordenes_pendientes_$_num p
                        ON
                        u.idusuario =  p.id_usuario
                        GROUP BY u.idusuario";
                      $this->db->query($query_get);

        }


      }

      function create_tmp_data_usuarios_ventas($flag , $_num , $param ){


        $query_drop  = "DROP  TABLE IF exists tmp_data_usuarios_ventas_$_num";
        $this->db->query($query_drop);

        if($flag == 0 ){

          $query_get = "CREATE TABLE  tmp_data_usuarios_ventas_$_num AS
                          SELECT
                          u.idusuario id_usuario_ventas,
                          u.nombre  nombre_vendedor       ,
                          u.apellido_paterno   apellido_vendedor ,
                          u.apellido_materno  apellido2_vendedor
                        FROM
                          usuario u
                        INNER  JOIN
                          tmp_ordenes_pendientes_$_num p
                        ON
                        u.idusuario =  p.id_usuario_referencia
                        GROUP BY u.idusuario";
                      $this->db->query($query_get);

        }

      }

      function get_num_saldos_pendientes($param){

          $where  = $this->get_where_tipo_cobranza_num($param);
          $query_get =  "SELECT
                            count(0)num_pendientes
                          FROM
                             proyecto_persona_forma_pago ppfp
                            ".$where;

          $result = $this->db->query($query_get);
          return $result->result_array()[0]["num_pendientes"];
      }


      function get_num_saldos_pendientes_persona($param){

          $query_get = "SELECT
                              count(0)num_pendientes
                          FROM
                             proyecto_persona_forma_pago ppfp
                          INNER JOIN
                              proyecto_persona pp
                          ON
                              ppfp.id_proyecto_persona =  pp.id_proyecto_persona
                          INNER JOIN proyecto p
                          ON
                              pp.id_proyecto =  p.id_proyecto
                          WHERE
                              pp.id_persona = '".$param["id_persona"]."'
                          AND
                              ppfp.saldo_cubierto < monto_a_pagar
                          ";

          $result = $this->db->query($query_get);
          return $result->result_array()[0]["num_pendientes"];
      }



      function get_where_tipo_cobranza_num($param){


          $tipo = $param["tipo"];
          $extra = "";
          $where ="";
          switch ($tipo){
              case 1:

                $where =" WHERE
                            id_usuario_venta =  $id_usuario AND
                            ppfp.saldo_cubierto < monto_a_pagar
                              AND
                            datediff( CURRENT_DATE() ,  ppfp.fecha_vencimiento_anticipo) < 2";

              break;

              case 2:

                $where =" WHERE
                            id_usuario_venta =  $id_usuario AND

                            ppfp.saldo_cubierto >= monto_a_pagar
                              AND
                                datediff( CURRENT_DATE() , pp.siguiente_vencimiento) >= - 240
                                AND
                                datediff( CURRENT_DATE() , pp.siguiente_vencimiento) < 0";


                break;

               case 3:
                $where =" WHERE
                            id_usuario_venta =
                            $id_usuario AND
                            ppfp.saldo_cubierto < monto_a_pagar
                              AND
                            datediff( CURRENT_DATE() ,  ppfp.fecha_vencimiento_anticipo) > 1";
                break;



                case 4:

                     $where =" WHERE
                            id_usuario_venta =  $id_usuario AND
                            ppfp.saldo_cubierto >= monto_a_pagar";


                break;


              default:

              break;
          }

          return $where;
      }

      function get_where_tipo_cobranza($tipo , $param){

          $recibo =  $param["recibo"];
          $nombre = $param["nombre"];

          $extra = "";
          if($recibo  > 0) {
            $extra =  " AND ppfp.id_proyecto_persona_forma_pago = '".$recibo."' ";
          }if (strlen($nombre ) >1 ){
            $extra =  " AND (prn.nombre like  '%".$nombre."%'  OR
                            a_paterno like  '%".$nombre."%'  OR
                            a_materno like  '%".$nombre."%'
                            OR
                            p.proyecto LIKE '%".$nombre."%' )";
          }
          $where ="";
          switch ($tipo) {
              case 1:

                $where =" WHERE
                            ppfp.saldo_cubierto < monto_a_pagar
                              AND
                            datediff( CURRENT_DATE() ,  ppfp.fecha_vencimiento_anticipo) < 2
                            ".$extra."
                            GROUP BY ppfp.id_proyecto_persona_forma_pago
                            ";

              break;

              case 2:

                $where =" WHERE
                            ppfp.saldo_cubierto >= monto_a_pagar
                            GROUP BY ppfp.id_proyecto_persona_forma_pago
                            ORDER BY dias_para_vencimiento_servicio DESC";


                break;

               case 3:
                $where =" WHERE
                            ppfp.saldo_cubierto < monto_a_pagar
                            GROUP BY ppfp.id_proyecto_persona_forma_pago
                            ORDER BY dias_para_vencimiento DESC";
                break;



                case 4:

                     $where =" WHERE
                            ppfp.saldo_cubierto >= monto_a_pagar

                            GROUP BY ppfp.id_proyecto_persona_forma_pago
                            ORDER BY
                             prn.id_persona
                             DESC";


                break;


              default:

              break;
          }

          return $where;
      }

      function get_saldos_pendientes_usuario($param){

          $id_usuario = $param["id_usuario"];
             $query_get = "SELECT
                              ppfp.* ,
                              datediff( CURRENT_DATE() ,
                              ppfp.fecha_vencimiento_anticipo) dias_para_vencimiento ,
                              p.proyecto,
                              cf.ciclo,
                              cf.flag_meses,
                              cf.num_meses
                          FROM
                             proyecto_persona_forma_pago ppfp
                          INNER JOIN
                              proyecto_persona pp
                          ON
                              ppfp.id_proyecto_persona =  pp.id_proyecto_persona
                          INNER JOIN
                              ciclo_facturacion cf
                          ON
                              pp.ciclo_facturacion =  cf.id_ciclo_facturacion

                          INNER JOIN proyecto p
                          ON
                              pp.id_proyecto =  p.id_proyecto
                          WHERE
                              pp.id_usuario = '".$id_usuario."'
                          AND
                              ppfp.saldo_cubierto < monto_a_pagar";

          $result = $this->db->query($query_get);
          return $result->result_array();

      }



      function crea_proyecto($param){

        $proyecto  =$param["proyecto"];
        $url              =$param["url"];
        $idtipo_negocio   =$param["tipo_negocio"];
        $id_servicio   =$param["id_servicio"];

        $query_insert = "INSERT INTO proyecto(
                              proyecto ,
                              url,
                              id_servicio
                          )VALUES(
                              '".$proyecto  ."',
                              '".$url              ."',
                              '".$id_servicio   ."'
                          )";

        $this->db->query($query_insert);
        return $this->db->insert_id();

      }

      function crea_proyecto_persona_forma_pago($param){

        $id_proyecto_persona = $param["id_proyecto_persona"];
        $id_forma_pago       = $param["id_forma_pago"];
        $saldo_cubierto     = 0;

        $fecha_vencimiento          =$param["fecha_vencimiento"];
        $id_usuario_validacion = $param["id_usuario"];
        $monto_a_pagar  = $param["monto_a_pagar"];
        $razon_social               =$param["razon_social"];
        $fecha_vencimiento_anticipo =$param["fecha_vencimiento_anticipo"];


          $query_insert ="INSERT INTO proyecto_persona_forma_pago(
                                    id_proyecto_persona ,
                                    id_forma_pago,
                                    saldo_cubierto,
                                    fecha_vencimiento,
                                    id_usuario_validacion,
                                    monto_a_pagar,
                                    razon_social,
                                    fecha_vencimiento_anticipo
                            )
                      VALUES(
                        '".  $id_proyecto_persona ."',
                        '".  $id_forma_pago ."',
                              $saldo_cubierto ,
                              $fecha_vencimiento,
                        '".  $monto_a_pagar ."',
                        '".  $razon_social ."',
                        '".  $fecha_vencimiento_anticipo ."'
                      )";

          $this->db->query($query_insert);
          return $this->db->insert_id();

      }

      function crea_anticipo($param){

        $anticipo                       = $param["anticipo"];
        $descripcion                    = $param["descripcion"];
        $id_proyecto_persona_forma_pago = $param["id_proyecto_persona_forma_pago"];
        $fecha_vencimiento              = $param["fecha_vencimiento"];
        $id_usuario                     = $param["id_usuario_validacion"];

        $query_insert ="INSERT INTO anticipo(
                          anticipo  ,
                          descripcion ,
                          id_proyecto_persona_forma_pago ,
                          fecha_vencimiento ,
                          id_usuario
                          )VALUES(

          '".$anticipo                       ."' ,
          '".$descripcion                    ."' ,
          '".$id_proyecto_persona_forma_pago ."' ,
          '".$fecha_vencimiento              ."' ,
          '".$id_usuario                     ."'
        )";

          $this->db->query($query_insert);
          return $this->db->insert_id();

      }


      function get_usuarios_deuda_pendiente(){

          $query_get ="SELECT
                        id_usuario ,
                        id_proyecto_persona_forma_pago
                      FROM
                        proyecto_persona_forma_pago
                      WHERE
                        saldo_cubierto < monto_a_pagar
                      AND
                        cancela_email =0
                      AND
                        num_email_recordatorio < 3
                      AND  status = 6";
          $result =  $this->db->query($query_get);
          return $result->result_array();
      }

      function get_where_compras_usuario($param){


        $where = "";
        if(get_info_usuario_valor_variable($param , "status") > 0){

          $status = $param["status"];
          $where = " AND status = ".$status;
        }
        $order =" ORDER BY fecha_registro DESC";
        $where =  $where . $order;
        return $order;
      }








    */


}   
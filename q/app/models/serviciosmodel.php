<?php defined('BASEPATH') or exit('No direct script access allowed');

class serviciosmodel extends CI_Model
{
    public $options;
    public $lista_servicios = [];

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert("servicio", $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function q_up($q, $q2, $id_servicio)
    {
        return $this->update([$q => $q2], ["id_servicio" => $id_servicio]);
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id_servicio" => $id]);
    }

    function set_gamificacion_deseo($param, $positivo = 1, $valor = 1)
    {

        $val = ($positivo == 1) ? "deseado + " . $valor : "deseado - " . $valor;
        $query_update = "UPDATE servicio SET deseado =  " . $val . " WHERE id_servicio =" . $param["id_servicio"];
        return $this->db->query($query_update);
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
        return $this->db->get("servicio")->result_array();
    }

    function set_compra_stock($stock, $id_servicio)
    {

        $query_update = "UPDATE servicio SET stock =  stock - $stock WHERE id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }

    function anexo_stock($stock, $id_servicio)
    {

        $query_update = "UPDATE servicio SET stock =  stock + $stock WHERE id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update("servicio", $data);
    }

    private function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    private function get_option($key)
    {
        return $this->options[$key];
    }

    function num_periodo($param)
    {

        $_num = mt_rand();
        $this->create_tmp_servicio(1, $_num, $param);
        $query_get = "SELECT
                        DATE(fecha_registro)fecha_registro, 
                        COUNT(0)num 
                        FROM tmp_servicio_$_num
                        GROUP BY DATE(fecha_registro)";
        $data_complete = $this->db->query($query_get)->result_array();
        $this->create_tmp_servicio(0, $_num, $param);
        return $data_complete;
    }

    private function create_tmp_servicio($flag, $_num, $param)
    {

        $this->drop_tmp($_num);
        if ($flag == 1) {
            $query_create = "CREATE TABLE  tmp_servicio_$_num AS  
                            SELECT 
                              fecha_registro
                            FROM  
                              servicio 
                            WHERE      
                            status = 1
                            AND
                              DATE(fecha_registro) 
                            BETWEEN 
                            '" . $param["fecha_inicio"] . "' 
                            AND  
                            '" . $param["fecha_termino"] . "' ";
            $this->db->query($query_create);
        }
    }

    private function drop_tmp($_num)
    {
        $query_drop = "DROP TABLE IF EXISTS tmp_servicio_$_num";
        $this->db->query($query_drop);
    }

    function get_productos_solicitados($param)
    {

        $_num = mt_rand();
        $this->create_tmp_productos_solicitados(0, $_num, $param);
        $query_get = "SELECT * FROM tmp_productos_$_num ORDER BY num_keywords DESC";
        $result = $this->db->query($query_get);
        $response = $result->result_array();
        $this->create_tmp_productos_solicitados(1, $_num, $param);
        return $response;
    }

    function set_vista($param)
    {

        $id_servicio = $param["id_servicio"];
        $query_update =
            "UPDATE servicio 
        SET 
        vista               =  vista + 1 ,
        ultima_vista        =  CURRENT_TIMESTAMP()
        WHERE id_servicio   =  $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }

    function create_tmp_productos_solicitados($flag, $_num, $param)
    {

        $this->db->query(get_drop("tmp_productos_$_num"));

        if ($flag == 0) {

            $query_get =
                "CREATE TABLE tmp_productos_$_num AS 
                      SELECT 
                        keyword, 
                        COUNT(0)num_keywords 
                      FROM 
                        keyword 
                      WHERE 
                        DATE(fecha_registro) 
                      BETWEEN 
                        '" . $param["fecha_inicio"] . "'  
                      AND 
                        '" . $param["fecha_termino"] . "'
                        AND
                        LENGTH(keyword) > 2
                      GROUP BY keyword";

            $this->db->query($query_get);
        }
    }

    function get_producto_alcance($param)
    {

        $query_get = "SELECT id_servicio 
                    FROM  
                    servicio 
                    WHERE 
                    id_usuario = '" . $param["id_usuario"] . "'
                    AND 
                    vista = '" . $param["tipo"] . "'
                    AND 
                    status = 1 
                    AND
                    existencia>0
                    LIMIT 1";
        return $this->db->query($query_get)->result_array()[0]["id_servicio"];
    }

    function get_alcance_productos_usuario($param)
    {

        $id_usuario = $param["id_usuario"];

        $params = [
            "MAX(vista)maximo",
            "AVG(vista)promedio",
            "MIN(vista)minimo"
        ];

        $params_where = [
            "id_usuario" => $id_usuario,
            "status" => 1,
            "existencia" => ">0"
        ];
        return $this->get($params, $params_where);
    }

    function get_top_semanal_vendedor($param)
    {

        $_num = mt_rand();
        $this->create_views_productos_usuario(0, $_num, $param);
        $query_get = "SELECT 
                        id_servicio , 
                        COUNT(0)vistas 
                        FROM tmp_views_productos_$_num 
                        GROUP BY id_servicio
                        ORDER BY COUNT(0) 
                        DESC
                        LIMIT 25 ";
        $result = $this->db->query($query_get);
        $data_complete = $result->result_array();
        $this->create_views_productos_usuario(1, $_num, $param);
        return $data_complete;
    }

    private function create_views_productos_usuario($flag, $_num, $param)
    {

        $this->db->query(get_drop(" tmp_views_productos_$_num"));
        if ($flag == 0) {

            $id_usuario = $param["id_usuario"];
            $query_get = "CREATE TABLE tmp_views_productos_$_num AS 
                      SELECT 
                        id_servicio  
                      FROM 
                        pagina_web
                      WHERE 
                        id_usuario = " . $id_usuario . "
                      AND 
                        DATE(fecha_registro )
                      BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 WEEK ) 
                        AND  DATE(CURRENT_DATE())";
            $this->db->query($query_get);
        }
    }


    function get_tipos_entregas($param)
    {

        $query_get = "SELECT
        id_servicio,   
        nombre_servicio,     
        vista , 
        deseado, 
        valoracion  
        FROM 
        servicio
        WHERE 
        status =  1 
        AND 
        vista > 1 
        AND  
        DATE(ultima_vista) 
        BETWEEN 
        '" . $param["fecha_inicio"] . "' AND '" . $param["fecha_termino"] . "' 
        ORDER 
        BY 
        deseado
        DESC
        ";
        return $this->db->query($query_get)->result_array();
    }

    function set_q_servicio($param)
    {

        $q = $param["q"];
        $q2 = $param["q2"];
        $id_servicio = $param["id_servicio"];
        $response = $this->q_up($q, $q2, $id_servicio);
        if ($q == "nombre_servicio") {

            $param["metakeyword"] = $q2;
            $param["id_servicio"] = $id_servicio;
            $response = $this->agrega_metakeyword_sistema($param);
        }
        return $response;
    }

    function elimina_color_servicio($param)
    {

        $colores = $this->get_colores_por_servicio($param);
        if (isset($colores[0]["color"])) {

            $colores_en_servicio = $colores[0]["color"];
            $color = $param["color"];
            $id_servicio = $param["id_servicio"];
            $arreglo_colores = explode(",", $colores_en_servicio);

            $nueva_lista = "";
            for ($z = 0; $z < count($arreglo_colores); $z++) {
                if ($arreglo_colores[$z] != $color) {
                    $nueva_lista .= $arreglo_colores[$z] . ",";
                }
            }
            return $this->q_up("color", $nueva_lista, $id_servicio);
        } else {
            return 1;
        }
    }

    function agrega_color_servicio($param)
    {

        $colores = $this->get_colores_por_servicio($param);
        if (isset($colores[0]["color"])) {
            return $this->agrega_color($param, 1, $colores[0]["color"]);
        } else {
            return $this->agrega_color($param, 0, "");
        }
    }

    function agrega_color($param, $flag, $color_anterior)
    {

        $color = $param["color"];
        if ($flag != 0) {

            $info_a = explode(",", $color_anterior);
            array_push($info_a, $color);
            $nuevo = array_unique($info_a);
            $color = implode(",", $nuevo);
        }
        return $this->q_up("color", $color, $param["id_servicio"]);
    }

    function get_colores_por_servicio($param)
    {
        return $this->q_get(["color"], $param["id_servicio"]);
    }

    function gamificacion_usuario_servicios($param)
    {

        $id = $param["id"];
        $valoracion = $param["valoracion"];
        $nueva_valoracion = ($valoracion > 0) ? "  valoracion + $valoracion " : " valoracion - $valoracion ";
        return $this->q_up("valoracion", $nueva_valoracion, $id);
    }

    function get_num_en_venta_usuario($param)
    {

        $query_get = "SELECT 
                        COUNT(0)num_servicios
                      FROM 
                      servicio 
                      WHERE 
                      id_usuario = '" . $param["id_usuario"] . "'
                      AND 
                        existencia > 0
                      AND 
                        status =1
                      AND flag_imagen>0";

        return $this->db->query($query_get)->result_array()[0]["num_servicios"];
    }

    function busqueda($param)
    {

        $busqueda = $this->get_resultados_posibles($param);
        $response["total_busqueda"] = $busqueda['num_servicios'];
        $where = $busqueda['where'];        
        $response["servicios"] = $this->create_productos_disponibles($where);

        return $response;
    }

    function get_clasificaciones_disponibles($_num)
    {

        $niveles = ["primer_nivel", "segundo_nivel", "tercer_nivel", "cuarto_nivel", "quinto_nivel"];
        $response = [];
        for ($a = 0; $a < count($niveles); $a++) {

            $nivel = $niveles[$a];
            $query_get = "SELECT DISTINCT($nivel)id_clasificacion FROM tmp_producto_$_num";
            $response[$nivel] = $this->db->query($query_get)->result_array();
        }
        return $response;
    }

    function get_limit($param)
    {

        $page = (isset($param["extra"]['page']) && !empty($param["extra"]['page'])) ? $param["extra"]['page'] : 1;
        $per_page = $param["resultados_por_pagina"]; //la cantidad de registros que desea mostrar
        $adjacents = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
        return " LIMIT $offset , $per_page ";
    }

    function agrega_servicios_list($servicio)
    {
        if (es_data($servicio)) {
            array_push($this->lista_servicios, $servicio[0]);
        }
    }

    function get_sql_servicio($param, $flag_conteo)
    {

        $q = $param["q"];
        $limit = ($flag_conteo == 0) ? $this->get_limit($param) : " ";
        $extra_clasificacion = $this->get_extra_clasificacion($param);
        $num_q = strlen(trim($q));
        $id_usuario = $param["id_usuario"];

        $extra_existencia = ($id_usuario > 0) ? " " : " AND existencia > 0  ";
        $vendedor = $param["vendedor"];
        $extra_empresa = ($id_usuario > 0 && $vendedor < 1) ? " AND id_usuario = " . $id_usuario : "";
        $extra_empresa = (prm_def($param, "global") > 0) ? " " : $extra_empresa;
        $extra_vendedor = ($vendedor > 0) ? " AND id_usuario =  '" . $vendedor . "'" : "";
        $extra_rifa = (prm_def($param,'es_sorteo') > 0 ) ? 'AND es_sorteo = 1 ':'';

        $orden = $this->get_orden($param);

        $sql_match = ($num_q > 0) ?
            "  AND (
                    MATCH(metakeyword , metakeyword_usuario) 
                    AGAINST ('" . $q . "*')
                    OR 
                    nombre_servicio LIKE '%" . $q . "%'
                    OR 
                    descripcion LIKE '%" . $q . "%'
                    OR 
                    precio = '" . $q . "'                     
                    
                )
                " : "";

        $no_empresa = (prm_def($param, 'es_empresa') < 1) ? 'AND  es_publico >  0' : ' ';
        
        $extra_status = (prm_def($param,'es_sorteo') > 0 && prm_def($param,'resultados') > 0 ) ? " AND status = 3 " :" AND status = 1 ";

        return " WHERE                     
                    flag_imagen > 0
                    " . $extra_status . "
                    " . $extra_empresa . "
                    " . $extra_vendedor . "
                    " . $extra_existencia . "                           
                    " . $no_empresa . "   
                    " . $extra_clasificacion . "
                    " . $extra_rifa . "
                    " . $sql_match . "
                    " . $orden . "
                    " . $limit;
    }

    function get_extra_clasificacion($param)
    {

        $id_clasificacion = $param["id_clasificacion"];
        $extra = " AND( primer_nivel  =  $id_clasificacion 
                        OR 
                        segundo_nivel  =  $id_clasificacion 
                        OR 
                        tercer_nivel  =  $id_clasificacion 
                        OR                    
                        cuarto_nivel   =  $id_clasificacion 
                        OR                    
                        quinto_nivel   =  $id_clasificacion )";

        $extra = ($id_clasificacion > 0) ? $extra : "";
        return $extra;
    }

    function get_orden($param)
    {


        switch ($param["order"]) {
                /*Novedades primero*/
            case 1:
                return " ORDER BY fecha_registro DESC , deseado DESC , vista DESC, precio DESC";
                break;

            case 2:
                return " ORDER BY  deseado DESC , vista  DESC, precio DESC";
                break;
                
                /*Calificado*/
            case 3:
                return " ORDER BY valoracion DESC , deseado DESC , vista DESC";
                break;

            case 4:
                return " ORDER BY deseado DESC , vista DESC, valoracion DESC , precio DESC";
                break;

            case 5:
                return " ORDER BY deseado DESC , vista DESC, precio DESC";
                break;

            case 6:
                return " ORDER BY precio ASC, deseado DESC , vista DESC";
                break;

            case 7:
                return " ORDER BY nombre_servicio ASC, deseado DESC , vista DESC";
                break;

            case 8:
                return " ORDER BY nombre_servicio DESC, deseado DESC , vista DESC";
                break;

            case 9:
                return
                    " AND flag_servicio = 1 
                    ORDER BY deseado DESC , vista  DESC , valoracion DESC";
                break;

            case 10:
                return " AND flag_servicio = 0 ORDER BY  deseado DESC , vista  DESC";
                break;

            case 11:
                return " ORDER BY  deseado DESC, vista DESC ";
                break;

            default:

                break;
        }
    }

    function agrega_elemento_distinto($distinto)
    {
        $nuevo = " AND status = 1 AND id_servicio != $distinto";
        $sql = $this->get_option("sql_distintos");
        $nuevo_sql = $sql . $nuevo;
        $this->set_option("sql_distintos", $nuevo_sql);
    }

    function get_producto_por_clasificacion($param)
    {

        $this->set_option("sql_distintos", "");
        $this->agrega_elemento_distinto($param["id_servicio"]);
        $n_servicio = $this->get_producto_clasificacion_nivel(1, $param["primer_nivel"]);


        if (es_data($n_servicio)) {
            $this->agrega_servicios_list($n_servicio);
            $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);


            $n_servicio = $this->get_producto_clasificacion_nivel(2, $param["segundo_nivel"]);
            $this->agrega_servicios_list($n_servicio);


            if (es_data($n_servicio)) {

                $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);
                $n_servicio =
                    $this->get_producto_clasificacion_nivel(3, $param["tercer_nivel"]);
                $this->agrega_servicios_list($n_servicio);


                if (es_data($n_servicio)) {
                    $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);
                    $n_servicio =
                        $this->get_producto_clasificacion_nivel(4, $param["cuarto_nivel"]);
                    $this->agrega_servicios_list($n_servicio);


                    if (es_data($n_servicio)) {
                        $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);
                        $n_servicio =
                            $this->get_producto_clasificacion_nivel(5, $param["quinto_nivel"]);
                        $this->agrega_servicios_list($n_servicio);
                    }
                }
            }
        }


        return $this->lista_servicios;
    }


    function get_producto_clasificacion_nivel($nivel, $id_clasificacion)
    {

        $lista_niveles = [
            "",
            "primer_nivel",
            "segundo_nivel",
            "tercer_nivel",
            "cuarto_nivel",
            "quinto_nivel"
        ];

        $nivel_text = $lista_niveles[$nivel];
        $distinto = $this->get_option("sql_distintos");
        $query_get = "SELECT 
                        id_servicio ,  
                        nombre_servicio, 
                        flag_servicio, 
                        flag_envio_gratis,
                        metakeyword, 
                        primer_nivel , 
                        segundo_nivel ,
                        tercer_nivel ,
                        cuarto_nivel , 
                        quinto_nivel, 
                        color,
                        precio,
                        precio_alto,
                        id_ciclo_facturacion,
                        es_publico,
                        es_sorteo,
                        precio_alto
                        FROM 
                        servicio
                        WHERE 
                            es_publico >  0 
                        $distinto
                            AND 
                        $nivel_text = $id_clasificacion  
                            AND 
                        existencia > 0
                            AND 
                        status = 1
                            AND 
                        flag_imagen = 1
                        LIMIT 2";

        return $this->db->query($query_get)->result_array();
    }

    function periodo($param)
    {

        $query_get = "SELECT * FROM servicio WHERE status = 1 AND  DATE(fecha_registro) 
        BETWEEN '" . $param["fecha_inicio"] . "' AND '" . $param["fecha_termino"] . "'";

        return $this->db->query($query_get)->result_array();
    }

    function get_clasificaciones_por_id_servicio($id_servicio)
    {

        $params = [
            "id_servicio",
            "primer_nivel",
            "segundo_nivel",
            "tercer_nivel",
            "cuarto_nivel",
            "quinto_nivel"
        ];
        return $this->get($params, ["id_servicio" => $id_servicio]);
    }

    function get_clasificaciones_destacadas()
    {

        $query_get = "SELECT 
                    primer_nivel, 
                    count(0)total
                    FROM servicio 
                    WHERE 
                    status =1 
                    AND existencia >0 
                    GROUP BY 
                    primer_nivel
                    ORDER BY count(0) DESC  LIMIT 5";
        return $this->db->query($query_get)->result_array();
    }
    function total()
    {

        $query_get = "SELECT count(0)total FROM servicio where status = 1 ";
        return $this->db->query($query_get)->result_array();
    }

    function get_resumen($param)
    {

        $id_servicio = $param["id_servicio"];
        $query_get = "SELECT 
                            *
                        FROM  
                            servicio s  
                        INNER JOIN              
                            ciclo_facturacions cf                
                        ON  
                            s.id_ciclo_facturacion = cf.id_ciclo_facturacion
                        WHERE 
                            s.id_servicio ='" . $id_servicio . "' LIMIT 1";
        return $this->db->query($query_get)->result_array();
    }

    function busqueda_producto($param)
    {

        $data_complete["total_busqueda"] = $this->get_resultados_posibles($param);
        $busqueda = $this->get_resultados_posibles($param);
        $data_complete["total_busqueda"] = $busqueda['num_servicios'];        
        $data_complete["servicio"] = $this->create_productos_disponibles($busqueda['where']);
                
        return $data_complete;
    }


    function get_resultados_posibles($param)
    {

        $query_where = $this->get_sql_servicio($param, 1);
        $where = $this->get_sql_servicio($param, 0);
        $query_get = _text_("SELECT  COUNT(0)num_servicios FROM servicio  ", $query_where);
        $num_servicios = $this->db->query($query_get)->result_array()[0]["num_servicios"];
        return [
            'num_servicios' => $num_servicios,
            'where' => $where
        ];
    }


    function create_productos_disponibles($where)
    {

        $query_create = _text_(" 
                SELECT  id_servicio, nombre_servicio, id_usuario, descripcion, 
                marca, dimension,metakeyword_usuario,
                metakeyword, primer_nivel , segundo_nivel , 
                tercer_nivel , cuarto_nivel , quinto_nivel, es_publico, 
                precio,precio_alto, es_sorteo FROM servicio ", $where);
        return $this->db->query($query_create)->result_array();
    }

    function agrega_metakeyword_sistema($param)
    {

        $metakeyword = $param["metakeyword"];
        $id_servicio = $param["id_servicio"];
        $meta = $this->get_palabras_clave_por_servicio_sistema($id_servicio);
        $metakeyword = $meta . "," . $metakeyword;
        return $this->q_up("metakeyword", $metakeyword, $id_servicio);
    }

    function get_palabras_clave($id_servicio)
    {

        return $this->q_get(["metakeyword_usuario"], $id_servicio)[0]["metakeyword_usuario"];
    }

    function get_num_anuncios($param)
    {

        $id_usuario = $param["id_usuario"];
        $query_get = "SELECT COUNT(0)num 
        FROM 
        servicio 
        WHERE 
        id_usuario =$id_usuario 
        AND 
        status = 1
        AND 
        existencia >0
        LIMIT 1";
        return $this->db->query($query_get)->result_array()[0]["num"];
    }

    function get_num_lectura_valoraciones($param)
    {
        $id_usuario = $param["id_usuario"];
        $query_get = "
            SELECT 
                COUNT(0)num
            FROM 
                servicio s 
            INNER JOIN  
                valoracion v
            ON 
                s.id_servicio =  v.id_servicio
            WHERE 
                s.id_usuario = $id_usuario
                AND s.status = 1 
            AND
                leido_vendedor = 0";

        return $this->db->query($query_get)->result_array()[0]["num"];
    }

    function set_preferencia_entrega($tipo, $id_servicio)
    {

        $query_update = "UPDATE servicio SET " . $tipo . " = " . $tipo . " + 1 WHERE id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }

    function restablecer($id)
    {
        $query_update = "UPDATE servicio SET  vista = 0  , valoracion = 0 , deseado = 0  WHERE id_servicio = $id LIMIT 1";
        return $this->db->query($query_update);
    }

    function sin_ventas()
    {

        $query_update = "SELECT s.id_servicio, s.fecha_registro , 
                            DATEDIFF(s.fecha_registro, CURRENT_DATE()) dias
                            FROM 
                            servicio s 
                            LEFT JOIN proyecto_persona_forma_pagos p  
                            ON s.id_servicio =  p.id_servicio
                            WHERE 
                            s.fecha_registro < DATE_ADD(current_date() , INTERVAL  - 7 DAY) 
                            AND 
                            s.status = 1
                            and 
                            p.id_servicio IS NULL";
        return $this->db->query($query_update)->result_array();
    }
}

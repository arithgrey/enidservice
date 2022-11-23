<?php defined('BASEPATH') or exit('No direct script access allowed');

class usuario_model extends CI_Model
{
    private $table;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'users';
    }

    function set_ultima_publicacion($param)
    {

        $id_usuario = $param["id_usuario"];
        $query_update = "UPDATE users SET ultima_publicacion = CURRENT_TIMESTAMP() WHERE id =  $id_usuario";
        return $this->db->query($query_update);
    }

    function calificacion_cancelacion_compra($param)
    {

        return $this->update(["num_cancelaciones" => "num_cancelaciones + 1"], ["id" => $param["id"]]);
    }

    function evalua_usuario_existente($param)
    {
        return $this->get(["COUNT(0)num"], ["email" => $param["email"]])[0]["num"];
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
        return $this->db->get($this->table)->result_array();
    }

    function update($data = [], $params_where = [], $limit = 1)
    {
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->table, $data);
    }

    function q_up($q, $q2, $id_usuario)
    {
        return $this->update([$q => $q2], ["id" => $id_usuario]);
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function get_usuario_ventas()
    {
        return $this->get(["id"], ["email" => 'ventas@enidservices.com']);
    }

    function get_miembro($param)
    {

        $query_get = "SELECT 
                      u.id,
                      u.name,                   
                      u.apellido_paterno ,                 
                      u.apellido_materno,                                    
                      u.email,
                      u.fecha_registro,                  
                      u.status,                                
                      u.email_alterno,
                      u.tel_contacto,
                      u.tel_contacto_alterno,
                      u.inicio_labor,
                      u.fin_labor,
                      u.grupo,
                      u.cargo,
                      u.turno,
                      u.sexo, 
                      u.id_departamento,
                      u.tiene_auto,
                      u.tiene_moto,
                      u.tiene_bicicleta,
                      u.reparte_a_pie,
                      up.idperfil
                      FROM users u
                      INNER JOIN usuario_perfil up 
                        ON up.id =  u.id
                      WHERE 
                      u.id = '" . $param["id_usuario"] . "' 
                      LIMIT 1";

        $result = $this->db->query($query_get);
        return $result->result_array();
    }


    function cancelacion_compra($id_usuario)
    {

        $query_update = "UPDATE users 
                        SET num_cancelaciones = num_cancelaciones + 1 
                        WHERE id = $id_usuario 
                        LIMIT 1";

        return $this->db->query($query_update);
    }

    function registros($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $query_get =
            "SELECT 
                            COUNT(0)num ,
                            SUM(CASE WHEN tel_contacto 
                            IS NOT NULL THEN 1 ELSE 0 END )
                            registros_numeros_telefonicos
                        FROM 
                            users
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "'";

        $result = $this->db->query($query_get);
        $total = $result->result_array();

        $response["num"] = $total[0]["num"];
        $response["registros_numeros_telefonicos"] =
            $total[0]["registros_numeros_telefonicos"];
        return $response;
    }

    function insert($params, $return_id = 0)
    {

        $insert = $this->db->insert($this->table, $params);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function has_phone($param)
    {

        $id_usuario = $param["id_usuario"];
        $query_get = "SELECT 
                        COUNT(0)num 
                    FROM users 
                    WHERE 
                        id =$id_usuario
                    AND 
                        tel_contacto 
                    IS NOT NULl LIMIT 1";

        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }

    function publican_periodo($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $query_get = "SELECT COUNT(0)num FROM users
                        WHERE 
                            DATE(ultima_publicacion) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "'
                        ";
        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }

    function num_registros_periodo($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $query_get =
            "SELECT 
                            COUNT(0)num ,
                            DATE(fecha_registro) fecha
                        FROM 
                            users
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "'
                        GROUP BY DATE(fecha_registro)";
        return $this->db->query($query_get)->result_array();
    }

    function get_usuarios_perfil($param)
    {

        $id_perfil = $param["id_perfil"];
        $id_empresa = $param['id_empresa'];
        $id_usuario = $param['id_usuario'];
        $_num = mt_rand();
        $this->create_tmp_usuarios_perfil(0, $_num, $id_perfil, $id_empresa, $id_usuario);
        $query_get =
            "SELECT
                    u.id
                    ,name
                    ,email 
                    ,apellido_paterno 
                    ,apellido_materno ,
                    CONCAT(name,' ', apellido_paterno ) nombre_completo
                    FROM  users u
                    INNER JOIN 
                    tmp_clienes_$_num up 
                    ON 
                    u.id = up.idusuario
                    AND u.status = 1";

        $result = $this->db->query($query_get);
        $data_complete = $result->result_array();
        $this->create_tmp_usuarios_perfil(1, $_num, $id_perfil, $id_empresa, $id_usuario);
        return $data_complete;
    }

    function create_tmp_usuarios_perfil($flag, $_num, $perfil, $id_empresa, $id_usuario)
    {

        $query_drop = "DROP TABLE IF exists tmp_clienes_$_num";
        $this->db->query($query_drop);
        if ($flag == 0) {

            $query_create = "CREATE TABLE tmp_clienes_$_num AS 
                          SELECT 
                            up.idusuario 
                            FROM 
                            usuario_perfil  up 
                            INNER JOIN users u 
                            ON 
                            u.id = up.idusuario
                            WHERE 
                            u.id_empresa = '" . $id_empresa . "' AND
                            up.idperfil=" . $perfil .
                " OR up.idusuario ='" . $id_usuario . "'";
            $this->db->query($query_create);
        }
    }

    function valida_pass($antes, $id_usuario)
    {
        $q = [
            "id" => $id_usuario,
            "password" => $antes
        ];
        return $this->get(["COUNT(0)num"], $q)[0]["num"];
    }

    function num_registros_preriodo($param)
    {

        $q = ["DATE(fecha_registro)" => "BETWEEN '" . $param["fecha_inicio"] . "' AND  '" . $param["fecha_termino"] . "'"];
        return $this->get(["COUNT(0)num"], $q)[0]["num"];
    }

    function get_usuarios_periodo($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $limit = $this->get_limit_usuarios($param);
        $query_get = "SELECT 
                    id id_usuario
                    ,name
                    ,email
                    ,apellido_paterno
                    ,apellido_materno
                    ,fecha_registro 
                    ,puntuacion                    
                    FROM users 
                    WHERE DATE(fecha_registro) 
                    BETWEEN 
                    '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' " . $limit;
        $result = $this->db->query($query_get);
        return $result->result_array();
    }

    function get_limit_usuarios($param)
    {

        $page = (isset($param['page']) && !empty($param['page'])) ? $param['page'] : 1;
        $per_page = 10; //la cantidad de registros que desea mostrar
        $adjacents = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
        return " LIMIT $offset , $per_page ";
    }

    function registros_preriodo($param)
    {

        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $limit = $this->get_limit_usuarios($param);
        $query_get =
            "SELECT 
                    id id_usuario
                    ,name
                    ,email
                    ,apellido_paterno
                    ,apellido_materno
                    , fecha_registro 
                    FROM users 
                    WHERE DATE(fecha_registro) 
                    BETWEEN 
                    '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' " . $limit;
        $result = $this->db->query($query_get);
        return $result->result_array();
    }

    function num_total($param)
    {
        $where =
            $this->get_where_usuarios_total($param);
        $query_get = _text_("SELECT COUNT(0)num FROM users u", $where);
        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }

    function get_where_usuarios_total($param)
    {

        $status = $param["status"];
        $q = prm_def($param, "q");
        $es_perfil = (array_key_exists("id_departamento", $param));
        $departamento = "AND u.id_departamento = ";
        $extra_perfil = ($es_perfil) ? _text_($departamento, $param["id_departamento"]) : "";

        $extra = (strlen($q) > 1) ? " WHERE 
        u.name like '%" . $q . "%'
        OR u.email like '%" . $q . "%'
        OR u.apellido_paterno like '%" . $q . "%'
        OR u.apellido_materno like '%" . $q . "%'
        OR u.tel_contacto  like '%" . $q . "%'
         " : " ";


        return "   inner join usuario_perfil pu
                    on 
                    pu.idusuario = u.id
                    AND 
                    pu.idperfil != 20                    
                    AND u.status = $status
                    " . $extra . $extra_perfil . " 
                    ORDER BY u.fecha_registro DESC";
    }

    function get_productos_deseados_sugerencias($param)
    {

        $id_usuario = $param["id_usuario"];
        $limit = $param["limit"];
        $query_get = "SELECT                         
                        s.id_servicio ,  
                        s.nombre_servicio,                         
                        s.metakeyword, 
                        s.primer_nivel , 
                        s.segundo_nivel ,
                        s.tercer_nivel ,
                        s.cuarto_nivel , 
                        s.quinto_nivel,
                        s.es_publico, 
                        s.precio,
                        s.precio_alto,
                        s.es_sorteo             
                    FROM usuario_deseo us
                    INNER JOIN servicio s  
                    ON us.id_servicio =  s.id_servicio
                    WHERE 
                       us.id_usuario = '" . $id_usuario . "' 
                       AND  
                       s.status = 1 
                    ORDER BY 
                    us.num_deseo DESC LIMIT $limit ";


        return $this->db->query($query_get)->result_array();
    }

    function num_q($param)
    {
        return $this->get([" COUNT(0)num "], [$param["key"] => $param["value"]], 1000)[0]["num"];
    }

    function get_usuarios_sin_publicar_articulos($param)
    {
        $query_get = "SELECT
                    name , 
                    email 
                    FROM users 
                    WHERE status = 1 
                    AND 
                    ultima_publicacion 
                    < DATE_ADD(CURRENT_DATE() , INTERVAL - 30 DAY )
                    AND id_departamento =9 ";
        return $this->db->query($query_get)->result_array();
    }

    function verifica_registro_telefono($param)
    {

        $query_get = "SELECT COUNT(0)num FROM 
                    users WHERE 
                    id ='" . $param["id_usuario"] . "' 
                    and tel_contacto is null";
        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }

    function get_equipo_enid_service($param)
    {

        $_num = mt_rand();
        $this->create_usuarios_enid_service(0, $_num, $param);
        $query_get = "SELECT 
                    u.* , 
                    d.nombre nombre_departamento                        
                   FROM 
                    tmp_usuarios_enid_service_$_num u
                   INNER JOIN 
                    departamento d 
                    ON 
                    u.id_departamento =  d.id_departamento";


        $data_complete = $this->db->query($query_get)->result_array();
        $this->create_usuarios_enid_service(1, $_num, $param);
        return $data_complete;
    }

    function proveedores_servicio($param)
    {

        $_num = mt_rand();
        $this->create_usuarios_enid_service(0, $_num, $param);

        $id_servicio = $param["id_servicio"];
        $query_get = "SELECT u.*, ps.* FROM tmp_usuarios_enid_service_$_num u 
                    INNER JOIN proveedor_servicio ps 
                    ON u.id_usuario = ps.id_usuario
                    AND ps.id_servicio = $id_servicio";

        $data_complete = $this->db->query($query_get)->result_array();
        $this->create_usuarios_enid_service(1, $_num, $param);
        return $data_complete;
    }


    function create_usuarios_enid_service($flag, $_num, $param)
    {

        $this->db->query(get_drop("tmp_usuarios_enid_service_$_num"));
        if ($flag == 0) {

            $where = $this->get_where_usuarios($param);
            $query_create = "CREATE TABLE 
                            tmp_usuarios_enid_service_$_num AS 
                            SELECT      
                              u.id id_usuario,
                              u.name,                   
                              u.apellido_paterno ,                 
                              u.apellido_materno,                                    
                              u.email,                              
                              u.id_departamento ,
                              u.fecha_registro,
                              u.puntuacion
                            FROM 
                              users u
                            " . $where;
            $this->db->query($query_create);
        }
    }

    function get_where_usuarios($param)
    {

        $status = $param["status"];
        $q = trim(prm_def($param, "q"));

        $es_departamento = (array_key_exists("id_departamento", $param));
        $departamento = "AND u.id_departamento = ";
        $extra_perfil = ($es_departamento) ? _text_($departamento, $param["id_departamento"]) : "";


        $extra = (strlen($q) > 1) ?
            " WHERE 
            u.name like '%" . $q . "%'
            OR u.email like '%" . $q . "%'
            OR u.apellido_paterno like '%" . $q . "%'
            OR u.apellido_materno like '%" . $q . "%'
            OR u.tel_contacto  like '%" . $q . "%'
            OR u.id  like '%" . $q . "%'
             " : " ";

        $limit = $this->get_limit_usuarios($param);
        return "inner join usuario_perfil pu
                    on 
                    pu.idusuario = u.id
                    AND pu.idperfil != 20                    
                    AND u.status = $status
                     " . $extra . $extra_perfil .
            " ORDER BY u.fecha_registro DESC " . $limit;
    }

    function set_miembro($param)
    {

        $id_usuario = $param["id_usuario"];
        $params = [
            "name" => $param["nombre"],
            "email" => $param["email"],
            "apellido_paterno" => $param["apellido_paterno"],
            "apellido_materno" => $param["apellido_materno"],
            "inicio_labor" => $param["inicio_labor"],
            "fin_labor" => $param["fin_labor"],
            "turno" => $param["turno"],
            "sexo" => $param["sexo"],
            "id_departamento" => $param["departamento"],
            "status" => $param["status"],

        ];

        $tel_contacto = $param["tel_contacto"];

        if (strlen($tel_contacto) > 3) {
            $params["tel_contacto"] = $tel_contacto;
        }
        if (array_key_exists('auto', $param)) {

            $params['tiene_auto'] = $param['auto'];
            $params['tiene_moto'] = $param['moto'];
            $params['tiene_bicicleta'] = $param['bicicleta'];
            $params['reparte_a_pie'] = $param['reparte_a_pie'];
        }

        $this->update($params, ["id" => $id_usuario]);

        $query_update = "UPDATE users SET ultima_modificacion = CURRENT_TIMESTAMP() WHERE id = $id_usuario LIMIT 1 ";
        return $this->db->query($query_update);
    }

    function crea_usuario_enid_service($param)
    {


        $params = [
            "name" => $param["nombre"],
            "email" => $param["email"],
            "id_empresa" => '1',
            "apellido_paterno" => $param["apellido_paterno"],
            "apellido_materno" => $param["apellido_materno"],
            "inicio_labor" => $param["inicio_labor"],
            "fin_labor" => $param["fin_labor"],
            "turno" => $param["turno"],
            "sexo" => $param["sexo"],
            "id_departamento" => $param["departamento"],
            "password" => sha1("qwerty123.1")
        ];
        if (strlen($param["tel_contacto"]) > 3) {

            $params["tel_contacto"] = $param["tel_contacto"];
        }


        $id_usuario = $this->insert($params, 1);
        $param["id_usuario"] = $id_usuario;
        return $param;
    }

    function registrar_afiliado($param)
    {

        $data_complete["usuario_existe"] = $this->evalua_usuario_existente($param);
        $data_complete["usuario_registrado"] = 0;

        if ($data_complete["usuario_existe"] == 0) {

            $params = [
                "email" => $param["email"],
                "id_empresa" => '1',
                "id_departamento" => 8,
                "password" => $param["password"],
                "name" => $param["nombre"],
                "tel_contacto" => $param["telefono"]
            ];

            $id_usuario = $this->insert($params, 1);
            $param["id_usuario"] = $id_usuario;
            $param["puesto"] = 19;
            $data_complete["usuario_permisos"] = $this->agrega_permisos_usuario($param);
            $data_complete["id_usuario"] = $id_usuario;
            $data_complete["email"] = $param["email"];
            $data_complete["usuario_registrado"] = 1;
        }
        return $data_complete;
    }

    function busqueda($id, $email, $tel_contacto, $tel_contacto_alterno,  $facebook = '', $url_lead = '')
    {
        $where = "WHERE email = '" . $email . "'";
        $extra_email = ($id > 0) ? " OR id = " . $id : " ";
        $extra_tel = (strlen($tel_contacto) > 3) ? " OR tel_contacto = " . $tel_contacto : " ";
        $extra_tel_alterno = (strlen($tel_contacto_alterno) > 3) ? " OR tel_contacto_alterno = " . $tel_contacto_alterno : " ";
        $extra_url_lead = (strlen($url_lead) > 3) ? " OR url_lead = '" . $url_lead."'" : " ";
        $extra_url_facebook = (strlen($facebook) > 3) ? " OR facebook like '%".$facebook."%'" : " ";


        $query_get = "SELECT id FROM users " . $where . $extra_tel . $extra_tel_alterno . $extra_email . $extra_url_lead . $extra_url_facebook;            
        
        return $this->db->query($query_get)->result_array();
    }

    function gamificacion_ventas($id_usuario)
    {

        $query = "UPDATE users 
                  SET 
                  fecha_ultima_venta = CURRENT_TIMESTAMP () ,
                    ha_vendido =  ha_vendido + 1 
                    WHERE id = $id_usuario LIMIT 1";
        return $this->db->query($query);
    }

    function get_in($in)
    {

        $query_get = 'SELECT 
                id id_usuario,
                name,
                apellido_paterno,
                apellido_materno,
                email,
                nombre_usuario,
                num_compras,
                num_cancelaciones,
                puntuacion,
                tel_contacto
                FROM 
                users
                 WHERE 
                 id in (' . $in . ')';

        return $this->db->query($query_get)->result_array();
    }

    function entregas($ids, $moto, $bicicleta, $pie)
    {
        $extra_moto = ($moto > 0) ? ' AND tiene_moto > 0  ' : ' ';
        $extra_bicicleta = ($bicicleta > 0) ? ' AND tiene_bicicleta > 0  ' : ' ';
        $extra_pie = ($pie > 0) ? ' AND reparte_a_pie > 0  ' : ' ';

        $response = [];
        if ($moto > 0) {

            $query_get = "SELECT 
                id id_usuario            
                FROM users 
                WHERE       
                1 = 1
                " . $extra_moto . "
                AND  id IN ( $ids ) 
                ORDER BY puntuacion DESC";

            $usuarios_moto = $this->db->query($query_get)->result_array();
            $response = $this->simplifica_usuarios($response, $usuarios_moto);
        }

        if ($bicicleta > 0) {

            $query_get = "SELECT 
                id id_usuario              
                FROM users 
                WHERE
                1 = 1        
                " . $extra_bicicleta . "
                AND  id IN ( $ids )";

            $usuarios_bicicleta = $this->db->query($query_get)->result_array();
            $response = $this->simplifica_usuarios($response, $usuarios_bicicleta);
        }

        if ($pie > 0) {
            $query_get = "SELECT 
                id id_usuario           
                FROM users 
                WHERE    
                1 = 1   
                " . $extra_pie . "
                AND  id IN ( $ids )";

            $usuarios_pie = $this->db->query($query_get)->result_array();
            $response = $this->simplifica_usuarios($response, $usuarios_pie);
        }

        return $response;
    }

    function simplifica_usuarios($data_base, $usuarios)
    {

        if (es_data($usuarios)) {

            foreach ($usuarios as $row) {


                $data_base[] = $row['id_usuario'];
            }
        }
        return $data_base;
    }

    function entregas_auto($ids)
    {

        $query_get = "SELECT 
                id id_usuario         
                FROM users 
                WHERE
                 tiene_auto > 0 
                 AND 
                id in ($ids) 
                ORDER BY puntuacion DESC";

        $usuarios_auto = $this->db->query($query_get)->result_array();
        return $this->simplifica_usuarios([], $usuarios_auto);
    }

    function empresa_perfil($id_empresa, $in)
    {

        $query_get = "SELECT u.id FROM users u 
        INNER JOIN usuario_perfil up  
        ON u.id = up.idusuario  
        WHERE id_empresa = $id_empresa 
        AND up.idperfil in ($in)";

        return $this->db->query($query_get)->result_array();
    }

    
}

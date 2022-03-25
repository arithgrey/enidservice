<?php

use Enid\Paths\Paths  as Paths;
use Enid\Api\Api as Api;

class app extends CI_Controller
{
    private $paths;
    private $api;
    function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->paths = new Paths();
        $this->api = new Api();
    }

    function imgs_productos($id_servicio, $completo = 0, $limit = 1, $path = 0, $data = [])
    {

        if (es_data($data)) {

            $response = $this->path_imagenes($data);
        } else {

            $response = $this->get_img($id_servicio, $completo, $limit, $path);
        }

        return $response;
    }

    function imgs_usuarios($id_usuario, $completo = 0, $limit = 1, $path = 0, $data = [])
    {

        if (es_data($data)) {

            $response = $this->path_imagenes_usuario($data);
        } else {

            $response = $this->get_img_usuario($id_usuario, $completo, $limit, $path);
        }

        return $response;
    }

    private function path_imagenes_usuario($data)
    {
        $response = [];
        $a = 0;
        $usuarios = [];
        $usuarios_path = [];
        foreach ($data as $row) {
            $id = $data[$a]["id_usuario"];
            if (!in_array($id, $usuarios)) {

                $usuarios[] = $id;
                $path = $this->get_img_usuario($id, 1, 1, 1);
                $usuarios_path[] = [
                    'id' => $id,
                    'path' => $path
                ];
            } else {
                $path = search_bi_array($usuarios_path, 'id', $id, 'path');
            }

            $row["url_img_usuario"] = $path;
            $response[] = $row;
            $a++;
        }
        return $response;
    }

    private function path_imagenes($data)
    {
        $response = [];
        $a = 0;
        $servicios = [];
        $servicios_path = [];
        foreach ($data as $row) {
            $id = $data[$a]["id_servicio"];
            if (!in_array($id, $servicios)) {

                $servicios[] = $id;
                $path = $this->get_img($id, 1, 1, 1);
                $servicios_path[] = [
                    'id' => $id,
                    'path' => $path
                ];
            } else {
                $path = search_bi_array($servicios_path, 'id', $id, 'path');
            }

            $row["url_img_servicio"] = $path;
            $response[] = $row;
            $a++;
        }
        return $response;
    }

    function productos_ordenes_compra($id_orden_compra)
    {

        $q = ['id' => $id_orden_compra];
        $productos_ordenes_compra = $this->api->api("producto_orden_compra/orden_compra/", $q);
        return $this->add_imgs_servicio($productos_ordenes_compra);
    }
    function recompensa_orden_compra($id_orden_compra, $descuento = 1)
    {

        $q = ['id' => $id_orden_compra];
        $recompensa  =  $this->api->api("recompensa_orden_compra/id/", $q);
        $total_descuento = 0;

        if ($descuento > 0) {
            if (es_data($recompensa)) {

                $descuentos = array_column($recompensa, "descuento");
                $total_descuento = array_sum($descuentos);
            }
            return $total_descuento;
        }
        return $recompensa;
    }

    private function get_img($id_servicio, $completo = 0, $limit = 1, $path = 0)
    {

        $q["id_servicio"] = $id_servicio;
        $q["c"] = $completo;
        $q["l"] = $limit;

        $response = $this->api->api("imagen_servicio/servicio", $q);

        if ($path > 0) {
            $response = get_img_serv($response);
        }

        return $response;
    }

    private function get_img_usuario($id_usuario, $completo = 0, $limit = 1, $path = 0)
    {

        $q["id_usuario"] = $id_usuario;
        $q["c"] = $completo;
        $q["l"] = $limit;
        $api = "imagen_usuario/usuario/";
        $response = $this->api->api($api, $q);
        if ($path > 0) {
            $response = get_img_usr($response);
        }

        return $response;
    }

    function api($api, $q = [], $format = 'json', $type = 'GET', $debug = 0, $externo = 0, $b = "")
    {
        return $this->api->api($api, $q, $format, $type, $debug, $externo, $b);
    }

    function calcula_costo_envio($q)
    {

        return $this->api->api("cobranza/calcula_costo_envio", $q);
    }

    function send_email($q, $test = 0)
    {

        return $this->api->api(
            "sender/index",
            [
                "test" => $test
            ],
            'json',
            "POST",
            0,
            1,
            "msj"
        );
    }

    function usuario($id_usuario, $completo = 0, $fotos = 0)
    {

        $q = [
            "id_usuario" => $id_usuario,
            "c" => $completo,
        ];

        $usuario = $this->api->api("usuario/q/", $q);
        if ($fotos > 0) {
            $usuario = $this->add_imgs_usuario($usuario);
        }
        return $usuario;
    }

    function servicio($id_servicio, $completo = 0)
    {
        return $this->api->api(
            "servicio/base",
            [
                "id_servicio" => $id_servicio,
                "c" => $completo,
            ]
        );
    }

    function empresa($id_empresa)
    {

        return $this->api->api(
            "empresa/id/",
            [
                "id_empresa" => $id_empresa
            ]
        );
    }

    function paginacion($q)
    {

        return $this->api->api("paginacion/create/", $q);
    }

    function acceso()
    {

        if (!$this->is_logged_in()) {
            $this->out();
        }
    }

    function is_logged_in()
    {

        $is_logged_in = $this->session->userdata('logged_in');
        return (!isset($is_logged_in) || $is_logged_in != true) ? 0 : 1;
    }

    function out()
    {
        $this->session->unset_userdata($this->session);
        $this->session->sess_destroy();
        redirect(path_enid("_login"));
    }

    function set_userdata($newdata = array(), $newval = '')
    {

        $this->session->set_userdata($newdata, $newval);
    }

    function pagina($data, $center_page, $pagina_base = 0)
    {

        $this->load->view("header_template", $data);

        if ($pagina_base > 0) {

            $data["page"] = $center_page;
            $this->load->view("base", $data);
        } else {


            $this->load->view($center_page, $data);
        }

        $this->load->view("footer_template", $data);
    }

    function getperfiles()
    {
        return $this->session->userdata('perfiles')[0]["idperfil"];
    }

    function session()
    {
        $data["is_mobile"] = (dispositivo() === 1) ? 1 : 0;
        $data["proceso_compra"] = 0;
        $data["clasificaciones_departamentos"] = $this->api->api("clasificacion/primer_nivel");
        $data["footer_visible"] = true;
        if ($this->is_logged_in() > 0) {

            $session = $this->get_session();
            $nombre = $session["nombre"];
            $data['titulo'] = "";
            $data["menu"] = create_contenido_menu($session);
            $data["nombre"] = $nombre;
            $data["email"] = $session["email"];
            $data["perfilactual"] = pr($session["perfildata"], "nombreperfil", "");
            $data["id_perfil"] = pr($session['perfiles'], "idperfil", "");
            $data["in_session"] = 1;
            $data["no_publics"] = 1;
            $data["meta_keywords"] = "";
            $data["url_img_post"] = "";
            $data["id_usuario"] = $session["id_usuario"];
            $data["id_empresa"] = $session["idempresa"];
            $data["info_empresa"] = $session["info_empresa"];
            $data["desc_web"] = "";
            $data["data_status_enid"] = $session["data_status_enid"];
            $data["recien_creado"] = $session["recien_creado"];
            $data["path_img_usuario"] = $session["path_img_usuario"];
            $data["tipo_comisionista"] = $session["tipo_comisionista"];
        } else {

            $data["in_session"] = 0;
            $data["id_usuario"] = "";
            $data["nombre"] = "";
            $data["email"] = "";
            $data["telefono"] = "";
            $data["id_perfil"] = 0;
            $data["menu"] = "";
            $data["data_status_enid"] = "";
            $data['key_desarrollo'] = $this->config->item('key_desarrollo');
            $data["path_img_usuario"] = "";
        }

        $data['restricciones'] = $this->config->item('restricciones');
        return $data;
    }

    function get_session($key = [])
    {

        return (is_string($key)) ? $this->session->userdata($key) : $this->session->all_userdata();
    }

    function cSSJs($data, $key = '', $valida_session = 0)
    {
        $response = $this->paths->getcSSJs();
        if ($valida_session > 0) {
            $this->acceso();
        }

        if (array_key_exists($key, $response)) {

            $pagina = 0;
            foreach ($response[$key] as $clave => $valor) {

                $data[$clave] = $valor;
                if ($clave == "pagina") {
                    $pagina = $valor;
                }
            }

            $data["meta_keywords"] = $this->remplazo("meta_keywords", $data);
            $data["desc_web"] = $this->remplazo("desc_web", $data);
            $data["titulo"] = $this->remplazo("titulo", $data);
            $data["url_img_post"] = $this->remplazo("url_img_post", $data);

            $this->log_acceso($data, $pagina);
        } else {

            echo "NO EXISTE -> " . $key;
        }

        return $data;
    }
    function remplazo($key, $data)
    {
        $response = '';
        if (array_key_exists($key, $data)) {
            $response =  $data[$key];
        }
        return $response;
    }
    function add_imgs_servicio($ordenes, $key = "id_servicio", $index = 'url_img_servicio')
    {

        $a = 0;
        $response = [];
        if (es_data($ordenes)) {


            $path_servicio = [];
            $servicios = [];
            foreach ($ordenes as $row) {

                $orden = $row;
                $id_servicio = $ordenes[$a][$key];
                if (!in_array($id_servicio, $servicios)) {
                    $servicios[] = $id_servicio;
                    $path = $this->imgs_productos($id_servicio, 1, 1, 1);
                    $path_servicio[] = [
                        'id_servicio' => $id_servicio,
                        'path' => $path
                    ];
                    $orden[$index] = $path;
                } else {

                    $path = search_bi_array($path_servicio, 'id_servicio', $id_servicio, 'path');
                    $orden[$index] = $path;
                }

                $a++;
                $response[] = $orden;
            }
        }
        return $response;
    }

    function add_imgs_usuario($usuarios, $key = "id")
    {

        $a = 0;
        $response = [];
        $path_usuario = [];
        $nuevos_usuarios = [];
        foreach ($usuarios as $row) {

            $orden = $row;
            $id_usuario = $usuarios[$a][$key];
            if (!in_array($id_usuario, $nuevos_usuarios)) {
                $nuevos_usuarios[] = $id_usuario;
                $path = $this->imgs_usuarios($id_usuario, 1, 1, 1);
                $path_usuario[] = [
                    'id_usuario' => $id_usuario,
                    'path' => $path
                ];
                $orden["url_img_usuario"] = $path;
            } else {

                $path = search_bi_array($path_usuario, 'id_usuario', $id_usuario, 'path');
                $orden["url_img_usuario"] = $path;
            }

            $a++;
            $response[] = $orden;
        }

        return $response;
    }

    function session_enid()
    {

        return $this->session;
    }

    function set_flashdata($newdata = array(), $newval = '')
    {

        $this->session->set_flashdata($newdata, $newval);
    }

    function saldos_pendientes_orden_compra($id_orden_compra)
    {

        $saldos = [];
        $productos_orden_compra = $this->productos_ordenes_compra($id_orden_compra);

        foreach ($productos_orden_compra as $row) {

            $saldos[] = $this->get_recibo_saldo_pendiente($row["id_proyecto_persona_forma_pago"]);
        }
        return $saldos;
    }

    private function get_recibo_saldo_pendiente($id_recibo)
    {

        return $this->api->api("recibo/saldo_pendiente_recibo/", ["id_recibo" => $id_recibo]);
    }

    function direccion($id)
    {

        return $this->api->api("direccion/data_direccion/", ["id_direccion" => $id]);
    }

    function get_direccion_pedido($id_recibo)
    {

        $request =
            [
                "id_recibo" => $id_recibo
            ];
        return $this->api->api(
            "proyecto_persona_forma_pago_direccion/recibo/",
            $request
        );
    }

    /*Recibe los productos ordenes de compra o el id de la orden de compra*/
    function domicilios_orden_compra($productos_orden_compra)
    {

        $es_data = !is_array($productos_orden_compra);
        $es_num = ($productos_orden_compra > 0);
        if ($es_data && $es_num) {
            $productos_orden_compra =
                $this->productos_ordenes_compra($productos_orden_compra);
        }
        $response = [];
        foreach ($productos_orden_compra as $row) {
            $recibo[0] = $row;
            $domicilio = $this->get_domicilio_entrega($recibo);
            if (es_data($domicilio)) {
                if (es_data($domicilio)) {

                    $response[] = $domicilio[0];
                }
            }
        }
        return $response;
    }

    function asigna_reparto($id_orden_compra)
    {
        return $this->api->api("recibo/reparto", ["orden_compra" => $id_orden_compra], "json", "PUT");
    }

    function get_domicilio_entrega($producto_orden_compra)
    {

        $response = [];
        foreach ($producto_orden_compra as $row) {

            $tipo_entrega = $row["tipo_entrega"];
            $ubicacion = $row["ubicacion"];
            $id_recibo = $row["id_proyecto_persona_forma_pago"];

            switch ($tipo_entrega) {

                case 2: //Mensajería
                    if ($ubicacion > 0) {
                        $response = $this->get_ubicacion_recibo($id_recibo);
                    } else {
                        $response = $this->get_domicilio_recibo($id_recibo);
                    }
                    break;
                default:
            }

            if (es_data($response)) {

                $response[0]["tipo_entrega"] = $tipo_entrega;
                $response[0]["es_ubicacion"] = $ubicacion;
            }
        }

        return $response;
    }

    private function get_domicilio_recibo($id_recibo)
    {

        $direccion = $this->get_direccion_pedido($id_recibo);
        $domicilio = [];

        $id_direccion = pr($direccion, "id_direccion");
        if ($id_direccion > 0) {

            $domicilio = $this->direccion($id_direccion);
        }

        return $domicilio;
    }

    private function get_ubicacion_recibo($id_recibo)
    {
        return $this->api->api("ubicacion/index", ["id_recibo" => $id_recibo]);
    }

    function totales_seguidores($id_usuario)
    {

        return $this->api->api("usuario_conexion/totales_seguidores/", ["id_usuario" => $id_usuario]);
    }

    function recibos_usuario($id_usuario, $es_pago = 0)
    {

        return $this->api->api(
            "recibo/usuario_relacion/",
            [
                "id_usuario" => $id_usuario,
                "es_pago" => $es_pago
            ]
        );
    }

    function log_acceso($data, $pagina)
    {

        if ($pagina > 0) {
            $q = [
                "in_session" => $data["in_session"],
                "is_mobile" => $data["is_mobile"],
                "pagina_id" => $pagina
            ];

            $api = "acceso/index";
            return $this->api->api($api, $q, "json", "POST");
        } else {
            //echo "No tienes ID de página";
        }
    }

    function tipo_comisionistas()
    {

        return $this->api->api("tipo_comisionista/index");
    }
    function recompensas_recibos($recibos)
    {

        $response =  [];
        if (es_data($recibos)) {

            $ids = array_unique(array_column($recibos, 'id_orden_compra'));
            $response =  $this->api->api("recompensa/ids_recibo_descuento", ["ids" => $ids]);
        }
        return $response;
    }
}

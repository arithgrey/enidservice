<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->load->helper("deseos");

    }

    function index()
    {


        $data = $this->app->session(6);
        $in_session = $data['in_session'];
        if ($in_session) {

            $this->app->acceso();
            $param = $this->input->get();

            if (prm_def($param, "q") === "preferencias") {


                $this->render_preferencias($data);

            } else {

                $this->load_lista_deseos($data);

            }


        } else {

            $this->explorar_deseos($data);
        }

    }

    private function render_preferencias($data)
    {

        $data += [
            "preferencias" => $this->get_preferencias($data["id_usuario"]),
            "tmp" => format_preferencias()
        ];
        $this->app->pagina(
            $this->app->cssJs($data, "lista_deseos_preferencias"),
            render_deseos($data),
            1
        );
    }

    private function load_lista_deseos($data)
    {

        $lista_deseo = $this->get_lista_deseos($data["id_usuario"]);
        $data["productos_deseados"] = $this->add_imagenes($lista_deseo);
        if (es_data($data["productos_deseados"])) {

            $data = $this->app->cssJs($data, "lista_deseos_productos_deseados");
            $data["usuario"] = $this->app->usuario($data["id_usuario"]);
            $this->app->pagina($data, productos_deseados($data, $data["productos_deseados"] ), 1);

        } else {

            $this->app->pagina($data, sin_productos(), 1);

        }
    }

    private function explorar_deseos($data)
    {
        $q = ['ip' => $this->input->ip_address()];
        $lista_deseo = $this->app->api("usuario_deseo_compra/index/format/json/", $q);

        if (es_data($lista_deseo)) {


            $data = $this->app->cssJs($data, "lista_deseos_productos_deseados");
            $this->app->pagina($data, productos_deseados($data,  $lista_deseo, 1), 1);

        } else {
            $this->app->pagina($data, sin_productos(), 1);
        }
    }

    private function add_imagenes($servicios)
    {
        $response = [];
        $a = 0;
        foreach ($servicios as $row) {

            $servicio = $row;
            $id_servicio = $servicios[$a]["id_servicio"];
            $servicio["url_img_servicio"] = $this->app->imgs_productos($id_servicio, 1, 1, 1);
            $a++;
            $response[] = $servicio;
        }
        return $response;

    }


    private function get_lista_deseos($id_usuario)
    {

        $q = [
            "id_usuario" => $id_usuario,
            "c" => 1,
        ];
        return $this->app->api("usuario_deseo/usuario/format/json/", $q);
    }

    private function get_preferencias($id_usuario)
    {
        return $this->app->api("clasificacion/interes_usuario/format/json/", ["id_usuario" => $id_usuario]);
    }
}
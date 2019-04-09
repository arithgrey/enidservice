<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("pago");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();
        if (get_param_def($param, "info") > 0) {
            $this->crea_info();
        } else {
            (ctype_digit($this->input->get("recibo"))) ? $this->crea_orden() : redirect("../../");
        }
    }

    private function crea_info()
    {

        $data = $this->principal->val_session("");
        $data["meta_keywords"] = "";
        $data["desc_web"] = "Formas de pago Enid Service";
        $data["url_img_post"] = create_url_preview("formas_pago_enid.png");
        $data["clasificaciones_departamentos"] = "";
        $response = div(get_format_pago(), 6, 1);
        $this->principal->show_data_page($data, $response, 1);
    }

    private function crea_orden()
    {

        $data = $this->principal->val_session("");
        $data["meta_keywords"] = "";
        $data["desc_web"] = "";
        $data["url_img_post"] = create_url_preview("formas_pago_enid.png");
        $id_recibo = $this->input->get("recibo");
        $data["recibo"] = $id_recibo;
        $info_recibo = $this->get_recibo_forma_pago($id_recibo);

        $data["clasificaciones_departamentos"] = "";
        //$this->principal->show_data_page($data, 'home');
        $response = div($info_recibo, ["class" => "col-lg-8 col-lg-offset-2 contenedor_principal_enid"]);
        $this->principal->show_data_page($data, $response, 1);

    }

    private function get_recibo_forma_pago($id_recibo)
    {

        $q = ['id_recibo' => $id_recibo];
        $api = "recibo/resumen_desglose_pago";
        return $this->principal->api($api, $q, "html");
    }

}
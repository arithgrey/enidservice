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
        $i = get_param_def($param, "info");

        switch ($i) {


            case $i >  0 :

                $this->crea_info();

                break;

            default:

                $fn = (ctype_digit($this->input->get("recibo"))) ? $this->crea_orden() : redirect("../../");

                break;


        }

    }

    private function crea_info()
    {

        $this->principal->show_data_page($this->principal->getCssJs($this->principal->val_session(), "forma_pago") , get_format_pago(), 1);

    }

    private function crea_orden()
    {

        $data = $this->principal->val_session("", "", "", create_url_preview("formas_pago_enid.png"));
        $id_recibo = $this->input->get("recibo");
        $data["recibo"] = $id_recibo;
        $recibo = $this->get_recibo_forma_pago($id_recibo);
        $this->principal->show_data_page($data, get_format_orden($recibo), 1);

    }

    private function get_recibo_forma_pago($id_recibo)
    {

        $q = ['id_recibo' => $id_recibo];
        $api = "recibo/resumen_desglose_pago";
        return $this->principal->api($api, $q, "html");
    }

}
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
        $i = prm_def($param, "info");

        switch ($i) {


            case $i >  0 :

                $this->crea_info();

                break;

            default:

                $fn = (ctype_digit($this->input->get("recibo"))) ?
                    $this->crea_orden() :
                    redirect(path_enid("go_home"));

                break;


        }

    }

    private function crea_info()
    {

        $this->app->pagina($this->app->cssJs($this->app->session(), "forma_pago") , get_format_pago(), 1);

    }

    private function crea_orden()
    {

        $data = $this->app->session("", "", "", create_url_preview("formas_pago_enid.png"));
        $id_recibo = $this->input->get("recibo");
        $data["recibo"] = $id_recibo;

        $this->app->pagina(
            $data,
            format_orden($this->get_recibo_forma_pago($id_recibo)),
            1
        );

    }

    private function get_recibo_forma_pago($id_recibo)
    {

        return $this->app->api("recibo/resumen_desglose_pago", ['id_recibo' => $id_recibo], "html");

    }

}
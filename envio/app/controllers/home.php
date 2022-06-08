<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    private $data;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("pago");
        $this->load->library(lib_def());
        $this->data = $this->app->session();

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
        
        $data = $this->app->cssJs($this->data, "forma_pago");
        $this->app->pagina($data , get_format_pago(), 1);

    }

    private function crea_orden()
    {
                
        $id_recibo = $this->input->get("recibo");
        $this->data["recibo"] = $id_recibo;

        $this->app->pagina(
            $data,
            format_orden($this->get_recibo_forma_pago($id_recibo)),
            1
        );

    }

    private function get_recibo_forma_pago($id_recibo)
    {

        return $this->app->api("recibo/resumen_desglose_pago", ['id_orden_compra' => $id_recibo], "html");

    }

}
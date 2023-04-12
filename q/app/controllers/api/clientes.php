<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';
use Enid\Leads\LeadsFormat;
use Google\Service\StreetViewPublish\Level;

class clientes extends REST_Controller
{   
    private $leads_format;
    function __construct()
    {
        parent::__construct();
        $this->load->model("recibo_model");
        $this->load->library(lib_def());
        $this->leads_format = new LeadsFormat($this->recibo_model);

    }

    function recibos_sin_ficha_seguimiento_GET()
    {
        $param = $this->get();
        $response = $this->leads_format->recibos_sin_ficha_seguimiento();
        $this->response($response);
    }
}

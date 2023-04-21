<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Enid\RespuestasFrecuentes\Form as FormRespuestaFrecuente;

class Home extends CI_Controller
{

    private $formRespuestaFrecuente;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->app->acceso();
        $this->load->helper("respuestas");
        $this->formRespuestaFrecuente =  new FormRespuestaFrecuente();
    }

    function index()
    {

        $data = $this->app->session();
        $data = $this->app->cssJs($data, "respuestas_frecuentes");
        $data["formulario_busqueda_frecuente"] = $this->formRespuestaFrecuente->busqueda(0);
        $data["formulario_registro"] = $this->formRespuestaFrecuente->registro();

        $this->app->pagina($data, render($data), 1);
    }
}

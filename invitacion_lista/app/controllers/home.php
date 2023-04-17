<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Enid\Invitacion\Invitacion;

class Home extends CI_Controller
{
    private $invitacion;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->invitacion =  new Invitacion();
    }

    function index()
    {
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "invitacion_lista");

        $data["footer_visible"] = false;
        $data["navegacion_principal"] = false;
        $data["pixel_facebook"] = false;
        $data["titulo"] = "Lista de invitados";
        $data["url_img_post"] = "invitacion_enlace.jpeg";
        $data["presentacion"] = $this->invitacion->format();
        $this->app->pagina($data, 'invitacion/lista');
    }
}

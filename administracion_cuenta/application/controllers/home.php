<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("cuenta");
        $this->load->library(lib_def());                
        $this->app->acceso();
     
    }

    function index()
    {
            
        $data = $this->app->session();
        $id_usuario= $this->app->get_session("idusuario");
        $usuario = $this->app->usuario($id_usuario,1);
        $usuario = $this->app->add_imgs_usuario($usuario);
        $data["usuario"] = $usuario;
        $data = $this->app->cssJs($data, "administracion_cuenta", 1);
        $this->app->pagina($data, render_cuenta($data),1);

    }

}
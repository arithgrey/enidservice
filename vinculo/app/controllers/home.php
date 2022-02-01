<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('vinculo');
        $this->load->library(lib_def());
    }

    function index()
    {

        $params = $this->input->get();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "vinculo");
        $faq = $this->faq($params["tag"]);
        $this->app->pagina($data, render($faq), 1);

    }
    private function faq($id)
    {

        return $this->app->api("pregunta_frecuente/index",
            [
                "id" => $id
            ]
        );
    }

}
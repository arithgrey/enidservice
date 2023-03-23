<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Sess extends REST_Controller
{
    private $session_enid;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->session_enid = new Enid\SessionEnid\Format($this->app);
    }

    function start_post()
    {

        $param = $this->post();
        $response = false;    
        $response = [];
        if (fx($param, "email,secret")) {

            $response = 
            $this->session_enid->session($param["email"],$param["secret"]);

            $this->response($response);
        }
        $this->response($response);
    }
}

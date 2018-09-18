<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class cuenta_pago extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                                      
       	$this->load->model("cuenta_pago_model");
        $this->load->library(lib_def());     
    }

}?>

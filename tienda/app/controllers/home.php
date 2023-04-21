<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        
    }

    function index()
    {

        $param = $this->input->get();            
        
        setcookie('xn', prm_def($param, "xn",1), strtotime('2038-01-01'),"/");
        header("location:../search/?q2=0&q=kitsmasvendidos&order=2");        
        
    }

    
}

<?php

use \SMB\UrlStatus;
class Home extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());                        
        $this->load->helper('web');
     
    }

    function index()
    {
        $response = [];
        
        
        $data = $this->app->session();    
        $this->app->pagina($data, append($response),1);

    }

}
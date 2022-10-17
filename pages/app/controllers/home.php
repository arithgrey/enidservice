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
        
        $endpoints = accesos_test(); 
        //$endpoints += accesos_internos();        

        foreach($endpoints as $row){

            $url = _text('http://localhost/web/', $row);                        
            $ret = \SMB\UrlStatus::get($url);                                        
            $codigo = $ret->code();
            $es_url_valida = $ret->isValidUrl();            
            $response[] = test_web($url , $codigo, $es_url_valida);             
        }

        $data = $this->app->session();    
        $this->app->pagina($data, append($response),1);

    }

}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");           
    }        
    /*enviamos promo servicios díaria*/              
    function index(){        
       echo "ok";
    }
    /**/   
}
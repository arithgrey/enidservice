<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Paginacion extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        $this->load->library("pagination");                         
    }
    function create_GET(){

        $param              =   $this->get();                  
        $response           =   false;
        if (if_ext($param , "totales_elementos,per_page,q")) {

            $totales_elementos  =   $param["totales_elementos"];
            $per_page           =   $param["per_page"];         
            $q                  =   $param["q"];        
            
            $base_url           = "?q=".$q;
            if( get_param_def($param , "q2" , 0 , 1 ) > 0 ){
                $q2        =    $param["q2"];    
                $base_url .=    "&q2=$q2";
            }if(get_param_def($param , "q3" , 0 , 1 )  > 0){
                $q3         =   $param["q3"];    
                $base_url  .=   "&q3=".$q3;
            }
            if ( get_param_def($param , "order" , 0 , 1 ) > 0  ) {
                $base_url .= "&order=".$param["order"];
            }

            
            $config['full_tag_open']    = '<div class="pagination">';
            $config['full_tag_close']   = '</div>';
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';        
            $config['cur_tag_open']     = '<li class="active"><span>';
            $config['cur_tag_close']    = '<span></span></span></li>';
            $config['prev_tag_open']    = '<li>';
            $config['prev_tag_close']   = '</li>';
            $config['next_tag_open']    = '<li>';
            $config['next_tag_close']   = '</li>';        
            $config['prev_link']        = '«';
            $config['last_link']        = '»';
            $config['next_link']        = '<span class="white">›</span>';
            $config['first_tag_open']   = '<li>';
            $config['first_tag_close']  = '</li>';
            $config['last_tag_open']    = '<li>';
            $config['last_tag_close']   = '</li>'; 
            $config['per_page']         = $per_page;
            $config['base_url']         = $base_url;    
            $config['num_links']        = 10;     
            $config['first_link']       = '<span class="white">« Primera</span>';
            $config['last_link']        = '<span class="white">Última»</span>';
            $config['total_rows']       = $totales_elementos;                
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string']= TRUE;     
            $config['enable_query_strings'] = TRUE;                
            $config['query_string_segment'] = 'page';
            
            $this->pagination->initialize($config);
            $response  =   $this->pagination->create_links();              

        }
        $this->response($response);
        
    }
}
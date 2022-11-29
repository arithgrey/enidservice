<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        $client = new Google_Client();
        $client->setClientId($this->config->item('googleClientId'));
        $client->setClientSecret($this->config->item('googleClientSecret'));
        $client->setRedirectUri($this->config->item('googleRedirectUriRegister'));
        $client->addScope("email");
        $client->addScope("profile");
    
        
        if (strlen(prm_def($param, 'code')) > 3 ) {
            
            $token = $client->fetchAccessTokenWithAuthCode($param['code']);

            $client->setAccessToken($token['access_token']);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email =  $google_account_info->email;            
            $name =  $google_account_info->name;            
            
            if($google_account_info->verifiedEmail){       

                $this->vendedor($name, $email);                
                redirect(path_enid("login_registrado"));

            }
                  
        } 
        
    }
    
    private function vendedor($nombre, $email){
        
        return $this->app->api("usuario/vendedor", 
        [
            "email" => $email,
            "nombre" => $nombre,
            "password" => sha1($email)
        ], 
        "json", "POST");

    }
       
}

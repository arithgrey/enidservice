<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("log");
        $this->load->library(lib_def());
    }

    function index()
    {

        $client = new Google_Client();
        $client->setClientId($this->config->item('googleClientId'));
        $client->setClientSecret($this->config->item('googleClientSecret'));
        $client->setRedirectUri($this->config->item('googleRedirectUri'));
        $client->addScope("email");
        $client->addScope("profile");
        $authUrl = '';
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($this->input->get('code'));
            
            $client->setAccessToken($token['access_token']);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;
            $picture =  $google_account_info->picture;
            
            
        } else {
            $authUrl =  $client->createAuthUrl();
        }

        $param = $this->input->get();
        $this->validate_user_sesssion();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "login");
        $data["auth_url"] = $authUrl;
        $this->app->pagina($data, page_sigin(prm_def($param, "action"), $data), 1);
    }

    function validate_user_sesssion()
    {

        if (intval($this->app->is_logged_in()) > 0) {
            redirect(path_enid("url_home"));
        }
    }

    function logout()
    {

        $this->app->out();
    }
}

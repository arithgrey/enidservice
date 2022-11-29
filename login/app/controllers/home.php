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
            $picture =  $google_account_info->picture;
            
            /*
                $name =  $google_account_info->name;            
            */
            $this->google_session($email, $picture);

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
    private function google_session($email, $picture)
    {

        $response = [];
        $usuario = $this->usuario_email($email);
        $response["usuario"] = $usuario;
        $response["login"] = false;
        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $id_usuario = $usuario["id"];
            $nombre = $usuario["name"];
            $email = $usuario["email"];
            $id_empresa = $usuario["id_empresa"];

            $session = $this->enid_session($picture,$id_usuario, $nombre, $email, $id_empresa);
            $response["session"] = $session;
            $response["session_creada"] = $this->app->get_session();        
            redirect(path_enid("url_home"));
        }

    }
    private function enid_session($picture ,$id_usuario, $nombre, $email, $id_empresa)
    {

        $empresa = $this->app->get_empresa($id_empresa);
        $perfiles = $this->app->get_perfil_user($id_usuario);
        $perfildata = $this->app->get_perfil_data($id_usuario);
        $empresa_permiso = $this->app->get_empresa_permiso($id_empresa);
        $empresa_recurso = $this->app->get_empresa_recursos($id_empresa);
        $status_enid = $this->app->estatus_enid_service();
        $response = 0;

        if (es_data($perfiles)) {

            $navegacion = $this->app->get_recursos_perfiles($perfiles);
            $usuario[] = ["id" => $id_usuario];

            if (es_data($navegacion)) {

                $response = [
                    "id_usuario" => $id_usuario,
                    "nombre" => $nombre,
                    "email" => $email,
                    "perfiles" => $perfiles,
                    "perfildata" => $perfildata,
                    "id_empresa" => pr($empresa, "id"),
                    "empresa_permiso" => $empresa_permiso,
                    "empresa_recurso" => $empresa_recurso,
                    "data_navegacion" => $navegacion,
                    "info_empresa" => $empresa,
                    "data_status_enid" => $status_enid,
                    "logged_in" => 1,
                    "recien_creado" => 0,
                    "path_img_usuario" => $picture,
                    "tipo_comisionista" => $this->app->tipo_comisionistas()
                ];

                $this->app->set_userdata($response);
            }
        }
        return $response;
    }

    private function usuario_email($email)
    {

        return $this->app->api("usuario/email", ["email" => $email], "json", "POST");
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

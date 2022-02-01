<?php 

class Home extends CI_Controller
{   
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper("recomendacion");
        $this->load->library(lib_def());
        
    }

    function index()
    {

        $param = $this->input->get();
        $id_usuario = $this->input->get("q");    
        $usuario = $this->app->usuario($id_usuario);

        if(es_data($usuario)){
            $this->create_vista($usuario, $id_usuario, $param);
        }else{
            $this->go_home();
        }   

    }

    private function create_vista($usuario, $id_usuario, $param)
    {

        $data = $this->app->session();        
        $recomendacion = $this->busqueda_recomendacion($id_usuario);
        
        if ($data["in_session"] == 1) {
            $this->notifica_lectura($id_usuario, $data["id_usuario"]);
        }

        $config = config_paginador($param, $recomendacion, $id_usuario);
        $data["paginacion"] = $this->get_paginacion($config);
        $data = $this->app->cssJs($data, "recomendacion_vista");
        $data["resumen_valoraciones_vendedor"] = $this->resumen_valoraciones_vendedor($config,  $id_usuario);
        $data["usuario"] = $usuario;
        $data["resumen_recomendacion"] = $recomendacion["info_valoraciones"];

    
        $this->app->pagina($data, format_recomendacion($data), 1);

    }

    private function busqueda_recomendacion($id_usuario)
    {

        return $this->app->api("valoracion/usuario", 
        [
            "id_usuario" => $id_usuario
        ]);

    }

    private function notifica_lectura($id_usuario, $id_usuario_valoracion)
    {

        if ($id_usuario === $id_usuario_valoracion) {

            $this->app->api("valoracion/lectura", 
            [
                "id_usuario" => $id_usuario
            ], 
            'json', 
            'PUT');

        }
    }

    private function resumen_valoraciones_vendedor($q, $id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->app->api("valoracion/resumen_valoraciones_vendedor", $q);
    }

    private function get_paginacion($q)
    {

        return $this->app->api("producto/paginacion", $q);
    }

    private function go_home()
    {
        redirect("../../", 'POST');
    }
}
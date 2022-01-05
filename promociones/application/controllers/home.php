<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller
{
    public $options;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("recompensa");
        $this->load->library(lib_def());
    }

    function index()
    {
        $param = $this->input->get();        
        $data = $this->app->session(3);
        $numero_recompensas = $this->total_recompensas();

        $configuracion_paginacion = $this->configuracion_paginador($param, $numero_recompensas);
        $data["html_paginador"] = $configuracion_paginacion["html_paginador"];

        $data["recompensa"] = $this->recompensas($configuracion_paginacion["paginacion"]);        
        
        $data = $this->app->cssJs($data, "recompensa");
        $this->app->log_acceso($data, 21);
        $this->app->pagina($data, recompensa($data), 1);

    }

    private function configuracion_paginador($param, $numero_recompensas){
        
        $page = prm_def($param, "page",1); /*Pagina actual*/        
        $per_page = prm_def($param, "rpg", 8); //la cantidad de registros que desea mostrar
        $adjacents = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
            
        $conf["page"] = $page;
        $conf["totales_elementos"] = $numero_recompensas;
        $conf["per_page"] = $per_page;
        $conf["q"] = "";
        $conf["q2"] = "";

        
        return [
            "html_paginador"    => $this->app->paginacion($conf) , 
            "paginacion" => " LIMIT $offset , $per_page "
        ];

    }

    private function recompensas($configuracion_paginacion)
    {

        $api = "recompensa/disponible/format/json/";
        return $this->app->api($api, ["paginacion" => $configuracion_paginacion ]);

    }

    private function total_recompensas()
    {

        $api = "recompensa/total_disponible/format/json/";
        return $this->app->api($api);

    }


}

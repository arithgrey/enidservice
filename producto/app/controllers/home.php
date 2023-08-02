<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Enid\ServicioImagen\Format as FormatImgServicio;
class Home extends CI_Controller
{    
    private $id_servicio;     
    private $servicio_imagen;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("producto");
        $this->load->library(lib_def());
        $this->id_servicio = $this->input->get("producto");        
        $this->servicio_imagen = new FormatImgServicio();
    }

    function index()
    {
        $param = $this->input->get();                
        evita_basura($this->id_servicio);
        $method = $_SERVER['REQUEST_METHOD'];
        if (ctype_digit($this->id_servicio)) {
            
            $this->load_servicio($param);

        } else {

            $id_recibo = $this->input->get("recibo");
            $this->recibo($id_recibo, $method);

        }       

    }

    function recibo($id_recibo, $method)
    {

        if ($method == "POST" && ctype_digit($id_recibo)) {

            $this->view_recibo_registrado();

        } else {

            redirect(
                "https://www.google.com/", "refresh", 302);
        }

    }

    private function load_servicio($param)
    {   
        
        $data = $this->app->session();
        $data["proceso_compra"] = (!$data["in_session"]) ? prm_def($param, "proceso") : 1;

        if ($this->id_servicio < 1) {

            $this->app->pagina($data, no_encontrado());

        } else {

            $data["desde_valoracion"] = prm_def($param, "valoracion");
            $this->vista($param, $data);
        }
    }

    private function vista($param, $data)
    {
    
        
        $data["q2"] = prm_def($param, "q2");
        $servicio = $this->app->servicio($this->id_servicio);                
        if(pr($servicio, "status") > 0){

            $data["tallas"] = $this->get_tallas($this->id_servicio);
            $path = path_enid("go_home");
            $id_usuario = pr($servicio, "id_usuario");
    
            $usuario = (es_data($servicio)) ? $this->app->usuario($id_usuario) : redirect($path);
            $redirect = (!es_data($usuario)) ? redirect($path) : "";
            $data["usuario"] = $usuario;
            $data["id_publicador"] = key_exists_bi($servicio, 0, "id_usuario", 0);
        
            $data["info_servicio"]["servicio"] = $servicio;
            $data["costo_envio"] = "";
            $data["tiempo_entrega"] = "";
            $data["ciclos"] = "";            
            if (pr($servicio, "flag_servicio") == 0) {
    
                $nicho = $this->app->api("nicho/id",["id" => $data["id_nicho"]]);
                
                $data["costo_envio"] = 0;                
                $data["tiempo_entrega"] = valida_tiempo_entrega($servicio, $nicho);
            }
    
            
            $data["imgs"] = $this->app->imgs_productos($this->id_servicio, 1, 10);    
            $data["meta_keywords"] = costruye_meta_keyword($servicio);
            
            $this->crea_historico_vista_servicio($this->id_servicio);
            $data["url_actual"] = get_url_request("");        
    
            if (es_data($data["imgs"])) {
                $nombre_imagen = pr($data["imgs"], "nombre_imagen");
                $data["url_img_post"] = url_post($nombre_imagen);
            }
            
            $titulo_nombre_servicio = html_escape(pr($servicio,"nombre_servicio"));                                                                                                                                                    

            $data["desc_web"] = descripcion($servicio);
            $data["titulo"] = $titulo_nombre_servicio;
            $data["id_servicio"] = $this->id_servicio;
            $data["existencia"] = $this->get_existencia($this->id_servicio);
            $data["servicio_materiales"] = $this->servicio_materiales($this->id_servicio);
            $data["recompensa"] = $this->recompensa($this->id_servicio);
            $data["alcaldias"] = $this->app->api("delegacion/cobertura");
            $is_mobile = $data["is_mobile"];
            
            $data["imagenes"] = $this->servicio_imagen->formatG($data["imgs"], pr($servicio, "nombre_servicio"), $is_mobile);
            $data = $this->app->cssJs($data, "producto");    
              
            $this->app->log_acceso($data, 3, $this->id_servicio  );
            $this->app->pagina($data, render_producto($data), 1);
            
            
        }else{
            
            $data = $this->app->cssJs($data, "sin_encontrar");
            $this->app->pagina($data, sin_resultados($data), 1);            
            

        }
    
    }

    private function servicio_materiales($id_servicio)
    {

        return $this->app->api("servicio_material/id",
            [
                'id_servicio' => $id_servicio,
                "materiales" => 1
            ]
        );

    }

    private function get_tallas($id_servicio)
    {
        
        return $this->app->api("servicio/talla", 
            [
                "id" => $id_servicio,
                "v" => "1",
                "id_servicio" => $id_servicio

            ]
        );
    }

    private function crea_historico_vista_servicio($id_servicio)
    {
        $this->app->api("servicio/visitas",
            [
                "id_servicio" => $id_servicio
            ],
            'json',
            'PUT'
        );
    }

    private function get_existencia($id_servicio)
    {
        
        return $this->app->api("servicio/existencia", ["id_servicio" => $id_servicio]);
    }

    private function recompensa($id_servicio)
    {
                
        return $this->app->api("recompensa/visible", ["id_servicio" => $id_servicio]);

    }

    function view_recibo_registrado()
    {

        $data = $this->app->session();
        $param = $this->input->get();
        $data +=
            [
                "meta_keywords" => "",
                "desc_web" => "",
                "url_img_post" => "",
                "id_servicio" => $param["servicio"],
                "recibo" => $param["recibo"],
                "proceso_compra" => 1,
                "orden_pedido" => 0,

            ];

        $this->app->pagina($this->app->cssJs($data, "producto_recibo_registrado"), render_tipo_entrega($data));

    }
}

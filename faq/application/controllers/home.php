<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("faq");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->principal->val_session("");
        $data["respuesta"] = "";
        $data["faqs_categoria"] = "";
        $data["r_sim"] = "";

        $param = ($this->input->get() !== false) ? $this->input->get() : [];
        $faq = (array_key_exists("faq", $param)) ? $param["faq"] : "";
        $faqs = (array_key_exists("faqs", $param)) ? $param["faqs"] : "";
        $categoria = (array_key_exists("categoria", $param)) ? $param["categoria"] : "";

        $data["es_form"] =  ( get_param_def($param , "nueva") > 0 ) ?  1 : 0 ;
        $data["categorias_publicas_venta"] = $this->get_categorias_por_tipo(1);
        $data["categorias_temas_de_ayuda"] = $this->get_categorias_por_tipo(5);

        $flag_busqueda_q = get_param_def($param , "faq");
        $data["flag_busqueda_q"] = $flag_busqueda_q;
        $data["lista_categorias"] = $this->get_categorias_tipo(1);

        if ($flag_busqueda_q >  0 ) {

            $data["respuesta"] = $this->get_faq($faq);

        }

        $flag_categoria = get_param_def($param, "categoria");
        if ($flag_categoria >  0 ) {

            $data["faqs_categoria"] = $this->get_faqs_categoria($categoria, $data);

        }

        $flag_busqueda_personalidaza = get_param_def($param, "faqs");
        $data["flag_busqueda_personalidaza"] = $flag_busqueda_personalidaza;

        if ($flag_busqueda_personalidaza > 0 ) {

            $data["faqs_categoria"] = $this->search_faqs($faqs);
        }
        $data["param"] = $this->input->get();
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos();

        $data = $this->getCssJs($data);
        $this->principal->show_data_page($data, get_format_faqs($data)  , 1);

    }

    private function get_categorias_por_tipo($tipo)
    {

        $q["tipo"] = $tipo;
        $api = "categoria/categorias_por_tipo/format/json/";
        $response = $this->principal->api($api, $q);

        return $response;
    }

    private function get_faqs_categoria($id_categoria, $data)
    {

        $in_session = $data["in_session"];
        $extra = " AND status IN(1, 2, 3) ";
        if ($in_session == 1) {
            $id_perfil = $data["id_perfil"];
            $extra = ($id_perfil == 20) ? " AND status IN(1, 3) " : "";
        }

        $q["id_categoria"] = $id_categoria;
        $q["extra"] = $extra;

        $api = "faqs/qsearch/format/json/";
        $response = $this->principal->api($api, $q);

        $response =  $this->append_imgs($response);

        return $response;

    }
    private function append_imgs($data){

        $response =  [];

        $a = 0;
        foreach($data as $row ){

            $response[$a] =  $row;
            $id_faq     =  $row["id_faq"];
            $img_faq    =  $this->get_img_faq($id_faq);

            $url_img  = "";
            if ( count($img_faq) >  0 ){

                $url_img = path_enid("img_faq", $img_faq[0]["nombre_imagen"]);

            }

            $response[$a]["url_img"] =  $url_img;
            $a ++;

        }
        return $response;

    }
    private function  get_img_faq($id_faq){

        $q["id_faq"] = $id_faq;
        $api = "imagen_faq/img/format/json/";
        return $this->principal->api($api, $q);

    }
    private function get_categorias_tipo($tipo = 1)
    {

        $q["tipo"] = $tipo;
        $api = "categoria/categorias_por_tipo/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_faq($faq)
    {

        $q["id"] = $faq;
        $api = "faqs/id/format/json/";
        $response = $this->principal->api($api, $q);
        return $response;

    }

    private function search_faqs($q)
    {
        $param["q"] = $q;
        $api = "faqs/search/format/json/";
        return $this->principal->api($api, $param);
    }

    private function getCssJs($data)
    {
        $data["js"] = [
            "js/summernote.js",
            "faq/principal.js"
        ];
        $data["css"] = [
            "faqs.css",
            "faqs_second.css"
        ];
        return $data;
    }
}
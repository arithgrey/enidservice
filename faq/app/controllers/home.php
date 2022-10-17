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

        $data = $this->app->session();
        $param = $this->input->get();

        $faqs = prm_def($param, 'faqs');
        $categoria = prm_def($param, 'categoria');

        $data["es_form"] = prm_def($param, "nueva");
        $data["categorias_publicas_venta"] = $this->get_categorias_por_tipo(1);
        $data["categorias_temas_de_ayuda"] = $this->get_categorias_por_tipo(5);
        $data["lista_categorias"] = $this->get_categorias_tipo(1);


        $id_faq = prm_def($param, "faq");
        $data["flag_busqueda_q"] = ($id_faq > 0);
        $f = 0;

        if ($id_faq > 0) {

            $data["respuesta"] = $this->get_faq($id_faq);
            $f++;
        }

        if ($categoria > 0) {

            $data["faqs_categoria"] = $this->get_faqs_categoria($categoria, $data);
            $f++;
        }


        $data["flag_busqueda_personalidaza"] = ($faqs > 0);

        if ($faqs > 0) {

            $data["faqs_categoria"] = $this->search_faqs($faqs);
            $f++;

        }
        if ($f < 1) {


            $data["faqs_categoria"] = $this->append_imgs(
                $this->recientes($param));

        }

        $data["param"] = $this->input->get();

        $data = $this->app->cssJs($data, "faq");
        $this->app->pagina($data, render($data), 1);

    }

    private function recientes($q)
    {


        return $this->app->api("fq/index/");

    }

    private function get_categorias_por_tipo($tipo)
    {

        $q["tipo"] = $tipo;
        return $this->app->api("categoria/categorias_por_tipo/", $q);


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
        return $this->append_imgs($this->app->api("fq/qsearch/", $q));


    }

    private function append_imgs($data)
    {

        $response = [];
        if (es_data($data)) {

            $a = 0;
            foreach ($data as $row) {

                $response[$a] = $row;
                $id_faq = $row["id_faq"];
                $img_faq = $this->get_img_faq($id_faq);

                $path = "";
                if (es_data($img_faq)) {

                    $path = path_enid("img_faq", $img_faq[0]["nombre_imagen"]);
                }

                $response[$a]["url_img"] = $path;
                $a++;
            }
        }

        return $response;

    }

    private function get_img_faq($id_faq)
    {

        $q["id_faq"] = $id_faq;
        return $this->app->api("imagen_faq/img/", $q);

    }

    private function get_categorias_tipo($tipo = 1)
    {

        $q["tipo"] = $tipo;
        return $this->app->api("categoria/categorias_por_tipo/", $q);
    }

    private function get_faq($faq)
    {

        if ($faq > 0) {
            $q["id"] = $faq;
            return $this->app->api("fq/id/", $q);
        }
    }

    private function search_faqs($q)
    {
        $param["q"] = $q;
        return $this->app->api("fq/search/", $param);
    }

}
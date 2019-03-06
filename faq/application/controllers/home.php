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
		$session = $data["in_session"];

		$param = ($this->input->get() !== false) ? $this->input->get() : array();
		$faq = (array_key_exists("faq", $param)) ? $param["faq"] : "";
		$faqs = (array_key_exists("faqs", $param)) ? $param["faqs"] : "";
		$categoria = (array_key_exists("categoria", $param)) ? $param["categoria"] : "";


		$data["categorias_publicas_venta"] = $this->get_categorias_por_tipo(1);
		$data["categorias_temas_de_ayuda"] = $this->get_categorias_por_tipo(5);
		$data["perfil"] = $this->principal->getperfiles();

		$flag_busqueda_q = get_info_serviciosq($faq);
		$data["flag_busqueda_q"] = $flag_busqueda_q;
		$data["lista_categorias"] = $this->get_categorias_tipo(1);



		if ($flag_busqueda_q == 1) {
			$data["respuesta"] = $this->get_faq($faq, $session);
		}


		$flag_categoria = get_info_categoria($categoria);
		$data["flag_categoria"] = $flag_categoria;

		if ($flag_categoria == 1) {

			$id_categoria = $categoria;
			$resumen_respuestas = $this->get_faqs_categoria($id_categoria, $data);
			$data["faqs_categoria"] = $resumen_respuestas;
			//$info_categoria = $this->get_info_categoria($id_categoria);

		}
		$flag_busqueda_personalidaza = get_info_serviciosq($faqs);
		$data["flag_busqueda_personalidaza"] = $flag_busqueda_personalidaza;


		if ($flag_busqueda_personalidaza == 1) {


			$resumen_respuestas = $this->search_faqs($faqs);
			$data["flag_categoria"] = 1;
			$data["faqs_categoria"] = $resumen_respuestas;

		}
		$clasificaciones_departamentos = $this->principal->get_departamentos();
		$data["clasificaciones_departamentos"] = $clasificaciones_departamentos;
		$data = $this->getCssJs($data);
		$this->principal->show_data_page($data, 'home');
	}

	private function get_categorias_por_tipo($tipo)
	{

		$q["tipo"] = $tipo;
		$api = "categoria/categorias_por_tipo/format/json/";
		$response = $this->principal->api($api, $q);

		return $response;
	}

	function get_faqs_categoria($id_categoria, $data)
	{

		$in_session = $data["in_session"];
		$extra = " AND status IN(1, 2, 3) ";
		if ($in_session == 1) {
			$id_perfil = $data["perfil"];
			$extra = ($id_perfil == 20) ? " AND status IN(1, 3) " : "";
		}

		$q["id_categoria"] = $id_categoria;
		$q["extra"] = $extra;

		$api = "faqs/qsearch/format/json/";
		$response = $this->principal->api($api, $q);
		return $response;

	}

	private function get_categorias_tipo($tipo = 1)
	{

		$q["tipo"] = $tipo;
		$api = "categoria/categorias_por_tipo/format/json/";
		return $this->principal->api($api, $q);
	}

	function get_faq($faq, $session)
	{

		$q["id"] = $faq;
		$api = "faqs/id/format/json/";
		$response = $this->principal->api($api, $q);
		return $response;

	}

	private function get_info_categoria($id)
	{

		$param["id"] = $id;
		$api = "categoria/id/format/json/";
		$response = $this->principal->api($api, $param);
		return $response[0];
	}

	private function search_faqs($q)
	{
		$param["q"] = $q;
		$api = "faqs/search/format/json/";
		return $this->principal->api($api, $param);
	}

	private function getCssJs($data)
	{
		$data["js"] = ["js/summernote.js", "faq/principal.js"];
		$data["css"] = ["faqs.css", "faqs_second.css"];
		$data["css_external"] = ["http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css"];
		return $data;
	}
}
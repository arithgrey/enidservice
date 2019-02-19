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
		$param = $this->input->get();
		$faq = $param["faq"];
		$faqs = $param["faqs"];
		$categoria = $param["categoria"];


		$data["categorias_publicas_venta"] = $this->get_categorias_por_tipo(1);
		$data["categorias_temas_de_ayuda"] = $this->get_categorias_por_tipo(5);
		$data["categorias_programa_de_afiliados"] = $this->get_categorias_por_tipo(6);
		$data["perfil"] = $this->principal->getperfiles();

		$flag_busqueda_q = get_info_serviciosq($faq);
		$data["flag_busqueda_q"] = $flag_busqueda_q;
		//$data["lista_categorias"]    =  $this->get_categorias_by_status(1);        


		$data["meta_keywords"] = " Preguntas frecuentes, Enid Service";
		$data["desc_web"] = " Preguntas frecuentes, Enid Service";
		$data["url_img_post"] = create_url_preview("faq.png");

		/*CUANDO SE SOLICITA LA RESPUESTA ALGÚN FAQ POR ID*/
		if ($flag_busqueda_q == 1) {

			$respuesta = $this->principal->get_faq($faq, $session);
			$data["respuesta"] = $respuesta;
			$info_respuesta = $respuesta[0];


			$id_faq = $info_respuesta["id_faq"];
			$id_categoria = $info_respuesta["id_categoria"];
			$titulo = $info_respuesta["titulo"];

			$data["meta_keywords"] = $titulo;
			$data["desc_web"] = $titulo;
			$data["url_img_post"] =
				"http://enidservice.com/inicio/imgs/index.php/enid/img_faq/" . $id_faq . "/";
			$resp_sim_faq = $this->principal->get_respuestas_similares($id_faq, $id_categoria);
			$data["r_sim"] = $resp_sim_faq;

		}


		$flag_categoria = get_info_categoria($categoria);
		$data["flag_categoria"] = $flag_categoria;
		/*Cuando la personas ve las respuestas por categorías*/
		if ($flag_categoria == 1) {

			$id_categoria = $categoria;
			$resumen_respuestas = $this->get_faqs_categoria($id_categoria, $data);
			$data["faqs_categoria"] = $resumen_respuestas;
			$info_categoria = $this->get_info_categoria($id_categoria);
			$data["meta_keywords"] = " Preguntas frecuentes, " . $info_categoria["nombre_categoria"] . ", ";
			$data["desc_web"] = " Preguntas frecuentes, " . $info_categoria["nombre_categoria"];
			$data["url_img_post"] = create_url_preview("faq.png");

		}
		$flag_busqueda_personalidaza = get_info_serviciosq($faqs);
		$data["flag_busqueda_personalidaza"] = $flag_busqueda_personalidaza;

		/*CUANDO LA PERSONA REALIZA BÚSQUEDA DE FORMA PERSONALIZADA*/
		if ($flag_busqueda_personalidaza == 1) {

			$resumen_respuestas =
				$this->search_faqs($faqs);


			$data["flag_categoria"] = 1;
			$data["faqs_categoria"] = $resumen_respuestas;

		}
		$clasificaciones_departamentos = $this->principal->get_departamentos("nosotros");
		$data["clasificaciones_departamentos"] = $clasificaciones_departamentos;
		$data = $this->getCssJs($data);
		$this->principal->show_data_page($data, 'home');
	}

	function get_faqs_categoria($id_categoria, $data)
	{

		$in_session = $data["in_session"];
		$extra = " AND status IN(1, 2, 3) ";
		if ($in_session == 1) {
			$id_perfil = $data["perfil"][0]["idperfil"];
			$extra = ($id_perfil == 20) ? " AND status IN(1, 3) " : "";
		}

		$q["id_categoria"] = $id_categoria;
		$q["extra"] = $extra;

		$api = "faqs/qsearch/format/json/";
		$response = $this->principal->api($api, $q);
		return $response;

	}

	private function getCssJs($data)
	{
		$data["js"] = ["faq/principal.js"];
		$data["css"] = ["faqs.css", "faqs_second.css"];
		$data["css_external"] = ["http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css"];
		return $data;
	}

	private function get_categorias_por_tipo($tipo)
	{

		$q["tipo"] = $tipo;
		$api = "categoria/categorias_por_tipo/format/json/";
		$response = $this->principal->api($api, $q);
		debug($response, 1);

		return $response;
	}

	private function get_categorias_by_status($status = 1)
	{

		$q["tipo"] = 1;
		$api = "empresa/q/format/json/";
		return $this->principal->api($api, $q);
	}

	private function search_faqs($q)
	{
		$param["q"] = $q;
		$api = "faqs/search/format/json/";
		return $this->principal->api($api, $param);
	}

	private function get_info_categoria($id)
	{

		$param["id"] = $id;
		$api = "categoria/id/format/json/";
		$response = $this->principal->api($api, $param);
		return $response[0];
	}
}
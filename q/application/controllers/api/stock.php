<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Stock extends REST_Controller
{
	public $option;
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->helper("stock");
		$this->load->library("table");
		$this->load->library(lib_def());
	}

	function compras_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "fecha_inicio,tipo")) {

			$pedidos_contra_entrega = $this->get_solicitudes_contra_entrega($param);
			$pedidos_servicio = crea_resumen_servicios_solicitados($pedidos_contra_entrega);
			$pedidos_servicio = $this->agrega_stock_servicios($pedidos_servicio);
			$response = $this->asocia_servicio_solicitudes($pedidos_servicio, $param["tipo"]);
			$compras_por_enviar = $this->get_compras_por_enviar();

			if (get_param_def($param, "v") > 0) {

				$response = $this->create_table_compras($response, $compras_por_enviar);

			}
		}
		$this->response($response);
	}

	private function create_table_compras($servicios, $compras_por_enviar)
	{

		$this->table->set_heading('#',
            'SERVICIO',
            'STOCK ACTUAL',
            "PEDIDOS CONTRA ENTREGA",
            "CASOS IDENTICO",
            "PRONOSTICO  VENTAS (A)",
            "PRONOSTICO VENTAS (B)",
            "ADQUIRIDAS ENID",
            "OTRAS PLATAFORMAS",
            "COMPRAR OPCIÓN (A)",
            "COMPRAR OPCIÓN (B)"
        );
		$b = 1;
		for ($a = 0; $a < count($servicios); $a++) {

			$id_servicio = $servicios[$a]["id_servicio"];
			$stock = $servicios[$a]["stock"];
			$url_imagen = link_imagen_servicio($id_servicio);
			$pedidos_contra_entrega = $servicios[$a]["pedidos_contra_entrega"];

			$total_pedidos_contra_entrega = $servicios[$a]["total_pedidos_contra_entrega"];
			$total_entregas_contra_entrega = $servicios[$a]["total_entregas_contra_entrega"];
			$pedidos = $servicios[$a]["pedidos"];
			$resumen = $this->get_format_resumen($total_pedidos_contra_entrega . "/" . $total_entregas_contra_entrega, $pedidos, $pedidos_contra_entrega);
			$sugerencia = $resumen["sugerencia"];
			$sugerencia_b = $resumen["sugerencias_b"];
			$img = img([
				"class" => "img-responsive img_servicio_compras",
				"src" => $url_imagen,
			]);

			$img = anchor_enid($img, ["href" => get_url_servicio($id_servicio)]);
			$total_enid = $this->get_ventas_tipo(1, $compras_por_enviar, $id_servicio);
			$total_otras = $this->get_ventas_tipo(2, $compras_por_enviar, $id_servicio);
			$total_compras = ($sugerencia + $total_enid + $total_otras) - $stock;
			$total_compras_b = ($sugerencia_b + $total_enid + $total_otras) - $stock;

			$this->table->add_row($b, $img, $stock, $pedidos_contra_entrega, $resumen["text"], $sugerencia, $sugerencia_b, $total_enid, $total_otras, $total_compras, $total_compras_b);
			$b++;
		}


        $this->table->set_template(template_table_enid());
		return $this->table->generate();

	}

	private function get_ventas_tipo($tipo, $compras_pagas, $id_servicio)
	{

		$compras = 0;
		foreach ($compras_pagas as $row) {
			if ($tipo == 1) {
				if (($row["tipo_entrega"] == 1 || $row["tipo_entrega"] == 2 || $row["tipo_entrega"] == 3) && $row["id_servicio"] == $id_servicio) {
					$compras = $compras + $row["ventas_pagas_sin_envio"];
				}
			} else {
				if ($row["tipo_entrega"] == 4 && $row["id_servicio"] == $id_servicio) {
					$compras = $compras + $row["ventas_pagas_sin_envio"];
				}
			}
		}
		return $compras;
	}

	private function get_ventas_fecha($fecha, $ventas)
	{

		$venta = 0;
		for ($a = 0; $a < count($ventas); $a++) {


			if ($fecha == $ventas[$a]["fecha_entrega"]) {

				$venta = $ventas[$a]["solicitudes"];

			}
		}
		return $venta;

	}

	private function get_format_resumen($resumen, $pedidos, $pedidos_contra_entrega)
	{

		//$resumen        =  anchor_enid($resumen , ["class"    =>  "dropdown-toggle" , "href"=>"#",  "id"=>"dropdownMenuLink"]);
		$solicitudes = $pedidos["solicitudes"];
		$entregas = $pedidos["entregas"];

		$table = "<table  border='1' class='text-center' >";
		$table .= "<tr>";
		$table .= get_td("FECHA");
		$table .= get_td("SOLICITUDES");
		$table .= get_td("VENTAS");
		$table .= "</tr>";

		$promedio = [];
		$relevante = [];
		$secundaria = [];
		$media = [];

		for ($a = 0; $a < count($solicitudes); $a++) {


			$fecha_contra_entrega = $solicitudes[$a]["fecha_contra_entrega"];
			$solicitud = $solicitudes[$a]["solicitudes"];

			$class = ($pedidos_contra_entrega == $solicitud) ? "caso_exacto" : "";
			$t = "<tr class='" . $class . "'>";
			$t .= get_td($fecha_contra_entrega);
			$ventas_efectivas = $this->get_ventas_fecha($fecha_contra_entrega, $entregas);
			$t .= get_td($solicitud);
			$t .= get_td($ventas_efectivas);

			$t .= "</tr>";

			if ($pedidos_contra_entrega == $solicitud) {

				$relevante[] = $t;
				$promedio [] = ["solicitud" => $solicitud, "ventas_efectivas" => $ventas_efectivas];

				if (!array_key_exists($ventas_efectivas, $media)) {
					$media[$ventas_efectivas] = 1;
				} else {
					$media[$ventas_efectivas] = $media[$ventas_efectivas] + 1;
				}

			} else {
				if (!array_key_exists($ventas_efectivas, $secundaria)) {
					$secundaria[$ventas_efectivas] = 1;
				} else {
					$secundaria[$ventas_efectivas] = $secundaria[$ventas_efectivas] + 1;
				}
			}
		}


		for ($a = 0; $a < count($relevante); $a++) {
			$table .= $relevante[$a];
		}

		$table .= "</table>";
		$tabla_porcentaje = $this->get_tabla_porcentajes($media, $pedidos_contra_entrega, count($relevante));

		$totales_casos = $this->get_max_min($tabla_porcentaje["totales"]);
		$completo = $totales_casos["completo"];
		asort($completo);
		$min = (count($completo) > 0) ? $completo[0] : 0;
		$max = $totales_casos["max"];
		$text_resumen = count($relevante);
		$text = div($text_resumen . div($table . $tabla_porcentaje["table"], ["class" => "dropdown-menu"]), ["class" => "dropdown"]);
		$response = ["text" => $text, "promedios" => $promedio, "media" => $media, "sugerencia" => $max, "sugerencias_b" => $min];

		return $response;
	}

	private function get_max_min($totales)
	{


		$max = 0;
		$min = array();

		foreach ($totales as $row) {
			if ($row["compras"] > $max) {
				$max = $row["compras"];
			}
			array_push($min, $row["compras"]);

		}
		$response = ["max" => $max, "completo" => $min];
		return $response;
	}

	private function get_tabla_porcentajes($media, $pedidos_contra_entrega, $total)
	{

		$table = "<table border='1' class='text-center'>";

		$table .= "<tr>";
		$table .= get_td("SOLICITUDES " . $pedidos_contra_entrega, ["colspan" => 3]);
		$table .= "</tr>";

		$table .= "<tr>";
		$table .= get_td("CASOS");
		$table .= get_td("PORCENTAJE");
		$table .= get_td("COMPRAS");
		$table .= "</tr>";

		$totales = [];
		$z = 0;
		foreach ($media as $key => $value) {
			$totales[$z] = ["casos" => $value, "compras" => $key];
			$table .= "<tr>";
			$table .= get_td($value);
			$table .= get_td(porcentaje_total($value, $total) . "%");
			$table .= get_td($key);
			$table .= "</tr>";
			$z++;
		}
		$table .= "</table>";
		//$r =  $totales;
		$response = ["table" => $table, "totales" => $totales];
		return $response;
	}

	private function get_comparativa_solicitudes($solicitudes, $entregas_efectivas, $pedidos_contra_entrega)
	{

	}

	private function asocia_servicio_solicitudes($pedidos_servicio, $tipo)
	{
		$response = [];
		foreach ($pedidos_servicio as $row) {

			$id_servicio = $row["id_servicio"];
			$pedidos = $this->get_solicitudes_servicio_pasado($id_servicio, $tipo);
			$total_pedidos = count($pedidos["solicitudes"]);
			$total_entregas = count($pedidos["entregas"]);

			$response[] = [
				"id_servicio" => $id_servicio,
				"pedidos_contra_entrega" => $row["pedidos"],
				"stock" => $row["stock"],
				"total_pedidos_contra_entrega" => $total_pedidos,
				"total_entregas_contra_entrega" => $total_entregas,
				"pedidos" => $pedidos
			];
		}
		return $response;
	}

	private function agrega_stock_servicios($servicios)
	{

		$response = [];
		for ($a = 0; $a < count($servicios); $a++) {

			$id_servicio = $servicios[$a]["id_servicio"];
			$response[] = [
				"id_servicio" => $id_servicio,
				"pedidos" => $servicios[$a]["pedidos"],
				"stock" => $this->get_stock_servicio($id_servicio)
			];
		}
		return $response;
	}

	private function get_stock_servicio($id_servicio)
	{
		$q["id_servicio"] = $id_servicio;
		$api = "servicio/stock/format/json/";
		return $this->app->api($api, $q);
	}

	private function get_solicitudes_servicio_pasado($id_servicio, $tipo = 1)
	{
		$q["id_servicio"] = $id_servicio;
		$q["tipo"] = $tipo;
		$api = "recibo/solicitudes_periodo_servicio/format/json/";
		return $this->app->api($api, $q);
	}

	private function get_solicitudes_contra_entrega($param)
	{


		$q["cliente"] = "";
		$q["recibo"] = "";
		$q["v"] = 0;
		$q["tipo_entrega"] = 0;
		$q["status_venta"] = 6;
		$q["tipo_orden"] = 5;
		$q["fecha_inicio"] = $param["fecha_inicio"];
		$q["fecha_termino"] = $param["fecha_inicio"];

		$api = "recibo/pedidos/format/json/";
		return $this->app->api($api, $q);

	}

	private function get_compras_por_enviar()
	{

		$q[1] = 1;
		$api = "recibo/compras_por_enviar/format/json/";
		return $this->app->api($api, $q);

	}
}
<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';
require FCPATH . 'vendor/autoload.php';

class cobranza_test extends REST_Controller
{
    private $faker;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->faker = Faker\Factory::create();
    }

    function primer_orden_GET()
    {

        $param = $this->get();
        $total = prm_def($param, "total", 1);

        $response = [];
        $faker_user = [];    

        for ($a = 0; $a < $total; $a++) {

            $start_date = 'now ';
            $end_date = '+1 year';
            $date = $this->faker->dateTimeBetween($start_date, $end_date);
            $input_fecha_contra_entrega = $date->format('Y-m-d');

            $start_date = '-1 year ';
            $end_date = 'now';
            $date = $this->faker->dateTimeBetween($start_date, $end_date);
            $fecha_servicio = $date->format('Y-m-d');
            $name = $this->faker->name();
            $faker_user  = [
                "password" =>  sha1($this->faker->password()),
                "nombre" => $name,
                "email" => $this->faker->email(),
                "facebook" => "https://enidservices.com/kits-pesas-barras-discos-mancuernas-fit",
                "telefono" => str_replace('-', '', $this->faker->phoneNumber),
                "id_servicio" => 1156,
                "ciclo_facturacion" => 0,
                "usuario_referencia" => 1,
                "talla" => 0,
                "tipo_entrega" => 2,
                "fecha_contra_entrega" => $input_fecha_contra_entrega,
                "fecha_servicio" => $fecha_servicio,
                "es_cliente" => 1,
                "es_carro_compras" => 1,
                "producto_carro_compra" => [1156],
                "recompensas" => [],
                "es_prospecto" => 0,
                "url_facebook_conversacion" => "https://enidservices.com/kits-pesas-barras-discos-mancuernas-fit/se",
                "comentario_compra" => _text_("nueva compra de:", $name),
                "lead_ubicacion" => 0,
                "lead_catalogo" => 0,
                "numero_cliente" => 0,
            ];

            $response[] = $this->app->api(
                "cobranza/primer_orden",
                $faker_user,
                "json",
                "POST"
            );

        }

        $this->response($response);
    }
}

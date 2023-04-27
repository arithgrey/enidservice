<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

use Enid\WhatsApp\WhatsAppAPI;
class blaster extends REST_Controller
{
    private $whatsAppAPI;
    function __construct()
    {
        parent::__construct();
        $this->load->model("recibo_model");
        $this->load->library(lib_def());
        $configWhatsApp= $this->config->item('whatsApp');
        $this->whatsAppAPI = new whatsAppAPI($configWhatsApp);

    }
    function recibos_sin_ficha_seguimiento_GET()
    {
        /*
        $recibos =  $this->recibo_model->recibos_pagos_mayores_a_30_dias_sin_ficha_seguimiento();
        $ids_usuarios = array_unique(array_column($recibos, 'id_usuario'));

        $usuarios  = $this->app->api("usuario/ids", ["ids" => $ids_usuarios]);

        $numeros_telefonicos = array_unique(array_column($usuarios, "tel_contacto"));
        $telefonos = $this->filtro_telefonico($numeros_telefonicos);
        */

        $this->response($this->whatsAppAPI->sendMessageTest());
    }
    function filtro_telefonico($numeros_telefonicos)
    {
        $response = [];
        foreach ($numeros_telefonicos as $numero) {
            if ( strlen($numero) == 10 || strlen($numero) == 12 || strlen($numero) == 13) {
                $response[] = $numero;
            }
        }

        return $response;
    }
}

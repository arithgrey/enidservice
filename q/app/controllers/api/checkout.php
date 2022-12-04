<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Checkout extends REST_Controller
{
    public $option;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
    }
    function deuda_orden_compra($id_orden_compra)
    {

        $q["id_orden_compra"] = $id_orden_compra;
        return $this->app->api("recibo/deuda_orden_compra/", $q);
    }
    private function log_intento_pago($id_intento_pago, $id_orden_compra)
    {
        
        $q = [            
            "id_intento_pago" => $id_intento_pago,
            "id_orden_compra" => $id_orden_compra,
        ];
        return $this->app->api("pago_orden_compra/index", $q, "json", "POST");
    }

    function index_POST()
    {

        $secred_api_key_pay = $this->config->item('secred_api_key_pay');
        \Stripe\Stripe::setApiKey($secred_api_key_pay);
        
        header('Content-Type: application/json');
        $output = [];
        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);
            $id_orden_compra = $jsonObj->items[0]->orden_compra;            
            $deuda = $this->deuda_orden_compra($id_orden_compra);

            if (es_data($deuda)) {
                // Create a PaymentIntent with amount and currency
                $subtotal = $deuda["saldo_pendiente_pago_contra_entrega"];
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $subtotal,
                    'currency' => 'mxn',
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                    'metadata' =>
                    [
                        'order_id' => $id_orden_compra
                    ],
                ]);

                $output = [
                    'clientSecret' => $paymentIntent->client_secret
                ];
                
                $this->log_intento_pago($paymentIntent->id, $id_orden_compra);

            } else {
                http_response_code(500);
                $this->response(['error' => "Ups! no encontramos tu orden de compra, intenta de nuevo refrescando la página!"]);
            }
            $this->response($output);
        } catch (Error $e) {
            http_response_code(500);
            $this->response(['error' => $e->getMessage()]);
        }
    }
}

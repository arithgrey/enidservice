<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Stock extends REST_Controller{
    public $option;
    private $id_usuario;
    function __construct(){
        parent::__construct();
        $this->load->helper("stock");
        $this->load->library(lib_def());
    }
    function compras_GET(){

        $param      =   $this->get();
        $response   =   false;
        if(if_ext($param , "fecha_inicio")){

            $pedidos_contra_entrega     =   $this->get_solicitudes_contra_entrega($param);
            $pedidos_servicio           =   crea_resumen_servicios_solicitados($pedidos_contra_entrega);
            $response                   =   $this->asocia_servicio_solicitudes($pedidos_servicio);
        }
        $this->response($response);
    }
    private function asocia_servicio_solicitudes($pedidos_servicio){
        $response   =   [];
        foreach($pedidos_servicio  as $row){

            $id_servicio =  $row["id_servicio"];
            $solicitudes =  $this->get_solicitudes_servicio_pasado($id_servicio);
            $response[]     = [
                "id_servicio" => $id_servicio ,
                "pedidos"     => $row["pedidos"],
                "solicitudes" => $solicitudes
            ];

        }
        return $response;
    }
    private function get_solicitudes_servicio_pasado($id_servicio){
        $q["id_servicio"]           = $id_servicio;
        $api                        = "recibo/solicitudes_periodo_servicio/format/json/";
        return  $this->principal->api( $api , $q);

    }
    private function get_solicitudes_contra_entrega($param){


        $q["cliente"]               =   "";
        $q["recibo"]                =   "";
        $q["v"]                     =   0;
        $q["tipo_entrega"]          =   0;
        $q["status_venta"]          =   6;
        $q["tipo_orden"]            =   5;
        $q["fecha_inicio"]          =   $param["fecha_inicio"];
        $q["fecha_termino"]         =   $param["fecha_inicio"];

        $api                        = "recibo/pedidos/format/json/";
        return  $this->principal->api( $api , $q);

    }
}
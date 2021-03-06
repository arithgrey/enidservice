<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('transferencia');
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {

        $data = $this->app->session("Enid Service");
        $data["clasificaciones_departamentos"] = "";
        $data = $this->app->cssJs($data, "movimientos");

        $param = $this->input->get();
        if ($data["in_session"] == 1) {

            $action = prm_def($param, "action");
            $id_usuario = $data["id_usuario"];
            switch ($action) {
                case 0:
                    $this->general($data,  $id_usuario);
                    break;

                case 1:

                    $this->cuentas_usuario($data, $param, $id_usuario);
                    break;
                case 2:

                    $this->metodos_transferencia($data, $param, $id_usuario);
                    break;

                case 3:

                    $this->cuentas_asociadas($data, $id_usuario);
                    break;

                case 4:

                    $this->crea_cuenta($id_usuario);
                    break;

                case 6:

                    $this->app->pagina($data, render_agregar_saldo_cuenta(),1);

                    break;
                case 7:

                    $this->app->pagina($data , render_agregar_saldo_oxoo($data) , 1);
                    break;

                case 8:

                    $this->saldo_oxxo($data, $id_usuario);
                    break;
                case 9:
                    $this->saldo_amigo($data);
                    break;

                default:

                    break;
            }

        } else {
            redirect("../");
        }

    }

    private function saldo_amigo($data)
    {


        $this->app->pagina($this->app->cssJs($data, "movimientos_saldo_amigo"), 'solicitar_a_un_amigo');

    }

    private function saldo_oxxo($data, $id_usuario)
    {

        $param = $this->input->get();
        $data["saldo_disponible"] = $this->get_saldo_usuario($id_usuario);
        $q  = [
            "id_usuario" => $id_usuario,
            "id_usuario_venta" => $param["operacion"],
            "id_recibo" => $param["recibo"],
        ];

        $data["recibo"] = $this->get_recibo_por_pagar($q);

        if (search_bi_array($data,"recibo","cuenta_correcta","cuenta_correcta" ,0 ) >  0  ) {

            $this->app->pagina($data, 'pagar_con_saldo_enid');

        } else {

            redirect(path_enid("home"));

        }
    }
    private function crea_cuenta($id_usuario)
    {

        if ($this->input->post()) {

            $prm = $this->input->post();
            $prm["id_usuario"] = $id_usuario;
            $registro = $this->agregar_cuenta_bancaria($prm);
            $base_transfer = "../../movimientos/?q=transfer";
            $ext =  ($prm["tipo"] == 0) ?  "&action=1&error=1" : "&action=1&tarjeta=1&error=1";
            $fn =  ($registro["registro_cuenta"] > 1) ? redirect($base_transfer . "&action=3") : redirect($base_transfer . $ext);



        } else {

            redirect("../../movimientos");
        }

    }

    private function cuentas_asociadas($data, $id_usuario)
    {

        $data +=  [
            "cuentas_bancarias" => $this->get_cuentas_usuario($id_usuario, 0),
            "tarjetas" => $this->get_cuentas_usuario($id_usuario, 1),
            "css" => ["cuentas_asociadas.css"]
        ];

        $this->app->pagina($data, render_cuentas_asociadas($data) , 1 );
    }

    private function metodos_transferencia($data, $param, $id_usuario)
    {


        $data["saldo_disponible"] = $this->get_saldo_usuario($id_usuario);
        $cuentas_bancarias = $this->get_cuentas_usuario($id_usuario, 0);
        $data["cuentas_gravadas"] = 0;

        if (es_data($cuentas_bancarias) ) {

            $data["cuentas_gravadas"] = 1;
            $data["cuentas_bancarias"] = $cuentas_bancarias;

        }
        $this->app->pagina($data, 'metodos_transferencia');

    }

    private function cuentas_usuario($data, $param, $id_usuario)
    {

        $prm["id_usuario"] = $id_usuario;
        $data["bancos"] = $this->get_bancos_disponibles($prm);
        $data["usuario"] = $this->app->usuario($id_usuario);
        $data["banca"] = prm_def($param, "tarjeta");
        $prm = $this->input->get();
        $data["error"] =  (prm_def($prm, "error") > 0) ?  1 : 0;
        $data["seleccion"] = prm_def($param, "seleccion");
        $this->app->pagina($data, render_metodos_disponibles($data) ,1 );

    }

    private function general($data, $id_usuario)
    {

        $data["saldo_disponible"] = $this->get_saldo_usuario($id_usuario);
        $data = $this->app->cssJs($data, "movimientos_general");
        $this->app->pagina($data, render_empresas($data),1);

    }

    private function get_saldo_usuario($id_usuario)
    {

        return $this->app->api("recibo/saldo", ["id_usuario" => $id_usuario] , "json", "POST");
    }

    private function get_cuentas_usuario($id_usuario, $tipo)
    {

        $q  = [
            "id_usuario" =>  $id_usuario,
            "tipo" => $tipo,
            "metodos_disponibles" => 1
        ];

        return $this->app->api("cuentas/usuario", $q, "json", "POST");
    }

    private function get_bancos_disponibles($q)
    {

        return $this->app->api("banco/index/format/json/", $q);
    }

    private function get_recibo_por_pagar($q)
    {

        return $this->app->api("cobranza/recibo_por_pagar/format/json/", $q);

    }

    private function agregar_cuenta_bancaria($q)
    {

        return $this->app->api("cuentas/bancaria", $q, "json", "POST");
    }
}
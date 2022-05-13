<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Colonia extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("colonia_model");
        $this->load->library(lib_def());
    }

    function delegacion_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "delegacion")) {

            $response = $this->colonia_model->delegacion($param["delegacion"]);

            if (es_data($response) && prm_def($param, 'auto')) {
                $select = create_select(
                    $response,
                    "cp",
                    "colonia",
                    'colonia_ubicacion',
                    "colonia",
                    'id_codigo_postal',
                    0,
                    1,
                    '0',
                    '-'
                );

                $texto_colonia = d("¿Colonia?", 'strong');
                $selector[] = flex($texto_colonia, $select, _between);

                $sin_colonia = _text_(
                    span('aquí', ['class' => 'sin_colonia f11 red_enid cursor_pointer']),
                    icon(_text_(_eliminar_icon, 'sin_colonia red_enid'))
                );
                $texto = _text_("Dá click", $sin_colonia, "si no cuentas con este dato");
                $selector[] = d($texto, 'mt-3');

                $response  = append($selector);
            }
        }
        $this->response($response);
    }
}

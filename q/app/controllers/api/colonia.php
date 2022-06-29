<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Colonia extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("colonia_model");
        $this->load->library('table');
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
    function delegacion_cotizador_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "delegacion")) {

            $response = $this->colonia_model->delegacion($param["delegacion"]);
            
            if (es_data($response) && prm_def($param, 'auto')) {

                $es_administrador = prm_def($param,"edicion");

                $heading = [
                    "Costo de entrega",                    
                    "Colonia",                    
                ];
                
                if($es_administrador > 0 ){
                    $heading = array_merge($heading, [""]);
                }

                $this->table->set_template(template_table_enid());
                $this->table->set_heading($heading);


                foreach($response  as $row){

                    $id_codigo_postal = $row["id_codigo_postal"];
                    $costo = $row["costo_entrega"];
                    $colonia = $row["colonia"];
                    
                    $row = [
                        money($costo),
                        $colonia 
                    ];
                    
                    if($es_administrador > 0 ){
                        
                        $icono = icon(
                            _text_(_editar_icon, "costo_entrega_colonia") ,
                            [
                                "id" => $id_codigo_postal,
                                "costo" => $costo,
                                "colonia" => $colonia
                            ]
                        );
                        $row = array_merge($row, [$icono]);

                    }

                    
                    $this->table->add_row($row);
                
                    
                }
                            
                $selector[] = $this->table->generate();            
                $response  = append($selector);
            }
        }
        $this->response($response);
    }
    
}

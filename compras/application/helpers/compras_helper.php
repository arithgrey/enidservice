<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_form_entrega')) {

        function get_form_entrega()
        {
            return  get_btw(

                        div("FECHA DE ENTREGA", ["class" => 'strong']),

						input([
							"data-date-format" => "yyyy-mm-dd",
							"name" => 'fecha_inicio',
							"class" => "form-control input-sm datetimepicker4",
							"id" => 'datetimepicker4',
							"value" => date("Y-m-d")
						]),
                    6
					);

        }
    }
}


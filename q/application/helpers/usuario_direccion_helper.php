<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {



    function get_format_domicilio($info_envio_direccion){

        $r[] =  get_campo($info_envio_direccion, "direccion", "Dirección", 1) ;
        $r[] =  get_campo($info_envio_direccion, "calle", "Calle", 1) ;
        $r[] =  get_campo($info_envio_direccion, "numero_exterior", " Número exterior ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "numero_interior", " Número interior ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "entre_calles", "Entre ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "cp", " C.P. ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "asentamiento", " Colonia ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "municipio", " Delegación/Municipio ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "ciudad", " Ciudad ", 1) ;
        $r[] =  get_campo($info_envio_direccion, "estado", " Estado ", 1) ;


    }
    /**/
	function val_btn_pago($param, $id_proyecto_persona_forma_pago)
	{

		$btn = anchor_enid("Liquida ahora!",
			[
				'class' => 'resumen_pagos_pendientes ',
				'id' => $id_proyecto_persona_forma_pago,
				'href' => '#tab_renovar_servicio',
				'data-toggle' => 'tab'
			]);


		if (get_info_usuario_valor_variable($param, "externo") == 1) {

			$url = "../forma_pago/?recibo=" . $id_proyecto_persona_forma_pago;
			//$extra = "";
			$f_btn = anchor_enid("LIQUIDAR AHORA!",
				[
					'class' => 'resumen_pagos_pendientes top_20',
					'id' => $id_proyecto_persona_forma_pago,
					'href' => $url
				], 1, 1);

			$s_btn = anchor_enid("ACCEDE A TU CUENTA PARA VER EL ESTADO DE TU PEDIDO",
				[
					'class' => 'resumen_pagos_pendientes black top_20',
					'id' => $id_proyecto_persona_forma_pago,
					'href' => '../area_cliente/?action=compras'
				]);


			$contenido = div($f_btn);
			$contenido .= div($s_btn);
			return $contenido;
		}
		return $btn;
	}

}
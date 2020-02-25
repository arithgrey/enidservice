<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function busqueda_reparto($data)
    {

        $repartidores =  $data['repartidores'];
        $recibos = $data['recibos'];
        $r[] = form_open("",
            [
                "class" => "busqueda mt-5",
                "method" => "POST",

            ]
        );
        $r[] = flex(
            "TIPO DE ENTREGA",
            create_select(
                $data["tipos_entregas"],
                "tipo_entrega",
                "tipo_entrega form-control",
                "tipo_entrega",
                "nombre",
                "id",
                0,
                1,
                0,
                "-"
            ),
            "col-sm-6 flex-column p-0 mt-3 strong", '', 'mt-3'
        );
        $r[] = flex(
            "REPARTIDOR",
            create_select(
                $repartidores,
                "repartidor",
                "repartidor form-control",
                "repartidor",
                "nombre",
                "idusuario",
                0,
                1,
                0,
                "-"
            ),
            "col-sm-6 flex-column p-0 mt-3 strong", '', 'mt-3'
        );

        $r[] = frm_fecha_busqueda();
        $r[] = form_close();
        $z[] = append($r);

        $response[] = d(_titulo("CUENTAS PENDIENTES POR COBRAR"), ' col-sm-10 col-sm-offset-1 mt-5');
        $response[] = d($z, 10, 1);
        $response[] = d($recibos, 10, 1);
        return append($response);


    }


}

<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function busqueda_reparto($data, $param)
    {

        $repartidores = $data['repartidores'];
        $fechas[] =
            [
                "fecha" => "FECHA REGISTRO",
                "val" => 1,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA CONTRA ENTREGA",
                "val" => 5,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA ENTREGA",
                "val" => 2,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA CANCELACION",
                "val" => 3,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA PAGO",
                "val" => 4,
            ];
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
            "col-sm-4 flex-column  mt-3 strong", '', 'mt-3'
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
            "col-sm-4 flex-column  mt-3 strong", '', 'mt-3'
        );

        $busqueda_orden = create_select_selected(
            $fechas,
            'val',
            'fecha',
            5,
            'tipo_orden',
            'form-control'
        );
        $r[] = flex(
            "Ordenar",
            $busqueda_orden,
            "flex-column col-md-4  mt-3 text-uppercase strong", '', 'mt-3'
        );

        $fecha_inicio = prm_def($param,'fecha_inicio');
        $fecha_termino = prm_def($param,'fecha_termino');
        $r[] = frm_fecha_busqueda($fecha_inicio, $fecha_termino, 'col-sm-4 mt-5', 'col-sm-4 mt-5');
        $r[] = form_close();
        $z[] = append($r);

        $response[] = d(_titulo("CUENTAS PENDIENTES POR COBRAR"), ' col-sm-10 col-sm-offset-1 mt-5');
        $response[] = d($z, 10, 1);
        $response[] = d($recibos, 10, 1);
        return append($response);


    }


}

<?php

namespace Enid\BusquedaRecibo;

class Form
{

    function busqueda($param, $data, $busqueda_simple = 0 )
    {

        $response[] = form_open("", ["class" => "form_busqueda_pedidos mt-5", "method" => "post"]);
        $response = $this->hiddens($param, $data, $response);
        $response[] = $this->form_busqueda_pedidos($data, $this->fechas_busqueda(), $busqueda_simple);
        $visibilidad = (!array_keys($data,"comisionistas") ) ? 'd-none' : '';
        $response = $this->filtro_comisionistas($data, $visibilidad, $response);
        $response = $this->fecha_en_busqueda($param, $response,$busqueda_simple);
        $response[] = form_close();
        $_response[] = d($response, 12); 
        $_response[] = d(place("place_pedidos"), 12); 
        return append($_response);
    }
    function fechas_busqueda()
    {
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
        return $fechas;
    }
    
    function fecha_en_busqueda($param, $response, $busqueda_simple)
    {
        $extra = $busqueda_simple ? 'd-none':'';
        $ancho_fechas = 'col-sm-6 mt-5 p-0 p-md-1 ';
        $es_busqueda = keys_en_arreglo(
            $param,
            [
                'fecha_inicio',
                'fecha_termino',
                'type',
                'servicio'
            ]
        );


        if ($es_busqueda && es_data($param)) {

            $response[] = d(frm_fecha_busqueda(
                $param["fecha_inicio"],
                $param["fecha_termino"],
                $ancho_fechas,
                $ancho_fechas
            ),$extra);
            $response[] = hiddens(
                [
                    "name" => "consulta",
                    "class" => "consulta",
                    "value" => 1,
                ]
            );
            $response[] = hiddens(
                [
                    "name" => "servicio",
                    "class" => "servicio",
                    "value" => $param["servicio"],
                ]
            );
            $response[] = hiddens(
                [
                    "name" => "type",
                    "class" => "type",
                    "value" => $param["type"],
                ]
            );
        } else {

            $response[] = d(frm_fecha_busqueda(0, 0, $ancho_fechas, $ancho_fechas),$extra);
        }
        
        return $response;
    }
    function form_busqueda_pedidos($data, $fechas, $busqueda_simple)
    {
        $extra = $busqueda_simple ? 'd-none':'';
        $tipos_entregas = $data["tipos_entregas"];
        $status_ventas = $data["status_ventas"];
        $id_perfil = $data['id_perfil'];
        $restriciones_comisionista_busqueda = $data['restricciones']['restriccion_status_comisionista_busqueda'];
        $restricciones_administrador_busqueda = $data['restricciones']['restricciones_administrador_busqueda'];
        $restricciones = ($id_perfil == 6) ? $restriciones_comisionista_busqueda : [];
        $restricciones = (!in_array($id_perfil, [20, 6])) ? $restricciones_administrador_busqueda : $restricciones;
        $visibilidad = $this->visibilidad_input_form($data);

        $input_cliente = input_enid(            
            [
                "name" => "cliente",
                "id" => "cliente",
                "placeholder" => "Encuentra tu cliente, puedes ingresar su Nombre, correo, telefono ...",
                "class" => "input_busqueda",
                "onpaste" => "paste_telefono();"
            ]
        );


        $r[] = hiddens(["name" => "v", 'value' => 1]);

        $r[] = input_enid(            
            [
                "name" => "recibo",
                "id" => 'busqueda_recibo',
                "placeholder"=> "# de Recibo"
            ]
        );


        $r[] = d(flex(
            "Tipo de entrega",
            create_select(
                $tipos_entregas,
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
            "flex-column col-md-4 p-0 mt-3"
        ), $visibilidad);

        $r[] = d(flex(
            'Status',
            create_select(
                $status_ventas,
                "status_venta",
                "status_venta  form-control",
                "status_venta",
                "text_vendedor",
                "id_estatus_enid_service",
                0,
                1,
                0,
                "-",
                $restricciones
            ),
            "flex-column col-md-4 p-0 mt-3"
        ), $visibilidad);


        $busqueda_orden = create_select_selected(
            $fechas,
            'val',
            'fecha',
            5,
            'tipo_orden',
            'tipo_orden form-control'
        );
        $r[] = d(flex(
            "Ordenar",
            $busqueda_orden,
            "flex-column col-md-4 p-0 mt-3"
        ), $visibilidad);

        
        $form[] = d($input_cliente);
        $form[] = d($r, $extra);
        return append($form);
    }
    function visibilidad_input_form($data)
    {
        return es_cliente($data) ? 'd-none' : '';
    }
    function hiddens($param, $data, $response)
    {

        $es_busqueda_reparto = prm_def($param, 'reparto');
        $response[] = hiddens(['class' => 'usuarios', 'name' => 'usuarios', 'value' => prm_def($param, 'usuarios')]);
        $response[] = hiddens(['class' => 'ids', 'name' => 'ids', 'value' => prm_def($param, 'ids')]);
        $response[] = hiddens(['class' => 'es_busqueda_reparto', 'name' => 'es_busqueda_reparto', 'value' => $es_busqueda_reparto]);
        $response[] = hiddens(['class' => 'es_administrador', 'name' => 'es_administrador', 'value' => es_administrador($data)]);
        $response[] = hiddens(
            [
                "name" => "perfil",
                "class" => "perfil_consulta",
                "value" => $data["id_perfil"],
            ]
        );
        return $response;
    }
    private function filtro_comisionistas($data, $visibilidad, $response)
    {

        $es_busqueda_con_comisionistas = es_data(prm_def($data, 'comisionistas', []));
        if ($es_busqueda_con_comisionistas) {
            $select_comisionistas = create_select(
                $data['comisionistas'],
                'id_usuario_referencia',
                'comisionista form-control',
                'comisionista',
                'nombre_usuario',
                'id',
                0,
                1,
                0,
                '-'
            );
            $response[] = flex_md(
                'Filtrar por vendedor',
                $select_comisionistas,
                _text_('col-sm-12 mt-md-m5 mt-3 p-0', _between_md, $visibilidad),
                _text_('text-left', $visibilidad),
                _text_('text-left', $visibilidad)
            );
        }

        return $response;
    }
}

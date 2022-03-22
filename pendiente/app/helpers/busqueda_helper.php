<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {

        $response[] =  d(formato_comisiones($data) , 4);
        $response[] =  d(formato_cuenta_asociada($data) , 4);    
        $solicitud_deposito = format_link("Solicitar depósito", [ "class" => "solicitud_deposito"]);
        $response[] =  d($solicitud_deposito, 4);
        $response[] = formato_solicitud_hecha($data);
        $response[] = formato_modal_cuenta($data);

        return d($response, 8, 1);

    }    
    
    function formato_solicitud_hecha($data)
    {
        $solicitud_retiro = $data["solicitud_retiro"];

        $response = "";
        if (es_data($solicitud_retiro)) {

            $texto  = _text_(
                "Solicitud enviada", 
                format_fecha(pr($solicitud_retiro, "fecha_registro")),
                "tu dinero está en camino llegará en un plazo no mayor a 24 hrs"
            );

            $response = d($texto, "col-sm-12 display-7 black mt-5 border_bottom_big text-right");
        }
        return $response;

    }
    function formato_cuenta_asociada($data)
    {
        
        $cuenta_pago = $data["cuenta_pago"];    
        $bancos = $data["bancos"];        

        $response = "";
        $editar_cuenta = icon(_text_(_editar_icon, "edita_cuenta_pago"));
        if (es_data($cuenta_pago)) {
            
            $propietario_tarjeta = pr($cuenta_pago, "propietario_tarjeta");
            $id_cuenta_pago = pr($cuenta_pago, "id_cuenta_pago");
            $numero_tarjeta = pr($cuenta_pago, "numero_tarjeta");
            $id_banco = pr($cuenta_pago, "id_banco");

            $classe_center = 'd-flex p-3 rounded flex-column text-center text-uppercase border';    
            $nombre_banco = search_bi_array($bancos, "id_banco", $id_banco, "nombre");

            

            $items = [
                d("Cuenta destino", 'display-5 black'), 
                d($propietario_tarjeta),
                d($numero_tarjeta, _text_(_strong, "f14")),
                d($nombre_banco),
                d($editar_cuenta)
            ];

            $response =  d($items, "d-flex flex-column");    

        }else{
            
            

            $items = [
                d("Cuenta destino", 'display-5 black'),                 
                d($editar_cuenta)
            ];

            $response =  d($items, "d-flex flex-column");    

        }
        return $response;
        

    }    
    
    function formato_comisiones($data)
    {
        $saldo_por_cobrar = $data["saldo_por_cobrar"];    
        $comisiones_por_cobrar = $data["comisiones_por_cobrar"];
        $ultima_orden_compra = 0; 

        if ($saldo_por_cobrar > 0  ) {
            
            $ids_ordenes_compra  = array_column($comisiones_por_cobrar,"id_orden_compra");            
            $ultima_orden_compra = max($ids_ordenes_compra);

        }
        
        $clase_centro = 
        'd-flex p-3 saldo_disponible white flex-column text-center text-uppercase border_black';    

        $response[] = flex("Saldo disponible", money($saldo_por_cobrar), $clase_centro, '' ,'display-4');
        $response[] =  hiddens([
            "name" => "ultima_orden_compra", 
            "class" => "ultima_orden_compra",
            "value" => $ultima_orden_compra
        ]);

        $response[] =  hiddens([
            "name" => "monto", 
            "class" => "monto",
            "value" => $saldo_por_cobrar
        ]);


        return append($response);

    }
    function formato_modal_cuenta($data)
    {
        
        $bancos = $data["bancos"];        
        $cuenta_pago = $data["cuenta_pago"];

        $propietario_tarjeta = pr($cuenta_pago, "propietario_tarjeta");
        $id_cuenta_pago = pr($cuenta_pago, "id_cuenta_pago");
        $numero_tarjeta = pr($cuenta_pago, "numero_tarjeta");
        $id_banco = pr($cuenta_pago, "id");


        $select_banco = create_select(
            $bancos, "banco", "banco", "banco", "nombre", "id",  $id_banco);
        
        $envio = btn("Enviar",
                [
                    "class" => "envio_solicitud",
                ]
            );

        $input_nombre = input_frm("", "Propietario de la cuenta",
            [
                "name" => "propietario_tarjeta",
                "id" => "propietario_tarjeta",
                "type" => "text",
                "class" => 'propietario_tarjeta',
                "required" => true,
                "value" => $propietario_tarjeta
            ]);
        
        $input_numero = input_frm("", "Numero tarjeta ó cuenta clabe",
            [
                "name" => "numero_tarjeta",
                "id" => "numero_tarjeta",
                "type" => "float",
                "class" => 'numero_tarjeta',
                "required" => true,
                "value" => $numero_tarjeta
            ]); 


        $input_id_cuenta_pago = hiddens(
            [
            "name" => "id_cuenta_pago",
            "class" => "id_cuenta_pago",
            "value" => $id_cuenta_pago
            ]
        );
        $input_id_usuario = hiddens(
            [
            "name" => "id_usuario",
            "class" => "id_usuario",
            "value" => $data["id_usuario"]
            ]
        );

        $inputs = [
            d(_titulo("Cuenta destino")),
            $input_id_cuenta_pago,
            $input_id_usuario,
            d($input_nombre, "mt-5"), 
            d($input_numero, "mt-5"),
            d($select_banco, "mt-5"),
            d($envio, "mt-5")
            
        ];

        $form[] = form_open("",
            [
                "class" => "form_cuenta",
                "method" => "post"
            ]
        );

        $form[] = append($inputs);    
        $form[] = form_close();

        return gb_modal(append($form), "modal_cuenta");


    }
    
}


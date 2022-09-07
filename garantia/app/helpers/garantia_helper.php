<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render_user($data)
    {
        
        $response[] = compra($data["ticket"]);
        $response[] = d(cross_selling(),10,1);

        

        return append($response);
    }

    function compra($ticket){
        $r[] = hiddens_tickects($ticket);
        $r[] = d('', "place_resumen_servicio");
        $response[] = d($r, 6, 1);
        $response[] = d("Dejanos tu correo para enviarte tu codigo de Garantía","h3 black col-md-6 col-md-offset-3");
        $response[] = form_open("", ["class" => "form_garantia col-md-6 col-md-offset-3", "id" => "form_garantia"]);
        $response[] = hiddens(["name" => "orden_compra", "value" => $ticket]);
        $response[] = input_frm("mt-5", "CORREO ELECTRÓNICO",
            [
                "name" => "email",
                "placeholder" => "CORREO",
                "class" => "email registro_email ",
                "type" => "email",
                "required" => true,
                "onkeypress" => "minusculas(this);",
                "id" => "registro_email",
            ], _text_correo
        );
        $response[] = btn('Envíar', ['class' => 'mt-5']);
        $response[] = form_close();
        return d($response,"seccion_compra");
        
    }
    function cross_selling(){

        $otros_articulis_titulo = _titulo('Quedamos notificados!', 2);
        $response[] = d($otros_articulis_titulo, 'mt-5 sugerencias_titulo ');
        $response[] = d("Aquí te dejamos más cosas que te podrían interesar!", 'mt-2 sugerencias_titulo ');
        $response[] = d(place("place_tambien_podria_interezar"));
        return d($response, "d-none notifcacion_garantia");

    }
    function hiddens_tickects($ticket)
    {
        return append(
            [
                hiddens(["class" => "action", "value" => "compras"]),
                hiddens(["class" => "ticket", "value" => $ticket])
            ]
        );
    }


    
}

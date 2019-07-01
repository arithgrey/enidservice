<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('get_format_descripction')) {

        function get_format_descripction()
        {
            $r[] = p("Como parte de nuestro equipo, influirás en el futuro de negocios
        que se encuentran en crecimiento a lo largo de la ciudad de México, 
        desean resolver sus operaciones más fácil, aumentar sus competencias,
        mejorar su posición de gestión y administración a diferentes escalas y
        sectores.");
            $r[] = p("Labores");
            $r[] = ul([
                "1.- Apertura de mercado.",
                "2.- Seguimiento a clientes.",
                "3.- Cierres de ventas."]);

            $r[] = p("Ofrecemos ");

            $r[] = ul(["- Sueldo + Comisiones",

                "- Bonos
              por productividad y Calidad (Hasta 30% adicional al salario)  ",

                "- Capacitación constante ",

                "- Tipo de puesto: 
              Medio tiempo",

                "- Horario: 
              Lunes a Viernes de 8:00 AM a 2:00 PM"]);

            $r[] = p("Requisitos ");

            $r[] = ul([
                "- Estado Civil: Indistinto",
                "- Edad: 20 años - 45 años",
                "- Escolaridad: Bachillerato / Licenciatura "
            ]);
            $r[] = p("Experiencia requerida:");
            $r[] = ul([
                "1.- Ventas en Call center: 1 año.",
                "2.- Conocimientos básicos en informática. "]);

            $r[] = p("En caso de cumplir con los requisitos solicitados, enviar curriculum a empleo@enidservice.com");
            return append($r);
        }
    }
    if (!function_exists('get_format_temas_ayuda')) {
        function get_format_temas_ayuda()
        {
            $r[] = heading_enid("TEMAS DE AYUDA", 3);
            $r[] = heading_enid("¿Tienes alguna duda?", 4);
            $r[] = p("¡Llámanos! Podemos ayudarte." . icon('fa icon-mobile contact'));
            $r[] = anchor_enid(
                "",
                [
                    "class" => "black strong",
                    "target" => "_blank",
                    "href" => "tel:5552967027"
                ]);
            $r[] = div("De Lunes a Viernes de 8:00 a 19:00 y Sábados de 09:00 a 18:00.", 1);
            $r[] = div("Podemos utilizar tu correo para mantenerte informado..", 1);
            $r[] = div("O si lo prefieres Comunícate directamente", 1);

            $r[] = anchor_enid(
                "FAQS",
                [
                    "href" => path_enid("faqs", "/?categoria=5"),
                    "class" => "top_20"
                ],
                1,
                1,
                1
            );

            return append($r);

        }
    }

}
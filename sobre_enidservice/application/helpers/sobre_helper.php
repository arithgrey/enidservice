<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_descripcion()
    {
        $r[] = div("Lo que hacemos en Enid Service") ;
        $r[] = img(["src" => "../img_tema/portafolio/ejemplo-personas.jpg"]) ;

        $r[] = p("Facilitamos los procesos de negocios a través de las TIC, Tecnologías de la información y comunicación, por lo tanto,el éxito de las personas a quienes ayudamos, define nuestro 
                propio éxito como negocio. ") ;

        $r[] = p("Acompañamos a las empresas en el desarrollo de nuevos proyectos, directamente vinculados a sus actividades claves, 
                que generan valor y que resulta necesarias para establecer  ventajas competitiva ante el mercado.") ;

        $r[] = heading_enid("MARCO METODOLÓGICO", 3) ;

        $r[] = p("Empleamos un enfoque que promueve la colaboración entre líneas de negocio, desarrollo y operaciones de TI, habilitando la entrega continua, el despliegue continuo y la supervisión continua de aplicaciones.") ;

        $r[] = p("Reduciendo el tiempo necesario para tratar el feedback de los clientes. El desarrollo y las operaciones, e incluso las pruebas.") ;

        $r[] = anchor_enid("Leer más", [
            "href" => "../tareas_complejas/",
            "class" => "a_enid_blue"
        ]) ;

        return append_data($r);
    }

}

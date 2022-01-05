<?php

function path_enid($pos, $extra = 0, $link_directo = 0, $controlador = 0)
{

    $path = "";
    $base_url = [
        "amazon" =>"https://www.amazon.com.mx/s?me=A2ZBGOMVSPRBHV&marketplaceID=A1AM78C64UM0Y8",
        "fotos_clientes_facebook" => "https://www.facebook.com/enidservicemx/",
        "fotos_clientes_instagram" => "https://www.instagram.com/enid_service/",
        "whatsapp" => "https://wa.me/c/5215552967027",
        "sobre_vender" => "sobre_ventas",
        "recompensas" => "recompensa/?&id=",
        "clientes" => "clientes",
        "top_competencia" => "competencias",
        "solicitud_saldo" => "pendiente",
        "conexiones" => "conexiones",
        "top_competencia_entrega" => "competencias_entregas",
        "top_competencias" => "competencias/?tipo_top=",
        "top_competencia_entregas" => "competencias_entregas",
        "top_competencias_entregas" => "competencias_entregas/?tipo_top=",
        "busqueda_pedidos_usuarios" => 'pedidos/?usuarios=1&ids=',
        "url_home" => "../reporte_enid",
        "reporte_enid" => "reporte_enid",
        "forma_pago" => "forma_pago/?info=1",
        "forma_pago_search" => "forma_pago/?recibo=",
        "nfaq" => "faq/?nueva=1",
        "editar_faq" => "faq/?faq=",
        "img_faq" => "img_tema/productos/",
        "faqs" => "faq",
        "login" => "login",
        "promociones" => "promociones",
        "_login" => "../login",
        "vender" => "planes_servicios",
        "entregas" => "entregas",
        "seguidores" => "seguidores",
        "vender_nuevo" => "planes_servicios/?action=nuevo",
        "editar_producto" => "planes_servicios/?action=editar&servicio=",
        "sobre_enid" => "sobre_enidservice",
        "img_logo" => "img_tema/enid_service_logo.jpg",
        "img_logo_amazon" => "img_tema/amazon_compra.png",
        "img_logo_ml" => "img_tema/logo_compra_ml.png",
        "nuba_seller_club" =>  "/img_tema/portafolio/nuba_seller.png",
        "pagina_enid_service_facebook" =>  "/img_tema/portafolio/facebook_enid_service.jpg",
        "pregunta" => "pregunta",
        "pregunta_search" => "pregunta/?tag=",
        "search" => "search",
        "search_q3" => "search/?q3=",
        "paypal_enid" => "https://www.paypal.me/eniservice/",
        "home" => "",
        "pedidos" => "pedidos",
        "busqueda" => "busqueda",
        "pedidos_reparto" => "pedidos/?reparto=1",
        "pedido_seguimiento" => "pedidos/?seguimiento=",
        "producto" => "producto/?producto=",
        "pedidos_recibo" => "pedidos/?recibo=",
        "imagen_usuario" => "imgs/index.php/enid/imagen_usuario/",
        "youtube_embebed" => "https://www.youtube.com/embed/",
        "area_cliente_compras" => "area_cliente/?action=compras&ticket=",
        "area_cliente" => "area_cliente",
        "_area_cliente" => "../area_cliente",
        "area_cliente_pregunta" => "area_cliente/?action=preguntas",
        "instagram" => "https://www.instagram.com/enid_service/",
        "twitter" => "https://twitter.com/enidservice",
        "facebook" => "https://www.facebook.com/enidservicemx/",
        "pinterest" => "https://es.pinterest.com/enid_service",
        "linkeding" => "https://www.linkedin.com/in/enid-service-433651138",
        "tumblr" => "https://enidservice.tumblr.com/",
        "administracion_cuenta" => "administracion_cuenta",
        "logout" => "login/index.php/startsession/logout",
        "nuevo_usuario" => "login/?action=nuevo",
        "lista_deseos" => "lista_deseos",
        "lista_deseos_preferencias" => "lista_deseos/?q=preferencias",
        "terminos-y-condiciones" => "terminos-y-condiciones",
        "contacto" => "contact/#envio_msj",
        "contact" => "contact/?ubicacion=1#direccion",
        "recomendacion" => "recomendacion/?q=",
        "compras" => "compras",
        "tiempo_venta" => "tiempo_venta",
        "ventas_encuentro" => "ventas_encuentro",
        "config_path" => "config/config.php",
        "config_mines" => "config/mimes.php",
        "config_db" => "db/database.php",
        "config_constants" => "config/constants.php",
        "desarrollo" => "desarrollo",
        "inventario" => "stock",
        "usuario_contacto" => "usuario_contacto/?id_usuario=",
        "vinculo" => "vinculo/?tag=",
        "go_home" => "../",
        "valoracion_servicio" => "valoracion/?servicio=",
        "cross_selling" => "cross_selling/?id_usuario=",
        "enid" => "https://enidservices.com",
        "nuba_seller" =>"https://www.facebook.com/groups/810697523192704",
        "enid_service_facebook" =>"https://www.facebook.com/enidservicemx",
        "busqueda_usuario" => 'usuarios_enid_service/?q=',
        "enid_login" => _text("http://enidservices.com/", _web, "/login/"),
        "logo_enid" => _text("http://enidservices.com/", _web, "/img_tema/enid_service_logo.jpg"),
        "logo_oxxo" => _text("http://enidservices.com/", _web, "/img_tema/portafolio/oxxo-logo.png"),
        "rastreo_pedido" => _text("http://enidservices.com/", _web, "/img_tema/seguimiento.png"),
        "dispositivo" => "img_tema/dispositivo.png"
    ];


    if (array_key_exists($pos, $base_url)) {

        $path = ($link_directo > 0) ?
            (($extra !== 0) ? $base_url[$pos] . $extra : $base_url[$pos]) : (($extra !== 0) ? "../" . $base_url[$pos] . $extra : "../" . $base_url[$pos]);

        if ($controlador > 0) {

            $path = _text("../", $path);
        }
    } else {

        echo "NO EXISTE ->  " . $pos;
    }

    return $path;

}


function path_imagen_web($path_imagen)
{

    return get_url_request(substr($path_imagen, 3, strlen($path_imagen)));
}

function get_url_servicio($id_servicio, $n = 0)
{

    return ($n > 0) ? "../img_tema/productos/" . $id_servicio : "../producto/?producto=" . $id_servicio;

}

function get_url_usuario($nombre_imagen, $n = 0)
{

    return _text("../img_tema/personas/", $nombre_imagen);

}


function create_url_preview($img)
{
    return base_url() . "../img_tema/portafolio/" . $img;
}

function lib_def()
{
    return "../../librerias/app";
}


function pago_oxxo($url_request, $saldo, $id_recibo, $id_usuario)
{


    $url_request = (strlen($url_request) < 1) ? '../' : $url_request;
    return ($saldo > 0 && $id_recibo > 0 && $id_usuario > 0) ?
        (
        _text($url_request, "orden_pago_oxxo/?q=", $saldo, "&q2=", $id_recibo, "&q3=", $id_usuario)
        ) : "";

}

function get_url_tienda($id_usuario)
{

    return _text(
        "https://", $_SERVER['HTTP_HOST'], "/", _web, "/search/?q3=", $id_usuario, '&tienda=1');

}

function url_recuperacion_password()
{

    return "../msj/index.php/api/mailrest/recupera_password/format/json/";
}
function get_url_request($extra)
{

    $web = _text("https://", $_SERVER['HTTP_HOST'], "/", _web, "/", $extra);
    $local = _text("http://", $_SERVER['HTTP_HOST'], "/", _web, "/", $extra);
    return (es_local()) ? $local : $web;

}
function link_imagen_servicio($id)
{

    return ($id > 0) ? _text("../imgs/index.php/enid/imagen_servicio/", $id) : "";

}
function get_img_serv($img)
{

    return (es_data($img)) ? get_url_servicio($img[0]["nombre_imagen"], 1) : "";
}

function get_img_usr($img)
{

    return (es_data($img)) ? get_url_usuario($img[0]["nombre_imagen"], 1) : "";
}
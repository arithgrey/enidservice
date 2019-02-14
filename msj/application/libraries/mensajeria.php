<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Mensajeria
    {

        function notifica_nuevo_contacto_subscrito($param, $email)
        {

            $destinatario = "ventas@enidservice.com";
            $asunto = "Se ha subscrito una nueva persona";
            $email_contacto = $param["email"];

            $info = div(strong("Contacto .-" . $email_contacto));

            $cuerpo = "<html>";
            $cuerpo .= "<meta charset='utf-8'>";
            $cuerpo .= div("Buen día " . $email . " - 
                      Una nueva persona se ha subscrito, al boletín, verifica si hay alguna oferta 
                      o necesidad la cual podamos ayudar a resolver");
            $cuerpo .= $info;
            $cuerpo .= "</html>";

            //$headers = get_headers_e();
            mail($destinatario, '=?UTF-8?B?' . base64_encode($asunto) . '?=', $cuerpo, $headers);
            return $cuerpo;
        }

        function notifica_agradecimiento_por_subscripcion($param, $email)
        {

            $destinatario = "ventas@enidservice.com";
            $asunto =
                "Gracias por creer en nosotros! Si lo prefieres puedes contactarnos directamente al (55)5296-7027 y (55)3269-3811";
            $email_contacto = $param["email"];
            $info = "Gracias por contactarnos, pronto tendrás noticias nuestras!";

            $cuerpo = "<html>";
            $cuerpo .= "<meta charset='utf-8' >";
            $cuerpo .= div("Buen día " . $email . " - " . $info);
            $cuerpo .= div("Buen día " . $email . " - " . $info);
            $cuerpo .= "</html>";

            //$headers = get_headers_e($email);
            mail($destinatario, '=?UTF-8?B?' . base64_encode($asunto) . '?=', $cuerpo, $headers);
            return $cuerpo;
        }

        function notifica_agradecimiento_contacto($param)
        {

            $nombre = $param["nombre"];
            $email_contacto = $param["email"];
            $destinatario = "ventas@enidservice.com";
            $asunto = "Gracias por contactarte " . $nombre;
            $info = $this->get_mensaje_base_agradecimiento();

            $cuerpo = "<html>";
            $cuerpo .= "<meta charset='utf-8' >";
            $cuerpo .= div("Excelente día  " . $email_contacto . " - " . $nombre);
            $cuerpo .= div($info);
            $cuerpo .= "</html>";

            $headers = get_headers_e($email_contacto);
            mail($destinatario, '=?UTF-8?B?' . base64_encode($asunto) . '?=', $cuerpo, $headers);
            return $cuerpo;

        }

        function get_mensaje_base_agradecimiento()
        {

            $cuerpo = heading_enid("Gracias por contactarse!");
            $cuerpo .= heading_enid("A la brevedad nos pondremos en contacto", 2);
            return $cuerpo;
        }
    }
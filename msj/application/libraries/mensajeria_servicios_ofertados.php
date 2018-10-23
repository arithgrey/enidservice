<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   class Mensajeria_servicios_ofertados{         
  
      function notifica_agradecimiento_contacto($param){

        $nombre         =   $param["empresa"];
        $email_contacto =   trim($param["email"]);                
        $destinatario   =   "arithgrey@enidservice.com";         
        $asunto         =   "Gracias por contactarte ".$nombre;                 
        $info           =   "Recibimos tu evaluación, en menos de 24 horas tendrás noticias de nosotros ";
          
        $link_facebook = anchor_enid("Facebook" ,
        [
          "target" => '_blank',
          "href"   => 'https://www.facebook.com/enidservicemx/'
        ]);  

        $link_twitter = anchor_enid("Twitter" ,
        [
          "target" => '_blank',
          "href"   => 'https://twitter.com/enidservice'
        ]);  

        $link_linkedin = anchor_enid("Linkedin" ,
        [
          "target" => '_blank',
          "href"   => 'https://www.linkedin.com/in/enid-service-433651138'
        ]);  

        $link_contacto = anchor_enid("Contacto +525552967027" ,
        [
          "target" => '_blank',
          "href"   => 'tel:+525552967027'
        ]);  

        $link_email = anchor_enid("ventas@enidservice.com" ,
        [           
          "target" => '_top',
          "href"   => 'mailto:ventas@enidservice.com?Subject=Hello%20again'
        ]);  

        $array_links  = [
          $link_facebook , 
          $link_twitter, 
          $link_linkedin , 
          $link_contacto,
          $link_email 
        ];

        
        $cuerpo   = "<html>";
        $cuerpo  .= "<meta charset='utf-8' >";
        $cuerpo  .= div("Excelente día  ".$email_contacto ." - ". $nombre );
        $cuerpo  .= ul($array_links);
        $cuerpo  .= "</html>";
                 
        $headers =  $this->get_headers_mail(trim($email_contacto));
        mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
        return $cuerpo;
    }
    function get_headers_mail($mail){
        $headers  = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";         
        $headers .= "From: Enid Service <arithgrey@enidservice.com>\r\n";     
        $headers .= "Cc: $mail\r\n"; 
        return $headers;           
    }
}
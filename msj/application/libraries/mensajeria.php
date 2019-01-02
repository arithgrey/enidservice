<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   class Mensajeria{

       /*
       function notifica_mail_marketing( $plantilla  , $p_nombre, $p_descripcion,$id_tipo_publicidad  ,  $mail , $nombre ,  $email  , $email_alterno , $imgs){

          $part_imgs =  "";
          foreach ($imgs as $row){
              $id_imagen  = $row["idimagen"];
              $url        =  base_url('index.php/enid/img')."/".$id_imagen;
              $part_imgs .=  img(["src" => $url], ["width"=>"100%;"]);
          }

          $destinatario         =   "ventas@enidservice.com";
          $contenido_plantilla  =   $this->get_contenido_plantilla($plantilla);
          $asunto               =   $p_nombre;

          $cuerpo  = "<html>";
          $cuerpo .= "<meta charset='utf-8' >";
          $cuerpo .= label("Buen día ".$nombre." - ".$mail, ["style"  => 'font-weight:bold; font-size:1.2em;']);
          $cuerpo .=  center($part_imgs);
          $cuerpo .=  div($p_descripcion);
          $cuerpo .=  div($contenido_plantilla);

          $this->get_headers_mail($mail);
          $headers =  $this->get_headers_mail($mail);
          mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);

          return $cuerpo;

      }
       */
      private function get_headers_mail($mail){

        $headers  = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";         
        $headers .= "From: Enid Service <arithgrey@enidservice.com>\r\n";     
        $headers .= "Cc: $mail\r\n"; 
        return $headers;           
      }
      /*
      function notificacion_new_user($mail , $pass){   

         $mail                  =   $mail;
         $datos["mail_send"]    =   $mail;
         $datos["pass_send"]    =   $pass;
         $destinatario          =   "ventas@enidservice.com";
         $asunto                =   "Accesos a tu cuenta Enid Service";
         $cuerpo                =   "<html>";
         $img_presentacion      =   img(["src" => base_url('../../img_tema/presentacion.png')]);
         $text                  =   "Hola buen día has ha sido invitado a ser miembro de la cuenta Enid service te estamos haciendo entrega de sus datos de acceso.";

         $cuerpo .= anchor_enid($img_presentacion . $text,  ["href"=>base_url('index.php/startsession')]);
         $config_button = [
          "class" =>  'btn btn-default login-btn ' ,
          "style" =>  'border-radius: 0;
                border-style: solid;
                border-width: 0;
                cursor: pointer;    
                padding: 1rem 1.77778rem 0.94444rem 1.77778rem;
                font-size: 0.98889rem;
                background-color: #008CBA;
                border-color: #007095;
                color: #FFFFFF;'
         ];
         $cuerpo .= anchor_enid(guardar("ACCEDER AHORA!" , $config_button) , 
          ["href" => base_url('index.php/startsession')]);

         $cuerpo .= heading_enid("Usuario :".   $mail , 3);
         $cuerpo .= heading_enid("Password: ".  trim($pass));
         $cuerpo .= div("Te recomendamos hacer el cambio  de tu contraseña al ingresar al sistema." , 1);
         $cuerpo .= "</html>";  
         $headers =  $this->get_headers_mail($mail);
         mail($destinatario, '=?UTF-8?B?'.base64_encode($asunto).'?=' ,$cuerpo,$headers);
         return $datos;       
      }           
      */
      /*
      function notifica_nuevo_contacto($param ,  $email ){

        $destinatario   = "ventas@enidservice.com";         
        $asunto         = "Tienes un nuevo contacto comercial";         
        $nombre         =  $param["nombre"];
        $email_contacto =  $param["email"];
        $tel            =  $param["tel"];
        $mensaje        =  $param["mensaje"];

        $info           =  div(strong("NOMBRE:" . $nombre));
        $info          .=  div(strong("EMAIL:" . $email_contacto));
        $info          .=  div(strong("TELÉFONO:" . $tel));
        $info          .=  div(strong("Mensaje:" . $mensaje));
                 
        $text           = "Buen día ".$email." - tienes un nuevo contacto comercial estos son sus datos para que lo contactes ";


        $cuerpo  = "<html>"; 
        $cuerpo .= "<meta charset='utf-8' >"; 
        $cuerpo .= label($text);
        $cuerpo .= $info;
        $cuerpo .= "</html>";     
         
        $headers =  $this->get_headers_mail($email);
        mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
        return $cuerpo;

      }
      */
      function notifica_nuevo_contacto_subscrito($param ,  $email ){

        $destinatario   = "ventas@enidservice.com";         
        $asunto         = "Se ha subscrito una nueva persona";       
        $email_contacto =  $param["email"];        

        $info           =  div(strong("Contacto .-" .$email_contacto));        

        $cuerpo    = "<html>";
        $cuerpo   .= "<meta charset='utf-8'>";
        $cuerpo   .= div("Buen día ".$email." - 
                      Una nueva persona se ha subscrito, al boletín, verifica si hay alguna oferta 
                      o necesidad la cual podamos ayudar a resolver");
        $cuerpo   .= $info;
        $cuerpo   .= "</html>";

        $headers =  $this->get_headers_mail($email);
        mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
        return $cuerpo;
      }
      function notifica_agradecimiento_por_subscripcion($param ,  $email){

        $destinatario = "ventas@enidservice.com";         
        $asunto         = 
        "Gracias por creer en nosotros! Si lo prefieres puedes contactarnos directamente al 
        (55)5296-7027 y (55)3269-3811";
        $email_contacto =  $param["email"];
        $info           =  "Gracias por contactarnos, pronto tendrás noticias nuestras!"; 

        $cuerpo  = "<html>";
        $cuerpo .= "<meta charset='utf-8' >";
        $cuerpo .= div("Buen día ".$email." - " . $info );
        $cuerpo .= div("Buen día ".$email." - " . $info );
        $cuerpo .= "</html>"; 
        
        $headers =  $this->get_headers_mail($email);
        mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
        return $cuerpo; 
      }
      /**/
      function notifica_agradecimiento_contacto($param){

        $nombre           =   $param["nombre"];
        $email_contacto   =   $param["email"];
        $destinatario     =   "ventas@enidservice.com";         
        $asunto           =   "Gracias por contactarte ".$nombre;                 
        $info             =  $this->get_mensaje_base_agradecimiento();

        $cuerpo           =  "<html>";
        $cuerpo          .=  "<meta charset='utf-8' >";
        $cuerpo          .=  div("Excelente día  ".$email_contacto." - ". $nombre );
        $cuerpo          .=  div($info);
        $cuerpo          .= "</html>"; 
                 
        $headers =  $this->get_headers_mail($email_contacto);
        mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
        return $cuerpo;

      }
      function get_mensaje_base_agradecimiento(){

        $cuerpo =  heading_enid("Gracias por contactarse!");
        $cuerpo =  heading_enid("A la brevedad nos pondremos en contacto" , 2);        
        return $cuerpo;
      }
}
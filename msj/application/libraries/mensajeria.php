<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   class Mensajeria{         
      function notifica_mail_marketing( $plantilla  , $p_nombre, $p_descripcion , $id_tipo_publicidad  ,  $mail , $nombre ,  $email  , $email_alterno , $imgs){        

        $part_imgs =  ""; 
        foreach ($imgs as $row){

          $id_imagen = $row["idimagen"];
          $url =  base_url('index.php/enid/img')."/".$id_imagen;
          $part_imgs .=  "<img src='".$url."' width=100%; > ";
          
        }
      $destinatario = "ventas@enidservice.com"; 
      $contenido_plantilla =  $this->get_contenido_plantilla($plantilla);
      $asunto = $p_nombre; 

      $cuerpo = "<html>                                    
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día ".$nombre." - ".$mail."
                    </label>

                  <center>
                  ".$part_imgs."
                  </center>  
                                    
                    ".$p_descripcion."                  
                  

                  ".$contenido_plantilla."
             
             </html>"; 

        
         $this->get_headers_mail($mail);
         $headers =  $this->get_headers_mail($mail);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;

      }
      /**/
      function get_contenido_plantilla($plantilla ){

        $contenido_plantilla = "";
        if ($plantilla ==  0 ){
          
          $contenido_plantilla =  "<center>
                    <span style='margin-top: 9%;margin-left: 5%;font-size: 3em;color: #223c48;'>
                      Enid Service
                    </spa>                    
                  </center>
                  
                  <center>
                  <a href='". base_url('index.php/startsession') ."'>
                          <button class='btn btn-default login-btn ' style='border-radius: 0;
                                  border-style: solid;
                                  border-width: 0;
                                  cursor: pointer;    
                                  padding: 1rem 1.77778rem 0.94444rem 1.77778rem;
                                  font-size: 0.98889rem;
                                  background-color: #008CBA;
                                  border-color: #007095;
                                  color: #FFFFFF;'>                    
                              Inicia ahora.!
                          </button>
                  </a>
                  </center>";
        }else{
          $contenido_plantilla = "
                  <center>                    
                    <a href='". url_developer() ."'>
                            <button class='btn btn-default login-btn ' style='border-radius: 0;
                              border-style: solid;
                              border-width: 0;
                              cursor: pointer;    
                              padding: 1rem 1.77778rem 0.94444rem 1.77778rem;
                              font-size: 0.98889rem;
                              background-color: #008CBA;
                              border-color: #007095;
                              color: #FFFFFF;'>                    
                                Conoce mi trabajo
                              
                            </button>
                    </a>
                  </center>";
        }
        return $contenido_plantilla;                
      }
      /**/
      function get_headers_mail($mail){

        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

        //dirección del remitente 
        $headers .= "From: Enid Service <arithgrey@enidservice.com>\r\n";     

        $headers .= "Cc: $mail\r\n"; 

        return $headers;           
      }
      /**/
      function notificacion_new_user($mail , $pass){   

         $mail =  $mail;
         $datos["mail_send"] =  $mail;
         $datos["pass_send"] =  $pass;
         $destinatario = "ventas@enidservice.com"; 
         $asunto = "Accesos a tu cuenta Enid Service"; 
         $cuerpo = "<html>
                  <a href='". base_url('index.php/startsession') ."'>                  
                     <img src=". base_url('application/img/mail/presentacion.png') .">
                     <center>
                        <strong>
                               <span style='color:black;'>
                                   Hola buen día has ha sido invitado a ser miembro de la cuenta Enid service
                                   le estamos haciendo entrega de sus datos de acceso.
                               </span>      
                            </strong>
                        </center>
                     </a>

                     
                     <center>
                        <a href='". base_url('index.php/startsession') ."'>
                             <button class='btn btn-default login-btn ' style='border-radius: 0;
                              border-style: solid;
                              border-width: 0;
                              cursor: pointer;    
                              padding: 1rem 1.77778rem 0.94444rem 1.77778rem;
                              font-size: 0.98889rem;
                              background-color: #008CBA;
                              border-color: #007095;
                              color: #FFFFFF;'>                    
                                 Inicia ahora.!
                             </button>
                         </a>
                     </center>

                     <center>
                        <label>
                           Usuario :  ". $mail ."
                        </label>
                        <label>
                           Password: ".trim($pass)."
                        </label>
                        
                        <label>
                           Te recomendamos hacer el cambio  de tu contraseña al ingresar al sistema.
                        </label>
                     </center>                
                  </html>"; 

         
         $headers =  $this->get_headers_mail($mail);
         mail($destinatario, '=?UTF-8?B?'.base64_encode($asunto).'?=' ,$cuerpo,$headers);
         return $datos;       
      }           
      /**/
      function notifica_nuevo_contacto($param ,  $email ){

        $destinatario = "ventas@enidservice.com";         
        $asunto = "Tienes un nuevo contacto comercial"; 
        
        $nombre =  $param["nombre"];
        $email_contacto =  $param["email"];
        $tel =  $param["tel"];
        $mensaje =  $param["mensaje"];


        $info =  "<strong>Nombre: </strong>".$nombre; 
        $info .=  "<strong>Email: </strong>".$email_contacto; 
        $info .=  "<strong>Teléfono: </strong> ".$tel; 
        $info .=  "<strong>Mensaje: </strong>".$mensaje; 




        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día ".$email." - tienes un nuevo contacto comercial estos son sus datos para que lo contactes 
                    </label>
                      ".$info."
                    </html>"; 

        
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;

      }
      /**/
      function notifica_nuevo_contacto_subscrito($param ,  $email ){

        $destinatario = "ventas@enidservice.com";         
        $asunto = "Se ha subscrito una nueva persona";       
        $email_contacto =  $param["email"];        

        $info =  "<strong>Contacto .- </strong>".$email_contacto; 

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día 
                        ".$email." - 
                      Una nueva persona se ha subscrito, al boletín, verifica si hay alguna oferta 
                      o necesidad la cual podamos ayudar a resolver
                    </label>
                      ".$info."
                    </html>"; 
        
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;

      }
      /**/
      function notifica_agradecimiento_por_subscripcion($param ,  $email){

        $destinatario = "ventas@enidservice.com";         
        $asunto = "Gracias por creer en nosotros!
                    Si lo prefieres puedes contactarnos directamente al (55)5296-7027 y (55)3269-3811";       
        $email_contacto =  $param["email"];        

        $info =  "Gracias por contactarnos, pronto tendrás noticias nuestras!</strong>"; 

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día 
                        ".$email." -                       
                    </label>
                      ".$info."
                    </html>"; 
        
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo; 
      }
      /**/
      function notifica_agradecimiento_contacto($param){

        $nombre =  $param["nombre"];
        $email_contacto =  $param["email"];
        $destinatario = "ventas@enidservice.com";         
        $asunto = "Gracias por contactarte ".$nombre;         
        
        $info =  $this->get_mensaje_base_agradecimiento();

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Excelente día  ".$email_contacto." - ". $nombre ."
                    </label>
                      ".$info."
                    </html>"; 
                 
         $headers =  $this->get_headers_mail($email_contacto);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;

      }
      /**/
      function get_mensaje_base_agradecimiento(){

        $mensaje = '
             <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
                <tbody><tr>
                    <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
              <tbody><tr>
                <td align="center" valign="top" id="templateHeader" data-template-container="" style="background:#F7F7F7 none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F7F7F7;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 45px;padding-bottom: 45px;">
                  
                  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                    <tbody><tr>
                                      <td valign="top" class="headerContainer" style="background:transparent none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                
                                    
                                        <img align="center" alt="" src="https://gallery.mailchimp.com/a5e137daf691ed74c0b882f1f/images/5424d4e8-6e90-4db5-87c9-4477314b92bc.png" width="100" style="max-width: 100px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #808080;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">
                        
                            <h1 style="display: block;margin: 0;padding: 0;color: #222222;font-family: Helvetica;font-size: 40px;font-style: normal;line-height: 150%;letter-spacing: normal;text-align: center;">
                              Gracias por contactarse!
                            </h1>

                            <h2 >
                              A la brevedad nos pondremos en contacto
                            </h2>

                        </td>
                    </tr>
                </tbody></table>
      
            </td>
        </tr>
    </tbody>
</table>





</td>
                    </tr>
                  </tbody></table>
                  
                </td>
                            </tr>
                            <tr>
                <td align="center" valign="top" id="templateFooter" data-template-container="" style="background:#333333 none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #333333;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 45px;padding-bottom: 63px;">
                  
                  <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                    <tbody><tr>
                                      <td valign="top" class="footerContainer" style="background:#333333 none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #333333;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody><tr>
        <td align="center" style="padding-left: 9px;padding-right: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><p></p><p></p><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <tbody><tr>
                                <td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody>
                                                  <tr>

                                                    <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                    <a href="https://www.linkedin.com/in/enid-service-433651138" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                      <img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-linkedin-48.png" style="display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" height="24" width="24" class="">
                                                                                    </a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>



                                                    <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                    <a href="http://www.facebook.com/enidservicemx/" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-facebook-48.png" style="display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" height="24" width="24" class="">
                                                                                    </a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                    <a href="https://twitter.com/enidservice/" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-twitter-48.png" style="display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                     
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                    <a href="http://enidservice.com/" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-link-48.png" style="display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right: 0;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <p>
                                                            </p><p></p><p></p><p></p><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                            
                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                                    <a href="mailto:ventas@enidservice.com" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-forwardtofriend-48.png" style="display: block;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" height="24" width="24" class=""></a>
                                                                                </td>
                                                                            
                                                                            
                                                                        </tr>

                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody><tbody></tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>



                                            <table>
                                              <tbody><tr>
                                                    <td style="color:white;">
                                                        </td></tr></tbody></table></td></tr></tbody></table><p></p><p></p><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><tbody><tr><td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table><tbody><tr><td style="color:white;">Contáctenos
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="color:white;">
                                                      (55)5296-7027 , (55)3269-3811&nbsp;
                                                    </td>
                                                </tr>
                                                <tr style="color:white;">
                                                  <td>
                                                    ventas@enidservice ,  soporte@enidservice.com, hola@enidservice.com
                                                  </td>
                                                </tr>

                                            </tbody></table>
                                        
                                        
                                </td>
                            </tr>
                        </tbody></table>




                    <p></p></td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;table-layout: fixed !important;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%;padding: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #505050;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                    <tbody><tr>
                        <td style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                    </tr>
                  </tbody></table>
                  
                </td>
                            </tr>
                        </tbody></table>                        
                    </td>
                </tr>
            </tbody></table>
        </center>
                <center>
                
                
            </center>
                ';
          return $mensaje;

      }

}
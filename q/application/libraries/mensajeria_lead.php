<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   class Mensajeria_lead{     
      /**/  
      function envia_correo_maps($param){        
        /**/
        
        $email = $param["info_usuario"][0]["email"];
        $nombre = $param["info_usuario"][0]["nombre"];

        
        $asunto = "Hola ".$nombre." te damos la Bienvenida a tu área de clientes";

        $info_correo = "<label>
                          BUEN DÍA 
                          ".strtoupper($nombre)."
                          POR FAVOR LEE ESTE CORREO ELECTRÓNICO COMPLETO Y CONSÉRVALO
                        </label>
                        <div>    
                          <img src='http://enidservice.com/inicio/img_tema/enid_service_logo.jpg' width='100%'>
                        <div>
                        <div>
                          <div style='font-size:.8em!important;background: black;color: white;
                            padding:10px;'>  
                            Desde este momento, 
                            puedes solicitar soporte
                            y seguimiento a tus servicios  
                            desde este medio.
                          </div> 
                        </div> 
                        
                        ";

        $info_correo .= $this->forma_info_accesos_area_cliente_usuario($param);

        $this->envia_correo_notificacion_cliente($asunto , $info_correo , $email );         
        return $info_correo;
      } 
      /**/
      function forma_info_accesos_area_cliente_usuario($param){
        
          $password =  $param["password"];        
          $email =  $param["info_usuario"][0]["email"];

          $estilos ="style='font-size:.8em!important;background: #0030ff;color: white;padding:5px;' ";
          $estilos_1 ="style='font-size:.8em!important;padding:5px;background:#072a69;color:white!important;' ";
          
          $l = "<div style='overflow:auto'>
                  <table style='margin-top:30px;' width='100%'>";                        
            $l .= "<tr>";      
              $l .= get_td("Sitio de soporte" , $estilos);      
              $l .= get_td("http://enidservice.com/inicio/login/", $estilos_1);      
            $l .= "</tr>";      


            $l .= "<tr>";      
              $l .= get_td(" Usuario " , $estilos);      
              $l .= get_td($email, $estilos_1);      
            $l .= "</tr>";      

            $l .= "<tr>";      
              $l .= get_td(" Password " , $estilos);      
              $l .= get_td("<span>" .$password ."</span>", $estilos_1);      
            $l .= "</tr>";      

          $l .= "</table>
                </div>
                <hr>    
                <div>
                  También contamos con Secciones de 
                  <a href='http://enidservice.com/inicio/faq/' style='font-weight:bold;color:blue;' target='_black'>
                    Preguntas Frecuentes
                  </a>
                </div>
                <hr>
                <div>
                  <label>
                    SÓLO DE ESA MANERA SE TE PUEDE ATENDER YA QUE ES POR TU SEGURIDAD Y PARA CONFIRMAR QUE LA PETICIÓN PROVIENE DEL LEGÍTIMO PROPIETARIO.
                  </label>              
                </div>
                <hr>
                
                <label>
                  <a href='https://goo.gl/DTHQid' target='black' style='color:blue;'>
                    También te invitamos a que nos des la opinión de nuestro trato a través de este medio. 
                  </a>
                </label> 
                ";


          return $l;

      }                               
      /**/
      function envia_correo_notificacion($asunto , $info_correo , $email){

        $destinatario = "ventas@enidservice.com";                         
        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >                    
                      ".$info_correo."
                    </html>"; 
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);         
         return $cuerpo;

      }
      /**/
      function envia_correo_notificacion_cliente($asunto , $info_correo , $email){
        /**/
        $destinatario = "ventas@enidservice.com";                         
        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >                    
                      ".$info_correo."
                    </html>"; 
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;
      }
      /**/
      function notifica_registro_de_pago_efectuado($param){          
          /**/                   
          $asunto = "Una persona ha registrado su pago, valar que sea efectivo";
          $info_correo = "Una persona 
                          ha realizando la notificación de este pago, hay que realizar la validación para verificar que sea efectivo
                          ";
                          
          $info_notificacion_pago =  $param[0]; 
          $info_correo .= $this->get_table_notificacion_servicios($info_notificacion_pago);
          return $this->envia_correo_notificacion($asunto , $info_correo , "ventas@enidservice.com"); 

      }   
      /**/
      function notifica_registro_de_pago_efectuado_cliente($param){          
          
          /**/                   
          $info_notificacion_pago =  $param[0]; 
          $nombre_persona         = $info_notificacion_pago["nombre_persona"];
          $correo  = $info_notificacion_pago["correo"];

          $asunto = "Hola ".$nombre_persona." hemos recibido tu notificación de pago, a la brevedad será procesado";

          $info_correo = "Información notificada ";
                          
          $info_correo .= $this->get_table_notificacion_servicios($info_notificacion_pago);
          return $this->envia_correo_notificacion_cliente($asunto , $info_correo , $correo); 
      }   
      /**/
      function get_table_notificacion_servicios($param){

          $nombre_persona         = $param["nombre_persona"];
          $correo                 = $param["correo"];
          $dominio                = $param["dominio"];
          $fecha_pago             = $param["fecha_pago"];
          $fecha_registro         = $param["fecha_registro"];
          $cantidad               = $param["cantidad"];
          $referencia             = $param["referencia"];
          $comentario             = $param["comentario"];
          $id_notificacion_pago   = $param["id_notificacion_pago"];
          $num_recibo             = $param["num_recibo"];
          $forma_pago             = $param["forma_pago"];
          $nombre_servicio        = $param["nombre_servicio"];

          $l ="<table style='width:100%'>";
            /**/
            $l .="<tr>";
              $l .= get_td("#Recibo");
              $l .= get_td($num_recibo);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("#Refereancia de pago");
              $l .= get_td($id_notificacion_pago);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("Persona");
              $l .= get_td($nombre_persona);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("Correo");
              $l .= get_td($correo);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("Dominio");
              $l .= get_td($dominio);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("Fecha pago");
              $l .= get_td($fecha_pago);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("Fecha Registro");
              $l .= get_td($fecha_registro);
            $l .="</tr>";

            /**/
            $l .="<tr>";
              $l .= get_td("Cantidad notificada");
              $l .= get_td($cantidad." MXN ");
            $l .="</tr>";


            /**/
            $l .="<tr>";
              $l .= get_td("Referencia");
              $l .= get_td($referencia);
            $l .="</tr>";


            /**/
            $l .="<tr>";
              $l .= get_td("Comentario");
              $l .= get_td($comentario);
            $l .="</tr>";

            /**/            
            $l .="<tr>";
              $l .= get_td("Forma de pago");
              $l .= get_td($forma_pago);
            $l .="</tr>";


            $l .="<tr>";
              $l .= get_td("Nombre Servicio");
              $l .= get_td($nombre_servicio);
            $l .="</tr>";


          $l .="</table>";

          return $l;
      }             
      /**/
      function notifica_usuario_pagina_web($param){
          $usuario  = $param[0];                        
          $usuario["mensaje"] =  "Dar seguimiento al prospecto ahora!";
          return $this->notifica_nuevo_contacto_pagina_web($usuario , "enidservice@gmail.com");        
      }  
      /**/
      function notifica_usuario_pagina_web_notificacion($param){

          $usuario  = $param[0];                        
          return $this->notifica_nuevo_contacto_pagina_web_usuario($usuario , $usuario["email"]);        
      }
      /**/
      function notifica_nuevo_contacto_pagina_web_usuario($param ,  $email ){

        $destinatario = "ventas@enidservice.com";         
        $nombre =  $param["nombre"];
        $asunto = "Excelente día ".$nombre ." gracias por contactarte!";         
                

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                        Buen día ".$nombre."
                          Excelente día hemos recibido tu solicitud, a la brevedad tendrás 
                          noticias nuestras y podemos dar seguimiento de tu solicitud a través 
                          de tu área de cliente, para acceder a ella dirígete a este enlace. 
                          
                          http://enidservice.com/inicio/login/ 
                    </label>                      
                    </html>"; 
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         
         return $cuerpo;

      }  

      /**/  
      function notifica_nuevo_contacto_pagina_web($param ,  $email ){

        $destinatario = "ventas@enidservice.com";         
        $asunto = "Urgente, una persona, requiere una cotización, dar seguimiento ahora!";         

        $nombre =  $param["nombre"];
        $tel =  $param["tel_contacto"];
        $email_contacto =  $param["email"];        
        $mensaje =  $param["mensaje"];

        $info =  "<strong>Nombre: </strong>".$nombre; 
        $info .=  "<strong>Email: </strong>".$email_contacto; 
        $info .=  "<strong>Teléfono: </strong> ".$tel; 
        $info .=  "<strong>Mensaje: </strong>".$mensaje; 

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                        Buen día ".$email." - una persona requiere una cotización de su página web
                    </label>
                      ".$info."
                    </html>"; 
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         
         return $cuerpo;

      }        
      /**/
      function notifica_nuevo_contacto_afiliado($param ,  $email ){

        $destinatario = "ventas@enidservice.com";         
        $asunto = "Urgente, una persona, se ha registrado al programa de afiliados!";         
        $nombre =  $param["nombre"];
        $tel =  $param["tel_contacto"];
        $email_contacto =  $param["email"];        
        $mensaje =  $param["mensaje"];

        $info =  "<strong>Nombre: </strong>".$nombre; 
        $info .=  "<strong>Email: </strong>".$email_contacto; 
        $info .=  "<strong>Teléfono: </strong> ".$tel; 
        $info .=  "<strong>Mensaje: </strong>".$mensaje; 

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día ".$email." - 
                      Se ha registrado como afiliado hay que verificar que tenga lo necesario para promocionar nuestros servicios 
                    </label>
                      ".$info."
                    </html>"; 
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         
         return $cuerpo;

      }
      /**/
      function notifica_usuario_en_proceso_compra($param){          
          $usuario  = $param[0];          
          $correo = $usuario["email"];
          $usuario["email"] =  $correo;
          $usuario["mensaje"] =  "Está en proceso de venta, dar soporte a su compra";
          return $this->notifica_nuevo_contacto($usuario , "enidservice@gmail.com");        
      }
      /**/
      function notifica_nuevo_contacto($param ,  $email ){

        $destinatario = "ventas@enidservice.com";         
        $asunto = "Urgente, venta en proceso, una persona está realizando compra en línea, dar soporte a su compra!";         
        $nombre =  $param["nombre"];
        $tel =  $param["tel_contacto"];
        $email_contacto =  $param["email"];        
        $mensaje =  $param["mensaje"];


        $info =  "<strong>Nombre: </strong>".$nombre; 
        $info .=  "<strong>Email: </strong>".$email_contacto; 
        $info .=  "<strong>Teléfono: </strong> ".$tel; 
        $info .=  "<strong>Mensaje: </strong>".$mensaje; 

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día ".$email." - 
                      Esta personas está realizando su compra en línea, hay que darle soporte 
                    </label>
                      ".$info."
                    </html>"; 
         
         $headers =  $this->get_headers_mail($email);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);         
         return $cuerpo;

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
      function notificacion_email($param , $correo_dirigido_a){
        
        $email_contacto = $correo_dirigido_a;
        $destinatario = "ventas@enidservice.com";                 
        $info   =  $param["info_correo"];
        $asunto =  $param["asunto"];
        $cuerpo = "<html>                                     
                    <meta charset='utf-8'>                    
                      ".$info."
                    </html>"; 
                 
         $headers =  $this->get_headers_mail($email_contacto);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;
      }
      function enviar($mensaje, $asunto ,$correo_dirigido_a){
        
        $email_contacto = $correo_dirigido_a;
        $destinatario = "ventas@enidservice.com";                 
        $info   =  $mensaje;
        $asunto =  $asunto;
        $cuerpo = "<html>                                     
                    <meta charset='utf-8'>                    
                      ".$info."
                    </html>"; 
                 
         $headers =  $this->get_headers_mail($email_contacto);
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;
      }
      /**/
}
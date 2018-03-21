<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   class Mensajeria_servicios_ofertados{         
      
      /**/
      function notifica_paginas_web_me($param , $mail){
    
        $destinatario = "arithgrey@enidservice.com";         
        $asunto = "Tienes un nuevo contacto comercial -  páginas web";         

        $email_contacto =  trim($param["email"]);        
        $tel =  $param["tel"];
        $empresa = $param["empresa"];
        $rubro = $param["rubro"];
        $facebook =  $param["facebook"];
        $twitter =  $param["twitter"];
        $youtube =  $param["youtube"];
        $objetivos = $param["objetivos"];
        $sitio_similar = $param["sitio_similar"];                      
        $presupuesto = $param["presupuesto"];
            
        

        $info =  "<br><strong>Email: </strong>".$email_contacto; 
        $info .=  "<br><strong>Teléfono: </strong> ".$tel;         
        $info .=  "<br><strong>Nombre: </strong>".$empresa;               
        $info .=  "<br><strong>Rubro: </strong> ".$rubro; 
        $info .=  "<br><strong> facebook: </strong> ".$facebook; 
        $info .=  "<br><strong> twitter: </strong> ".$twitter; 
        $info .=  "<br><strong> youtube: </strong> ".$youtube; 
        $info .=  "<br><strong>Objetivos: </strong> ".$objetivos; 
        $info .=  "<br><strong> sitio similar: </strong> ".$sitio_similar;         
        $info .=  "<br><strong>Presupuesto: </strong> ".$presupuesto; 

        

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Buen día ".$mail." - 
                        tienes un nuevo contacto comercial 
                        estos son sus datos para que lo contactes 
                    </label>
                      ".$info."
                    </html>"; 
    
         
         $headers =  $this->get_headers_mail(trim($mail));
         mail($destinatario , '=?UTF-8?B?'.base64_encode($asunto).'?=' , $cuerpo , $headers);
         return $cuerpo;  
  
      }          

      /**/
      function notifica_agradecimiento_contacto($param){

        $nombre =  $param["empresa"];
        $email_contacto =  trim($param["email"]);                
        $destinatario = "arithgrey@enidservice.com";         

        $asunto = "Gracias por contactarte ".$nombre;         
        
        $info =  "Recibimos tu evaluación, en menos de 24 horas tendrás noticias de nosotros 

                  <br>   
                  <br>   
                  <a target='_blank' href='http://goo.gl/AQciya'>
                      Danos la opinión que tienes de nuestros servicios aquí 
                  </a>
                  <br>
                  <a target = '_blank' href='https://www.facebook.com/enidservicemx/'>
                      Facebook
                  </a>
                  <br>
                  <a target = '_blank' href='https://twitter.com/enidservice'>
                      Twitter
                  </a>
                  <br>
                  <a target = '_blank' href='https://github.com/arithgrey'>
                      Github
                  </a>
                  <br>
                  <a target = '_blank' href='https://www.linkedin.com/in/enid-service-433651138'>
                      Linkedin
                  </a>
                  <br>
                  
                  <a target='_blank' href='tel:+525545444823' >
                      Contacto +525545444823
                  </a>
                  <br>
                  <a href='mailto:ventas@enidservice.com?Subject=Hello%20again' target='_top'>        
                      ventas@enidservice.com
                  </a>
                  <br>
                  <a href='mailto:enidservice@gmail.com?Subject=Hello%20again' target='_top'>        
                      enidservice@gmail.com
                  </a>
                  <br>

                  ";

        $cuerpo = "<html>                                     
                    <meta charset='utf-8' >
                    <label style='font-weight:bold; font-size:1.2em;'>
                      Excelente día  ".$email_contacto ." - ". $nombre ."
                    </label>
                      ".$info."
                    </html>"; 
                 
         $headers =  $this->get_headers_mail(trim($email_contacto));
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
        //$email_copia = "enidservice@gmail.com";
        //$headers .= "Bcc: $email_copia\r\n";

        return $headers;           
      }

}
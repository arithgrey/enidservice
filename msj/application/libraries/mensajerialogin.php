<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
   class Mensajerialogin{         
    function mail_recuperacion_pw($param){
    
    $mail =  trim($param["mail"]);
    $new_pass=  $param["new_pass"];

    $datos["mail"] =  $mail;
    $datos["new_pass"] =  $new_pass;
    
    $destinatario = "arithgrey@enidservice.com"; 
    $asunto = "Recuperación password - Enid Service"; 
    $cuerpo =  $this->get_cuerpo($param);
    $headers = $this->get_headers($mail);
    mail($destinatario, '=?UTF-8?B?'.base64_encode($asunto).'?=' ,$cuerpo,$headers);
    
    return $datos;  
  }  
  /**/
  function get_cuerpo($param){

    $mail =  trim($param["mail"]);
    $new_pass=  $param["new_pass"];
    $cuerpo = "<html>                  
          <center>
            <strong>
                    <span style='color:black;'>
                        Solicitaste la recuperación de tu contraseña Enid Service
                    </span>      
                  </strong>
              </center>                
                
                <center>
                  <a href='http://enidservice.com/inicio/login/'>                      
                      Inicia ahora.!
                  </a>
                </center>
                <strong>
                  <center>                
                    <label style=''>
                      Usuario :  ". $mail ."
                    </label>
                    <label style='background: #104c5f;color: white;' >
                      Nueva  password: ".trim($new_pass)."
                    </label>
                    
                    <label>
                      Te recomendamos hacer el cambio de tu contraseña al ingresar.
                    </label>
                  </center>
              </strong>    
           
           </html>"; 

    return $cuerpo;
  }
  /**/
  function get_headers($mail){


    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    $headers .= "From: Enid Service <arithgrey@enidservice.com>\r\n";     
    $headers .= "Cc: $mail\r\n"; 
    return $headers;

  }
  /**/

}
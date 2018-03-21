$(document).ready(function(){
  
  $(".form-miembro-enid-service").submit(registra_prospecto_cotización);
});

function registro_prospecto(){

    url = "../persona/index.php/api/equipo/prospecto_pagina_web/format/json/";
    pw = $.trim($(".password").val());  
    pwpost = ""+CryptoJS.SHA1(pw);
    data_send =  {"password": pwpost , email : $(".email").val(),  nombre : $(".nombre").val() , telefono :  $(".telefono").val() , "plan": 1};

    $.ajax({
      url : url , 
      type : "POST" , 
      data: data_send, 
      beforeSend : function(){            
        show_load_enid(".place_registro_afiliado" ,  "Validando datos " , 1 );
      }           

      }).done(function(data){     
          
          if(data.usuario_existe > 0){  
            usuario_registrado =   "<span class='alerta_enid'>Ya tienes una cuenta con nosotros, solicita tu cotización desde tu área de clientes</span><br><a href='../login/' class='blue_enid_background white' style='padding:5px;' > - Acceder aquí</a>";
            llenaelementoHTML(".place_registro_afiliado" , usuario_registrado);               
          }else{      

            redirect("../login/?action=registro");

            
          }         

      }).fail(function(){             
        show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");       
      });

}
/**/
function registra_prospecto_cotización(e){
   
  text_password =  $.trim($(".password").val());
  if (text_password.length>7 ) {

      
      flag =  valida_tel_form(".telefono_info_contacto" , ".place_num_tel"  );
      if(flag ==  1){
          flag_correo =  valida_email_form(".email" , ".place_correo_incorrecto");           
          if(flag_correo ==  1) {

            flag =  valida_text_form(".nombre" , ".place_nombre_info" , 8 , "Nombre" );
            if(flag == 1 ){
                registro_prospecto();   
            }

          }
      } 
      
  }else{
    llenaelementoHTML( ".place_password_afiliado" ,  "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
  }

  e.preventDefault();
}
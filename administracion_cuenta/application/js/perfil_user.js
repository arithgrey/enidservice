function update_password(e){
	
	flag = 0; 
	flag2 = 0;
	flag3 = 0;
	flag =  valida_text_form("#password" , ".place_pw_1" , 7 , "Texto " );			
	flag2 =  valida_text_form("#pw_nueva" , ".place_pw_2" , 7 , "Texto " );			
	flag3 =  valida_text_form("#pw_nueva_confirm" , ".place_pw_3" , 7 , "Texto " );			
	nueva_password = 0;
	
	msj_user = "";
	if (flag == flag2 && flag ==  flag3) {
	
			/*Ahora validamos que no sean las mismas que la antigua*/			
			if ($("#password").val() !=  $("#pw_nueva").val() ){nueva_password =  1;}else{nueva_password =  2;}
			if ($("#password").val() !=  $("#pw_nueva_confirm").val() ){nueva_password =  1;}else{nueva_passwor	 =  2;}		
	}


	switch(nueva_password){
		case 1: 
			a = $("#password").val();
			b = $("#pw_nueva").val();
			c = $("#pw_nueva_confirm").val();
			anterior = "" +CryptoJS.SHA1(a);
			nuevo = "" +CryptoJS.SHA1(b);
			confirma = "" +CryptoJS.SHA1(c);
			actualiza_password(anterior , nuevo , confirma); 			
			break;
		case 2:			
			llenaelementoHTML(".msj_password" , "La nueva contraseña no puede ser igual a la actual ");
			break;
		default: 
			break;
	}

	e.preventDefault();
}
/**/
function termina_session(){
	url =   '../login/index.php/startsession/logout';
	redirect(url);	
}
/**/
function  actualiza_password(anterior , nuevo , confirma){
	
	url ="index.php/api/cambiopasswordcontrolador/actualizarPassword/format/json";	
	$.ajax({ 
			url : url , 
			type : "POST", 
			data :{"nuevo": nuevo, "anterior": anterior, "confirma": confirma }, 			
			beforeSend : function(){			
				show_load_enid( ".msj_password"   , "Registrando ... " , 1 );	
			}
			/**/
		}).done(function(data){					
			/**/
			if(data == true){				
				show_response_ok_enid(".msj_password" , "Contraseña actualizada correctamente, inicia sessión para verificar el cambio.");	
				setInterval('termina_session()',3000);
			}else{
				llenaelementoHTML(".msj_password" , data );			
			}			
	}).fail(function(){		
		show_error_enid(".msj_password", genericresponse[0]);
	});	
}
/**/
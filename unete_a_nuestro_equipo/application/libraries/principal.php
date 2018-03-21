<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
	require "interfaces/iRegistro.php";
	class principal extends CI_Model implements  iRegistro{	 			
		
		

function get_valor_numerico_bool($bool){

				$valor =0;
				if ($bool ==  true ){
		        	$valor =  1;
		        }
		        return $valor;
			}	
			/**/
			function crea_historico( $tipo , $id_evento = 0 , $id_usuario = 0  , $id_empresa = 0){

			$pagina_url =  base_url(uri_string());         
	        $ip = $this->input->ip_address();               
	        $dispositivo  = $this->agent->agent_string();        
	        $browser = $this->agent->browser().' '.$this->agent->version();
	        
	        $robot = $this->agent->robot();
	        $mobile = $this->agent->mobile();
			$platform =  $this->agent->platform(); 

			$is_browser=  $this->agent->is_browser();
			$is_robot = $this->agent->is_robot();
	        $is_mobile = $this->agent->is_mobile();
			
	        
	        $table ="";
	        $is_robot=  $this->get_valor_numerico_bool($is_robot);
	        $is_mobile =  $this->get_valor_numerico_bool($is_mobile);
	        if ($is_robot ==  1){
	        	$table = "pagina_web_bot";	
	        }else{
	        	$table = "pagina_web";
	        }


	        $url_referencia = "";
	        
	        if(isset( $_SERVER['HTTP_REFERER'] ) ){	            
	            $url_referencia  = strtolower( $_SERVER['HTTP_REFERER'] ); 	           
	        }
	        $flag_enid =1;
	        $dominio =  get_dominio($pagina_url);

	        if ($dominio != "enidservice.com"){

	        	$flag_enid =0;
	        }	        

	        $query_insert =  "INSERT INTO $table(
			                      url,             
			                      ip ,            
			                      dispositivo , 
			                      tipo , 
			                      id_evento , 
			                      id_usuario , 
			                      id_empresa, 
			                      url_referencia ,
			                      dominio, 
			                      flag_enid,
			                      browser,
								  robot,
							 	  mobile, 
								  platform,
								  is_browser,
								  is_robot,
								  is_mobile
			                )
			                VALUES( 
	                        	'".$pagina_url."'  ,
	                        	'".$ip."'  , 
	                        	'".$dispositivo."'  , 
	                        	'". $tipo ."'  ,  
	                        	$id_evento , 
	                        	$id_usuario , 
	                        	$id_empresa, 
	                        	'".$url_referencia."', 
	                        	'".$dominio."' , 
	                        	'".$flag_enid."',
	                        	'".$browser."' ,
	                        	'".$robot."' ,
	                        	'".$mobile."' ,
	                        	'".$platform."' ,
	                        	'".$is_browser."' ,
								'".$is_robot."' ,
								'".$is_mobile."' 
                        	)"; 
      		return  $this->db->query($query_insert);
      	}



		/**/
		function show_data_page($data, $center_page , $tema = 0 ){           

	            $this->load->view("../../../view_tema/header_template", $data);
	            $this->load->view($center_page , $data);            
	            $this->load->view("../../../view_tema/footer_template", $data);
	                            
	    }
	    /**/
	    /*
	 	function isuserexistrecord($mail, $secret){

		        $responsedb = $this->enidmodel->validauserrecord($mail , $secret);
		        
		        if (count($responsedb) == 1){
		        
		                $responsedb =  $responsedb[0];                                
		                $id_usuario = $responsedb["idusuario"];
		                $nombre = $responsedb["nombre"];
		                $email =  $responsedb["email"];                
		                $fecha_registro = $responsedb["fecha_registro"]; 
		        
		            return $this->createsession($id_usuario, $nombre , $email);            

		        }else{
		    
		            return "Error en en los datos de acceso"; 
		        }               
	    } */
	    /**/  
    	function createsession($id_usuario, $nombre , $email){
	      
	        $id_empresa =  $this->enidmodel->getidempresabyidusuario($id_usuario); 
	        $info_empresa =  $this->enidmodel->get_info_empresa($id_empresa);
	        $id_perfil =  $this->enidmodel->getperfiluser($id_usuario); 	        
	        $perfildata =  $this->enidmodel->getperfildata($id_usuario); 
	        $empresa_permiso =  $this->enidmodel->get_empresa_permiso($id_empresa);
	        $empresa_recurso =  $this->enidmodel->get_empresa_recurso($id_empresa);         
	        $data_navegacion =  $this->enidmodel->display_recursos_by_perfiles($id_perfil); 

	        $newdatasession = array(            
	            "idusuario" => $id_usuario , 
	            "nombre" => $nombre ,
	            "email" => $email ,            
	            "perfiles" => $id_perfil ,  
	            "perfildata" => $perfildata ,
	            "idempresa" => $id_empresa ,
	            "empresa_permiso" => $empresa_permiso , 
	            "empresa_recurso" => $empresa_recurso , 
	            "data_navegacion" =>  $data_navegacion ,            
	            "info_empresa" =>  $info_empresa ,            
	            'logged_in' => TRUE
	        );   

	        $this->session->set_userdata($newdatasession);                                          
	        return 1;
	    }    		
	}
?>
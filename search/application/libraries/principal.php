<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
	require "interfaces/iRegistro.php";
	class principal extends CI_Model implements  iRegistro{	 			
		
		function get_faqs_categoria($q , $in_session){

		
			$query_get ="SELECT titulo, id_faq  FROM faq WHERE id_categoria = '".$q."' AND status =1 ";
			$result =  $this->db->query($query_get);            				
			return $result->result_array();
		}	
		/**/
	    function get_planes_correos(){

	    	$query_get ="SELECT  
	    					id_servicio , 
	    					nombre_servicio 
	    					FROM  
	    					servicio 
	    					WHERE  
	    					nombre_servicio 
	    					LIKE '%Cuentas de correo -%'";

			$result =  $this->db->query($query_get);		    					
			return $result->result_array();			
		}
		/**/		
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
	}
?>
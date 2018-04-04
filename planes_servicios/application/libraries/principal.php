<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
	require "interfaces/iRegistro.php";
	class principal extends CI_Model implements  iRegistro{	 			
	
		/**/
		function create_ciclo_facturacion(){

			$query_get ="select * from ciclo_facturacion WHERE id_ciclo_facturacion!=5";
			$result = $this->db->query($query_get);
			return $result->result_array();
		}		
		/**/
		function get_tipo_proyectos(){
			$query_get =  "SELECT t.* FROM proyecto p  INNER JOIN tipo_negocio t ON 
							p.idtipo_negocio = t.idtipo_negocio 
							WHERE p.id_proyecto not in (1,2,3)
							GROUP BY t.idtipo_negocio ORDER BY t.nombre ASC"; 


			$result = $this->db->query($query_get);
			return $result->result_array();
		}
		/**/
		function get_fuentes(){

			$query_get = "SELECT * FROM fuente WHERE status = 1 ORDER BY nombre ASC";
			$result = $this->db->query($query_get);
			return $result->result_array();
		}
		/**/
		function get_servicios(){

			$query_get = "SELECT * FROM servicio";
			$result = $this->db->query($query_get);
			return $result->result_array();
		}
		/**/
		function get_tipos_negocios(){
		
			$query_get ="SELECT * FROM tipo_negocio WHERE status =1 AND prospeccion = 1 ORDER BY nombre DESC";
			$result =  $this->db->query($query_get);
			return $result->result_array();			
		}
		/**/
		function get_tipos_negocios_enid(){
		
			$query_get ="SELECT * FROM tipo_negocio";
			$result =  $this->db->query($query_get);
			return $result->result_array();			
		}
		/**/
		function get_telefonos_disponibles($_num , $flag ){

			$query_drop ="DROP TABLE IF EXISTS tmp_base_telefonica_$_num";
			$this->db->query($query_drop);

			if($flag == 0 ){

				$query_get = "CREATE TABLE tmp_base_telefonica_$_num AS 
							  SELECT COUNT(0)num_disponibles, idtipo_negocio 
							  FROM base_telefonica 
							  WHERE 
							  n_tocado = 0 
							  AND 
							  status =1 
							  GROUP BY 
							  idtipo_negocio";

				$this->db->query($query_get);
			}


		}
		/**/
		function get_tipos_negocios_base_telefonica(){

			$_num =  get_random();
			$this->get_telefonos_disponibles($_num , 0 );
		
			$query_get =    "SELECT t.* FROM tmp_base_telefonica_$_num b 
							INNER JOIN tipo_negocio t 
							ON b.idtipo_negocio =  t.idtipo_negocio 
							GROUP BY t.idtipo_negocio";
						
			$result =  $this->db->query($query_get);
			$data =  $result->result_array();			
			$this->get_telefonos_disponibles($_num , 1 );

			return $data;

		}
		/**/
		function get_estados(){

			$query_get ="SELECT * FROM estado";
			$result =  $this->db->query($query_get);
			return $result->result_array();
		}



		/**/
		function get_usuario_enid(){

			$query_get ="SELECT idusuario, nombre , email FROM usuario WHERE status = 1"; 	
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
	    /**/
	 	function isuserexistrecord($mail, $secret){

		        $responsedb = $this->enidmodel->validauserrecord($mail , $secret);
		        /*Validamos que exista el usuario en la db*/        
		        if (count($responsedb) == 1){
		            /*Crear session*/ 
		                $responsedb =  $responsedb[0];                                
		                $id_usuario = $responsedb["idusuario"];
		                $nombre = $responsedb["nombre"];
		                $email =  $responsedb["email"];                
		                $fecha_registro = $responsedb["fecha_registro"]; 
		            /*Response url*/        
		            return $this->createsession($id_usuario, $nombre , $email);            

		        }else{
		            /*Response data error*/        
		            return "Error en en los datos de acceso"; 
		        }               
	    }   
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
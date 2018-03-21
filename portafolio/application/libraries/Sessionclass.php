<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
class Sessionclass extends CI_Controller{
	function __construct(){
		parent::__construct();
		
	}
	/**/
	function is_logged_in(){			
		$is_logged_in = $this->session->userdata('logged_in');	
		if(!isset($is_logged_in) || $is_logged_in != true) {			
			return false;
		}
		return true;
	}	
	function logout(){				
		$this->session->sess_destroy();				
		redirect(base_url());
	}
	function getemailuser(){
		return $this->session->userdata('email');
	}	
	function getnombre(){
		return $this->session->userdata('nombre');
	}
	function getidusuario(){
		return $this->session->userdata('idusuario');
	}
	function getfecharegistro(){
		return $this->session->userdata('fecha_registro');
	}
	function getperfiles(){
		return $this->session->userdata('perfiles');	
	}
	function getidempresa(){
		
		return $this->session->userdata('idempresa');	
	}
	
	function getuserdataperfil(){
		return $this->session->userdata('perfildata');
	}	
	/*Nombre del perfil del usuario actual */
	function getnameperfilactual(){
		$dataperfil = $this->getuserdataperfil();
		$nombre ="";		
		foreach ($dataperfil as $row) {			
			$nombre = $row["nombreperfil"];
		}
		return $nombre;
	}
	/**/
	function get_empresa_permiso(){
		return $this->session->userdata('empresa_permiso');	
	}
	/**/
	function get_empresa_recurso(){
		return $this->session->userdata('empresa_recurso');	
	}
	/**/
	function get_user_data_navegacion(){
		return $this->session->userdata("data_navegacion");
	}



	/*Generamos menú*/
	function generadinamymenu(){
		
		$perfiles = $this->getperfiles();
		$data = $this->get_user_data_navegacion();

		$menu ='';
		$id_empresa = $this->getidempresa();		

		$flag = 0; 		
		foreach ($data as $row) {
			$nombre = $row["nombre"];
			$main_page = base_url($row["urlpaginaweb"]);	
			if ($nombre ==  "Empresa"  OR  $nombre == "Evaluar servicio" OR  $nombre == "Evaluar gustos musicales" ){
				$main_page = base_url($row["urlpaginaweb"])."/".$id_empresa;		
			}

			$icono = $row["iconorecurso"];
			
            $menu .= '<li>
	            		<a class="menu-enid" href="'. $main_page.'" >
	            			<i class="'.$icono.'" >
	            			</i> 	
		            		<span>
		            		 	' . $nombre . '
		            		</span>
	                    </a>
                    <ul class="sub-menu-list">';
                                
            $sub_paginas = $row["subpaginas"];
	        $subpaginasli = ''; 


	        if ($nombre ==  "Empresa" OR  $nombre == "Evaluar servicio" OR  $nombre == "Evaluar gustos musicales" ){
	        	$flag++;
	        }

	        foreach ($sub_paginas as $row) {
	        	
		        	if ($flag > 0 ) {
		        		$urlpag = base_url($row["urlpaginaweb"] ."/" . $id_empresa); 
		        		$flag =0;	

		        			$iconosub = $row["iconpermiso"];				        		        	
				        	$nombresubpage  = $row["nombrepermiso"];
							//$subpaginasli .= ' <li ><a href="'. $urlpag .'"> Acerca de tu empresa </a></li>';						
		        	}else{

		        			$urlpag = base_url($row["urlpaginaweb"] ); 
		        			$iconosub = $row["iconpermiso"];				        		        	
				        	$nombresubpage  = $row["nombrepermiso"];
							$subpaginasli .= ' <li ><a class="menu-enid" href="'. $urlpag .'"> '.$nombresubpage.'</a></li>';
		        	}
            }
	        $menu.= $subpaginasli;		           	    
		    $menu.= '</ul>
	        </li>';	

		}	
		return $menu;
	}
/**/
	
}
<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
class Sessionclass extends CI_Controller{
	function __construct(){
		parent::__construct();
		
	}
	/**/
	function get_info_empresa(){
		return $this->session->userdata('info_empresa');
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
		$b = 0;	
		foreach ($data as $row){


			$nombre = $row["nombre"];
			$id_recurso =  $row["idrecurso"];
			$url = $row["urlpaginaweb"];				
			$icono = $row["iconorecurso"];
			$descripcion = $row["descripcionrecurso"];
			//$extra = $row["extra"];			
			$extra ="";
			$order_negocio =  $row["order_negocio"];

			
			$style ="";
			if ( $order_negocio >9){
				$style ="style='background:rgb(2, 17, 29);' ";	
			}

			$menu .=  "
			<li>
                <a href='".$url."' class='black'>
                    <i class='".$icono."'>
                    </i>  
					".$nombre."
                </a>
			</li>";                        
			$b++;
		}	
		return $menu;
	}
/**/
	
}
<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');
class Sessionclass extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library("session");			
	}
	function set_userdata($session_data){
		$this->session->set_userdata($session_data);	
	}
	function get_info_empresa(){
		return $this->session->userdata('info_empresa');
	}
	function is_logged_in(){			
		$is_logged_in = $this->session->userdata('logged_in');	
		if(!isset($is_logged_in) || $is_logged_in != true) {			
			return false;
		}
		return true;
	}	
	function logout(){				
		$this->session->unset_userdata($this->session);
		$this->session->sess_destroy();				
		redirect("../../login");
	}
	function get_session($key){
		return $this->session->userdata($key);
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
		return $this->session->userdata('perfiles')[0]["idperfil"];  
	}
	function getidempresa(){
		
		return $this->session->userdata('idempresa');	
	}	
	function getuserdataperfil(){
		return $this->session->userdata('perfildata');
	}
	function getnameperfilactual(){
		$dataperfil = $this->getuserdataperfil();
		$nombre     =   "";
		foreach ($dataperfil as $row) {			
			$nombre = $row["nombreperfil"];
		}
		return $nombre;
	}
	function get_empresa_permiso(){
		return $this->session->userdata('empresa_permiso');	
	}
	function get_empresa_recurso(){
		return $this->session->userdata('empresa_recurso');	
	}
	function get_user_data_navegacion(){
		return $this->session->userdata("data_navegacion");
	}
	function create_contenido_menu(){
		

		$data 		= 	$this->get_user_data_navegacion();
		$menu 		=	'';
		$id_empresa = 	$this->getidempresa();
		$b 			= 	0;	
		foreach ($data as $row) {

			$nombre 	= $row["nombre"];
			$id_recurso =  $row["idrecurso"];
			$url 		= base_url($row["urlpaginaweb"]);	
			if ($id_recurso ==  18 ){
				$url = base_url($row["urlpaginaweb"])."/?q=".$id_empresa;	
			}

			$icono 			= 	$row["iconorecurso"];
			$menu .= 	li(
							anchor_enid(icon($icono). $nombre , 
							[
								"href"=> $url ,  
								"class"=>'black'
							]));
			
			$b++;
		}	
		return $menu;
	}
}
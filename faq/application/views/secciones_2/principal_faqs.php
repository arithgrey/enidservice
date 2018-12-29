<?php  
	if ($flag_categoria ==  0 && $flag_busqueda_q ==  0) {		
		$this->load->view("secciones_2/categorias");				
	}else if($flag_categoria ==  1){
		$this->load->view("secciones_2/faqs_categorias");
	}else{}
	
	if($flag_busqueda_q ==  1){		
		$this->load->view("secciones_2/respuesta");
	}






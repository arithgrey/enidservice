<?php
if ($flag_categoria < 1 && $flag_busqueda_q < 1) {
	$this->load->view("secciones_2/categorias");
} else if ($flag_categoria > 0 ) {
	echo  get_format_faq_categorias($faqs_categoria);
} else {
}
if ($flag_busqueda_q >  0) {
	echo get_formar_respuesta($respuesta , $in_session, $perfil);
}






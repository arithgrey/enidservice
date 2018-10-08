<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="<?=base_url('application')?>/js/summernote.js"></script>
	<div class="panel-heading">
		 <ul class="nav nav-tabs">
		   	<li class="li_menu active">  
		      <?=anchor_enid("General" .icon("fa fa-question-circle") , ["href"=>"#tab_faq_general", "data-toggle"=>"tab", "aria-expanded"=>"false"])?>
		  	</li>
		  	<li class="btn_img_avanzado li_menu " style="display: none;">
		  		<?=anchor_enid("Avanzado" . icon("fa fa-plus-circle") , [
		  			"href"			=>	"#tab_faq_avanzado" ,
				    "class"			=>	"btn_img_avanzado" ,
				    "id"				=>	"enviados_a_validacion" ,
				    "data-toggle"		=>	"tab" ,
				    "aria-expanded"	=>	"true"
		  		])?>
		  	</li>     
		 </ul>
	</div>

 							<div class="panel-body">
                                <div class="tab-content">
									<?=place("",  ["id"=>'info_articulo'])?>
                                    <div class="tab-pane fade in active" id="tab_faq_general">
                                    	<form class="form_respuesta" id='form_respuesta'>
											<?=label("Categoria")?>
											<?=create_select($lista_categorias , "categoria" , "form-control categoria" , "categoria" , 
											"nombre_categoria", "id_categoria" );?>
											<?=label("Tipo")?>
											<select class="form-control tipo_respuesta" name='status' >
												<option value="1">
													Pública
												</option>
												<option value="0">
													Privada
												</option>
												<option value="2">
													Solo para labor de venta
												</option>
												<option value="3">
													Pos venta
												</option>
											</select>
											<?=label("Pregunta frecuente")?>
											<?=input(["type"=>"text" , "name"=>"titulo",  "class"=>'form-control titulo',  "required" => true])?>
											<?=label("Respuesta")?>
											<?=div("-" , ["id"=>"summernote"])?>
											<?=guardar("Registrar" , ["class"=>"btn" , "type"=>"submit"] )?>
										</form>
										<?=place("place_refitro_respuesta")?>
                                    </div>
                                    <div class="tab-pane fade" id="tab_faq_avanzado">
										<?=place("place_img_actual_faq")?>
										<?=label("Pre view")?>
										<?=place("place_load_img_faq")?>
                                    </div>                                              
                                </div>
                            </div>     






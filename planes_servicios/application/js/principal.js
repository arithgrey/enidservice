var servicio = 0;
var grupo = 0;
var contenido_mensaje = "";
var nombre_servicio = "";
var padre = 0;
var nivel = "";
var id_clasificacion = 0;
var costo = 0;
var ciclo_facturacion = 5;
var q_action = 0;
var id_imagen = 0;
var q = 0;
var nuevo = 0;
var flag_nueva_categoria = 0;
var producto_nuevo = 0;
var envio_incluido = 0;
var cantidad = 0;
var seccion_recorrido = 0;

$(document).ready(function() {
	
	set_option("is_mobile" ,$(".es_movil").val());
	set_option("page", 1);	
	$("footer").ready(valida_action_inicial);
	$(".btn_servicios").click(carga_servicios);	
	$(".tipo_promocion").click(configuracion_inicial);
	$(".form_nombre_producto").submit(simula_envio);
	$(".btn_agregar_servicios").click(function(){
		showonehideone(".contenedor_nombre", ".contenedor_categorias");
		set_option("nuevo", 1);		
		$(".texto_ventas_titulo").show();
	});
	$(".li_menu_servicio").click(function() {
		$(".btn_agregar_servicios").show();
		$(".contenedor_top").show();
	});
	/**/	
	$(".contenedor_busqueda_global_enid_service").hide();
	$(".ci_facturacion").change(evalua_precio);
	$(".cancelar_registro").click(cancelar_registro);
	set_option("selected_2" , 0);
	set_option("selected_3" , 0);
	set_option("selected_4" , 0);
	set_option("selected_5" , 0);
	set_option("selected_6" , 0);
	set_option("selected_7" , 0);

	set_option("primer_nivel", 0);
	set_option("segundo_nivel", 0);
	set_option("tercer_nivel", 0);
	set_option("cuarto_nivel", 0);
	set_option("quinto_nivel", 0);
	
});
/**/
function cancelar_carga_imagen(){
	showonehideone( ".contenedor_global_servicio" , ".contenedor_agregar_imagenes");	
}
/**/
function cancelar_registro(){	
	showonehideone(".contenedor_agregar_servicio_form" ,".contenedor_categorias_servicios");
}
/**/
function carga_servicios() {

	$(".texto_ventas_titulo").show();
	$(".contenedor_busqueda").show();

	url = "../tag/index.php/api/producto/servicios_empresa/format/json/";
	orden =  $("#orden").val();	
	data_send = {
		"q" : get_q(),
		"id_clasificacion" : get_option("id_clasificacion"),
		"page" : get_option("page"),
		"order": orden
	}
	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_servicios", "Cargando ... ", 1);
		}
	}).done(
			function(data) {

				if (data.num_servicios != undefined) {
					llenaelementoHTML(".place_servicios", data.info_servicios);
				} else {

					llenaelementoHTML(".place_servicios", data);
					$(".pagination > li > a, .pagination > li > span").click(
							function(e) {

								var page_html = $(this);
								num_paginacion = $(page_html).attr(
										"data-ci-pagination-page");
								/**/

								if (validar_si_numero(num_paginacion) == true) {
									set_option("page", num_paginacion);
								} else {
									num_paginacion = $(this).text();
									set_option("page", num_paginacion);
								}
								carga_servicios();
								e.preventDefault();
							});

					$(".servicio").click(carga_info_servicio);

				}

			}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
}
/**/
function carga_info_servicio(e) {

	servicio = e.target.id;
	set_option("servicio", servicio);

	if (get_option("servicio") > 0) {
		carga_informacion_servicio(1);
	}
}
/**/
function carga_informacion_servicio(num) {

	$(".contenedor_busqueda").hide();
	url = "../base/index.php/api/servicio/especificacion/format/json/";
	data_send = {
		servicio : get_option("servicio"),
		"num" : num
	}

	$.ajax({
				url : url,
				type : "GET",
				data : data_send,
				beforeSend : function() {					
					$(".texto_ventas_titulo").hide();
				}
			})
			.done(
					function(data) {

						
						llenaelementoHTML(".place_servicios", data);

						$(".cancelar_carga_imagen").click(cancelar_carga_imagen);
						$(".menu_meta_key_words").click(carga_sugerencias_meta_key_words);
						$(".agregar_img_servicio").click(carga_form_img);						
						/**/
						$(".text_costo").click(muestra_input_costo);
						$(".text_ciclo_facturacion").click(
								muestra_select_ciclo_facturacion);
						$(".text_nombre_servicio").click(
								muestra_seccion_nombre_servicio);
						$(".text_desc_servicio").click(
								muestra_seccion_desc_servicio);
						$(".text_porcentaje_ganancia").click(
								muestra_seccion_porcentaje_ganancia);
						$(".text_porcentaje_ganancias_afiliados").click(
								muestra_seccion_porcentaje_ganancia_afiliados);
						$(".text_video_servicio").click(
								muestra_seccion_video_servicio);
						$(".text_url_facebook").click(
								muestra_seccion_video_servicio_facebook);
						$(".text_info_envio")
								.click(muestra_input_incluye_envio);
						/**/
						$(".text_pagina_venta").click(
								muestra_seccion_url_pagina_web);
						/**/
						$(".form_costo").submit(registra_costo_servicio);
						/**/
						$(".form_ciclo_facturacion").submit(
								registrar_ciclo_facturacion);
						$(".form_servicio_nombre_info").submit(
								actualiza_dato_servicio);
						/**/
						$(".form_servicio_url_venta").submit(
								actualiza_dato_url_venta);
						/**/
						$(".form_servicio_afiliados").submit(
								actualiza_dato_servicio_afiliado);
						$(".form_servicio_desc").submit(
								actualiza_dato_servicio_desc);
						/**/
						$(".form_servicio_youtube").submit(
								actualiza_dato_servicio_youtube);
						$(".form_servicio_facebook").submit(
								actualiza_dato_servicio_facebook);
						/**/
						$(".foto_producto").click(elimina_foto_producto);
						/**/
						$(".form_tag").submit(agrega_metakeyword);
						
						/**/
						$(".text_nuevo").click(muestra_input_producto_nuevo);
						$(".text_ciclo_facturacion").click(
								muestra_input_ciclo_facturacion);
						$(".text_cantidad").click(muestra_input_cantidad);

						$(".btn_guardar_producto_nuevo").click(
								actualiza_servicio_usado);
						$(".btn_guardar_ciclo_facturacion").click(
								actualiza_ciclo_facturacion);
						$(".btn_guardar_cantidad_productos").click(
								actualiza_cantidad);
						/**/
						$(".text_incluye_envio").click(
								muestra_input_incluye_envio);
						$(".btn_guardar_envio").click(actualiza_envio_incluido);
						/* Recorremos a la sección de categorias */
						if (get_flag_nueva_categoria() == 1) {
							recorrepage("#seccion_metakeywords_servicio");
						}
						/**/
						$(".text_agregar_color").click(muestra_input_color);
						$(".elimina_color").click(elimina_color_servicio);

						if (get_option("flag_recorrido") != undefined) {
							recorrepage(get_option("seccion_a_recorrer"));
						}
						$('#summernote').summernote();
						$(".entregas_en_casa").click(u_entregas_en_casa);
						$(".telefono_visible").click(u_telefono_visible);
						$(".venta_mayoreo").click(u_ventas_mayoreo);
					}).fail(function() {
				show_error_enid(".place_servicios", "Error ... ");
			});
}
/**/
function u_entregas_en_casa(e){

	url =  "../base/index.php/api/servicio/entregas_en_casa/format/json/";	
	data_send  = {entregas_en_casa : e.target.id , servicio : get_option("servicio")};
	$.ajax({
		url : url , 
		type: "PUT",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".place_sobre_el_negocio" , "Cargando ... ");
		}
	}).done(function(data){													
		carga_informacion_servicio(4);
	}).fail(function(){
		//show_error_enid(".place_direccion_envio" , "Error ... al cargar portafolio.");
	});
}
/**/
function u_telefono_visible(e){	
	url =  "../base/index.php/api/servicio/telefono_visible/format/json/";	
	data_send  = {telefono_visible : e.target.id , servicio : get_option("servicio")};	
	$.ajax({
		url : url , 
		type: "PUT",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".place_sobre_el_negocio" , "Cargando ... ");
		}
	}).done(function(data){			

		carga_informacion_servicio(4);

	}).fail(function(){});	
}
/**/
function u_ventas_mayoreo(e){
	url =  "../base/index.php/api/servicio/ventas_mayoreo/format/json/";	
	data_send  = {venta_mayoreo : e.target.id , servicio : get_option("servicio")};	
	$.ajax({
		url : url , 
		type: "PUT",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".place_sobre_el_negocio" , "Cargando ... ");
		}
	}).done(function(data){			

		carga_informacion_servicio(4);
	}).fail(function(){
		//show_error_enid(".place_direccion_envio" , "Error ... al cargar portafolio.");
	});	
}
/**/
function muestra_input_costo() {

	visible = $(".text_costo").is(":visible");
	if (visible == true) {
		showonehideone(".input_costo", ".text_costo");
	} else {
		showonehideone(".input_costo", ".text_costo");
	}
}
/**/
function muestra_input_producto_nuevo() {

	visible = $(".text_nuevo").is(":visible");
	if (visible == true) {
		showonehideone(".input_nuevo", ".text_nuevo");
	} else {
		showonehideone(".input_nuevo", ".text_nuevo");
	}
}
function muestra_input_ciclo_facturacion() {

	visible = $(".text_ciclo_facturacion").is(":visible");
	if (visible == true) {
		showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
	} else {
		showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
	}
}
/**/
function muestra_input_cantidad() {

	visible = $(".text_cantidad").is(":visible");
	if (visible == true) {
		showonehideone(".input_cantidad", ".text_cantidad");
	} else {
		showonehideone(".input_cantidad", ".text_cantidad");
	}
}
function muestra_input_incluye_envio() {

	visible = $(".contenedor_informacion_envio").is(":visible");
	if (visible == true) {
		showonehideone(".input_envio", ".contenedor_informacion_envio");
	} else {
		showonehideone(".input_envio", ".contenedor_informacion_envio");
	}
}

/**/
function muestra_select_ciclo_facturacion(e) {

	id_ciclo_facturacion = e.target.id;
	set_option("id_ciclo_facturacion", id_ciclo_facturacion);

	visible = $(".text_ciclo_facturacion").is(":visible");
	if (visible == true) {
		showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
	} else {
		showonehideone(".input_ciclo_facturacion", ".text_ciclo_facturacion");
	}
}
/**/
function muestra_seccion_nombre_servicio(e) {

	/**/
	visible = $(".text_nombre_servicio").is(":visible");
	if (visible == true) {
		showonehideone(".input_nombre_servicio_facturacion",
				".text_nombre_servicio");
	} else {
		showonehideone(".input_nombre_servicio_facturacion",
				".text_nombre_servicio");
	}
}
/**/
function muestra_seccion_video_servicio() {
	/**/
	visible = $(".text_video_servicio").is(":visible");
	if (visible == true) {
		showonehideone(".input_url_youtube", ".text_video_servicio");
	} else {
		showonehideone(".input_url_youtube", ".text_video_servicio");
	}
}
/**/
function muestra_seccion_video_servicio_facebook() {

	visible = $(".text_video_servicio_facebook").is(":visible");
	if (visible == true) {
		showonehideone(".input_url_facebook", ".text_video_servicio_facebook");
	} else {
		showonehideone(".input_url_facebook", ".text_video_servicio_facebook");
	}
}
/**/
function muestra_seccion_desc_servicio(e) {
	/**/
	visible = $(".text_desc_servicio").is(":visible");
	if (visible == true) {
		showonehideone(".input_desc_servicio_facturacion",
				".text_desc_servicio");
	} else {
		showonehideone(".input_desc_servicio_facturacion",
				".text_desc_servicio");
	}
}
/**/
function muestra_input_color(e) {
	/**/
	visible = $(".text_agregar_color").is(":visible");
	if (visible == true) {
		showonehideone(".input_servicio_color", ".text_agregar_color");
		carga_listado_colores();
	} else {
		showonehideone(".input_servicio_color", ".text_agregar_color");
	}
}
/**/
function registra_costo_servicio(e) {

	url = "../base/index.php/api/servicio/costo/format/json/";
	data_send = $(".form_costo").serialize() + "&" + $.param({
		"servicio" : get_option("servicio")
	});
	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(4);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}

/**/
function actualiza_dato_servicio(e) {

	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $(".form_servicio_nombre_info").serialize() + "&" + $.param({
		"servicio" : get_option("servicio")
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}
/**/
function actualiza_dato_url_venta(e) {
	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $(".form_servicio_url_venta").serialize() + "&" + $.param({
		"servicio" : get_option("servicio")
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function(){}
	}).done(function(data) {

		carga_informacion_servicio(1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();

}

/**/
function actualiza_dato_servicio_afiliado(e) {

	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $(".form_servicio_afiliados").serialize() + "&" + $.param({
		"servicio" : get_option("servicio")
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}
/**/
function valida_url_youtube() {

	url = $(".url_youtube").val();
	text_youtube = "youtu";
	/**/
	input = ".url_youtube";
	place_msj = ".place_url_youtube";
	mensaje_user = "Url no valida!, ingrese url de youtube <span class='url_youtube_alert'><i class='fa fa-youtube-play'></i> Youtube! </span>";

	if (url.indexOf(text_youtube) != -1) {

		$(place_msj).empty();
		return 1;
	} else {

		$(input).css("border", "1px solid rgb(13, 62, 86)");
		llenaelementoHTML(place_msj, "<span class='alerta_enid'>"
				+ mensaje_user + "</span>");
		return 0;
	}

}
/**/
function actualiza_dato_servicio_youtube(e) {

	if (valida_url_youtube() == 1) {
		/* Validamos que la url realmente sea de youtube */
		url = "../base/index.php/api/servicio/q/format/json/";
		data_send = $(".form_servicio_youtube").serialize() + "&" + $.param({
			"servicio" : get_option("servicio")
		});
		$.ajax({
			url : url,
			type : "PUT",
			data : data_send,
			beforeSend : function() {
				// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
			}
		}).done(function(data) {

			carga_informacion_servicio(1);

		}).fail(function() {
			show_error_enid(".place_servicios", "Error ... ");
		});
	}
	e.preventDefault();
}
/**/
function actualiza_dato_servicio_facebook(e) {
	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $(".form_servicio_facebook").serialize() + "&" + $.param({
		"servicio" : get_option("servicio")
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}
/**/
function actualiza_dato_servicio_desc(e) {

	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $(".form_servicio_desc").serialize() + "&" + $.param({
		"servicio" : get_option("servicio"),
		"q2" : $(".note-editable").html()
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
		}
	}).done(function(data) {
		carga_informacion_servicio(2);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}
/**/
function registrar_ciclo_facturacion(e) {

	url = "../base/index.php/api/servicio/ciclo_facturacion/format/json/";
	data_send = $(".form_ciclo_facturacion").serialize() + "&" + $.param({
		"servicio" : get_option("servicio")
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(4);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}
/**/
function carga_grupos() {

	url = "../base/index.php/api/servicio/grupos/format/json/";
	data_send = {}

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_grupos", "Cargando ... ", 1);
		}
	}).done(function(data) {

		llenaelementoHTML(".place_grupos", data);

		$(".grupo").change(function() {

			nuevo_grupo = $(".grupo").val();
			set_grupo(nuevo_grupo);
			carga_info_grupos();
		});

		carga_info_grupos();
		//

	}).fail(function() {
		show_error_enid(".place_grupos", "Error ... ");
	});
}
/**/
function carga_info_grupos() {

	/** ** */
	grupo = get_grupo();
	if (grupo == 0) {
		grupo = $(".grupo").val();
		set_grupo(grupo);
	}
	/**/
	url = "../base/index.php/api/servicio/grupo/format/json/";
	data_send = {
		grupo : get_grupo()
	}

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_info_grupos", "Cargando ... ", 1);
		}
	}).done(function(data) {

		llenaelementoHTML(".place_info_grupos", data);
		$(".servicio").click(carga_info_servicio);
		/**/
		$(".nuevo_grupo_servicios").click(carga_form_nuevo_grupo);
		$(".agregar_servicios_grupo").click(agregar_servicio_grupo);

	}).fail(function() {
		show_error_enid(".place_info_grupos", "Error ... ");
	});
}
/**/
function get_grupo() {
	return grupo;
}
/***/
function set_grupo(n_grupo) {
	grupo = n_grupo;
}
/**/
function carga_form_nuevo_grupo() {

	url = "../base/index.php/api/servicio/grupo_form/format/json/";
	data_send = {}

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_info_grupos", "Cargando ... ", 1);
		}
	}).done(function(data) {

		llenaelementoHTML(".place_grupos", data);

		$(".form_grupo_sistema").submit(agregar_grupo_sistema);
	}).fail(function() {
		show_error_enid(".place_info_grupos", "Error ... ");
	});
}

function agregar_grupo_sistema(e) {

	url = "../base/index.php/api/servicio/grupo_form/format/json/";
	data_send = $(".form_grupo_sistema").serialize();

	$.ajax({
		url : url,
		type : "POST",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_info_grupos", "Cargando ... ", 1);
		}
	}).done(function(data) {

		set_grupo(data);
		carga_grupos();
		carga_info_grupos();

	}).fail(function() {
		show_error_enid(".place_info_grupos", "Error ... ");
	});
	e.preventDefault();
}
/**/
function agregar_servicio_grupo(e) {

	$("#seccion_izquierda_grupos").removeClass("col-lg-11");
	$("#seccion_izquierda_grupos").addClass("col-lg-6");
	$("#seccion_derecha_grupos").removeClass("col-lg-1");
	$("#seccion_derecha_grupos").addClass("col-lg-6");

	cargar_lista_servicios_grupo();
}
/**/
function cargar_lista_servicios_grupo() {

	url = "../base/index.php/api/servicio/servicios_grupo/format/json/";
	data_send = {
		grupo : get_grupo()
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_servicios_en_grupos", "Cargando ... ", 1);
		}
	}).done(function(data) {

		llenaelementoHTML(".place_servicios_en_grupos", data);
		$(".grupo_servicio").click(agrega_quita_servicio_grupo);

	}).fail(function() {
		show_error_enid(".place_servicios_en_grupos", "Error ... ");
	});
}
/**/
function agrega_quita_servicio_grupo(e) {
	id_servicio = e.target.id;
	set_option("servicio", id_servicio);
	/**/
	data_send = $.param({
		"servicio" : get_option("servicio"),
		"grupo" : get_grupo()
	});
	url = "../base/index.php/api/servicio/servicio_grupo/format/json/";

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
		}
	}).done(function(data) {
		/**/
		carga_grupos();
	}).fail(function() {
		show_error_enid(".place_servicios_en_grupos", "Error ... ");
	});
}
/**/
function muestra_seccion_url_pagina_web() {
	/**/
	visible = $(".text_pagina_venta").is(":visible");
	if (visible == true) {
		showonehideone(".input_url_pagina_web", ".text_pagina_venta");
	} else {
		showonehideone(".input_url_pagina_web", ".text_pagina_venta");
	}
}
/**/
function muestra_seccion_porcentaje_ganancia() {

	visible = $(".text_porcentaje_ganancia").is(":visible");
	if (visible == true) {
		showonehideone(".input_porcentaje_ganancia",
				".text_porcentaje_ganancia");
	} else {
		showonehideone(".input_porcentaje_ganancia",
				".text_porcentaje_ganancia");
	}
}
/**/
function muestra_seccion_porcentaje_ganancia_afiliados() {

	visible = $(".text_porcentaje_ganancias_afiliados").is(":visible");
	if (visible == true) {
		showonehideone(".input_porcentaje_ganancia_afiliados",
				".text_porcentaje_ganancias_afiliados");
	} else {
		showonehideone(".input_porcentaje_ganancia_afiliados",
				".text_porcentaje_ganancias_afiliados");
	}
}
/**/

/**/
function configuracion_inicial(e) {


	set_option("modalidad", e.target.id);
	if (get_option("modalidad") == 1) {

		set_option("id_ciclo_facturacion", 9);
		$(".text_modalidad").text("Servicio");
		$(".tipo_producto").css("color", "black");
		$(".tipo_servicio").css("color", "blue");
		$(".contenedor_ciclo_facturacion").show();
		selecciona_select(".ci_facturacion", 9);	
		$(".precio").val(0);
		$(".contenedor_precio").hide();
		$(".siguiente_btn").show();

	}else{

		set_option("id_ciclo_facturacion", 5);
		$(".text_modalidad").text("Artículo/Producto");
		$(".tipo_producto").css("color", "blue");
		$(".tipo_servicio").css("color", "black");
		$(".contenedor_ciclo_facturacion").hide();
		$(".contenedor_precio").show();
	}
}
/**/
function simula_envio(e) {

	costo = $(".costo").val();
	next =  (get_option("modalidad") == 0 && costo == 0)?0:1; 
	
	if (next) {
		showonehideone(".contenedor_categorias", ".contenedor_nombre");
		$(".contenedor_top").hide();
		set_nombre_servicio($(".nuevo_producto_nombre").val());
		set_costo(costo);
		$(".extra_precio").text("");		
		verifica_existencia_categoria();
	}else{
		$("#costo").css("border" , "1px solid rgb(13, 62, 86)");
		$(".extra_precio").text("INGRESA EL PRECIO DEL PRODUCTO");
	}
	e.preventDefault();
}
function verifica_existencia_categoria(){
	
	
	var url ="../base/index.php/api/servicio/verifica_existencia_clasificacion/format/json/";	
	nombre =  $(".nuevo_producto_nombre").val();
	data_send =  {clasificacion : nombre , servicio : get_option("modalidad")};
	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			
		}
	}).done(listar_categorias);

	
}
function listar_categorias(data){
	
	

	if (data.total >0) {
		cat =  data.categorias;
		if (cat[1].nivel != undefined && cat[1].nivel ==  1) {
			data =  cat;
			for(var a in data ){
				nivel =  parseInt(data[a].nivel);
				id_clasificacion =  parseInt(data[a].id_clasificacion); 
			
				switch(nivel) {
				    case 1:		 				 					 		
				    	set_option("selected_1" , 1);
				    	set_option("selected_num_1" , id_clasificacion);					    	
				 		carga_listado_categorias();    
						set_option("padre" , id_clasificacion);			 	
						
				        break;

				    case 2:
				  		set_option("selected_2" , 1);
				    	set_option("selected_num_2" , id_clasificacion);				
				  		carga_listado_categorias_segundo_nivel();      
				  		set_option("padre" , id_clasificacion);			 		
				  		set_option("segundo_nivel" , id_clasificacion);		
				        break;

				    case 3:
				    	set_option("selected_3" , 1);
				    	set_option("selected_num_3" , id_clasificacion);				
				  		carga_listado_categorias_tercer_nivel();
				  		set_option("padre" , id_clasificacion);			 				    	
				  		set_option("tercer_nivel" , id_clasificacion);		
				        break;

				    case 4:
				    	set_option("selected_4" , 1);
				    	set_option("selected_num_4" , id_clasificacion);				
				  		carga_listado_categorias_cuarto_nivel();
				  		set_option("padre" , id_clasificacion);			 				    	
				  		set_option("cuarto_nivel" , id_clasificacion);		
				        break;

				    default:
				        
				}		

			}
		}else{
			carga_listado_categorias();		
		}
	}else{
		carga_listado_categorias();		
	}
	
	
}
/**/
function get_nombre_servicio() {
	return nombre_servicio;
}
/**/
function set_nombre_servicio(n_nombre_servicio) {
	nombre_servicio = n_nombre_servicio;
	$(".nombre_producto").val(n_nombre_servicio);
}
function clean_data_categorias(){

	$(".segundo_nivel_seccion").empty();
	$(".tercer_nivel_seccion").empty();
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();	
	set_option("nivel" , 1);	
	set_option("padre", 0);
	showonehideone(".contenedor_categorias_servicios", ".contenedor_agregar_servicio_form");
}
/**/
function carga_listado_categorias() {

	nombre =  $(".nuevo_producto_nombre").val();
	clean_data_categorias();	
	data_send = {"modalidad" : get_option("modalidad"), "padre" : 0, "nivel" : get_option("nivel"), "is_mobile": get_option("is_mobile"), nombre:nombre};
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	
	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".primer_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(muestra_p_nivel);
	
}
function muestra_p_nivel(data){

	llenaelementoHTML(".primer_nivel_seccion", data);		
	if (get_option("selected_1") == 1) {
		$(".nivel_1 option[value='"+get_option("selected_num_1") +"']").attr("selected", true);		
	}

	set_option("primer_nivel" ,  $(".nivel_1 option").val());
	

	$(".primer_nivel_seccion .nivel_1").change(carga_listado_categorias_segundo_nivel);		
	$(".nueva_categoria_producto").click(agregar_categoria_servicio);
	add_cancelar_movil();
}
/**/
function carga_listado_categorias_segundo_nivel() {


	set_option("nivel" , 2);	
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	
	if (get_option("selected_2") == 0) {		
		n_padre = $(".nivel_1 option:selected").val();		
		set_option("padre" , n_padre);		
	}
	set_option("primer_nivel" , $(".nivel_1 option:selected").val());


	$(".segundo_nivel_seccion").empty();
	$(".tercer_nivel_seccion").empty();
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel"),
		"is_mobile": get_option("is_mobile")
	};
	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".segundo_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(muestra_s_nivel);

}
function muestra_s_nivel(data){

	llenaelementoHTML(".segundo_nivel_seccion", data);
	if (get_option("selected_2") == 1) {		
		$(".nivel_2 option[value='"+get_option("selected_num_2") +"']").attr("selected", true);
	}
	set_option("segundo_nivel" , $(".nivel_2 option:selected").val());

	$(".segundo_nivel_seccion .nivel_2").change(carga_listado_categorias_tercer_nivel);
	$(".nueva_categoria_producto").click(agregar_categoria_servicio);	
	add_cancelar_movil();
}
/**/
function carga_listado_categorias_tercer_nivel() {
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";	
	set_option("nivel" , 3);

	if (get_option("selected_3") == 0) {		
		n_padre= $(".nivel_2 option:selected").val();		
		set_option("padre" , n_padre);
	}
	
	set_option("segundo_nivel" , $(".nivel_2 option:selected").val());

	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" 	: get_option("padre"),
		"nivel" 	: get_option("nivel"),
		"is_mobile"	: get_option("is_mobile")
	};


	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".tercer_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(muestra_t_nivel);

}
function muestra_t_nivel(data){

	llenaelementoHTML(".tercer_nivel_seccion", data);

	if (get_option("selected_3") == 1 ) {		
		$(".nivel_3 option[value='"+get_option("selected_num_3") +"']").attr("selected", true);
	}
	$(".tercer_nivel_seccion .nivel_3").change(carga_listado_categorias_cuarto_nivel);	
	$(".nueva_categoria_producto").click(agregar_categoria_servicio);	
	add_cancelar_movil();
}
/**/
function carga_listado_categorias_cuarto_nivel() {

	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";	
	set_option("nivel" ,4);
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	if (get_option("selected_4") == 0) {		
		n_padre= $(".nivel_3 option:selected").val();		
		set_option("padre" , n_padre);
	}
	set_option("tercer_nivel" , $(".nivel_3 option:selected").val());


	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel"),
		"is_mobile": get_option("is_mobile")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".cuarto_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(muestras_c_nivel);

}
function muestras_c_nivel(data){

	llenaelementoHTML(".cuarto_nivel_seccion", data);
	if (get_option("selected_4") == 1) {		
		$(".nivel_4 option[value='"+get_option("selected_num_4") +"']").attr("selected", true);
	}
	$(".cuarto_nivel_seccion .nivel_4").change(carga_listado_categorias_quinto_nivel);
	$(".nueva_categoria_producto").click(agregar_categoria_servicio);
	recorrepage(".cuarto_nivel_seccion");
	add_cancelar_movil();
}
/**/
function carga_listado_categorias_quinto_nivel() {

	
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);
	set_option("nivel" , 5);
	$(".sexto_nivel_seccion").empty();	
	if (get_option("selected_5") == 0) {		
		n_padre= $(".nivel_4 option:selected").val();		
		set_option("padre" , n_padre);
	}
	set_option("cuarto_nivel" , $(".nivel_4 option:selected").val());
	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel"),
		"is_mobile": get_option("is_mobile")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".quinto_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(muestra_q_nivel);

}
/**/
function muestra_q_nivel(data){

	llenaelementoHTML(".quinto_nivel_seccion", data);
	$(".quinto_nivel_seccion .nivel_5").change(carga_listado_categorias_sexto_nivel);
	$(".nueva_categoria_producto").click(agregar_categoria_servicio);
	recorrepage(".quinto_nivel_seccion");
	add_cancelar_movil();
}
/**/
function carga_listado_categorias_sexto_nivel() {
	
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);
	set_option("nivel",6);
	$(".sexto_nivel").empty();
	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel"),
		"is_mobile": get_option("is_mobile")
	};
	set_option("quinto_nivel" , $(".nivel_5 option:selected").val());
	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".sexto_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(muestra_sexo_nivel);

}
/**/
function muestra_sexo_nivel(data){
	
	llenaelementoHTML(".sexto_nivel_seccion", data);	
	$(".nueva_categoria_producto").click(agregar_categoria_servicio);
	add_cancelar_movil();	
}
/**/
function agregar_categoria_servicio(e){

	id_categoria = e.target.id;
	set_option("id_clasificacion", id_clasificacion);
	if (get_option("modalidad") == 0) {
		set_option("id_ciclo_facturacion", 5);
	} else {
		set_option("id_ciclo_facturacion", $("#ciclo").val());
	}	
	registra_nuevo_servicio();	
}
/**/
function registra_nuevo_servicio() {

	url = "../base/index.php/api/servicio/nuevo/format/json/";

	
	var  data_send = {
		"nombre_servicio" 	: get_nombre_servicio(),
		"flag_servicio" 	: get_option("modalidad"),
		"precio" 			: get_costo(),
		"ciclo_facturacion" : get_option("id_ciclo_facturacion"),
		"primer_nivel" 		: get_option("primer_nivel"),
		"segundo_nivel" 	: get_option("segundo_nivel"),
		"tercer_nivel" 		: get_option("tercer_nivel"),
		"cuarto_nivel" 		: get_option("cuarto_nivel"),
		"quinto_nivel" 		: get_option("quinto_nivel")
	}

	console.log(data_send);
	$.ajax({
		url : url,
		type : "POST",
		data : data_send,
		beforeSend : function(){}
	}).done(status_registro);	
}
/**/
function status_registro(data){

	if (data.registro!=0){			
		if (data.registro.servicio>0) {
			set_option("servicio", data.registro.servicio);
			carga_informacion_servicio(1);
			document.getElementById("form_nombre_producto").reset();
			$("#tab_productividad").tab("show");
			$(".btn_serv").tab("show");
			$(".btn_agregar_servicios").show();
		}else{								
			redirect("../planes_servicios/?action=nuevo&mensaje="+data.registro.mensaje);				
		}
	}			
}
/**/
function set_costo(n_costo) {
	costo = n_costo;
}
/**/
function get_costo() {
	return costo;
}

/**/
function get_q_action() {
	return q_action;
}
/**/
function set_q_action(n_q_action) {
	q_action = n_q_action;
}
/**/
function elimina_foto_producto(e) {

	id_imagen = e.target.id;
	set_imagen(id_imagen);

	url = "../imgs/index.php/api/img_controller/imagen_servicio/format/json/";
	data_send = {
		"id_imagen" : get_imagen()
	}

	$.ajax({
		url : url,
		type : "DELETE",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_servicios", "Cargando ... ", 1);
		}
	}).done(function(data) {

		carga_informacion_servicio(1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});

}
/**/
function get_imagen() {
	return id_imagen;
}
/**/
function set_imagen(n_imagen) {
	id_imagen = n_imagen;
}
/**/
function agrega_metakeyword(e) {

	url = "../base/index.php/api/servicio/metakeyword_usuario/format/json/";
	data_send = $(".form_tag").serialize();
	$.ajax({
		url : url,
		type : "POST",
		data : data_send,
		beforeSend : function() {}
	}).done(function(data) {
		console.log(data);
		set_flag_nueva_categoria(1);
		carga_informacion_servicio(3);
		carga_sugerencias_meta_key_words();
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();
}
/**/
function eliminar_tag(text, id_servicio) {
	/**/
	url = "../base/index.php/api/servicio/metakeyword_usuario/format/json/";
	data_send = {
		"tag" : text,
		"id_servicio" : id_servicio
	};
	$.ajax({
		url : url,
		type : "DELETE",
		data : data_send,
		beforeSend : function() {
		}
	}).done(function(data) {
		/**/
		carga_informacion_servicio(3);
		carga_sugerencias_meta_key_words();
		/**/
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
}
/**/
function onkeyup_colfield_check(e) {
	var enterKey = 13;
	if (e.which == enterKey) {
		set_option("page", 1);
		carga_servicios();
	}
}
/**/
function get_q() {
	q = $(".q_emp").val();
	return q;
}
/***/
function set_flag_nueva_categoria(n_flag_nueva_categoria) {
	flag_nueva_categoria = n_flag_nueva_categoria;
}
/**/
function get_flag_nueva_categoria() {
	return flag_nueva_categoria;
}
/**/
function get_producto_nuevo() {
	return producto_nuevo;
}
/**/
function set_producto_nuevo(n_producto_nuevo) {
	producto_nuevo = n_producto_nuevo;
}
/**/
function get_envio_incluido() {
	return envio_incluido;
}
/**/
function set_envio_incluido(n_envio_incluido) {
	envio_incluido = n_envio_incluido;
}
/**/
function actualiza_servicio_usado() {

	set_producto_nuevo($(".producto_nuevo").val());
	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $.param({
		"servicio" : get_option("servicio"),
		"q2" : get_producto_nuevo(),
		"q" : "flag_nuevo"
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(4);
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});

}
/**/
function actualiza_envio_incluido() {

	set_envio_incluido($(".input_envio_incluido").val());
	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $.param({
		"servicio" : get_option("servicio"),
		"q2" : get_envio_incluido(),
		"q" : "flag_envio_gratis"
	});
	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {
		carga_informacion_servicio(4);
		set_option("flag_recorrido", 1);
		set_option("seccion_a_recorrer", ".text_info_envio");
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});

}
/**/
function actualiza_ciclo_facturacion() {

	set_option("id_ciclo_facturacion", $(".ciclo_facturacion").val());
	url = "../base/index.php/api/servicio/ciclo_facturacion/format/json/";
	data_send = $.param({
		"servicio" : get_option("servicio"),
		"ciclo_facturacion" : get_option("id_ciclo_facturacion")
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
		}
	}).done(function(data) {
		carga_informacion_servicio(4);
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();

}
/**/
function actualiza_cantidad() {

	set_option("existencia", $(".existencia").val());
	url = "../base/index.php/api/servicio/q/format/json/";
	data_send = $.param({
		"servicio" : get_option("servicio"),
		"q2" : get_option("existencia"),
		"q" : "existencia"
	});

	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		carga_informacion_servicio(4);
		set_option("seccion_a_recorrer", ".text_cantidad");
		set_option("flag_recorrido", 1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
	e.preventDefault();

}
/**/
function agrega_color_servicio(e) {

	color = e.target.id;
	set_option("color", color);

	data_send 		= $.param({
		"servicio" 	: get_option("servicio"),
		"color" 	: get_option("color")
	});
	url = "../base/index.php/api/servicio/color/format/json/";

	$.ajax({
		url : url,
		type : "POST",
		data : data_send,
		beforeSend : function() {
		}
	}).done(function(data) {
		carga_informacion_servicio(2);
		set_option("seccion_a_recorrer", "#contenedor_colores_disponibles");
		set_option("flag_recorrido", 1);
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});

}
/**/
function carga_listado_colores() {
	data_send = {};
	url = "../portafolio/index.php/api/proyecto/colores/format/json/";

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {

		llenaelementoHTML(".place_colores_disponibles", data);
		$(".colores").click(agrega_color_servicio);
		recorrepage("#seccion_colores_info");
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
}
/**/
function elimina_color_servicio(e) {

	color = e.target.id;
	set_option("color", color);
	data_send = $.param({
		"servicio" 	: get_option("servicio"),
		"color" 	: get_option("color")
	});
	url = "../base/index.php/api/servicio/color/format/json/";

	$.ajax({
		url : url,
		type : "DELETE",
		data : data_send,
		beforeSend : function() {
		}
	}).done(function(data) {

		carga_informacion_servicio(2);
		set_option("seccion_a_recorrer", "#contenedor_colores_disponibles");
		set_option("flag_recorrido", 1);

	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
}
/**/
function evalua_precio(){

	ci_facturacion = $(".ci_facturacion").val();
	switch (parseInt(ci_facturacion)) {
	case 9:
		$(".contenedor_precio").hide();
		$(".precio").val(0);
		break;
	case 5:
		$(".contenedor_precio").hide();
		$(".precio").val(0);
		break;
	default:
		$(".contenedor_precio").show();
	}
}
/**/
function valida_action_inicial(){


	es_movil= $(".es_movil").val();  	
	set_option("accion", $(".q_action").val());		
	switch (parseInt(get_option("accion"))){	
	case 2:		

		set_option("servicio", $(".extra_servicio").val());		
		carga_informacion_servicio(1);
		set_option("modalidad" , 1);
		set_option("nuevo", 0);
		break;

	case 1:		
		/*Si es version movil recorre pantalla*/
		if (es_movil == 1) {recorrepage(".text_deseas_anunciar")}
		set_option("modalidad" , 0);
		set_option("nuevo", 1);
		$(".contenedor_articulos_mobil").hide();
		break;
	case 0:				

		carga_servicios();
		set_option("modalidad" , 1);
		set_option("nuevo", 0);
		break;
	default:
		break;
	}	
}
/**/
function add_cancelar_movil(){

	$(".add_cancelar").empty();
	
	if (es_movil ==  1 && $(".nueva_categoria_producto").val() !== undefined) {
		btn_cancelar =  "<div class='cancelar_registro'>REGRESAR</div>";
		llenaelementoHTML(".add_cancelar" , btn_cancelar);
		$(".cancelar_registro").click(cancelar_registro);
	}
}
/**/
function carga_sugerencias_meta_key_words(){

	url = "../base/index.php/api/servicio/metakeyword_catalogo/format/json/";
	data_send =  {"v" : 1};
	$.ajax({
		url : url,
		type : "GET",
		data : data_send
	}).done(muestra_sugerencias_meta_key_words).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
}
/**/
function muestra_sugerencias_meta_key_words(data){
	
	llenaelementoHTML(".contenedor_sugerencias_tags" , data);	
	var tag_servicio_registrados = $('.tag_servicio');			
	var arr_registros = [];	 
	
	$.each( tag_servicio_registrados, function(i, val){
	    arr_registros.push( $(val).attr('id') );
	});

	if (arr_registros.length > 0){		
		var tag_sugerencias = $('.tag_catalogo');				
		var arr_sugerencias = [];	 
		var  x =0;

		$.each( tag_sugerencias, function(i, val){		    
		    for (var i = 0; i < arr_registros.length; i++) {
				if ($(val).attr('id') == arr_registros[i] ) {
					$(val).hide();					
				}		    	
		    }
		});
	}	
	$(".tag_catalogo").click(auto_complete_metakeyword);
}
/**/
function auto_complete_metakeyword(e){
	var tag =  e.target.id; 
	$(".metakeyword_usuario").val(tag);	
	$(".form_tag").submit();
}
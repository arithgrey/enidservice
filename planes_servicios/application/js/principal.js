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

	set_option("page", 1);	
	$("footer").ready(valida_action_inicial);
	$(".btn_servicios").click(carga_servicios);	
	$(".tipo_promocion").click(configuracion_inicial);
	$(".form_nombre_producto").submit(simula_envio);
	$(".btn_agregar_servicios").click(function() {
		showonehideone(".contenedor_nombre", ".contenedor_categorias");
		set_option("nuevo", 1);
		/**/
		$(".texto_ventas_titulo").show();
	});
	$(".li_menu_servicio").click(function() {
		$(".btn_agregar_servicios").show();
	});
	/*
	$(".li_menu_grupos").click(function() {
		$(".btn_agregar_servicios").hide();
	});
	*/
	
	$(".contenedor_busqueda_global_enid_service").hide();
	$(".ci_facturacion").change(evalua_precio);

});
function carga_servicios() {

	$(".texto_ventas_titulo").show();
	$(".contenedor_busqueda").show();
	url = "../tag/index.php/api/producto/servicios_empresa/format/json/";
	data_send = {
		"q" : get_q(),
		"id_clasificacion" : get_option("id_clasificacion"),
		"page" : get_option("page")
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
					// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
					$(".texto_ventas_titulo").hide();
				}
			})
			.done(
					function(data) {

						/**/
						llenaelementoHTML(".place_servicios", data);

						$(".agregar_img_servicio").click(carga_form_img);
						/*
						$(".btn_agregar_termino").click(
								lista_terminos_disponibles);
								
						$(".termino").click(asocia_termino_servicio);
						*/
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
						$(".editar_categorias_servicio").click(function() {
							set_option("nuevo", 0);
							carga_listado_categorias();
							recorrepage(".contenedor_cat");
						});

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
		carga_informacion_servicio(2);
	}).fail(function(){
		//show_error_enid(".place_direccion_envio" , "Error ... al cargar portafolio.");
	});
}
/*
function lista_terminos_disponibles() {

	url = "../base/index.php/api/servicio/terminos_servicios/format/json/";
	data_send = {
		servicio : get_option("servicio")
	}

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".place_servicios", "Cargando ... ", 1);
		}
	}).done(function(data) {

		llenaelementoHTML(".place_servicios", data);
		$(".form_termino_servicio").submit(agregar_termino_servicio);
		$(".termino").click(asocia_termino_servicio);
		$(".form_busqueda_termino").submit(busqueda_terminos);
	}).fail(function() {
		show_error_enid(".place_servicios", "Error ... ");
	});
}
*/
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
		$(".contenedor_precio").hide();
		$(".precio").val(0);

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

	carga_listado_categorias();
	/**/
	nombre_servicio = $(".nuevo_producto_nombre").val();
	costo = $(".costo").val();
	showonehideone(".contenedor_categorias", ".contenedor_nombre");
	set_nombre_servicio(nombre_servicio);
	set_costo(costo);

	e.preventDefault();
}
/**/
function get_nombre_servicio() {
	return nombre_servicio;
}
/***/
function set_nombre_servicio(n_nombre_servicio) {
	nombre_servicio = n_nombre_servicio;
	$(".nombre_producto").val(n_nombre_servicio);
}
/**/
function carga_listado_categorias() {

	$(".btn_agregar_servicios").hide();
	if (get_option("nuevo") == 1) {
		showonehideone(".contenedor_nombre", ".contenedor_categorias");
	} else {
		$(".contenedor_categorias").show();
	}

	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("nivel" , "primer_nivel");
	set_option("padre", 0);

	$(".segundo_nivel_seccion").empty();
	$(".tercer_nivel_seccion").empty();
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	$(".categorias_edicion .segundo_nivel_seccion").empty();
	$(".categorias_edicion .tercer_nivel_seccion").empty();
	$(".categorias_edicion .cuarto_nivel_seccion").empty();
	$(".categorias_edicion .quinto_nivel_seccion").empty();
	$(".categorias_edicion .sexto_nivel_seccion").empty();

	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".primer_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(
			function(data) {

				llenaelementoHTML(".primer_nivel_seccion", data);
				/* Carga categorias segundo nivel */
				$(".primer_nivel .num_clasificacion").click(carga_listado_categorias_segundo_nivel);
				$(".nueva_categoria_producto").click(agregar_categoria_servicio);

			}).fail(
			function() {
				show_error_enid(".primer_nivel_seccion",
						"Error ... al cargar portafolio.");
			});

}
/**/
function carga_listado_categorias_segundo_nivel(e) {
	padre = e.target.value;
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);	
	set_option("nivel" , "segundo_nivel");

	$(".tercer_nivel_seccion").empty();
	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();
	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".segundo_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(
			function(data) {

				llenaelementoHTML(".segundo_nivel_seccion", data);
				$(".segundo_nivel .num_clasificacion").click(carga_listado_categorias_tercer_nivel);
				$(".nueva_categoria_producto").click(agregar_categoria_servicio);

			}).fail(
			function() {
				show_error_enid(".segundo_nivel_seccion",
						"Error ... al cargar portafolio.");
			});

}
/**/
function carga_listado_categorias_tercer_nivel(e) {

	padre = e.target.value;
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);	
	set_option("nivel" , "tercer_nivel");
	
	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel")
	};

	$(".cuarto_nivel_seccion").empty();
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".tercer_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(
			function(data) {

				llenaelementoHTML(".tercer_nivel_seccion", data);
				$(".tercer_nivel .num_clasificacion").click(carga_listado_categorias_cuarto_nivel);
				$(".nueva_categoria_producto").click(agregar_categoria_servicio);

			}).fail(
			function() {
				show_error_enid(".tercer_nivel_seccion",
						"Error ... al cargar portafolio.");
			});

}
/**/
function carga_listado_categorias_cuarto_nivel(e) {

	padre = e.target.value;
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);
	set_option("nivel" ,"cuarto_nivel");
	$(".quinto_nivel_seccion").empty();
	$(".sexto_nivel_seccion").empty();

	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".cuarto_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(
			function(data) {

				llenaelementoHTML(".cuarto_nivel_seccion", data);
				$(".cuarto_nivel .num_clasificacion").click(carga_listado_categorias_quinto_nivel);
				$(".nueva_categoria_producto").click(agregar_categoria_servicio);

			}).fail(
			function() {
				show_error_enid(".cuarto_nivel_seccion",
						"Error ... al cargar portafolio.");
			});

}
/**/
function carga_listado_categorias_quinto_nivel(e) {

	padre = e.target.value;
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);
	set_option("nivel" , "quinto_nivel");
	$(".sexto_nivel_seccion").empty();

	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".quinto_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(
			function(data) {

				llenaelementoHTML(".quinto_nivel_seccion", data);
				$(".quinto_nivel .num_clasificacion").click(carga_listado_categorias_sexto_nivel);
				$(".nueva_categoria_producto").click(agregar_categoria_servicio);

			}).fail(
			function() {
				show_error_enid(".quinto_nivel_seccion",
						"Error ... al cargar portafolio.");
			});

}
function carga_listado_categorias_sexto_nivel(e) {

	padre = e.target.value;
	url = "../base/index.php/api/servicio/lista_categorias_servicios/format/json/";
	set_option("padre" , padre);
	set_option("nivel","sexto_nivel");
	$(".sexto_nivel").empty();
	data_send = {
		"modalidad" : get_option("modalidad"),
		"padre" : get_option("padre"),
		"nivel" : get_option("nivel")
	};

	$.ajax({
		url : url,
		type : "GET",
		data : data_send,
		beforeSend : function() {
			show_load_enid(".sexto_nivel_seccion", "Cargando ... ", 1);
		}
	}).done(function(data) {
		llenaelementoHTML(".sexto_nivel_seccion", data);
	}).fail(
			function() {
				show_error_enid(".sexto_nivel_seccion",
						"Error ... al cargar portafolio.");
			});

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
	
	if(get_option("nuevo") == 1) {
		registra_nuevo_servicio();
	} else {
		actualiza_categorias_servicio();
	}

}
/**/
function actualiza_categorias_servicio() {

	set_valores_categorias();
	data_send = {
		"primer_nivel" : get_categoria_primer_nivel(),
		"segundo_nivel" : get_categoria_segundo_nivel(),
		"tercer_nivel" : get_categoria_tercer_nivel(),
		"cuarto_nivel" : get_categoria_cuarto_nivel(),
		"quinto_nivel" : get_categoria_quinto_nivel(),
		"id_servicio" : get_option("servicio")
	};
	
	url = "../base/index.php/api/servicio/categorias/format/json/";
	$.ajax({
		url : url,
		type : "PUT",
		data : data_send,
		beforeSend : function(){}
	}).done(function(data) {
		carga_informacion_servicio(3);
	}).fail(function() {
		show_error_enid(".place_registro_servicio", "Error ... ");
	});

}
/**/
function registra_nuevo_servicio() {

	set_valores_categorias();
	/**/

	data_send = {
		"nombre_servicio" : get_nombre_servicio(),
		"flag_servicio" : get_option("modalidad"),
		"precio" : get_costo(),
		"ciclo_facturacion" : get_option("id_ciclo_facturacion"),
		"primer_nivel" : get_categoria_primer_nivel(),
		"segundo_nivel" : get_categoria_segundo_nivel(),
		"tercer_nivel" : get_categoria_tercer_nivel(),
		"cuarto_nivel" : get_categoria_cuarto_nivel(),
		"quinto_nivel" : get_categoria_quinto_nivel()
	};
	url = "../base/index.php/api/servicio/nuevo/format/json/";
	console.log(data_send);
	$.ajax({
		url : url,
		type : "POST",
		data : data_send,
		beforeSend : function() {

		}
	}).done(function(data) {

		console.log(data);

		set_option("servicio", data);
		carga_informacion_servicio(1);
		document.getElementById("form_nombre_producto").reset();

		$("#tab_productividad").tab("show");
		$(".btn_serv").tab("show");
		$(".btn_agregar_servicios").show();

	}).fail(function() {
		show_error_enid(".place_registro_servicio", "Error ... ");
	});

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
function set_valores_categorias() {

	set_categoria_primer_nivel(0);
	set_categoria_segundo_nivel(0);
	set_categoria_tercer_nivel(0);
	set_categoria_cuarto_nivel(0);
	set_categoria_quinto_nivel(0);

	/**/

	if (get_option("nuevo") == 0) {

		/**/
		primer_nivel = $(
				".categorias_edicion .primer_nivel_seccion option:selected")
				.val();
		set_categoria_primer_nivel(primer_nivel);
		/***/
		segundo_nivel = $(".categorias_edicion .segundo_nivel option:selected")
				.val();
		if (segundo_nivel != undefined) {
			set_categoria_segundo_nivel(segundo_nivel);
		}
		/***/
		tercer_nivel = $(".categorias_edicion .tercer_nivel option:selected")
				.val();
		if (tercer_nivel != undefined) {
			set_categoria_tercer_nivel(tercer_nivel);
		}
		cuarto_nivel = $(".categorias_edicion .cuarto_nivel option:selected")
				.val();
		if (cuarto_nivel != undefined) {
			set_categoria_cuarto_nivel(cuarto_nivel);
		}
		/**/
		quinto_nivel = $(".categorias_edicion .quinto_nivel option:selected")
				.val();
		if (quinto_nivel != undefined) {
			set_categoria_quinto_nivel(quinto_nivel);
		}
	} else {
		/**/
		primer_nivel = $(".primer_nivel_seccion option:selected").val();
		set_categoria_primer_nivel(primer_nivel);
		/***/

		segundo_nivel = $(".categorias_edicion .segundo_nivel option:selected")
				.val();
		if (segundo_nivel != undefined) {
			set_categoria_segundo_nivel(segundo_nivel);
		}
		/***/
		tercer_nivel = $(".tercer_nivel option:selected").val();
		if (tercer_nivel != undefined) {
			set_categoria_tercer_nivel(tercer_nivel);
		}
		cuarto_nivel = $(".cuarto_nivel option:selected").val();
		if (cuarto_nivel != undefined) {
			set_categoria_cuarto_nivel(cuarto_nivel);
		}
		/**/
		quinto_nivel = $(".quinto_nivel option:selected").val();
		if (quinto_nivel != undefined) {
			set_categoria_quinto_nivel(quinto_nivel);
		}
	}

	/***/
}
/**/
function set_categoria_primer_nivel(nivel) {
	categoria_primer_nivel = nivel;
}
/**/
function get_categoria_primer_nivel() {
	return categoria_primer_nivel;
}
/**/
function set_categoria_segundo_nivel(nivel) {
	categoria_segundo_nivel = nivel;
}
/**/
function get_categoria_segundo_nivel() {
	return categoria_segundo_nivel;
}
/**/
function set_categoria_tercer_nivel(nivel) {
	categoria_tercer_nivel = nivel;
}
/**/
function get_categoria_tercer_nivel() {
	return categoria_tercer_nivel;
}
/**/
function set_categoria_cuarto_nivel(nivel) {
	categoria_cuarto_nivel = nivel;
}
/**/
function get_categoria_cuarto_nivel() {
	return categoria_cuarto_nivel;
}
/***/
function set_categoria_quinto_nivel(nivel) {
	categoria_quinto_nivel = nivel;
}
/**/
function get_categoria_quinto_nivel() {
	return categoria_quinto_nivel;
}
/**/

/**/

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
		beforeSend : function() {
			// show_load_enid(".place_servicios" , "Cargando ... ", 1 );
		}
	}).done(function(data) {
		set_flag_nueva_categoria(1);
		carga_informacion_servicio(3);
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

	data_send = $.param({
		"servicio" : get_option("servicio"),
		"color" : get_option("color")
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
		"servicio" : get_option("servicio"),
		"color" : get_option("color")
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
function valida_action_inicial() {
	
	set_option("accion", $(".q_action").val());	
	switch (parseInt(get_option("accion"))){	
	case 1:		
		$(".btn_agregar_servicios").tab("show");
		set_option("modalidad" , 0);
		set_option("nuevo", 1);
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
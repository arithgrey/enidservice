<?php
$info_respuesta = "";
$info_respuestas_similares_text = "";


foreach ($respuesta as $row) {

	$titulo = $row["titulo"];
	$respuesta = $row["respuesta"];
	$id_faq = $row["id_faq"];


	$btn_conf = "";
	if ($in_session == 1) {

		if ($perfil[0]["idperfil"] != 20 && $perfil[0]["idperfil"] != 19 && $perfil[0]["idperfil"] != 17) {

			$btn_conf = anchor_enid("", [
				"href" => '#tab2default',
				"data-toggle" => 'tab',
				"class" => 'btn_edicion_respuesta fa fa-cog',
				"id" => $id_faq]);
		}

	}
	$info_respuesta = div(div($btn_conf . $titulo), ["class" => "row"]);
	$info_respuesta .= $respuesta;
}


$x = 1;
foreach ($r_sim as $row) {

	$titulo = $row["titulo"];
	$id_faq = $row["id_faq"];
	$href = "?faq=" . $id_faq;


	$href_img = "../imgs/index.php/enid/img_faq/" . $id_faq;

	$info_respuestas_similares_text .= '<a href="' . $href . '" class="row">
									<ul class="event-list" >
										<li class="black blue_enid_background" >
											<time>
											' . span($x, ["class" => "day"]) . '
											</time>
											' . img(["src" => $href_img]) . '
											<div class="info">
												' . div($titulo) . '
											</div>
										</li>
									</ul>
								</a>';

	$x++;
}

?>
<?= div($info_respuesta) ?>

<hr>
<div class="row">
	<?= div(
		anchor_enid(
			img(["src" => "http://enidservice.com/inicio/img_tema/faq/correo-para-empresas-enidservice.png"]),
			["href" => "../correo_para_negocios"]
		),
		["class" => "col-lg-8 col-lg-offset-2"]
	) ?>
</div>
<hr>
<?= heading("Resultados relacionados", 2) ?>
<?= div($info_respuestas_similares_text, ["style" => "height: 600px;overflow-y: auto;"], 1) ?>
<hr>
<?= div(anchor_enid("Ir a categorias", ["href" => '../faq', "class" => 'black strong']),
	["style" => 'margin-top:20px;padding: 5px;', "class" => "blue_enid_background white"]
) ?>
<hr>
<?= anchor_enid(
	img(
		[
			"src" => "http://enidservice.com/inicio/img_tema/faq/necesitas-una-pagina-web-enidservice.png",
			"width" => "100%"
		]),
	["href" => "../contacto/#envio_msj"
	]) ?>



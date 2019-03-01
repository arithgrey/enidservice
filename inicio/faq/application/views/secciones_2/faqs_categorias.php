<div class="row"></div>
<?php
$lista_preguntas = "";
$x = 1;
foreach ($faqs_categoria as $row) {

	$titulo = $row["titulo"];
	$id_faq = $row["id_faq"];
	$href = "?faq=" . $id_faq;
	$href_img = "../imgs/index.php/enid/img_faq/" . $id_faq;

	$lista_preguntas .= '<a href="' . $href . '" class="row">
									<ul class="event-list" >
										<li class="black blue_enid_background" >
											<time style="background:#00304b!important;">
												' . span($x, ["class" => "day"]) . '
											</time>
											' . img(["src" => $href_img]) . '
											' . heading($titulo) . '
										</li>
									</ul>
								</a>';
	$x++;
}
?>

<?= heading("Temas relacionados", 2) ?>
<?= div($lista_preguntas, ["style" => "height: 600px;overflow-y: auto;"], 1) ?>

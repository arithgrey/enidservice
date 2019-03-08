<div class="col-lg-2">
    <?= $this->load->view("../../../view_tema/izquierdo.php") ?>
</div>
<div class='col-lg-10'>

	<?= get_format_menu($in_session, $perfil) ?>
	<?=valida_format_respuestas_menu($in_session, $lista_categorias)?>

    <div class="tab-pane fade in active" id="tab1default">
        <?= get_format_faqs($flag_categoria, $flag_busqueda_q, $categorias_publicas_venta, $categorias_temas_de_ayuda, $faqs_categoria, $respuesta, $in_session, $perfil) ?>
    </div>

</div>


    




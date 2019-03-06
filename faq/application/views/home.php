<div class="col-lg-2">
    <?= $this->load->view("../../../view_tema/izquierdo.php") ?>
</div>
<div class='col-lg-10'>
    <?= get_format_menu($in_session, $perfil) ?>
    <?php if ($in_session == 1): ?>
        <div class="tab-pane fade" id="tab2default">
            <?= get_form_respuesta($lista_categorias) ?>
        </div>
    <?php endif; ?>
    <div class="tab-pane fade in active" id="tab1default">
        <?= get_format_faqs($flag_categoria, $flag_busqueda_q, $categorias_publicas_venta, $categorias_temas_de_ayuda, $faqs_categoria, $respuesta, $in_session, $perfil) ?>
    </div>

</div>


    




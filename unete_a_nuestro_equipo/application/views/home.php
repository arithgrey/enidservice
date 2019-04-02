<div id='info_antes_de_ayuda'>
    <?= div(get_format_temas_ayuda(), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= place("info_articulo", ["id" => 'info_articulo']) ?>
            <?= $this->load->view("secciones_2/paginas_web") ?>
        </div>
    </div>
</div>        

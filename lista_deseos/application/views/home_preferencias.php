<div class="contenedor_principal_enid">
    <?= div(get_menu(), ["class" => "col-lg-2"]) ?>
    <div class="col-lg-10">
        <?=get_list_clasificaciones($is_mobile, $preferencias, $tmp)?>
    </div>
</div>
<?= $this->load->view("secciones/slider"); ?>

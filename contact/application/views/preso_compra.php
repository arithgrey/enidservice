<?= br(2) ?>
<div class="col-lg-10 col-lg-offset-1">
    <?=get_btw(
        heading_enid("Recibe nuestra ubicación", 2, ["class" => "strong"]),
        div("¿A través de qué medio?", ["class" => "text_selector"]),
        "text-center"
    )?>
</div>
<div class="col-lg-10 col-lg-offset-1">
	<div class="contenedor_eleccion">
		<?=get_format_eleccion()?>
	</div>
</div>
<div class="contenedor_eleccion_correo_electronico">
	<div class="col-lg-6 col-lg-offset-3">
		<div class="contendor_in_correo top_20">
			<?= get_form_ubicacion($servicio) ?>
		</div>
	</div>
</div>
<div class="contenedor_eleccion_whatsapp">
	<div class="col-lg-6 col-lg-offset-3">
		<div class="contendor_in_correo top_20">
			<?= get_form_whatsapp($servicio) ?>
		</div>
	</div>
</div>
<?= get_form_proceso_compra() ?>
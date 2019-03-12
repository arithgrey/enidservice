<div class="seccion_registro_nuevo_usuario_enid_service">
	<?= get_format_nuevo_usuario() ?>
</div>
<div class="contenedor_recuperacion_password display_none">
	<?= get_format_recuperacion_pw() ?>
</div>
<div class="wrapper_login">
	<?= get_form_acceso($action); ?>
</div>
<?= input_hidden(
	[
		"class" => "action",
		"value" => $action],
	1
); ?>
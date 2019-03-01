<?= n_row_12() ?>
<div class="col-lg-7">
	<form class="form-horizontal form_categoria" id="form_categoria">
		<div class="form-group">
			<?= div("¿ES SERVICIO?", ["class" => "col-lg-4"]) ?>
			<div class="col-lg-8">
				<select id="servicio" name="servicio" class="form-control servicio">
					<option value="0">NO</option>
					<option value="1">SI</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<?= div("CATEGORÍA", ["class" => "col-lg-4"]) ?>
			<div class="col-lg-8">
				<?= input([
					"id" => "textinput",
					"name" => "clasificacion",
					"placeholder" => "CATEGORÍA",
					"class" => "form-control input-md clasificacion",
					"required" => "true",
					"type" => "text"
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= guardar("SIGUIENTE", ["class" => "a_enid_blue add_categoria"]) ?>
			<?= place("msj_existencia") ?>
		</div>
	</form>
	<?= n_row_12() ?>
	<table>
		<?= get_td(place('primer_nivel')) ?>
		<?= get_td(place('segundo_nivel')) ?>
		<?= get_td(place('tercer_nivel')) ?>
		<?= get_td(place('cuarto_nivel')) ?>
		<?= get_td(place('quinto_nivel')) ?>
	</table>
	<?= end_row() ?>
</div>
<?= div(heading("CATEGORÍAS 	EN PRODUCTOS Y SERVICIOS", 3), ["class" => "col-lg-5"]) ?>
<?= end_row() ?>

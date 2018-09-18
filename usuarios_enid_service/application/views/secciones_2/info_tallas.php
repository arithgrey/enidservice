<?=n_row_12()?>
	<div class="col-lg-6 col-lg-offset-3">
		<div class="col-lg-3">
			<?=div("TIPO CLASIFICACIÓN")?>			
		</div>		
		<div class="col-lg-9">
			<form class="form-tipo-talla">				
				<?=input(["type"=>"text", "name"=>"tipo_talla","required"=>""])?>
			</form>
		</div>
	</div>
<?=end_row()?>
<?=place("place_tallas")?>

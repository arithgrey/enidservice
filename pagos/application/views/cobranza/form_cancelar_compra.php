<?=n_row_12()?>
	<div class="jumbotron" style="padding: 10px;">
		<h3 style="font-weight: bold;font-size: 1.2em;">			
			¿REALMENTE DESEAS CANCELAR LA COMPRA DE:<br>
			<span class="blue_enid">
				<?=strtoupper($recibo["resumen"])?>
			</span>
			?
		</h3>	  	
	</div>
<?=end_row()?>

<?=n_row_12()?>
	<a class="cancelar_orden_compra" id="<?=$recibo['id_recibo']?>" style="background: #f00 !important;padding: 10px!important;color:white !important;font-weight: bold !important;">
		CANCELAR ÓRDEN DE COMPRA
	</a>
<?=end_row()?>
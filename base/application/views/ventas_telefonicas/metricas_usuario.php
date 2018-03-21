<label class='blue_enid_background white' style='padding:2px;'>
	Resumen mensual
</label>
<div style='overflow:auto;'>
	<table class="table-striped table-bordered text-center" width="100%">
		<thead>
	        <tr>
	        	<?=get_td("Fecha ")?>
		        <?=get_td("Ventas ")?>
				<?=get_td("Ventas confirmada")?>
				<?=get_td("Contactos efectivos")?>
				<?=get_td("Referidos")?>
		        <?=get_td("Le interesa ")?>
				<?=get_td("Llamar después ")?>
				<?=get_td("No le interesa ")?>
				<?=get_td("No volver a llamar  ")?>
				<?=get_td("No contesta  ")?>					
	        </tr>
	   	</thead>
		<tbody>                                                          
			<?=get_resumen_venta_usuario($labor_venta)?>
		</tbody>
	</table>
</div>



<br>


<label class='blue_enid_background white' style='padding:2px;'>
	Resumen por periodo seleccionado
</label>
<div style='overflow:auto;'>
	<table class="table-striped table-bordered text-center" width="100%">
		<thead>
	        <tr>
	        	<?=get_td("Horario")?>
		        <?=get_td("Ventas ")?>
				<?=get_td("Venta confirmada")?>
				<?=get_td("Contactos efectivos")?>
				<?=get_td("Referidos")?>
		        <?=get_td("Le interesa ")?>
				<?=get_td("Llamar después ")?>
				<?=get_td("No le interesa ")?>
				<?=get_td("No volver a llamar  ")?>
				<?=get_td("No contesta  ")?>					
	        </tr>
	   	</thead>
		<tbody>                                                          
			<?=get_resumen_venta_usuario_periodo($labor_venta)?>
		</tbody>
	</table>
</div>
<br>
<br>




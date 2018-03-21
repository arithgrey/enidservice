<?php if ($info["tipo"] ==1){/*Tipo = 1 ventas*/?>	
	<h2 class="texto_ventas_titulo">
		VENDE PRODUCTOS Y SERVICIOS 
		<a  href="../planes_servicios/?q=1" 
			class='a_enid_blue' 
			style="color: white!important">  
			AQUÍ		
		</a>
	</h2>
	<?=get_numero_articulos_en_venta_usuario($info["numero_articulos_en_venta"])?>
<?php }else{?>
	<h2 class="texto_ventas_titulo">
		MIRA LAS ÚLTIMAS NOVEDADES Y PROMOCIONES 
		<a  href="../search/?action=novedades" 
			class='a_enid_blue' 
			style="color: white!important">  
			AQUÍ 
		</a>
	</h2>


<?php }?>

<xmp>
	<?=print_r($info)?>
</xmp>
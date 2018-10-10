<div class="contenedor_categorias_servicios">
	<?=heading_enid("GRUPO AL CUAL PERTENECE TU PRODUCTO" , "3" )?>			  	
	<?=anchor_enid(
		"CANCELAR" ,  
		[
			"class"	=>	"cancelar_registro" ,
			"style"	=>	"color: white!important"
		] , 
		1);?>
	<hr>
	<?=n_row_12()?>
		<div class="info_categoria">
			<?=place("primer_nivel_seccion"] , 1)?>
  	    </div>
  	    <div class="info_categoria">
			<?=place("segundo_nivel_seccion"] , 1)?>
  	    </div>	
  	    <div class="info_categoria">
			<?=place("tercer_nivel_seccion"] , 1)?>
  	    </div>	 
  	    <div class="info_categoria">
			<?=place("cuarto_nivel_seccion"] , 1)?>
  	    </div>	              	
		<div class="info_categoria">
			<?=place("quinto_nivel_seccion"] , 1)?>
  	    </div>	              	  	        
  	    <div class="info_categoria">
			<?=place("sexto_nivel_seccion"] , 1)?>
  	    </div>	              	  	        
  	<?=end_row();?>                   
</div>
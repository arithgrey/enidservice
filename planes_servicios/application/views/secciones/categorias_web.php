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
			<?=div( "" , ["class"	=>	"primer_nivel_seccion"] , 1)?>
  	    </div>
  	    <div class="info_categoria">
			<?=div( "" , ["class"	=>	"segundo_nivel_seccion"] , 1)?>
  	    </div>	
  	    <div class="info_categoria">
			<?=div( "" , ["class"	=>	"tercer_nivel_seccion"] , 1)?>
  	    </div>	 
  	    <div class="info_categoria">
			<?=div( "" , ["class"	=>	"cuarto_nivel_seccion"] , 1)?>
  	    </div>	              	
		<div class="info_categoria">
			<?=div( "" , ["class"	=>	"quinto_nivel_seccion"] , 1)?>
  	    </div>	              	  	        
  	    <div class="info_categoria">
			<?=div( "" , ["class"	=>	"sexto_nivel_seccion"] , 1)?>
  	    </div>	              	  	        
  	<?=end_row();?>                   
</div>
<?php if($in_session ==  0):?>
	<a href="../login/">
		<div class="a_enid_black agregar_a_lista">		
			AGREGAR A TU LISTA DE DESEOS
			<i class="fa fa-gift"></i>
		</div>
	</a>
<?php else:?>
	<div id='agregar_a_lista_deseos_add'>
		<div 		
			class="a_enid_blue agregar_a_lista_deseos">		
			AGREGAR A TU LISTA DE DESEOS
			<i class="fa fa-gift"></i>
		</div>	
	</div>
<?php endif;?>
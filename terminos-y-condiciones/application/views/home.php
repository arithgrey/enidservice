<?php 
	$temas = [
		"Realizar pedidos"                
		,"Pagos"                
		,"Envíos"                
		,"Devoluciones"                
		,"Uso de nuestro sitio"                
		,"Términos y condiciones"                
		,"POlítica de privacidad"                
		,"Términos y condiciones de uso del sitio" ];
?>

<?=n_row_12()?>
    <div class="contenedor_principal_enid">        
        <div class="col-lg-3">
			<?=ul(li("TEMAS DE AYUDA"))?>
			<?=ul($temas)?>       
        </div>
        <div class="col-lg-9">
            <?=heading_enid($titulo)?>            
            <?=$this->load->view($vista);?>
        </div>
    </div>
<?=end_row()?>
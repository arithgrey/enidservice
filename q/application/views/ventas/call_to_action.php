<?=n_row_12()?>                            
	<?=heading(
		"ESTAMOS A UN PASO DE ENVIAR TU PEDIDO", 
		'1'
	
		
	);?>
<?=end_row()?>
<?=n_row_12()?>                            
	<?=add_element( 
		"SALDO PENDIENTE" , 
		"p" , 
		array('style' =>  '' )
	)?>
	<?=n_row_12()?>
		<?=add_element( 
			$data_saldo_pendiente."MXN", 
			"p" , 
			array('style' =>  'text-decoration: underline;    
					font-size: 2.5em;
				    line-height: 108.33333%;
				    color: #01182d;
				    letter-spacing: -2px;' )
		)?>       
	<?=end_row()?>
    <?=val_btn_pago($param , $id_recibo)?>
<?=end_row()?>
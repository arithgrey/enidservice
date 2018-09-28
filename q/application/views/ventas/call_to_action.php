<?=heading_enid("ESTAMOS A UN PASO DE ENVIAR TU PEDIDO", '1', [] , 1);?>
<?=n_row_12()?>                            
	<?=p("SALDO PENDIENTE")?>
		<?=p($data_saldo_pendiente."MXN" , 
		['style' =>  'text-decoration: underline;font-size: 2.5em; line-height: 108.33333%;color: #01182d;letter-spacing: -2px;' ])?>
    <?=val_btn_pago($param , $id_recibo)?>
<?=end_row()?>
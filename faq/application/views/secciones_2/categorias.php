<?=n_row_12()?>
	<?=div("Servicios" , ["class"=>"blue_enid_background white strong"])?>
	<?=div(lista_categorias($categorias_publicas_venta));?>
<?=end_row()?>
<?=n_row_12()?>
	<?=place("place_categorias_extras")?>
<?=end_row()?>
<?=n_row_12()?>
	<?=div("Temas de ayuda" , ["class"=>"white strong", "style"=>"background: black;"])?>
	<?=div(lista_categorias($categorias_temas_de_ayuda) );?>
<?=end_row()?>

<?=n_row_12()?>
	<?=diiv("Programa de afiliados" , ["class"=>"white strong", "style"=>"background: black;"])?>
	<?=div(lista_categorias($categorias_programa_de_afiliados))?>
<?=end_row()?>



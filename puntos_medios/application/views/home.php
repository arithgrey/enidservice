<br><br>
<div class="col-lg-10 col-lg-offset-1 titulo_principal_puntos_encuentro">
	<center>
		<?=heading_enid("IDENTIFICA TU PUNTO MÁS CERCANO" , 2 ,[ "class" => "strong" ])?>		
		<?=create_select($tipos_puntos_encuentro , 
		"tipos_puntos_encuentro" , 
		"tipos_puntos_encuentro" , 
		"tipos_puntos_encuentro" , 
		"tipo" ,
		"id" 
		,0 , 1 , 0 ,  "-")?>

	</center>
</div>
<br>
<?=div(place("place_lineas") , ["class" => "col-lg-10 col-lg-offset-1"] ,1)?>
<div class='formulario_quien_recibe display_none'>
	<?=$this->load->view("quien_recibe");?>
</div>


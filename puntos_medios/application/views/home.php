<br><br>
<div class="col-lg-10 col-lg-offset-1 titulo_principal_puntos_encuentro">
	<center>
		<?=heading_enid("IDENTIFICA TU PUNTO MÁS CERCANO" , 2 ,[ "class" => "strong titulo_punto_encuentro" ])?>		
		<?=create_select($tipos_puntos_encuentro , 
		"tipos_puntos_encuentro" , 
		"tipos_puntos_encuentro hide" ,
		"tipos_puntos_encuentro" , 
		"tipo" ,
		"id" 
		,0 , 1 , 0 ,  "-")?>

	</center>
</div>
<br>
<?=div(place("place_lineas") , ["class" => "col-lg-8 col-lg-offset-2"] ,1)?>

<?php  if($primer_registro == 1 ):?>

	<?=input_hidden(["name" => "servicio", "class"  =>"servicio" , "value" => $servicio ])?>
	<div class='formulario_quien_recibe display_none'>
		<?=$this->load->view("quien_recibe");?>
	</div>

<?php else:?>

	<div class='formulario_quien_recibe display_none'>
		<?=$this->load->view("form_horario")?>
	</div>
<?php endif;?>
<?=input_hidden(["class"=>"primer_registro" , "value" => $primer_registro])?>
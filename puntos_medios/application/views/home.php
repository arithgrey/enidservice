<br><br>
<div class="col-lg-10 col-lg-offset-1 titulo_principal_puntos_encuentro">
	<center>
		<?=heading_enid("IDENTIFICA TU PUNTO MÁS CERCANO" , 2 ,[ "class" => "strong titulo_punto_encuentro" ])?>		
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


<?php  if($primer_registro == 1 ):?>

	<?=input_hidden(["name" => "servicio", "class"  =>"servicio" , "value" => $servicio ])?>
	<div class='formulario_quien_recibe display_none'>
		<?=$this->load->view("quien_recibe");?>
	</div>

<?php else:?>
	<div class='formulario_quien_recibe display_none'>
		<div class="col-lg-6 col-lg-offset-3">	

			<form class="form_punto_encuentro_horario">
			 	<?=heading_enid("¿En qué horario te gustaría recibir tu pedido?",
					4, 
				["class" =>"strong titulo_horario_entra"])?>				
				
				<br>  	
				<?=label(icon("fa fa-calendar-o") ." FECHA ",["class" =>"col-lg-4 control-label"])?>  
				<div class="col-lg-8">
					<?=input([
						"data-date-format"  =>  "yyyy-mm-dd",
						"name"              =>  'fecha_entrega',
						"class"             =>  "form-control input-sm " ,
						"type"				=>  'date',
						"value"             =>  date("Y-m-d"),
						"min"				=>  date("Y-m-d"),
						"max"				=> add_date(date("Y-m-d") , 4)
					])?>        
				</div>
				<?=label( icon("fa fa-clock-o") ." HORA DE ENCUENTRO", 
					["class" =>	"col-lg-4 control-label"]
										)?>  
				<div class="col-lg-8">
					<?=lista_horarios()?>							  	    
				</div>
				<?=input_hidden([
					"class" => "recibo",
					"name"	=> "recibo",
					"value"	=> $recibo
				])?>	
				<?=input_hidden(["name" => "punto_encuentro" , "class"  =>"punto_encuentro_form" ])?>		
				<br>
				<?=guardar("CONTINUAR" ,["class" =>"top_20"])?>
				<?=place("place_notificacion_punto_encuentro")?>
			</form>	 	
		</div>
	</div>
<?php endif;?>
<?=input_hidden(["class"=>"primer_registro" , "value" => $primer_registro])?>
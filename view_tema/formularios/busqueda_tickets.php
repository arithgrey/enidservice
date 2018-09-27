
<?=div("Ticket" . icon("fa fa-search") , ["class"=>"col-lg-4"])?>
<div class="formulario_busqueda_tickets">
	<?=div(input(["name"=>"q" , "class"=>"input-sm q", "type"=>"text"]) , ["class"=>"col-lg-4"])?>
	<div class="col-lg-4">	
		
		<?=create_select($departamentos,"depto" ,"form-control input-sm depto" ,"depto" ,"nombre","id_departamento" );?>

		<?=input_hidden([
			"name"		=>	"departamento" ,
			"value"		=>	$num_departamento,
			"id"		=>	'num_departamento',
			"class"		=>	'num_departamento'
		])?>				      	
	</div>	   
</div>
<?=place('place_proyectos')?>
<?=place('place_tickets')?>
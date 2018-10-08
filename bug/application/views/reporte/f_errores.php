<?=n_row_12()?>
	<div class="col-lg-6 col-lg-offset-3">
		<form class='form-error'  id='form-error' action='<?=base_url("index.php/api/reportes/reporteincidencia/format/json/")?>'>
			<div class='enid-service-start' id='enid-service-start'>
				<center>			
					<?=heading("Calíficanos!")?>						
				</center>
				<?=n_row_12()?>		
				<seccion id='seccion-califica' class='seccion-califica'>
					<p class="clasificacion">
						<?=input([
							"id"	=>	"radio1" ,
							"name"	=>	"estrellas" ,
							"value"	=>	"5" ,
							"class"	=>	'input-start' ,
							"type"	=>	"radio"
						])?>
						<?=label("★" , [
							"title"	=>	'Danos 5 estrellas' ,
							"class"	=>	's-estrella'  ,
							"style"	=>	'font-size:3em;' ,
							"for"	=>	"radio1"
						])?>
						
						<?=input([
							"id"	=>	"radio2" ,
							"name"	=>	"estrellas" ,
							"value"	=>	"4" ,
							"class"	=>	'input-start' ,
							"type"	=>	"radio"
						])?>
						<?=label("★" , [
							"title"	=>	'Danos 4 estrellas' ,
							"class"	=>	's-estrella'  ,
							"style"	=>	'font-size:3em;' ,
							"for"	=>	"radio2"
						])?>

						<?=input([
							"id"	=>	"radio3" ,
							"name"	=>	"estrellas" ,
							"value"	=>	"3" ,
							"class"	=>	'input-start' ,
							"type"	=>	"radio"
						])?>
						<?=label("★" , [
							"title"	=>	'Danos 3 estrellas' ,
							"class"	=>	's-estrella'  ,
							"style"	=>	'font-size:3em;' ,
							"for"	=>	"radio3"
						])?>
						<?=input([
							"id"	=>	"radio4" ,
							"name"	=>	"estrellas" ,
							"value"	=>	"2" ,
							"class"	=>	'input-start' ,
							"type"	=>	"radio"
						])?>
						<?=label("★" , [
							"title"	=>	'Danos 2 estrellas' ,
							"class"	=>	's-estrella'  ,
							"style"	=>	'font-size:3em;' ,
							"for"	=>	"radio4"
						])?>
						<?=input([
							"id"	=>	"radio5" ,
							"name"	=>	"estrellas" ,
							"value"	=>	"1" ,
							"class"	=>	'input-start' ,
							"type"	=>	"radio"
						])?>
						<?=label("★" , [
							"title"	=>	'Danos 1 estrellas' ,
							"class"	=>	's-estrella'  ,
							"style"	=>	'font-size:3em;' ,
							"for"	=>	"radio5"
						])?>
					</p>
				</seccion>
				<?=end_row()?>
				<?=place("place_val_estrellas" , ["id"=>'place_val_estrellas'])?>
			</div>
			<?=n_row_12()?>								            			
				<div class='calificaciones-ocultas'>
					<?=div(create_select(
							$tipos_incidencias , 
							"tipo_incidencia", 
							"incidencia form-control input-sm" ,  
							"incidencia" , 
							"tipo_incidencia" , 
							"idtipo_incidencia" ) ,  ["class"=>'col-lg-6'])?>

										
													
					<?=div(create_select(
						$calificaciones , 
						"afectacion", 
						"afectacion form-control input-sm" ,  
						"afectacion" , 
						"nombre" , 
						"idcalificacion" ),  ["class"=>'col-lg-6'])?>
										
					<?=input_hidden([
						"class"			=>	"form-control input-sm" ,
						"value"			=>	 base_url(),
						"name"			=>	"pagina_error" ,
						"id"			=>	"pagina_error" ,
						"placeholder"	=>	"enidservice.com"
					])?>			
				</div>
				<center>
					<?=span("¿Que mejorarías de nuestro sistema?" , ["class"=>'text-mejora black'])?>
				</center>
				<?=place("place_reporte_incidencia")?>
				<textarea name='descripcion' id='descripcion_incidencia' class='descripcion form-control'  rows="2" >
				</textarea>				
				<?=input_hidden(["name" 	=> 	'tipo_template', "value" =>  $param["tipo"]])?>
			<?=end_row()?>
			<?=div(btn_registrar_cambios_enid("btn_registar" , "btn_registar") , [] , 1)?>             	
		</form>
	</div>
<?=end_row()?>
<?=div(place("place_registro") , ["class"=>"col-lg-6 col-lg-offset-3"] )?>
			
		
	

<style type="text/css">
.seccion-califica p {
  text-align: center;
}.seccion-califica label {
  font-size: 50px;
}input[type="radio"] {
  display: none;
}label {
  color: #D7EDF5;
}.clasificacion {
  direction: rtl;
  unicode-bidi: bidi-override;
}.input-start:hover , .s-estrella:hover{
	cursor: pointer;
}label:hover,
label:hover ~ label {
  color: #10A9FC;
}input[type="radio"]:checked ~ label {
  color: #10A9FC;
}.calificaciones-ocultas{
	display: none;
}.text-mejora{
	color: #078AEA;
	
	
}
</style>
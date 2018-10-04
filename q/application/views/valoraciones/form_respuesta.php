<?php 	
	$next =0;	
	if ($info_usuario!=0) {
		$cliente =  $info_usuario[0];
		$nombre = $cliente["nombre"]." " .$cliente["apellido_paterno"];
		$telefono =  
		(strlen($cliente["tel_contacto"])>4)?$cliente["tel_contacto"]:
		$cliente["tel_contacto_alterno"];				
		$next ++;	
	}
?>

<?=n_row_12()?>

	<?=heading_enid($data_send["pregunta"] , 2)?>
	<?=anchor_enid( strong("SOBRE") . strtoupper($data_send["nombre_servicio"]) , 
		[ 
			"href"		=> 	get_url_servicio($data_send["id_servicio"]) , 
			"class" 	=>	'a_enid_blue_sm'
		]
		,
		1
	)?>
		

<?php if($next>0):?>
	<div class="top_15">
		<?=strong("CLIENTE:")?>
		<?=span(strtoupper($nombre) , ["class" => "underline"])?>	
	</div>
	<?php if(strlen($telefono)>4):?>
		<div style="margin-top: 10px;">
			<?=strong("TELÉFONO DE CONTACTO:")?>
			<?=span($telefono , ["class" => "underline"])?>
		</div>
	<?php endif;?>		
<?php endif;?>
<?=end_row()?>
<?=n_row_12()?>
<div class="contenedor_preguntas">
	<div class="panel panel-primary">
		<?=div("Seguimiento" , ["class" => "panel-heading"])?>
		<div class="panel-body">
			<div class="<?=verifica_scroll_respuesta(count($respuestas))?>">
				<ul class="chat">
				<?php foreach($respuestas as $row){	       
					$respuesta      =  $row["respuesta"];
					$fecha_registro =  $row["fecha_registro"];
					$id_pregunta    =  $row["id_pregunta"];
					$id_usuario     =  $row["id_usuario"];
					$nombre  		= $row["nombre"];
					$apellido_paterno  = $row["apellido_paterno"];                    				
				?>
				<li class="left clearfix">
					<?=span(
						img([
							"src" 			= carga_imagen_usuario_respuesta($id_usuario),
		                    "onerror" 		= "this.src='../img_tema/user/user.png'",
		                    "style" 		= "width: 40px!important;height: 32px!important;"	,
		                    "class" 		= "img-circle"
						]) , 
						["class" 			=>	"chat-img pull-left"]
					)?>
					<div class="chat-body clearfix">
						<div class="header">
							<?=strong( $nombre . $apellido_paterno , ["class" => "primary-font"] )?>
							<?=small(icon("fa fa-clock") . $fecha_registro , ["class" => "pull-right text-muted"] )?>
						</div>
						<?=p($respuesta)?>
					</div>
				</li>
				<?php }?>                 
				</ul>
			</div>
		</div>
		<form class="form_valoracion_pregunta"  > 
	        <div class="panel-footer">
	            <div class="input-group">
	            <?=input([
	            	"id"				=> 	"btn-input" ,
		            "type"				=> 	"text" ,
		            "class"				=> 	"form-control input-sm" ,
		            "placeholder"		=> 	"Agrega una respuesta",
		            "name"				=> 	"respuesta"
	            ])?>
	            <?=guardar("Enviar respuesta" , 
	            [
	            	"class"=>"btn btn-warning btn-sm input-group-btn" ,
	            	"id"=>"btn-chat"
	            ])?>
	            </div>
	        </div>
	    </form>
	</div>        
</div>
<?=end_row()?>
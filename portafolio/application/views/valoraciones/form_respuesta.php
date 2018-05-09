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
<div style="margin-top: 10px;"></div>
<?=n_row_12()?>
<div>
	<h3 style="font-weight: bold;font-size: 2em;">
	  	<?=$data_send["pregunta"]?>
	</h3>
	<div>
		<strong>
			SOBRE 
			<a href="<?=get_url_servicio($data_send["servicio"])?>" 
				class='a_enid_blue_sm'
				style="color: white!important">
				<?=strtoupper($data_send["nombre_servicio"])?>			
			</a>
		</strong>
	</div>  	
</div>
<?php if($next>0):?>
	<div style="margin-top: 15px;">
		<span class="strong">
			CLIENTE:
		</span> 
		<span style="text-decoration: underline;">
			<?=strtoupper($nombre)?>
		</span>
	</div>
	<?php if(strlen($telefono)>4):?>
		<div style="margin-top: 10px;">
			<span class="strong">
				TELÉFONO DE CONTACTO:
			</span> 
			<span style="text-decoration: underline;">
				<?=$telefono?>
			</span>
		</div>
	<?php endif;?>		
<?php endif;?>
<?=end_row()?>
<?=n_row_12()?>
<div class="contenedor_preguntas">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Seguimiento
                </div>
                <div class="panel-body">
                	<div class="<?=verifica_scroll_respuesta(count($respuestas))?>">
	                    <ul class="chat">
	                    	<?php 
		                    	foreach($respuestas as $row){	       

									$respuesta      =  $row["respuesta"];
									$fecha_registro =  $row["fecha_registro"];
									$id_pregunta    =  $row["id_pregunta"];
									$id_usuario     =  $row["id_usuario"];
									$nombre  = $row["nombre"];
									$apellido_paterno  = $row["apellido_paterno"];                    				
							?>
		                        <li class="left clearfix">
		                        	<span class="chat-img pull-left">
		                            	<img 
		                            		src="<?=carga_imagen_usuario_respuesta($id_usuario)?>" 
		                            		onerror="this.src='../img_tema/user/user.png'"
		                            		style="width: 40px;height: 32px;"	
		                            		class="img-circle"/>
		                        	</span>
		                            <div class="chat-body clearfix">
		                                <div class="header">
		                                    <strong class="primary-font">
		                                	    <?=$nombre?> <?=$apellido_paterno?>
		                                	</strong> 
		                                    <small class="pull-right text-muted">
		                                        <span class="fa fa-clock">
		                                     	</span><?=$fecha_registro?>
		                                     </small>
		                                </div>
		                                <p>
		                                    <?=$respuesta?>
		                                </p>
		                            </div>
		                        </li>
	                        <?php }?>                 
	                    </ul>
                    </div>
                </div>
                <form class="form_valoracion_pregunta"  > 
	                <div class="panel-footer">
	                    <div class="input-group">
	                        <input 
		                        id="btn-input" 
		                        type="text" 
		                        class="form-control input-sm" 
		                        placeholder="Agrega una respuesta"
		                        name="respuesta" />
	                        <span class="input-group-btn">
	                            <button class="btn btn-warning btn-sm" id="btn-chat">
	                                Enviar respuesta
	                            </button>
	                        </span>
	                    </div>
	                </div>
                </form>
            </div>        
</div>
<?=end_row()?>

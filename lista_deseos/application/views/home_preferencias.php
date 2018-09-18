<?php 
	
	/*headings*/
	$heading_1	= heading_enid("TUS PREFERENCIAS E INTERESES" );
	/*P*/
	$p1 	= p("CUÉNTANOS TUS INTERESES PARA  MEJORAR TU EXPERIENCIA"); 
	$tmp =  div( $heading_1 .  $p1  , ['class' => "col-lg-4"] );



?>
<div class="contenedor_principal_enid">
<?=n_row_12()?>	
	<div class="col-lg-2">
		<?=$this->load->view("secciones/menu");?>
	</div>	
	<div class="col-lg-10" style="background: #1119bf;padding: 20px;">
	<?php  if($is_mobile == 1):?>
		<?=$tmp?>
	<?php endif;?>			
			<div class="col-lg-8"> 
				
				<div class="row">
						<?php $r =0; $z =0; foreach ($preferencias as $row): ?>						
							<?php  if ($z == 0): ?>								
								<div class="col-lg-4">								

									<?php endif; ?>
					<?php 
					$extra = ($row["id_usuario"] != null )?
					"selected_clasificacion":"";
					$preferencia_="preferencia_".$row['id_clasificacion'];
					$config =  array('class' => 
					'list-preferencias
					item_preferencias 
					'.$preferencia_.' '.$extra.' ' ,
					'id' => $row['id_clasificacion']);


					$extraIcon = ($row["id_usuario"] != null )?" fa fa-check-circle-o ":"";
					
					$extraIcon =  add_element("" , "i" , array('class'=>$extraIcon));
					$clasificacion 
					=  add_element( 
						$extraIcon.$row["nombre_clasificacion"], "div" , $config);  	
					echo add_element($clasificacion  ,  'div' , array('class' => 'row') );

					?>

									<?php $z ++; if ($z == 9): ?>							
								</div>

							<?php $z =0; endif; ?>
							<?php $r ++; if ($r == 26): ?>							
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
														
			</div>
			</div>
			<?php if($is_mobile == 0):?>
				<?=$tmp?>
			<?php endif;?>
		</div>	
<?=n_row_12()?>			
		<?=$this->load->view("secciones/slider");?>			
<?=end_row()?>
<?=end_row()?>
</div>

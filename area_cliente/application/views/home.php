<?php 
$llamadas_hechas = anchor_enid("HECHAS". 
	span( "" ,['class' => 'notificacion_preguntas_sin_leer_cliente'] ) , 
[	"class"	=>	"a_enid_black preguntas btn_preguntas_compras" ,
	"id"	=>	'0' ,
	"style"	=>	"color: white!important"
]);

$llamadas_recibidas =  anchor_enid(
	"RECIBIDAS" .span("" , ['class' => 'notificacion_preguntas_sin_leer_ventas']   ) , 
["class"	=>"a_enid_blue preguntas btn_preguntas_ventas" ,
"id"	=>"1" ,
"style" =>"color: white!important"
]);
?>
	<?=n_row_12()?>
	    <div class="contenedor_principal_enid">
		    <?=$this->load->view("secciones/menu");?>
		    <div class='col-lg-10'>
		        <div class="tab-content">            
		            <div class="tab-pane <?=valida_active_tab('compras' , $action)?>"  id='tab_mis_pagos'>
		                <?=div("" , ["class"=>"place_servicios_contratados"] , 1)?>
		            </div>
		            <div 
		            	class="tab-pane <?=valida_active_tab('ventas' , $action)?>" 
		            	id='tab_mis_ventas'>                
		                <?=n_row_12()?> 
		                	<div class="col-lg-9">	                		
		                    	<?=div("", ["class"=>'place_ventas_usuario'])?>
		                    </div>
		                    <div class="col-lg-3">	                		
		                    	<?=heading_enid("MIS VALORACIONES Y RESEÑAS RECIBIDAS" , 3 ,[])?>
								
								<center>
						    		<?=$valoraciones;?>
						    	</center>
						    	
						    	<?=anchor_enid("VER COMENTARIOS" , [
						    		"href"	=>	"../recomendacion/?q=".$id_usuario ,
									"class"	=>	"a_enid_blue text-center"] ,
									1
								)?>
								<?=div($alcance , [] , 1)?>
		                    </div>

		                <?=end_row()?>

		            </div>
		            <div class="tab-pane <?=valida_active_tab('preguntas' , $action)?>" id="tab_buzon">
						<div class="contenedor_opciones_buzon">
							<?=heading_enid("BUZÓN" , 3)?>
							<?=p("TUS PREGUNTAS" , ['class' => 'text-preguntas'])?>
							<hr>
							<?=n_row_12()?>
								<table>
									<tr>
										<td>
											<?=$llamadas_hechas;?>
											<?=$llamadas_recibidas?>
										</td>
									</tr>
								</table>
							<?=end_row()?>
						</div>
						<?=place("place_buzon")?>
		            </div>
		            <div  class="tab-pane" id="tab_pagos">
		            	<?=place("place_pagar_ahora")?>
		            </div>
		            <div  class="tab-pane" id="tab_renovar_servicio">    
		           		<?=place("place_resumen_servicio")?>       
		            </div>
		        </div>
		    </div>   
		</div> 
		<?=input_hidden(["class"=>"action",  "value"=>$action ])?>
		
	<?=end_row()?>





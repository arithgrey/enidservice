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
		        	<div class="tab-pane <?=valida_active_tab('preguntas' , $action)?>" id="tab_buzon">
						<!--<div class="contenedor_opciones_buzon">-->
							<?=heading_enid("BUZÓN" , 3)?>
							<?=div("TUS PREGUNTAS" , ['class' => 'text-preguntas'])?>
							<hr>							
							<table>
								<tr>
									<?=get_td($llamadas_hechas . $llamadas_recibidas )?>
								</tr>
							</table>
						<!--</div>-->

						<?=place("place_buzon")?>
		            </div>
		            <div class="tab-pane <?=valida_active_tab('compras' , $action)?>"  id='tab_mis_pagos'>
		                <?=place("place_servicios_contratados")?>
		            </div>
		            <div class="tab-pane <?=valida_active_tab('ventas' , $action)?>" id='tab_mis_ventas'>                
		                
		                	<?=div(place("place_ventas_usuario") , ["class"=>"col-lg-9"])?>
		                    <div class="col-lg-3">	                		
		                    	<?=heading_enid("MIS VALORACIONES Y RESEÑAS RECIBIDAS" , 3)?>
								<center>
						    		<?=$valoraciones;?>
						    	</center>
						    	<br>
						    	<CENTER>
						    	<?=anchor_enid("VER COMENTARIOS" , 
						    		[
						    		"href"	=>	"../recomendacion/?q=".$id_usuario ,
									"class"	=>	"a_enid_blue text-center top_10"
									] ,
									1,
									1
								)?>
								</CENTER>
								<?=div($alcance , 1)?>
		                    </div>

		                

		            </div>
		            
					<?=div(place("place_pagar_ahora") ,  ["class"=>"tab-pane", "id"=>"tab_pagos"] )?>
		           	<?=div(place("place_resumen_servicio") , ["class"=>"tab-pane" , "id"=>"tab_renovar_servicio"] )?>       
		        </div>
		    </div>   
		</div> 
		<?=input_hidden(["class"=>"action",  "value"=>$action ])?>
		
	<?=end_row()?>





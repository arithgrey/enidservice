<?php 
	
	$l = "";

	foreach ($llamar_despues as $row){


		$id_base_telefonica  =  $row["id_base_telefonica"];
		$telefono  =  $row["telefono"];
		$n_tocado  =  $row["n_tocado"];
		$idtipo_negocio  =  $row["idtipo_negocio"];						
			$fecha_registro  =  $row["fecha_registro"];
			$fecha_modificacion  =  $row["fecha_modificacion"];		
		
		$fecha_agenda  =  $row["fecha_agenda"];
		$hora_agenda  =  $row["hora_agenda_text"];		
		$comentario  =  $row["comentario"];
		//$info_publicidad  =  $row["info_publicidad"];
		$nombre_fuente  =  $row["nombre_fuente"];
		$extra_font_size = "style='font-size:.7em!important;'"; 
		$extra_font_size2 = "style='font-size:.7em!important;'"; 



		$l .=  "<tr>";
			

			
			$extra_marcar_hecha =  "<i class='fa fa-check llamada_hecha_llamar_despues' 
										href='#tab_tipificar_llamar_despues' 
            							data-toggle='tab' 
										id='".$telefono ."' 
										onclick=set_tmp_tel($telefono);
										>
									</i>"; 			
			$l .=  get_td($extra_marcar_hecha, $extra_font_size );

			$extra_tel ="<i class='icon-mobile contact'></i>";
			$l .=  get_td( "<a href='+$telefono' target='_black' >".
								$extra_tel. $telefono ."</a>", 
							$extra_font_size2 );


			$l .=  get_td($fecha_agenda."<br>" .$hora_agenda , $extra_font_size );			
			$l .=  get_td($comentario, $extra_font_size );
			//$l .=  get_td($info_publicidad, $extra_font_size );
			
			$l .=  get_td($n_tocado, $extra_font_size );
			$l .=  get_td($nombre_fuente, $extra_font_size );

		$l .=  "</tr>";
	}

	 

?>


<div class='<?=valida_class_extra_scroll($llamar_despues)?> contenedor_listado'>	

<?=$this->load->view("../../../view_tema/header_table")?>  	                                     	

		<th style='font-size:.8em;color:#007BE3!important;'>
			Marcar como hecha
		</th>

		<th style='font-size:.8em;color:#007BE3!important;'>
			Tel.
		</th>
		<th style='font-size:.8em;color:#007BE3!important' nowrap>
			Fecha agenda 
		</th>
						
		<th style='font-size:.8em;color:#007BE3!important;'>
			Comentario
		</th>						
		<!--
			<th style='font-size:.8em;color:#007BE3!important;'>
				Como el se publicita
			</th>
		-->								
		<th style='font-size:.8em;color:#007BE3!important;'>
			#Intentos 
		</th>		
		<th style='font-size:.8em;color:#007BE3!important;'>
			Fuente
		</th>
		
	<?=$l;?>                           
<?=$this->load->view("../../../view_tema/footer_table")?>  	                                     		
</div>
<?php  
	$l ="";
	$tipo = 0;	

	$estilos_estra ="style='font-size:.8em!important;background: #0030ff;color: white;'"; 	
	foreach ($info as $row) {	

		$tipo =  $row["tipo"];
		$id_persona =  $row["id_persona"];
		$nombre =  $row["nombre"];
		$a_paterno =  $row["a_paterno"];
		$a_materno =  $row["a_materno"];
		$tel =  $row["tel"];
		$tel_2 =  $row["tel_2"];
		$sitio_web =  $row["sitio_web"];
		$correo =  $row["correo"];
		$nombre_fuente =  $row["nombre_fuente"];
		
		$tipo_negocio =  $row["tipo_negocio"];		 		
		$nombre = $nombre . "<br> " . $a_paterno . " " . $a_materno; 						
		$fecha_registro = $row["fecha_registro"];
		
		
		/*PERSONA*/
		$extra_persona =  "<i class='info_persona fa fa-history ' 
								id='".$id_persona."'>
							</i>";



		$extra_agendar =  "<i 
							href='#tab_agendar_llamada' 
		    				data-toggle='tab' 
							class='btn_agendar_llamada fa fa-phone-square ' 
							id='".$id_persona."'>
							</i>";
	

		$l .= "<tr>";							
			

			$l.= get_td($nombre , "style='font-size:.7em!important;'");
			$l.= get_td($extra_persona , "style='font-size:.8em!important;'  ");
			$l.= btn_ticket($tipo , $id_persona , $nombre );
			$l.= get_td($tel  , "style='font-size:.8em!important;' ");						
			
			$l.= get_td($tipo_negocio  , "style='font-size:.8em!important;' ");			
		$l .= "</tr>";
		
	}
 	
?>
  	        
<?=n_row_12()?>
	<span 	
		class='text-center strong'
	 	style='font-size:.8em!important;'>
		# Resultados
		<?=count($info);?>		
	</span>		
<?=end_row()?>

<?=n_row_12()?>
	<div style="height: 450px;overflow: auto;">
		<?=$this->load->view("../../../view_tema/header_table")?>
			<tr>                       	    
				<?=get_td("Nombre", $estilos_estra)?>          
				<?=get_td("Historial", $estilos_estra)?>          
				<?=get_td("Ticket", $estilos_estra)?>          
				<?=get_td("Tel.", $estilos_estra)?>          
				<?=get_td("Negocio", $estilos_estra)?>          				
			</tr>	              
			<?=$l;?>                           
		<?=$this->load->view("../../../view_tema/footer_table")?>
	</div>
<?=end_row()?>
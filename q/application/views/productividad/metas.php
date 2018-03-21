
	<br>
	<div style='overflow-x:auto; overflow-y:hidden;'>
		<table class='table_enid_service text-center ' border=1  width="100%">
			
			<tr>			
				<?=get_td("Sitios web ".$metas["info_metas"][0]["accesos_sw"] , "style='background:#0047C2; color:white!important;' title='Sitios web' ")?>
				<?=get_td("Actuales ". get_num_actual($metas["info_metas_cumplidas"][0]["paginas_web"])  , ""  )?>
				<?=get_td("Restan ".  get_diferencia_metas($metas["info_metas"][0]["accesos_sw"] , $metas["info_metas_cumplidas"][0]["paginas_web"] )  , "" )?>
				
				<?=get_td("Tienda en linea" . $metas["info_metas"][0]["accesos_tl"] , "style='background:#0047C2; color:white !important;' title='Tienda en linea'   ")?>
				<?=get_td("Actuales ". get_num_actual($metas["info_metas_cumplidas"][0]["tienda_en_linea"]) , ""  )?>
				<?=get_td("Restan ".  get_diferencia_metas( $metas["info_metas"][0]["accesos_tl"] , $metas["info_metas_cumplidas"][0]["tienda_en_linea"] ) , ""  )?>


				<?=get_td("CRM " .$metas["info_metas"][0]["accesos_crm"] ,  "style='background:#0047C2; color:white !important;'")?>
				<?=get_td("Actuales ". get_num_actual($metas["info_metas_cumplidas"][0]["crm"])  , "" )?>
				<?=get_td("Restan ".  get_diferencia_metas($metas["info_metas"][0]["accesos_crm"] , $metas["info_metas_cumplidas"][0]["crm"] ) , ""   )?>

				<?=get_td("Adwords ". $metas["info_metas"][0]["accesos_adwords"]  , "style='background:#0047C2; color:white !important;'")?>
				<?=get_td("Actuales ". get_num_actual($metas["info_metas_cumplidas"][0]["google_adwords"]) , "" )?>
				<?=get_td("Restan ".  get_diferencia_metas($metas["info_metas"][0]["accesos_adwords"] , $metas["info_metas_cumplidas"][0]["google_adwords"] ) , ""   )?>



				<?=get_td("<span class=' white'> Linkedin ".$metas["info_metas"][0]["linkedin"] ."</span>" , "class='blue_linkeding_background' " )?>
				<?=get_td("<span class=' white'> Facebook ".$metas["info_metas"][0]["facebook"] ."</span>" , "class='blue_linkeding_background' " )?>
				<?=get_td("<span class=' white'> Twitter ".$metas["info_metas"][0]["twitter"] ."</span>" , "class='blue_linkeding_background' " )?>



				<?=get_td("<span class=' white'> Artículos ".$metas["info_metas"][0]["blogs_creados"] ."</span>" , "style='background:#0047C2; color:white!important;' " )?>
				<?=get_td("<span class=' white'> Actuales ". get_num_actual($metas["info_blogs"][0]["num_blogs"]) ."</span>"  , "style='background:#0047C2; color:white!important;' " )?>
				<?=get_td("<span class=' white'> Restan ".  get_diferencia_metas($metas["info_metas"][0]["blogs_creados"]."</span>" , $metas["info_blogs"][0]["num_blogs"] )  , "style='background:#0047C2; color:white!important;' " )?>



			</tr>
		</table>
	</div>
	<br>
	<div style='overflow-x:auto; overflow-y:hidden; '>
		<table class='table_enid_service text-center blue_enid_background' border=1  width="100%">	
			<tr style='background:white; color:black!important;'>
				<?php
					foreach ($metas["perfiles_prospectacion"] as $row) {
						echo get_td($row["nombre"]);		
					}
				?>
			</tr>
		</table>
	</div>
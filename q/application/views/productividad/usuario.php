<?php	$resumen = get_fechas_cotizador($productividad_usuario);?>
<?=heading_enid("Productividad/Enid Service", 2 , ["class" => "titulo_repo"] )?>
	<?=n_row_12()?>	
		<div  style='overflow-x:auto;'>
			<table class='table_enid_service' border=1>		
				<tr class='f-enid'>								
					<?=$resumen["fechas"]?>
				</tr>						
				<tr>
					<?=$resumen["proyectos"]?>
				</tr>
				<tr>
					<?=$resumen["info_clientes"]?>
				</tr>
				<tr>
					<?=$resumen["prospectos_contato"]?>
				</tr>
				<tr>
					<?=$resumen["info_clientes_sistema"]?>
				</tr>
				<tr>
					<?=$resumen["info_afiliados"]?>
				</tr>
				<tr>
					<?=$resumen["info_visitas"]?>				
				</tr>
				<tr>
					<?=$resumen["contactos"]?>
				</tr>
				<tr>
					<?=$resumen["contactos_promociones"]?>
				</tr>				
				<tr>
					<?=$resumen["email_enviados"]?>
				</tr>
				<tr>
					<?=$resumen["email_leidos"]?>
				</tr>				
				<tr>
					<?=$resumen["prospectos"];?>
				</tr>				
				<tr>
					<?=$resumen["blogs"];?>
				</tr>
			</table>
		</div>
	
	<?=end_row()?>

<style type="text/css">
.table_enid_service{
	width: 100%;
}
.table_enid_service .f-enid{
	text-align: center;
	color: white !important;
}
.tipo_text{
	background: #166781;
	color: white;
}
.campo_contacto{
	background: #3C5E79;	
	color: white;
}
.titulo-principal{
	background: #2196f3;
	color: white;
}
.f-enid , .table_enid_service_header{
	background: #0022B7;
	color: white !important;
	
}
.white{
	color: white !important;
}
.strong{
	
}
table {
	text-align: center;
}
.sitios_dia:hover, .dispositivos_dis:hover,.blogs_creados:hover{
	cursor: pointer;
}
.buen_estado{
	background: blue;
}
.alerta_estado{
	background: red;
}
.titulo_repo{
	color: black !important;
}
.titulo_table:hover{
	cursor: pointer;
}
.titulo_table{
	background: #0071F2;
	color: white !important;
	
}
.titulo_table_descargas{
	background:white;
	color:  black!important;
		
}
.titulo_table_leido_sitios_web{
	
	background: #005CAB;
	color: white !important;
			
}
.titulo_table_adw{
	background: #F20808;
	color: white !important;
				
}
.titulo_table_tl{
	background: #084465;
	color: white !important;
					
}
.titulo_table_crm{
	
	background: white;
	color: black !important;
						
}
</style>
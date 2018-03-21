<?php
	
	$list = "";  
	$complete  ="";		
    $list_prospectos = "";			
	$height ="style='overflow-x:auto;'"; 

		if (count($prospectos) >= 20 ){			
			$height ="style='overflow-y:scroll; overflow-x:auto; height: 500px;' " ; 
		}

		$b =1;						  
	$t_eventos =  0;
	foreach ($prospectos as $row) {		

		$idempresa = $row["idempresa"]; 
		$nombreempresa       =  $row["nombreempresa"]; 
		$fecha_registro      =  $row["fecha_registro"]; 
		$facebook =  $row["facebook"]; 
		$tweeter =  $row["tweeter"]; 
		$gp   =  $row["gp"]; 
		$www  =  $row["www"]; 
		$dias_dif =  $row["dias_dif"]; 
		$id_empresa_eventos =  $row["id_empresa_eventos"];
		$num_eventos 	=  $row["num_eventos"];	
		$url_empresa =  url_la_historia($idempresa);  

		$miembros =  $row["miembros"]; 
		$t_eventos = 		$t_eventos + valida_num_eventos($num_eventos ); 
		$list_prospectos .= "<tr>";


		$list_prospectos .=  get_td($idempresa);

		$list_prospectos .=  get_td( "Uso de la plataforma", valida_atencion($dias_dif  ,$num_eventos)  );
		$list_prospectos .=  get_td("<a href='".$url_empresa."' >" . $nombreempresa . "</a>");
		
		$list_prospectos .=  get_td('<a class="miembros_empresa" id="'.$idempresa.'" data-toggle="modal" data-target="#miembros"> #Usuarios '.$miembros .' </a>' );
		$list_prospectos .=  get_td(valida_uso($dias_dif));
		$list_prospectos .=  get_td(valida_num_eventos($num_eventos ));
		
		$list_prospectos .=  get_td($fecha_registro);
		$list_prospectos .=  get_td($facebook);
		$list_prospectos .=  get_td($tweeter);
		$list_prospectos .=  get_td($gp);
		$list_prospectos .=  get_td($www);
		$list_prospectos .= "</tr>";

	}

?>


<?=titulo_enid("Prospectos Enid Service")?>

<?=n_row_12()?>
	Eventos <?=$t_eventos?>
<?=end_row()?>

<span class='num_registros_encontrados'>
	# Prospectos encontrados <?=count($prospectos);?>
</span>
<div <?=$height?> >
	<table class='table_enid_service' border=1>
		<tr class="table_enid_service_header">				
			<?=get_td("#")?>
			<?=get_td("Alerta Enid")?>
			<?=get_td("Empresa")?>
			<?=get_td("Contactos")?>
			<?=get_td("Dias de uso")?>			
			<?=get_td("Eventos publicitados")?>
			<?=get_td("Fecha registro")?>
			<?=get_td("Facebook")?>
			<?=get_td("Tweeter")?>
			<?=get_td("Google plust "  )?>
			<?=get_td("www")?>
		</tr>		
		<?=$list_prospectos;?>
	</table>
</div>

<style type="text/css">
.alert-uso-ok{
	background: rgb(62, 178, 192);
	color: white;
}
.alert-uso{
	background: #a94442;
	color: white;
}

	
</style>
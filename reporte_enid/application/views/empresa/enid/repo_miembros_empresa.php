<?php
        $complete  ="";		
        $lis_miembros = "";			
		$height ="style='overflow-x:auto;'"; 
		if (count($miembros) >= 20 ){
			
			$height ="style='overflow-x:auto; height: 300px;' " ; 
		}

		$b =1;						  
		foreach($miembros as $row){

				$idusuario=     $row["idusuario"];
				$nombre=     $row["nombre"];
				$email=     $row["email"];
				$fecha_registro=     $row["fecha_registro"];
				$puesto=     $row["puesto"];
				$status=     $row["status"];
				$apellido_paterno=     $row["apellido_paterno"];
				$apellido_materno=     $row["apellido_materno"];
				$email_alterno=     $row["email_alterno"];
				$tel_contacto=     $row["tel_contacto"];
				$tel_contacto_alterno=     $row["tel_contacto_alterno"];
				$edad=     $row["edad"];
				$cargo=     $row["cargo"];
				$url_fb=     $row["url_fb"];
				$url_tw=     $row["url_tw"];
				$url_www=     $row["url_www"];
				$sexo=     $row["sexo"];


				$lis_miembros .=  "<tr>";
				$lis_miembros .=  get_td($idusuario);
				$lis_miembros .=  get_td($nombre .  " " . $apellido_paterno .  " " .$apellido_materno);
				$lis_miembros .=  get_td($email);
				$lis_miembros .=  get_td($email_alterno);
				$lis_miembros .=  get_td($tel_contacto);
				$lis_miembros .=  get_td($tel_contacto_alterno);

				$lis_miembros .=  get_td($fecha_registro);
				$lis_miembros .=  get_td($puesto);
				$lis_miembros .=  get_td($edad);
				
				
				$lis_miembros .=  get_td($cargo);
				$lis_miembros .=  get_td($url_fb);
				$lis_miembros .=  get_td($url_tw);
				$lis_miembros .=  get_td($url_www);
				$lis_miembros .=  get_td($sexo);
				$lis_miembros .=  get_td($status);
				$lis_miembros .=  "</tr>";

		}
		
?>






<span class='num_registros_encontrados'>
	# Miembros <?=count($miembros);?>
</span>
<div  <?=$height?> >
	<table class='table_enid_service' border=1>
		<tr class="table_enid_service_header">			

				<?=get_td("#")?> 
				<?=get_td("Nombre")?> 
				<?=get_td("email")?> 
				<?=get_td("email_alterno")?> 
				<?=get_td("Tel.")?> 
				<?=get_td("Tel. 2")?> 
				<?=get_td("Fecha registro")?> 
				<?=get_td("Puesto")?> 								
				<?=get_td("Edad")?> 
				<?=get_td("Cargo")?> 
				<?=get_td("Fb")?> 
				<?=get_td("Tw")?> 
				<?=get_td("www")?> 
				<?=get_td("Sexo")?> 
				<?=get_td("Estatus")?> 
		</tr>		
		<?=$lis_miembros;?>
	</table>
</div>
<style type="text/css">
.tipo_text{
	background: #166781;
	color: white;
}
.campo_contacto{
	background: #3C5E79;	
	color: white;
}

</style>
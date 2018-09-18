<?php
        $complete  ="";		
        $info_uso = "";			
		$height ="style='overflow-x:auto;'"; 
		if (count($info_sistema["semanal"])>3 ){		
			$height ="style='overflow-x:auto;' " ; 
		}
		$b =1;						  
		$x =0;
		$limite = count($info_sistema["semanal"]) -1;
		$total_d_m_1 = 0;
		
		
		$formas_pago_1 = 0;

		$faq_1 =0;
		$faq ="";
		
		$correos_empresas_1 =0;
		$correos_empresas ="";

		$sobre_enid_1 =0;
		$sobre_enid ="";

		$afiliados = 0; 
		$afiliados_1 = 0; 

		$nosotros_1 = 0; 
		$procesar_compra_1 = 0; 
		/*TOTAL*/

		$total_visitas =0;
		$total_faqs =0;
		$total_formas_pago =0;
		$total_contacto =0;
		$total_principal = 0;
		$total_afiliado =0;
		$total_home =0;
		$total_producto =0;
		$total_procesar_compra =0;
		foreach ($info_sistema["semanal"] as $row) {

			$f_registro =  $row["horario"];
			
			$total_registrado = valida_total_menos1(
				$total_d_m_1 ,  $row["total_registrado"]);
			

			$total_visitas = $total_visitas +$row["total_registrado"];
			$faq = 
			valida_total_menos1($faq_1 , $row["faq"] );
			$faq_1 = $row["faq"]; 


			$total_faqs= $total_faqs +$row["faq"];

		
			$formas_pago = 
			valida_total_menos1(
				$formas_pago_1 
				, $row["formas_pago"] );			
			$formas_pago_1 = $row["formas_pago"];
			
			$total_formas_pago  = $total_formas_pago + $row["formas_pago"];
			/**/			 			
			$sobre_enid = valida_total_menos1($sobre_enid_1 , $row["sobre_enid"] );
			$sobre_enid_1 = $row["sobre_enid"]; 

			$total_principal=  $total_principal + $row["sobre_enid"];


			
			$procesar_compra = valida_total_menos1($procesar_compra_1 , $row["procesar_compra"] );
			$procesar_compra_1 = $row["procesar_compra"]; 

			$total_procesar_compra = $total_procesar_compra + $row["procesar_compra"];
			/***********************************/
				$afiliados = valida_total_menos1($afiliados_1 , $row["afiliados"] );
				$total_afiliado =  $total_afiliado + $row["afiliados"];
				$afiliados_1 = $row["afiliados"]; 

				$nosotros = valida_total_menos1($nosotros_1 , $row["nosotros"] );
				$nosotros_1 = $row["nosotros"]; 
				$total_home  =  $total_home + $row["nosotros"];

			/***********************************/		
			$contacto =  $row["contacto"];
			$total_contacto =$total_contacto + $contacto;
			$cotizaciones =  $row["cotizaciones"];					
			$style ="";
			

			$info_uso .='<tr  '.$style.'>';		

				$info_uso .= get_td($f_registro);
				$info_uso .=  $total_registrado;								
				$info_uso .=  $faq;
				$info_uso .= $formas_pago;
				$info_uso .= get_td($contacto);			
				$info_uso .= $sobre_enid;
				$info_uso .= $afiliados;
				$info_uso .= $nosotros;								
				$info_uso .= $procesar_compra;				
				                          	
			$info_uso .='</tr>';			
			$b++;
			$x ++;
		}
?>





	


<div style="margin-top: 50px;">
	<table class='table_enid_service' border=1>		
		<tr  style="background: #000;color: white;text-align: center!important;">				
				<?=get_td("Horario")?>
				<?=get_td("Total")?>								
				<?=get_td("FAQ")?>
				<?=get_td("Formas de pago")?>			
				<?=get_td("Contacto")?>				
				<?=get_td("Sobre Enid")?>
				<?=get_td("Afiliados")?>
				<?=get_td("Home")?>								
				<?=get_td("Procesar compra" )?>												
		</tr>		
		<?=$info_uso;?>
		<tr style="background: #000;color: white;text-align: center!important;">				
				<?=get_td("Total")?>
				<?=get_td($total_visitas)?>								
				<?=get_td($total_faqs)?>
				<?=get_td($total_formas_pago)?>			
				<?=get_td($total_contacto)?>				
				<?=get_td($total_principal)?>
				<?=get_td($total_afiliado)?>
				<?=get_td($total_home)?>				
				<?=get_td($total_procesar_compra)?>		
											
		</tr>		
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
.titulo-principal{
	background: #2196f3;
	color: white;
}
.f-enid 
, .table_enid_service_header{
	background: #03396E;
	color: white !important;
}
.white{
	color: white !important;
}

table {
	text-align: center;
	width: 100% !important;
	font-size: .85em;
}

.sitios_dia:hover
, .dispositivos_dis:hover{
	cursor: pointer;
}

.buen_estado{
	background: blue;
}
.alerta_estado{
	background: red;
}
.titulos_sitios_web_e{
	background: #000209!important;
	color: white!important;
}
.table_enid_service .f-enid{
	color: white !important;
}

</style>
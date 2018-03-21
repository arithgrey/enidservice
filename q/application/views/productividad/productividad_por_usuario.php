<?php
        $complete  ="";		
        $info_uso = "";			
		$height ="style='overflow-x:auto;'"; 
		if (count($productividad_usuario["data_usuario_sociales"])>3 ){		
			$height ="style='overflow-x:auto;' " ; 
		}
		$b =1;						  
		$x =0;
		$limite = count($productividad_usuario["data_usuario_sociales"]) -1;
		$t =0;

		$tt =0;

		$total_d_m_1 = 0;
		
		$paginas_m1 =  0; 
		$paginas_m2 =  0; 
		$paginas_m3 =  0; 
		$paginas_m4 =  0; 
		$paginas_m5 =  0; 
		$paginas_m6 = 0;
		$paginas_m7 = 0;



		$t_p_m1 =  0; 
		$t_p_m2 =  0; 
		$t_p_m3 =  0; 
		$t_p_m4 =  0; 
		$t_p_m5 =  0; 
		$t_p_m6 = 0;
		$t_p_m7 = 0;



		$ads_m1 =  0; 
		$ads_m2 =  0; 
		$ads_m3 =  0; 
		$ads_m4 =  0; 
		$ads_m5 =  0; 
		$ads_m6 =  0; 
		$ads_m7 =  0; 


		$t_ads_1 =  0; 
		$t_ads_2 =  0; 
		$t_ads_3 =  0; 
		$t_ads_4 =  0; 
		$t_ads_5 =  0; 
		$t_ads_6 =  0; 
		$t_ads_7 =  0; 




		$tl_1 =  0; 
		$tl_2 =  0; 
		$tl_3 =  0; 
		$tl_4 =  0; 
		$tl_5 =  0; 
		$tl_6 =  0; 
		$tl_7 =  0;

		
		$ttl_2 =  0; 
		$ttl_3 =  0; 
		$ttl_4 =  0; 
		$ttl_5 =  0; 
		$ttl_6 =  0; 
		$ttl_7 =  0;




		$crm_1 =  0; 
		$crm_2 =  0; 
		$crm_3 =  0; 
		$crm_4 =  0; 
		$crm_5 =  0; 
		$crm_6 =  0; 
		$crm_7 =  0; 
		$correos = 0;





		$tcrm_2 =  0; 
		$tcrm_3 =  0; 
		$tcrm_4 =  0; 
		$tcrm_5 =  0; 
		$tcrm_6 =  0; 
		$tcrm_7 =  0; 
		$tcorreos = 0;




		
		$total_encuesta_pagina_web =  0;
		$ultimos_encuestas = 0;

		$z = 0; 
		$dif =  count($productividad_usuario["data_usuario_sociales"] ); 

		foreach ($productividad_usuario["data_usuario_sociales"] as $row) {
			
			

			$totales = valida_total_menos1($t  , $row["totales"]  , " class='text-tb' ");			
			$t  = $row["totales"];			

			$tt +=  $t;


			$pagina_web_fb = valida_total_menos1($paginas_m2 , $row["pagina_web_fb"]  , " class='text-tb' ");			
			$paginas_m2 = $row["pagina_web_fb"];			
			$t_p_m2 +=   $paginas_m2;
		


			$pagina_web_ml = valida_total_menos1($paginas_m3 , $row["pagina_web_mercado_libre"]  , " class='text-tb' ");			
			$paginas_m3 = $row["pagina_web_mercado_libre"];	

			$t_p_m3 += $paginas_m3;
		


			
			$pagina_web_lk = valida_total_menos1($paginas_m4 , $row["pagina_web_linkeding"]  , " class='text-tb' ");			
			$paginas_m4 = $row["pagina_web_linkeding"];			
			$t_p_m4 +=  $paginas_m4; 
		

			
			$pagina_web_tw = valida_total_menos1($paginas_m5 , $row["pagina_web_twitter"]  , " class='text-tb' ");			
			$paginas_m5 = $row["pagina_web_twitter"];			

			$t_p_m5 += $paginas_m5;
		


			$pagina_web_email = valida_total_menos1($paginas_m6 , $row["pagina_web_email"]  , " class='text-tb' ");			
			$paginas_m6 = $row["pagina_web_email"];			
			$t_p_m6 += $paginas_m6;
		




			$pagina_web_blog = valida_total_menos1($paginas_m7 , $row["pagina_web_blog"]  , " class='text-tb' ");			
			$paginas_m7 = $row["pagina_web_blog"];			
			$t_p_m7 += $paginas_m7;



			$google_adwords_fb = valida_total_menos1($ads_m2 , $row["google_adwords_fb"]  , " class='text-tb' ");			
			$ads_m2 = $row["google_adwords_fb"];
			$t_ads_2 +=  $ads_m2; 

		
		


			$google_adwords_ml = valida_total_menos1($ads_m3 , $row["google_adwords_ml"]  , " class='text-tb' ");			
			$ads_m3 = $row["google_adwords_ml"];
			$t_ads_3 +=  $ads_m3;  
		


			/**/
			$google_adwords_lk = valida_total_menos1($ads_m4 , $row["google_adwords_lk"]  , " class='text-tb' ");			
			$ads_m4 = $row["google_adwords_lk"];
			$t_ads_4 += $ads_m4;
		

			$google_adwords_tw = valida_total_menos1($ads_m5 , $row["google_adwords_tw"]  , " class='text-tb' ");			
			$ads_m5 = $row["google_adwords_tw"];
			$t_ads_5 += $ads_m5;
		


			$google_adwords_email = valida_total_menos1($ads_m6 , $row["google_adwords_email"]  , " class='text-tb' ");			
			$ads_m6 = $row["google_adwords_email"];
			$t_ads_6 += $ads_m6;



			$google_adwords_blog = valida_total_menos1($ads_m7 , $row["google_adwords_blog"]  , " class='text-tb' ");			
			$ads_m7 = $row["google_adwords_blog"];
			$t_ads_7 += $ads_m7;


			$tienda_en_linea_fb = valida_total_menos1($tl_2 , $row["tienda_en_linea_fb"]  , " class='text-tb' ");			
			$tl_2 = $row["tienda_en_linea_fb"];

			$ttl_2 +=  $tl_2; 
			



			$tienda_en_linea_ml = valida_total_menos1($tl_3 , $row["tienda_en_linea_ml"]  , " class='text-tb' ");			
			$tl_3 = $row["tienda_en_linea_ml"];
			$ttl_3 += $tl_3; 
			



			$tienda_en_linkeding = valida_total_menos1($tl_4 , $row["tienda_en_linkeding"]  , " class='text-tb' ");			
			$tl_4 = $row["tienda_en_linkeding"];
			$ttl_4 += $tl_4;
			



			$tienda_en_twitter = valida_total_menos1($tl_5 , $row["tienda_en_twitter"]  , " class='text-tb' ");			
			$tl_5 = $row["tienda_en_twitter"];
			$ttl_5 += $tl_5; 
			


			$tienda_en_email = valida_total_menos1($tl_6 , $row["tienda_en_email"]  , " class='text-tb' ");			
			$tl_6 = $row["tienda_en_email"];
			$ttl_6 += $tl_6;
			


			$tienda_en_blog = valida_total_menos1($tl_7 , $row["tienda_en_blog"]  , " class='text-tb' ");			
			$tl_7 = $row["tienda_en_blog"];
			$ttl_7 += $tl_7;

			

			$crm_fb = valida_total_menos1($crm_2 , $row["crm_fb"]  , " class='text-tb' ");			
			$crm_2 = $row["crm_fb"];

			$tcrm_2 +=  $crm_2; 
		


			$crm_ml = valida_total_menos1($crm_3 , $row["crm_ml"]  , " class='text-tb' ");			
			$crm_3 = $row["crm_ml"];
			$tcrm_3 += $crm_3; 
		

			$crm_linkeding = valida_total_menos1($crm_4 , $row["crm_linkeding"]  , " class='text-tb' ");			
			$crm_4 = $row["crm_linkeding"];
			$tcrm_4 +=  $crm_4;
		

			$crm_twitter = valida_total_menos1($crm_5 , $row["crm_twitter"]  , " class='text-tb' ");			
			$crm_5 = $row["crm_twitter"];
			$tcrm_5 +=  $crm_5;


			$crm_email = valida_total_menos1($crm_6 , $row["crm_email"]  , " class='text-tb' ");			
			$crm_6 = $row["crm_email"];
			$tcrm_6 += $crm_6;
		

			$crm_blog = valida_total_menos1($crm_7 , $row["crm_blog"]  , " class='text-tb' ");			
			$crm_7 = $row["crm_blog"];
			$tcrm_7 += $crm_7;
		
			$num_correos_registrados = valida_total_menos1($correos , $row["num_correos_registrados"]  , " class='text-tb' ");			
			$correos = $row["num_correos_registrados"];
			$tcorreos += $correos;

			$dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			$f_registro =  $row["fecha_registro"];
			$dia_semana = $dias[date('N', strtotime($f_registro))];						
			$style ="";			

			$info_uso .='<tr  '.$style.'>';							
					
					

			

					$info_uso .= get_td( "<span class=' text-tb white text-tb'>". $dia_semana  ."</span>",
					 "class=' text-tb blue_enid_background white' ");		
					$info_uso .= get_td("<span class='white text-tb'>".$f_registro ."</span>", 
					 "class='white blue_enid_background' ");			

				
				$info_uso .= $totales;	
				$info_uso .= $pagina_web_fb;
				$info_uso .= $pagina_web_ml;
				$info_uso .= $pagina_web_lk;
				$info_uso .= $pagina_web_tw;
				$info_uso .= $pagina_web_email;
				$info_uso .= $pagina_web_blog;
											
				$info_uso .= $google_adwords_fb;
				$info_uso .= $google_adwords_ml;
				$info_uso .= $google_adwords_lk;
				$info_uso .= $google_adwords_tw;
				$info_uso .= $google_adwords_email;
				$info_uso .= $google_adwords_blog;
				
				$info_uso .= $tienda_en_linea_fb;
				$info_uso .= $tienda_en_linea_ml;
				$info_uso .= $tienda_en_linkeding;
				$info_uso .= $tienda_en_twitter;
				$info_uso .= $tienda_en_email;
				$info_uso .= $tienda_en_blog;
				
				$info_uso .= $crm_fb;
				$info_uso .= $crm_ml;
				$info_uso .= $crm_linkeding;
				$info_uso .= $crm_twitter;
				$info_uso .= $crm_email;
				$info_uso .= $crm_blog;

				$info_uso .= $num_correos_registrados;
							
				                          	
			$info_uso .='</tr>';			
			$b++;
			$x ++;
			$z ++;
		}
?>


<h3 class="black">
	Productivida
</h3>
<div  <?=$height?> >
	<table  class='table_enid_service text-center'
			width="100%"
			border=1>		
			<tr style='background:red;' class='white blue_enid_background'>				
				<?=get_td("<span class='white strong'>
							Periodo
							</span>" ,  
							"colspan='2' class='white blue_enid_background'")?>				
				
				<?=get_td("<span class=' text-tb white strong'>Totales</span>",   
						  "class=' text-tb white blue_enid_background'  " )?>				
				<?=get_td("<span class=' text-tb white strong'> Páginas web</span>" , "colspan='6'")?>
				<?=get_td("<span class=' text-tb white strong'> Adwords </span>" , "colspan='6'")?>
				<?=get_td("<span class=' text-tb white strong'> Tienda en linea </span>" , "colspan='6'")?>
				<?=get_td("<span class=' text-tb white strong'> CRM </span>" , "colspan='6'")?>
				<?=get_td("<span class=' text-tb white strong'> Correos registrados </span>" , "")?>
			</tr>
		<tr class=' text-tb f-enid'>			

				<?=get_td("<span class='text-tb white'>Día</span>" 
						 ,"class='white blue_enid_background' " );?>				

				<?=get_td("<span class=' text-tb white'>Fecha</span>" 
				,"class=' white blue_enid_background'");?>						

					<?=get_td("<span class=' text-tb white'>Acumulados</span>" , "class=' white blue_enid_background'")?>

				<?=get_td("Sitios web FB" , "style=' background:#AAF2E4 !important; '  
				class='text-tb' ")?>
				<?=get_td("ML" , "style=' background:#AAF2E4 !important;'  
				class='text-tb' ")?>				
				<?=get_td("Lk" , "style=' background:#AAF2E4 !important; '  
				class='text-tb' ")?>
				<?=get_td("TW" , "style=' background:#AAF2E4 !important;'  
				class='text-tb' ")?>
				<?=get_td("email" , "style=' background:#AAF2E4 !important;'  
				class='text-tb' ")?>							
				<?=get_td("Blog" , "style=' background:#AAF2E4 !important;'  
				class='text-tb' ")?>							
				
				<?=get_td("Adwords  FB"  , "style='color:white !important; background:#B12E0B;'  
				class='text-tb' ")?>				
				<?=get_td("ML"  , "style='color:white !important; background:#B12E0B;'  
				class='text-tb' ")?>				
				<?=get_td("LK"  , "style='color:white !important; background:#B12E0B;'  
				class='text-tb' ")?>				
				<?=get_td("TW"  , "style='color:white !important; background:#B12E0B;'  
				class='text-tb' ")?>				
				<?=get_td("email"  , "style='color:white !important; background:#B12E0B;'  
				class='text-tb' ")?>				
				<?=get_td("Blog"  , "style='color:white !important; background:#B12E0B;'  
				class='text-tb' ")?>				

				
				<?=get_td("Tienda en linea 
							FB"  , "style='color:white !important; background:#084465; color:white !important;'  
							class='text-tb' ")?>				
				<?=get_td("ML"  , "style='color:white !important; background:#084465; color:white !important;'  
				class='text-tb' ")?>				
				<?=get_td("LK"  , "style='color:white !important; background:#084465; color:white !important;'  
				class='text-tb' ")?>				
				<?=get_td("TW"  , "style='color:white !important; background:#084465; color:white !important;'  
				class='text-tb' ")?>				
				<?=get_td("email"  , "style='color:white !important; background:#084465; color:white !important;'  
				class='text-tb' ")?>				
				<?=get_td("Blog"  , "style='color:white !important; background:#084465; color:white !important;'  
				class='text-tb' ")?>				



				<?=get_td("CRM FB"  , "style='background:white;'  
				class='text-tb' ")?>				
				<?=get_td("ML"  , "style='background:white;'  
				class='text-tb' ")?>				
				<?=get_td("LK"  , "style='background:white;'  
				class='text-tb' ")?>				
				<?=get_td("TW"  , "style='background:white;'  
				class='text-tb' ")?>				
				<?=get_td("email"  , "style='background:white;'  
				class='text-tb' ")?>							
				<?=get_td("Blog"  , "style='background:white;'  
				class='text-tb' ")?>							
				
				<?=get_td("Correos registrados"  , "style='background:white;'  ")?>					
		</tr>		
		<?=$info_uso;?>
		

		<tr>
			<td colspan='2'>
				Totales
			</td>
			<?=get_td("<span class='text-tb'> ".$tt."</span>")?>			
			<?=get_td("<span class='text-tb'> ".$t_p_m2."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_p_m3."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_p_m4."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_p_m5."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_p_m6."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_p_m7."</span>")?>


			
			<?=get_td("<span class='text-tb'> ".$t_ads_2 ."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_ads_3 ."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_ads_4 ."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_ads_5 ."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_ads_6 ."</span>")?>
			<?=get_td("<span class='text-tb'> ".$t_ads_7 ."</span>")?>


			<?=get_td("<span class='text-tb'> ".$ttl_2."</span>")?>;
			<?=get_td("<span class='text-tb'> ".$ttl_3."</span>")?>;
			<?=get_td("<span class='text-tb'> ".$ttl_4."</span>")?>;
			<?=get_td("<span class='text-tb'> ".$ttl_5."</span>")?>;
			<?=get_td("<span class='text-tb'> ".$ttl_6."</span>")?>;
			<?=get_td("<span class='text-tb'> ".$ttl_7."</span>")?>;




			<?=get_td("<span class='text-tb'> ".$tcrm_2."</span>")?>
			<?=get_td("<span class='text-tb'> ".$tcrm_3."</span>")?>
			<?=get_td("<span class='text-tb'> ".$tcrm_4."</span>")?>
			<?=get_td("<span class='text-tb'> ".$tcrm_5."</span>")?>
			<?=get_td("<span class='text-tb'> ".$tcrm_6."</span>")?>
			<?=get_td("<span class='text-tb'> ".$tcrm_7."</span>")?>
			<?=get_td("<span class='text-tb'> ".$tcorreos."</span>")?>


		</tr>
	</table>
</div>




<style type="text/css">
.text_email{
	background: red !important;
}
</style>





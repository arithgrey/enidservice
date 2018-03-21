<?php		
	$info_respuesta ="";		
	$info_respuestas_similares_text ="";


	foreach ($respuesta as $row) {
		
		$titulo    =  $row["titulo"];
		$respuesta =  $row["respuesta"];
		$id_faq =  $row["id_faq"];


		$btn_conf = "";
		if ($in_session ==1 ){

			if ($perfil[0]["idperfil"] != 20 && $perfil[0]["idperfil"] != 19 && $perfil[0]["idperfil"] != 17  ) {
				
				$btn_conf = "<a href='#tab2default' 
							data-toggle='tab' 
							class='btn_edicion_respuesta fa fa-cog' 
							id='".$id_faq ."'>
							</a>";	
			}
			
		}

		
		$info_respuesta .= "<div class='row'>
								<div 
									style='padding: 15px;background: #0036d1;'>
									<p class='white strong' 
					                	style='font-size: 2.5em;
					                	line-height: .9;'>
					                	".$btn_conf.$titulo ."
					                </p>
					            </div>
				            </div><br><br>";
		$info_respuesta .= $respuesta;
	}
		

	$x = 1;
	foreach($r_sim as $row) {
		
		$titulo = $row["titulo"];
		$id_faq = $row["id_faq"];

		$href="?faq=".$id_faq;		
		
		
		$href_img ="../imgs/index.php/enid/img_faq/".$id_faq;

		$info_respuestas_similares_text .= '<a href="'.$href.'" class="row">
									<ul class="event-list" >
										<li class="black blue_enid_background" >
											<time style="background:#00304b!important;">
												<span class="day" >
													'.	$x .'
												</span>
											
											</time>
											<img src="'.$href_img.'"/>

											<div class="info">

												<div class="black blue_enid_background" 
												style="font-size:.8em;												
												color:white!important;padding:5px;">
												' .$titulo .'
												</div>
												
											</div>
											
										</li>
									</ul>
								</a>';		
		
		$x ++;
	}

?>


<div>
	<?=$info_respuesta?>
</div>
<hr>
<div class="row">
	
	<div class="col-lg-8 col-lg-offset-2">
		<a href="../correo_para_negocios">
			<img src="http://enidservice.com/inicio/img_tema/faq/correo-para-empresas-enidservice.png" width="100%">
		</a>
		
	</div>
</div>	

<hr>

<h2 class="white" style="background: black; " >
	Resultados relacionados 
</h2>



<div style="margin-top: 20px;">
	<?=n_row_12();?>
	<div style="height: 600px;overflow-y: auto;">

		<?=$info_respuestas_similares_text;?>
	</div>
	<?=end_row();?>
</div>
<hr>
<div style='margin-top:20px;padding: 5px;' class="blue_enid_background white">
	<a href='../faq' class='black strong' style="color: white!important;" >
		Ir a categorias
	</a>
</div>
<hr>
<a href="../contacto/#envio_msj">
			<img src="http://enidservice.com/inicio/img_tema/faq/necesitas-una-pagina-web-enidservice.png" width="100%">

</a>


<style type="text/css">
	
	.event-list > li {
		background-color: rgb(255, 255, 255);
		box-shadow: 0px 0px 5px rgb(51, 51, 51);
		box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
		padding: 0px;
		
	}
	.event-list > li > time {
		display: inline-block;
		width: 100%;
		color: rgb(255, 255, 255);
		background-color: black;
		padding: 5px;
		text-align: center;
		text-transform: uppercase;
	}
	
	.event-list > li > time > span {
		display: none;
	}
	.event-list > li > time > .day {
		display: block;
		font-size: 56pt;
		font-weight: 100;
		line-height: 1;
	}
	.event-list > li time > .month {
		display: block;
		font-size: 24pt;
		font-weight: 900;
		line-height: 1;
	}
	
    
	

	@media (min-width: 768px) {
		.event-list > li {
			position: relative;
			display: block;
			width: 100%;
			height: 130px;
			padding: 0px;
		}

		.event-list > li > time,
		.event-list > li > img  {
			display: inline-block;
		}

		.event-list > li > time,
		.event-list > li > img {
			width: 130px;
			float: left;
		}
		.event-list > li > .info {
			background-color: white;
			overflow: hidden;
		}
		.event-list > li > time,
		.event-list > li > img {
			width: 130px;
			height: 130px;
			padding: 0px;
			margin: 0px;
		}
		
		
		
	}
</style>
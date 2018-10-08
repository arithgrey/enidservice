<div class="row"></div>
<?php	
	$lista_preguntas = "";	
	$x  =1;
	foreach($faqs_categoria as $row) {

		$titulo = $row["titulo"];
		$id_faq = $row["id_faq"];
		$href 	="?faq=".$id_faq;		
		$href_img ="../imgs/index.php/enid/img_faq/".$id_faq;

		$lista_preguntas .= '<a href="'.$href.'" class="row">
									<ul class="event-list" >
										<li class="black blue_enid_background" >
											<time style="background:#00304b!important;">
												'.span($x , ["class"=>"day"] ).'
											</time>
											'.img(["src"=> $href_img ]).'
											'. heading($titulo).'
										</li>
									</ul>
								</a>';			
		$x ++;
	}	
?>

<?=heading("Temas relacionados" , 2 , 1)?>
<?=div($lista_preguntas , ["style"=>"height: 600px;overflow-y: auto;"] , 1)?>
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
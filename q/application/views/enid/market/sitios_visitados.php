<?php 
	$info ="";
	$a  =1;
	foreach ($sitios_visitados as $row) {
		
		$url =  $row["url"];
		$accesos =  $row["accesos"];

		$info .= "<tr>";
			$info .= get_td($a);
			$info .= get_td($accesos);
			$info .= "<td> " . $url ."</td>";
			
		$info .= "</tr>";
		$a ++;

	}
?>


<div class="contenedor_listado_info contenedor_listado ">
	<?=$this->load->view("../../../view_tema/header_table")?> 
               						
		<tr style="background: #0022B7!important;color: white;">				
			<?=get_th("#", "style='font-size:.8em;' class='white blue_enid_background text-center' ");?>
			<?=get_th("Accesos" , "style='font-size:.8em;' class='white blue_enid_background text-center' ");?>				
			<?=get_th("Sitio", "style='font-size:.8em;' class='white blue_enid_background text-center' ");?>
			
		</tr>				
		<?=$info?>
	<?=$this->load->view("../../../view_tema/footer_table")?>  	              
</div>
<?php
	
	$id_faq ="";
	$titulo ="";
	$id_categoria ="";
	$fecha_registro ="";
	
	$l = "";
	$z =1;
	$extra ="";
	foreach ($info_blog as $row) {
		
		$id_faq  =  $row["id_faq"];
		$titulo  =  $row["titulo"];
		$id_categoria  =  $row["id_categoria"];
		$categoria ="";
		
		$url ="../faq/?faq=".$id_faq;		
		$l .= "<tr>";
			$l .= get_td($z, $extra);
			$l .= get_td("<a href='".$url."'>" .$titulo ."</a>", $extra);			
		$l .= "</tr>";
		$z ++;
	}

?>

<div  style='overflow-x:auto;'>
	<table class='table_enid_service' border=1>
		<tr class="white" style="background: #0022B7!important;font-size: .8em;">
		
			<?=get_td("#");?>
			<?=get_td("Titulo");?>			
		</tr>
		<?=$l;?>
	</table>		
</div>
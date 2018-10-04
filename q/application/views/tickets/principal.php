<?php	
	
	$l =  "";
	$l.= "<tr>";	    
	    $l.= get_td("Más info", 		["class"=> "blue_enid_background white"]);
	    $l.= get_td("Estado", 			["class"=> "blue_enid_background white"]);
	    $l.= get_td("T.pendientes", 	["class"=> "blue_enid_background white"]);	     
	    $l.= get_td("Departamento", 	["class"=> "blue_enid_background white"]);
	    $l.= get_td("Proyecto", 		["class"=> "blue_enid_background white"]);
	    $l.= get_td("Asunto", 			["class"=> "blue_enid_background white"]);
	    $l.= get_td(" Última solicitud",["class"=> "blue_enid_background white"]);
	   	    
	$l.= "</tr>";



	$dif_clientes = [
	"#0656F9","#ed1c24","black","#01b9af","#173A83","#ed1c24","black","#01b9af","#173A83",
	"#ed1c24","black","#01b9af","#173A83","#ed1c24","black","#01b9af","#173A83" ];
	
	
	$tmp_cliente ="";
	$tmp_estilo_proyecto ="background:#0656F9!important";
	$zz =0;
	foreach ($info_tickets as $row) {
		
		$fecha_registro = $row["fecha_registro"];
		$fecha_ultima_solicitud =  $row["fecha_ultima_solicitud"];
		$fecha_ultima_solicitud_text =  $row["fecha_ultima_solicitud_text"];


		$id_ticket = $row["id_ticket"];			
		$asunto = $row["asunto"];
		$status = $row["status"];
		$lista_status=["Abierto","Cerrado","Visto"];		
		$proyecto = $row["proyecto"];


		if ($tmp_cliente != $proyecto){
			$tmp_estilo_proyecto ="background:".$dif_clientes[$zz]."!important;";
			$zz ++; 
		}
			


		$class_estatus 		  	= ["estado_abierto" , "estado_cerrado" , "estado_visto" ];
		$class_estatus_iconos 	= ["fa fa-bars" , "fa fa-check" , "fa fa-eye"];
		$fecha_liberacion 	  	= $row["fecha_liberacion"];
		$nombre_departamento 	= $row["nombre_departamento"];

		

		$btn_mas_info = anchor_enid("Ver" , 
			[
				"class"	=>	'strong white ver_detalle_ticket blue_enid_background',
				"id"	=>	$id_ticket
			]);


		$num_tareas_pendientes =  $row["num_tareas_pendientes"];


		$l.= "<tr>";	    
			$l.= 
			get_td($lista_status[$status].icon($class_estatus_iconos[$status]),
				["class"=> $class_estatus[$status]]);		   
		    $l.= get_td($btn_mas_info);		  
		    $l.= get_td($num_tareas_pendientes);		   
		    $l.= get_td($nombre_departamento);
		    $l.= get_td($proyecto , ["class"=>'white']);		  
		    $l.= get_td($asunto);                      
		    $l.= get_td($fecha_ultima_solicitud . " días". "".$fecha_ultima_solicitud_text);		    
		$l.= "</tr>";
	}
?>



<div class='row'>
	
	<div class='col-lg-6'>				
		<?=anchor_enid('Abrir ticket', 
		[
			"class" => "btn input-sm solicitar_desarrollo_form"
		] ,
		0 ,
		1 )?>
		

	</div>		
	<div class="col-lg-6">
		<div class="pull-right">
			
			<?=label("Mostrar" , ["class"=>"strong black"])?>
			<select class='estatus_tickets text-center input-sm'>
				<option value='' >
					-
				</option>
				<option value='0' <?=evalua_status_ticket(0 , $status_solicitado)?> >
					Abierto
				</option>					
				<option value='2' <?=evalua_status_ticket(2 , $status_solicitado)?> >
					Visto
				</option>
				<option value='1' <?=evalua_status_ticket(1 , $status_solicitado)?> >
					Cerrado
				</option>
			</select>					
		</div>
	</div>
</div>

<div class="contenedor_listado_info">
	<?=$this->load->view("../../../view_tema/header_table");?>                                  
		<?=$l;?>
	<?=$this->load->view("../../../view_tema/footer_table")?>               
</div>
<!--
<style type="text/css">
.estado_abierto{
	background: #041E7B!important;
	color: white;
}.estado_cerrado{
	background: #0594FE!important;
	color: white;
}.estado_visto{
	background: #F94206 !important;
	color: white;
}
</style>
-->
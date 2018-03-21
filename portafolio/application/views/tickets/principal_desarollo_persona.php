<?php	
	
	$extra_titulos = "class='blue_enid_background white' style='font-size:.8em;' ";	
	$l =  "";
	$l.= "<tr>";	    	    
	    $l.= get_td("Estado", "class='blue_enid_background white' style='font-size:.8em;'  ");
	    $l.= get_td("Tareas",
	     "class='blue_enid_background white' style='font-size:.8em;'  ");
	    
	    $l.= get_td("Proyecto", $extra_titulos);	    
	    $l.= get_td("Departamento", $extra_titulos);
	    $l.= get_td("Asunto", $extra_titulos);
	    $l.= get_td(" Última solicitud", $extra_titulos);                      	   	 
	$l.= "</tr>";


	$dif_clientes = ["#0656F9","#2F58AB","black","#01b9af","#173A83","#2F58AB","black","#01b9af","#173A83",
					 "#2F58AB","black","#01b9af","#173A83","#2F58AB","black","#01b9af","#173A83",
					 "#2F58AB","black","#01b9af","#173A83","#2F58AB","black","#01b9af","#173A83" ,
					 "#2F58AB","black","#01b9af","#173A83","#2F58AB","black","#01b9af","#173A83" ,
					 "#2F58AB","black","#01b9af","#173A83","#2F58AB","black","#01b9af","#173A83",
					 "#2F58AB","black","#01b9af","#173A83","#2F58AB","black","#01b9af","#173A83" ];
	
	
	$tmp_cliente ="";
	$tmp_estilo_proyecto ="background:#0656F9!important";
	$zz =0;
	$lista_proyectos = [];

	foreach ($info_tickets as $row) {
		
		$fecha_registro = $row["fecha_registro"];
		$fecha_ultima_solicitud =  $row["fecha_ultima_solicitud"];
		$fecha_ultima_solicitud_text =  $row["fecha_ultima_solicitud_text"];


		$id_ticket = $row["id_ticket"];			
		$asunto = $row["asunto"];
		$status = $row["status"];
		$lista_status=["Abierto","Cerrado","Visto"];		
		$proyecto = $row["proyecto"];

		$class_estatus = ["estado_abierto" , "estado_cerrado" , "estado_visto" ];
		$class_estatus_iconos = ["fa fa-bars" , "fa fa-check" , "fa fa-eye"];

		$fecha_liberacion = $row["fecha_liberacion"];
		$nombre_departamento = $row["nombre_departamento"];
		$btn_mas_info ="<a class='strong white ver_detalle_ticket'

						id='".$id_ticket."' style='padding:2px;font-size:.8em;color:white!important;'>

							".$lista_status[$status]."
							<br>

							Ver tareas
						</a>";

		$num_tareas_pendientes =  $row["num_tareas_pendientes"];


		/**/


		if ($tmp_cliente != $proyecto){
			


			$tmp_cliente = $proyecto; 
			$tmp_estilo_proyecto ="background:".$dif_clientes[$zz]."!important;";

			$zz ++; 
		}
			


		$l.= "<tr>";	    



			
		    $l.= get_td( $btn_mas_info , "class='blue_enid_background' ");
		    $l.= get_td($num_tareas_pendientes ,  "style='font-size:.8em;' ");
		    $l.= get_td($proyecto ,  "style='font-size:.8em; $tmp_estilo_proyecto'
		    							class='blue_enid_background white' ");
		    $l.= get_td($nombre_departamento ,  "style='font-size:.8em;' ");
		    	

		    $l.= get_td($asunto ,  "style='font-size:.8em;' ");
                      		  

		    $l.= get_td($fecha_ultima_solicitud . " días". "<br>".$fecha_ultima_solicitud_text
		     ,  "style='font-size:.6em;' ");
		    
		$l.= "</tr>";
	}
?>



					

<div class='row'>
	
	<div class="col-lg-12 faq_btn" >
                        <div class="pull-right">
                            <a 
                              class="input-sm btn" 
                              href="../faq">
                                Preguntas frecuentes      
                                <i class="fa fa-info-circle">                                  
                                </i>
                            </a> 
                        </div>
	</div>   

	<div class='col-lg-6'>		
		
		<button class='btn 
					  input-sm 
					  solicitar_desarrollo_form' 
				style="background: black!important;">
			Abrir 
			ticket
		</button>

	</div>		
	<div class="col-lg-6">


		<div class="pull-right">
			<div>
				<label 
				style="font-size:.8em;" 
				class="strong black">
					Mostrar
				</label>	
			</div>
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
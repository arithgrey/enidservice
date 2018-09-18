
<?php 	
	$tb ="";
	foreach ($conceptos as $row){
		
		$funcionalidad =  $row["funcionalidad"];		
		$conceptos =  $row["conceptos"];				
		$tb.= "<table style='width:100%'>";
			$tb.= "<tr>";
				$tb.= "<td>";
					$tb.= "<span>".
							$funcionalidad."
							</span>";
				$tb.= "</td>";
				$tb.= "<td>";
					$tb.= "<table style='width:100%;margin-top:30px;' >";
					foreach ($conceptos as $row2){							
							
							$privacidad =$row2["privacidad"];
							$id_privacidad = $row2["id_privacidad"];
							$id_usuario = $row2["id_usuario"];
							
							$extra_seleccion = "";
							$termino_asociado =0;
							if ($id_usuario !=  null ) {
								$extra_seleccion = "checked";
								$termino_asociado =1;
							}

							$tb.= "<tr>";
								$tb.= "<td>";
									$tb.= "<input 
											id='".$id_privacidad."'
											class='concepto_privacidad' 
											termino_asociado ='".$termino_asociado."'
											type='checkbox' ".$extra_seleccion."
											>";
								$tb.= "</td>";
								$tb.= "<td>";
									$tb.= strtoupper($privacidad);
								$tb.= "</td>";
							$tb.= "</tr>";
						
					}
					$tb.= "</table>";					
				$tb.= "</td>";
			$tb.= "</tr>";
		$tb.= "</table>";

	}
?>
<?=$tb;?>
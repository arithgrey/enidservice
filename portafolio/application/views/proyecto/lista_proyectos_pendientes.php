<?php		
    $l =  "";
    $parte_extra = "class='blue_enid_background white' 
                        style='font-size:.8em;' ";
  	$l.= "<tr>";


  			$l.= get_td("<span class='white'>
                        Configurar
                	    </span>" ,$parte_extra);    

            

            $l.= get_td("<span class='white'>
                        Proyecto
                    </span>" ,$parte_extra);    

            
	        $l.= get_td("<span class='white'>
                        Tipo
                    </span>" ,$parte_extra);    

                    

            $l.= get_td("<span class='white'>
                            Status
                        </span>" , $parte_extra);                      

                         
            
   $l.= "</tr>";
   
	foreach($proyectos as $row){
		
			
		$id_proyecto  = $row["id_proyecto"];
		$proyecto  = $row["proyecto"];
		$fecha_registro  = $row["fecha_registro"];
		$url  = $row["url"];
		$url_img  = $row["url_img"];
		$status  = $row["status"];
		$id_servicio  = $row["id_servicio"];
		$nombre_servicio  = $row["nombre_servicio"];
		
		$extra_style ="style='font-size:.8em;' ";

		$lista_status = ["Pendiente de publicar", "Activo"];
		
		$btn_configuracion ="<i 
								href='#tab_modificar_proyecto' 
                            	data-toggle='tab'
								class='fa fa-cog btn_configuracion_proyecto' 
								id='".$id_proyecto."' >
							</i>";
		$l.= "<tr>";

			$l.= get_td($btn_configuracion , $extra_style);
			$l.= get_td($proyecto , $extra_style);
			$l.= get_td($nombre_servicio , $extra_style);
			$l.= get_td($lista_status[$status] , $extra_style);

		$l.= "</tr>";	

	}
?>


                               
<div class="contenedor_listado_info">
    <?=$this->load->view("../../../view_tema/header_table");?>
      <?=$l;?>
    <?=$this->load->view("../../../view_tema/footer_table")?>               
</div>
  
<style type="text/css">
    .blue_enid{
        font-size: .8em!important;
    }
</style>
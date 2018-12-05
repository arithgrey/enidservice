<?php 
    
    $id_recibo      =   $recibo[0]["id_proyecto_persona_forma_pago"];  
    $id_servicio    =   $recibo[0]["id_servicio"];


?>
	<br>

	
    <div class="container-fluid gedf-wrapper">
    
        <?=n_row_12()?>    	
    	   <?=div(heading_enid(icon("fa fa-map-marker") ."DIRECCIÓN DE ENTREGA" ) , 1)?>
        <?=end_row()?>
        <div class="row">
            <div class="col-md-3">
                <br>
                <?=div("TUS DIRECCIONES DE ENTREGA REGISTRADAS")?>                
                <?=agregar_nueva_direccion(0);?>                
                <div class="card">
                    <ul class="list-group list-group-flush">
                    	<?=create_lista_direcciones($lista_direcciones , $id_recibo)?>	
                    </ul>                
                </div>
                <br>
                <br>
                
                
                

            </div>
            <div class="col-md-6 gedf-main">            
                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                
                                <?=div(img(
                                    	[
                                    		"src" 	=> link_imagen_servicio($id_servicio) ,
                                    		"class"	=>	"rounded-circle",
                                    		"style"	=>	"width:50px!important;height:50px!important;"

                                    ]), 
                                ["class" 	=>	"mr-2" ])?>
                                <?=div(heading_enid(
                                    	"ORDEN #" .$recibo[0]["id_proyecto_persona_forma_pago"] ,  
                                    	5,
                                    	["class"	=>	"h5 m-0"]
                                    ), 
                                    ["class" => "ml-2" ]
                                )?>

                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <a class="card-link" href="#">
                            <h5 class="card-title">                            	
                        	DIRECCIÓN DE ENTREGA    	
                            </h5>
                        </a>
                        <p class="card-text">                        	
                        	<?=create_descripcion_direccion_entrega($domicilio)?>   
                            <?=valida_accion_pago($recibo)?>                         
                        </p>
                    </div>
                    
                </div>         

            </div>
            <div class="col-md-3">
                <br>
                <?=div("TUS PUNTOS DE ENCUENTRO REGISTRADOS")?>                
                <?=agregar_nueva_direccion(1);?>                
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <?=get_lista_puntos_encuentro($puntos_encuentro , $id_recibo)?>
                    </ul>                
                </div>
                <br>
                <br>
                
                
            </div>
        </div>
    </div>
    <form   class="form_registro_direccion" 
            action="../producto/?recibo=<?=$id_recibo?>&servicio=<?=$id_servicio?>" 
            method="post" >
        
    </form>
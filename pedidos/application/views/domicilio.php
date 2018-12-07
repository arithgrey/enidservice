<?php 
    
    $id_recibo      =   $recibo[0]["id_proyecto_persona_forma_pago"];  
    $id_servicio    =   $recibo[0]["id_servicio"];
    $num_ciclos = $recibo[0]["num_ciclos_contratados"];
?>
	<br>
    <div class="container-fluid gedf-wrapper">

        <div class="row">
            <div class="col-md-3">
                <br>
                <?=div("TUS DIRECCIONES DE ENTREGA REGISTRADAS", ["class" => "text_direcciones_registradas"])?>
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
                <?=div("TUS PUNTOS DE ENCUENTRO REGISTRADOS" , ["class" => "text_puntos_registrados"])?>
                <?=agregar_nueva_direccion(1);?>                
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <?=get_lista_puntos_encuentro($puntos_encuentro , $id_recibo , $domicilio)?>
                    </ul>                
                </div>
                <br>
                <br>
                
                
            </div>
        </div>
    </div>
    
    <form class="form_registro_direccion" action="../procesar/?w=1" method="POST">
       <?=input_hidden(["class" => "recibo" , "name" => "recibo", "value"=>  $id_recibo])?>
    </form>


    <form   class="form_puntos_medios" 
            action="../puntos_medios/?recibo=<?=$id_recibo?>"     
            method="POST">

           <?=input_hidden([            
            "name"  => "recibo" , 
            "value"=>  $id_recibo
           ])?>
    </form>
    <form   class="form_puntos_medios_avanzado"
            action="../puntos_medios/?recibo=<?=$id_recibo?>"
            method="POST">
        <?=input_hidden([
            "name"  => "recibo" ,
            "value"=>  $id_recibo
        ])?>
        <?=input_hidden([
            "name"  => "avanzado" ,
            "value"=>  1
        ])?>
        <?=input_hidden([
            "class" => "punto_encuentro_asignado" ,
            "name"  => "punto_encuentro" ,
            "value" =>  0
        ])?>

    </form>
<?php

    $id_recibo      =   $recibo[0]["id_proyecto_persona_forma_pago"];
    $id_servicio    =   $recibo[0]["id_servicio"];
    $num_ciclos     =   $recibo[0]["num_ciclos_contratados"];
    $id_error       =   "imagen_".$id_servicio;
?>
	<?=br()?>
    <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3">
                <?=br()?>
                <?=div("TUS DIRECCIONES DE ENTREGA REGISTRADAS", ["class" => "text_direcciones_registradas"])?>
                <?=agregar_nueva_direccion(0);?>
                <div class="card">
                    <?=ul(create_lista_direcciones($lista_direcciones , $id_recibo) , ["class"=>"list-group list-group-flush"])?>
                </div>
                <?=br(2)?>
            </div>
            <div class="col-md-6 gedf-main">
                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">

                                <?=div(img(
                                    	[
                                    		"src" 	    =>  link_imagen_servicio($id_servicio) ,
                                    		"class"	    =>	"rounded-circle",
                                    		"id"        =>  $id_error,
                                    		"onerror"   =>  "reloload_img( '".$id_error."','".link_imagen_servicio($id_servicio)."');",
                                    		"style"	    =>	"width:50px!important;height:50px!important;"

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
                                        <?=icon("fa fa-ellipsis-h")?>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?=create_descripcion_direccion_entrega($domicilio)?>
                        <?=valida_accion_pago($recibo)?>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <?=br()?>
                <?=div("TUS PUNTOS DE ENCUENTRO REGISTRADOS" , ["class" => "text_puntos_registrados"])?>
                <?=agregar_nueva_direccion(1);?>
                <?=div(ul([get_lista_puntos_encuentro($puntos_encuentro , $id_recibo , $domicilio)] , ["class"=>"list-group list-group-flush"]))?>
                <?=br(2)?>
            </div>
        </div>
    </div>
    <?=get_form_registro_direccion($id_recibo);?>
    <?=get_form_puntos_medios($id_recibo);?>
    <?=get_form_puntos_medios_avanzado($id_recibo);?>

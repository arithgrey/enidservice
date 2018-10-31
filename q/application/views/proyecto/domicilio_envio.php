<?php	
    /**/
    $id_recibo =  $param["id_recibo"];    
    $id_codigo_postal = 0;
    $direccion= "";
    $calle ="";
    $entre_calles= "";
    $numero_exterior= "";
    $numero_interior=  "";
    $cp= "";
    $asentamiento =  "";
    $direccion_envio ="";
    $municipio = "";
    $estado ="";
    $flag_existe_direccion_previa = 0;
    $pais ="";
    $direccion_visible ="style='display:none;'";
    $nombre_receptor =  "";
    $telefono_receptor = "";
    foreach ($info_envio_direccion as $row){

        $direccion =  $row["direccion"];
        $calle =  $row["calle"];
        $entre_calles =  $row["entre_calles"];
        $numero_exterior =  $row["numero_exterior"];
        $numero_interior =  $row["numero_interior"];
        $cp =  $row["cp"];
        $asentamiento =  $row["asentamiento"];
        $municipio  =  $row["municipio"];
        $estado = $row["estado"];        
        $flag_existe_direccion_previa ++;
        $direccion_visible ="";
        $id_codigo_postal = $row["id_codigo_postal"];
        $pais ="";        
        $nombre_receptor =  $row["nombre_receptor"];
        $telefono_receptor =  $row["telefono_receptor"];
    }
    /**/


    if($registro_direccion ==  0) {

        $nombre =  get_campo($info_usuario , "nombre");
        $apellido_paterno =  get_campo($info_usuario , "apellido_paterno");
        $apellido_materno =  get_campo($info_usuario , "apellido_materno");
        $nombre_receptor =  $nombre ." " .$apellido_paterno ." ".$apellido_materno;
        $telefono_receptor =  get_campo($info_usuario , "tel_contacto");
    }
?>
                                    
<div class='contenedor_informacion_envio'>        
    <?=heading_enid("DIRECCIÓN DE ENVÍO" , 2 , [] , 1)?>
    <div id='modificar_direccion_seccion' class="contenedor_form_envio">
    <hr>
    <form class="form-horizontal form_direccion_envio">
        <?=n_row_12()?>  
        <div class="row">
            <div class="col-lg-6">
                <?=div("Persona que recibe" , ["class"=>"titulo_enid_sm_sm"] )?>
                <?=input([
                    "maxlength"    =>"80",
                    "name"         =>"nombre_receptor",
                    "value"        => $nombre_receptor  ,
                    "placeholder"  =>"* Tu o quien más pueda recibir tu ,pedido",
                    "required"     =>"required" ,
                    "class"        =>"nombre_receptor" ,
                    "id"           =>"nombre_receptor",
                    "type"         =>"text"
                ])?>
                                        
            </div>              
            <div class="col-lg-6">
                <?=div("Teléfono" , ["class"=>"titulo_enid_sm_sm"] )?>
                <?=input([
                    "maxlength"     =>"12",
                    "name"          =>"telefono_receptor",
                    "value"         => $telefono_receptor  ,
                    "placeholder"   =>"* Algún número telefónico ",
                    "required"      =>"required" ,
                    "class"         =>"telefono_receptor" ,
                    "id"            =>"telefono_receptor",
                    "type"          =>"text"
                ])?>
            </div>                                    
        </div>    
        <?=end_row()?>
        <?=n_row_12()?>      
            <?=div("Código postal" , ["class"=>"titulo_enid_sm_sm"])?>  
            <?=input([
                "maxlength"         =>"5",
                "name"              =>"cp",
                "value"             => $cp ,
                "placeholder"       =>"* Código postal",
                "required"          =>"required" ,
                "class"             =>"codigo_postal" ,
                "id"                =>"codigo_postal",
                "type"              =>"text"
            ])?>
            <?=place('place_codigo_postal')?>
            <?=input_hidden(["name" => "id_usuario" , "value" => $id_usuario ])?>
        <?=end_row()?>
        <?=n_row_12()?>
            <?=div("Calle" , ["class"=>"titulo_enid_sm_sm"] )?>
            <?=input([
                        "class"         =>   "textinput address1" ,
                        "name"          =>   "calle" ,
                        "value"         =>   $calle,
                        "maxlength"     =>   "30" ,
                        "placeholder"   =>   "* Calle" ,
                        "required"      =>   "required" ,
                        "autocorrect"   =>   "off" ,
                        "type"          =>   "text"
            ])?>
        <?=end_row()?>
        <?=n_row_12()?>
            <?=div("Entre la calle y la calle, o información adicional" , 
            ["class"=>"titulo_enid_sm_sm"] )?>
            <?=input([
                "required"                  => true ,
                "class"                     =>"textinput address3 " ,
                "name"                      =>"referencia" ,
                "value"                     => $entre_calles ,
                "placeholder"               => "true",
                "Entre la calle y la calle, o información adicional" ,
                "type"                      =>"text"
            ])?>
        <?=end_row()?>
        <?=n_row_12()?>
            <div class="row">
                <div class="col-lg-6">
                    <?=div("Número Exterior" , ["class"=>"titulo_enid_sm_sm"] )?>
                    <?=input([
                        "class"           =>    "required numero_exterior",
                        "name"            =>    "numero_exterior" ,
                        "value"           =>    $numero_exterior,
                        "maxlength"       =>    "8" ,
                        "placeholder"     =>    "* Número Exterior" ,
                        "required"        =>    "true" ,
                        "type"            =>    "text"
                    ])?>                     
                                                
                </div>
                <div class="col-lg-6">
                    <?=div("Número Interior" , ["class"=>"titulo_enid_sm_sm"] )?>
                    <?=input([
                        "class"         =>       "numero_interior" ,
                        "name"          =>       "numero_interior" ,
                        "value"         =>       $numero_interior ,
                        "maxlength"     =>       "10"  ,
                        "autocorrect"   =>       "off" ,
                        "type"          =>       "text",
                        "required "     =>       "true"
                    ])?>                                            
                </div>
            </div>
        <?=end_row()?>    
        <div <?=$direccion_visible?> class="parte_colonia_delegacion">
            <?=n_row_12()?>
                <?=div("Colonia" ,  ["class"=>"titulo_enid_sm_sm"] )?>
                
                <?=div(input([
                            "type"          =>  "text" ,
                            "name"          =>  "colonia" ,
                            "value"         =>  $asentamiento ,
                            "readonly"      =>  true 
                        ]

                    ) , ["class"        =>"place_colonias_info"]) ?>
                
                <?=place('place_asentamiento')?>            
            <?=end_row()?>                                                  
            <?=n_row_12()?>
                <div class=" district delegacion_c">
                    <?=div("Delegación o Municipio" ,  ["class"=>"titulo_enid_sm_sm"])?>                    
                    <?=div(input([
                            "type"      =>   "text" ,
                            "name"      =>   "delegacion",
                            "value"     =>   $municipio ,
                            "readonly"  =>   true
                    ]), ["class"    =>   "place_delegaciones_info"])?>
                </div>
            <?=end_row()?>          
            <?=n_row_12()?>
                <div class=" district  estado_c">
                    <?=div("Estado" ,  ["class"=>"titulo_enid_sm_sm"])?>
                    <div class="place_estado_info">
                    <?=input([
                        "type"      =>   "text" ,
                        "name"      =>   "estado",
                        "value"     =>   $estado,
                        "readonly"  => "true"
                    ])?>                
                    </div>              
                </div>
            <?=end_row()?>                           
            <?=n_row_12()?>
                <div class=" district pais_c">
                    <?=div("País" ,  ["class"=>"titulo_enid_sm_sm"])?>
                    <?=place("place_pais_info")?>                       
                </div>
            <?=end_row()?>  
            <?=n_row_12()?>
                <div class="direccion_principal_c">
                    <?=div("Esta es mi dirección principal " , 
                    ["class"    =>  "titulo_enid_sm_sm"])?>
                                                
                    <select name='direccion_principal'>
                        <option value="1">SI</option>    
                        <option value="0">NO</option>
                    </select>
                </div>
                <?=input_hidden([
                    "name"    => "id_recibo", 
                    "value"   => $id_recibo, 
                    "class"   => "id_recibo" 
                ])?>                            
            <?=end_row()?> 
            <?=div(
                guardar("Registrar dirección " ,  
                ['class' =>     "text_btn_direccion_envio"]) , 
                ["class"=>"button_c"]
            )?>                    
            <?=place("notificacion_direccion" )?>
                                        
                                        
        </div>
    </form>
    </div>                                                             
</div>
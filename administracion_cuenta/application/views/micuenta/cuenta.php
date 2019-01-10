<div>
    <div class="col-lg-8" >
        <?=n_row_12()?>
            <div class="col-lg-5">
                <div  style="position: relative;">
                    <?=div(img([
                        "src"       =>  "../imgs/index.php/enid/imagen_usuario/".$id_usuario ,
                        "onerror"   =>  "this.src='../img_tema/user/user.png'"                    
                    ]),  ["class"   => "imagen_usuario_completa"])?>                
                    <?=anchor_enid("MODIFICAR" , ["class"=>"editar_imagen_perfil "] )?>
                </div>
                <?=place("place_form_img")?>
            </div>
        <?=end_row()?>
        

        <?=n_row_12()?>

            <div class="page-header menu_info_usuario" >
            <?=heading_enid("Cuenta" , 1 , ['class'=>'strong'] , 1)?>   
            <br>  
            <?=n_row_12()?>
                <form class="f_nombre_usuario">
                    <?=div('Nombre de usuario',  ['class'=> 'strong'] , 1)?>
                    <?=input([
                        "id"            =>  "nombre_usuario" ,
                        "name"          =>  "nombre_usuario" ,
                        "placeholder"   =>  "Nombre por cual te indentifican clientes y vendedores" ,
                        "class"         =>  "form-control input-sm input_enid nombre_usuario" ,
                        "required"      =>  true  ,
                        "type"          =>  "text",
                        "value"         =>  get_campo($usuario , 'nombre_usuario' ) ,
                        "maxlength"     =>  "15"
                    ])?>
                    <?=div(div("" , ['class'=>'registro_nombre_usuario']) , ['class'=> '"col-lg-7"'])?>
                </form>
              <?=end_row()?>



              <?=n_row_12()?>
                <form >
                    <?=div('Correo electrónico' , ['class' => 'strong'] , 1)?>                    
                    <?=input([
                            "id"            => "correo_electronico",
                            "name"          => "correo_electronico",
                            "placeholder"   => "El correo electrónico no se mostrará públicamente",
                            "class"         => "form-control input-sm input_enid correo_electronico",
                            "required"      => "",
                            "type"          => "text",
                            "value"         => get_campo($usuario , 'email' ),
                            "readonly"      =>  true 
                    ])?>
                    <?=div('El correo electrónico NO se mostrará públicamente', ['class'=> 'blue_enid '], 1)?>
                </form>
              <?=end_row()?>
              <br>

            
              <?=n_row_12()?>
                <form class="f_telefono_usuario">
                    <div class="row">                        
                        <?=div("Teléfon Movil" , ["class" => "col-lg-3 strong" ])?>                        
                        <div class ="col-lg-2" >
                            <?=input([
                                    "id"   => "lada",
                                    "name" => "lada",
                                    "placeholder" => "Lada",
                                    "class" => "form-control input-sm input_enid lada ",
                                    "required" => "",
                                    "type" => "text",
                                    "maxlength" => "3",
                                    "minlength" => "2",
                                    "value" => get_campo($usuario , 'tel_lada')
                            ])?>
                            <?=place("registro_telefono_usuario_lada")?>
                        </div>
                        <div class ="col-lg-5" >
                            <?=input([
                                "id"          => "telefono",
                                "name"        => "telefono",
                                "placeholder" => "Teléfono",
                                "class"       => "form-control input-sm input_enid telefono ",
                                "required"    => true,
                                "type"        => "text",
                                "maxlength"   => "13",
                                "minlength"   => "8",
                                "value"       => get_campo($usuario , 'tel_contacto')
                            ])?>
                            <?=div("" , ["class" => "registro_telefono_usuario" ])?>

                        </div>
                        <?=div(guardar("Actualizar", ["class"=>"input_enid"]) , ["class"=>"col-lg-2"])?>
                    </div>                                
                </form>
                <?=end_row()?>
              
              <?=n_row_12()?>
                    <form class="f_telefono_usuario_negocio">
                    <div class="row">
                       <?=div("Teléfono de negocio", ["class"=>"col-lg-3 strong"] )?>
                        <div class="col-lg-2">                                
                            <?=form_input(array(
                                        'name'          => 'lada_negocio',
                                        'id'            => 'lada',
                                        'value'         => get_campo($usuario , 'lada_negocio'),
                                        'maxlength'     => '3',
                                        'minlength'     => '2',
                                        'class'         => 'form-control input-sm input_enid lada_negocio lada2',
                                        'placeholder'   => "Lada" ,
                                        'type'          =>"text"
                                    )
                            );?>
                            <?=place("registro_telefono_usuario_lada_negocio")?>
                                
                        </div>
                        <div class="col-lg-5">
                                <?=form_input(array(
                                        'name'          => 'telefono_negocio',
                                        'id'            => 'telefono',
                                        'value'         => get_campo($usuario , 'tel_contacto_alterno'),
                                        'maxlength'     => '13',
                                        'minlength'     => '8',
                                        'class'         => 'form-control input-sm input_enid telefono telefono_info_contacto_negocio tel2',
                                        'placeholder'   => "El Teléfono de tu negocio" ,
                                        'type'          => "text"
                                    )
                                );?>                                
                            <?=place("registro_telefono_usuario_negocio")?>
                        </div>
                        <?=div(guardar("Actualizar", ["class"=>"input_enid"]) , ["class"=>"col-lg-2"])?>
                    </div>            
                    </form>                
              <?=end_row()?>
            </div>

        <?=end_row()?>
        <?=div("Mantén la calma esta información será solo será visible si tú lo permites "  , 
        ['class'=>'registro_telefono_usuario_lada_negocio blue_enid_background2 white padding_1'] , 1)?>
    </div>   
    
    <div class="col-lg-4">
        <div class="contenedor_lateral">
            <?=heading_enid("TU CUENTA ENID SERVICE" , 3)?>   
                <?=n_row_12()?>
                    <?=get_campo($usuario , "nombre" , "Tu Nombre")?>
                    <?=get_campo($usuario , "apellido_paterno" , "Tu prime apellido")?>
                    <?=get_campo($usuario , "apellido_materno" , "Tu prime apellido")?>            
                <?=end_row()?>
                <?=n_row_12()?>
                    <?=div(get_campo($usuario , "email" , "") , ["class" => "top_20"] , 1)?>
                <?=end_row()?>

                <?=n_row_12()?>
                    <?=get_campo($usuario , "tel_contacto" , "Tu prime apellido" , 1)?>
                <?=end_row()?>
                <br>
                <?=n_row_12()?>
                    <?=anchor_enid("MI DIRECCIÓN" . icon('fa  fa-fighter-jet') ,
                        [  "class"=>"a_enid_black btn_direccion top_20", 
                            "href"=>"#tab_direccion" ,  
                            "data-toggle"=>"tab" 
                        ] , 
                        1 ,
                        1)?>
                <?=end_row()?>
            <hr>
        </div>
    </div>
</div>

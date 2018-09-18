<div>
    <div class="col-lg-7" >
        <?=n_row_12()?>
            <div class="col-lg-5">
                <?=n_row_12()?>        
                    <div class="coach-card">            
                            <?=n_row_12()?>
                                <?=img([
                                    "src"=>"../imgs/index.php/enid/imagen_usuario/".$id_usuario ,
                                    "onerror"=>"this.src='../img_tema/user/user.png'"
                                ])?>

                            <?=end_row()?>     
                            <?=anchor_enid("ACTUALIZAR FOTO" , ["class"=>"a_enid_blue editar_imagen_perfil white" , "style"=>"color: white!important"] , 1)?>
                    </div>
                <?=end_row()?>
                <?=div("" , ["class"=>"place_form_img"] , 1)?>
                
            </div>
        <?=end_row()?>
        

        <?=n_row_12()?>
            <div class="page-header" >
            <?=heading_enid("Cuenta" , 1 , [] , 1)?>
              
              <?=n_row_12()?>
                <form class="f_nombre_usuario">
                    <?=label('Nombre de usuario', '', ['class'=> 'col-md-3 control-label'])?>
                    <?=input([
                        "id"            =>  "nombre_usuario" ,
                        "name"          =>  "nombre_usuario" ,
                        "placeholder"   =>  "Nombre por cual te indentifican clientes y vendedores" ,
                        "class"         =>  "form-control input-sm input_enid nombre_usuario" ,
                        "required"      =>  true  ,
                        "type"          =>  "text",
                        "value"         =>  entrega_data_campo($usuario , 'nombre_usuario' ) ,
                        "maxlength"     =>  "15"
                    ])?>
                    <?=div(div("" , ['class'=>'registro_nombre_usuario']) , ['class'=> '"col-md-7"'])?>
                </form>
              <?=end_row()?>



              <?=n_row_12()?>
                <form>
                    <?=label('Correo electrónico', '', ["class"=>"col-md-3 control-label" ] )?>
                        <div class="col-md-7">
                           <?=input([
                            "id"            => "correo_electronico",
                            "name"          => "correo_electronico",
                            "placeholder"   => "El correo electrónico no se mostrará públicamente",
                            "class"         => "form-control input-sm input_enid correo_electronico",
                            "required"      => "",
                            "type"          => "text",
                            "value"         => entrega_data_campo($usuario , 'email' ),
                            "readonly"      =>  true 
                            ])?>
                           <?=div('El correo electrónico NO se mostrará públicamente'  , [] , 1)?>
                        </div>
                </form>
              <?=end_row()?>

            
              <?=n_row_12()?>
                <form class="f_telefono_usuario">
                    <div>
                        
                        <?=div("Teléfon Movil" , ["class" => "col-md-3 control-label" ])?>
                        
                        <div class ="col-md-2" >
                            <?=input([
                                    "id"   => "lada",
                                    "name" => "lada",
                                    "placeholder" => "Lada",
                                    "class" => "form-control input-sm input_enid lada ",
                                    "required" => "",
                                    "type" => "text",
                                    "maxlength" => "3",
                                    "minlength" => "2",
                                    "value" => entrega_data_campo($usuario , 'tel_lada')
                            ])?>
                            <?=place("registro_telefono_usuario_lada")?>
                        </div>
                        <div class ="col-md-5" >

                            <?=input([
                                "id"          => "telefono",
                                "name"        => "telefono",
                                "placeholder" => "Teléfono",
                                "class"       => "form-control input-sm input_enid telefono ",
                                "required"    => true,
                                "type"        => "text",
                                "maxlength"   => "13",
                                "minlength"   => "8",
                                "value"       => entrega_data_campo($usuario , 'tel_contacto')
                            ])?>
                            <?=div("" , ["class" => "registro_telefono_usuario" ])?>

                        </div>
                        <?=div(guardar("Actualizar", ["class"=>"input_enid"]) , ["class"=>"col-lg-2"])?>
                    </div>                                
                </form>
                <?=end_row()?>
              
              <?=n_row_12()?>
                    <form class="f_telefono_usuario_negocio">
                    <div>
                       <?=div("Teléfono de negocio" ,["class"=>"col-md-3 control-label"] )?>                          
                        <div class="col-md-2">
                                
                            <?=form_input(array(
                                        'name'          => 'lada_negocio',
                                        'id'            => 'lada',
                                        'value'         => entrega_data_campo($usuario , 'lada_negocio'),
                                        'maxlength'     => '3',
                                        'minlength'     => '2',
                                        'class'         => 'form-control input-sm input_enid lada_negocio lada2',
                                        'placeholder'   => "Lada" ,
                                        'type'          =>"text"
                                    )
                            );?>
                            <?=place("registro_telefono_usuario_lada_negocio")?>
                                
                        </div>
                        <div class="col-md-5">
                                <?=form_input(array(
                                        'name'          => 'telefono_negocio',
                                        'id'            => 'telefono',
                                        'value'         => entrega_data_campo($usuario , 'tel_contacto_alterno'),
                                        'maxlength'     => '13',
                                        'minlength'     => '8',
                                        'class'         => 'form-control input-sm input_enid telefono telefono_info_contacto_negocio tel2',
                                        'placeholder'   => "El Teléfono de tu negocio" ,
                                        'type'          => "text"
                                    )
                                );?>
                                <?=div("" , ["class"=>"registro_telefono_usuario_negocio"] , 1)?>
                        </div>
                        <?=div(guardar("Actualizar", ["class"=>"input_enid"]) , ["class"=>"col-lg-2"])?>
                    </div>            
                    </form>                
              <?=end_row()?>
            </div>

        <?=end_row()?>
        <?=div("Mantén la calma esta información será solo será visible si tú lo permites "  , ['class'=>'registro_telefono_usuario_lada_negocio'] , 1)?>
    </div>   
    
    <div class="col-lg-5">
        <?=heading_enid("TU CUENTA ENID SERVICE" , 3)?>
        <div>
            <p style="text-decoration: underline">
                <?=entrega_data_campo($usuario , "nombre" , "Tu Nombre")?>
                <?=entrega_data_campo($usuario , "apellido_paterno" , "Tu prime apellido")?>
                <?=entrega_data_campo($usuario , "apellido_materno" , "Tu prime apellido")?>
            </p>
            <?=n_row_12()?>
                <?=entrega_data_campo($usuario , "email" , "Tu prime apellido")?>
            <?=end_row()?>
            <?=n_row_12()?>
                <?=entrega_data_campo($usuario , "tel_contacto" , "Tu prime apellido" , 1)?>
            <?=end_row()?>
        </div>
        <?=anchor_enid("MI DIRECCIÓN" . icon('fa  fa-fighter-jet') , ["class"=>"a_enid_black btn_direccion", "href"=>"#tab_direccion" ,  "data-toggle"=>"tab" ] , 1 )?>
        <hr>
    </div>
</div>

    <div class="seccion_registro_nuevo_usuario_enid_service">                
        <?=n_row_12();?>            
                <?=anchor_enid(
                  "ACCEDER AHORA" , 
                  [ 
                    "class"   =>    "btn_acceder_cuenta_enid a_enid_blue" , 
                    "id"      =>    "btn_acceder_cuenta_enid",
                    'style'   =>    "color:white!important"

                    ] , 
                    1)?>    
                <?=n_row_12()?>
                    <div class="col-lg-4 col-lg-offset-4">
                    <?=div(
                        anchor_enid(img(["src"    =>  "../img_tema/enid_service_logo.jpg"])) , 
                        ["class"  =>  "col-lg-6 col-lg-offset-3"]
                    )?>
                    </div>
                <?=end_row()?>
                
                <?=n_row_12()?>                
                <div class="col-lg-4 col-lg-offset-4">
                    <?=heading('ÚNETE A ENID SERVICE', '3')?>            
                    
                </div>                      
            <?=end_row()?>       

                <?=n_row_12()?>
                    <div class="col-lg-4 col-lg-offset-4">  
                      <form class="form-miembro-enid-service" id='form-miembro-enid-service'>        
                            <?=input([                
                                
                                "name"        =>    "email", 
                                "placeholder" =>    "CORREO ELECTRÓNICO" ,
                                "class"       =>    "form-control input-sm email email",
                                "type"        =>    "email",
                                "required"    =>    true,
                                "onkeypress"  =>    "minusculas(this);" ] , 1)?>    

                            <?=place("place_correo_incorrecto")?>
                                    
                            <?=input([                
                                "name"        =>"nombre" ,
                                "placeholder" =>"TU NOMBRE" ,
                                "class"       =>"form-control input-sm  nombre nombre_persona",
                                "type"        =>"text",
                                "required"    =>  true ],
                            1)?>
                            <?=place("place_nombre_info")?>
                                
                            <?=input([
                                "id"            => "password" ,
                                "placeholder"   => "UNA CONTRASEÑA " ,
                                "class"         => "form-control input-sm password",
                                "type"          => "password",
                                "value"         => "" ,
                                "required"      => true  ] , 
                            1)?>  
                            <?=place("place_password_afiliado")?>
                            <?=guardar('Registrar')?>  
                      </form>
                      <?=place("place_registro_miembro")?>
                    
  
                    </div>
                <?=end_row()?>
            
        <?=end_row()?>
    </div>

    <!--RECUPERAR CONTRASEÑA-->
    <div class="contenedor_recuperacion_password" style="display: none;">
        <?=n_row_12();?>
        
            <?=anchor_enid("ACCEDER AHORA!" , 
                    [   
                        "class"    =>   "btn_acceder_cuenta_enid a_enid_blue",
                        "id"       =>   "btn_acceder_cuenta_enid",
                        "style"    =>   "color: white!important"
                    ] , 
                    1
                    );?>                    
            <?=n_row_12()?>
                <div class="col-lg-4 col-lg-offset-4">
                    <?=div(img(["src"    =>  "../img_tema/enid_service_logo.jpg"]), 
                               ["class"  =>  "col-lg-6 col-lg-offset-3"])?>
                </div>
            <?=end_row()?>
            
            <?=n_row_12()?>                
                <div class="col-lg-4 col-lg-offset-4">
                    <?=heading('RECUPERA TUS DATOS DE ACCESO', '3')?>            
                    <form class='form-pass' id='form-pass' action='<?=url_recuperacion_password()?>'>
                        <?=input([
                                "type"        =>    "email" ,
                                "id"          =>    "email_recuperacion" ,
                                "name"        =>    'mail' ,
                                "placeholder" =>    "Email"  ,
                                "class"       =>    "form-control input-sm" ,
                                "required"    =>    true  ]);?>                            
                        <?=div(
                                "Ingresa tu correo electrónico para que tu contraseña 
                                pueda ser enviada" ,  
                                ["class" => 'msj-recuperacion'] , 
                                1
                            )?>                                
                        <?=guardar("Enviar" , 
                            ["class"    =>  "btn_nnuevo recupera_password btn a_enid_blue"])?>    
                            
                    </form>  
                    <?=place("place_recuperacion_pw")?>
                    <?=place("recuperacion_pw")?>                    
                </div>                      
            <?=end_row()?>       
        <?=end_row()?>
    </div>        

    <!--ACCEDER-->  
    <div class="wrapper_login" >            
        <?=n_row_12();?>         
            <?=anchor_enid(
                "SOY NUEVO, CREAR UNA CUENTA!" ,
                ["class"    =>  "btn_soy_nuevo",
                "style"    =>  "color: white!important;"] , 1);?>        

            <?=n_row_12()?>
              <div class="col-lg-4 col-lg-offset-4">
                <div class="col-lg-6 col-lg-offset-3">

                    <?=anchor_enid(
                        img(
                        ["src"  =>  "../img_tema/enid_service_logo.jpg" ]) , 
                        ["href" =>  "../"] , 
                    1)?>                    
                </div>
                
              </div>

            <?=end_row()?>







            <?=n_row_12()?>
                <div class="col-lg-4 col-lg-offset-4">
                    <form 
                        <?=add_attributes([
                            "class"     =>      "form_sesion_enid" ,
                            "id"        =>      "in"  ,
                            "method"    =>      "POST" ,
                            "action"    =>      
                            base_url('index.php/api/sess/start/format/json')]);?> >

                        <?=input([
                            "name"      =>  get_random() , 
                            "value"     =>  get_random() ,  
                            "type"      =>  "hidden"]);?>
                        
                        <?=input([
                            "type"      =>  'hidden' ,
                            "name"      =>  'secret' ,
                            "id"        =>  "secret"])?>    
                                            
                        <?=input([
                            "class"         => 'form-control input-sm ' ,
                            "type"          => "mail" ,
                            "name"          => 'mail' ,
                            "id"            => "mail"                    ,
                            "onkeypress"    => "minusculas(this);" ,
                            "placeholder"   => "TU CORREO ELECTRÓNICO"
                            ] , 1 )?>   
                                     
                        <?=input([
                            "type"          =>  "password" ,
                            "placeholder"   =>  "Tu contraseña" ,
                            "name"          =>  'pw' ,
                            "id"            =>  "pw"] , 1);?>       
                            
                        <?=add_element( 
                            "INICIAR SESIÓN" , 
                            "button" , 
                            ['class' => 'a_enid_blue'] , 
                            1);?>  
                               
                    </form>                          
                </div> 
            <?=end_row()?> 
            
            <?=n_row_12()?> 
                <div class="col-lg-4 col-lg-offset-4">
                    <?=place("place_acceso_sistema top_20 bottom_20" )?>
                    <?=anchor_enid(
                        "¿OLVIDASTE TU CONTRASEÑA?", 
                        [
                            "id"      => "olvide-pass",
                            "class"   => "recupara-pass  olvide_pass "
                        ] , 
                        1 
                    );?>                                
                    <?=anchor_enid( 
                         div(strong("¿ERES NUEVO?" , ["class" => "black"]) ."  REGISTRA UNA AHORA!" , ['class' => 'llamada-a-la-accion '])
                        , 
                        ['class' => 'registrar-cuenta registrar_cuenta']  
                    )?>
                    
                    <?php if( $action === "registro"){?>                
                        <?=div("COMPRA O VENDE ACCEDIENDO A TU CUENTA!" , 
                        ["class" => "mensaje_bienvenida"])?>                            
                    <?php } ?> 
                </div>
            <?=end_row()?> 


        <?=end_row()?>
    </div>
    <?=input_hidden(
        [
            "class" =>  "action" , 
            "value" =>  $action ] , 
        1
    );?>
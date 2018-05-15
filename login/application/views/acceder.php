    <?=n_row_12()?>
        <div class="text-right">
            <a class="btn_soy_nuevo" style="color: white!important;">                
                SOY NUEVO, CREAR UNA CUENTA!
            </a>
        </div>
    <?=end_row()?>
    <?=n_row_12()?>
      <div class="col-lg-4 col-lg-offset-4">
        <div class="col-lg-6 col-lg-offset-3">
          <img src="../img_tema/enid_service_logo.jpg" style="width: 100%">
        </div>
      </div>
    <?=end_row()?>

    <?=n_row_12()?>
        <hr style="margin-top: 0px!important;margin-bottom: 0px!important;">
    <?=end_row()?>

    <div class="col-lg-4 col-lg-offset-4">
        <?=n_row_12()?>
        <div class="row">
            <form 
                class="form_sesion_enid" 
                id="in" method="POST"
                action="<?=base_url('index.php/api/sessionrestcontroller/start/format/json')?>">
                <input name="<?=get_random()?>" value="<?=get_random()?>-1" type="hidden">
                <input type='hidden' name='secret' id="secret">            
                <div class="col-lg-12">
                    <input 
                    type="mail" 
                    name='mail' 
                    id="mail"                    
                    onkeypress="minusculas(this);" 
                    placeholder="TU CORREO ELECTRÓNICO">
                </div>
                <br>
                <div class="col-lg-12">
                    <input type="password" placeholder="Tu contraseña" name='pw' id="pw">
                </div>                
                <div class="col-lg-12">
                    <button 
                        style="background: #0003E1!important;
                        width:100%;padding:10px;color: white;">
                        INICIAR SESIÓN
                    </button>
                </div>
                <div>                       
                    <?php if( $action === "registro"){?>                
                        <div style="margin-top: 15px;background: #010c26;color: white;padding: 10px;">
                            Felicidades ahora puedes comprar y vender desde
                            Enid Service.
                            <br>
                            Accede a tu cuenta ahora!
                        </div>                        
                    <?php } ?>
                </div>
            </form>
            
            <?=n_row_12()?>
                <div style="margin-top: 10px;">
                    <center>
                        <a type="button" 
                           id='olvide-pass' 
                           class="recupara-pass" 
                           style="font-size: 1.2em;color: #075893;">                            
                            ¿OLVIDASTE TU CONTRASEÑA?
                        </a>
                    </center>
                </div>
                <div style="margin-top: 10px;">
                    <center>
                        <a class="btn_soy_nuevo_simple">                    
                            <span style="color: #696969;">
                                ¿NO TIENES UNA CUENTA?  
                            </span>
                            <strong style="color: black;">
                                ACCEDER AHORA
                            </strong>
                        </a>
                    </center>
                </div>

            <?=end_row()?>
            <?=n_row_12()?>
                <div class="place_acceso_sistema">
                </div>
            <?=end_row()?>
        </div>    
        <?=end_row()?>
    </div>
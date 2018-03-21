<main>
<?=n_row_12()?>
    <div class="seccion_registro_nuevo_usuario_enid_service">        
        <?=$this->load->view("form_persona")?>
    </div>
<?=end_row()?>
<?=n_row_12()?>
    <div class="contenedor_recuperacion_password" style="display: none;">
        <?=n_row_12()?>
            <div class="text-right">
                <a  class="btn_acceder_cuenta_enid a_enid_blue" 
                    id="btn_acceder_cuenta_enid"
                   
                     style="color: white!important">
                    Acceder ahora!
                </a>
            </div>
        <?=end_row()?>

        <div class="col-lg-4 col-lg-offset-4">
            <h3 style="font-weight: bold;font-size: 3em;">      
                RECUPERA TUS DATOS DE ACCESO
            </h3>
            <div id='contenedor-form-recuperacion'>
                <p>
                    <strong class='msj-recuperacion'>
                        Ingresa tu correo electrónico para que tu contraseña pueda ser enviada                 
                    </strong>
                </p>
                <form class='form-pass' id='form-pass' action='<?=url_recuperacion_password()?>' >
                    <input 
                        type="email" 
                        id="email_recuperacion" 
                        name='mail' 
                        placeholder="Email"  class="form-control input-sm" required>
                    <br>
                    <button class="btn_nnuevo recupera_password btn a_enid_black">
                        Enviar          
                    </button>       
                </form>    
                <div class='place_recuperacion_pw'>
                </div>
                <div class='recuperacion_pw'>
                </div>                
            </div>
        </div>
    </div>
    
<?=end_row()?>
<div class="wrapper wrapper_login" >
    <?=n_row_12()?>
        <div class="text-right">
            <a class="btn_soy_nuevo" style="color: white!important;">
                Soy nuevo, crear cuenta!
            </a>
        </div>
    <?=end_row()?>


    <div class="col-lg-4 col-lg-offset-4">

        <div>
        <h3 style="font-weight: bold;font-size: 3em;">      
          Ingresa a tu cuenta
        </h3>
        <center>
            <form 
                class="form_sesion_enid"  
                id="in" 
                method="POST"
                action="<?=base_url('index.php/api/sessionrestcontroller/start/format/json')?>">
                <input 
                type="mail" 
                name='mail' 
                id="mail"
                onkeypress="minusculas(this);" placeholder="Tu email">
                <input type="password" placeholder="Tu contraseña" name='pw' id="pw">
                <input type='hidden' name='secret' id="secret">            
                <input name="<?=get_random()?>" value="<?=get_random()?>1" type="hidden">            
                <button type="submit" id="login-button">Login</button>
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
        </center>
        <div class='text-right'>
            <a type="button" 
               id='olvide-pass' 
               class="recupara-pass  text-left a_enid_blue" style="color: white!important">
                Olvidé mi contraseña                              
            </a>
        </div>
        <div class="place_acceso_sistema">
        </div>
    </div>    
</div>

</main>
<link rel="stylesheet" type="text/css" href="../css_tema/template/login.css">
<input type="hidden" class="action" value="<?=$action?>">
<script src="<?=base_url('application/js/sha1.js');?>">
</script>
<script type="text/javascript" src="<?=base_url('application/js/ini.js')?>">
</script>


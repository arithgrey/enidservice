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
                    ACCEDER AHORA!
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
            <h3 style="font-weight: bold;font-size: 2em;">      
                RECUPERA TUS DATOS DE ACCESO
            </h3>
            <div id='contenedor-form-recuperacion'>
                
                <form 
                    class='form-pass' id='form-pass' 
                    action='<?=url_recuperacion_password()?>'>
                    <input 
                        type="email" 
                        id="email_recuperacion" 
                        name='mail' 
                        placeholder="Email"  class="form-control input-sm" required>
                    <br>
                    <p>
                        <strong class='msj-recuperacion'>
                            Ingresa tu correo electrónico para que tu contraseña pueda ser enviada                 
                        </strong>
                    </p>
                    <button class="btn_nnuevo recupera_password btn a_enid_black"
                        style="width: 100%;">
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
    <?=$this->load->view("acceder")?>
</div>
    
</main>
<link 
rel="stylesheet" type="text/css" 
href="../css_tema/template/login.css?<?=version_enid?>">
<input type="hidden" class="action" value="<?=$action?>">
<script src="<?=base_url('application/js/sha1.js');?>?<?=version_enid?>">
</script>
<script type="text/javascript" src="<?=base_url('application/js/ini.js')?>?<?=version_enid?>">
</script>


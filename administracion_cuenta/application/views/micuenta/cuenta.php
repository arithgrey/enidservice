<div>
    <div class="col-lg-7" >
        <?=n_row_12()?>
            <div class="col-lg-5">
                <?=n_row_12()?>        
                    <div class="coach-card">            
                            <?=n_row_12()?>
                                <img 
                                src="../imgs/index.php/enid/imagen_usuario/<?=$id_usuario?>" 
                                 width="100%"
                                 onerror="this.src='../img_tema/user/user.png'">
                            <?=end_row()?>     
                            <?=n_row_12()?>
                                <a  class="a_enid_blue editar_imagen_perfil white" style="color: white!important">
                                    ACTUALIZAR FOTO
                                </a>
                            <?=end_row()?>
                    </div>
                <?=end_row()?>
                <?=n_row_12()?>        
                    <div class="place_form_img">            
                    </div>
                <?=end_row()?>
            </div>
        <?=end_row()?>
        

        <?=n_row_12()?>
            <div class="page-header" >
              <h1>
                Cuenta                
              </h1>
              
              <?=n_row_12()?>
                <form class="f_nombre_usuario">
                    <div>
                        <label 
                        class="col-md-3 control-label" 
                        for="textinput">Nombre de usuario
                        </label>  
                        <div class="col-md-7">
                            <input 
                                id="nombre_usuario" 
                                name="nombre_usuario" 
                                placeholder="Nombre por cual te 
                                indentifican clientes y vendedores" 
                                class="form-control input-sm input_enid nombre_usuario" 
                                required="" 
                                type="text"
                                value="<?=entrega_data_campo($usuario , 'nombre_usuario' )?>" 
                                maxlength="15">
                            <span class="registro_nombre_usuario">
                            </span>
                        </div>
                    </div>            
                </form>
              <?=end_row()?>



              <?=n_row_12()?>
                <form>
                    <div>
                        <label 
                            class="col-md-3 control-label" 
                            for="textinput">
                            Correo electrónico
                        </label>  
                        <div class="col-md-7">
                            <input 
                                id="correo_electronico" 
                                name="correo_electronico" 
                                placeholder="El correo electrónico no se mostrará públicamente" 
                                class="form-control input-sm input_enid correo_electronico" 
                                required="" 
                                type="text"
                                value="<?=entrega_data_campo($usuario , 'email' )?>"
                                readonly>
                            <span>
                                El correo electrónico
                                <strong>NO</strong> 
                                se mostrará públicamente
                            </span>
                        </div>
                    </div>            
                </form>
              <?=end_row()?>

            <div style="margin-top: 30px;"></div>
              <?=n_row_12()?>
                <form class="f_telefono_usuario">
                    <div>
                        <label 
                            class="col-md-3 control-label" 
                            for="textinput">
                            Teléfono Movil  
                        </label>  
                        
                        <div class="col-md-2">
                                <input id="lada" 
                                name="lada" 
                                placeholder="Lada" 
                                class="form-control input-sm input_enid lada " 
                                required="" 
                                type="text"
                                maxlength="3"
                                minlength="2"
                                value="<?=entrega_data_campo($usuario , 'tel_lada')?>">
                                <span class="registro_telefono_usuario_lada"> 
                                </span>
                            
                        </div>
                        <div class="col-md-5">

                            <input id="telefono" 
                                name="telefono" 
                                placeholder="Teléfono" 
                                class="form-control input-sm input_enid telefono telefono_info_contacto" 
                                required
                                type="text"
                                maxlength="13"
                                minlength="8"
                                value="<?=entrega_data_campo($usuario , 'tel_contacto')?>">
                                <span class="registro_telefono_usuario"> 
                                </span>
                            
                        </div>
                        <div class="col-lg-2">
                            <button class="input_enid"> 
                                Actualizar
                            </button>
                        </div>
                    </div>                                
                </form>
                <?=end_row()?>
              <div style="margin-top: 30px;"></div>
              <?=n_row_12()?>
                    <form class="f_telefono_usuario_negocio">
                    <div>
                        <label 
                            class="col-md-3 control-label" 
                            for="textinput">
                            Teléfono de negocio
                        </label>                          
                        <div class="col-md-2">
                                <input id="lada" 
                                name="lada_negocio" 
                                placeholder="Lada" 
                                class="form-control input-sm input_enid lada_negocio "
                                type="text"
                                maxlength="3"
                                minlength="2"
                                value="<?=entrega_data_campo($usuario , 'lada_negocio')?>">
                                <span class="registro_telefono_usuario_lada_negocio"> 
                                </span>
                        </div>
                        <div class="col-md-5">
                            <input id="telefono" 
                                name="telefono_negocio" 
                                placeholder="El Teléfono de tu negocio" 
                                class="form-control input-sm input_enid telefono telefono_info_contacto_negocio"                                 
                                type="text"
                                maxlength="13"
                                minlength="8"
                                value="<?=entrega_data_campo($usuario , 'tel_contacto_alterno')?>">
                                <span class="registro_telefono_usuario_negocio"> 
                                </span>
                        </div>
                        <div class="col-lg-2">
                            <button class="input_enid"> 
                                Actualizar
                            </button>
                        </div>
                    </div>            
                    </form>                
              <?=end_row()?>
            </div>

        <?=end_row()?>
        <?=n_row_12()?>
            <center>
                <span class="strong">
                    Mantén la calma esta información será solo será visible si tú lo permites 
                </span>
            </center>
        <?=end_row()?>
                    
    </div>   
    
    <div class="col-lg-5">
        <h3 style="font-weight: bold;font-size: 3em;">                                      
            TU CUENTA ENID SERVICE
        </h3>
        <div>
            <p style="font-size: 1.2em; font-weight: bold;text-decoration: underline">
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
        <?=n_row_12()?>
            <div style="margin-top: 20px;">
                <a class="a_enid_black btn_direccion" href="#tab_direccion" data-toggle="tab" >
                    MI DIRECCIÓN 
                    <i class="fa  fa-fighter-jet"></i>
                </a>
            </div>
        <?=end_row()?>
        <hr>
        
    </div>
</div>
<style type="text/css">
.coach-card{
    background-color:#04112f;
    text-align: center;        
    padding: 5px;
}
.coach-card .coach-img{
    width: 100px;
    border: 1.3px white solid;
    border-radius: 100%;
    margin-bottom: 9.6px;
}
.coach-card .coach-info{
    text-align: left;
    margin-bottom: 46px;
}
.coach-card .coach-info .coach-info-text{
    margin-left: 25px;
}
.coach-card .coach-info .sep-line{
    border-color: #336699;
}
.coach-card .coach-info .coach-info-text .grey-text{
    color: #6699cc;
}
.coach-card .coach-info .coach-info-text .white-text{
    color: #ffffff;
    font-size: 1.2em;
}

.coach-card .coach-details{
    background-color: #E6E6FA;
    padding-top: 24px;
}
.coach-card .coach-details .coach-name{
    font-size: 1.5em;
    color: #6699cc;
}
.coach-card .coach-details .coach-job{
    color: #ccccff;
}
.coach-card .coach-desc{
    text-align: center;
    position: relative;
    background-color: white;
    padding-left: 15px;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}
.coach-card .coach-desc .tarrif{
    padding-top: 27px;
    text-align: left;
    border-right: 1px solid #E6E6FA;
    border-bottom: 1px solid #E6E6FA;
    padding-bottom: 22px;
}
.coach-card .coach-desc .tarrif-no-right{
    padding-top: 27px;
    text-align: left;
    border-bottom: 1px solid #E6E6FA;
    padding-bottom: 22px;
}
.coach-card .coach-desc .pers-count{
    font-size: 0.92em;
    color:#E6E6FA;
}
.coach-card .coach-desc .pers-tarrif{
    font-size: 1.4em;
    font-weight: bold;
    color: #163f99;
}
.coach-card .coach-desc .coach-desc-text{
    padding-top: 27px;
    padding-left: 28px;
    padding-bottom: 41px;
    font-size: 1em;
    color: #163f99;
    text-align: justify;
    max-width: 308px;
}

.coach-card .coach-desc .coach-reserve-btn{
    position: relative;
    width: 200px;
    height: 33px;
    margin-left: 66px;
    top: 16.5px;
}
</style>


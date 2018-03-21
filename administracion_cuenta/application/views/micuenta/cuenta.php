<div>
    <div class="col-lg-3">

        <?=n_row_12()?>        
            <div class="coach-card">            
                    <?=n_row_12()?>
                        <img src="../imgs/index.php/enid/imagen_usuario/<?=$id_usuario?>" 
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
    <div class="col-lg-4">
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
                <a class="a_enid_black" href="#tab_direccion" data-toggle="tab" >
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
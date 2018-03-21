
<div class="row">
    <div class="col-sm-4">
        <div class="place_form_img">            
        </div>
        
        <div class="coach-card">
            
            <div style="padding: 10px;">
                <div class="text-left">
                    <i class="fa fa-pencil editar_imagen_perfil white">
                    </i>
                </div>
                <img 
                    src="../imgs/index.php/enid/imagen_usuario/<?=$id_usuario?>" 
                    width="100%"
                    onerror="this.src='../img_tema/user/user.png'"
                    >
            </div>            
            <div class="row coach-info">                
                <div class="col-md-12">
                    <div class="coach-info-text">
                        <span class="grey-text white">
                           <?=get_resumen_cuenta($info_usuario)?>
                        </span>
                        
                    </div>
                    
                </div>
            </div>


            <div class="coach-details">
                <div class="row">
                   <br><br>
                </div>
            </div>
            
        </div>
    </div>
    <div class="col-lg-2">
         
    </div>
    <div class="col-lg-6">
        <?=get_resumen_cuenta($info_usuario)?>
        <p class="black strong" style="font-size: .9em;">
            Detalles
        </p>    
        
        <?=n_row_12()?>
            <span style="font-size:.8em;">
                Número de Servicios/Productos
                <a href="../area_cliente" class="blue_enid strong">                 
                    (<?=$num_proyectos?>)                   
                    ver
                </a>
            </span>
        <?=end_row()?>

        <?=n_row_12()?>
            <span style="font-size:.8em;">
                Tickets de soporte:
                <a href="../area_cliente" class="blue_enid strong">                 
                    (<?=$num_tickets?>)                 
                    ver
                </a>
            </span>
        <?=end_row()?>


        <?=n_row_12()?>
            <span style="font-size:.8em;">
                Tareas de soporte:
                <a href="../area_cliente" class="blue_enid strong">                 
                    (<?=$num_tareas?>)                  
                    ver
                </a>
            </span>
        <?=end_row()?>
    </div>



</div>

<style type="text/css">
    .coach-card{
    background-color:#163f99;
    text-align: center;
    padding-top: 80px;
    border-radius: 12px;
    width: 364px;
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
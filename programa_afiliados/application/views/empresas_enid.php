<main>    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
    </script>
    <br>
    <div class="col-lg-2" >       
        <?=$this->load->view("menu")?>
    </div>
    <div class='col-lg-10'>
        <div class="tab-content">                        
            <div class="tab-pane active" id='tab_productividad_ventas'>           
                
                <div style="width: 100%;">
                    <div 
                    class="place_metricas_afiliado" 
                    id="place_metricas_afiliado" 
                    style="width: 100%; height: 300px;">                    
                    </div>
                    <label>
                        Ganancias acumuladas: <?=$ganancias["ganancias"]?> 
                        MXN
                        <i class="fa fa-money"></i>
                    </label>


                    <div id="sum_box" class="row mbl">
                        <div class="col-sm-6 col-md-3">
                            <div class="panel income db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-money">                    
                                        </i>
                                    </p>
                                    <h4 class="value white">
                                        <span>0
                                        </span>
                                        <span>MXN
                                        </span>
                                    </h4>
                                    <p class="description">
                                        Saldo total
                                    </p>                                  
                                </div>
                            </div>
                        </div>                            
                        <div class="col-sm-6 col-md-3">
                            <div class="panel income db mbm" style="background: #0a8c7e!important">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="fa fa-shopping-bag">                    
                                        </i>
                                    </p>
                                    <a href="../search">
                                        <h4 class="value white" style="font-size:.9em!important;">
                                            <span >
                                                Promocionar                                                ahora!
                                            </span>                                            
                                        </h4>
                                        <p class="description">
                                            Productos
                                        </p> 
                                    </a>
                                </div>
                            </div>
                        </div> 



                    </div>
                    
                    <div>
                      <span class="strong informe_ventas">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                        Informe ventas mensual
                      </span>
                    </div>
                    <div class="ventas_usuario">                        
                    </div>                
                </div>                    
            </div>   
            <!---->
            <div class="tab-pane" id='tab_pagos_realizados'>
                <div class="place_info_cuentas_pago">                    
                </div>
            </div>              
            
            <div class="tab-pane" id='tab_videos_disponibles'>
                    
                <div class="panel">
                    <div>
                            <ul class="nav nav-tabs">
                                <li class="active videos_disponibles video_facebook" >
                                    <a href="#tab1default"  data-toggle="tab">
                                       Últimos
                                    </a>
                                </li>                                
                            </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1default">
                                <div class="place_info_videos_disponibles">                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>              

        </div>
    </div>
<main>
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datepicker/css/datepicker.css" />

<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datetimepicker/css/datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-timepicker/css/timepicker.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css">

<script type="text/javascript" src="../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js_tema/js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js_tema/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<script src="../js_tema/js/pickers-init.js"></script>
<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/posibles_clientes.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/clientes.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/proyectos_persona.js')?>">
</script>    

<script type="text/javascript" src="<?=base_url('application/js/notificaciones.js')?>">
</script>    

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">

<script src="<?=base_url('application')?>/js/summernote.js">    
</script>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<style type="text/css">
.campo_avanzado{
    display: none;
}
.btn_mostrar_mas_campos{
    background: #0485D7; 
    padding: 4px;
    color: white;
}
.btn_ocultar_mas_campos:hover , .btn_mostrar_mas_campos:hover{
    cursor: pointer;
}
.agendar_llamada_btn{
    background: #0485D7; 
    padding: 4px;
    color: white;
}
.campo_avanzado_agenda{
    display: none;
}
.alerta_llamadas_agendadas{
    background: #0a399b;
    padding: 5px;
    color: white;
    font-size: .8em!important;
}
.contenedor_form_agenda{
    display: none;
}
.agendar_llamada_btn:hover{
    cursor: pointer;
}
.li_menu{
    font-size: .8em!important;
}
.regresar_btn:hover{
    cursor: pointer;
}
.agregar_info_validacion:hover{
    cursor: pointer;
}
.agregar_info_validacion{
    font-size: .8em;
    background: white;
    padding: 4px;
}
.alerta_red_notificacion{

    background:red;
    padding: 5px;
    color: white;
    font-size: .8em!important;
}.regresar_btn_posible_cliente:hover{
    cursor: pointer;
}.btn_convertir_persona{
    display: none;
}.btn_agendar_correo{
    display: none;
}.btn_agendar_llamada{
    display: none;
}.btn_agregar_comentario{
    display: none;
}.regresar_btn_posible_cliente{
    display: none;   
}.btn_llamar{
 display: none;      
}
</style>






<style type="text/css">
    

#sum_box h4 {
    text-align: left;
    margin-top: 0px;
    font-size: 30px;
    margin-bottom: 0px;
    padding-bottom: 0px;
}


#sum_box .db:hover {
    background: #40516f;
    color: #fff;
}




#sum_box .db:hover .icon {
    opacity: 1;
    color: #999999;
}

#sum_box .icon {
    color: #fff;
    font-size: 55px;
    margin-top: 7px;
    margin-bottom: 0px;
    float: right;
}


.panel.income.db.mbm{
        background-color: #0a5fe0;
        color: white!important;
}

.panel.profit.db.mbm{
        background-color: #5bc0de;
}


.panel.task.db.mbm{
        background-color: #f0ad4e;
}
</style>

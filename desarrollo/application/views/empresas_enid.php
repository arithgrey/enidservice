<main>    
    
<div class='row'>
<div style='background:white;'>
    <div class="col-lg-2">              
        
        <nav class="nav-sidebar">

            <ul class="nav tabs">       
                <br>        
                
                
                <li class='black li_menu <?=valida_seccion_activa(2 , $activa )?>' 
                    style='background:white;'>
                    <a  
                        href="#tab_charts" 
                        data-toggle="tab"                         
                        class='black strong'>
                        <i class="fa fa-area-chart"></i>
                        Métricas                        
                    </a>
                </li>                 
                 
                <li class='black li_menu <?=valida_seccion_activa(1 , $activa )?>' 
                    style='background:white;'>
                    <a                          
                        href="#tab_abrir_ticket" 
                        data-toggle="tab" 
                        id='base_tab_clientes' 
                        class='black strong base_tab_clientes'>
                        <i class="fa fa-check-circle">
                        </i>
                        Pendientes
                        <span class="place_tareas_pendientes">                            
                        </span>
                    </a>
                </li>       
                            

            </ul>
        </nav>        
    </div>
</div>
<div class='col-lg-10'>
    <div class="tab-content">        
        <input type='hidden' class='id_usuario' value='<?=$id_usuario;?>'>                
        <div 
            class="tab-pane <?=valida_seccion_activa(1 , $activa)?>" 
            id='tab_abrir_ticket'>
            <?=$this->load->view("tickets/principal")?>                              
        </div>
        <div 
            class="tab-pane  <?=valida_seccion_activa(2 , $activa)?>" 
            id='tab_charts'>
            <?=$this->load->view("tickets/charts")?>                              
        </div>
    </div>
</div>
</div>        
<?=$this->load->view("modal/principal")?>
<main>
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>    
    <br>
    <br>
    <br>
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
<script type="text/javascript" src="../js_tema/js/bootstrap-daterangepicker/moment.min.js">    
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-daterangepicker/daterangepicker.js">
</script>
<script type="text/javascript" 
src="../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js">    
</script>
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
<script type="text/javascript" src="<?=base_url('application/js/validacion.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/correos_agendados.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/pagos.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/notificaciones.js')?>">
</script>    

<script type="text/javascript" src="../js_tema/js/tickets.js">
</script>    
<script type="text/javascript" src="../js_tema/js/notificaciones.js">
</script>    

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" 
rel="stylesheet">

<script src="<?=base_url('application')?>/js/summernote.js">    
</script>







<style type="text/css">
.herramientas_session{
    display: none!important;
}
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
.alerta_validaciones{
    background: #0a399b;
    padding: 5px;
    color: white;
    font-size: .8em!important;
}
.alerta_llamadas_agendadas{
    background: #0a399b;
    padding: 5px;
    color: white;
    font-size: .8em!important;
}
.alerta_pendientes{
    background: red;
    padding: 5px;
    color: white;
    font-size: .8em!important;
}
.alerta_pendientes_blue{
    background: blue;
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
    font-size: .85em!important;
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
.btn_liquidar_servicio:hover{
    cursor: pointer;
}
.regresar_btn_posible_cliente:hover{
    cursor: pointer;
}
.contenedor-info-ventas{
    display: none;
}
</style>
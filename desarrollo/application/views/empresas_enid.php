<main>    
    <div class="contenedor_principal_enid_service">
        <div class='row'>
            <div>
                <div class="col-lg-2">                                          
                    <?=$this->load->view("desarrollo/menu")?>
                </div>
            </div>
            <div class='col-lg-10'>
                <div class="tab-content">        
                    <input 
                    type='hidden' 
                    class='id_usuario' 
                    value='<?=$id_usuario;?>'>

                    <div 
                        class="tab-pane <?=valida_seccion_activa(3 , $activa)?>" 
                        id="tab_nuevo_ticket">
                        <div class="place_form_tickets">
                        </div>
                    </div>
                    <div class="tab-pane <?=valida_seccion_activa(1 , $activa)?>" 
                        id='tab_abrir_ticket'>
                        <?=n_row_12()?>
                            <h3 style="font-weight: bold;font-size: 3em;">
                                DESARROLLO ENID SERVICE
                            </h3>
                        <?=end_row()?>
                        <?=$this->load->view("../../../view_tema/formularios/busqueda_tickets")?>
                    </div>

                    <div class="tab-pane <?=valida_seccion_activa(2 , $activa)?>" 
                        id='tab_charts'>
                        <?=$this->load->view("tickets/charts")?>
                    </div>

                </div>
            </div>
        </div>            
    </div>    
</main>    
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




<link rel="stylesheet" type="text/css" href="../css_tema/template/desarrollo.css">




<main>    
<br>
<br>
<div class='row'>    
    <div class="col-lg-2" >       
        <?=$this->load->view("secciones_2/menu")?>       
    </div>    
    <div class='col-lg-10'>
        <div class="tab-content">            
            <input type='hidden' class='id_usuario' value='<?=$id_usuario;?>'>            
            <div class="tab-pane active " id="tab1">      
              <?=$this->load->view("secciones_2/info_usuario")?>          
            </div>
            <div class="tab-pane" id='tab_productividad_ventas'>
                <?=$this->load->view("secciones_2/afiliados");?>
            </div>
            <div class="tab-pane" id='tab_perfiles_permisos'>
                <?=$this->load->view("secciones_2/perfiles_permisos_seccion");?>
            </div>
            <div class="tab-pane" id='tab_agregar_recursos'>
                <?=$this->load->view("secciones_2/form_agregar_recurso");?>
            </div>
            <div class="tab-pane" id='tab_mas_info_usuario'>
                <?=$this->load->view("secciones_2/info_usuario_completa")?>          
            </div>
        </div>
    </div>
</div>
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
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<main>
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datepicker/css/datepicker.css" />

<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datetimepicker/css/datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-timepicker/css/timepicker.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css">

<script type="text/javascript" src="../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js">
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js">
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js">
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-daterangepicker/moment.min.js">
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-daterangepicker/daterangepicker.js">
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js">
</script>
<script type="text/javascript" src="../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js">
</script>

<script src="../js_tema/js/pickers-init.js">
</script>
<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/notificaciones.js')?>">
</script>    
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">

<script src="<?=base_url('application')?>/js/summernote.js">    
</script>





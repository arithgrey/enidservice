<main>    
<br>
<div class='row'>    
    <div class='col-lg-2' >        
        <?=$this->load->view("secciones_2/menu");?>        
    </div>    
    <div class='col-lg-6 ' style="background: #0024bf; padding: 10px;">    
        <div class="tab-content">
            <input type='hidden' class='id_usuario' value='<?=$id_usuario;?>'>        
            <div class='tab-pane <?=valida_seccion_activa(1 , $activa )?>' id='tab_redes_sociales'>
                <?=$this->load->view("secciones_2/principal_redes");?>
            </div>
            <div class='tab-pane  <?=valida_seccion_activa(2 , $activa )?>' id='tab_en_correo_electronico'>
                <?=$this->load->view("secciones_2/principal_correo_electronico");?>
            </div>            
            <div class="tab-pane " id="tab_registro_msj">
                <?=$this->load->view("secciones_2/tab_registrar_mensaje");?>          
            </div>
            
        </div>
    </div>    
</div>        
<main>


<main>
  
</main>

<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>">    
</script>
<script type="text/javascript" src="<?=base_url('application/js/ventas.js')?>">    
</script>
<script type="text/javascript" src="<?=base_url('application/js/notificaciones.js')?>">    
</script>

<script type="text/javascript" src="<?=base_url('application/js/email.js')?>">    
</script>


<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="../js_tema/js/bootstrap-timepicker/css/timepicker.css" />
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




<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">

<script src="../js_tema/js/summernote.js">    
</script>

<textarea id='contenedor_msj_temporal' class='contenedor_msj_temporal' style='display:none;'>
</textarea>
<style type="text/css">
.cargar_metas:hover{
  cursor: pointer;
}
.contenedor-info-ventas{
    display: none;
}

</style>

<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<style type="text/css">
.navbar, main{
    background-color: #FFF!important;
}
    
}
</style>
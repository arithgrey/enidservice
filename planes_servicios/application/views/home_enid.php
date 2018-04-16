<main>    
    <div class='contenedor_principal_planes_servicios'>        
        <div class="col-lg-2" >       
            <?=$this->load->view("menu")?>
        </div>
        <div class='col-lg-10'>
            <br>
            <div class="tab-content">                    
                <div 
                    class="tab-pane <?=valida_active_tab('lista' , $action)?> " 
                    id='tab_servicios'>
                    <?=$this->load->view("secciones/servicios");?>
                </div>                
                <div class="tab-pane <?=valida_active_tab('nuevo' , $action)?>" id='tab_form_servicio'>
                    <?=$this->load->view("secciones/form_servicios")?>
                </div>
            </div>
        </div>
    </div>
</main>


<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/slider.js')?>">
</script>    
<script type="text/javascript" src="<?=base_url('application/js/img.js')?>">
</script>    
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="../js_tema/js/summernote.js">    
</script>
<input type="hidden" name="q_action" value="<?=$q_action?>" class="q_action">
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css'>
<link rel="stylesheet" type="text/css" href="../css_tema/template/vender.css">
<link rel="stylesheet" type="text/css" href="../css_tema/template/planes_servicios.css">

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


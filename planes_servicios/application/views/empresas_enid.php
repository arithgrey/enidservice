<main>    
    <div>
        <br>
        <div class="col-lg-2" >       
            <?=$this->load->view("menu")?>
        </div>
        <div class='col-lg-10'>
            <br>
            <div class="tab-content">                    
                <div class="tab-pane active" id='tab_servicios'>
                    <?=$this->load->view("secciones/servicios");?>
                </div>                
                <div class="tab-pane" id='tab_form_servicio'>
                    <?=$this->load->view("secciones/form_servicios")?>
                </div>
            </div>
        </div>
    </div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<main>


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
.scroll_terms{
    height: 300px;
    overflow: auto;
}
.termino:hover{
    cursor: pointer;
}
.muestra_input_precio:hover{
 cursor: pointer;   
}
.contenedor_descripcion:hover{
    cursor: pointer;
}
</style>
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css'>
<link rel="stylesheet" type="text/css" href="../css_tema/template/vender.css">
<main>    
    <div>
        <br>
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
.tipo_promocion{
        background: white;
        color: black;
        border: solid 1px;
        padding: 10px;
        margin-top: 10px;
    }
</style>
<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css'>
<link rel="stylesheet" type="text/css" href="../css_tema/template/vender.css">
 <style>
            .text-danger strong {
                color: #001ec3;
            }
            .receipt-main {
                
                padding: 40px 30px !important;
                position: relative;
                box-shadow: 0 1px 21px #acacac;                
            }            
            .receipt-footer h1{            
                font-weight: 400 !important;
                margin: 0 !important;
            }
            
            
            .receipt-right h5 {
                font-size: 16px;
                font-weight: bold;
                margin: 0 0 7px 0;
            }
            .receipt-right p {
                font-size: 12px;
                margin: 0px;
            }
            .receipt-right p i {
                text-align: center;
                width: 18px;
            }
            .receipt-main td {
                padding: 9px 20px !important;
            }
            .receipt-main th {
                padding: 13px 20px !important;
            }
            .receipt-main td {
                font-size: 13px;
                font-weight: initial !important;
            }

                 
            #container {
                background-color: #dcdcdc;
            }
            .terminos_btn:hover{
                cursor: pointer;
            }
            .text_ciclo_facturacion:hover{
                cursor: pointer;
            }    
    .tag_servicio:hover{    
        padding: 10px;
        background: blue;
        cursor: pointer;   
    }  
    .tag_servicio{
        background:black;margin-left: 1px;font-size:.8em;padding: 5px;color: white;
    }
    .gallery {  
      margin: 0 auto;
      padding: 5px;
      background: #fff;
      box-shadow: 0 1px 2px rgba(0,0,0,.3);
    }
    .gallery > div {
      position: relative;
      float: left;
      padding: 5px;
    }
    .gallery > div > img {
      display: block;
      width: 200px;
      transition: .1s transform;
      transform: translateZ(0); /* hack */
    }
    .gallery > div:hover {
      z-index: 1;
    }
    .gallery > div:hover > img {
      transform: scale(1.7,1.7);
      transition: .3s transform;
    }

    .nav-tabs>li.active {
      border: 1px solid #ddd;
      border-top: 5px solid blue;
      
    }
    .nav-tabs>li {      
      border: 1px solid #fff;
      border-top: 3px solid transparent;        
      min-width: 80px;                              
    }    
    .text_agregar_color:hover{
        cursor: pointer;
    }
    .text_info_envio:hover{
        cursor: pointer;
    }
    .contenedor_imagenes_info{
        border:solid 1px;
    }
    .titulo_seccion_producto{
        font-weight: bold;
        font-size: 1.5em;
    }
    .well{
        background: #fefefe!important;
    }
    </style>
</div>

<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


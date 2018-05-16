<main>
<div class='row'>
    <div class="contenedor_principal_enid_service">
    <?=$this->load->view("secciones/menu");?>    
    <div class='col-lg-10'>
        <div class="tab-content">   
            <div class="tab-pane" id='reporte'>
                <?=n_row_12()?>
                  <div class="place_reporte">
                  </div>
                <?=end_row()?>  
            </div>                    
            <div class="tab-pane active" id='tab_default_1'>                                

                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        INDICADORES ENID SERVICE
                    </span>
                <?=end_row()?> 
                <?=n_row_12()?>
                    <div class="row">
                        <form class='form_busqueda_global_enid'>                    
                            <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                        </form>
                    </div>
                <?=end_row()?> 
                <?=n_row_12()?>                    
                    <div class='place_usabilidad' >
                    </div>   
                <?=end_row()?>             
            </div>                    
            <div class="tab-pane" id='tab_default_2'>                                  
                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        VISITAS WEB 
                    </span>
                <?=end_row()?> 
                <?=n_row_12()?>
                    <form class='f_usabilidad row'>                    
                            <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                    </form>
                <?=end_row()?> 
                <?=n_row_12()?>                    
                    <div class="contenedor_reporte">
                        <?=n_row_12()?>
                            <div class='place_usabilidad_general' >
                            </div>     
                        <?=end_row()?>
                    </div>
                <?=end_row()?>  
            </div>
            <div class="tab-pane" id='tab_default_3'>                
                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        EMAIL ENVIADOS  
                    </span>
                <?=end_row()?> 
                <?=n_row_12()?>
                    <div class='row'>
                        <form class='form_busqueda_mail_enid'>         
                            <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                        </form>
                    </div>
                <?=end_row()?>
                <?=n_row_12()?>  
                    <div class='place_envios'>                      
                    </div>
                    <div  style='overflow-x:auto;'>
                        <div class='place_mail_marketing' >
                        </div>                
                    </div>                                
                <?=end_row()?>  
            </div>            
            <div class="tab-pane" id="tab_atencion_cliente">                
                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        TAREAS RESUELTAS
                    </span>
                <?=end_row()?> 
                <?=$this->load->view("secciones/atencion_cliente" );?>
            </div>
            <div class="tab-pane" id="tab_afiliaciones">
                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS
                    </span>
                <?=end_row()?> 
                <?=$this->load->view("secciones/afiliaciones" );?>
            </div>
            <div class="tab-pane" id="tab_busqueda_productos">
                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        PRODUCTOS MÁS BUSCADOS POR CLIENTES
                    </span>
                <?=end_row()?> 
                <?=$this->load->view("secciones/keywords" );?>
            </div>

            <div class="tab-pane" id="tab_productos_publicos">
                <?=n_row_12()?>
                    <span class="titulo_enid_sm">
                        CATEGORÍAS DESTACADAS
                    </span>
                <?=end_row()?> 
                <br>
                <br>
                <?=n_row_12()?>
                    <?php 
                        $categorias_destacadas_orden =  
                        sub_categorias_destacadas($categorias_destacadas);  
                    ?>
                    <div class="row">
                        <?=crea_repo_categorias_destacadas($categorias_destacadas_orden)?>
                    </div>
                <?=end_row()?>
                
            </div>

            
            
        </div>
    </div>   
    </div>
</div>        
<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</main>





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
<script type="text/javascript" src="<?=base_url('application/js/principal.js')?>">
</script>
<style type="text/css" src="../css_tema/template/metricas.css"></style>
<style type="text/css">
    .clasificaciones_sub_menu_ul{
        display: inline-table;
    }
    .total_categoria{
        background: black;
        padding: 5px;
        color: white;
    }
</style>
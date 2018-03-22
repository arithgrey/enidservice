<main>
<br>
<div class='row'>
    <?=$this->load->view("secciones/menu");?>    
    <div class='col-lg-10'>
        <div class="tab-content">            
            <div class="tab-pane active" id='tab_default_1'>                                
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
                    <div class='place_usabilidad' >
                    </div>     
                <?=end_row()?>  
            </div>
            <div class="tab-pane" id='tab_default_3'>                
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
                        <div class='place_usabilidad' >
                        </div>                
                    </div>                                
                <?=end_row()?>  
            </div>
            <div  class="tab-pane" id="tab_default_faq">
                <?=n_row_12()?>
                    <div class='row'>
                        <form class='form_busqueda_blog'>         
                            <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                        </form>
                    </div>
                <?=end_row()?>
                <?=n_row_12()?>                
                    <div class='place_repo_faq'>                      
                    </div>                    
                <?=end_row()?>   
            </div> 
            <div class="tab-pane" id='reporte'>                                  
                <?=n_row_12()?>
                  <div class="place_reporte">
                  </div>
                <?=end_row()?>  
            </div>           
            <div class="tab-pane" id="tab_atencion_cliente">                
                <?=$this->load->view("secciones/atencion_cliente" );?>
            </div>
            <div class="tab-pane" id="tab_afiliaciones">
              <?=$this->load->view("secciones/afiliaciones" );?>
            </div>
            <div class="tab-pane" id="tab_busqueda_productos">
              <?=$this->load->view("secciones/keywords" );?>
            </div>
            
        </div>
    </div>   
</div>        
<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</main>

<?=$this->load->view("modal/principal")?>




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
<script type="text/javascript" src="<?=base_url('application/js/secciones/usuario.js')?>">
</script>

























<style type="text/css">
    .btn_menu_tab{
        font-size: .8em!important;
    }
    .text-tb{
      font-size: .8em!important;
    }
    .proyectos_registrados:hover{
      cursor: pointer;
    }
    .clientes_info:hover{
      cursor: pointer;
    }.posibles_clientes_contacto:hover{
        cursor: pointer;
    }.num_prospectos_sistema:hover{
      cursor: pointer;
    }.num_afiliados:hover{
      cursor: pointer;
    }
    .contactos_registrados:hover{
      cursor: pointer; 
    }.num_contactos_promociones:hover{
      cursor: pointer; 
    }
    .table_enid_service{
      font-size: .8em!important;
    }
    .usuarios,.contactos,.solicitudes{
        color: blue!important;
        font-weight: bold;
    }
    .usuarios:hover{
        cursor: pointer;
    }
    .contactos:hover,.solicitudes:hover{
        cursor: pointer;
    }
</style>
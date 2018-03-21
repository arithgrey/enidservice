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
                    <div class="container">
                        <div class="row">
                            <div class='col-lg-6' 
                                style='padding:10px;background: black;display: none;'>
                              <div class="col-md-12">
                                <label  for="checkboxes-0">
                                  <input name="checkboxes" 
                                  id="checkboxes-0" 
                                  class='mostrar_servicio_sw' 
                                  value="1" 
                                  type="checkbox" 
                                  checked>
                                    <span 
                                    class='white'
                                    style="font-size: .9em!important;">
                                        Páginas web
                                    </span>
                                </label>
                                <label  for="checkboxes-1">
                                  <input name="checkboxes" 
                                  id="checkboxes-1" 
                                  class='mostrar_adw' 
                                  value="2" 
                                  type="checkbox" 
                                  checked>
                                  <span 
                                  style="font-size: .9em!important;"
                                  class='white'>
                                    Adwords
                                  </span>
                                </label>
                                <label  for="checkboxes-2">
                                  <input name="checkboxes" 
                                  id="checkboxes-2" 
                                  class='mostrar_tl'  
                                  value="3" 
                                  type="checkbox" 
                                  checked>
                                    <span 
                                    class='white'
                                    style="font-size: .9em!important;">
                                        Tiendas en línea
                                    </span>
                                </label>
                                <label  for="checkboxes-3">
                                  <input name="checkboxes" 
                                  id="checkboxes-3" 
                                  class='mostrar_crm' 
                                  value="4" 
                                  type="checkbox" 
                                  checked>
                                    <span 
                                    class='white'
                                    style="font-size: .9em!important;">
                                        CRM
                                    </span>
                                </label>
                              </div>
                            </div>
                            
                            <form class='form_busqueda_actividad_enid'>                    
                                    <?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
                            </form>

                        </div>
                    </div>

                <?=end_row()?>

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
</style>
<main>    
    <div class='contenedor_principal_planes_servicios'>        
        <div class="col-lg-2" >       
            <?=$this->load->view("menu")?>
        </div>
        <div class='col-lg-10'>            
            <div class="tab-content">                   
                <div class="tab-pane <?=valida_active_tab(0, $action , $considera_segundo )?> " 
                    id='tab_servicios'>                    
                    <?=$this->load->view("secciones/servicios");?>
                </div>                
                <div 
                    class="tab-pane <?=valida_active_tab(1 , $action)?>" 
                    id='tab_form_servicio'>                    
                    <?=$this->load->view("secciones/form_servicios")?>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <?php if(count($top_servicios)>0 && $is_mobile ==1):?>
                <div class="card" 
                style="background: #00142f;padding: 2px 2px 30px;margin-top:100px;color: white;">
                    <?=n_row_12()?>
                        <div class="card" style="margin-top: 30px;">
                          <div class="card-header">                    
                                <div style="font-weight: bold;">
                                    TUS ARTÍCULOS MÁS VISTOS 
                                    DE LA SEMANA
                                </div>
                          </div>

                          <div class="card-body" style="margin-top: 20px;background: white; padding: 5px;">                    
                            <ul class="list-unstyled mt-3 mb-4">
                                <?php foreach ($top_servicios as $row): ?>
                                    <a  href="../producto/?producto=<?=$row['id_servicio']?>" 
                                        style='color: black!important;text-decoration:underline;'>
                                        <li>
                                            <i class="fa fa-angle-right"></i>
                                            <?php 
                                                $articulo = 
                                                (trim(strlen($row["nombre_servicio"])) > 22)?
                                                substr($row["nombre_servicio"], 0,22)."...":
                                                strlen($row["nombre_servicio"]);
                                            ?>
                                            
                                            <?=$articulo?>
                                            <div 
                                                    class="pull-right" 
                                                    title="Personas que han visualizado este  producto">
                                                    <span class="a_enid_black_sm_sm" >
                                                        <?=$row["vistas"]?>
                                                    </span>
                                            </div>                                            
                                        </li>
                                    </a>
                                <?php endforeach; ?>                      
                            </ul>                    
                          </div>
                        </div>
                    <?=end_row()?>
                </div>
            <?php endif;?>
        </div>
    </div>
</main>


<input type="hidden" name="version_movil" value="<?=$es_movil?>" class='es_movil'>
<script type="text/javascript" 
src="<?=base_url('application/js/principal.js')?><?=version_enid?>">
</script>     
<script type="text/javascript" 
src="<?=base_url('application/js/img.js')?><?=version_enid?>">
</script>    
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" 
rel="stylesheet">
<script 
src="../js_tema/js/summernote.js<?=version_enid?>">    
</script>
<input type="hidden" value="<?=$action?>" class="q_action">
<input type="hidden" value="<?=$extra_servicio?>" class="extra_servicio">

<link rel='stylesheet prefetch' href='../css_tema/template/css_tienda.css<?=version_enid?>'>
<link rel="stylesheet" type="text/css" href="../css_tema/template/vender.css<?=version_enid?>">
<link rel="stylesheet" 
type="text/css" href="../css_tema/template/planes_servicios.css<?=version_enid?>">
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
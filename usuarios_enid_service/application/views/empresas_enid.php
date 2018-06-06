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
            <div class="tab-pane" id='tab_agregar_categorias'>
                <?=$this->load->view("secciones_2/info_categorias_servicio")?>          
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

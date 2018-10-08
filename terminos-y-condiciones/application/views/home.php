<?=n_row_12()?>
    <div class="contenedor_principal_enid">        
        <div class="col-lg-3">
            <?=$this->load->view("secciones/menu");?>
        </div>
        <div class="col-lg-9">
            <?=heading_enid($titulo)?>            
            <?=$this->load->view($vista);?>
        </div>
    </div>
<?=end_row()?>
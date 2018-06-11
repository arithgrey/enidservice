<?=n_row_12()?>
    <div class="contenedor_principal_enid">        
        <div class="col-lg-3">
            <?=$this->load->view("secciones/menu");?>
        </div>
        <div class="col-lg-9">
            <h1 style="font-size: 3em;font-weight: bold;">
                <?=$titulo;?>
            </h1>
            <?=$this->load->view($vista);?>
        </div>
    </div>
<?=end_row()?>
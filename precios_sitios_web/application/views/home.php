<main>                    
<br>
<br>
<div class='row' style="background: white!important;">

    <div class='container'>        
        <div class='col-lg-2'>
            <div class="row">
            <?=$this->load->view("../../../view_tema/izquierdo.php");?>    
            </div>
        </div>
        <div class='col-lg-10'>        
            <?=n_row_12()?>
                <?=$this->load->view("secciones_2/tabla_precios");?>                
            <?=end_row()?>
        </div>
    </div>
</div>
</main>
<script type="text/javascript" src="<?=base_url('application')?>/js/principal.js"></script>
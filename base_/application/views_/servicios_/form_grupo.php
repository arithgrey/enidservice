<?=heading_enid(
    "Agregar grupo de servicios al sistema" , 
    4 ,  
    ['class' => 'col-lg-8 col-lg-offset-2' , 
    1])?>            

<?=n_row_12()?>
    <div class="col-lg-8 col-lg-offset-2">        
        <?=div("NOMBRE DEL GRUPO", [], 1)?>
        <form class='form_grupo_sistema'>
            <?=input(["type"=>"text", "name"=>"grupo",  "class"=>"form-control input-sm"])?>
            <?=guardar("+Agregar")?>
        </form>
    </div>
<?=end_row()?>
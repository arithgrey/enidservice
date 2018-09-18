<?=n_row_12()?>
    <?=icon("fa fa-search")?>
    Tu búsqueda de 
    <?=$busqueda?> (<?=$num_servicios?> Productos)
<?=end_row()?>
<?=div($paginacion , [] , 1)?>
<?=n_row_12()?>
<?php
    $list ="";  
    $flag =0;    
    foreach($lista_productos as $row){
        echo div($row , ["class" => 'col-lg-3', "style"=>'margin-top:30px;'] );
        $flag ++;
        if ($flag == 4) {
            $flag =0;
            echo "<hr>";
        }
    }
?>
<?=end_row()?>
<?=div($paginacion , [] , 1)?>
                <?=n_row_12()?>
                        <i class="fa fa-search">                    
                        </i>
                        Tu búsqueda de
                        <strong>
                        <?=$busqueda?>
                        </strong> (<?=$num_servicios?> Productos)
                <?=end_row()?>
                <?=n_row_12()?>
                    <?=$paginacion?>
                <?=end_row()?>
                <?php
                   $list ="";  
                   $flag =0;    
                    foreach($lista_productos as $row){
                        
                        echo "<div class='col-lg-3' style='margin-top:30px;' >";  
                        echo $row;
                        echo "</div>";  
                        $flag ++;
                        if ($flag == 4) {
                            $flag =0;
                            echo "<hr>";
                        }
                    }
                ?>
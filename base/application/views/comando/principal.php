<br>
<?php 	
	$l = "";
	foreach ($comandos_ayuda as $row) {
		
		$l .= "<tr>";
			$l .= get_td($row["tipo"] , "class='blue_enid_background white strong' ");
			$l .= "<center>".get_td($row["comando"]) ."</center>";			
		$l .= "</tr>";
	}	
?>
<div class="container">
	<div class="row">        
		<div class="col-md-12">
    	   <table class="table table-list-search">
                <thead class='blue_enid_background white'>
                    <tr>
                        <th>
                            Referencia
                        </th>
                        <th>
                            Comando
                        </th>                            
                    </tr>
                </thead>
                <tbody>
                    <?=$l;?>
                </tbody>
            </table>   
		</div>
	</div>
</div>
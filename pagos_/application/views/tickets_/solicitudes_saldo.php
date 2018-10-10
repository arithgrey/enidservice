<div class="jumbotron">
  <h1 class="titulo_enid">ULTIMOS MOVIMIENTOS
  </h1> 
</div>

<?=n_row_12();?>

<?=end_row();?>
<?=n_row_12();?>	
	<?php if(count($solicitud_saldo)>0): ?>
		<div class='titulo_enid_sm_sm'>
			SOLICITUDES DE SALDO A TUS AMIGOS
		</div>
	<?php endif;?>
    <?php foreach ($solicitud_saldo as $row): ?>
    			
    		<?=n_row_12();?>
                   <div class='list-group-item-movimiento '>
                   		<table style='width:100%'>
                   			<tr>
                   				<td colspan="2">
                               		<div class='folio'>
                               			Folio #<?=$row["id_solicitud"];?>
                               		</div>
                           		<td>
                           	</tr>
                           	<tr>
                           		<td>
                               		<div class='desc_solicitud'>
                               			<span class='monto_solicitado'>                   		
                                   			SOLICITUD DE SALDO A <?=$row["email_solicitado"] ?>
                                   		</span>                                   		
                               		</div>
                           		</td>
                           		<td>
                           			<span class='pull-right'>
                           				<span class='monto_solicitud_text'>
            								<?=$row["monto_solicitado"];?>MXN
            							</span>
            						</span>
                           		</td>
                           		
                       		</tr> 
                   		</table>                   		  
                   </div>
            <?=end_row();?>
         
    <?php endforeach; ?>
<?=end_row();?>
<style>
.list-group-item-movimiento{    
    margin-top:3px;
    border-width: 1px;
    border-style: solid;
    padding: 6px;
}
.list-group-item-movimiento:hover , .list-group-item-movimiento:hover .monto_solicitud_text {
    background: #0042ff;
    color:white;
    cursor:pointer;
}   
.list-group-item-movimiento:hover .folio{
    background: white;
    color: black;
}
.folio{
    background: black;
    color: white;    
    padding: 6px;
    width: 80px!important;
}
.monto_solicitado{
    
    
}
.desc_solicitud{
    margin-left: 50px;
}
.monto_solicitud_text{
    
    color:blue;
    
    text-align: right;
}
</style>
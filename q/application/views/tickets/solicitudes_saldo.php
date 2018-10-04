<?=div( heading_enid("ULTIMOS MOVIMIENTOS" , 1, ["class"=>"titulo_enid"])  , ["class"=>"jumbotron"])?>

<?=n_row_12();?>	
	<?php if(count($solicitud_saldo)>0): ?>
		<?=div("SOLICITUDES DE SALDO A TUS AMIGOS" , ["class"=>'titulo_enid_sm_sm'])?>
	<?php endif;?>
    <?php foreach ($solicitud_saldo as $row): ?>
    		<?=n_row_12();?>
                   <div class='list-group-item-movimiento '>
                   		<table style='width:100%'>
                   			<tr>
                            <?=get_td(div("Folio # ".$row["id_solicitud"] ,  ["class" =>  'folio']) , ["colspan" => "2"])?>
                   				  </tr>
                           	<tr>
                           		<td>
                                <?=div()?>
                               		<div class='desc_solicitud'>
                                    <?=span("SOLICITUD DE SALDO A" . $row["email_solicitado"] , ["class"=>'monto_solicitado'] )?>
                               			
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
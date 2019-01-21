<?=n_row_12()?>    
    <div id="sum_box" class=" mbl">            
        <div class="panel income db mbm">
            <div class="panel-body">
                <?=div(icon('icon fa fa-money') , ["class"=>"icon"])?>
                <?=div("Saldo disponible")?>
                <?=heading_enid("$". number_format(get_data_saldo($saldo_disponible),2). "MXN" ,
                    2, 
                    ["class"    =>  "value white"]
                )?>
                <?=span("Monto expresado en Pesos Mexicanos")?>
            </div>
        </div>
    </div>
    <div class="card" style="width: 100%">
        <?=get_submenu()?>
    </div>
<?=end_row()?>
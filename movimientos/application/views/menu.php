    <?=n_row_12()?>    
        <div id="sum_box" class=" mbl">
            <div class="">
                <div class="panel income db mbm">
                    <div class="panel-body">
                        <p class="icon">
                            icon('icon fa fa-money">                    
                            get_titulo_modalidad
                        </p>
                        <p>
                            Saldo disponible
                        </p>                                  
                        <h4 class="value white">
                            <span>
                                $<?=number_format ($saldo_disponible,2)?>
                            </span>
                            <span>MXN
                            </span>
                        </h4>
                        <span>
                            Monto expresado en Pesos Mexicanos
                        </span>
                    </div>

                </div>
            </div>                                                    
        </div>          
    <?=$this->load->view("sub_menu")?>
    <?=end_row()?>
    <?=n_row_12()?>    
        <div id="sum_box" class=" mbl">
            <div class="">
                <div class="panel income db mbm">
                    <div class="panel-body">
                        <p class="icon">
                            <i class="icon fa fa-money">                    
                            </i>
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
        <div class="card" style="width: 100%">
          <ul class="list-group list-group-flush">
            
            <a href="?q=transfer&action=2">
                <li class="list-group-item">
                    <i class="fa fa-fighter-jet">
                    </i>
                    Trasnferir fondos                
                </li>
            </a>
            <a href="?q=transfer&action=1">
                <li class="list-group-item metodo_pago_disponible">
                    <i class="fa fa-credit-card-alt"></i>
                    Asociadar cuenta bancaria
                </li>
            </a>
            <a href="?q=transfer&action=1&tarjeta=1">
                <li class="list-group-item metodo_pago_disponible">
                    <i class="fa fa-credit-card-alt"></i>
                    Asociadar tarjeta de crédito o débito
                </li>
            </a>
          </ul>
        </div>          
    <?=end_row()?>
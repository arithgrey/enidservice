<div class="row top_150 base_enid_web">
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
        <div class="col-sm-6">
            <?= $cobro_compra;?>
            <?=hiddens([
                    "class"=> "orden_compra", 
                    "value" => $orden_compra,
                    "name" => "orden_compra"
                    ])?> 
        </div>
        <div class="col-sm-6">                      
            <form id="payment-form" class="w-100">
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>                  
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pagar ahora!</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
            
        </div>
        </div>
    </div>
</div>
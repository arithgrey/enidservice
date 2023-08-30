<div class="row top_150 base_enid_web">
    <div class="col-md-8 col-md-offset-2">
        <div class="d-md-block d-none">
            <h1 class="strong text-uppercase ">
                Pago contra entrega en CDMX y envíos a todo México
            </h1>
            <h2 class="f14 strong">
                 <span class="borde_end_b ">
                    Categorías
                </span>                
            </h2>
        </div>
        <div class="d-md-none">
            <h1 class="strong text-uppercase f12">
                Pago contra entrega en CDMX y envíos a todo México
            </h1>
            <h2 class="f11 borde_end_b">            
                Categorías                
            </h2>
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <?php foreach ($nichos as $nicho) : ?>
                <div class="col-md-4 col-xs-6">
                    <a href="../../<?= $nicho["path"] ?>">
                        <div class="mt-5" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='white'">
                            <img src="<?= $nicho["url_img"] ?>">
                            <h2 class="fp9">
                                <span class="borde_end_b"> 
                                <?= $nicho["nombre"] ?>
                                </span>
                            </h2>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</div>
<style>
    .card:hover {
        background-color: #f2f2f2;
        cursor: pointer;
    }
</style>
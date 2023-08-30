<div class="row top_150 base_enid_web">
    <div class="col-md-10 col-md-offset-1">
        <div class="d-md-block d-none">
            <h1 class="strong text-uppercase ">
                Pago contra entrega <br> en CDMX y envíos a todo México
            </h1>
        </div>
        <div class="d-md-none">
            <h1 class="strong text-uppercase f12">
                Pago contra entrega en CDMX y envíos a todo México
            </h1>

        </div>
    </div>
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <?php foreach ($nichos as $nicho) : ?>
                <?php if (intval($nicho["publico"]) > 0) : ?>
                    <div class="col-md-3 col-xs-6">
                        <a href="../../<?= $nicho["path"] ?>" class="hps h_345 p-1 mh-auto top_50 bottom_50 border border-secondary">
                            <div class="flex-column mx-auto my-auto d-block p-1 mh-auto mt-5" onmouseover="this.style.backgroundColor='#f2f2f2'" onmouseout="this.style.backgroundColor='white'">
                                <div class="mt-5">
                                    <img src="<?= $nicho["url_img"] ?>" class="d-block mh_250 mh_sm_310 mx-auto mt-3 servicio">
                                </div>
                                <div class=" black text-center">
                                    <h2 class="borde_end_b f12">
                                        <?= $nicho["nombre"] ?>
                                    </h2>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>

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
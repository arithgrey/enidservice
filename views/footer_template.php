<?= gb_modal() ?>
<h2 class="d-none">
    mancuernas walmart
</h2>
<h2 class="d-none">
    mancuernas baratas
</h2>
<h2 class="d-none">
    set mancuernas
</h2> 
<h2 class="d-none">
mancuernas aurrera
</h2>
<h2 class="d-none">
    mancuernas soriana
</h2> 
<h2 class="d-none">
mancuernas gym
</h2> 
<h2 class="d-none">
mancuernas ajustables
</h2>
<h2 class="d-none">
    mancuernas chedraui
</h2>
<h2 class="d-none">
CDMX
</h2>

<?php if (isset($css) && !is_null($css) && is_array($css) && count($css) > 0): ?>
    <?php foreach ($css as $c): $link = "../css_tema/template/" . $c; ?>
        <?php if (file_exists($link)): ?>
            <link rel="stylesheet" type="text/css"
                  href="<?= $link; ?>?<?= version_enid ?>">
        <?php else: ?>
            NO SE CARGO ->  <?= print_r($link) ?><br>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($css_external) && !is_null($css_external) && is_array($css_external)): ?>
    <?php foreach ($css_external as $c): ?>
        <?php if (file_exists($c)): ?>
            <link rel="stylesheet" type="text/css"
                  href="<?php echo $c; ?>?<?= version_enid ?>">
        <?php else: ?>
            NO SE CARGO ->  <?= print_r($c) ?>
            <?= br() ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($js) && !is_null($js) && is_array($js)): ?>
    <?php $s = "../js_tema/";
    foreach ($js as $script): ?>
        <?php $file = $s . $script;
        if (file_exists($file)): ?>
            <script type='text/javascript'
                    src='<?php echo $file; ?>?<?= version_enid ?>'></script>
        <?php else: ?>
            NO SE CARGO ->  <?= print_r($script) ?>
            <?= br() ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>


<?php if (isset($js_extra) && !is_null($js_extra) && is_array($js_extra)): ?>
    <?php foreach ($js_extra as $script): ?>
        <?php if (file_exists($script)): ?>
            <script type='text/javascript' src='<?php echo $script; ?>'></script>
        <?php else: ?>
            NO SE CARGO <?= print_r($script) ?><br>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (prm_def($this->input->get(), "debug")): ?>
    <style>
        body * {
            border: solid 1px blue !important
        }
    </style>
<?php endif; ?>


</div>
<?= hiddens(
    ["class" => "in_session",
        "value" => $in_session]
) ?>
<?= hiddens(
    ["name" => "titulo_web",
        "class" => "titulo_web",
        "value" => $titulo]
) ?>

<?= d('', 'top_100 bottom_100') ?>
<?= hiddens(['class' => 'is_mobile', 'value' => is_mobile()]) ?>
<?php if ($footer_visible): ?>
    <?php if (!is_mobile()): ?>
        <footer class='p-4 mt-5 border-top border-primary top_200' id='sticky-footer'>
            
            <?=footer_opciones()?>
            <?= d("© 2019 ENID SERVICE.", 'col-lg-12 p-0 mt-5 strong fp9'); ?>
        </footer>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>

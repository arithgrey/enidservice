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
        <script type='text/javascript' src='<?php echo $script; ?>'></script>        
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
        <footer class='p-4 mt-5 borde_black top_200' id='sticky-footer'>            
            <?=footer_opciones()?>
            <?= d("© 2022 ENID SERVICE.", 'col-lg-12 p-0 mt-5 strong fp9'); ?>
        </footer>    
<?php endif; ?>
</body>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '682128699417398');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=682128699417398&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

</html>

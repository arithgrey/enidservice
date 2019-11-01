<?php

require '../librerias/restclient.php';
$api = new RestClient();
$api->set_option('base_url', "json");
$api->set_option('format', "json");
$api->set_option('base_url', "http://enidservices.com/inicio/q/index.php/api/");
$arrayName = array('q' => "1");
$result2 = $api->get("cron/recordatorio_publicaciones/format/html", $arrayName);
$response = $result2->response;
?>
<?= $response; ?>

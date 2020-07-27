<?php

require '../librerias/restclient.php';

$api = new RestClient();
$api->set_option('base_url', "json");
$api->set_option('format', "json");


$api->set_option('base_url',
	"http://enidservices.com/web/msj/index.php/api/");

$arrayName = array('q' => "1");
$result2 = $api->get("cobranza/deuda_pendiente/format/json/", $arrayName);
$response = $result2->response;

?>

<?= $response; ?>

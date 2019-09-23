<?php

require '../librerias/restclient.php';

$api = new RestClient();
$api->set_option('base_url', "json");
$api->set_option('format', "json");


$api->set_option('base_url', "http://enidservice.com/inicio/msj/index.php/api/");

$arrayName = array('q' => "1");
$result2 = $api->get("areacliente/reporte_direccion/format/json/", $arrayName);
$response = $result2->response;

?>

<?= $response; ?>

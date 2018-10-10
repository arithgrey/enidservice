<?php 
  $nombre = $info_usuario["nombre"];
  $ganancias =  $info_usuario["ganancias"];
?>

<?=div("Buen día" . $nombre . "Primero que nada un cordial saludo" )?>
<?=div("Equipo Enid Service.")?>
<?=div("El motivo por el cual nos estamos poniendo en contacto con usted, es debido a que se registro en nuestro programa de afiliados Enid Service, el cual es la forma fácil de ganar dinero a través de su recomendación. ")?>
<?=div("Primero que nada me gustaría recordar le que por cada venta que realicemos a través de su recomendación, usted recibirá el 50% de las ganancias de dicha venta. ")?>
<?=div("Usted puede consultar nuestro catálogo de productos en línea a través de nuestra pagina web. ")?>
<?=anchor_enid("Nuestros productos", 
[
  "href"  =>  "http://enidservice.com/inicio/search/?q="
])?>

<?=div("Usted puede consultar nuestro catálogo de productos en línea a través de nuestra pagina web. ")?>
<?=anchor_enid("Consulte nuestros productos " ,  
["href"=>"http://enidservice.com/inicio/search/?q="])?>

<?=div("Puede verificar sus ganancias y otros temas con relación a este programa, desde  su cuenta Enid Service desde este enlace.")?>
<?=anchor_enid("Consulte sus ganancias aquí  " ,  ["href"=>"http://enidservice.com"])?>

<?=div("Así como también desde dicha cuenta, usted puede solicitar el pago de sus ganancias.")?>
<?=div("Para nosotros es muy importante facilitar le las cosas y hacer que obtenga el mayor número de ganancias, si hay algo en lo que le podamos ayudar para que este proceso sea mucho más fácil, tiene algún tipo de inquietud o simplemente desea saber más del tema, no dude en realizarnos una llamada o si lo prefiere solicite que le hablemos desde nuestra página de contacto, sin más por el momento, quedo  a sus órdenes. ")?>
      

<?=div("TUS GANANCIAS MENSUALES")?>
<?=div($ganancias . "MXN")?>


<?=$this->load->view("../../../view_tema/base_informacion_contacto")?>
	
<?=br(2)?>
<?=addNRow(div($formulario_valoracion , ["class"=>"col-lg-8 col-lg-offset-2"]))?>


<?=addNRow(div(div("ENVIAMOS TU PREGUNTA AL VENDEDOR!" ,[ "class"=> "blue_enid_background white registro_pregunta display_none padding_10"]) , ["class"=>"col-lg-8 col-lg-offset-2"]) )?>

<?=br(5)?>
<?=hr( ["style" => "border-top: 1.2px solid #000;"])?>
<?=br(5)?>
<?=addNRow(div(place("place_valoraciones", ["id" => "place_valoraciones"]) ,  ['class' =>"col-lg-8 col-lg-offset-2"  , "style" => "background: white;"] , 1) , ["style" => "background: #002693;"])?>
<?=br(4)?>
<?=div(place("place_tambien_podria_interezar" ,["id" => "place_tambien_podria_interezar"]) , ['class' =>"col-lg-8 col-lg-offset-2"] , 1)?>
<?=input_hidden(["class" => "servicio"  , "value"	=> $id_servicio ])?>

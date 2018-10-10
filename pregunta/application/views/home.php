<?=div($formulario_valoracion , ["class"=>"col-lg-8 col-lg-offset-2"] , 1)?>	
<?=get_call_to_action_registro($in_session)?>
					
<?=div(place("place_tambien_podria_interezar") , ['class' =>"col-lg-10 col-lg-offset-1"] , 1)?>			
<hr>
<?=div(place("place_valoraciones") ,  ['class' =>"col-lg-10 col-lg-offset-1"] , 1)?>

<?=input_hidden(["class" => "envio_pregunta"  , "value"	=> $in_session])?>
<?=input_hidden(["class" => "servicio"  , "value"	=> $id_servicio ])?>

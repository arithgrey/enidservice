<?= br() ?>
<?= get_msj_busqueda_error() ?>
<?= get_btw(
	heading_enid("UPS AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 2, ["class" => "strong"]),
	anchor_enid("Explorar ahora!",
		[
			"href" => "../",
			"style" =>
				"color: #040174;text-decoration: none;font-size: 1.5em;text-decoration: underline;"
		]),
	"col-lg-4 col-lg-offset-4"
) ?>
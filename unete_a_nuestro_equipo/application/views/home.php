<div id='info_antes_de_ayuda'>
	<div class="col-lg-2">
		<?=get_format_temas_ayuda()?>
	</div>
	<div class='col-lg-10'>
		<div class="tab-content">
			<?= place("info_articulo", ["id" => 'info_articulo']) ?>
			<?= $this->load->view("secciones_2/paginas_web") ?>
		</div>
	</div>
</div>        

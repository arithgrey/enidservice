<div class='col-lg-8 col-lg-offset-2'>
	<?= place("info_articulo", ["id" => 'info_articulo']) ?>
	<?= $this->load->view("secciones_2/paginas_web") ?>
</div>
<?= input_hidden(["value" => $email, "class" => 'email_s']) ?>



<?= n_row_12() ?>
<div class='col-lg-8 col-lg-offset-2'>
	<?= place("info_articulo", ["id" => 'info_articulo']) ?>
	<?= $this->load->view("secciones_2/paginas_web") ?>
</div>
<?= end_row() ?>
<?= input_hidden(["value" => $email, "class" => 'email_s']) ?>



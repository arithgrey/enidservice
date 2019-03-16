<div class='row' id='info_antes_de_ayuda'>
	<div class="col-lg-2">
        <?=get_format_izquierdo($in_session)?>
	</div>
	<div class='col-lg-10'>
		<?= n_row_12() ?>
		<div class="row">
			<div>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<?= anchor_enid("Lo que hacemos",
							[
								"href" => "#home",
								"data-toggle" => "tab"
							]) ?>
					</li>
					<li role="presentation">
						<?= anchor_enid("Misión",
							[
								"href" => "#profile",
								"data-toggle" => "tab"
							]) ?>
					</li>
					<li role="presentation">
						<?= anchor_enid("Visión",
							[
								"href" => "#messages",
								"data-toggle" => "tab"
							]) ?>
					</li>
					<li role="presentation">
						<?= anchor_enid("Tareas complejas", ["href" => "../tareas_complejas"]) ?>
					</li>
				</ul>
				
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<?=get_format_descripcion()?>
                        <?=hr()?>
					</div>
					<div role="tabpanel" class="tab-pane" id="profile">

						<?= p("Nuestra Misión") ?>
						<?= img(["src" => "../img_tema/portafolio/bg-tecnologia.jpg"]) ?>
						<?= p("Tenemos por misión, ayudar a negocios a desempeñarse mejor, reducir sus gastos de operación y adquirir igualdad y competencias entre mercados, con una mejor posición de gestión y administración a diferentes escalas y sectores, siempre alineándonos con sus estrategias y estableciendo un objetivo único y común a sus intereses.") ?>
						<hr
								style="color:black;height: 1px;border: 0;background-color: black;">
					</div>
					<div role="tabpanel" class="tab-pane" id="messages">
						<?= anchor_enid("Nuestra Visión") ?>
						<?= img(["src" => "../img_tema/portafolio/bte.png"]) ?>
						<?= p("Contar con el mejor sistema de negocios en la ciudad de México, para el año 2021 gracia a las tecnologías de la Información y la comunicación.") ?>
						<hr style="color:black;height: 1px;border: 0;background-color: black;">
					</div>
				</div>
			</div>
		</div>
		<?= end_row() ?>
	</div>
</div>            
<?=n_row_12()?>
<div class="panel">
	<span class='strong' style="font-size: .9em">
		Hola comunico con usted ya que encontré la referencia de su negocio a través de 
		<?=$data_tel["tel"][0]["nombre_fuente"]?>
		 , es para saber si existe inconveniente con que le haga llegar a través de correo electrónico o por otro medio la referencia de nuestro catálogo de productos que tenemos en línea. 
	
	</span>
	<div style="font-size: .8em">		
		<span>
			Notamos que también vende sus productos en mercado libre, por lo cual vemos esta como una oportunidad para que reduzca sus tiempos en compra de productos mientras que comisiona al mismo tiempo 	
		</span>
	</div>
</div>
<?=end_row()?>

<?n_row_12()?>
	<div class='white' style='padding:10px;background:#012A7E!important;font-size: .8em;'>
		<label class='strong'>
			Información de ayuda: 
		</label>
		<br>
		<span>
			Tipo de Negocio:  
		</span>
		<span class='place_info_tipo_negocio'>
		</span>
		<br>
		<label class='strong'>
			Fuente:  <?=$data_tel["tel"][0]["nombre_fuente"]?>
		</label>
		<br>
		<?=$data_tel["tel"][0]["info_publicidad"]?>
	</div>
<?=end_row()?>

<div class='row'>
	<form class='form_tipificacion'>												
		<div class='col-lg-4'>
			<a  target="_black" 
				href="tel:<?=$data_tel["tel"][0]["telefono"]?>"
				class='btn'
				style='background:white!important; color:black!important;font-size:1.1em;'>
				<span class='black'>
					<i class='icon-mobile contact'>
					</i>
					<?=$data_tel["tel"][0]["telefono"]?>
				</span>		
			</a>
		</div>				
		<div class='col-lg-4'>
				
				<input value="<?=$data_tel["tel"][0]["id_fuente"]?>" name='id_fuente' id='id_fuente_marcacion' class='id_fuente' type='hidden'>
				<input value="<?=$data_tel["tel"][0]["telefono"]?>" name='telefono' id='telefono' class='telefono_venta' type='hidden'>
				<input value='<?=$id_usuario;?>' name='id_usuario' type='hidden'>
				<div class='black strong'>			
					Tipificación
					<?=$this->load->view("ventas_telefonicas/tipificacion")?>			
				</div>
		</div>
		<div class='col-lg-4'>
			<button class='btn btn_registrar_ficha'>
				Registrar 
			</button>		
			
		</div>
		<?=n_row_12()?>
			<div class='place_update_prospecto'>
			</div>
		<?=end_row()?>
	</form>
</div>
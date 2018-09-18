<?php $icon_user =  icon("fa fa-user")?>
<div class="contenedor_footer_iniciar_sesion">	
	<table>
		<tr>
			<td style="background: black;padding: 15px;">
				<?=anchor_enid($icon_user  . "INICIAR SESIÓN" , ["href"=>"../login/"])?>
			</td>
			<td style="background: black;padding: 15px;">
				<?=anchor_enid($icon_user  . "CREAR UNA CUENTA" , ["href"=>"../login/?action=nuevo"])?>
			</td>
		</tr>
	</table>
</div>

	<div class="col-lg-4 col-lg-offset-4">
		<?=heading_enid("ACTUALIZAR DATOS DE ACCESO" , 3 , [])?>
		<?=n_row_12()?>
					<form id="form_update_password" class="form-horizontal" method="POST">            			
						<div class="form-group">            
							<?=div("Contraseña actual", 1)?>
				            <?=input([
				              	"name"			=> 	"password" ,
				              	"id"			=> 	"password" ,
				              	"class"			=> 	"form-control input-sm",
				              	"type"			=> 	"password" ,
				              	"required"		=>  true
				             ])?>
					        <?=place('place_pw_1')?>
				            <?=div("nueva", [] , 1)?>
				            <input 
				            	name="pw_nueva" 
				            	id="pw_nueva" 
				            	type="password" 
				            	class='form-control input-sm'
				             	required>
				            <?=place('place_pw_2')?>
				            <?=div("Confirmar nueva", 1)?>
				            <?=input([
				            	"name"			=> "pw_nueva_confirm" ,
				            	"id"			=> "pw_nueva_confirm"  ,
				            	"type"			=> "password" ,
				            	"class"			=> "form-control input-sm" ,
				            	"required"		=> "true"
				            ])?>
							<?=input_hidden(["name"=>"secret", "id"=>"secret"])?>
				            
				            <?=place('place_pw_3')?>
				            <?=div("", ["id"=>"reportesession", "class"=>"reportesession"])?>
				            <?=guardar("Actualizar" , ["id"	=>	"inbutton",  "class"=>"btn btn_save input-sm"])?>
				        </div>    
			      	</form>
		<?=end_row()?>
		<?=place("msj_password")?>
	</div>

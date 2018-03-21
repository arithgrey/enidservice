<?php 
	 
	 $info_persona =  $info[0];
	 
	 $nombre_fuente = $info_persona["nombre_fuente"];
	 $id_persona     =  $info_persona["id_persona"];
	 $nombre         =  $info_persona["nombre"];
	 $a_paterno      =  $info_persona["a_paterno"];
	 $a_materno      =  $info_persona["a_materno"];

	 $tel            =  $info_persona["tel"];
	 $tel_2          =  $info_persona["tel_2"];
	 $sitio_web      =  $info_persona["sitio_web"];


	 $correo         =  $info_persona["correo"];
	 $correo2        =  $info_persona["correo2"];
	 $correo3        =  $info_persona["correo3"];
	 $fecha_registro =  $info_persona["fecha_registro"];
	 $direccion      =  $info_persona["direccion"];
	 $comentario     =  $info_persona["comentario"];

	 $id_servicio    =  $info_persona["id_servicio"];	 
	 $status         =  $info_persona["status"];	 
	 $id_usuario     =  $info_persona["id_usuario"];	  	
	 $tipo           =  $info_persona["tipo"];
	 
	 /*Info de validación */
	
?>

<?=n_row_12()?>	
	<span 	 	 
	 class="regresar_btn_posible_cliente black strong " 
	 aria-expanded="true">
	    <i class="fa fa-chevron-circle-left">     
	    </i>
	      Cancelar
	</span>
<?=end_row()?>

<?=n_row_12()?>
	<div class='place_campo_editado'>
	</div>
<?=end_row()?>

<?=n_row_12()?>
<div>
	<a 

		target="_black" 
		href="tel:<?=$tel;?>" 
		class='btn input-sm btn_llamar'  		
		style="background: black!important">
		<i class="fa fa-phone" >
		</i>
		Llamar
	</a>


</div>
<?=end_row()?>


<div>
	
		<i class="fa fa-angle-double-down btn_mas_info_usuario"></i>
		<i class="fa fa-angle-double-up btn_menos_info_usuario">			
		</i>
	<span class="strong ">		
		<?=evalua_cadena($nombre);?> <?=$a_paterno?> <?=$a_materno?>
	</span>
</div>

<div class="contenedor_datos_cliente" >
	<div style="background: #0061ce;color: white;">
		<?=n_row_12()?>
			
			<div class='col-lg-6'>
				<span class="text-campo-persona">
					Nombre :
				</span> 
				<span style='font-size:.85em;' 
						class='texto_editable texto_nombre' 
						onclick="showonehideone('.editable_nombre' , '.texto_nombre' );">
					<?=evalua_cadena($nombre);?>
				</span>
				<div class='editable editable_nombre'>
					<input 
						   onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "nombre")'			
						   name='nombre' 
						   class='form-control input-sm' 
						   id='nombre_p' 
						   value='<?=$nombre?>'
						   placeholder='Nombre'>
				</div>
			</div>
			<div class='col-lg-6'>
				<span class="text-campo-persona">
					A.Paterno:
				</span> 
				<span style='font-size:.85em;' class='texto_editable texto_a_paterno' onclick="showonehideone('.editable_a_paterno' , '.texto_a_paterno' );">
					<?=evalua_cadena($a_paterno)?>
				</span>
				<div class='editable editable_a_paterno'>
					<input name='apaterno' 
						   class='form-control input-sm' 
						   id='apaterno_p' 
						   value='<?=$a_paterno?>'
						   placeholder='Apellido paterno'
						   
						   onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "a_paterno")'>
				</div>
			</div>
			<div class='col-lg-6'>
				<span class="text-campo-persona">
					A.Materno :
				</span> 
				<span style='font-size:.85em;' 
					  class='texto_editable texto_a_materno' 
					  onclick="showonehideone('.editable_a_materno' , '.texto_a_materno' );" 
					  placeholder='Apellido Materno'>
					<?=evalua_cadena($a_materno)?>
				</span>
				<div class='editable editable_a_materno'>
					<input name='amaterno' 
							class='form-control input-sm' 
							id='amaterno_p' 
							value='<?=$a_materno?>'
							onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "a_materno")'>
				</div>
			</div>	
			
			
			

			
			<div class='col-lg-6'>
				<span class="text-campo-persona"> 
					Tel.
				</span>
				<span  style='font-size:.85em;' 
						class='texto_editable texto_tel' 
						onclick="showonehideone('.editable_tel' , '.texto_tel' );">
					<?=evalua_cadena($tel);?>
				</span>
				<div class='editable editable_tel'>
					<input 
					name='tel' 
					type='tel' 
					class='form-control input-sm' 
					id='tel_p' 
					value='<?=$tel;?>'
					placeholder='Teléfono'
					onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "tel")'>

				</div>
			</div>

			<div class='col-lg-6'>
				<span class="text-campo-persona">
					Tel2.
				</span>
				<span 
					style='font-size:.85em;' 
					class='texto_editable texto_tel2' 
					onclick="showonehideone('.editable_tel2' , '.texto_tel2' );"
					placeholder='Teléfono 2'>
					<?=evalua_cadena($tel_2);?>
				</span>
				<div class='editable editable_tel2'>
					<input name='tel2' 
					value='<?=$tel_2;?>' 
					type='tel' 
					class='form-control input-sm' 
					id='tel2_p'
					onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "tel_2")'>
				</div>
			</div>
			<div class='col-lg-6'>
				<span class="text-campo-persona">
					Sitio web
				</span>
				<span style='font-size:.85em;' class='texto_editable texto_sitio_web' onclick="showonehideone('.editable_sitio_web' , '.texto_sitio_web' );">
					<?=evalua_cadena($sitio_web)?>
				</span>
				<div class='editable editable_sitio_web'>
					<input  
					value='<?=$sitio_web?>' 
					name='sitio_web' 
					type='url' 
					class='form-control input-sm' 
					id='url_p'
					placeholder='Teléfono'
					onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "sitio_web")'>
				</div>
			</div>	
			<div class='col-lg-6'>
				<span class="text-campo-persona">
					Email
				</span>
				<span style='font-size:.85em;' class='texto_editable texto_correo' onclick="showonehideone('.editable_correo' , '.texto_correo' );">
					<?=evalua_cadena($correo);?>
				</span>
				<div class='editable editable_correo'>
					<input 
						name='correo' 
						value='<?=$correo;?>' 
						type='email' 
						class='form-control input-sm' 
						id='email_p'
						placeholder='Correo electrónico'
						onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "correo")'>
				</div>
			</div>
			<div class='col-lg-6'>
				<span class="text-campo-persona"> 
					Email 2
				</span>
				<span style='font-size:.85em;' class='texto_editable texto_correo2' onclick="showonehideone('.editable_correo2' , '.texto_correo2' );">
					<?=evalua_cadena($correo2);?>
				</span>
				<div class='editable editable_correo2'>
					<input 
					value='<?=$correo2;?>' 
					name='correo2' 
					type='email' 
					class='form-control input-sm' 
					id='email2_p'
					placeholder='Correo electrónico 2'
					onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "correo2")'>
				</div>
			</div>
			<div class='col-lg-6'>
				<span class="text-campo-persona">
					Email 3
				</span>
				<span style='font-size:.85em;' class='texto_editable texto_correo3' onclick="showonehideone('.editable_correo3' , '.texto_correo3' );">
					<?=evalua_cadena($correo3);?>
				</span>
				<div class='editable editable_correo3'>
					<input 
					value='<?=$correo3;?>' 
					name='correo3' 
					type='email' 
					class='form-control input-sm' 
					id='email3_p'
					placeholder='Correo electrónico 3'
					onblur='actualiza_info_campo(this , "<?=$id_persona;?>" , "correo3")'>
				</div>
			</div>

		<?=end_row()?>
	</div>
</div>

<!--*****************AQUÍ INFO DEL HISTORIAL ****************************-->

	   <div class="panel panel-primary">
		    <div class="panel-heading strong">
		       Seguimiento al cliente
		    </div>
		    <div class="panel-body">
		        <ul class="chat">
		            <?=get_comentarios_persona($info_comentarios)?> 
		        </ul>
		    </div>
		    <div class="panel-footer">
		    	<form class="form_comentarios_seguimiento_cliente">
			        <div class="input-group">		            			           
			            <div>
			            	<?=create_select(
			            		$tipificacion , 
			            		"tipificacion" , 
			            		"form-control tipificacion_selector" , 
			            		"id_tipificacion" , 
			            		"nombre_tipificacion" , 
			            		"id_tipificacion" )?>	
			            </div>
			            <div class="contenedor_horario_seguimiento" style="display: none;">
			            	<?=$this->load->view("../../../view_tema/inputs_agenda")?>
			            </div>
			            <div>
				            <input id="btn-input" 
				            type="text" 
				            name="comentario" 
				            class="form-control input-sm"
				            placeholder="Agregar comentario" />
			            </div>
			            <span class="input-group-btn">
			                <button class="btn btn-warning btn-sm" id="btn-chat">
								Enviar
			                </button>
			            </span>
			        </div>
			        <div class="place_nuevo_comentario">			        	
			        </div>
		        </form>
		    </div>
		</div>

<style type="text/css">
.text_comentarios{
	font-size: .8em!important;
}
.editable{
	display: none;
}
.texto_editable:hover{
	cursor: pointer;
}.agregar_info_validacion:hover{
	cursor: pointer;
}
.text-campo-persona{
	font-weight: bold;
	font-size: .85em;

}
.campo_oculto{
	display: none;

}
.texto_editable{
	
}
/**/
.chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 250px;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

</style>



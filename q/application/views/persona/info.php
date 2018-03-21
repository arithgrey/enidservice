<?php 
	$info_persona =  $info[0];

	 $tipo_negocio =  $info_persona["tipo_negocio"];
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


	 //$id_servicio    =  $info_persona["id_servicio"];
	 $nombre_servicio =  $info_persona["nombre_servicio"];
	 $id_fuente      =  $info_persona["id_fuente"];
	 $status         =  $info_persona["status"];	 
	 $id_usuario     =  $info_persona["id_usuario"];


	 $tipificaciones = ["" ,"Le interesa", "Llamar después","No le interesa","No volver a llamar","No contesta","Venta"];
	  	

	 $tipo           =  $info_persona["tipo"];
	 $referido       =  $info_persona["referido"];
	 /**/
	
?>

<br>
<br>
<div class='row white' style='padding:10px;background:#0876F9;'>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Nombre :
		</label> 
		<span style='font-size:.9em;'>
			<?=$nombre?>
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			A.Paterno :
		</label> 
		<span style='font-size:.9em;'>
			<?=$a_paterno?>
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			A.Materno :
		</label> 
		<span style='font-size:.9em;'>
			<?=$a_materno?>
		</span>
	</div>	
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Tipo negocio:
		</label> 
		<span style='font-size:.9em;'>
			<?=$tipo_negocio?>		
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Servicio de interés
		</label> 
		<span style='font-size:.9em;'>			
			<?=$nombre_servicio;?>		
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Fuente
		</label> 
		<span style='font-size:.9em;'>			
			<?=$nombre_fuente?>
		</span>
	</div>

	
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Tel.
		</label>
		<span style='font-size:.9em;'>
			<?=$tel;?>
		</span>
	</div>

	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Tel2.
		</label>
		<span style='font-size:.9em;'>
			<?=$tel_2;?>
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Sitio web
		</label>
		<span style='font-size:.9em;'>
			<?=$sitio_web?>
		</span>
	</div>	
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Email
		</label>
		<span style='font-size:.9em;'>
			<?=$correo;?>
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Email 2
		</label>
		<span style='font-size:.9em;'>
			<?=$correo2;?>
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Email 3
		</label>
		<span style='font-size:.9em;'>
			<?=$correo3;?>
		</span>
	</div>
	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Tipificación
		</label>
		<span style='font-size:.9em;'>
			<?=$tipificaciones[$tipo];?>
		</span>
	</div>

	<div class='col-lg-4'>
		<label style='font-size:1em!important;'>
			Dirección
		</label>
		<span style='font-size:.9em;'>
			<?=$direccion;?>
		</span>
	</div>
</div>



<!--*****************AQUÍ INFO DEL HISTORIAL ****************************-->

<br>
<button 
	class='btn btn_agregar_comentario'  		
	id="<?=$id_persona;?>"
	data-toggle='modal' 
	data-target='#agregar_comentarios_modal'>
	<i class="fa fa-comment" aria-hidden="true"></i>
	Agregar comentario
</button>
<button 
	href="#tab_agendar_llamada" 
    data-toggle="tab" 
	class='btn btn_agendar_llamada'  		
	id="<?=$id_persona;?>">
	<i class="fa fa-phone-square" aria-hidden="true">
	</i>
	Agendar llamada
</button>








<div style='height:500px; overflow:auto;'>
	<div class='row'>
		<div class='col-lg-12'>
			<table class="table table-striped table-bordered">
	              <thead style='background:#0876F9;' class='white'>
	                <tr>

	                  <td class='white strong'>
	                     Fecha
	                  </td>
	                  <td class='white strong'>
	                  	 Tipificación
	                  </td>
	                  <td class='white strong'>
	                    <center >
	                     Comentarios
	                    </center>
	                  </td>
	                </tr>
	              </thead>
	              <tbody>                              
	              	<?=get_comentarios_persona($info_comentarios)?>  
	                <tr>                 
	                   <td class='text_comentarios'>
		                   <?=$fecha_registro;?> 
	                   </td>
	                   <td class='text_comentarios'>
		               	<?=$tipificaciones[$tipo];?>
	                   </td>
	                   
	                   <td class='text_comentarios'>
	                   	<?=$comentario;?>
	                   </td>
	                </tr>
	                
	                </tbody>
	              </table>
		</div>
	<div>
</div>



<style type="text/css">
.text_comentarios{
	font-size: .8em!important;
}
</style>
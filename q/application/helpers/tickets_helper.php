<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
	function valida_tipo_usuario_tarea($id_perfil)
	{
		$text = "Equipo Enid Service";
		if ($id_perfil == 20) {
			$text = "Cliente";
		}
		return $text;
	}

	function get_form_cancelar_compra($recibo, $modalidad)
	{

		$heading_1 = heading_enid("¿REALMENTE DESEAS CANCELAR LA COMPRA?", 3);
		$div = div(strtoupper($recibo["resumen"]));
		$tmp = div(div(append_data([$heading_1 . $div]), ["class" => "padding_20"]), ['class' => 'jumbotron']);
		$btn = guardar("CANCELAR ÓRDEN DE COMPRA",
			[
				"class" => "cancelar_orden_compra",
				"id" => $recibo['id_recibo'],
				"modalidad" => $modalidad
			],
			1,
			1);

		return append_data([$tmp, $btn]);
	}

	function valida_check_tarea($id_tarea, $valor_actualizar, $status, $id_perfil)
	{

		if ($id_perfil != 20) {

			$config = [
				"type" => 'checkbox',
				"class" => 'tarea',
				"id" => $id_tarea,
				"value" => $valor_actualizar,
			];
			if ($status == 1) {
				$config["checked"] = true;
			}

			$input = input($config);
		} else {
			$input = ($status == 1) ? " Tarea terminada" : " | En proceso";
		}
		return $input;
	}

	function valida_mostrar_tareas($data)
	{

		if (count($data) > 0) {

			$config = ["class" => 'mostrar_tareas_pendientes a_enid_black cursor_pointer'];
			$config2 = ["class" => 'mostrar_todas_las_tareas a_enid_black cursor_pointer'];
			$contenido = div("MOSTRAR SÓLO TAREAS PENDIENTES", $config);
			$contenido .= div("MOSTRAR TODAS LAS TAREAS", $config2);
			return $contenido;
		}
	}

	function create_notificacion_ticket($info_usuario, $param, $info_ticket)
	{

		$usuario = $info_usuario[0];
		$nombre_usuario = $usuario["nombre"] . " " . $usuario["apellido_paterno"] . $usuario["apellido_materno"] . " -  " . $usuario["email"];


		$asunto_email = "Nuevo ticket abierto [" . $param["ticket"] . "]";
		$ticket = div("Nuevo ticket abierto [" . $param["ticket"] . "]");
		$ticket .= div("Cliente que solicita " . $nombre_usuario . "");

		$lista_prioridades = ["", "Alta", "Media", "Baja"];
		$lista = "";
		$asunto = "";
		$mensaje = "";
		$prioridad = "";
		$nombre_departamento = "";

		foreach ($info_ticket as $row) {

			$asunto = $row["asunto"];
			$mensaje = $row["mensaje"];
			$prioridad = $row["prioridad"];
			$nombre_departamento = $row["nombre_departamento"];

		}

		$ticket .= div("Prioridad: " . $lista_prioridades[$prioridad]);
		$ticket .= div("Departamento a quien está dirigido: " . $nombre_departamento);
		$ticket .= div("Asunto:" . $asunto);
		$ticket .= div("Reseña:" . $mensaje);

		$msj_email["info_correo"] = $ticket;
		$msj_email["asunto"] = $asunto_email;

		return $msj_email;

	}

	function crea_tabla_resumen_ticket($info_ticket, $info_num_tareas)
	{

		$tareas = $info_num_tareas[0]["tareas"];
		$pendientes = $info_num_tareas[0]["pendientes"];
		$id_ticket = "";
		$asunto = "";
		$mensaje = "";
		$status = "";
		$fecha_registro = "";
		$prioridad = "";
		$id_proyecto = "";
		$id_usuario = "";
		$nombre_departamento = "";
		foreach ($info_ticket as $row) {

			$id_ticket = $row["id_ticket"];
			$status = $row["status"];
			$fecha_registro = $row["fecha_registro"];
			$prioridad = $row["prioridad"];
			$nombre_departamento = $row["nombre_departamento"];
			$lista_prioridad = ["Alta", "Media", "Baja"];
			$lista_status = ["Abierto", "Cerrado", "Visto"];
			$asunto = $row["asunto"];
		}
		?>


		<?= n_row_12() ?>
		<?php echo "<table class='table_resumen_ticket'>"; ?>
			<?php echo "<tr>"; ?>
			<?= get_td(heading_enid($asunto, 3, ["class" => "white"])); ?>
			<?= get_td("#TAREAS " . $tareas); ?>
			<?= get_td("#PENDIENTES " . $pendientes) ?>
			<?php echo "</tr>"; ?>

			<?php echo "<tr>"; ?>
			<?= get_td($info_ticket[0]["asunto"], ["colspan" => 3]); ?>
			<?php echo "</tr>"; ?>

			<?php echo "<tr>"; ?>
			<?= get_td(div($info_ticket[0]["mensaje"])); ?>
			<?php echo "</tr>"; ?>

			<?php echo "</tr>"; ?>
		<?php echo "</table>"; ?>
		<?= end_row() ?>

		<?= n_row_12() ?>
		<?php echo "<table>"; ?>
			<?php echo "<tr>"; ?>
			<?php get_td("TICKET # " . $id_ticket) ?>

			<?php get_td("DEPARTAMENTO " . strtoupper($nombre_departamento)) ?>

			<?php get_td("ESTADO " . strtoupper($lista_status[$status])) ?>

			<?php get_td("PRIORIDAD " . strtoupper($lista_prioridad[$prioridad])) ?>

			<?php get_td("ALTA " . strtoupper($fecha_registro)) ?>
			<?php echo "</tr>"; ?>
		<?php echo "</table>"; ?>
		<?= end_row() ?>

		<?php
	}
}
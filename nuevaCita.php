<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" />
	<script src="assets/bootstrap/bootstrap.min.js"></script>
</head>

<body>
	<?php
	session_start();
	if (!isset($_SESSION["dniUsu"]) || $_SESSION["usuTipo"] !== "Asistente") {
		header("Location: index.php");
	}
	$enlace = mysqli_connect("localhost", "asistente", "asistente", "consultas");

	$alertType = $alertHeading = $alertInfo = $paciente = $fechaHora = $medico = $consultorio = "";

	$fechaActual = date("Y-m-d\TH:i");

	if (isset($_POST["nuevaCita"])) {
		$paciente = $_POST["paciente"];
		$fechaHora = $_POST["fecha"];
		$medico = $_POST["medico"];
		$consultorio = $_POST["consultorio"];

		$fecha = date('Y-m-d', strtotime($_POST["fecha"]));
		$hora = date('H:i:s', strtotime($_POST["fecha"]));

		if (!fechavalida($fecha, $hora)) {
			$alertType = "danger";
			$alertHeading = "Fecha no valida";
			$alertInfo = "La fecha y hora debe ser posterior a la fecha y hora actual";
		} else {
			$comprobarCita = 'SELECT citFecha, citHora, citPaciente, citMedico, citConsultorio FROM `citas` WHERE citFecha = "' . $fecha . '" AND citHora = "' . $hora . '" AND citPaciente = "' . $_POST["paciente"] . '" AND citMedico = "' . $_POST["medico"] . '" AND citConsultorio = ' . $_POST["consultorio"] . '';
			$dato = mysqli_query($enlace, $comprobarCita);
			if (mysqli_num_rows($dato) === 0) {
				$asignarCita = mysqli_query($enlace, "INSERT INTO citas (citFecha, citHora, citPaciente, citMedico, citConsultorio, citEstado) VALUES ('$fecha', '$hora', '$_POST[paciente]', '$_POST[medico]', $_POST[consultorio], 'Asignado')");

				if ($asignarCita) {
					$alertType = "success";
					$alertHeading = "Cita Registrada";
				} else {
					$alertType = "danger";
					$alertHeading = "Error al registrar la cita";
				}
			} else {
				$alertType = "danger";
				$alertHeading = "Cita ya existe";
			}
		}
	} else if (isset($_POST['cerrarsesion'])) {
		session_destroy();
		header("Location:index.php");
	} else if (isset($_POST['escoger'])) {
		header("Location:escoger.php");
	}

	function fechavalida($fecha, $hora)
	{
		if ($fecha > date('Y-m-d')) {
			return true;
		} else if (($fecha === date('Y-m-d')) && ($hora > date('H:i:s'))) {
			return true;
		}
		return false;
	}
	?>

	<nav class="navbar navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand">Se ha validado como <?= isset($_SESSION["usuTipo2"]) ? $_SESSION["usuTipo"] . " y " . $_SESSION["usuTipo2"] : $_SESSION["usuTipo"] ?></a>
			<form class="d-flex" action="#" method="post">
				<button class="btn btn-secondary me-2" type="submit" name="escoger">Opciones</button>
				<button class="btn btn-secondary me-2" type="submit" name="cerrarsesion">Cerrar Sesión</button>
			</form>
		</div>
	</nav>
	<form action="#" method="post">
		<div class="container py-5">
			<h3 class="mb-3 fw-normal">Nueva cita</h3>
			<div class="row">
				<?php
				if ($alertType != "") {
				?>
					<div class="alert alert-<?= $alertType ?>" role="alert">
						<h4 class="alert-heading"><?= $alertHeading ?></h4>
						<p class="mb-0"><?= $alertInfo ?></p>
					</div>
				<?php
				}
				?>

				<div class="mb-3 col-sm-6">
					<label class="form-label">Paciente</label>
					<select class="form-select" name="paciente" required>
						<option <?= $paciente === "" ? "selected" : "" ?>>Seleccione</option>
						<?php
						$consultarPacientes = mysqli_query($enlace, 'SELECT DISTINCT `dniPac`, `pacNombres`, `pacApellidos` FROM `pacientes`, `usuarios` WHERE dniPac = dniUsu AND usuEstado = "Activo" AND usutipo = "Paciente"');
						while ($fila = mysqli_fetch_array($consultarPacientes)) {
						?>
							<option value="<?= $fila["dniPac"] ?>" <?= $paciente === $fila["dniPac"] ? "selected" : "" ?>><?= $fila["pacNombres"] . " " . $fila["pacApellidos"] . " (" . $fila["dniPac"] . ")" ?></option>
						<?php
						}
						?>
					</select>
				</div>

				<div class="mb-3 col-sm-6">
					<label class="form-label">Médico</label>
					<select class="form-select" name="medico" required>
						<option <?= $medico === "" ? "selected" : "" ?>>Seleccione</option>
						<?php
						$consultarMedicos = mysqli_query($enlace, 'SELECT DISTINCT `dniMed`, `medNombres`, `medApellidos` FROM `medicos`, `usuarios` WHERE dniMed = dniUsu AND usuEstado = "Activo" AND usutipo = "Medico"');
						while ($fila = mysqli_fetch_array($consultarMedicos)) {
						?>
							<option value="<?= $fila["dniMed"] ?>" <?= $medico === $fila["dniMed"] ? "selected" : "" ?>><?= $fila["medNombres"] . " " . $fila["medApellidos"] . " (" . $fila["dniMed"] . ")" ?></option>
						<?php
						}
						?>
					</select>
				</div>

				<div class="mb-3 col-sm-6">
					<label class="form-label">Consultorio</label>
					<select class="form-select" name="consultorio" required>
						<option <?= $consultorio === "" ? "selected" : "" ?>>Seleccione</option>
						<?php
						$consultarConsultorios = mysqli_query($enlace, 'SELECT `idConsultorio`, `conNombre` FROM `consultorios`');
						while ($fila = mysqli_fetch_array($consultarConsultorios)) {
						?>
							<option value="<?= $fila["idConsultorio"] ?>" <?= $consultorio === $fila["idConsultorio"] ? "selected" : "" ?>><?= $fila["conNombre"] . " (" . $fila["idConsultorio"] . ")" ?></option>
						<?php
						}
						?>
					</select>
				</div>

				<div class="mb-3 col-sm-6">
					<label class="form-label">Fecha</label>
					<input type="datetime-local" class="form-control" name="fecha" value="<?= $fechaHora ?>" min="<?= $fechaActual ?>" required>
				</div>

				<div>
					<button type="submit" class="col-12 col-sm-auto btn btn-primary" name="nuevaCita">Crear Cita</button>
				</div>

			</div>
		</div>
	</form>
</body>

</html>
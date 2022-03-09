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
	if (!isset($_SESSION["dniUsu"]) || !isset($_SESSION["tipoRegistro"]) || ($_SESSION["usuTipo"] !== "Administrador" && $_SESSION["usuTipo"] !== "Asistente")) {
		header("Location: index.php");
	}

	if ($_SESSION["usuTipo"] === "Administrador") {
		$enlace = mysqli_connect("localhost", "administrador", "administrador", "consultas");
	} else {
		$enlace = mysqli_connect("localhost", "asistente", "asistente", "consultas");
	}

	$alertType = $alertHeading = $alertInfo = $dni = $nombre = $apellidos = $especialidad = $telefono = $correo = $fechanacimiento = $sexo = "";

	if (isset($_POST["darAlta"])) {
		$dni = $_POST["dni"];
		$nombre = $_POST["nombre"];
		$apellidos = $_POST["apellidos"];

		if ($_SESSION["tipoRegistro"] === "altapaciente") {
			$fechanacimiento = $_POST["fechanacimiento"];
			$sexo = $_POST["sexo"];
			$login = $_POST["dni"] . "pac";
		} else {
			$especialidad = $_POST["especialidad"];
			$telefono = $_POST["telefono"];
			$correo = $_POST["correo"];
			$login = $_POST["dni"] . "med";
		}

		if ($_POST["password"] !== $_POST["password2"]) {
			$alertType = "danger";
			$alertHeading = "Las contraseñas no coinciden";
		} else if (!dnivalido($dni)) {
			$alertType = "danger";
			$alertHeading = "DNI no valido";
			$alertInfo = "8 números y 1 letra de validación";
		} else if (!nombrevalido($nombre)) {
			$alertType = "danger";
			$alertHeading = "Nombre no valido";
			$alertInfo = "Solo letras y la primera debe ser mayúscula";
		} else if (!apellidosvalido($apellidos)) {
			$alertType = "danger";
			$alertHeading = "Apellidos no validos";
			$alertInfo = "Dos apellidos separados por espacios o un solo apellido, cada apellido empezando por mayúscula";
		} else if (($_SESSION["tipoRegistro"] === "altapaciente") && (!fechavalida($fechanacimiento))) {
			$alertType = "danger";
			$alertHeading = "Fecha no valida";
			$alertInfo = "La fecha debe ser igual o anterior a la fecha de hoy";
		} else if (($_SESSION["tipoRegistro"] === "altapaciente") && (!sexovalido($sexo))) {
			$alertType = "danger";
			$alertHeading = "Sexo no valido";
			$alertInfo = "Sexo debe ser masculino o femenino";
		} else if (($_SESSION["tipoRegistro"] === "altamedico") && (!especialidadvalida($especialidad))) {
			$alertType = "danger";
			$alertHeading = "Especialidad no valida";
			$alertInfo = "Solo letras y la primera debe ser mayúscula";
		} else if (($_SESSION["tipoRegistro"] === "altamedico") && (!telefonovalido($telefono))) {
			$alertType = "danger";
			$alertHeading = "Teléfono no valido";
			$alertInfo = "9 dígitos";
		} else if (($_SESSION["tipoRegistro"] === "altamedico") && (!correovalido($correo))) {
			$alertType = "danger";
			$alertHeading = "Correo no valido";
		} else {
			// El login esta compuesto por DNI + TIPO
			// Un mismo DNI puede ser usado para varios tipos de usuarios, el login es unico
			$comprobarUsuario = 'SELECT `usuLogin` FROM `usuarios` WHERE usuLogin="' . $login . '"';
			$dato = mysqli_query($enlace, $comprobarUsuario);
			if (mysqli_num_rows($dato) === 0) {
				if ($_SESSION["tipoRegistro"] === "altapaciente") {
					$darAltaUsuarios = mysqli_query($enlace, "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword, usuEstado, usutipo) VALUES ('$_POST[dni]', '$login', '$_POST[password]', 'Activo', 'Paciente')");
					$darAltaTipo = mysqli_query($enlace, "INSERT INTO pacientes (dniPac, pacNombres, pacApellidos, pacFechaNacimiento, pacSexo) VALUES ('$_POST[dni]', '$_POST[nombre]', '$_POST[apellidos]', '$_POST[fechanacimiento]', '$_POST[sexo]')");
				} else {
					$darAltaUsuarios = mysqli_query($enlace, "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword, usuEstado, usutipo) VALUES ('$_POST[dni]', '$login', '$_POST[password]', 'Activo', 'Medico')");
					$darAltaTipo = mysqli_query($enlace, "INSERT INTO medicos (dniMed, medNombres, medApellidos, medEspecialidad, medTelefono, medCorreo) VALUES ('$_POST[dni]', '$_POST[nombre]', '$_POST[apellidos]', '$_POST[especialidad]', '$_POST[telefono]','$_POST[correo]')");
				}

				if ($darAltaUsuarios && $darAltaTipo) {
					$alertType = "success";
					$alertHeading = "Usuario Registrado";
					$alertInfo = "Usuario: " . $_POST["nombre"] . " " . $_POST["apellidos"] . " con DNI: " . $_POST["dni"];
				} else {
					$alertType = "danger";
					$alertHeading = "Error al registrar el usuario";
				}
			} else {
				$alertType = "danger";
				$alertHeading = "Usuario ya existe";
			}
		}
	} else if (isset($_POST['cerrarsesion'])) {
		session_destroy();
		header("Location:index.php");
	} else if (isset($_POST['escoger'])) {
		header("Location:escoger.php");
	}

	function dnivalido($dni)
	{
		if (!preg_match('/[0-9]{8}[A-Z]/', $dni)) {
			return false;
		}
		$letra = substr($dni, -1);
		$numeros = substr($dni, 0, -1);
		if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
			return true;
		}
		return false;
	}
	function nombrevalido($input)
	{
		// \b[^\d\W]+\b
		if (preg_match('/[A-Z][a-zA-Z]+/', $input)) {
			return true;
		}
		return false;
	}
	function apellidosvalido($input)
	{
		if (preg_match('/([A-Z][a-zA-Z]+ [A-Z][a-zA-Z]+)|([A-Z][a-zA-Z]+)/',  $input)) {
			return true;
		}
		return false;
	}
	function fechavalida($input)
	{
		if ($input < date('Y-m-d')) {
			return true;
		}
		return false;
	}
	function especialidadvalida($input)
	{
		if (preg_match('/[A-Z][a-zA-Z]+/', $input)) {
			return true;
		}
		return false;
	}
	function sexovalido($input)
	{
		if (($input === "Masculino") || ($input === "Femenino")) {
			return true;
		}
		return false;
	}
	function telefonovalido($input)
	{
		if (preg_match('/[0-9]{9}/', $input)) {
			return true;
		}
		return false;
	}
	function correovalido($input)
	{
		if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
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
			<h3 class="mb-3 fw-normal">Registrar <?= $_SESSION["tipoRegistro"] === "altapaciente" ? "paciente" : "médico" ?></h3>
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

				<div class="mb-3 col-sm-4">
					<label class="form-label">DNI</label>
					<input type="text" class="form-control" name="dni" pattern="[0-9]{8}[A-Z]" title="8 números y 1 letra" value="<?= $dni ?>" required>
				</div>

				<div class="mb-3 col-sm-4">
					<label class="form-label">Nombre</label>
					<input type="text" class="form-control" name="nombre" pattern="[A-Z][a-zA-Z]+" title="Solo letras, primera letra mayúscula" value="<?= $nombre ?>" required>
				</div>

				<div class="mb-3 col-sm-4">
					<label class="form-label">Apellidos</label>
					<input type="text" class="form-control" name="apellidos" pattern="([A-Z][a-zA-Z]+ [A-Z][a-zA-Z]+)|([A-Z][a-zA-Z]+)" title="Dos apellidos separados por espacios o un solo apellido y cada apellido empezando por mayúscula" value="<?= $apellidos ?>" required>
				</div>

				<?php
				if ($_SESSION["tipoRegistro"] === "altapaciente") {
				?>
					<div class="mb-3 col-sm-6">
						<label class="form-label">Fecha de Nacimiento</label>
						<input type="date" class="form-control" name="fechanacimiento" max="<?= date("Y-m-d") ?>" value="<?= $fechanacimiento ?>" required>
					</div>

					<div class="mb-3 col-sm-6">
						<label class="form-label">Sexo</label>
						<select class="form-select" name="sexo" required>
							<option <?= $sexo === "" ? "selected" : "" ?>>Seleccione</option>
							<option <?= $sexo === "Femenino" ? "selected" : "" ?> value="Femenino">Femenino</option>
							<option <?= $sexo === "Masculino" ? "selected" : "" ?> value="Masculino">Masculino</option>
						</select>
					</div>
				<?php
				} else {
				?>
					<div class="mb-3">
						<label class="form-label">Especialidad</label>
						<input type="text" class="form-control" name="especialidad" pattern="[A-Z][a-zA-Z]+" title="Solo letras y la primera mayuscula" value="<?= $especialidad ?>" required>
					</div>

					<div class="mb-3 col-sm-6">
						<label class="form-label">Teléfono</label>
						<input type="tel" class="form-control" name="telefono" pattern="[0-9]{9}" title="9 dígitos" value="<?= $telefono ?>" required>
					</div>

					<div class="mb-3 col-sm-6">
						<label class="form-label">Correo</label>
						<input type="email" class="form-control" name="correo" value="<?= $correo ?>" required>
					</div>
				<?php
				}
				?>

				<div class="mb-3 col-sm-6">
					<label class="form-label">Contraseña</label>
					<input type="password" class="form-control" name="password" required>
				</div>

				<div class="mb-3 col-sm-6">
					<label class="form-label">Repetir Contraseña</label>
					<input type="password" class="form-control" name="password2" required>
				</div>

				<div>
					<button type="submit" class="col-12 col-sm-auto btn btn-primary" name="darAlta">Dar de Alta</button>
				</div>

			</div>
		</div>
	</form>
</body>

</html>
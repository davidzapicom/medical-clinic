<?php
session_start();
if (isset($_SESSION["tipo"])){
if ($_SESSION["tipo"] == "admin"){
	header ("Location: admin.php");
	exit();
	}
if ($_SESSION["tipo"] == "medico"){
	header("Location: medico.php");
	exit();
}
if ($_SESSION["tipo"] == "asistente"){
	header("Location: asistente.php");
	exit();
}
if ($_SESSION["tipo"] == "paciente"){
	header("Location: paciente.php");
	exit();
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Clinica login</title>
</head>
<body>
	<h1 style="background-color: red; color: white; padding: 2%; width: 600px;">CENTRO MÉDICO ADSI VIRTUAL</h1>
<form action="clinica.php" method="post" style="background-color: silver; width: 408px;">
	<p style="width: 400px; background-color: red; padding: 1%;"><span style="font-family: Helvetica; color: white; margin-left: 35%;">Inicio sesión</span></p>
	Login: <input style="margin-bottom: 2px;" type="text" name="nombre" placeholder="usuario" size="12"> <br>
	Clave: <input type="password"  pattern=".{6,}" name="pass" size="12"> <br>
	<p style="width: 400px; background-color: red; color: white; padding: 1%;">
	<input style="margin-left: 35%;" type="submit" name="enviar" value="Iniciar sesión">
	</p>
</form>
</body>
</html>

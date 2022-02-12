<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
	<?php
	session_start();
	$sessionErr = $consultaErr = "";
    echo '<h3>Hola ' .$_SESSION["name"]. ' ' .$_SESSION["rol"]. '.</h3>';
    echo '<a class="boton" href="logout.php">Cerrar sesión</a>';
	if ($_SESSION["rol"] === "consultor") {
		$_SESSION["con"] = mysqli_connect("localhost", "consultor", "consultor", "ventas");
	} else {
		$sessionErr = "No puedes consultar";
	}
	$hoy = date("Y-m-d");
	?>
		<div class="container">
				<form action="#" method="post">
					<p class="error"><?php ' . $sessionErr . ' ?></p>
					<div>
						Inicio: <input type="date" name="inicio" max="<?php echo $hoy ?>">
						Fin: <input type="date" name="fin" max="<?php $hoy ?>">
						<button type="submit" class="boton" name="consultar">Consultar</button>
					</div>
	<?php
	if (isset($_POST['consultar'])) {
		if (($_POST["inicio"] === "") && ($_POST["fin"] === "")) {
			$inicio = "0000-00-00 00:00:00";
			$fin =  $hoy . " 23:59:59";
		} else if (($_POST["inicio"] === "") || ($_POST["fin"] === "")) {
			$consultaErr = 'Introduce ambas fechas o deja ambas vacias.';
		} else if ($_POST["inicio"] > $_POST["fin"]) {
			$consultaErr = 'El "fin" debe ser posterior al "inicio".';
		} else {
			$inicio = $_POST["inicio"] . " 00:00:00";
			$fin = $_POST["fin"] . " 23:59:59";
		}
		if ($consultaErr === "") {
			$selectCompras = 'SELECT * FROM compras WHERE (fecha BETWEEN "' . $inicio . '" AND "' . $fin . '") AND (idusuario = "' . $_SESSION["idusuario"] . '")';
			$consultarCompras = mysqli_query($_SESSION["con"], $selectCompras);
			if (mysqli_num_rows($consultarCompras) === 0) {
				$consultaErr = $_SESSION["name"] . ", no has realizado ninguna compra entre esas fechas.";
			}
		}
		if ($consultaErr !== "") {
			echo '<p class="error">' . $consultaErr . '</p>';
		} else {
			?>
					<table>
						<thead>
							<th>Fecha</th>
							<th>Nombre</th>
							<th>Precio</th>
							<th>Cantidad</th>
						</thead>
						<tbody>
			<?php
			while ($fetch = mysqli_fetch_array($consultarCompras)) {
				$selectArticulos = 'SELECT descripcion FROM articulos WHERE idarticulo = "' . $fetch["idarticulo"] . '"';
				$consultaNombreArticulo = mysqli_query($_SESSION["con"], $selectArticulos);
				$nombreArticulo = mysqli_fetch_assoc($consultaNombreArticulo)["descripcion"];
				echo '
							<tr>
								<td> ' . $fetch["fecha"] . '</td>
								<td> ' . $nombreArticulo . '</td>
								<td> ' . $fetch["precio_unitario"] . '€</td>
								<td> ' . $fetch["cantidad"] . '</td>
							</tr>
				';
			}
			?>
						</tbody>
					</table>
		<?php
		}
	}
	?>
				</form>
		</div>
</body>
</html>
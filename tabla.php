<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/table-style.css">
</head>

<body>
    <?php
	session_start();
		$con = mysqli_connect("localhost", "administrador", "", "Clinica");
		$selectCompras = 'SELECT * FROM citas WHERE citConsultorio="6"';
			$resultado = mysqli_query($con, $selectCompras);
			// if (mysqli_num_rows($resultado) === 0) {
			// 	$consultaErr = $_SESSION["name"] . ", no has realizado ninguna compra entre esas fechas.";
			// }
			?>
            <section>
                <h1>Fixed Table header</h1>
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th>Identificación</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha Nacimiento</th>
                                <th>Sexo</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <?php
			while ($fetch = mysqli_fetch_array($resultado)) {
				echo '
							<tr>
								<td> ' . $fetch["dniPac"] . '</td>
								<td> ' . $fetch["pacNombres"] . '</td>
								<td> ' . $fetch["pacApellidos"] . '</td>
								<td> ' . $fetch["pacFechaNacimiento"] . '</td>
								<td> ' . $fetch["pacSexo"] . '</td>
							</tr>';
			}
			?>
                        </tbody>
                    </table>
                </div>
            </section>
            <script src="assets/js/table-script.js"></script>
</body>

</html>
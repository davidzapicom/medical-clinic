<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/table-style.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/table-script.js"></script>
</head>

<body>
    <?php
    session_start();
    if ($_SESSION['usutipo'] === 'Asistente') {
        $_SESSION["con"] = mysqli_connect("localhost", "administrador", "", "Clinica");
    } else {
        header("location:../index.php");
    }

    $selectCitas = 'SELECT * FROM citas WHERE citEstado = "Asignado"';
    $consultarCitas = mysqli_query($_SESSION["con"], $selectCitas);
    if (mysqli_num_rows($consultarCitas) === 0) {
        $consultaErr = $_SESSION["name"] . ", no has realizado ninguna compra entre esas fechas.";
    }
    ?>
    <h1>Bienvenid@ <?php  '<p class="ufl">' . $_SESSION['name'] . ', bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>' ?></h1>
    <button class="logout" data-hover="Bye 👋" onclick="window.location.href='../logout.php'">
        <a href="../logout.php">
            <div>Cerrar sesión</div>
        </a>
    </button>
    <a href="index.php">Inicio</a>
    <a href="alta-paciente.php">Alta paciente</a>
    <a href="citas-atendidas.php">Citas atendidas</a>
    <a href="citas-pendientes.php">Citas pendientes</a>
    <a href="ver-pacientes.php">Ver pacientes</a>
    <section>
        <h1>Citas pendientes</h1>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Medico</th>
                        <th>Consultorio</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php
                    while ($fetch = mysqli_fetch_array($consultarCitas)) {
                        echo '<tr>
								<td> ' . $fetch["idCita"] . '</td>
								<td> ' . $fetch["citFecha"] . '</td>
								<td> ' . $fetch["citHora"] . '€</td>
								<td> ' . $fetch["citPaciente"] . '</td>
                                <td> ' . $fetch["citMedico"] . '</td>
                                <td> ' . $fetch["citConsultorio"] . '</td>
                                <td> ' . $fetch["CitObservaciones"] . '</td>
							</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>
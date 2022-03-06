<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Médico - Atender cita | Clinica ADSI</title>
</head>

<body>
    <?php
    session_start();
    $con = mysqli_connect('localhost', 'Medico', 'mEdrrr033IcO', 'Clinica');
    if (mysqli_connect_errno()) {
        printf("Conexión fallida %s\n", mysqli_connect_error());
        exit();
    }

    $fecha = $_SESSION['atenderpaciente'][0];
    $hora = $_SESSION['atenderpaciente'][1];
    $dni = $_SESSION['atenderpaciente'][2];
    $nombre = $_SESSION['atenderpaciente'][3];
    $apellido = $_SESSION['atenderpaciente'][4];
    ?>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../assets/img/scene.jpg" alt="foto perfil">
                </span>
                <div class="text logo-text">
                    <span class="name">Clinica ADSI</span>
                    <span class="profession">
                        <p class="ufl white"><strong><?php echo $_SESSION["name"] . '</strong> | ' . $_SESSION['usutipo']; ?></p>
                    </span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                <li class="nav-link">
                        <a href="citas-atendidas.php">
                        <i class='bx bx-calendar-check icon'></i>
                            <span class="text nav-text">Citas Atendidas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="citas-pendientes.php">
                        <i class='bx bx-calendar-minus icon' ></i>
                            <span class="text nav-text">Citas Pendientes</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="ver-pacientes.php">
                        <i class='bx bxs-user-badge icon'></i>
                            <span class="text nav-text">Ver Pacientes</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li>
                    <a href="../logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Bye 👋</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>
    <section class="home">
        <div class="text">
            <h1>Atender Cita</h1>
        </div>
        <form action="#" method="POST" class="atenderCita">

            <table border="1" style="text-align: center;">
                <tr>
                    <th>DNI paciente</th>
                    <td><?php echo $dni; ?></td>
                </tr>
                <tr>
                    <th>Nombre paciente</th>
                    <?php

                    $sql = "SELECT pacNombres,pacApellidos FROM pacientes WHERE dniPac='$nif';";
                    $result = mysqli_query($con, $sql);
                    $registro = mysqli_fetch_row($result);


                    ?>
                    <td><?php echo $nombre . " " . $apellido; ?></td>
                </tr>
                <tr>
                    <th>Fecha cita</th>
                    <td><?php echo $fecha; ?></td>
                </tr>
                <tr>
                    <th>Hora cita</th>
                    <td><?php echo $hora; ?></td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td><textarea name="obs" placeholder="Escriba aquí las observaciones del paciente" style="box-sizing: border-box; width: 350px; height: 200px; resize: none; overflow: auto;" required="required"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="atender" value="Continuar"></td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_POST['atender'])) {
            $observaciones = $_POST['obs'];
            $sql = "UPDATE citas SET citEstado='Atendido', CitObservaciones='$observaciones' WHERE citPaciente='$nif' AND citFecha='$fecha' AND citHora='$hora';";
            if (mysqli_query($conexion, $sql)) {
                $mensajeregistro = "Se han registrado las observaciones con éxito, redirigiéndole a la página anterior";
        ?>

                <div id="modalB" style="display: block;" class="modal opacidad">
                    <div class="modal-cont cajaModal">
                        <div class="contenedor">
                            <p><?php echo $mensajeregistro; ?></p>
                        </div>
                    </div>
                </div>

        <?php
                header("Refresh:3; url=citas-pendientes.php", true);
            } else {
                echo " <br> Error: " . $sql . "<br>" . mysqli_error($con);
            }
        }
        ?>
    </section>
    <script src="../assets/js/bar-script.js"></script>
    <script src="../assets/js/table-script.js"></script>
</body>

</html>
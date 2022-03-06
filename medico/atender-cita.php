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
    ini_set("display_errors", true);
    $error = $aviso = "";
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


    if (isset($_POST['atender'])) {
        $observaciones = $_POST['observaciones'];
        $sql = "UPDATE citas SET citEstado='Atendido', CitObservaciones='$observaciones' WHERE citPaciente='$dni' AND citFecha='$fecha' AND citHora='$hora';";
        if (mysqli_query($con, $sql)) {
            $error = "La cita se ha registrado como atendida.";
            header("Refresh:3; url=citas-atendidas.php", true);
        } else {
            echo " <br> Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
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
                            <i class='bx bx-calendar-minus icon'></i>
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
            <h1>Alta Paciente</h1>
            <form action="#" method="post">
                DNI: <input type="text" name="dnipaciente" value="<?php echo $dni ?>" readonly>
                <br />
                <?php
                $sql = "SELECT pacNombres,pacApellidos FROM pacientes WHERE dniPac='$dni'";
                $result = mysqli_query($con, $sql);
                $registro = mysqli_fetch_row($result);
                ?>
                Nombre: <input type="text" name="nombre" value="<?php echo $nombre ?>" readonly>
                <br />
                Apellidos: <input type="text" name="apellidos" value="<?php echo $apellido ?>" readonly>
                <br />
                Observaciones: <textarea rows="6" cols="35" name="observaciones" placeholder="Escriba aquí las observaciones del paciente" required></textarea>
                <br />
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" name="atender" value="Continuar">
            </form>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
</body>

</html>
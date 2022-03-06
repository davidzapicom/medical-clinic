<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Asistente - Nueva cita | Clinica ADSI</title>
</head>
<body>
    <?php
    session_start();
    $error = $aviso = "";
    if (isset($_POST['alta'])) {
        $_SESSION['dnipaciente'] = $_POST['dnipaciente'];
        $_SESSION['dnimedico'] = $_POST['dnimedico'];
        $_SESSION['consultorio'] = $_POST['consultorio'];
        $_SESSION['observaciones'] = $_POST['observaciones'];
        $_SESSION['fechacita'] = date('Y-m-d', strtotime($_POST['fechacita']));
        $_SESSION['horacita'] = date('H:i:s', strtotime($_POST['horacita']));


        if ($_SESSION['usutipo'] == 'Asistente') {
            $con = mysqli_connect('localhost', 'Asistente', 'Ass86teN33', 'Clinica');
            if (mysqli_connect_errno()) {
                printf("Conexión fallida %s\n", mysqli_connect_error());
                exit();
            }

            $ins = "INSERT INTO citas (idCita,citFecha,citHora,citPaciente,citMedico,citConsultorio,citEstado,citObservaciones) VALUES (NULL,'$_SESSION[fechacita]','$_SESSION[horacita]','$_SESSION[dnipaciente]','$_SESSION[dnimedico]','$_SESSION[consultorio]','Asignado','$_SESSION[observaciones]')";
            if (mysqli_query($con, $ins)) {
                $error = "Cita insertada correctamente.";
                $_SESSION['dnipaciente'] =  $_SESSION['dnimedico'] =  $_SESSION['consultorio'] =  $_SESSION['observaciones'] =  $_SESSION['fechacita'] =  $_SESSION['horacita'] = "";
            } else {
                $error = "ERROR: no se ha podido insertar la cita.";
                $aviso = "Vuelve a intentarlo.";
            }
            mysqli_close($con);
        } else {
            $error = "No tienes permisos.";
            $aviso = "Inicie sesión como asistente para poder realizar la operación.";
            header("Refresh:4; url=../logout.php", true);
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
                        <a href="#">
                            <i class='bx bx-calendar-plus icon'></i>
                            <span class="text nav-text">Nueva Cita</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="alta-paciente.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Alta Paciente</span>
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
            <h1>Nueva Cita</h1>
            <form action="#" method="post">
                Paciente: <select name="dnipaciente" value="<?php if (isset($_POST['alta'])) echo $_SESSION['dnipaciente']; ?>" required>
                    <?php
                    $con = mysqli_connect('localhost', 'Asistente', 'Ass86teN33', 'Clinica');
                    $result = mysqli_query($con, "SELECT pacNombres,pacApellidos,dniPac FROM pacientes");
                    while ($registro = mysqli_fetch_row($result)) {
                    ?>
                        <option value=<?php echo $registro[2] ?>><?php echo $registro[0] . " " . $registro[1]; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br />
                Médico: <select name="dnimedico" value="<?php if (isset($_POST['alta'])) echo $_SESSION['dnimedico']; ?>" required>
                    <?php
                    $result = mysqli_query($con, "SELECT medNombres,medApellidos,dniMed FROM medicos");
                    while ($registro = mysqli_fetch_row($result)) {
                    ?>
                        <option value=<?php echo $registro[2] ?>><?php echo $registro[0] . " " . $registro[1]; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br />
                Consultorio: <select name="consultorio" value="<?php if (isset($_POST['alta'])) echo $_SESSION['consultorio']; ?>" required>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM consultorios");
                    while ($registro = mysqli_fetch_row($result)) {
                    ?>
                        <option value=<?php echo $registro[0] ?>><?php echo $registro[1] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br />
                Fecha: <input type="date" name="fechacita" value="<?php if (isset($_POST['alta'])) echo $_SESSION['fechacita']; ?>" min="<?= date('Y-m-d'); ?>" max="2100-12-31" required>
                <br />

                Hora: <input type="time" id="horacita" name="horacita" min="09:00" max="20:30" required>
                <small>La clínica atiende de 9:00 a 20:30.</small>
                <br />
                <textarea rows="6" cols="35" name="observaciones" class="form-control" placeholder="Observaciones" maxlength="150" value="<?php if (isset($_POST['alta'])) echo $_SESSION['observaciones']; ?>" required></textarea>
                <br />
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" class="button" name="alta" value="Insertar cita">
            </form>
        </div>
    </section>
    <?php
    $mysqli->close();
    ?>
    <script src="../assets/js/bar-script.js"></script>
</body>
</html>
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
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['nombre'] = $_POST['nombre'];
        $_SESSION['apellidos'] = $_POST['apellidos'];
        $_SESSION['dnipaciente'] = $_POST['dnipaciente'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['password2'] = $_POST['password2'];
        $_SESSION['sexo'] = $_POST['sexo'];
        $_SESSION['fechanacimiento'] = date('Y-m-d', strtotime($_POST['fechanacimiento']));

        if ($_SESSION['usutipo'] == 'Asistente') {
            $con = mysqli_connect('localhost', 'Asistente', 'Ass86teN33', 'Clinica');
            if (mysqli_connect_errno()) {
                printf("Conexión fallida %s\n", mysqli_connect_error());
                exit();
            }
            $selectususarios = "SELECT * FROM pacientes where dniPac='$_SESSION[dnipaciente]'";
            $result = mysqli_query($con, $selectususarios);

            if (mysqli_num_rows($result) != 0) {
                $error = "Ya hay un usuario resgistrado con ese DNI.";
                $aviso = "Compruebe el DNI / inicie sesión.";
            } else {
                if ($_POST['password'] != $_POST['password2']) {
                    $error = "Las contraseñas no coinciden.";
                    $aviso = "Comprueba las contraseñas e intentalo de nuevo.";
                    $_SESSION['password'] = $_SESSION['password2'] = "";
                } else {
                    if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_SESSION['password'])) {
                        $error = "La contraseña debe tener al menos 8 caracteres, un numero, una mayúscula, una minúscula y un carácter especial.";
                        $_SESSION['password'] = $_SESSION['password2'] = "";
                    } else {
                        $cif = hash_hmac('sha512', '$password', 'secret');
                        $inpac = "INSERT INTO pacientes (dniPac,pacNombres,pacApellidos,pacFechaNacimiento,pacSexo) VALUES ('$_SESSION[dnipaciente]','$_SESSION[nombre]','$_SESSION[apellidos]','$_SESSION[fechanacimiento]','$_SESSION[sexo]')";
                        $inusu = "INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$_SESSION[dnipaciente]','$_SESSION[usuario]','$cif','Activo','Paciente')";
                        if (mysqli_query($con, $inpac) && mysqli_query($con, $inusu)) {
                            $error = "Usuario insertado correctamente.";
                            $_SESSION['usuario'] = $_SESSION['nombre'] = $_SESSION['apellidos'] = $_SESSION['dnipaciente'] = $_SESSION['password'] = $_SESSION['password2'] = $_SESSION['sexo'] = $_SESSION['fechanacimiento'] = "";
                        } else {
                            $error = "ERROR: no se ha podido insertar el usuario.";
                            $aviso = "Vuelve a intentarlo.";
                        }
                    }
                }
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
                <input type="text" name="dnipaciente" placeholder="DNI Paciente" required>
                <br />
                <input type="text" name="dnimedico" placeholder="DNI Médico" required>
                <br />
                <input type="text" name="nombre" placeholder="Nombre" required>
                <br />
                <input type="text" name="apellidos" placeholder="Apellidos" required>
                <br />
                <input type="number" name="consultorio" placeholder="Consultorio" required>
                <br />
                <label for="fechacita">Fecha</label>
                <input type="date" name="fechacita" required>
                <br />
                <label for="sexo">Sexo</label>
                <select name="sexo" id="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" class="button" name="alta" value="Insertar cita">
            </form>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
</body>
</html>
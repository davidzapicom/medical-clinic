<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Administrador | Clinica ADSI</title>
</head>
<body>
    <?php
    session_start();
    $error = $aviso = "";
    if (isset($_POST['alta'])) {
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['nombre'] = $_POST['nombre'];
        $_SESSION['apellidos'] = $_POST['apellidos'];
        $_SESSION['especialidad'] = $_POST['especialidad'];
        $_SESSION['telefono'] = $_POST['telefono'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['dnipaciente'] = $_POST['dnipaciente'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['password2'] = $_POST['password2'];
        $_SESSION['estado'] = $_POST['estado'];
        $_SESSION['tipo'] = "Médico";
        if ($_POST['password'] != $_POST['password2']) {
            $error = "Las contraseñas no coinciden.";
            $aviso = "Comprueba las contrasñas e intentalo de nuevo.";
            $_SESSION['password'] = $_SESSION['password2'] = "";
        } else {
            $con = mysqli_connect('localhost', 'administrador', '', 'Clinica');
            $inmed = "INSERT INTO pacientes (dniPac,pacNombres,pacApellidos,pacFechaNacimiento,pacSexo) VALUES ('$_POST[dnipaciente]','$_POST[nombre]','$_POST[apellidos]','$_POST[especialidad]','$_POST[telefono]','$_POST[correo]')";
            $inusu = "INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$_POST[dnipaciente]','$_POST[usuario]','$_POST[password]','$_POST[estado]','$_SESSION[tipo]')";
            if (mysqli_query($con, $inmed) && mysqli_query($con, $inusu)) {
                $error = "Usuario insertado correctamente.";
                $_SESSION['usuario'] = $_SESSION['nombre'] = $_SESSION['apellidos'] = $_SESSION['especialidad'] = "";
                $_SESSION['telefono'] = $_SESSION['email'] = $_SESSION['dnipaciente'] = $_SESSION['password'] = "";
                $_SESSION['password2'] = $_SESSION['estado'] = $_SESSION['tipo'] = "";
            } else {
                $error = "ERROR: no se ha podido insertar el usuario.";
                $aviso = "Vuelve a intentarlo.";
            }
            mysqli_close($con);
        }
    }
    ?>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../assets/img/scene.jpg" alt="">
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
                        <a href="#">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Alta Paciente</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="alta-medico.php">
                            <i class='bx bx-user-plus icon'></i>
                            <span class="text nav-text">Alta Medico</span>
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
                <input type="text" name="dnipaciente" placeholder="DNI" required>
                <br />
                <input type="text" name="nombre" placeholder="Nombre de usuario" required>
                <br />
                <input type="text" name="nombre" placeholder="Nombre" required>
                <br />
                <input type="text" name="apellidos" placeholder="Apellidos" required>
                <br />
                <label for="fechanacimiento">Fecha nacimiento</label>
                <input type="date" name="fechanacimiento" required>
                <br />
                <label for="sexo">Sexo</label>
                <select name="sexo" id="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <div class="input">
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <input type="password" name="password2" placeholder="Contraseña otra vez" required>
                </div>
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" class="button" name="alta" value="Alta">
            </form>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
</body>
</html>
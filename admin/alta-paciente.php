<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Administrador - Alta paciente | Clinica ADSI</title>
</head>
<body>
    <?php
    ini_set("display_errors", true);
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

        if ($_SESSION['usutipo'] == 'Administrador') {
            $con = mysqli_connect('localhost', 'Administrador', 'a2d7mTT4', 'Clinica');
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
            mysqli_close($con);
        } else {
            $error = "No tienes permisos.";
            $aviso = "Inicie sesión como administrador para poder realizar la operación.";
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
                <input type="text" name="dnipaciente" placeholder="DNI" value="<?php if (isset($_POST['alta'])) echo $_SESSION['dnipaciente']; ?>" required>
                <br />
                <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?php if (isset($_POST['alta'])) echo $_SESSION['usuario']; ?>" required>
                <br />
                <input type="text" name="nombre" placeholder="Nombre" value="<?php if (isset($_POST['alta'])) echo $_SESSION['nombre']; ?>" required>
                <br />
                <input type="text" name="apellidos" placeholder="Apellidos" value="<?php if (isset($_POST['alta'])) echo $_SESSION['apellidos']; ?>" required>
                <br />
                <label for="fechanacimiento">Fecha nacimiento</label>
                <input type="date" name="fechanacimiento" value="<?php if (isset($_POST['alta'])) echo $_SESSION['fechanacimiento']; ?>" required>
                <br />
                <label for="sexo">Sexo</label>
                <input type="radio" name="sexo" <?php if (isset($_SESSION['sexo']) && $_SESSION['sexo'] == "Masculino") echo "checked";?> value="Masculino" required>Masculino
                <input type="radio" name="sexo" <?php if (isset($_SESSION['sexo']) && $_SESSION['sexo'] == "Femenino") echo "checked";?> value="Femenino" required>Femenino
                <div class="input">
                    <input type="password" name="password" placeholder="Contraseña" value="<?php if (isset($_POST['alta'])) echo $_SESSION['password']; ?>" equired>
                    <input type="password" name="password2" placeholder="Contraseña otra vez" value="<?php if (isset($_POST['alta'])) echo $_SESSION['password2']; ?>" required>
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
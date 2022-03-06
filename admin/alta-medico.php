<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Administrador - Alta médico | Clinica ADSI</title>
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
        $_SESSION['correo'] = $_POST['correo'];
        $_SESSION['dnimedico'] = $_POST['dnimedico'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['password2'] = $_POST['password2'];
        $_SESSION['estado'] = $_POST['estado'];
        $_SESSION['tipo'] = "Medico";

        if ($_SESSION['usutipo'] == 'Administrador') {
            $con = mysqli_connect('localhost', 'Administrador', 'a2d7mTT4', 'Clinica');
            if (mysqli_connect_errno()) {
                printf("Conexión fallida %s\n", mysqli_connect_error());
                exit();
            }
            $selectususarios = "SELECT * FROM medicos where dniMed='$_SESSION[dnimedico]'";
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
                        $inmed = "INSERT INTO medicos (dniMed,medNombres,medApellidos,medEspecialidad,medTelefono,medCorreo) VALUES ('$_SESSION[dnimedico]','$_SESSION[nombre]','$_SESSION[apellidos]','$_SESSION[especialidad]','$_SESSION[telefono]','$_SESSION[correo]')";
                        $inusu = "INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$_SESSION[dnimedico]','$_SESSION[usuario]','$cif','$_SESSION[estado]','$_SESSION[tipo]')";
                        if (mysqli_query($con, $inmed) && mysqli_query($con, $inusu)) {
                            $error = "Usuario insertado correctamente.";
                            $_SESSION['usuario'] = $_SESSION['nombre'] = $_SESSION['apellidos'] = $_SESSION['especialidad'] = $_SESSION['telefono'] = $_SESSION['correo'] = $_SESSION['dnimedico'] = $_SESSION['password'] = $_SESSION['password2'] = $_SESSION['estado'] = $_SESSION['tipo'] = "";
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
                        <a href="alta-paciente.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Alta Paciente</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
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
            <h1>Alta Médico</h1>
            <form action="#" method="post">
                <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?php if (isset($_POST['alta'])) echo $_SESSION['usuario']; ?>" pattern="[A-Za-z0-9]+" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir solo letras y numeros.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="nombre" placeholder="Nombre" value="<?php if (isset($_POST['alta'])) echo $_SESSION['nombre']; ?>" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir solo letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="apellidos" placeholder="Apellidos" value="<?php if (isset($_POST['alta'])) echo $_SESSION['apellidos']; ?>" maxlength="15" oninvalid="this.setCustomValidity('Debes introducir solo letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="especialidad" placeholder="Especialidad" value="<?php if (isset($_POST['alta'])) echo $_SESSION['especialidad']; ?>" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="tel" name="telefono" placeholder="Teléfono (000-000-000)" value="<?php if (isset($_POST['alta'])) echo $_SESSION['telefono']; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" maxlength="15" oninvalid="this.setCustomValidity('Debes introducir solo numeros y letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="email" name="correo" placeholder="Correo" value="<?php if (isset($_POST['alta'])) echo $_SESSION['correo']; ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" maxlength="30" oninvalid="this.setCustomValidity('Debes introducir un email válido.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="dnimedico" placeholder="DNI" value="<?php if (isset($_POST['alta'])) echo $_SESSION['dnimedico']; ?>" pattern="[0-9]{8}[A-Za-z]{1}" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir ocho numeros y una letra.')" oninput="this.setCustomValidity('')" required>
                <br />
                <div class="input">
                    <input type="password" name="password" placeholder="Contraseña" value="<?php if (isset($_POST['alta'])) echo $_SESSION['password']; ?>" required>
                    <input type="password" name="password2" placeholder="Contraseña otra vez" value="<?php if (isset($_POST['alta'])) echo $_SESSION['password2']; ?>" required>
                </div>
                <label for="estado">Estado</label>
                <select name="estado" id="estado" value="<?php if (isset($_POST['alta'])) echo $_SESSION['estado']; ?>" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <br />
                <label for="tipo">Rol</label>
                <input type="text" name="tipo" value="Médico" readonly>
                <br />
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" class="button" name="alta" value="Alta">
            </form>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
</body>

</html>
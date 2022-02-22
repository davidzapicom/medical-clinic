<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../paciente/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Administrador - Alta Medico | Clinica ADSI</title>
</head>

<body>
    <?php
    session_start();
    $error = "";
    $aviso = "";
    if (isset($_POST['login'])) {
        
        $apellidos = $_POST['apellidos'];




        $inuser = "INSERT INTO usuarios ('dniUsu','usuLogin','usuPassword','usuEstado','usutipo') VALUES ('$_POST[dni]', '$_POST[nombre]','$_POST[password]','$_POST[estado]','$_POST[tipo]')";
        $inmed = "INSERT INTO medicos ('dniMed','medNombres','medApellidos','medEspecialidad','medTelefono','medCorreo') VALUES ('$_POST[dni]','$_POST[nombre]','$_POST[apellidos]','$_POST[especialidad]','$_POST[telefono]','$_POST[email]')";
        $result = mysqli_query($_SESSION["con"], $inuser);
        $result = mysqli_query($_SESSION["con"], $inmed);
        mysqli_close($_SESSION["con"]);
    } else {
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
                        <p class="ufl"><strong><?php echo $_SESSION["name"] . '</strong> | ' . $_SESSION['usutipo']; ?></p>
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
                            <span class="text nav-text">Alta Médico</span>
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
                <input type="text" name="nombre" placeholder="Nombre" class="input__password" required>
                <br />
                <input type="text" name="apellidos" placeholder="Apellidos" class="input__password" required>
                <br />
                <input type="text" name="especialidad" placeholder="Especialidad" class="input__password" required>
                <br />
                <input type="tel" name="telefono" placeholder="Telefono" class="input__password" required>
                <br />
                <input type="email" name="email" placeholder="Email" class="input__password" required>
                <br />
                <input type="id" name="dni" placeholder="DNI" class="input__password" required>
                <br />
                <div class="input">
                    <input type="password" name="password" placeholder="Contraseña" class="input__password" id="input-pass" required>
                    <input type="password" name="password2" placeholder="Contraseña otra vez" class="input__password" id="input-pass" required>
                </div>
                <select name="estado">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <input type="text" name="tipo" placeholder="Rol" class="input__password" required>
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" class="button" name="alta" value="Alta">
            </form>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
    <?php
    }
    ?>
</body>
</html>
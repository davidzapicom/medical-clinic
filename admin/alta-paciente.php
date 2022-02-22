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
                        <a href="#">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Alta Paciente</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="alta-medico.php">
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
            <h1>Alta Paciente</h1>
            <form action="#" method="post">
                <div class="input">
                    <i class='bx bx-user input__lock'></i>
                    <input type="text" name="usu" placeholder="Nombre de usuario/a o DNI" class="input__password" required>
                </div>
                <br />
                <div class="input">
                    <div class="input__overlay" id="input-overlay"></div>

                    <i class='bx bx-lock-alt input__lock'></i>
                    <input type="password" name="pass" placeholder="Contraseña" class="input__password" id="input-pass" required>
                    <i class='bx bx-hide input__icon' id="input-icon"></i>
                </div>
                <div class="input">


                    <i class='bx bx-lock-alt input__lock'></i>
                    <input type="password" name="pass" placeholder="Introduce la contraseña otra vez" class="input__password" id="input-pass" required>
                    <i class='bx bx-hide input__icon' id="input-icon"></i>
                </div>
                <p><?php echo "<strong>$error</strong>"; ?></p>
                <p><?php echo "$aviso"; ?></p>
                <input type="submit" class="button" name="login" value="Iniciar sesion">
            </form>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
</body>

</html>
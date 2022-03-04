<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        body {
            display: grid;
            place-items: center;
            background-image: url("assets/img/frame.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Login | Clinica ADSI</title>
</head>
<body>
    <?php
    ini_set("display_errors", true);
    session_start();
    $error = $aviso = "";
    if (isset($_POST['login'])) {
        $_SESSION['name'] = $_POST['usu'];
        $_SESSION['dni'] = $_POST['dni'];
        $password = $_POST['pass'];
        $cif = hash_hmac('sha512', '$password', 'secret');
        $con = mysqli_connect('localhost', 'Acceso', 'take55AcceSs38', 'Clinica');
        $sentencia = 'SELECT * FROM usuarios WHERE dniUsu="' . $_SESSION["dni"] . '" AND (usuLogin="' . $_SESSION["name"] . '" AND usuPassword="' . $cif . '")';
        $result = mysqli_query($con, $sentencia);
        if (mysqli_connect_errno()) {
            printf("Conexión fallida %s\n", mysqli_connect_error());
            exit();
        }
        $fetch = mysqli_fetch_assoc($result);
        // $_SESSION['usutipo'] = $fetch['usutipo'];

        var_dump($fetch);

        if (mysqli_num_rows($result) == 0) {
            $error = "Usuario inexistente";
            // $sentencia = 'SELECT * FROM usuarios WHERE usuLogin="' . $_SESSION["name"] . '" AND dniUsu="' . $_SESSION["dni"] . '"';
            // $result2 = mysqli_query($con, $sentencia);
            // $fetch = mysqli_fetch_assoc($result2);
            // mysqli_close($con);
            // if (mysqli_num_rows($result2) == 0) {
            //     $error = "Usuario inexistente.";
            // } else {
            //     $error = "Contraseña incorrecta.";
            // }
            // $aviso = "Por favor, intentelo de nuevo.";
            // header("Refresh:2; url=index-complicado.php", true);
        } else {






            if ($_SESSION['usutipo'] == 'Paciente') {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
                header("Refresh:2.5; url=paciente/index.php", true);
            } else if ($_SESSION['usutipo'] == 'Medico') {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
                header("Refresh:2.5; url=medico/index.php", true);
            } else if ($_SESSION['usutipo'] == 'Asistente') {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
                header("Refresh:2.5; url=asistente/index.php", true);
            } else {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
                header("Refresh:2.5; url=admin/index.php", true);
            }
        }
    }
    ?>
    <div class="form">
        <form action="#" method="post">
            <h1>Clinica ADSI</h1>
            <div class="input">
            <i class='bx bx-dialpad-alt input__lock'></i>
                <input type="text" name="dni" placeholder="DNI" class="input__password" required>
            </div>
            <br />
            <div class="input">
                <i class='bx bx-user input__lock'></i>
                <input type="text" name="usu" placeholder="Nombre de usuario/a" class="input__password" required>
            </div>
            <br />
            <div class="input">
                <div class="input__overlay" id="input-overlay"></div>

                <i class='bx bx-lock-alt input__lock'></i>
                <input type="password" name="pass" placeholder="Contraseña" class="input__password" id="input-pass" required>
                <i class='bx bx-hide input__icon' id="input-icon"></i>
            </div>
            <p><?php echo "<strong>$error</strong>"; ?></p>
            <p><?php echo "$aviso"; ?></p>
            <input type="submit" class="button" name="login" value="Iniciar sesion">
        </form>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>
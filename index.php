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
    session_start();
    $error = "";
    $aviso = "";
    if (isset($_POST['login'])) {
        $_SESSION['usu'] = $_POST['usu'];
        $password = $_POST['pass'];
        //$cif = hash_hmac('sha512', '$password', 'secret');
        $_SESSION["con"] = mysqli_connect('localhost', 'administrador', '', 'Clinica');
        $sentencia = 'SELECT * FROM usuarios WHERE usuLogin="' . $_SESSION["usu"] . '" OR dniUsu="' . $_SESSION["usu"] . '" AND usuPassword="' . $password . '"';
        $result = mysqli_query($_SESSION["con"], $sentencia);
        $fetch = mysqli_fetch_assoc($result);
        $_SESSION['name'] = $fetch['usuLogin'];
        $_SESSION['dni'] = $fetch['dniUsu'];
        $_SESSION['usutipo'] = $fetch['usutipo'];
        if (mysqli_num_rows($result) == 0) {
            $sentencia = 'SELECT * FROM usuarios WHERE usuLogin="' . $_SESSION["usu"] . '" OR dniUsu="' . $_SESSION["usu"] . '"';
            $result2 = mysqli_query($_SESSION["con"], $sentencia);
            $fetch = mysqli_fetch_assoc($result2);
            mysqli_close($_SESSION["con"]);
            if (mysqli_num_rows($result2) == 0) {
                $error = "Usuario inexistente.";
            } else {
                $error = "Contraseña incorrecta.";
            }
            $aviso = "Por favor, intentelo de nuevo.";
    ?>
            <script>
                setTimeout(saltar, 2000);

                function saltar() {
                    location.replace("index.php");
                }
            </script>
            <?php
        } else {
            if ($_SESSION['usutipo'] == 'Paciente') {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
            ?>
                <script>
                    setTimeout(saltar, 2500);

                    function saltar() {
                        location.replace("paciente/index.php");
                    }
                </script>
            <?php
            } else if ($_SESSION['usutipo'] == 'Medico') {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
            ?>
                <script>
                    setTimeout(saltar, 2500);

                    function saltar() {
                        location.replace("medico/index.php");
                    }
                </script>
            <?php
            } else if ($_SESSION['usutipo'] == 'Asistente') {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
            ?>
                <script>
                    setTimeout(saltar, 2500);

                    function saltar() {
                        location.replace("asistente/index.php");
                    }
                </script>
            <?php
            } else {
                $error = '<p class="ufl"><strong>' . $_SESSION["name"] . '</strong>, bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>';
            ?>
                <script>
                    setTimeout(saltar, 2500);

                    function saltar() {
                        location.replace("admin/index.php");
                    }
                </script>
    <?php
            }
        }
    }
    ?>
    <div class="form">
        <form action="#" method="post">
            <h1>Clinica ADSI</h1>
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
            <p><?php echo "<strong>$error</strong>"; ?></p>
            <p><?php echo "$aviso"; ?></p>
            <input type="submit" class="button" name="login" value="Iniciar sesion">
        </form>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>
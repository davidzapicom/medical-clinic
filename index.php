<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-image: url("assets/img/frame.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Iniciar sesion</title>
</head>
<body>
    <?php
    session_start();
    $error = "";
    if (isset($_POST['login'])) {
        $_SESSION['name'] = $_POST['name'];
        $password = $_POST['pass'];
        //$cif = hash_hmac('sha512', '$password', 'secret');
        $_SESSION["con"] = mysqli_connect('localhost', 'administrador', '', 'Clinica');
        $sentencia = 'SELECT * FROM usuarios WHERE usuLogin="' . $_SESSION["name"] . '" AND usuPassword="' . $password . '"';
        $result = mysqli_query($_SESSION["con"], $sentencia);
        $fetch = mysqli_fetch_assoc($result);
        $_SESSION['usutipo'] = $fetch['usutipo'];
        $_SESSION["usuLogin"] = $fetch["usuLogin"];
        mysqli_close($_SESSION["con"]);
        if (mysqli_num_rows($result) == 0) {
            $error = "Usuario inexistente/contraseña incorrecta. <br/> Intentelo de nuevo.";
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
                $error = 'Bienvenid@ ' . $_SESSION["name"] . '! <br/> Espere mientras es redirigid@.';
            ?>
                <script>
                    setTimeout(saltar, 2500);
                    function saltar() {
                        location.replace("paciente/index.php");
                    }
                </script>
            <?php
            } else if ($_SESSION['usutipo'] == 'Medico') {
                $error = 'Bienvenid@ ' . $_SESSION["name"] . '! <br/> Espere mientras es redirigid@.';
            ?>
                <script>
                    setTimeout(saltar, 2500);
                    function saltar() {
                        location.replace("medico/index.php");
                    }
                </script>
            <?php
            } else if ($_SESSION['usutipo'] == 'Asistente') {
                $error = 'Bienvenid@ ' . $_SESSION["name"] . '! <br/> Espere mientras es redirigid@.';
            ?>
                <script>
                    setTimeout(saltar, 2500);
                    function saltar() {
                        location.replace("asistente/index.php");
                    }
                </script>
            <?php
            } else {
                $error = 'Bienvenid@ ' . $_SESSION["name"] . '! <br/> Espere mientras es redirigid@.';
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
            <h1>¡Bienvenid@!</h1>
            <div class="input">
                <i class='bx bx-user input__lock'></i>
                <input type="text" name="name" placeholder="Nombre de usuario/a" class="input__password" required>
            </div>
            <br />
            <div class="input">
                <div class="input__overlay" id="input-overlay"></div>

                <i class='bx bx-lock-alt input__lock'></i>
                <input type="password" name="pass" placeholder="Contraseña" class="input__password" id="input-pass" required>
                <i class='bx bx-hide input__icon' id="input-icon"></i>
            </div>
            <p><?php echo "<strong> $error </strong>"; ?></p>
            <br />
            <input type="submit" class="button" name="login" value="Iniciar sesion">
        </form>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>
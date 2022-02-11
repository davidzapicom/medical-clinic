<?php
session_start();
$error = "";
if (isset($_POST['Login'])) {
    $_SESSION['name'] = $_POST['name'];
    $password = $_POST['pass'];
    $cif = hash_hmac('sha512', '$password', 'secret');
    $_SESSION["con"] = mysqli_connect('localhost', 'root', '', 'Clinica');
    $sentencia = 'SELECT * FROM usuarios WHERE usuLogin="' . $_SESSION["name"] . '" AND usuPassword="' . $cif . '"';
    $result = mysqli_query($_SESSION["con"], $sentencia);
    $fetch = mysqli_fetch_assoc($result);
    $_SESSION['rol'] = $fetch['rol'];
    $_SESSION["idusuario"] = $fetch["idusuario"];
    mysqli_close($_SESSION["con"]);
    if (mysqli_num_rows($result) == 0) {
        $error = "Usuario inexistente o contraseña incorrecta";
    } else {
        if ($_SESSION['rol'] == 'consultor') {
            header("location:cart.php");
        } else if ($_SESSION['rol'] == 'administrador') {
            header("location:insert.php");
        }
    }
} else {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <title>Iniciar sesion</title>
    </head>

    <body>
        <div class="form">
            <form action="login.php" method="post">
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
                <p><?php echo $error; ?></p>
                <br />
                <input type="submit" class="button" name="login" value="Iniciar sesion">
            </form>
        </div>
        <script src="assets/js/main.js"></script>
    </body>

    </html>
<?php
}
?>
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
    ini_set('display_errors', '1');
    $error = $aviso = "";
    if (isset($_POST['alta'])) {
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $especialidad = $_POST['especialidad'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $dnimedico = $_POST['dnimedico'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $estado = $_POST['estado'];
        $tipo = "Medico";

        if ($_SESSION['usutipo'] == 'Administrador') {
            $con = mysqli_connect('localhost', 'Administrador', 'a2d7mTT4', 'Clinica');
            if (mysqli_connect_errno()) {
                printf("Conexión fallida %s\n", mysqli_connect_error());
                exit();
            }
            $selectdni = "SELECT * FROM usuarios where dniUsu='$dnimedico' AND usutipo='Medico'";
            $selectusu = "SELECT * FROM usuarios where usuLogin='$usuario' AND usutipo='Medico'";
            $resultdni = mysqli_query($con, $selectdni);
            $resultusu = mysqli_query($con, $selectusu);

            if (mysqli_num_rows($resultdni) != 0 && mysqli_num_rows($resultusu) != 0) {
                $error = "Ya hay un médico resgistrado con ese DNI y usuario.";
                $aviso = "Compruebe los datos / inicie sesión.";
                $_SESSION['check'] = 0;
            } else if (mysqli_num_rows($resultdni) != 0) {
                $error = "Ya hay un médico resgistrado con ese DNI.";
                $aviso = "Compruebe el DNI / inicie sesión.";
                $_SESSION['check'] = 0;
            } else if (mysqli_num_rows($resultusu) != 0) {
                $error = "Ya hay un médico resgistrado con ese usuario.";
                $aviso = "Compruebe el usuario / inicie sesión.";
                $_SESSION['check'] = 0;
            } else if ($_POST['password'] != $_POST['password2']) {
                $error = "Las contraseñas no coinciden.";
                $aviso = "Comprueba las contraseñas e intentalo de nuevo.";
                $_SESSION['check'] = 0;
            } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
                $error = "La contraseña debe tener al menos 8 caracteres, un numero, una mayúscula, una minúscula y un carácter especial.";
                $_SESSION['check'] = 0;
            } else {
                $cif = hash_hmac('sha512', '$password', 'secret');
                $inmed = "INSERT INTO medicos (dniMed,medNombres,medApellidos,medEspecialidad,medTelefono,medCorreo) VALUES ('$dnimedico','$nombre','$apellidos','$especialidad','$telefono','$correo')";
                $inusu = "INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$dnimedico','$usuario','$cif','$estado','$tipo')";

                if (mysqli_query($con, $inmed) && mysqli_query($con, $inusu)) {
                    $_SESSION['check'] = 1;
                } else {
                    $error = "ERROR: no se ha podido insertar el médico.";
                    $aviso = "Vuelve a intentarlo.";
                    $_SESSION['check'] = 0;
                }
            }
            mysqli_close($con);
        } else {
            $error = "No tienes permisos.";
            $aviso = "Inicie sesión como administrador para poder realizar la operación.";
            header("Refresh:4; url=../logout.php", true);
        }
    }
    if ($_SESSION['check'] == 1) {
        $error = "Médico insertado correctamente.";
    }






//Funciones


//} else if (($_SESSION["tipoRegistro"] === "altamedico") && (!regexvalidar($regexTelefono, $telefono))) {
    function regexvalidar($regex, $input)
	{
		if (preg_match("/" . $regex . "/", $input)) {
			return true;
		}
		return false;
	}
	function dnivalido($regex, $dni)
	{
		if (!regexvalidar($regex, $dni)) {
			return false;
		}
		$letra = substr($dni, -1);
		$numeros = substr($dni, 0, -1);
		if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
			return true;
		}
		return false;
	}
	function fechavalida($input)
	{
		if ($input <= date('Y-m-d')) {
			return true;
		}
		return false;
	}
	function sexovalido($input)
	{
		if (($input === "Masculino") || ($input === "Femenino")) {
			return true;
		}
		return false;
	}
	function correovalido($input)
	{
		if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
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
                <input type="text" name="usuario" placeholder="Nombre de usuario" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $usuario; ?>" pattern="[A-Za-z0-9]+" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir solo letras y numeros.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="nombre" placeholder="Nombre" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $nombre; ?>" pattern="[A-Za-z]+" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir solo letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="apellidos" placeholder="Apellidos" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $apellidos; ?>" pattern="[A-Za-z]+" maxlength="15" oninvalid="this.setCustomValidity('Debes introducir solo letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="especialidad" placeholder="Especialidad" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $especialidad; ?>" pattern="[A-Za-z]+" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="tel" name="telefono" placeholder="Teléfono (000000000)" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $telefono; ?>" pattern="[0-9]{9}" maxlength="9" oninvalid="this.setCustomValidity('Debes introducir solo numeros y letras.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="email" name="correo" placeholder="Correo" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $correo; ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" maxlength="30" oninvalid="this.setCustomValidity('Debes introducir un email válido.')" oninput="this.setCustomValidity('')" required>
                <br />
                <input type="text" name="dnimedico" placeholder="DNI" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $dnimedico; ?>" pattern="[0-9]{8}[A-Za-z]{1}" maxlength="10" oninvalid="this.setCustomValidity('Debes introducir ocho numeros y una letra.')" oninput="this.setCustomValidity('')" required>
                <br />
                <div class="input">
                    <input type="password" name="password" placeholder="Contraseña" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $password; ?>" required>
                    <input type="password" name="password2" placeholder="Contraseña otra vez" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $password2; ?>" required>
                </div>
                <label for="estado">Estado</label>
                <select name="estado" id="estado" value="<?php if (isset($_POST['alta']) && $_SESSION['check'] == 0) echo $estado; ?>" required>
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
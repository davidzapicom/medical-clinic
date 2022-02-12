<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        form {
            display: grid;
            place-items: center;
            width: 100px;
        }
    </style>
    <script language="javascript">
        function mostrarForm(valor) {

            if (document.prim.selec[0].selected == true) {
                document.getElementById('asistente').style.visibility = "visible";
                document.getElementById('medico').style.visibility = "hidden";
                document.getElementById('paciente').style.visibility = "hidden";
            } else if (document.prim.selec[1].selected == true) {
                document.getElementById('asistente').style.visibility = "hidden";
                document.getElementById('medico').style.visibility = "visible";
                document.getElementById('paciente').style.visibility = "hidden";
            } else {
                document.getElementById('asistente').style.visibility = "hidden";
                document.getElementById('medico').style.visibility = "hidden";
                document.getElementById('paciente').style.visibility = "visible";
            }
        }
    </script>
    <title>Página de altas | Clinica</title>
</head>

<body>
    <!-- <?php
            session_start();
            if (isset($_POST['asistente']) || isset($_POST['medico']) || isset($_POST['paciente'])) {
            }

            ?> -->
    <h1>Bienvenid@ <?php  '<p class="ufl">' . $_SESSION['name'] . ', bienvenid@! <br/>Por favor, espere mientras es redirigid@.</p>' ?></h1>
    <button class="logout" data-hover="Bye 👋" onclick="window.location.href='../logout.php'">
        <a href="../logout.php">
            <div>Cerrar sesión</div>
        </a>
    </button>


    <div id="primero" class="custom-select" style="width:200px;">
        <form id="prim" name="prim">
            <select name="selec" onchange="javascript: mostrarForm('value');">
                <option value="0">Asistente</option>
                <option value="1">Medico</option>
                <option value="2">Paciente</option>
            </select>
        </form>
    </div>
    <details>


    <div id="asistente">
        <form id="soport" action="#" method="post">
            <label for="sop">Soporte</label>
            <input id="sop" />
        </form>
    </div>
    <div id="medico" style="visibility: hidden;">
        <form id="information" action="#" method="post">
            <label for=" inf">Informaci&oacute;n</label>
            <input id="inf" />
        </form>
    </div>
    <div id="paciente" style="visibility: hidden;">
        <form id="information" action="#" method="post">
            <h3>Formulario alta paciente:</h3>
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
            <p><?php echo "<strong>$error</strong>"; ?></p>
            <p><?php echo "$aviso"; ?></p>
            <input type="submit" class="button" name="login" value="Iniciar sesion">
        </form>
    </div>
    <script src="assets/js/main.js"></script>
</body>
</html>
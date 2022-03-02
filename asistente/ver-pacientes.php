<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Asistente - Pacientes | Clinica ADSI</title>
</head>
<body>
    <?php
    session_start();
    $con = mysqli_connect('localhost', 'Asistente', 'Ass86teN33', 'Clinica');
    if (mysqli_connect_errno()) {
        printf("Conexión fallida %s\n", mysqli_connect_error());
        exit();
    }

   $sql = "SELECT DISTINCT * FROM pacientes"; 
   $result = mysqli_query($con, $sql);
    $filas = mysqli_num_rows($result);
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
                        <a href="citas-atendidas.php">
                            <i class='bx bx-calendar-check icon'></i>
                            <span class="text nav-text">Citas Atendidas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="nueva-cita.php">
                            <i class='bx bx-calendar-plus icon'></i>
                            <span class="text nav-text">Nueva Cita</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="alta-paciente.php">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Alta Paciente</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bxs-user-badge icon'></i>
                            <span class="text nav-text">Ver Pacientes</span>
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
            <h1>Mis Pacientes</h1>
        </div>
        <div class="tabla">
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha Nacimiento</th>
                            <th>Sexo</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <?php
                        if ($filas != 0) {
                            while ($registro = mysqli_fetch_row($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $registro[0]; ?></td>
                                    <td><?php echo $registro[1]; ?></td>
                                    <td><?php echo $registro[2]; ?></td>
                                    <td><?php echo $registro[3]; ?></td>
                                    <td><?php echo $registro[4]; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td>No hay pacientes en el registro</td></tr>";
                        }
                        mysqli_close($con);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="../assets/js/bar-script.js"></script>
    <script src="assets/js/table-script.js"></script>
</body>
</html>
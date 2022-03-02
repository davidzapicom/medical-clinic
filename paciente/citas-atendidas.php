<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Paciente - Citas atendidas | Clinica ADSI</title>
</head>
<body>
    <?php
    session_start();
    $con = mysqli_connect('localhost', 'Paciente', 'PACC654456cieEnte2', 'Clinica');
    if (mysqli_connect_errno()) {
        printf("Conexión fallida %s\n", mysqli_connect_error());
        exit();
    }
    
    if ($_SESSION['usutipo'] == 'Paciente') {

    $sql = "SELECT citas.citFecha,citas.citHora,medicos.medNombres,medicos.medApellidos,consultorios.conNombre,citas.CitObservaciones FROM citas,medicos,consultorios WHERE citas.citPaciente='$_SESSION[dni]' AND citas.citEstado='Atendido' AND citas.citMedico=medicos.dniMed AND citas.citConsultorio=consultorios.idConsultorio;";
    $result = mysqli_query($con, $sql);
    $filas = mysqli_num_rows($result);
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
                        <a href="#">
                            <i class='bx bx-calendar-check icon'></i>
                            <span class="text nav-text">Citas Atendidas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="citas-pendientes.php">
                            <i class='bx bx-calendar-minus icon' ></i>
                            <span class="text nav-text">Citas Pendientes</span>
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
            <h1>Mis Citas Atendidas</h1>
        </div>
        <div class="tabla">
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Médico</th>
                            <th>Consultorio</th>
                            <th>Observaciones</th>
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
                                    <td><?php echo $registro[2]. ' ' .$registro[3]; ?></td>
                                    <td><?php echo $registro[4]; ?></td>
                                    <td><?php echo $registro[5]; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td>No hay citas para mostrar.</td></tr>";
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Médico - Citas pendientes | Clinica ADSI</title>
</head>

<body>
    <?php
    session_start();
    $con = mysqli_connect('localhost', 'Medico', 'mEdrrr033IcO', 'Clinica');
    if (mysqli_connect_errno()) {
        printf("Conexión fallida %s\n", mysqli_connect_error());
        exit();
    }

    $sql = "SELECT citas.citFecha,citas.citHora,pacientes.dniPac,pacientes.pacNombres,pacientes.pacApellidos,consultorios.conNombre,citas.CitObservaciones FROM citas,medicos,consultorios,pacientes WHERE citas.citMedico='$_SESSION[dni]' AND citas.citEstado='Asignado' AND citas.citMedico=medicos.dniMed AND citas.citConsultorio=consultorios.idConsultorio AND citas.citPaciente=pacientes.dniPac";
    $result = mysqli_query($con, $sql);
    $filas = mysqli_num_rows($result);



    if (isset($_POST['ac'])) {
		foreach ($_POST['ac'] as $value) {
			$pac=explode(",", $value);
		}
		$_SESSION['atenderpaciente']=$pac;
		var_dump($_SESSION['atenderpaciente']);
		header("Location:atender-cita.php");
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
                        <a href="#">
                        <i class='bx bx-calendar-minus icon' ></i>
                            <span class="text nav-text">Citas Pendientes</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="ver-pacientes.php">
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
            <h1>Mis Citas Pendientes</h1>
        </div>
        <form action="#" method="POST" name="miForm">
        <div class="tabla">
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Dni</th>
                            <th>Paciente</th>
                            <th>Consultorio</th>
                            <th>Observaciones</th>
                            <th>Atender</th>
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
                                    <td><?php echo $registro[3]. ' ' .$registro[4]; ?></td>
                                    <td><?php echo $registro[5]; ?></td>
                                    <td><?php echo $registro[6]; ?></td>
                                    <td><button type="submit" name="ac[]" value=<?php echo $registro[0].",".$registro[1].",".$registro[2].",".$registro[3].",".$registro[4]; ?>>Atender</button></td>
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
        </form>
    </section>
    <script src="../assets/js/bar-script.js"></script>
    <script src="../assets/js/table-script.js"></script>
</body>
</html>
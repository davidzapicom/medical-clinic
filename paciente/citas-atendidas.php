<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style-sidebar.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <title>Paciente - Citas atendidas | Clinica ADSI</title>
</head>
<body>
<?php
session_start();









?>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../assets/img/scene.jpg" alt="">
                </span>
                <div class="text logo-text">
                    <span class="name">Clinica ADSI</span>
                    <span class="profession"><p class="ufl"><strong><?php echo $_SESSION["name"]. '</strong> | ' .$_SESSION['usutipo']; ?></p></span>
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
                            <span class="text nav-text">Citas Atendidas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="citas-pendientes.php">
                        <i class='bx bx-user-plus icon'></i>
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
    </section>
    <script src="../assets/js/bar-script.js"></script>
</body>
</html>
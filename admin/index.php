<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
    <link rel="stylesheet" href="../assets/css/buttons.css">
    <title>Página de altas | Clinica</title>
</head>

<body>
    <?php
    session_start();




    ?>
    <h1>Bienvenid@ <?php echo $_SESSION["name"];  ?></h1>
        <button data-hover="Bye 👋" onclick="window.location.href='../logout.php'">
            <a href="../logout.php">
                <div>Cerrar sesión</div>
            </a>
        </button>
    <form action="">
        <select name="" id="">
            <option value="">Asistente</option>
            <option value="">Medico</option>
            <option value="">Paciente</option>
        </select>
    </form>


</body>
</html>
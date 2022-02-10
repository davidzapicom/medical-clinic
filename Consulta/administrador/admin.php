<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Admin</title>

<meta charset='UTF-8' />

</head>

<div>

<h1>Bienvenido <?php  session_start();              echo  $_SESSION["usuario"];          ?> </h1>

<form action="" method="POST">
		<fieldset>
			<legend>Menú de opciones</legend>
			<p><button type="submit" name="paciente">Alta Paciente</button></p>
			<p><button type="submit" name="medico">Alta Medico</button></p>
            <p><button type="submit" name="asistente">Alta Asistente</button></p>
            <p><button type="submit" name="cerrar">Cerrar sesion</button></p>
		</fieldset>

</div>

<?php

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["paciente"])){ // Alta paciente

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("adminp.php")

        } 
        
    </script>
            
    <?php

}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["medico"])){ // Alta medico

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("adminm.php")

        } 
        
    </script>
            
    <?php


}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["asistente"])){ // Alta asistente

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("admina.php")

        } 
        
    </script>
            
    <?php

}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["cerrar"])){ // Cerrar sesion 

    echo "Se va ha cerrar sesion <br><br>";

    echo "Espera mientras es redirigido";

    session_destroy();

    ?>

    <script>

    setTimeout(saltar, 1000);
    
    function saltar() {

        location.replace("../login.php")

      } 

    </script>

    <?php


}

?>


</body>
</html>
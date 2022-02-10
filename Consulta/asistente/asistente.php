<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Asistente</title>

<meta charset='UTF-8' />

</head>

<div>

<h1>Bienvenido <?php  session_start();              echo  $_SESSION["usuario"];          ?> </h1>

<form action="" method="POST">
		<fieldset>
			<legend>Menú de opciones</legend>
			<p><button type="submit" name="citasatendidas">Ver citas atendidas</button></p>
			<p><button type="submit" name="nuevacita">Nueva cita</button></p>
            <p><button type="submit" name="altapacientes">Alta pacientes</button></p>
            <p><button type="submit" name="pacientes">Ver pacientes</button></p>
            <p><button type="submit" name="cerrar">Cerrar sesion</button></p>
		</fieldset>

</div>

<?php

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["citasatendidas"])){ // Ver citas atendiddas

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("asistente_citas_atendidas.php")

        } 
        
    </script>
            
    <?php

}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["nuevacita"])){ // Nueva cita

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("asistente_nuevacita.php")

        } 
        
    </script>
            
    <?php


}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["altapacientes"])){ // Alta pacientes

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("asistente_alta.php")

        } 
        
    </script>
            
    <?php


}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["pacientes"])){ // Ver pacientes

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("asistente_pacientes.php")

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
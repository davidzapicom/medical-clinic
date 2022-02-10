<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Medico</title>

<meta charset='UTF-8' />

</head>

<div>

<h1>Bienvenido <?php  session_start();              echo  $_SESSION["usuario"];          ?> </h1>

<form action="" method="POST">
		<fieldset>
			<legend>Menú de opciones</legend>
			<p><button type="submit" name="citasatendidas">Ver citas atendidas</button></p>
			<p><button type="submit" name="citaspendientes">Ver citas pendientes</button></p>
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

        location.replace("medico_citasatendidas.php")

        } 
        
    </script>
            
    <?php

}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["citaspendientes"])){ // Ver citas pendientes

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("medico_citaspendientes.php")

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

        location.replace("medico_pacientes.php")

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
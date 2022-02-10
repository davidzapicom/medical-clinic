<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Paciente</title>

<meta charset='UTF-8' />

</head>

<div>

<h1>Bienvenido <?php  session_start();              echo  $_SESSION["usuario"];          ?> </h1>

<form action="" method="POST">
		<fieldset>
			<legend>Menú de opciones</legend>
			<p><button type="submit" name="citas">Ver citas</button></p>
            <p><button type="submit" name="cerrar">Cerrar sesion</button></p>
		</fieldset>

</div>

<?php

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["citas"])){ // Ver citas

    ?>

    <script>

    setTimeout(saltar, 500);
            
    function saltar() {

        location.replace("paciente_citas.php")

        } 
        
    </script>
            
    <?php

}

// --------------------------------------------------------------------------------------------------------------

if (isset($_POST["cerrar"])){ // Cerrar sesion 
    
    session_destroy();

    ?>

    <script>

    document.write("Se va ha cerrar sesion <br><br> Espera mientras es redirigido");

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
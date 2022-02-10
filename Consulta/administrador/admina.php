<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Admin</title>

<meta charset='UTF-8' />

</head>


<?php

session_start();

if (isset($_POST["guardarm"])){

    $dni = $_POST["dni"];
    $usua = $_POST["usua"];
    $contra = $_POST["contra"];

    $contraencryp= hash_hmac('sha512', $contra, 'adminz');

    //--------------------------------------------------------------------------------------------

        $host='localhost'; $nombre_bd='consulta'; //Base de datos

        $usuario_bd = 'administra'; $password_bd = 'Admin?';
    
        $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );
    
        $enlace = $_SESSION["enlace"];
    
    //---------------------------------------------------------------------------------------------

    $sqlu = "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword, usuEstado, usutipo) VALUES ('$dni', '$usua', '$contraencryp', 'Activo', 'Asistente')";

    if (mysqli_query($enlace, $sqlu)) { //Esto para insertar en la base de datos

        echo "El asistente fue creado con exito <br><br>";

        ?>
	
        <script>

            setTimeout(saltar, 2000);
            
            function saltar() {

            location.replace("admin.php")

            } 
        
        </script>
            
    <?php

    } else {

    echo "Error: " . $sqlu . "<br>" . mysqli_error($enlace);

    }


}else{

    ?>

<div>
    
<form action="" method="post">

    <fieldset>
		<legend>Alta asistente</legend>
            
        DNI <input name="dni" type="text" required/></br></br>
        Usuario <input name="usua" type="text" required/></br></br>
        Contraseña <input name="contra" type="password" required/></br></br>
                
        <input type="submit" value="Guardar" name="guardarm"/>&nbsp
        <input type="submit" value="Cancelar" name="cancelarp" onclick="Volver()"/>

        </fieldset>
    
    </form>

    <script>

		function Volver() {

		    location.replace("admin.php")

		} 
			
		</script>
    
    </div>

<?php

}

?>


</body>
</html>
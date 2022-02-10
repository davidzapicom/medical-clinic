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
    $nom = $_POST["nom"];
    $ape = $_POST["ape"];
    $espe = $_POST["espe"];
    $movil = $_POST["movil"];
    $email = $_POST["email"];
    $usua = $_POST["usua"];
    $contra = $_POST["contra"];

    $contraencryp= hash_hmac('sha512', $contra, 'adminz');

    //--------------------------------------------------------------------------------------------

        $host='localhost'; $nombre_bd='consulta'; //Base de datos

        $usuario_bd = 'administra'; $password_bd = 'Admin?';
    
        $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );
    
        $enlace = $_SESSION["enlace"];
    
    //---------------------------------------------------------------------------------------------

    $sqlc = "INSERT INTO medicos (dniMed, medNombres, medApellidos, medEspecialidad, medTelefono, medCorreo) VALUES ('$dni', '$nom', '$ape', '$espe', '$movil', '$email')";

    $sqlu = "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword, usuEstado, usutipo) VALUES ('$dni', '$usua', '$contraencryp', 'Activo', 'Medico')";

    if (mysqli_query($enlace, $sqlc)) { //Esto para insertar en la base de datos

        echo "El medico fue creado con exito <br><br>";

    } else {

    echo "Error: " . $sqlc . "<br>" . mysqli_error($enlace);

    }

    if (mysqli_query($enlace, $sqlu)) { //Esto para insertar en la base de datos

        echo "El usuario fue creado con exito";

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
    
<form action="adminm.php" method="post">

    <fieldset>
		<legend>Alta medico</legend>
            
        DNI <input name="dni" type="text" required/></br></br>
        Nombre <input name="nom" type="text" required/></br></br>
        Apellidos <input name="ape" type="text" required/></br></br>
        Especialidad <input name="espe" type="text" required/></br></br>
        Telefono <input type="tel" id="movil" name="movil" pattern="[0-9]{9}"></br></br>
        Correo <input type="email" name="email" required/></br></br>
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
<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Admin</title>

<meta charset='UTF-8' />

</head>

<?php

session_start();

if (isset($_POST["guardarp"])){

    $dni = $_POST["dni"];
    $nom = $_POST["nom"];
    $ape = $_POST["ape"];
    $nac = $_POST["nac"];
    $sexo = $_POST["sexo"];
    $usua = $_POST["usua"];
    $contra = $_POST["contra"];

    if ($sexo == 'mascu'){

        $sexof = "masculino";

    }else{

        $sexof = "femenino";

    }

    $contraencryp= hash_hmac('sha512', $contra, 'adminz');

    //--------------------------------------------------------------------------------------------

    $host='localhost'; $nombre_bd='consulta'; //Base de datos

    $usuario_bd = 'administra'; $password_bd = 'Admin?';

    $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

    $enlace = $_SESSION["enlace"];

    //---------------------------------------------------------------------------------------------

    $sqlc = "INSERT INTO pacientes (dniPac, pacNombres, pacApellidos, pacFechaNacimiento, pacSexo) VALUES ('$dni', '$nom', '$ape', '$nac', '$sexof')";

    $sqlu = "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword, usuEstado, usutipo) VALUES ('$dni', '$usua', '$contraencryp', 'Activo', 'Paciente')";

    if (mysqli_query($enlace, $sqlc)) { //Esto para insertar en la base de datos

        echo "El paciente fue creado con exito <br><br>";

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
    
    <form action="adminp.php" method="post">

    <fieldset>
		<legend>Alta paciente</legend>
            
        DNI <input name="dni" type="text" required/></br></br>
        Nombre <input name="nom" type="text" required/></br></br>
        Apellidos <input name="ape" type="text" required/></br></br>
        Fecha Nacimiento <input name="nac" type="date" required/></br></br>
    
        <label>Sexo:</label>
            <select id="sexo" name="sexo">
                <option value="mascu">Masculino</option>
                <option value="feme">Femenino</option>
        </select>       </br></br>
    
        Usuario <input name="usua" type="text" required/></br></br>
        Contraseña <input name="contra" type="password" required/></br></br>
                
        <input type="submit" value="Guardar" name="guardarp"/>&nbsp
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
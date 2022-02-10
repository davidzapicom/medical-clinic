<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Medico</title>

<meta charset='UTF-8' />

<style>

table, th, td {

    border: 1px solid black;
    text-align: center;

}

</style>

</head>

<fieldset>

    <legend>Lista de pacientes</legend>

    <?php

    //--------------------------------------------------------------------------------------------

    $host='localhost'; $nombre_bd='consulta'; //Base de datos

    $usuario_bd = 'medicos'; $password_bd = 'medicos';

    $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

    $enlace = $_SESSION["enlace"];

    //---------------------------------------------------------------------------------------------

    $select = "SELECT * FROM pacientes";

    $resultado = mysqli_query($enlace, $select);

    if (mysqli_num_rows($resultado) > 0) { //Esto un select

        ?>

    <table>
        <tr>
            <th>DNI</th>
            <th>Nombre</th> 
            <th>Apellidos</th>
            <th>Fecha Nacimiento</th>
            <th>Sexo</th>
        </tr>
 
    <?php
    
        while($fila = mysqli_fetch_assoc($resultado)) {

            echo "<tr><td>" . $fila["dniPac"] . "</td><td>" . $fila["pacNombres"] . "</td><td>" . $fila["pacApellidos"] 
            . "</td><td>" . $fila["pacFechaNacimiento"] . "</td><td>" . $fila["pacSexo"] . "</td></tr>";

        }

    } else {

        echo "No hay pacientes";

    }

    ?>

    </table>

        <br><br>
        
        <input type="submit" value="Volver" name="volver" onclick="Volver()"/>

        <script>

		function Volver() {

		    location.replace("medico.php")

		} 
			
		</script>

    <?php

    ?>

    
			
</fieldset>


</body>
</html>
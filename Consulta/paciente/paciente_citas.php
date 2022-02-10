<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Paciente</title>

<meta charset='UTF-8' />

<style>

table, th, td {

    border: 1px solid black;
    text-align: center;

}

</style>

</head>

<fieldset>

    <legend>Lista de citas de <?php  session_start();              echo  $_SESSION["usuario"];          ?></legend>

<?php

 //--------------------------------------------------------------------------------------------

 $host='localhost'; $nombre_bd='consulta'; //Base de datos

 $usuario_bd = 'pacientes'; $password_bd = 'pacientes';

 $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

 $enlace = $_SESSION["enlace"];

 //---------------------------------------------------------------------------------------------

//------------------------------ Select para el nombre del paciente ---------------------------------------------

    $usua = $_SESSION["usuario"];
         
    $select_id = "SELECT dniUsu FROM usuarios WHERE usuLogin = '$usua'";

    $resultado = mysqli_query($enlace, $select_id);

    if (mysqli_num_rows($resultado) > 0) { //Esto un select

        ?>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Hora</th> 
            <th>Paciente</th>
            <th>Medico</th>
            <th>Consultorio</th>
            <th>Estado</th>
        </tr>
 
    <?php

        while($fila = mysqli_fetch_assoc($resultado)) {

            $nombret = $fila["dniUsu"];
             
        }

    }else{

        echo 'na siquiera';

    }

    //echo $nombret;

//-------------------------------------------------------------------------------------------------------------

 $selectp = "SELECT * FROM citas WHERE citPaciente = '$nombret' AND citEstado = 'Asignado'";
 $select = "SELECT * FROM citas INNER JOIN pacientes,medicos,consultorios WHERE citas.citPaciente = '$nombret' AND citas.citEstado = 'Asignado' AND consultorios.idConsultorio = citConsultorio AND medicos.dniMed = citMedico AND pacientes.dniPac = citPaciente";

 $resultado = mysqli_query($enlace, $select);

 if (mysqli_num_rows($resultado) > 0) { //Esto un select
 
     while($fila = mysqli_fetch_assoc($resultado)) { // Select para mostrar las citas atendidas

        echo "<tr><td>" . $fila["citFecha"] . "</td><td>" . $fila["citHora"] . "</td><td>" . $fila["pacNombres"] . " " . $fila["pacApellidos"] 
        . "</td><td>" . $fila["medNombres"] . " " . $fila["medApellidos"] . "</td><td>" . $fila["conNombre"] . "</td><td>" . $fila["citEstado"] . "</td></tr>";

     }

 } else {

     echo "No hay pacientes";

 }

?>

</table>

<br><input type="submit" value="Volver" name="volver" onclick="Volver()"/>

</fieldset>

<script>

	function Volver() {

		location.replace("paciente.php")

	} 
			
</script>


</body>
</html>
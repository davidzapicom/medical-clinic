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

    <legend>Lista de citas atendidas</legend>

<?php

 //--------------------------------------------------------------------------------------------

 session_start();

 $host='localhost'; $nombre_bd='consulta'; //Base de datos

 $usuario_bd = 'medicos'; $password_bd = 'medicos';

 $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

 $enlace = $_SESSION["enlace"];

 //---------------------------------------------------------------------------------------------

//------------------------------ Select para el nombre del paciente ---------------------------------------------

    $usua = $_SESSION["usuario"];
         
    $select_id = "SELECT dniUsu FROM usuarios WHERE usuLogin = '$usua'";

    $resultado = mysqli_query($enlace, $select_id);

    if (mysqli_num_rows($resultado) > 0) { //Esto un select

        while($fila = mysqli_fetch_assoc($resultado)) {

            $nombret = $fila["dniUsu"];
             
        }

    }else{

        echo 'na siquiera';

    }

    //echo $nombret;

//-------------------------------------------------------------------------------------------------------------

 $select = "SELECT * FROM citas WHERE citMedico = '$nombret' AND citEstado = 'Atendido'";
 $selectp = "SELECT *FROM citas INNER JOIN pacientes,medicos,consultorios WHERE citas.citMedico = '$nombret' AND citas.citEstado = 'Atendido' AND consultorios.idConsultorio = citConsultorio AND medicos.dniMed = citMedico AND pacientes.dniPac = citPaciente";
 
 $resultado = mysqli_query($enlace, $selectp);

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

     while($fila = mysqli_fetch_assoc($resultado)) { // Select para mostrar las citas atendidas

        echo "<tr><td>" . $fila["citFecha"] . "</td><td>" . $fila["citHora"] . "</td><td>" . $fila["pacNombres"] . " " . $fila["pacApellidos"] . "</td><td>" 
        . $fila["medNombres"] . " " . $fila["medApellidos"] . "</td><td>" . $fila["conNombre"] . "</td><td>" . $fila["citEstado"] . "</td></tr>";

     }

 } else {

     echo "No hay citas para este medico";

 }

?>

</table>

<br><input type="submit" value="Volver" name="volver" onclick="Volver()"/>

</fieldset>



<script>

	function Volver() {

		location.replace("medico.php")

	} 
			
</script>


</body>
</html>
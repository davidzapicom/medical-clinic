<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Asistente</title>

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

 $host='localhost'; $nombre_bd='consulta'; //Base de datos

 $usuario_bd = 'asistentes'; $password_bd = 'asistentes';

 $_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

 $enlace = $_SESSION["enlace"];

 //---------------------------------------------------------------------------------------------

 $selectp = "SELECT * FROM citas WHERE citEstado = 'Atendido'";
 $select = "SELECT * FROM citas INNER JOIN pacientes,medicos,consultorios WHERE citas.citEstado = 'Atendido' AND consultorios.idConsultorio = citConsultorio AND medicos.dniMed = citMedico AND pacientes.dniPac = citPaciente";

 $resultado = mysqli_query($enlace, $select);

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

        echo "<tr><td>" . $fila["citFecha"] . "</td><td>" . $fila["citHora"] . "</td><td>" . $fila["pacNombres"] . " " . $fila["pacApellidos"] 
        . "</td><td>" . $fila["medNombres"] . " " . $fila["medApellidos"] . "</td><td>" . $fila["conNombre"] . "</td><td>" . $fila["citEstado"] . "</td></tr>";

    //------------------------------ Select para el nombre del paciente ---------------------------------------------

     /*$id_paciente = $fila["citPaciente"];
         
     $select_id_1 = "SELECT * FROM pacientes WHERE dniPac = '$id_paciente'";

     $resultado = mysqli_query($enlace, $select_id_1);

     if (mysqli_num_rows($resultado) > 0) { //Esto un select

         while($fila = mysqli_fetch_assoc($resultado)) {

             $nombre_paciente = $fila["pacNombres"] . " " . $fila["pacApellidos"];
             
         }

     }

     echo $nombre_paciente;*/

    //-------------------------------------------------------------------------------------------------------------

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

		location.replace("asistente.php")

	} 
			
</script>


</body>
</html>
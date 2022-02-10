<?php
session_start();
if (isset($_POST["listadocitas"])){
$servername = "localhost";
$username = "paciente";
$password = "paciente";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
} 

$sqlcitas = "SELECT * FROM citas";

$citas = mysqli_query($conn, $sqlcitas);
 
	if (!empty($citas) AND mysqli_num_rows($citas) > 0) {
 	 echo "<h1>LISTADO DE CITAS</h1><br>";
 	 echo "<table border='1'>";
 	 echo "<tr style='background-color: red; color: white;'>";
 	 echo "<th>Fecha</th>";
 	 echo "<th>Hora</th>";
 	 echo "<th>Paciente</th>";
 	 echo "<th>Medico</th>";
 	 echo "<th>Consultorio</th>";
 	 echo "<th>Estado</th>";
 	 echo "<th>Observaciones</th>";
 	 echo "</tr>";
 	while($row = mysqli_fetch_assoc($citas)) {
 	echo "<tr>";
	echo "<td> " . $row['citFecha'] . " </td>";
	echo "<td> " .$row['citHora'] . "</td>";
	echo "<td> ".$row['citPaciente']." </td>";
	echo "<td> ".$row['citMedico']." </td>";
	echo "<td> ".$row['citConsultorio']." </td>";
	echo "<td> ".$row['citEstado']." </td>";
	echo "<td>  </td>";
	echo "</tr>";
	}
    echo "</table>";
	}

}
?>
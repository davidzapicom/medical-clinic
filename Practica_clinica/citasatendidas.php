<?php
session_start();

if (isset($_POST["citaatendida"])){

   $servername = "localhost";
$username = "asistente";
$password = "asistente";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
}


$sqlcitasatendidas = "SELECT * FROM citas";

$result = mysqli_query($conn, $sqlcitasatendidas);



	if (!empty($result) AND mysqli_num_rows($result) > 0) {
 	 echo "<h1>LISTADO DE CITAS ATENDIDAS</h1><br>";
 	 echo "<table border='1' >";
 	 echo "<tr style='background-color: red; color: white;'>";
 	 echo "<th>Fecha</th>";
 	 echo "<th>Hora</th>";
 	 echo "<th>ID paciente</th>";
 	 echo "<th>ID medico</th>";
 	 echo "<th>Consultorio</th>";
 	 echo "<th>Estado</th>";
 	 echo "<th>Observaciones</th>";
 	 echo "</tr>";
 	while($row = mysqli_fetch_assoc($result)) {
 		if ($row['citEstado'] == 'Atendido'){
 	echo "<tr>";
	echo "<td> " . $row['citFecha'] . " </td>";
	echo "<td> " .$row['citHora'] . "</td>";
	echo "<td> ".$row['citPaciente']." </td>";
	echo "<td> ".$row['citMedico']." </td>";
	echo "<td> ".$row['citConsultorio']." </td>";
	echo "<td> ".$row['citEstado']." </td>";
	echo "<td> "  ?> <img style="height: 30px; width: 30px; text-align: center;" src="https://image.flaticon.com/icons/png/512/68/68103.png" alt="libretaylapiz">  <?php "  </td>";
	echo "</tr>";
	}
	}
    echo "</table>";
    }
	
} 




?>
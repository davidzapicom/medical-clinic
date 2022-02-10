<?php
session_start();
if (isset($_POST["citapendiente"])){
$servername = "localhost";
$username = "medico";
$password = "medico";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
}

$sqlcitaspendientes = "SELECT * FROM citas";

$result = mysqli_query($conn, $sqlcitaspendientes);
 
	if (!empty($result) AND mysqli_num_rows($result) > 0) {
 	 echo "<h1>LISTADO DE CITAS POR ATENDER</h1><br>";
 	 echo "<table border='1' >";
 	 echo "<tr style='background-color: red; color: white;'>";
 	 echo "<th>Fecha</th>";
 	 echo "<th>Hora</th>";
 	 echo "<th>ID paciente</th>";
 	 echo "<th>ID medico</th>";
 	 echo "<th>Consultorio</th>";
 	 echo "<th>Estado</th>";
 	 echo "<th>Atender</th>";
 	 echo "</tr>";
 	while($row = mysqli_fetch_assoc($result)) {
 		if ($row['citEstado'] == 'Asignado'){
 	echo "<tr>";
	echo "<td> " . $row['citFecha'] . " </td>";
	echo "<td> " .$row['citHora'] . "</td>";
	echo "<td> ".$row['citPaciente']." </td>";
	echo "<td> ".$row['citMedico']." </td>";
	echo "<td> ".$row['citConsultorio']." </td>";
	echo "<td> ".$row['citEstado']." </td>";
	echo "<td> "  ?> <a href="atendercita.php"> <img style="height: 30px; width: 30px;" src="https://image.flaticon.com/icons/png/512/68/68103.png" alt="libretaylapiz"> </a> <?php "  </td>";
	echo "</tr>";
	 }
    ?>
    <?php
	}
    echo "</table>";
	} 
  
}
?>
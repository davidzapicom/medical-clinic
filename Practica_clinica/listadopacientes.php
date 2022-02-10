<?php
session_start();

if (isset($_POST["bt3"])|| isset($_POST["listado"])){
	$servername = "localhost";
	$username = "medico";
	$password = "medico";
	$dbname = "consultas";

	$conn = mysqli_connect($servername, $username, $password,$dbname);

	if (!$conn){
 	die("Connection failed: " . mysqli_connect_error());
} 

    
    $sql = "SELECT * FROM pacientes";
    $result = mysqli_query($conn, $sql);
 
	if (!empty($result) AND mysqli_num_rows($result) > 0) {
 	 echo "<h1>LISTADO DE PACIENTES</h1><br>";
 	 echo "<table border='1'>";
 	 echo "<tr style='background-color: red; color: white;'>";
 	 echo "<th>Identificación</th>";
 	 echo "<th>Nombre</th>";
 	 echo "<th>Apellidos</th>";
 	 echo "<th>Fecha Nacimiento</th>";
 	 echo "<th>Sexo</th>";
 	 echo "</tr>";
 	while($row = mysqli_fetch_assoc($result)) {
 	echo "<tr>";
	echo "<td> " . $row['dniPac'] . " </td>";
	echo "<td> " .$row['pacNombres'] . "</td>";
	echo "<td> ".$row['pacApellidos']." </td>";
	echo "<td> ".$row['pacFechaNacimiento']." </td>";
	echo "<td> ".$row['pacSexo']." </td>";
	echo "</tr>";
	}
    echo "</table>";
	}
}


?>
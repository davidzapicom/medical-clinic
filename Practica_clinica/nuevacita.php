<?php
session_start();

if (isset($_POST["nuevacita"])){
	$servername = "localhost";
	$username = "asistente";
	$password = "asistente";
	$dbname = "consultas";

	$conn = mysqli_connect($servername, $username, $password,$dbname);

	if (!$conn){
	 die("Connection failed: " . mysqli_connect_error());
	} 

	$sqlpaciente = "SELECT dniPac FROM pacientes";
	$sqlmedico = "SELECT dniMed FROM medicos";
	$sqlconsultorio = "SELECT idConsultorio FROM consultorios";

	$result = mysqli_query($conn, $sqlpaciente);
	$doctors = mysqli_query($conn, $sqlmedico);
    $consul = mysqli_query($conn, $sqlconsultorio);

?>
<form method="post" style="background-color: silver; width: 408px;">
	<p style="width: 400px; background-color: red; padding: 1%; color: white; text-align: center;">ASIGNAR CITA</p>
	<table style="margin-left: 5px;">
		<tr>
			<td>Paciente: </td>
			<td>
	 <?php 	
	 if (mysqli_num_rows($result) > 0) {
		echo "<select name='pacs'>";
 			while($row = mysqli_fetch_assoc($result)) {
      		$namePac = $row["dniPac"];
      		echo "<option selected hidden>Seleccionar</option>";
       		echo "<option value= '".$namePac. " '>" . $namePac."</option>";
			} 
			echo "</select>";
			} ?>
		</td>
		</tr>
		<tr>
			<td>Fecha:</td>
			<td><input type="date" name="fechacita" required="required"></td>
		</tr>
		<tr>
			<td>Hora:</td>
			<td><input type="time" name="hora" required="required"></td>
		</tr>
		<tr>
			<td>Medico:</td>
			<td><?php if (mysqli_num_rows($doctors) > 0) {
		    echo "<select name='meds'>";
 			while($med = mysqli_fetch_assoc($doctors)) {
      		$nameMed = $med["dniMed"];
      		echo "<option selected hidden>Seleccionar</option>";
       		echo "<option value= '".$nameMed."'>" . $nameMed ."</option>";
			} 
			echo "</select>";
			} ?></td>
		</tr>
		<tr>
			<td>Consultorio:</td>
			<td><?php if (mysqli_num_rows($consul) > 0) {
		    echo "<select name='consuls'>";
 			while($med = mysqli_fetch_assoc($consul)) {
      		$idConsul = $med["idConsultorio"];
      		echo "<option selected hidden>Seleccionar</option>";
       		echo "<option value= '".$idConsul."'>" . $idConsul ."</option>";
			} 
			echo "</select>";
			} ?></td>
		</tr>
	</table>
	<p style="width: 400px; text-align: center; padding: 1%; background-color: red;"><input type="submit" name="enviarcita" value="Enviar"></p>
</form>
<?php
 }
 if (isset($_POST["enviarcita"])){
 	$servername = "localhost";
	$username = "asistente";
	$password = "asistente";
	$dbname = "consultas";

	$conn = mysqli_connect($servername, $username, $password,$dbname);

	if (!$conn){
	 die("Connection failed: " . mysqli_connect_error());
	} 
 	    $paci = $_POST["pacs"];
 	    $fechacita = $_POST["fechacita"];
 	    $horacita = $_POST["hora"];
		$medico = $_POST["meds"];
		$consul = $_POST["consuls"];

		$sqlCitas = "INSERT INTO citas (idCita, citFecha,citHora,citPaciente,citMedico,citConsultorio,citEstado,CitObservaciones) VALUES ('','".$fechacita."','".$horacita."','".$paci."','".$medico."',".$consul.",'Asignado', '')";

		if (mysqli_query($conn, $sqlCitas)) {
 		 header ("Location: asistente.php");
 		 exit();
		} else {
  		echo "Error al insertar los datos: " . mysqli_error($conn);
		}
	}
?>
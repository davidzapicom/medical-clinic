<?php
session_start();
if (isset($_SESSION["tipo"])=="asistente"){
$servername = "localhost";
$username = "asistente";
$password = "asistente";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
} 
?>

<form method="post" style="background-image: url('https://image.freepik.com/vector-gratis/mano-dibujada-medicina-patrones-fisuras-doddle-bosquejo-salud-antecedentes-medicos_7586-1191.jpg'); height: 600px; text-align: center; width: 600px;">
	<button style= "background-color: silver; width: 200px; padding: 1%; height: 70px; margin-bottom: 8px; margin-top: 17%;" type="submit" name="citaatendida" formaction="citasatendidas.php"> Ver Citas Atendidas </button> <br>
	<button style= "background-color: silver; width: 200px; padding: 1%; height: 70px; margin-bottom: 8px;" type="submit" name="nuevacita" formaction="nuevacita.php"> Nueva Cita </button> <br>
	<button style= "background-color: silver; width: 200px; padding: 1%; height: 70px; margin-bottom: 8px;" type="submit" name="alta" formaction="altapaciente.php"> Alta Paciente </button> <br>
	<button style= "background-color: silver; width: 200px; padding: 1%; height: 70px; margin-bottom: 8px;" type="submit" name="listado" formaction="listadopacientes.php">Ver Pacientes </button><br>
	<button style= "background-color: silver; width: 200px; padding: 1%; height: 70px; margin-bottom: 8px;" type="submit" name="cierre" formaction="cierresesion.php"> Cerrar Sesión </button>
</form>
<?php
}
?>
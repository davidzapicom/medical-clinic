<?php
session_start();
if (isset($_SESSION["tipo"])=="medico"){
$servername = "localhost";
$username = "medico";
$password = "medico";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
} 
?>

<form method="post" style="background-image: url('https://image.freepik.com/vector-gratis/mano-dibujada-medicina-patrones-fisuras-doddle-bosquejo-salud-antecedentes-medicos_7586-1191.jpg'); height: 600px; text-align: center; width: 600px;">
	<button style= "background-color: silver; width: 200px; height: 70px; padding: 1%; margin-bottom: 8px; margin-top: 20%;" type="submit" name="citaatendida" formaction="citasatendidas.php"> Ver Citas Atendidas </button> <br>
	<button style= "background-color: silver; width: 200px; height: 70px;padding: 1%; margin-bottom: 8px;" type="submit" name="citapendiente" formaction="citaspendientes.php">Ver Citas Pendientes </button><br>
	<button style= "background-color: silver; width: 200px; height: 70px;padding: 1%; margin-bottom: 8px;" type="submit" name="bt3" formaction="listadopacientes.php">Ver Pacientes </button><br>
	<button style= "background-color: silver; width: 200px; height: 70px; padding: 1%;" type="submit" name="bt4" formaction="cierresesion.php"> Cerrar Sesión </button>
</form>

<?php
}
?>

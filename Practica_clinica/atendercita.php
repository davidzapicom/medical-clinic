<?php
session_start();
?>

<form method="post" action="#" onsubmit="return validacion()" style="width: 408px; background-color: silver;">
	<p style="background-color: red; color: white; width: 400px; padding: 1%; text-align: center;">ATENDER CITA</p>
	<table style="margin-left: 5px;">
		<tr>
			<td>Paciente ID</td>
			<td><input type="text" name="pacid" required="required" id="idpaciente"></td>
		</tr>
		<tr>
			<td>Observaciones</td>
			<td><textarea name="observaciones" required="required" cols="29" rows="8" maxlength="200"></textarea></td>
		</tr>
	</table>
	<p style="background-color: red; padding: 1%; width: 400px; text-align: center;"><input type="submit" name="enviarcitaatendida" value="Enviar"></p>
</form>
<script type="text/javascript">
	function validacion(){
        var dniPac = document.getElementById("idpaciente").value;
		
 		if(/^\d{8}[A-Z]$/.test(dniPac)){
  	    var numero = dniPac.substr(0,8);
   	    var letra = dniPac.substr(8,1);
  
    	if (letra != 'TRWAGMYFPDXBNJZSQVHLCKET'.charAt(numero%23)) {
        alert('DNI erroneo, la letra del NIF no se corresponde');
        return false;
        }
        } else{
        alert('DNI erroneo, formato no válido');
        return false;
        }
	}
</script>
<?php
if (isset($_POST["enviarcitaatendida"])){
$servername = "localhost";
$username = "medico";
$password = "medico";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
} 

$idpaciente = $_POST["pacid"];

$sqlactualizar = "UPDATE citas SET citEstado = 'Atendido' WHERE citEstado = 'Asignado' AND citPaciente = '".$idpaciente."' ";

if (mysqli_query($conn, $sqlactualizar)) {
 		 header("Location: medico.php");
 		 exit();
		} else {
  		echo "Error al actualizar los datos: " . mysqli_error($conn);
		}
}
?>
<?php

session_start();

if (isset($_POST["bt2"])){
?>

<h1>ADSI VIRTUAL</h1>
<form method="post" action="#" onsubmit="return validacion()" style="width: 408px; background-color: silver;">
    <p style="background-color: red; color: white; width: 400px; padding: 1%; text-align: center;">REGISTRAR MÉDICO</p>
    <table style="margin-left: 5px;">
    	<tr>
		<td>Nombre:</td> <td><input type='text' name= 'nombreMed' id="nombreMed" required="required"> </td>
		</tr>
		<tr>
		<td>Apellidos: </td> <td><input type='text' name= 'apellMed' id="apellMed" required="required"> </td>
		</tr>
		<tr>
		<td>Especialidad: </td> <td><input type='text' name= 'especialidad' id="especialidad" required="required"></td>
		</tr> 
		<tr>
		<td>Teléfono: </td> <td><input type="text" name="telf" id="telf" required="required"></td>
		</tr>
		<tr>
		<td>Email: </td> <td><input type="email" name="mail" placeholder="email@gmail.com" required="required"></td>
		</tr>
		<tr>
		<td>DNI: </td> <td><input type="text" name="dniMed" id="dniMed" required="required"></td>
		</tr>
        <tr>
		<td>Usuario: </td> <td><input type="text" name="usuMed" required="required"></td> 
		</tr>
		<tr>
		<td>Contraseña: </td> <td><input type="password"  pattern=".{6,}" name="passMed" required="required" title="Mínimo 6 caracteres"></td>
		</tr> 
		<tr>
		<td>Repite contraseña: </td> <td><input type="password" pattern=".{6,}" name="passMedrep" required="required" title="Mínimo 6 caracteres"></td>
		</tr> 
		<tr>
		<td>Estado: </td> <td><select name="estado">
		<option value="Activo">Activo</option>
		<option value="Inactivo">Inactivo</option>
		</select> </td>
        </tr>
	</table>
	<br>
    <p style="background-color: red; padding: 1%; width: 400px; text-align: center;"><input type="submit" name="enviarAltaMed" value="Dar de alta"></p>
</form>

<script type="text/javascript">
	function validacion(){

		var nombreMed = document.getElementById("nombreMed").value;

		if (!(/^[a-zA-ZñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ ]+$/.test(nombreMed))){
			alert("Nombre incorrecto. Introduzca solo caracteres alfabéticos.");
			return false;
		}

		var apellMed = document.getElementById("apellMed").value;

		if (!(/^[a-zA-ZñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ ]+$/.test(apellMed))){
			alert("Apellidos incorrectos. Introduzca solo caracteres alfabéticos.");
			return false;
		}

		var espe = document.getElementById("especialidad").value;

		    if (!(/^[a-zA-ZñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ ]+$/.test(espe))){
			alert("Especialidad incorrecta. Introduzca solo caracteres alfabéticos.");
			return false;
		}

        var telfMed = document.getElementById("telf").value;

		if (!(/^\d{9}$/.test(telfMed))){
			alert("Número incorrecto. Introduzca solo números y 9 dígitos.");
			return false;
		}

		var dniMed = document.getElementById("dniMed").value;
		
 		if(/^\d{8}[A-Z]$/.test(dniMed)){
  	    var numero = dniMed.substr(0,8);
   	    var letra = dniMed.substr(8,1);
  
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
 }
 if (isset($_POST["enviarAltaMed"])){
 	if (!empty($_POST["enviarAltaMed"])){
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
}

		if ($_POST["passMed"] == $_POST["passMedrep"]){
		$nombreMed = $_POST["nombreMed"];
		$apellMed = $_POST["apellMed"];
	    $especialidad = $_POST["especialidad"];
		$telf = $_POST["telf"];
	    $mail = $_POST["mail"];
	    $dniMed = $_POST["dniMed"];
		$usuMed = $_POST["usuMed"];
		$passMed = $_POST["passMed"];
		$passMedencryp= hash_hmac('sha512', $passMed, 'primeraweb');
	    $estado = $_POST["estado"];


		$sqlmedicos = "INSERT INTO medicos (dniMed, medNombres, medApellidos,medEspecialidad,medTelefono,medCorreo) VALUES ('".$dniMed."',
  		 '".$nombreMed."', '".$apellMed."', '".$especialidad ."', '".$telf."', '".$mail."')";
         
        $sqlusuarios = "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword,usuEstado,usutipo) VALUES (
  		 '".$dniMed."', '".$usuMed."', ' ".$passMedencryp."', '".$estado."', 'medico')";


    	if (mysqli_query($conn, $sqlmedicos) && mysqli_query($conn, $sqlusuarios)) {
 		 header("Location: admin.php");
 		 exit();
		} else {
  		echo "Error al insertar los datos: " . mysqli_error($conn);
		} 
         }
         else{
			echo "Las contraseñas no coinciden.";
		}
   }
 }
 ?>

<?php

session_start();

if (isset($_POST["bt1"])|| isset($_POST["alta"])){
?>

<h1>ADSI VIRTUAL</h1> 
<form method="post" action="#" onsubmit="return validacion()" style="width: 408px; background-color: silver;">
    <p style="width: 400px; background-color: red; padding: 1%; color: white; text-align: center;">INSERTAR PACIENTE</p>
    <table style="margin-left: 5px;">
    	<tr>
		<td>Identificación:</td> <td><input type='text' name= 'id' id="pacID" required="required"> </td>
		</tr>
		<tr>
		<td>Nombre: </td> <td><input type='text' name= 'nombre' id="nombrePac" required="required"> </td>
		</tr>
		<tr>
		<td>Apellidos: </td> <td><input type='text' name= 'apell' id="apellPac" required="required"></td>
		</tr> 
		<tr>
		<td>Fecha de nacimiento: </td> <td><input type="date" name="fechanac" id="fecha" required="required"></td>
		</tr>
		<tr>
		<td>Sexo: </td> <td><select name="sexos">
		<option selected hidden>Seleccionar</option>
		<option value="Femenino">Femenino</option>
		<option value="Masculino">Masculino</option>
		</select> </td>
        </tr>
        <tr>
		<td>Usuario: </td> <td><input type="text" name="usu" required="required"></td> 
		</tr>
		<tr>
		<td>Contraseña: </td> <td><input type="password" pattern=".{6,}" name="pass" required="required"></td>
		</tr> 
	</table>
    <p style="width: 400px; text-align: center; padding: 1%; background-color: red;"><input type="submit" name="alta" value="Dar de alta">	</p>
</form>
<script type="text/javascript">
	function validacion(){
		var dniPac = document.getElementById("pacID").value;
		
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

		var nombrePac = document.getElementById("nombrePac").value;

		if (!(/^[a-zA-ZñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ ]+$/.test(nombrePac))){
			alert("Nombre incorrecto. Introduzca solo caracteres alfabéticos.");
			return false;
		}

		var apellPac = document.getElementById("apellPac").value;

		if (!(/^[a-zA-ZñÑäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ ]+$/.test(apellPac))){
			alert("Apellido incorrecto. Introduzca solo caracteres alfabéticos.");
			return false;
		}
             

	}
</script>

<?php
 }

 if (isset($_POST["alta"])){
 	if (!empty($_POST["alta"])){
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
} 
	    $id = $_POST["id"];
		$nombre = $_POST["nombre"];
		$apell = $_POST["apell"];
		$fechanac = $_POST["fechanac"];
	    $sexo = $_POST["sexos"];
		$usu = $_POST["usu"];
		$pass = $_POST["pass"];
		$passPacencryp= hash_hmac('sha512', $pass, 'primeraweb');


		$sqlpacientes = "INSERT INTO pacientes (dniPac, pacNombres, pacApellidos,pacFechaNacimiento,pacSexo) VALUES (
  		 '" .$id ."', '".$nombre."', '".$apell ."', '".$fechanac."', '".$sexo."')";
         
        $sqlusuarios = "INSERT INTO usuarios (dniUsu, usuLogin, usuPassword,usuEstado,usutipo) VALUES (
  		 '".$id."', '".$usu."', '". $passPacencryp."', 'Activo', 'paciente')";


    	if (mysqli_query($conn, $sqlpacientes) && mysqli_query($conn, $sqlusuarios)) {
 		 if ($_SESSION["tipo"]== "admin"){
 		 	header("Location: admin.php");
 		 	exit();
 		 }else{
 		 	header("Location: asistente.php");
 		 	exit();
 		 }
		} else {
  		echo "Error al insertar los datos: " . mysqli_error($conn);
		}
		
   }
 }
 ?>

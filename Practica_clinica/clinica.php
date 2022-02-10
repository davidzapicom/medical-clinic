<?php
session_start();

$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "consultas";

$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn){
 die("Connection failed: " . mysqli_connect_error());
} 

if (isset($_POST["enviar"])){
  if (empty($_POST["nombre"]) || empty($_POST["pass"])){
    echo "Debe introducir el usuario y la clave";
  } else {
  $_SESSION["nombre"] = $_POST["nombre"];
  $nombre = $_SESSION["nombre"];
  $_SESSION["pass"] = $_POST["pass"];
  $clave = $_SESSION["pass"];
  $claveencryp= hash_hmac('sha512', $clave, 'primeraweb');
    }
}


$sql = "SELECT usutipo FROM usuarios WHERE usuLogin = '" .$nombre."' AND usuPassword = '".$claveencryp."'";  


$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
 while($row = mysqli_fetch_assoc($result)) {
       $tipo = $row["usutipo"];
}
       $_SESSION["tipo"] = "$tipo";
       header ("Location: login.php");
       exit();
} else {
	echo "Se está intentando validar con el usuario con rol <br>";
  echo "El usuario introducido no existe. Valídese de nuevo. " . mysqli_error($conn);

 }
mysqli_close($conn);

?>

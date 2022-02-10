<!DOCTYPE html>
<html>
<body>

<head>

<title>Login</title>

<meta charset='UTF-8' />

</head>

<?php

session_start();

if (isset($_POST["iniciar"])){

	//echo "Hola";

	$host='localhost'; $nombre_bd='consulta'; //Base de datos


	$_SESSION["usuario"] = $_POST["usuario"];
    $_SESSION["password"] = $_POST["password"];

	if ($_SESSION["usuario"] == 'administrador'){ //Si el nombre de usuario es Admin va por aqui

		$usuario_bd = 'administrador'; $password_bd = 'Admin?';

		$_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

		if (mysqli_connect_errno()) {

			echo "Conexión fallida <br>";

			echo '<a href="login.php">Volver al login</a>';
			
			}else {
			
				echo "Bienvenido Administrador <br><br>";

				echo "Espera mientras es redirigido";

				?>
	
				<script>

				setTimeout(saltar, 2000);
				
				function saltar() {

					location.replace("administrador/admin.php")

				} 
			
				</script>
				
				<?php
			}

	}else{

		$usuario_bd = "root"; $password_bd = "";

		$_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

		$enlace = $_SESSION["enlace"]; //Conexion

		$usuario_o = $_SESSION["usuario"]; $password_o = $_SESSION["password"];

		//$password_o_encryp = hash_hmac('sha512', $password_o, 'adminz');

		$select_usuario = "SELECT * FROM usuarios WHERE usuLogin  = '$usuario_o' AND usuPassword  = '$password_o' AND usutipo";

		$resultado = mysqli_query($enlace, $select_usuario);

		if (mysqli_num_rows($resultado) > 0) { //Esto un select
    
			while($fila = mysqli_fetch_assoc($resultado)) {
		
				//---------------------------------------------------------------------------------------------------

				if ($fila["usutipo"] == 'Medico'){ // Para medico

					echo 'Bienvenido ' . $_SESSION["usuario"] . ' <br><br>';

					echo "Espera mientras es redirigido";

					?>
	
					<script>

					setTimeout(saltar, 2000);
				
					function saltar() {

						location.replace("medico/medico.php")

					} 
			
					</script>
				
					<?php

				}

				// -------------------------- Hasta aqui medico ---------------------------------------

				if ($fila["usutipo"] == 'Asistente'){ //Para asistente

					echo 'Bienvenido ' . $_SESSION["usuario"] . ' <br><br>';

					echo "Espera mientras es redirigido";

					?>
	
					<script>

					setTimeout(saltar, 2000);
				
					function saltar() {

						location.replace("asistente/asistente.php")

					} 
			
					</script>
				
					<?php

				}

				// -------------------------------- Hasta aqui asistente ----------------------------------

				if ($fila["usutipo"] == 'Paciente'){ //Para paciente

					echo 'Bienvenido ' . $_SESSION["usuario"] . ' <br><br>';

					echo "Espera mientras es redirigido";

					?>
	
					<script>

					setTimeout(saltar, 2000);
				
					function saltar() {

						location.replace("paciente/paciente.php")

					} 
			
					</script>
				
					<?php

				}

				// -------------------------------- Hasta aqui paciente ----------------------------------

				if ($fila["usutipo"] == 'Administrador'){ //Para administrador

					echo 'Bienvenido ' . $_SESSION["usuario"] . ' <br><br>';

					echo "Espera mientras es redirigido";

					?>
	
					<script>

					setTimeout(saltar, 2000);
				
					function saltar() {

						location.replace("administrador/admin.php")

					} 
			
					</script>
				
					<?php

				}

				// -------------------------------- Hasta aqui administrador ----------------------------------
		
			}
		
			} else {
		
				echo "Usuario no encontrado o pusiste mal la contraseña";

				?>
	
					<script>

					setTimeout(saltar, 2000);
				
					function saltar() {

						location.replace("login.php")

					} 
			
					</script>
				
					<?php
		
			}

	}

//------------------------------------------ A partir de aqui el formulario ------------------------------------------

}else{


?>

<div>

<form action="" method="post">
<fieldset>

	<legend>Login</legend>
		
	<p>Usuario: <input name="usuario" type="text" required/></p>

    <p>Constraseña: <input name="password" type="password" required/></p>
			
	<input type="submit" value="Inciar sesion" name="iniciar"/>

	</fieldset>

</form>

</div>

<?php


}


?>

</body>
</html>
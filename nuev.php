<?php

session_start();

$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['usu3'], $_SESSION['pass3'], $_SESSION['basedatos']);
	if (mysqli_connect_errno()) {
	    printf("Conexión fallida %s\n", mysqli_connect_error());
	    exit();
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Nueva cita</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Girassol|Varela+Round&display=swap');
	</style>
</head>
<body>
	<header style="background-color: #05668D;">
		<img src="Logo.png" alt="Logo MediCare">
		<h1>Tu centro médico de confianza</h1>
	</header>
	<h2>Bienvenido/a <?php echo $_SESSION['user']; ?>, se ha identificado como <?php echo $_SESSION['rol'] ?></h2>
	<div class="backClose">
		<form action="" method="POST">
			<button type="submit" name="back">Volver al menú</button>
			<button type="submit" name="logout">Cerrar Sesión</button>
		</form>
	</div>
	<form action="" method="POST" name="ncForm" onsubmit="return validar()" class="altas-citas">
		<fieldset>
			<legend>Asignar nueva cita</legend>
			<p>Paciente: <select name="pac" required="required" onblur="valselp()" id="selp">
				<option value="vacio">Seleccione</option>
				<?php

				$sql="SELECT pacNombres,pacApellidos,dniPac FROM pacientes;";
				$result = mysqli_query ($conexion, $sql);
				while ($registro = mysqli_fetch_row($result)) {

				?>

				<option value=<?php echo $registro[2] ?>><?php echo $registro[0]." ".$registro[1]; ?></option>

				<?php

				}

				?>
			</select><span id="avisoselectp"></span></p>
			<p>Fecha: <input type="date" name="fechacit" id="fc" required="required" onblur="valfc()"><span id="avisofecha"></span></p>
			<!-- Otra forma de validar la fecha sería incluir en el input de fecha el atributo min=<?php //echo date("Y-m-d"); ?>-->
			<p>Hora: <input type="time" name="horacit" id="hc" required="required" onblur="valhc()"><span id="avisohora"></span></p>
			<p>Médico: <select name="med" required="required" onblur="valselm()" id="selm">
				<option value="vacio">Seleccione</option>
				<?php

				$sql2="SELECT medNombres,medApellidos,dniMed FROM medicos;";
				$result2 = mysqli_query($conexion, $sql2);
				while ($registro = mysqli_fetch_row($result2)) {

				?>

				<option value=<?php echo $registro[2] ?>><?php echo $registro[0]." ".$registro[1]; ?></option>

				<?php

				}

				?>
			</select><span id="avisoselectm"></span></p>
			<p>Consultorio: <select name="cons" required="required" onblur="valselc()" id="selc">
				<option value="vacio">Seleccione</option>
				<?php

				$sql3="SELECT idConsultorio,conNombre FROM consultorios;";
				$result3 = mysqli_query($conexion, $sql3);
				while ($registro = mysqli_fetch_row($result3)) {

				?>

				<option value=<?php echo $registro[0]; ?>><?php echo $registro[0]." - ".$registro[1]; ?></option>

				<?php

				}

				?>
			</select><span id="avisoselectc"></span></p>
			<p><input type="submit" name="insertar" value="Asignar cita"></p>
		</fieldset>
	</form>

	<?php

	if (isset($_POST['insertar'])) {
		$pac=$_POST['pac'];
		$fc=$_POST['fechacit'];
		$hc=$_POST['horacit'];
		$med=$_POST['med'];
		$cons=$_POST['cons'];

		if ($_SESSION['rol']=='Asistente') {

			$sql="INSERT INTO citas (idCita,citFecha,citHora,citPaciente,citMedico,citConsultorio,citEstado,citObservaciones) VALUES (NULL,'$fc','$hc','$pac','$med','$cons','Asignado','');";
			if (mysqli_query($conexion, $sql)) {
			 	$mensajecita="Se ha asignado la cita con éxito";
	?>		 	

	<div id="modalB" style="display: block;" class="modal opacidad">
    	<div class="modal-cont cajaModal">
    		<span onclick="document.getElementById('modalB').style.display='none'"class="botonModal grande arribaDerecha">&times;</span>
    		<div class="contenedor">
    			<p><?php echo $mensajecita; ?></p>
    		</div>
    	</div>
    </div>

	<?php
			}
			else {
				echo " <br> Error: " . $sql . "<br>" . mysqli_error($conexion);
			}
		}
	}

	if (isset($_POST['back'])) {

		header("Location:inicio.php");

	}

	if (isset($_POST['logout'])) {

		session_destroy();
			 
		header("Location:index.php");
	}

	mysqli_close($conexion);

	?>

	<script>

		var modal = document.getElementById('modalB');

		window.onclick = function(event) {
		  if (event.target == modal) {
		    modal.style.display = "none";
		  }
		}
		
		function validar() {
			if (valselp() && valfc() && valhc() && valselm() && valselc()) {
				return true;
			}
			else {
				alert ("Datos erróneos, indtroducir de nuevo");
				return false;
			}
		}

		function valfc() {
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1;
			var yyyy = today.getFullYear();
			if (dd<10) {
				dd='0'+dd;
			}
			if (mm<10) {
				mm='0'+mm;
			}
			today = yyyy+"-"+mm+"-"+dd;

			var fecha = document.ncForm.fechacit.value;

			var cf=fecha.localeCompare(today);

			if (cf==1 || cf==0) {
				document.getElementById('fc').style.border="3px solid green";
				document.getElementById('avisofecha').innerHTML=" &check; Fecha correcta";
				return true;
			}
			else {
				document.getElementById('fc').style.border="3px solid red";
				document.getElementById('avisofecha').innerHTML=" &cross; Fecha incorrecta (No puede ser una fecha anterior a la de hoy)";
				return false;
			}
		}

		function valhc() {
			var liminf = "08:00";
			var limsup = "15:00";

			var hora = document.ncForm.horacit.value;

			var chi = hora.localeCompare(liminf);
			var chs = hora.localeCompare(limsup);

			if ( (chi==1 || chi==0) && (chs==-1 || chs==0)) {
				document.getElementById('hc').style.border="3px solid green";
				document.getElementById('avisohora').innerHTML=" &check; Hora correcta";
				return true;
			}
			else {
				document.getElementById('hc').style.border="3px solid red";
				document.getElementById('avisohora').innerHTML=" &cross; Hora incorrecta (Horario de 08:00 a 15:00)";
				return false;
			}
		}

		function valselp() {
			var sp = document.ncForm.pac.value;

			if (sp=="vacio") {
				document.getElementById('selp').style.border="3px solid red";
				document.getElementById('avisoselectp').innerHTML=" &cross; Ha de seleccionar alguna opción";
				return false;
			}
			else {
				document.getElementById('selp').style.border="3px solid green";
				document.getElementById('avisoselectp').innerHTML=" &check; Opción válida";
				return true;
			}
		}

		function valselm() {
			var sm = document.ncForm.med.value;

			if (sm=="vacio") {
				document.getElementById('selm').style.border="3px solid red";
				document.getElementById('avisoselectm').innerHTML=" &cross; Ha de seleccionar alguna opción";
				return false;
			}
			else {
				document.getElementById('selm').style.border="3px solid green";
				document.getElementById('avisoselectm').innerHTML=" &check; Opción válida";
				return true;
			}
		}

		function valselc() {
			var sc = document.ncForm.cons.value;

			if (sc=="vacio") {
				document.getElementById('selc').style.border="3px solid red";
				document.getElementById('avisoselectc').innerHTML=" &cross; Ha de seleccionar alguna opción";
				return false;
			}
			else {
				document.getElementById('selc').style.border="3px solid green";
				document.getElementById('avisoselectc').innerHTML=" &check; Opción válida";
				return true;
			}
		}

	</script>
</body>
</html>
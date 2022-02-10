<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Medico</title>

<meta charset='UTF-8' />

</head>

<?php  

session_start();              

$fecha = $_SESSION["fecha"];
$hora = $_SESSION["hora"];
$paciente = $_SESSION["paciente"];

//--------------------------------------------------------------------------------------------

$host='localhost'; $nombre_bd='consulta'; //Base de datos

$usuario_bd = 'medicos'; $password_bd = 'medicos';

$_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

$enlace = $_SESSION["enlace"];

//---------------------------------------------------------------------------------------------


$select_observaciones = "SELECT citPaciente,CitObservaciones FROM citas WHERE citFecha = '$fecha' AND citHora = '$hora' AND citPaciente = '$paciente'";

            $resultado = mysqli_query($enlace, $select_observaciones);

            if (mysqli_num_rows($resultado) > 0) { //Esto un select
    
                while($fila = mysqli_fetch_assoc($resultado)) {

                    $pacientez = $fila["citPaciente"];

                    $observaciones = $fila["CitObservaciones"];

                }

            }

?>

<form action="" method="POST">
		<fieldset>
			<legend>Atendiendo cita de <?php echo $pacientez?></legend>
			<p><textarea name="textoob" rows="8" cols="50"><?php echo $observaciones?> </textarea></p>
            <label>¿Marcar como atendida?</label>
            <select id="marcar" name="marcar">
            <option value="Si">Si</option>
            <option value="No">No</option>
            </select></br>
            <p><input type="submit" value="Guardar" name="guardar"/></p>
</form>
		    <p><button type="button" onclick="Volver()">Volver</button>
        </fieldset>

    <script>

	function Volver() {

		location.replace("medico_citaspendientes.php")

	} 
			
</script>

<?php 

if (isset($_POST["guardar"])){

    $textoob = $_POST["textoob"];
    $marcar = $_POST["marcar"];

    if ($marcar == 'Si'){

        $marcarf = 'Atendido';

    }else{

        $marcarf = 'Asignado';

    }
    

    $update = "UPDATE `citas` SET `CitObservaciones` = '$textoob', citEstado = '$marcarf' WHERE citFecha = '$fecha' AND citHora = '$hora' AND citPaciente = '$paciente'";

    if ($enlace->query($update) === TRUE) {

        echo "Observacion actualizada";

        ?>

        <script>

        setTimeout(saltar, 2000);
				
			function saltar() {

		        location.replace("medico_citaspendientes.php")

            }
			
        </script>

    <?php

      } else {

        echo "Error updating record: " . $enlace->error;

      }




}


?>

</body>
</html>
<!DOCTYPE html>
<html>
<body>

<head>

<title>Administracion - Asistente</title>

<meta charset='UTF-8' />

</head>

<?php

//--------------------------------------------------------------------------------------------

$host='localhost'; $nombre_bd='consulta'; //Base de datos

$usuario_bd = 'asistentes'; $password_bd = 'asistentes';

$_SESSION["enlace"] = mysqli_connect ( $host, $usuario_bd, $password_bd, $nombre_bd );

$enlace = $_SESSION["enlace"];

//---------------------------------------------------------------------------------------------

if (isset($_POST["guardarp"])){

    $paciente = $_POST["paciente"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $medico = $_POST["medico"];
    $consultorio = $_POST["consultorio"];

    //echo "Consultorio= " . $consultorio . "<br><br>";

    //------------------------------ Select para la ID de la cita --------------------------------------------------

    $select_id = "SELECT idCita FROM citas";

    $id_cita = 0;

            $resultado = mysqli_query($enlace, $select_id);

            if (mysqli_num_rows($resultado) > 0) { //Esto un select
    
                while($fila = mysqli_fetch_assoc($resultado)) {

                    $cita = $fila["idCita"];

                    $id_cita = $id_cita + $cita;
                    
            }

        }

    //-------------------------------------------------------------------------------------------------------------

    //------------------------------ Select para paciente --------------------------------------------------

    $select_id_paciente = "SELECT dniPac FROM pacientes WHERE pacNombres = '$paciente'";

            $resultado = mysqli_query($enlace, $select_id_paciente);

            if (mysqli_num_rows($resultado) > 0) { //Esto un select
    
                while($fila = mysqli_fetch_assoc($resultado)) {

                    $id_paciente = $fila["dniPac"];
                    
            }

        }

   //-------------------------------------------------------------------------------------------------------------

   //------------------------------ Select para medico --------------------------------------------------

   $select_id_medico = "SELECT dniMed FROM medicos WHERE medNombres = '$medico'";

   $resultado = mysqli_query($enlace, $select_id_medico);

   if (mysqli_num_rows($resultado) > 0) { //Esto un select

       while($fila = mysqli_fetch_assoc($resultado)) {

           $id_medico = $fila["dniMed"];
           
   }

}

//-------------------------------------------------------------------------------------------------------------

//------------------------------ Select para consultorio --------------------------------------------------

/*$select_id_consultorio = "SELECT * FROM consultorios WHERE conNombre = '$consultorio'";

$resultado = mysqli_query($enlace, $select_id_consultorio);

if (mysqli_num_rows($resultado) > 0) { //Esto un select

    while($fila = mysqli_fetch_assoc($resultado)) {

        $id_consultorio = $fila["idConsultorio"];
        
}

}else{

    echo "No se encontro na<br><br>";

}*/

//-------------------------------------------------------------------------------------------------------------

    $sqlm = "INSERT INTO citas (idCita , citFecha, citHora, citPaciente , citMedico, citConsultorio , citEstado) 
    VALUES ('$id_cita', '$fecha', '$hora', '$id_paciente', '$id_medico', '$consultorio', 'Asignado')";

    if (mysqli_query($enlace, $sqlm)) { //Esto para insertar en la base de datos

        echo "La cita fue creada con exito <br><br>";

        ?>
	
        <script>

            setTimeout(saltar, 2000);
            
            function saltar() {

            location.replace("asistente.php")

            } 
        
        </script>
            
    <?php

    } else {

        echo "Error: " . $sqlm . "<br>" . mysqli_error($enlace). "<br>";

    }


}else{

?>


<form action="" method="POST">
	<fieldset>
		<legend>Nueva cita</legend>

        <label>Paciente:</label> 
            <select id="paciente" name="paciente">

            <?php // Pacientes -------------------------------------------------------

            $select_pacientes = "SELECT * FROM pacientes";

            $resultado = mysqli_query($enlace, $select_pacientes);

            if (mysqli_num_rows($resultado) > 0) { //Esto un select
    
                while($fila = mysqli_fetch_assoc($resultado)) {

                    $pacientes_encontraos = $fila["pacNombres"] . " " . $fila["pacApellidos"];
                    $pacientes_encontraos_nombre = $fila["pacNombres"];

                    ?>

                    <option value="<?php echo $pacientes_encontraos_nombre ?>"> <?php echo $pacientes_encontraos ?> </option>

                    <?php

                }

            }

            ?>

        </select></br></br>

        Fecha <input name="fecha" type="date" required/></br></br>
        Hora <input type="time" name="hora"  required/></br></br>

        <!-- ------------------------------------------------------------------------------- -->

        <label>Medico:</label> 
            <select id="medico" name="medico">

        <?php // medicos -------------------------------------------------------

        $select_medicos = "SELECT * FROM medicos";

        $resultado = mysqli_query($enlace, $select_medicos);

        if (mysqli_num_rows($resultado) > 0) { //Esto un select

            while($fila = mysqli_fetch_assoc($resultado)) {

                $medicos_encontraos = $fila["medNombres"] . " " . $fila["medApellidos"];
                $medicos_encontraos_nombre = $fila["medNombres"];

                /*<?php echo $medicos_encontraos ?>*/

        ?>

        <option value="<?php echo $medicos_encontraos_nombre ?>"> <?php echo $medicos_encontraos ?> </option>

        <?php

            }

        }

        ?>

        </select></br></br>

        <!-- ------------------------------------------------------------------------------- -->

        <label>Consultorio:</label> 
            <select id="consultorio" name="consultorio">

        <?php // consultorio -------------------------------------------------------

        $select_consultorio = "SELECT * FROM consultorios";

        $resultado = mysqli_query($enlace, $select_consultorio);

        if (mysqli_num_rows($resultado) > 0) { //Esto un select

            while($fila = mysqli_fetch_assoc($resultado)) {

                $consultorios_encontraos = $fila["conNombre"];
                $consultorios_encontraos_id = $fila["idConsultorio"];

        ?>

        <option value="<?php echo $consultorios_encontraos_id ?>"> <?php echo $consultorios_encontraos ?> </option>

        <?php

            }

        }

        ?>

        </select></br></br>
                
        <input type="submit" value="Guardar" name="guardarp"/>&nbsp
        <input type="submit" value="Cancelar" name="cancelarp" onclick="Volver()"/>
		
    </fieldset>

    <script>

		function Volver() {

		    location.replace("asistente.php")

		} 
			
	</script>

</div>

<?php

}

?>

</body>
</html>
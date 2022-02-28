<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/table-style.css">
</head>

<body>
    <?php
    session_start();
    $conexion = mysqli_connect('localhost', 'administrador', '', 'Clinica');
    if (mysqli_connect_errno()) {
        printf("Conexión fallida %s\n", mysqli_connect_error());
        exit();
    }
    ?>
    <section>
        <h1>Fixed Table header</h1>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php
                    $sql = "SELECT * FROM pacientes;";
                    $result = mysqli_query($conexion, $sql);
                    $filas = mysqli_num_rows($result);
                    if ($filas > 0) {
                        while ($registro = mysqli_fetch_row($result)) {
                    ?>
                            <tr>
                                <td><?php echo $registro[0]; ?></td>
                                <td><?php echo $registro[1]; ?></td>
                                <td><?php echo $registro[2]; ?></td>
                                <td><?php echo $registro[3]; ?></td>
                                <td><?php echo $registro[4]; ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay pacientes en el registro</td></tr>";
                    }
                    mysqli_close($conexion);
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script src="assets/js/table-script.js"></script>
</body>

</html>
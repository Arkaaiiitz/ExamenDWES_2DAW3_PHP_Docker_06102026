<html>
    <head>
        <title>Examen de Desarrollo web en entorno servidor</title>
        <link rel="icon" type="image/png" sizes="32x32" href="../imagenes/favicon.jpeg">
        <link rel="stylesheet" type="text/css" href="../estilos/estilos.css">

    </head>
    <body>
        <h1>Centro de Ayuda al Empleo</h1>
        <h2>
            <?php

                //Conectamos la base de datos
                $Conexion = mysqli_connect("localhost","php","admin","cae") or die ("No se ha podido conectar a la base de datos");
                
                //comprobación de si se ha enviado el formulario
                if(isset($_POST["nombre"])){
                    //Recogemos los datos del formulario
                    $nombre = $_POST["nombre"];
                    $apellidos = $_POST["apellidos"];
                    $dni = $_POST["dni"];
                    $fechaNac = $_POST["f_nac"];
                    $telefono = $_POST["tlf"];
                    $correo = $_POST["email"];
                    $puestoEmpleado = $_POST["profesion"];
                    $opcion = $_POST["jornadaParcial"];

                    //Miramos si se ha elegido algún idioma
                    if(isset($_POST["idiomas"])){
                        $idiomas = implode(", ", $_POST["idiomas"]);
                    } else {
                        $idiomas = "Ninguno";
                    }

                    //guardamos los datos en la tabla solicitud de la base de datos
                    $datos = mysqli_query($Conexion, "INSERT INTO solicitud (nombre, apellidos, dni, f_nac, tlf, email, profesion, jornadaParcial, idiomas) VALUES ('$nombre', '$apellidos', '$dni', '$fechaNac', '$telefono', '$correo', '$puestoEmpleado', '$opcion', '$idiomas')")
                    or die ("Problemas en el select:") . mysqli_error($Conexion);
                }

                //Comprobamos si se ha elegido un botón de profesión
                $tipo = "soldadura";
                if(isset($_REQUEST['tipo'])){
                    if ($_REQUEST['tipo'] == 'informatica'){
                        $tipo = 'informatica';
                    } elseif ($_REQUEST['tipo'] == 'socio'){
                        $tipo = "socio";
                    }
                }

                //Viniendo del formulario se nos manda automáticamente la profesión elegida
                if(isset($_REQUEST['profesion'])){
                    $tipo = $_REQUEST['profesion'];
                }

                //Se muestra el tipo de solicitud
                echo "Solicitudes de $tipo";
            ?>
        </h2>

        
        <?php 
        // Aquí tenéis que crear la tabla de solicitantes de ese tipo

            //Buscamos las solicitudes según la profesión elegida
            if($tipo == 'informatica'){
                $solicitudes = mysqli_query($Conexion, "SELECT * FROM solicitud WHERE profesion = 'informatica'");
            } else if($tipo == 'socio'){
                $solicitudes = mysqli_query($Conexion, "SELECT * FROM solicitud WHERE profesion = 'socio'");
            } else {
                $solicitudes = mysqli_query($Conexion, "SELECT * FROM solicitud WHERE profesion = 'soldadura'");
            }

            //Se crea la tabla
            echo "<table>";
                echo "<tr>";
                echo "<th>Nombre</th>";
                echo "<th>Apellidos</th>";
                echo "<th>Fecha de Nacimiento</th>";
                echo "<th>Teléfono</th>";
                echo "<th>Email</th>";
                echo "<th>Profesión</th>";
                echo "<th>Jornada</th>";
                echo "<th>Idiomas</th>";
                echo "</tr>";

                //Se recorre los resultados de la consulta y se muestran en la tabla
                while($fila = mysqli_fetch_array($solicitudes)){
                    echo "<tr>";
                    echo "<td>" . $fila ['nombre'] . "</td>";
                    echo "<td>" . $fila ['apellidos'] . "</td>";
                    echo "<td>" . $fila ['f_nac'] . "</td>";
                    echo "<td>" . $fila ['tlf'] . "</td>";
                    echo "<td>" . $fila ['email'] . "</td>";
                    echo "<td>" . $fila ['profesion'] . "</td>";
                    echo "<td>" . $fila ['jornadaParcial'] . "</td>";
                    echo "<td>" . $fila ['idiomas'] . "</td>";
                    echo "</tr>";
                }
            //Se cierra la tabla
            echo "</table>";
            //Se cierra la conexión a la base de datos
            mysqli_close($Conexion);
        ?>
        <button onclick="location.href='../html/index.html'">Volver al formulario</button>
    </body>
</html>
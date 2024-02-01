<?php

// $servername = "10.3.1.110:3306";
// $username = "root";
// $password = "WNeqRzh!nHrfA9d**K!^";
// $dbname = "evaluacion_docente";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evaluacion_docente1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Falló la conexión a la base de datos: " . $conn->connect_error);
}

if (isset($_POST['documento'])) {
    $documento = $_POST['documento'];
    // Hacer algo con la variable $documento
} else {
    echo "Documento invalido";
}

$query = "SELECT * FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = $documento AND ENCUESTA LIKE '%SIN CATEDRA%' AND CARGO_DOCENTE = 'Docente Planta'";
$resultado = mysqli_query($conn, $query);
if (mysqli_num_rows($resultado) > 0) {
    // el número de documento se encontró en ae_docente_catedra para Docente Ocasional, enviar POST a archivo1.php
?>
    <form id="myForm" action="/evaluacion_docente/dashboard/generarpdf_caso3_planta_duplicados.php" method="post">
        <input type="hidden" name="documento" value="<?php echo $documento ?>">
    </form>
    <script>
        // Obtener el formulario
        var form = document.getElementById("myForm");

        // Enviar el formulario
        form.submit();
    </script>
    <?php

} else {
    // el número de documento no se encontró en ae_docente_catedra para Docente Ocasional
    // consulta a la tabla ae_docente_catedra para Docente Catedra PREGRADO
    $query = "SELECT * FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = $documento AND ENCUESTA LIKE '%CON CATEDRA(caso2)%'";
    $resultado = mysqli_query($conn, $query);
    if (mysqli_num_rows($resultado) > 0) {
        // el número de documento se encontró en ae_docente_catedra para Docente Ocasional, enviar POST a archivo1.php
    ?>
        <form id="myForm" action="/evaluacion_docente/dashboard/generarpdf_caso2_planta_duplicados.php" method="post">
            <input type="hidden" name="documento" value="<?php echo $documento ?>">
        </form>
        <script>
            // Obtener el formulario
            var form = document.getElementById("myForm");

            // Enviar el formulario
            form.submit();
        </script>
        <?php

    } else {
        // el número de documento no se encontró en ae_docente_catedra para Docente Catedra PREGRADO
        // consulta a la tabla ae_docente_catedra para Docente Planta
        $query = "SELECT * FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = $documento";
        $resultado = mysqli_query($conn, $query);
        if (mysqli_num_rows($resultado) > 0) {
            // el número de documento se encontró en ae_docente_catedra para Docente Ocasional, enviar POST a archivo1.php
        ?>
            <form id="myForm" action="/evaluacion_docente/dashboard/generarpdf_caso1_planta_duplicados.php" method="post">
                <input type="hidden" name="documento" value="<?php echo $documento ?>">
            </form>
            <script>
                // Obtener el formulario
                var form = document.getElementById("myForm");

                // Enviar el formulario
                form.submit();
            </script>
            <?php

        } else {

            // el número de documento no se encontró en ae_docente_catedra para Docente Catedra PREGRADO
            // consulta a la tabla ae_docente_catedra para Docente Planta
            $query = "SELECT * FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento AND ENCUESTA LIKE '%SIN CATEDRA%' AND CARGO_DOCENTE = 'Docente Planta'";
            $resultado = mysqli_query($conn, $query);
            if (mysqli_num_rows($resultado) > 0) {
                // el número de documento se encontró en ae_docente_catedra para Docente Ocasional, enviar POST a archivo1.php
            ?>
                <form id="myForm" action="/evaluacion_docente/dashboard/generarpdf_caso3_planta_duplicados.php" method="post">
                    <input type="hidden" name="documento" value="<?php echo $documento ?>">
                </form>
                <script>
                    // Obtener el formulario
                    var form = document.getElementById("myForm");

                    // Enviar el formulario
                    form.submit();
                </script>
                <?php

            } else {

                // el número de documento no se encontró en ae_docente_catedra para Docente Catedra PREGRADO
                // consulta a la tabla ae_docente_catedra para Docente Planta
                $query = "SELECT * FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento AND ENCUESTA LIKE '%CON CATEDRA(caso2)%'";
                $resultado = mysqli_query($conn, $query);
                if (mysqli_num_rows($resultado) > 0) {
                    // el número de documento se encontró en ae_docente_catedra para Docente Ocasional, enviar POST a archivo1.php
                ?>
                    <form id="myForm" action="/evaluacion_docente/dashboard/generarpdf_caso2_planta_duplicados.php" method="post">
                        <input type="hidden" name="documento" value="<?php echo $documento ?>">
                    </form>
                    <script>
                        // Obtener el formulario
                        var form = document.getElementById("myForm");

                        // Enviar el formulario
                        form.submit();
                    </script>
                    <?php

                } else {

                    // el número de documento no se encontró en ae_docente_catedra para Docente Catedra PREGRADO
                    // consulta a la tabla ae_docente_catedra para Docente Planta
                    $query = "SELECT * FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento";
                    $resultado = mysqli_query($conn, $query);
                    if (mysqli_num_rows($resultado) > 0) {
                        // el número de documento se encontró en ae_docente_catedra para Docente Ocasional, enviar POST a archivo1.php
                    ?>
                        <form id="myForm" action="/evaluacion_docente/dashboard/generarpdf_caso1_planta_duplicados.php" method="post">
                            <input type="hidden" name="documento" value="<?php echo $documento ?>">
                        </form>
                        <script>
                            // Obtener el formulario
                            var form = document.getElementById("myForm");

                            // Enviar el formulario
                            form.submit();
                        </script>
<?php

                    } else {

                        // el número de documento no se encontró en ae_docente_catedra para Docente Planta
                        // mostrar un mensaje emergente antes de redirigir
                        echo "<script>alert('¡El documento no existe en la base de datos!');</script>";

                        // redirigir a otra página después de mostrar el mensaje emergente
                        echo "<script>window.location.href = '/evaluacion_docente/dashboard/index.php';</script>";
                    }
                }
            }
        }
    }
}

?>
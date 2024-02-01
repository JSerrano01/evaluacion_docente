<?php 

// Conexión a la base de datos

$servername = "10.3.1.110:3306";
$username = "root";
$password = "WNeqRzh!nHrfA9d**K!^";
$dbname = "evaluacion_docente";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Falló la conexión a la base de datos: " . $conn->connect_error);
}

//De la pregunta 1 a la 5 tienen diferente formato de respuestas que el resto de preguntas

//Actualizacion de preguntas de la 1 a la 5
$preguntas = array(
    "PREGUNTA1", "PREGUNTA2", "PREGUNTA3", "PREGUNTA4", "PREGUNTA5"
);

$consultas = array();

// Ejecutar la consulta SQL dentro del loop
for ($i = 1; $i <= count($preguntas); $i++) {
    $sql = "UPDATE e_estud SET PREGUNTA$i = CASE
                WHEN PREGUNTA$i = 'a. Totalmente de acuerdo' THEN 5
                WHEN PREGUNTA$i = 'b. De acuerdo' THEN 4
                WHEN PREGUNTA$i = 'c. Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA$i = 'd. En desacuerdo' THEN 2
                WHEN PREGUNTA$i = 'e. Totalmente de desacuerdo' THEN 1
            END";

    // Ejecutar la consulta
    $result = mysqli_query($conn, $sql);

}

//Actualizacion de preguntas de la 6 a la 39
$preguntas1 = array(
    "PREGUNTA6", "PREGUNTA7", "PREGUNTA8", "PREGUNTA9", "PREGUNTA10","PREGUNTA11","PREGUNTA12","PREGUNTA13","PREGUNTA14","PREGUNTA15","PREGUNTA16","PREGUNTA17","PREGUNTA18","PREGUNTA19","PREGUNTA20","PREGUNTA21","PREGUNTA22","PREGUNTA23","PREGUNTA24","PREGUNTA25","PREGUNTA26","PREGUNTA27","PREGUNTA28","PREGUNTA29","PREGUNTA30","PREGUNTA31","PREGUNTA32","PREGUNTA33","PREGUNTA34","PREGUNTA35","PREGUNTA36","PREGUNTA37","PREGUNTA38","PREGUNTA39"
);

$consultas1 = array();

// Ejecutar la consulta SQL dentro del loop
for ($i = 6; $i <= 39; $i++) {
    $sql1 = "UPDATE e_estud SET PREGUNTA$i = CASE
                WHEN PREGUNTA$i = 'Totalmente de acuerdo' THEN 5
                WHEN PREGUNTA$i = 'De acuerdo' THEN 4
                WHEN PREGUNTA$i = 'Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA$i = 'En desacuerdo' THEN 2
                WHEN PREGUNTA$i = 'Totalmente de desacuerdo' THEN 1
            END";

    // Ejecutar la consulta
    $result1 = mysqli_query($conn, $sql1);

}  
  // mostrar un mensaje emergente antes de redirigir
  echo "<script>alert('¡La base de datos fue actualizada!');</script>";
  
  // redirigir a otra página después de mostrar el mensaje emergente
  echo "<script>window.location.href = 'e_estud.php';</script>";
    

?>
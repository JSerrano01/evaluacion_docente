<?php
include_once 'plantilla.php';
include_once 'funciones.php';
include_once 'bd/conexion.php';


header("Content-type: application/pdf; charset=utf-8");
$funcion = new Functions_Aux();
$objeto = new Conexion();
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$servername = "10.3.1.110:3306";
$username = "root";
$password = "WNeqRzh!nHrfA9d**K!^";
$dbname = "evaluacion_docente";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "evaluacion_docente1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Falló la conexión a la base de datos: " . $conn->connect_error);
}

if (isset($_POST['documento'])) {
    $documento = $_POST['documento'];
    // Se establece la variable $documento con POST
} else

    $documento = 666155;


//Verificar si el docente existe en ae_docente_catedra o ae_docente_sin_catedra
$query = "SELECT * FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = $documento";
$resultado = mysqli_query($conn, $query);
if (mysqli_num_rows($resultado) > 0) {

    $query_aecatedra = "SELECT * from ae_docente_catedra WHERE DOCUMENTO_DOCENTE = $documento ";
    //Ejecución de query data de aecatedra
    $resultado_aecatedra = $conexion->prepare($query_aecatedra);
    $resultado_aecatedra->execute();
    $data_aecatedra = $resultado_aecatedra->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = "SELECT * FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento";
    $resultado = mysqli_query($conn, $query);
    if (mysqli_num_rows($resultado) > 0) {

        $query_aecatedra = "SELECT * from ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento ";
        //Ejecución de query data de aecatedra
        $resultado_aecatedra = $conexion->prepare($query_aecatedra);
        $resultado_aecatedra->execute();
        $data_aecatedra = $resultado_aecatedra->fetchAll(PDO::FETCH_ASSOC);
    }
}
/*
$query_aecatedra = "SELECT * from ae_docente_catedra WHERE DOCUMENTO_DOCENTE = $documento ";
//Ejecución de query data de aecatedra
$resultado_aecatedra = $conexion->prepare($query_aecatedra);
$resultado_aecatedra->execute();
$data_aecatedra = $resultado_aecatedra->fetchAll(PDO::FETCH_ASSOC);
//se debe setear SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

*/
// Consulta SQL de evaluacion estudiantes 
$query_eval_estudiantes = "SELECT  GRUPO, COUNT(GRUPO) as COUNT_ENC, ENCUESTA, ROUND(AVG(((PREGUNTA1 + PREGUNTA4 + PREGUNTA5 + PREGUNTA6 + PREGUNTA7+ PREGUNTA8+ PREGUNTA9+ PREGUNTA10+ PREGUNTA11) / 9)),2) AS gestion_asig, ROUND(AVG(((PREGUNTA12 + PREGUNTA13 + PREGUNTA14 + PREGUNTA15) / 4) ),2) AS ambiente_asig, ROUND(AVG(((PREGUNTA16 + PREGUNTA17 + PREGUNTA18 + PREGUNTA19 + PREGUNTA20) / 5)),2) AS motivacion_asig, ROUND(AVG(((PREGUNTA21 + PREGUNTA22 + PREGUNTA23 + PREGUNTA24 + PREGUNTA25) / 5)),2) AS evaluacion_asig, ROUND(AVG(((PREGUNTA26 + PREGUNTA27 + PREGUNTA28 + PREGUNTA29 + PREGUNTA30 + PREGUNTA31 + PREGUNTA32 + PREGUNTA33 + PREGUNTA34 + PREGUNTA35 + PREGUNTA36 + PREGUNTA37 + PREGUNTA38 + PREGUNTA39) / 14)),2) AS comunicacion_asig FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento GROUP BY GRUPO";
$resultado_evalestud = $conexion->prepare($query_eval_estudiantes);
$resultado_evalestud->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
$data_estudiantes = $resultado_evalestud->fetchAll(PDO::FETCH_ASSOC);

//Consulta SQL de estudiantes con promedio de cada indicador resultados
$query_eval_estudiantes1 = "SELECT  GRUPO, COUNT(GRUPO) as COUNT_ENC, ENCUESTA, ROUND(AVG(((PREGUNTA1 + PREGUNTA4 + PREGUNTA5 + PREGUNTA6 + PREGUNTA7+ PREGUNTA8+ PREGUNTA9+ PREGUNTA10+ PREGUNTA11) / 9)),2) AS gestion_asig, ROUND(AVG(((PREGUNTA12 + PREGUNTA13 + PREGUNTA14 + PREGUNTA15) / 4) ),2) AS ambiente_asig, ROUND(AVG(((PREGUNTA16 + PREGUNTA17 + PREGUNTA18 + PREGUNTA19 + PREGUNTA20) / 5)),2) AS motivacion_asig, ROUND(AVG(((PREGUNTA21 + PREGUNTA22 + PREGUNTA23 + PREGUNTA24 + PREGUNTA25) / 5)),2) AS evaluacion_asig, ROUND(AVG(((PREGUNTA26 + PREGUNTA27 + PREGUNTA28 + PREGUNTA29 + PREGUNTA30 + PREGUNTA31 + PREGUNTA32 + PREGUNTA33 + PREGUNTA34 + PREGUNTA35 + PREGUNTA36 + PREGUNTA37 + PREGUNTA38 + PREGUNTA39) / 14)),2) AS comunicacion_asig FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento";
$resultado_evalestud1 = $conexion->prepare($query_eval_estudiantes1);
$resultado_evalestud1->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
$data_estudiantes1 = $resultado_evalestud1->fetchAll(PDO::FETCH_ASSOC);

$query_eval_estudiantes2 = "SELECT GRUPO,PREGUNTA40, GROUP_CONCAT(PREGUNTA40 SEPARATOR ', ') AS RESPUESTAS_PREGUNTA40 FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento GROUP BY GRUPO, PREGUNTA40";
$resultado_evalestud2 = $conexion->prepare($query_eval_estudiantes2);
$resultado_evalestud2->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
$data_estudiantes2 = $resultado_evalestud2->fetchAll(PDO::FETCH_ASSOC);

/*
//Consulta SQL para evaluacion por parte del decano
$query_eval_decano = "SELECT e_decano_planta.* FROM e_decano_planta INNER JOIN ae_docente_catedra ON e_decano_planta.DOCUMENTO_DOCENTE = ae_docente_catedra.DOCUMENTO_DOCENTE WHERE ae_docente_catedra.DOCUMENTO_DOCENTE = :documento";
$resultado_eval_decano = $conexion->prepare($query_eval_decano);
$resultado_eval_decano->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
$data_decano = $resultado_eval_decano->fetchAll(PDO::FETCH_ASSOC);

//Consulta SQL para resultado evaluacion por parte del decano
$query_eval_decano1 = "SELECT ROUND(SUM(CASE WHEN PREGUNTA1 = 'SI' THEN ((PREGUNTA2 * PREGUNTA3) / 100) ELSE 0 END + CASE WHEN PREGUNTA4 = 'SI' THEN ((PREGUNTA5 * PREGUNTA6) / 100) ELSE 0 END + CASE WHEN PREGUNTA7 = 'SI' THEN ((PREGUNTA8 * PREGUNTA9) / 100) ELSE 0 END + CASE WHEN PREGUNTA10 = 'SI' THEN ((PREGUNTA11 * PREGUNTA12) / 100) ELSE 0 END + CASE WHEN PREGUNTA13 = 'SI' THEN ((PREGUNTA14 * PREGUNTA15) / 100) ELSE 0 END + CASE WHEN PREGUNTA16 = 'SI' THEN ((PREGUNTA17 * PREGUNTA18) / 100) ELSE 0 END) / (SELECT COUNT(*) FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento AND (PREGUNTA1 = 'SI' OR PREGUNTA4 = 'SI' OR PREGUNTA7 = 'SI' OR PREGUNTA10 = 'SI' OR PREGUNTA13 = 'SI' OR PREGUNTA16 = 'SI')), 2) AS RESULTADO FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento";
$resultado_eval_decano1 = $conexion->prepare($query_eval_decano1);
$resultado_eval_decano1->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
$data_decano1 = $resultado_eval_decano1->fetchAll(PDO::FETCH_ASSOC);
*/

$query1 = "SELECT * FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = $documento";
$resultado1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($resultado1) > 0) {
    //Consulta SQL para evaluacion por parte del decano
    $query_eval_decano = "SELECT * FROM e_decano_planta  WHERE DOCUMENTO_DOCENTE = :documento";
    $resultado_eval_decano = $conexion->prepare($query_eval_decano);
    $resultado_eval_decano->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
    $data_decano = $resultado_eval_decano->fetchAll(PDO::FETCH_ASSOC);

    //Consulta SQL para resultado evaluacion por parte del decano
    $query_eval_decano1 = "SELECT ROUND(SUM(CASE WHEN PREGUNTA1 = 'SI' THEN ((PREGUNTA2 * PREGUNTA3) / 100) ELSE 0 END + CASE WHEN PREGUNTA4 = 'SI' THEN ((PREGUNTA5 * PREGUNTA6) / 100) ELSE 0 END + CASE WHEN PREGUNTA7 = 'SI' THEN ((PREGUNTA8 * PREGUNTA9) / 100) ELSE 0 END + CASE WHEN PREGUNTA10 = 'SI' THEN ((PREGUNTA11 * PREGUNTA12) / 100) ELSE 0 END + CASE WHEN PREGUNTA13 = 'SI' THEN ((PREGUNTA14 * PREGUNTA15) / 100) ELSE 0 END + CASE WHEN PREGUNTA16 = 'SI' THEN ((PREGUNTA17 * PREGUNTA18) / 100) ELSE 0 END) / (SELECT COUNT(*) FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento AND (PREGUNTA1 = 'SI' OR PREGUNTA4 = 'SI' OR PREGUNTA7 = 'SI' OR PREGUNTA10 = 'SI' OR PREGUNTA13 = 'SI' OR PREGUNTA16 = 'SI')), 2) AS RESULTADO FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento";
    $resultado_eval_decano1 = $conexion->prepare($query_eval_decano1);
    $resultado_eval_decano1->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
    $data_decano1 = $resultado_eval_decano1->fetchAll(PDO::FETCH_ASSOC);

    //Consulta SQL para observaciones por parte del decano
    $query_eval_decano2 = "SELECT PREGUNTA16 AS P16, PREGUNTA17 AS P17, PREGUNTA18 AS P18,PREGUNTA19 AS P19 FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento";
    $resultado_eval_decano2 = $conexion->prepare($query_eval_decano2);
    $resultado_eval_decano2->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
    $data_decano2 = $resultado_eval_decano2->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query1 = "SELECT * FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = $documento";
    $resultado1 = mysqli_query($conn, $query1);
    if (mysqli_num_rows($resultado1) > 0) {
        //Consulta SQL para evaluacion por parte del decano
        $query_eval_decano = "SELECT * FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_decano = $conexion->prepare($query_eval_decano);
        $resultado_eval_decano->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_decano = $resultado_eval_decano->fetchAll(PDO::FETCH_ASSOC);

        $query_eval_decano1 = "SELECT 
        ROUND((CASE 
            WHEN PREGUNTA1 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA1 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA1 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA1 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA1 = 'e) Totalmente de desacuerdo' THEN 1
        END +
        CASE 
            WHEN PREGUNTA2 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA2 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA2 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA2 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA2 = 'e) Totalmente de desacuerdo' THEN 1
        END  +
        CASE 
            WHEN PREGUNTA3 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA3 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA3 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA3 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA3 = 'e) Totalmente de desacuerdo' THEN 1
        END
        +
        CASE 
            WHEN PREGUNTA4 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA4 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA4 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA4 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA4 = 'e) Totalmente de desacuerdo' THEN 1
        END
        +
        CASE 
            WHEN PREGUNTA5 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA5 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA5 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA5 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA5 = 'e) Totalmente de desacuerdo' THEN 1
        END
        +
        CASE 
            WHEN PREGUNTA6 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA6 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA6 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA6 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA6 = 'e) Totalmente de desacuerdo' THEN 1
        END
        +
        CASE 
            WHEN PREGUNTA7 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA7 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA7 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA7 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA7 = 'e) Totalmente de desacuerdo' THEN 1
        END
        +
        CASE 
            WHEN PREGUNTA8 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA8 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA8 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA8 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA8 = 'e) Totalmente de desacuerdo' THEN 1
        END)/8 ,2)AS RESULTADO
        FROM e_decano_catedra 
        WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_decano1 = $conexion->prepare($query_eval_decano1);
        $resultado_eval_decano1->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_decano1 = $resultado_eval_decano1->fetchAll(PDO::FETCH_ASSOC);

        //Consulta SQL para observaciones por parte del decano
        $query_eval_decano2 = "SELECT PREGUNTA16 AS P16, PREGUNTA17 AS P17, PREGUNTA18 AS P18,PREGUNTA19 AS P19 FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_decano2 = $conexion->prepare($query_eval_decano2);
        $resultado_eval_decano2->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_decano2 = $resultado_eval_decano2->fetchAll(PDO::FETCH_ASSOC);
    }
}


//Creacion de PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetTopMargin(0);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('CASO 1: DOCENTE COMÚN'), 1, 1, 'C', true);
$pdf->Ln(1);
$pdf->Rect(10, 30, 190, 35);
$pdf->SetCol(0);
$pdf->SetLeftMargin(12);
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->Cell(0, 10, utf8_decode('INSTITUCIÓN UNIVERSITARIA COLEGIO MAYOR DE ANTIOQUIA'), 0, 0, '');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '7.5');
//para extraer el periodo completo del reporte
$referencia_encuesta = explode("-", $data_aecatedra[0]['ENCUESTA']);
$periodo_encuesta = $referencia_encuesta[1] . "-" . $referencia_encuesta[2];
$pdf->Cell(0, 10, utf8_decode('EVALUACIÓN DE DESEMPEÑO PARA EL PERIODO: ' . $periodo_encuesta), 0, 0, '');
$pdf->Ln();
$pdf->Cell(40, 10, utf8_decode('NOMBRE DEL DOCENTE: '), 0, 0, '');
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['NOMBRE_DOCENTE']), 0, 0, '');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 10, utf8_decode('CARGO: '), 0, 0, '');
$pdf->Cell(-25);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE']), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 10, utf8_decode('IDENTIFICACIÓN: '), 0, 0, '');
$pdf->Cell(-12);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['DOCUMENTO_DOCENTE']), 0, 0, 'L');
$pdf->Ln();
$pdf->SetCol(0);
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('EVALUACIÓN POR PARTE DEL DECANO (40%)'), 1, 1, 'C', true);
$pdf->Ln(2);
$pdf->Rect(10, 77, 190, 35);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->SetCol(0);
$pdf->SetLeftMargin(12);
$pdf->Cell(40, 10, utf8_decode('EVALUADOR: '), 0, 0, '');
$pdf->Cell(-18);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode($data_decano[0]['NOMBRE_EVALUADOR']), 0, 0, '');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 0, utf8_decode('DOCENTE: '), 0, 0, '');
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(-18);
$pdf->Cell(50, 0, utf8_decode($data_aecatedra[0]['NOMBRE_DOCENTE']), 0, 0, '');
$pdf->SetCol(1.3);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, -10, utf8_decode('DEP. DEL EVALUADOR: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, -10, utf8_decode($data_decano[0]['FACULTAD']), 0, 0, '');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 20, utf8_decode('DEP. DEL DOCENTE: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 20, utf8_decode($data_aecatedra[0]['FACULTAD']), 0, 0, '');
$pdf->SetCol(0.5);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(30, 30, utf8_decode('TIPO DOCENTE: '), 0, 0, '');
$pdf->Cell(-1);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(30, 30, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE']), 0, 0, '');
$pdf->SetCol(0.5);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(30, 40, utf8_decode('TOTAL: '), 0, 0, '');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(40, 40, utf8_decode($data_decano1[0]['RESULTADO']), 0, 0, '');
$pdf->SetCol(0.5);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(30, 50, utf8_decode('VALOR: '), 0, 0, '');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(40, 50, utf8_decode(ROUND(($data_decano1[0]['RESULTADO'] * 0.4), 2)), 0, 0, '');
$pdf->SetCol(1);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(30, 60, utf8_decode('FECHA: '), 0, 0, '');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(40, 60, utf8_decode($data_aecatedra[0]['FECHA_DILIGENCIAMIENTO']), 0, 0, '');
$pdf->SetCol(0);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 80, utf8_decode('VALOR FINAL: '), 0, 0, '');
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(40, 80, utf8_decode($data_decano1[0]['RESULTADO'] . ' (' . ROUND(($data_decano1[0]['RESULTADO'] * 0.4), 2) . ')'), 0, 0, '');
$pdf->SetCol(0);
$pdf->Ln(45);
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('AUTOEVALUACIÓN DEL DOCENTE (20%)'), 1, 0, 'C', true);
$pdf->Ln();
$header = array('Encuesta', 'Dominio de la disciplina', 'Gestión de la Asignatura', 'Ambientes y Estrategias de Aprendizaje', 'Motivación', 'Evaluación', 'Comunicación y Relación con los estudiantes', 'TOTAL', 'VALOR');
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->SetWidths(array(30, 15, 21, 25, 18, 18, 25, 18, 25, 12, 12));
$pdf->Row($header);

//suma de primer factor a evaluar - Dominio disciplina
$dominio_disc = $funcion->promedio_valores_preguntas($data_aecatedra[0], 1, 6, 'aecatedra');
//suma de segundo factor a evaluar - Gestión de la asignatura
$gestion_asig = $funcion->promedio_valores_preguntas($data_aecatedra[0], 7, 10, 'aecatedra');
//suma de tercer factor a evaluar - Ambiente y estrategias
$ambiente_est = $funcion->promedio_valores_preguntas($data_aecatedra[0], 11, 15, 'aecatedra');
//suma de cuarto factor a evaluar - Motivación
$motivacion = $funcion->promedio_valores_preguntas($data_aecatedra[0], 16, 20, 'aecatedra');
//suma de quinto factor a evaluar - Evaluacion
$evaluacion = $funcion->promedio_valores_preguntas($data_aecatedra[0], 21, 26, 'aecatedra');
//suma de sexto factor a evaluar - Comunicación
$comunicacion = $funcion->promedio_valores_preguntas($data_aecatedra[0], 27, 31, 'aecatedra');
$valores = array($dominio_disc, $gestion_asig, $ambiente_est, $motivacion, $evaluacion, $comunicacion);
$promedio_valores = round(array_sum($valores) / count($valores), 2);
$valor_base_porcentaje = $promedio_valores * 0.2;
$autoevaluacion_completa = array($data_aecatedra[0]['ENCUESTA'], strval($dominio_disc), $gestion_asig, $ambiente_est, $motivacion, $evaluacion, $comunicacion, $promedio_valores, $valor_base_porcentaje);

$pdf->SetFont('Arial', '', '6.5');
$pdf->Row($autoevaluacion_completa);

$pdf->Ln();
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('EVALUACIÓN POR PARTE DE ESTUDIANTES (40%)'), 1, 0, 'C', true);
$pdf->Ln();
$header = array('Grupo', 'Encuesta', 'Encuestas diligenciadas', 'Dominio de la disciplina', 'Gestión de la Asignatura', 'Ambientes y Estrategias de Aprendizaje', 'Motivación', 'Evaluación', 'Comunicación y Relación con los estudiantes', 'TOTAL', 'VALOR');
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->SetWidths(array(9, 15, 16, 21, 16, 23, 18, 18, 23, 15, 12));
$pdf->Row($header);
$pdf->Ln();
$pdf->SetFont('Arial', '', '6.5');
$pdf->SetWidths(array(10, 15, 16, 21, 16, 23, 18, 18, 23, 15, 12));


//Recorrido para mostrar de la consulta de evaluacion estudiantes
for ($i = 0; $i < count($data_estudiantes); $i++) {

    $pdf->Row(array($data_estudiantes[$i]['GRUPO'], $data_estudiantes[$i]['ENCUESTA'], $data_estudiantes[$i]['COUNT_ENC'], $data_estudiantes[$i]['gestion_asig'], $data_estudiantes[$i]['gestion_asig'], $data_estudiantes[$i]['ambiente_asig'], $data_estudiantes[$i]['motivacion_asig'], $data_estudiantes[$i]['evaluacion_asig'], $data_estudiantes[$i]['comunicacion_asig'], round((($data_estudiantes[$i]['gestion_asig'] + $data_estudiantes[$i]['gestion_asig'] + $data_estudiantes[$i]['ambiente_asig'] + $data_estudiantes[$i]['motivacion_asig'] + $data_estudiantes[$i]['evaluacion_asig'] + $data_estudiantes[$i]['comunicacion_asig']) / 6),2), round((($data_estudiantes[$i]['gestion_asig'] + $data_estudiantes[$i]['gestion_asig'] + $data_estudiantes[$i]['ambiente_asig'] + $data_estudiantes[$i]['motivacion_asig'] + $data_estudiantes[$i]['evaluacion_asig'] + $data_estudiantes[$i]['comunicacion_asig']) / 6) * 0.4, 2))) . "<br>";

    $pdf->Ln();
    $pdf->Ln();
}

//Recorrido de segunda consulta SQL de evaluacion estudiantes para promedio de cada factor 

for ($i = 0; $i < count($data_estudiantes1); $i++) {

    $pdf->Row(array(" ", "PROMEDIO", $data_estudiantes1[$i]['COUNT_ENC'], $data_estudiantes1[$i]['gestion_asig'], $data_estudiantes1[$i]['gestion_asig'], $data_estudiantes1[$i]['ambiente_asig'], $data_estudiantes1[$i]['motivacion_asig'], $data_estudiantes1[$i]['evaluacion_asig'], $data_estudiantes1[$i]['comunicacion_asig'], round(($data_estudiantes1[$i]['gestion_asig'] + $data_estudiantes1[$i]['gestion_asig'] + $data_estudiantes1[$i]['ambiente_asig'] + $data_estudiantes1[$i]['motivacion_asig'] + $data_estudiantes1[$i]['evaluacion_asig'] + $data_estudiantes1[$i]['comunicacion_asig']) / 6, 2), round((($data_estudiantes1[$i]['gestion_asig'] + $data_estudiantes1[$i]['gestion_asig'] + $data_estudiantes1[$i]['ambiente_asig'] + $data_estudiantes1[$i]['motivacion_asig'] + $data_estudiantes1[$i]['evaluacion_asig'] + $data_estudiantes1[$i]['comunicacion_asig']) / 6) * 0.4, 2))) . "<br>";

    $pdf->Ln();
    $pdf->Ln();
}


//Mostrar resultados consolidados de la evalucaion
$pdf->AddPage();
$pdf->Ln();
$pdf->SetCol(0.55);
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(120, 8, utf8_decode('RESULTADOS CONSOLIDADOS'), 1, 0, 'C', true);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 10, utf8_decode('EVALUACION POR PARTE DEL DECANO (40%) '), 0, 0, '');
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(40);
$pdf->Cell(50, 10, utf8_decode($data_decano1[0]['RESULTADO'] . "  " . "(" . ROUND(($data_decano1[0]['RESULTADO'] * 0.4), 2) . ")"), 0, 0, '');
$pdf->Cell(40);
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 10, utf8_decode('AUTOEVALUACION (20%) '), 0, 0, '');
$pdf->Cell(40);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode($promedio_valores . "  " . "(" . ROUND($valor_base_porcentaje, 2) . ")"), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 10, utf8_decode('EVALUACION POR PARTE DE LOS ESTUDIANTES (40%) '), 0, 0, '');
$pdf->Cell(40);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode(round(($data_estudiantes1[0]['gestion_asig'] + $data_estudiantes1[0]['gestion_asig'] + $data_estudiantes1[0]['ambiente_asig'] + $data_estudiantes1[0]['motivacion_asig'] + $data_estudiantes1[0]['evaluacion_asig'] + $data_estudiantes1[0]['comunicacion_asig']) / 6, 2) . "  " . "(" . round((($data_estudiantes1[0]['gestion_asig'] + $data_estudiantes1[0]['gestion_asig'] + $data_estudiantes1[0]['ambiente_asig'] + $data_estudiantes1[0]['motivacion_asig'] + $data_estudiantes1[0]['evaluacion_asig'] + $data_estudiantes1[0]['comunicacion_asig']) / 6) * 0.4, 2) . ")"), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->Cell(40, 10, utf8_decode('TOTAL PUNTOS '), 0, 0, '');
$pdf->Cell(40);
$pdf->SetFont('Arial', '', '6.5');
$pdf->Cell(50, 10, utf8_decode(round((ROUND(($data_decano1[0]['RESULTADO'] * 0.4), 2) + ROUND($valor_base_porcentaje, 2) + round((($data_estudiantes1[0]['gestion_asig'] + $data_estudiantes1[0]['gestion_asig'] + $data_estudiantes1[0]['ambiente_asig'] + $data_estudiantes1[0]['motivacion_asig'] + $data_estudiantes1[0]['evaluacion_asig'] + $data_estudiantes1[0]['comunicacion_asig']) / 6) * 0.4, 2)), 2)), 0, 0, 'L');
$pdf->Ln();

//Pregunta espacio en la pagina o agrega una nueva
$altura_requerida = 90; // ajustar esta altura según sea necesario
if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
    $pdf->AddPage();
}

//Mostar tabla de observaciones

$pdf->SetCol(0);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', '7.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('OBSERVACIONES'), 1, 0, 'C', true);
$pdf->Ln(10);

//Pregunta espacio en la pagina o agrega una nueva
$altura_requerida = 90; // ajustar esta altura según sea necesario
if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
    $pdf->AddPage();
}

//Observaciones por parte del decano
$pdf->SetCol(0);
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('OBSERVACIONES POR PARTE DEL DECANO'), 1, 0, 'C', true);
$pdf->Ln(8);

// código a ejecutar si todas las condiciones son verdaderas

if (isset($data_decano[0]['PREGUNTA16']) && !empty($data_decano[0]['PREGUNTA16'])) {
    $pdf->SetFont('Arial', 'B', '5.5');
    $pdf->Cell(65, 10, utf8_decode('FACTORES Y ASPECTOS QUE SE DEBEN MEJORAR: '), 0, 0, '');
    $pdf->Cell(-12);
    $pdf->SetFont('Arial', '', '6.5');
    $pdf->Cell(50, 10, utf8_decode($data_decano[0]['PREGUNTA16']), 0, 0, '', false);
} else {
    $pdf->Cell(40);
    $pdf->SetFont('Arial', 'B', '6.5');
    $pdf->Cell(50, 10, utf8_decode('No Hay Observaciones'), 0, 0, '', false);


    if (isset($data_decano[0]['PREGUNTA17']) && !empty($data_decano[0]['PREGUNTA17'])) {
        $pdf->SetFont('Arial', 'B', '5.5');
        $pdf->Cell(65, 10, utf8_decode('FACTORES Y ASPECTOS EN LOS QUE SOBRESALE EL EVALUADO: '), 0, 0, '');
        $pdf->Cell(-12);
        $pdf->SetFont('Arial', '', '6.5');
        $pdf->Cell(50, 10, utf8_decode($data_decano[0]['PREGUNTA17']), 0, 0, '', false);
    } else {
        $pdf->Cell(40);
        $pdf->SetFont('Arial', 'B', '6.5');
        $pdf->Cell(50, 10, utf8_decode('No Hay Observaciones'), 0, 0, '', false);


        if (isset($data_decano[0]['PREGUNTA18']) && !empty($data_decano[0]['PREGUNTA18'])) {
            $pdf->SetFont('Arial', 'B', '5.5');
            $pdf->Cell(65, 10, utf8_decode('LIMITACIONES PARA EL CUMPLIMIENTO DE LOS OBJETIVOS: '), 0, 0, '');
            $pdf->Cell(-12);
            $pdf->SetFont('Arial', '', '6.5');
            $pdf->Cell(50, 10, utf8_decode($data_decano[0]['PREGUNTA18']), 0, 0, '', false);
        } else {
            $pdf->Cell(40);
            $pdf->SetFont('Arial', 'B', '6.5');
            $pdf->Cell(50, 10, utf8_decode('No Hay Observaciones'), 0, 0, '', false);


            if (isset($data_decano[0]['PREGUNTA19']) && !empty($data_decano[0]['PREGUNTA19'])) {
                $pdf->SetFont('Arial', 'B', '5.5');
                $pdf->Cell(65, 10, utf8_decode('OBSERVACIONES: '), 0, 0, '');
                $pdf->Cell(-12);
                $pdf->SetFont('Arial', '', '6.5');
                $pdf->Cell(50, 10, utf8_decode($data_decano[0]['PREGUNTA19']), 0, 0, '', false);
            } else {
                $pdf->Cell(40);
                $pdf->SetFont('Arial', 'B', '6.5');
                $pdf->Cell(50, 10, utf8_decode('No Hay Observaciones'), 0, 0, '', false);
            }
        }
    }
}


//Pregunta espacio en la pagina o agrega una nueva
$altura_requerida = 90; // ajustar esta altura según sea necesario
if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
    $pdf->AddPage();
}

//Observaciones Autoevaluacion Docente
$pdf->SetCol(0);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('OBSERVACIONES AUTOEVALUACION DOCENTE'), 1, 0, 'C', true);
$pdf->Ln(8);

if (isset($data_aecatedra[0]['PREGUNTA32']) && !empty($data_aecatedra[0]['PREGUNTA32'])) {
    $pdf->SetFont('Arial', 'B', '5.5');
    $pdf->Cell(65, 10, utf8_decode('FACTORES Y ASPECTOS QUE SE DEBEN MEJORAR: '), 0, 0, '');
} else {
    $pdf->Cell(-12);
    $pdf->SetFont('Arial', '', '6.5');
    $pdf->Cell(50, 10, utf8_decode('-'), 0, 0, '', false);
}


if (isset($data_aecatedra[0]['PREGUNTA32']) && !empty($data_aecatedra[0]['PREGUNTA32'])) {
    $pdf->Cell(-12);
    $pdf->SetFont('Arial', '', '6.5');
    $pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['PREGUNTA32']), 0, 0, '', false);
} else {
    $pdf->Cell(40);
    $pdf->SetFont('Arial', 'B', '6.5');
    $pdf->Cell(50, 10, utf8_decode('No Hay Observaciones'), 0, 0, '', false);
}

$pdf->Ln(15);


//Pregunta espacio en la pagina o agrega una nueva
$altura_requerida = 90; // ajustar esta altura según sea necesario
if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
    $pdf->AddPage();
}

//Observaciones evaluacion estudiantes
$pdf->SetCol(0);
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', '6.5');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('OBSERVACIONES EVALUACION DOCENTE POR PARTE DEL ESTUDIANTES'), 1, 0, 'C', true);
$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(150, 10, utf8_decode('OBSERVACIONES '), 0, 0, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 7.1);
$pdf->SetWidths(array(5, 120));
$pdf->SetAligns(array('L', 'L'));

// Agrupar las respuestas por grupo
$respuestas_por_grupo = array();
foreach ($data_estudiantes2 as $estudiante) {
    $grupo = $estudiante['GRUPO'];
    $respuesta = $estudiante['PREGUNTA40'];
    if (!isset($respuestas_por_grupo[$grupo])) {
        $respuestas_por_grupo[$grupo] = array();
    }
    $respuestas_por_grupo[$grupo][] = $respuesta;
}
//Pregunta espacio en la pagina o agrega una nueva
$altura_requerida = 90; // ajustar esta altura según sea necesario
if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
    $pdf->AddPage();
}
// Mostrar las respuestas por grupo
foreach ($respuestas_por_grupo as $grupo => $respuestas) {
    $pdf->Cell(30, 10, "Grupo:" . $grupo, 0, 0, 'L');
    $pdf->Ln();
    foreach ($respuestas as $respuesta) {
        $pdf->Row(array(" - ", $respuesta));
    }
    //Pregunta espacio en la pagina o agrega una nueva
    $altura_requerida = 90; // ajustar esta altura según sea necesario
    if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
        $pdf->AddPage();
    }
    $pdf->Ln();
}

//Pregunta espacio en la pagina o agrega una nueva
$altura_requerida = 90; // ajustar esta altura según sea necesario
if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
    $pdf->AddPage();
}

$pdf->SetCol(0.1);
$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(150, 10, utf8_decode('FIRMA DEL EVALUADOR'), 0, 0, 'L');
$pdf->Cell(-50);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(150, 10, utf8_decode('FIRMA DEL EVALUADO'), 0, 0, 'L');
$pdf->Ln(25);
$pdf->Cell(-1);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(150, 10, utf8_decode('FECHA DE LA EVALUACION'), 0, 0, 'L');
$pdf->Ln(15);

$pdf->Output('I', $periodo_encuesta . '_' . utf8_decode($data_aecatedra[0]['FACULTAD']) . '-' . $data_aecatedra[0]['CARGO_DOCENTE'] . '_Cedula' . $documento . '_' . $data_aecatedra[0]['NOMBRE_DOCENTE'] . '.pdf');

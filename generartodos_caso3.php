<?php
//require_once('plugins/fpdf/fpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evaluacion_docente1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Falló la conexión a la base de datos: " . $conn->connect_error);
}

// Crear la consulta SQL para seleccionar los DOCUMENTO_DOCENTE de las tres tablas
$query = "SELECT DOCUMENTO_DOCENTE 
FROM ae_docente_catedra 
WHERE ENCUESTA LIKE '%SIN CATEDRA%'
UNION 
SELECT DOCUMENTO_DOCENTE 
FROM ae_docente_sin_catedra 
WHERE ENCUESTA LIKE '%SIN CATEDRA%'";

// Ejecutar la consulta y guardar los resultados en un array
$result = mysqli_query($conn, $query);
$documentos = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $documentos[] = $row['DOCUMENTO_DOCENTE'];
    }
}

// Liberar la memoria del resultado de la consulta
mysqli_free_result($result);

// Generar los PDF correspondientes
foreach ($documentos as $documento) {

    //Pregunta si el documento esta para imprimir en caso 3
    $query = "SELECT * FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento AND ENCUESTA LIKE '%SIN CATEDRA%' AND CARGO_DOCENTE = 'Docente Planta'";
    $resultado = mysqli_query($conn, $query);

    if (mysqli_num_rows($resultado) > 0) {

        include_once 'plantilla.php';
        include_once 'funciones.php';
        include_once 'bd/conexion.php';


        header("Content-type: application/pdf; charset=utf-8");
        $funcion = new Functions_Aux();
        $objeto = new Conexion();
        $objeto = new Conexion();
        $conexion = $objeto->Conectar();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "evaluacion_docente1";

        $conn = new mysqli($servername, $username, $password, $dbname);

        $query_aecatedra = "SELECT * ,COUNT(ENCUESTA) AS COUNT_ENCUESTA, PREGUNTA1 + PREGUNTA2 + PREGUNTA3 + PREGUNTA4 + PREGUNTA5 +PREGUNTA6 + PREGUNTA7 + PREGUNTA8  AS TOTAL from ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = $documento ";
        //Ejecución de query data de aecatedra
        $resultado_aecatedra = $conexion->prepare($query_aecatedra);
        $resultado_aecatedra->execute();
        $data_aecatedra = $resultado_aecatedra->fetchAll(PDO::FETCH_ASSOC);

        $query_eval_sin_catedra = "SELECT 
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
        FROM ae_docente_sin_catedra 
        WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_sin_catedra = $conexion->prepare($query_eval_sin_catedra);
        $resultado_eval_sin_catedra->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_eval_sin_catedra = $resultado_eval_sin_catedra->fetchAll(PDO::FETCH_ASSOC);


        $query_eval_sin_catedra1 = "SELECT 
        (CASE 
            WHEN PREGUNTA1 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA1 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA1 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA1 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA1 = 'e) Totalmente de desacuerdo' THEN 1
        END) AS P1,
        (CASE 
            WHEN PREGUNTA2 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA2 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA2 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA2 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA2 = 'e) Totalmente de desacuerdo' THEN 1
        END)  AS P2,
        (CASE 
            WHEN PREGUNTA3 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA3 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA3 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA3 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA3 = 'e) Totalmente de desacuerdo' THEN 1
        END)
        AS P3,
        (CASE 
            WHEN PREGUNTA4 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA4 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA4 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA4 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA4 = 'e) Totalmente de desacuerdo' THEN 1
        END)
        AS P4,
        (CASE 
            WHEN PREGUNTA5 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA5 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA5 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA5 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA5 = 'e) Totalmente de desacuerdo' THEN 1
        END)
        AS P5,
        (CASE 
            WHEN PREGUNTA6 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA6 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA6 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA6 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA6 = 'e) Totalmente de desacuerdo' THEN 1
        END) AS P6,
        (CASE 
            WHEN PREGUNTA7 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA7 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA7 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA7 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA7 = 'e) Totalmente de desacuerdo' THEN 1
        END) AS P7,
        (CASE 
            WHEN PREGUNTA8 = 'a) Totalmente de acuerdo' THEN 5 
            WHEN PREGUNTA8 = 'b) De acuerdo' THEN 4 
            WHEN PREGUNTA8 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
            WHEN PREGUNTA8 = 'd) En desacuerdo' THEN 2
            WHEN PREGUNTA8 = 'e) Totalmente de desacuerdo' THEN 1
        END)AS P8
        FROM ae_docente_sin_catedra 
        WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_sin_catedra1 = $conexion->prepare($query_eval_sin_catedra1);
        $resultado_eval_sin_catedra1->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_eval_sin_catedra1 = $resultado_eval_sin_catedra1->fetchAll(PDO::FETCH_ASSOC);


        //Consulta SQL para evaluacion por parte del decano
        $query_eval_decano = "SELECT e_decano_planta.* FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_decano = $conexion->prepare($query_eval_decano);
        $resultado_eval_decano->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_decano = $resultado_eval_decano->fetchAll(PDO::FETCH_ASSOC);

        //Consulta SQL para resultado evaluacion por parte del decano
        $query_eval_decano1 = "SELECT ROUND(SUM(CASE WHEN PREGUNTA1 = 'SI' THEN ((PREGUNTA2 * PREGUNTA3) / 100) ELSE 0 END + CASE WHEN PREGUNTA4 = 'SI' THEN ((PREGUNTA5 * PREGUNTA6) / 100) ELSE 0 END + CASE WHEN PREGUNTA7 = 'SI' THEN ((PREGUNTA8 * PREGUNTA9) / 100) ELSE 0 END + CASE WHEN PREGUNTA10 = 'SI' THEN ((PREGUNTA11 * PREGUNTA12) / 100) ELSE 0 END + CASE WHEN PREGUNTA13 = 'SI' THEN ((PREGUNTA14 * PREGUNTA15) / 100) ELSE 0 END + CASE WHEN PREGUNTA16 = 'SI' THEN ((PREGUNTA17 * PREGUNTA18) / 100) ELSE 0 END) / (SELECT COUNT(*) FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento AND (PREGUNTA1 = 'SI' OR PREGUNTA4 = 'SI' OR PREGUNTA7 = 'SI' OR PREGUNTA10 = 'SI' OR PREGUNTA13 = 'SI' OR PREGUNTA16 = 'SI')), 2) AS RESULTADO FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento";
        $resultado_eval_decano1 = $conexion->prepare($query_eval_decano1);
        $resultado_eval_decano1->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
        $data_decano1 = $resultado_eval_decano1->fetchAll(PDO::FETCH_ASSOC);


        //Creacion de PDF
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->SetTopMargin(0);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', '7.5');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(0, 8, utf8_decode('CASO 3: DOCENTE PLANTA - SIN CÁTEDRA'), 1, 1, 'C', true);
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
        $pdf->Cell(0, 8, utf8_decode('EVALUACIÓN POR PARTE DEL DECANO (70%)'), 1, 1, 'C', true);
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
        $pdf->Cell(40, 50, utf8_decode(ROUND(($data_decano1[0]['RESULTADO'] * 0.7), 2)), 0, 0, '');
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
        $pdf->Cell(40, 80, utf8_decode($data_decano1[0]['RESULTADO'] . ' (' . ROUND(($data_decano1[0]['RESULTADO'] * 0.7), 2) . ')'), 0, 0, '');
        $pdf->SetCol(0);
        $pdf->Ln(45);
        $pdf->SetFont('Arial', 'B', '7.5');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(0, 8, utf8_decode('AUTOEVALUACIÓN DEL DOCENTE (30%)'), 1, 0, 'C', true);
        $pdf->Ln();
        $header = array('Encuesta', 'Total Encuestas', 'Asistencia a Reuniones', 'Aporte al mejoramiento de contenido', 'Información oportuna del curso', 'Uso de TICs y otros recursos', 'Puntualidad en actividades académicas', 'Puntualidad en evaluación del curso', 'Ecuanimidad y respeto en el entorno', 'Cumplimiento en entrega de informes', 'TOTAL VALOR');
        $pdf->SetFont('Arial', 'B', '6.5');
        $pdf->SetWidths(array(13, 15, 16, 20, 20, 16, 20, 20, 20, 20, 12));
        $pdf->Row($header);

        $pdf->SetFont('Arial', '', '5.5');
        $pdf->Row(array($data_aecatedra[0]['ENCUESTA'], $data_aecatedra[0]['COUNT_ENCUESTA'], $data_eval_sin_catedra1[0]['P1'], $data_eval_sin_catedra1[0]['P2'], $data_eval_sin_catedra1[0]['P3'], $data_eval_sin_catedra1[0]['P4'], $data_eval_sin_catedra1[0]['P5'], $data_eval_sin_catedra1[0]['P6'], $data_eval_sin_catedra1[0]['P7'], $data_eval_sin_catedra1[0]['P8'], $data_eval_sin_catedra[0]['RESULTADO']));


        //Mostrar resultados consolidados de la evalucaion
        $altura_requerida = 90; // ajustar esta altura según sea necesario
        if ($pdf->GetY() + $altura_requerida > $pdf->GetPageHeight()) {
            $pdf->AddPage();
        }

        $pdf->Ln();
        $pdf->SetCol(0.55);
        $pdf->SetFont('Arial', 'B', '7.5');
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(120, 8, utf8_decode('RESULTADOS CONSOLIDADOS'), 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', '6.5');
        $pdf->Cell(40, 10, utf8_decode('EVALUACION POR PARTE DEL DECANO (70%) '), 0, 0, '');
        $pdf->SetFont('Arial', '', '6.5');
        $pdf->Cell(40);
        $pdf->Cell(50, 10, utf8_decode($data_decano1[0]['RESULTADO'] . "  " . "(" . ROUND(($data_decano1[0]['RESULTADO'] * 0.7), 2) . ")"), 0, 0, '');
        $pdf->Cell(40);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', '6.5');
        $pdf->Cell(40, 10, utf8_decode('AUTOEVALUACION (30%) '), 0, 0, '');
        $pdf->Cell(40);
        $pdf->SetFont('Arial', '', '6.5');
        $pdf->Cell(50, 10, utf8_decode($data_eval_sin_catedra[0]['RESULTADO'] . "  " . "(" . ROUND(($data_eval_sin_catedra[0]['RESULTADO'] * 0.3), 2) . ")"), 0, 0, 'L');
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', '6.5');
        $pdf->Cell(40, 10, utf8_decode('TOTAL PUNTOS '), 0, 0, '');
        $pdf->Cell(40);
        $pdf->SetFont('Arial', '', '6.5');
        $pdf->Cell(50, 10, utf8_decode(round((ROUND(($data_decano1[0]['RESULTADO'] * 0.7), 2) + ROUND(($data_eval_sin_catedra[0]['RESULTADO'] * 0.3), 2)), 2)), 0, 0, 'L');
        $pdf->Ln();

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


        $pdf->Output('F', 'C:/xampp/htdocs/evaluacion_docente/pdfs/FORMATOS CASO 3/' . $periodo_encuesta . '_' . $data_aecatedra[0]['FACULTAD'] . '-' . $data_aecatedra[0]['CARGO_DOCENTE'] . '_Cedula' . $documento . '_' . $data_aecatedra[0]['NOMBRE_DOCENTE'] . '.pdf');
    }
    continue;
}

?>

<script>alert('¡Todos los documentos fueron generados con exito!');</script>

<script>window.location.href = '/evaluacion_docente/dashboard/index.php';</script>

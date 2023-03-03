<?php
include_once 'plantilla.php';
include_once 'funciones.php';
include_once 'bd/conexion.php';
header("Content-type: application/pdf; charset=utf-8");
$funcion = new Functions_Aux();
$objeto = new Conexion();
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$query_aecatedra = "SELECT * from ae_docente_catedra";
//Ejecución de query data de aecatedra
$resultado_aecatedra = $conexion->prepare($query_aecatedra);
$resultado_aecatedra->execute();
$data_aecatedra = $resultado_aecatedra->fetchAll(PDO::FETCH_ASSOC);

//se debe setear SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));



$query_eval_estudiantes = "SELECT * , GRUPO, COUNT(GRUPO) as COUNT_ENC, ENCUESTA from e_estud WHERE DOCUMENTO_DOCENTE = :documento GROUP BY GRUPO";
$resultado_evalestud = $conexion->prepare($query_eval_estudiantes);
$resultado_evalestud->execute([':documento' => $data_aecatedra[0]['DOCUMENTO_DOCENTE']]);
$data_estudiantes = $resultado_evalestud->fetchAll(PDO::FETCH_ASSOC);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetTopMargin(0);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', '15');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('CASO 1: DOCENTE COMÚN'), 1, 1, 'C', true);
$pdf->Ln(1);
$pdf->Rect(10, 30, 190, 35);
$pdf->SetCol(0);
$pdf->SetLeftMargin(12);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(0, 10, utf8_decode('INSTITUCIÓN UNIVERSITARIA COLEGIO MAYOR DE ANTIOQUIA'), 0, 0, '');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '9');
//para extraer el periodo completo del reporte
$referencia_encuesta = explode("-", $data_aecatedra[0]['ENCUESTA']);
$periodo_encuesta = $referencia_encuesta[1] . "-" . $referencia_encuesta[2];
$pdf->Cell(0, 10, utf8_decode('EVALUACIÓN DE DESEMPEÑO PARA EL PERIODO: ' . $periodo_encuesta), 0, 0, '');
$pdf->Ln();
$pdf->Cell(40, 10, utf8_decode('NOMBRE DEL DOCENTE: '), 0, 0, '');
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['NOMBRE_DOCENTE']), 0, 0, '');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(40, 10, utf8_decode('CARGO: '), 0, 0, '');
$pdf->Cell(-25);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE']), 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(40, 10, utf8_decode('IDENTIFICACIÓN: '), 0, 0, '');
$pdf->Cell(-12);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[0]['DOCUMENTO_DOCENTE']), 0, 0, 'L');
$pdf->Ln();
$pdf->SetCol(0);
$pdf->SetFont('Arial', 'B', '12');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('EVALUACIÓN POR PARTE DEL DECANO (40%)'), 1, 1, 'C', true);
$pdf->Ln(2);
$pdf->Rect(10, 77, 190, 35);
$pdf->SetFont('Arial', 'B', '9');
$pdf->SetCol(0);
$pdf->SetLeftMargin(12);
$pdf->Cell(40, 10, utf8_decode('EVALUADOR: '), 0, 0, '');
$pdf->Cell(-18);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(50, 10, utf8_decode($data_aecatedra[79]['NOMBRE_DOCENTE']), 0, 0, '');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(40, 0, utf8_decode('DOCENTE: '), 0, 0, '');
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(-18);
$pdf->Cell(50, 0, utf8_decode($data_aecatedra[0]['NOMBRE_DOCENTE']), 0, 0, '');
$pdf->SetCol(1.3);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(40, -10, utf8_decode('DEP. DEL EVALUADOR: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(50, -10, utf8_decode($data_aecatedra[0]['FACULTAD']), 0, 0, '');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(40, 20, utf8_decode('DEP. DEL DOCENTE: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(50, 20, utf8_decode($data_aecatedra[0]['NOMBRE_DOCENTE']), 0, 0, '');
$pdf->SetCol(0.5);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(30, 30, utf8_decode('TIPO DOCENTE: '), 0, 0, '');
$pdf->Cell(-1);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(30, 30, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE']), 0, 0, '');
$pdf->SetCol(0.5);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(30, 40, utf8_decode('TOTAL: '), 0, 0, '');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(40, 40, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE']), 0, 0, '');
$pdf->SetCol(0.5);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(30, 50, utf8_decode('VALOR: '), 0, 0, '');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(40, 50, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE']), 0, 0, '');
$pdf->SetCol(1);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(30, 60, utf8_decode('FECHA: '), 0, 0, '');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(40, 60, utf8_decode($data_aecatedra[0]['FECHA_DILIGENCIAMIENTO']), 0, 0, '');
$pdf->SetCol(0);
$pdf->SetFont('Arial', 'B', '9');
$pdf->Cell(40, 80, utf8_decode('VALOR FINAL: '), 0, 0, '');
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(-15);
$pdf->SetFont('Arial', '', '9');
$pdf->Cell(40, 80, utf8_decode($data_aecatedra[0]['CARGO_DOCENTE'] . ' (' . $data_aecatedra[0]['CARGO_DOCENTE'] . ')'), 0, 0, '');
$pdf->SetCol(0);
$pdf->Ln(45);
$pdf->SetFont('Arial', 'B', '12');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('AUTOEVALUACIÓN DEL DOCENTE (20%)'), 1, 0, 'C', true);
$pdf->Ln();
$header = array('Encuesta', 'Dominio de la disciplina', 'Gestión de la Asignatura', 'Ambientes y Estrategias de Aprendizaje', 'Motivación', 'Evaluación', 'Comunicación y Relación con los estudiantes', 'TOTAL', 'VALOR');
$pdf->SetFont('Arial', 'B', '8');
$pdf->SetWidths(array(30, 15, 21, 25, 18, 18, 25, 18, 25, 12, 12));
$pdf->Row($header);

//suma de primer factor a evaluar - Dominio disciplina
$dominio_disc = $funcion->promedio_valores_preguntas($data_aecatedra[0], 1, 6, 'aecatedra');
//suma de segundo factor a evaluar - Gestión de la asignatura
$gestion_asig = $funcion->promedio_valores_preguntas($data_aecatedra[0], 7, 10, 'aecatedra');
//suma de segundo factor a evaluar - Ambiente y estrategias
$ambiente_est = $funcion->promedio_valores_preguntas($data_aecatedra[0], 11, 15, 'aecatedra');
//suma de segundo factor a evaluar - Motivación
$motivacion = $funcion->promedio_valores_preguntas($data_aecatedra[0], 16, 20, 'aecatedra');
//suma de segundo factor a evaluar - Evaluacion
$evaluacion = $funcion->promedio_valores_preguntas($data_aecatedra[0], 21, 26, 'aecatedra');
//suma de segundo factor a evaluar - Comunicación
$comunicacion = $funcion->promedio_valores_preguntas($data_aecatedra[0], 27, 31, 'aecatedra');
$valores = array($dominio_disc, $gestion_asig, $ambiente_est, $motivacion, $evaluacion, $comunicacion);
$promedio_valores = round(array_sum($valores) / count($valores), 2);
$valor_base_porcentaje = $promedio_valores * 0.2;
$autoevaluacion_completa = array($data_aecatedra[0]['ENCUESTA'], strval($dominio_disc), $gestion_asig, $ambiente_est, $motivacion, $evaluacion, $comunicacion, $promedio_valores, $valor_base_porcentaje);

$pdf->SetFont('Arial', '', '8');
$pdf->Row($autoevaluacion_completa);

$pdf->Ln();
$pdf->SetFont('Arial', 'B', '12');
$pdf->SetFillColor(232, 232, 232);
$pdf->Cell(0, 8, utf8_decode('EVALUACIÓN POR PARTE DE ESTUDIANTES (40%)'), 1, 0, 'C', true);
$pdf->Ln();
$header = array('Grupo', 'Encuesta', 'Encuestas diligenciadas', 'Gestión de la Asignatura', 'Ambientes y Estrategias de Aprendizaje', 'Motivación', 'Evaluación', 'Comunicación y Relación con los estudiantes', 'TOTAL', 'VALOR');
$pdf->SetFont('Arial', 'B', '8');
$pdf->SetWidths(array(20, 15, 21, 18, 25, 18, 18, 25, 18, 12));
$pdf->Row($header);
$pdf->Ln();
$pdf->SetFont('Arial', '', '8');
$pdf->SetWidths(array(20, 15, 21, 18, 25, 18, 18, 25, 18, 12));


/*

//suma de segundo factor a evaluar - Gestión de la asignatura
$gestion = $funcion->promedio_valores_preguntas_estudiantes($data_estudiantes[0], 7, 10, 'estud');
//suma de segundo factor a evaluar - Ambiente y estrategias
$ambiente = $funcion->promedio_valores_preguntas_estudiantes($data_estudiantes[0], 11, 15, 'estud');
//suma de segundo factor a evaluar - Motivación
$motivacion_est = $funcion->promedio_valores_preguntas_estudiantes($data_estudiantes[0], 16, 20, 'estud');
//suma de segundo factor a evaluar - Evaluacion
$evaluacion_est = $funcion->promedio_valores_preguntas_estudiantes($data_estudiantes[0], 21, 26, 'estud');
//suma de segundo factor a evaluar - Comunicación
$comunicacion_est = $funcion->promedio_valores_preguntas_estudiantes($data_estudiantes[0], 27, 31, 'estud');
$valores = array($gestion, $ambiente, $motivacion_est, $evaluacion_est, $comunicacion_est);
$promedio_valores_est = round(array_sum($valores_est) / count($valores_est), 2);
$valor_base_porcentaje_est = $promedio_valores_est * 0.2;
$evaluacion_completa_est = array($gestion, $ambiente, $motivacion_est, $evaluacion_est, $comunicacion_est, $promedio_valores_est, $valor_base_porcentaje_est);

*/

for ($i = 0; $i < count($data_estudiantes); $i++) {

    $pdf->Row(array($data_estudiantes[$i]['GRUPO'], $data_estudiantes[$i]['ENCUESTA'], $data_estudiantes[$i]['COUNT_ENC'], $gestion_asig, $ambiente_est, $motivacion, $evaluacion, $comunicacion, $promedio_valores, $valor_base_porcentaje)) . "<br>";
    $pdf->Ln();
    $pdf->Ln();

    

}



$pdf->Output();

?>
<?php 

include_once 'bd/conexion.php';
header("Content-type: application/pdf; charset=utf-8");
$funcion = new Functions_Aux();
$objeto = new Conexion();
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$query_aecatedra = "UPDATE e_estud SET PREGUNTA1,PREGUNTA2,PREGUNTA3 = 5 WHERE PREGUNTA1 = 'a. Totalmente de acuerdo'";
//Ejecución de query data de aecatedra
$resultado_aecatedra = $conexion->prepare($query_aecatedra);
$resultado_aecatedra->execute();
$data_aecatedra = $resultado_aecatedra->fetchAll(PDO::FETCH_ASSOC);




?>
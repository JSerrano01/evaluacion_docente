<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'cargar_ae_doc_cat'){
	//parametro 1 para autoevaluación de docentes de cátedra
	$cargar = $crud->cargar_data(1);
	if($cargar)
		echo $cargar;
}
if($action == 'cargar_ae_doc_sin_cat'){
	//parametro 2 para autoevaluación de docentes sin cátedra
	$cargar = $crud->cargar_data(2);
	if($cargar)
		echo $cargar;
}
if($action == 'cargar_e_dec_cat'){
	//parametro 3 para evaluación de decano a docentes cátedra.
	$cargar = $crud->cargar_data(3);
	if($cargar)
		echo $cargar;
}
if($action == 'cargar_e_dec_planta'){
	//parametro 4 para evaluación de decano a docentes planta.
	$cargar = $crud->cargar_data(4);
	if($cargar)
		echo $cargar;
}
if($action == 'cargar_e_estud'){
	//parametro 5 para evaluación de estudiantes a docentes.
	$cargar = $crud->cargar_data(5);
	if($cargar)
		echo $cargar;
}
ob_end_flush();
?>
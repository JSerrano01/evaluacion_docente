<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'cargar_ae_doc_cat'){
	$cargar = $crud->cargar_ae_doc_cat();
	if($cargar)
		echo $cargar;
}

ob_end_flush();
?>
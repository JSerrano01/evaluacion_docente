<?php
session_start();
ini_set('display_errors', 1);
$log_file = "./my-errors.log";
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include '../bd/conexion.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}
	function cargar_ae_doc_cat(){
		#$array=json_decode($_POST['datos']);
		$dato = $_POST['datos'];
		return 1;
		/*
		$firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : '';
		$lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : '';
		$middlename = (isset($_POST['middlename'])) ? $_POST['middlename'] : '';
		$contact = (isset($_POST['contact'])) ? $_POST['contact'] : '';
		$address = (isset($_POST['address'])) ? $_POST['address'] : '';
		$email = (isset($_POST['email'])) ? $_POST['email'] : '';
		$password = (isset($_POST['password'])) ? $_POST['password'] : '';
		$type = (isset($_POST['type'])) ? $_POST['type'] : '';

		$check = $this->db->prepare("SELECT * FROM users where email = ?");
		$check->bind_param('s', $email);
		$check->execute();
		$check->store_result();
		if($check->num_rows > 0){
			return 2;
			exit;
		}
		else{
			$save = $this->db->prepare("INSERT INTO users (firstname, lastname, middlename, contact, address, email, password, type) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
			$save->bind_param('sssssssi', $firstname, $lastname, $middlename, $contact, $address, $email, $password, $type);
			$save->execute();
			if($save){
				return 1;
			}
		}*/
	}
}
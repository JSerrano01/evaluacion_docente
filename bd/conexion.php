<?php
 class Conexion{
     public static function Conectar(){
        //  define('servidor','10.3.1.110:3306');
         define('servidor','localhost');
        //  define('nombre_bd','evaluacion_docente');
         define('nombre_bd','evaluacion_docente1');
         define('usuario','root');
        //  define('password','WNeqRzh!nHrfA9d**K!^');   
         define('password','');      
         $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4');
         
         try{
            $conexion = new PDO("mysql:host=".servidor.";dbname=".nombre_bd, usuario, password, $opciones);             
            return $conexion; 
         }catch (Exception $e){
             die("El error de Conexión es :".$e->getMessage());
         }         
     }
     
 }
?>
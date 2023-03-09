<?php 

include_once 'bd/conexion.php';
header("Content-type: application/pdf; charset=utf-8");
$funcion = new Functions_Aux();
$objeto = new Conexion();
$objeto = new Conexion();
$conexion = $objeto->Conectar();
//Se hace la consulta en la base de datos

$sql = "UPDATE e_estud SET PREGUNTA1 = CASE
        WHEN PREGUNTA1 = 'a. Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA1 = 'b. De acuerdo' THEN 4
        WHEN PREGUNTA1 = 'c. Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA1 = 'd. En desacuerdo' THEN 2
        WHEN PREGUNTA1 = 'e. Totalmente de desacuerdo' THEN 1
        
    END";
/*
$sql2 = "UPDATE e_estud SET PREGUNTA2 = CASE
        WHEN PREGUNTA2 = 'a. Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA2 = 'b. De acuerdo' THEN 4
        WHEN PREGUNTA2 = 'c. Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA2 = 'd. En desacuerdo' THEN 2
        WHEN PREGUNTA2 = 'e. Totalmente de desacuerdo' THEN 1
        
    END";

$sql3 = "UPDATE e_estud SET PREGUNTA3 = CASE
        WHEN PREGUNTA3 = 'a. Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA3 = 'b. De acuerdo' THEN 4
        WHEN PREGUNTA3 = 'c. Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA3 = 'd. En desacuerdo' THEN 2
        WHEN PREGUNTA3 = 'e. Totalmente de desacuerdo' THEN 1
        
    END";
    */

$sql4 = "UPDATE e_estud SET PREGUNTA4 = CASE
WHEN PREGUNTA4 = 'a. Totalmente de acuerdo' THEN 5
WHEN PREGUNTA4 = 'b. De acuerdo' THEN 4
WHEN PREGUNTA4 = 'c. Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA4 = 'd. En desacuerdo' THEN 2
WHEN PREGUNTA4 = 'e. Totalmente de desacuerdo' THEN 1

END";

$sql5 = "UPDATE e_estud SET PREGUNTA5 = CASE
        WHEN PREGUNTA5 = 'a. Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA5 = 'b. De acuerdo' THEN 4
        WHEN PREGUNTA5 = 'c. Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA5 = 'd. En desacuerdo' THEN 2
        WHEN PREGUNTA5 = 'e. Totalmente de desacuerdo' THEN 1
        
    END";

$sql6 = "UPDATE e_estud SET PREGUNTA6 = CASE
WHEN PREGUNTA6 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA6 = 'De acuerdo' THEN 4
WHEN PREGUNTA6 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA6 = 'En desacuerdo' THEN 2
WHEN PREGUNTA6 = 'Totalmente de desacuerdo' THEN 1

END";

$sql7 = "UPDATE e_estud SET PREGUNTA7 = CASE
        WHEN PREGUNTA7 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA7 = 'De acuerdo' THEN 4
        WHEN PREGUNTA7 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA7 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA7 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql8 = "UPDATE e_estud SET PREGUNTA8 = CASE
WHEN PREGUNTA8 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA8 = 'De acuerdo' THEN 4
WHEN PREGUNTA8 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA8 = 'En desacuerdo' THEN 2
WHEN PREGUNTA8 = 'Totalmente de desacuerdo' THEN 1

END";

$sql9 = "UPDATE e_estud SET PREGUNTA9 = CASE
        WHEN PREGUNTA9 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA9 = 'De acuerdo' THEN 4
        WHEN PREGUNTA9 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA9 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA9 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql10 = "UPDATE e_estud SET PREGUNTA10 = CASE
WHEN PREGUNTA10 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA10 = 'De acuerdo' THEN 4
WHEN PREGUNTA10 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA10= 'En desacuerdo' THEN 2
WHEN PREGUNTA10 = 'Totalmente de desacuerdo' THEN 1

END";

$sql11 = "UPDATE e_estud SET PREGUNTA11 = CASE
        WHEN PREGUNTA11 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA11 = 'De acuerdo' THEN 4
        WHEN PREGUNTA11 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA11 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA11 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql12 = "UPDATE e_estud SET PREGUNTA12 = CASE
WHEN PREGUNTA12 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA12 = 'De acuerdo' THEN 4
WHEN PREGUNTA12 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA12 = 'En desacuerdo' THEN 2
WHEN PREGUNTA12 = 'Totalmente de desacuerdo' THEN 1

END";

$sql13 = "UPDATE e_estud SET PREGUNTA13 = CASE
        WHEN PREGUNTA13 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA13 = 'De acuerdo' THEN 4
        WHEN PREGUNTA13 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA13 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA13 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql14 = "UPDATE e_estud SET PREGUNTA14 = CASE
WHEN PREGUNTA14 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA14 = 'De acuerdo' THEN 4
WHEN PREGUNTA14 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA14 = 'En desacuerdo' THEN 2
WHEN PREGUNTA14 = 'Totalmente de desacuerdo' THEN 1

END";

$sql15 = "UPDATE e_estud SET PREGUNTA15 = CASE
        WHEN PREGUNTA15 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA15 = 'De acuerdo' THEN 4
        WHEN PREGUNTA15 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA15 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA15 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql16 = "UPDATE e_estud SET PREGUNTA16 = CASE
WHEN PREGUNTA16 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA16 = 'De acuerdo' THEN 4
WHEN PREGUNTA16 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA16 = 'En desacuerdo' THEN 2
WHEN PREGUNTA16 = 'Totalmente de desacuerdo' THEN 1

END";

$sql17 = "UPDATE e_estud SET PREGUNTA17 = CASE
        WHEN PREGUNTA17 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA17 = 'De acuerdo' THEN 4
        WHEN PREGUNTA17 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA17 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA17 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql18 = "UPDATE e_estud SET PREGUNTA18 = CASE
WHEN PREGUNTA18 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA18 = 'De acuerdo' THEN 4
WHEN PREGUNTA18 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA18 = 'En desacuerdo' THEN 2
WHEN PREGUNTA18 = 'Totalmente de desacuerdo' THEN 1

END";

$sql19 = "UPDATE e_estud SET PREGUNTA19 = CASE
        WHEN PREGUNTA19 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA19 = 'De acuerdo' THEN 4
        WHEN PREGUNTA19 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA19 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA19 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql20 = "UPDATE e_estud SET PREGUNTA20 = CASE
WHEN PREGUNTA20 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA20 = 'De acuerdo' THEN 4
WHEN PREGUNTA20 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA20 = 'En desacuerdo' THEN 2
WHEN PREGUNTA20 = 'Totalmente de desacuerdo' THEN 1

END";

$sql21 = "UPDATE e_estud SET PREGUNTA21 = CASE
        WHEN PREGUNTA21 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA21 = 'De acuerdo' THEN 4
        WHEN PREGUNTA21 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA21 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA21 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql22 = "UPDATE e_estud SET PREGUNTA22 = CASE
WHEN PREGUNTA22 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA22 = 'De acuerdo' THEN 4
WHEN PREGUNTA22 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA22 = 'En desacuerdo' THEN 2
WHEN PREGUNTA22 = 'Totalmente de desacuerdo' THEN 1

END";

$sql23 = "UPDATE e_estud SET PREGUNTA23 = CASE
        WHEN PREGUNTA23 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA23 = 'De acuerdo' THEN 4
        WHEN PREGUNTA23 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA23 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA23 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql24 = "UPDATE e_estud SET PREGUNTA24 = CASE
WHEN PREGUNTA24 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA24 = 'De acuerdo' THEN 4
WHEN PREGUNTA24 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA24 = 'En desacuerdo' THEN 2
WHEN PREGUNTA24 = 'Totalmente de desacuerdo' THEN 1

END";

$sql25 = "UPDATE e_estud SET PREGUNTA25 = CASE
        WHEN PREGUNTA25 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA25 = 'De acuerdo' THEN 4
        WHEN PREGUNTA25 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA25 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA25 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql26 = "UPDATE e_estud SET PREGUNTA26 = CASE
WHEN PREGUNTA26 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA26 = 'De acuerdo' THEN 4
WHEN PREGUNTA26 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA26 = 'En desacuerdo' THEN 2
WHEN PREGUNTA26 = 'Totalmente de desacuerdo' THEN 1

END";

$sql27 = "UPDATE e_estud SET PREGUNTA27 = CASE
        WHEN PREGUNTA27 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA27 = 'De acuerdo' THEN 4
        WHEN PREGUNTA27 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA27 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA27 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql28 = "UPDATE e_estud SET PREGUNTA28 = CASE
WHEN PREGUNTA28 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA28 = 'De acuerdo' THEN 4
WHEN PREGUNTA28 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA28 = 'En desacuerdo' THEN 2
WHEN PREGUNTA28 = 'Totalmente de desacuerdo' THEN 1

END";

$sql29 = "UPDATE e_estud SET PREGUNTA29 = CASE
        WHEN PREGUNTA29 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA29 = 'De acuerdo' THEN 4
        WHEN PREGUNTA29 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA29 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA29 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql30 = "UPDATE e_estud SET PREGUNTA30 = CASE
WHEN PREGUNTA30 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA30 = 'De acuerdo' THEN 4
WHEN PREGUNTA30 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA30 = 'En desacuerdo' THEN 2
WHEN PREGUNTA30 = 'Totalmente de desacuerdo' THEN 1

END";

$sql31 = "UPDATE e_estud SET PREGUNTA31 = CASE
        WHEN PREGUNTA31 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA31 = 'De acuerdo' THEN 4
        WHEN PREGUNTA31 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA31 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA31 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql32 = "UPDATE e_estud SET PREGUNTA32 = CASE
WHEN PREGUNTA32 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA32 = 'De acuerdo' THEN 4
WHEN PREGUNTA32 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA32 = 'En desacuerdo' THEN 2
WHEN PREGUNTA32 = 'Totalmente de desacuerdo' THEN 1

END";

$sql33 = "UPDATE e_estud SET PREGUNTA33 = CASE
        WHEN PREGUNTA33 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA33 = 'De acuerdo' THEN 4
        WHEN PREGUNTA33 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA33 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA33 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql34 = "UPDATE e_estud SET PREGUNTA34 = CASE
WHEN PREGUNTA34 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA34 = 'De acuerdo' THEN 4
WHEN PREGUNTA34 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA34 = 'En desacuerdo' THEN 2
WHEN PREGUNTA34 = 'Totalmente de desacuerdo' THEN 1

END";

$sql35 = "UPDATE e_estud SET PREGUNTA35 = CASE
        WHEN PREGUNTA35 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA35 = 'De acuerdo' THEN 4
        WHEN PREGUNTA35 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA35 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA35 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql36 = "UPDATE e_estud SET PREGUNTA36 = CASE
WHEN PREGUNTA36 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA36 = 'De acuerdo' THEN 4
WHEN PREGUNTA36 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA36 = 'En desacuerdo' THEN 2
WHEN PREGUNTA36 = 'Totalmente de desacuerdo' THEN 1

END";

$sql37 = "UPDATE e_estud SET PREGUNTA37 = CASE
        WHEN PREGUNTA37 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA37 = 'De acuerdo' THEN 4
        WHEN PREGUNTA37 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA37 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA37 = 'Totalmente de desacuerdo' THEN 1
        
    END";

$sql38 = "UPDATE e_estud SET PREGUNTA38 = CASE
WHEN PREGUNTA38 = 'Totalmente de acuerdo' THEN 5
WHEN PREGUNTA38 = 'De acuerdo' THEN 4
WHEN PREGUNTA38 = 'Ni de acuerdo ni en desacuerdo' THEN 3
WHEN PREGUNTA38 = 'En desacuerdo' THEN 2
WHEN PREGUNTA38 = 'Totalmente de desacuerdo' THEN 1

END";

$sql39 = "UPDATE e_estud SET PREGUNTA39 = CASE
        WHEN PREGUNTA39 = 'Totalmente de acuerdo' THEN 5
        WHEN PREGUNTA39 = 'De acuerdo' THEN 4
        WHEN PREGUNTA39 = 'Ni de acuerdo ni en desacuerdo' THEN 3
        WHEN PREGUNTA39 = 'En desacuerdo' THEN 2
        WHEN PREGUNTA39 = 'Totalmente de desacuerdo' THEN 1
        
    END";



$resultado = mysqli_query($conn, $sql);
//$resultado2 = mysqli_query($conn, $sql2);
//$resultado3 = mysqli_query($conn, $sql3);
$resultado4 = mysqli_query($conn, $sql4);
$resultado5 = mysqli_query($conn, $sql5);
$resultado6 = mysqli_query($conn, $sql6);
$resultado7 = mysqli_query($conn, $sql7);
$resultado8 = mysqli_query($conn, $sql8);
$resultado9 = mysqli_query($conn, $sql9);
$resultado10 = mysqli_query($conn, $sql10);
$resultado11 = mysqli_query($conn, $sql11);
$resultado12 = mysqli_query($conn, $sql12);
$resultado13 = mysqli_query($conn, $sql13);
$resultado14 = mysqli_query($conn, $sql14);
$resultado15 = mysqli_query($conn, $sql15);
$resultado16 = mysqli_query($conn, $sql16);
$resultado17 = mysqli_query($conn, $sql17);
$resultado18 = mysqli_query($conn, $sql18);
$resultado19 = mysqli_query($conn, $sql19);
$resultado20 = mysqli_query($conn, $sql20);
$resultado21 = mysqli_query($conn, $sql21);
$resultado22 = mysqli_query($conn, $sql22);
$resultado23 = mysqli_query($conn, $sql23);
$resultado24 = mysqli_query($conn, $sql24);
$resultado25 = mysqli_query($conn, $sql25);
$resultado26 = mysqli_query($conn, $sql26);
$resultado27 = mysqli_query($conn, $sql27);
$resultado28 = mysqli_query($conn, $sql28);
$resultado29 = mysqli_query($conn, $sql29);
$resultado30 = mysqli_query($conn, $sql30);
$resultado31 = mysqli_query($conn, $sql31);
$resultado32 = mysqli_query($conn, $sql32);
$resultado33 = mysqli_query($conn, $sql33);
$resultado34 = mysqli_query($conn, $sql34);
$resultado35 = mysqli_query($conn, $sql35);
$resultado36 = mysqli_query($conn, $sql36);
$resultado37 = mysqli_query($conn, $sql37);
$resultado38 = mysqli_query($conn, $sql38);
$resultado39 = mysqli_query($conn, $sql39);


header('Location: 1.php');

?>
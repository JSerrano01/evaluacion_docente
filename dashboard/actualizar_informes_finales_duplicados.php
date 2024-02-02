    <?php

    //----------------------------- CAMBIAR CONEXION A BASE DE DATOS CADA VEZ QUE SE VAYAN A HACER CAMBIOS ------------------------------------------------

    $servername = "10.3.1.110:3306";
    $username = "root";
    $password = "WNeqRzh!nHrfA9d**K!^";
    $dbname = "evaluacion_docente";

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "evaluacion_docente1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $pdo = new PDO('mysql:host=10.3.1.110:3306;dbname=evaluacion_docente', 'root', 'WNeqRzh!nHrfA9d**K!^');

    // $pdo = new PDO('mysql:host=localhost;dbname=evaluacion_docente1', 'root', '');

    // //----------------------------- CAMBIAR CONEXION A BASE DE DATOS CADA VEZ QUE SE VAYAN A HACER CAMBIOS ------------------------------------------------

    //-----------------------------------------------------------------------------------------------------------------------------------------

    include_once '../bd/conexion.php';

    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    // Primera consulta: obtener todos los documentos docente de todas las tablas
    $sql_docentes = "SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_catedra
                UNION 
                SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_sin_catedra
                UNION 
                SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_catedra
                UNION 
                SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_planta
                UNION 
                SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_estud";

    $consulta_docentes = $conexion->prepare($sql_docentes);
    $consulta_docentes->execute();

    // Almacenar los resultados en un array
    $docentes_array = $consulta_docentes->fetchAll(PDO::FETCH_ASSOC);

    // Lista para almacenar documentos duplicados
    $documentos_duplicados = array();

    // Verificar documentos duplicados en ambas tablas
    foreach ($docentes_array as $docente) {
        $documento = $docente['DOCUMENTO_DOCENTE'];

        $sql = "SELECT 1
            FROM e_decano_catedra c
            INNER JOIN e_decano_planta p ON c.DOCUMENTO_DOCENTE = p.DOCUMENTO_DOCENTE
            WHERE c.DOCUMENTO_DOCENTE = :documento";

        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(':documento', $documento, PDO::PARAM_INT);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            // El documento existe en ambas tablas
            $documentos_duplicados[] = $documento;
        }
    }

    // Segunda consulta: Obtener toda la información de los documentos duplicados
    if (!empty($documentos_duplicados)) {
        $documentos_duplicados_str = implode(',', array_fill(0, count($documentos_duplicados), '?'));

        $sql_duplicados = "SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM (
                        SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_catedra
                        UNION 
                        SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_sin_catedra
                        UNION 
                        SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_catedra
                        UNION 
                        SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_planta
                        UNION 
                        SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_estud
                    ) AS t
                    WHERE DOCUMENTO_DOCENTE IN ($documentos_duplicados_str)";

        $consulta_duplicados = $conexion->prepare($sql_duplicados);
        $consulta_duplicados->execute($documentos_duplicados);
    }

    //-------------------------------------------------------------------------AGREGAR A INFORME CON NOTA DECANO CATEDRA----------------------------------------------------------------


    $i = 0;

    set_time_limit(180); // 300 segundos (5 minutos)

    foreach ($documentos_duplicados as $documento) {

        $query_eval_estudiantes = "SELECT 
    ROUND(AVG(((PREGUNTA1 + PREGUNTA4 + PREGUNTA5 + PREGUNTA6 + PREGUNTA7+ PREGUNTA8+ PREGUNTA9+ PREGUNTA10+ PREGUNTA11) / 9)),2) AS gestion_asig,
    ROUND(AVG(((PREGUNTA12 + PREGUNTA13 + PREGUNTA14 + PREGUNTA15) / 4) ),2) AS ambiente_asig,
    ROUND(AVG(((PREGUNTA16 + PREGUNTA17 + PREGUNTA18 + PREGUNTA19 + PREGUNTA20) / 5)),2) AS motivacion_asig,
    ROUND(AVG(((PREGUNTA21 + PREGUNTA22 + PREGUNTA23 + PREGUNTA24 + PREGUNTA25) / 5)),1) AS evaluacion_asig,
    ROUND(AVG(((PREGUNTA26 + PREGUNTA27 + PREGUNTA28 + PREGUNTA29 + PREGUNTA30 + PREGUNTA31 + PREGUNTA32 + PREGUNTA33 + PREGUNTA34 + PREGUNTA35 + PREGUNTA36 + PREGUNTA37 + PREGUNTA38 + PREGUNTA39) / 14)),2) AS comunicacion_asig
    FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento";

        $stmt = $pdo->prepare($query_eval_estudiantes);
        $stmt->bindParam(':documento', $documento);


        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado_estud = $stmt->fetch(PDO::FETCH_ASSOC);


        // Consulta SQL
        $query_eval_decano2 = "SELECT 
        ROUND((
            CASE 
                WHEN PREGUNTA1 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA1 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA1 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA1 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA1 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA2 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA2 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA2 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA2 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA2 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA3 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA3 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA3 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA3 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA3 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA4 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA4 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA4 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA4 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA4 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA5 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA5 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA5 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA5 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA5 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA6 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA6 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA6 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA6 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA6 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA7 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA7 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA7 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA7 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA7 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA8 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA8 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA8 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA8 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA8 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END )/8 ,
            2
        ) AS RESULTADO
    FROM e_decano_catedra 
    WHERE DOCUMENTO_DOCENTE = :documento";


        // Preparar la consulta
        $stmt2 = $pdo->prepare($query_eval_decano2);
        $stmt2->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt2->execute();

        // Obtener el resultado
        $resultado_dec_cat = $stmt2->fetchColumn();


        // Consulta SQL
        $query_ae_sin_catedra = "SELECT 
        ROUND((
            CASE 
                WHEN PREGUNTA1 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA1 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA1 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA1 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA1 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA2 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA2 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA2 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA2 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA2 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA3 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA3 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA3 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA3 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA3 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA4 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA4 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA4 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA4 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA4 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA5 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA5 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA5 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA5 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA5 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA6 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA6 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA6 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA6 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA6 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA7 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA7 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA7 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA7 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA7 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA8 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA8 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA8 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA8 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA8 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END )/8 ,
            2
        ) AS RESULTADO
    FROM ae_docente_sin_catedra 
    WHERE DOCUMENTO_DOCENTE = :documento";


        // Preparar la consulta
        $stmt_ae_sin_catedra = $pdo->prepare($query_ae_sin_catedra);
        $stmt_ae_sin_catedra->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_ae_sin_catedra->execute();

        // Obtener el resultado
        $resultado_ae_sin_catedra = $stmt_ae_sin_catedra->fetchColumn();


        $total = 0;

        for ($j = 1; $j <= 31; $j++) {
            $pregunta = "PREGUNTA" . $j;

            // Consulta SQL
            $query = "SELECT 
                ROUND((CASE 
                    WHEN $pregunta = 'Totalmente de acuerdo' THEN 5 
                    WHEN $pregunta = 'De acuerdo' THEN 4 
                    WHEN $pregunta = 'Ni de acuerdo ni en desacuerdo' THEN 3
                    WHEN $pregunta = 'En desacuerdo' THEN 2
                    WHEN $pregunta = 'Totalmente de desacuerdo' THEN 1
                END), 2) AS RESULTADO
                FROM ae_docente_catedra 
                WHERE DOCUMENTO_DOCENTE = :documento";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':documento', $documento);
            $stmt->execute();

            $result = $stmt->fetchColumn(); // Obtener el valor del resultado

            $total += $result;

            $stmt->closeCursor();
        }

        $tot = round($total / 31, 2);

        $eval_estud_total = round(($resultado_estud['gestion_asig'] + $resultado_estud['ambiente_asig'] + $resultado_estud['motivacion_asig'] + $resultado_estud['evaluacion_asig'] + $resultado_estud['comunicacion_asig']) / 5, 2);

        // Consulta SQL
        $query_docente = "SELECT NOMBRE_DOCENTE FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento;";


        // Preparar la consulta
        $stmt_docente = $pdo->prepare($query_docente);
        $stmt_docente->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_docente->execute();

        // Obtener el resultado
        $resultado_docente = $stmt_docente->fetchColumn();

        $query_docente = "SELECT FACULTAD FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento;";


        // Preparar la consulta
        $stmt_facultad = $pdo->prepare($query_docente);
        $stmt_facultad->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_facultad->execute();

        // Obtener el resultado
        $resultado_facultad = $stmt_facultad->fetchColumn();

        $query_docente = "SELECT CARGO_DOCENTE FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT CARGO_DOCENTE FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT CARGO_DOCENTE FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT CARGO_DOCENTE FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION
                SELECT CARGO_DOCENTE FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento;";


        // Preparar la consulta
        $stmt_nomina = $pdo->prepare($query_docente);
        $stmt_nomina->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_nomina->execute();

        // Obtener el resultado
        $resultado_nomina = $stmt_nomina->fetchColumn();


        $query_encuesta = "SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento ";


        // Preparar la consulta
        $stmt_encuesta = $pdo->prepare($query_encuesta);
        $stmt_encuesta->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_encuesta->execute();

        // Obtener el resultado
        $resultado_encuesta = $stmt_encuesta->fetchColumn();

        //Generador de nota final
        $valid_count = 0;

        //-----------------------------VERIFICA SI ES EVALUACION CASO 3------------------------------------------


        if (!empty($resultado_ae_sin_catedra) && $resultado_ae_sin_catedra != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0) {
            $total_ae_sin = round($resultado_ae_sin_catedra * 0.3, 2);
            $total_decano_planta = round($resultado_dec_planta * 0.7, 2);
            $valid_count++;
        } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
            $ae_total = round($tot * 0.3, 2);
            $total_decano_planta = round($resultado_dec_planta * 0.7, 2);
            $valid_count++;
        } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_cat) && $resultado_dec_cat != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
            $total_tot = round($tot * 0.3, 2);
            $total_decano_catedra = round($resultado_dec_cat * 0.7, 2);
            $valid_count++;
        } else {
            // Verificar resultado_dec_planta
            if (!empty($resultado_dec_planta) && $resultado_dec_planta != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                $total_decano_planta = round($resultado_dec_planta * 0.4, 2);
                $estud_total = round($eval_estud_total * 0.4, 2);
                $ae_total = round($tot * 0.2, 2);
                $valid_count++;
            } elseif (!empty($resultado_dec_cat) && $resultado_dec_cat != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                $total_decano_catedra = round($resultado_dec_cat * 0.4, 2);
                $estud_total = round($eval_estud_total * 0.4, 2);
                $ae_total = round($tot * 0.2, 2);
                $valid_count++;
            }
        }


        $resultado_nota_final = 0;

        // Realizar división si hay variables válidas
        if ($valid_count > 0) {

            if (!empty($resultado_ae_sin_catedra) && $resultado_ae_sin_catedra != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0) {
                $resultado_nota_final += $total_ae_sin;
                $resultado_nota_final += $total_decano_planta;
            } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
                $resultado_nota_final += $ae_total;
                $resultado_nota_final += $total_decano_planta;
            } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_cat) && $resultado_dec_cat != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
                $resultado_nota_final += $total_tot;
                $resultado_nota_final += $total_decano_catedra;
            } else {
                // Verificar resultado_dec_planta
                if (!empty($resultado_dec_planta) && $resultado_dec_planta != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                    $resultado_nota_final += $total_decano_planta;
                    $resultado_nota_final += $estud_total;
                    $resultado_nota_final += $ae_total;
                } elseif (!empty($resultado_dec_cat) && $resultado_dec_cat != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                    $resultado_nota_final += $total_decano_catedra;
                    $resultado_nota_final += $estud_total;
                    $resultado_nota_final += $ae_total;
                }
            }
        }



        $resultado_nota_final = round($resultado_nota_final, 3);

        $resultado_dec_planta = "";

        // Almacenar los valores en el arreglo bidimensional
        $resultado_valores = array(
            $i++,
            $documento,
            $resultado_docente,
            $resultado_facultad,
            $resultado_nomina,
            $resultado_encuesta,
            $resultado_dec_planta,
            $resultado_dec_cat,
            $eval_estud_total,
            $tot,
            $resultado_ae_sin_catedra,
            $resultado_nota_final
        );

        $resultados_valores[] = $resultado_valores; // Agregar el resultado al arreglo bidimensional

        $stmt->closeCursor();
        //$stmt1->closeCursor();
        $stmt2->closeCursor();
        $stmt_docente->closeCursor();
        $stmt_facultad->closeCursor();
        $stmt_nomina->closeCursor();
        $resultado_nota_final = 0;
        $resultado_dec_planta = 0;
        $resultado_dec_cat = 0;
        $resultado_ae_sin_catedra = 0;
        $tot = 0;
        $eval_estud_total = 0;
        $total_decano_catedra = 0;
        $estud_total = 0;
        $ae_total = 0;
        $total_decano_planta = 0;
        $total_ae_sin = 0;
    }


    // Consulta SQL para truncar la tabla
    $sql_truncate = "TRUNCATE TABLE informes_finales_duplicados";

    // Ejecutar la consulta TRUNCATE
    $conn->query($sql_truncate);

    foreach ($resultados_valores as $resultado_valor) {
        $i = $resultado_valor[0]; //Obtener numero de registro
        $documento = $resultado_valor[1]; // Obtener el valor del documento
        $nombre_docente = $resultado_valor[2]; // Obtener el valor del nombre del docente
        $resultado_facultad = $resultado_valor[3]; // Obtener el valor de la facultad
        $resultado_nomina = $resultado_valor[4]; // Obtener el valor del cargo
        $resultado_encuesta = $resultado_valor[5]; // Obtener el valor del periodo
        $nota_decano_p = $resultado_valor[6]; // Obtener el valor de nota decano planta
        $nota_decano_c = $resultado_valor[7]; // Obtener el valor de nota decano catedra
        $nota_estud = $resultado_valor[8];    // Obtener el valor nota estudiantes
        $nota_auto_e = $resultado_valor[9]; // Obtener el valor de la nota auto evaluacion
        $nota_auto_e_sin = $resultado_valor[10]; // Obtener el valor de la nota auto evaluacion sin catedra
        $resultado_nota_final = $resultado_valor[11]; // Obtener el valor de la nota auto evaluacion


        // Construir la consulta SQL de inserción
        $sql = "INSERT INTO informes_finales_duplicados (id,DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, FACULTAD, NOMINA, PERIODO, NOTA_ESTUDIANTES, NOTA_AUTOEVALUACION_CON_CATEDRA, NOTA_AUTOEVALUACION_SIN_CATEDRA, NOTA_DECANO_P, NOTA_DECANO_C, NOTA_FINAL) VALUES ('$i','$documento', '$nombre_docente', '$resultado_facultad', '$resultado_nomina', '$resultado_encuesta', '$nota_estud', '$nota_auto_e', '$nota_auto_e_sin', '$nota_decano_p', '$nota_decano_c', '$resultado_nota_final' )";

        // Ejecutar la consulta
        $conn->query($sql);
    }

    //--------------------------------------------------------------------------------AGREGAR A INFORME CON EVALUACION DOCENTE PLANTA-------------------------------------------------------------------------------------------------------------

    $i = 0;

    set_time_limit(180); // 300 segundos (5 minutos)

    foreach ($documentos_duplicados as $documento) {

        $query_eval_estudiantes = "SELECT 
    ROUND(AVG(((PREGUNTA1 + PREGUNTA4 + PREGUNTA5 + PREGUNTA6 + PREGUNTA7+ PREGUNTA8+ PREGUNTA9+ PREGUNTA10+ PREGUNTA11) / 9)),2) AS gestion_asig,
    ROUND(AVG(((PREGUNTA12 + PREGUNTA13 + PREGUNTA14 + PREGUNTA15) / 4) ),2) AS ambiente_asig,
    ROUND(AVG(((PREGUNTA16 + PREGUNTA17 + PREGUNTA18 + PREGUNTA19 + PREGUNTA20) / 5)),2) AS motivacion_asig,
    ROUND(AVG(((PREGUNTA21 + PREGUNTA22 + PREGUNTA23 + PREGUNTA24 + PREGUNTA25) / 5)),1) AS evaluacion_asig,
    ROUND(AVG(((PREGUNTA26 + PREGUNTA27 + PREGUNTA28 + PREGUNTA29 + PREGUNTA30 + PREGUNTA31 + PREGUNTA32 + PREGUNTA33 + PREGUNTA34 + PREGUNTA35 + PREGUNTA36 + PREGUNTA37 + PREGUNTA38 + PREGUNTA39) / 14)),2) AS comunicacion_asig
    FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento";

        $stmt = $pdo->prepare($query_eval_estudiantes);
        $stmt->bindParam(':documento', $documento);


        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado_estud = $stmt->fetch(PDO::FETCH_ASSOC);

        // Consulta SQL 2
        $query_eval_decano1 = "SELECT
        ROUND(
            SUM(
                CASE WHEN PREGUNTA1 = 'SI' THEN ((PREGUNTA2 * PREGUNTA3) / 100) ELSE 0 END +
                CASE WHEN PREGUNTA4 = 'SI' THEN ((PREGUNTA5 * PREGUNTA6) / 100) ELSE 0 END +
                CASE WHEN PREGUNTA7 = 'SI' THEN ((PREGUNTA8 * PREGUNTA9) / 100) ELSE 0 END +
                CASE WHEN PREGUNTA10 = 'SI' THEN ((PREGUNTA11 * PREGUNTA12) / 100) ELSE 0 END +
                CASE WHEN PREGUNTA13 = 'SI' THEN ((PREGUNTA14 * PREGUNTA15) / 100) ELSE 0 END +
                CASE WHEN PREGUNTA16 = 'SI' THEN ((PREGUNTA17 * PREGUNTA18) / 100) ELSE 0 END
            ) /
            (
                SELECT COUNT(*)
                FROM e_decano_planta
                WHERE DOCUMENTO_DOCENTE = :documento
                AND (PREGUNTA1 = 'SI' OR PREGUNTA4 = 'SI' OR PREGUNTA7 = 'SI' OR PREGUNTA10 = 'SI' OR PREGUNTA13 = 'SI' OR PREGUNTA16 = 'SI')
            ),
            2
        ) AS RESULTADO
    FROM e_decano_planta
    WHERE DOCUMENTO_DOCENTE = :documento";


        // Preparar la consulta 2
        $stmt1 = $pdo->prepare($query_eval_decano1);
        $stmt1->bindParam(':documento', $documento);

        // Ejecutar la consulta 2
        $stmt1->execute();

        // Obtener el resultado 2
        $resultado_dec_planta = $stmt1->fetchColumn();


        // Consulta SQL
        $query_ae_sin_catedra = "SELECT 
        ROUND((
            CASE 
                WHEN PREGUNTA1 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA1 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA1 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA1 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA1 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA2 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA2 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA2 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA2 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA2 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA3 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA3 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA3 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA3 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA3 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA4 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA4 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA4 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA4 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA4 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA5 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA5 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA5 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA5 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA5 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA6 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA6 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA6 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA6 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA6 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA7 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA7 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA7 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA7 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA7 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END + CASE 
                WHEN PREGUNTA8 = 'a) Totalmente de acuerdo' THEN 5 
                WHEN PREGUNTA8 = 'b) De acuerdo' THEN 4 
                WHEN PREGUNTA8 = 'c) Ni de acuerdo ni en desacuerdo' THEN 3
                WHEN PREGUNTA8 = 'd) En desacuerdo' THEN 2
                WHEN PREGUNTA8 = 'e) Totalmente en desacuerdo' THEN 1
                ELSE 0 -- Puedes agregar un caso predeterminado si ninguno de los anteriores se cumple
            END )/8 ,
            2
        ) AS RESULTADO
    FROM ae_docente_sin_catedra 
    WHERE DOCUMENTO_DOCENTE = :documento";


        // Preparar la consulta
        $stmt_ae_sin_catedra = $pdo->prepare($query_ae_sin_catedra);
        $stmt_ae_sin_catedra->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_ae_sin_catedra->execute();

        // Obtener el resultado
        $resultado_ae_sin_catedra = $stmt_ae_sin_catedra->fetchColumn();


        $total = 0;

        for ($j = 1; $j <= 31; $j++) {
            $pregunta = "PREGUNTA" . $j;

            // Consulta SQL
            $query = "SELECT 
                ROUND((CASE 
                    WHEN $pregunta = 'Totalmente de acuerdo' THEN 5 
                    WHEN $pregunta = 'De acuerdo' THEN 4 
                    WHEN $pregunta = 'Ni de acuerdo ni en desacuerdo' THEN 3
                    WHEN $pregunta = 'En desacuerdo' THEN 2
                    WHEN $pregunta = 'Totalmente de desacuerdo' THEN 1
                END), 2) AS RESULTADO
                FROM ae_docente_catedra 
                WHERE DOCUMENTO_DOCENTE = :documento";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':documento', $documento);
            $stmt->execute();

            $result = $stmt->fetchColumn(); // Obtener el valor del resultado

            $total += $result;

            $stmt->closeCursor();
        }

        $tot = round($total / 31, 2);

        $eval_estud_total = round(($resultado_estud['gestion_asig'] + $resultado_estud['ambiente_asig'] + $resultado_estud['motivacion_asig'] + $resultado_estud['evaluacion_asig'] + $resultado_estud['comunicacion_asig']) / 5, 2);

        // Consulta SQL
        $query_docente = "SELECT NOMBRE_DOCENTE FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT NOMBRE_DOCENTE FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento;";


        // Preparar la consulta
        $stmt_docente = $pdo->prepare($query_docente);
        $stmt_docente->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_docente->execute();

        // Obtener el resultado
        $resultado_docente = $stmt_docente->fetchColumn();

        $query_docente = "SELECT FACULTAD FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT FACULTAD FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento;";


        // Preparar la consulta
        $stmt_facultad = $pdo->prepare($query_docente);
        $stmt_facultad->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_facultad->execute();

        // Obtener el resultado
        $resultado_facultad = $stmt_facultad->fetchColumn();

        $query_docente = "SELECT CARGO_DOCENTE FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT CARGO_DOCENTE FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT CARGO_DOCENTE FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION 
                SELECT CARGO_DOCENTE FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento
                UNION
                SELECT CARGO_DOCENTE FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento;";


        // Preparar la consulta
        $stmt_nomina = $pdo->prepare($query_docente);
        $stmt_nomina->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_nomina->execute();

        // Obtener el resultado
        $resultado_nomina = $stmt_nomina->fetchColumn();


        $query_encuesta = "SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta FROM ae_docente_catedra WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM ae_docente_sin_catedra WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM e_decano_planta WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM e_decano_catedra WHERE DOCUMENTO_DOCENTE = :documento 
        UNION
        SELECT SUBSTRING_INDEX(ENCUESTA, '-', 3) AS periodo_encuesta  FROM e_estud WHERE DOCUMENTO_DOCENTE = :documento ";


        // Preparar la consulta
        $stmt_encuesta = $pdo->prepare($query_encuesta);
        $stmt_encuesta->bindParam(':documento', $documento);

        // Ejecutar la consulta
        $stmt_encuesta->execute();

        // Obtener el resultado
        $resultado_encuesta = $stmt_encuesta->fetchColumn();

        //Generador de nota final
        $valid_count = 0;

        //-----------------------------VERIFICA SI ES EVALUACION CASO 3------------------------------------------


        if (!empty($resultado_ae_sin_catedra) && $resultado_ae_sin_catedra != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0) {
            $total_ae_sin = round($resultado_ae_sin_catedra * 0.3, 2);
            $total_decano_planta = round($resultado_dec_planta * 0.7, 2);
            $valid_count++;
        } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
            $ae_total = round($tot * 0.3, 2);
            $total_decano_planta = round($resultado_dec_planta * 0.7, 2);
            $valid_count++;
        } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_cat) && $resultado_dec_cat != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
            $total_tot = round($tot * 0.3, 2);
            $total_decano_catedra = round($resultado_dec_cat * 0.7, 2);
            $valid_count++;
        } else {
            // Verificar resultado_dec_planta
            if (!empty($resultado_dec_planta) && $resultado_dec_planta != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                $total_decano_planta = round($resultado_dec_planta * 0.4, 2);
                $estud_total = round($eval_estud_total * 0.4, 2);
                $ae_total = round($tot * 0.2, 2);
                $valid_count++;
            } elseif (!empty($resultado_dec_cat) && $resultado_dec_cat != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                $total_decano_catedra = round($resultado_dec_cat * 0.4, 2);
                $estud_total = round($eval_estud_total * 0.4, 2);
                $ae_total = round($tot * 0.2, 2);
                $valid_count++;
            }
        }


        $resultado_nota_final = 0;

        // Realizar división si hay variables válidas
        if ($valid_count > 0) {

            if (!empty($resultado_ae_sin_catedra) && $resultado_ae_sin_catedra != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0) {
                $resultado_nota_final += $total_ae_sin;
                $resultado_nota_final += $total_decano_planta;
            } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_planta) && $resultado_dec_planta != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
                $resultado_nota_final += $ae_total;
                $resultado_nota_final += $total_decano_planta;
            } elseif (!empty($tot) && $tot != 0 && !empty($resultado_dec_cat) && $resultado_dec_cat != 0 && empty($eval_estud_total) && $eval_estud_total == 0) {
                $resultado_nota_final += $total_tot;
                $resultado_nota_final += $total_decano_catedra;
            } else {
                // Verificar resultado_dec_planta
                if (!empty($resultado_dec_planta) && $resultado_dec_planta != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                    $resultado_nota_final += $total_decano_planta;
                    $resultado_nota_final += $estud_total;
                    $resultado_nota_final += $ae_total;
                } elseif (!empty($resultado_dec_cat) && $resultado_dec_cat != 0 && (!empty($eval_estud_total) && $eval_estud_total != 0) && !empty($tot) && $tot != 0) {
                    $resultado_nota_final += $total_decano_catedra;
                    $resultado_nota_final += $estud_total;
                    $resultado_nota_final += $ae_total;
                }
            }
        }



        $resultado_nota_final = round($resultado_nota_final, 3);

        $resultado_dec_cat = "";


        // Almacenar los valores en el arreglo bidimensional
        $resultado_valores = array(
            $i++,
            $documento,
            $resultado_docente,
            $resultado_facultad,
            $resultado_nomina,
            $resultado_encuesta,
            $resultado_dec_planta,
            $resultado_dec_cat,
            $eval_estud_total,
            $tot,
            $resultado_ae_sin_catedra,
            $resultado_nota_final
        );

        $resultados_valores[] = $resultado_valores; // Agregar el resultado al arreglo bidimensional

        $stmt->closeCursor();
        // $stmt1->closeCursor();
        $stmt2->closeCursor();
        $stmt_docente->closeCursor();
        $stmt_facultad->closeCursor();
        $stmt_nomina->closeCursor();
        $resultado_nota_final = 0;
        $resultado_dec_planta = 0;
        $resultado_dec_cat = 0;
        $resultado_ae_sin_catedra = 0;
        $tot = 0;
        $eval_estud_total = 0;
        $total_decano_catedra = 0;
        $estud_total = 0;
        $ae_total = 0;
        $total_decano_planta = 0;
        $total_ae_sin = 0;
    }


    // Consulta SQL para truncar la tabla
    $sql_truncate = "TRUNCATE TABLE informes_finales_duplicados";

    // Ejecutar la consulta TRUNCATE
    $conn->query($sql_truncate);

    foreach ($resultados_valores as $resultado_valor) {
        $i = $resultado_valor[0]; //Obtener numero de registro
        $documento = $resultado_valor[1]; // Obtener el valor del documento
        $nombre_docente = $resultado_valor[2]; // Obtener el valor del nombre del docente
        $resultado_facultad = $resultado_valor[3]; // Obtener el valor de la facultad
        $resultado_nomina = $resultado_valor[4]; // Obtener el valor del cargo
        $resultado_encuesta = $resultado_valor[5]; // Obtener el valor del periodo
        $nota_decano_p = $resultado_valor[6]; // Obtener el valor de nota decano planta
        $nota_decano_c = $resultado_valor[7]; // Obtener el valor de nota decano catedra
        $nota_estud = $resultado_valor[8];    // Obtener el valor nota estudiantes
        $nota_auto_e = $resultado_valor[9]; // Obtener el valor de la nota auto evaluacion
        $nota_auto_e_sin = $resultado_valor[10]; // Obtener el valor de la nota auto evaluacion sin catedra
        $resultado_nota_final = $resultado_valor[11]; // Obtener el valor de la nota auto evaluacion


        // Construir la consulta SQL de inserción
        $sql = "INSERT INTO informes_finales_duplicados (id,DOCUMENTO_DOCENTE, NOMBRE_DOCENTE, FACULTAD, NOMINA, PERIODO, NOTA_ESTUDIANTES, NOTA_AUTOEVALUACION_CON_CATEDRA, NOTA_AUTOEVALUACION_SIN_CATEDRA, NOTA_DECANO_P, NOTA_DECANO_C, NOTA_FINAL) VALUES ('$i','$documento', '$nombre_docente', '$resultado_facultad', '$resultado_nomina', '$resultado_encuesta', '$nota_estud', '$nota_auto_e', '$nota_auto_e_sin', '$nota_decano_p', '$nota_decano_c', '$resultado_nota_final' )";

        // Ejecutar la consulta
        $conn->query($sql);

    }


    // mostrar un mensaje emergente antes de redirigir
    echo "<script>alert('¡Las notas finales fueron actualizadas!');</script>";

    // redirigir a otra página después de mostrar el mensaje emergente
    echo "<script>window.location.href = 'informes_finales_duplicados.php';</script>";
    ?>


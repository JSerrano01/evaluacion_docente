<?php require_once "vistas/parte_superior.php" ?>

<div class="container">
    <h1>Contenido Doble Evaluacion</h1>

    <?php
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

    // Cerrar la conexión
    $conexion = null;
    ?>

    <!-- HTML para mostrar la tabla -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>DOCUMENTO DOCENTE</th>
                                <th>NOMBRE DOCENTE</th>
                                <th>DESCARGAR EVALUACION SIN OBS</th>
                                <th>DESCARGAR EVALUACION CON OBS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila = $consulta_duplicados->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo $fila['DOCUMENTO_DOCENTE'] ?></td>
                                    <td><?php echo $fila['NOMBRE_DOCENTE'] ?></td>
                                    <td>
                                        <form id="myForm" action="/evaluacion_docente/dashboard/seleccion_caso_duplicados_planta.php" method="post">
                                            <input type="hidden" name="documento" value="<?php echo $fila['DOCUMENTO_DOCENTE'] ?>">
                                            <button type="submit" onclick="submitForm()" class="btn btn-primary"><i class=""> Evaluación con decano planta</button>
                                        </form>
                                        <br></br>
                                        <form id="myForm" action="/evaluacion_docente/dashboard/seleccion_caso_duplicados_catedra.php" method="post">
                                            <input type="hidden" name="documento" value="<?php echo $fila['DOCUMENTO_DOCENTE'] ?>">
                                            <button type="submit" onclick="submitForm()" class="btn btn-primary"><i class=""> Evaluación con decano catedra</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form id="myForm2" action="/evaluacion_docente/dashboard/seleccion_caso_obs_duplicados_planta.php" method="post">
                                            <input type="hidden" name="documento" value="<?php echo $fila['DOCUMENTO_DOCENTE'] ?>">
                                            <button type="submit" onclick="submitForm2()" class="btn btn-primary"><i class=""></i> Evaluación con decano planta</button>
                                        </form>
                                        <br>
                                        <form id="myForm2" action="/evaluacion_docente/dashboard/seleccion_caso_obs_duplicados_catedra.php" method="post">
                                            <input type="hidden" name="documento" value="<?php echo $fila['DOCUMENTO_DOCENTE'] ?>">
                                            <button type="submit" onclick="submitForm2()" class="btn btn-primary"><i class=""></i> Evaluación con decano catedra</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br></br>
        <br></br>
        <h1>Informe Duplicados</h1>
        <br>
        <div class="container" style="display: flex; gap: 110px; margin-left: -30px;">
            <div class="column" style="display: flex; flex-direction: column;">
                <form action="/evaluacion_docente/dashboard/informes_finales_duplicados.php" method="get" style="margin-bottom: 15px;">
                    <div>
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Ver Informe Final Duplicados</button>
                    </div>
                </form>
            </div>
            <div class="column" style="display: flex; flex-direction: column;">
                <form action="/evaluacion_docente/dashboard/informe_duplicados.php" method="get" style="margin-bottom: 15px;">
                    <div>
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Descargar Informe Final Duplicados</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "vistas/parte_inferior.php" ?>
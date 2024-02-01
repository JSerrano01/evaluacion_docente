<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<div class="container">
    <h1><B>NOTAS FINALES DUPLICADOS</B></h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
    </div>
    <br>

    <?php
    include_once '../bd/conexion.php';


    $objeto = new Conexion();
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    $consulta = "SELECT * FROM informes_finales_duplicados";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);




    ?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
    </div>
    <br>
    <div class="container" style="height:auto ; min-height:100vh">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>DOCUMENTO DOCENTE</th>
                                <th>NOMBRE DOCENTE</th>
                                <th>FACULTAD</th>
                                <th>NOMINA</th>
                                <th>PERIODO</th>
                                <th>NOTA ESTUDIANTES</th>
                                <th>NOTA AUTOEVALUACION CON CATEDRA</th>
                                <th>NOTA AUTOEVALUACION SIN CATEDRA</th>
                                <th>NOTA DECANO PLANTA</th>
                                <th>NOTA DECANO CATEDRA</th>
                                <th>NOTA FINAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $dat) {
                            ?>
                                <tr>
                                    <td><?php echo $dat['DOCUMENTO_DOCENTE'] ?></td>
                                    <td><?php echo $dat['NOMBRE_DOCENTE'] ?></td>
                                    <td><?php echo $dat['FACULTAD'] ?></td>
                                    <td><?php echo $dat['NOMINA'] ?></td>
                                    <td><?php echo $dat['PERIODO'] ?></td>
                                    <td><?php echo $dat['NOTA_ESTUDIANTES'] ?></td>
                                    <td><?php echo $dat['NOTA_AUTOEVALUACION_CON_CATEDRA'] ?></td>
                                    <td><?php echo $dat['NOTA_AUTOEVALUACION_SIN_CATEDRA'] ?></td>
                                    <td><?php echo $dat['NOTA_DECANO_P'] ?></td>
                                    <td><?php echo $dat['NOTA_DECANO_C'] ?></td>
                                    <td><?php echo $dat['NOTA_FINAL'] ?></td>
                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <br>NOTA: Boton para actualizar a las notas finales mas reciente en el sistema</br>
        <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" onclick="window.location.href='actualizar_informes_finales_duplicados.php'">ACTUALIZAR</button>

                <!-- --------------------------------------------ENLACE A PRODUCCION ------------------------------------------------------------------------------ -->

        <!-- <form action="https://apps2.colmayor.edu.co/descargar_informe_final"  method="get">
            <br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="submit">DESCARGAR EXCEL</button>
        </form> -->

                <!-- --------------------------------------------ENLACE A LOCAL ------------------------------------------------------------------------------ -->

        <form action="http://127.0.0.1:5000/descargar_informe_final_duplicados"  method="get">
            <br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="submit">DESCARGAR EXCEL</button>
        </form>

    </div>
    <!--FIN del cont principal-->
    <?php require_once "vistas/parte_inferior.php" ?>
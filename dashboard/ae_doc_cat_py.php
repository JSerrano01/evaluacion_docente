<?php require_once "vistas/parte_superior.php" ?>

<title>EvalReporter</title>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Autoevaluación de docentes con cátedra</h1>
    <div class="card-header">
    <br></br>

                <!-- --------------------------------------------ENLACE A LOCAL ------------------------------------------------------------------------------ -->

        <!-- <form class="card-tools" action="http://127.0.0.1:5000/cargar_datos_ae_doc_catedra" method="post" enctype="multipart/form-data">
            <label for="fileUpload">Seleccione el archivo maestro de autoevaluación de docentes con cátedra</label>
            <input class="btn btn-block btn-sm btn-default btn-flat border-primary" type="file" name="archivo_excel" id="archivo" accept=".xlsx" required>
            <br></br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="submit">Subir Datos</button>
        </form> -->

                <!-- --------------------------------------------ENLACE A PRODUCCION ------------------------------------------------------------------------------ -->

        <form class="card-tools" action="https://apps2.colmayor.edu.co/eval-docente-services/cargar_datos_ae_doc_catedra" method="post" enctype="multipart/form-data">
            <label for="fileUpload">Seleccione el archivo maestro de autoevaluación de docentes con cátedra</label>
            <input class="btn btn-block btn-sm btn-default btn-flat border-primary" type="file" name="archivo_excel" id="archivo" accept=".xlsx" required>
            <br></br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="submit">Subir Datos</button>
        </form>

    </div>
            <br></br>
        <br>NOTA: Recordar eliminar las primeras columnas que trae el archivo plano (Marcadas en azul)</br>
        <br>
        <img src="/evaluacion_docente/sources/imgs/muestra_excel.PNG" alt="" style="height: 190px;">
        <br>
        <br>
</div>
</body>

</html>


<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php" ?>
<?php
$mensaje = $_GET['mensaje'] ?? '';
$mensajeEscapado = addslashes($mensaje);
if ($mensajeEscapado) {
    echo "<script>alert('$mensajeEscapado');</script>";
}
?>

<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Evaluación de decanos a docentes de planta</h1>
    <div class="card-header">
    <br></br>

        <!-- --------------------------------------------ENLACE A LOCAL ------------------------------------------------------------------------------ -->

        <form class="card-tools" action="http://127.0.0.1:5000/cargar_datos_e_dec_planta" method="post" enctype="multipart/form-data">
            <label for="fileUpload">Seleccione el archivo maestro de evaluación decanos a docentes de planta</label>
            <input class="btn btn-block btn-sm btn-default btn-flat border-primary" type="file" name="archivo_excel" id="archivo" accept=".xlsx" required>
            <br></br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="submit">Subir Datos</button>
        </form>

            <!-- --------------------------------------------ENLACE A PRODUCCION ------------------------------------------------------------------------------ -->

        <!-- <form class="card-tools" action="https://apps2.colmayor.edu.co/cargar_datos_e_dec_planta" method="post" enctype="multipart/form-data">
            <label for="fileUpload">Seleccione el archivo maestro de evaluación decanos a docentes de planta</label>
            <input class="btn btn-block btn-sm btn-default btn-flat border-primary" type="file" name="archivo_excel" id="archivo" accept=".xlsx" required>
            <br></br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="submit">Subir Datos</button>
        </form> -->
        
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
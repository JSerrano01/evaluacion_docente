<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Evaluación de estudiantes a docentes</h1>
    <div class="card-header">
        <br></br>
        <div class="card-tools">
            <label for="fileUpload">Seleccione el archivo maestro de evaluación de estudiantes a docentes</label>
            <input class="btn btn-block btn-sm btn-default btn-flat border-primary" type="file" id="fileUpload" />
            <br></br>
            <input class="btn btn-primary btn-sm btn-default btn-flat border-primary" type="button" id="upload" value="Subir datos" ></input>
            <br></br>
            <br>NOTA:Despues de subir el archivo plano y termine la carga de este con el mendaje de "¡Registros agregados correctamente!".Presionar el boton "ACTUALIZAR" para hacer la actualizacion en la base de datos</br>
            <button class="btn btn-primary btn-sm btn-default btn-flat border-primary" onclick="window.location.href='actualizar_e_estud.php'">ACTUALIZAR</button>
        </div>
    </div>
</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Contenido principal</h1>
    
    
    
 <?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_catedra
            UNION DISTINCT
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_sin_catedra
            UNION DISTINCT
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_catedra
            UNION DISTINCT
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_planta
            UNION DISTINCT
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_estud";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container">
        <div class="row">
            <div class="col-lg-12">            
                
            </div>    
        </div>    
    </div>    
    <br>  
<div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>DOCUMENTO DOCENTE</th>
                                <th>NOMBRE DOCENTE</th>                                
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['DOCUMENTO_DOCENTE'] ?></td>
                                <td><?php echo $dat['NOMBRE_DOCENTE'] ?></td>   
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
        </div>  
    </div>    
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>
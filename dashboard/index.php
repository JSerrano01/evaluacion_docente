<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<div class="container">
  <h1>Contenido principal</h1>



  <?php
  include_once '../bd/conexion.php';


  $objeto = new Conexion();
  $objeto = new Conexion();
  $conexion = $objeto->Conectar();
  $consulta = "SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_catedra
            UNION 
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM ae_docente_sin_catedra
            UNION 
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_catedra
            UNION 
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_decano_planta
            UNION 
            SELECT DOCUMENTO_DOCENTE, NOMBRE_DOCENTE FROM e_estud";
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
                <th>DESCARGAR EVALUACION SIN OBS</th>
                <th>DESCARGAR EVALUACION CON OBS</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($data as $dat) {
              ?>
                <tr>
                  <td><?php echo $dat['DOCUMENTO_DOCENTE'] ?></td>
                  <td><?php echo $dat['NOMBRE_DOCENTE'] ?></td>
                  <td>
                    <form id="myForm" action="/evaluacion_docente/seleccion_caso.php" method="post"><input type="hidden" name="documento" value="<?php echo $dat['DOCUMENTO_DOCENTE'] ?>"><button type="submit" onclick="submitForm()" class="btn btn-primary"><i class=''> Descargar evaluacion</button></form>
                  </td>
                  <td>
                    <form id="myForm2" action="/evaluacion_docente/seleccion_caso_obs.php" method="post"><input type="hidden" name="documento" value="<?php echo $dat['DOCUMENTO_DOCENTE'] ?>"><button type="submit" onclick="submitForm2()" class="btn btn-primary"><i class=''></i> Descargar evaluacion</button></form>
                  </td>
                </tr>

              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br></br>
    <h1>Descargas Masivas</h1>
    <br>
<<<<<<< HEAD
    <div class="container" style="display: flex; gap: 110px; margin-left: -30px;">
      <div class="column" style="display: flex; flex-direction: column;">
        <form action="/evaluacion_docente/generartodos_caso1.php" method="get" style="margin-bottom: 15px;">
          <div>
            <button type="submit" class="btn btn-primary" style="width: 200px;">Descargar evaluaciones CASO 1</button>
          </div>
        </form>

        <form action="/evaluacion_docente/generartodos_caso1_obs.php" method="get" style="margin-bottom: 15px;">
          <div>
            <button type="submit" class="btn btn-primary" style="width: 200px;">Descargar evaluaciones CASO 1 CON OBS</button>
          </div>
        </form>
      </div>

      <div class="column" style="display: flex; flex-direction: column;">
        <form action="/evaluacion_docente/generartodos_caso2.php" method="get">
          <div>
            <button type="submit" class="btn btn-primary" style="width: 200px;">Descargar evaluaciones CASO 2</button>
          </div>
        </form>
      </div>

      <div class="column" style="display: flex; flex-direction: column;">
        <form action="/evaluacion_docente/generartodos_caso3.php" method="get" style="margin-bottom: 15px;">
          <div>
            <button type="submit" class="btn btn-primary" style="width: 200px;">Descargar evaluaciones CASO 3</button>
          </div>
        </form>

        <form action="/evaluacion_docente/generartodos_caso3_obs.php" method="get">
          <div>
            <button type="submit" class="btn btn-primary" style="width: 200px;">Descargar evaluaciones CASO 3 OBS</button>
          </div>
        </form>
      </div>
=======
    <div class="container" style="height:auto ; min-height:100vh">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%" >
                        <thead class="text-center">
                            <tr>
                                <th>DOCUMENTO DOCENTE</th>
                                <th>NOMBRE DOCENTE</th>
                                <th>DESCARGAR EVALUACION SIN OBS</th>
                                <th>DESCARGAR EVALUACION CON OBS</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                            foreach ($data as $dat) {
                            ?>
                                <tr>
                                    <td><?php echo $dat['DOCUMENTO_DOCENTE'] ?></td>
                                    <td><?php echo $dat['NOMBRE_DOCENTE'] ?></td>
                                    <td><form id="myForm" action="/evaluacion_docente/seleccion_caso.php" method="post"><input type="hidden" name="documento" value="<?php  echo $dat['DOCUMENTO_DOCENTE'] ?>"><button type="submit" onclick="submitForm()" class="btn btn-primary"><i class='fa fa-download'> Descargar evaluacion</button></form></td>
                                    <td>
                                    <form id="myForm2" action="/evaluacion_docente/seleccion_caso_obs.php" method="post"><input type="hidden" name="documento" value="<?php echo $dat['DOCUMENTO_DOCENTE'] ?>"><button type="submit" onclick="submitForm2()" class="btn btn-primary"><i class='fa fa-download'></i> Descargar evaluacion</button></form></td>
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
        <br>
        <form action="/evaluacion_docente/generartodos_caso1.php" method="get">
  <div>
    <button type="submit" class="btn btn-primary">Descargar evaluaciones CASO 1</button>
  </div>
</form>
<br>
<form action="/evaluacion_docente/generartodos_caso1_obs.php" method="get">
  <div>
    <button type="submit" class="btn btn-primary">Descargar evaluaciones CASO 1 CON OBS</button>
  </div>
</form>
<br>
<form action="/evaluacion_docente/generartodos_caso2.php" method="get">
  <div>
    <button type="submit" class="btn btn-primary">Descargar evaluaciones CASO 2</button>
  </div>
</form>
<br>
<form action="/evaluacion_docente/generartodos_caso3.php" method="get">
  <div>
    <button type="submit" class="btn btn-primary">Descargar evaluaciones CASO 3</button>
  </div>
</form>
<br>
<form action="/evaluacion_docente/generartodos_caso3_obs.php" method="get">
  <div>
    <button type="submit" class="btn btn-primary">Descargar evaluaciones CASO 3 OBS</button>
  </div>
</form>
<br>

>>>>>>> 3ba1478b7baa3aa22dc5bf14fc9a3b53445dce93
    </div>
    <br></br>
    <h1>Duplicados</h1>
    <br>
    <div class="container" style="display: flex; gap: 110px; margin-left: -30px;">
      <div class="column" style="display: flex; flex-direction: column;">
        <form action="/evaluacion_docente/dashboard/duplicados.php" method="get" style="margin-bottom: 15px;">
          <div>
            <button type="submit" class="btn btn-primary" style="width: 200px;">Ver Duplicados</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>
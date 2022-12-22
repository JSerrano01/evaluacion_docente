
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Confirma salir y cerrar Sesión?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="../bd/logout.php">Salir</a>
  
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

 <!-- Librería de excel y archivos -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

  <!-- datatables JS -->
  <script type="text/javascript" src="vendor/datatables/datatables.min.js"></script>    
  <!-- código propio JS --> 
  <script type="text/javascript" src="main.js"></script>  
  <script>
    //función para subir datos desde excel
    $('#upload').click(function()
    {
      //Reference the FileUpload element.
      var fileUpload = $("#fileUpload")[0];
      //Validate whether File is valid Excel file.
      var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
      
      if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (FileReader) != "undefined") {
          var reader = new FileReader();

          //For Browsers other than IE.
          if (reader.readAsBinaryString) {
            reader.onload = function (e) {
              var dataFull = ProcessExcel(e.target.result)
              console.log(dataFull[1].ID_ENCUESTA_QUSUARIO)
              console.log(dataFull[1].ID_DOCENTE)
              console.log(dataFull[1].FACULTAD)
              console.log(dataFull[1].PROGRAMA)
              console.log(dataFull[1].DOCUMENTO_DOCENTE)
              console.log(dataFull[1].NOMBRE_DOCENTE)
              console.log(dataFull[1].CARGO_DOCENTE)
              console.log(dataFull[1].ENCUESTA)
              console.log(dataFull[1].FECHA_DILIGENCIAMIENTO)
              console.log(typeof(dataFull))
              sendToDataBase(dataFull)
            };
            reader.readAsBinaryString(fileUpload.files[0]);
          } else {
            //For IE Browser.
            reader.onload = function (e) {
              var data = "";
              var bytes = new Uint8Array(e.target.result);
              for (var i = 0; i < bytes.byteLength; i++) {
                data += String.fromCharCode(bytes[i]);
              }
            
            };
            reader.readAsArrayBuffer(fileUpload.files[0]);
          }
        } else {
          alert("Este navegador no soporta HTML5.");
        }
      } else {
        alert("Por favor suba un archivo de excel válido.");
      }

    })
    function ProcessExcel(data) {
              //Read the Excel File data.
              var workbook = XLSX.read(data, {
                  type: 'binary'
              });

              //Fetch the name of First Sheet.
              var firstSheet = workbook.SheetNames[0];

              //Read all rows from First Sheet into an JSON array.
              var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        return(excelRows)
          };
    function sendToDataBase(data){
      var jsonData = JSON.stringify(data)
      var dato1 = "Valor 1"
      //start_load()
      $.ajax({
        url:'ajax.php?action=cargar_ae_doc_cat',
        method: 'POST',
        type: 'POST',
        data:{datos : dato1},
        success:function(resp){
          console.log(resp)
          if(resp == 1){
            
            alert_toast("Datos guardados satisfactoriamente",'success')
            setTimeout(function(){
              location.reload()
            },1500)
          }else{
            $('#msg').html('<div class="alert alert-danger">Usuario ya existe</div>')
            //end_load()
          }
        }
      })
    }
  </script>

    

</body>

</html>

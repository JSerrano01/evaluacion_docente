
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2023</span>
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
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script> "
  <script>
    //función para subir datos desde excel
    $('#upload').click(function()
    {
      //get url path
      let url = document.URL;
      let url_php = url.split('/');
      var path_url = url_php[url_php.length - 1]
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
              switch (path_url) {
                case "a_e_doc_cat.php":
                  sendToDataBase(dataFull, 'cargar_ae_doc_cat')
                  break;
                case "a_e_doc_sin_cat.php":
                  sendToDataBase(dataFull, 'cargar_ae_doc_sin_cat')
                  break;
                case "e_dec_cat.php":
                  sendToDataBase(dataFull, 'cargar_e_dec_cat')
                  break;
                case "e_dec_planta.php":
                  sendToDataBase(dataFull, 'cargar_e_dec_planta')
                  break;
                case "e_estud.php":
                  sendToDataBase(dataFull, 'cargar_e_estud')
                  break;
              }
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
    function sendToDataBase(data, action){
      var jsonData = JSON.stringify(data)
      var url_ajax = 'ajax.php?action='+action
      $.ajax({
        url: url_ajax,
        method: 'POST',
        type: 'POST',
        data:{datos : jsonData},
        success:function(resp){
          console.log(resp)
          if(resp == 1){
            Swal.fire({
                       type:'success',
                       title:'¡Registros agregados correctamente!',
                       confirmButtonColor:'#3085d6',
                   }).then((result) => {
                    setTimeout(function(){
                      
                                  location.reload()
                                },1500)
                   })
            
          }else{
            Swal.fire({
                       type:'error',
                       title:'¡Se ha producido un error al realizar la petición! Puede que algunos datos no se hayan cargado correctamente.',
                       confirmButtonColor:'#3085d6',
                   }).then((result) => {
                    setTimeout(function(){
                                  location.reload()
                                },1500)
                   })
          }
        }
      }) 
    }
    
    $('#update').click(function()
    {
      
      window.location = 'actualizar_e_estud.php';
    
    })
  </script>


    

</body>

</html>

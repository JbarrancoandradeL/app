
<!-- Se dibuja la tabla superior que hace referencia a la base de datos de categorias de Rueda de la Prosperidad -->
<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />


<div class="row">
    <div class="col-sm-12" style=" ">
        <div class="panel-body"> 
            <button onclick="open_modal_cat(0)" style="" type="button" class="btn btn-success">AGREGAR NUEVA CATEGORÍA</button>
            <table class="table table-striped table-hover" id="tablaCategoriaPRP">
                <thead>
                    <tr>
                        <!-- <th style="width: 20px">#</th> -->
                        <th>NOMBRE DE LA CATEGORIA</th>
                        <th style="width: 55px">ESTADO</th>                   
                    </tr>
                </thead>
                <tbody> 
                </tbody>
            </table>       
        </div>
    </div>



    <div class="col-sm-12" style="margin-top: 50px">

        <div class="panel-body"> 
            <button onclick="open_modal_preg(0)" style="" type="button" class="btn btn-success">AGREGAR NUEVA PREGUNTA</button>
            <table class="table table-striped table-hover" id="tablaPreguntasPRP">
                <thead>
                    <tr>
                        <th style="width: 20px">#</th>
                        <th style="width: 120px">CATEGORÍA</th>
                        <th>DESCRIPCIÓN</th>
                        <th style="width: 55px">ESTADO</th>                   
                    </tr>
                </thead>
                <tbody>

                    
                </tbody>
            </table>
        
        </div>

    </div> 

  </div>
 


<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>

<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript"> 
    $("#TituloPagNav").html("Administrar Creencias ");
    $("#TituloPag").html("Creencias <small>Administrar Creencias </small>");
</script>
<!-- scripts que controla  -->
<script type="text/javascript">

    function listar_categorias (argument) {
        
        var table = $('#tablaCategoriaPRP').DataTable();
            table .clear() .draw();
            table.destroy();


        var table2 = $('#tablaPreguntasPRP').DataTable();
            table2 .clear() .draw();
            table2.destroy();

        $.ajax({
          type: "POST",
            url: "get_categorias_AND_preguntasrp",
            // data: "id=" + id,
            dataType: "json",
            cache: false,
            
            success: function (result) {
                
                var categorias = result['categorias'];
                var preguntasrp = result['preguntasrp'];

               $('#tablaCategoriaPRP').dataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false,
                    "order": [[1, 'asc']],
                    // "aaSorting": [],
                      // "bInfo": false,
                      // "bFilter" : false,               
                      "bLengthChange": false,
                      "bProcessing": true,
                      "ssAjaxDataProp" : "data",
                      "pageLength": 10,
                      "language": {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
                      "aaData": categorias,
                        "aoColumns": [
                        // { "mData": "num" }, 
                        { "mData": "nombre" }, 
                        { "mData": "estado" } 
                      ]
              });
            

                $('#tablaPreguntasPRP').dataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false,
                    "order": [[1, 'asc']],
                    // "aaSorting": [],
                      // "bInfo": false,
                      // "bFilter" : false,               
                      "bLengthChange": false,
                      "bProcessing": true,
                      "ssAjaxDataProp" : "data",
                      "pageLength": 10,
                      "language": {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
                      "aaData": preguntasrp,
                        "aoColumns": [
                         { "mData": "num" }, 
                         { "mData": "cate_preg" }, 
                        { "mData": "nombre" }, 
                        { "mData": "estado" } 
                      ]
              });

           
            }});

    }
    // permite abrir la ventana modal para la categoria de preguntas

    var codigo = 0;
    function open_modal_cat (code) {
        
        codigo = code;

        if(codigo != 0) {
            $("#btn_eliminar_cat").removeClass("ocultar");
            $("#title_modal_cate").html("EDITAR CATEGORÍA");
            $("#modal_categorias").modal({backdrop: 'static', keyboard: false}); 

            var par = "codigo=" + codigo;

                $.ajax({
                    type: "POST",
                    url: "get_categorias_preguntasrp_by_code",
                    data: par,
                    dataType: "json",
                    cache: false,
                    
                    success: function (result) {

                        $("#add_cate_name").val(result[0]['nombre']);
                        $("#add_cate_estado").val(result[0]['estado']);

                    }
                });

        } else {

            $("#add_cate_name").val("");
            $("#add_cate_estado").val("1");

            $("#btn_eliminar_cat").addClass("ocultar");
            $("#title_modal_cate").html("CREAR CATEGORIA"); 
            $("#modal_categorias").modal({backdrop: 'static', keyboard: false}); 
            setTimeout(function(){ $("#add_cate_name").focus(); }, 500);
        }

    }

    // permite abrir la ventana modal para las preguntas
    var codigo_preg_temp = 0;
    function open_modal_preg (code) {
        
        codigo_preg_temp = code;
 
        var par = "codigo=" + code; 
            
            $.ajax({
                
                  type: "POST",
                  url: "get_categorias_preguntasrp_AND_a_preguntaByCode",
                  data: par,
                  dataType: "json",
                  cache: false,
                  
                  success: function (result) {

                    var catregorias_preguntas = result['catregorias_preguntas']; // Lista de categorias
                    var datos_pregunta = result['datos_pregunta']; // Datos de la pregunta
                    
                    ///// CARGAR EL SELECT DE CATEGORIA 
                    var code_select = '<option value="0">SELECCIONE CATEGORÍA</option>';
                    for(x in catregorias_preguntas) { 
                      code_select += '<option value="' + catregorias_preguntas[x]['codigo'] + '"> ' + catregorias_preguntas[x]['nombre'] + ' </option>'; 
                    }
                    $("#add_preg_categ").html(code_select);
                    ///// FIN DE CARGAR EL SELECT DE CATEGORIA 


                    if(codigo_preg_temp == 0) {
                        $("#add_preg_categ").val("0");                        
                        $("#add_preg_name").val("");
                        $("#add_preg_estado").val("1");

                        $("#btn_eliminar_preg").addClass("ocultar");
                        $("#title_modal_preg").html("CREAR NUEVA PREGUNTA");
                        $("#modal_preguntas").modal({backdrop: 'static', keyboard: false}); 

                        setTimeout(function(){ $("#add_preg_categ").focus() }, 500);

                    } else {

                        if(datos_pregunta.length > 0) {
 
                            $("#add_preg_categ").val(datos_pregunta[0]['code_categoria']);                        
                            $("#add_preg_name").val(datos_pregunta[0]['nombre']);
                            $("#add_preg_estado").val(datos_pregunta[0]['estado']);
                            
                            $("#btn_eliminar_preg").removeClass("ocultar");
                            $("#title_modal_preg").html("EDITAR PREGUNTA");
                            $("#modal_preguntas").modal({backdrop: 'static', keyboard: false}); 

                            setTimeout(function(){ $("#add_preg_name").focus() }, 500);
                        }

                    }

                    
                }

              });
        }  
 

    function save_categoria(argument) {

         
        if( $("#add_cate_name").val() == "") {

            $("#add_cate_name").notify("EL NOMBRE DE LA CATEGORÍA NO PUEDE SER VACÍO", "error");
            $("#add_cate_name").focus();

            return false;
        }

        set_disabled("btn_save_cat", 1);
        
        var nombre = $("#add_cate_name").val();
        var estado = $("#add_cate_estado").val();

        var par = "add_cate_name=" + nombre;
            par += "&add_cate_estado=" + estado;
            par += "&add_cate_code=" + codigo;


        $.ajax({
            type: "POST",
            url: "save_categoria_preguntasrp",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

              console.log(result);

               if(result == 1) {
                
                    $.notify("CATEGORÍA GUARDADO CON ÉXITO", "success");

               } else  if(result == 2) {

                    $.notify("CATEGORÍA ACTUALIZADA CON ÉXITO", "success");

               } else {

                    $.notify("ERROR AL GUARDAR CATEGORÍA", "error");
               }

               $("#modal_categorias").modal("hide");
               
               set_disabled("btn_save_cat", 0);

               listar_categorias();
       
            }

        });
         
    }
    // Permite realizar el guardado usando ajax de las categorias en la BD
    // 
    // 
    
    function save_pregunta(argument) {


      // console.log("save_pregunta");

        
        if( $("#add_preg_categ").val() == "0") {
            // SI  no ha seleccionado una categoria

            $("#add_preg_categ").notify("DEBE DEFINIR UNA CATEGORÍA", "error");
            $("#add_preg_categ").focus();
            return false;


        } else if( $("#add_preg_name").val().trim() == "") {
            // Si el nombre esta vacio

            $("#add_preg_name").notify("DEBE DEFINIR UNA PREGUNTA", "error");
            $("#add_preg_name").val("");
            $("#add_preg_name").focus();
            return false;

        }

       

        var par = "add_preg_name=" + $("#add_preg_name").val(); // NOMBRE DE LA PREGUNTA O DESCRIPCION
            par += "&add_preg_categ=" + $("#add_preg_categ").val(); // CODIGO DE LA CATEGORIA A LA QUE PERTENECE LA PREGUNTA
            par += "&add_preg_estado=" + $("#add_preg_estado").val(); // ESTADO EN EL QUE SE CREA LA PREGUNTA
            par += "&add_preg_code=" + codigo_preg_temp; // CODIGO DE LA PREGUNTA / CERO SI ES NUEVA

       set_disabled("btn_save_preg", 1);
 
        $.ajax({
            type: "POST",
            url: "save_preguntarp",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

                // console.log(result);
               
               // return false;

               if(result == 1) {
                
                    $.notify("PREGUNTA GUARDADA CON ÉXITO", "success");

               } else  if(result == 2) {

                    $.notify("PREGUNTA ACTUALIZADA CON ÉXITO", "success");

               } else {

                    $.notify("ERROR INTERNO", "error");
               }

               $("#modal_preguntas").modal("hide");

               set_disabled("btn_save_preg", 0);

               listar_categorias();
       
            }

        });
         
    }

    // Permitevisualizar el boton de confirmado para elminar categoria
    // 
    // 
    
    function confirm_delete_categoria(argument) {
        $("#btn_conf_eliminar_cat").removeClass("ocultar");
        setTimeout(function(){ $("#btn_conf_eliminar_cat").addClass("ocultar"); }, 4000);

    }

    // Permitevisualizar el boton de confirmado para elminar pregunta
    // 
    // 

    function confirm_delete_preguntas(argument) {
         $("#btn_conf_eliminar_preg").removeClass("ocultar");
         setTimeout(function(){ $("#btn_conf_eliminar_preg").addClass("ocultar"); }, 4000);

    }
    // Permite eliminar una categoria de la base de datos
    // 
    // 
    function delete_categoria(argument) {      
        
        var par = "add_cate_code=" + codigo; 

        $.ajax({
            type: "POST",
            url: "delete_categoria_preguntasrp",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

               if(result) {
                
                    $.notify("CATEGORÍA ELIMINADA CON ÉXITO", "success");

               } else {

                    $.notify("ERROR INTERNO", "error");
               }

               $("#modal_categorias").modal("hide");
               listar_categorias();
       
            }
            
        });
         
    }
    // Permite elimminar una pregunta de la base de dato
    // 
    // 
    function delete_pregunta(argument) {      
        
        var par = "add_preg_code=" + codigo_preg_temp; 

        $.ajax({
            type: "POST",
            url: "delete_preguntasrp",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

               if(result) {
                
                    $.notify("PREGUNTA ELIMINADA CON ÉXITO", "success");

               } else {

                    $.notify("ERROR INTERNO", "error");
               }

               $("#modal_preguntas").modal("hide");
               listar_categorias();
       
            }
            
        });
         
    }

    listar_categorias();
    

</script>





  <!-- Modal CATEGORIAS-->
  <div class="modal fade" id="modal_categorias" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title_modal_cate"> - - - - </h4>
        </div>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-sm-8"> 
                <div class="form-group">
                    <label for="email">NOMBRE DE LA CATEGORIA:</label>
                    <input type="email" class="form-control" id="add_cate_name">
                </div>
            </div>
            <div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">ESTADO</label>
                    <select class="form-control" id="add_cate_estado">
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                </div>
            </div> 
        </div>

        </div>
        <div class="modal-footer">
          <table style="width: 100%">
              <tr>
                  <td class="" style="text-align: left; width: 100px;"> 
                    <button onclick="confirm_delete_categoria()" type="button" class="btn btn-danger" id="btn_eliminar_cat">ELIMINAR</button>
                  </td>
                  <td class="" style="text-align: left;"> 
                    <button onclick="delete_categoria()" type="button" class="btn btn-info ocultar" id="btn_conf_eliminar_cat">CONFIRMA</button>
                  </td>
                  <td class="" style="text-align: right;"> 
                      <button id="btn_save_cat" type="button" class="btn btn-success" onclick="save_categoria()">GUARDAR</button>
                  </td>
              </tr>
          </table>
        </div>
      </div>
      
    </div>
  </div>




  <!-- MODAL PREGUNTAS -->    
  <div class="modal fade" id="modal_preguntas" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title_modal_preg"> - - - -. </h4>
        </div>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="email">CATEGOR&Iacute;A:</label>
                    <select class="form-control" id="add_preg_categ">
                                             
                    </select>
                </div>
            </div>

            <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="email">PREGUNTA:</label>
                    <textarea class="form-control" style="resize: none;" id="add_preg_name" rows="2"></textarea> 
                </div>
            </div>
            <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="email">ESTADO</label>
                    <select class="form-control" id="add_preg_estado">
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                </div>
            </div> 
        </div>
        </div>
        <div class="modal-footer">
          <table style="width: 100%">
              <tr>
                  <td class="" style="text-align: left; width: 100px;"> 
                    <button onclick="confirm_delete_preguntas()" type="button" class="btn btn-danger" id="btn_eliminar_preg">ELIMINAR</button>
                  </td>
                  <td class="" style="text-align: left;"> 
                    <button onclick="delete_pregunta()" type="button" class="btn btn-info ocultar" id="btn_conf_eliminar_preg">CONFIRMA</button>
                  </td>
                  <td class="" style="text-align: right;"> 
                      <button id="btn_save_preg" type="button" class="btn btn-success" onclick="save_pregunta()">GUARDAR PREGUNTA</button>
                  </td>
              </tr>
          </table>
        </div>
      </div>
      
    </div>
  </div>
  
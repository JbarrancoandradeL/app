<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />

<!-- Se dibuja la tabla superior que hace referencia a la base de datos de categorias de egresos -->
<div class="row">
    <div class="col-sm-12" style="background-color:#e6e6e6;  ">
        <div class="panel-body"> 
            <button onclick="open_modal_cat_activos(0)" style="" type="button" class="btn btn-success">AGREGAR NUEVA</button>
            <table class="table table-striped table-hover" id="tablaCategoriaActivos">
                <thead>
                    <tr>                        
                        <th>NOMBRE DE LA CATEGORIA</th>
                        <th style="width: 55px">ESTADO</th>                   
                    </tr>
                </thead>
                <tbody>
 
                </tbody>
            </table>       
        </div>
    </div>

<!-- Se dibuja la tabla inferior que hace referencia a la base de datos de egresos -->
    <div class="col-sm-12" style="background-color:#f5f5f5;  ">

        <div class="panel-body"> 
            <button onclick="open_modal_activos(0)" style="" type="button" class="btn btn-success">AGREGAR NUEVO ACTIVO</button>
            <table class="table table-striped table-hover" id="tablaActivos">
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
    $("#TituloPagNav").html("Administrar Activos");
    $("#TituloPag").html("Administrar Activos <small> Administrar Categor&iacute;as de Activos </small>");
</script>
<!-- scripts que controla  -->
<script type="text/javascript">
    function listar_categorias_activos (argument) {
        
        var table = $('#tablaCategoriaActivos').DataTable();
            table.clear().draw();
            table.destroy();


        var table2 = $('#tablaActivos').DataTable();
            table2 .clear() .draw();
            table2.destroy();

        $.ajax({
            type: "POST",
            url: "get_categorias_AND_activos",
            // data: "id=" + id,
            dataType: "json",
            cache: false,
            
            success: function (result) {
                
                var categorias = result['categorias'];
                var activos = result['activos'];
               
               $('#tablaCategoriaActivos').dataTable({
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
            

                $('#tablaActivos').dataTable({
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
                      "aaData": activos,
                        "aoColumns": [
                         { "mData": "num" }, 
                         { "mData": "cate_acti" }, 
                        { "mData": "nombre" }, 
                        { "mData": "estado" } 
                      ]
              });

           
            }});

    }
    // permite abrir la ventana modal para la categoria de egresos

    var codigo = 0;
    function open_modal_cat_activos (code) {        
        codigo = code;
        if(codigo != 0) {
            $("#btn_eliminar_cat").removeClass("ocultar");
            $("#title_modal_cate").html("EDITAR CATEGORÍA");
            $("#modal_categorias_activos").modal({backdrop: 'static', keyboard: false}); 
            var par = "codigo=" + codigo;
                $.ajax({
                    type: "POST",
                    url: "get_categorias_activos_by_code",
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
            $("#modal_categorias_activos").modal({backdrop: 'static', keyboard: false}); 
            setTimeout(function(){ $("#add_cate_name").focus(); }, 500);
        }
    }

     // permite abrir la ventana modal para las preguntas
    var codigo_activo_temp = 0;
    function open_modal_activos (code) {
        
        codigo_activo_temp = code;
 
        var par = "codigo=" + code; 
            
            $.ajax({                
                  type: "POST",
                  url: "get_categorias_activos_AND_a_activoByCode",
                  data: par,
                  dataType: "json",
                  cache: false,
                  
                  success: function (result) {

                    var catregorias_activos = result['catregorias_activos']; // Lista de categorias
                    var datos_activo = result['datos_activo']; // Datos de la pregunta
                    
                    ///// CARGAR EL SELECT DE CATEGORIA 
                    var code_select = '<option value="0">SELECCIONE CATEGORÍA</option>';
                    for(x in catregorias_activos) { 
                      code_select += '<option value="' + catregorias_activos[x]['codigo'] + '"> ' + catregorias_activos[x]['nombre'] + ' </option>'; 
                    }
                    $("#add_activo_categ").html(code_select);
                    ///// FIN DE CARGAR EL SELECT DE CATEGORIA 


                    if(codigo_activo_temp == 0) {
                        $("#add_activo_categ").val("0");                        
                        $("#add_activo_name").val("");
                        $("#add_activo_estado").val("1");

                        $("#btn_eliminar_activo").addClass("ocultar");
                        $("#title_modal_activos").html("CREAR NUEVO ACTIVO");
                        $("#modal_activos").modal({backdrop: 'static', keyboard: false}); 

                        setTimeout(function(){ $("#add_activo_categ").focus() }, 500);

                    } else {

                        if(datos_activo.length > 0) {
 
                            $("#add_activo_categ").val(datos_activo[0]['code_categoria']);                        
                            $("#add_activo_name").val(datos_activo[0]['nombre']);
                            $("#add_activo_estado").val(datos_activo[0]['estado']);
                            
                            $("#btn_eliminar_activo").removeClass("ocultar");
                            $("#title_modal_activos").html("EDITAR ACTIVO");
                            $("#modal_activos").modal({backdrop: 'static', keyboard: false}); 

                            setTimeout(function(){ $("#add_activo_name").focus() }, 500);
                        }

                    }

                    
                }

              });
        }

          // Permite guardar las categorias de activos usando ajax en la base de datos
        // 
        // 
        function save_categoria_activos(argument) {
        
            if( $("#add_cate_name").val() == "") {

                $("#add_cate_name").notify("EL NOMBRE DE LA CATEGORÍA NO PUEDE SER VACÍO", "error");
                $("#add_cate_name").focus();

                return false;
            }

            var nombre = $("#add_cate_name").val();
            var estado = $("#add_cate_estado").val();

            var par = "add_cate_name=" + nombre;
                par += "&add_cate_estado=" + estado;
                par += "&add_cate_code=" + codigo;

            $.ajax({
                type: "POST",
                url: "save_categoria_activos",
                data: par,
                dataType: "json",
                cache: false,
                
                success: function (result) {
                  
                   if(result == 1) {
                    
                        $.notify("CATEGORÍA GUARDADA CON ÉXITO", "success");

                   } else  if(result == 2) {

                        $.notify("CATEGORÍA ACTUALIZADA CON ÉXITO", "success");

                   } else {

                        $.notify("ERROR AL GUARDAR CATEGORÍA", "error");
                   }

                   $("#modal_categorias_activos").modal("hide");
                   listar_categorias_activos();           
                }
            });             
        }

        // Permite guardar los tipos de egresos usando ajax en la base de datos
        // 
        // 
        function save_activos(argument) {
        
          if( $("#add_activo_categ").val() == "0") {
              // SI  no ha seleccionado una categoria

              $("#add_activo_categ").notify("DEBE DEFINIR UNA CATEGORÍA", "error");
              $("#add_activo_categ").focus();
              return false;


          } else if( $("#add_activo_name").val().trim() == "") {
              // Si el nombre esta vacio

              $("#add_activo_name").notify("DEBE DEFINIR EL EGRESO", "error");
              $("#add_activo_name").val("");
              $("#add_activo_name").focus();
              return false;

          }

         

          var par = "add_activo_name=" + $("#add_activo_name").val(); // NOMBRE DE LA PREGUNTA O DESCRIPCION
              par += "&add_activo_categ=" + $("#add_activo_categ").val(); // CODIGO DE LA CATEGORIA A LA QUE PERTENECE LA PREGUNTA
              par += "&add_activo_estado=" + $("#add_activo_estado").val(); // ESTADO EN EL QUE SE CREA LA PREGUNTA
              par += "&add_activo_code=" + codigo_activo_temp; // CODIGO DE LA PREGUNTA / CERO SI ES NUEVA
              
          $.ajax({
              type: "POST",
              url: "save_activos",
              data: par,
              dataType: "json",
              cache: false,              
              success: function (result) {
                       

                if(result == 1) {                  
                      $.notify("TIPO DE ACTIVO GUARDADO CON ÉXITO", "success");
                } else  if(result == 2) {
                      $.notify("TIPO DE ACTIVO  ACTUALIZADA CON ÉXITO", "success");
                } else {
                      $.notify("ERROR INTERNO", "error"); 
                }
                $("#modal_activos").modal("hide");
                listar_categorias_activos();       
              }
          });         
        }

          // Permitevisualizar el boton de confirmado para elminar categoria
    // 
    // 
    
    function confirm_delete_categoria_activos(argument) {
        $("#btn_conf_eliminar_cat").removeClass("ocultar");
        setTimeout(function(){ $("#btn_conf_eliminar_cat").addClass("ocultar"); }, 4000);

    }

    // Permitevisualizar el boton de confirmado para elminar pregunta
    // 
    // 

    function confirm_delete_activos(argument) {
         $("#btn_conf_eliminar_activo").removeClass("ocultar");
         setTimeout(function(){ $("#btn_conf_eliminar_activo").addClass("ocultar"); }, 4000);

    }


       // Permite eliminar una categoria de egresos de la BD
    // 
    // 
    function delete_categoria_activos(argument) {      
        
        var par = "add_cate_code=" + codigo; 

        $.ajax({
            type: "POST",
            url: "delete_categoria_activos",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {
               if(result) {                
                    $.notify("CATEGORÍA ELIMINADA CON ÉXITO", "success");
               } else {
                    $.notify("ERROR INTERNO", "error");
               }
               $("#modal_categorias_activos").modal("hide");
               listar_categorias_activos();       
            }
            
        });
         
    }
    // Permite elimminar una pregunta de la base de dato
    // 
    // 
    function delete_activos(argument) {      
        
        var par = "add_activo_code=" + codigo_activo_temp; 

        $.ajax({
            type: "POST",
            url: "delete_activos",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {
               if(result) {                
                    $.notify("TIPO DE ACTIVO ELIMINADO CON ÉXITO", "success");
               } else {
                    $.notify("ERROR INTERNO", "error");
                }
               $("#modal_activos").modal("hide");
               listar_categorias_activos();       
            }
            
        });
         
    }


     listar_categorias_activos();
</script>


<!-- Modal CATEGORIAS-->
  <div class="modal fade" id="modal_categorias_activos" role="dialog">
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
                    <input type="text" class="form-control" id="add_cate_name">
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
                    <button onclick="confirm_delete_categoria_activos()" type="button" class="btn btn-danger" id="btn_eliminar_cat">ELIMINAR</button>
                  </td>
                  <td class="" style="text-align: left;"> 
                    <button onclick="delete_categoria_activos()" type="button" class="btn btn-info ocultar" id="btn_conf_eliminar_cat">CONFIRMA</button>
                  </td>
                  <td class="" style="text-align: right;"> 
                      <button type="button" class="btn btn-success" onclick="save_categoria_activos()">GUARDAR</button>
                  </td>
              </tr>
          </table>
        </div>
      </div>
      
    </div>
  </div>

   <!-- MODAL ACTIVOS -->    
  <div class="modal fade" id="modal_activos" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title_modal_activos"> - - - -. </h4>
        </div>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="email">CATEGOR&Iacute;A:</label>
                    <select class="form-control" id="add_activo_categ">
                                             
                    </select>
                </div>
            </div>

            <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="email">Descripci&oacute;n:</label>
                    <textarea class="form-control" style="resize: none;" id="add_activo_name" rows="2"></textarea> 
                </div>
            </div>
            <div class="col-sm-12"> 
                <div class="form-group">
                    <label for="email">ESTADO</label>
                    <select class="form-control" id="add_activo_estado">
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
                    <button onclick="confirm_delete_activos()" type="button" class="btn btn-danger" id="btn_eliminar_activo">ELIMINAR</button>
                  </td>
                  <td class="" style="text-align: left;"> 
                    <button onclick="delete_activos()" type="button" class="btn btn-info ocultar" id="btn_conf_eliminar_activo">CONFIRMA</button>
                  </td>
                  <td class="" style="text-align: right;"> 
                      <button type="button" class="btn btn-success" onclick="save_activos()">GUARDAR</button>
                  </td>
              </tr>
          </table>
        </div>
      </div>
      
    </div>
  </div>
<!-- Se dibuja la tabla superior que hace referencia a la base de datos de categorias de Rueda de la Prosperidad -->
<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />


<div class="row">
    <div class="col-sm-12" style="background-color:#f5f5f5;  ">

        <div class="panel-body"> 
            <button onclick="open_modal_ingresos(0)" style="" type="button" class="btn btn-success">AGREGAR NUEVA INGRESO</button>
            <table class="table table-striped table-hover" id="tablaIngresos">
                <thead>
                    <tr>
                        <!-- <th style="width: 20px">#</th> -->
                        <th>DESCRIPCI&Oacute;N</th>
                        <th style="width: 55px">TIPO</th>
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
    $("#TituloPagNav").html("Administrar Ingresos");
    $("#TituloPag").html("Flujo de dinero <small>Administrar tipos de ingresos </small>");
</script>

<!-- scripts que controla  -->
<script type="text/javascript">
	 function listar_ingresos (argument) {
        
        var table = $('#tablaIngresos').DataTable();
            table .clear() .draw();
            table.destroy();

        $.ajax({
          type: "POST",
            url: "get_ingresos",
            // data: "id=" + id,
            dataType: "json",
            cache: false,
            
            success: function (result) {   
               $('#tablaIngresos').dataTable({
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
                      "aaData": result,
                        "aoColumns": [
                        // { "mData": "num" }, 
                        { "mData": "nombre" }, 
                        { "mData": "tipo" }, 
                        { "mData": "estado" } 
                      ]
              });
            }});        
    }
    // permite abrir la ventana modal para los tipos de ingresos

    var codigo = 0;
    function open_modal_ingresos (code) {
        
        codigo = code;

        if(codigo != 0) {
            $("#btn_eliminar_ingreso").removeClass("ocultar");
            $("#title_modal_ingresos").html("EDITAR INGRESO");
            $("#modal_ingresos").modal({backdrop: 'static', keyboard: false}); 

            var par = "codigo=" + codigo;

                $.ajax({
                    type: "POST",
                    url: "get_ingresos_by_code",
                    data: par,
                    dataType: "json",
                    cache: false,
                    
                    success: function (result) {
                        $("#add_ingreso_name").val(result[0]['nombre']);
                        $("#add_ingreso_tipo").val(result[0]['tipo']);
                        $("#add_ingreso_estado").val(result[0]['estado']);

                    }
                });

        } else {

            $("#add_ingreso_name").val("");
            $("#add_ingreso_tipo").val("A");
            $("#add_ingreso_estado").val("1");

            $("#btn_eliminar_ingreso").addClass("ocultar");
            $("#title_modal_ingresos").html("CREAR INGRESO"); 
            $("#modal_ingresos").modal({backdrop: 'static', keyboard: false}); 
            setTimeout(function(){ $("#add_ingreso_name").focus(); }, 500);
        }

    }
    function save_ingresos(argument) {
        
        if( $("#add_ingreso_name").val() == "") {

            $("#add_ingreso_name").notify("LA DESCRIPCIÓN DEL INGRESO NO PUEDE SER VACÍA", "error");
            $("#add_ingreso_name").focus();

            return false;
        }

        var nombre = $("#add_ingreso_name").val();
        var tipo_ingreso = $("#add_ingreso_tipo").val();
        var estado = $("#add_ingreso_estado").val();

        var par = "add_ingreso_name=" + nombre;
            par += "&add_ingreso_tipo=" + tipo_ingreso;
            par += "&add_ingreso_estado=" + estado;
            par += "&add_ingreso_code=" + codigo;

        $.ajax({
            type: "POST",
            url: "save_ingresos",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {
            
               if(result == 1) {                
                    $.notify("INGRESO GUARDADO CON ÉXITO", "success");
               } else  if(result == 2) {
                    $.notify("INGRESO ACTUALIZADA CON ÉXITO", "success");
               } else {
                    $.notify("ERROR AL GUARDAR INGRESO", "error");               }

               $("#modal_ingresos").modal("hide");
               listar_ingresos();       
            }

        });
         
    }
    // Permite visualizar el boton de confirmado para elminar ingreso
    // 
    // 
    
    function confirm_delete_ingresos(argument) {
        $("#btn_conf_eliminar_ingreso").removeClass("ocultar");
        setTimeout(function(){ $("#btn_conf_eliminar_ingreso").addClass("ocultar"); }, 4000);

    }
    // Permite eliminar tipo de ingreso de la base de datos
    // 
    // 
    function delete_ingresos(argument) {      
        
        var par = "add_ingreso_code=" + codigo; 

        $.ajax({
            type: "POST",
            url: "delete_ingresos",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

               if(result) {
                
                    $.notify("INGRESO ELIMINADO CON ÉXITO", "success");

               } else {

                    $.notify("ERROR INTERNO", "error");
               }

               $("#modal_ingresos").modal("hide");
               listar_ingresos();
       
            }
            
        });
         
    }
    listar_ingresos ();
</script>

<!-- Modal INGRESOS-->
  <div class="modal fade" id="modal_ingresos" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title_modal_ingresos"> - - - - </h4>
        </div>
        <div class="modal-body">          
          <div class="row">
            <div class="col-sm-6"> 
                <div class="form-group">
                    <label for="email">Descripci&oacute;n ingreso:</label>
                    <input type="email" class="form-control" id="add_ingreso_name">
                </div>
            </div>
            <div class="col-sm-3"> 
                <div class="form-group">
                    <label for="email">TIPO</label>
                    <select class="form-control" id="add_ingreso_tipo">
                        <option value="A">ACTIVO</option>
                        <option value="P">PASIVO</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3"> 
                <div class="form-group">
                    <label for="email">ESTADO</label>
                    <select class="form-control" id="add_ingreso_estado">
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
                    <button onclick="confirm_delete_ingresos()" type="button" class="btn btn-danger" id="btn_eliminar_ingreso">ELIMINAR</button>
                  </td>
                  <td class="" style="text-align: left;"> 
                    <button onclick="delete_ingresos()" type="button" class="btn btn-info ocultar" id="btn_conf_eliminar_ingreso">CONFIRMA</button>
                  </td>
                  <td class="" style="text-align: right;"> 
                      <button type="button" class="btn btn-success" onclick="save_ingresos()">GUARDAR</button>
                  </td>
              </tr>
          </table>
        </div>
      </div>      
    </div>
  </div>

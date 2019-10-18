
<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<style type="text/css">
    .cogs_list {
        cursor: pointer; padding: 3px 8px 4px 6px;
    }

</style>

<div class="row">
    <div class="col-md-12">
        <!-- start: DYNAMIC TABLE PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> MIS EVENTOS
                <div class="panel-tools"> 
                    <button type="button" class="btn btn-success btn-sm" onclick="open_nuevo(0)">
                        CREAR NUEVO
                    </button>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover table-full-width" id="table_1">
                    <thead>
                        <tr>
                            <!-- <th class="" style="width: 15px">#</th>  -->
                            <!-- <th style="white-space: nowrap;" class="">FECHA DE CREADO</th> -->
                            <th style="white-space: nowrap;" class="">DESCRIPCIÓN</th>
                            <th style="width: 50px">
                                ESTADO
                            </th>
                            <!-- <th class="" style="width: 5px"> </th>  -->
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
        <!-- end: DYNAMIC TABLE PANEL -->
    </div>
</div>



<div class="container">
  <!-- <h2 id="titile_nuevo_ev">NUEVO EVENTO</h2> -->
  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="modal_nuevo_ev" role="dialog">
    <div class="modal-dialog">
    
    <form action="#" onsubmit="return save_evento()">
        
   
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="titile_nuevo_ev">- - - - -</h4>
        </div>
        <div class="modal-body">
          
            <div id="espere_modal_ev" class="" style="text-align: center; padding: 85px;">
                <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
            </div>

          <div class="row ocultar" id="data_modal_ev">
              
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="form-field-22">
                        DESCRIPCIÓN DEL EVENTO
                    </label>
                    <textarea required="" style="resize: none;" id="descripcion_ev" placeholder="" id="form-field-22" class="form-control"></textarea>
                </div>
              </div>

              <div class="col-sm-6">
                  <div class="form-group">
                    <label for="form-field-22">
                        ESTADO
                    </label>
                    <select required="" class="form-control" id="estado_ev">
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                </div>
              </div>

              <div class="col-sm-6">
                  
              </div>  

          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">GUARDAR</button>
        </div>
      </div>
       </form>
    </div>
  </div>
  
</div>




<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/js/min/table-data.min.js"></script>


<script type="text/javascript"> 
    
    var event_code_save = 0;
    
    function open_nuevo (val) {
        
        event_code_save = val;

        if(val == 0){
            
            mostrar_espere_modal_event(0);  

            $("#titile_nuevo_ev").html("NUEVO EVENTO");

            $("#descripcion_ev").val("");
            $("#estado_ev").val(1);

            set_focus("descripcion_ev");

        } else {
            
            $("#titile_nuevo_ev").html("ACTUALIZAR  EVENTO");

            mostrar_espere_modal_event(1);

            var par = "codigo_evento=" + event_code_save; 

     
            $.ajax({
              type: "POST",
                url: "get_evento_by_code",
                data: par,
                dataType: "json",
                cache: false,
                
                success: function (result) { 

                    $("#descripcion_ev").val(result['descripcion']);
                    $("#estado_ev").val(result['estado']);

                    mostrar_espere_modal_event(0);   

                    set_focus("descripcion_ev");
                }

            });

        }

        // console.log(val);

        $("#modal_nuevo_ev").modal({backdrop: 'static', keyboard: false}); 
    }


    function save_evento (argument) {
        
        var par = "codigo_evento=" + event_code_save;
            par += "&descripcion=" + $("#descripcion_ev").val();
            par += "&estado=" + $("#estado_ev").val();

 
        $.ajax({
          type: "POST",
            url: "save_evento",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {
                
                if(result == 1) {
                    
                    $.notify("INSERTADO CON EXITO", "success");
                    $("#modal_nuevo_ev").modal("hide");

                } else if(result == 2) {

                    $.notify("ACTUALIZADO CON EXITO", "success");
                    $("#modal_nuevo_ev").modal("hide");
                } else {
                    $.notify("ERROR INTERNO", "error");
                }

                listar();
            }

        });

        return false;
        
    }

    function listar (argument) {
        

      var table_1 = $('#table_1').DataTable();
            table_1 .clear() .draw();
            table_1.destroy();

        $.ajax({
          type: "POST",
            url: "get_all_eventos",
            // data: "id=" + id,
            dataType: "json",
            cache: false,
            
            success: function (result) {

                console.log(result);
                
                
               $('#table_1').dataTable({
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
                        // { "mData": "num" },  
                        // { "mData": "fecha_creado" }, 
                        { "mData": "descripcion" }, 
                        // { "mData": "abrir" },
                        { "mData": "estado" }
                      ]
              });
        }

    });

    }


    function mostrar_espere_modal_event (val) {
        
        if(val == 1) {

            $("#espere_modal_ev").removeClass("ocultar");
            $("#data_modal_ev").addClass("ocultar");
        } else {
            $("#data_modal_ev").removeClass("ocultar");
            $("#espere_modal_ev").addClass("ocultar");
        }

        console.log("MOSTRA " + val);
    }

    listar();

    $("#TituloPag").html("Lista de eventos <small>  </small>");

 
    $("#TituloPagNav").html("Eventos");
   

</script>
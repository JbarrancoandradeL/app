
<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url() ?>assets/js/min/table-data.min.js"></script>
<style type="text/css">
    .cogs_list {
        cursor: pointer; padding: 3px 8px 4px 6px;
    }

</style>

<div class="row">
    <div class="col-sm-12" style=" ">

        <div class="panel-body"> 
            <button onclick="open_modal_usuarios(0)" style="margin: 10px" type="button" class="btn btn-success">AGREGAR USUARIO</button>            
            <table class="table table-striped table-hover" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th style="width: 155px">IDENTIFICACI&Oacute;N</th>
                        <th>NOMBRE</th> 
                        <th style="width: 155px">EVENTO</th>  
                                  
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        
        </div>

    </div> 

  </div>
<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript"> 
    $("#TituloPagNav").html("Administrar Usuarios");
    $("#TituloPag").html("USUARIOS <small>Administrar los Usuarios en el sistema </small>");
</script>
<!-- scripts que controla  -->
<script type="text/javascript"> 
    var city_data = [];
     function listar (argument) {

      var table_1 = $('#tablaUsuarios').DataTable();
            table_1 .clear() .draw();
            table_1.destroy();

            $.ajax({
              type: "POST",
                url: "get_city_and_users",
                // data: "id=" + id,
                dataType: "json",
                cache: false,
                
                success: function (result) {
                    var usuarios_data =  result['users'];
                    city_data =  result['citys'];               
                   $('#tablaUsuarios').dataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : true,
                        'info'        : true,
                        'autoWidth'   : true,
                        "order": [[1, 'asc']],
                        // "aaSorting": [],
                          // "bInfo": false,
                          // "bFilter" : false,               
                          "bLengthChange": false,
                          "bProcessing": true,
                          "ssAjaxDataProp" : "data",
                          "pageLength": 10,
                          "language": {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
                          "aaData": usuarios_data,
                            "aoColumns": [
                            { "mData": "identificacion" },
                            { "mData": "pn_pa" },
                            { "mData": "evento_desc" } ]
                  });
            }

        });


    }


    //Esta función permite cambiar las ciudaddes dependiendo de los departamentos.

    function change_city(id_dtto) {
      var code_select = '<option value="">SELECCIONE...</option>';
      if(id_dtto != ""){
        for(x in city_data) {        
          if(parseInt(city_data[x]['codigo_dtto']) == id_dtto){          
            code_select += '<option value="' + city_data[x]['id_municipio'] + '"> ' + city_data[x]['municipio'] + ' </option>'; 
              
          }
        }
      }
      $("#add_ciudad").html(code_select);
        
    }

    //Esta función permite abrir la ventana modal

    var usuario_code = 0;
    
    function open_modal_usuarios (val) {
        
      usuario_code = val;
      change_city('');
      $("#btn_conf_eliminar_usuario").addClass("ocultar");
      
      if(val == 0){   
        $("#btn_eliminar_usuario").addClass("ocultar");
        $("#title_modal_usuarios").html("NUEVO USUARIO");
        $("#formModal")[0].reset();  

        //Para hacer requerida la contraseña
        set_required("add_pass",1);
        set_required("add_r_pass",1);

        //Para que sea editable el nombre de usuario 
        set_readOnly('add_usuario',0); 

        //Inicia con el pais colomia dtto y ciudades
        add_remove_o_pais (0);

        $.ajax({                
              type: "POST",
              url: "get_eventos_activos",              
              dataType: "json",
              cache: false,
              
              success: function (result) {            
                var datos_eventos =  result;

                var code_select = '<option value="">SELECCIONE..</option>';
                for(x in datos_eventos) { 
                  code_select += '<option value="' + datos_eventos[x]['codigo'] + '"> ' + datos_eventos[x]['descripcion'] + ' </option>'; 
                }
                $("#add_evento").html(code_select);
           }
        });
    

      }else{
        $("#btn_eliminar_usuario").removeClass("ocultar");
        $("#title_modal_usuarios").html("ACTUALIZAR USUARIO");
        $("#formModal")[0].reset();
        //Para que sea NO editable el nombre de usuario 
        set_readOnly('add_usuario',1);

         //Para hacer NO requerida la contraseña
        set_required("add_pass",0);
        set_required("add_r_pass",0);        
        var par = "codigo=" + usuario_code; 
        $.ajax({                
              type: "POST",
              url: "get_users_by_code",
              data: par,
              dataType: "json",
              cache: false,
              
              success: function (result) {
                

                    var datos_usuario =  result['datos_usuario'];
                    var datos_eventos =  result['eventos'];

                    var code_select = '<option value="">SELECCIONE..</option>';
                    for(x in datos_eventos) { 
                      code_select += '<option value="' + datos_eventos[x]['codigo'] + '"> ' + datos_eventos[x]['descripcion'] + ' </option>'; 
                    }
                    $("#add_evento").html(code_select);

                    $("#add_tipo_doc").val(datos_usuario[0]['tipo_documento']);
                    $("#add_n_doc").val(datos_usuario[0]['documento']);
                    $("#add_nombre1").val(datos_usuario[0]['nombre1']);
                    $("#add_nombre2").val(datos_usuario[0]['nombre2']);
                    $("#add_apellido1").val(datos_usuario[0]['apellido1']);
                    $("#add_apellido2").val(datos_usuario[0]['apellido2']);
                    $("#add_email").val(datos_usuario[0]['correo']);
                    $("#add_telefono").val(datos_usuario[0]['telefono']);
                    $('input:radio[name=add_pais][value='+datos_usuario[0]['pais']+']').prop('checked', 'checked');

                    //Para cambiar las opciones de paises
                    if(datos_usuario[0]['pais'] == 'CO') add_remove_o_pais (0);
                    else add_remove_o_pais (1);




                    $("#add_otro_pais").val(datos_usuario[0]['otro_pais']);
                    $("#add_dtto").val(datos_usuario[0]['departamento']);
                    
                    change_city(datos_usuario[0]['departamento']);//Se actualzia el selector de ciudades. 
                    $("#add_ciudad").val(datos_usuario[0]['ciudad']);

                    $("#add_direccion").val(datos_usuario[0]['direccion']);
                    $("#add_estado").val(datos_usuario[0]['estado']);
                    $("#add_evento").val(datos_usuario[0]['codigo_evento']);
                    $("#add_usuario").val(datos_usuario[0]['usuario']);  
                                        
            }
        });

      }   
      $("#modal_usuarios").modal({backdrop: 'static', keyboard: false}); 
    }  
    function save_usuarios(argument) {
          set_disabled("btn_save_usuario", 1);

          var add_tipo_doc  = $("#add_tipo_doc").val();
          var add_n_doc     = $("#add_n_doc").val();
          var add_nombre1   = $("#add_nombre1").val();
          var add_nombre2   = $("#add_nombre2").val();
          var add_apellido1 = $("#add_apellido1").val();
          var add_apellido2 = $("#add_apellido2").val();
          var add_email     = $("#add_email").val();
          var add_telefono  = $("#add_telefono").val();
          var add_pais      = $('input:radio[name=add_pais]:checked').val();
          var add_otro_pais = $("#add_otro_pais").val();
          var add_dtto      = $("#add_dtto").val();
          var add_ciudad    = $("#add_ciudad").val();
          var add_direccion = $("#add_direccion").val();
          var add_estado    = $("#add_estado").val();
          var add_evento    = $("#add_evento").val();
          var add_usuario   = $("#add_usuario").val();
          var add_pass      = $("#add_pass").val();
          var add_r_pass    = $("#add_r_pass").val();

          if(add_pass != add_r_pass){
              $("#add_r_pass").notify("LA CONTRASEÑA NO COINCIDE", "error");
              $("#add_r_pass").focus();
              set_disabled("btn_save_usuario", 0);
              return false;
          }

          var array_save = {
            "usuario_code" : usuario_code,
            "add_tipo_doc" : add_tipo_doc,
            "add_n_doc" : add_n_doc,
            "add_nombre1" : add_nombre1,
            "add_nombre2" : add_nombre2,
            "add_apellido1" : add_apellido1,
            "add_apellido2" : add_apellido2,            
            "add_email" : add_email,
            "add_telefono" : add_telefono,            
            "add_pais" : add_pais,
            "add_otro_pais" : add_otro_pais,
            "add_dtto" : add_dtto,
            "add_ciudad" : add_ciudad, 
            "add_direccion" : add_direccion, 
            "add_evento" : add_evento,
            "add_estado" : add_estado,
            "add_usuario" : add_usuario, 
            "add_pass" : add_pass,
            "add_r_pass" : add_r_pass
          };
          
          $.ajax({
              type: "POST",
              url: "save_usuarios",
              data: {datos_save : array_save},
              dataType: "json",
              cache: false,
              
              success: function (result) {  
                console.log(result);                
                if(result==1){
                  $("#add_usuario").notify("EL NOMBRE DE USUARIO YA EXISTE", "error");
                  $("#add_usuario").focus();
                }else if(result==5){
                  $("#add_n_doc").notify("YA EXISTE UN USUARIO CON ESTE NúMERO DE DOCUMENTO", "error");
                  $("#add_n_doc").focus();
                }else if(result==2){
                  $.notify("ERROR AL CREAR LA CUENTA", "error");
                }else if(result == 0) {                    
                  $.notify("USUARIO GUARDADO CON ÉXITO", "success");
                  $("#modal_usuarios").modal("hide");
                  listar();    
                } else  if(result == 4) {
                  $.notify("USUARIO ACTUALIZADA CON ÉXITO", "success");
                  $("#modal_usuarios").modal("hide");
                  listar();
                }
                
                set_disabled("btn_save_usuario", 0);
                return false;
              }
              
          }); 
          return false;       
    }
    

   function add_remove_o_pais (val){
    if (val==1) {
          // console.log("Otro");
        $("#clase_o_pais").removeClass("ocultar");
        
        set_required("add_otro_pais",1);

        set_required("add_dtto",0); 
        set_required("add_ciudad",0);

        $("#clase_dtto").addClass("ocultar");
        $("#clase_ciudad").addClass("ocultar"); 
   
    }else{
        // console.log("Colombia");   
        $("#clase_dtto").removeClass("ocultar");
        $("#clase_ciudad").removeClass("ocultar");
        set_required("add_dtto",1); 
        set_required("add_ciudad",1);

        
        set_required("add_otro_pais",0);
        $("#clase_o_pais").addClass("ocultar");        

        
    }
  }
  function confirm_delete_usuario(argument) {
       $("#btn_conf_eliminar_usuario").removeClass("ocultar");
       setTimeout(function(){ $("#btn_conf_eliminar_usuario").addClass("ocultar"); }, 4000);

  }
  function delete_usuario(argument) {      
        
        var par = "usuario_code=" + usuario_code; 

        $.ajax({
            type: "POST",
            url: "delete_usuario",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

               if(result == 0) {
                
                    $.notify("USUARIO ELIMINADA CON ÉXITO", "success");

               } else if(result == 2){

                    $.notify("ERROR INTERNO", "error");
               }else if(result == 1){

                    $.notify("ESTE USUARIO NO PUEDE SER ELIMINADO", "error");
               }

               $("#modal_usuarios").modal("hide");
               listar();
       
            }
            
        });
         
    }
  listar();
</script>


<!-- MODAL PREGUNTAS -->    
  <div class="modal fade" id="modal_usuarios" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">

        <form id="formModal" action="#" onsubmit="return save_usuarios() ">
          
        

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title_modal_usuarios"> - - - -. </h4>
        </div>
        <div class="modal-body">
          
            <div class="row">                
                <div class="col-sm-6">                     
                    <div class="form-group">
                        <label for="email">TIPO DE DOCUMENTO:</label>
                        <select class="form-control" id="add_tipo_doc" required="">
                            <option value="">SELECCIONE..</option>
                            <?php
                              $tipo_documentos = $array_data['tipo_doc']; 
                                foreach ($tipo_documentos as $key => $value) {?>                   
                                                    
                                   <option value="<?php  echo $key; ?>"><?php  echo $value; ?> </option>
                                 <?php  } ?> 
                                                                     
                        </select>
                    </div>
                </div>

                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">N° DOCUMENTO:</label>
                        <input type="number"  class="form-control" id="add_n_doc" required="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">PRIMER NOMBRE:</label>
                        <input type="text" class="form-control" id="add_nombre1" required="">
                    </div>
                </div>

                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">SEGUNDO NOMBRE:</label>
                        <input type="text"  class="form-control" id="add_nombre2" >
                    </div>
                </div>
             </div>
             <div class="row">
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">PRIMER APELLIDO:</label>
                        <input type="text" class="form-control" id="add_apellido1" required="">
                    </div>
                </div>

                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">SEGUNDO APELLIDO:</label>
                        <input type="text"  class="form-control" id="add_apellido2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">CORREO ELECTR&Oacute;NICO:</label>
                        <input type="email"  class="form-control" id="add_email" required="">
                    </div>
                </div>
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">N° TELEF&Oacute;NICO:</label>
                        <input type="tel" class="form-control" id="add_telefono" required="">
                    </div>
                </div>
            </div>
              <div class="row">
                <div class="col-sm-6"> 
                    <div class="form-group">                      
                           <p> <label for="email">PA&Iacute;S:</label></p>                      
                            <label class="radio-inline">
                                <input type="radio" name="add_pais" id="add_pais"  value="CO" checked onclick="add_remove_o_pais(0)">
                                Col
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="add_pais" value="OT" onclick="add_remove_o_pais(1)">
                                Otro
                            </label>
                        </div>
                </div>
                <div class="col-sm-6" id="clase_o_pais"> 
                    <div class="form-group">
                        <label for="email">¿C&Uacute;AL?:</label>
                        <input type="text" class="form-control " id="add_otro_pais" >
                    </div>
                </div>                
            </div>
            <div class="row">            
                <div class="col-sm-6" id="clase_dtto"> 
                    <div class="form-group">
                        <label for="email">DEPARTAMENTO:</label>
                        <select class="form-control" id="add_dtto" onchange="change_city(this.value)" >
                            <option value="">SELECCIONE..</option>
                            <?php
                              $dttos = $array_data['dtto']; 
                                foreach ($dttos as $key => $value) {?>                   
                                                    
                                   <option value="<?php  echo $value['codigo']; ?>"><?php  echo $value['nombre']; ?> </option>
                                 <?php  } ?> 
                        </select>
                    </div>
                </div>
                <div class="col-sm-6" id="clase_ciudad"> 
                    <div class="form-group">
                        <label for="email">CIUDAD:</label>
                        <select class="form-control" id="add_ciudad" >
                            <option value="">SELECCIONE..</option>
                        </select>
                    </div>
                </div>                 
            </div>             
        <div class="row"> 
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">DIRECCI&Oacute;N:</label>
                         <input type="text" class="form-control" id="add_direccion" required="">
                    </div>
                </div>
                <div class="col-sm-6" id="clase_pais"> 
                    <div class="form-group">
                        <label for="email">EVENTO:</label>
                        <select class="form-control" id="add_evento" required="">
                            <option value="">SELECCIONE..</option>
                            <!-- aqui va el selector de eventos -->
                        </select>
                    </div>
                </div> 
        </div>
         <div class="row">                         
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">ESTADO</label>
                        <select class="form-control" id="add_estado">
                            <option value="1">ACTIVO</option>
                            <option value="0">INACTIVO</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">USUARIO:</label>
                        <input type="text" class="form-control " id="add_usuario" required="">
                    </div>
                </div>                                      
         </div>
         <div class="row">
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">CONTRASE&Ntilde;A:</label>
                        <input type="password" class="form-control " id="add_pass" required="">
                    </div>
                </div>
                 <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">REPITA CONTRASE&Ntilde;A:</label>
                        <input type="password" class="form-control " id="add_r_pass" required="">
                    </div>
                </div>                                      
         </div>             
        </div>
        <div class="modal-footer">
          <table style="width: 100%">
              <tr>
                 <td class="" style="text-align: left; width: 100px;"> 
                    <button onclick="confirm_delete_usuario()" type="button" class="btn btn-danger" id="btn_eliminar_usuario">ELIMINAR</button>
                  </td>
                  <td class="" style="text-align: left;"> 
                    <button onclick="delete_usuario()" type="button" class="btn btn-info ocultar" id="btn_conf_eliminar_usuario">CONFIRMA</button>
                  </td>
                  <td class="" style="text-align: right;"> 
                      <button type="submit" id="btn_save_usuario" class="btn btn-success">GUARDAR</button>
                  </td>
              </tr>
          </table>
        </div>

        </form>

      </div>
      
    </div>
  </div>
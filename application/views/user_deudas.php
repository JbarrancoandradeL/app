

<!-- <?php print_r( $tipo_deuda ) ?> -->

<!-- Se dibuja la tabla superior que hace referencia a la base de datos de categorias de Rueda de la Prosperidad -->
<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />


<script src="<?php echo base_url() ?>js/angular.min.js"></script>

 <div id="myApp" ng-app="myApp" ng-controller="myCtrl"> 	


<div class="row">
    <div class="col-sm-12" style="background-color:#f5f5f5;  ">

        <div class="panel-body"> 
            <button onclick="open_modal1(0)" style="" type="button" class="btn btn-success">AGREGAR NUEVA DEUDA</button>
            <table class="table table-striped table-hover" id="tabladeudas">
                <thead>
                    <tr>
                        <!-- <th style="width: 20px">#</th> -->
                        <th style="width: 25px">#</th>
                        <th>ACREEADOR</th>
                        <th style="">TIPO DEUDA</th>
                        <th style="">PLAZO</th>
                        <th style="">TIEMPO RESTANTE</th>
                        <th style="">TASA EA</th>
                        <th style="">CUOTA C/M</th>
                        <th style="">PRESTAMO INICIAL</th>                    
                        <th style="">SALDO</th>                    
                        <th style="">FECHA INICIO</th>                    
                    </tr>
                </thead>
                <tbody>
                    <tr style="cursor: pointer;" ng-repeat="(key, item) in lista_deudas" ng-click="open_modal1(item.codigo_deuda)">
                    	<td> {{key+1}} </td>
                    	<td> {{item.acreedor}} </td>
                    	<td> {{item.tipo_deuda}} </td>
                    	<td> {{item.plazo}} </td>
                    	<td> {{item.tiempo_restante}} </td>
                    	<td> {{item.tasa_ea}} </td>
                    	<td> $ {{item.cuota_mensual}} </td>
                    	<td> {{item.prestamo_inicial}} </td>
                    	<td> {{item.saldo_deuda}} </td>
                    	<td> {{item.fecha_inicio_deuda}} </td>
                    </tr>
                </tbody>
            </table>
        
        </div>

    </div> 

  </div>
 

<!-- MODAL DEUDAS -->
<!-- Modal -->
  <div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">

      	<form action="#" onsubmit="return save_1()">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title_modal1">Modal Header</h4>
        </div>
        <div class="modal-body">
          
          
          	
          
          <div class="row">
            
            <div class="col-sm-5"> 
                <div class="form-group">
                    <label for="email">ACREEDOR:</label>
                    <input required="" type="text" class="form-control" id="acreedor" value="">
                </div>
            </div>

            <div class="col-sm-5"> 
                <div class="form-group">
                    <label for="email">TIPO DE DEUDA</label>
                    <select required="" class="form-control" id="tipo_deuda">
                    	<option value="" selected="">SELECCIONE</option>
                        <?php foreach ($tipo_deuda as $key => $value) { ?>
                        	<option value="<?php echo $value['id'] ?>"> <?php echo $value['nombre'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="col-sm-2"> 
                <div class="form-group">
                    <label for="email">PLAZO</label>
                    <input required="" id="plazo"  type="number" name="" class="form-control" min="0" value="">
                </div>
            </div> 	

        </div>


         <div class="row">

         	
            
         	<div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">TIEMPO RESTANTE</label>
                    <input required="" id="tiempo_rest"  type="number" name="" class="form-control" min="0" value="">
                </div>
            </div> 
            

            <div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">TASA EA</label>
                    <input required="" id="tasa"  type="text" name="" class="form-control" value="">
                </div>
            </div> 

         	<div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">CUOTA C/M:</label>
                    <input required="" id="cuota"  type="number" class="form-control" value="">
                </div>
            </div>

         </div>

         <div class="row">
            
           

            <div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">PRESTAMO INICIAL</label>
                    <input required="" id="prestamo" type="text" name="" class="form-control" value="">
                </div>
            </div>
            <div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">SALDO</label>
                    <input required="" id="saldo" type="number" name="" class="form-control" min="0" value="">
                </div>
            </div> 

            <div class="col-sm-4"> 
                <div class="form-group">
                    <label for="email">FECHA INICIO</label>
                    <input required="" id="fecha_ini" type="text" name="" class="form-control" min="0" value="">
                </div>
            </div> 

        </div>

       

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">GUARDAR</button>
        </div>

         </form>
      </div>
    </div>







<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
 
<!-- scripts que controla  -->
<script type="text/javascript">
	 

	 var app = angular.module('myApp', []);
	
	app.controller('myCtrl', function($scope, $http) {
	  	
	  	$scope.lista_deudas = [];

	  	$scope.open_modal1 = function (value) {
	  		
	  		open_modal1(value);
	  	}

	  	$scope.listar_deudas = function (argument) {
	  		
            // console.log("listar_deudas");

  		  	$.ajax({
	          	type: "POST",
	            url: "get_user_deudas",
	            // data: "id=" + id,
	            dataType: "json",
	            cache: false,
	            
	            success: function (result) {   
 
	            	$scope.lista_deudas = result;

	            	setTimeout(function () {
	            		$scope.$apply();
	            	}, 100)
	            	return false; 
	            	
	            }});  
	  		 
	  	}


	  	$scope.open_nuevo_rp = function (codigo_save) { 
	  		open_nuevo_rp(codigo_save);
	  	}


        $scope.save_1 = function (argument) { 
        
        var par  = "codigo_deuda=" + codigo_deuda;
            par += "&acreedor=" + $("#acreedor").val();
            par += "&tipo_deuda=" + $("#tipo_deuda").val();
            par += "&plazo=" + $("#plazo").val();
            par += "&tiempo_rest=" + $("#tiempo_rest").val();
            par += "&tasa=" + $("#tasa").val();
            par += "&cuota=" + $("#cuota").val();
            par += "&prestamo=" + $("#prestamo").val();
            par += "&saldo=" + $("#saldo").val();
            par += "&fecha_ini=" + $("#fecha_ini").val();

        // console.log("par: " + par);
 
        $.ajax({
            type: "POST",
            url: "save_deuda",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {
 
                
                if(result == 1) {                
                    
                    $.notify("DEUDA GUARDADA CON ÉXITO", "success");

               } else  if(result == 2) {
                    
                    $.notify("DEUDA ACTUALIZADA CON ÉXITO", "success");

               } else {

                    $.notify("ERROR AL GUARDAR DEUDA", "error");   
                   

                }     

                $("#modal1").modal("hide");

                $scope.listar_deudas();


            }
            

        });
         
    }


	  	$scope.listar_deudas();

	});

 
    // permite abrir la ventana modal para los tipos de deudas

    var codigo_deuda = 0;
    function open_modal1 (code) {
        
        // console.log("VER " + code);

        codigo_deuda = code;

        if(codigo_deuda != 0) {
            $("#btn_eliminar_deuda").removeClass("ocultar");
            $("#title_modal1").html("EDITAR DEUDA");
            $("#modal1").modal({backdrop: 'static', keyboard: false}); 

            var par = "codigo_deuda=" + codigo_deuda;

                $.ajax({
                    type: "POST",
                    url: "get_deudas_by_code",
                    data: par,
                    dataType: "json",
                    cache: false,
                    
                    success: function (result) {
                        
                        // console.log(result);

                        $("#acreedor").val(result.acreedor);
                        $("#tipo_deuda").val(result.tipo_deuda_id);
                        $("#plazo").val(result.plazo);
                        $("#tiempo_rest").val(result.tiempo_restante);
                        $("#tasa").val(result.tasa_ea);
                        $("#cuota").val(result.cuota_mensual);
                        $("#saldo").val(result.saldo_deuda);
                        $("#fecha_ini").val(result.fecha_inicio_deuda);
                        $("#prestamo").val(result.prestamo_inicial);

 

                    }
                });

        } else {

            $("#add_deuda_name").val("");
            $("#add_deuda_tipo").val("A");
            $("#add_deuda_estado").val("1");

            $("#btn_eliminar_deuda").addClass("ocultar");
            $("#title_modal1").html("CREAR DEUDA"); 
            $("#modal1").modal({backdrop: 'static', keyboard: false}); 
            setTimeout(function(){ $("#add_deuda_name").focus(); }, 500);
        }

    }
        
    function save_1 (argument) {
        
        angular.element('#myApp').scope().save_1();
    }
    // Permite visualizar el boton de confirmado para elminar deuda
    // 
    // 
    
    function confirm_delete_deudas(argument) {
        $("#btn_conf_eliminar_deuda").removeClass("ocultar");
        setTimeout(function(){ $("#btn_conf_eliminar_deuda").addClass("ocultar"); }, 4000);

    }
    // Permite eliminar tipo de deuda de la base de datos
    // 
    // 
    function delete_deudas(argument) {      
        
        var par = "add_deuda_code=" + codigo_deuda; 

        $.ajax({
            type: "POST",
            url: "delete_deudas",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

               if(result) {
                
                    $.notify("DEUDA ELIMINADO CON ÉXITO", "success");

               } else {

                    $.notify("ERROR INTERNO", "error");
               }

               $("#modal1").modal("hide");
               listar_deudas();
       
            }
            
        });
         
    }

</script>




</div>


<script type="text/javascript">
	$("#TituloPagNav").html("Anotar mis deudas");
    $("#TituloPag").html("Anotar mis deudas <small> </small>");
</script>


<script src="<?php echo base_url() ?>js/angular.min.js"></script>

<!-- <?php print_r($eventos) ?> -->

<style type="text/css">
	
	.div_barra, .div_barra2 {
	    width: 100px; 
	    margin: auto; 

	}

	.div_selected {

	}

	.div_barra { 
	    background-color: green;
	}
	
	.div_barra2 { 
		border-top-left-radius: 10px;
	    border-top-right-radius: 10px;
	    background-color: whitesmoke;
	}
	
	#table_barras td {
		text-align: center;
	}
	.div_name {
	    padding: 0px 0px 10px 20px;
    	text-align: left;
	}



	.progress-bar-vertical {
	    width: 120px;
	    min-height: 300px;
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: -webkit-flex;
	    display: flex;
	    align-items: flex-end;
	    -webkit-align-items: flex-end;
        margin: auto;
	}

.progress-bar-vertical .progress-bar {
  width: 100%;
  height: 0;
  -webkit-transition: height 0.6s ease;
  -o-transition: height 0.6s ease;
  transition: height 0.6s ease;
}

</style>

<div id="myApp" ng-app="myApp" ng-controller="myCtrl" class="row">
	
	<div class="col-sm-5"> 
		
		<table style="width: 100%" id="table_barras">
			<tr>
				<td style="width: 33%; ">   <span id="por_txt_ab">0.00</span>% </td>
				<td style="width: 34%; ">   <span id="por_txt_zc">0.00</span>% </td>
				<td style="width: 33%; ">   <span id="por_txt_es">0.00</span>% </td>
			</tr>
			<tr>
				
				<td> 
					<div ng-click="pintar_usuarios(1)" class="progress progress-bar-vertical">
					  <div id="progress_ab" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 0%;"> 
					  </div>
					</div>
		 		</td>

				
				<td> 
					<div ng-click="pintar_usuarios(2)" class="progress progress-bar-vertical">
					  <div id="progress_zc" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 0%;"> 
					  </div>
					</div>
		 		</td>

				
				<td> 
					<div ng-click="pintar_usuarios(3)" class="progress progress-bar-vertical">
					  <div id="progress_es" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height: 0%;"> 
					  </div>
					</div>
		 		</td>

			</tr>
			<tr>
				<td> ABUNDANTE </td>
				<td> ZONA DE CONFORT</td>
				<td> ESCASA </td>
			</tr>
		</table>

	</div>


	<div class="col-sm-7" style="margin-top: 15px;"> 
		

		 
                        <!-- start: BASIC TABLE PANEL -->
                        <div class="panel panel-default">
                        	
                        	<select onchange="change_select_evento()" id="select_cat" class="form-control">

                        		<option style="font-weight: 600" value="0"> TODAS LAS CATEGORIAS </option> 

                        		<?php foreach ($categorias as $key => $value) { ?>
                        			<option value="<?php echo $value['codigo'] ?>"> <?php echo $value['nombre'] ?> </option> 
                        		<?php } ?>
                        	</select>

                        	<select onchange="change_select_evento()" id="select_evento" class="form-control">
                        		<?php foreach ($eventos as $key => $value) { ?>
                        			<option value="<?php echo $value['codigo'] ?>"> <?php echo $value['descripcion'] ?> </option> 
                        		<?php } ?>
                        	</select>

                            <div class="panel-heading" style="padding-left: 10px;">
                                
                                <table style="width: 100%">
                                	<tr>
                                		<td> <div style="text-align: left; text-align: left; font-weight: 600; color: #607D8B;"> 
                                			TOTAL PARTICIPANTES ( <span id="total_parti">0</span> ) </div> 
                                		</td>
                                		<td> <div style="text-align: right;">  </div> </td>
                                	</tr>
                                </table>
                                
                            </div>
                            <div class="panel-body">
                                
                                <div class="row" style="height: 200px; overflow: scroll; white-space: nowrap;">
                                	
                                	<div class="div_msj ocultar" id="div_espere" style="padding: 50px 0px; text-align: center;">
									    <i class="fa-4x fa fa-spinner fa-spin"> </i>
									</div>

                                	<div id="div_no_data" style="text-align: center; padding: 70px 0px;" class="div_msj ocultar"> 
                                		NO HAY DATOS PARA MOSTRAR </h5> 
                                	</div>

                                	<div id="div_no_data" style="text-align: center; padding: 70px 0px;" class="div_msj ocultar"> 
                                		NO HAY DATOS PARA MOSTRAR </h5> 
                                	</div>

                                	<div id="div_click_men" style="text-align: center; padding: 70px 0px;" class="div_msj ocultar"> 
                                		<h5> CLICK EN LA MENTALIDAD PARA VER USUARIOS </h5> 
                                	</div>

                                	<div id="div_no_user" style="text-align: center; padding: 70px 0px;" class="div_msj ocultar"> 
                                		<h5> LA MENTALIDAD <span id="mensalidad_selected"></span> NO REGISTRA USUARIOS </h5> 
                                	</div>

                                	<div id="div_user_list" ng-repeat="(key, u) in usuarios_list" class="div_msj ocultar list_users col-sm-6"> 
                                		{{u.nombre_usuario}} 
                                	</div>
                                     
                                </div>
                                

                            </div>
                        </div>
                       

	</div>


	<script type="text/javascript">
			
		 


	</script>


	<script>

	var app = angular.module('myApp', []);

		app.controller('myCtrl', function($scope) {
		  	
		  	$scope.usuarios_all = "John";
		  	$scope.usuarios_list = [];
		  	$scope.show1 = 0;

		  	$scope.pintar_usuarios = function (ment) {
		  		
		  		$(".div_msj").addClass("ocultar");
		  		
		  		$scope.usuarios_list = [];

		  		$("#msj_user").addClass("ocultar");
		  		
		  		// ment = Mentalidad a mostrar
		  		// 1 = ABUNDANTE
		  		// 2 = zona de CONFORT
		  		// 3 = escasa

		  		if(ment == 1) {	$("#mensalidad_selected").html('ABUNDANTE'); }
		  		if(ment == 2) {	$("#mensalidad_selected").html('ZONA DE CONFORT'); }
		  		if(ment == 3) {	$("#mensalidad_selected").html('ESCASA'); }
 


		  		// console.log($scope.usuarios_all);
				
				if($scope.usuarios_all == null) {  
					$("#div_no_data").removeClass("ocultar");
					return false;
				} 

		  		var lista_temp = $scope.usuarios_all['lista'];

		  		var arr_temp = [];
		  		for(u in $scope.usuarios_all['lista']) {


		  			if(ment == 1 && $scope.usuarios_all['lista'][u]['mentalidad'] == 'ab') {
		  				
		  				arr_temp.push($scope.usuarios_all['lista'][u]);

		  			} else if(ment == 2 && $scope.usuarios_all['lista'][u]['mentalidad'] == 'zc') {
		  				
		  				arr_temp.push($scope.usuarios_all['lista'][u]);

		  			} else if(ment == 3 && $scope.usuarios_all['lista'][u]['mentalidad'] == 'es') {
		  				
		  				arr_temp.push($scope.usuarios_all['lista'][u]);

		  			}
		  			
		  		}


		  		$scope.usuarios_list = arr_temp;

		  		setTimeout(function() {



		  			if($scope.usuarios_list.length == 0) { 
		  			$(".div_msj").addClass("ocultar");
		  			$("#div_no_user").removeClass("ocultar"); 
			  		} else {
			  			$(".div_msj").addClass("ocultar");
			  			$("#div_user_list").removeClass("ocultar"); 
			  		}

		  			$scope.$apply();

	  			}, 100);


		  		// console.log($scope.usuarios_list);
		  	}

		  	$scope.iniciar = function (argument) {
		  		
		  		$scope.show1 = 0;

		  		var codigo_evento = $("#select_evento").val();
		  		var codigo_cat = $("#select_cat").val();
 					
 				$(".div_msj").addClass("ocultar");
 				$("#div_espere").removeClass("ocultar");

 				var par  = 'codigo_evento=' + codigo_evento;
 					par += '&codigo_cat=' + codigo_cat;

 				console.log("PAR: " + par);

		  		$.ajax({
                type: "POST",
                url: "get_reporte_general_cre_lim",
                data: par,
                dataType: "json",
                cache: false,
                
                success: function (result) { 

                	$(".div_msj").addClass("ocultar");

                    if(result == 0) {

                    	$scope.usuarios_all = null;

		 				$("#progress_ab").css("height", "0%");
						$("#progress_zc").css("height", "0%");
						$("#progress_es").css("height", "0%");

						$("#por_txt_ab").html("0.00");
						$("#por_txt_zc").html("0.00");
						$("#por_txt_es").html("0.00");

						$("#total_parti").html("0"); 

 						$("#div_no_data").removeClass("ocultar");

                    } else {

                    	$scope.usuarios_all = result;

		 				$("#progress_ab").css("height", result['porc_ab'] + "%");
						$("#progress_zc").css("height", result['porc_zc'] + "%");
						$("#progress_es").css("height", result['porc_es'] + "%");

						$("#por_txt_ab").html(parseFloat(result['porc_ab']).toFixed(2));
						$("#por_txt_zc").html(parseFloat(result['porc_zc']).toFixed(2));
						$("#por_txt_es").html(parseFloat(result['porc_es']).toFixed(2));

						$("#total_parti").html(result['lista'].length); 

						$("#div_click_men").removeClass("ocultar");
                    }

 					
					$(".temp_ocultar").removeClass("ocultar");

	                }

	            });

		  	}


		  	$scope.iniciar();

		});

	  	function change_select_evento (argument) {
	  		angular.element(document.getElementById('myApp')).scope().iniciar(); 
	  	}
	</script>


</div>


<script type="text/javascript"> 
    $("#TituloPag").html("Reporte - Creencias");
    $("#TituloPagNav").html("Reporte - Creencias");
    
</script>
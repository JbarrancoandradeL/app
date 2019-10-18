

<?php 

    $codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
    // print_r("estado_evento: " . $codigo_evento_estado_evento['estado_evento']); 
    // print_r("<br>codigo_evento: " . $codigo_evento_estado_evento['codigo_evento']); 
    // print_r("<br>codigo_usuario: " . $this->session->userdata('user_code')); 

?>


<style type="text/css">
 
	.div_pre {
		background-color: #f5f5f5 !important;
		border-color: #f5f5f5 !important; 
	}

	#table_pregunta td {
		text-align: center;
	    padding: 8px !important;
	    border: 1px solid whitesmoke;
	}

	#table_pregunta label {
		margin: 0px !important;  
	}



</style>



<script src="<?php echo base_url() ?>js/angular.min.js"></script>


	<!-- ng-app="myApp" ng-controller="myCtrl" -->
  <div ng-app="myApp" ng-controller="myCtrl"> 

  	 <!-- ng-repeat="pre in preguntas_list" -->


     <div class="alert alert-success ocultar" id="div_finish">
        
         <div class="row">
                    <div class="col-md-12">
                        <!-- start: BASIC TABLE PANEL -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i> 
                                <strong>Has finalizado!</strong> No hay items pendientes! 
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="">
                                    <thead>
                                        <tr> 
                                            <th> ÁMBITOS </th>
                                            <th style="text-align: center;">PREG.</th>
                                            <th style="text-align: center;">PTS</th> 
                                            <th>MENTALIDAD</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="rt in tabla_usuario_categorias"> 
                                            <td class="">{{rt.categoria}}</td>
                                            <td style="text-align: center;"> {{rt.n_preguntas}} </td> 
                                            <td style="text-align: center;"> {{rt.puntos}} </td> 
                                            <td> {{rt.mentalidad}} </td> 
                                        </tr>
                                        <tr ng-repeat="tot in tabla_usuario_totales" style="background-color: whitesmoke; font-weight: 700;"> 
                                            <td class="">TOTAL GENERAL</td>
                                            <td style="text-align: center;"> {{tot.total_preguntas}} </td> 
                                            <td style="text-align: center;"> {{tot.total_puntos}} </td> 
                                            <td>   </td> 
                                        </tr>
                                        

                                    </tbody>
                                </table>
                            
                             <div style="text-align: center;">
                                 <div class="alert alert-info"> {{pensamiento}} </div>
                             </div>

                            </div>

                        </div>
                        <!-- end: BASIC TABLE PANEL -->
                    </div>
                </div>

    </div>


    <div id="div_list" class="ocultar">
 
	   <div ng-repeat="pre in preguntas_list" style=" border-radius: 3px; margin-bottom: 20px" class="">

	  	<div id="div_{{pre.codigo}}" class="row" style="background-color: whitesmoke;">
        
        <div class="col-sm-8">
        	<div id="paginator-content-1" class="alert alert-info div_pre" style="min-height: 74px;">
                {{pre.nombre}}
            </div>
        </div>
        
        <div class="col-sm-4">
        	<table style="width: 100%" border="0" id="table_pregunta">
        		<tr> 
        			<td>
        				<label class="radio-inline">
                            <input ng-click="click_calificar(pre.codigo, 1)" type="radio" class="red" value="1"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 1
                        </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 2)" type="radio" class="red" value="2"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 2
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 3)" type="radio" class="red" value="3"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 3
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 4)" type="radio" class="red" value="4"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 4
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 5)" type="radio" class="red" value="5"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 5
	                    </label>
        			</td> 

        		</tr>

        		<tr> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 6)" type="radio" class="red" value="6"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 6
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 7)" type="radio" class="red" value="7"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 7
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 8)" type="radio" class="red" value="8"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 8
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 9)" type="radio" class="red" value="9"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 9
	                    </label>
        			</td> 
        			<td>
        				<label class="radio-inline">
	                        <input ng-click="click_calificar(pre.codigo, 10)" type="radio" class="red" value="10"  id="R{{pre.codigo}}" name="R{{pre.codigo}}"> 10
	                    </label>
        			</td> 

        		</tr>
        	</table>
        </div> 

		</div>	
	 
	   </div>

    </div>

    <div class="" id="div_espere" style="padding: 160px; text-align: center;">
        <i class="fa-4x fa fa-spinner fa-spin"> </i>
    </div>
 
 <div>

    <table style="width: 100%">
        <tr>
            <td> 
                <!-- <button onclick="listar()"> LISTAR (TEMPORAL)</button> -->
            </td>
            <td style="text-align: right;"> 
                <button id="btn_sig" ng-click="siguiente_an()" data-style="expand-right" class="btn btn-teal ladda-button ocultar">
                    <span class="ladda-label"> Continuar </span>
                        <i class="fa fa-arrow-circle-right"></i>
                        <span class="ladda-spinner"></span>
                    <span class="ladda-spinner"></span>
                </button>
            </td>
        </tr>
    </table>
 </div>

 </div>

<script type="text/javascript"> 
    $("#TituloPagNav").html("Creencias");
   
</script>

<script>

	var app = angular.module('myApp', []);

	app.controller('myCtrl', function($scope) {
	   
	  $scope.preguntas_list = [];

        $scope.click_calificar = function (code, val) {

            // var code = $("#R" + code).val();

            for(x in $scope.preguntas_list) {

                if($scope.preguntas_list[x]['codigo'] == code) {
                    // ESTA ES LA PREGUNTA
                    $scope.preguntas_list[x]['rta'] = val;

                    // console.log($scope.preguntas_list[x]);
                    return false;
                }

            }


            // console.log(code);
            // console.log(val);
        }


        $scope.siguiente_an = function (argument) {

            // console.log($scope.preguntas_list);

            for(x in $scope.preguntas_list) {

                if($scope.preguntas_list[x]['rta'] == '0') { 
                    $("#div_" + $scope.preguntas_list[x]['codigo']).notify("DEBE RESPONDER ESTA PREGUNTA ANTES DE CONTINUAR", "error");
                    return false;
                }

                
            }

            $scope.guardar_califi();
        }

        $scope.guardar_califi = function (argument) {

            var preguntas_list = $scope.preguntas_list;

            // console.log(preguntas_list);
            // return false;

            // $("#div_espere").removeClass("ocultar");
            // $("#div_list, #btn_sig").addClass("ocultar");

            $.ajax({
                type: "POST",
                url: "save_respuestas_pre",
                data: { respuestas : preguntas_list} ,
                dataType: "json",
                cache: false,
                
                success: function (result) { 
                    // console.log(result);

                    listar();  
                }
            });

            // console.log("guardar_califi");

            
             
        }


        function listar(argument) {
            
            $("#div_espere").removeClass("ocultar");
            $("#div_list, #btn_sig").addClass("ocultar");
            $("#div_finish").addClass("ocultar");

            go_top();
                    
    	    $.ajax({
                type: "POST",
                url: "get_preguntas_usuarios",
                // data: "id=" + id,
                dataType: "json",
                cache: false,
                
                success: function (result) { 

                    // console.log(result);
                    // return false;
                   
                        // console.log(result.preguntas.length);
                        // return false;

                    if(result.preguntas.length > 0) { 

                        // Si hay preguntas
                        $("#div_list, #btn_sig").removeClass("ocultar");
                        $scope.$apply( function ( ) { 
                            $scope.preguntas_list = result.preguntas; 
                        }); 


                        $("#TituloPag").html("Creencias <small id='subTituloPag'>Califícate de 1 a 10 con relación a las siguientes afirmaciones. Siendo 1 = 100% en desacuerdo y 10 = 100% de acuerdo </small> "); 

                    } else {
                        // Ya no hay preguntas
                        // console.log("Ya no hay preguntas");
                        
                        $("#div_finish").removeClass("ocultar");
                        $("#subTituloPag").html("");

                        // console.log(result.tabla_usuario['totales'][0]['informe']);

                        

                        $scope.$apply( function ( ) { 
                            $scope.tabla_usuario_categorias = result.tabla_usuario['categorias'];
                            $scope.tabla_usuario_totales = result.tabla_usuario['totales'];
                            $scope.pensamiento = result.tabla_usuario['totales'][0]['informe'];
                        }); 
                        

                        $("#TituloPag").html("Creencias"); 
                    }

                    // console.log(preguntas);

                	

                    $("#div_espere").addClass("ocultar");
 
                }
            });
        }
    
        listar();


	});

</script>


<!-- <script>
  
	function listar (argument) {
		
		$.ajax({
          type: "POST",
            url: "get_preguntas_usuarios",
            // data: "id=" + id,
            dataType: "json",
            cache: false,
            
            success: function (result) { 

            	$scope.$apply( function ( ) { 
            		$scope.preguntas_list = result; 
            	}); 

            }
        });

	}
 
</script> -->


<script type="text/javascript">
    
    
    
     

</script>
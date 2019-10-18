
<?php 

    // $codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
    // print_r("estado_evento: " . $codigo_evento_estado_evento['estado_evento']); 
    // print_r("<br>codigo_evento: " . $codigo_evento_estado_evento['codigo_evento']); 
    // print_r("<br>codigo_usuario: " . $this->session->userdata('user_code')); 

?>
<style type="text/css">
	
	.btn_num {
		padding: 2px 0px;
	    margin: 0px;
	    width: 29px;
	}

	.td_num {
		padding: 10px 0px !important;
    	text-align: center !important;
	}

    .btn_active {
        color: #fdfdfd !important;
        background-color: #4CAF50 !important;
    }

</style>


<script src="<?php echo base_url() ?>js/angular.min.js"></script>



<!-- Parrafo -->

   <div class="panel" style=" padding-left: 10px; color: #797979">
        Como lideres extraordinarios nos enfrentamos con el gran desafío de mantener un equilibrio en todas estas áreas fundamentales de nuestra vida. Incluso sabiendo que saldremos adelante sin ser conscientes de en que área estamos poniendo mayor atención o esfuerzo.
Sin embargo, es bien sabido que tendemos a enfocarnos mas en algunas áreas especificas, descuidando otras que a lo mejor son mas importantes en nuestra vida y requieren mas atención, lo cual nos aleja de una vida plena y llena de prosperidad.

<br><br>

Con los resultados adquiridos en este ejercicio, podrás identificar que hay una discrepancia entre tu estado actual y el estado en el que quieres estar. Para ello, debemos enfocarnos primeramente en aquellas áreas donde la diferencia no es tan grande, lo que quiere decir que has sido mas constante y te has enfocado más en ellas. Reflexiona y pregúntate ¿Qué has hecho para ser exitoso en ellas?

<br><br>

Ahora es momento de enfocarnos en aquellas áreas que cuentan con una discrepancia mayor y que necesitan de toda tu atención y de unas acciones enfocadas. ¿Cual es el área que tiene la diferencia mas grande entre tu estado actual y tu estado deseado? Ese es el área que te ayudaremos a mejorar.

<br><br> </div>




<!-- GRAFICA -->
    
   <div id="div_grafica" class="ocultar">
        <canvas id="marksChart"  style="display: block; "></canvas>
        <br> <br>
   </div>

 

    <script src="<?php echo base_url() ?>js/chart.bundle.min.js"></script>

 
    <!-- Scrips que cambian el titulo general de la página -->
    <script type="text/javascript"> 
        $("#TituloPagNav").html("Flujo de dinero - Estado");
        $("#TituloPag").html("Flujo de dinero<small> Estado mensual</small>");   
    </script>




<!-- FIN GRAFICA -->


<div id="myApp" ng-app="myApp" ng-controller="myCtrl"> 


<div class="" id="div_espere" style="padding: 160px; text-align: center;">
    <i class="fa-4x fa fa-spinner fa-spin"> </i>
</div>

<div id="div_tabla" class="ocultar">
    
 

    <div class="panel panel-default">
            <div class="panel-heading" style=" padding-left: 10px; text-align: center;">
                <!-- <i class="fa fa-external-link-square"></i> -->
                 ÁREA DE FOCO SUGERIDO
                <div class="panel-tools">
                     
                </div>
            </div>
            <div class="panel-body">
                
                <div ng-repeat="(key, s) in lista_sugeridos" class="row" style="margin: 0px 0px; margin-bottom: 25px; color: #6b6b6b; font-weight: 400;">
                    <b>{{s.categoria}}:</b> {{s.enunciado}}
                </div>

            </div>
        </div>

</div>

<div class="row ocultar" id="div_lista">
                    <div class="col-md-12">
                        <!-- start: BASIC TABLE PANEL -->
                        <div class="panel panel-default" ng-repeat="(key, p) in lista_preguntas">
                            <div id="preg_{{p.codigo}}" class="panel-heading" style="height: auto !important; padding: 15px !important;"> 
                               
                                {{p.pregunta}}

                                <div class="panel-tools">
                                    <a class="ocultar btn btn-xs btn-link panel-collapse collapses" href="#">
                                    </a> 
                                </div>
                            </div>

                            <div class="panel-body" style="padding: 15px 0px 0px 15px;">
                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">
                                            	Da un puntaje de 1 a 10, teniendo en cuenta el estado en el que te encuentras actualmente.
                                            </th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="center td_num"> 
                                            	 
                                        	 	<div> 
                                        	 		<table style="width: 100%">
                                        	 			<tr>
<td> 
    <button ng-disabled="p.rta2 < 1 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 1}" ng-click="set_calif(key, 1, 1)" type="button" class="btn btn-default btn_num"> 
        1 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 2 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 2}" ng-click="set_calif(key, 1, 2)" type="button" class="btn btn-default btn_num"> 
        2 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 3 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 3}" ng-click="set_calif(key, 1, 3)" type="button" class="btn btn-default btn_num"> 
        3 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 4 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 4}" ng-click="set_calif(key, 1, 4)" type="button" class="btn btn-default btn_num"> 
        4 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 5 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 5}" ng-click="set_calif(key, 1, 5)" type="button" class="btn btn-default btn_num"> 
        5 
    </button> 
     </td>

<td> 
    <button ng-disabled="p.rta2 < 6 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 6}" ng-click="set_calif(key, 1, 6)" type="button" class="btn btn-default btn_num"> 
        6 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 7 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 7}" ng-click="set_calif(key, 1, 7)" type="button" class="btn btn-default btn_num"> 
        7 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 8 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 8}" ng-click="set_calif(key, 1, 8)" type="button" class="btn btn-default btn_num"> 
        8 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 9 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 9}" ng-click="set_calif(key, 1, 9)" type="button" class="btn btn-default btn_num"> 
        9 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta2 < 10 && p.rta2 != 0" ng-class="{'btn_active': p.rta1 == 10}" ng-click="set_calif(key, 1, 10)" type="button" class="btn btn-default btn_num"> 
        10
         </button> 
          </td>

                                        	 			</tr>
                                        	 		</table>
                                    	  		</div> 
                                    	  		
                                            </td>  
                                              
                                        </tr>

                                    </tbody>

                                </table>
                            </div>

                            <div class="panel-body" style="padding: 0px 0px 0px 15px;">
                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">
                                            	Da un puntaje de 1 a 10, teniendo en cuenta el estado en el que quisieras estar.
                                            </th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="center td_num"> 
                                            	 
                                        	 	<div> 
                                        	 		<table style="width: 100%">
                                        	 			<tr>
<td> 
    <button ng-disabled="p.rta1 > 1 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 1}" ng-click="set_calif(key, 2, 1)" type="button" class="btn btn-default btn_num"> 
        1 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 2 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 2}" ng-click="set_calif(key, 2, 2)" type="button" class="btn btn-default btn_num"> 
        2 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 3 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 3}" ng-click="set_calif(key, 2, 3)" type="button" class="btn btn-default btn_num"> 
        3 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 4 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 4}" ng-click="set_calif(key, 2, 4)" type="button" class="btn btn-default btn_num"> 
        4 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 5 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 5}" ng-click="set_calif(key, 2, 5)" type="button" class="btn btn-default btn_num"> 
        5 
    </button> 
     </td>

<td> 
    <button ng-disabled="p.rta1 > 6 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 6}" ng-click="set_calif(key, 2, 6)" type="button" class="btn btn-default btn_num"> 
        6 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 7 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 7}" ng-click="set_calif(key, 2, 7)" type="button" class="btn btn-default btn_num"> 
        7 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 8 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 8}" ng-click="set_calif(key, 2, 8)" type="button" class="btn btn-default btn_num"> 
        8 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 9 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 9}" ng-click="set_calif(key, 2, 9)" type="button" class="btn btn-default btn_num"> 
        9 
    </button> 
</td>

<td> 
    <button ng-disabled="p.rta1 > 10 || p.rta1 == 0" ng-class="{'btn_active': p.rta2 == 10}" ng-click="set_calif(key, 2, 10)" type="button" class="btn btn-default btn_num"> 1
        0 
    </button> 
     </td>

                                        	 			</tr>
                                        	 		</table>
                                    	  		</div> 
                                    	  		
                                            </td>  
                                              
                                        </tr>

                                    </tbody>

                                </table>
                            </div>


                        </div>
                        <!-- end: BASIC TABLE PANEL -->
                    </div>

                    <div class="col-md-12">
                    	<table style="width: 100%">
                    		<tr>
                    			<td style="text-align: left;"> 
			                    	<button ng-disabled="preg_show == 0" ng-click="next_prev(0)" data-style="expand-left" class="btn btn-teal ladda-button ocultar">
			                            <i class="fa fa-arrow-circle-left"> </i>                 
			                            <span class="ladda-label"> Anterior </span>
			                        </button>
                    			</td>

                    			<td style="text-align: right;">
                    				<button ng-click="next_prev(1)" data-style="expand-right" class="btn btn-teal ladda-button">

			                            <span class="ladda-label"> Siguiente </span>
                                        <i class="fa fa-arrow-circle-right"> </i>
			                        </button>
                    			</td>
                    		</tr>
                    	</table>
                    </div> 

</div>


</div>


<script>
    
    var app = angular.module('myApp', []);
    
    app.controller('myCtrl', function($scope, $http) {
        
        $scope.lista_preguntas = [];
        $scope.lista_sugeridos = [];
        $scope.preg_show = 0;

        $("#div_espere").removeClass("ocultar");
        $("#div_lista").addClass("ocultar");
        $("#div_tabla").addClass("ocultar");

        $scope.listar = function (argument) {
            
            $http({ method: 'POST', url: 'get_preguntas_rp_user' }).then(function successCallback(response) {
                
                if(response.data['lista_preguntas'].length > 0) {
                    // mostrar preguntas
                    $scope.lista_preguntas = response.data['lista_preguntas'];
                    $("#div_espere").addClass("ocultar");
                    $("#div_lista").removeClass("ocultar");
                
                } else {
                    // MOSTRAR LA TABLA
                        
                    // console.log(response.data['tabla_usuario']['grafica']);

                    $scope.lista_sugeridos = response.data['tabla_usuario']['lista_sugeridos'];

                    $("#div_espere").addClass("ocultar");
                    $("#div_lista").addClass("ocultar");
                    $("#div_tabla").removeClass("ocultar");
                     $("#div_grafica").removeClass("ocultar");
                    

                    var grafica = response.data['tabla_usuario']['grafica'];

                    var categorias = grafica['categorias'];
                    var valor_presente = grafica['valor_presente'];
                    var valor_futuro = grafica['valor_futuro'];

                    $scope.pintar_grafica(categorias, valor_presente, valor_futuro);

                }

                
            


          }, function errorCallback(response) { 
               
          });

             
        }


        $scope.pintar_grafica = function (categorias, valor_presente, valor_anhelado) {
                
               // console.log(categorias);
                // console.log("ACTUAL: " + valor_presente);
                // console.log("ANHELADO: " + valor_anhelado);

                var marksData = {
                  labels: categorias,
                  datasets: [{
                    label: "Estado Actual", 
                    backgroundColor: "rgba(200,0,0,0.2)",
                    data: valor_presente
                  }, {
                    label: "Estado Anhelado",
                    backgroundColor: "rgba(0,0,200,0.2)",
                    data: valor_anhelado
                  }]
                };
                 var Canvas = document.getElementById('marksChart').getContext('2d');
                var radarChart = new Chart(Canvas, {
                  type: 'radar',
                  data: marksData
                });

        }

        $scope.set_calif = function (index, n_rta, calif) {


            $scope.lista_preguntas[index]['rta' + n_rta] = calif;  
            
            // $scope.lista_preguntas[index]['rta1']
            // $scope.lista_preguntas[index]['rta2']

            // if(n_rta == 1) {
            //     // Respondio el actualmente
            //     if($scope.lista_preguntas[index]['rta1'] > $scope.lista_preguntas[index]['rta2']) {

            //     }    
            // }

            
            // $(".btn_rta" + n_rta).removeClass("btn_active");
            // $("#btn_rta" + n_rta + calif).addClass("btn_active");
            // console.log(index + " | " + n_rta + " | " + calif);
            
            // console.log($scope.lista_preguntas);

           

        }

        $scope.next_prev = function (val) {

            // console.log("next_prev");

            for(x in $scope.lista_preguntas) {

                var item = $scope.lista_preguntas[x];

                if(item['rta1'] == '0' || item['rta2'] == '0') {

                    $("#preg_" + item['codigo']).notify( "DEBE RESPONDER ESTA PREGUNTA", { position:"bottom center" } );
                    go_top();
                    return false;
                }

            }

            $scope.save_preguntas();

            // console.log($scope.lista_preguntas);

            // if(val == 1 && $scope.preg_show < ($scope.lista_preguntas.length -1)) {  
            //     $scope.preg_show ++; 
            
            // } else if(val == 0 && $scope.preg_show > 0) { 
            //     $scope.preg_show --; 
            // }   
        }


        $scope.save_preguntas = function (argument) {
            
            $("#div_espere").removeClass("ocultar");
            $("#div_lista").addClass("ocultar");

            var array_save = $scope.lista_preguntas[$scope.preg_show];

             $.ajax({
                type: "POST",
                url: "save_respuestas_MRP",
                data: { respuestas : array_save} ,
                dataType: "json",
                cache: false,
                
                success: function (result) { 
             
                    console.log(result);
 
                    // console.log($scope.lista_preguntas);
                    $scope.listar();
                }
            });

        }

        $scope.open_nuevo_rp = function (codigo_save) { 
            open_nuevo_rp(codigo_save);
        }

        $scope.listar();

    });

</script>


<script type="text/javascript">
	 $("#TituloPag").html("Rueda de la prosperidad <small id='subTituloPag'>  </small> ");  
</script>
 
 <script src="<?php echo base_url() ?>js/angular.min.js"></script>

<!-- <?php print_r($datos) ?> -->

<div id="myApp" ng-app="myApp" ng-controller="myCtrl" class="row">

                    <div class="col-md-12">
                        

                        <div class="panel panel-default">
                        
                            <div class="panel-heading" style="padding-left: 10px;">

                                REPORTE RUEDA DE LA PROSPERIDAD

                                <div class="panel-tools" style="top: 3px;">

                                     <select onchange="listar()" class="form-control input-sm" id="select_evento">
                                     	
                                     	<?php foreach ($eventos as $key => $value) { ?>
                                     		<option value="<?php echo $value['codigo_evento'] ?>"> <?php echo $value['descripcion'] ?> </option>
                                     	<?php } ?>

                                     </select>
                                </div>
                            </div>
                            <div class="panel-body">


                            	<div class="div_espere" style="padding: 60px 0px; text-align: center;">
							        <i class="fa-4x fa fa-spinner fa-spin"> </i>
							    </div>

                            	<div class="div_show ocultar" ng-show="reporte.length == 0" style="font-weight: bold !important; text-align: center; color: #9E9E9E; padding: 60px 0px">
                            		NO HAY DATOS PARA MOSTRAR 
                            	</div>

                                <div class="div_show ocultar" ng-show="reporte.length > 0">
	                                
	                                <table class="table table-hover" id="sample-table-1">
	                                    <thead>
	                                        <tr> 
	                                            <th style="">CATEGORIA</th> 
	                                            <th style="text-align: center;">ALTO</th>  
	                                            <th style="text-align: center;">MEDIO</th>  
	                                            <th style="text-align: center;">BAJO</th>  
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        
	                                        	<tr ng-repeat="r in reporte"> 
		                                            <td style=""> {{r.categoria}} </td>
		                                            <td style="text-align: center;"> {{r.alto}}  </td>  
		                                            <td style="text-align: center;"> {{r.medio}}  </td>  
		                                            <td style="text-align: center;"> {{r.bajo}}  </td>  
		                                        </tr> 

	                                    </tbody>
	                                </table>
                                	
                                </div>


                            </div>
                        </div>
                        <!-- end: BASIC TABLE PANEL -->
                    </div>
                </div>



<script>

	var app = angular.module('myApp', []);

	app.controller('myCtrl', function($scope) {

		$scope.reporte = -1;

		$scope.listar = function (argument) {
			 
			 $(".div_show").addClass("ocultar");
			 $(".div_espere").removeClass("ocultar");

			var codigo_evento = $("#select_evento").val();

	  		$.ajax({
            type: "POST",
            url: "get_data_rep_admin_mrp",
            data: 'codigo_evento=' + codigo_evento ,
            dataType: "json",
            cache: false,
            
            success: function (result) { 
					
			 		

					$scope.reporte = result['reporte'];
                	$scope.$digest();

                	$(".div_espere").addClass("ocultar");
					$(".div_show").removeClass("ocultar");
                }

            });


		};

		
		$scope.listar();

	});

</script>


<script type="text/javascript">
	
	function listar (argument) {
		angular.element('#myApp').scope().listar();
	}

</script>


<script type="text/javascript"> 
    $("#TituloPag").html("REPORTE - RUEDA DE LA PROSPERIDAD");
    $("#TituloPagNav").html("REPORTE - RUEDA DE LA PROSPERIDAD");
    
</script>                
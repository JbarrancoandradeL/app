<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />

<div id="myApp" ng-app="myApp" ng-controller="myCtrl">

	<div class="panel panel-default">
		<div class="panel-body" ng-repeat="x in deudas">
			<ul class='pricing-table col-lg-8'>
			<h4>Introducción de datos: </h4>
				<li>
					<b>Capital inicial: </b> {{x.prestamo_inicial}}
				</li>
				<li>
					<b>Tipo de interés nominal: </b> {{x.tasa_ea}} %
				</li>
				<li>
					<b>Plazo (AÑOS): </b> {{x.plazoA}}
				</li>
				<li>
					<b>Periodicidad: </b> 12
				</li>
				<li>
					<b>Comisión de apertura: </b> 0
				</li>
				<li>
					<b>Comisión de gestión:</b> 0
				</li>
				<li>
					<b>Gastos fijos bancarios:</b> 0
				</li>
				<li>
					<b>Gastos adicionales: </b> 0
				</li>
				<li>
					<b>Comisión de cancelación anticipada :</b> 0
				</li>
				<li>
					<b>Prepagable (1) o pospagable (0) : </b> 0
				</li>
			</ul>
           
			<ul class='pricing-table col-lg-4'>
			<h4> Resultados: </h4>
				<li>
					<b>Comisión de apertura: </b> 0
				</li>
				<li>
					<b>Comisión de gestión: </b> 0
				</li>
				<li>
					<b>Capital efectivo: </b> {{x.prestamo_inicial}}
				</li>
				<li>
					<b>T.A.E. real </b>  {{x.tasa_ea}} %
				</li>
				<li>
					<b > resultado </b> {{x.tasa_ea/12}}
				</li>
				
			</ul>
			<br>
			<table class="table table-striped table-bordered table-hover table-full-width " id="tabla_indicador">
				<thead>
					<tr>
						<th class="hidden-xs">Periodos de pago MENSUAL</th>
						<th class="hidden-xs">Cuota </th>
						<th class="hidden-xs">Pago de intereses</th>
						<th class="hidden-xs"> Amortización del principal</th>
						<th class="hidden-xs"> Amortización acumulada del principal</th>
						<th class="hidden-xs"> Capital pendiente</th>
						<th class="hidden-xs"> Importe de la comisión de cancelación</th>
						<th class="hidden-xs"> Coste de cancelación</th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							0
						</td>

						<td>
							170000
						</td>

						<td>
							88829
						</td>

						<td>
							37391
						</td>

						<td>
							82819
						</td>

						<td>
							93931
						</td>

						<td>
							1982882
						</td>

						<td>
							288393
						</td>
					<tr>



				</tbody>
			</table>




		</div>
	</div>

</div>

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url() ?>js/angular.min.js"></script>



<script>
	var app = angular.module('myApp', []);

	app.controller('myCtrl', function($scope, $http) {
		$scope.getData = function(argument) {
			$http({
				method: 'POST',
				url: 'mis_tab_amortizacion_data'
			}).then(function successCallback(response) {
				console.log(response.data);
				$scope.deudas = response.data.Resources

			}, function errorCallback(response) {
				console.log(response.data);

			});
		}

		$scope.getData()

	});
</script>


<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript">
	$("#TituloPagNav").html("Usuarios - Mi Perfil");
	$("#TituloPag").html("Flujo de dinero<small> Mis Tablas Amortizacion </small>");
</script>

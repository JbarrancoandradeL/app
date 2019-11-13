<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css"
    rel="stylesheet" />

<div id="myApp" ng-app="myApp" ng-controller="myCtrl">

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12">
                    <!-- start: DYNAMIC TABLE PANEL -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i> Indicadores Financieros
                            <div class="panel-tools">
                                
                            </div>
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover table-full-width "
                                id="tabla_indicador">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs">Nivel de Endeudamiento </th>
                                        <th class="hidden-xs">Indicador de Riqueza </th>
                                        <th class="hidden-xs">
                                            Flujo de caja ( COP )
                                        </th>
                                        <th class="hidden-xs"> Indice de deuda </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in names">
                                        <td>{{x.NvlEndeuda}}</td>
                                        <td>
                                            {{x.riqueza}}
                                        </td>
                                        <td> {{x.FlujoCaja}}</td>
                                        <td>{{x.indiceDeuda}}</td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end: DYNAMIC TABLE PANEL -->
                </div>
            </div>

        </div>
    </div>

</div>

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url() ?>js/angular.min.js"></script>



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
            
            $http({ method: 'POST', url: 'mis_indicadores_user' }).then(function successCallback(response) {
                console.log(response.data);
                $scope.names = response.data.reporte
            


          }, function errorCallback(response) { 
            console.log( response.data);
          });

             
        }


       
        $scope.listar();

    });

</script>


<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript">
$("#TituloPagNav").html("Usuarios - Mi Perfil");
$("#TituloPag").html("Flujo de dinero<small> Mis Indicadores </small>");
</script>
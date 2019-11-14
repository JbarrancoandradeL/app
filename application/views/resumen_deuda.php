<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css"
    rel="stylesheet" />

<style type="text/css">
.well {
    min-height: 20px;
    padding: 0px;
    margin-bottom: 20px;
    background-color: #D9D9D9;
    border: 1px solid #D9D9D9;
    border-radius: 0px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
    padding-left: 15px;
    border: 0px;
}

.thumbnail .caption {
    padding: 9px;
    color: #333;
    padding-left: 0px;
    padding-right: 0px;
}

.icon-style {
    margin-right: 15px;
    font-size: 18px;
    margin-top: 20px;
}

p {
    margin: 3px;
}

.well-add-card {
    margin-bottom: 10px;
}

.btn-add-card {
    margin-top: 20px;
}

.thumbnail {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 6px solid #D9D9D9;
    border-radius: 15px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
    padding-left: 0px;
    padding-right: 0px;
}

.btn {
    border-radius: 0px;
}

.btn-update {
    margin-left: 15px;
}

.enMoney::before {
    content: "$";
}

.negMoney {
    color: red;
}
</style>
<div id="myApp" ng-app="myApp" ng-controller="myCtrl">
    <div class="container" id="tourpackages-carousel">
        <div class="row">

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="thumbnail">
                    <div class="caption">
                        <div class='col-lg-12'>
                            <span class="glyphicon glyphicon-credit-card"></span>

                        </div>
                        <div class='col-lg-12 well well-add-card'>
                            <h4>Resumen Deuda</h4>
                        </div>
                        <div class='pricing-table col-lg-12'>
                            <ul>
                                <li>
                                    <b>Tiempo</b> 3 Años
                                </li>
                                <li>
                                    <b>Total Intereses</b> <span class='enMoney'> 245.000.00</span>
                                </li>
                                <li>
                                    <b>Capital</b> $ 400000
                                </li>
                                <li>
                                    <b>Tasa de interés</b> 25.3 % E.A
                                </li>
                          
                            </ul>

                        </div>
                        <button type="button" class="btn btn-primary btn-xs btn-update btn-add-card">Simular</button>

                    </div>
                </div>
            </div>


        </div><!-- End row -->
    </div><!-- End container -->
</div>

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url() ?>js/angular.min.js"></script>

<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript">
$("#TituloPagNav").html("Usuarios - Mi Perfil");
$("#TituloPag").html("Mi Resumen deudas <small> Conocer mi estado financiero</small>");
</script>

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
            
            $http({ method: 'POST', url: 'resumen_deuda_usr' }).then(function successCallback(response) {
                console.log(response.data);
                $scope.names = response.data.reporte
            


          }, function errorCallback(response) { 
            console.log( response.data);
          });

             
        }


       
        $scope.listar();

    });

</script>

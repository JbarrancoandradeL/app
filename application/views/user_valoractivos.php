
<script src="<?php echo base_url() ?>js/angular.min.js"></script>
<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskMoney.js"></script>

<div ng-app="myApp" ng-controller="myCtrl">
 

<div id="espere_ini" style="text-align: center; padding: 100px;">
    <li class="fa fa-spinner fa-4x fa-spin" ></li>
</div>

<div id="array_lista" ng-repeat="(key, cat) in array_categorias" ng-show="key == index_cat" class="panel panel-heading panel-default ocultar temp_ocultar col-sm-8">

    
        <i class="fa fa-external-link-square"></i> {{cat.nombre}} 
    
    <div class="panel-body" >
        <table class="table" id="sample-table-1">   

                <tr ng-repeat="(key, eg) in cat.activos">  
                    <td style="text-align: right;">{{eg.nombre_activo}} </td>
                    <input type="hidden" value="{{eg.codigo_activo}}"  id="{{eg.codigo_activo}}">                    
                    <td>
                       <input type="text" style="text-align: right; " value="{{eg.valor | currency: '$ ':2}}" class="form-control currency" id="valor_{{eg.codigo_activo}}"  >
                    </td>
                </tr>

        </table>
    </div>
     <div style="margin-bottom: 20px;">
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center;"> 
                        <button id="btn_save" ng-click="save_valores_activos(0)" ng-show="index_cat > 0" data-style="expand-right" class="btn btn-success ladda-button">
                        <span class="ladda-label"> Anterior </span>
                        <i class="glyphicon glyphicon-log-in"></i>    
                        <span class="ladda-spinner"></span>
                        <span class="ladda-spinner"></span>
                        </button>
                    </td>

                    <td style="text-align: center;"> 

                        <button id="btn_save" ng-click="save_valores_activos(1)" data-style="expand-right" class="btn btn-success ladda-button">
                        
                        <span class="ladda-label" ng-show="index_cat < array_categorias.length - 1"> Siguiente </span>
                        <span class="ladda-label"ng-show="index_cat == array_categorias.length - 1"> Guardar </span>

                        <i class="glyphicon glyphicon-log-in"></i>    
                        <span class="ladda-spinner"></span>
                        <span class="ladda-spinner"></span>
                        </button>
                    </td>

                </tr>
            </table>
         </div>
</div>


<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript"> 
    $("#TituloPagNav").html("Anotar Activos");
    $("#TituloPag").html("Mapa de riquezas<small> Anotar Activos</small>"); 
       
</script>

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>

<script type="text/javascript"> 
    
    
    var app = angular.module('myApp', []);

    app.controller('myCtrl', function($scope) {
        
        $scope.index_cat = 0;   
        
        $scope.listar = function (result) {
              
            $.ajax({
                type: "POST",
                url: "get_activos_usuarios",
                // data: par,
                dataType: "json",
                cache: false,
                
                success: function (result) { 
                    
                    $scope.$apply( function ( ) { $scope.array_categorias = result; } );  

                    show_espere(0);
                    $(".currency").maskMoney({prefix:'$ ', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});
                }
            });  

        } 

        $scope.save_valores_activos = function (val = 0) { 

            show_espere(1);

            
            var bandera_salida = true;
            
            var save_activos = $scope.array_categorias[$scope.index_cat]['activos'];
            var array_save = new Array();
  
            $(":input[type=hidden]").each(function(){  
                
                var codigo_activo =  $(this).attr('id');
                var valor = $("#valor_" + codigo_activo).maskMoney('unmasked')[0];
                
                var temp = new Array(codigo_activo, valor); 
                array_save.push(temp);
 
            });

            if(!bandera_salida) return 0;

            $.ajax({
                type: "POST",
                url: "save_valores_activos",
                data: {datos_save : array_save},
                dataType: "json",
                cache: false,
                
                success: function (result) {  

                    if(val == 1) { 

                        if($scope.index_cat < $scope.array_categorias.length -1) { 
                            $scope.$apply(function() { $scope.index_cat ++; }); 
                        } 


                    } else {

                        if($scope.index_cat > 0) {
                            $scope.$apply(function() { $scope.index_cat --;  }); 
                        }
                    } 

                    show_espere(0);
                }
                
            }); 

           
        }
        
        $scope.listar();

    });
 

 function show_espere(val) {
     
     if(val == 1) {
        $("#espere_ini").removeClass("ocultar"); 
        $(".temp_ocultar").addClass("ocultar");

     } else {
        $("#espere_ini").addClass("ocultar"); 
        $(".temp_ocultar").removeClass("ocultar");
     }
 }



</script>


</div>

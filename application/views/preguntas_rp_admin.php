
<script src="<?php echo base_url() ?>js/angular.min.js"></script>

 <div id="myApp" ng-app="myApp" ng-controller="myCtrl"> 
	


<div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i> PREGUNTAS RP
                                <div class="panel-tools">
                                    <button onclick="open_nuevo_rp(0)" type="button" class="input-sm btn btn-success"> CREAR NUEVO </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th>CATEGORÍA</th>
                                            <th>ENUNCIADO</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        <tr ng-repeat="(key, p) in lista_preguntas">
                                            <td> <a href="" ng-click="open_nuevo_rp(p.codigo)"> {{p.categoria}} </a> </td>
                                            <td> {{p.enunciado}} </td> 
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>




<!-- Modal NUEVO -->
<div id="modal_nuevo_rp" class="modal fade" role="dialog">
  <div class="modal-dialog">

  	<form action="#" onsubmit="return save_update ()">
  		
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title_modal_add">- - - - -</h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
            <label for="form-field-22"> CATEGORÍA </label> 
            <input id="add_cate" required="" type="" name="" class="form-control">
        </div>

        <div class="form-group">
            <label for="form-field-22"> ENUNCIADO </label> 
            <textarea rows="5" required="" id="add_enun" style="resize: none;" rows="4" placeholder="" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="form-field-22"> PREGUNTA: </label>
            <textarea rows="3" required="" id="add_pre" style="resize: none;" rows="4" placeholder="" class="form-control"></textarea> 
        </div>
    
        <div class="form-group">
            <label for="form-field-22"> ESTADO </label>
            <select id="add_estado" class="form-control">
            	<option value="1"> ACTIVO </option>
            	<option value="0"> INACTIVO </option>
            </select>
        </div>



      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="btn_save_item">GUARDAR</button>
      </div>
    </div>
	</form>
  </div>


</div>


<script>
	
	var app = angular.module('myApp', []);
	
	app.controller('myCtrl', function($scope, $http) {
	  	
	  	$scope.lista_preguntas = [];

	  	$scope.listar = function (argument) {
	  		
	  		$http({ method: 'POST', url: 'get_preguntas_rp_admin' }).then(function successCallback(response) {
        		
	  			$scope.lista_preguntas = response.data;
	        
	          	// console.log($scope.lista_preguntas);

	 
	      }, function errorCallback(response) { 
	 	       
	      });

	  		 
	  	}


	  	$scope.open_nuevo_rp = function (codigo_save) { 
	  		open_nuevo_rp(codigo_save);
	  	}

	  	$scope.listar();

	});

</script>


<script type="text/javascript">

  	function save_update (argument) {
  		

  		var par =  "codigo=" + codigo_save;
  		    par += "&add_cate=" + $("#add_cate").val();
  		    par += "&add_enun=" + $("#add_enun").val();
		    par += "&add_pre=" + $("#add_pre").val(); 
		    par += "&add_estado=" + $("#add_estado").val();


  		set_disabled("btn_save_item", 1);

        $.ajax({
            type: "POST",
            url: "save_update_categoriaMRP",
            data: par,
            dataType: "json",
            cache: false,
            
            success: function (result) {

            	console.log(result);

            	if(result == 1) {
            		$.notify("PREGUNTA GUARDADA CON ÉXITO", "success");
            		$("#modal_nuevo_rp").modal("hide");
            		angular.element(document.getElementById('myApp')).scope().listar(); 
            	
            	} else if(result == 2) {
            		$.notify("PREGUNTA ACTUALIZADA CON ÉXITO", "success");
            		$("#modal_nuevo_rp").modal("hide");
                set_disabled("btn_save_item", 0);
            		angular.element(document.getElementById('myApp')).scope().listar(); 
            	}

                set_disabled("btn_save_item", 0);

            	// console.log(result); 

            }
        });


  		return false;
  	}



	 var codigo_save = 0;
    function open_nuevo_rp (code) {
        
        // console.log("code: " + code);

        codigo_save = code;

        if(codigo_save != 0) {

        	$("#title_modal_add").html("ACTUALIZAR PREGUNTA"); 

           	var par = "codigo=" + codigo_save; 
 
	        $.ajax({
	            type: "POST",
	            url: "get_preguntas_rp_admin_by_codigo",
	            data: par,
	            dataType: "json",
	            cache: false,
	            
	            success: function (result) {

                    console.log(result);
	 				
	 				$("#add_cate").val(result.categoria);
	 				$("#add_enun").val(result.enunciado);
					$("#add_pre").val(result.pregunta); 
					$("#add_estado").val(result.estado);
 	 				
 	 				$("#modal_nuevo_rp").modal({backdrop: 'static', keyboard: false}); 

	            	set_focus("add_cate");
	            }
	        });


	        } else {

				$("#add_cate").val("");
				$("#add_enun").val("");
				$("#add_pre").val(""); 
				$("#add_estado").val(1);
				$("#title_modal_add").html("CREAR NUEVA PREGUNTA"); 
	        	$("#modal_nuevo_rp").modal({backdrop: 'static', keyboard: false}); 

	            set_focus("add_cate");
	        }

    }


	$("#TituloPag").html("Rueda de la prosperidad <small id='subTituloPag'>Modulo de administración</small> ");  

 
    $("#TituloPagNav").html("Rueda de la prosperidad");
   


</script>
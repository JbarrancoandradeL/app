<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />

<div class="panel panel-default">                          
    <div class="panel-body">         
    	<form id="formModal" action="#" onsubmit="return save_datos_miperfil() ">        	
        <div class="col-sm-12"> <h3>DATOS GENERALES</h3>
             <div class="row">                
                <div class="col-sm-3">                     
                    <div class="form-group">
                        <label for="email">TIPO DE DOCUMENTO:</label>
                        <select class="form-control" id="add_tipo_doc" required="">
                            <option value="">SELECCIONE..</option>
                            <?php
                              $tipo_documentos = $array_data['tipo_doc']; 
                                foreach ($tipo_documentos as $key => $value) {?>                   
                                                    
                                   <option value="<?php  echo $key; ?>"><?php  echo $value; ?> </option>
                                 <?php  } ?> 
                                                                     
                        </select>
                    </div>
                </div>

                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">N° DOCUMENTO:</label>
                        <input type="number"  class="form-control" id="add_n_doc" required="">
                    </div>
                </div>
        	</div>
        	<div class="row">
                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">PRIMER NOMBRE:</label>
                        <input type="text" class="form-control" id="add_nombre1" required="">
                    </div>
                </div>

                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">SEGUNDO NOMBRE:</label>
                        <input type="text"  class="form-control" id="add_nombre2" >
                    </div>
                </div>
            
             
                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">PRIMER APELLIDO:</label>
                        <input type="text" class="form-control" id="add_apellido1" required="">
                    </div>
                </div>

                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">SEGUNDO APELLIDO:</label>
                        <input type="text"  class="form-control" id="add_apellido2">
                    </div>
                </div>
           </div>
           
            <div class="row">
                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">CORREO ELECTR&Oacute;NICO:</label>
                        <input type="email"  class="form-control" id="add_email" required="">
                    </div>
                </div>
                <div class="col-sm-3"> 
                    <div class="form-group">
                        <label for="email">N° TELEF&Oacute;NICO:</label>
                        <input type="tel" class="form-control" id="add_telefono" required="">
                    </div>
                </div>
           
                <div class="col-sm-3"> 
                    <div class="form-group">                      
                           <p> <label for="email">PA&Iacute;S:</label></p>                      
                            <label class="radio-inline">
                                <input type="radio" name="add_pais" id="add_pais"  value="CO" checked onclick="add_remove_o_pais(0)">
                                Col
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="add_pais" value="OT" onclick="add_remove_o_pais(1)">
                                Otro
                            </label>
                        </div>
             	</div>
                <div class="col-sm-3" id="clase_o_pais"> 
                    <div class="form-group">
                        <label for="email">¿C&Uacute;AL?:</label>
                        <input type="text" class="form-control " id="add_otro_pais" >
                    </div>
                </div>                
            </div>

            <div class="row">            
                <div class="col-sm-3" id="clase_dtto"> 
                    <div class="form-group">
                        <label for="email">DEPARTAMENTO:</label>
                        <select class="form-control" id="add_dtto" onchange="change_city(this.value)" >
                            <option value="">SELECCIONE..</option>
                            <?php
                              $dttos = $array_data['dtto']; 
                                foreach ($dttos as $key => $value) {?>                   
                                                    
                                   <option value="<?php  echo $value['codigo']; ?>"><?php  echo $value['nombre']; ?> </option>
                                 <?php  } ?> 
                        </select>
                    </div>
                </div>
                <div class="col-sm-3" id="clase_ciudad"> 
                    <div class="form-group">
                        <label for="email">CIUDAD:</label>
                        <select class="form-control" id="add_ciudad" >
                            <option value="">SELECCIONE..</option>
                        </select>
                    </div>
                </div>                 
       
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <label for="email">DIRECCI&Oacute;N:</label>
                         <input type="text" class="form-control" id="add_direccion" required="">
                    </div>
                </div>
                
        	</div>

        </div>
        <div class="col-sm-12"> <h3>CAMBIO DE CONTRASE&Ntilde;A</h3>
             <div class="row">
             	<div class="col-sm-4"> 
                    <div class="form-group">
                        <label for="email">CONTRASE&Ntilde;A: ACTUAL</label>
                        <input type="password" class="form-control " id="add_pass_actual" >
                    </div>
                </div>
                <div class="col-sm-4"> 
                    <div class="form-group">
                        <label for="email">NUEVA CONTRASE&Ntilde;A:</label>
                        <input type="password" class="form-control " id="add_pass" >
                    </div>
                </div>
                 <div class="col-sm-4"> 
                    <div class="form-group">
                        <label for="email">REPITA NUEVA CONTRASE&Ntilde;A:</label>
                        <input type="password" class="form-control " id="add_r_pass" >
                    </div>
                </div>                                      
         </div>           
        </div>
        <div>

            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: center;">                     	 
                        <button type="submit" id="btn_save_usuario"  data-style="expand-right" class="btn btn-success ladda-button">
                        <span class="ladda-label"> Guardar </span>
                        <i class="glyphicon glyphicon-log-in"></i>    
                        <span class="ladda-spinner"></span>
                        <span class="ladda-spinner"></span>
                        </button>
                    </td>
                </tr>
            </table>
         </div>
     </form>
    </div>
</div>

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>

<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript"> 
    $("#TituloPagNav").html("Usuarios - Mi Perfil");
    $("#TituloPag").html("Mi Perfil<small> Actualizar mis datos</small>");   
</script>
<!-- scripts que controla  -->
<script type="text/javascript"> 
	var city_data = [];
	var usuario_code = '';

	 function show_datos (argument) {

        $.ajax({
          type: "POST",
            url: "get_city_and_user_actual",
            // data: "id=" + id,
            dataType: "json",
            cache: false,
            
            success: function (result) {
                var datos_usuario =  result['user'];
                city_data =  result['citys'];               
            
              	usuario_code = datos_usuario[0]['usuario_code'];

                $("#add_tipo_doc").val(datos_usuario[0]['tipo_documento']);
                $("#add_n_doc").val(datos_usuario[0]['documento']);
                $("#add_nombre1").val(datos_usuario[0]['nombre1']);
                $("#add_nombre2").val(datos_usuario[0]['nombre2']);
                $("#add_apellido1").val(datos_usuario[0]['apellido1']);
                $("#add_apellido2").val(datos_usuario[0]['apellido2']);
                $("#add_email").val(datos_usuario[0]['correo']);
                $("#add_telefono").val(datos_usuario[0]['telefono']);
                $('input:radio[name=add_pais][value='+datos_usuario[0]['pais']+']').prop('checked', 'checked');

                //Para cambiar las opciones de paises
                if(datos_usuario[0]['pais'] == 'CO') add_remove_o_pais (0);
                else add_remove_o_pais (1);


	            $("#add_otro_pais").val(datos_usuario[0]['otro_pais']);
	            $("#add_dtto").val(datos_usuario[0]['departamento']);
                    
                change_city(datos_usuario[0]['departamento']);//Se actualzia el selector de ciudades. 
                $("#add_ciudad").val(datos_usuario[0]['ciudad']);

                $("#add_direccion").val(datos_usuario[0]['direccion']);
                    
            
        }

        });


    }
    function save_datos_miperfil(){
    	set_disabled("btn_save_usuario", 1);

		var add_tipo_doc  = $("#add_tipo_doc").val();
		var add_n_doc     = $("#add_n_doc").val();
		var add_nombre1   = $("#add_nombre1").val();
		var add_nombre2   = $("#add_nombre2").val();
		var add_apellido1 = $("#add_apellido1").val();
		var add_apellido2 = $("#add_apellido2").val();
		var add_email     = $("#add_email").val();
		var add_telefono  = $("#add_telefono").val();
		var add_pais      = $('input:radio[name=add_pais]:checked').val();
		var add_otro_pais = $("#add_otro_pais").val();
		var add_dtto      = $("#add_dtto").val();
		var add_ciudad    = $("#add_ciudad").val();
		var add_direccion = $("#add_direccion").val();
         
        var add_pass_actual= $("#add_pass_actual").val();       
        var add_pass      = $("#add_pass").val();
        var add_r_pass    = $("#add_r_pass").val();


        // PARA VALIDAR LOS CAMPOS DE CONTRASEÑA
        if(add_pass_actual != "" && add_pass == ""){
        	$("#add_pass").notify("DEBE INGRESAR NUEVA CONTRASEÑA", "error");
			$("#add_pass").focus();
			set_disabled("btn_save_usuario", 0);
			return false;
        }

        if(add_pass_actual == "" && add_pass != ""){
        	$("#add_pass_actual").notify("DEBE INGRESAR CONTRASEÑA ACTUAL", "error");
			$("#add_pass_actual").focus();
			set_disabled("btn_save_usuario", 0);
			return false;
        }

		if(add_pass != add_r_pass){
			$("#add_r_pass").notify("LA CONTRASEÑA NO COINCIDE", "error");
			$("#add_r_pass").focus();
			set_disabled("btn_save_usuario", 0);
			return false;
		}

          var array_save = {
            "usuario_code" : usuario_code,
            "add_tipo_doc" : add_tipo_doc,
            "add_n_doc" : add_n_doc,
            "add_nombre1" : add_nombre1,
            "add_nombre2" : add_nombre2,
            "add_apellido1" : add_apellido1,
            "add_apellido2" : add_apellido2,            
            "add_email" : add_email,
            "add_telefono" : add_telefono,            
            "add_pais" : add_pais,
            "add_otro_pais" : add_otro_pais,
            "add_dtto" : add_dtto,
            "add_ciudad" : add_ciudad, 
            "add_direccion" : add_direccion,              
            "add_pass_actual" : add_pass_actual,
            "add_pass" : add_pass,
            "add_r_pass" : add_r_pass
          };
          
          $.ajax({
              type: "POST",
              url: "save_usuario_actual",
              data: {datos_save : array_save},
              dataType: "json",
              cache: false,
              
              success: function (result) {  
                console.log(result);                
                if(result == 0) {
                  $.notify("USUARIO ACTUALIZADO CON ÉXITO", "success");
                  show_datos();
                }else if(result==1){
                  $("#add_pass_actual").notify("CONTRASEÑA INCORRECTA", "error");
                  $("#add_pass_actual").focus();
                }else if(result==2){
                  $.notify("ERROR AL ACTUALZIAR CONTRASEÑA", "error");                  
                }else if(result==3){
                  $.notify("ERROR AL ACTUALZIAR USUARIO", "error");                  
                }
                set_disabled("btn_save_usuario", 0);
                return false;
              }
              
          }); 
          return false;       
    }
	function add_remove_o_pais (val){
	    if (val==1) {
	          // console.log("Otro");
	        $("#clase_o_pais").removeClass("ocultar");
	        
	        set_required("add_otro_pais",1);

	        set_required("add_dtto",0); 
	        set_required("add_ciudad",0);

	        $("#clase_dtto").addClass("ocultar");
	        $("#clase_ciudad").addClass("ocultar"); 
	   
	    }else{
	        // console.log("Colombia");   
	        $("#clase_dtto").removeClass("ocultar");
	        $("#clase_ciudad").removeClass("ocultar");
	        set_required("add_dtto",1); 
	        set_required("add_ciudad",1);

	        
	        set_required("add_otro_pais",0);
	        $("#clase_o_pais").addClass("ocultar");        

	        
	    }
	}
	//Esta función permite cambiar las ciudaddes dependiendo de los departamentos.

    function change_city(id_dtto) {
      var code_select = '<option value="">SELECCIONE...</option>';
      if(id_dtto != ""){
        for(x in city_data) {        
          if(parseInt(city_data[x]['codigo_dtto']) == id_dtto){          
            code_select += '<option value="' + city_data[x]['id_municipio'] + '"> ' + city_data[x]['municipio'] + ' </option>'; 
              
          }
        }
      }
      $("#add_ciudad").html(code_select);
        
    }
    show_datos();
</script>
function go_top (e = '') {
 	
 	console.log("go_top: " + e);
 	
 	if(e == '') {

	 	$("html, body").animate({
		        scrollTop: 0
	    }, "slow");

 	} else {
		
		$("" + e).animate({
		        scrollTop: 0
	    }, "slow");

 	}
	 
	 // e.preventDefault();
}

function set_focus(id) {
	
	setTimeout(function(){ $("#" + id).focus() }, 500);

}


function set_disabled( id = '', val = 1) {
	
	if(val == 1) {
		 $("#" + id).prop("disabled", true);
	} else {
		$("#" + id).prop("disabled", false);
	}
}

function set_required( id = '', val = 1) {	
	if(val == 1) {
		 $("#" + id).prop("required", true);
	} else {
		$("#" + id).prop("required", false);
	}
}
function set_readOnly(id='',val = 1){
    	if(val == 1) {
	        // Ponemos el atributo de solo lectura
	        $("#"+id).attr("readonly","readonly");
	        // Ponemos una clase para cambiar el color del texto y mostrar que esta deshabilitado
	         $("#"+id).css('background-color', '#dbd5cd');
	         $("#"+id).css('color', '#000000');
	         
    	}else{
    		 // Eliminamos el atributo de solo lectura
	        $("#"+id).removeAttr("readonly");
	        // Eliminamos la clase que hace que cambie el color
	         $("#"+id).css('background-color', '#ffffff');	         
	         $("#"+id).css('color', '#969696');
    	}
}

<?php 

	class Model_Amortizacion extends CI_Model { 	

        
		// INICIO DE FUNCIONES DE EL VERDADERO MODULO RP

		// Reporte del lado del administrador
		function get_data_amortizacion_all($value='') {
            $codigo_usuario = $this->session->userdata('user_code');	

		//	$frm_data = $this->input->post();
            
		// return "HOLA"; 
			$rt['Resources'] = $this->db->query("SELECT  valor_deudas.acreedor,valor_deudas.plazo,valor_deudas.tiempo_restante,
			valor_deudas.tasa_ea,valor_deudas.cuota_mensual,valor_deudas.saldo_deuda,
			valor_deudas.fecha_inicio_deuda,valor_deudas.prestamo_inicial,ROUND((valor_deudas.plazo/12)) as plazoA
			from valor_deudas            
	        WHERE valor_deudas.codigo_usuario ='$codigo_usuario' ")->result_array();
			return $rt;

		}


	
	}

?>

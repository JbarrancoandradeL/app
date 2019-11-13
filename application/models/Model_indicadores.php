<?php 

	class Model_indicadores extends CI_Model { 	

        
		// INICIO DE FUNCIONES DE EL VERDADERO MODULO RP

		// Reporte del lado del administrador
		function get_data_indicadores($value='') {
            $codigo_usuario = $this->session->userdata('user_code');	

		//	$frm_data = $this->input->post();
            
		// return "HOLA"; 
			$rt['reporte'] = $this->db->query("SELECT sum(valor_activos_usuarios.valor)/(sum(valor_deudas.saldo_deuda)) as NvlEndeuda,
            sum(valor_activos_usuarios.valor)-(sum(valor_deudas.saldo_deuda)) as riqueza,
            sum(valor_ingresos_usuarios.valor) - sum(valor_egresos_usuarios.valor) as FlujoCaja,
            sum(valor_deudas.saldo_deuda)/sum(valor_egresos_usuarios.valor) as indiceDeuda
      FROM `usuarios` 
          LEFT join valor_deudas on valor_deudas.codigo_usuario = usuarios.codigo
          left join valor_activos_usuarios on valor_activos_usuarios.codigo_usuario = usuarios.codigo
          left join valor_ingresos_usuarios on valor_ingresos_usuarios.codigo_usuario = usuarios.codigo
          left join valor_egresos_usuarios  On valor_egresos_usuarios.codigo_usuario  = usuarios.codigo
          WHERE usuarios.codigo='$codigo_usuario'")->result_array();

			return $rt;

		}


	
	}

?>
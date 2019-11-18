<?php 

	class Model_indicadores extends CI_Model { 	

        
		// INICIO DE FUNCIONES DE EL VERDADERO MODULO RP

		// Reporte del lado del administrador
		function get_data_indicadores($value='') {
            $codigo_usuario = $this->session->userdata('user_code');	

		//	$frm_data = $this->input->post();
            
		// return "HOLA"; 
			$rt['Resources'] = $this->db->query("SELECT deudat.TotalDeuda,ActiTb.TotalAct,Ingresotb.TotalIng,Egresostb.TotalEgre
			FROM usuarios 
			LEFT JOIN (select SUM(valor_activos_usuarios.valor) as TotalAct,valor_activos_usuarios.codigo_usuario,valor_activos_usuarios.codigo_evento
				    FROM valor_activos_usuarios 
				    GROUP BY  valor_activos_usuarios.codigo_usuario, valor_activos_usuarios.codigo_evento
				    )  ActiTb  ON  ActiTb.codigo_usuario = usuarios.codigo                                      
			LEFT JOIN (select SUM(valor_deudas.saldo_deuda) as TotalDeuda,codigo_usuario,codigo_evento
				    FROM valor_deudas 
				    GROUP BY  valor_deudas.codigo_usuario, valor_deudas.codigo_evento
				    )  deudat  ON  deudat.codigo_usuario = usuarios.codigo      
								   
			LEFT JOIN (select SUM(valor_ingresos_usuarios.valor) as TotalIng,codigo_usuario,codigo_evento
				    FROM valor_ingresos_usuarios 
				    GROUP BY  valor_ingresos_usuarios.codigo_usuario, valor_ingresos_usuarios.codigo_evento
				    )  Ingresotb  ON  Ingresotb.codigo_usuario = usuarios.codigo   
				    
			LEFT JOIN (select SUM(valor_egresos_usuarios.valor) as TotalEgre,codigo_usuario,codigo_evento
				    FROM valor_egresos_usuarios 
				    GROUP BY  valor_egresos_usuarios.codigo_usuario, valor_egresos_usuarios.codigo_evento
				    )  Egresostb  ON  Egresostb.codigo_usuario = usuarios.codigo             
			WHERE usuarios.codigo='$codigo_usuario'")->result_array();

			return $rt;

		}


	
	}

?>

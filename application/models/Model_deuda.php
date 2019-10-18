<?php 

	class Model_deuda extends CI_Model { 

	 	function save_deuda($value='') {
	 		
	 		$frm_data 	= $this->input->post();
			
		 
			$acreedor = $frm_data['acreedor'];
			$tipo_deuda = $frm_data['tipo_deuda'];
			$plazo = $frm_data['plazo'];
			$tiempo_rest = $frm_data['tiempo_rest'];
			$tasa = $frm_data['tasa'];
			$cuota = $frm_data['cuota'];
			$prestamo = $frm_data['prestamo'];
			$saldo = $frm_data['saldo'];
			$fecha_ini = $frm_data['fecha_ini'];
			$codigo_deuda = $frm_data['codigo_deuda'];


			$codigo_usuario = $this->session->userdata('user_code');

			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 


			if($codigo_deuda == '0') {
				// insert

				$next_id = $this->db->query("SELECT (MAX(p.id) + 1) next_id FROM `valor_deudas` p ")->result_array()[0]['next_id'];
				$next_id = ($next_id == null)? 1 : $next_id;
				$new_code = $this->Model_general->get_new_code("DUD", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA

				$isnert = $this->db->query("INSERT INTO `valor_deudas` (`codigo_usuario`, `codigo_evento`, `codigo_deuda`, `acreedor`, `tipo_deuda_id`, `plazo`, `tiempo_restante`, `tasa_ea`, `cuota_mensual`, `prestamo_inicial`, `saldo_deuda`, `fecha_inicio_deuda`) 
					VALUES ('$codigo_usuario', '$codigo_evento', '$new_code', '$acreedor', '$tipo_deuda', '$plazo', '$tiempo_rest', '$tasa', '$cuota', '$prestamo', '$saldo', '$fecha_ini');");

				return 1;

			} else {

				// Update

				$update = $this->db->query("UPDATE `valor_deudas` v
				SET v.acreedor = '$acreedor',
				 v.tipo_deuda_id = '$tipo_deuda',
				 v.plazo = '$plazo',
				 v.tiempo_restante = '$tiempo_rest',
				 v.tasa_ea = '$tasa',
				 v.cuota_mensual = '$cuota',
				 v.prestamo_inicial = '$prestamo',
				 v.saldo_deuda = '$saldo',
				 v.fecha_inicio_deuda = '$fecha_ini'
				WHERE v.codigo_deuda = '$codigo_deuda' ");

				return 2;
			}

			return 3;
			 
	 	}


	 	function get_deudas_by_code($value='') {
	 		
 			$codigo_usuario = $this->session->userdata('user_code');

			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 

			$frm_data 	= $this->input->post();
			$codigo_deuda = $frm_data['codigo_deuda'];

	 		$data = $this->db->query("SELECT
											d.codigo_deuda,
											d.acreedor,
											d.plazo,
											d.tiempo_restante,
											d.tasa_ea,
											d.cuota_mensual,
											d.prestamo_inicial,
											d.saldo_deuda,
											d.fecha_inicio_deuda,
											t.nombre tipo_deuda,
											t.id tipo_deuda_id 
										FROM
											`valor_deudas` d 
										INNER JOIN tipo_deuda t on t.id = d.tipo_deuda_id
										WHERE d.eliminado = 0 
											AND d.codigo_usuario = '$codigo_usuario' 
											and d.codigo_evento = '$codigo_evento'
											and d.codigo_deuda = '$codigo_deuda'; ")->result_array()[0];

	 		return $data;

	 	}

	 	function get_user_deudas($value='') {
	 		
	 		$codigo_usuario = $this->session->userdata('user_code');

			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 

	 		$data = $this->db->query("SELECT
											d.codigo_deuda,
											d.acreedor,
											d.plazo,
											d.tiempo_restante,
											d.tasa_ea,
											d.cuota_mensual,
											d.prestamo_inicial,
											d.saldo_deuda,
											d.fecha_inicio_deuda,
											t.nombre tipo_deuda
										FROM
											`valor_deudas` d 
										INNER JOIN tipo_deuda t on t.id = d.tipo_deuda_id
										WHERE d.eliminado = 0 
											AND d.codigo_usuario = '$codigo_usuario' 
											and d.codigo_evento = '$codigo_evento'; ")->result_array();

	 		return $data;

	 	}
	}
?>
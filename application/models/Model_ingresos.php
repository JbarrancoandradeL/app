<?php 

	class Model_ingresos extends CI_Model { 

		function save_valores_ingresos_usuario ($value='') {
			//Traer los datos del usuario actual y el evento al que pertenece
			$codigo_usuario = $this->session->userdata('user_code');						
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];

			
			$bandera = true;
			
			$frm_data = $this->input->post();
			$datos_save = $frm_data['datos_save'];
			
			$eliminar = $this->db->query("DELETE FROM valor_ingresos_usuarios WHERE codigo_usuario = '$codigo_usuario' 
										AND codigo_evento = '$codigo_evento'");

			foreach ($datos_save as $key => $value) {
				$codigo = $value[0]; //$this->Model_general->desencriptar($key);
				$valor = $value[1];
				$valor_adicional = $value[2]; 
				if($valor == "") $valor = 0;
				if($valor_adicional == "") $valor_adicional = 0;
				$insertar = $this->db->query("INSERT INTO valor_ingresos_usuarios (codigo_usuario, codigo_evento, codigo_ingreso, 
											valor, valor_adicional) 
											VALUES ('$codigo_usuario','$codigo_evento','$codigo', $valor, $valor_adicional)");
				if(!$insertar) $bandera = false;
			}	

			return $bandera;

		}
		// Devuelve todos los tipos de ingresos que esten activos y no eliminados
		// y los valores que cada usuario ha depositado en el 
			
		function get_ingresos_usuarios ( $value='') {

			//Traer los datos del usuario actual y el evento al que pertenece
			$codigo_usuario = $this->session->userdata('user_code');						
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];			



		 	$datos = $this->db->query("SELECT i.codigo, UPPER(i.nombre) nombre, i.tipo, 
		 							if(v.valor IS NULL, 0, v.valor) valor,
		 							if(v.valor_adicional IS NULL, 0, v.valor_adicional) valor_adicional		 							
		 							FROM `ingresos` i 
		 							LEFT JOIN valor_ingresos_usuarios v on v.codigo_usuario = '$codigo_usuario' AND v.codigo_evento = '$codigo_evento'
		 							AND v.codigo_ingreso = i.codigo
		 							WHERE i.eliminado = 0 AND i.estado = 1 
		 							ORDER BY i.tipo, i.nombre")->result_array();		 
	 		 		
			return $datos;
		} 
			// Devuelve todos los tipos de ingresos que no esten eliminados		
			//recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML
			// YA
		function get_ingresos ($link = 0) {

		 	$datos = $this->db->query("SELECT c.codigo, UPPER(c.nombre) nombre, c.tipo, c.estado FROM 
		 		`ingresos` c WHERE c.eliminado = 0 ORDER BY c.nombre;")->result_array();		
		 	
		 	if($link == "1") {
		 		foreach ($datos as $key => $value) {
		 			$datos[$key]['num'] = $key+1;
		 			$codigo_temp = $this->Model_general->encriptar($value['codigo']);
					$datos[$key]['nombre'] = '<a onclick="open_modal_ingresos(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';

					if($value['estado'] == 1) {
						$datos[$key]['estado'] = '<span class="label label-success">ACTIVO</span>';		

					} else if($value['estado'] == 0) {
						$datos[$key]['estado'] = '<span class="label label-danger">INACTIVO</span>';		
					}

					if($value['tipo'] == 'A') {
						$datos[$key]['tipo'] = '<span class="label label-default">ACTIVO</span>';		

					} else if($value['tipo'] == 'P') {
						$datos[$key]['tipo'] = '<span class="label label-warning">PASIVO</span>';		
					}  
				}
	 		}else{
	 			foreach ($datos as $key => $value) {	  				
	  				$datos[$key]['codigo'] = $this->Model_general->encriptar($value['codigo']);	  					  				
	 			}
	 		}	 		
			return $datos;
		} 
		// Devuelve los datos de un Ingreso
		// segun un codigo de Ingreso especificado
		// YA
		function get_ingresos_by_code ($value='') {			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT c.nombre, c.tipo, c.estado FROM `ingresos` c WHERE c.codigo = '$codigo'")->result_array();
			return $data;
		}
		// Permite almacenar en la BD un tipo de ingreso
		// 
		// YA
		function save_ingresos ($value='') {
			
			$next_id = $this->db->query("SELECT (MAX(c.id) + 1) maximo FROM `ingresos` c")->result_array();

			if($next_id == null) {
				$next_id = 1;
			} else {
				$next_id = (int) $next_id[0]['maximo'];
			}

			$new_code = $this->Model_general->get_new_code("IN", 10, $next_id);
			$frm_data = $this->input->post();

			$add_ingreso_tipo = $frm_data['add_ingreso_tipo'];
			$add_ingreso_estado = $frm_data['add_ingreso_estado'];

			$add_ingreso_name   = $frm_data['add_ingreso_name'];
			$add_ingreso_name = $this->Model_general->limpiar_cadena($add_ingreso_name);
			if(strlen($add_ingreso_name) == 0){$add_ingreso_name = "0";}
			$add_ingreso_code   = $frm_data['add_ingreso_code'];

			 

			if($add_ingreso_code == "0") {				
				
				$insert = $this->db->query("INSERT INTO `ingresos` (`codigo`, `nombre`, `tipo`, `estado`) 
											VALUES ('$new_code', '$add_ingreso_name', '$add_ingreso_tipo', '$add_ingreso_estado') ");
				if($insert) {					 
					return 1;
				} else {					
					return 0;
				}
			} else {
				// "ACTUALIZAR";
				$add_ingreso_code = $this->Model_general->desencriptar($add_ingreso_code);
				$update = $this->db->query("UPDATE ingresos c set c.nombre = '$add_ingreso_name', c.tipo = '$add_ingreso_tipo', c.estado = '$add_ingreso_estado' WHERE c.codigo = '$add_ingreso_code' ");
				if($update) {					 
					return 2;
				} else {					
					return 0;
				}

			} 
			return 0;
		}
		// Cambia el estad de eliminado de los tipos de ingreso 
		// 
		// ya
		function delete_ingresos ($value='') {
			
			$frm_data = $this->input->post();
			$add_ingreso_code = $frm_data['add_ingreso_code'];
			$add_ingreso_code = $this->Model_general->desencriptar($add_ingreso_code);
			$deleted = $this->db->query("UPDATE ingresos c set c.eliminado = '1'
												WHERE c.codigo = '$add_ingreso_code' ");

			return $deleted;
		}
	}
?>
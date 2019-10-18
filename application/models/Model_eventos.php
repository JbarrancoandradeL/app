<?php 

	class Model_eventos extends CI_Model { 
		

		function get_all_eventos_activos($con_html = 1) {
		 	
		 	$rt = $this->db->query("SELECT DATE_FORMAT(e.fecha_creado, '%d/%m/%Y %h:%i') fecha_creado, e.codigo, e.descripcion, e.estado FROM `eventos` e WHERE e.estado = 1")->result_array();

		 	if($con_html == 1) {
		 		
			 	foreach ($rt as $key => $value) {
			 		$rt[$key]['num'] = ($key+1);

			 		$rt[$key]['descripcion'] = ' <div class="mause_over_link" onclick="open_nuevo(' . "'" . $value['codigo'] . "'" .')"> ' . $value['descripcion'] . ' </div>  ';

			 		$rt[$key]['estado'] = ($value['estado'] == 1)? ' <span class="label label-success">ACTIVO</span> ' : ' <span class="label label-danger">INACTIVO</span>';

			 		// Boton abrir
			 		// $rt[$key]['abrir'] = ' <i onclick="open_nuevo(' . "'" . $value['codigo'] . "'" .')" class="fa fa-cogs cogs_list"> </i> ';

			 	}
		 	}

		 	return $rt;
		} 


		function get_all_eventos($con_html = 1) {
		 	
		 	$rt = $this->db->query("SELECT DATE_FORMAT(e.fecha_creado, '%d/%m/%Y %h:%i') fecha_creado, e.codigo, e.descripcion, e.estado FROM `eventos` e;")->result_array();

		 	if($con_html == 1) {
		 		
			 	foreach ($rt as $key => $value) {
			 		$rt[$key]['num'] = ($key+1);

			 		$rt[$key]['descripcion'] = ' <div class="mause_over_link" onclick="open_nuevo(' . "'" . $value['codigo'] . "'" .')"> ' . $value['descripcion'] . ' </div>  ';

			 		$rt[$key]['estado'] = ($value['estado'] == 1)? ' <span class="label label-success">ACTIVO</span> ' : ' <span class="label label-danger">INACTIVO</span>';

			 		// Boton abrir
			 		// $rt[$key]['abrir'] = ' <i onclick="open_nuevo(' . "'" . $value['codigo'] . "'" .')" class="fa fa-cogs cogs_list"> </i> ';

			 	}
		 	}

		 	return $rt;
		} 

		function save_evento ($value='') {
			
			$frm_data = $this->input->post();
 
			$codigo_evento = $frm_data['codigo_evento'];
			$descripcion = strtoupper( trim($frm_data['descripcion']) );
			$estado = $frm_data['estado'];


			if($codigo_evento == "0") {
				// GUARDAR


				$sig_id = $this->db->query("SELECT (MAX(e.id) +1 ) sig_id  FROM `eventos` e")->result_array()[0]['sig_id'];
				$new_codigo = $this->Model_general->get_new_code ("EV", 10, $sig_id);
				$fecha_creado = date("Y-m-d H:i:s");

				$insert = $this->db->query("INSERT INTO `eventos` (`codigo`, `descripcion`, `estado`, `fecha_creado`) 
											VALUES ('$new_codigo', '$descripcion', '$estado', '$fecha_creado');");

				return 1; // Insertado

			} else {

				$update = $this->db->query("UPDATE eventos e set e.descripcion = '$descripcion', e.estado = '$estado' 
												WHERE e.codigo = '$codigo_evento'");

				return 2; //"ACTUALIZADO";
			}

		}


		function get_evento_by_code ($value='') {
			
			$frm_data = $this->input->post();
 
			$codigo_evento = $frm_data['codigo_evento'];

			$rt = $this->db->query("SELECT UPPER(e.descripcion) descripcion, e.estado FROM `eventos` e WHERE e.codigo = '$codigo_evento'")->result_array()[0];

 			return $rt;

		}

		function validar_login($value = null) {
			
			$frm_data = $this->input->post();

			$user = strtolower(trim($frm_data['user']));
			$contra = md5($frm_data['contra']);

			$resultado = $this->db->query("SELECT u.usuario, u.codigo cuenta_codigo FROM `cuenta` u 
												WHERE u.usuario = '$user' and u.contrasena = '$contra';")->result_array();


			if($resultado == null) {
				
				return 0;

			} else {

				// return "ENTRO A LA SEGUNDA CONSULTA";

				$cuenta_codigo = $resultado[0]['cuenta_codigo']; 

				// return  $resultado;

				$rt = $this->db->query("SELECT
												u.nombre1, u.apellido1, u.codigo user_code, u.codigo_perfil
											FROM
												usuarios u
											WHERE
												u.codigo_cuenta = '$cuenta_codigo' AND u.estado = 1 LIMIT 1")->result_array();


				if($rt != null) {

					$set_session = array(
					    'codigo_perfil'  => $rt[0]['codigo_perfil'],
					    'nombre1'  => $rt[0]['nombre1'],
					    'apellido1'  => $rt[0]['apellido1'],
					    'user_code'     => $rt[0]['user_code']
					);

					$this->session->set_userdata($set_session);

					return 1;


				} else {

					return 0;
				}

				

			}

			// return $resultado;
		}
		

	}	

?>
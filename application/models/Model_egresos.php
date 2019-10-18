<?php 

	class Model_egresos extends CI_Model { 

		function save_valores_egresos($value='') {
			
			$codigo_usuario = $this->session->userdata('user_code');	
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];		

			$rt = $this->input->post();
			$datos_save = $rt['datos_save'];


			$this->db->query("DELETE FROM `valor_egresos_usuarios` 
							WHERE codigo_usuario = '$codigo_usuario' AND codigo_evento = '$codigo_evento';");

			foreach ($datos_save as $key => $value) {
				
				$codigo_egreso = $value[0];
				$valor = $value[1];
				$valor_hormiga = $value[2];
				if($valor == "") $valor = 0;
				if($valor_hormiga == "") $valor_hormiga = 0;
				$insert = $this->db->query("INSERT INTO `valor_egresos_usuarios` (`codigo_usuario`, `codigo_evento`, `codigo_egreso`, `valor`, `valor_hormiga`) 
												VALUES ('$codigo_usuario', '$codigo_evento', '$codigo_egreso', '$valor', '$valor_hormiga');");

			}

			return 1;

		}



		// Devuelve todos los tipos de ingresos que esten activos y no eliminados
		// y los valores que cada usuario ha depositado en el 			
		function get_egresos_usuarios ($value='') {

			$codigo_usuario = $this->session->userdata('user_code');
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];


			$datos = $this->db->query("SELECT 
											c.nombre, c.codigo codigo_categoria 
										FROM
											`categoria_egresos` c
											LEFT JOIN egresos e on e.categoria_egre_code = c.codigo AND e.eliminado = 0 AND e.estado = 1
										WHERE
											c.eliminado = 0 AND c.estado = 1 AND e.codigo IS NOT NULL GROUP BY c.codigo")->result_array();

			foreach ($datos as $key => $value) {
				
				$codigo_categoria = $value['codigo_categoria'];

				$datos[$key]['egresos'] = $this->db->query("SELECT UPPER(e.descripcion) nombre_egreso, e.codigo codigo_egreso,
																if(v.valor IS NULL, 0, v.valor) valor,
																FORMAT(if(v.valor IS NULL, 0, v.valor), 2) valor_formateado, 
																if(v.valor_hormiga IS NULL, 0, v.valor_hormiga) valor_hormiga
														FROM
																`egresos` e
														LEFT JOIN valor_egresos_usuarios v on v.codigo_usuario = '$codigo_usuario' 
														AND v.codigo_evento = '$codigo_evento' AND v.codigo_egreso = e.codigo
														WHERE e.categoria_egre_code = '$codigo_categoria' AND e.eliminado = 0 AND e.estado = 1")->result_array();
			}

			return $datos;
 
		} 

			// Devuelve todas las categorias de  egresos que no esten eliminadas		
			//recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML
			// 

		function get_categorias_egresos ($link = 0) {

		 	$datos = $this->db->query("SELECT c.codigo, UPPER(c.nombre) nombre, c.estado FROM 
		 		`categoria_egresos` c WHERE c.eliminado = 0 ORDER BY c.nombre;")->result_array();		
		 	
		 	if($link == "1") {
		 		foreach ($datos as $key => $value) {
		 			$datos[$key]['num'] = $key+1;
		 			$codigo_temp = $this->Model_general->encriptar($value['codigo']);
					$datos[$key]['nombre'] = '<a onclick="open_modal_cat_egresos(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';

					if($value['estado'] == 1) {
						$datos[$key]['estado'] = '<span class="label label-success">Activo</span>';		

					} else if($value['estado'] == 0) {
						$datos[$key]['estado'] = '<span class="label label-danger">Inactivo</span>';		
					} 
				}
	 		}else{
	 			foreach ($datos as $key => $value) {	  				
	  				$datos[$key]['codigo'] = $this->Model_general->encriptar($value['codigo']);	  					  				
	 			}
	 		}	 		
			return $datos;
		} 

		// Devuelve todas los tipos de egresos
		// que no esten eliminadas y que la categoria que la relaciona no esté eliminada		
		// recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML
		
		 function get_egresos ($link = 0) {
	 		$datos = $this->db->query("SELECT
													UPPER(p.descripcion) nombre,
													p.codigo,
													p.estado,
													UPPER(cp.nombre) cate_egres,
													cp.codigo code_categoria
											FROM
													`egresos` p
											INNER JOIN categoria_egresos cp on cp.codigo = p.categoria_egre_code AND cp.eliminado = 0
											WHERE
													p.eliminado = 0;")->result_array();
	 		if($link == 1) {
	 			foreach ($datos as $key => $value) {
	  				$datos[$key]['num'] = $key+1;
	  				$codigo_temp = $this->Model_general->encriptar($value['codigo']);
	  				$datos[$key]['nombre'] = '<a onclick="open_modal_egresos(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';
	  				$datos[$key]['code_categoria'] = $this->Model_general->encriptar($value['code_categoria']);
	  				if($value['estado'] == 1) {
						$datos[$key]['estado'] = '<span class="label label-success">Activo</span>';
					} else if($value['estado'] == 0) {
						$datos[$key]['estado'] = '<span class="label label-danger">Inactivo</span>';		
					} 
	 			}	
	 		}else{
	 			foreach ($datos as $key => $value) {	  				
	  				$datos[$key]['codigo'] = $this->Model_general->encriptar($value['codigo']);	  				
	  				$datos[$key]['code_categoria'] = $this->Model_general->encriptar($value['code_categoria']);	  				 
	 			}
	 		}
		 	return $datos;
		} 


		// Devuelve los datos de una categoria de egresos
		// segun un codigo de pregunta especificado
		//
		function get_categorias_egresos_by_code ($value='') {
			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT c.nombre, c.estado FROM `categoria_egresos` c WHERE c.codigo = '$codigo'")->result_array();
			return $data;
		}
		

		// Devuelve los datos de una  preguntas Rueda de la Prosperidad
		// segun un codigo de pregunta especificado
		//
		function get_egresos_by_code ($value='') {			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT
											p.descripcion nombre,									
											p.estado,
											cp.nombre cate_egres,
											cp.codigo code_categoria
									FROM
											`egresos` p
									INNER JOIN categoria_egresos cp on cp.codigo = p.categoria_egre_code AND cp.eliminado = 0
									WHERE
											p.eliminado = 0 AND p.codigo = '$codigo'")->result_array();

			foreach ($data as $key => $value) {
	  				$data[$key]['code_categoria'] = $this->Model_general->encriptar($value['code_categoria']);
	 		}
			return $data;

		}

		// Permite almacenar en la BD una categoria de egresos
		// 
		// 
		function save_categoria_egresos ($value='') {
			
			$next_id = $this->db->query("SELECT (MAX(c.id) + 1) maximo FROM `categoria_egresos` c")->result_array();

			if($next_id == null) {
				$next_id = 1;
			} else {
				$next_id = (int) $next_id[0]['maximo'];
			}

			$new_code = $this->Model_general->get_new_code("CE", 10, $next_id);
			$frm_data = $this->input->post();

			$add_cate_estado = $frm_data['add_cate_estado'];
			$add_cate_name   = $frm_data['add_cate_name'];
			$add_cate_name = $this->Model_general->limpiar_cadena($add_cate_name);
			if(strlen($add_cate_name) == 0){$add_cate_name = "0";}
			$add_cate_code   = $frm_data['add_cate_code'];
			
			
			// return $frm_data;

			if($add_cate_code == "0") {				
				//  "INSERTAR";

				$insert = $this->db->query("INSERT INTO `categoria_egresos` (`codigo`, `nombre`, `estado`) 
											VALUES ('$new_code', '$add_cate_name', '$add_cate_estado') ");
				if($insert) {					 
					return 1;
				} else {					
					return 0;
				}
			} else {
				// "ACTUALIZAR";
				$add_cate_code = $this->Model_general->desencriptar($add_cate_code);
				$update = $this->db->query("UPDATE categoria_egresos c set c.nombre = '$add_cate_name', c.estado = '$add_cate_estado' WHERE c.codigo = '$add_cate_code' ");
				if($update) {					 
					return 2;
				} else {					
					return 0;
				}

			} 
			return 0;
		}

		// Permite almacenar tipos de egresos en la BD
		// 
		// 
		function save_egresos($value='') {
			 
			$frm_data = $this->input->post();
			
			$add_egreso_categ = $frm_data['add_egreso_categ'];
			$add_egreso_code = $frm_data['add_egreso_code'];
			$add_egreso_estado = $frm_data['add_egreso_estado'];
			$add_egreso_name = strtoupper( trim($frm_data['add_egreso_name']) );
			$add_egreso_name = $this->Model_general->limpiar_cadena($add_egreso_name);
	
			if(strlen($add_egreso_name) == 0){$add_egreso_name = "0";}


			if($add_egreso_code == "0") {
				// Es nuevo, vamos a insertar la pregunta
					
				// BUSCAR CUAL SERIA EL NUEVO ID				
				$next_id = $this->db->query("SELECT (MAX(p.id) + 1) maximo FROM `egresos` p ")->result_array();

				$next_id = ($next_id == null)? 1 : (int) $next_id[0]['maximo'];

				$new_code = $this->Model_general->get_new_code("EG", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA

				$add_egreso_categ = $this->Model_general->desencriptar($add_egreso_categ);
				$insert = $this->db->query("INSERT INTO `egresos` (`descripcion`, `codigo`, `categoria_egre_code`, `estado`) 
												VALUES ('$add_egreso_name', '$new_code', '$add_egreso_categ', '$add_egreso_estado');");

				if($insert) {
					return 1; // INSERTADO CON EXITO
				} else {
					return 3; // ERROR INTERNO
				}

			} else {
				// ESTAMOS EDITANDO UNA PREGUNTA
				$add_egreso_code = $this->Model_general->desencriptar($add_egreso_code);
				$add_egreso_categ = $this->Model_general->desencriptar($add_egreso_categ);
				$update = $this->db->query("UPDATE egresos p set p.descripcion = '$add_egreso_name', p.categoria_egre_code = '$add_egreso_categ', p.estado = '$add_egreso_estado' 
												WHERE p.codigo = '$add_egreso_code'");

				if($update) {
					return 2; // INSERTADO CON EXITO
				} else {
					return 3; // ERROR INTERNO
				}

				return "ACTUALIZAR";
			}

		}

		// Cambia el estad de eliminado de un tipo de egreso
		// 
		// 
		function delete_egresos ($value='') {
			
			$frm_data = $this->input->post();
			$add_egreso_code = $frm_data['add_egreso_code'];
			$add_egreso_code = $this->Model_general->desencriptar($add_egreso_code);
			$deleted = $this->db->query("UPDATE egresos c set c.eliminado = '1'
												WHERE c.codigo = '$add_egreso_code' ");

			return $deleted;
		}

		// Cambia el estad de eliminado de las categorias de  egreso 
		// 
		// 
		function delete_categoria_egresos ($value='') {
			
			$frm_data = $this->input->post();
			$add_cate_code = $frm_data['add_cate_code'];
			$add_cate_code = $this->Model_general->desencriptar($add_cate_code);
			$deleted = $this->db->query("UPDATE categoria_egresos c set c.eliminado = '1'
												WHERE c.codigo = '$add_cate_code' ");

			return $deleted;
		}

	}

?>
<?php 

	class Model_activos extends CI_Model { 

		function save_valores_activos($value='') {
			
			$codigo_usuario = $this->session->userdata('user_code');	
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];		

			$rt = $this->input->post();
			$datos_save = $rt['datos_save'];


			$this->db->query("DELETE FROM `valor_activos_usuarios` 
							WHERE codigo_usuario = '$codigo_usuario' AND codigo_evento = '$codigo_evento';");

			foreach ($datos_save as $key => $value) {
				
				$codigo_activo = $value[0];
				$valor = $value[1];
				
				if($valor == "") $valor = 0;
				
				$insert = $this->db->query("INSERT INTO `valor_activos_usuarios` (`codigo_usuario`, `codigo_evento`, `codigo_activo`, `valor`)
											VALUES ('$codigo_usuario', '$codigo_evento', '$codigo_activo', '$valor');");

			}

			return 1;

		}

		// Devuelve todos los tipos de activos que esten activos y no eliminados
		// y los valores que cada usuario ha depositado en el 			
		function get_activos_usuarios ($value='') {

			$codigo_usuario = $this->session->userdata('user_code');
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];


			$datos = $this->db->query("SELECT 
											c.nombre, c.codigo codigo_categoria 
										FROM
											`categoria_activos` c
											LEFT JOIN activos a on a.categoria_activo_code = c.codigo AND a.eliminado = 0 AND a.estado = 1
										WHERE
											c.eliminado = 0 AND c.estado = 1 AND a.codigo IS NOT NULL GROUP BY c.codigo")->result_array();

			foreach ($datos as $key => $value) {
				
				$codigo_categoria = $value['codigo_categoria'];

				$datos[$key]['activos'] = $this->db->query("SELECT UPPER(a.descripcion) nombre_activo, a.codigo codigo_activo,
																if(v.valor IS NULL, 0, v.valor) valor,
																FORMAT(if(v.valor IS NULL, 0, v.valor), 2) valor_formateado
														FROM `activos` a
														LEFT JOIN valor_activos_usuarios v on v.codigo_usuario = '$codigo_usuario' 
														AND v.codigo_evento = '$codigo_evento' AND v.codigo_activo = a.codigo
														WHERE a.categoria_activo_code = '$codigo_categoria' AND a.eliminado = 0 AND a.estado = 1")->result_array();
			}

			return $datos;
 
		} 

		// Devuelve todas las categorias de  activos que no esten eliminadas		
		//recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML
		// 

		function get_categorias_activos ($link = 0) {

		 	$datos = $this->db->query("SELECT c.codigo, UPPER(c.nombre) nombre, c.estado FROM 
		 		`categoria_activos` c WHERE c.eliminado = 0 ORDER BY c.nombre;")->result_array();		
		 	
		 	if($link == "1") {
		 		foreach ($datos as $key => $value) {
		 			$datos[$key]['num'] = $key+1;
		 			$codigo_temp = $this->Model_general->encriptar($value['codigo']);
					$datos[$key]['nombre'] = '<a onclick="open_modal_cat_activos(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';

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
		// Devuelve todas los tipos de activos
		// que no esten eliminadas y que la categoria que la relaciona no esté eliminada		
		// recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML
		
		 function get_activos ($link = 0) {
	 		$datos = $this->db->query("SELECT
													UPPER(a.descripcion) nombre,
													a.codigo,
													a.estado,
													UPPER(ca.nombre) cate_acti,
													ca.codigo code_categoria
											FROM
													`activos` a
											INNER JOIN categoria_activos ca on ca.codigo = a.categoria_activo_code AND ca.eliminado = 0
											WHERE
													a.eliminado = 0;")->result_array();
	 		if($link == 1) {
	 			foreach ($datos as $key => $value) {
	  				$datos[$key]['num'] = $key+1;
	  				$codigo_temp = $this->Model_general->encriptar($value['codigo']);
	  				$datos[$key]['nombre'] = '<a onclick="open_modal_activos(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';
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

		// Devuelve los datos de una categoria de activos
		// segun un codigo de pregunta especificado
		//
		function get_categorias_activos_by_code ($value='') {
			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT c.nombre, c.estado FROM `categoria_activos` c WHERE c.codigo = '$codigo'")->result_array();
			return $data;
		}

		// Devuelve los datos de un activo 
		// segun un codigo especificado
		//
		function get_activos_by_code ($value='') {			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT
											a.descripcion nombre,									
											a.estado,
											ca.nombre cate_activo,
											ca.codigo code_categoria
									FROM
											`activos` a
									INNER JOIN categoria_activos ca on ca.codigo = a.categoria_activo_code AND ca.eliminado = 0
									WHERE
											a.eliminado = 0 AND a.codigo = '$codigo'")->result_array();

			foreach ($data as $key => $value) {
	  				$data[$key]['code_categoria'] = $this->Model_general->encriptar($value['code_categoria']);
	 		}
			return $data;

		}
		// Permite almacenar en la BD una categoria de egresos
		// 

		function save_categoria_activos ($value='') {
		
			$next_id = $this->db->query("SELECT (MAX(c.id) + 1) maximo FROM `categoria_activos` c")->result_array();

			if($next_id == null) {
				$next_id = 1;
			} else {
				$next_id = (int) $next_id[0]['maximo'];
			}

			$new_code = $this->Model_general->get_new_code("CA", 10, $next_id);
			$frm_data = $this->input->post();

			$add_cate_estado = $frm_data['add_cate_estado'];
			$add_cate_name   = $frm_data['add_cate_name'];
			$add_cate_name = $this->Model_general->limpiar_cadena($add_cate_name);
			if(strlen($add_cate_name) == 0){$add_cate_name = "0";}
			$add_cate_code   = $frm_data['add_cate_code'];
			
			
			
			if($add_cate_code == "0") {				
				//  "INSERTAR";

				$insert = $this->db->query("INSERT INTO `categoria_activos` (`codigo`, `nombre`, `estado`) 
											VALUES ('$new_code', '$add_cate_name', '$add_cate_estado') ");
				if($insert) {					 
					return 1;
				} else {					
					return 0;
				}
			} else {
				// "ACTUALIZAR";
				$add_cate_code = $this->Model_general->desencriptar($add_cate_code);
				$update = $this->db->query("UPDATE categoria_activos c set c.nombre = '$add_cate_name', c.estado = '$add_cate_estado' WHERE c.codigo = '$add_cate_code' ");
				if($update) {					 
					return 2;
				} else {					
					return 0;
				}

			} 
			return 0;
		}
		// Permite almacenar tipos de activos en la BD
		// 
		// 
		function save_activos($value='') {
			 
			$frm_data = $this->input->post();
			
			$add_activo_categ = $frm_data['add_activo_categ'];
			$add_activo_code = $frm_data['add_activo_code'];
			$add_activo_estado = $frm_data['add_activo_estado'];
			$add_activo_name = strtoupper( trim($frm_data['add_activo_name']) );
			$add_activo_name = $this->Model_general->limpiar_cadena($add_activo_name);
	
			if(strlen($add_activo_name) == 0){$add_activo_name = "0";}


			if($add_activo_code == "0") {
				// Es nuevo, vamos a insertar la pregunta
					
				// BUSCAR CUAL SERIA EL NUEVO ID				
				$next_id = $this->db->query("SELECT (MAX(p.id) + 1) maximo FROM `activos` p ")->result_array();

				$next_id = ($next_id == null)? 1 : (int) $next_id[0]['maximo'];

				$new_code = $this->Model_general->get_new_code("AC", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA

				$add_activo_categ = $this->Model_general->desencriptar($add_activo_categ);
				$insert = $this->db->query("INSERT INTO `activos` (`descripcion`, `codigo`, `categoria_activo_code`, `estado`) 
												VALUES ('$add_activo_name', '$new_code', '$add_activo_categ', '$add_activo_estado');");

				if($insert) {
					return 1; // INSERTADO CON EXITO
				} else {
					return 3; // ERROR INTERNO
				}

			} else {
				// ESTAMOS EDITANDO UNA PREGUNTA
				$add_activo_code = $this->Model_general->desencriptar($add_activo_code);
				$add_activo_categ = $this->Model_general->desencriptar($add_activo_categ);
				$update = $this->db->query("UPDATE activos p set p.descripcion = '$add_activo_name', p.categoria_activo_code = '$add_activo_categ', p.estado = '$add_activo_estado' 
												WHERE p.codigo = '$add_activo_code'");

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
		function delete_activos ($value='') {
			
			$frm_data = $this->input->post();
			$add_activo_code = $frm_data['add_activo_code'];
			$add_activo_code = $this->Model_general->desencriptar($add_activo_code);
			$deleted = $this->db->query("UPDATE activos c set c.eliminado = '1'
												WHERE c.codigo = '$add_activo_code' ");

			return $deleted;
		}

		// Cambia el estad de eliminado de las categorias de  egreso 
		// 
		// 
		function delete_categoria_activos ($value='') {
			
			$frm_data = $this->input->post();
			$add_cate_code = $frm_data['add_cate_code'];
			$add_cate_code = $this->Model_general->desencriptar($add_cate_code);
			$deleted = $this->db->query("UPDATE categoria_activos c set c.eliminado = '1'
												WHERE c.codigo = '$add_cate_code' ");

			return $deleted;
		}

	}


	

?>
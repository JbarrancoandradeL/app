<?php 

	class Model_preguntasrp extends CI_Model { 	

 
		// INICIO DE FUNCIONES DE EL VERDADERO MODULO RP

		// Reporte del lado del administrador
		function get_data_rep_admin_mrp($value='') {

			$frm_data = $this->input->post();

			$codigo_evento = $frm_data['codigo_evento'];
			// return "HOLA"; 
			$rt['reporte'] = $this->db->query("SELECT
										p.categoria,
										SUM( if(r.rta1 <= 5, 1, 0) ) as bajo,
										SUM( if(r.rta1 > 5 AND r.rta1 <= 8, 1, 0) ) as medio,
										SUM( if(r.rta1 > 8, 1, 0) ) as alto
									FROM
										`preguntasmrp` p
									LEFT JOIN respuestas_mrp r on r.codigo_preg = p.codigo
									WHERE r.codigo_evento = '$codigo_evento'
									GROUP BY p.codigo
									")->result_array();

			return $rt;

		}


		function get_eventos ($solo_activos  = 0) {

			if($solo_activos == 0) {

				$eventos = $this->db->query("SELECT e.codigo codigo_evento, descripcion, e.estado 
													FROM eventos e ORDER BY e.estado DESC")->result_array(); 
			} else {

				$eventos = $this->db->query("SELECT e.codigo codigo_evento, descripcion, e.estado 
													FROM eventos e WHERE e.estado = 1 ORDER BY e.estado DESC")->result_array(); 
			}

			return $eventos;

		}
		function get_preguntas_rp_admin($value='') {
			 
			$rt = $this->db->query("SELECT p.codigo, UPPER(p.enunciado) enunciado, UPPER(p.categoria) categoria, UPPER(p.pregunta) pregunta, p.estado FROM `preguntasmrp` p 
										WHERE p.eliminado = 0")->result_array();


			return $rt;

		}

		function get_preguntas_rp_admin_by_codigo($value='') {
			
			$frm_data = $this->input->post();

			$codigo = $frm_data['codigo'];

			$rt = $this->db->query("SELECT p.codigo, UPPER(p.enunciado) enunciado, UPPER(p.categoria) categoria, UPPER(p.pregunta) pregunta, p.estado FROM `preguntasmrp` p 
										WHERE p.eliminado = 0 AND p.codigo = '$codigo' ")->result_array()[0];

			return $rt;
		}


		function save_update_categoriaMRP($value='') {
			 
			$frm_data = $this->input->post();
			
			
			$add_cate 	= strtoupper( trim( $frm_data['add_cate'] ) );
			// return "HH";
			$add_pre 	= strtoupper( trim( $frm_data['add_pre'] ) ); 
			$add_enun 	= trim( $frm_data['add_enun'] );
			$add_estado = $frm_data['add_estado'];
			$codigo 	= $frm_data['codigo'];


			if($codigo == "0") {
 
				$next_id = $this->db->query("SELECT (MAX(p.id) + 1) next_id FROM `preguntasmrp` p ")->result_array()[0]['next_id']; 
				$next_id = ($next_id == null)? 1 : $next_id;
			 
				$new_code = $this->Model_general->get_new_code("PRP", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA

				$insert = $this->db->query("INSERT INTO `preguntasmrp` (`codigo`, `categoria`, `enunciado`, `pregunta`, `estado`) 
												VALUES ('$new_code', '$add_cate', '$add_enun', '$add_pre', '$add_estado');");

				if($insert) {
					return 1; // GUARDADO CON EXITO
				} else {
					return -1; // ERROR INTERNO
				}

			} else {


				$update = $this->db->query("UPDATE preguntasmrp p set p.categoria = '$add_cate', p.enunciado = '$add_enun', p.pregunta = '$add_pre', p.estado = '$add_estado'  WHERE p.codigo = '$codigo'");

				// return $frm_data;

				if($update) {
					return 2; // ACTUALIZADO CON EXITO
				} else {
					return -1; // ERROR INTERNO
				}

			}

			// return $rt;

		}



		// Traer todas las preguntas para que el usuario responda
		function get_preguntas_rp_user($value='') {
			
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 

			$codigo_usuario = $this->session->userdata('user_code');

			$rt['lista_preguntas'] = [];
			$rt['tabla_usuario'] = [];

			$rt['lista_preguntas'] = $this->db->query("SELECT
											p.codigo, p.enunciado, p.pregunta, if(r.rta1 IS NULL, 0, r.rta1) rta1, if(r.rta2 IS NULL, 0, r.rta2) rta2
										FROM
											`preguntasmrp` p 
										LEFT JOIN respuestas_mrp r on r.codigo_evento = '$codigo_evento' AND r.codigo_usuario = '$codigo_usuario' AND r.codigo_preg = p.codigo
										WHERE
											p.eliminado = 0
										AND p.estado = 1 AND r.rta1 IS NULL LIMIT 2
										 ")->result_array();

			if($rt['lista_preguntas'] == null) {
				$rt['tabla_usuario']['lista_sugeridos'] = $this->get_tabla_MRP_usuario();
				$rt['tabla_usuario']['grafica'] = $this->get_grafica_MRP_usuario();
			}

			return $rt;
			
		}

		function get_grafica_MRP_usuario($value='') {
			
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 

			$codigo_usuario = $this->session->userdata('user_code');

			$rt_temp = $this->db->query("SELECT
										p.categoria,
										if(r.rta1 IS NULL, 0, r.rta1) rta1, 
										if(r.rta2 IS NULL, 0, r.rta2) rta2
									FROM
										`respuestas_mrp` r
									INNER JOIN preguntasmrp p on p.codigo = r.codigo_preg
									WHERE
										r.codigo_evento = '$codigo_evento'
									AND r.codigo_usuario = '$codigo_usuario'")->result_array();


			$rt['categorias'] = [];
			$rt['valor_presente'] = [];
			$rt['valor_futuro'] = [];

			
			foreach ($rt_temp as $key => $value) {
			
				$isMobile = $this->isMobile();


				if($isMobile) {

					$rt['categorias'][] 	= (strlen($value['categoria']) > 18)? substr($value['categoria'], 0 , 16) . '...' : $value['categoria'] ;
					$rt['valor_presente'][] = $value['rta1'];
					$rt['valor_futuro'][]	= $value['rta2'];

				} else {

					$rt['categorias'][] 	= $value['categoria'];
					$rt['valor_presente'][] = $value['rta1'];
					$rt['valor_futuro'][]	= $value['rta2'];

				}

			}

			// print_r("<pre>");
			// print_r($rt);
			// exit();

			return $rt;

		}

		function isMobile() {

		    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

		}

		function get_tabla_MRP_usuario ($value='') {
			
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 

			$codigo_usuario = $this->session->userdata('user_code');

			$rt = $this->db->query("SELECT
										p.categoria, p.codigo codigo_pregunta, p.enunciado, p.pregunta, 
										if(r.rta1 IS NULL, 0, r.rta1) rta1, 
										if(r.rta2 IS NULL, 0, r.rta2) rta2
									FROM
										`preguntasmrp` p 
									LEFT JOIN respuestas_mrp r on r.codigo_evento = '$codigo_evento' AND r.codigo_usuario = '$codigo_usuario' AND r.codigo_preg = p.codigo
									WHERE
										p.eliminado = 0
									AND p.estado = 1 ORDER BY r.rta1
									 ")->result_array();


			// print_r($this->db->last_query());
			// exit();

			$retornar = [];

			$min = ($rt != null)? $rt[0]['rta1'] : 0;
 

			foreach ($rt as $key => $value) {


				if($value['rta1'] == $min) {
					// print_r($value['categoria'] . "<br>");
					$retornar[] = $value;					
				}
			}

			// exit();

			return $retornar;

		}

		function save_respuestas_MRP($value='') {
			
			$frm_data 	= $this->input->post();
			// return "HOLA";
			$respuestas = $frm_data['respuestas'];
			$codigo_preg = $respuestas['codigo'];
			$enunciado 	 = $respuestas['enunciado'];
			$pregunta 	 = $respuestas['pregunta'];
			$rta1 		 = $respuestas['rta1'];
			$rta2 		 = $respuestas['rta2']; 

			// return $codigo_preg;

			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 

			// $codigo_evento = $this->session->userdata('codigo_evento');	 
			$codigo_usuario = $this->session->userdata('user_code');

			$next_id = $this->db->query("SELECT (MAX(p.id) + 1) next_id FROM `respuestas_mrp` p ")->result_array()[0]['next_id'];
			$next_id = ($next_id == null)? 1 : $next_id;
			$new_code = $this->Model_general->get_new_code("RRP", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA
 


			$insert = $this->db->query("INSERT INTO `respuestas_mrp` (
										`codigo`,
										`codigo_evento`,
										`codigo_usuario`,
										`codigo_preg`,
										`rta1`,
										`rta2` 
									)
									VALUES
										('$new_code', '$codigo_evento', '$codigo_usuario', '$codigo_preg', '$rta1', '$rta2'); ");
		 	if($insert) {
	 			return 1; // Guardado con exito
		 	} else {
		 		return 2; // Error interno
		 	}
		}

		// FIN DE FUNCIONES DE EL VERDADERO MODULO RP

		function save_respuestas_pre ($value='') {			
			$frm_data = $this->input->post();

			$respuestas = $frm_data['respuestas'];
			

			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 

			// $codigo_evento = $this->session->userdata('codigo_evento');	 
			$codigo_usuario = $this->session->userdata('user_code');


			foreach ($respuestas as $key => $value) {				

				$next_id = $this->db->query("SELECT (MAX(p.id) + 1) next_id FROM `respuestas_cre_lim` p ")->result_array()[0]['next_id'];

				$next_id = ($next_id == null)? 1 : $next_id;
			
				// return $next_id;

				$new_code = $this->Model_general->get_new_code("RCL", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA


				$codigo_preg = $value['codigo'];
				$rta = $value['rta']; 

				// return $value;

				$insert = $this->db->query("INSERT INTO `respuestas_cre_lim` (
											`codigo`,
											`codigo_evento`,
											`codigo_usuario`,
											`codigo_preg`,
											`respuesta`
										)
										VALUES
											('$new_code', '$codigo_evento', '$codigo_usuario', '$codigo_preg', '$rta');

										");
			}			

	 		return 1;
		}

		function get_reporte_general_cre_lim($value='') {
			
			$frm_data = $this->input->post();

			$codigo_evento = $frm_data['codigo_evento'];
			$codigo_cat = $frm_data['codigo_cat'];

			// return $frm_data;

			$rm = $this->Model_general->rango_mensalidad( 0, $codigo_cat);

			$filtro1 = ($codigo_cat != '0')? " WHERE prp.categoria_code = '".$codigo_cat."' " : '';
			// WHERE prp.categoria_code = 'CP40221817170'

			$rt['lista'] = $this->db->query("SELECT
												r.codigo_usuario, 
												SUM(r.respuesta) sum_rta,  
												UPPER(CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ' , u.apellido2)) nombre_usuario
											FROM
												`respuestas_cre_lim` r
											INNER JOIN usuarios u on u.codigo = r.codigo_usuario AND r.codigo_evento = '$codigo_evento'
											INNER JOIN preguntasrp prp on prp.codigo = r.codigo_preg 
											$filtro1
											GROUP BY r.codigo_usuario;")->result_array();

			if($rt['lista'] == null) {
				return 0;
			}
			
			$total_ab = 0;
			$total_zc = 0;
			$total_es = 0;

			 

			foreach ($rt['lista'] as $key => $value) {
				
				if($value['sum_rta'] <= $rm['ab']) { 
					// Total mentalidad ABUNDANTE
					$rt['lista'][$key]['mentalidad'] = 'ab';
					$total_ab ++;

				} else if($value['sum_rta'] <= $rm['zc']) {
					// Total mentalidad zona de CONFORT
					$rt['lista'][$key]['mentalidad'] = 'zc';
					$total_zc ++;

				} else if($value['sum_rta']  <= $rm['es']) { 
					// Total mentalidad ESCASA
					$rt['lista'][$key]['mentalidad'] = 'es';
					$total_es ++;

				} 

			}


			// Total de personas
			$total_usuarios = count($rt['lista']);
			
			$rt['porc_ab']  = ( ($total_ab * 100) / $total_usuarios);
			$rt['porc_zc'] = ( ($total_zc * 100) / $total_usuarios);
			$rt['porc_es'] = ( ($total_es * 100) / $total_usuarios);

			return $rt;

		}
		
		function get_preguntas_usuarios ($value='') {	

			$codigo_usuario = $this->session->userdata('user_code');
			
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 

			// Arreglo a retornar
			$return_data['preguntas'] = [];
			$return_data['tabla_usuario'] = [];

			// return $estado_evento;

			if($estado_evento == 0 ) {

				// Como el evento esta inactivo ya - debo retornar la tabla usuario
				$return_data['tabla_usuario'] = $this->get_data_tabla_usuario();

				return $return_data;

			} else {
			  

			// Aqui trae todas las preguntas que no haya respondido el usuario que esta en session
			$resultado = $this->db->query("SELECT p.descripcion nombre, p.codigo, if(r.respuesta IS NULL, 0, r.respuesta) rta
													FROM `preguntasrp` p 
												LEFT JOIN respuestas_cre_lim r on r.codigo_evento = '$codigo_evento' AND r.codigo_preg = p.codigo AND r.codigo_usuario = '$codigo_usuario'
											WHERE p.eliminado = 0 AND r.respuesta IS NULL ORDER BY p.categoria_code ")->result_array();


			// El evento esta activo pero como no hay preguntas por responder - debo retornar la tabla usuario
			if($resultado == null) {
				
				$return_data['tabla_usuario'] = $this->get_data_tabla_usuario(); 
				return $return_data;

			} else {

				//De aqui en adelante si hay preguntar por responder y el evento si esta inactivo


				// Desordenar todas las preguntas
				shuffle($resultado);

				// Meter dos preguntas para retornar
				$contador = 1;
				foreach ($resultado as $key => $value) {				
					if($contador <= 5) {
						$return_data['preguntas'][] = $resultado[$key];
						$contador ++;
					} else {
						$resultado = null;
					}
				}

				// Retornar cuando el evento si esta activo y si hay preguntas por contestar
				return $return_data;
			}
 

			}
			
		}


		// TRae los datos de la tabla para el usuario una vez que ha terminado de responder todas las preguntas
		function get_data_tabla_usuario($value='') {
			 
			$codigo_usuario = $this->session->userdata('user_code');
			
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 	 

			// Traer el rango de mentalidad segun las preguntas que tenga
			$rm = $this->Model_general->rango_mensalidad();

			// Variable a retornar
			$rt = [];
 
			// Como el evento esta activo, traer todas las categorias de las preguntas actuales
			$rt['categorias'] = $this->db->query("SELECT
										UPPER(c.nombre) categoria, 
										COUNT(p.codigo) n_preguntas, 
										SUM(r.respuesta) puntos
									FROM
										`categoria_preguntas` c
									INNER JOIN preguntasrp p ON p.categoria_code = c.codigo
									INNER JOIN respuestas_cre_lim r on r.codigo_preg = p.codigo AND r.codigo_evento = '$codigo_evento' AND r.codigo_usuario = '$codigo_usuario'
									GROUP BY c.codigo
									ORDER BY
										c.nombre")->result_array();	
		 

		 	// Agregar Columna mentalidad
			foreach ($rt['categorias'] as $key => $value) {

				// Rango temporal de mentalidad por un numero dado
				$rango_temp = $this->Model_general->rango_mensalidad($value['n_preguntas']);


				// Asignar el tipo de mentalidad en la culumna
				if($value['puntos'] <= $rango_temp['ab']) {
					$rt['categorias'][$key]['mentalidad'] = "ABUNDANTE";

				} else if($value['puntos'] <= $rango_temp['zc']) {
					$rt['categorias'][$key]['mentalidad'] = "ZONA DE CONFORT";

				} else {
					$rt['categorias'][$key]['mentalidad'] = "ESCASA";
				}

			}



			// Calcuilando Totales
			$total['total_preguntas'] = 0;
			$total['total_puntos'] = 0;

			foreach ($rt['categorias'] as $key => $value) {
				$total['total_preguntas'] += $value['n_preguntas'];
				$total['total_puntos'] += $value['puntos'];
			}

			$rt['totales'][0] = $total;
			// FIN Calcuilando Totales


			// Calculando Informe
			$txt_mentalidad = "";
			if($rt['totales'][0]['total_puntos'] <= $rm['ab']) {
				$txt_mentalidad = " una mentalidad ABUNDANTE";

			} else if($rt['totales'][0]['total_puntos'] <= $rm['zc']) {
				$txt_mentalidad = " una mentalidad en ZONA DE CONFORT";

			} else {
				$txt_mentalidad = " una mentalidad ESCASA";
			}

			$rt['totales'][0]['informe'] = "Según las respuestas obtenidas en la encuesta cuyo puntaje es de " . $rt['totales'][0]['total_puntos'] . ", ud tiende" . $txt_mentalidad;

			// Fin Calculando Informe

			return $rt;

		}




	// Devuelve todas las categorias de  preguntas de Rueda de la Prosperidad
	// que no esten eliminadas		
	//recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML

		function get_categorias_preguntasrp ($link = 0) {

		 	$datos = $this->db->query("SELECT c.codigo, UPPER(c.nombre) nombre, c.estado FROM `categoria_preguntas` c WHERE c.eliminado = 0 ORDER BY c.nombre;")->result_array();		
		 	
		 	if($link == "1") {
		 		foreach ($datos as $key => $value) {
		 			$datos[$key]['num'] = $key+1;
		 			$codigo_temp = $this->Model_general->encriptar($value['codigo']);
					$datos[$key]['nombre'] = '<a onclick="open_modal_cat(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';

					if($value['estado'] == 1) {
						$datos[$key]['estado'] = '<span class="label label-success">Activo</span>';		

					} else if($value['estado'] == 0) {
						$datos[$key]['estado'] = '<span class="label label-danger">Inactivo</span>';		
					} 
				}
	 		}else{
	 			foreach ($datos as $key => $value) {	  				
	  				// $datos[$key]['codigo'] = $this->Model_general->encriptar($value['codigo']);	  					  				
	 			}
	 		}	 		
			return $datos;
		} 

	// Devuelve todas las preguntas de Rueda de la Prosperidad
	// que no esten eliminadas y que la categoria que la relaciona no esté eliminada		
	//recibe parametro 1 = devuelve con html, 0 = devuelve solo los datos sin HTML
		
		 function get_preguntasrp ($link = 0) {


	 		$datos = $this->db->query("SELECT
													UPPER(p.descripcion) nombre,
													p.codigo,
													p.estado,
													UPPER(cp.nombre) cate_preg,
													cp.codigo code_categoria
											FROM
													`preguntasrp` p
											INNER JOIN categoria_preguntas cp on cp.codigo = p.categoria_code AND cp.eliminado = 0
											WHERE
													p.eliminado = 0;")->result_array();
	 		if($link == 1) {
	 			foreach ($datos as $key => $value) {
	  				$datos[$key]['num'] = $key+1;
	  				$codigo_temp = $this->Model_general->encriptar($value['codigo']);
	  				$datos[$key]['nombre'] = '<a onclick="open_modal_preg(' . "'" . $codigo_temp . "'" . ') " href="javascript:void(0);"> ' . $value['nombre'] . ' </a>';
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

		// Devuelve los datos de una categoria de preguntas Rueda de la Prosperidad
		// segun un codigo de pregunta especificado
		//
		function get_categorias_preguntasrp_by_code ($value='') {
			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT UPPER(c.nombre) nombre, c.estado FROM `categoria_preguntas` c WHERE c.codigo = '$codigo'")->result_array();
			return $data;

		}
		// Devuelve los datos de una  preguntas Rueda de la Prosperidad
		// segun un codigo de pregunta especificado
		//
		function get_preguntasrp_by_code ($value='') {			
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];
			$codigo = $this->Model_general->desencriptar($codigo);
			$data = $this->db->query("SELECT
											p.descripcion nombre,									
											p.estado,
											cp.nombre cate_preg,
											cp.codigo code_categoria
									FROM
											`preguntasrp` p
									INNER JOIN categoria_preguntas cp on cp.codigo = p.categoria_code AND cp.eliminado = 0
									WHERE
											p.eliminado = 0 AND p.codigo = '$codigo'")->result_array();

			foreach ($data as $key => $value) {
	  				$data[$key]['code_categoria'] = $this->Model_general->encriptar($value['code_categoria']);
	 		}
			return $data;

		}

		// Cambia el estad de eliminado de una pregunta de Rueda de prosperidad
		// 
		// 
		function delete_preguntasrp ($value='') {
			
			$frm_data = $this->input->post();
			$add_preg_code = $frm_data['add_preg_code'];
			$add_preg_code = $this->Model_general->desencriptar($add_preg_code);
			$deleted = $this->db->query("UPDATE preguntasrp c set c.eliminado = '1'
												WHERE c.codigo = '$add_preg_code' ");

			return $deleted;
		}

		// Cambia el estad de eliminado de una categoria de pregunta de Rueda de prosperidad
		// 
		// 
		function delete_categoria_preguntasrp ($value='') {
			
			$frm_data = $this->input->post();
			$add_cate_code = $frm_data['add_cate_code'];
			$add_cate_code = $this->Model_general->desencriptar($add_cate_code);
			$deleted = $this->db->query("UPDATE categoria_preguntas c set c.eliminado = '1'
												WHERE c.codigo = '$add_cate_code' ");

			return $deleted;
		}


		function save_preguntarp($value='') {
			 
			$frm_data = $this->input->post();
			$add_preg_categ = $frm_data['add_preg_categ'];
			$add_preg_code = $frm_data['add_preg_code'];
			$add_preg_estado = $frm_data['add_preg_estado'];
			$add_preg_name = $frm_data['add_preg_name'];
			$add_preg_name = $this->Model_general->limpiar_cadena($add_preg_name);
			$add_preg_name = strtoupper( trim($frm_data['add_preg_name']) );
 			// return $add_preg_name;

			if(strlen($add_preg_name) == 0){$add_preg_name = "0";}

			// return $add_preg_code;

			if($add_preg_code == "0") {
				// Es nuevo, vamos a insertar la pregunta
					
				// BUSCAR CUAL SERIA EL NUEVO ID				
				$next_id = $this->db->query("SELECT (MAX(p.id) + 1) maximo FROM `preguntasrp` p ")->result_array();

				$next_id = ($next_id == null)? 1 : (int) $next_id[0]['maximo'];

				$new_code = $this->Model_general->get_new_code("PR", 10, $next_id); // NUEVO CODIGO PARA LA PREGUNTA

				$add_preg_categ = $this->Model_general->desencriptar($add_preg_categ);
				$insert = $this->db->query("INSERT INTO `preguntasrp` (`descripcion`, `codigo`, `categoria_code`, `estado`) 
												VALUES ('$add_preg_name', '$new_code', '$add_preg_categ', '$add_preg_estado');");

				if($insert) {
					return 1; // INSERTADO CON EXITO
				} else {
					return 3; // ERROR INTERNO
				}

			} else {
				// ESTAMOS EDITANDO UNA PREGUNTA
				$add_preg_code = $this->Model_general->desencriptar($add_preg_code);
				$add_preg_categ = $this->Model_general->desencriptar($add_preg_categ);
				$update = $this->db->query("UPDATE preguntasrp p set p.descripcion = '$add_preg_name', p.categoria_code = '$add_preg_categ', p.estado = '$add_preg_estado' 
												WHERE p.codigo = '$add_preg_code'");

				if($update) {
					return 2; // INSERTADO CON EXITO
				} else {
					return 3; // ERROR INTERNO
				}

				return "ACTUALIZAR";
			}

		}

		function save_categoria_preguntasrp ($value='') {
			
			$next_id = $this->db->query("SELECT (MAX(c.id) + 1) maximo FROM `categoria_preguntas` c")->result_array();

			if($next_id == null) {
				$next_id = 1;
			} else {
				$next_id = (int) $next_id[0]['maximo'];
			}

			$new_code = $this->Model_general->get_new_code("CP", 10, $next_id);
			$frm_data = $this->input->post();

			$add_cate_estado = $frm_data['add_cate_estado'];
			$add_cate_name   = $frm_data['add_cate_name'];
			$add_cate_name = $this->Model_general->limpiar_cadena($add_cate_name);
			$add_cate_name = strtoupper(trim($add_cate_name));

			if(strlen($add_cate_name) == 0){$add_cate_name = "0";}

			$add_cate_code   = $frm_data['add_cate_code'];

			// return $frm_data;

			if($add_cate_code == "0") {				
				//  "INSERTAR";

				$insert = $this->db->query("INSERT INTO `categoria_preguntas` (`codigo`, `nombre`, `estado`) 
											VALUES ('$new_code', '$add_cate_name', '$add_cate_estado') ");
				if($insert) {					 
					return 1;
				} else {					
					return 0;
				}
			} else {
				// "ACTUALIZAR";
				$add_cate_code = $this->Model_general->desencriptar($add_cate_code);
				$update = $this->db->query("UPDATE categoria_preguntas c set c.nombre = '$add_cate_name', c.estado = '$add_cate_estado' WHERE c.codigo = '$add_cate_code' ");
				if($update) {					 
					return 2;
				} else {					
					return 0;
				}

			} 
			return 0;
		}
	}

?>
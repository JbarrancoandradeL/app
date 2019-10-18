<?php 

	class Model_usuario extends CI_Model { 

						
		function get_datos_ventana_modal_usuarios($value='') {
			$rt['tipo_doc'] = $this->Model_general->get_tipos_de_documentos();		
			$rt['dtto'] = $this->Model_general->get_dttos_colombia();					
			return $rt;
		}

		function save_usuario_actual($value='') {
			$frm_data = $this->input->post();
			$datos_save = $frm_data['datos_save'];


			$usuario_code	= $datos_save["usuario_code"];
			
			$add_tipo_doc  	= $datos_save["add_tipo_doc"];
			$add_n_doc  	= $this->Model_general->limpiar_cadena($datos_save["add_n_doc"]);
			$add_nombre1  	= $this->Model_general->limpiar_cadena($datos_save["add_nombre1"]);
			$add_nombre2  	= $this->Model_general->limpiar_cadena($datos_save["add_nombre2"]);
			$add_apellido1  = $this->Model_general->limpiar_cadena($datos_save["add_apellido1"]);
			$add_apellido2  = $this->Model_general->limpiar_cadena($datos_save["add_apellido2"]);
			$add_email  	= $this->Model_general->limpiar_cadena($datos_save["add_email"]);
			$add_telefono  	= $this->Model_general->limpiar_cadena($datos_save["add_telefono"]);
			$add_pais  		= $datos_save["add_pais"];
			$add_otro_pais  = $this->Model_general->limpiar_cadena($datos_save["add_otro_pais"]);
			$add_dtto  		= $datos_save["add_dtto"];
			$add_ciudad  	= $datos_save["add_ciudad"];
			$add_direccion  = $this->Model_general->limpiar_cadena($datos_save["add_direccion"]);	

			$add_pass_actual= $this->Model_general->limpiar_cadena($datos_save["add_pass_actual"]);
			$add_pass  = $this->Model_general->limpiar_cadena($datos_save["add_pass"]);
			$add_r_pass  = $this->Model_general->limpiar_cadena($datos_save["add_r_pass"]);
			
			if ($add_dtto == ""){$add_dtto=0;}
			if ($add_ciudad == ""){$add_ciudad=0;}
			
			if($add_pass_actual != ""){

				$contra = md5($add_pass_actual);
				
				$resultado_valida_clave = $this->db->query("SELECT c.codigo codigo_cuenta
										FROM `cuenta` c									
										INNER JOIN usuarios u on u.codigo_cuenta = c.codigo
										WHERE u.codigo = '$usuario_code' and c.contrasena = '$contra'
										LIMIT 1")->result_array();

				if($resultado_valida_clave == null) {					
					return 1; // "Clave no coincide";
				} else{
					// "Clave coincide"
					$codigo_cuenta = $resultado_valida_clave[0]['codigo_cuenta'];					
					$contra_nueva = md5($add_pass);				
					$actualizar_cuenta = $this->db->query("UPDATE cuenta c set c.contrasena = '$contra_nueva'				
															WHERE c.codigo = '$codigo_cuenta'");
					if(!$actualizar_cuenta) {
						return 2; // Error al actualizar contraseña
					}
				}

			}
			
			$actualizar = $this->db->query("UPDATE usuarios u set u.tipo_documento = '$add_tipo_doc', 
					u.documento = '$add_n_doc', u.nombre1 = '$add_nombre1', u.nombre2 = '$add_nombre2', u.apellido1 = '$add_apellido1',
					u.apellido2 = '$add_apellido2', u.correo = '$add_email', u.telefono = '$add_telefono', u.pais = '$add_pais',
					u.otro_pais = '$add_otro_pais', u.departamento = $add_dtto, u.ciudad = $add_ciudad, u.direccion = '$add_direccion'
					WHERE u.codigo = '$usuario_code' ");
			
			if($actualizar) {
				return 0; //ACTUALIZACION CORRECTA
			}else{
				return 3; //ERROR AL ACTUALIZAR USUARIO
			}
		}

		function get_city_and_user_actual ($value='') {
			$codigo_usuario = $this->session->userdata('user_code');			
			$rt['citys'] = $this->Model_general->get_mcipios_colombia();

			$rt['user'] = $this->db->query("SELECT										
										u.codigo usuario_code,	 
										UPPER(u.nombre1) nombre1,
										UPPER(u.nombre2) nombre2,
										UPPER(u.apellido1) apellido1,
										UPPER(u.apellido2) apellido2,
										u.tipo_documento,
										u.documento,
										u.correo,
										u.telefono,
										u.pais,
										u.otro_pais,
										u.departamento,
										u.ciudad, 
										u.direccion
									FROM
										`usuarios` u
							
									WHERE u.codigo = '$codigo_usuario'
									LIMIT 1")->result_array();	 	
			
			return $rt;
		}
		function get_city_and_users($value='') {
			$rt['users'] = $this->get_all_usuarios();
			$rt['citys'] = $this->Model_general->get_mcipios_colombia();
			return $rt;
		}
		function get_users_by_code($value='') {
			$frm_data = $this->input->post();
			$codigo = $frm_data['codigo'];

			$rt['datos_usuario'] = $this->db->query("SELECT										
										u.codigo,	 
										UPPER(u.nombre1) nombre1,
										UPPER(u.nombre2) nombre2,
										UPPER(u.apellido1) apellido1,
										UPPER(u.apellido2) apellido2,
										u.tipo_documento,
										u.documento,
										u.correo,
										u.telefono,
										u.pais,
										u.otro_pais,
										u.departamento,
										u.ciudad, 
										u.direccion,
										u.estado,
										c.usuario usuario,
										e.codigo codigo_evento, 
										e.estado estado_evento,
										e.fecha_creado fecha_evento,
										UPPER(e.descripcion) evento_desc 
									FROM
										`usuarios` u
									INNER JOIN eventos e on e.codigo = u.codigo_evento
									INNER JOIN cuenta c on c.codigo = u.codigo_cuenta
									WHERE u.codigo = '$codigo'
									LIMIT 1")->result_array();	 	
			
			
			
			$estado_evento = $rt['datos_usuario'][0]['estado_evento'];
			
			$this->load->model('Model_eventos'); 
			$eventos_activos_usuar = $this->Model_eventos->get_all_eventos_activos(0);
			
			if($estado_evento != 1){			
				$eventos_activos_usuar[] = Array(
												    'fecha_creado' => $rt['datos_usuario'][0]['fecha_evento'],
												    'codigo' => $rt['datos_usuario'][0]['codigo_evento'],
												    'descripcion' => $rt['datos_usuario'][0]['evento_desc'],
												    'estado' => $rt['datos_usuario'][0]['estado_evento']
												);
			}

			$rt['eventos'] = $eventos_activos_usuar;
			
		 	return $rt;
		}



		function save_usuarios($value='') {
			$frm_data = $this->input->post();
			$datos_save = $frm_data['datos_save'];


			$usuario_code	= $datos_save["usuario_code"];
			
			$add_tipo_doc  	= $datos_save["add_tipo_doc"];
			$add_n_doc  	= $this->Model_general->limpiar_cadena($datos_save["add_n_doc"]);
			$add_nombre1  	= $this->Model_general->limpiar_cadena($datos_save["add_nombre1"]);
			$add_nombre2  	= $this->Model_general->limpiar_cadena($datos_save["add_nombre2"]);
			$add_apellido1  = $this->Model_general->limpiar_cadena($datos_save["add_apellido1"]);
			$add_apellido2  = $this->Model_general->limpiar_cadena($datos_save["add_apellido2"]);
			$add_email  	= $this->Model_general->limpiar_cadena($datos_save["add_email"]);
			$add_telefono  	= $this->Model_general->limpiar_cadena($datos_save["add_telefono"]);
			$add_pais  		= $datos_save["add_pais"];
			$add_otro_pais  = $this->Model_general->limpiar_cadena($datos_save["add_otro_pais"]);
			$add_dtto  		= $datos_save["add_dtto"];
			$add_ciudad  	= $datos_save["add_ciudad"];
			$add_direccion  = $this->Model_general->limpiar_cadena($datos_save["add_direccion"]);
			$add_evento  	= $datos_save["add_evento"];
			$add_estado  	= $datos_save["add_estado"];
			$add_usuario  = strtolower($this->Model_general->limpiar_cadena($datos_save["add_usuario"]));
			$add_pass  = $this->Model_general->limpiar_cadena($datos_save["add_pass"]);
			$add_r_pass  = $this->Model_general->limpiar_cadena($datos_save["add_r_pass"]);
			
			if ($add_dtto == ""){$add_dtto=0;}
			if ($add_ciudad == ""){$add_ciudad=0;}

			if($usuario_code == "0"){
				//Para verificar si el usuario CON ESTE DOCUMENTO			
				$existe_usuario = $this->db->query("SELECT u.codigo FROM `usuarios` u WHERE u.tipo_documento = '$add_tipo_doc' AND u.documento = '$add_n_doc' LIMIT 1")->result_array();

				if(sizeof($existe_usuario) > 0){
					return 5;	//Ya el usuario existe en la bd
				}

				//Para verificar si el usuario existe
				
				$existe_cuenta = $this->db->query("SELECT c.codigo FROM `cuenta` c WHERE c.usuario = '$add_usuario' LIMIT 1")->result_array();

				if(sizeof($existe_cuenta) > 0){
					return 1;	//Ya el usuario existe en la bd
				}
			
				//Para generar el nuevo codigo de la cuenta

				$next_id_cuenta = $this->db->query("SELECT (MAX(c.id) + 1) maximo FROM `cuenta` c")->result_array();

				if($next_id_cuenta == null) {
					$next_id_cuenta = 1;
				} else {
					$next_id_cuenta = (int) $next_id_cuenta[0]['maximo'];
				}
			
				$new_code_cuenta = $this->Model_general->get_new_code("CU", 10, $next_id_cuenta);
		
				$contra = md5($add_pass);
				$insertar = $this->db->query("INSERT INTO `cuenta` (`codigo`, `usuario`, `contrasena`)				
					VALUES ('$new_code_cuenta', '$add_usuario', '$contra')");
				
				if(!$insertar) {					 
					return 2; // Error al crear la cuenta
				}
				
				//Para crear el codigo de usuario
				$next_id_usuario = $this->db->query("SELECT (MAX(c.id) + 1) maximo FROM `usuarios` c")->result_array();

				if($next_id_usuario == null) {
					$next_id_usuario = 1;
				} else {
					$next_id_usuario = (int) $next_id_usuario[0]['maximo'];
				}
				
				$usuario_code = $this->Model_general->get_new_code("US", 10, $next_id_usuario);
				$fecha_creado = date("Y-m-d H:i:s");
			
				$insertar = $this->db->query("INSERT INTO `usuarios` 
					(`codigo`, `codigo_evento`, `codigo_perfil`, `codigo_cuenta`, `tipo_documento`, 
					`documento`, `nombre1`, `nombre2`, `apellido1`, `apellido2`, `correo`, `telefono`, 
					`pais`, `otro_pais`,`departamento`, `ciudad`, `direccion`, `estado`, `fecha_creado`, `eliminado`) 
					VALUES ('$usuario_code', '$add_evento', 'PE0483143843', '$new_code_cuenta', '$add_tipo_doc', 
					'$add_n_doc', '$add_nombre1', '$add_nombre2', '$add_apellido1', '$add_apellido2', '$add_email', '$add_telefono', 
					'$add_pais', '$add_otro_pais', $add_dtto, $add_ciudad, '$add_direccion', $add_estado, '$fecha_creado', 0)");
					
				if($insertar) {					 
					return 0; //Creacion Exitosa
				} else {					
					return 3; // Error indeterminado
				}
			}else{

				$actualizar = $this->db->query("UPDATE usuarios u set u.codigo_evento = '$add_evento', u.tipo_documento = '$add_tipo_doc', 
					u.documento = '$add_n_doc', u.nombre1 = '$add_nombre1', u.nombre2 = '$add_nombre2', u.apellido1 = '$add_apellido1',
					u.apellido2 = '$add_apellido2', u.correo = '$add_email', u.telefono = '$add_telefono', u.pais = '$add_pais',
					u.otro_pais = '$add_otro_pais', u.departamento = $add_dtto, u.ciudad = $add_ciudad, u.direccion = '$add_direccion',
					u.estado = $add_estado WHERE u.codigo = '$usuario_code' ");
					
				if($actualizar) {
					if( $add_pass != ""){
						$codigo_cuenta = $this->db->query("SELECT u.codigo_cuenta FROM `usuarios` u 
													WHERE u.codigo = '$usuario_code' LIMIT 1")->result_array()[0]['codigo_cuenta'];	 	
						
						$contra = md5($add_pass);
						$actualizar_cuenta = $this->db->query("UPDATE cuenta c set c.contrasena = '$contra'				
																WHERE c.codigo = '$codigo_cuenta'");
						if($actualizar_cuenta) {
							return 4; //actualizacion Exitosa con contraseña
						}else{
							return 3; // Error indeterminado		
						}
					}else{
						return 4; //actualizacion Exitosa sin contraseña	
					}
					
				} else {					
					return 3; // Error indeterminado
				}
				
			}

		}
		// / Cambia el estad de eliminado de un USUARIO
		// 
		// 
		function delete_usuario ($value='') {
			
			$frm_data = $this->input->post();
			$usuario_code = $frm_data['usuario_code'];


			$consulta_id_usuario = $this->db->query("SELECT u.id FROM `usuarios` u WHERE u.codigo = '$usuario_code'
									LIMIT 1")->result_array()[0]['id'];	

			if(($consulta_id_usuario == 1) || ($consulta_id_usuario == 2)){
				return 1; //no se puede eliminar usuarios administradores
			}
			
			$deleted = $this->db->query("UPDATE usuarios u set u.eliminado = '1'
												WHERE u.codigo = '$usuario_code' ");
			if($deleted){
				return 0; //Eliminacion exito
			}
			return 2; //Error interno
			
		}

		function get_all_usuarios($value='') {		 	
		 	$rt = $this->db->query("SELECT										
										UPPER(e.descripcion) evento_desc,
										u.codigo,	 
										UPPER(CONCAT(u.nombre1, ' ', u.apellido1)) pn_pa,
										UPPER(CONCAT(u.tipo_documento, ' ', u.documento)) identificacion 
									FROM
										`usuarios` u
									INNER JOIN eventos e on e.codigo = u.codigo_evento
									INNER JOIN perfil p on p.codigo = u.codigo_perfil
									WHERE u.estado = 1 AND u.eliminado = 0")->result_array();


		 	foreach ($rt as $key => $value) {
		 		$rt[$key]['num'] = ($key+1);
		 		$rt[$key]['identificacion'] = '<div class="mause_over_link" onclick="open_modal_usuarios(' . "'" . $value['codigo'] . "'" .')"> ' .$value['identificacion'] . ' </div>  ';
		 		$rt[$key]['pn_pa'] =   $value['pn_pa'];
		 		// Boton abrir
		 		$rt[$key]['abrir'] = ' <i onclick="open_modal_usuarios(' . "'" . $value['codigo'] . "'" .')" class="clip-info mause_over_link"> </i> ';
		 	}
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
												u.nombre1, u.apellido1, u.codigo user_code, u.codigo_evento codigo_evento, u.codigo_perfil
											FROM
												usuarios u
											WHERE
												u.codigo_cuenta = '$cuenta_codigo' AND u.estado = 1 LIMIT 1")->result_array();


				if($rt != null) {

					$set_session = array(
					    'codigo_perfil'  => $rt[0]['codigo_perfil'],
					    'nombre1'  => $rt[0]['nombre1'],
					    'apellido1'  => $rt[0]['apellido1'],
					    'codigo_evento'  => $rt[0]['codigo_evento'],
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
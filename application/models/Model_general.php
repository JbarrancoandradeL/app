<?php 

	class Model_general extends CI_Model { 
		
		//Valores seguridad
		const METODO = "AES-256-CBC";
		const IV_SECRETA = "07082019";
		const LLAVE_SECRETA = '@$C0l0mB14:2019';



		protected function c_encriptar($cadena){
			$salida=FALSE;
			$llave = hash('sha256',LLAVE_SECRETA);
			$iv	=substr(hash('sha256',IV_SECRETA),0,16);
			$salida=openssl_encrypt($cadena, METODO, $llave, 0, $iv);
			$salida=base64_encode($salida);
			return $salida;
		}
			 
		protected function c_desencriptar($cadena){
			$llave= hash('sha256',LLAVE_SECRETA);
			$iv	=substr(hash('sha256',IV_SECRETA),0,16);
			$salida=openssl_decrypt(base64_decode($cadena), METODO, $llave,0, $iv);
			return $salida;
		}


		protected function generar_codigo_aleatorio ($letra, $longitud, $num){
			for($i=1;$i<=$longitud;$i++){
				$numero=rand(0,9);
				$letra.=$numero;
			}
			return $letra.$num;
		}

		// funciones publicas
		// 
		// 


		function get_tipo_deuda($value='') {
			
			$rt = $this->db->query("SELECT t.id, UPPER(t.nombre) nombre FROM `tipo_deuda` t ORDER BY t.nombre;")->result_array();			

			return $rt;

		}

		function limpiar_cadena($cadena){
			$cadena = trim($cadena);
			$cadena = stripslashes($cadena);
			$cadena=str_ireplace("<script","", $cadena);
			$cadena=str_ireplace("</script>","", $cadena);
			$cadena=str_ireplace("<script src","", $cadena);
			$cadena=str_ireplace("<script type","", $cadena);
			$cadena=str_ireplace("SELECT","", $cadena);
			$cadena=str_ireplace("INSERT INTO","", $cadena);
			$cadena=str_ireplace("DELETE","", $cadena);
			$cadena=str_ireplace("<script>","", $cadena);
			$cadena=str_ireplace("--","", $cadena);
			$cadena=str_ireplace("^","", $cadena);
			$cadena=str_ireplace("[","", $cadena);
			$cadena=str_ireplace("]","", $cadena);
			$cadena=str_ireplace("==","", $cadena);
			$cadena=str_ireplace("'","", $cadena);
			return $cadena;
		}
		function get_new_code ($letra, $longitud, $num) {
			
			$code = $this->generar_codigo_aleatorio($letra, $longitud, $num);

			return $code;
		}
		function encriptar($cadena){
			$code = base64_encode($cadena);
			return $code;
		}	
		function desencriptar($cadena){
			$code = base64_decode($cadena);
			return $code;
		}
 
		function get_tipos_de_documentos($value='') {

			$tipos_documentos = array(  "CC"  => "C&eacute;DULA",
										"PP"  => "PASAPORTE",			    
										"TI"  => "TARJETA DE IDENTIDAD",
										"RC"  => "REGISTRO CIVIL",
										"CE"  => "C&Eacute;DULA DE EXTRANJER&Iacute;A"										
									    );	 

			return $tipos_documentos;
		}
		 
		function get_mcipios_colombia ($codigo_evento = '0') {
			$rt = $this->db->query("SELECT m.id_municipio,	UPPER(m.municipio) municipio, m.codigo_dtto
										FROM mpios_colombia m
										WHERE m.estado = 1")->result_array();			
			return $rt;
		}
		function get_dttos_colombia ($codigo_evento = '0') {
			$rt = $this->db->query("SELECT dttos.codigo, UPPER(dttos.nombre) nombre
									FROM dttos_colombia dttos")->result_array();			
			return $rt;
		}

		function rango_mensalidad ($num = 0, $codigo_cat = '0') {
			
			$codigo_usuario = $this->session->userdata('user_code'); 
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento']; 
  			
			$men['ab'] = 0; $men['zc'] = 0; $men['es'] = 0;

			if($num == 0) {

				if($estado_evento == 1) {

					// Filtrar por categoria
					$filtro1 = ($codigo_cat != '0')? " AND p.categoria_code = '".$codigo_cat."' " : '';

					$total = $this->db->query("SELECT COUNT(p.codigo) total 
												FROM `preguntasrp` p  
												WHERE  p.eliminado = 0 AND p.estado = 1 $filtro1 ;")->result_array()[0]['total'];
				} else {

					// Filtrar por categoria
					$filtro2 = ($codigo_cat != '0')? " AND prp.categoria_code = '".$codigo_cat."' " : '';

					$total = $this->db->query("SELECT COUNT(r.codigo) total 
												FROM respuestas_cre_lim r 
												INNER JOIN preguntasrp prp on prp.codigo = r.codigo_preg 
												
												WHERE r.codigo_usuario = '$codigo_usuario' 
												and r.codigo_evento = '$codigo_evento' $filtro2 ")->result_array()[0]['total'];
				}

				$men['ab'] = ( ($total * 10) * 0.3);
				$men['zc'] = ( ($total * 10) * 0.699);
				$men['es'] = ($total*10);	
				
			} else {

				$men['ab'] = (   ($num * 10) * 0.3);
				$men['zc'] = (   ($num * 10) * 0.699);
				$men['es'] = (  $num * 10);		

			}


			return $men;
		}


		function get_codigo_estado_evento ($codigo_evento = '0') {
			
			$codigo_usuario = $this->session->userdata('user_code'); 

			$rt = $this->db->query("SELECT
											u.codigo_evento, e.estado estado_evento
										FROM
											`usuarios` u
											INNER JOIN eventos e on e.codigo = u.codigo_evento
										WHERE
											u.codigo = '$codigo_usuario';")->result_array()[0];

			return $rt;
		}
	}	

?>
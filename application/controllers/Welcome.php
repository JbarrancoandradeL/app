<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index() {	
		if($this->session->userdata('user_code')) {
			$this->go_to("home");
		} else {
			$this->go_to("login");			
		}
	}


	function go_to ($value='') {		
		header("Location: " . base_url() . "index.php/welcome/" . $value);
	}


	function test ($value='') {
		$val = 1000000000;

		print_r( number_format($val, 2) );
	}


	// MODULO DE USUARIOS
	
	function get_users_by_code ($value='') {		
		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->get_users_by_code();
		echo json_encode( $rt );
		
	}
	function delete_usuario ($value='') {		
		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->delete_usuario();
		echo json_encode( $rt );
		
	}
	
	function get_eventos_activos ($value='') {
		$this->load->model('Model_eventos'); 
		$rt = $this->Model_eventos->get_all_eventos_activos(0);
		echo json_encode( $rt );
	}
	function usuarios($value='') {
		 $this->load->model('Model_usuario'); 
		 $data['array_data'] = $this->Model_usuario->get_datos_ventana_modal_usuarios();
		$this->cargar_vistas('usuarios', $data);
		
	}
	function get_city_and_user_actual($value=''){		
		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->get_city_and_user_actual();
		echo json_encode( $rt );
	}
	function get_city_and_users($value=''){		
		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->get_city_and_users();
		echo json_encode( $rt );
	}

	function get_all_usuarios ($value='') {
		
		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->get_all_usuarios();
		echo json_encode( $rt );
		
	}

	// modulo de eventos
	function eventos_admin($value='') {
		$this->cargar_vistas('eventos_admin');			
	}

	function save_evento ($value='') {
		
		$this->load->model('Model_eventos'); 
		$rt = $this->Model_eventos->save_evento();
		echo json_encode( $rt );

	}
	
	function get_evento_by_code ($value='') {
		
		$this->load->model('Model_eventos'); 
		$rt = $this->Model_eventos->get_evento_by_code();
		echo json_encode( $rt );

	}
	 

	function get_all_eventos ($value='') {
		
		$this->load->model('Model_eventos'); 
		$rt = $this->Model_eventos->get_all_eventos();
		echo json_encode( $rt );
		
	}


	// Traer los datos para el reporte general de creencias limitantes
	function get_reporte_general_cre_lim ($value='') {
		
		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->get_reporte_general_cre_lim();
		echo json_encode( $rt );	 	
	}

	function rep_admin_cre_lim($value='') {

		$this->load->model('Model_eventos'); 
		$data['eventos'] = $rt = $this->Model_eventos->get_all_eventos(0);
		
		$this->load->model('Model_preguntasrp'); 
		$data['categorias'] = $rt = $this->Model_preguntasrp->get_categorias_preguntasrp(0);

		$this->cargar_vistas('rep_admin_cre_lim', $data);		
	}

	// llama la vista de el administrador de los tipos de ingresos
	
	function login($value='') {		
		$this->session->sess_destroy();
		$this->load->view('login'); 
	}

	function validar_login ($value='') { 		 
		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->validar_login();
		echo json_encode( $rt );

	}
	// ------------------------------------------------------------------------------------------------------
	// funciones para cargar las vistas de reporte  mapa de riqueza
	// 
	// 

	function user_mapaderiqueza($value='') {
		$this->load->model('Model_reportesusuarios'); 
		$data = $this->Model_reportesusuarios->get_datos_mapar();
		$this->cargar_vistas('user_mapaderiqueza',$data);			
	}
	// ------------------------------------------------------------------------------------------------------
	// funciones para cargar PDF del reporte flujo de dinero
	// 
	//
	function user_mapaderiquezaPDF($value='') {
	
		 $this->load->model('Model_reportesusuarios'); 
		 $this->Model_reportesusuarios->get_datos_maparPDF();			 
	}
	
	// ------------------------------------------------------------------------------------------------------
	// funciones para cargar las vistas de cada modulo
	// 
	// 

	// ------------------------------------------------------------------------------------------------------
	// funciones para cargar PDF del reporte flujo de dinero
	// 
	//
	function user_flujodedineroPDF($value='') {
	
		 $this->load->model('Model_reportesusuarios'); 
		 $this->Model_reportesusuarios->get_datos_flujoPDF();			 
	}
	// ------------------------------------------------------------------------------------------------------
	// funciones para cargar las vistas de reporte flujo de dinero
	// 
	// 

	function user_flujodedinero($value='') {
		$this->load->model('Model_reportesusuarios'); 
		$data = $this->Model_reportesusuarios->get_datos_flujo();
		$this->cargar_vistas('user_flujodedinero',$data);			
	}

	// llama la vista de valores de losActivos
	
	function user_valoractivos($value='') {		
		$rt['vista_actual'] = "Activos";								
		$this->cargar_vistas('user_valoractivos',$rt);		
	}
	// llama la vista de el administrador de los egresos
	
	function user_valoregresos($value='') {		
		$rt['vista_actual'] = "egresos";								
		$this->cargar_vistas('user_valoregresos',$rt);		
	}
	function user_valoregresos_h($value='') {		
		$rt['vista_actual'] = "egresos_h";								
		$this->cargar_vistas('user_valoregresos',$rt);		
	}


	function resumen_deuda($value='') {		
		$rt['vista_actual'] = "resumen_deuda";								
		$this->cargar_vistas('resumen_deuda',$rt);		
	}

	function resumen_deuda_usr($value='') {		
	  $this->load->model('Model_resumenDed');
	  $rt = $this->Model_resumenDed->get_data_resumended();
	  echo json_encode( $rt );
	}

/*
	function mis_indicadores_user($value='') {
		$this->load->model('Model_indicadores'); 
		$rt = $this->Model_indicadores->get_data_indicadores();
		echo json_encode( $rt );
	}
*/



	// vista mi perfil
	function mi_perfil($value='') {
		$this->load->model('Model_usuario'); 
		$data['array_data'] = $this->Model_usuario->get_datos_ventana_modal_usuarios();
		$this->cargar_vistas('mi_perfil',$data);			
	}


	// llama la vista de el administrador de los tipos de ingresos
	
	function ingresos_admin($value='') {		
		$this->cargar_vistas('ingresos');		
	}
	// llama la vista de el administrador de los tipos de egresos y sus categorias
	
	function activos_admin($value='') {		
		$this->cargar_vistas('categoriasactivos');
	}
	// llama la vista de el administrador de los tipos de egresos y sus categorias
	
	function egresos_admin($value='') {		
		$this->cargar_vistas('categoriasegresos');
	}
	// llama la vista de el administrador de la rueda de la Prosperidad

	function preguntas_cl_admin($value='') {	
		$this->cargar_vistas('categoriasprp');			
	}
	// llama la vista del home
	function home ($value='') {		
		$this->cargar_vistas('home');	
	}
	// llama la interfaz que permite resolver las preguntas de la rueda de la prosperidad 	
	function user_cre_lim ($value='') {		
		$this->cargar_vistas("user_cre_lim");
	}
	




	// MODULO RUEDA DE LA PROSPERIDAD

	function rep_admin_mrp($value='') {
		
		$this->load->model('Model_preguntasrp'); 
		$data['eventos'] =  $this->Model_preguntasrp->get_eventos();

		$this->cargar_vistas("rep_admin_mrp", $data); 
	}

	function get_data_rep_admin_mrp($value='') {
		
		$this->load->model('Model_preguntasrp'); 
		$data = $this->Model_preguntasrp->get_data_rep_admin_mrp();

		echo json_encode($data);
	}




	// Usuario, rueda de la prosperidad
	function user_rp ($value='') {
		$this->cargar_vistas("user_rp");
	}

	// Admin Rueda de la prosperidad
	function preguntas_rp_admin($value='') {
		$this->cargar_vistas("preguntas_rp_admin"); 
	}
	
	// Admin Rueda de la prosperidad
	function get_preguntas_rp_user($value='') {
		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->get_preguntas_rp_user();
		echo json_encode( $rt );
	}


	// indicadores de deuda
	function mis_indicadores($value='') {
		$this->cargar_vistas("mis_indicadores"); 
	}

	function mis_indicadores_user($value='') {
		$this->load->model('Model_indicadores'); 
		$rt = $this->Model_indicadores->get_data_indicadores();
		echo json_encode( $rt );
	}

	 

	function save_update_categoriaMRP ($value='') {
		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->save_update_categoriaMRP();
		echo json_encode( $rt );
	}

	// GUARDAR RESPUESTA DEL LADO DEL USUARIO MRP
	function save_respuestas_MRP($value='') {
		
		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->save_respuestas_MRP();
		echo json_encode( $rt );	
	}

	function get_preguntas_rp_admin ($value='') {

		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->get_preguntas_rp_admin();
		echo json_encode( $rt );	 	
	}

	function get_preguntas_rp_admin_by_codigo ($value='') {

		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->get_preguntas_rp_admin_by_codigo();
		echo json_encode( $rt );	 	
	}

	// llama la interfaz que permite anotar los ingresos de un usuario 	
	function user_valoringresos_ad ($value='') {
		$this->load->model('Model_ingresos');
		$rt['tipos_ingresos'] = $this->Model_ingresos->get_ingresos_usuarios();
		$rt['vista_actual'] = "ingresos_ad";						
		$this->cargar_vistas("user_valoringresos",$rt);
	}

	// llama la interfaz que permite anotar los ingresos de un usuario 	
	function user_valoringresos ($value='') {
		$this->load->model('Model_ingresos');
		$rt['tipos_ingresos'] = $this->Model_ingresos->get_ingresos_usuarios();
		$rt['vista_actual'] = "ingresos";						
		$this->cargar_vistas("user_valoringresos",$rt);
	}
 	// función que carga las vistas
 	function cargar_vistas ($vista='login', $data = null) { 		

 		if($this->session->userdata('user_code')) {
			
			// $data_header			
			$this->load->view('header');
			$this->load->view($vista, $data);
			$this->load->view('footer');

		} else {
			
			$this->go_to("login");			

		}
		

 	}

 	function user_deudas($value='') {
	 
		$data['tipo_deuda'] = $this->Model_general->get_tipo_deuda();
		$this->cargar_vistas('user_deudas', $data);
 	}

 	function get_user_deudas ($value='') {
 		
 		$this->load->model('Model_deuda'); 
		$rt = $this->Model_deuda->get_user_deudas();		 
		echo json_encode( $rt );

 	}

 	function get_deudas_by_code  ($value='') {
 		
 		$this->load->model('Model_deuda'); 
		$rt = $this->Model_deuda->get_deudas_by_code ();		 
		echo json_encode( $rt );

 	}
 	

	function save_deuda ($value='') {
 		
 		$this->load->model('Model_deuda'); 
		$rt = $this->Model_deuda->save_deuda();		 
		echo json_encode( $rt );

 	}

 	// ------------------------------------------------------------------------------------------------------
	// Funciones para el modulo de usuario 
 	// 
 	// 
 	// contiene las funciones de consulta y guardado

 	function save_usuarios ($value=''){
 		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->save_usuarios();		 
		echo json_encode( $rt );	 
 	}
 	
 	
 	function save_usuario_actual ($value=''){
 		$this->load->model('Model_usuario'); 
		$rt = $this->Model_usuario->save_usuario_actual();		 
		echo json_encode( $rt );	 
 	}
	// Guarda las respuestas a las preguntas de la rueda de la prosperidad
	function save_respuestas_pre ($value='') {	 	
	 	$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->save_respuestas_pre();
		echo json_encode( $rt );	 	
	} 
	
 	// Trae las preguntas del modulo de usuarios
 	function get_preguntas_usuarios($value='') { 		
 		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->get_preguntas_usuarios();
		echo json_encode( $rt );
 	}
 	

 	// ------------------------------------------------------------------------------------------------------
 	// Funciones para el modulo de ADMON Activos 
 	// 
 	// 
 	// contiene las funciones de consulta y guardado
 	
 	// devuleve los valores de los activos de un usuario
	function get_activos_usuarios($value='') {
		$this->load->model('Model_activos'); 
		$data = $this->Model_activos->get_activos_usuarios();		
		echo json_encode($data);
	}

	function save_valores_activos($value='') {

		$this->load->model('Model_activos'); 
		$rt = $this->Model_activos->save_valores_activos();
		echo json_encode( $rt );
	}

 	// ------------------------------------------------------------------------------------------------------
 	// Funciones para el modulo de ADMON egresos 
 	// 
 	// 
 	// contiene las funciones de consulta y guardado
 	
 	// devuleve los valores de los egresos de un usuario
	function get_egresos_usuarios($value='') {
		$this->load->model('Model_egresos'); 
		$data = $this->Model_egresos->get_egresos_usuarios();		
		echo json_encode($data);
	}


	function save_valores_egresos($value='') {

		$this->load->model('Model_egresos'); 
		$rt = $this->Model_egresos->save_valores_egresos();
		echo json_encode( $rt );
	}

	// guardar los tipos de activos en la BD
	function save_activos ($value='') {	
		$this->load->model('Model_activos'); 
		$rt = $this->Model_activos->save_activos();
		echo json_encode( $rt );
	}
	// guardar los tipos de egresos en la BD
	function save_egresos ($value='') {	
		$this->load->model('Model_egresos'); 
		$rt = $this->Model_egresos->save_egresos();
		echo json_encode( $rt );
	}
	// devuelve las categorias de los Activos y los tipos de activos para la interfaz administracion 
	function get_categorias_AND_activos($value='') {
		$this->load->model('Model_activos'); 
		$data['categorias'] = $this->Model_activos->get_categorias_activos(1);
		$data['activos']  = $this->Model_activos->get_activos(1);
		echo json_encode($data);
	}
	// devuelve las categorias de los egresos y los tipos de egresos para la interfaz administracion 
	function get_categorias_AND_egresos($value='') {
		$this->load->model('Model_egresos'); 
		$data['categorias'] = $this->Model_egresos->get_categorias_egresos(1);
		$data['egresos']  = $this->Model_egresos->get_egresos(1);
		echo json_encode($data);
	}
	// Devuelve los datos de una categoria de Activos, segun un codigo de categoria especificado
	function get_categorias_activos_by_code($value='') {
		$this->load->model('Model_activos'); 
        $data = $this->Model_activos->get_categorias_activos_by_code();
		echo json_encode($data);
	}
	// Devuelve los datos de una categoria de egresos, segun un codigo de categoria especificado
	function get_categorias_egresos_by_code($value='') {
		$this->load->model('Model_egresos'); 
        $data = $this->Model_egresos->get_categorias_egresos_by_code();
		echo json_encode($data);
	}
	// Para devolver las categorias de activos y los datos de un activo por codigo
	function get_categorias_activos_AND_a_activoByCode($value='') {
		$this->load->model('Model_activos'); 
		$data['catregorias_activos'] = $this->Model_activos->get_categorias_activos(0);		
		$data['datos_activo'] = $this->Model_activos->get_activos_by_code(0);
		echo json_encode($data);
	}
	// Para devolver las categorias de egresos y los datos de un egresos por codigo
	function get_categorias_egresos_AND_a_egresoByCode($value='') {
		$this->load->model('Model_egresos'); 
		$data['catregorias_egresos'] = $this->Model_egresos->get_categorias_egresos(0);		
		$data['datos_egreso'] = $this->Model_egresos->get_egresos_by_code(0);
		echo json_encode($data);
	}
	// guarda las categorias de activos 
	function save_categoria_activos($value='') {
		$this->load->model('Model_activos'); 
         $rt = $this->Model_activos->save_categoria_activos();
		echo json_encode($rt);

	}
	// guarda las categorias de egresos 
	function save_categoria_egresos($value='') {
		
		$this->load->model('Model_egresos'); 
        $rt = $this->Model_egresos->save_categoria_egresos();
		echo json_encode($rt);

	}
	// Lllama a la funcion que cambia al estado eliminado de un egreso
	function delete_egresos($value='') {		
		$this->load->model('Model_egresos'); 
        $rt = $this->Model_egresos->delete_egresos();
		echo json_encode($rt);
	}
	// Llama a la funcion que cambia al estado eliminado de una categoria de  egresos
	function delete_categoria_egresos($value='') {		
		$this->load->model('Model_egresos'); 
        $rt = $this->Model_egresos->delete_categoria_egresos();
		echo json_encode($rt);

	}
	// Lllama a la funcion que cambia al estado eliminado de un egreso
	function delete_activos($value='') {		
		$this->load->model('Model_activos'); 
        $rt = $this->Model_activos->delete_activos();
		echo json_encode($rt);
	}
	// Llama a la funcion que cambia al estado eliminado de una categoria de  egresos
	function delete_categoria_activos($value='') {		
		$this->load->model('Model_activos'); 
        $rt = $this->Model_activos->delete_categoria_activos();
		echo json_encode($rt);

	}
	// ------------------------------------------------------------------------------------------------------
	// Funciones para el modulo de ADMON creencias y rueda de la prosperidad 
 	// 
 	// 
 	// contiene las funciones de consulta y guardado

	// guardar las preguntas de la rueda de la prosperidad
	function save_preguntarp ($value='') {
		$this->load->model('Model_preguntasrp'); 
		$rt = $this->Model_preguntasrp->save_preguntarp();
		echo json_encode( $rt );
	}
	// devuelve las categorias y las preguntas de la rueda de la prosperidad para la administración	
	function get_categorias_AND_preguntasrp($value='') {
		$this->load->model('Model_preguntasrp'); 
		$data['categorias'] = $this->Model_preguntasrp->get_categorias_preguntasrp(1);
		$data['preguntasrp']  = $this->Model_preguntasrp->get_preguntasrp(1);
		echo json_encode($data);
	}
	// Devuelve los datos de una categoria de preguntas Rueda de la Prosperidad, 
	// segun un codigo de categoria especificado
	function get_categorias_preguntasrp_by_code($value='') {

		$this->load->model('Model_preguntasrp'); 
        $data = $this->Model_preguntasrp->get_categorias_preguntasrp_by_code();

		echo json_encode($data);
	}
	// Para devolver las categorias Rueda de la Prosperidad
	function get_categorias_preguntasrp_AND_a_preguntaByCode($value='') {

		$this->load->model('Model_preguntasrp'); 
		$data['catregorias_preguntas'] = $this->Model_preguntasrp->get_categorias_preguntasrp(0);		
		$data['datos_pregunta'] = $this->Model_preguntasrp->get_preguntasrp_by_code(0);
		echo json_encode($data);
	}
	// Para devolver las categorias Rueda de la Prosperidad
	function get_categorias_preguntasrp($value='') {
		$this->load->model('Model_preguntasrp'); 
		$data= $this->Model_preguntasrp->get_categorias_preguntasrp(0);		
		echo json_encode($data);
	}
	
	// Devuelve los datos de una  preguntas Rueda de la Prosperidad
	// segun un codigo de pregunta especificado	
 	function get_preguntasrp_by_code($value='') {
		$this->load->model('Model_preguntasrp'); 
         // $data = $this->Model_preguntasrp->get_preguntasrp_by_code();
		echo json_encode($data);
	}
	// guarda las categorias de la preguntas de la rueda de la prosperidad
	function save_categoria_preguntasrp($value='') {		
		$this->load->model('Model_preguntasrp'); 
        $rt = $this->Model_preguntasrp->save_categoria_preguntasrp();
		echo json_encode($rt);
	}
	// Lllama a la funcion que cambia al estado eliminado de una pregunta
	function delete_preguntasrp($value='') {		
		$this->load->model('Model_preguntasrp'); 
        $rt = $this->Model_preguntasrp->delete_preguntasrp();
		echo json_encode($rt);
	}

	// Lllama a la funcion que cambia al estado eliminado de una categoria de  preguntaRP

	function delete_categoria_preguntasrp($value='') {		
		$this->load->model('Model_preguntasrp'); 
        $rt = $this->Model_preguntasrp->delete_categoria_preguntasrp();
		echo json_encode($rt);

	}


	// ------------------------------------------------------------------------------------------------------
	// Funciones para el modulo de ADMON ingresos
 	// 
 	// 
 	// contiene las funciones de consulta y guardado

 	// devuleve los tipos de ingresos
	function get_ingresos($value='') {
		$this->load->model('Model_ingresos'); 
		$data = $this->Model_ingresos->get_ingresos(1);		
		echo json_encode($data);
	}	
	
	// Devuelve los datos de un tipo de ingreso, segun un codigo de categoria especificado
	function get_ingresos_by_code($value='') {
		$this->load->model('Model_ingresos'); 
        $data = $this->Model_ingresos->get_ingresos_by_code();
		echo json_encode($data);
	}	
	// guarda los tipos de ingresos 
	function save_ingresos($value='') {		
		$this->load->model('Model_ingresos'); 
        $rt = $this->Model_ingresos->save_ingresos();
		echo json_encode($rt);

	}		
	// Lllama a la funcion que cambia al estado eliminado de un tipo de ingreso
	function delete_ingresos($value='') {		
		$this->load->model('Model_ingresos'); 
        $rt = $this->Model_ingresos->delete_ingresos();
		echo json_encode($rt);

	}
	// Lllama a la funcion que guarda los valores de ingresos de un usuario para un evento 
	function save_valores_ingresos_usuario($value='') {		
		$this->load->model('Model_ingresos'); 
        $rt = $this->Model_ingresos->save_valores_ingresos_usuario();
		echo json_encode($rt);

	}
	
}
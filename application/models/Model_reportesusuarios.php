<?php 
	class Model_reportesusuarios extends CI_Model { 
		function get_datos_mapar($value=''){
				//Traer los datos del usuario actual y el evento al que pertenece
			$codigo_usuario = $this->session->userdata('user_code');						
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];			

		 	$datos['categoria_activos'] = $this->db->query("SELECT 
											UPPER(c.nombre) nombre, c.codigo codigo_categoria 
										FROM
											`categoria_activos` c
											LEFT JOIN activos a on a.categoria_activo_code = c.codigo AND a.eliminado = 0 AND a.estado = 1
										WHERE
											c.eliminado = 0 AND c.estado = 1 AND a.codigo IS NOT NULL GROUP BY c.codigo")->result_array();

			foreach ($datos['categoria_activos'] as $key => $value) {

				$codigo_categoria = $value['codigo_categoria'];

				$datos['categoria_activos'][$key]['activos'] = $this->db->query("SELECT SUM(if(v.valor IS NULL, 0, v.valor)) suma_valores
														FROM `activos` a
														LEFT JOIN valor_activos_usuarios v on v.codigo_usuario = '$codigo_usuario' 
														AND v.codigo_evento = '$codigo_evento' AND v.codigo_activo = a.codigo
														WHERE a.categoria_activo_code = '$codigo_categoria' AND a.eliminado = 0 AND a.estado = 1
														GROUP BY a.categoria_activo_code")->result_array();
			}


			$datos['deudas_usuarios'] = $this->db->query("SELECT  SUM(if(d.saldo_deuda IS NULL, 0, d.saldo_deuda)) total, 
														UPPER(t.nombre) tipo_deuda
													FROM
														`valor_deudas` d 
													INNER JOIN tipo_deuda t on t.id = d.tipo_deuda_id
													WHERE d.codigo_usuario = '$codigo_usuario' AND d.codigo_evento = '$codigo_evento' 
													AND d.eliminado = 0
													GROUP BY d.tipo_deuda_id ")->result_array();


			return $datos;
		 
			
		}

		function get_datos_maparPDF($value=''){
				//Traer los datos del usuario actual y el evento al que pertenece
			$codigo_usuario = $this->session->userdata('user_code');						
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];	

			$this->load->library('fpdf/Fpdf');
			$pdf = new Fpdf('P','mm','Letter');
			$pdf->setTitulo("MAPA DE RIQUEZAS");
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',10);
			$pdf->ln();
			$pdf->setFillColor(230,230,230);
			$pdf->setXY(10,50);
			$pdf->cell(50, 6, utf8_decode("ACTIVO") , 0,0,'L',1);			
			$pdf->cell(50, 6, utf8_decode("VALOR") , 0,1,'R',1);
			$pdf->ln();

		 	$categoria_activos = $this->db->query("SELECT 
											UPPER(c.nombre) nombre, c.codigo codigo_categoria 
										FROM
											`categoria_activos` c
											LEFT JOIN activos a on a.categoria_activo_code = c.codigo AND a.eliminado = 0 AND a.estado = 1
										WHERE
											c.eliminado = 0 AND c.estado = 1 AND a.codigo IS NOT NULL GROUP BY c.codigo")->result_array();

			foreach ($categoria_activos as $key => $value) {

				$codigo_categoria = $value['codigo_categoria'];

				$categoria_activos[$key]['activos'] = $this->db->query("SELECT SUM(if(v.valor IS NULL, 0, v.valor)) suma_valores
														FROM `activos` a
														LEFT JOIN valor_activos_usuarios v on v.codigo_usuario = '$codigo_usuario' 
														AND v.codigo_evento = '$codigo_evento' AND v.codigo_activo = a.codigo
														WHERE a.categoria_activo_code = '$codigo_categoria' AND a.eliminado = 0 AND a.estado = 1
														GROUP BY a.categoria_activo_code")->result_array();
			}
			
			$pdf->SetFont('Arial','B',8);
			$total_activos = 0;
                                    
	        foreach ($categoria_activos as $key => $value) {
                $nombre_categoria_act = $value['nombre'];
                
                $total_valor = $value['activos'][0]['suma_valores'];
                $total_activos += $total_valor;

                $total_valor_moneda =  "$ ".number_format($total_valor,2);
	                    
	        	$pdf->cell(50, 6, utf8_decode($nombre_categoria_act) , 0,0,'L',0);
				
				$pdf->cell(50, 6, $total_valor_moneda, 0,1,'R',0);
	        
	        }                                                                                                     

	        $total_activos_moneda = "$ ".number_format($total_activos,2);                                    

	        $pdf->setFillColor(245,245,245);

            $pdf->cell(50, 6, utf8_decode("TOTAL ACTIVOS") , 0,0,'L',1);			
			$pdf->cell(50, 6, $total_activos_moneda, 0,1,'R',1);
			$pdf->ln();                  
	        
	        
			//Secrea ahora la tabla para los egresos
			$pdf->SetFont('Arial','B',10);
			
			$pdf->setFillColor(230,230,230);			
			$pdf->cell(50, 6, utf8_decode("PASIVOS") , 0,0,'L',1);
			$pdf->cell(50, 6, utf8_decode("VALOR") , 0,0,'R',1);
			
			$pdf->ln();
			
			$deudas_usuarios = $this->db->query("SELECT  SUM(if(d.saldo_deuda IS NULL, 0, d.saldo_deuda)) total, 
														UPPER(t.nombre) tipo_deuda
													FROM
														`valor_deudas` d 
													INNER JOIN tipo_deuda t on t.id = d.tipo_deuda_id
													WHERE d.codigo_usuario = '$codigo_usuario' AND d.codigo_evento = '$codigo_evento' 
													AND d.eliminado = 0
													GROUP BY d.tipo_deuda_id ")->result_array();

			 $total_deudas = 0;
			 $pdf->SetFont('Arial','B',8);
                                    
            foreach ($deudas_usuarios as $key => $value) {
                    
                $tipo_deuda = $value['tipo_deuda'];
                $total_valor = $value['total'];
                $total_deudas += $total_valor;
                $total_valor_moneda =  "$ ".number_format($total_valor,2);
                               
                $pdf->cell(50, 6, utf8_decode($tipo_deuda) , 0,0,'L',0);
				$pdf->cell(50, 6, $total_valor_moneda, 0,1,'R',0); 
			}
                        
                                    
            $total_deudas_moneda = "$ ".number_format($total_deudas,2);                                    
            
            $mapa_neto = $total_activos - $total_deudas;
            $mapa_neto_moneda = "$ ".number_format($mapa_neto,2);

            $pdf->setFillColor(245,245,245);

            $pdf->cell(50, 6, utf8_decode("TOTAL PASIVOS") , 0,0,'L',1);			
			$pdf->cell(50, 6, $total_deudas_moneda, 0,1,'R',1);
			$pdf->ln();   
             
            $pdf->cell(50, 6, utf8_decode("RIQUEZA NETA") , 0,0,'L',1);			
			$pdf->cell(50, 6, $mapa_neto_moneda, 0,1,'R',1);
			$pdf->ln();   
                                 
                                 
                                


			$pdf->Output("RiquezasM.pdf", "I");
		}


		function get_datos_flujo($value=''){
				//Traer los datos del usuario actual y el evento al que pertenece
			$codigo_usuario = $this->session->userdata('user_code');						
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];			

		 	$datos['ingresos_usuarios'] = $this->db->query("SELECT if(i.tipo = 'P', 'PASIVO', 'ACTIVO') tipo, 
		 							SUM(if(v.valor IS NULL, 0, v.valor)) suma_valores,
		 							SUM(if(v.valor_adicional IS NULL, 0, v.valor_adicional)) suma_valores_ad		 							
		 							FROM `ingresos` i 
		 							LEFT JOIN valor_ingresos_usuarios v on v.codigo_usuario = '$codigo_usuario' AND v.codigo_evento = '$codigo_evento'
		 							AND v.codigo_ingreso = i.codigo
		 							WHERE i.eliminado = 0 AND i.estado = 1
		 							group by i.tipo 
		 							ORDER by tipo asc")->result_array();		



		 	$datos['categoria_egresos'] = $this->db->query("SELECT 
											UPPER(c.nombre) nombre, c.codigo codigo_categoria 
										FROM
											`categoria_egresos` c
											LEFT JOIN egresos e on e.categoria_egre_code = c.codigo AND e.eliminado = 0 AND e.estado = 1
										WHERE
											c.eliminado = 0 AND c.estado = 1 AND e.codigo IS NOT NULL GROUP BY c.codigo")->result_array();

			foreach ($datos['categoria_egresos'] as $key => $value) {

				$codigo_categoria = $value['codigo_categoria'];

				$datos['categoria_egresos'][$key]['egresos'] = $this->db->query("SELECT SUM(if(v.valor IS NULL, 0, v.valor)) suma_valores,
																SUM(if(v.valor_hormiga IS NULL, 0, v.valor_hormiga)) suma_valores_hormiga
														FROM
																`egresos` e
														LEFT JOIN valor_egresos_usuarios v on v.codigo_usuario = '$codigo_usuario' 
														AND v.codigo_evento = '$codigo_evento' AND v.codigo_egreso = e.codigo
														WHERE e.categoria_egre_code = '$codigo_categoria' AND e.eliminado = 0 AND e.estado = 1
														GROUP BY e.categoria_egre_code")->result_array();
			}

			//Se coloca así momentaneamente mientras se implementa el modulo

			$datos['total_deudas'] = 0;
			return $datos;
		 
			
		}

		function get_datos_flujoPDF($value=''){
				//Traer los datos del usuario actual y el evento al que pertenece

			$codigo_usuario = $this->session->userdata('user_code');						
			$codigo_evento_estado_evento = $this->Model_general->get_codigo_estado_evento();
			$estado_evento = $codigo_evento_estado_evento['estado_evento']; 
			$codigo_evento = $codigo_evento_estado_evento['codigo_evento'];			

			

			$this->load->library('fpdf/Fpdf');
			$pdf = new Fpdf('P','mm','Letter');
			$pdf->setTitulo("PLAN DE LIBERTAD");
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',10);
			$pdf->ln();
			$pdf->setFillColor(230,230,230);
			$pdf->setXY(10,50);
			$pdf->cell(50, 6, utf8_decode("TIPO DE INGRESO") , 0,0,'L',1);
			$pdf->cell(50, 6, utf8_decode("INGRESO MENSUAL") , 0,0,'R',1);
			$pdf->cell(50, 6, utf8_decode("INGRESO ADICIONAL") , 0,0,'R',1);
			$pdf->cell(50, 6, utf8_decode("LIBERTAD FINANCIERA") , 0,1,'R',1);
			$pdf->ln();

			$datos_ingresos = $this->db->query("SELECT if(i.tipo = 'P', 'PASIVO', 'ACTIVO') tipo, 
		 							SUM(if(v.valor IS NULL, 0, v.valor)) suma_valores,
		 							SUM(if(v.valor_adicional IS NULL, 0, v.valor_adicional)) suma_valores_ad		 							
		 							FROM `ingresos` i 
		 							LEFT JOIN valor_ingresos_usuarios v on v.codigo_usuario = '$codigo_usuario' AND v.codigo_evento = '$codigo_evento'
		 							AND v.codigo_ingreso = i.codigo
		 							WHERE i.eliminado = 0 AND i.estado = 1
		 							group by i.tipo 
		 							ORDER by tipo asc")->result_array();

			$pdf->SetFont('Arial','B',8);
			$total_ingresos = 0;
            $total_ingresos_ad = 0;
            foreach ($datos_ingresos as $key => $value) {
                                            
                $nombre_ingreso = $value['tipo'];
                $total_valor = $value['suma_valores'];
                $total_ingresos += $total_valor;

                $total_valor_ad = $value['suma_valores_ad'];
                $total_ingresos_ad += $total_valor_ad;

                $total_valor_lf_ingresos = $total_valor +  $total_valor_ad;

                $total_valor_moneda =  number_format( $total_valor, 2);
                $total_valor_ad_moneda =  number_format($total_valor_ad,2); 
                $total_valor_lf_ingresos_moneda =  number_format($total_valor_lf_ingresos, 2);
				
				$pdf->cell(50, 6, utf8_decode("INGRESO ".$nombre_ingreso) , 0,0,'L',0);
				$pdf->cell(50, 6, "$ ".$total_valor_moneda, 0,0,'R',0);
				$pdf->cell(50, 6, "$ ".$total_valor_ad_moneda , 0,0,'R',0);
				$pdf->cell(50, 6, "$ ".$total_valor_lf_ingresos_moneda , 0,1,'R',0);
                
			}
                                     
            // Para totalizar los ingresos    
            $total_ingresos_lf = $total_ingresos + $total_ingresos_ad;
            $total_ingresos_moneda = number_format( $total_ingresos, 2);                                    
            $total_ingresos_ad_moneda = number_format($total_ingresos_ad,2);

            $total_ingresos_lf_moneda = number_format($total_ingresos_lf,2);

            $pdf->setFillColor(245,245,245);

            $pdf->cell(50, 6, utf8_decode("TOTAL INGRESOS") , 0,0,'L',1);
			$pdf->cell(50, 6, "$ ".$total_ingresos_moneda , 0,0,'R',1);
			$pdf->cell(50, 6, "$ ".$total_ingresos_ad_moneda , 0,0,'R',1);
			$pdf->cell(50, 6, "$ ".$total_ingresos_lf_moneda , 0,1,'R',1);
			$pdf->ln();
             

			//Secrea ahora la tabla para los egresos
			$pdf->SetFont('Arial','B',10);
			
			$pdf->setFillColor(230,230,230);			
			$pdf->cell(50, 6, utf8_decode("TIPO DE EGRESOS") , 0,0,'L',1);
			$pdf->cell(50, 6, utf8_decode("EGRESO MENSUAL") , 0,0,'R',1);
			$pdf->cell(50, 6, utf8_decode("AHORRO HORMIGA") , 0,0,'R',1);
			$pdf->cell(50, 6, " " , 0,1,'R',1);
			$pdf->ln();
			
            $categoria_egresos = $this->db->query("SELECT 
											UPPER(c.nombre) nombre, c.codigo codigo_categoria 
										FROM
											`categoria_egresos` c
											LEFT JOIN egresos e on e.categoria_egre_code = c.codigo AND e.eliminado = 0 AND e.estado = 1
										WHERE
											c.eliminado = 0 AND c.estado = 1 AND e.codigo IS NOT NULL GROUP BY c.codigo")->result_array();

			foreach ($categoria_egresos as $key => $value) {
							
				$codigo_categoria = $value['codigo_categoria'];

				$categoria_egresos[$key]['egresos'] = $this->db->query("SELECT SUM(if(v.valor IS NULL, 0, v.valor)) suma_valores,
																SUM(if(v.valor_hormiga IS NULL, 0, v.valor_hormiga)) suma_valores_hormiga
														FROM
																`egresos` e
														LEFT JOIN valor_egresos_usuarios v on v.codigo_usuario = '$codigo_usuario' 
														AND v.codigo_evento = '$codigo_evento' AND v.codigo_egreso = e.codigo
														WHERE e.categoria_egre_code = '$codigo_categoria' AND e.eliminado = 0 AND e.estado = 1
														GROUP BY e.categoria_egre_code")->result_array();
			}

			//Se coloca así momentaneamente mientras se implementa el modulo

			$total_deudas = 0; 
			

			$pdf->SetFont('Arial','B',8);

			$total_egresos = 0;
            $total_egresos_h = 0;
            foreach ($categoria_egresos as $key => $value) {
                $nombre_categoria_egr = $value['nombre'];
                
                $total_valor = $value['egresos'][0]['suma_valores'];
                $total_egresos += $total_valor;

                $total_valor_h = $value['egresos'][0]['suma_valores_hormiga'];
                $total_egresos_h += $total_valor_h;

                $total_valor_LFE =  $total_valor - $total_valor_h;

                
                $total_valor_moneda =  number_format($total_valor,2);
                $total_valor_h_moneda =  number_format($total_valor_h,2);
                $total_valor_LFE_moneda =  number_format($total_valor_LFE,2);
                    
                $pdf->cell(50, 6, utf8_decode($nombre_categoria_egr) , 0,0,'L',0);
				$pdf->cell(50, 6, "$ ".$total_valor_moneda , 0,0,'R',0);
				$pdf->cell(50, 6, "$ ".$total_valor_h_moneda , 0,0,'R',0);
				$pdf->cell(50, 6, "$ ".$total_valor_LFE_moneda , 0,1,'R',0);

            }
			//Setotalizan los egresos el total_deudas ya viene con valor desde el modulo
            $total_egresos += $total_deudas; 
            $total_deudas_moneda = number_format( $total_deudas, 2);

            $total_LFE = $total_egresos - $total_egresos_h;
            $total_LFE_moneda = number_format( $total_LFE,2);

            $total_egresos_moneda = number_format( $total_egresos,2);                                    
            $total_egresos_h_moneda = number_format( $total_egresos_h,2);

            $flujo_neto = $total_ingresos - $total_egresos;
            $flujo_neto_moneda = number_format( $flujo_neto,2);


            $meta_plan = $total_ingresos_ad + $total_egresos_h;
            $meta_plan_moneda = number_format( $meta_plan,2);

            $total_libertad = $total_ingresos_lf - $total_LFE;
            $total_libertad_moneda = number_format( $total_libertad,2);
    		
    		$pdf->cell(50, 6, utf8_decode("DEUDAS") , 0,0,'L',0);
			$pdf->cell(50, 6, "$ ".$total_deudas_moneda , 0,0,'R',0);
			$pdf->cell(50, 6, " " , 0,0,'R',0);
			$pdf->cell(50, 6, " " , 0,1,'R',0);
    		
    		$pdf->setFillColor(245,245,245);

            $pdf->cell(50, 6, utf8_decode("TOTAL EGRESOS") , 0,0,'L',1);
			$pdf->cell(50, 6, "$ ".$total_egresos_moneda , 0,0,'R',1);
			$pdf->cell(50, 6, "$ ".$total_egresos_h_moneda , 0,0,'R',1);
			$pdf->cell(50, 6, "$ ".$total_LFE_moneda , 0,1,'R',1);
			$pdf->ln();                  

			//Para los totales generales flijo neto
			$pdf->cell(50, 6, utf8_decode("FLUJO NETO") , 0,0,'L',1);
			$pdf->cell(50, 6, "$ ".$flujo_neto_moneda , 0,0,'R',1);
			$pdf->cell(50, 6, "$ ".$meta_plan_moneda , 0,0,'R',1);
			$pdf->cell(50, 6, "$ ".$total_libertad_moneda , 0,1,'R',1);
			$pdf->ln();                  

			$pdf->Output("flujo_dinero.pdf", "I");
		}

	}
?>
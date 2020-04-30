<?php 
class ControllerSaleDepositos extends Controller {
	private $error = array(); 
     
  	public function index() {
		    	
		$this->document->setTitle('Dep&oacute;sitos'); 
		
		$this->load->model('sale/depositos');
		$this->load->model('sale/order');
		$this->load->model('inscripciones/solicitud');
		$this->load->model('inscripciones/numeros');
		$this->load->model('inscripciones/participantes');
		
		$this->getForm();
  	}
  
  	public function update() {
    	
		$this->load->model('sale/depositos');
		$this->load->model('sale/order');
		$this->load->model('inscripciones/solicitud');
		$this->load->model('inscripciones/numeros');
		$this->load->model('inscripciones/participantes');

    	$this->document->setTitle('Dep&oacute;sitos');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if (isset($this->request->files['archivo_depositos_carga']['tmp_name'])) {

				if (is_uploaded_file($this->request->files['archivo_depositos_carga']['tmp_name'])) {
					
					$filename = 'archivo_depositos.csv';
	
					move_uploaded_file($this->request->files['archivo_depositos_carga']['tmp_name'], DIR_UPLOAD . $filename);
					
					if (file_exists(DIR_UPLOAD . $filename)) {

						$contenido = DIR_UPLOAD . $filename;
						$this->model_sale_depositos->importarDepositos($contenido);
				
					}
			
				}

			}

			if (ob_get_level() == 0) ob_start();

			$total_infile = 0;
			$total_processed = 0;
			$total_confirmed = 0;
			$total_depurated = 0;

			$solicitudes = 0;
			
			$results = $this->model_sale_order->getOrdersDTAuto();
			$solicitudes_total = count($results);

//			echo 'Total Solicitudes: ' . count($results) . '<br />';

			foreach ($results as $result) {
				
				$depositos_varios = strrpos($result['payment_number'], ",");
				
//				echo 'Numeros de Pago: ' . count($depositos_varios) . '<br />';
	
				if ($depositos_varios) {
					
					$cantidad_depositos = count($depositos_varios);
				
					$depositos_array = explode(',',$result['payment_number']);
				
					foreach ($depositos_array as $key => $deposito) {
						
						if ($deposito == '' || $deposito === '') {
							$deposito = 'n/a';
						}
				
						if (substr($deposito,0, 8) == '00523000') {
							
							$numero_deposito = substr($deposito, 8);
							
						} else if (substr($deposito,0, 7) == '0052300') {
							
							$numero_deposito = substr($deposito, 7);
							
						} else if (substr($deposito,0, 7) == '102-98-') {
							
							$numero_deposito = substr($deposito, 7);
							
						} else if (substr($deposito,0, 6) == 'IB0000') {
							
							$numero_deposito = substr($deposito, 6);
							
						} else if (substr($deposito,0, 6) == 'TE0000') {
							
							$numero_deposito = substr($deposito, 6);
							
						} else if (substr($deposito,0, 6) == 'te0000') {
							
							$numero_deposito = substr($deposito, 6);
							
						} else if (substr($deposito,0, 6) == 'Te0000') {
							
							$numero_deposito = substr($deposito, 6);
							
						} else if (substr($deposito,0, 6) == 'tE0000') {
							
							$numero_deposito = substr($deposito, 6);
							
						} else if (substr($deposito,0, 5) == '52300') {
							
							$numero_deposito = substr($deposito, 5);
							
						} else if (substr($deposito,0, 5) == 'te000') {
							
							$numero_deposito = substr($deposito, 5);
							
						} else if (substr($deposito,0, 5) == 'TE000') {
							
							$numero_deposito = substr($deposito, 5);
							
						} else if (substr($deposito,0, 5) == 'tE000') {
							
							$numero_deposito = substr($deposito, 5);
							
						} else if (substr($deposito,0, 5) == 'Te000') {
							
							$numero_deposito = substr($deposito, 5);
							
						} else if (substr($deposito,0, 4) == '0012') {
							
							$numero_deposito = substr($deposito, 4);
							
						} else if (substr($deposito,0, 4) == '4251') {
							
							$numero_deposito = substr($deposito, 4);
							
						} else if (substr($deposito,0, 1) == '0') {
							
							$numero_deposito = substr($deposito, 1);
							
						} else if (substr($deposito,0, 2) == '00') {
							
							$numero_deposito = substr($deposito, 2);
	
						} else if (substr($deposito,0, 3) == '000') {
							
							$numero_deposito = substr($deposito, 3);
	
						} else if (substr($deposito,0, 4) == '0000') {
							
							$numero_deposito = substr($deposito, 4);
	
						} else if (substr($deposito,0, 5) == '00000') {
							
							$numero_deposito = substr($deposito, 5);
	
						} else if (substr($deposito,0, 6) == '000000') {
							
							$numero_deposito = substr($deposito, 6);
	
						} else if (substr($deposito,0, 7) == '0000000') {
							
							$numero_deposito = substr($deposito, 7);
	
						} else if (substr($deposito,0, 8) == '00000000') {
							
							$numero_deposito = substr($deposito, 8);
	
						} else if (substr($deposito,0, 9) == '000000000') {
							
							$numero_deposito = substr($deposito, 9);
	
						} else {
							
							$numero_deposito = $deposito;
							if ($numero_deposito == '') {
								$numero_deposito = 'n/a';
							}
	
						}

//						echo 'El numero de deposito es: ' . $numero_deposito . '<br />';

						$monto = 0;
						$monto_total = 0;
						
						$montos_soliciitud = $this->model_sale_depositos->getMontoBySolicitud($result['order_id']);
						
//						echo 'Total de Eventos: ' . count($montos_soliciitud) . '<br />';
		
						foreach ($montos_soliciitud as $value) {
							
							$valor = $value['price'];
							$monto = $valor;
							$monto_total = $monto_total + $valor;
							
//							echo 'El monto individual es: ' . $monto . '<br />';
	
							$deposito = $this->model_sale_depositos->getDeposito($numero_deposito, $monto);
				
							if ($deposito) {
								$this->model_sale_depositos->processDeposito($deposito['solicitud_deposito_id']);
			
								$eventos_opciones = $this->model_inscripciones_solicitud->getEventosBySolicitudOpcion($result['order_id']);
						
								foreach ($eventos_opciones as $evento_opcion) {
						
									$codigo_evento = $this->model_inscripciones_solicitud->getEventoIdByOpcion($result['order_id'], $evento_opcion['codigo_opcion']);
									$cedula = $this->model_inscripciones_participantes->getParticipanteCedula($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
									$categoria = $this->model_inscripciones_participantes->getParticipanteCategoria($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
									$tiempo = $this->model_inscripciones_participantes->getParticipanteTiempo($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
//									$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
									if ($codigo_evento == 86) {
										$grupo = $this->model_inscripciones_participantes->getParticipanteModalidad($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
									} else {
										$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
									}

									$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);
			//						echo 'El numero es: ' . $numero . '<br />';
						
									$this->model_inscripciones_participantes->confirm($cedula, $result['order_id'], $codigo_evento, $numero, $evento_opcion['codigo_opcion']);
							
									echo 'La solicitud de inscripcion N°: ' . $result['order_id'] . ' ha sido confirmada con el N° de transaccion: ' . $numero_deposito . '.<br />';
			
								}
			
								$this->model_sale_depositos->updateDeposito($deposito, $monto);
		
								$solicitud_saldada = $this->model_inscripciones_solicitud->getSaldoSolicitud($result['order_id'], $monto_total);
						
								if ($solicitud_saldada) {
			
									$data = array();
									$data = array(
										'order_status_id'	=> 3,
										'comment'			=> '',
										'notify'			=> false,
									);
				
									$this->model_sale_order->addOrderHistory($result['order_id'], $data);
									
									$this->model_sale_depositos->updateDeposito($deposito['solicitud_deposito_id'], $result['total']);
									
								}
							}
						}
					}

				} else {

					if (substr($result['payment_number'],0, 8) == '00523000') {
						
						$numero_deposito = substr($result['payment_number'], 8);
						
					} else if (substr($result['payment_number'],0, 7) == '0052300') {
						
						$numero_deposito = substr($result['payment_number'], 7);
						
					} else if (substr($result['payment_number'],0, 7) == '102-98-') {
						
						$numero_deposito = substr($result['payment_number'], 7);
						
					} else if (substr($result['payment_number'],0, 6) == 'IB0000') {
						
						$numero_deposito = substr($result['payment_number'], 6);
						
					} else if (substr($result['payment_number'],0, 6) == 'TE0000') {
						
						$numero_deposito = substr($result['payment_number'], 6);
						
					} else if (substr($result['payment_number'],0, 6) == 'te0000') {
						
						$numero_deposito = substr($result['payment_number'], 6);
						
					} else if (substr($result['payment_number'],0, 6) == 'Te0000') {
						
						$numero_deposito = substr($result['payment_number'], 6);
						
					} else if (substr($result['payment_number'],0, 6) == 'tE0000') {
						
						$numero_deposito = substr($result['payment_number'], 6);
						
					} else if (substr($result['payment_number'],0, 5) == '52300') {
						
						$numero_deposito = substr($result['payment_number'], 5);
						
					} else if (substr($result['payment_number'],0, 5) == 'te000') {
						
						$numero_deposito = substr($result['payment_number'], 5);
						
					} else if (substr($result['payment_number'],0, 5) == 'TE000') {
						
						$numero_deposito = substr($result['payment_number'], 5);
						
					} else if (substr($result['payment_number'],0, 5) == 'tE000') {
						
						$numero_deposito = substr($result['payment_number'], 5);
						
					} else if (substr($result['payment_number'],0, 5) == 'Te000') {
						
						$numero_deposito = substr($result['payment_number'], 5);
						
					} else if (substr($result['payment_number'],0, 4) == '0012') {
						
						$numero_deposito = substr($result['payment_number'], 4);
						
					} else if (substr($result['payment_number'],0, 4) == '4251') {
						
						$numero_deposito = substr($result['payment_number'], 4);
						
					} else if (substr($result['payment_number'],0, 1) == '0') {
						
						$numero_deposito = substr($result['payment_number'], 1);
						
					} else if (substr($result['payment_number'],0, 2) == '00') {
						
						$numero_deposito = substr($result['payment_number'], 2);

					} else if (substr($result['payment_number'],0, 3) == '000') {
						
						$numero_deposito = substr($result['payment_number'], 3);

					} else if (substr($result['payment_number'],0, 4) == '0000') {
						
						$numero_deposito = substr($result['payment_number'], 4);

					} else if (substr($result['payment_number'],0, 5) == '00000') {
						
						$numero_deposito = substr($result['payment_number'], 5);

					} else if (substr($result['payment_number'],0, 6) == '000000') {
						
						$numero_deposito = substr($result['payment_number'], 6);

					} else if (substr($result['payment_number'],0, 7) == '0000000') {
						
						$numero_deposito = substr($result['payment_number'], 7);

					} else if (substr($result['payment_number'],0, 8) == '00000000') {
						
						$numero_deposito = substr($result['payment_number'], 8);

					} else if (substr($result['payment_number'],0, 9) == '000000000') {
						
						$numero_deposito = substr($result['payment_number'], 9);

					} else {
						
						$numero_deposito = $result['payment_number'];
						if ($numero_deposito == '' || $numero_deposito === '') {
							$numero_deposito = 'n/a';
						}

					}

					$monto = 0;
					
					$montos_soliciitud = $this->model_sale_depositos->getMontoBySolicitud($result['order_id']);
					
					foreach ($montos_soliciitud as $value) {
						
						$valor = $value['price'];
						$monto = $monto + $valor;
						
					}
				
					$deposito = $this->model_sale_depositos->getDeposito($numero_deposito, $monto);
			
					if ($deposito) {
						
						$this->model_sale_depositos->processDeposito($deposito);
	
						$eventos_opciones = $this->model_inscripciones_solicitud->getEventosBySolicitudOpcionD($result['order_id']);
				
						foreach ($eventos_opciones as $evento_opcion) {
				
							$codigo_evento = $this->model_inscripciones_solicitud->getEventoIdByOpcion($result['order_id'], $evento_opcion['codigo_opcion']);

							$cedula = $this->model_inscripciones_participantes->getParticipanteCedula($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);

							$categoria = $this->model_inscripciones_participantes->getParticipanteCategoria($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);

							$tiempo = $this->model_inscripciones_participantes->getParticipanteTiempo($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);

//							$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
							if ($codigo_evento == 86) {
								$grupo = $this->model_inscripciones_participantes->getParticipanteModalidad($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
							} else {
								$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($result['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
							}


							$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);

							$this->model_inscripciones_participantes->confirm($cedula, $result['order_id'], $codigo_evento, $numero, $evento_opcion['codigo_opcion']);
					
							echo 'La solicitud de inscripcion N°: ' . $result['order_id'] . ' ha sido confirmada con el N° de transaccion: ' . $result['payment_number'] . '.<br />';
	
						}
	
//						echo 'El monto es: ' . $monto . '.<br />';

						$this->model_sale_depositos->updateDeposito($deposito, $monto);

						$solicitud_saldada = $this->model_inscripciones_solicitud->getSaldoSolicitud($result['order_id'], $monto);
				
						if ($solicitud_saldada) {
	
							$data = array();
							$data = array(
								'order_status_id'	=> 3,
								'comment'			=> '',
								'notify'			=> false,
							);
		
							$this->model_sale_order->addOrderHistory($result['order_id'], $data);
							
						}
	
					}

				}

				// Checking how many deposits are with 0 or less available coupons, just for statistics
				$total_infile = $this->model_sale_depositos->getDepositosTotal();
				$total_processed = $this->model_sale_depositos->getDepositosProcesados();
				$total_confirmed = $this->model_sale_depositos->getDepositosConfirmados();
				$total_depurated = $this->model_sale_depositos->getDepositosDepurados();
		
				$this->data['depositos_archivo'] = $total_infile;
				$this->data['depositos_procesados'] = $total_processed;
				$this->data['depositos_confirmados'] = $total_confirmed;
				$this->data['depositos_depurados'] = $total_depurated;

				$solicitudes++;
				$porcentaje = $solicitudes * 100 / $solicitudes_total;
				$output = '<script>$("#progressbar").progressbar({value:' . round($porcentaje) . '})</script>';

				ob_flush();
				flush();

				$this->response->setOutput($output);

			}

			ob_end_flush();		

			$this->session->data['success'] = 'Usted ha modificado los dep&oacute;sitos!';

			$url = '';
			
//			$this->redirect($this->url->link('sale/depositos', 'token=' . $this->session->data['token'] . $url, 'SSL'));

		}

    	$this->getForm();

  	}

  	private function getForm() {
    	$this->data['heading_title'] = 'Dep&oacute;sitos';
 
		$this->data['entry_depositos_titulo'] = 'Datos de Dep&oacute;sitos';
		$this->data['entry_depositos_archivo'] = 'Dep&oacute;sitos en archivo';
		$this->data['entry_depositos_procesados'] = 'Dep&oacute;sitos procesados';
		$this->data['entry_depositos_confirmados'] = 'Dep&oacute;sitos confirmados';
		$this->data['entry_depositos_depurados'] = 'Dep&oacute;sitos depurados';
		$this->data['entry_depositos_sobreutilizados'] = 'Dep&oacute;sitos sobreutilizados';
		$this->data['entry_depositos_carga_titulo'] = 'Importar Dep&oacute;sitos';
		$this->data['entry_depositos_progreso_titulo'] = 'Progreso de Confirmaci&oacute;n';
		$this->data['entry_depositos_carga_descripcion'] = 'Seleccione el archivo que contiene los datos de depositos';

    	$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Dep&oacute;sitos',
			'href'      => $this->url->link('sale/depositos', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['action'] = $this->url->link('sale/depositos/update', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('sale/depositos', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['token'] = $this->session->data['token'];

		$total_infile = 0;
		$total_processed = 0;
		$total_confirmed = 0;
		$total_depurated = 0;

		// Checking how many deposits are with 0 or less available coupons, just for statistics
		$total_infile = $this->model_sale_depositos->getDepositosTotal();
		$total_processed = $this->model_sale_depositos->getDepositosProcesados();
		$total_confirmed = $this->model_sale_depositos->getDepositosConfirmados();
		$total_depurated = $this->model_sale_depositos->getDepositosDepurados();

		$this->data['depositos_archivo'] = $total_infile;
		$this->data['depositos_procesados'] = $total_processed;
		$this->data['depositos_confirmados'] = $total_confirmed;
		$this->data['depositos_depurados'] = $total_depurated;

		$this->template = 'sale/depositos_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'sale/depositos')) {
      		$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los eventos!';
    	}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Advertencia: ¡Por favor verifique la informaci&oacute;n!';
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}

	public function progreso() {
		
		$json = array();

		$this->load->model('sale/depositos');

		$depositos_total = $this->model_sale_depositos->getDepositosTotal();
		
		$depositos = $this->model_sale_depositos->getDepositos();

		$depo = $this->request->get['depo'];

    	foreach ($depositos as $deposito) {

			$depo++;
			$json['depo'] = $depo;
			$porcentaje = $depo * 100 / $depositos_total;
			$json['porcentaje'] = $porcentaje;

			$this->load->library('json');
			$this->response->setOutput(Json::encode($json));

		}

	}  

	public function status() {
		
		$output = '';

		$this->load->model('sale/depositos');

		$depositos_total = $this->model_sale_depositos->getDepositosTotal();
		
		$depositos = $this->model_sale_depositos->getDepositos();

//		if (isset($this->request->get['depo'])) {

//			$depo = $this->request->get['depo'];
			$depo = 0;
	
			foreach ($depositos as $deposito) {
	
				$depo++;
				$porcentaje = $depo * 100 / $depositos_total;
				$output = '<script>$("#progressbar").progressbar({value:' . round($porcentaje) . '})</script>';
				flush();
				ob_flush();
	
			}

			$this->response->setOutput($output);
			
//		}
	}  

}
?>
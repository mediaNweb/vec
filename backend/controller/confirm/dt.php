<?php
class ControllerConfirmDt extends Controller {
	private $error = array();

  	public function index() {
		$this->load->idioma('confirm/dt');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('sale/order');

    	$this->getList();
  	}
	
	public function confirm() {

		$this->load->idioma('confirm/dt');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('sale/order');
		
		if (isset($this->request->post['selected']) && $this->validateForm()) {

			$this->load->model('inscripciones/solicitud');
			$this->load->model('inscripciones/numeros');
			$this->load->model('inscripciones/participantes');
	
			$data = array();
			$data = array(
				'order_status_id'	=> 3,
				'comment'			=> '',
				'notify'			=> false,
			);
	
			foreach ($this->request->post['selected'] as $order_id) {

				$this->model_sale_order->addOrderHistory($order_id, $data);
				
				$eventos_opciones = $this->model_inscripciones_solicitud->getEventosBySolicitudOpcion($order_id);
		
	//			$json['mensaje'] = 'El arreglo tiene: ' . count($eventos_id) . 'registros';				
		
				foreach ($eventos_opciones as $evento_opcion) {
		
					$codigo_evento = $this->model_inscripciones_solicitud->getEventoIdByOpcion($order_id, $evento_opcion['codigo_opcion']);
					$cedula = $this->model_inscripciones_participantes->getParticipanteCedula($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					$categoria = $this->model_inscripciones_participantes->getParticipanteCategoria($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					$tiempo = $this->model_inscripciones_participantes->getParticipanteTiempo($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					if ($codigo_evento == 86) {
						$grupo = $this->model_inscripciones_participantes->getParticipanteModalidad($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					} else {
						$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					}
					
					$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);
		
					$this->model_inscripciones_participantes->confirm($cedula, $order_id, $codigo_evento, $numero, $evento_opcion['codigo_opcion']);
			
					if ($codigo_evento == 38) {
		
						$combo = $this->model_inscripciones_participantes->getParticipanteComboByOpcion($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
						
						if ($combo == 'Si') {
		
							$codigo_evento = 31;

							$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);
			
							$this->model_inscripciones_participantes->confirm($cedula, $order_id, $codigo_evento, $numero, $evento_opcion['codigo_opcion']);
							
						}
						
					}

				}

			}

			$this->session->data['success'] = $this->idioma->get('text_success');
				
		}

    	$this->getList();

	}

  	private function getList() {

//		if (isset($this->request->get['eventos_id'])) {
			$eventos_id = $this->request->get['eventos_id'];
//		} else {
//			$eventos_id = 0;
//		}

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_cliente'])) {
			$filter_cliente = $this->request->get['filter_cliente'];
		} else {
			$filter_cliente = null;
		}

		if (isset($this->request->get['filter_payment_number'])) {
			$filter_payment_number = $this->request->get['filter_payment_number'];
		} else {
			$filter_payment_number = null;
		}
		
		if (isset($this->request->get['filter_payment_date'])) {
			$filter_payment_date = $this->request->get['filter_payment_date'];
		} else {
			$filter_payment_date = null;
		}
		
		if (isset($this->request->get['filter_evento'])) {
			$filter_evento = $this->request->get['filter_evento'];
		} else {
			$filter_evento = null;
		}
		
		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_cliente'])) {
			$url .= '&filter_cliente=' . $this->request->get['filter_cliente'];
		}
											
		if (isset($this->request->get['filter_payment_number'])) {
			$url .= '&filter_payment_number=' . $this->request->get['filter_payment_number'];
		}
					
		if (isset($this->request->get['filter_payment_date'])) {
			$url .= '&filter_payment_date=' . $this->request->get['filter_payment_date'];
		}
					
		if (isset($this->request->get['filter_evento'])) {
			$url .= '&filter_evento=' . $this->request->get['filter_evento'];
		}
					
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&eventos_id=' . $eventos_id . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['orders'] = array();

		$data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_cliente'	     => $filter_cliente,
			'filter_payment_number'  => $filter_payment_number,
			'filter_payment_date'  	 => $filter_payment_date,
			'filter_evento'          => $filter_evento,
			'filter_total'           => $filter_total,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$order_total = $this->model_sale_order->getTotalOrdersDT($data, $eventos_id);

		$results = $this->model_sale_order->getOrdersDT($data, $eventos_id);

    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->idioma->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);

/*
			$action[] = array(
				'text' => $this->idioma->get('text_confirm'),
				'href' => $this->url->link('confirm/dt/confirm', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
*/

			$this->data['orders'][] = array(
				'order_id'      	=> $result['order_id'],
				'cliente'      		=> $result['cliente'],
//				'status'        	=> $result['status'],
				'payment_number'	=> $result['payment_number'],
				'payment_date'		=> $result['payment_date'],
				'evento'			=> $result['evento'],
				'total'         	=> $this->moneda->format($result['total'], $result['currency_code'], $result['currency_value']),
				'selected'      	=> isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        	=> $action
			);
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');
		$this->data['eventos_id'] = $eventos_id;
		$this->data['to_confirm'] = $order_total;

		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_abandoned_orders'] = $this->idioma->get('text_abandoned_orders');

		$this->data['column_order_id'] = $this->idioma->get('column_order_id');
    	$this->data['column_cliente'] = $this->idioma->get('column_cliente');
		$this->data['column_status'] = $this->idioma->get('column_status');
		$this->data['column_payment_number'] = $this->idioma->get('column_payment_number');
		$this->data['column_payment_date'] = $this->idioma->get('column_payment_date');
		$this->data['column_evento'] = $this->idioma->get('column_evento');
		$this->data['column_total'] = $this->idioma->get('column_total');
		$this->data['column_action'] = 'Acci&oacute;n';

		$this->data['button_filter'] = 'Filtrar';
		$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_confirm'] = 'Confirmar Seleccionados';

		$this->data['token'] = $this->session->data['token'];

//		$this->data['confirm'] = $this->url->link('confirm/dt/confirm', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . $url, 'SSL');
		$this->data['confirm'] = $this->url->link('confirm/dt/confirm', 'token=' . $this->session->data['token'] . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('confirm/eventos', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_cliente'])) {
			$url .= '&filter_cliente=' . $this->request->get['filter_cliente'];
		}
											
		if (isset($this->request->get['filter_payment_number'])) {
			$url .= '&filter_payment_number=' . $this->request->get['filter_payment_number'];
		}
					
		if (isset($this->request->get['filter_payment_date'])) {
			$url .= '&filter_payment_date=' . $this->request->get['filter_payment_date'];
		}
					
		if (isset($this->request->get['filter_evento'])) {
			$url .= '&filter_evento=' . $this->request->get['filter_evento'];
		}
					
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['sort_cliente'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=cliente' . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=status' . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['sort_payment_number'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=o.payment_number' . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['sort_payment_date'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=o.payment_date' . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['sort_evento'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=evento' . '&eventos_id=' . $eventos_id . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&sort=o.total' . '&eventos_id=' . $eventos_id . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_cliente'])) {
			$url .= '&filter_cliente=' . $this->request->get['filter_cliente'];
		}
											
		if (isset($this->request->get['filter_payment_number'])) {
			$url .= '&filter_payment_number=' . $this->request->get['filter_payment_number'];
		}
					
		if (isset($this->request->get['filter_payment_date'])) {
			$url .= '&filter_payment_date=' . $this->request->get['filter_payment_date'];
		}
					
		if (isset($this->request->get['filter_evento'])) {
			$url .= '&filter_evento=' . $this->request->get['filter_evento'];
		}
					
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('confirm/dt', 'token=' . $this->session->data['token'] . '&eventos_id=' . $eventos_id . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_order_id'] = $filter_order_id;
		$this->data['filter_cliente'] = $filter_cliente;
		$this->data['filter_payment_number'] = $filter_payment_number;
		$this->data['filter_payment_date'] = $filter_payment_date;
		$this->data['filter_evento'] = $filter_evento;
		$this->data['filter_total'] = $filter_total;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'confirm/dt_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
		$this->response->setOutput($this->render());
  	}

  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'confirm/dt')) {
      		$this->error['warning'] = $this->idioma->get('error_permission');
    	}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->idioma->get('error_warning');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    
	
}
?>
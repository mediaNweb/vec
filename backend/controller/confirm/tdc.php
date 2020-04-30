<?php
class ControllerConfirmTdc extends Controller {
	private $error = array();

  	public function index() {
		$this->load->idioma('confirm/tdc');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('sale/order');

    	$this->getList();
  	}
	
	public function confirm() {

		$this->load->idioma('confirm/tdc');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('sale/order');
		
//		if ($this->validateForm()) {
		if (isset($this->request->post['selected']) && $this->validateForm()) {

			$this->load->model('inscripciones/solicitud');
			$this->load->model('inscripciones/numeros');
			$this->load->model('inscripciones/participantes');
	
			$fecha = date("Y-m-d");
	
			foreach ($this->request->post['selected'] as $order_id) {

				$this->session->data['success'] = $this->idioma->get('text_success');
	
				$this->model_inscripciones_solicitud->confirm($order_id, $this->config->get('undostrespagos_order_status_id'), '', $order_id . '_00', $fecha);
				
				$eventos_opciones = $this->model_inscripciones_solicitud->getEventosBySolicitudOpcion($order_id);
		
	//			$json['mensaje'] = 'El arreglo tiene: ' . count($eventos_id) . 'registros';				
		
				foreach ($eventos_opciones as $evento_opcion) {
		
					$this->model_inscripciones_participantes->create($order_id, '' ,'Internet', 'Website', true);
	
					$codigo_evento = $this->model_inscripciones_solicitud->getEventoIdByOpcion($order_id, $evento_opcion['codigo_opcion']);
					$cedula = $this->model_inscripciones_participantes->getParticipanteCedula($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					$categoria = $this->model_inscripciones_participantes->getParticipanteCategoria($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					$tiempo = $this->model_inscripciones_participantes->getParticipanteTiempo($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($order_id, $evento_opcion['codigo_opcion'], $codigo_evento);
					
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
	
		}

    	$this->getList();

	}

  	private function getList() {
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

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
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
											
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
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
			'href'      => $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['orders'] = array();

		$data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_cliente'	     => $filter_cliente,
			'filter_total'           => $filter_total,
			'filter_date_added'      => $filter_date_added,
			'filter_date_modified'   => $filter_date_modified,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$order_total = $this->model_sale_order->getTotalOrdersTDC($data);

		$results = $this->model_sale_order->getOrdersTDC($data);

    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->idioma->get('text_confirm'),
				'href' => $this->url->link('confirm/tdc/confirm', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);

			$this->data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'cliente'      	=> $result['cliente'],
				'status'        => $result['status'],
				'total'         => $this->moneda->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date('d/m/Y', strtotime($result['date_added'])),
				'date_modified' => date('d/m/Y', strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');
		$this->data['to_confirm'] = $order_total;

		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_abandoned_orders'] = $this->idioma->get('text_abandoned_orders');

		$this->data['column_order_id'] = $this->idioma->get('column_order_id');
    	$this->data['column_cliente'] = $this->idioma->get('column_cliente');
		$this->data['column_status'] = $this->idioma->get('column_status');
		$this->data['column_total'] = $this->idioma->get('column_total');
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');
		$this->data['column_date_modified'] = $this->idioma->get('column_date_modified');
		$this->data['column_action'] = 'Acci&oacute;n';

		$this->data['button_filter'] = 'Filtrar';
		$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_confirm'] = 'Confirmar Seleccionados';

		$this->data['token'] = $this->session->data['token'];

		$this->data['confirm'] = $this->url->link('confirm/tdc/confirm', 'token=' . $this->session->data['token'] . $url, 'SSL');
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
											
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_cliente'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . '&sort=cliente' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_cliente'])) {
			$url .= '&filter_cliente=' . $this->request->get['filter_cliente'];
		}
											
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
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
		$pagination->url = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_order_id'] = $filter_order_id;
		$this->data['filter_cliente'] = $filter_cliente;
		$this->data['filter_total'] = $filter_total;
		$this->data['filter_date_added'] = $filter_date_added;
		$this->data['filter_date_modified'] = $filter_date_modified;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'confirm/tdc_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
		$this->response->setOutput($this->render());
  	}

  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'confirm/tdc')) {
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
<?php
class ControllerReportClienteOrder extends Controller {
	public function index() {     
		$this->load->idioma('report/cliente_order');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}	
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
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
			'href'      => $this->url->link('report/cliente_order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/cliente');
		
		$this->data['clientes'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
				
		$cliente_total = $this->model_report_cliente->getTotalOrders($data); 
		
		$results = $this->model_report_cliente->getOrders($data);
		
		foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('sale/cliente/update', 'token=' . $this->session->data['token'] . '&cliente_id=' . $result['cliente_id'] . $url, 'SSL')
			);
						
			$this->data['clientes'][] = array(
				'cliente'       => $result['cliente'],
				'email'          => $result['email'],
				'cliente_group' => $result['cliente_group'],
				'status'         => ($result['status'] ? 'Habilitado' : 'Deshabilitado'),
				'orders'         => $result['orders'],
				'products'       => $result['products'],
				'total'          => $this->moneda->format($result['total'], $this->config->get('config_currency')),
				'action'         => $action
			);
		}
		 
 		$this->data['heading_title'] = $this->idioma->get('heading_title');
		 
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_all_status'] = $this->idioma->get('text_all_status');
		
		$this->data['column_cliente'] = $this->idioma->get('column_cliente');
		$this->data['column_email'] = $this->idioma->get('column_email');
		$this->data['column_cliente_group'] = $this->idioma->get('column_cliente_group');
		$this->data['column_status'] = $this->idioma->get('column_status');
		$this->data['column_orders'] = $this->idioma->get('column_orders');
		$this->data['column_products'] = $this->idioma->get('column_products');
		$this->data['column_total'] = $this->idioma->get('column_total');
		$this->data['column_action'] = 'Acci&oacute;n';
		
		$this->data['entry_date_start'] = $this->idioma->get('entry_date_start');
		$this->data['entry_date_end'] = $this->idioma->get('entry_date_end');
		$this->data['entry_status'] = $this->idioma->get('entry_status');

		$this->data['button_filter'] = 'Filtrar';
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localidad/order_status');
		
		$this->data['order_statuses'] = $this->model_localidad_order_status->getOrderStatuses();
			
		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $cliente_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('report/cliente_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_order_status_id'] = $filter_order_status_id;
				 
		$this->template = 'report/cliente_order.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
}
?>
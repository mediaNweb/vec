<?php
class ControllerReportSaleOrder extends Controller { 
	public function index() {  
		$this->load->idioma('report/sale_order');

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
		
		if (isset($this->request->get['filter_group'])) {
			$filter_group = $this->request->get['filter_group'];
		} else {
			$filter_group = 'week';
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
		
		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
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
			'href'      => $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->load->model('report/sale');
		
		$this->data['orders'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_group'           => $filter_group,
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		$order_total = $this->model_report_sale->getTotalOrders($data);
		
		$results = $this->model_report_sale->getOrders($data);
		
		foreach ($results as $result) {
			$this->data['orders'][] = array(
				'date_start' => date('d/m/Y', strtotime($result['date_start'])),
				'date_end'   => date('d/m/Y', strtotime($result['date_end'])),
				'orders'     => $result['orders'],
				'products'   => $result['products'],
				'impuesto'        => $this->moneda->format($result['impuesto'], $this->config->get('config_currency')),
				'total'      => $this->moneda->format($result['total'], $this->config->get('config_currency'))
			);
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');
		
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_all_status'] = $this->idioma->get('text_all_status');
		
		$this->data['column_date_start'] = $this->idioma->get('column_date_start');
		$this->data['column_date_end'] = $this->idioma->get('column_date_end');
    	$this->data['column_orders'] = $this->idioma->get('column_orders');
		$this->data['column_products'] = $this->idioma->get('column_products');
		$this->data['column_impuesto'] = $this->idioma->get('column_impuesto');
		$this->data['column_total'] = $this->idioma->get('column_total');
		
		$this->data['entry_date_start'] = $this->idioma->get('entry_date_start');
		$this->data['entry_date_end'] = $this->idioma->get('entry_date_end');
		$this->data['entry_group'] = $this->idioma->get('entry_group');	
		$this->data['entry_status'] = $this->idioma->get('entry_status');

		$this->data['button_filter'] = 'Filtrar';
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localidad/order_status');
		
		$this->data['order_statuses'] = $this->model_localidad_order_status->getOrderStatuses();

		$this->data['groups'] = array();

		$this->data['groups'][] = array(
			'text'  => $this->idioma->get('text_year'),
			'value' => 'year',
		);

		$this->data['groups'][] = array(
			'text'  => $this->idioma->get('text_month'),
			'value' => 'month',
		);

		$this->data['groups'][] = array(
			'text'  => $this->idioma->get('text_week'),
			'value' => 'week',
		);

		$this->data['groups'][] = array(
			'text'  => $this->idioma->get('text_day'),
			'value' => 'day',
		);

		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}		

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_group'] = $filter_group;
		$this->data['filter_order_status_id'] = $filter_order_status_id;
				 
		$this->template = 'report/sale_order.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
}
?>
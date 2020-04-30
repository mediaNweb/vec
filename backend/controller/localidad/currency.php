<?php 
class ControllerLocalidadCurrency extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->idioma('localidad/currency');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/currency');
		
		$this->getList();
	}

	public function insert() {
		$this->load->idioma('localidad/currency');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/currency');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_moneda->addCurrency($this->request->post);
			
			$this->session->data['success'] = $this->idioma->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('localidad/currency');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/currency');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_moneda->editCurrency($this->request->get['currency_id'], $this->request->post);
			
			$this->session->data['success'] = $this->idioma->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
					
			$this->redirect($this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->idioma('localidad/currency');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/currency');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $currency_id) {
				$this->model_localidad_moneda->deleteCurrency($currency_id);
			}
			
			$this->session->data['success'] = $this->idioma->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'title';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
	
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
			'href'      => $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('localidad/currency/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localidad/currency/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['currencies'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$currency_total = $this->model_localidad_moneda->getTotalCurrencies();

		$results = $this->model_localidad_moneda->getCurrencies($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('localidad/currency/update', 'token=' . $this->session->data['token'] . '&currency_id=' . $result['currency_id'] . $url, 'SSL')
			);
						
			$this->data['currencies'][] = array(
				'currency_id'   => $result['currency_id'],
				'title'         => $result['title'] . (($result['code'] == $this->config->get('config_currency')) ? ' <b>(Predeterminado)</b>' : null),
				'code'          => $result['code'],
				'value'         => $result['value'],
				'date_modified' => date('d/m/Y', strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['currency_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}	
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_title'] = $this->idioma->get('column_title');
    	$this->data['column_code'] = $this->idioma->get('column_code');
		$this->data['column_value'] = $this->idioma->get('column_value');
		$this->data['column_date_modified'] = $this->idioma->get('column_date_modified');
		$this->data['column_action'] = 'Acci&oacute;n';

		$this->data['button_insert'] = 'Agregar';
		$this->data['button_delete'] = 'Eliminar';

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
		$this->data['sort_code'] = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . '&sort=code' . $url, 'SSL');
		$this->data['sort_value'] = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . '&sort=value' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . '&sort=date_modified' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $currency_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localidad/currency_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->idioma->get('heading_title');
    	
		$this->data['text_enabled'] = 'Habilitado';
    	$this->data['text_disabled'] = 'Deshabilitado';
		
		$this->data['entry_title'] = $this->idioma->get('entry_title');
		$this->data['entry_code'] = $this->idioma->get('entry_code');
		$this->data['entry_value'] = $this->idioma->get('entry_value');
		$this->data['entry_symbol_left'] = $this->idioma->get('entry_symbol_left');
		$this->data['entry_symbol_right'] = $this->idioma->get('entry_symbol_right');
		$this->data['entry_decimal_place'] = $this->idioma->get('entry_decimal_place');
		$this->data['entry_status'] = $this->idioma->get('entry_status');

		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';

		$this->data['tab_general'] = 'General';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}
		
 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
		$url = '';
			
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
			'href'      => $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'),      		
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['currency_id'])) {
			$this->data['action'] = $this->url->link('localidad/currency/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localidad/currency/update', 'token=' . $this->session->data['token'] . '&currency_id=' . $this->request->get['currency_id'] . $url, 'SSL');
		}
				
		$this->data['cancel'] = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['currency_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$currency_info = $this->model_localidad_moneda->getCurrency($this->request->get['currency_id']);
		}

		if (isset($this->request->post['title'])) {
			$this->data['title'] = $this->request->post['title'];
		} elseif (isset($currency_info)) {
			$this->data['title'] = $currency_info['title'];
		} else {
			$this->data['title'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (isset($currency_info)) {
			$this->data['code'] = $currency_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['symbol_left'])) {
			$this->data['symbol_left'] = $this->request->post['symbol_left'];
		} elseif (isset($currency_info)) {
			$this->data['symbol_left'] = $currency_info['symbol_left'];
		} else {
			$this->data['symbol_left'] = '';
		}

		if (isset($this->request->post['symbol_right'])) {
			$this->data['symbol_right'] = $this->request->post['symbol_right'];
		} elseif (isset($currency_info)) {
			$this->data['symbol_right'] = $currency_info['symbol_right'];
		} else {
			$this->data['symbol_right'] = '';
		}

		if (isset($this->request->post['decimal_place'])) {
			$this->data['decimal_place'] = $this->request->post['decimal_place'];
		} elseif (isset($currency_info)) {
			$this->data['decimal_place'] = $currency_info['decimal_place'];
		} else {
			$this->data['decimal_place'] = '';
		}

		if (isset($this->request->post['value'])) {
			$this->data['value'] = $this->request->post['value'];
		} elseif (isset($currency_info)) {
			$this->data['value'] = $currency_info['value'];
		} else {
			$this->data['value'] = '';
		}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($currency_info)) {
			$this->data['status'] = @$currency_info['status'];
		} else {
      		$this->data['status'] = '';
    	}

		$this->template = 'localidad/currency_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validateForm() { 
		if (!$this->user->hasPermission('modify', 'localidad/currency')) { 
			$this->error['warning'] = $this->idioma->get('error_permission');
		} 

		if ((strlen(utf8_decode($this->request->post['title'])) < 3) || (strlen(utf8_decode($this->request->post['title'])) > 32)) {
			$this->error['title'] = $this->idioma->get('error_title');
		}

		if (strlen(utf8_decode($this->request->post['code'])) != 3) {
			$this->error['code'] = $this->idioma->get('error_code');
		}

		if (!$this->error) { 
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localidad/currency')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('sale/order');
		
		foreach ($this->request->post['selected'] as $currency_id) {
			$currency_info = $this->model_localidad_moneda->getCurrency($currency_id);

			if ($currency_info) {
				if ($this->config->get('config_currency') == $currency_info['code']) {
					$this->error['warning'] = $this->idioma->get('error_default');
				}
				
				$store_total = $this->model_setting_store->getTotalStoresByCurrency($currency_info['code']);
	
				if ($store_total) {
					$this->error['warning'] = sprintf($this->idioma->get('error_store'), $store_total);
				}					
			}
			
			$order_total = $this->model_sale_order->getTotalOrdersByCurrencyId($currency_id);

			if ($order_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_order'), $order_total);
			}					
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
}
?>
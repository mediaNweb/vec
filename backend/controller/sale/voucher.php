<?php  
class ControllerSaleVoucher extends Controller {
	private $error = array();
     
  	public function index() {
		$this->load->idioma('sale/voucher');
    	
		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/voucher');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->idioma('sale/voucher');

    	$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/voucher');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_voucher->addVoucher($this->request->post);
			
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
			
			$this->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->idioma('sale/voucher');

    	$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/voucher');
				
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_voucher->editVoucher($this->request->get['voucher_id'], $this->request->post);
      		
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
			
			$this->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->idioma('sale/voucher');

    	$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/voucher');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) { 
			foreach ($this->request->post['selected'] as $voucher_id) {
				$this->model_sale_voucher->deleteVoucher($voucher_id);
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
			
			$this->redirect($this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}

  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'v.date_added';
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
			'href'      => $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('sale/voucher/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/voucher/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['vouchers'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$voucher_total = $this->model_sale_voucher->getTotalVouchers();
	
		$results = $this->model_sale_voucher->getVouchers($data);
 
    	foreach ($results as $result) {
			$action = array();
									
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $result['voucher_id'] . $url, 'SSL')
			);
						
			$this->data['vouchers'][] = array(
				'voucher_id' => $result['voucher_id'],
				'code'       => $result['code'],
				'from'       => $result['from_name'],
				'to'         => $result['to_name'],
				'amount'     => $this->moneda->format($result['amount'], $this->config->get('config_currency')),
				'theme'      => $result['theme'],
				'status'     => ($result['status'] ? 'Habilitado' : 'Deshabilitado'),
				'date_added' => date('d/m/Y', strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['voucher_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}
									
		$this->data['heading_title'] = $this->idioma->get('heading_title');
		
		$this->data['text_send'] = $this->idioma->get('text_send');
		$this->data['text_wait'] = $this->idioma->get('text_wait');
		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_code'] = $this->idioma->get('column_code');
		$this->data['column_from'] = $this->idioma->get('column_from');
		$this->data['column_to'] = $this->idioma->get('column_to');
		$this->data['column_amount'] = $this->idioma->get('column_amount');
		$this->data['column_theme'] = $this->idioma->get('column_theme');
		$this->data['column_status'] = $this->idioma->get('column_status');
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');
		$this->data['column_action'] = 'Acci&oacute;n';		
		
		$this->data['button_insert'] = 'Agregar';
		$this->data['button_delete'] = 'Eliminar';
 
 		$this->data['token'] = $this->session->data['token'];
		
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
		
		$this->data['sort_code'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.code' . $url, 'SSL');
		$this->data['sort_from'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.from_name' . $url, 'SSL');
		$this->data['sort_to'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.to_name' . $url, 'SSL');
		$this->data['sort_amount'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.amount' . $url, 'SSL');
		$this->data['sort_theme'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=theme' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_end' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . '&sort=v.date_added' . $url, 'SSL');
				
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $voucher_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/voucher_list.tpl';
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
		
    	$this->data['entry_code'] = $this->idioma->get('entry_code');
		$this->data['entry_from_name'] = $this->idioma->get('entry_from_name');
		$this->data['entry_from_email'] = $this->idioma->get('entry_from_email');
		$this->data['entry_to_name'] = $this->idioma->get('entry_to_name');
		$this->data['entry_to_email'] = $this->idioma->get('entry_to_email');
		$this->data['entry_message'] = $this->idioma->get('entry_message');
		$this->data['entry_amount'] = $this->idioma->get('entry_amount');
		$this->data['entry_theme'] = $this->idioma->get('entry_theme');
		$this->data['entry_status'] = $this->idioma->get('entry_status');

    	$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';
		
		$this->data['tab_general'] = 'General';
		$this->data['tab_voucher_history'] = $this->idioma->get('tab_voucher_history');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['voucher_id'])) {
			$this->data['voucher_id'] = $this->request->get['voucher_id'];
		} else {
			$this->data['voucher_id'] = 0;
		}
		 		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}		
		
		if (isset($this->error['from_name'])) {
			$this->data['error_from_name'] = $this->error['from_name'];
		} else {
			$this->data['error_from_name'] = '';
		}	
		
		if (isset($this->error['from_email'])) {
			$this->data['error_from_email'] = $this->error['from_email'];
		} else {
			$this->data['error_from_email'] = '';
		}	
		
		if (isset($this->error['to_name'])) {
			$this->data['error_to_name'] = $this->error['to_name'];
		} else {
			$this->data['error_to_name'] = '';
		}	
		
		if (isset($this->error['to_email'])) {
			$this->data['error_to_email'] = $this->error['to_email'];
		} else {
			$this->data['error_to_email'] = '';
		}	
		
		if (isset($this->error['amount'])) {
			$this->data['error_amount'] = $this->error['amount'];
		} else {
			$this->data['error_amount'] = '';
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
			'href'      => $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['voucher_id'])) {
			$this->data['action'] = $this->url->link('sale/voucher/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $this->request->get['voucher_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'] . $url, 'SSL');
  		
		if (isset($this->request->get['voucher_id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$voucher_info = $this->model_sale_voucher->getVoucher($this->request->get['voucher_id']);
    	}

    	if (isset($this->request->post['code'])) {
      		$this->data['code'] = $this->request->post['code'];
    	} elseif (isset($voucher_info)) {
			$this->data['code'] = $voucher_info['code'];
		} else {
      		$this->data['code'] = '';
    	}
		
    	if (isset($this->request->post['from_name'])) {
      		$this->data['from_name'] = $this->request->post['from_name'];
    	} elseif (isset($voucher_info)) {
			$this->data['from_name'] = $voucher_info['from_name'];
		} else {
      		$this->data['from_name'] = '';
    	}
		
    	if (isset($this->request->post['from_email'])) {
      		$this->data['from_email'] = $this->request->post['from_email'];
    	} elseif (isset($voucher_info)) {
			$this->data['from_email'] = $voucher_info['from_email'];
		} else {
      		$this->data['from_email'] = '';
    	}

    	if (isset($this->request->post['to_name'])) {
      		$this->data['to_name'] = $this->request->post['to_name'];
    	} elseif (isset($voucher_info)) {
			$this->data['to_name'] = $voucher_info['to_name'];
		} else {
      		$this->data['to_name'] = '';
    	}
		
    	if (isset($this->request->post['to_email'])) {
      		$this->data['to_email'] = $this->request->post['to_email'];
    	} elseif (isset($voucher_info)) {
			$this->data['to_email'] = $voucher_info['to_email'];
		} else {
      		$this->data['to_email'] = '';
    	}

    	if (isset($this->request->post['message'])) {
      		$this->data['message'] = $this->request->post['message'];
    	} elseif (isset($voucher_info)) {
			$this->data['message'] = $voucher_info['message'];
		} else {
      		$this->data['message'] = '';
    	}
		
    	if (isset($this->request->post['amount'])) {
      		$this->data['amount'] = $this->request->post['amount'];
    	} elseif (isset($voucher_info)) {
			$this->data['amount'] = $voucher_info['amount'];
		} else {
      		$this->data['amount'] = '';
    	}
 
 		$this->load->model('sale/voucher_theme');
			
		$this->data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

    	if (isset($this->request->post['voucher_theme_id'])) {
      		$this->data['voucher_theme_id'] = $this->request->post['voucher_theme_id'];
    	} elseif (isset($voucher_info)) { 
			$this->data['voucher_theme_id'] = $voucher_info['voucher_theme_id'];
		} else {
      		$this->data['voucher_theme_id'] = '';
    	}		
 
    	if (isset($this->request->post['status'])) { 
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($voucher_info)) {
			$this->data['status'] = $voucher_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}

		$this->template = 'sale/voucher_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());		
  	}
	
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/voucher')) {
      		$this->error['warning'] = $this->idioma->get('error_permission');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['code'])) < 3) || (strlen(utf8_decode($this->request->post['code'])) > 10)) {
      		$this->error['code'] = $this->idioma->get('error_code');
    	}
			      
    	if ((strlen(utf8_decode($this->request->post['to_name'])) < 1) || (strlen(utf8_decode($this->request->post['to_name'])) > 64)) {
      		$this->error['to_name'] = $this->idioma->get('error_to_name');
    	}    	
		
		if ((strlen($this->request->post['to_email']) > 96) || !filter_var($this->request->post['to_email'], FILTER_VALIDATE_EMAIL)) {
      		$this->error['to_email'] = $this->idioma->get('error_email');
    	}
		
    	if ((strlen(utf8_decode($this->request->post['from_name'])) < 1) || (strlen(utf8_decode($this->request->post['from_name'])) > 64)) {
      		$this->error['from_name'] = $this->idioma->get('error_from_name');
    	}  
		
		if ((strlen(utf8_decode($this->request->post['from_email'])) > 96) || !filter_var($this->request->post['from_email'], FILTER_VALIDATE_EMAIL)) {
      		$this->error['from_email'] = $this->idioma->get('error_email');
    	}
		
		if ($this->request->post['amount'] < 1) {
      		$this->error['amount'] = $this->idioma->get('error_amount');
    	}

    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/voucher')) {
      		$this->error['warning'] = $this->idioma->get('error_permission');  
    	}
	  	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}	
	
	public function history() {
    	$this->language->load('sale/voucher');
		
		$this->load->model('sale/voucher');
				
		$this->data['text_no_results'] = 'Sin resultados';
		
		$this->data['column_order_id'] = $this->idioma->get('column_order_id');
		$this->data['column_cliente'] = $this->idioma->get('column_cliente');
		$this->data['column_amount'] = $this->idioma->get('column_amount');
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['histories'] = array();
			
		$results = $this->model_sale_voucher->getVoucherHistories($this->request->get['voucher_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'cliente'   => $result['cliente'],
				'amount'     => $this->moneda->format($result['amount'], $this->config->get('config_currency')),
        		'date_added' => date('d/m/Y', strtotime($result['date_added']))
        	);
      	}			
		
		$history_total = $this->model_sale_voucher->getTotalVoucherHistories($this->request->get['voucher_id']);
			
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/voucher/history', 'token=' . $this->session->data['token'] . '&voucher_id=' . $this->request->get['voucher_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/voucher_history.tpl';		
		
		$this->response->setOutput($this->render());
  	}
	
	public function send() {
    	$this->language->load('sale/voucher');
		
		$json = array();
    	
     	if (!$this->user->hasPermission('modify', 'sale/voucher')) {
      		$json['error'] = $this->idioma->get('error_permission'); 
    	} elseif (isset($this->request->get['voucher_id'])) {
			$this->load->model('sale/voucher');
			
			$this->model_sale_voucher->sendVoucher($this->request->get['voucher_id']);
			
			$json['success'] = $this->idioma->get('text_sent');
		}	
			
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));			
  	}			
}
?>
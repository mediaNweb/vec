<?php 
class ControllerPaymentUnDosTresPagos extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/undostrespagos');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('undostrespagos', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_test'] = $this->language->get('text_test');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_capture'] = $this->language->get('text_capture');		
		
		$this->data['entry_login'] = $this->language->get('entry_login');
		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_hash'] = $this->language->get('entry_hash');
		$this->data['entry_server'] = $this->language->get('entry_server');
		$this->data['entry_mode'] = $this->language->get('entry_mode');
		$this->data['entry_method'] = $this->language->get('entry_method');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['login'])) {
			$this->data['error_login'] = $this->error['login'];
		} else {
			$this->data['error_login'] = '';
		}

 		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

 		if (isset($this->error['hash'])) {
			$this->data['error_hash'] = $this->error['hash'];
		} else {
			$this->data['error_hash'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/undostrespagos', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/undostrespagos', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['undostrespagos_login'])) {
			$this->data['undostrespagos_login'] = $this->request->post['undostrespagos_login'];
		} else {
			$this->data['undostrespagos_login'] = $this->config->get('undostrespagos_login');
		}
	
		if (isset($this->request->post['undostrespagos_key'])) {
			$this->data['undostrespagos_key'] = $this->request->post['undostrespagos_key'];
		} else {
			$this->data['undostrespagos_key'] = $this->config->get('undostrespagos_key');
		}
		
		if (isset($this->request->post['undostrespagos_hash'])) {
			$this->data['undostrespagos_hash'] = $this->request->post['undostrespagos_hash'];
		} else {
			$this->data['undostrespagos_hash'] = $this->config->get('undostrespagos_hash');
		}

		if (isset($this->request->post['undostrespagos_server'])) {
			$this->data['undostrespagos_server'] = $this->request->post['undostrespagos_server'];
		} else {
			$this->data['undostrespagos_server'] = $this->config->get('undostrespagos_server');
		}
		
		if (isset($this->request->post['undostrespagos_mode'])) {
			$this->data['undostrespagos_mode'] = $this->request->post['undostrespagos_mode'];
		} else {
			$this->data['undostrespagos_mode'] = $this->config->get('undostrespagos_mode');
		}
		
		if (isset($this->request->post['undostrespagos_method'])) {
			$this->data['undostrespagos_method'] = $this->request->post['undostrespagos_method'];
		} else {
			$this->data['undostrespagos_method'] = $this->config->get('undostrespagos_method');
		}
		
		if (isset($this->request->post['undostrespagos_total'])) {
			$this->data['undostrespagos_total'] = $this->request->post['undostrespagos_total'];
		} else {
			$this->data['undostrespagos_total'] = $this->config->get('undostrespagos_total'); 
		} 
				
		if (isset($this->request->post['undostrespagos_order_status_id'])) {
			$this->data['undostrespagos_order_status_id'] = $this->request->post['undostrespagos_order_status_id'];
		} else {
			$this->data['undostrespagos_order_status_id'] = $this->config->get('undostrespagos_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['undostrespagos_geo_zone_id'])) {
			$this->data['undostrespagos_geo_zone_id'] = $this->request->post['undostrespagos_geo_zone_id'];
		} else {
			$this->data['undostrespagos_geo_zone_id'] = $this->config->get('undostrespagos_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['undostrespagos_status'])) {
			$this->data['undostrespagos_status'] = $this->request->post['undostrespagos_status'];
		} else {
			$this->data['undostrespagos_status'] = $this->config->get('undostrespagos_status');
		}
		
		if (isset($this->request->post['undostrespagos_sort_order'])) {
			$this->data['undostrespagos_sort_order'] = $this->request->post['undostrespagos_sort_order'];
		} else {
			$this->data['undostrespagos_sort_order'] = $this->config->get('undostrespagos_sort_order');
		}

		$this->template = 'payment/undostrespagos.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/undostrespagos')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['undostrespagos_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['undostrespagos_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}

		if (!$this->request->post['undostrespagos_hash']) {
			$this->error['hash'] = $this->language->get('error_hash');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
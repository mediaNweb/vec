<?php 
class ControllerPaymentBankTransfer extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->idioma('payment/bank_transfer');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bank_transfer', $this->request->post);				
			
			$this->session->data['success'] = $this->idioma->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_enabled'] = 'Habilitado';
		$this->data['text_disabled'] = 'Deshabilitado';
		$this->data['text_all_zones'] = $this->idioma->get('text_all_zones');
		
		$this->data['entry_bank'] = $this->idioma->get('entry_bank');
		$this->data['entry_total'] = $this->idioma->get('entry_total');	
		$this->data['entry_order_status'] = $this->idioma->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->idioma->get('entry_geo_zone');
		$this->data['entry_status'] = $this->idioma->get('entry_status');
		$this->data['entry_sort_order'] = $this->idioma->get('entry_sort_order');
		
		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';

		$this->data['tab_general'] = 'General';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->load->model('localidad/idioma');
		
		$languages = $this->model_localidad_idioma->getIdiomas();
		
		foreach ($languages as $language) {
			if (isset($this->error['bank_' . $language['idioma_id']])) {
				$this->data['error_bank_' . $language['idioma_id']] = $this->error['bank_' . $language['idioma_id']];
			} else {
				$this->data['error_bank_' . $language['idioma_id']] = '';
			}
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('payment/bank_transfer', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/bank_transfer', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localidad/idioma');
		
		foreach ($languages as $language) {
			if (isset($this->request->post['bank_transfer_bank_' . $language['idioma_id']])) {
				$this->data['bank_transfer_bank_' . $language['idioma_id']] = $this->request->post['bank_transfer_bank_' . $language['idioma_id']];
			} else {
				$this->data['bank_transfer_bank_' . $language['idioma_id']] = $this->config->get('bank_transfer_bank_' . $language['idioma_id']);
			}
		}
		
		$this->data['languages'] = $languages;
		
		if (isset($this->request->post['bank_transfer_total'])) {
			$this->data['bank_transfer_total'] = $this->request->post['bank_transfer_total'];
		} else {
			$this->data['bank_transfer_total'] = $this->config->get('bank_transfer_total'); 
		} 
				
		if (isset($this->request->post['bank_transfer_order_status_id'])) {
			$this->data['bank_transfer_order_status_id'] = $this->request->post['bank_transfer_order_status_id'];
		} else {
			$this->data['bank_transfer_order_status_id'] = $this->config->get('bank_transfer_order_status_id'); 
		} 
		
		$this->load->model('localidad/order_status');
		
		$this->data['order_statuses'] = $this->model_localidad_order_status->getOrderStatuses();
		
		if (isset($this->request->post['bank_transfer_geo_zone_id'])) {
			$this->data['bank_transfer_geo_zone_id'] = $this->request->post['bank_transfer_geo_zone_id'];
		} else {
			$this->data['bank_transfer_geo_zone_id'] = $this->config->get('bank_transfer_geo_zone_id'); 
		} 
		
		$this->load->model('localidad/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localidad_geo_zone->getGeoZones();
		
		if (isset($this->request->post['bank_transfer_status'])) {
			$this->data['bank_transfer_status'] = $this->request->post['bank_transfer_status'];
		} else {
			$this->data['bank_transfer_status'] = $this->config->get('bank_transfer_status');
		}
		
		if (isset($this->request->post['bank_transfer_sort_order'])) {
			$this->data['bank_transfer_sort_order'] = $this->request->post['bank_transfer_sort_order'];
		} else {
			$this->data['bank_transfer_sort_order'] = $this->config->get('bank_transfer_sort_order');
		}
		

		$this->template = 'payment/bank_transfer.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/bank_transfer')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		$this->load->model('localidad/idioma');

		$languages = $this->model_localidad_idioma->getIdiomas();
		
		foreach ($languages as $language) {
			if (!$this->request->post['bank_transfer_bank_' . $language['idioma_id']]) {
				$this->error['bank_' .  $language['idioma_id']] = $this->idioma->get('error_bank');
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
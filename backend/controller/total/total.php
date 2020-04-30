<?php 
class ControllerTotalTotal extends Controller { 
	private $error = array(); 
	 
	public function index() { 
		$this->load->idioma('total/total');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('total', $this->request->post);
		
			$this->session->data['success'] = $this->idioma->get('text_success');
			
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_enabled'] = 'Habilitado';
		$this->data['text_disabled'] = 'Deshabilitado';
		
		$this->data['entry_status'] = $this->idioma->get('entry_status');
		$this->data['entry_sort_order'] = $this->idioma->get('entry_sort_order');
					
		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('total/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('total/total', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['total_status'])) {
			$this->data['total_status'] = $this->request->post['total_status'];
		} else {
			$this->data['total_status'] = $this->config->get('total_status');
		}

		if (isset($this->request->post['total_sort_order'])) {
			$this->data['total_sort_order'] = $this->request->post['total_sort_order'];
		} else {
			$this->data['total_sort_order'] = $this->config->get('total_sort_order');
		}
																		
		$this->template = 'total/total.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/total')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
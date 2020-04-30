<?php
class ControllerExtensionTotal extends Controller {
	public function index() {
		$this->load->idioma('extension/total');
		 
		$this->document->setTitle($this->idioma->get('heading_title')); 

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['heading_title'] = $this->idioma->get('heading_title');
			
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_confirm'] = $this->idioma->get('text_confirm');

		$this->data['column_name'] = $this->idioma->get('column_name');
		$this->data['column_status'] = $this->idioma->get('column_status');
		$this->data['column_sort_order'] = $this->idioma->get('column_sort_order');
		$this->data['column_action'] = 'Acci&oacute;n';

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
		
			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		$this->load->model('setting/extension');

		$extensions = $this->model_setting_extension->getInstalled('total');
		
		foreach ($extensions as $key => $value) {
			if (!file_exists(DIR_APPLICATION . 'controller/total/' . $value . '.php')) {
				$this->model_setting_extension->uninstall('total', $value);
				
				unset($extensions[$key]);
			}
		}
		
		$this->data['extensions'] = array();
				
		$files = glob(DIR_APPLICATION . 'controller/total/*.php');
		
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				
				$this->load->idioma('total/' . $extension);
	
				$action = array();
				
				if (!in_array($extension, $extensions)) {
					$action[] = array(
						'text' => $this->idioma->get('text_install'),
						'href' => $this->url->link('extension/total/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);
				} else {
					$action[] = array(
						'text' => 'Editar',
						'href' => $this->url->link('total/' . $extension . '', 'token=' . $this->session->data['token'], 'SSL')
					);
								
					$action[] = array(
						'text' => $this->idioma->get('text_uninstall'),
						'href' => $this->url->link('extension/total/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);
				}
										
				$this->data['extensions'][] = array(
					'name'       => $this->idioma->get('heading_title'),
					'status'     => $this->config->get($extension . '_status') ? 'Habilitado' : 'Deshabilitado',
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'action'     => $action
				);
			}
		}

		$this->template = 'extension/total.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function install() {
		if (!$this->user->hasPermission('modify', 'extension/total')) {
			$this->session->data['error'] = $this->idioma->get('error_permission'); 
			
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		} else {				
			$this->load->model('setting/extension');
		
			$this->model_setting_extension->install('total', $this->request->get['extension']);

			$this->load->model('user/user_group');
		
			$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'total/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'total/' . $this->request->get['extension']);

			require_once(DIR_APPLICATION . 'controller/total/' . $this->request->get['extension'] . '.php');
			
			$class = 'ControllerTotal' . str_replace('_', '', $this->request->get['extension']);
			$class = new $class($this->registry);
			
			if (method_exists($class, 'install')) {
				$class->install();
			}
			
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function uninstall() {
		if (!$this->user->hasPermission('modify', 'extension/total')) {
			$this->session->data['error'] = $this->idioma->get('error_permission'); 
			
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		} else {			
			$this->load->model('setting/extension');
			$this->load->model('setting/setting');
		
			$this->model_setting_extension->uninstall('total', $this->request->get['extension']);
		
			$this->model_setting_setting->deleteSetting($this->request->get['extension']);
		
			require_once(DIR_APPLICATION . 'controller/total/' . $this->request->get['extension'] . '.php');
			
			$class = 'ControllerTotal' . str_replace('_', '', $this->request->get['extension']);
			$class = new $class($this->registry);
			
			if (method_exists($class, 'uninstall')) {
				$class->uninstall();
			}
		
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}	
}
?>
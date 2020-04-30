<?php
class ControllerCommonReset extends Controller {
	private $error = array();
	
	public function index() {
		if ($this->user->isLogged()) {
			$this->redirect($this->url->link('common/home', '', 'SSL'));
		}
				
		if (isset($this->request->get['code'])) {
			$code = $this->request->get['code'];
		} else {
			$code = '';
		}
		
		$this->load->model('user/user');
		
		$user_info = $this->model_user_user->getUserByCode($code);
		
		if ($user_info) {
			$this->load->idioma('common/reset');
			
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				$this->model_user_user->editPassword($user_info['user_id'], $this->request->post['password']);
	 
				$this->session->data['success'] = $this->idioma->get('text_success');
		  
				$this->redirect($this->url->link('common/login', '', 'SSL'));
			}
			
			$this->data['breadcrumbs'] = array();
	
			$this->data['breadcrumbs'][] = array(
				'text'      => 'Huis',
				'href'      => $this->url->link('common/home'),        	
				'separator' => false
			); 
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->idioma->get('text_reset'),
				'href'      => $this->url->link('common/reset', '', 'SSL'),       	
				'separator' => ' &raquo; '
			);
			
			$this->data['heading_title'] = $this->idioma->get('heading_title');
	
			$this->data['text_password'] = $this->idioma->get('text_password');
	
			$this->data['entry_password'] = $this->idioma->get('entry_password');
			$this->data['entry_confirm'] = $this->idioma->get('entry_confirm');
	
			$this->data['button_save'] = 'Besparen';
			$this->data['button_cancel'] = 'Annuleren';
	
			if (isset($this->error['password'])) { 
				$this->data['error_password'] = $this->error['password'];
			} else {
				$this->data['error_password'] = '';
			}
	
			if (isset($this->error['confirm'])) { 
				$this->data['error_confirm'] = $this->error['confirm'];
			} else {
				$this->data['error_confirm'] = '';
			}
			
			$this->data['action'] = $this->url->link('common/reset', 'code=' . $code, 'SSL');
	 
			$this->data['cancel'] = $this->url->link('common/login', '', 'SSL');
			
			if (isset($this->request->post['password'])) {
				$this->data['password'] = $this->request->post['password'];
			} else {
				$this->data['password'] = '';
			}
	
			if (isset($this->request->post['confirm'])) {
				$this->data['confirm'] = $this->request->post['confirm'];
			} else {
				$this->data['confirm'] = '';
			}
			
			$this->template = 'common/reset.tpl';
			$this->children = array(
				'common/header',
				'common/footer',
			);
									
			$this->response->setOutput($this->render());						
		} else {
			return $this->forward('common/login');
		}
	}

	private function validate() {
    	if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
      		$this->error['password'] = $this->idioma->get('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->idioma->get('error_confirm');
    	}  

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
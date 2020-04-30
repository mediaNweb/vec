<?php
class ControllerComunMantenimiento extends Controller {
    public function index() {
        if ($this->config->get('config_maintenance')) {
			$route = '';
			
			if (isset($this->request->get['route'])) {
				$part = explode('/', $this->request->get['route']);
				
				if (isset($part[0])) {
					$route .= $part[0];
				}			
			}
			
			// Show site if logged in as admin
			$this->load->library('user');
			
			$this->user = new User($this->registry);
	
			if (($route != 'payment') && !$this->user->isLogged()) {
				return $this->forward('comun/mantenimiento/info');
			}						
        }
    }
		
	public function info() {
        $this->load->language('comun/mantenimiento');
        
        $this->document->setTitle($this->config->get('config_title') . ' ' . $this->idioma->get('heading_title'));
        
        $this->data['heading_title'] = $this->idioma->get('heading_title');
                
        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'text'      => $this->idioma->get('text_maintenance'),
			'href'      => $this->url->link('comun/mantenimiento'),
            'separator' => false
        ); 
        
        $this->data['message'] = $this->idioma->get('text_message');
      
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/mantenimiento.php')) {
            $this->template = $this->config->get('config_template') . '/mantenimiento.php';
        } else {
            $this->template = 'maintenance.php';
        }
		
		$this->children = array(
			'comun/footer',
			'comun/header'
		);
		
		$this->response->setOutput($this->render());
    }
}
?>
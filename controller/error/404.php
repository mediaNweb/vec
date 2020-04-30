<?php   
class ControllerError404 extends Controller {
	public function index() {		
//		$this->idioma->load('error/not_found');
		
        $this->document->setTitle($this->config->get('config_title') . ' ' . $this->config->get('config_title').'- Error 404');
		
		$this->data['breadcrumbs'] = array();
 
      	$this->data['breadcrumbs'][] = array(
        	'text'      => 'Inicio',
			'href'      => $this->url->link('comun/home'),
        	'separator' => false
      	);		
		
		if (isset($this->request->get['route'])) {
       		$this->data['breadcrumbs'][] = array(
        		'text'      => 'Error',
				'href'      => $this->url->link($this->request->get['route']),
        		'separator' => ' &raquo; ',
      		);	   	
		}
		
		$this->data['heading_title'] = $this->document->getTitle();
		
		$this->data['text_error'] = 'P&aacute;gina no encontrada';
		
		$this->data['button_continue'] = 'Continuar';
		
		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
		
		$this->data['continue'] = $this->url->link('comun/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/error/404.php')) {
			$this->template = $this->config->get('config_template') . '/error/404.php';
		} else {
			$this->template = 'error/404.php';
		}
		
		$this->children = array(
            'comun/header',
			'error/404',
			'comun/footer'
		);
		
		$this->response->setOutput($this->render());
  	}
}
?>
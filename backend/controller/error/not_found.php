<?php    
class ControllerErrorNotFound extends Controller {    
	public function index() { 
    	$this->load->idioma('error/not_found');
 
    	$this->document->setTitle($this->idioma->get('heading_title'));

    	$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_not_found'] = $this->idioma->get('text_not_found');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'error/not_found.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());	
  	}
}
?>
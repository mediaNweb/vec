<?php    
class ControllerErrorPermission extends Controller {    
	public function index() { 
  
    	$this->document->setTitle('Permiso Denegado');
		
    	$this->data['heading_title'] = 'Permiso Denegado';

		$this->data['text_permission'] = 'Usted no tiene los permisos para accesar a esta p&aacute;gina por favor contacte al administrador del sistema.';
													
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Permiso Denegado',
			'href'      => $this->url->link('error/permission', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'error/permission.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}
}
?>
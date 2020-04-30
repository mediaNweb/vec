<?php
class ControllerCatalogPreguntas extends Controller { 
	private $error = array();

	public function index() {
		$this->load->idioma('catalog/preguntas');

		$this->document->setTitle($this->idioma->get('heading_title'));
		 
		$this->load->model('catalog/preguntas');

		$this->getList();
	}

	public function insert() {
		$this->load->idioma('catalog/preguntas');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/preguntas');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_preguntas->addPregunta($this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('catalog/preguntas');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/preguntas');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_preguntas->editPregunta($this->request->get['preguntas_frecuentes_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->idioma('catalog/preguntas');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/preguntas');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $preguntas_frecuentes_id) {
				$this->model_catalog_preguntas->deletePregunta($preguntas_frecuentes_id);
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
			
			$this->redirect($this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ec.preguntas_frecuentes_pregunta';
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
       		'text'      => $this->idioma->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/preguntas/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/preguntas/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['preguntas'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$preguntas_total = $this->model_catalog_preguntas->getTotalPreguntas();
	
		$results = $this->model_catalog_preguntas->getPreguntas($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('catalog/preguntas/update', 'token=' . $this->session->data['token'] . '&preguntas_frecuentes_id=' . $result['preguntas_frecuentes_id'] . $url, 'SSL')
			);

			$this->data['preguntas'][] = array(
				'preguntas_frecuentes_id' 	=> $result['preguntas_frecuentes_id'],
				'preguntas_frecuentes_pregunta'	=> $result['preguntas_frecuentes_pregunta'],
				'preguntas_frecuentes_respuesta'	=> $result['preguntas_frecuentes_respuesta'],
				'selected'      	=> isset($this->request->post['selected']) && in_array($result['preguntas_frecuentes_id'], $this->request->post['selected']),
				'action'        	=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = $this->idioma->get('text_no_results');

		$this->data['column_title'] = $this->idioma->get('column_title');
		$this->data['column_calendario_fecha'] = $this->idioma->get('column_calendario_fecha');
		$this->data['column_action'] = $this->idioma->get('column_action');		
		
		$this->data['button_insert'] = $this->idioma->get('button_insert');
		$this->data['button_delete'] = $this->idioma->get('button_delete');
 
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
		
		$this->data['sort_title'] = $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . '&sort=ec.preguntas_frecuentes_pregunta' . $url, 'SSL');
		$this->data['sort_calendario_fecha'] = $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . '&sort=ec.calendario_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $preguntas_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->idioma->get('text_pagination');
		$pagination->url = $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/preguntas_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->idioma->get('heading_title');

    	$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';
		$this->data['text_none'] = $this->idioma->get('text_none');
		$this->data['text_default'] = $this->idioma->get('text_default');
		$this->data['text_enabled'] = $this->idioma->get('text_enabled');
    	$this->data['text_disabled'] = $this->idioma->get('text_disabled');
		
		$this->data['entry_title'] = $this->idioma->get('entry_title');
		$this->data['entry_preguntas_frecuentes_respuesta'] = $this->idioma->get('entry_preguntas_frecuentes_respuesta');
		
		$this->data['button_save'] = $this->idioma->get('button_save');
		$this->data['button_cancel'] = $this->idioma->get('button_cancel');
    	
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['preguntas_frecuentes_pregunta'])) {
			$this->data['error_title'] = $this->error['preguntas_frecuentes_pregunta'];
		} else {
			$this->data['error_title'] = array();
		}

 		if (isset($this->error['preguntas_frecuentes_respuesta'])) {
			$this->data['error_titular'] = $this->error['preguntas_frecuentes_respuesta'];
		} else {
			$this->data['error_titular'] = array();
		}
		
	 	if (isset($this->error['calendario_texto'])) {
			$this->data['error_description'] = $this->error['calendario_texto'];
		} else {
			$this->data['error_description'] = array();
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
       		'text'      => $this->idioma->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['preguntas_frecuentes_id'])) {
			$this->data['action'] = $this->url->link('catalog/preguntas/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/preguntas/update', 'token=' . $this->session->data['token'] . '&preguntas_frecuentes_id=' . $this->request->get['preguntas_frecuentes_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'] . $url, 'SSL');

  		$this->data['posiciones'] = array();

   		$this->data['posiciones'][] = array(
       		'valor'      	=> 'L',
			'descripcion'	=> 'Izquierda',     		
   		);

   		$this->data['posiciones'][] = array(
       		'valor'      	=> 'C',
			'descripcion'	=> 'Centro',     		
   		);

   		$this->data['posiciones'][] = array(
       		'valor'      	=> 'R',
			'descripcion'	=> 'Derecha',     		
   		);

		if (isset($this->request->get['preguntas_frecuentes_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$preguntas_info = $this->model_catalog_preguntas->getPregunta($this->request->get['preguntas_frecuentes_id']);
		}
		
    	if (isset($this->request->post['preguntas_frecuentes_pregunta'])) {
      		$this->data['preguntas_frecuentes_pregunta'] = $this->request->post['preguntas_frecuentes_pregunta'];
    	} elseif (isset($preguntas_info)) {
			$this->data['preguntas_frecuentes_pregunta'] = $preguntas_info['preguntas_frecuentes_pregunta'];
		} else {	
      		$this->data['preguntas_frecuentes_pregunta'] = '';
    	}

    	if (isset($this->request->post['preguntas_frecuentes_respuesta'])) {
      		$this->data['preguntas_frecuentes_respuesta'] = $this->request->post['preguntas_frecuentes_respuesta'];
    	} elseif (isset($preguntas_info)) {
			$this->data['preguntas_frecuentes_respuesta'] = $preguntas_info['preguntas_frecuentes_respuesta'];
		} else {	
      		$this->data['preguntas_frecuentes_respuesta'] = '';
    	}
		
		$this->template = 'catalog/preguntas_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/preguntas')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['preguntas_frecuentes_pregunta'])) < 3) || (strlen(utf8_decode($this->request->post['preguntas_frecuentes_pregunta'])) > 255)) {
			$this->error['preguntas_frecuentes_pregunta'] = $this->idioma->get('error_title');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->idioma->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/preguntas')) {
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
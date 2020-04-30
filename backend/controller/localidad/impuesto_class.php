<?php
class ControllerLocalidadImpuestoClass extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->idioma('localidad/impuesto_class');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/impuesto_class');
		
		$this->getList(); 
	}

	public function insert() {
		$this->load->idioma('localidad/impuesto_class');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/impuesto_class');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_impuesto_class->addImpuestoClass($this->request->post);

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
			
			$this->redirect($this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('localidad/impuesto_class');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/impuesto_class');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_impuesto_class->editImpuestoClass($this->request->get['impuestos_clase_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->idioma('localidad/impuesto_class');

		$this->document->setTitle($this->idioma->get('heading_title'));
 		
		$this->load->model('localidad/impuesto_class');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $impuestos_clase_id) {
				$this->model_localidad_impuesto_class->deleteImpuestoClass($impuestos_clase_id);
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
			
			$this->redirect($this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'impuestos_clase_titulo';
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
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->data['insert'] = $this->url->link('localidad/impuesto_class/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localidad/impuesto_class/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');		
		
		$this->data['impuestos_clasees'] = array();
		
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$impuestos_clase_total = $this->model_localidad_impuesto_class->getTotalImpuestoClasses();

		$results = $this->model_localidad_impuesto_class->getImpuestos($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('localidad/impuesto_class/update', 'token=' . $this->session->data['token'] . '&impuestos_clase_id=' . $result['impuestos_clase_id'] . $url, 'SSL')
			);
					
			$this->data['impuestos_clasees'][] = array(
				'impuestos_clase_id' => $result['impuestos_clase_id'],
				'impuestos_clase_titulo'        => $result['impuestos_clase_titulo'],
				'selected'     => isset($this->request->post['selected']) && in_array($result['impuestos_clase_id'], $this->request->post['selected']),
				'action'       => $action				
			);
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = 'Sin resultados';
	
		$this->data['column_title'] = $this->idioma->get('column_title');
		$this->data['column_action'] = 'Acci&oacute;n';	

		$this->data['button_insert'] = 'Agregar';
		$this->data['button_delete'] = 'Eliminar';
 
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
		 
		$this->data['sort_title'] = $this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . '&sort=impuestos_clase_titulo' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $impuestos_clase_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localidad/impuesto_class_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->idioma->get('heading_title');
				
		$this->data['entry_title'] = $this->idioma->get('entry_title');
		$this->data['entry_description'] = $this->idioma->get('entry_description');
		$this->data['entry_geo_zone'] = $this->idioma->get('entry_geo_zone');
		$this->data['entry_rate'] = $this->idioma->get('entry_rate');
		$this->data['entry_priority'] = $this->idioma->get('entry_priority');
		
		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_add_rate'] = $this->idioma->get('button_add_rate');
		$this->data['button_remove'] = 'Eliminar';
		
		$this->data['tab_general'] = 'General';
		$this->data['tab_rate'] = $this->idioma->get('tab_rate');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['impuestos_clase_titulo'])) {
			$this->data['error_title'] = $this->error['impuestos_clase_titulo'];
		} else {
			$this->data['error_title'] = '';
		}
		
 		if (isset($this->error['impuestos_clase_descripcion'])) {
			$this->data['error_description'] = $this->error['impuestos_clase_descripcion'];
		} else {
			$this->data['error_description'] = '';
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
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['impuestos_clase_id'])) {
			$this->data['action'] = $this->url->link('localidad/impuesto_class/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localidad/impuesto_class/update', 'token=' . $this->session->data['token'] . '&impuestos_clase_id=' . $this->request->get['impuestos_clase_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['impuestos_clase_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$impuestos_clase_info = $this->model_localidad_impuesto_class->getImpuestoClass($this->request->get['impuestos_clase_id']);
		}

		if (isset($this->request->post['impuestos_clase_titulo'])) {
			$this->data['impuestos_clase_titulo'] = $this->request->post['impuestos_clase_titulo'];
		} elseif (isset($impuestos_clase_info)) {
			$this->data['impuestos_clase_titulo'] = $impuestos_clase_info['impuestos_clase_titulo'];
		} else {
			$this->data['impuestos_clase_titulo'] = '';
		}

		if (isset($this->request->post['impuestos_clase_descripcion'])) {
			$this->data['impuestos_clase_descripcion'] = $this->request->post['impuestos_clase_descripcion'];
		} elseif (isset($impuestos_clase_info)) {
			$this->data['impuestos_clase_descripcion'] = $impuestos_clase_info['impuestos_clase_descripcion'];
		} else {
			$this->data['impuestos_clase_descripcion'] = '';
		}

		$this->load->model('localidad/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localidad_geo_zone->getGeoZones();
		
		if (isset($this->request->post['impuesto_rate'])) {
			$this->data['impuestos_tasas'] = $this->request->post['impuesto_rate'];
		} elseif (isset($this->request->get['impuestos_clase_id'])) {
			$this->data['impuestos_tasas'] = $this->model_localidad_impuesto_class->getImpuestoRates($this->request->get['impuestos_clase_id']);
		} else {
			$this->data['impuestos_tasas'] = array();
		}

		$this->template = 'localidad/impuesto_class_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localidad/impuesto_class')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['impuestos_clase_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['impuestos_clase_titulo'])) > 32)) {
			$this->error['impuestos_clase_titulo'] = $this->idioma->get('error_title');
		}

		if ((strlen(utf8_decode($this->request->post['impuestos_clase_descripcion'])) < 3) || (strlen(utf8_decode($this->request->post['impuestos_clase_descripcion'])) > 255)) {
			$this->error['impuestos_clase_descripcion'] = $this->idioma->get('error_description');
		}
		
		if (isset($this->request->post['impuesto_rate'])) {
			foreach ($this->request->post['impuesto_rate'] as $value) {
				if (!$value['impuestos_tasa_prioridad']) {
					$this->error['warning'] = $this->idioma->get('error_priority');
				}

				if (!$value['impuestos_tasa']) { 
					$this->error['warning'] = $this->idioma->get('error_rate');
				}

				if ((strlen(utf8_decode($value['impuestos_tasa_descripcion'])) < 3) || (strlen(utf8_decode($value['impuestos_tasa_descripcion'])) > 255)) {
					$this->error['warning'] = $this->idioma->get('error_description');
				}
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localidad/impuesto_class')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}
		
		$this->load->model('catalog/evento');

		foreach ($this->request->post['selected'] as $impuestos_clase_id) {
			$product_total = $this->model_catalog_evento->getTotalproductsByImpuestoClassId($impuestos_clase_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_product'), $product_total);
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
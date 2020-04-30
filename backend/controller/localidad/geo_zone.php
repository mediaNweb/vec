<?php
class ControllerLocalidadGeoZone extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->idioma('localidad/geo_zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/geo_zone');
		
		$this->getList();
	}

	public function insert() {
		$this->load->idioma('localidad/geo_zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/geo_zone');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_geo_zone->addGeoZone($this->request->post);
			
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
			
			$this->redirect($this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('localidad/geo_zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/geo_zone');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_geo_zone->editGeoZone($this->request->get['geo_zone_id'], $this->request->post);

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
			
			$this->redirect($this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->idioma('localidad/geo_zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/geo_zone');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $geo_zone_id) {
				$this->model_localidad_geo_zone->deleteGeoZone($geo_zone_id);
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
			
			$this->redirect($this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
			'href'      => $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('localidad/geo_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localidad/geo_zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['geo_zones'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$geo_zone_total = $this->model_localidad_geo_zone->getTotalGeoZones();
		
		$results = $this->model_localidad_geo_zone->getGeoZones($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('localidad/geo_zone/update', 'token=' . $this->session->data['token'] . '&geo_zone_id=' . $result['geo_zone_id'] . $url, 'SSL')
			);
					
			$this->data['geo_zones'][] = array(
				'geo_zone_id' => $result['geo_zone_id'],
				'name'        => $result['name'],
				'description' => $result['description'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['geo_zone_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->idioma->get('heading_title');
		
		$this->data['text_no_results'] = 'Sin resultados';
	
		$this->data['column_name'] = $this->idioma->get('column_name');
		$this->data['column_description'] = $this->idioma->get('column_description');
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
		 
		$this->data['sort_name'] = $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_description'] = $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . '&sort=description' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $geo_zone_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localidad/geo_zone_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->idioma->get('heading_title');
				
		$this->data['entry_name'] = $this->idioma->get('entry_name');
		$this->data['entry_description'] = $this->idioma->get('entry_description');
		$this->data['entry_country'] = $this->idioma->get('entry_country');
		$this->data['entry_zone'] = $this->idioma->get('entry_zone');

		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_add_geo_zone'] = $this->idioma->get('button_add_geo_zone');
		$this->data['button_remove'] = 'Eliminar';
				
		$this->data['tab_general'] = 'General';

		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

 		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
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
			'href'      => $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
				
		if (!isset($this->request->get['geo_zone_id'])) {
			$this->data['action'] = $this->url->link('localidad/geo_zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localidad/geo_zone/update', 'token=' . $this->session->data['token'] . '&geo_zone_id=' . $this->request->get['geo_zone_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['geo_zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$geo_zone_info = $this->model_localidad_geo_zone->getGeoZone($this->request->get['geo_zone_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($geo_zone_info)) {
			$this->data['name'] = $geo_zone_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['description'])) {
			$this->data['description'] = $this->request->post['description'];
		} elseif (isset($geo_zone_info)) {
			$this->data['description'] = $geo_zone_info['description'];
		} else {
			$this->data['description'] = '';
		}
		
		$this->load->model('localidad/pais');
		 
		$this->data['paises'] = $this->model_localidad_pais->getPaises();
		
		if (isset($this->request->post['zone_to_geo_zone'])) {
			$this->data['zone_to_geo_zones'] = $this->request->post['zone_to_geo_zone'];
		} elseif (isset($this->request->get['geo_zone_id'])) {
			$this->data['zone_to_geo_zones'] = $this->model_localidad_geo_zone->getZoneToGeoZones($this->request->get['geo_zone_id']);
		} else {
			$this->data['zone_to_geo_zones'] = array();
		}

		$this->template = 'localidad/geo_zone_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localidad/geo_zone')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 32)) {
			$this->error['name'] = $this->idioma->get('error_name');
		}

		if ((strlen(utf8_decode($this->request->post['description'])) < 3) || (strlen(utf8_decode($this->request->post['description'])) > 255)) {
			$this->error['description'] = $this->idioma->get('error_description');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localidad/geo_zone')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}
		
		$this->load->model('localidad/impuesto_class');

		foreach ($this->request->post['selected'] as $geo_zone_id) {
			$impuesto_rate_total = $this->model_localidad_impuesto_class->getTotalImpuestoRatesByGeoZoneId($geo_zone_id);

			if ($impuesto_rate_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_impuesto_rate'), $impuesto_rate_total);
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	public function zone() {
		$output = '<option value="0">' . $this->idioma->get('text_all_zones') . '</option>';
		
		$this->load->model('localidad/estado');
		
		$results = $this->model_localidad_estado->getEstadosByPaisId($this->request->get['paises_id']);

		foreach ($results as $result) {
			$output .= '<option value="' . $result['estados_id'] . '"';

			if ($this->request->get['zone_id'] == $result['estados_id']) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['estados_nombre'] . '</option>';
		}

		$this->response->setOutput($output);
	} 		
}
?>
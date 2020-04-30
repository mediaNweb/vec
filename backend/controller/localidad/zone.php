<?php 
class ControllerLocalidadZone extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->idioma('localidad/zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/estado');
		
		$this->getList();
	}

	public function insert() {
		$this->load->idioma('localidad/zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/estado');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_estado->addZone($this->request->post);
	
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
			
			$this->redirect($this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('localidad/zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/estado');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_estado->editEstado($this->request->get['estados_id'], $this->request->post);			
			
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
			
			$this->redirect($this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->idioma('localidad/zone');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/estado');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $estados_id) {
				$this->model_localidad_estado->deleteZone($estados_id);
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

			$this->redirect($this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.paises_nombre';
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
			'href'      => $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('localidad/zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localidad/zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
	
		$this->data['zones'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$zone_total = $this->model_localidad_estado->getTotalEstados();
			
		$results = $this->model_localidad_estado->getEstados($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('localidad/zone/update', 'token=' . $this->session->data['token'] . '&estados_id=' . $result['estados_id'] . $url, 'SSL')
			);
					
			$this->data['zones'][] = array(
				'estados_id'  => $result['estados_id'],
				'country'  => $result['paises_nombre'],
				'estados_nombre'     => $result['estados_nombre'] . (($result['estados_id'] == $this->config->get('config_estados_id')) ? ' <b>(Predeterminado)</b>' : null),
				'estados_codigo'     => $result['estados_codigo'],
				'selected' => isset($this->request->post['selected']) && in_array($result['estados_id'], $this->request->post['selected']),
				'action'   => $action			
			);
		}
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_country'] = $this->idioma->get('column_country');
		$this->data['column_name'] = $this->idioma->get('column_name');
		$this->data['column_code'] = $this->idioma->get('column_code');
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
		 
		$this->data['sort_country'] = $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . '&sort=c.paises_nombre' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . '&sort=z.estados_nombre' . $url, 'SSL');
		$this->data['sort_code'] = $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . '&sort=z.estados_codigo' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $zone_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localidad/zone_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['entry_status'] = $this->idioma->get('entry_status');
		$this->data['entry_name'] = $this->idioma->get('entry_name');
		$this->data['entry_code'] = $this->idioma->get('entry_code');
		$this->data['entry_country'] = $this->idioma->get('entry_country');

		$this->data['text_enabled'] = 'Habilitado';
		$this->data['text_disabled'] = 'Deshabilitado';
		
		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';
		
		$this->data['tab_general'] = 'General';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['estados_nombre'])) {
			$this->data['error_name'] = $this->error['estados_nombre'];
		} else {
			$this->data['error_name'] = '';
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
			'href'      => $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['estados_id'])) {
			$this->data['action'] = $this->url->link('localidad/zone/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localidad/zone/update', 'token=' . $this->session->data['token'] . '&estados_id=' . $this->request->get['estados_id'] . $url, 'SSL');
		}
		 
		$this->data['cancel'] = $this->url->link('localidad/zone', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['estados_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$zone_info = $this->model_localidad_estado->getEstado($this->request->get['estados_id']);
		}

		if (isset($this->request->post['estados_status'])) {
			$this->data['estados_status'] = $this->request->post['estados_status'];
		} elseif (isset($zone_info)) {
			$this->data['estados_status'] = $zone_info['estados_status'];
		} else {
			$this->data['estados_status'] = '1';
		}
		
		if (isset($this->request->post['estados_nombre'])) {
			$this->data['estados_nombre'] = $this->request->post['estados_nombre'];
		} elseif (isset($zone_info)) {
			$this->data['estados_nombre'] = $zone_info['estados_nombre'];
		} else {
			$this->data['estados_nombre'] = '';
		}

		if (isset($this->request->post['estados_codigo'])) {
			$this->data['estados_codigo'] = $this->request->post['estados_codigo'];
		} elseif (isset($zone_info)) {
			$this->data['estados_codigo'] = $zone_info['estados_codigo'];
		} else {
			$this->data['estados_codigo'] = '';
		}

		if (isset($this->request->post['paises_id'])) {
			$this->data['paises_id'] = $this->request->post['paises_id'];
		} elseif (isset($zone_info)) {
			$this->data['paises_id'] = $zone_info['estados_id_pais'];
		} else {
			$this->data['paises_id'] = '';
		}
		
		$this->load->model('localidad/pais');
		
		$this->data['paises'] = $this->model_localidad_pais->getPaises();

		$this->template = 'localidad/zone_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localidad/zone')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['estados_nombre'])) < 3) || (strlen(utf8_decode($this->request->post['estados_nombre'])) > 64)) {
			$this->error['estados_nombre'] = $this->idioma->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localidad/zone')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}
		
		$this->load->model('setting/store');
		$this->load->model('sale/cliente');
		$this->load->model('sale/affiliate');
		$this->load->model('localidad/geo_zone');
		
		foreach ($this->request->post['selected'] as $estados_id) {
			if ($this->config->get('config_estados_id') == $estados_id) {
				$this->error['warning'] = $this->idioma->get('error_default');
			}
			
			$store_total = $this->model_setting_store->getTotalStoresByZoneId($estados_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_store'), $store_total);
			}
		
			$address_total = $this->model_sale_cliente->getTotalAddressesByZoneId($estados_id);

			if ($address_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_address'), $address_total);
			}

			$affiliate_total = $this->model_sale_affiliate->getTotalAffiliatesByZoneId($estados_id);

			if ($affiliate_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_affiliate'), $affiliate_total);
			}
					
			$zone_to_geo_zone_total = $this->model_localidad_geo_zone->getTotalZoneToGeoZoneByZoneId($estados_id);
		
			if ($zone_to_geo_zone_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_zone_to_geo_zone'), $zone_to_geo_zone_total);
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
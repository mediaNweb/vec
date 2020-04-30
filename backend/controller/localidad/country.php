<?php 
class ControllerLocalidadCountry extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->idioma('localidad/country');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/pais');
		
		$this->getList();
	}

	public function insert() {
		$this->load->idioma('localidad/country');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/pais');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_pais->addPais($this->request->post);
			
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
			
			$this->redirect($this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('localidad/country');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/pais');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localidad_pais->editPais($this->request->get['paises_id'], $this->request->post);

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
					
			$this->redirect($this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->idioma('localidad/country');
 
		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('localidad/pais');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $paises_id) {
				$this->model_localidad_pais->deletePais($paises_id);
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

			$this->redirect($this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'paises_nombre';
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
			'href'      => $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('localidad/country/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localidad/country/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$this->data['paises'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$country_total = $this->model_localidad_pais->getTotalCountries();
		
		$results = $this->model_localidad_pais->getPaises($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('localidad/country/update', 'token=' . $this->session->data['token'] . '&paises_id=' . $result['paises_id'] . $url, 'SSL')
			);

			$this->data['paises'][] = array(
				'paises_id' => $result['paises_id'],
				'paises_nombre'       => $result['paises_nombre'] . (($result['paises_id'] == $this->config->get('config_paises_id')) ? ' <b>(Predeterminado)</b>' : null),
				'paises_iso_code_2' => $result['paises_iso_code_2'],
				'paises_iso_code_3' => $result['paises_iso_code_3'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['paises_id'], $this->request->post['selected']),				
				'action'     => $action
			);
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');
		
		$this->data['text_no_results'] = 'Sin resultados';
		
		$this->data['column_name'] = $this->idioma->get('column_name');
		$this->data['column_iso_code_2'] = $this->idioma->get('column_iso_code_2');
		$this->data['column_iso_code_3'] = $this->idioma->get('column_iso_code_3');
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
		
		$this->data['sort_name'] = $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . '&sort=paises_nombre' . $url, 'SSL');
		$this->data['sort_iso_code_2'] = $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . '&sort=paises_iso_code_2' . $url, 'SSL');
		$this->data['sort_iso_code_3'] = $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . '&sort=paises_iso_code_3' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $country_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localidad/country_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->idioma->get('heading_title');
	
		$this->data['text_enabled'] = 'Habilitado';
		$this->data['text_disabled'] = 'Deshabilitado';
		$this->data['text_yes'] = 'Si';
		$this->data['text_no'] = 'No';
				
		$this->data['entry_name'] = $this->idioma->get('entry_name');
		$this->data['entry_iso_code_2'] = $this->idioma->get('entry_iso_code_2');
		$this->data['entry_iso_code_3'] = $this->idioma->get('entry_iso_code_3');
		$this->data['entry_address_format'] = $this->idioma->get('entry_address_format');
		$this->data['entry_postcode_required'] = $this->idioma->get('entry_postcode_required');
		$this->data['entry_status'] = $this->idioma->get('entry_status');
		
		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';

		$this->data['tab_general'] = 'General';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['paises_nombre'])) {
			$this->data['error_name'] = $this->error['paises_nombre'];
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
			'href'      => $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['paises_id'])) { 
			$this->data['action'] = $this->url->link('localidad/country/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localidad/country/update', 'token=' . $this->session->data['token'] . '&paises_id=' . $this->request->get['paises_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('localidad/country', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if (isset($this->request->get['paises_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$country_info = $this->model_localidad_pais->getPais($this->request->get['paises_id']);
		}

		if (isset($this->request->post['paises_nombre'])) {
			$this->data['paises_nombre'] = $this->request->post['paises_nombre'];
		} elseif (isset($country_info)) {
			$this->data['paises_nombre'] = $country_info['paises_nombre'];
		} else {
			$this->data['paises_nombre'] = '';
		}

		if (isset($this->request->post['paises_iso_code_2'])) {
			$this->data['paises_iso_code_2'] = $this->request->post['paises_iso_code_2'];
		} elseif (isset($country_info)) {
			$this->data['paises_iso_code_2'] = $country_info['paises_iso_code_2'];
		} else {
			$this->data['paises_iso_code_2'] = '';
		}

		if (isset($this->request->post['paises_iso_code_3'])) {
			$this->data['paises_iso_code_3'] = $this->request->post['paises_iso_code_3'];
		} elseif (isset($country_info)) {
			$this->data['paises_iso_code_3'] = $country_info['paises_iso_code_3'];
		} else {
			$this->data['paises_iso_code_3'] = '';
		}

		if (isset($this->request->post['paises_formato_direccion'])) {
			$this->data['paises_formato_direccion'] = $this->request->post['paises_formato_direccion'];
		} elseif (isset($country_info)) {
			$this->data['paises_formato_direccion'] = $country_info['paises_formato_direccion'];
		} else {
			$this->data['paises_formato_direccion'] = '';
		}

		if (isset($this->request->post['postcode_required'])) {
			$this->data['postcode_required'] = $this->request->post['postcode_required'];
		} elseif (isset($country_info)) {
			$this->data['postcode_required'] = $country_info['postcode_required'];
		} else {
			$this->data['postcode_required'] = 0;
		}
				
		if (isset($this->request->post['paises_status'])) {
			$this->data['paises_status'] = $this->request->post['paises_status'];
		} elseif (isset($country_info)) {
			$this->data['paises_status'] = $country_info['paises_status'];
		} else {
			$this->data['paises_status'] = '1';
		}

		$this->template = 'localidad/country_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localidad/country')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['paises_nombre'])) < 3) || (strlen(utf8_decode($this->request->post['paises_nombre'])) > 128)) {
			$this->error['paises_nombre'] = $this->idioma->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localidad/country')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}
		
		$this->load->model('setting/store');
		$this->load->model('sale/cliente');
		$this->load->model('sale/affiliate');
		$this->load->model('localidad/estado');
		$this->load->model('localidad/geo_zone');
		
		foreach ($this->request->post['selected'] as $paises_id) {
			if ($this->config->get('config_paises_id') == $paises_id) {
				$this->error['warning'] = $this->idioma->get('error_default');
			}
			
			$store_total = $this->model_setting_store->getTotalStoresByPaisId($paises_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_store'), $store_total);
			}
			
			$address_total = $this->model_sale_cliente->getTotalAddressesByPaisId($paises_id);
	
			if ($address_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_address'), $address_total);
			}

			$affiliate_total = $this->model_sale_affiliate->getTotalAffiliatesByPaisId($paises_id);
	
			if ($affiliate_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_affiliate'), $affiliate_total);
			}
							
			$zone_total = $this->model_localidad_estado->getTotalZonesByPaisId($paises_id);
		
			if ($zone_total) {
				$this->error['warning'] = sprintf($this->idioma->get('error_zone'), $zone_total);
			}
		
			$zone_to_geo_zone_total = $this->model_localidad_geo_zone->getTotalZoneToGeoZoneByPaisId($paises_id);
		
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
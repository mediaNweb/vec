<?php
class ControllerCatalogOpcion extends Controller {
	private $error = array();  
 
	public function index() {

		$this->document->setTitle('Datos para Inscripci&oacute;n');
		
		$this->load->model('catalog/opcion');
		
		$this->getList();
	}

	public function insert() {

		$this->document->setTitle('Datos para Inscripci&oacute;n');
		
		$this->load->model('catalog/opcion');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_opcion->addOpcion($this->request->post);
			
			$this->session->data['success'] = 'Usted ha modificado los datos para inscripci&oacute;n!';

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
			
			$this->redirect($this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {

		$this->document->setTitle('Datos para Inscripci&oacute;n');
		
		$this->load->model('catalog/opcion');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_opcion->editOpcion($this->request->get['opcion_id'], $this->request->post);
			
			$this->session->data['success'] = 'Usted ha modificado las opciones!';

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
			
			$this->redirect($this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {

		$this->document->setTitle('Datos para Inscripci&oacute;n');
 		
		$this->load->model('catalog/opcion');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $opcion_id) {
				$this->model_catalog_opcion->deleteOpcion($opcion_id);
			}
			
			$this->session->data['success'] = 'Usted ha modificado las opciones!';
			
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
			
			$this->redirect($this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.opcion_nombre';
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
       		'text'      => 'Datos para Inscripci&oacute;n',
			'href'      => $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('catalog/opcion/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/opcion/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$this->data['options'] = array();
		
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$option_total = $this->model_catalog_opcion->getTotalOpciones();
		
		$results = $this->model_catalog_opcion->getOpciones($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('catalog/opcion/update', 'token=' . $this->session->data['token'] . '&opcion_id=' . $result['opcion_id'] . $url, 'SSL')
			);

			$this->data['options'][] = array(
				'opcion_id'  => $result['opcion_id'],
				'opcion_nombre'       => $result['opcion_nombre'],
				'opcion_orden' => $result['opcion_orden'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['opcion_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$this->data['heading_title'] = 'Datos para Inscripci&oacute;n';
		
		$this->data['button_insert'] = 'Agregar';
		$this->data['button_delete'] = 'Eliminar';

		$this->data['text_no_results'] = 'Sin resultados';
		
		$this->data['column_name'] = 'Dato para Inscripci&oacute;n';
		$this->data['column_sort_order'] = 'Orden';
		$this->data['column_action'] = 'Acci&oacute;n';

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
		
		$this->data['sort_name'] = $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . '&sort=od.opcion_nombre' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . '&sort=o.opcion_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $option_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/opcion_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = 'Datos para Inscripci&oacute;n';
		
		$this->data['text_choose'] = 'Selecci&oacute;n';
		$this->data['text_select'] = 'Despliegue';
		$this->data['text_radio'] = 'Selecci&oacute;n simple';
		$this->data['text_checkbox'] = 'Selecci&oacute;n m&uacute;ltiple';
		$this->data['text_input'] = 'Casilla de texto';
		$this->data['text_text'] = 'Texto';
		$this->data['text_textarea'] = '&Aacute;rea de texto';
		$this->data['text_file'] = 'Archivo';
		$this->data['text_date'] = 'Fecha';
		$this->data['text_datetime'] = 'Fecha/Hora';
		$this->data['text_time'] = 'Hora';

		$this->data['entry_name'] = 'Nombre de la opci&oacute;n:';
		$this->data['entry_type'] = 'Tipo:';
		$this->data['entry_value'] = 'Nombre del valor de opci&oacute;n';
		$this->data['entry_sort_order'] = 'Orden';

		$this->data['button_save'] = 'Guardar';
		$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_add_option_value'] = 'Agregar Valor a la Opci&oacute;n';
		$this->data['button_remove'] = 'Eliminar';

		$this->data['tab_general'] = 'General';

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['opcion_nombre'])) {
			$this->data['error_name'] = $this->error['opcion_nombre'];
		} else {
			$this->data['error_name'] = array();
		}	
				
 		if (isset($this->error['valor_opcion'])) {
			$this->data['error_option_value'] = $this->error['valor_opcion'];
		} else {
			$this->data['error_option_value'] = array();
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
       		'text'      => 'Datos para Inscripci&oacute;n',
			'href'      => $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['opcion_id'])) {
			$this->data['action'] = $this->url->link('catalog/opcion/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else { 
			$this->data['action'] = $this->url->link('catalog/opcion/update', 'token=' . $this->session->data['token'] . '&opcion_id=' . $this->request->get['opcion_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['opcion_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$option_info = $this->model_catalog_opcion->getOpcion($this->request->get['opcion_id']);
    	}
		
		if (isset($this->request->post['opcion_descripcion'])) {
			$this->data['opcion_descripcion'] = $this->request->post['opcion_descripcion'];
		} elseif (isset($this->request->get['opcion_id'])) {
			$this->data['opcion_descripcion'] = $this->model_catalog_opcion->getOpcionDescripciones($this->request->get['opcion_id']);
		} else {
			$this->data['opcion_descripcion'] = array();
		}	

		if (isset($this->request->post['opcion_tipo'])) {
			$this->data['opcion_tipo'] = $this->request->post['opcion_tipo'];
		} elseif (isset($option_info)) {
			$this->data['opcion_tipo'] = $option_info['opcion_tipo'];
		} else {
			$this->data['opcion_tipo'] = '';
		}
		
		if (isset($this->request->post['opcion_orden'])) {
			$this->data['opcion_orden'] = $this->request->post['opcion_orden'];
		} elseif (isset($option_info)) {
			$this->data['opcion_orden'] = $option_info['opcion_orden'];
		} else {
			$this->data['opcion_orden'] = '';
		}
		
		if (isset($this->request->post['valor_opcion'])) {
			$this->data['valor_opciones'] = $this->request->post['valor_opcion'];
		} elseif (isset($this->request->get['opcion_id'])) {
			$this->data['valor_opciones'] = $this->model_catalog_opcion->getOpcionValorDescripciones($this->request->get['opcion_id']);
		} else {
			$this->data['valor_opciones'] = array();
		}

		$this->template = 'catalog/opcion_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/opcion')) {
			$this->error['warning'] = 'Advertencia: Usted no tiene los permisos adecuados para modificar las opciones!';
		}

		foreach ($this->request->post['opcion_descripcion'] as $value) {
			if ((strlen(utf8_decode($value['opcion_nombre'])) < 1) || (strlen(utf8_decode($value['opcion_nombre'])) > 128)) {
				$this->error['opcion_nombre'][$language_id] = 'El Nombre de la opci&oacute;n debe contener entre 1 y 128 caract&eacute;res!';
			}
		}

		if (($this->request->post['opcion_tipo'] == 'select' || $this->request->post['opcion_tipo'] == 'radio' || $this->request->post['opcion_tipo'] == 'checkbox') && !isset($this->request->post['valor_opcion'])) {
			$this->error['warning'] = 'Advertencia: Los valores de la opci&oacute;n son requeridos';
		}

		if (isset($this->request->post['valor_opcion'])) {
			foreach ($this->request->post['valor_opcion'] as $opcion_valor_id => $valor_opcion) {
				foreach ($valor_opcion['opcion_valor_descripcion'] as $opcion_valor_descripcion) {
					if ((strlen(utf8_decode($opcion_valor_descripcion['opcion_nombre'])) < 1) || (strlen(utf8_decode($opcion_valor_descripcion['opcion_nombre'])) > 128)) {
						$this->error['valor_opcion'][$opcion_valor_id][0] = 'El Nombre para el Valor de la Opci&oacute;n debe contener entre 1 y 128 caract&eacute;res!';
					}					
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
		if (!$this->user->hasPermission('modify', 'catalog/opcion')) {
			$this->error['warning'] = 'Advertencia: Usted no tiene los permisos adecuados para modificar las opciones!';
		}
		
		$this->load->model('catalog/evento');
		
		foreach ($this->request->post['selected'] as $opcion_id) {
			$evento_total = $this->model_catalog_evento->getTotalEventosByOpcionId($opcion_id);

			if ($evento_total) {
				$this->error['warning'] = sprintf('Advertencia: Esta opci&oacute;n no puede ser eliminada porque se encuentra asignada a %s eventos!', $evento_total);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->post['filter_name'])) {
			
			$this->load->model('catalog/opcion');
			
			$data = array(
				'filter_name' => $this->request->post['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$options = $this->model_catalog_opcion->getOpciones($data);
			
			foreach ($options as $option) {
				$option_value_data = array();
				
				if ($option['opcion_tipo'] == 'select' || $option['opcion_tipo'] == 'radio' || $option['opcion_tipo'] == 'checkbox') {
					$option_values = $this->model_catalog_opcion->getOpcionValores($option['opcion_id']);
					
					foreach ($option_values as $option_value) {
						$option_value_data[] = array(
							'opcion_valor_id' => $option_value['opcion_valor_id'],
							'opcion_valor_decripcion_nombre'	=> html_entity_decode($option_value['opcion_valor_decripcion_nombre'], ENT_QUOTES, 'UTF-8')					
						);
					}
					
					$sort_order = array();
				  
					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['opcion_valor_decripcion_nombre'];
					}
			
					array_multisort($sort_order, SORT_ASC, $option_value_data);					
				}
				
				$type = '';
				
				if ($option['opcion_tipo'] == 'select' || $option['opcion_tipo'] == 'radio' || $option['opcion_tipo'] == 'checkbox') {
					$type = 'Selecci&oacute;n';
				}
				
				if ($option['opcion_tipo'] == 'text' || $option['opcion_tipo'] == 'textarea') {
					$type = 'Texto';
				}
				
				if ($option['opcion_tipo'] == 'file') {
					$type = 'Archivo';
				}
				
				if ($option['opcion_tipo'] == 'date' || $option['opcion_tipo'] == 'datetime' || $option['opcion_tipo'] == 'time') {
					$type = 'Fecha';
				}
												
				$json[] = array(
					'opcion_id'    	=> $option['opcion_id'],
					'opcion_nombre'	=> html_entity_decode($option['opcion_nombre'], ENT_QUOTES, 'UTF-8'),
					'category'     	=> $type,
					'opcion_tipo'   => $option['opcion_tipo'],
					'option_value' 	=> $option_value_data
				);
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['opcion_nombre'];
		}

		array_multisort($sort_order, SORT_ASC, $json);
				
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
}
?>
<?php    
class ControllerCatalogPatrocinante extends Controller { 
	private $error = array();
  
  	public function index() {
		
		
		$this->document->setTitle('Patrocinantes');
		 
		$this->load->model('catalog/patrocinante');
		
    	$this->getList();
  	}
  
  	public function insert() {
		

    	$this->document->setTitle('Patrocinantes');
		
		$this->load->model('catalog/patrocinante');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_patrocinante->addPatrocinante($this->request->post);

			$this->session->data['success'] = 'Ha modificado los patrocinantes';
			
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
			
			$this->redirect($this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		

    	$this->document->setTitle('Patrocinantes');
		
		$this->load->model('catalog/patrocinante');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_patrocinante->editPatrocinante($this->request->get['patrocinantes_id'], $this->request->post);

			$this->session->data['success'] = 'Ha modificado los patrocinantes';

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
			
			$this->redirect($this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		

    	$this->document->setTitle('Patrocinantes');
		
		$this->load->model('catalog/patrocinante');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $patrocinantes_id) {
				$this->model_catalog_patrocinante->deletePatrocinante($patrocinantes_id);
			}

			$this->session->data['success'] = 'Ha modificado los patrocinantes';
			
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
			
			$this->redirect($this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'patrocinantes_titulo';
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
       		'text'      => 'Patrocinantes',
			'href'      => $this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/patrocinante/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/patrocinante/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['patrocinantes'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$patrocinante_total = $this->model_catalog_patrocinante->getTotalPatrocinantes();
	
		$results = $this->model_catalog_patrocinante->getPatrocinantes($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('catalog/patrocinante/update', 'token=' . $this->session->data['token'] . '&patrocinantes_id=' . $result['patrocinantes_id'] . $url, 'SSL')
			);

			if ($result['patrocinantes_imagen'] && file_exists(DIR_IMAGE . $result['patrocinantes_imagen'])) {
				$image = $this->model_tool_image->resize($result['patrocinantes_imagen'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
						
			$this->data['patrocinantes'][] = array(
				'patrocinantes_id' 		=> $result['patrocinantes_id'],
				'patrocinantes_titulo'  => $result['patrocinantes_titulo'],
				'patrocinantes_imagen'  => $image,
				'patrocinantes_url'		=> $result['patrocinantes_url'],
				'selected'        		=> isset($this->request->post['selected']) && in_array($result['patrocinantes_id'], $this->request->post['selected']),
				'action'          		=> $action
			);
		}	
	
		$this->data['heading_title'] = 'Patrocinantes';
		
		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_patrocinantes_titulo'] = 'Nombre del Patrocinante';
		$this->data['column_patrocinantes_imagen'] = 'Im&aacute;gen del Patrocinante';
		$this->data['column_patrocinantes_url'] = 'URL del Patrocinante';
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
		
		$this->data['sort_patrocinantes_titulo'] = $this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . '&sort=patrocinantes_titulo' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $patrocinante_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/patrocinante_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
  
  	private function getForm() {
    	$this->data['heading_title'] = 'Patrocinantes';

    	$this->data['text_enabled'] = 'Habilitado';
    	$this->data['text_disabled'] = 'Deshabilitado';
		$this->data['text_default'] = ' <b>(Predeterminado)</b>';
    	$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';
		$this->data['text_percent'] = 'Porcentaje';
		$this->data['text_amount'] = 'Cantidad Acomodada';
				
		$this->data['entry_patrocinantes_titulo'] = 'Nombre del Patrocinante:';
		$this->data['entry_patrocinantes_url'] = 'URL del Patrocinante:';
    	$this->data['entry_patrocinantes_imagen'] = 'Im&aacute;gen:';
		  
    	$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';
		
		$this->data['tab_general'] = 'General';
			  
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['patrocinantes_titulo'])) {
			$this->data['error_patrocinantes_titulo'] = $this->error['patrocinantes_titulo'];
		} else {
			$this->data['error_patrocinantes_titulo'] = '';
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
       		'text'      => 'Patrocinantes',
			'href'      => $this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['patrocinantes_id'])) {
			$this->data['action'] = $this->url->link('catalog/patrocinante/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/patrocinante/update', 'token=' . $this->session->data['token'] . '&patrocinantes_id=' . $this->request->get['patrocinantes_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
    	if (isset($this->request->get['patrocinantes_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$patrocinante_info = $this->model_catalog_patrocinante->getPatrocinante($this->request->get['patrocinantes_id']);
    	}

    	if (isset($this->request->post['patrocinantes_titulo'])) {
      		$this->data['patrocinantes_titulo'] = $this->request->post['patrocinantes_titulo'];
    	} elseif (isset($patrocinante_info)) {
			$this->data['patrocinantes_titulo'] = $patrocinante_info['patrocinantes_titulo'];
		} else {	
      		$this->data['patrocinantes_titulo'] = '';
    	}
		
		if (isset($this->request->post['patrocinantes_imagen'])) {
			$this->data['patrocinantes_imagen'] = $this->request->post['patrocinantes_imagen'];
		} elseif (isset($patrocinante_info)) {
			$this->data['patrocinantes_imagen'] = $patrocinante_info['patrocinantes_imagen'];
		} else {
			$this->data['patrocinantes_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($patrocinante_info) && $patrocinante_info['patrocinantes_imagen'] && file_exists(DIR_IMAGE . $patrocinante_info['patrocinantes_imagen'])) {
			$this->data['preview_patrocinantes_imagen'] = $this->model_tool_image->resize($patrocinante_info['patrocinantes_imagen'], 100, 100);
		} else {
			$this->data['preview_patrocinantes_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['patrocinantes_url'])) {
			$this->data['patrocinantes_url'] = $this->request->post['patrocinantes_url'];
		} elseif (isset($patrocinante_info)) {
			$this->data['patrocinantes_url'] = $patrocinante_info['patrocinantes_url'];
		} else {
			$this->data['patrocinantes_url'] = '';
		}

		$this->template = 'catalog/patrocinante_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/patrocinante')) {
      		$this->error['warning'] = 'Advertencia: Usted no tiene permisos para modificar los patrocinantes';
    	}

    	if ((strlen(utf8_decode($this->request->post['patrocinantes_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['patrocinantes_titulo'])) > 64)) {
      		$this->error['patrocinantes_titulo'] = 'El nombre del patrocinante debe contener entre 3 y 64 caract&eacute;res';
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/patrocinante')) {
			$this->error['warning'] = 'Advertencia: Usted no tiene permisos para modificar los patrocinantes';
    	}	
		
		$this->load->model('catalog/evento');

		foreach ($this->request->post['selected'] as $patrocinantes_id) {
  			$evento_total = $this->model_catalog_evento->getTotalEventosByPatrocinanteId($patrocinantes_id);
    
			if ($evento_total) {
	  			$this->error['warning'] = sprintf('Advertencia: Este patrocinante no puede ser eliminado porque se encuentra asignado a %s eventos', $evento_total);	
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
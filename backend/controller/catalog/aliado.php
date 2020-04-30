<?php    
class ControllerCatalogAliado extends Controller { 
	private $error = array();
  
  	public function index() {
		
		
		$this->document->setTitle('Aliados');
		 
		$this->load->model('catalog/aliado');
		
    	$this->getList();
  	}
  
  	public function insert() {
		

    	$this->document->setTitle('Aliados');
		
		$this->load->model('catalog/aliado');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_aliado->addAliado($this->request->post);

			$this->session->data['success'] = 'Ha modificado los aliados';
			
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
			
			$this->redirect($this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		

    	$this->document->setTitle('Aliados');
		
		$this->load->model('catalog/aliado');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_aliado->editAliado($this->request->get['aliados_id'], $this->request->post);

			$this->session->data['success'] = 'Ha modificado los aliados';

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
			
			$this->redirect($this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		

    	$this->document->setTitle('Aliados');
		
		$this->load->model('catalog/aliado');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $aliados_id) {
				$this->model_catalog_aliado->deleteAliado($aliados_id);
			}

			$this->session->data['success'] = 'Ha modificado los aliados';
			
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
			
			$this->redirect($this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'aliados_titulo';
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
       		'text'      => 'Aliados',
			'href'      => $this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/aliado/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/aliado/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['aliados'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$aliado_total = $this->model_catalog_aliado->getTotalAliados();
	
		$results = $this->model_catalog_aliado->getAliados($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('catalog/aliado/update', 'token=' . $this->session->data['token'] . '&aliados_id=' . $result['aliados_id'] . $url, 'SSL')
			);

			if ($result['aliados_imagen'] && file_exists(DIR_IMAGE . $result['aliados_imagen'])) {
				$image = $this->model_tool_image->resize($result['aliados_imagen'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
						
			$this->data['aliados'][] = array(
				'aliados_id' 		=> $result['aliados_id'],
				'aliados_titulo'  => $result['aliados_titulo'],
				'aliados_imagen'  => $image,
				'aliados_url'		=> $result['aliados_url'],
				'selected'        		=> isset($this->request->post['selected']) && in_array($result['aliados_id'], $this->request->post['selected']),
				'action'          		=> $action
			);
		}	
	
		$this->data['heading_title'] = 'Aliados';
		
		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_aliados_titulo'] = 'Nombre del Aliado';
		$this->data['column_aliados_imagen'] = 'Im&aacute;gen del Aliado';
		$this->data['column_aliados_url'] = 'URL del Aliado';
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
		
		$this->data['sort_aliados_titulo'] = $this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . '&sort=aliados_titulo' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $aliado_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/aliado_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
  
  	private function getForm() {
    	$this->data['heading_title'] = 'Aliados';

    	$this->data['text_enabled'] = 'Habilitado';
    	$this->data['text_disabled'] = 'Deshabilitado';
		$this->data['text_default'] = ' <b>(Predeterminado)</b>';
    	$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';
		$this->data['text_percent'] = 'Porcentaje';
		$this->data['text_amount'] = 'Cantidad Acomodada';
				
		$this->data['entry_aliados_titulo'] = 'Nombre del Aliado:';
		$this->data['entry_aliados_url'] = 'URL del Aliado:';
    	$this->data['entry_aliados_imagen'] = 'Im&aacute;gen:';
		  
    	$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';
		
		$this->data['tab_general'] = 'General';
			  
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['aliados_titulo'])) {
			$this->data['error_aliados_titulo'] = $this->error['aliados_titulo'];
		} else {
			$this->data['error_aliados_titulo'] = '';
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
       		'text'      => 'Aliados',
			'href'      => $this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['aliados_id'])) {
			$this->data['action'] = $this->url->link('catalog/aliado/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/aliado/update', 'token=' . $this->session->data['token'] . '&aliados_id=' . $this->request->get['aliados_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/aliado', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
    	if (isset($this->request->get['aliados_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$aliado_info = $this->model_catalog_aliado->getAliado($this->request->get['aliados_id']);
    	}

    	if (isset($this->request->post['aliados_titulo'])) {
      		$this->data['aliados_titulo'] = $this->request->post['aliados_titulo'];
    	} elseif (isset($aliado_info)) {
			$this->data['aliados_titulo'] = $aliado_info['aliados_titulo'];
		} else {	
      		$this->data['aliados_titulo'] = '';
    	}
		
		if (isset($this->request->post['aliados_imagen'])) {
			$this->data['aliados_imagen'] = $this->request->post['aliados_imagen'];
		} elseif (isset($aliado_info)) {
			$this->data['aliados_imagen'] = $aliado_info['aliados_imagen'];
		} else {
			$this->data['aliados_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($aliado_info) && $aliado_info['aliados_imagen'] && file_exists(DIR_IMAGE . $aliado_info['aliados_imagen'])) {
			$this->data['preview_aliados_imagen'] = $this->model_tool_image->resize($aliado_info['aliados_imagen'], 100, 100);
		} else {
			$this->data['preview_aliados_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['aliados_url'])) {
			$this->data['aliados_url'] = $this->request->post['aliados_url'];
		} elseif (isset($aliado_info)) {
			$this->data['aliados_url'] = $aliado_info['aliados_url'];
		} else {
			$this->data['aliados_url'] = '';
		}

		$this->template = 'catalog/aliado_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/aliado')) {
      		$this->error['warning'] = 'Advertencia: Usted no tiene permisos para modificar los aliados';
    	}

    	if ((strlen(utf8_decode($this->request->post['aliados_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['aliados_titulo'])) > 64)) {
      		$this->error['aliados_titulo'] = 'El nombre del aliado debe contener entre 3 y 64 caract&eacute;res';
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/aliado')) {
			$this->error['warning'] = 'Advertencia: Usted no tiene permisos para modificar los aliados';
    	}	
		
		$this->load->model('catalog/evento');

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  
  	}
}
?>
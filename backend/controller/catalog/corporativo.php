<?php    
class ControllerCatalogCorporativo extends Controller { 
	private $error = array();
  
  	public function index() {
		
		
		$this->document->setTitle('Corporativos');
		 
		$this->load->model('catalog/corporativo');
		
    	$this->getList();
  	}
  
  	public function insert() {
		

    	$this->document->setTitle('Corporativos');
		
		$this->load->model('catalog/corporativo');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_corporativo->addCorporativo($this->request->post);

			$this->session->data['success'] = 'Ha modificado los corporativos';
			
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
			
			$this->redirect($this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	} 
   
  	public function update() {
		

    	$this->document->setTitle('Corporativos');
		
		$this->load->model('catalog/corporativo');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_corporativo->editCorporativo($this->request->get['corporativos_id'], $this->request->post);

			$this->session->data['success'] = 'Ha modificado los corporativos';

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
			
			$this->redirect($this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		

    	$this->document->setTitle('Corporativos');
		
		$this->load->model('catalog/corporativo');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $corporativos_id) {
				$this->model_catalog_corporativo->deleteCorporativo($corporativos_id);
			}

			$this->session->data['success'] = 'Ha modificado los corporativos';
			
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
			
			$this->redirect($this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'corporativos_titulo';
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
       		'text'      => 'Corporativos',
			'href'      => $this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/corporativo/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/corporativo/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['corporativos'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$corporativo_total = $this->model_catalog_corporativo->getTotalCorporativos();
	
		$results = $this->model_catalog_corporativo->getCorporativos($data);
 
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('catalog/corporativo/update', 'token=' . $this->session->data['token'] . '&corporativos_id=' . $result['corporativos_id'] . $url, 'SSL')
			);

			if ($result['corporativos_imagen'] && file_exists(DIR_IMAGE . $result['corporativos_imagen'])) {
				$image = $this->model_tool_image->resize($result['corporativos_imagen'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
						
			$this->data['corporativos'][] = array(
				'corporativos_id' 		=> $result['corporativos_id'],
				'corporativos_titulo'  => $result['corporativos_titulo'],
				'corporativos_imagen'  => $image,
				'corporativos_url'		=> $result['corporativos_url'],
				'selected'        		=> isset($this->request->post['selected']) && in_array($result['corporativos_id'], $this->request->post['selected']),
				'action'          		=> $action
			);
		}	
	
		$this->data['heading_title'] = 'Corporativos';
		
		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_corporativos_titulo'] = 'Nombre del Cliente Corporativo';
		$this->data['column_corporativos_imagen'] = 'Im&aacute;gen del Cliente Corporativo';
		$this->data['column_corporativos_url'] = 'URL del Cliente Corporativo';
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
		
		$this->data['sort_corporativos_titulo'] = $this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . '&sort=corporativos_titulo' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $corporativo_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/corporativo_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
  
  	private function getForm() {
    	$this->data['heading_title'] = 'Corporativos';

    	$this->data['text_enabled'] = 'Habilitado';
    	$this->data['text_disabled'] = 'Deshabilitado';
		$this->data['text_default'] = ' <b>(Predeterminado)</b>';
    	$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';
		$this->data['text_percent'] = 'Porcentaje';
		$this->data['text_amount'] = 'Cantidad Acomodada';
				
		$this->data['entry_corporativos_titulo'] = 'Nombre del Corporativo:';
		$this->data['entry_corporativos_url'] = 'URL del Corporativo:';
    	$this->data['entry_corporativos_imagen'] = 'Im&aacute;gen:';
		  
    	$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';
		
		$this->data['tab_general'] = 'General';
			  
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['corporativos_titulo'])) {
			$this->data['error_corporativos_titulo'] = $this->error['corporativos_titulo'];
		} else {
			$this->data['error_corporativos_titulo'] = '';
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
       		'text'      => 'Corporativos',
			'href'      => $this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['corporativos_id'])) {
			$this->data['action'] = $this->url->link('catalog/corporativo/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/corporativo/update', 'token=' . $this->session->data['token'] . '&corporativos_id=' . $this->request->get['corporativos_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
    	if (isset($this->request->get['corporativos_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$corporativo_info = $this->model_catalog_corporativo->getCorporativo($this->request->get['corporativos_id']);
    	}

    	if (isset($this->request->post['corporativos_titulo'])) {
      		$this->data['corporativos_titulo'] = $this->request->post['corporativos_titulo'];
    	} elseif (isset($corporativo_info)) {
			$this->data['corporativos_titulo'] = $corporativo_info['corporativos_titulo'];
		} else {	
      		$this->data['corporativos_titulo'] = '';
    	}
		
		if (isset($this->request->post['corporativos_imagen'])) {
			$this->data['corporativos_imagen'] = $this->request->post['corporativos_imagen'];
		} elseif (isset($corporativo_info)) {
			$this->data['corporativos_imagen'] = $corporativo_info['corporativos_imagen'];
		} else {
			$this->data['corporativos_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($corporativo_info) && $corporativo_info['corporativos_imagen'] && file_exists(DIR_IMAGE . $corporativo_info['corporativos_imagen'])) {
			$this->data['preview_corporativos_imagen'] = $this->model_tool_image->resize($corporativo_info['corporativos_imagen'], 100, 100);
		} else {
			$this->data['preview_corporativos_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['corporativos_url'])) {
			$this->data['corporativos_url'] = $this->request->post['corporativos_url'];
		} elseif (isset($corporativo_info)) {
			$this->data['corporativos_url'] = $corporativo_info['corporativos_url'];
		} else {
			$this->data['corporativos_url'] = '';
		}

		$this->template = 'catalog/corporativo_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}  
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/corporativo')) {
      		$this->error['warning'] = 'Advertencia: Usted no tiene permisos para modificar los corporativos';
    	}

    	if ((strlen(utf8_decode($this->request->post['corporativos_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['corporativos_titulo'])) > 64)) {
      		$this->error['corporativos_titulo'] = 'El nombre del corporativo debe contener entre 3 y 64 caract&eacute;res';
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/corporativo')) {
			$this->error['warning'] = 'Advertencia: Usted no tiene permisos para modificar los corporativos';
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
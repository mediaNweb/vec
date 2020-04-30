<?php
class ControllerCatalogNoticia extends Controller { 
	private $error = array();

	public function index() {
		$this->load->idioma('catalog/noticia');

		$this->document->setTitle($this->idioma->get('heading_title'));
		 
		$this->load->model('catalog/noticia');

		$this->getList();
	}

	public function insert() {
		$this->load->idioma('catalog/noticia');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/noticia');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_noticia->addNoticia($this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('catalog/noticia');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/noticia');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_noticia->editNoticia($this->request->get['noticia_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->idioma('catalog/noticia');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/noticia');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $noticia_id) {
				$this->model_catalog_noticia->deleteNoticia($noticia_id);
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
			
			$this->redirect($this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'n.noticia_titulo';
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
			'href'      => $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/noticia/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/noticia/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['noticias'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$noticia_total = $this->model_catalog_noticia->getTotalNoticias();
	
		$results = $this->model_catalog_noticia->getNoticias($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('catalog/noticia/update', 'token=' . $this->session->data['token'] . '&noticia_id=' . $result['noticia_id'] . $url, 'SSL')
			);

			if ($result['noticia_imagen'] && file_exists(DIR_IMAGE . $result['noticia_imagen'])) {
				$image = $this->model_tool_image->resize($result['noticia_imagen'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
						
			$this->data['noticias'][] = array(
				'noticia_id' 		=> $result['noticia_id'],
				'noticia_titulo'    => $result['noticia_titulo'],
				'noticia_imagen'	=> $image,
				'noticia_orden' 	=> $result['noticia_orden'],
				'selected'      	=> isset($this->request->post['selected']) && in_array($result['noticia_id'], $this->request->post['selected']),
				'action'        	=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = $this->idioma->get('text_no_results');

		$this->data['column_title'] = $this->idioma->get('column_title');
		$this->data['column_noticia_imagen'] = $this->idioma->get('column_noticia_imagen');
		$this->data['column_noticia_url'] = $this->idioma->get('column_noticia_url');
		$this->data['column_noticia_orden'] = $this->idioma->get('column_noticia_orden');
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
		
		$this->data['sort_title'] = $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . '&sort=n.noticia_titulo' . $url, 'SSL');
		$this->data['sort_noticia_orden'] = $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . '&sort=n.noticia_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $noticia_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->idioma->get('text_pagination');
		$pagination->url = $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/noticia_list.tpl';
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
		$this->data['entry_titular'] = $this->idioma->get('entry_titular');
		$this->data['entry_description'] = $this->idioma->get('entry_description');
		$this->data['entry_imagen'] = $this->idioma->get('entry_imagen');
		$this->data['entry_video'] = $this->idioma->get('entry_video');
		$this->data['entry_posicion'] = $this->idioma->get('entry_posicion');
		$this->data['entry_keyword'] = $this->idioma->get('entry_keyword');
		$this->data['entry_noticia_orden'] = $this->idioma->get('entry_noticia_orden');
		$this->data['entry_noticia_fdp'] = $this->idioma->get('entry_noticia_fdp');
		$this->data['entry_status'] = $this->idioma->get('entry_status');
		$this->data['entry_layout'] = $this->idioma->get('entry_layout');
		
		$this->data['button_save'] = $this->idioma->get('button_save');
		$this->data['button_cancel'] = $this->idioma->get('button_cancel');
    	
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['noticia_titulo'])) {
			$this->data['error_title'] = $this->error['noticia_titulo'];
		} else {
			$this->data['error_title'] = array();
		}

 		if (isset($this->error['noticia_titular'])) {
			$this->data['error_titular'] = $this->error['noticia_titular'];
		} else {
			$this->data['error_titular'] = array();
		}
		
	 	if (isset($this->error['noticia_texto'])) {
			$this->data['error_description'] = $this->error['noticia_texto'];
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
			'href'      => $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['noticia_id'])) {
			$this->data['action'] = $this->url->link('catalog/noticia/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/noticia/update', 'token=' . $this->session->data['token'] . '&noticia_id=' . $this->request->get['noticia_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'] . $url, 'SSL');

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

		if (isset($this->request->get['noticia_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$noticia_info = $this->model_catalog_noticia->getNoticia($this->request->get['noticia_id']);
		}
		
    	if (isset($this->request->post['noticia_titulo'])) {
      		$this->data['noticia_titulo'] = $this->request->post['noticia_titulo'];
    	} elseif (isset($noticia_info)) {
			$this->data['noticia_titulo'] = $noticia_info['noticia_titulo'];
		} else {	
      		$this->data['noticia_titulo'] = '';
    	}

    	if (isset($this->request->post['noticia_titular'])) {
      		$this->data['noticia_titular'] = $this->request->post['noticia_titular'];
    	} elseif (isset($noticia_info)) {
			$this->data['noticia_titular'] = $noticia_info['noticia_titular'];
		} else {	
      		$this->data['noticia_titular'] = '';
    	}
		
		if (isset($this->request->post['noticia_texto'])) {
			$this->data['noticia_texto'] = $this->request->post['noticia_texto'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_texto'] = $noticia_info['noticia_texto'];
		} else {
			$this->data['noticia_texto'] = '';
		}

		if (isset($this->request->post['noticia_fdp'])) {
			$this->data['noticia_fdp'] = $this->request->post['noticia_fdp'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_fdp'] = $noticia_info['noticia_fdp'];
		} else {
			$this->data['noticia_fdp'] = '';
		}

		if (isset($this->request->post['noticia_imagen'])) {
			$this->data['noticia_imagen'] = $this->request->post['noticia_imagen'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_imagen'] = $noticia_info['noticia_imagen'];
		} else {
			$this->data['noticia_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($noticia_info) && $noticia_info['noticia_imagen'] && file_exists(DIR_IMAGE . $noticia_info['noticia_imagen'])) {
			$this->data['preview_noticia_imagen'] = $this->model_tool_image->resize($noticia_info['noticia_imagen'], 100, 100);
		} else {
			$this->data['preview_noticia_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['noticia_video'])) {
			$this->data['noticia_video'] = $this->request->post['noticia_video'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_video'] = $noticia_info['noticia_video'];
		} else {
			$this->data['noticia_video'] = '';
		}

		if (isset($this->request->post['noticia_posicion'])) {
			$this->data['noticia_posicion'] = $this->request->post['noticia_posicion'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_posicion'] = $noticia_info['noticia_posicion'];
		} else {
			$this->data['noticia_posicion'] = 'L';
		}

		if (isset($this->request->post['noticia_orden'])) {
			$this->data['noticia_orden'] = $this->request->post['noticia_orden'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_orden'] = $noticia_info['noticia_orden'];
		} else {
			$this->data['noticia_orden'] = '';
		}

		if (isset($this->request->post['noticia_status'])) {
			$this->data['noticia_status'] = $this->request->post['noticia_status'];
		} elseif (isset($noticia_info)) {
			$this->data['noticia_status'] = $noticia_info['noticia_status'];
		} else {
			$this->data['noticia_status'] = 1;
		}
		
		$this->template = 'catalog/noticia_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/noticia')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['noticia_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['noticia_titulo'])) > 64)) {
			$this->error['noticia_titulo'] = $this->idioma->get('error_title');
		}

		if ((strlen(utf8_decode($this->request->post['noticia_titular'])) < 3) || (strlen(utf8_decode($this->request->post['noticia_titular'])) > 140)) {
			$this->error['noticia_titular'] = $this->idioma->get('error_titular');
		}
	
		if (strlen(utf8_decode($this->request->post['noticia_texto'])) < 3) {
			$this->error['noticia_texto'] = $this->idioma->get('error_description');
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
		if (!$this->user->hasPermission('modify', 'catalog/noticia')) {
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
<?php
class ControllerCatalogGaleria extends Controller { 
	private $error = array();

	public function index() {
		$this->load->idioma('catalog/galeria');

		$this->document->setTitle($this->idioma->get('heading_title'));
		 
		$this->load->model('catalog/galeria');

		$this->getList();
	}

	public function insert() {
		$this->load->idioma('catalog/galeria');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/galeria');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_galeria->addGaleria($this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('catalog/galeria');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/galeria');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_galeria->editGaleria($this->request->get['eventos_galeria_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->idioma('catalog/galeria');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/galeria');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $eventos_galeria_id) {
				$this->model_catalog_galeria->deleteGaleria($eventos_galeria_id);
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
			
			$this->redirect($this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ec.eventos_galeria_titulo';
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
			'href'      => $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/galeria/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/galeria/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['galerias'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$this->load->model('tool/image');

		$galeria_total = $this->model_catalog_galeria->getTotalGalerias();
	
		$results = $this->model_catalog_galeria->getGalerias($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('catalog/galeria/update', 'token=' . $this->session->data['token'] . '&eventos_galeria_id=' . $result['eventos_galeria_id'] . $url, 'SSL')
			);

			if ($result['eventos_galeria_imagen'] && file_exists(DIR_IMAGE . $result['eventos_galeria_imagen'])) {
				$image = $this->model_tool_image->resize($result['eventos_galeria_imagen'], 100, 75);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 100, 75);
			}

			$this->data['galerias'][] = array(
				'eventos_galeria_id'		=> $result['eventos_galeria_id'],
				'eventos_galeria_titulo'	=> $result['eventos_galeria_titulo'],
				'eventos_galeria_imagen'	=> $image,
				'selected'      			=> isset($this->request->post['selected']) && in_array($result['eventos_galeria_id'], $this->request->post['selected']),
				'action'        			=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = $this->idioma->get('text_no_results');

		$this->data['column_title'] = $this->idioma->get('column_title');
		$this->data['column_galeria_imagen'] = $this->idioma->get('column_galeria_imagen');
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
		
		$this->data['sort_title'] = $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . '&sort=ec.eventos_galeria_titulo' . $url, 'SSL');
		$this->data['sort_galeria_fecha'] = $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . '&sort=ec.galeria_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $galeria_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->idioma->get('text_pagination');
		$pagination->url = $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/galeria_list.tpl';
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
		$this->data['entry_eventos_galeria_imagen'] = $this->idioma->get('entry_eventos_galeria_imagen');
		
		$this->data['button_save'] = $this->idioma->get('button_save');
		$this->data['button_cancel'] = $this->idioma->get('button_cancel');
    	
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['eventos_galeria_titulo'])) {
			$this->data['error_title'] = $this->error['eventos_galeria_titulo'];
		} else {
			$this->data['error_title'] = array();
		}

 		if (isset($this->error['eventos_galeria_fecha'])) {
			$this->data['error_titular'] = $this->error['eventos_galeria_fecha'];
		} else {
			$this->data['error_titular'] = array();
		}
		
	 	if (isset($this->error['galeria_texto'])) {
			$this->data['error_description'] = $this->error['galeria_texto'];
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
			'href'      => $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['eventos_galeria_id'])) {
			$this->data['action'] = $this->url->link('catalog/galeria/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$ultimo_galeria_id = $this->model_catalog_galeria->getLastGaleriaId();
			$eventos_galeria_id = (int)$ultimo_galeria_id + 1;
			$uploadDir = '../imagenes/galerias/' . $eventos_galeria_id . '/';

			if (file_exists($uploadDir)) {
				$this->data['galeria_url'] = $uploadDir;
			} else {
				mkdir($uploadDir, 0777);
				mkdir($uploadDir . 'files/', 0777);
				mkdir($uploadDir . 'thumbnails/', 0777);
				copy(DIR_IMAGE . 'galerias/index.php', $uploadDir . 'index.php');
				copy(DIR_IMAGE . 'galerias/upload.class.php', $uploadDir . 'upload.class.php');
				$this->data['galeria_url'] = $uploadDir;
			}

		} else {
			$this->data['action'] = $this->url->link('catalog/galeria/update', 'token=' . $this->session->data['token'] . '&eventos_galeria_id=' . $this->request->get['eventos_galeria_id'] . $url, 'SSL');
			$uploadDir = '../imagenes/galerias/' . $this->request->get['eventos_galeria_id'] . '/';

			if (file_exists($uploadDir)) {
				$this->data['galeria_url'] = $uploadDir;
			} else {
				mkdir($uploadDir, 0777);
				mkdir($uploadDir . 'files/', 0777);
				mkdir($uploadDir . 'thumbnails/', 0777);
				copy(DIR_IMAGE . 'galerias/index.php', $uploadDir . 'index.php');
				copy(DIR_IMAGE . 'galerias/upload.class.php', $uploadDir . 'upload.class.php');
				$this->data['galera_url'] = $uploadDir;
			}

		}

		$this->data['cancel'] = $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['eventos_galeria_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$galeria_info = $this->model_catalog_galeria->getGaleria($this->request->get['eventos_galeria_id']);
		}
		
    	if (isset($this->request->post['eventos_galeria_titulo'])) {
      		$this->data['eventos_galeria_titulo'] = $this->request->post['eventos_galeria_titulo'];
    	} elseif (isset($galeria_info)) {
			$this->data['eventos_galeria_titulo'] = $galeria_info['eventos_galeria_titulo'];
		} else {	
      		$this->data['eventos_galeria_titulo'] = '';
    	}

		if (isset($this->request->post['eventos_galeria_imagen'])) {
			$this->data['eventos_galeria_imagen'] = $this->request->post['eventos_galeria_imagen'];
		} elseif (isset($galeria_info)) {
			$this->data['eventos_galeria_imagen'] = $galeria_info['eventos_galeria_imagen'];
		} else {
			$this->data['eventos_galeria_imagen'] = '';
		}

		$this->load->model('tool/image');
		
		if (isset($galeria_info) && $galeria_info['eventos_galeria_imagen'] && file_exists(DIR_IMAGE . $galeria_info['eventos_galeria_imagen'])) {
			$this->data['preview_eventos_galeria_imagen'] = $this->model_tool_image->resize($galeria_info['eventos_galeria_imagen'], 100, 100);
		} else {
			$this->data['preview_eventos_galeria_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}


		$this->template = 'catalog/galeria_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/galeria')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['eventos_galeria_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['eventos_galeria_titulo'])) > 64)) {
			$this->error['eventos_galeria_titulo'] = $this->idioma->get('error_title');
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
		if (!$this->user->hasPermission('modify', 'catalog/galeria')) {
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
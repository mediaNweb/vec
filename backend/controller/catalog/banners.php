<?php
class ControllerCatalogBanners extends Controller { 
	private $error = array();

	public function index() {
		$this->load->idioma('catalog/banners');

		$this->document->setTitle($this->idioma->get('heading_title'));
		 
		$this->load->model('catalog/banners');

		$this->getList();
	}

	public function insert() {
		$this->load->idioma('catalog/banners');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/banners');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_banners->addBanners($this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('catalog/banners');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/banners');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_banners->editBanners($this->request->get['banner_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->idioma('catalog/banners');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/banners');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $banner_id) {
				$this->model_catalog_banners->deleteBanners($banner_id);
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
			
			$this->redirect($this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'n.banner_titulo';
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
			'href'      => $this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/banners/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/banners/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['banners'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$banners_total = $this->model_catalog_banners->getTotalBanners();
	
		$results = $this->model_catalog_banners->getBanners($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('catalog/banners/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, 'SSL')
			);

			if ($result['banner_imagen'] && file_exists(DIR_IMAGE . $result['banner_imagen'])) {
				$image = $this->model_tool_image->resize($result['banner_imagen'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
						
			$this->data['banners'][] = array(
				'banner_id' 		=> $result['banner_id'],
				'banner_titulo'    => $result['banner_titulo'],
				'banner_imagen'	=> $image,
				'banner_url'		=> $result['banner_url'],
				'banner_orden' 	=> $result['banner_orden'],
				'selected'      	=> isset($this->request->post['selected']) && in_array($result['banner_id'], $this->request->post['selected']),
				'action'        	=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = $this->idioma->get('text_no_results');

		$this->data['column_title'] = $this->idioma->get('column_title');
		$this->data['column_banners_imagen'] = $this->idioma->get('column_banners_imagen');
		$this->data['column_banners_url'] = $this->idioma->get('column_banners_url');
		$this->data['column_banners_orden'] = $this->idioma->get('column_banners_orden');
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
		
		$this->data['sort_title'] = $this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . '&sort=n.banner_titulo' . $url, 'SSL');
		$this->data['sort_banner_orden'] = $this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . '&sort=n.banner_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $banners_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->idioma->get('text_pagination');
		$pagination->url = $this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/banners_list.tpl';
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
		$this->data['entry_posicion'] = $this->idioma->get('entry_posicion');
		$this->data['entry_keyword'] = $this->idioma->get('entry_keyword');
		$this->data['entry_banner_orden'] = $this->idioma->get('entry_banner_orden');
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

 		if (isset($this->error['banner_titulo'])) {
			$this->data['error_title'] = $this->error['banner_titulo'];
		} else {
			$this->data['error_title'] = array();
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
			'href'      => $this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['banner_id'])) {
			$this->data['action'] = $this->url->link('catalog/banners/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/banners/update', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/banners', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$banners_info = $this->model_catalog_banners->getBanner($this->request->get['banner_id']);
		}
		
    	if (isset($this->request->post['banner_titulo'])) {
      		$this->data['banner_titulo'] = $this->request->post['banner_titulo'];
    	} elseif (isset($banners_info)) {
			$this->data['banner_titulo'] = $banners_info['banner_titulo'];
		} else {	
      		$this->data['banner_titulo'] = '';
    	}

		if (isset($this->request->post['banner_texto'])) {
			$this->data['banner_texto'] = $this->request->post['banner_texto'];
		} elseif (isset($banners_info)) {
			$this->data['banner_texto'] = $banners_info['banner_texto'];
		} else {
			$this->data['banner_texto'] = '';
		}

		if (isset($this->request->post['banner_imagen'])) {
			$this->data['banner_imagen'] = $this->request->post['banner_imagen'];
		} elseif (isset($banners_info)) {
			$this->data['banner_imagen'] = $banners_info['banner_imagen'];
		} else {
			$this->data['banner_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($banners_info) && $banners_info['banner_imagen'] && file_exists(DIR_IMAGE . $banners_info['banner_imagen'])) {
			$this->data['preview_banner_imagen'] = $this->model_tool_image->resize($banners_info['banner_imagen'], 700, 231);
		} else {
			$this->data['preview_banner_imagen'] = $this->model_tool_image->resize('no_image.jpg', 700, 231);
		}

		if (isset($this->request->post['banner_url'])) {
			$this->data['banner_url'] = $this->request->post['banner_url'];
		} elseif (isset($banners_info)) {
			$this->data['banner_url'] = $banners_info['banner_url'];
		} else {
			$this->data['banner_url'] = '';
		}

		if (isset($this->request->post['banner_orden'])) {
			$this->data['banner_orden'] = $this->request->post['banner_orden'];
		} elseif (isset($banners_info)) {
			$this->data['banner_orden'] = $banners_info['banner_orden'];
		} else {
			$this->data['banner_orden'] = '';
		}

		if (isset($this->request->post['banner_status'])) {
			$this->data['banner_status'] = $this->request->post['banner_status'];
		} elseif (isset($banners_info)) {
			$this->data['banner_status'] = $banners_info['banner_status'];
		} else {
			$this->data['banner_status'] = 1;
		}
		
		$this->template = 'catalog/banners_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/banners')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['banner_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['banner_titulo'])) > 64)) {
			$this->error['banner_titulo'] = $this->idioma->get('error_title');
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
		if (!$this->user->hasPermission('modify', 'catalog/banners')) {
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
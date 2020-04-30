<?php
class ControllerCatalogPublicidad extends Controller { 
	private $error = array();

	public function index() {
		$this->load->idioma('catalog/publicidad');

		$this->document->setTitle($this->idioma->get('heading_title'));
		 
		$this->load->model('catalog/publicidad');

		$this->getList();
	}

	public function insert() {
		$this->load->idioma('catalog/publicidad');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/publicidad');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_publicidad->addPublicidad($this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->idioma('catalog/publicidad');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/publicidad');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_publicidad->editPublicidad($this->request->get['publicidad_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->idioma('catalog/publicidad');

		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('catalog/publicidad');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $publicidad_id) {
				$this->model_catalog_publicidad->deletePublicidad($publicidad_id);
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
			
			$this->redirect($this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.publicidad_titulo';
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
			'href'      => $this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/publicidad/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/publicidad/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['publicidad'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$publicidad_total = $this->model_catalog_publicidad->getTotalPublicidad();
	
		$results = $this->model_catalog_publicidad->getPublicidades($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('catalog/publicidad/update', 'token=' . $this->session->data['token'] . '&publicidad_id=' . $result['publicidad_id'] . $url, 'SSL')
			);

			if ($result['publicidad_imagen'] && file_exists(DIR_IMAGE . $result['publicidad_imagen'])) {

				$extension = substr(strrchr($result['publicidad_imagen'], '.'), 1);
				 
				if ($extension == 'pdf' || $extension == 'PDF') {
					
					$image = $this->model_tool_image->resize('icono_pdf.jpg', 40, 40);
					
				} else if ($extension == 'swf' || $extension == 'SWF') {
					
					$image = $this->model_tool_image->resize('icono_swf.jpg', 40, 40);
				
				} else { 
				
					$image = $this->model_tool_image->resize($result['publicidad_imagen'], 40, 40);
										
				}

			} else {

				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);

			}
						
			$this->data['publicidad'][] = array(
				'publicidad_id' 		=> $result['publicidad_id'],
				'publicidad_titulo'    => $result['publicidad_titulo'],
				'publicidad_imagen'	=> $image,
				'publicidad_url'		=> $result['publicidad_url'],
				'publicidad_orden' 	=> $result['publicidad_orden'],
				'selected'      	=> isset($this->request->post['selected']) && in_array($result['publicidad_id'], $this->request->post['selected']),
				'action'        	=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = $this->idioma->get('text_no_results');

		$this->data['column_title'] = $this->idioma->get('column_title');
		$this->data['column_publicidad_imagen'] = $this->idioma->get('column_publicidad_imagen');
		$this->data['column_publicidad_url'] = $this->idioma->get('column_publicidad_url');
		$this->data['column_publicidad_orden'] = $this->idioma->get('column_publicidad_orden');
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
		
		$this->data['sort_title'] = $this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . '&sort=p.publicidad_titulo' . $url, 'SSL');
		$this->data['sort_publicidad_orden'] = $this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . '&sort=p.publicidad_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $publicidad_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->idioma->get('text_pagination');
		$pagination->url = $this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/publicidad_list.tpl';
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
		$this->data['entry_publicidad_orden'] = $this->idioma->get('entry_publicidad_orden');
		$this->data['entry_publicidad_fdi'] = $this->idioma->get('entry_publicidad_fdi');
		$this->data['entry_publicidad_fdf'] = $this->idioma->get('entry_publicidad_fdf');
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

 		if (isset($this->error['publicidad_titulo'])) {
			$this->data['error_title'] = $this->error['publicidad_titulo'];
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
			'href'      => $this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['publicidad_id'])) {
			$this->data['action'] = $this->url->link('catalog/publicidad/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/publicidad/update', 'token=' . $this->session->data['token'] . '&publicidad_id=' . $this->request->get['publicidad_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/publicidad', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['publicidad_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$publicidad_info = $this->model_catalog_publicidad->getPublicidad($this->request->get['publicidad_id']);
		}
		
    	if (isset($this->request->post['publicidad_titulo'])) {
      		$this->data['publicidad_titulo'] = $this->request->post['publicidad_titulo'];
    	} elseif (isset($publicidad_info)) {
			$this->data['publicidad_titulo'] = $publicidad_info['publicidad_titulo'];
		} else {	
      		$this->data['publicidad_titulo'] = '';
    	}

    	$this->data['layouts'] = $this->model_catalog_publicidad->getLayouts();

    	if (isset($this->request->post['publicidad_layout_id'])) {
      		$this->data['publicidad_layout_id'] = $this->request->post['publicidad_layout_id'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_layout_id'] = $publicidad_info['publicidad_layout_id'];
		} else {
      		$this->data['publicidad_layout_id'] = 0;
    	} 

		if (isset($this->request->post['publicidad_imagen'])) {
			$this->data['publicidad_imagen'] = $this->request->post['publicidad_imagen'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_imagen'] = $publicidad_info['publicidad_imagen'];
		} else {
			$this->data['publicidad_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($publicidad_info) && $publicidad_info['publicidad_imagen'] && file_exists(DIR_IMAGE . $publicidad_info['publicidad_imagen'])) {

			$extension = substr(strrchr($publicidad_info['publicidad_imagen'], '.'), 1);
			 
			if ($extension == 'pdf' || $extension == 'PDF') {
				
				$this->data['preview_publicidad_imagen'] = $this->model_tool_image->resize('icono_pdf.jpg', 100, 100);
				
			} else if ($extension == 'swf' || $extension == 'SWF') {
				
				$this->data['preview_publicidad_imagen'] = $this->model_tool_image->resize('icono_swf.jpg', 100, 100);
			
			} else { 
			
				$this->data['preview_publicidad_imagen'] = $this->model_tool_image->resize($publicidad_info['publicidad_imagen'], 100, 100);

			}

		} else {

			$this->data['preview_publicidad_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		}

		if (isset($this->request->post['publicidad_url'])) {
			$this->data['publicidad_url'] = $this->request->post['publicidad_url'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_url'] = $publicidad_info['publicidad_url'];
		} else {
			$this->data['publicidad_url'] = '';
		}

		if (isset($this->request->post['publicidad_fdi'])) {
			$this->data['publicidad_fdi'] = $this->request->post['publicidad_fdi'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_fdi'] = $publicidad_info['publicidad_fdi'];
		} else {
			$this->data['publicidad_fdi'] = '';
		}

		if (isset($this->request->post['publicidad_fdf'])) {
			$this->data['publicidad_fdf'] = $this->request->post['publicidad_fdf'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_fdf'] = $publicidad_info['publicidad_fdf'];
		} else {
			$this->data['publicidad_fdf'] = '';
		}

		if (isset($this->request->post['publicidad_orden'])) {
			$this->data['publicidad_orden'] = $this->request->post['publicidad_orden'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_orden'] = $publicidad_info['publicidad_orden'];
		} else {
			$this->data['publicidad_orden'] = '';
		}

		if (isset($this->request->post['publicidad_status'])) {
			$this->data['publicidad_status'] = $this->request->post['publicidad_status'];
		} elseif (isset($publicidad_info)) {
			$this->data['publicidad_status'] = $publicidad_info['publicidad_status'];
		} else {
			$this->data['publicidad_status'] = 1;
		}
		
		$this->template = 'catalog/publicidad_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/publicidad')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['publicidad_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['publicidad_titulo'])) > 64)) {
			$this->error['publicidad_titulo'] = $this->idioma->get('error_title');
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
		if (!$this->user->hasPermission('modify', 'catalog/publicidad')) {
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
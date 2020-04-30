<?php    
class ControllerSaleCliente extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->idioma('sale/cliente');
		 
		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/cliente');
		
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->idioma('sale/cliente');

    	$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/cliente');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      	  	$this->model_sale_cliente->addCliente($this->request->post);
			
			$this->session->data['success'] = $this->idioma->get('text_success');
		  
			$url = '';

			if (isset($this->request->get['filter_id'])) {
				$url .= '&filter_id=' . $this->request->get['filter_id'];
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
/*
			if (isset($this->request->get['filter_cliente_group_id'])) {
				$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
			}
*/
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
/*
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
*/

			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
					
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
							
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    	
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->idioma('sale/cliente');

    	$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/cliente');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_cliente->editCliente($this->request->get['clientes_id'], $this->request->post);
	  		
			$this->session->data['success'] = $this->idioma->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['filter_id'])) {
				$url .= '&filter_id=' . $this->request->get['filter_id'];
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
/*
			if (isset($this->request->get['filter_cliente_group_id'])) {
				$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
			}
*/
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
/*
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
*/
			
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
					
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->idioma('sale/cliente');

    	$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/cliente');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $clientes_id) {
				$this->model_sale_cliente->deleteCliente($clientes_id);
			}
			
			$this->session->data['success'] = $this->idioma->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_id'])) {
				$url .= '&filter_id=' . $this->request->get['filter_id'];
			}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
/*
			if (isset($this->request->get['filter_cliente_group_id'])) {
				$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
			}
*/
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
/*
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}	
*/
				
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
					
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    
    	$this->getList();
  	}  
	
	public function approve() {
		$this->load->idioma('sale/cliente');
    	
		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/cliente');
		
		if (!$this->user->hasPermission('modify', 'sale/cliente')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		} elseif (isset($this->request->post['selected'])) {
			$approved = 0;
			
			foreach ($this->request->post['selected'] as $clientes_id) {
				$cliente_info = $this->model_sale_cliente->getCliente($clientes_id);
				
				if ($cliente_info && !$cliente_info['approved']) {
					$this->model_sale_cliente->approve($clientes_id);
					
					$approved++;
				}
			} 
			
			$this->session->data['success'] = sprintf($this->idioma->get('text_approved'), $approved);	
			
			$url = '';
		
			if (isset($this->request->get['filter_id'])) {
				$url .= '&filter_id=' . $this->request->get['filter_id'];
			}
		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
		
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
/*
			if (isset($this->request->get['filter_cliente_group_id'])) {
				$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
			}
*/
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
/*
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
*/
				
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
						
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
							
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
	
			$this->redirect($this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL'));			
		}
		
		$this->getList();
	} 
    
  	private function getList() {
		if (isset($this->request->get['filter_id'])) {
			$filter_id = $this->request->get['filter_id'];
		} else {
			$filter_id = null;
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		
/*
		if (isset($this->request->get['filter_cliente_group_id'])) {
			$filter_cliente_group_id = $this->request->get['filter_cliente_group_id'];
		} else {
			$filter_cliente_group_id = null;
		}
*/

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
/*
		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}
*/
		
		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
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

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
/*
		if (isset($this->request->get['filter_cliente_group_id'])) {
			$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
		}
*/
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
/*
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
*/
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
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
			'href'      => $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['approve'] = $this->url->link('sale/cliente/approve', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/cliente/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/cliente/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['clientes'] = array();

		$data = array(
			'filter_id'              	=> $filter_id, 
			'filter_name'              	=> $filter_name, 
			'filter_email'             	=> $filter_email, 
//			'filter_cliente_group_id'	=> $filter_cliente_group_id, 
			'filter_status'            	=> $filter_status, 
//			'filter_approved'          	=> $filter_approved, 
			'filter_date_added'        	=> $filter_date_added,
			'filter_ip'                	=> $filter_ip,
			'sort'                     	=> $sort,
			'order'                    	=> $order,
			'start'                    	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    	=> $this->config->get('config_admin_limit')
		);
		
		$cliente_total = $this->model_sale_cliente->getTotalClientes($data);
	
		$results = $this->model_sale_cliente->getClientes($data);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('sale/cliente/update', 'token=' . $this->session->data['token'] . '&clientes_id=' . $result['clientes_id'] . $url, 'SSL')
			);
			
			$this->data['clientes'][] = array(
				'clientes_id'    => $result['clientes_id'],
				'name'           => $result['name'],
				'clientes_email'          => $result['clientes_email'],
//				'cliente_group' => $result['cliente_group'],
				'clientes_status'         => ($result['clientes_status'] ? 'Habilitado' : 'Deshabilitado'),
//				'approved'       => ($result['approved'] ? 'Si' : 'No'),
				'ip'             => $result['clientes_ip'],
				'date_added'     => date('d/m/Y', strtotime($result['clientes_fdc'])),
				'login'          => $this->url->link('sale/cliente/login', 'token=' . $this->session->data['token'] . '&clientes_id=' . $result['clientes_id'], 'SSL'),
				'selected'       => isset($this->request->post['selected']) && in_array($result['clientes_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}	
					
		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_enabled'] = 'Habilitado';
		$this->data['text_disabled'] = 'Deshabilitado';
		$this->data['text_yes'] = 'Si';
		$this->data['text_no'] = 'No';		
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_login'] = $this->idioma->get('text_login');

		$this->data['column_id'] = $this->idioma->get('column_id');
		$this->data['column_name'] = $this->idioma->get('column_name');
		$this->data['column_clientes_email'] = $this->idioma->get('column_clientes_email');
		$this->data['column_cliente_group'] = $this->idioma->get('column_cliente_group');
		$this->data['column_clientes_status'] = $this->idioma->get('column_clientes_status');
		$this->data['column_approved'] = $this->idioma->get('column_approved');
		$this->data['column_ip'] = $this->idioma->get('column_ip');
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');
		$this->data['column_action'] = 'Acci&oacute;n';		
		
		$this->data['button_approve'] = $this->idioma->get('button_approve');
		$this->data['button_insert'] = 'Agregar';
		$this->data['button_delete'] = 'Eliminar';
		$this->data['button_filter'] = 'Filtrar';

		$this->data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
/*
		if (isset($this->request->get['filter_cliente_group_id'])) {
			$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
		}
*/			

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
/*
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
*/
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_id'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.clientes_id' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.clientes_nombre' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.clientes_email' . $url, 'SSL');
//		$this->data['sort_cliente_group'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=cliente_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.clientes_status' . $url, 'SSL');
//		$this->data['sort_approved'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.approved' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.clientes_ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . '&sort=c.clientes_fdc' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
/*
		if (isset($this->request->get['filter_cliente_group_id'])) {
			$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
		}
*/

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
/*
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}
*/
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $cliente_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_id'] = $filter_id;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
//		$this->data['filter_cliente_group_id'] = $filter_cliente_group_id;
		$this->data['filter_status'] = $filter_status;
//		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;
		
/*
		$this->load->model('sale/cliente_group');
		
    	$this->data['cliente_groups'] = $this->model_sale_cliente_group->getClienteGroups();
*/		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/cliente_list.tpl';
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
		$this->data['text_select'] = ' --- Seleccione --- ';
    	$this->data['text_wait'] = $this->idioma->get('text_wait');
		$this->data['text_no_results'] = 'Sin resultados';
		
		$this->data['column_ip'] = $this->idioma->get('column_ip');
		$this->data['column_total'] = $this->idioma->get('column_total');
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');
		
    	$this->data['entry_clientes_id'] = $this->idioma->get('entry_clientes_id');
    	$this->data['entry_clientes_nombre'] = $this->idioma->get('entry_clientes_nombre');
    	$this->data['entry_clientes_apellido'] = $this->idioma->get('entry_clientes_apellido');
    	$this->data['entry_clientes_genero'] = $this->idioma->get('entry_clientes_genero');
    	$this->data['entry_clientes_fdn'] = $this->idioma->get('entry_clientes_fdn');
    	$this->data['entry_clientes_email'] = $this->idioma->get('entry_clientes_email');
    	$this->data['entry_clientes_tel'] = $this->idioma->get('entry_clientes_tel');
    	$this->data['entry_clientes_cel'] = $this->idioma->get('entry_clientes_cel');
    	$this->data['entry_clientes_pin'] = $this->idioma->get('entry_clientes_pin');
    	$this->data['entry_clientes_twitter'] = $this->idioma->get('entry_clientes_twitter');
    	$this->data['entry_password'] = $this->idioma->get('entry_password');
    	$this->data['entry_confirm'] = $this->idioma->get('entry_confirm');
		$this->data['entry_clientes_id_sanguineo'] = $this->idioma->get('entry_clientes_id_sanguineo');
		$this->data['entry_clientes_talla'] = $this->idioma->get('entry_clientes_talla');
		$this->data['entry_clientes_boletin'] = $this->idioma->get('entry_clientes_boletin');
    	$this->data['entry_cliente_group'] = $this->idioma->get('entry_cliente_group');
    	$this->data['entry_clientes_direcciones_calle'] = $this->idioma->get('entry_clientes_direcciones_calle');
    	$this->data['entry_clientes_direcciones_urbanizacion'] = $this->idioma->get('entry_clientes_direcciones_urbanizacion');
		$this->data['entry_clientes_status'] = $this->idioma->get('entry_clientes_status');
		$this->data['entry_clientes_direcciones_casa'] = $this->idioma->get('entry_clientes_direcciones_casa');
		$this->data['entry_clientes_direcciones_municipio'] = $this->idioma->get('entry_clientes_direcciones_municipio');
		$this->data['entry_address_2'] = $this->idioma->get('entry_address_2');
		$this->data['entry_clientes_direcciones_ciudad'] = $this->idioma->get('entry_clientes_direcciones_ciudad');
		$this->data['entry_clientes_direcciones_postal'] = $this->idioma->get('entry_clientes_direcciones_postal');
		$this->data['entry_zone'] = $this->idioma->get('entry_zone');
		$this->data['entry_country'] = $this->idioma->get('entry_country');
		$this->data['entry_default'] = $this->idioma->get('entry_default');
		$this->data['entry_amount'] = $this->idioma->get('entry_amount');
		$this->data['entry_points'] = $this->idioma->get('entry_points');
 		$this->data['entry_description'] = $this->idioma->get('entry_description');
 
		$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';
    	$this->data['button_add_address'] = $this->idioma->get('button_add_address');
		$this->data['button_add_transaction'] = $this->idioma->get('button_add_transaction');
		$this->data['button_add_reward'] = $this->idioma->get('button_add_reward');
    	$this->data['button_remove'] = 'Eliminar';
	
		$this->data['tab_general'] = 'General';
		$this->data['tab_address'] = $this->idioma->get('tab_address');
		$this->data['tab_transaction'] = $this->idioma->get('tab_transaction');
		$this->data['tab_reward'] = 'Reward Points';
		$this->data['tab_ip'] = $this->idioma->get('tab_ip');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['clientes_id'])) {
			$this->data['clientes_id'] = $this->request->get['clientes_id'];
		} else {
			$this->data['clientes_id'] = 0;
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['clientes_id'])) {
			$this->data['error_clientes_id'] = $this->error['clientes_id'];
		} else {
			$this->data['error_clientes_id'] = '';
		}

 		if (isset($this->error['clientes_nombre'])) {
			$this->data['error_clientes_nombre'] = $this->error['clientes_nombre'];
		} else {
			$this->data['error_clientes_nombre'] = '';
		}

 		if (isset($this->error['clientes_apellido'])) {
			$this->data['error_clientes_apellido'] = $this->error['clientes_apellido'];
		} else {
			$this->data['error_clientes_apellido'] = '';
		}

 		if (isset($this->error['clientes_genero'])) {
			$this->data['error_clientes_genero'] = $this->error['clientes_genero'];
		} else {
			$this->data['error_clientes_genero'] = '';
		}

 		if (isset($this->error['clientes_fdn'])) {
			$this->data['error_clientes_fdn'] = $this->error['clientes_fdn'];
		} else {
			$this->data['error_clientes_fdn'] = '';
		}
		
 		if (isset($this->error['clientes_email'])) {
			$this->data['error_clientes_email'] = $this->error['clientes_email'];
		} else {
			$this->data['error_clientes_email'] = '';
		}
		
 		if (isset($this->error['clientes_tel'])) {
			$this->data['error_clientes_tel'] = $this->error['clientes_tel'];
		} else {
			$this->data['error_clientes_tel'] = '';
		}
		
 		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}
		
		if (isset($this->error['address_clientes_direcciones_calle'])) {
			$this->data['error_address_clientes_direcciones_calle'] = $this->error['address_clientes_direcciones_calle'];
		} else {
			$this->data['error_address_clientes_direcciones_calle'] = '';
		}

		if (isset($this->error['address_clientes_direcciones_municipio'])) {
			$this->data['error_address_clientes_direcciones_municipio'] = $this->error['address_clientes_direcciones_municipio'];
		} else {
			$this->data['error_address_clientes_direcciones_municipio'] = '';
		}
		
		if (isset($this->error['address_clientes_direcciones_ciudad'])) {
			$this->data['error_address_clientes_direcciones_ciudad'] = $this->error['address_clientes_direcciones_ciudad'];
		} else {
			$this->data['error_address_clientes_direcciones_ciudad'] = '';
		}
		
		if (isset($this->error['address_clientes_direcciones_postal'])) {
			$this->data['error_address_clientes_direcciones_postal'] = $this->error['address_clientes_direcciones_postal'];
		} else {
			$this->data['error_address_clientes_direcciones_postal'] = '';
		}
		
		if (isset($this->error['address_country'])) {
			$this->data['error_address_country'] = $this->error['address_country'];
		} else {
			$this->data['error_address_country'] = '';
		}
		
		if (isset($this->error['address_zone'])) {
			$this->data['error_address_zone'] = $this->error['address_zone'];
		} else {
			$this->data['error_address_zone'] = '';
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
/*
		if (isset($this->request->get['filter_cliente_group_id'])) {
			$url .= '&filter_cliente_group_id=' . $this->request->get['filter_cliente_group_id'];
		}
*/
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
/*
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
*/
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
			'href'      => $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['clientes_id'])) {
			$this->data['action'] = $this->url->link('sale/cliente/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/cliente/update', 'token=' . $this->session->data['token'] . '&clientes_id=' . $this->request->get['clientes_id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	if (isset($this->request->get['clientes_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$cliente_info = $this->model_sale_cliente->getCliente($this->request->get['clientes_id']);
    	}
			
    	if (isset($this->request->post['clientes_id'])) {
      		$this->data['clientes_id'] = $this->request->post['clientes_id'];
		} elseif (isset($cliente_info)) { 
			$this->data['clientes_id'] = $cliente_info['clientes_id'];
		} else {
      		$this->data['clientes_id'] = '';
    	}

    	if (isset($this->request->post['clientes_nombre'])) {
      		$this->data['clientes_nombre'] = $this->request->post['clientes_nombre'];
		} elseif (isset($cliente_info)) { 
			$this->data['clientes_nombre'] = $cliente_info['clientes_nombre'];
		} else {
      		$this->data['clientes_nombre'] = '';
    	}

    	if (isset($this->request->post['clientes_apellido'])) {
      		$this->data['clientes_apellido'] = $this->request->post['clientes_apellido'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_apellido'] = $cliente_info['clientes_apellido'];
		} else {
      		$this->data['clientes_apellido'] = '';
    	}

    	if (isset($this->request->post['clientes_genero'])) {
      		$this->data['clientes_genero'] = $this->request->post['clientes_genero'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_genero'] = $cliente_info['clientes_genero'];
		} else {
      		$this->data['clientes_genero'] = '';
    	}

    	if (isset($this->request->post['clientes_fdn'])) {
      		$this->data['clientes_fdn'] = $this->request->post['clientes_fdn'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_fdn'] = $cliente_info['clientes_fdn'];
		} else {
      		$this->data['clientes_fdn'] = '';
    	}

    	if (isset($this->request->post['clientes_email'])) {
      		$this->data['clientes_email'] = $this->request->post['clientes_email'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_email'] = $cliente_info['clientes_email'];
		} else {
      		$this->data['clientes_email'] = '';
    	}

    	if (isset($this->request->post['clientes_tel'])) {
      		$this->data['clientes_tel'] = $this->request->post['clientes_tel'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_tel'] = $cliente_info['clientes_tel'];
		} else {
      		$this->data['clientes_tel'] = '';
    	}

    	if (isset($this->request->post['clientes_cel'])) {
      		$this->data['clientes_cel'] = $this->request->post['clientes_cel'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_cel'] = $cliente_info['clientes_cel'];
		} else {
      		$this->data['clientes_cel'] = '';
    	}

    	if (isset($this->request->post['clientes_pin'])) {
      		$this->data['clientes_pin'] = $this->request->post['clientes_pin'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_pin'] = $cliente_info['clientes_pin'];
		} else {
      		$this->data['clientes_pin'] = '';
    	}

    	if (isset($this->request->post['clientes_twitter'])) {
      		$this->data['clientes_twitter'] = $this->request->post['clientes_twitter'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_twitter'] = $cliente_info['clientes_twitter'];
		} else {
      		$this->data['clientes_twitter'] = '';
    	}

    	if (isset($this->request->post['clientes_id_sanguineo'])) {
      		$this->data['clientes_id_sanguineo'] = $this->request->post['clientes_id_sanguineo'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_id_sanguineo'] = $cliente_info['clientes_id_sanguineo'];
		} else {
      		$this->data['clientes_id_sanguineo'] = '';
    	}
		
    	if (isset($this->request->post['clientes_talla'])) {
      		$this->data['clientes_talla'] = $this->request->post['clientes_talla'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_talla'] = $cliente_info['clientes_talla'];
		} else {
      		$this->data['clientes_talla'] = '';
    	}
		
    	if (isset($this->request->post['clientes_boletin'])) {
      		$this->data['clientes_boletin'] = $this->request->post['clientes_boletin'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_boletin'] = $cliente_info['clientes_boletin'];
		} else {
      		$this->data['clientes_boletin'] = '';
    	}
		
/*
		$this->load->model('sale/cliente_group');
			
		$this->data['cliente_groups'] = $this->model_sale_cliente_group->getClienteGroups();

    	if (isset($this->request->post['cliente_group_id'])) {
      		$this->data['cliente_group_id'] = $this->request->post['cliente_group_id'];
    	} elseif (isset($cliente_info)) { 
			$this->data['cliente_group_id'] = $cliente_info['cliente_group_id'];
		} else {
      		$this->data['cliente_group_id'] = $this->config->get('config_cliente_group_id');
    	}
*/		
    	if (isset($this->request->post['clientes_status'])) {
      		$this->data['clientes_status'] = $this->request->post['clientes_status'];
    	} elseif (isset($cliente_info)) { 
			$this->data['clientes_status'] = $cliente_info['clientes_status'];
		} else {
      		$this->data['clientes_status'] = 1;
    	}

    	if (isset($this->request->post['password'])) { 
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) { 
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}
		
		$this->load->model('localidad/pais');
		
		$this->data['paises'] = $this->model_localidad_pais->getPaises();

		$this->load->model('catalog/sanguineo');

		$this->data['grupos'] = $this->model_catalog_sanguineo->getGrupos();
			
		if (isset($this->request->post['address'])) { 
      		$this->data['addresses'] = $this->request->post['address'];
		} elseif (isset($this->request->get['clientes_id'])) {
			$this->data['addresses'] = $this->model_sale_cliente->getAddresses($this->request->get['clientes_id']);
		} else {
			$this->data['addresses'] = array();
    	}
		
		$this->data['ips'] = array();
    	
		if (isset($cliente_info)) {
			$results = $this->model_sale_cliente->getIpsByClienteId($this->request->get['clientes_id']);
		
			foreach ($results as $result) {
				$this->data['ips'][] = array(
					'ip'         => $result['ip'],
					'total'      => $this->model_sale_cliente->getTotalClientesByIp($result['ip']),
					'date_added' => date('d/m/y', strtotime($result['fdc'])),
					'filter_ip'  => HTTPS_SERVER . 'index.php?route=sale/cliente&token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip']
				);
			}
		}		
		
		$this->template = 'sale/cliente_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
			 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/cliente')) {
      		$this->error['warning'] = $this->idioma->get('error_permission');
    	}

    	if ((strlen(utf8_decode($this->request->post['clientes_id'])) < 1) || (strlen(utf8_decode($this->request->post['clientes_id'])) > 12)) {
      		$this->error['clientes_id'] = $this->idioma->get('error_clientes_id');
    	}

    	if ((strlen(utf8_decode($this->request->post['clientes_nombre'])) < 1) || (strlen(utf8_decode($this->request->post['clientes_nombre'])) > 32)) {
      		$this->error['clientes_nombre'] = $this->idioma->get('error_clientes_nombre');
    	}

    	if ((strlen(utf8_decode($this->request->post['clientes_apellido'])) < 1) || (strlen(utf8_decode($this->request->post['clientes_apellido'])) > 32)) {
      		$this->error['clientes_apellido'] = $this->idioma->get('error_clientes_apellido');
    	}

		if ((strlen(utf8_decode($this->request->post['clientes_email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['clientes_email'])) {
      		$this->error['clientes_email'] = $this->idioma->get('error_clientes_email');
    	}

    	if ((strlen(utf8_decode($this->request->post['clientes_tel'])) < 3) || (strlen(utf8_decode($this->request->post['clientes_tel'])) > 32)) {
      		$this->error['clientes_tel'] = $this->idioma->get('error_clientes_tel');
    	}

    	if (($this->request->post['password']) || (!isset($this->request->get['clientes_id']))) {
      		if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
        		$this->error['password'] = $this->idioma->get('error_password');
      		}
	
	  		if ($this->request->post['password'] != $this->request->post['confirm']) {
	    		$this->error['confirm'] = $this->idioma->get('error_confirm');
	  		}
    	}

		if (isset($this->request->post['address'])) {
			foreach ($this->request->post['address'] as $key => $value) {
				if ((strlen(utf8_decode($value['clientes_direcciones_municipio'])) < 3) || (strlen(utf8_decode($value['clientes_direcciones_municipio'])) > 128)) {
					$this->error['address_clientes_direcciones_municipio'][$key] = $this->idioma->get('error_clientes_direcciones_municipio');
				}
			
				if ((strlen(utf8_decode($value['clientes_direcciones_ciudad'])) < 2) || (strlen(utf8_decode($value['clientes_direcciones_ciudad'])) > 128)) {
					$this->error['address_clientes_direcciones_ciudad'][$key] = $this->idioma->get('error_clientes_direcciones_ciudad');
				} 
	
				$this->load->model('localidad/pais');
				
				$country_info = $this->model_localidad_pais->getPais($value['paises_id']);
						
				if ($country_info && $country_info['postcode_required'] && (strlen(utf8_decode($value['clientes_direcciones_postal'])) < 2) || (strlen(utf8_decode($value['clientes_direcciones_postal'])) > 10)) {
					$this->error['address_clientes_direcciones_postal'][$key] = $this->idioma->get('error_clientes_direcciones_postal');
				}
			
				if ($value['paises_id'] == '') {
					$this->error['address_country'][$key] = $this->idioma->get('error_country');
				}
				
				if ($value['estados_id'] == '') {
					$this->error['address_zone'][$key] = $this->idioma->get('error_zone');
				}	
			}
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
    	if (!$this->user->hasPermission('modify', 'sale/cliente')) {
      		$this->error['warning'] = $this->idioma->get('error_permission');
    	}	
	  	 
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  
  	} 
	
	public function login() {
		$json = array();
		
		if (isset($this->request->get['clientes_id'])) {
			$clientes_id = $this->request->get['clientes_id'];
		} else {
			$clientes_id = 0;
		}
		
		$this->load->model('sale/cliente');
				
		$cliente_info = $this->model_sale_cliente->getCliente($clientes_id);
				
		if ($cliente_info) {
			$this->session->data['clientes_id'] = $clientes_id;
				
			$this->redirect(HTTP_CATALOG);
//			$this->redirect('http://localhost/hipernew/index.php?route=sesion/editar');
		} else {
			$this->load->idioma('error/not_found');

			$this->document->setTitle($this->idioma->get('heading_title'));

			$this->data['heading_title'] = $this->idioma->get('heading_title');

			$this->data['text_not_found'] = $this->idioma->get('text_not_found');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => 'Inicio',
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->idioma->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);
		
			$this->template = 'error/not_found.tpl';
			$this->children = array(
				'common/header',
				'common/footer',
			);
		
			$this->response->setOutput($this->render());
		}
	}
		
	public function estado() {
		$output = '<option value="">' . ' --- Seleccione --- ' . '</option>'; 
		
		$this->load->model('localidad/estado');
		
		$results = $this->model_localidad_estado->getEstadosByPaisId($this->request->get['paises_id']);
		
		foreach ($results as $result) {
			$output .= '<option value="' . $result['estados_id'] . '"';

			if (isset($this->request->get['estados_id']) && ($this->request->get['estados_id'] == $result['estados_id'])) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['estados_nombre'] . '</option>';
		}

		if (!$results) {
			$output .= '<option value="0">' . ' --- Ninguno --- ' . '</option>';
		}

		$this->response->setOutput($output);
	}
	
	public function transaction() {
    	$this->idioma->load('sale/cliente');
		
		$this->load->model('sale/cliente');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/cliente')) { 
			$this->model_sale_cliente->addTransaction($this->request->get['clientes_id'], $this->request->post['description'], $this->request->post['amount']);
				
			$this->data['success'] = $this->idioma->get('text_success');
		} else {
			$this->data['success'] = '';
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/cliente')) {
			$this->data['error_warning'] = $this->idioma->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}		
		
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_balance'] = $this->idioma->get('text_balance');
		
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');
		$this->data['column_description'] = $this->idioma->get('column_description');
		$this->data['column_amount'] = $this->idioma->get('column_amount');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['transactions'] = array();
			
		$results = $this->model_sale_cliente->getTransactions($this->request->get['clientes_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['transactions'][] = array(
				'amount'      => $this->moneda->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
        		'date_added'  => date('d/m/Y', strtotime($result['date_added']))
        	);
      	}			
		
		$this->data['balance'] = $this->moneda->format($this->model_sale_cliente->getTransactionTotal($this->request->get['clientes_id']), $this->config->get('config_currency'));
		
		$transaction_total = $this->model_sale_cliente->getTotalTransactions($this->request->get['clientes_id']);
			
		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/cliente/transaction', 'token=' . $this->session->data['token'] . '&clientes_id=' . $this->request->get['clientes_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/cliente_transaction.tpl';		
		
		$this->response->setOutput($this->render());
	}
			
	public function reward() {
    	$this->idioma->load('sale/cliente');
		
		$this->load->model('sale/cliente');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/cliente')) { 
			$this->model_sale_cliente->addReward($this->request->get['clientes_id'], $this->request->post['description'], $this->request->post['points']);
				
			$this->data['success'] = $this->idioma->get('text_success');
		} else {
			$this->data['success'] = '';
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/cliente')) {
			$this->data['error_warning'] = $this->idioma->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}	
				
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_balance'] = $this->idioma->get('text_balance');
		
		$this->data['column_date_added'] = $this->idioma->get('column_date_added');
		$this->data['column_description'] = $this->idioma->get('column_description');
		$this->data['column_points'] = $this->idioma->get('column_points');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['rewards'] = array();
			
		$results = $this->model_sale_cliente->getRewards($this->request->get['clientes_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['rewards'][] = array(
				'points'      => $result['points'],
				'description' => $result['description'],
        		'date_added'  => date('d/m/Y', strtotime($result['date_added']))
        	);
      	}			
		
		$this->data['balance'] = $this->model_sale_cliente->getRewardTotal($this->request->get['clientes_id']);
		
		$reward_total = $this->model_sale_cliente->getTotalRewards($this->request->get['clientes_id']);
			
		$pagination = new Pagination();
		$pagination->total = $reward_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/cliente/reward', 'token=' . $this->session->data['token'] . '&clientes_id=' . $this->request->get['clientes_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/cliente_reward.tpl';		
		
		$this->response->setOutput($this->render());
	}

	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->post['filter_name'])) {
			$this->load->model('sale/cliente');
			
			$data = array(
				'filter_name' => $this->request->post['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
		
			$results = $this->model_sale_cliente->getClientes($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'clientes_id'    => $result['clientes_id'], 
					'name'           => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
//					'cliente_group' => $result['cliente_group'],
					'clientes_nombre'      => $result['clientes_nombre'],
					'clientes_apellido'       => $result['clientes_apellido'],
					'clientes_genero'       => $result['clientes_genero'],
					'clientes_fdn'       => $result['clientes_fdn'],
					'clientes_email'          => $result['clientes_email'],
					'clientes_tel'      => $result['clientes_tel'],
					'clientes_cel'            => $result['clientes_cel'],
					'clientes_pin'            => $result['clientes_pin'],
					'clientes_twitter'            => $result['clientes_twitter'],
					'address'        => $this->model_sale_cliente->getAddresses($result['clientes_id'])
				);					
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);
				
		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}		
	
	public function address() {
		$json = array();
		
		if (isset($this->request->post['address_id']) && $this->request->post['address_id']) {
			$this->load->model('sale/cliente');
			
			$json = $this->model_sale_cliente->getAddress($this->request->post['address_id']);
		}
		
		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));		
	}
}
?>
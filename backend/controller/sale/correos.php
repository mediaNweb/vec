<?php 
class ControllerSaleCorreos extends Controller {
	private $error = array(); 
     
  	public function index() {
		    	
		$this->document->setTitle('Correos'); 
		
		$this->load->model('inscripciones/participantes');
		
		$this->getList();
  	}
  
  	private function getList() {				

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'e.eventos_titulo';
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
       		'text'      => 'Correos',
			'href'      => $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['eventos'] = array();

		$data = array(
			'sort'            				=> $sort,
			'order'           				=> $order,
			'start'           				=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           				=> $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');

		$evento_total = $this->model_inscripciones_participantes->getTotalEventosActivos($data);
			
		$results = $this->model_inscripciones_participantes->getEventosActivos($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Descargar',
//				'href' => $this->url->link('sale/correos/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
				'href' => $this->url->link('sale/correos/export', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . '&sort=ep.eventos_participantes_id' . $url, 'SSL')
			);
			
			if ($result['eventos_logo'] && file_exists(DIR_IMAGE . $result['eventos_logo'])) {
				$image = $this->model_tool_image->resize($result['eventos_logo'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			$id_evento = $result['eventos_id'];
	
			$correos = $this->model_inscripciones_participantes->getTotalParticipantesCorreosByEvento($id_evento);
			$celulares = $this->model_inscripciones_participantes->getTotalParticipantesCelularesByEvento($id_evento);

      		$this->data['eventos'][] = array(
				'eventos_id' 				=> $result['eventos_id'],
				'eventos_titulo'       		=> $result['eventos_titulo'],
				'correos' 					=> $correos,
				'celulares' 				=> $celulares,
				'eventos_tipo_nombre'      	=> $this->model_inscripciones_participantes->getTipo($result['eventos_id']),
				'eventos_precio'      		=> $result['eventos_precio'],
				'eventos_logo'      		=> $image,
				'eventos_cupos_internet'	=> $result['eventos_cupos_internet'],
				'eventos_status'     		=> ($result['eventos_status'] ? 'Habilitado' : 'Deshabilitado'),
				'eventos_inscripciones'     => ($result['eventos_inscripciones'] ? 'Habilitado' : 'Deshabilitado'),
				'selected'   				=> isset($this->request->post['selected']) && in_array($result['eventos_id'], $this->request->post['selected']),
				'action'     				=> $action
			);
    	}
		
		$this->data['heading_title'] = 'Correos';		
				
		$this->data['text_enabled'] = 'Habilitado';		
		$this->data['text_disabled'] = 'Deshabilitado';		
		$this->data['text_no_results'] = 'Sin resultados';		
		$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';		
			
		$this->data['column_image'] = 'Im&aacute;gen';		
		$this->data['column_eventos_titulo'] = 'Nombre del Evento';		
		$this->data['column_totales'] = 'Total Correos';		
		$this->data['column_correos'] = 'Correos';		
		$this->data['column_celulares'] = 'Celulares';		
		$this->data['column_eventos_tipos_nombre'] = 'Tipo';		
		$this->data['column_eventos_precio'] = 'Costo de Inscripci&oacute;n';		
		$this->data['column_eventos_cupos_internet'] = 'Cupos para Internet';		
		$this->data['column_eventos_status'] = 'Status';		
		$this->data['column_action'] = 'Acci&oacute;n';		
				
		$this->data['button_copy'] = 'Copiar';		
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_eventos_titulo'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_titulo' . $url, 'SSL');
		$this->data['sort_eventos_privado'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_privado' . $url, 'SSL');
		$this->data['sort_eventos_tipos_nombre'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_tipos_nombre' . $url, 'SSL');
		$this->data['sort_eventos_precio'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_precio' . $url, 'SSL');
		$this->data['sort_eventos_cupos_internet'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_cupos_internet' . $url, 'SSL');
		$this->data['sort_eventos_status'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_eventos_status' . $url, 'SSL');
		$this->data['sort_eventos_orden'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . '&sort=e.eventos_orden' . $url, 'SSL');
		
		$url = '';

		$pagination = new Pagination();
		$pagination->total = $evento_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/correos_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function consulta() {
    	
		$this->load->idioma('sale/correos');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		
		$this->getForm();

  	}

  	private function getForm() {

		if (isset($this->request->get['filter_eventos_participantes_cedula'])) {
			$filter_eventos_participantes_cedula = $this->request->get['filter_eventos_participantes_cedula'];
		} else {
			$filter_eventos_participantes_cedula = null;
		}

		if (isset($this->request->get['filter_eventos_participantes_apellidos'])) {
			$filter_eventos_participantes_apellidos = $this->request->get['filter_eventos_participantes_apellidos'];
		} else {
			$filter_eventos_participantes_apellidos = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_nombres'])) {
			$filter_eventos_participantes_nombres = $this->request->get['filter_eventos_participantes_nombres'];
		} else {
			$filter_eventos_participantes_nombres = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_genero'])) {
			$filter_eventos_participantes_genero = $this->request->get['filter_eventos_participantes_genero'];
		} else {
			$filter_eventos_participantes_genero = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_email'])) {
			$filter_eventos_participantes_email = $this->request->get['filter_eventos_participantes_email'];
		} else {
			$filter_eventos_participantes_email = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_cel'])) {
			$filter_eventos_participantes_cel = $this->request->get['filter_eventos_participantes_cel'];
		} else {
			$filter_eventos_participantes_cel = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ep.eventos_participantes_id';
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

		if (isset($this->request->get['filter_eventos_participantes_cedula'])) {
			$url .= '&filter_eventos_participantes_cedula=' . $this->request->get['filter_eventos_participantes_cedula'];
		}
											
		if (isset($this->request->get['filter_eventos_participantes_apellidos'])) {
			$url .= '&filter_eventos_participantes_apellidos=' . $this->request->get['filter_eventos_participantes_apellidos'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_genero'])) {
			$url .= '&filter_eventos_participantes_genero=' . $this->request->get['filter_eventos_participantes_genero'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_nombres'])) {
			$url .= '&filter_eventos_participantes_nombres=' . $this->request->get['filter_eventos_participantes_nombres'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_email'])) {
			$url .= '&filter_eventos_participantes_email=' . $this->request->get['filter_eventos_participantes_email'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_cel'])) {
			$url .= '&filter_eventos_participantes_cel=' . $this->request->get['filter_eventos_participantes_cel'];
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
			'href'      => $this->url->link('sale/correos', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['participantes'] = array();

		$data = array(
			'filter_eventos_participantes_cedula'	    => $filter_eventos_participantes_cedula,
			'filter_eventos_participantes_apellidos'  => $filter_eventos_participantes_apellidos,
			'filter_eventos_participantes_genero'  	=> $filter_eventos_participantes_genero,
			'filter_eventos_participantes_nombres'    => $filter_eventos_participantes_nombres,
			'filter_eventos_participantes_email'		=> $filter_eventos_participantes_email,
			'filter_eventos_participantes_cel'		=> $filter_eventos_participantes_cel,
			'sort'                   	=> $sort,
			'order'                  	=> $order,
			'start'                  	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  	=> $this->config->get('config_admin_limit')
		);

		$this->load->model('catalog/evento');

		$id_evento = $this->request->get['eventos_id'];
		$evento_info = $this->model_catalog_evento->getEventoDescripcion($id_evento);

		$correos = $this->model_inscripciones_participantes->getTotalParticipantesCorreosByEvento($id_evento);
		$celulares = $this->model_inscripciones_participantes->getTotalParticipantesCelularesByEvento($id_evento);

		$order_total = $this->model_inscripciones_participantes->getTotalParticipantesByEvento($this->request->get['eventos_id']);

//		$this->data['results'] = $this->model_inscripciones_participantes->getParticipantesExport($this->request->get['eventos_id']);
		
		$results = $this->model_inscripciones_participantes->getParticipantesByEvento($this->request->get['eventos_id'], $data);

    	foreach ($results as $result) {

			$action = array();
			
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('sale/correos/info', 'token=' . $this->session->data['token'] . '&eventos_participantes_id=' . $result['eventos_participantes_id'] . $url, 'SSL')
			);

/*
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('sale/participantes/edit', 'token=' . $this->session->data['token'] . '&eventos_participantes_id=' . $result['eventos_participantes_id'] . $url, 'SSL')
			);
*/
			
			if (strlen($result['eventos_participantes_cel']) == 11) {
				$cel_format = '58' . substr($result['eventos_participantes_cel'], 1);  
			} else {
				if (strlen($result['eventos_participantes_cel']) == 10) {
					$cel_format = '58' . $result['eventos_participantes_cel'];  
				} else {
					$cel_format = $result['eventos_participantes_cel'];
				}
			}
			
			$this->data['participantes'][] = array(
				'eventos_participantes_id'			=> $result['eventos_participantes_id'],
				'eventos_participantes_id_pedido'   => $result['eventos_participantes_id_pedido'],
				'payment_method'					=> ($result['payment_method'] == '') ? 'Transcrita' : $result['payment_method'],
				'eventos_participantes_numero'      => $result['eventos_participantes_numero'],
				'eventos_participantes_cedula'      => $result['eventos_participantes_cedula'],
				'eventos_participantes_apellidos'   => $result['eventos_participantes_apellidos'],
				'eventos_participantes_nombres'		=> $result['eventos_participantes_nombres'],
				'eventos_participantes_genero'		=> $result['eventos_participantes_genero'],
				'eventos_participantes_fdn'			=> $result['eventos_participantes_fdn'],
				'eventos_participantes_email'       => $result['eventos_participantes_email'],
				'eventos_participantes_cel'      	=> $cel_format,
				'eventos_participantes_grupo'     	=> $result['eventos_participantes_grupo'],
				'eventos_participantes_edad'     	=> $result['eventos_participantes_edad'],
				'eventos_participantes_categoria'   => $result['eventos_participantes_categoria'],
				'selected'      					=> isset($this->request->post['selected']) && in_array($result['eventos_participantes_id'], $this->request->post['selected']),
				'action'        					=> $action
			);
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');

		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_abandoned_orders'] = $this->idioma->get('text_abandoned_orders');
		$this->data['text_no_results'] = 'Sin resultados';
		$this->data['text_correos'] = sprintf('Correos: (%s)', $correos);
		$this->data['text_celulares'] = sprintf('Celulares: (%s)', $celulares);

		$this->data['column_eventos_participantes_id_pedido'] = $this->idioma->get('column_eventos_participantes_id_pedido');
		$this->data['column_payment_method'] = $this->idioma->get('column_payment_method');
		$this->data['column_eventos_participantes_numero'] = $this->idioma->get('column_eventos_participantes_numero');
    	$this->data['column_eventos_participantes_cedula'] = $this->idioma->get('column_eventos_participantes_cedula');
		$this->data['column_eventos_participantes_apellidos'] = $this->idioma->get('column_eventos_participantes_apellidos');
		$this->data['column_eventos_participantes_nombres'] = $this->idioma->get('column_eventos_participantes_nombres');
		$this->data['column_eventos_participantes_genero'] = $this->idioma->get('column_eventos_participantes_genero');
		$this->data['column_eventos_participantes_fdn'] = $this->idioma->get('column_eventos_participantes_fdn');
		$this->data['column_eventos_participantes_email'] = $this->idioma->get('column_eventos_participantes_email');
		$this->data['column_eventos_participantes_cel'] = $this->idioma->get('column_eventos_participantes_cel');
		$this->data['column_eventos_participantes_id_pais'] = $this->idioma->get('column_eventos_participantes_id_pais');
    	$this->data['column_eventos_participantes_id_estado'] = $this->idioma->get('column_eventos_participantes_id_estado');
		$this->data['column_eventos_participantes_grupo'] = $this->idioma->get('column_eventos_participantes_grupo');
		$this->data['column_eventos_participantes_edad'] = $this->idioma->get('column_eventos_participantes_edad');
		$this->data['column_eventos_participantes_categoria'] = $this->idioma->get('column_eventos_participantes_categoria');
		$this->data['column_action'] = 'Acci&oacute;n';

		$this->data['button_filter'] = 'Filtrar';
		$this->data['button_download'] = 'Descargar';
		$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_delete'] = 'Eliminar';

		$this->data['eventos_titulo'] = $evento_info['eventos_titulo'];
		$this->data['eventos_id'] = $id_evento;
		$this->data['token'] = $this->session->data['token'];

		$this->data['delete'] = $this->url->link('sale/participantes/delete', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['action'] = $this->url->link('sale/participantes/export', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_numero' . $url, 'SSL');

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

		if (isset($this->request->get['filter_eventos_participantes_id_pedido'])) {
			$url .= '&filter_eventos_participantes_id_pedido=' . $this->request->get['filter_eventos_participantes_id_pedido'];
		}
		
		if (isset($this->request->get['filter_payment_method'])) {
			$url .= '&filter_payment_method=' . $this->request->get['filter_payment_method'];
		}

		if (isset($this->request->get['filter_eventos_participantes_numero'])) {
			$url .= '&filter_eventos_participantes_numero=' . $this->request->get['filter_eventos_participantes_numero'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_cedula'])) {
			$url .= '&filter_eventos_participantes_cedula=' . $this->request->get['filter_eventos_participantes_cedula'];
		}
											
		if (isset($this->request->get['filter_eventos_participantes_apellidos'])) {
			$url .= '&filter_eventos_participantes_apellidos=' . $this->request->get['filter_eventos_participantes_apellidos'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_genero'])) {
			$url .= '&filter_eventos_participantes_genero=' . $this->request->get['filter_eventos_participantes_genero'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_nombres'])) {
			$url .= '&filter_eventos_participantes_nombres=' . $this->request->get['filter_eventos_participantes_nombres'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_fdn'])) {
			$url .= '&filter_eventos_participantes_fdn=' . $this->request->get['filter_eventos_participantes_fdn'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_email'])) {
			$url .= '&filter_eventos_participantes_email=' . $this->request->get['filter_eventos_participantes_email'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_cel'])) {
			$url .= '&filter_eventos_participantes_cel=' . $this->request->get['filter_eventos_participantes_cel'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_id_pais'])) {
			$url .= '&filter_eventos_participantes_id_pais=' . $this->request->get['filter_eventos_participantes_id_pais'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_id_estado'])) {
			$url .= '&filter_eventos_participantes_id_estado=' . $this->request->get['filter_eventos_participantes_id_estado'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_grupo'])) {
			$url .= '&filter_eventos_participantes_grupo=' . $this->request->get['filter_eventos_participantes_grupo'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_edad'])) {
			$url .= '&filter_eventos_participantes_edad=' . $this->request->get['filter_eventos_participantes_edad'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_categoria'])) {
			$url .= '&filter_eventos_participantes_categoria=' . $this->request->get['filter_eventos_participantes_categoria'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_eventos_participantes_id_pedido'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_id_pedido' . $url, 'SSL');
		$this->data['sort_payment_method'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=o.payment_method' . $url, 'SSL');
		$this->data['sort_eventos_participantes_numero'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_numero' . $url, 'SSL');
		$this->data['sort_eventos_participantes_cedula'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_cedula' . $url, 'SSL');
		$this->data['sort_eventos_participantes_apellidos'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_apellidos' . $url, 'SSL');
		$this->data['sort_eventos_participantes_nombres'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_nombres' . $url, 'SSL');
		$this->data['sort_eventos_participantes_genero'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_genero' . $url, 'SSL');
		$this->data['sort_eventos_participantes_fdn'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_fdn' . $url, 'SSL');
		$this->data['sort_eventos_participantes_email'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_email' . $url, 'SSL');
		$this->data['sort_eventos_participantes_cel'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_cel' . $url, 'SSL');
		$this->data['sort_eventos_participantes_id_pais'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_id_pais' . $url, 'SSL');
		$this->data['sort_eventos_participantes_id_estado'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_id_estado' . $url, 'SSL');
		$this->data['sort_eventos_participantes_grupo'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_grupo' . $url, 'SSL');
		$this->data['sort_eventos_participantes_edad'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_edad' . $url, 'SSL');
		$this->data['sort_eventos_participantes_categoria'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . '&sort=ep.eventos_participantes_categoria' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_eventos_participantes_id_pedido'])) {
			$url .= '&filter_eventos_participantes_id_pedido=' . $this->request->get['filter_eventos_participantes_id_pedido'];
		}

		if (isset($this->request->get['filter_payment_method'])) {
			$url .= '&filter_payment_method=' . $this->request->get['filter_payment_method'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_numero'])) {
			$url .= '&filter_eventos_participantes_numero=' . $this->request->get['filter_eventos_participantes_numero'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_cedula'])) {
			$url .= '&filter_eventos_participantes_cedula=' . $this->request->get['filter_eventos_participantes_cedula'];
		}
											
		if (isset($this->request->get['filter_eventos_participantes_apellidos'])) {
			$url .= '&filter_eventos_participantes_apellidos=' . $this->request->get['filter_eventos_participantes_apellidos'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_genero'])) {
			$url .= '&filter_eventos_participantes_genero=' . $this->request->get['filter_eventos_participantes_genero'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_nombres'])) {
			$url .= '&filter_eventos_participantes_nombres=' . $this->request->get['filter_eventos_participantes_nombres'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_fdn'])) {
			$url .= '&filter_eventos_participantes_fdn=' . $this->request->get['filter_eventos_participantes_fdn'];
		}
					
		if (isset($this->request->get['filter_eventos_participantes_email'])) {
			$url .= '&filter_eventos_participantes_email=' . $this->request->get['filter_eventos_participantes_email'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_cel'])) {
			$url .= '&filter_eventos_participantes_cel=' . $this->request->get['filter_eventos_participantes_cel'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_id_pais'])) {
			$url .= '&filter_eventos_participantes_id_pais=' . $this->request->get['filter_eventos_participantes_id_pais'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_id_estado'])) {
			$url .= '&filter_eventos_participantes_id_estado=' . $this->request->get['filter_eventos_participantes_id_estado'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_grupo'])) {
			$url .= '&filter_eventos_participantes_grupo=' . $this->request->get['filter_eventos_participantes_grupo'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_edad'])) {
			$url .= '&filter_eventos_participantes_edad=' . $this->request->get['filter_eventos_participantes_edad'];
		}
		
		if (isset($this->request->get['filter_eventos_participantes_categoria'])) {
			$url .= '&filter_eventos_participantes_categoria=' . $this->request->get['filter_eventos_participantes_categoria'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_eventos_participantes_cedula'] = $filter_eventos_participantes_cedula;
		$this->data['filter_eventos_participantes_apellidos'] = $filter_eventos_participantes_apellidos;
		$this->data['filter_eventos_participantes_nombres'] = $filter_eventos_participantes_nombres;
		$this->data['filter_eventos_participantes_genero'] = $filter_eventos_participantes_genero;
		$this->data['filter_eventos_participantes_email'] = $filter_eventos_participantes_email;
		$this->data['filter_eventos_participantes_cel']	= $filter_eventos_participantes_cel;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/correos_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	} 
	
   	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/participantes')) {
			$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los participantes!';
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

	public function cliente() {
		
		$json = array();
		
		if (isset($this->request->get['clientes_id'])) {
			
			$this->load->model('inscripciones/participantes');

			$participante = $this->model_inscripciones_participantes->isParticipante($this->request->get['clientes_id'], $this->request->get['eventos_id']);

			if($participante) {

				$json['error'] = 'Usted ya se encuentra registrado en este evento.';

			} else {

				$this->load->model('sesion/cliente');
	
				$cliente = $this->model_sesion_cliente->isCliente($this->request->get['clientes_id']);
	
				if($cliente) {
	
					$this->load->model('sesion/cliente');
					
					$data_clientes = array();
					$data_clientes = $this->model_sesion_cliente->getCliente($this->request->get['clientes_id']);
				
					$json['output'] = $data_clientes;
					
					$data_categorias = array();
					$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $data_clientes['edad'], $data_clientes['sexo']);

					foreach ($data_categorias as $key => $value) {
						$json['categoria_' .$key] = $value;
					}
	
				} else {

					$persona = $this->model_sesion_cliente->isPersona($this->request->get['clientes_id']);
		
					if($persona) {
		
						$this->load->model('sesion/cliente');
						
						$data_personas = array();
						$data_personas = $this->model_sesion_cliente->getPersona($this->request->get['clientes_id']);
					
						$json['output'] = $data_personas;
						
						$data_categorias = array();
						$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $data_personas['edad'], $data_personas['sexo']);
	
						foreach ($data_categorias as $key => $value) {
							$json['categoria_' .$key] = $value;
						}
		
					}
					
				}
				
			}
			
		}	
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function estado() {
		
		$output = '<option value="">--Estado--</option>';

		$this->load->model('localidad/estado');
		
		if (isset($this->request->get['pais_id'])) {

			$results = $this->model_localidad_estado->getEstadosByPaisId($this->request->get['pais_id']);

			foreach ($results as $result) {

				$output .= '<option value="' . $result['estados_id'] . '"';

				if (isset($this->request->get['estados_id']) && ($this->request->get['estados_id'] == $result['estados_id'])) {
					$output .= ' selected="selected"';
				}

				$output .= '>' . $result['estados_nombre'] . '</option>';
				
			} 

			if (!$results) {
				$output .= '<option value="0">--Ninguno--</option>';
			}

			$this->response->setOutput($output);
			
		}
	}  

	public function categoria() {
		$json = array();
		
		if (isset($this->request->get['eventos_id']) && isset($this->request->get['edad']) && isset($this->request->get['sexo'])) {
			
			$this->load->model('sesion/cliente');

			$data_categorias = array();
			$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $this->request->get['edad'], $this->request->get['sexo']);

			foreach ($data_categorias as $key => $value) {
				$json['categoria_' .$key] = $value;
			}
				
		} else {
			
			$json['error'] = 'Debe colocar la Fecha de su Nacimiento y su Género.';
		
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));

	}

	function CSVExport($query) {
		$sql_csv = mysql_query($query) or die("Error: " . mysql_error()); //Replace this line with what is appropriate for your DB abstraction layer
		
		header ("Content-Type: application/msexcel");
		header ("Content-Disposition: attachment; filename=\"filename.csv\"");

//		header("Content-type:text/octect-stream");
//		header("Content-Disposition:attachment;filename=data.csv");
		while($row = mysql_fetch_row($sql_csv)) {
			print '"' . stripslashes(implode('";\"',$row)) . "\"\n";
		}
		exit;
	}

	/**
	* Generatting CSV formatted string from an array.
	* By Sergey Gurevich.
	*/
	function exportCSV($array, $header_row = true, $col_sep = ";", $row_sep = "\n", $qut = '"')
	{
		if (!is_array($array) or !is_array($array[0])) return false;

		$output = '';

		//Header row.
		if ($header_row)
		{
			foreach ($array[0] as $key => $val)
			{
				//Escaping quotes.
				$key = str_replace($qut, "$qut$qut", $key);
				$output .= "$col_sep$qut$key$qut";
			}
			$output = substr($output, 1).$row_sep;
		}
		//Data rows.
		foreach ($array as $key => $val)
		{
			$tmp = '';
			foreach ($val as $cell_key => $cell_val)
			{
				//Escaping quotes.
				$cell_val = str_replace($qut, "$qut$qut", $cell_val);
				$tmp .= "$col_sep$qut$cell_val$qut";
			}
			$output .= substr($tmp, 1).$row_sep;
		}
		
		print $output;
	}

	public function export() {

		$eventos_id = $this->request->get['eventos_id'];

		/** Error reporting */
		error_reporting(E_ALL);

 		if (ob_get_level() == 0) ob_start();

		header ("Content-Type: application/msexcel");
		header ("Content-Disposition: attachment; filename=\"data_contactos_" . $eventos_id . ".csv\"");

		$this->load->model('inscripciones/participantes');
		
		$results = $this->model_inscripciones_participantes->getParticipantesContactosExport($this->request->get['eventos_id']);

    	foreach ($results as $result) {
			
			if (strlen($result['Celular']) == 11) {
				$cel_format = '58' . substr($result['Celular'], 1);  
			} else {
				if (strlen($result['Celular']) == 10) {
					$cel_format = '58' . $result['Celular'];  
				} else {
					$cel_format = $result['Celular'];
				}
			}
			
			$array_participantes = array(
				'Nombre'		=> $result['Nombre'],
				'Genero'		=> $result['Genero'],
				'Email'       	=> ($this->validaEmail($result['Email']) ? $result['Email'] : 'Correo Invalido'),
				'Celular'      	=> $cel_format,
			);
				
			$data_participantes[] = $array_participantes;

			ob_flush();
			flush();

		}

		ob_end_flush();		
		
		/* Enabling Mac compatibility when reading files */
		ini_set('auto_detect_line_endings', true);

		//Converting array to CSV.
		$csv_data = $this->exportCSV($data_participantes, true, ";", "\r\n");

	}
	
	/**
	Validate an email address.
	Provide email address (raw input)
	Returns true if the email address has the email 
	address format and the domain exists.
	*/

	public function validaEmail($email) {
		
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   if (is_bool($atIndex) && !$atIndex)
	   {
		  $isValid = false;
	   }
	   else
	   {
		  $domain = substr($email, $atIndex+1);
		  $local = substr($email, 0, $atIndex);
		  $localLen = strlen($local);
		  $domainLen = strlen($domain);
		  if ($localLen < 1 || $localLen > 64)
		  {
			 // local part length exceeded
			 $isValid = false;
		  }
		  else if ($domainLen < 1 || $domainLen > 255)
		  {
			 // domain part length exceeded
			 $isValid = false;
		  }
		  else if ($local[0] == '.' || $local[$localLen-1] == '.')
		  {
			 // local part starts or ends with '.'
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $local))
		  {
			 // local part has two consecutive dots
			 $isValid = false;
		  }
		  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		  {
			 // character not valid in domain part
			 $isValid = false;
		  }
		  else if (preg_match('/\\.\\./', $domain))
		  {
			 // domain part has two consecutive dots
			 $isValid = false;
		  }
		  else if
	(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					 str_replace("\\\\","",$local)))
		  {
			 // character not valid in local part unless 
			 // local part is quoted
			 if (!preg_match('/^"(\\\\"|[^"])+"$/',
				 str_replace("\\\\","",$local)))
			 {
				$isValid = false;
			 }
		  }

		  if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
		  {
			 // domain not found in DNS
			 $isValid = false;
		  }

	   }

	   return $isValid;

	}

}
?>
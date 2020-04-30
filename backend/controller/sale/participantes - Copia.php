<?php 
class ControllerSaleParticipantes extends Controller {
	private $error = array(); 
     
  	public function index() {
		    	
		$this->document->setTitle('Participantes'); 
		
		$this->load->model('catalog/evento');
		$this->load->model('inscripciones/participantes');
		
		$this->getList();
  	}
  
  	private function getList() {				

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'e.eventos_fecha';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		if (isset($this->request->get['filter_eventos_year'])) {
			$filter_eventos_year = $this->request->get['filter_eventos_year'];
		} else {
			$filter_eventos_year = date("Y");
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

		if (isset($this->request->get['filter_eventos_year'])) {
			$url .= '&filter_eventos_year=' . $this->request->get['filter_eventos_year'];
		}
						
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Participantes',
			'href'      => $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
	   	$this->data['years'] = $this->model_catalog_evento->getEventosYears();			
		
		$this->data['eventos'] = array();

		$data = array(
			'filter_eventos_year'   		=> $filter_eventos_year,
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
				'text' => 'Ver Participante',
				'href' => $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			if ($result['eventos_logo'] && file_exists(DIR_IMAGE . $result['eventos_logo'])) {
				$image = $this->model_tool_image->resize($result['eventos_logo'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			$id_evento = $result['eventos_id'];
	
			$confirmados = $this->model_inscripciones_participantes->getTotalParticipantesConfirmadosByEvento($id_evento);
			$no_confirmados = $this->model_inscripciones_participantes->getTotalParticipantesNoConfirmadosByEvento($id_evento);
			$totales = $confirmados + $no_confirmados;

      		$this->data['eventos'][] = array(
				'eventos_id' 				=> $result['eventos_id'],
				'eventos_titulo'       		=> $result['eventos_titulo'],
				'confirmados' 				=> $confirmados,
				'no_confirmados' 			=> $no_confirmados,
				'totales' 					=> $totales,
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
		
		$this->data['heading_title'] = 'Participantes';		
				
    	$this->data['text_all'] = ' --- Todos --- ';
		$this->data['text_enabled'] = 'Habilitado';		
		$this->data['text_disabled'] = 'Deshabilitado';		
		$this->data['text_no_results'] = 'Sin resultados';		
		$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';		
			
		$this->data['column_image'] = 'Im&aacute;gen';		
		$this->data['column_eventos_titulo'] = 'Nombre del Evento';		
		$this->data['column_totales'] = 'Total Participantes';		
		$this->data['column_confirmados'] = 'Participantes Confirmados';		
		$this->data['column_no_confirmados'] = 'Participantes Sin Confirmar';		
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
					
		$this->data['sort_eventos_titulo'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_titulo' . $url, 'SSL');
		$this->data['sort_eventos_privado'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_privado' . $url, 'SSL');
		$this->data['sort_eventos_tipos_nombre'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_tipos_nombre' . $url, 'SSL');
		$this->data['sort_eventos_precio'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_precio' . $url, 'SSL');
		$this->data['sort_eventos_cupos_internet'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_cupos_internet' . $url, 'SSL');
		$this->data['sort_eventos_status'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_eventos_status' . $url, 'SSL');
		$this->data['sort_eventos_orden'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . '&sort=e.eventos_orden' . $url, 'SSL');
		
		$url = '';

		$pagination = new Pagination();
		$pagination->total = $evento_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_eventos_year'] = $filter_eventos_year;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/participantes_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function consulta() {
    	
		$this->load->idioma('sale/participantes');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		
		$this->getForm();

  	}

  	private function getForm() {

		if (isset($this->request->get['filter_eventos_participantes_id_pedido'])) {
			$filter_eventos_participantes_id_pedido = $this->request->get['filter_eventos_participantes_id_pedido'];
		} else {
			$filter_eventos_participantes_id_pedido = null;
		}

		if (isset($this->request->get['filter_payment_method'])) {
			$filter_payment_method = $this->request->get['filter_payment_method'];
		} else {
			$filter_payment_method = null;
		}

		if (isset($this->request->get['filter_eventos_participantes_numero'])) {
			$filter_eventos_participantes_numero = $this->request->get['filter_eventos_participantes_numero'];
		} else {
			$filter_eventos_participantes_numero = null;
		}

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
		
		if (isset($this->request->get['filter_eventos_participantes_fdn'])) {
			$filter_eventos_participantes_fdn = $this->request->get['filter_eventos_participantes_fdn'];
		} else {
			$filter_eventos_participantes_fdn = null;
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
		
		if (isset($this->request->get['filter_eventos_participantes_id_pais'])) {
			$filter_eventos_participantes_id_pais = $this->request->get['filter_eventos_participantes_id_pais'];
		} else {
			$filter_eventos_participantes_id_pais = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_id_estado'])) {
			$filter_eventos_participantes_id_estado = $this->request->get['filter_eventos_participantes_id_estado'];
		} else {
			$filter_eventos_participantes_id_estado = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_grupo'])) {
			$filter_eventos_participantes_grupo = $this->request->get['filter_eventos_participantes_grupo'];
		} else {
			$filter_eventos_participantes_grupo = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_edad'])) {
			$filter_eventos_participantes_edad = $this->request->get['filter_eventos_participantes_edad'];
		} else {
			$filter_eventos_participantes_edad = null;
		}
		
		if (isset($this->request->get['filter_eventos_participantes_categoria'])) {
			$filter_eventos_participantes_categoria = $this->request->get['filter_eventos_participantes_categoria'];
		} else {
			$filter_eventos_participantes_categoria = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ep.eventos_participantes_numero';
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
			'href'      => $this->url->link('sale/participantes', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['participantes'] = array();

		$data = array(
			'filter_eventos_participantes_id_pedido'    => $filter_eventos_participantes_id_pedido,
			'filter_payment_method'    					=> $filter_payment_method,
			'filter_eventos_participantes_numero'       => $filter_eventos_participantes_numero,
			'filter_eventos_participantes_cedula'	    => $filter_eventos_participantes_cedula,
			'filter_eventos_participantes_apellidos'  	=> $filter_eventos_participantes_apellidos,
			'filter_eventos_participantes_genero'  	 	=> $filter_eventos_participantes_genero,
			'filter_eventos_participantes_nombres'      => $filter_eventos_participantes_nombres,
			'filter_eventos_participantes_fdn'          => $filter_eventos_participantes_fdn,
			'filter_eventos_participantes_email'		=> $filter_eventos_participantes_email,
			'filter_eventos_participantes_cel'			=> $filter_eventos_participantes_cel,
			'filter_eventos_participantes_id_pais'		=> $filter_eventos_participantes_id_pais,
			'filter_eventos_participantes_id_estado'	=> $filter_eventos_participantes_id_estado,
			'filter_eventos_participantes_grupo'		=> $filter_eventos_participantes_grupo,
			'filter_eventos_participantes_edad'			=> $filter_eventos_participantes_edad,
			'filter_eventos_participantes_categoria'	=> $filter_eventos_participantes_categoria,
			'sort'                   					=> $sort,
			'order'                  					=> $order,
			'start'                  					=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  					=> $this->config->get('config_admin_limit')
		);

		$this->load->model('catalog/evento');
		$this->load->model('localidad/pais');
		$this->load->model('localidad/estado');

		$id_evento = $this->request->get['eventos_id'];
		$evento_info = $this->model_catalog_evento->getEventoDescripcion($id_evento);

		$confirmados = $this->model_inscripciones_participantes->getTotalParticipantesConfirmadosByEvento($id_evento);
		$no_confirmados = $this->model_inscripciones_participantes->getTotalParticipantesNoConfirmadosByEvento($id_evento);
		$totales = $confirmados + $no_confirmados;

		$order_total = $this->model_inscripciones_participantes->getTotalParticipantesByEvento($this->request->get['eventos_id']);

//		$this->data['results'] = $this->model_inscripciones_participantes->getParticipantesExport($this->request->get['eventos_id']);
		
		$results = $this->model_inscripciones_participantes->getParticipantesByEvento($this->request->get['eventos_id'], $data);

    	foreach ($results as $result) {

			$action = array();
			
			$action[] = array(
				'text' => $this->idioma->get('text_edit'),
				'href' => $this->url->link('sale/participantes/info', 'token=' . $this->session->data['token'] . '&eventos_participantes_id=' . $result['eventos_participantes_id'] . $url, 'SSL')
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
			
			$pais = $this->model_localidad_pais->getPaisByCodigo($result['eventos_participantes_id_pais']);
			$estado = $this->model_localidad_estado->getEstadoByCodigo($result['eventos_participantes_id_estado']);
			
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
				'eventos_participantes_id_pais'     => $pais,
				'eventos_participantes_id_estado'   => $estado,
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
		$this->data['text_confirmados'] = sprintf('Confirmados: (%s)', $confirmados);
		$this->data['text_no_confirmados'] = sprintf('No Cofirmados: (%s)', $no_confirmados);
		$this->data['text_totales'] = sprintf('Totales: (%s)', $totales);

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

		$this->data['filter_eventos_participantes_id_pedido'] = $filter_eventos_participantes_id_pedido;
		$this->data['filter_payment_method'] = $filter_payment_method;
		$this->data['filter_eventos_participantes_numero'] = $filter_eventos_participantes_numero;
		$this->data['filter_eventos_participantes_cedula'] = $filter_eventos_participantes_cedula;
		$this->data['filter_eventos_participantes_apellidos'] = $filter_eventos_participantes_apellidos;
		$this->data['filter_eventos_participantes_nombres'] = $filter_eventos_participantes_nombres;
		$this->data['filter_eventos_participantes_genero'] = $filter_eventos_participantes_genero;
		$this->data['filter_eventos_participantes_fdn'] = $filter_eventos_participantes_fdn;
		$this->data['filter_eventos_participantes_email'] = $filter_eventos_participantes_email;
		$this->data['filter_eventos_participantes_cel']	= $filter_eventos_participantes_cel;
		$this->data['filter_eventos_participantes_id_pais']	= $filter_eventos_participantes_id_pais;
		$this->data['filter_eventos_participantes_id_estado'] = $filter_eventos_participantes_id_estado;
		$this->data['filter_eventos_participantes_grupo'] = $filter_eventos_participantes_grupo;
		$this->data['filter_eventos_participantes_edad'] = $filter_eventos_participantes_edad;
		$this->data['filter_eventos_participantes_categoria'] = $filter_eventos_participantes_categoria;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/participantes_form.tpl';
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

		header ("Content-Type: application/msexcel; charset=iso-8859-1");
		header ("Content-Disposition: attachment; filename=\"data_participantes_" . $eventos_id . ".csv\"");

		$this->load->model('inscripciones/participantes');
		$this->load->model('localidad/pais');
		$this->load->model('localidad/estado');
		
		$results = $this->model_inscripciones_participantes->getParticipantesExport($this->request->get['eventos_id']);

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
			
			if ($this->request->get['eventos_id'] == 21) {
				
				$array_participantes = array(
					'Solicitud'		=> $result['Solicitud'],
					'Pago'			=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  	=> $result['Planilla'],
					'Deposito'  	=> $result['Deposito'],
					'Fecha'  		=> $result['Fecha'],
					'Numero'		=> $result['Numero'],
					'Cedula'      	=> $result['Cedula'],
					'Empleado'      => $result['Empleado'],
					'Apellidos'   	=> $result['Apellidos'],
					'Nombres'		=> $result['Nombres'],
					'Genero'		=> $result['Genero'],
					'Nacimiento'	=> $result['Nacimiento'],
					'Email'       	=> $result['Email'],
					'Celular'      	=> $cel_format,
					'Pais'     		=> $result['Pais'],
					'Estado'   		=> $result['Estado'],
					'Tiempo'     	=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     	=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     		=> $result['Edad'],
					'Categoria'   	=> $result['Categoria'],
					'Talla'			=> $this->model_inscripciones_participantes->getRespuestaTalla($result['eventos_participantes_datos']),
					'Acompañante'	=> $this->model_inscripciones_participantes->getRespuestaAcompañante($result['eventos_participantes_datos']),
					'Transporte'	=> $this->model_inscripciones_participantes->getRespuestaTransporte($result['eventos_participantes_datos']),
					'Ciudad'		=> $this->model_inscripciones_participantes->getRespuestaCiudad($result['eventos_participantes_datos']),
				);
				
			} else if ($this->request->get['eventos_id'] == 37) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Tipo de Inscripcion'	=> $this->model_inscripciones_participantes->getRespuestaTipoInscripcion($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 34) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Tipo de Inscripcion'	=> $this->model_inscripciones_participantes->getRespuestaTipoInscripcionMTB($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 31) {

				$array_participantes = array(
//					'Solicitud'		=> $result['Solicitud'],
//					'Pago'			=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
//					'Planilla'  	=> $result['Planilla'],
					'Deposito'  	=> $result['Deposito'],
//					'Fecha'  		=> $result['Fecha'],
					'Numero'		=> $result['Numero'],
					'Cedula'      	=> $result['Cedula'],
					'Apellidos'   	=> $result['Apellidos'],
					'Nombres'		=> $result['Nombres'],
					'Genero'		=> $result['Genero'],
//					'Nacimiento'	=> $result['Nacimiento'],
					'Email'       	=> $result['Email'],
					'Celular'      	=> $cel_format,
//					'Pais'     		=> $result['Pais'],
//					'Estado'   		=> $result['Estado'],
					'Tiempo'     	=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
//					'Grupo'     	=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     		=> $result['Edad'],
					'Categoria'   	=> $result['Categoria'],
				);

//Nombre de la Mascota			
			} else if ($this->request->get['eventos_id'] == 57) {
				
				$id_raza = $this->model_inscripciones_participantes->getRespuestaRazaMascota($result['eventos_participantes_datos'], $this->request->get['eventos_id']);
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Nombre de la Mascota'	=> $this->model_inscripciones_participantes->getRespuestaNombreMascota($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Edad de la Mascota'	=> $this->model_inscripciones_participantes->getRespuestaEdadMascota($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Raza de la Mascota'	=> $this->model_inscripciones_participantes->getRazaMascota($id_raza),
					'Género de la Mascota'	=> $this->model_inscripciones_participantes->getRespuestaGeneroMascota($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 61) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Tipo de Inscripcion'	=> $this->model_inscripciones_participantes->getRespuestaTipoInscripcion61($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 56) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Calendario'			=> $this->model_inscripciones_participantes->getRespuestaCalendario($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 54) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Equipo'				=> $this->model_inscripciones_participantes->getRespuestaEquipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Nombre del Equipo'		=> $this->model_inscripciones_participantes->getRespuestaNombreEquipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 39) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Total'					=> number_format($result['Monto'], 2, ",", ""),
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Edad'     				=> $result['Edad'],
				);

			} else if ($this->request->get['eventos_id'] == 74 || $this->request->get['eventos_id'] == 76) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Acompanante'			=> $this->model_inscripciones_participantes->getRespuestaAcompañante74($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Tipo'					=> $this->model_inscripciones_participantes->getRespuestaEmpleadoTipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 77) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Total'					=> number_format($result['Monto'], 2, ",", ""),
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Malliot'				=> $this->model_inscripciones_participantes->getRespuestaMaillot($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Material'				=> $this->model_inscripciones_participantes->getRespuestaMaterial($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 78) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Total'					=> number_format($result['Monto'], 2, ",", ""),
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Numero Corredor'		=> $this->model_inscripciones_participantes->getRespuestaFoto($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 96) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Total'					=> number_format($result['Monto'], 2, ",", ""),
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Nombre Equipo'			=> $this->model_inscripciones_participantes->getRespuestaNombreEquipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Participantes'			=> $this->model_inscripciones_participantes->getRespuestaParticipantesEquipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Miembro'				=> $this->model_inscripciones_participantes->getRespuestaMiembroEquipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 99) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Total'					=> number_format($result['Monto'], 2, ",", ""),
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Tipo de Inscripcion'	=> $this->model_inscripciones_participantes->getRespuestaTipoInscripcion132($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else if ($this->request->get['eventos_id'] == 107) {
				
				$array_participantes = array(
					'Solicitud'				=> $result['Solicitud'],
					'Pago'					=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Total'					=> number_format($result['Monto'], 2, ",", ""),
					'Planilla'  			=> $result['Planilla'],
					'Deposito'  			=> $result['Deposito'],
					'Fecha'  				=> $result['Fecha'],
					'Numero'				=> $result['Numero'],
					'Cedula'      			=> $result['Cedula'],
					'Empleado'      		=> $result['Empleado'],
					'Apellidos'   			=> $result['Apellidos'],
					'Nombres'				=> $result['Nombres'],
					'Genero'				=> $result['Genero'],
					'Nacimiento'			=> $result['Nacimiento'],
					'Email'       			=> $result['Email'],
					'Celular'      			=> $cel_format,
					'Pais'     				=> $result['Pais'],
					'Estado'   				=> $result['Estado'],
					'Tiempo'     			=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     			=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     				=> $result['Edad'],
					'Categoria'   			=> $result['Categoria'],
					'Material'				=> $this->model_inscripciones_participantes->getRespuestaMaterial($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
					'Tipo'					=> $this->model_inscripciones_participantes->getRespuestaTipo($result['eventos_participantes_datos'], $this->request->get['eventos_id']),
				);

			} else {

				$array_participantes = array(
					'Solicitud'		=> $result['Solicitud'],
					'Pago'			=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  	=> $result['Planilla'],
					'Deposito'  	=> $result['Deposito'],
					'Fecha'  		=> $result['Fecha'],
					'Numero'		=> $result['Numero'],
					'Cedula'      	=> $result['Cedula'],
					'Apellidos'   	=> $result['Apellidos'],
					'Nombres'		=> $result['Nombres'],
					'Genero'		=> $result['Genero'],
					'Nacimiento'	=> $result['Nacimiento'],
					'Email'       	=> $result['Email'],
					'Celular'      	=> $cel_format,
					'Pais'     		=> $result['Pais'],
					'Estado'   		=> $result['Estado'],
					'Tiempo'     	=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     	=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     		=> $result['Edad'],
					'Categoria'   	=> $result['Categoria'],
				);
				
			}

/*
			$opciones_array = $this->model_inscripciones_participantes->getOpcionesParticipantesExport($result['eventos_participantes_datos'], $this->request->get['eventos_id']);
			
			foreach($opciones_array as $opcion) {
				$array_opciones = array (
					$opcion['name'] => $opcion['value'],
				);
			}

			if(isset($array_opciones)) {
				$data_participantes[] = $array_participantes + $array_opciones;
			} else {
				$data_participantes[] = $array_participantes;
			}
*/

			$data_participantes[] = $array_participantes;

		}
		
		/* Enabling Mac compatibility when reading files */
		ini_set('auto_detect_line_endings', true);

		//Converting array to CSV.
		$csv_data = $this->exportCSV($data_participantes, true, ";", "\r\n");

/*
		$userAgent = $_SERVER[HTTP_USER_AGENT];
		$userAgent = strtolower ($userAgent);
// 		($array, $header_row = true, $col_sep = ";", $row_sep = "\n", $qut = '"')
		if(strpos($userAgent, "windows") !== false) {
			//Converting array to CSV.
			$csv_data = $this->exportCSV($data_participantes, true, ";", "\r\n");
		} else if(strpos($userAgent, "linux") !== false) { 
			//Converting array to CSV.
			$csv_data = $this->exportCSV($data_participantes, true, ";", "\n");
		} else {
			//Converting array to CSV.
			$csv_data = $this->exportCSV($data_participantes, true, ";", "\n");
		}
*/

	}
	
	public function exportXLS() {

		/** Error reporting */
		error_reporting(E_ALL);
		
		date_default_timezone_set('Europe/London');
		
		/** PHPExcel */
		require_once(DIR_SYSTEM . 'library/Excel/PHPExcel.php');
		
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Hipereventos Backdoor")
									 ->setLastModifiedBy("Hipereventos Backdoor")
									 ->setTitle("Data de Participantes")
									 ->setSubject("Data de Participantes")
									 ->setDescription("Archivo xls de Participantes generado desde el Backdoor de hipereventos.com.")
									 ->setKeywords("office 2003 openxml php")
									 ->setCategory("Archivo de Participantes");
		
/*		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		
					->setCellValue('A1', 'Número de Solicitud')
					->setCellValue('B1', 'Método de Pago')
					->setCellValue('C1', 'Número de Planila')
					->setCellValue('D1', 'Número de Pago')
					->setCellValue('E1', 'Fecha de Pago')
					->setCellValue('F1', 'Número de Participante')
					->setCellValue('G1', 'Cédula')
					->setCellValue('H1', 'Apellidos')
					->setCellValue('I1', 'Nombres')
					->setCellValue('J1', 'Género')
					->setCellValue('K1', 'Fecha de Nacimiento')
					->setCellValue('L1', 'Correo Electrónico')
					->setCellValue('M1', 'Celular')
					->setCellValue('N1', 'País')
					->setCellValue('O1', 'Estado')
					->setCellValue('P1', 'Grupo')
					->setCellValue('Q1', 'Edad')
					->setCellValue('R1', 'Categoría');
*/		
		// Miscellaneous glyphs, UTF-8
/*
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A4', 'Miscellaneous glyphs')
					->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
*/
		
		$this->load->model('inscripciones/participantes');
		$this->load->model('localidad/pais');
		$this->load->model('localidad/estado');
		
		$results = $this->model_inscripciones_participantes->getParticipantesExport($this->request->get['eventos_id']);

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
			
			if ($this->request->get['eventos_id'] == 21) {
				
				$array_participantes = array(
					'Solicitud'		=> $result['Solicitud'],
					'Pago'			=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  	=> $result['Planilla'],
					'Deposito'  	=> $result['Deposito'],
					'Fecha'  		=> $result['Fecha'],
					'Numero'		=> $result['Numero'],
					'Cedula'      	=> $result['Cedula'],
					'Empleado'      => $result['Empleado'],
					'Apellidos'   	=> $result['Apellidos'],
					'Nombres'		=> $result['Nombres'],
					'Genero'		=> $result['Genero'],
					'Nacimiento'	=> $result['Nacimiento'],
					'Email'       	=> $result['Email'],
					'Celular'      	=> $cel_format,
					'Pais'     		=> $result['Pais'],
					'Estado'   		=> $result['Estado'],
					'Tiempo'     	=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     	=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     		=> $result['Edad'],
					'Categoria'   	=> $result['Categoria'],
					'Talla'			=> $this->model_inscripciones_participantes->getRespuestaTalla($result['eventos_participantes_datos']),
					'Acompañante'	=> $this->model_inscripciones_participantes->getRespuestaAcompañante($result['eventos_participantes_datos']),
					'Transporte'	=> $this->model_inscripciones_participantes->getRespuestaTransporte($result['eventos_participantes_datos']),
					'Ciudad'		=> $this->model_inscripciones_participantes->getRespuestaCiudad($result['eventos_participantes_datos']),
				);
				
			} else {

				$array_participantes = array(
					'Solicitud'		=> $result['Solicitud'],
					'Pago'			=> ($result['Pago'] == '') ? 'Transcrita' : $result['Pago'],
					'Planilla'  	=> $result['Planilla'],
					'Deposito'  	=> $result['Deposito'],
					'Fecha'  		=> $result['Fecha'],
					'Numero'		=> $result['Numero'],
					'Cedula'      	=> $result['Cedula'],
					'Apellidos'   	=> $result['Apellidos'],
					'Nombres'		=> $result['Nombres'],
					'Genero'		=> $result['Genero'],
					'Nacimiento'	=> $result['Nacimiento'],
					'Email'       	=> $result['Email'],
					'Celular'      	=> $cel_format,
					'Pais'     		=> $result['Pais'],
					'Estado'   		=> $result['Estado'],
					'Tiempo'     	=> (isset($result['Tiempo'])) ? $result['Tiempo'] : '',
					'Grupo'     	=> (isset($result['Grupo'])) ? $result['Grupo'] : '',
					'Edad'     		=> $result['Edad'],
					'Categoria'   	=> $result['Categoria'],
				);
				
			}
			
/*
			$opciones_array = $this->model_inscripciones_participantes->getOpcionesParticipantesExport($result['eventos_participantes_datos']);
			
			foreach($opciones_array as $opcion) {
				$array_opciones = array (
					$opcion['name'] => $opcion['value'],
				);
			}
*/			
//			if(isset($array_opciones)) {
//				$data_participantes[] = $array_participantes + $array_opciones;
//			} else {
				$data_participantes[] = $array_participantes;
//			}

		}

		if ($this->request->get['eventos_id'] == 21) {

			$array_titulos = array('Solicitud', 'Pago', 'Planilla', 'Deposito', 'Fecha', 'Numero', 'Cedula', 'Empleado', 'Apellidos', 'Nombres', 'Genero', 'Nacimiento', 'Email', 'Celular', 'Pais', 'Estado', 'Tiempo', 'Grupo', 'Edad', 'Categoria', 'Talla', 'Acompañante', 'Transporte', 'Ciudad');
			
		} else {
			
			$array_titulos = array('Solicitud', 'Pago', 'Planilla', 'Deposito', 'Fecha', 'Numero', 'Cedula', 'Apellidos', 'Nombres', 'Genero', 'Nacimiento', 'Email', 'Celular', 'Pais', 'Estado', 'Tiempo', 'Grupo', 'Edad', 'Categoria');
			
		}
			
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Participantes');
		$objPHPExcel->getActiveSheet()->fromArray($array_titulos, null, 'A1');		
		$objPHPExcel->getActiveSheet()->fromArray($data_participantes, null, 'A2');		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client's web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="data_participantes_' . $this->request->get['eventos_id'] . '.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;

	}
	
	public function info() {
		$this->load->model('inscripciones/participantes');
		$this->load->model('catalog/transcripcion');
		$this->load->model('catalog/evento');
		$this->load->model('localidad/pais');
		$this->load->model('localidad/estado');

		if (isset($this->request->get['eventos_participantes_id'])) {
			$participantes_id = $this->request->get['eventos_participantes_id'];
		} else {
			$participantes_id = 0;
		}

		$participante_info = $this->model_inscripciones_participantes->getDatosParticipante($participantes_id);
		
		$this->data['order_info'] = $participante_info;

		if ($participante_info) {
			$this->load->idioma('sale/participantes');

			$eventos_id = $participante_info['Evento'];

			$this->document->setTitle($this->idioma->get('heading_title'));

			$this->data['heading_title'] = $this->idioma->get('heading_title');
			
			$this->data['text_order_id'] = $this->idioma->get('text_order_id');
			$this->data['text_customer_id'] = $this->idioma->get('text_customer_id');
			$this->data['text_number'] = $this->idioma->get('text_number');
			$this->data['text_firstname'] = $this->idioma->get('text_firstname');
			$this->data['text_lastname'] = $this->idioma->get('text_lastname');
			$this->data['text_gender'] = $this->idioma->get('text_gender');
			$this->data['text_date_birth'] = $this->idioma->get('text_date_birth');
			$this->data['text_email'] = $this->idioma->get('text_email');
			$this->data['text_cel'] = $this->idioma->get('text_cel');
			$this->data['text_country'] = $this->idioma->get('text_country');
			$this->data['text_zone'] = $this->idioma->get('text_zone');
			$this->data['text_group'] = $this->idioma->get('text_group');
			$this->data['text_time'] = $this->idioma->get('text_time');
			$this->data['text_range'] = $this->idioma->get('text_range');
			$this->data['text_age'] = $this->idioma->get('text_age');
			$this->data['text_category'] = $this->idioma->get('text_category');
						
			$this->data['entry_order_status'] = $this->idioma->get('entry_order_status');
			$this->data['entry_notify'] = $this->idioma->get('entry_notify');
			$this->data['entry_comment'] = $this->idioma->get('entry_comment');
			
			$this->data['button_cancel'] = 'Cancelar';
			$this->data['button_save'] = 'Guardar';		
		
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}
	
			if (isset($this->error['cedula'])) {
				$this->data['error_cedula'] = $this->error['cedula'];
			} else {
				$this->data['error_cedula'] = array();
			}
	
			if (isset($this->error['apellido'])) {
				$this->data['error_apellido'] = $this->error['apellido'];
			} else {
				$this->data['error_apellido'] = array();
			}
	
			if (isset($this->error['nombre'])) {
				$this->data['error_nombre'] = $this->error['nombre'];
			} else {
				$this->data['error_nombre'] = array();
			}
	
			if (isset($this->error['genero'])) {
				$this->data['error_genero'] = $this->error['genero'];
			} else {
				$this->data['error_genero'] = array();
			}
	
			if (isset($this->error['fdn'])) {
				$this->data['error_fdn'] = $this->error['fdn'];
			} else {
				$this->data['error_fdn'] = array();
			}
	
	/*
			if (isset($this->error['email'])) {
				$this->data['error_email'] = $this->error['email'];
			} else {
				$this->data['error_email'] = array();
			}
	
			if (isset($this->error['cel'])) {
				$this->data['error_cel'] = $this->error['cel'];
			} else {
				$this->data['error_cel'] = array();
			}
	*/
	
			if (isset($this->error['pais'])) {
				$this->data['error_pais'] = $this->error['pais'];
			} else {
				$this->data['error_pais'] = array();
			}
	
			if (isset($this->error['estado'])) {
				$this->data['error_estado'] = $this->error['estado'];
			} else {
				$this->data['error_estado'] = array();
			}
	
			if (isset($this->error['grupo'])) {
				$this->data['error_grupo'] = $this->error['grupo'];
			} else {
				$this->data['error_grupo'] = array();
			}
	
			if (isset($this->error['edad'])) {
				$this->data['error_edad'] = $this->error['edad'];
			} else {
				$this->data['error_edad'] = array();
			}
	
			if (isset($this->error['categoria'])) {
				$this->data['error_categoria'] = $this->error['categoria'];
			} else {
				$this->data['error_categoria'] = array();
			}

			$this->data['token'] = $this->session->data['token'];

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => 'Inicio',
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->idioma->get('heading_title'),
				'href'      => $this->url->link('sale/participantes', 'token=' . $this->session->data['token'], 'SSL'),				
				'separator' => ' :: '
			);

			$this->data['cancel'] = $this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $eventos_id, 'SSL');
			$this->data['action'] = $this->url->link('sale/participantes/update', 'token=' . $this->session->data['token'] . '&eventos_participantes_id=' . $this->request->get['eventos_participantes_id'], 'SSL');

			$this->data['eventos_id'] = $eventos_id;
			$this->data['eventos_edad_calendario'] = $this->model_catalog_evento->getEventoEdadCalendario($eventos_id);
			$this->data['eventos_descripcion_numeracion_id_tipo'] = $this->model_catalog_evento->getEventoTipoNumeracion($eventos_id);
			$this->data['paises'] = $this->model_localidad_pais->getPaises();
			$this->data['estados'] = $this->model_localidad_estado->getEstadosByPaisId($participante_info['Pais']);

			$numeracion = $this->model_catalog_evento->getEventoTipoNumeracion($eventos_id);

			if($numeracion == 3) { // Tiempos = 3
				$this->data['rangos'] = $this->model_catalog_evento->getIntervalosTiempo($eventos_id);
			}

			$this->data['categorias_opcionales'] = $this->model_catalog_transcripcion->getCategoriasOpcionales($eventos_id);
			$this->data['grupos_totales'] = $this->model_catalog_transcripcion->getTotalGrupos($eventos_id);
			$this->data['grupos_categorias'] = $this->model_catalog_transcripcion->getGrupos($eventos_id);
			
			$gc = $this->model_catalog_transcripcion->getGrupos($eventos_id);
	
			foreach ($gc as $gru) {
				$this->data['categorias_masculinas'] = $this->model_catalog_transcripcion->getCategoriasByParametros($eventos_id, $gru['eventos_categorias_grupo'], 'masculino', 'standard');
				$this->data['categorias_femeninas'] = $this->model_catalog_transcripcion->getCategoriasByParametros($eventos_id, $gru['eventos_categorias_grupo'], 'femenino', 'standard');
				$this->data['categorias_masculinas_op'] = $this->model_catalog_transcripcion->getCategoriasByParametros($eventos_id, $gru['eventos_categorias_grupo'], 'masculino', 'opcional');
				$this->data['categorias_femeninas_op'] = $this->model_catalog_transcripcion->getCategoriasByParametros($eventos_id, $gru['eventos_categorias_grupo'], 'femenino', 'opcional');
			}
	
			$this->data['numeros_reservados'] = $this->model_catalog_transcripcion->getNumerosReservadosByEvento($eventos_id);
	
			$this->data['categoria_info'] = $this->model_catalog_transcripcion->getCategoriasByEvento($eventos_id);
	
			$this->data['categorias'] = $this->model_catalog_transcripcion->getCategoriasDescripcionByEvento($eventos_id);

			$this->data['eventos_participantes_id'] = $this->request->get['eventos_participantes_id'];
			$this->data['eventos_participantes_id_pedido'] = $participante_info['Solicitud'];
			$this->data['payment_method'] = $participante_info['Pago'];
			$this->data['payment_number'] = $participante_info['Deposito'];
			$this->data['eventos_participantes_numero'] = $participante_info['Numero'];
			$this->data['eventos_participantes_cedula'] = $participante_info['Cedula'];
			$this->data['eventos_participantes_apellidos'] = $participante_info['Apellidos'];
			$this->data['eventos_participantes_nombres'] = $participante_info['Nombres'];
			$this->data['eventos_participantes_genero'] = $participante_info['Genero'];
			$this->data['eventos_participantes_fdn'] = $participante_info['Nacimiento'];
			$this->data['eventos_participantes_email'] = $participante_info['Email'];
			$this->data['eventos_participantes_cel'] = $participante_info['Celular'];
			$this->data['eventos_participantes_id_pais'] = $participante_info['Pais'];
			$this->data['eventos_participantes_pais'] = $this->model_localidad_pais->getPaisByCodigo($participante_info['Pais']);
			$this->data['eventos_participantes_id_estado'] = $participante_info['Estado'];
			$this->data['eventos_participantes_estado'] = $this->model_localidad_estado->getEstadoByCodigo($participante_info['Estado']);
			$this->data['eventos_participantes_grupo'] = $participante_info['Grupo'];
			$this->data['eventos_participantes_tiempo'] = $participante_info['Tiempo'];
			$this->data['eventos_participantes_edad'] = $participante_info['Edad'];
			$this->data['eventos_participantes_categoria'] = $participante_info['Categoria'];
			$this->data['eventos_participantes_datos'] = $participante_info['Datos'];

			$this->template = 'sale/participantes_info.tpl';
			$this->children = array(
				'common/header',
				'common/footer',
			);
			
			$this->response->setOutput($this->render());

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
	
  	public function delete() {
		$this->load->idioma('sale/participantes');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');

		$id_evento = $this->request->get['eventos_id'];

    	if (isset($this->request->post['selected']) && ($this->validateDelete())) {
			foreach ($this->request->post['selected'] as $participante_id) {
				$this->model_inscripciones_participantes->deleteParticipante($participante_id);
			}

			$this->session->data['success'] = $this->idioma->get('text_success');

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
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento . $url, 'SSL'));
			
    	}

		$this->getForm();
  	}

	public function update() {
		
		$this->load->idioma('sale/participantes');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		$this->load->model('inscripciones/numeros');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$id_evento = $this->request->post['eventos_id'];
			$cedula = $this->request->post['eventos_participantes_cedula'];
			$numero = $this->request->post['eventos_participantes_numero'];
			$categoria = $this->request->post['eventos_participantes_categoria'];
			$tiempo = (isset($this->request->post['eventos_participantes_tiempo'])) ? $this->request->post['eventos_participantes_tiempo'] : '';
			$grupo = (isset($this->request->post['eventos_participantes_grupo'])) ? $this->request->post['eventos_participantes_grupo'] : '';
			$solicitud = $this->request->post['eventos_participantes_id_pedido'];
			$datos = $this->request->post['participante_datos'];
			$grupo_prev = $this->request->post['grupo_prev'];
			$tiempo_prev = $this->request->post['tiempo_prev'];
//			$rango = $this->request->post['eventos_participantes_rango'];

			$this->model_inscripciones_participantes->editParticipante($this->request->get['eventos_participantes_id'], $this->request->post);

			if ($grupo_prev != $grupo) {
	
				$this->model_inscripciones_participantes->liberarNumero($cedula, $id_evento, $numero);

				$numero_nuevo = $this->model_inscripciones_numeros->getNumero($id_evento, $cedula, $categoria, $tiempo, $grupo);

				$this->model_inscripciones_participantes->update($cedula, $solicitud, $id_evento, $numero_nuevo, $datos);

			} else if ($tiempo_prev != $tiempo) {
				
				$this->model_inscripciones_participantes->liberarNumero($cedula, $id_evento, $numero);

				$numero_nuevo = $this->model_inscripciones_numeros->getNumero($id_evento, $cedula, $categoria, $tiempo, $grupo);

				$this->model_inscripciones_participantes->update($cedula, $solicitud, $id_evento, $numero_nuevo, $datos);

			}

			$this->session->data['success'] = '&Eacute;xito: ¡Usted ha modificado los participantes del evento!';
			
			$this->redirect($this->url->link('sale/participantes/consulta', 'token=' . $this->session->data['token'] . '&eventos_id=' . $id_evento, 'SSL'));

		}

//		$this->url->link('sale/participantes/info', 'token=' . $this->session->data['token'] . '&eventos_participantes_id=' . $result['eventos_participantes_id'] . $url, 'SSL');
		
		$this->info();
	}

  	private function validateForm() { 

		$this->load->model('catalog/evento');

    	if (!$this->user->hasPermission('modify', 'sale/participantes')) {
      		$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los participantes!';
    	}

		if ((strlen(utf8_decode($this->request->post['eventos_participantes_apellidos'])) < 2) || (strlen(utf8_decode($this->request->post['eventos_participantes_apellidos'])) > 48)) {
			$this->error['apellido'] = '¡El apellido debe tener entre 2 y 48 caractéres!';
		}

		if ((strlen(utf8_decode($this->request->post['eventos_participantes_nombres'])) < 2) || (strlen(utf8_decode($this->request->post['eventos_participantes_nombres'])) > 48)) {
			$this->error['nombre'] = '¡El nombre debe tener entre 2 y 48 caractéres!';
		}

		if ($this->request->post['eventos_participantes_genero'] == '') {
			$this->error['genero'] = '¡Debe seleccionar el genero!';
		}

		if ((strlen(utf8_decode($this->request->post['eventos_participantes_fdn'])) != 10)) {
			$this->error['fdn'] = '¡La fecha de nacimiento debe tener 10 caractéres (aaaa-mm-dd)!';
		} else {
			if (!ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $this->request->post['eventos_participantes_fdn'])) {	
				$this->error['fdn'] = '¡El formato de la fecha de nacimiento es inválido!';
			}
		}

		if ((strlen(utf8_decode($this->request->post['eventos_participantes_id_pais'])) == 0)) {
			$this->error['pais'] = '¡Debe seleccionar el país!';
		}

		if ((strlen(utf8_decode($this->request->post['eventos_participantes_id_estado'])) == 0)) {
			$this->error['estado'] = '¡Debe seleccionar el estado!';
		}

		$eventos_id = $this->request->post['eventos_id'];
		$numeracion = $this->model_catalog_evento->getEventoTipoNumeracion($eventos_id);

		if($numeracion == 1) { // Grupos = 1

			if ($this->request->post['eventos_participantes_grupo'] == '--Grupo--') {
				$this->error['grupo'] = '¡Debe seleccionar el grupo!';
			}

		}

		if($numeracion == 3) { // Tiempos = 3

			if ((strlen(utf8_decode($this->request->post['eventos_participantes_tiempo'])) == 0)) {
				$this->error['tiempo'] = '¡El tiempo no puede estar en blanco!';
			}

		}

		if ($this->request->post['eventos_participantes_edad'] == 0) {
			$this->error['edad'] = '¡La edad no puede ser 0!';
		}

		if ((strlen(utf8_decode($this->request->post['eventos_participantes_categoria'])) == 0)) {
			$this->error['categoria'] = '¡La categoría no puede estar en blanco!';
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Advertencia: ¡Por favor verifique la informaci&oacute;n!';
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
		
  	}

	public function edad() {
		$json = array();
		
		if (isset($this->request->get['fdn']) && isset($this->request->get['anio_calendario'])) {

			$fdn = $this->request->get['fdn'];
			$anio_calendario = $this->request->get['anio_calendario'];
			
			if ($anio_calendario) {
				
				list($anio_fdn,$mes_fdn,$dia_fdn) = explode("-",$fdn);
				$anio_actual = (int)date('Y');
				$edad = $anio_actual - $anio_fdn;
				
			} else { 
			
				list($anio_fdn,$mes_fdn,$dia_fdn) = explode("-",$fdn);
				$anio_diferencia  = date("Y") - $anio_fdn;
				$mes_diferencia = date("m") - $mes_fdn;
				$dia_diferencia   = date("d") - $dia_fdn;

				if ($dia_diferencia < 0 || $mes_diferencia < 0) {
//				if ($dia_diferencia < 0 && $mes_diferencia <= 0) {

					$anio_diferencia--;

				}

				$edad = $anio_diferencia;
				
			}
			
			$json['edad'] = $edad;
			
				
		} else {
			
			$json['error'] = 'Debe colocar la Fecha de su Nacimiento.';
		
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));

	}
	
}
?>
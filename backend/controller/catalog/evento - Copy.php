<?php 
class ControllerCatalogEvento extends Controller {
	private $error = array(); 
     
  	public function index() {
		    	
		$this->document->setTitle('Eventos'); 
		
		$this->load->model('catalog/evento');
		
		$this->getList();
  	}
  
  	public function insert() {
    	
    	$this->document->setTitle('Eventos'); 
		
		$this->load->model('catalog/evento');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_evento->addEvento($this->request->post);
	  		
			$this->session->data['success'] = 'Usted ha modificado los eventos!';
	  
			$url = '';
			
			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}
		
			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
			}
			
			if (isset($this->request->get['filter_eventos_precio'])) {
				$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
			}
			
			if (isset($this->request->get['filter_eventos_cupos_internet'])) {
				$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
			}
			
			if (isset($this->request->get['filter_eventos_status'])) {
				$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
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
			
			$this->redirect($this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	

    	$this->document->setTitle('Eventos');
		
		$this->load->model('catalog/evento');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$id_evento = $this->request->get['eventos_id'];
			
			$this->model_catalog_evento->editEvento($this->request->get['eventos_id'], $this->request->post);

			if (isset($this->request->files['ranking_carga']['tmp_name'])) {
				if (is_uploaded_file($this->request->files['ranking_carga']['tmp_name'])) {
					
					$filename = 'ranking_' . $id_evento . '.pdf';
	
					move_uploaded_file($this->request->files['ranking_carga']['tmp_name'], DIR_DOWNLOAD . $filename);
					
					if (file_exists(DIR_DOWNLOAD . $filename)) {
						$contenido = $filename;
						$this->model_catalog_evento->updateRankingEvento($this->request->get['eventos_id'], $contenido);
					}
				
				}
			}

			if (isset($this->request->files['numeracion_tiempos_carga']['tmp_name'])) {
				if (is_uploaded_file($this->request->files['numeracion_tiempos_carga']['tmp_name'])) {
					
					$filename = 'tiempos_previos.csv';
	
					move_uploaded_file($this->request->files['numeracion_tiempos_carga']['tmp_name'], DIR_UPLOAD . $filename);
					
					if (file_exists(DIR_UPLOAD . $filename)) {
						$contenido = DIR_UPLOAD . $filename;
						$this->model_catalog_evento->importarNumeracionEvento($this->request->get['eventos_id'], $contenido);
					}
				
				}
			}
			
			if (isset($this->request->files['circuito_carga']['tmp_name'])) {
				if (is_uploaded_file($this->request->files['circuito_carga']['tmp_name'])) {
					
					$filename = 'historial_circuito.csv';
	
					move_uploaded_file($this->request->files['circuito_carga']['tmp_name'], DIR_UPLOAD . $filename);
					
					if (file_exists(DIR_UPLOAD . $filename)) {
						$contenido = DIR_UPLOAD . $filename;
						$this->model_catalog_evento->importarCircuitoEvento($this->request->get['eventos_id'], $contenido);
					}
				
				}
			}
			
			$this->session->data['success'] = 'Usted ha modificado los eventos!';
			
			$url = '';
			
			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}
		
			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
			}
			
			if (isset($this->request->get['filter_eventos_precio'])) {
				$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
			}
			
			if (isset($this->request->get['filter_eventos_cupos_internet'])) {
				$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
			}	
		
			if (isset($this->request->get['filter_eventos_status'])) {
				$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
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
			
			$this->redirect($this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	

    	$this->document->setTitle('Eventos');
		
		$this->load->model('catalog/evento');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $eventos_id) {
				$this->model_catalog_evento->deleteEvento($eventos_id);
	  		}

			$this->session->data['success'] = 'Usted ha modificado los eventos!';
			
			$url = '';
			
			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}
		
			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
			}
			
			if (isset($this->request->get['filter_eventos_precio'])) {
				$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
			}
			
			if (isset($this->request->get['filter_eventos_cupos_internet'])) {
				$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
			}	
		
			if (isset($this->request->get['filter_eventos_status'])) {
				$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
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
			
			$this->redirect($this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function copy() {
    	

    	$this->document->setTitle('Eventos');
		
		$this->load->model('catalog/evento');
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $eventos_id) {
				$this->model_catalog_evento->copyEvento($eventos_id);
	  		}

			$this->session->data['success'] = 'Usted ha modificado los eventos!';
			
			$url = '';
			
			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}
		
			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
			}
			
			if (isset($this->request->get['filter_eventos_precio'])) {
				$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
			}
			
			if (isset($this->request->get['filter_eventos_cupos_internet'])) {
				$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
			}	
		
			if (isset($this->request->get['filter_eventos_status'])) {
				$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
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
			
			$this->redirect($this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	private function getList() {				
		if (isset($this->request->get['filter_eventos_titulo'])) {
			$filter_eventos_titulo = $this->request->get['filter_eventos_titulo'];
		} else {
			$filter_eventos_titulo = null;
		}

		if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
			$filter_eventos_tipos_nombre = $this->request->get['filter_eventos_tipos_nombre'];
		} else {
			$filter_eventos_tipos_nombre = null;
		}
		
		if (isset($this->request->get['filter_eventos_precio'])) {
			$filter_eventos_precio = $this->request->get['filter_eventos_precio'];
		} else {
			$filter_eventos_precio = null;
		}

		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$filter_eventos_cupos_internet = $this->request->get['filter_eventos_cupos_internet'];
		} else {
			$filter_eventos_cupos_internet = null;
		}

		if (isset($this->request->get['filter_eventos_status'])) {
			$filter_eventos_status = $this->request->get['filter_eventos_status'];
		} else {
			$filter_eventos_status = null;
		}

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
						
		if (isset($this->request->get['filter_eventos_titulo'])) {
			$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
		}
		
		if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
			$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
		}
		
		if (isset($this->request->get['filter_eventos_precio'])) {
			$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
		}
		
		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}		

		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
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
       		'text'      => 'Eventos',
			'href'      => $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('catalog/evento/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('catalog/evento/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('catalog/evento/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['eventos'] = array();

		$data = array(
			'filter_eventos_titulo'	  		=> $filter_eventos_titulo, 
			'filter_eventos_tipos_nombre'	=> $filter_eventos_tipos_nombre,
			'filter_eventos_precio'	  		=> $filter_eventos_precio,
			'filter_eventos_cupos_internet'	=> $filter_eventos_cupos_internet,
			'filter_eventos_status'   		=> $filter_eventos_status,
			'sort'            				=> $sort,
			'order'           				=> $order,
			'start'           				=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           				=> $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');
		
		$evento_total = $this->model_catalog_evento->getTotalEventos($data);
			
		$results = $this->model_catalog_evento->getEventos($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Editar',
				'href' => $this->url->link('catalog/evento/update', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			if ($result['eventos_logo'] && file_exists(DIR_IMAGE . $result['eventos_logo'])) {
				$image = $this->model_tool_image->resize($result['eventos_logo'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
	
      		$this->data['eventos'][] = array(
				'eventos_id' 				=> $result['eventos_id'],
				'eventos_titulo'       		=> $result['eventos_titulo'],
				'eventos_tipo_nombre'      	=> $this->model_catalog_evento->getTipo($result['eventos_id']),
				'eventos_precio'      		=> $result['eventos_precio'],
				'eventos_logo'      		=> $image,
				'eventos_cupos_apertura'	=> $result['eventos_cupos_apertura'],
				'eventos_cupos_internet'	=> $result['eventos_cupos_internet'],
				'eventos_status'     		=> ($result['eventos_status'] ? 'Habilitado' : 'Deshabilitado'),
				'eventos_inscripciones'     => ($result['eventos_inscripciones'] ? 'Habilitado' : 'Deshabilitado'),
				'selected'   				=> isset($this->request->post['selected']) && in_array($result['eventos_id'], $this->request->post['selected']),
				'action'     				=> $action
			);
    	}
		
		$this->data['heading_title'] = 'Eventos';		
				
		$this->data['text_enabled'] = 'Habilitado';		
		$this->data['text_disabled'] = 'Deshabilitado';		
		$this->data['text_no_results'] = 'Sin resultados';		
		$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';		
			
		$this->data['column_image'] = 'Im&aacute;gen';		
		$this->data['column_eventos_titulo'] = 'Nombre del Evento';		
		$this->data['column_eventos_tipos_nombre'] = 'Tipo';		
		$this->data['column_eventos_precio'] = 'Costo de Inscripci&oacute;n';		
		$this->data['column_eventos_cupos_internet'] = 'Cupos de Apertura';		
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

		if (isset($this->request->get['filter_eventos_titulo'])) {
			$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
		}
		
		if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
			$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
		}
		
		if (isset($this->request->get['filter_eventos_precio'])) {
			$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
		}
		
		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}
		
		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_eventos_titulo'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_titulo' . $url, 'SSL');
		$this->data['sort_eventos_privado'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_privado' . $url, 'SSL');
		$this->data['sort_eventos_tipos_nombre'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_tipos_nombre' . $url, 'SSL');
		$this->data['sort_eventos_precio'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_precio' . $url, 'SSL');
		$this->data['sort_eventos_cupos_internet'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_cupos_internet' . $url, 'SSL');
		$this->data['sort_eventos_status'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_eventos_status' . $url, 'SSL');
		$this->data['sort_eventos_orden'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_orden' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_eventos_titulo'])) {
			$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
		}
		
		if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
			$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
		}
		
		if (isset($this->request->get['filter_eventos_precio'])) {
			$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
		}
		
		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}

		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $evento_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_eventos_titulo'] = $filter_eventos_titulo;
		$this->data['filter_eventos_tipos_nombre'] = $filter_eventos_tipos_nombre;
		$this->data['filter_eventos_precio'] = $filter_eventos_precio;
		$this->data['filter_eventos_cupos_internet'] = $filter_eventos_cupos_internet;
		$this->data['filter_eventos_status'] = $filter_eventos_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/evento_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
    	$this->data['heading_title'] = 'Eventos';
 
    	$this->data['text_enabled'] = 'Habilitado';
    	$this->data['text_disabled'] = 'Deshabilitado';
    	$this->data['text_none'] = ' --- Ninguno --- ';
    	$this->data['text_yes'] = 'Si';
    	$this->data['text_no'] = 'No';
		$this->data['text_select_all'] = 'Seleccionar Todos';
		$this->data['text_unselect_all'] = 'Seleccionar Ninguno';
		$this->data['text_plus'] = '+';
		$this->data['text_minus'] = '-';
		$this->data['text_default'] = ' <b>(Predeterminado)</b>';
		$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';
		$this->data['text_opcion'] = 'Opci&oacute;n';
		$this->data['text_opcion_valor'] = 'Valor Opci&oacute;n';
		$this->data['text_select'] = ' --- Seleccione --- ';
		$this->data['text_none'] = ' --- Ninguno --- ';
		$this->data['text_percent'] = 'Porcentaje';
		$this->data['text_amount'] = 'Cantidad Arreglada';

		$this->data['entry_eventos_status'] = 'Status:';
		$this->data['entry_eventos_inscripciones'] = 'Inscripciones:';
    	$this->data['entry_eventos_fecha_disponible'] = 'Fecha Disponible:';
    	$this->data['entry_eventos_tipo'] = 'Tipo de Evento:';
		$this->data['entry_eventos_orden'] = 'Orden:';
		$this->data['entry_eventos_privado'] = 'Evento Privado:';
		$this->data['entry_eventos_titulo'] = 'Nombre del Evento:';
    	$this->data['entry_eventos_fecha'] = 'Fecha del Evento:';
    	$this->data['entry_eventos_hora'] = 'Hora del Evento:';
    	$this->data['entry_eventos_lugar'] = 'Lugar del Evento:';
    	$this->data['entry_eventos_precio'] = 'Costo de Inscripci&oacute;n:';
    	$this->data['entry_eventos_impuesto'] = 'Impuesto:';
    	$this->data['entry_eventos_cupos_apertura'] = 'Cupos de apertura:';
    	$this->data['entry_eventos_cupos'] = 'Cupos para Internet:';
    	$this->data['entry_eventos_afiche'] = 'Mostrar Afiche:';
    	$this->data['entry_eventos_redireccion'] = 'Redireccionar a URL del Evento:';
    	$this->data['entry_eventos_redireccion_url'] = 'URL del Evento:';
		$this->data['entry_meta_description'] = 'Meta Tag Description:';
		$this->data['entry_meta_keyword'] = 'Meta Tag Keywords:';
    	$this->data['entry_eventos_descripcion_resultados_url'] = 'URL de Resultados:';
    	$this->data['entry_eventos_descripcion_cedula'] = 'Permitir Inscritos Sin C&eacute;dula:';
    	$this->data['entry_eventos_ranking'] = 'Cargar Archivo de Ranking (PDF):';
    	$this->data['entry_eventos_circuito'] = 'Cargar Archivo de Circuito (CSV):';
    	$this->data['entry_eventos_descripcion_club'] = 'Permitir Inscritos por Club:';
    	$this->data['entry_eventos_descripcion_tallas'] = 'Permitir Selecci&oacute;n de Tallas:';
    	$this->data['entry_eventos_descripcion_circuito'] = 'Permitir Record de Circuito:';
    	$this->data['entry_eventos_descripcion_numeracion_id_tipo'] = 'Tipo de Numeraci&oacute;n:';
		$this->data['entry_eventos_descripcion_info'] = 'Informaci&oacute;n General:';
		$this->data['entry_eventos_descripcion_reglamento'] = 'Informaci&oacute;n de Reglamento:';
		$this->data['entry_eventos_descripcion_premiacion'] = 'Informaci&oacute;n de Premiaci&oacute;n:';
		$this->data['entry_eventos_descripcion_ruta'] = 'Informaci&oacute;n de Ruta:';
		$this->data['entry_eventos_descripcion_inscripciones_online'] = 'Informaci&oacute;n de Inscripci&oacute;n Online:';
		$this->data['entry_eventos_descripcion_inscripciones_tiendas'] = 'Informaci&oacute;n de Inscripci&oacute;n en Tiendas:';
		$this->data['entry_eventos_descripcion_materiales'] = 'Informaci&oacute;n de Materiales:';
		$this->data['entry_eventos_descripcion_responsabilidad'] = 'Liberaci&oacute;n de Responsabilidad:';
    	$this->data['entry_eventos_logo'] = 'Logotipo del Evento:';
    	$this->data['entry_eventos_imagen_home'] = 'Im&aacute;gen del Evento (Home):';
    	$this->data['entry_eventos_imagen_header'] = 'Im&aacute;gen del Evento (Header):';
    	$this->data['entry_eventos_imagen_afiche'] = 'Im&aacute;gen del Evento (Afiche):';
		$this->data['entry_eventos_patrocinantes'] = 'Patrocinantes del Evento:';
		$this->data['entry_eventos_categorias'] = 'Attribute:';
		$this->data['entry_eventos_categorias_titulo'] = 'Titulo';
		$this->data['entry_eventos_categorias_edad_desde'] = 'Edad Inicial';
		$this->data['entry_eventos_categorias_edad_hasta'] = 'Edad Final';
		$this->data['entry_eventos_categorias_genero'] = 'G&eacute;nero';
		$this->data['entry_eventos_categorias_tipo'] = 'Tipo';
		$this->data['entry_eventos_categorias_grupo'] = 'Grupo';
		$this->data['entry_eventos_numeracion'] = 'Attribute:';
		$this->data['entry_eventos_numeracion_datos_cupos_titulo'] = 'Datos de Cupos';
		$this->data['entry_eventos_numeracion_reserva_nd'] = 'Reservar Numero Desde';
		$this->data['entry_eventos_numeracion_reserva_nh'] = 'Reservar Numero Hasta';
		$this->data['entry_eventos_numeracion_liberar_nd'] = 'Liberar Numero Desde';
		$this->data['entry_eventos_numeracion_liberar_nh'] = 'Liberar Numero Hasta';
		$this->data['entry_eventos_numeracion_datos_cupos_totales'] = 'Cupos Internet Totales';
		$this->data['entry_eventos_numeracion_datos_cupos_utilizados'] = 'Cupos Internet Utilizados';
		$this->data['entry_eventos_numeracion_datos_cupos_confirmados'] = 'Cupos Internet Confirmados';
		$this->data['entry_eventos_numeracion_datos_cupos_no_confirmados'] = 'Cupos Internet Sin Confirmar';
		$this->data['entry_eventos_numeracion_datos_cupos_disponibles'] = 'Cupos Internet Disponibles';
		$this->data['entry_eventos_numeracion_datos_cupos_tiendas'] = 'Cupos Utilizados por Tiendas';
		$this->data['entry_eventos_numeracion_tiempos_carga_titulo'] = 'Importar Tiempos Previos';
		$this->data['entry_eventos_numeracion_tiempos_carga_descripcion'] = 'Seleccione el archivo que contiene los datos de tiempos';
		$this->data['entry_eventos_numeracion_tiempos_datos_titulo'] = 'Datos de Int&eacute;rvalos';
		$this->data['entry_eventos_numeracion_tiempos_datos_precargados'] = 'Total de Participantes con Int&eacute;rvalos Precargados';
		$this->data['entry_eventos_numeracion_tiempos_datos_totales'] = 'N&uacute;meros Totales';
		$this->data['entry_eventos_numeracion_tiempos_datos_utilizados'] = 'N&uacute;meros Utilizados';
		$this->data['entry_eventos_numeracion_tiempos_datos_disponibles'] = 'N&uacute;meros Disponibles';
		$this->data['entry_eventos_numeracion_tiempos_datos_reservados'] = 'N&uacute;meros Reservados';
		$this->data['entry_eventos_numeracion_tiempos_ti'] = 'Tiempo Inicial';
		$this->data['entry_eventos_numeracion_tiempos_tf'] = 'Tiempo Final';
		$this->data['entry_eventos_numeracion_tiempos_ni'] = 'N&uacute;mero Inicial';
		$this->data['entry_eventos_numeracion_tiempos_cn'] = 'Cantidad de N&uacute;meros';
		$this->data['entry_eventos_numeracion_grupos_datos_totales'] = 'N&uacute;meros Totales';
		$this->data['entry_eventos_numeracion_grupos_datos_utilizados'] = 'N&uacute;meros Utilizados';
		$this->data['entry_eventos_numeracion_grupos_datos_disponibles'] = 'N&uacute;meros Disponibles';
		$this->data['entry_eventos_numeracion_grupos_datos_reservados'] = 'N&uacute;meros Reservados';
		$this->data['entry_eventos_numeracion_grupos_g'] = 'Grupo';
		$this->data['entry_eventos_numeracion_grupos_ni'] = 'N&uacute;mero Inicial';
		$this->data['entry_eventos_numeracion_grupos_cn'] = 'Cantidad de N&uacute;meros';
		$this->data['entry_eventos_numeracion_estandar_datos_totales'] = 'N&uacute;meros Totales';
		$this->data['entry_eventos_numeracion_estandar_datos_utilizados'] = 'N&uacute;meros Utilizados';
		$this->data['entry_eventos_numeracion_estandar_datos_disponibles'] = 'N&uacute;meros Disponibles';
		$this->data['entry_eventos_numeracion_estandar_datos_reservados'] = 'N&uacute;meros Reservados';
		$this->data['entry_eventos_numeracion_estandar_ni'] = 'N&uacute;mero Inicial';
		$this->data['entry_eventos_numeracion_estandar_cn'] = 'Cantidad de N&uacute;meros';

		$this->data['entry_opcion'] = 'Opci&oacute;n';
		$this->data['entry_opcion_valor'] = 'Valor de Opci&oacute;n';
    	$this->data['entry_quantity'] = 'Cantidad de Opci&oacute;n';
		$this->data['entry_subtract'] = 'Restar Stock de Opci&oacute;n';
    	$this->data['entry_price'] = 'Precio de Opci&oacute;n';
		$this->data['entry_option_points'] = 'Puntos de Opci&oacute;n';
    	$this->data['entry_weight'] = 'Peso de Opci&oacute;n';
		

		$this->data['entry_text'] = 'Texto:';
		$this->data['entry_required'] = 'Requerido:';
				
    	$this->data['button_save'] = 'Guardar';
    	$this->data['button_cancel'] = 'Cancelar';
		$this->data['button_add_categoria'] = 'Agregar Categor&iacute;a';
		$this->data['button_add_numeracion'] = 'Agregar Numeraci&oacute;n';
		$this->data['button_add_opcion'] = 'Agregar Opci&oacute;n';
		$this->data['button_add_opcion_valor'] = 'Agregar Valor de Opci&oacute;n';
		$this->data['button_add_discount'] = 'Add Discount';
		$this->data['button_add_special'] = 'Add Special';
		$this->data['button_add_image'] = 'Agregar Im&aacute;gen';
		$this->data['button_remove'] = 'Eliminar';
		
    	$this->data['tab_general'] = 'General';
    	$this->data['tab_datos'] = 'Datos';
    	$this->data['tab_imagenes'] = 'Im&aacute;genes';
    	$this->data['tab_patrocinantes'] = 'Patrocinantes';
    	$this->data['tab_categorias'] = 'Categor&iacute;as';
    	$this->data['tab_numeracion'] = 'Numeraci&oacute;n';
    	$this->data['tab_opcion'] = 'Datos para Inscripci&oacute;n';
    	$this->data['tab_galeria'] = 'Galer&iacute;a';
		$this->data['tab_links'] = 'Links';
		 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['eventos_titulo'])) {
			$this->data['error_eventos_titulo'] = $this->error['eventos_titulo'];
		} else {
			$this->data['error_eventos_titulo'] = array();
		}

 		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = array();
		}		
   
   		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}	
		
   		if (isset($this->error['eventos_tipos_nombre'])) {
			$this->data['error_model'] = $this->error['eventos_tipos_nombre'];
		} else {
			$this->data['error_model'] = '';
		}		
     	
		if (isset($this->error['eventos_fecha_disponible'])) {
			$this->data['error_eventos_fecha_disponible'] = $this->error['eventos_fecha_disponible'];
		} else {
			$this->data['error_eventos_fecha_disponible'] = '';
		}	

		$url = '';

		if (isset($this->request->get['filter_eventos_titulo'])) {
			$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
		}
		
		if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
			$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
		}
		
		if (isset($this->request->get['filter_eventos_precio'])) {
			$url .= '&filter_eventos_precio=' . $this->request->get['filter_eventos_precio'];
		}
		
		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}	
		
		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
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
       		'text'      => 'Eventos',
			'href'      => $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['eventos_id'])) {
			$this->data['action'] = $this->url->link('catalog/evento/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/evento/update', 'token=' . $this->session->data['token'] . '&eventos_id=' . $this->request->get['eventos_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['eventos_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$evento_info = $this->model_catalog_evento->getEventoDescripcion($this->request->get['eventos_id']);
    	}

		if (isset($this->request->post['eventos_fecha_disponible'])) {
       		$this->data['eventos_fecha_disponible'] = $this->request->post['eventos_fecha_disponible'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_fecha_disponible'] = date('Y-m-d', strtotime($evento_info['eventos_fecha_disponible']));
		} else {
			$this->data['eventos_fecha_disponible'] = date('Y-m-d', time() - 86400);
		}

    	if (isset($this->request->post['eventos_status'])) {
      		$this->data['eventos_status'] = $this->request->post['eventos_status'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_status'] = $evento_info['eventos_status'];
		} else {
      		$this->data['eventos_status'] = 0;
    	}

    	if (isset($this->request->post['eventos_inscripciones'])) {
      		$this->data['eventos_inscripciones'] = $this->request->post['eventos_inscripciones'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_inscripciones'] = $evento_info['eventos_inscripciones'];
		} else {
      		$this->data['eventos_inscripciones'] = 0;
    	}

		$this->load->model('catalog/tipos');
		
    	$this->data['tipos'] = $this->model_catalog_tipos->getTipos();

    	if (isset($this->request->post['eventos_tipos_id'])) {
      		$this->data['eventos_tipos_id'] = $this->request->post['eventos_tipos_id'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_tipos_id'] = $this->model_catalog_evento->getTipoID($this->request->get['eventos_id']);
		} else {
      		$this->data['eventos_tipos_id'] = array();
    	} 

    	if (isset($this->request->post['eventos_orden'])) {
      		$this->data['eventos_orden'] = $this->request->post['eventos_orden'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_orden'] = $evento_info['eventos_orden'];
		} else {
      		$this->data['eventos_orden'] = 1;
    	}

    	if (isset($this->request->post['eventos_privado'])) {
      		$this->data['eventos_privado'] = $this->request->post['eventos_privado'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_privado'] = $evento_info['eventos_privado'];
		} else {
      		$this->data['eventos_privado'] = 1;
    	}

    	if (isset($this->request->post['eventos_titulo'])) {
      		$this->data['eventos_titulo'] = $this->request->post['eventos_titulo'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_titulo'] = $evento_info['eventos_titulo'];
		} else {
      		$this->data['eventos_titulo'] = '';
    	}

    	if (isset($this->request->post['eventos_titulo'])) {
      		$this->data['eventos_titulo'] = $this->request->post['eventos_titulo'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_titulo'] = $evento_info['eventos_titulo'];
		} else {
      		$this->data['eventos_titulo'] = '';
    	}

		if (isset($this->request->post['eventos_fecha'])) {
       		$this->data['eventos_fecha'] = $this->request->post['eventos_fecha'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_fecha'] = date('Y-m-d', strtotime($evento_info['eventos_fecha']));
		} else {
			$this->data['eventos_fecha'] = date('Y-m-d', time() - 86400);
		}

    	if (isset($this->request->post['eventos_hora'])) {
      		$this->data['eventos_hora'] = $this->request->post['eventos_hora'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_hora'] = $evento_info['eventos_hora'];
		} else {
      		$this->data['eventos_hora'] = '';
    	}

    	if (isset($this->request->post['eventos_lugar'])) {
      		$this->data['eventos_lugar'] = $this->request->post['eventos_lugar'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_lugar'] = $evento_info['eventos_lugar'];
		} else {
      		$this->data['eventos_lugar'] = '';
    	}

    	if (isset($this->request->post['eventos_precio'])) {
      		$this->data['eventos_precio'] = $this->request->post['eventos_precio'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_precio'] = $evento_info['eventos_precio'];
		} else {
      		$this->data['eventos_precio'] = '';
    	}

		$this->load->model('localidad/impuesto_class');
		
		$this->data['impuestos'] = $this->model_localidad_impuesto_class->getImpuestos();
    	
		if (isset($this->request->post['eventos_id_impuesto'])) {
      		$this->data['eventos_id_impuesto'] = $this->request->post['eventos_id_impuesto'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_id_impuesto'] = $evento_info['eventos_id_impuesto'];
		} else {
      		$this->data['eventos_id_impuesto'] = 1;
    	}

    	if (isset($this->request->post['eventos_cupos_apertura'])) {
      		$this->data['eventos_cupos_apertura'] = $this->request->post['eventos_cupos_apertura'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_cupos_apertura'] = $evento_info['eventos_cupos_apertura'];
		} else {
      		$this->data['eventos_cupos_apertura'] = 0;
    	}

    	if (isset($this->request->post['eventos_cupos_internet'])) {
      		$this->data['eventos_cupos_internet'] = $this->request->post['eventos_cupos_internet'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_cupos_internet'] = $evento_info['eventos_cupos_internet'];
		} else {
      		$this->data['eventos_cupos_internet'] = 0;
    	}

    	if (isset($this->request->post['eventos_afiche'])) {
      		$this->data['eventos_afiche'] = $this->request->post['eventos_afiche'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_afiche'] = $evento_info['eventos_afiche'];
		} else {
      		$this->data['eventos_afiche'] = 0;
    	}

    	if (isset($this->request->post['eventos_redireccion'])) {
      		$this->data['eventos_redireccion'] = $this->request->post['eventos_redireccion'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_redireccion'] = $evento_info['eventos_redireccion'];
		} else {
      		$this->data['eventos_redireccion'] = 0;
    	}

    	if (isset($this->request->post['eventos_redireccion_url'])) {
      		$this->data['eventos_redireccion_url'] = $this->request->post['eventos_redireccion_url'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_redireccion_url'] = $evento_info['eventos_redireccion_url'];
		} else {
      		$this->data['eventos_redireccion_url'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_resultados_url'])) {
      		$this->data['eventos_descripcion_resultados_url'] = $this->request->post['eventos_descripcion_resultados_url'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_resultados_url'] = $evento_info['eventos_descripcion_resultados_url'];
		} else {
      		$this->data['eventos_descripcion_resultados_url'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_cedula'])) {
      		$this->data['eventos_descripcion_cedula'] = $this->request->post['eventos_descripcion_cedula'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_cedula'] = $evento_info['eventos_descripcion_cedula'];
		} else {
      		$this->data['eventos_descripcion_cedula'] = 0;
    	}

    	if (isset($this->request->post['eventos_descripcion_club'])) {
      		$this->data['eventos_descripcion_club'] = $this->request->post['eventos_descripcion_club'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_club'] = $evento_info['eventos_descripcion_club'];
		} else {
      		$this->data['eventos_descripcion_club'] = 0;
    	}

    	if (isset($this->request->post['eventos_descripcion_tallas'])) {
      		$this->data['eventos_descripcion_tallas'] = $this->request->post['eventos_descripcion_tallas'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_tallas'] = $evento_info['eventos_descripcion_tallas'];
		} else {
      		$this->data['eventos_descripcion_tallas'] = 0;
    	}

    	if (isset($this->request->post['eventos_descripcion_circuito'])) {
      		$this->data['eventos_descripcion_circuito'] = $this->request->post['eventos_descripcion_circuito'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_circuito'] = $evento_info['eventos_descripcion_circuito'];
		} else {
      		$this->data['eventos_descripcion_circuito'] = 0;
    	}

		$this->load->model('catalog/numeracion');
		
    	$this->data['numeraciones'] = $this->model_catalog_numeracion->getNumeraciones();

    	if (isset($this->request->post['eventos_descripcion_numeracion_id_tipo'])) {
      		$this->data['eventos_descripcion_numeracion_id_tipo'] = $this->request->post['eventos_descripcion_numeracion_id_tipo'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_descripcion_numeracion_id_tipo'] = $evento_info['eventos_descripcion_numeracion_id_tipo'];
		} else {
      		$this->data['eventos_descripcion_numeracion_id_tipo'] = 0;
    	} 
		
    	if (isset($this->request->get['eventos_id'])) {
			$this->data['numeracion_habilitada'] = $this->model_catalog_evento->getEventoTotalNumeros($this->request->get['eventos_id']);
		}

    	if (isset($this->request->post['eventos_meta_keywords'])) {
      		$this->data['eventos_meta_keywords'] = $this->request->post['eventos_meta_keywords'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_meta_keywords'] = $evento_info['eventos_meta_keywords'];
		} else {
      		$this->data['eventos_meta_keywords'] = '';
    	}

    	if (isset($this->request->post['eventos_meta_description'])) {
      		$this->data['eventos_meta_description'] = $this->request->post['eventos_meta_description'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_meta_description'] = $evento_info['eventos_meta_description'];
		} else {
      		$this->data['eventos_meta_description'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_info'])) {
      		$this->data['eventos_descripcion_info'] = $this->request->post['eventos_descripcion_info'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_info'] = $evento_info['eventos_descripcion_info'];
		} else {
      		$this->data['eventos_descripcion_info'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_reglamento'])) {
      		$this->data['eventos_descripcion_reglamento'] = $this->request->post['eventos_descripcion_reglamento'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_reglamento'] = $evento_info['eventos_descripcion_reglamento'];
		} else {
      		$this->data['eventos_descripcion_reglamento'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_premiacion'])) {
      		$this->data['eventos_descripcion_premiacion'] = $this->request->post['eventos_descripcion_premiacion'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_premiacion'] = $evento_info['eventos_descripcion_premiacion'];
		} else {
      		$this->data['eventos_descripcion_premiacion'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_ruta'])) {
      		$this->data['eventos_descripcion_ruta'] = $this->request->post['eventos_descripcion_ruta'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_ruta'] = $evento_info['eventos_descripcion_ruta'];
		} else {
      		$this->data['eventos_descripcion_ruta'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_inscripciones_online'])) {
      		$this->data['eventos_descripcion_inscripciones_online'] = $this->request->post['eventos_descripcion_inscripciones_online'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_inscripciones_online'] = $evento_info['eventos_descripcion_inscripciones_online'];
		} else {
      		$this->data['eventos_descripcion_inscripciones_online'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_inscripciones_tiendas'])) {
      		$this->data['eventos_descripcion_inscripciones_tiendas'] = $this->request->post['eventos_descripcion_inscripciones_tiendas'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_inscripciones_tiendas'] = $evento_info['eventos_descripcion_inscripciones_tiendas'];
		} else {
      		$this->data['eventos_descripcion_inscripciones_tiendas'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_materiales'])) {
      		$this->data['eventos_descripcion_materiales'] = $this->request->post['eventos_descripcion_materiales'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_materiales'] = $evento_info['eventos_descripcion_materiales'];
		} else {
      		$this->data['eventos_descripcion_materiales'] = '';
    	}

    	if (isset($this->request->post['eventos_descripcion_responsabilidad'])) {
      		$this->data['eventos_descripcion_responsabilidad'] = $this->request->post['eventos_descripcion_responsabilidad'];
    	} else if (isset($evento_info)) {
			$this->data['eventos_descripcion_responsabilidad'] = $evento_info['eventos_descripcion_responsabilidad'];
		} else {
      		$this->data['eventos_descripcion_responsabilidad'] = '';
    	}

		if (isset($this->request->post['eventos_logo'])) {
			$this->data['eventos_logo'] = $this->request->post['eventos_logo'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_logo'] = $evento_info['eventos_logo'];
		} else {
			$this->data['eventos_logo'] = '';
		}
		
		if (isset($this->request->post['eventos_imagen_home'])) {
			$this->data['eventos_imagen_home'] = $this->request->post['eventos_imagen_home'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_imagen_home'] = $evento_info['eventos_imagen_home'];
		} else {
			$this->data['eventos_imagen_home'] = '';
		}

		if (isset($this->request->post['eventos_imagen_header'])) {
			$this->data['eventos_imagen_header'] = $this->request->post['eventos_imagen_header'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_imagen_header'] = $evento_info['eventos_imagen_header'];
		} else {
			$this->data['eventos_imagen_header'] = '';
		}

		if (isset($this->request->post['eventos_imagen_afiche'])) {
			$this->data['eventos_imagen_afiche'] = $this->request->post['eventos_imagen_afiche'];
		} elseif (isset($evento_info)) {
			$this->data['eventos_imagen_afiche'] = $evento_info['eventos_imagen_afiche'];
		} else {
			$this->data['eventos_imagen_afiche'] = '';
		}

		$this->load->model('tool/image');
		
		if (isset($evento_info) && $evento_info['eventos_logo'] && file_exists(DIR_IMAGE . $evento_info['eventos_logo'])) {
			$this->data['preview_eventos_logo'] = $this->model_tool_image->resize($evento_info['eventos_logo'], 100, 100);
		} else {
			$this->data['preview_eventos_logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($evento_info) && $evento_info['eventos_imagen_home'] && file_exists(DIR_IMAGE . $evento_info['eventos_imagen_home'])) {
			$this->data['preview_eventos_imagen_home'] = $this->model_tool_image->resize($evento_info['eventos_imagen_home'], 100, 100);
		} else {
			$this->data['preview_eventos_imagen_home'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($evento_info) && $evento_info['eventos_imagen_header'] && file_exists(DIR_IMAGE . $evento_info['eventos_imagen_header'])) {
			$this->data['preview_eventos_imagen_header'] = $this->model_tool_image->resize($evento_info['eventos_imagen_header'], 100, 100);
		} else {
			$this->data['preview_eventos_imagen_header'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($evento_info) && $evento_info['eventos_imagen_afiche'] && file_exists(DIR_IMAGE . $evento_info['eventos_imagen_afiche'])) {
			$this->data['preview_eventos_imagen_afiche'] = $this->model_tool_image->resize($evento_info['eventos_imagen_afiche'], 100, 100);
		} else {
			$this->data['preview_eventos_imagen_afiche'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
	
		$this->load->model('catalog/patrocinante');
				
		$this->data['patrocinantes'] = $this->model_catalog_patrocinante->getPatrocinantes();
		
		if (isset($this->request->post['evento_patrocinante'])) {
			$this->data['evento_patrocinante'] = $this->request->post['evento_patrocinante'];
		} elseif (isset($evento_info)) {
			$this->data['evento_patrocinante'] = $this->model_catalog_evento->getEventoPatrocinantes($this->request->get['eventos_id']);
		} else {
			$this->data['evento_patrocinante'] = array();
		}		

		if (isset($this->request->post['evento_categoria'])) {
			$this->data['evento_categorias'] = $this->request->post['evento_categoria'];
		} elseif (isset($evento_info)) {
			$this->data['evento_categorias'] = $this->model_catalog_evento->getEventoCategorias($this->request->get['eventos_id']);
		} else {
			$this->data['evento_categorias'] = array();
		}

    	if (isset($this->request->get['eventos_id'])) {

			$cupos_confirmados = $this->model_catalog_evento->getTotalParticipantesConfirmadosByEvento($this->request->get['eventos_id']);
			$cupos_no_confirmados = $this->model_catalog_evento->getTotalParticipantesNoConfirmadosByEvento($this->request->get['eventos_id']);
			$cupos_urilizados = $cupos_confirmados + $cupos_no_confirmados;

			$cupos_tiendas = $this->model_catalog_evento->getTotalParticipantesTiendasByEvento($this->request->get['eventos_id']);
			
			$this->data['evento_cupos_totales'] = $this->data['eventos_cupos_apertura'];
			$this->data['evento_cupos_urilizados'] = $cupos_urilizados;
			$this->data['evento_cupos_confirmados'] = $cupos_confirmados;
			$this->data['evento_cupos_no_confirmados'] = $cupos_no_confirmados;
			$this->data['evento_cupos_disponibles'] = $this->data['eventos_cupos_internet'];
			$this->data['evento_cupos_tiendas'] = $cupos_tiendas;

			/* Getting the time intervals */
			
			// $this->data['evento_intervalos'] = array();
	
			$this->data['evento_numeracion_tiempos'] = $this->model_catalog_evento->getEventoNumeracionTiempos($this->request->get['eventos_id']);
			$this->data['evento_tiempos_previos'] = $this->model_catalog_evento->getEventoTotalTiemposPrevios($this->request->get['eventos_id']);
			
			$this->data['evento_numeracion_grupos'] = $this->model_catalog_evento->getEventoNumeracionGrupos($this->request->get['eventos_id']);
	
			$this->data['evento_numeraciones_estandar'] = $this->model_catalog_evento->getEventoNumeracionEstandar($this->request->get['eventos_id']);
	
		}
		


		if (isset($this->request->post['evento_numeracion'])) {
			$this->data['evento_numeracion'] = $this->request->post['evento_numeracion'];
		} else {
			$this->data['evento_numeracion'] = array();
		}


		if (isset($this->request->post['evento_opcion'])) {
			$evento_opciones = $this->request->post['evento_opcion'];
		} elseif (isset($evento_info)) {
			$evento_opciones = $this->model_catalog_evento->getEventoOpciones($this->request->get['eventos_id']);			
		} else {
			$evento_opciones = array();
		}			
		
		$this->data['evento_opciones'] = array();
			
		foreach ($evento_opciones as $evento_opcion) {
			if ($evento_opcion['opcion_tipo'] == 'select' || $evento_opcion['opcion_tipo'] == 'radio' || $evento_opcion['opcion_tipo'] == 'checkbox') {
				$product_option_value_data = array();
				
				foreach ($evento_opcion['eventos_opcion_valor'] as $product_option_value) {
					$product_option_value_data[] = array(
						'eventos_opcion_valor_id' => $product_option_value['eventos_opcion_valor_id'],
						'opcion_valor_id'         => $product_option_value['opcion_valor_id'],
						'cantidad'                => $product_option_value['cantidad'],
						'restar'                  => $product_option_value['restar'],
						'precio'                  => $product_option_value['precio'],
						'precio_prefijo'          => $product_option_value['precio_prefijo'],
//						'points'                  => $product_option_value['puntos'],
//						'points_prefix'           => $product_option_value['puntos_prefijo'],						
//						'weight'                  => $product_option_value['peso'],
//						'weight_prefix'           => $product_option_value['peso_prefijo']	
					);						
				}
				
				$this->data['evento_opciones'][] = array(
					'eventos_opcion_id'    => $evento_opcion['eventos_opcion_id'],
					'opcion_id'            => $evento_opcion['opcion_id'],
					'opcion_nombre'        => $evento_opcion['opcion_nombre'],
					'opcion_tipo'          => $evento_opcion['opcion_tipo'],
					'eventos_opcion_valor' => $product_option_value_data,
					'eventos_opcion_requerido'             => $evento_opcion['eventos_opcion_requerido']
				);				
			} else {
				$this->data['evento_opciones'][] = array(
					'eventos_opcion_id' => $evento_opcion['eventos_opcion_id'],
					'opcion_id'         => $evento_opcion['opcion_id'],
					'opcion_nombre'     => $evento_opcion['opcion_nombre'],
					'opcion_tipo'       => $evento_opcion['opcion_tipo'],
					'opcion_valor'      => $evento_opcion['opcion_valor'],
					'eventos_opcion_requerido'          => $evento_opcion['eventos_opcion_requerido']
				);				
			}
		}

/*
'eventos_descripcion_mapa'					=> $result['eventos_descripcion_mapa'],
'eventos_descripcion_ranking'       		=> $result['eventos_descripcion_ranking'],
'eventos_descripcion_comentario'			=> $result['eventos_descripcion_comentario'],
'eventos_descripcion_preguntas'				=> $result['eventos_descripcion_preguntas'],

if (isset($this->request->post['product_image'])) {
	$product_images = $this->request->post['product_image'];
} elseif (isset($evento_info)) {
	$product_images = $this->model_catalog_evento->getProductImages($this->request->get['product_id']);
} else {
	$product_images = array();
}

$this->data['product_images'] = array();

foreach ($product_images as $product_image) {
	if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
		$image = $product_image['image'];
	} else {
		$image = 'no_image.jpg';
	}
	
	$this->data['product_images'][] = array(
		'image'   => $image,
		'preview' => $this->model_tool_image->resize($image, 100, 100)
	);
}

$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
*/
		$this->template = 'catalog/evento_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/evento')) {
      		$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los eventos!';
    	}

		if ((strlen(utf8_decode($this->request->post['eventos_titulo'])) < 3) || (strlen(utf8_decode($this->request->post['eventos_titulo'])) > 255)) {
			$this->error['eventos_titulo'] = '¡El nombre del evento debe tener entre 3 y 255 caracteres!';
		}
		
/*
		$this->load->model('catalog/evento');
		
		foreach ($this->request->post['eventos_numeros_id'] as $eventos_numeros_id) {
			$evento_total = $this->model_catalog_evento->getTotalClientesByNumero($eventos_numeros_id, $this->request->get['eventos_id']);

			if ($evento_total) {
				$this->error['warning'] = sprintf('error_product'), $evento_total);
			}
		}
*/

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Advertencia: ¡Por favor verifique la informaci&oacute;n!';
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/evento')) {
      		$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los eventos!';  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'catalog/evento')) {
      		$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los eventos!';  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	public function opcion() {
		$output = ''; 
		
		$this->load->model('catalog/opcion');
		
		$results = $this->model_catalog_opcion->getOpcionValores($this->request->get['opcion_id']);
		
		foreach ($results as $result) {
			$output .= '<option value="' . $result['opcion_valor_id'] . '"';

			if (isset($this->request->get['opcion_valor_id']) && ($this->request->get['opcion_valor_id'] == $result['opcion_valor_id'])) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['opcion_valor_decripcion_nombre'] . '</option>';
		}

		$this->response->setOutput($output);
	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->post['filter_eventos_titulo'])) {
			$this->load->model('catalog/evento');
			
			$data = array(
				'filter_eventos_titulo' => $this->request->post['filter_eventos_titulo'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_catalog_evento->getEventos($data);
			
			foreach ($results as $result) {
				$opcion_data = array();
				
				$evento_opciones = $this->model_catalog_evento->getEventoOpciones($result['eventos_id']);	
				
				foreach ($evento_opciones as $evento_opcion) {
					if ($evento_opcion['opcion_tipo'] == 'select' || $evento_opcion['opcion_tipo'] == 'radio' || $evento_opcion['opcion_tipo'] == 'checkbox') {
						$opcion_valor_data = array();
					
						foreach ($evento_opcion['evento_opcion_valor'] as $evento_opcion_valor) {
							$opcion_valor_data[] = array(
								'eventos_opcion_valor_id' => $evento_opcion_valor['eventos_opcion_valor_id'],
								'opcion_valor_id'         => $evento_opcion_valor['opcion_valor_id'],
								'eventos_titulo'                    => $evento_opcion_valor['eventos_titulo'],
								'eventos_precio'                   => (float)$evento_opcion_valor['eventos_precio'] ? $this->moneda->format($evento_opcion_valor['eventos_precio'], $this->config->get('config_currency')) : false,
								'precio_prefijo'            => $evento_opcion_valor['precio_prefijo']
							);	
						}
					
						$opcion_data[] = array(
							'eventos_opcion_id' => $evento_opcion['eventos_opcion_id'],
							'opcion_id'        => $evento_opcion['opcion_id'],
							'eventos_titulo'   => $evento_opcion['eventos_titulo'],
							'opcion_tipo'      => $evento_opcion['opcion_tipo'],
							'opcion_valor'     => $opcion_valor_data,
							'eventos_opcion_requerido'         => $evento_opcion['eventos_opcion_requerido']
						);	
					} else {
						$opcion_data[] = array(
							'eventos_opcion_id' => $evento_opcion['eventos_opcion_id'],
							'opcion_id'        => $evento_opcion['opcion_id'],
							'eventos_titulo'   => $evento_opcion['eventos_titulo'],
							'opcion_tipo'      => $evento_opcion['opcion_tipo'],
							'opcion_valor'     => $evento_opcion['opcion_valor'],
							'eventos_opcion_requerido'         => $evento_opcion['eventos_opcion_requerido']
						);				
					}
				}
				
				$json[] = array(
					'eventos_id' 			=> $result['eventos_id'],
					'eventos_titulo'        => html_entity_decode($result['eventos_titulo'], ENT_QUOTES, 'UTF-8'),	
					'eventos_tipos_nombre'	=> $result['eventos_tipos_nombre'],
					'option'     			=> $opcion_data,
					'eventos_precio'      	=> $result['eventos_precio']
				);	
			}
		}
		
		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}
?>
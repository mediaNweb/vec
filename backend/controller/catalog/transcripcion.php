<?php 
class ControllerCatalogTranscripcion extends Controller {
	private $error = array(); 
     
  	public function index() {
		    	
		$this->document->setTitle('Transcripciones'); 
		
		$this->load->model('catalog/evento');
		$this->load->model('catalog/transcripcion');
		
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
       		'text'      => 'Transcripciones',
			'href'      => $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
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

		$evento_total = $this->model_catalog_transcripcion->getTotalEventosActivos($data);
			
		$results = $this->model_catalog_transcripcion->getEventosActivos($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Inscribir Participante',
				'href' => $this->url->link('catalog/transcripcion/inscribir', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			if ($result['eventos_logo'] && file_exists(DIR_IMAGE . $result['eventos_logo'])) {
				$image = $this->model_tool_image->resize($result['eventos_logo'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

      		$this->data['eventos'][] = array(
				'eventos_id' 				=> $result['eventos_id'],
				'eventos_titulo'       		=> $result['eventos_titulo'],
				'eventos_tipo_nombre'      	=> $this->model_catalog_transcripcion->getTipo($result['eventos_id']),
				'eventos_precio'      		=> $result['eventos_precio'],
				'eventos_logo'      		=> $image,
				'eventos_cupos_internet'	=> $result['eventos_cupos_internet'],
				'eventos_status'     		=> ($result['eventos_status'] ? 'Habilitado' : 'Deshabilitado'),
				'eventos_inscripciones'     => ($result['eventos_inscripciones'] ? 'Habilitado' : 'Deshabilitado'),
				'selected'   				=> isset($this->request->post['selected']) && in_array($result['eventos_id'], $this->request->post['selected']),
				'action'     				=> $action
			);
    	}
		
		$this->data['heading_title'] = 'Transcripciones';		
				
    	$this->data['text_all'] = ' --- Todos --- ';
		$this->data['text_enabled'] = 'Habilitado';		
		$this->data['text_disabled'] = 'Deshabilitado';		
		$this->data['text_no_results'] = 'Sin resultados';		
		$this->data['text_image_manager'] = 'Administrador de Im&aacute;genes';		
			
		$this->data['column_image'] = 'Im&aacute;gen';		
		$this->data['column_eventos_titulo'] = 'Nombre del Evento';		
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
					
		$this->data['sort_eventos_titulo'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_titulo' . $url, 'SSL');
		$this->data['sort_eventos_privado'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_privado' . $url, 'SSL');
		$this->data['sort_eventos_tipos_nombre'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_tipos_nombre' . $url, 'SSL');
		$this->data['sort_eventos_precio'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_precio' . $url, 'SSL');
		$this->data['sort_eventos_cupos_internet'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_cupos_internet' . $url, 'SSL');
		$this->data['sort_eventos_status'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_eventos_status' . $url, 'SSL');
		$this->data['sort_eventos_orden'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . '&sort=e.eventos_orden' . $url, 'SSL');
		
		$url = '';

		$pagination = new Pagination();
		$pagination->total = $evento_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_eventos_year'] = $filter_eventos_year;
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/transcripcion_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function inscribir() {
    	

    	$this->document->setTitle('Transcripci&oacute;n de Participante');
		
		$this->load->model('catalog/transcripcion');
		$this->load->model('catalog/razas');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
//    	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$data = array();
			
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
			
			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTP_SERVER;	
			}
			
			$data['customer_id'] = 0;
			$data['firstname'] = $this->user->getFirstName();
			$data['lastname'] = $this->user->getLastName();
			$data['email'] = $this->user->getEmail();
			$data['telephone'] = '';
			
			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_company'] = '';
			$data['payment_address_1'] = '';
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_zone'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_country'] = '';
			$data['payment_country_id'] = '';
			$data['payment_address_format'] = '';
		
			$data['payment_method'] = '';
			
			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';	
			$data['shipping_company'] = '';	
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_zone'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_country'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_address_format'] = '';
			$data['shipping_method'] = '';

			$cantidad = $this->request->post['cupo'];			
			$product_data = array();
			$option_data = array();
			$datos_inscripcion = array();
			
			foreach ($this->request->post['opcion'] as $key => $value) {
				
				$eventos_opcion_id = $key;
				$opcion_id = $this->model_catalog_transcripcion->getCodigoOpcion($key);
				if ($opcion_id) {
					
					$opcion_nombre = ($this->model_catalog_transcripcion->getNombreOpcion($opcion_id)) ? $this->model_catalog_transcripcion->getNombreOpcion($opcion_id) : $key;
					$eventos_opcion_valor_id = $value;
					$opcion_valor_id = ($this->model_catalog_transcripcion->getCodigoValorOpcion($eventos_opcion_valor_id) ? $this->model_catalog_transcripcion->getCodigoValorOpcion($eventos_opcion_valor_id) : 0);
					$opcion_valor = $this->model_catalog_transcripcion->getNombreValorOpcion($opcion_valor_id);
					$opcion_tipo = $this->model_catalog_transcripcion->getTipoOpcion($opcion_id);
					
				} else {

					$eventos_opcion_id			= 0;
					$eventos_opcion_valor_id	= 0;
					$opcion_id					= 0;
					$opcion_valor_id			= 0;
					$opcion_nombre				= $key;
					$opcion_valor				= $value;
					$opcion_tipo				= '';
					
				}
				
				$option_data[] = array(
					'product_option_id'       => $eventos_opcion_id,
					'product_option_value_id' => $eventos_opcion_valor_id,
					'option_id'               => $opcion_id,
					'option_value_id'         => $opcion_valor_id,								   
					'name'                    => $opcion_nombre,
					'value'                   => $opcion_valor,
					'type'                    => $opcion_tipo,
				);					

				$datos_inscripcion[] = array(
					'name'                    => $key,
					'value'                   => $value,
				);					
			}
 
			$evento_info = $this->model_catalog_transcripcion->getEventoDescripcion($this->request->get['eventos_id']);
			
			$product_data[] = array(
				'product_id' => $this->request->get['eventos_id'],
				'name'       => $evento_info['eventos_titulo'],
				'model'      => '',
				'option'     => $option_data,
				'datos'      => $datos_inscripcion,
				'quantity'   => 1,
				'subtract'   => $cantidad,
				'price'      => 0,
				'total'      => 0,
				'tax'        => 0
			); 
			
			$total_data = array();
			$total = 0;
			$taxes = 0;

			$data['products'] = $product_data;
			$data['totals'] = $total_data;
			$data['comment'] = '';
			$data['total'] = $total;
			
			$data['affiliate_id'] = 0;
			$data['commission'] = 0;
			
			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->moneda->getId();
			$data['currency_code'] = $this->moneda->getCode();
			$data['currency_value'] = $this->moneda->getValue($this->moneda->getCode());
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			$this->load->model('inscripciones/solicitud');
			
			$this->session->data['order_id'] = $this->model_inscripciones_solicitud->create($data);

			$this->load->model('inscripciones/participantes');
			
			$empleado = (isset($this->request->post['opcion']['Carnet'])) ? $this->request->post['opcion']['Carnet'] : '';

			if ($this->request->post['cupo'] == 0) {
				$this->model_inscripciones_participantes->create($this->session->data['order_id'],  $this->request->post['planilla_id'], 'Tienda', 'Backdoor', $empleado);
			} else {
				$this->model_inscripciones_participantes->create($this->session->data['order_id'],  $this->request->post['planilla_id'], 'Internet', 'Backdoor', $empleado, true);
			}

			$fecha = date("Y-m-d");

			$this->model_inscripciones_solicitud->confirm($this->session->data['order_id'], 11, '', 'Planilla_' . $this->session->data['order_id'], $fecha, false);
			
			$this->load->model('inscripciones/numeros');
			$this->load->model('inscripciones/participantes');

			$eventos_opciones = $this->model_inscripciones_solicitud->getEventosBySolicitudOpcion($this->session->data['order_id']);

			foreach ($eventos_opciones as $evento_opcion) {

				$codigo_evento = $this->model_inscripciones_solicitud->getEventoIdByOpcion($this->session->data['order_id'], $evento_opcion['codigo_opcion']);
				$cedula = $this->model_inscripciones_participantes->getParticipanteCedula($this->session->data['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
				$categoria = $this->model_inscripciones_participantes->getParticipanteCategoria($this->session->data['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
				$tiempo = $this->model_inscripciones_participantes->getParticipanteTiempo($this->session->data['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
				$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($this->session->data['order_id'], $evento_opcion['codigo_opcion'], $codigo_evento);
				
				if($this->request->post['numero_reservado']) {
					$numero = $this->request->post['numero_reservado'];
				} else {
					$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);
				}

				$this->model_inscripciones_participantes->confirm($cedula, $this->session->data['order_id'], $codigo_evento, $numero, $evento_opcion['codigo_opcion']);
			
			}

			if (isset($this->session->data['success'])) {
				$this->data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			} else {
				$this->data['success'] = '';
			}

			$this->session->data['success'] = 'Usted ha inscrito al participante!';
			
			$url = '';
			
//			$this->redirect($this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			$this->redirect($this->url->link('catalog/transcripcion/inscribir', 'token=' . $this->session->data['token'] . '&eventos_id=' . $this->request->get['eventos_id'] . $url, 'SSL'));
			
		}

    	$this->getForm();
  	}

  	private function getForm() {
    	$this->data['heading_title'] = 'Transcripciones';
 
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
    	$this->data['entry_eventos_cupos'] = 'Cupos para Internet:';
    	$this->data['entry_eventos_afiche'] = 'Mostrar Afiche:';
    	$this->data['entry_eventos_redireccion'] = 'Redireccionar a URL del Evento:';
    	$this->data['entry_eventos_redireccion_url'] = 'URL del Evento:';
		$this->data['entry_meta_description'] = 'Meta Tag Description:';
		$this->data['entry_meta_keyword'] = 'Meta Tag Keywords:';
    	$this->data['entry_eventos_descripcion_resultados_url'] = 'URL de Resultados:';
    	$this->data['entry_eventos_descripcion_cedula'] = 'Permitir Inscritos Sin C&eacute;dula:';
    	$this->data['entry_eventos_descripcion_club'] = 'Permitir Inscritos por Club:';
    	$this->data['entry_eventos_descripcion_tallas'] = 'Permitir Selecci&oacute;n de Tallas:';
    	$this->data['entry_eventos_descripcion_circuito'] = 'Permitir Record de Circuito:';
    	$this->data['entry_eventos_descripcion_numeracion_id_tipo'] = 'Tipo de Numeraci&oacute;n:';
		$this->data['entry_eventos_descripcion_info'] = 'Informaci&oacute;n General:';
		$this->data['entry_eventos_descripcion_reglamento'] = 'Informaci&oacute;n de Reglamento:';
		$this->data['entry_eventos_descripcion_premiacion'] = 'Informaci&oacute;n de Premiaci&oacute;n:';
		$this->data['entry_eventos_descripcion_ruta'] = 'Informaci&oacute;n de Ruta:';
		$this->data['entry_eventos_descripcion_inscripciones'] = 'Informaci&oacute;n de Inscripci&oacute;n:';
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
		$this->data['entry_eventos_numeracion_datos_cupos_disponibles'] = 'Cupos Internet Disponibles';
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

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
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
       		'text'      => 'Transcripciones',
			'href'      => $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (isset($this->request->get['eventos_id'])) {
			$this->data['action'] = $this->url->link('catalog/transcripcion/inscribir', 'token=' . $this->session->data['token'] . '&eventos_id=' . $this->request->get['eventos_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['eventos_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$evento_info = $this->model_catalog_transcripcion->getEventoDescripcion($this->request->get['eventos_id']);
    	}

		if (isset($this->request->get['eventos_id'])) {
			$eventos_id = $this->request->get['eventos_id'];
		} else {
			$eventos_id = 0;
		}

/*
		if (isset($this->request->post['opcion'])) {
			foreach ($this->request->post['opcion'] as $key => $value) {
				if (isset($this->request->post['opcion'][$key])) {
					$this->data['opcion'][$key] = $value;
				} else {
					$this->data['opcion'][$key] = '';
				}
			}
		}
*/

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

		$this->data['paises'] = $this->model_catalog_transcripcion->getPaises();

		$this->data['razas'] = $this->model_catalog_razas->getRazas();

		$this->data['numeros_reservados'] = $this->model_catalog_transcripcion->getNumerosReservadosByEvento($eventos_id);

		$this->data['categoria_info'] = $this->model_catalog_transcripcion->getCategoriasByEvento($eventos_id);

		$this->data['categorias'] = $this->model_catalog_transcripcion->getCategoriasDescripcionByEvento($eventos_id);

		$numeracion = $this->model_catalog_transcripcion->getTipoNumeracion($eventos_id);

		if($numeracion == 3) { // Tiempos = 3
			$this->data['rangos'] = $this->model_catalog_transcripcion->getIntervalosTiempo($eventos_id);
		}

		$evento_info = $this->model_catalog_transcripcion->getEventoDescripcion($eventos_id);

		$this->data['evento_info'] = $evento_info;

		if ($evento_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			$this->data['breadcrumbs'][] = array(
			'text'      => $evento_info['eventos_titulo'],
			'href'      => $this->url->link('evento/evento', $url . '&eventos_id=' . $this->request->get['eventos_id']),
			'separator' => ' &raquo; '
			);            

			$this->document->setTitle($this->config->get('config_title') . ' ' . $evento_info['eventos_titulo']);
			$this->document->setDescription($evento_info['eventos_meta_description']);
			$this->document->setKeywords($evento_info['eventos_meta_keywords']);
			$this->document->addLink($this->url->link('evento/evento', 'eventos_id=' . $this->request->get['eventos_id']), 'canonical');

			$setting['width'] = 860;
			$setting['height'] = 215;

			$this->data['title']                                    = $evento_info['eventos_titulo'];
			$this->data['eventos_id']                               = $evento_info['eventos_id'];
			$this->data['eventos_titulo']                           = $evento_info['eventos_titulo'];
			$this->data['eventos_fecha']                            = $evento_info['eventos_fecha'];
			$this->data['eventos_hora']                             = $evento_info['eventos_hora'];
			$this->data['eventos_lugar']                            = $evento_info['eventos_lugar'];
			$this->data['eventos_logo']                             = $evento_info['eventos_logo'];
			$this->data['eventos_orden']                            = $evento_info['eventos_orden'];
			$this->data['eventos_cupos_internet']                   = $evento_info['eventos_cupos_internet'];
			$this->data['eventos_edad_calendario']                  = $evento_info['eventos_edad_calendario'];
			$this->data['eventos_precio']                           = $evento_info['eventos_precio'];
			$this->data['eventos_fdc']                              = $evento_info['eventos_fdc'];
			$this->data['eventos_fdum']                             = $evento_info['eventos_fdum'];
			$this->data['eventos_fecha_disponible']                 = $evento_info['eventos_fecha_disponible'];
			$this->data['eventos_inscripciones']					= $evento_info['eventos_inscripciones'];
			$this->data['eventos_status']                           = $evento_info['eventos_status'];
			$this->data['eventos_privado']                          = $evento_info['eventos_privado'];
			$this->data['eventos_id_impuesto']                      = $evento_info['eventos_id_impuesto'];
			$this->data['eventos_visitado']                         = $evento_info['eventos_visitado'];
			$this->data['eventos_href']                             = $this->url->link('evento/evento', 'eventos_id=' . $evento_info['eventos_id']);

			$this->data['eventos_descripcion_info']                 = $evento_info['eventos_descripcion_info'];
			$this->data['eventos_descripcion_reglamento']           = $evento_info['eventos_descripcion_reglamento'];
			$this->data['eventos_descripcion_premiacion']			= $evento_info['eventos_descripcion_premiacion'];
			$this->data['eventos_descripcion_ruta']                 = $evento_info['eventos_descripcion_ruta'];
			$this->data['eventos_descripcion_inscripciones_online']		= $evento_info['eventos_descripcion_inscripciones_online'];
			$this->data['eventos_descripcion_inscripciones_tiendas']		= $evento_info['eventos_descripcion_inscripciones_tiendas'];
			$this->data['eventos_descripcion_materiales']			= $evento_info['eventos_descripcion_materiales'];
			$this->data['eventos_descripcion_mapa']                 = $evento_info['eventos_descripcion_mapa'];
			$this->data['eventos_redireccion']          			= $evento_info['eventos_redireccion'];
			$this->data['eventos_redireccion_url']     				= $evento_info['eventos_redireccion_url'];
			$this->data['eventos_afiche']               			= $evento_info['eventos_afiche'];
			$this->data['eventos_imagen_afiche']           			= $evento_info['eventos_imagen_afiche'];
			$this->data['eventos_descripcion_resultados_url']       = $evento_info['eventos_descripcion_resultados_url'];
			$this->data['eventos_descripcion_responsabilidad']      = $evento_info['eventos_descripcion_responsabilidad'];
			$this->data['eventos_descripcion_ranking']              = $evento_info['eventos_descripcion_ranking'];
			$this->data['eventos_descripcion_cuenta']               = $evento_info['eventos_descripcion_cuenta'];
			$this->data['eventos_descripcion_cedula']               = $evento_info['eventos_descripcion_cedula'];
			$this->data['eventos_descripcion_comentario']           = $evento_info['eventos_descripcion_comentario'];
			$this->data['eventos_descripcion_club']                 = $evento_info['eventos_descripcion_club'];
			$this->data['eventos_descripcion_tallas']               = $evento_info['eventos_descripcion_tallas'];
			$this->data['eventos_descripcion_circuito']             = $evento_info['eventos_descripcion_circuito'];
			$this->data['eventos_descripcion_numeracion_id_tipo']   = $evento_info['eventos_descripcion_numeracion_id_tipo'];
			$this->data['eventos_descripcion_preguntas']            = $evento_info['eventos_descripcion_preguntas'];
			$this->data['eventos_meta_keywords']             		= $evento_info['eventos_meta_keywords'];
			$this->data['eventos_meta_description']            		= $evento_info['eventos_meta_description'];

			$this->data['text_option'] = 'Datos para Inscripci&oacute;n';
			$this->data['text_select'] = 'Seleccione';
			$this->data['button_cart'] = 'Agregar Inscripci&oacute;n';

			if ($evento_info['eventos_descripcion_cedula'] == 1) {
				$sin_cedula = 'sc' . uniqid();
				$this->data['sin_cedula'] = substr($sin_cedula, 0, 10);
			} else {
				$this->data['sin_cedula'] = '';
			}

			if (isset($this->request->post['paises_id'])) {
				$this->data['paises_id'] = $this->request->post['paises_id'];
			} else {
				$this->data['paises_id'] = '';
			}

			if (isset($this->request->post['estados_id'])) {
				$this->data['estados_id'] = $this->request->post['estados_id'];
			} else {
				$this->data['estados_id'] = '';
			}

			$this->data['opciones'] = array();
			
			foreach ($this->model_catalog_transcripcion->getEventoOpciones($this->request->get['eventos_id']) as $option) { 
				if ($option['opcion_tipo'] == 'select' || $option['opcion_tipo'] == 'radio' || $option['opcion_tipo'] == 'checkbox') { 
					$opcion_valor_data = array();
					
					foreach ($option['opcion_valor'] as $opcion_valor) {
//						if ($opcion_valor['cantidad'] > 0) {
							$opcion_valor_data[] = array(
								'eventos_opcion_valor_id' 			=> $opcion_valor['eventos_opcion_valor_id'],
								'opcion_valor_id'         			=> $opcion_valor['opcion_valor_id'],
								'opcion_valor_decripcion_nombre'    => $opcion_valor['opcion_valor_decripcion_nombre'],
							);
//						}
					}
					
					$this->data['opciones'][] = array(
						'eventos_opcion_id' 		=> $option['eventos_opcion_id'],
						'opcion_id'         		=> $option['opcion_id'],
						'opcion_nombre'     		=> $option['opcion_nombre'],
						'opcion_dato'     			=> $option['opcion_dato'],
						'opcion_tipo'       		=> $option['opcion_tipo'],
						'opcion_valor'      		=> $opcion_valor_data,
						'eventos_opcion_requerido'  => $option['eventos_opcion_requerido']
					);					
				} elseif ($option['opcion_tipo'] == 'text' || $option['opcion_tipo'] == 'textarea' || $option['opcion_tipo'] == 'file' || $option['opcion_tipo'] == 'date' || $option['opcion_tipo'] == 'datetime' || $option['opcion_tipo'] == 'time') {
					$this->data['opciones'][] = array(
						'eventos_opcion_id' 		=> $option['eventos_opcion_id'],
						'opcion_id'         		=> $option['opcion_id'],
						'opcion_nombre'     		=> $option['opcion_nombre'],
						'opcion_dato'     			=> $option['opcion_dato'],
						'opcion_tipo'       		=> $option['opcion_tipo'],
						'opcion_valor'      		=> $option['opcion_valor'],
						'eventos_opcion_requerido'  => $option['eventos_opcion_requerido']
					);						
				}
			}

			$this->data['text_agree'] = sprintf('He le&iacute;do y aceptado la <a href="%s?iframe=true&amp;width=800&amp;height=600" rel="prettyPhoto[iframe]" alt="Liberaci&oacute;n de Responsabilidad"><b>Liberaci&oacute;n de Responsabilidad</b></a>', $this->url->link('evento/evento/info', 'eventos_id=' . $this->request->get['eventos_id'], 'SSL'));
			
			if (isset($this->session->data['agree'])) { 
				$this->data['agree'] = $this->session->data['agree'];
			} else {
				$this->data['agree'] = '';
			}

		}    

		$this->template = 'catalog/transcripcion_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/transcripcion')) {
      		$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para transcricbir!';
    	}

		foreach ($this->request->post['opcion'] as $key => $value) {
			if ($key == 'Cédula') {
				if ((strlen(utf8_decode($value)) < 5) || (strlen(utf8_decode($value)) > 10)) {
					$this->error['cedula'] = '¡La cédula debe tener entre 5 y 10 caractéres!';
				}
			}

			if ($key == 'Apellido') {
				if ((strlen(utf8_decode($value)) < 2) || (strlen(utf8_decode($value)) > 48)) {
					$this->error['apellido'] = '¡El apellido debe tener entre 2 y 48 caractéres!';
				}
			}

			if ($key == 'Nombre') {
				if ((strlen(utf8_decode($value)) < 2) || (strlen(utf8_decode($value)) > 48)) {
					$this->error['nombre'] = '¡El nombre debe tener entre 2 y 48 caractéres!';
				}
			}
	
			if ($key == 'Género') {
				if ((strlen(utf8_decode($value)) == 0)) {
					$this->error['genero'] = '¡Debe seleccionar el genero!';
				}
			}
	
			if ($key == 'Fecha de Nacimiento') {
				if ((strlen(utf8_decode($value)) != 10)) {
					$this->error['fdn'] = '¡La fecha de nacimiento debe tener 10 caractéres (aaaa-mm-dd)!';
				} else {
					if (!preg_match ("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $value)) {	
						$this->error['fdn'] = '¡El formato de la fecha de nacimiento es inválido!';
					}
				}
			}
	
/*
			if ($key == 'Correo Electrónico') {
				if (!ereg("([A-Za-z0-9_.-]+@[A-Za-z0-9_.-]+\.[A-Za-z0-9_-]+)", $value)) {	
					$this->error['email'] = '¡El email es inválido!';
				}
			}
	
			if ($key == 'Celular') {
				if ((strlen(utf8_decode($value)) != 11)) {
					$this->error['cel'] = '¡El celular debe tener 11 caractéres (04141234567)!';
				} else {
					if (!ereg("^[0-9]+$",$value)) {	
						$this->error['fdn'] = '¡El celular debe tener solo numeros!';
					}
				}
			}
*/
	
			if ($key == 'País') {
				if ((strlen(utf8_decode($value)) == 0)) {
					$this->error['pais'] = '¡Debe seleccionar el país!';
				}
			}
	
			if ($key == 'Estado') {
				if ((strlen(utf8_decode($value)) == 0)) {
					$this->error['estado'] = '¡Debe seleccionar el estado!';
				}
			}
	
			if ($key == 'Grupo') {
				if ((strlen(utf8_decode($value)) == 0)) {
					$this->error['grupo'] = '¡Debe seleccionar el grupo!';
				}
			}
	
			if ($key == 'Edad') {
				if ($value == 0) {
					$this->error['edad'] = '¡La edad no puede ser 0!';
				}
			}
	
			if ($key == 'Categoría') {
				if ((strlen(utf8_decode($value)) == 0)) {
					$this->error['categoria'] = '¡La categoría no puede estar en blanco!';
				}
			}
	
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

//Apunta a Clientes / Participantes
	public function cliente() {
		
		$json = array();
		
		if (isset($this->request->get['clientes_id'])) {
			
			$this->load->model('inscripciones/participantes');
			$this->load->model('catalog/evento');

			$participante = $this->model_inscripciones_participantes->isParticipante($this->request->get['clientes_id'], $this->request->get['eventos_id']);

			if($participante) {

				$json['error'] = 'Usted ya se encuentra registrado en este evento.';

			} else {

				$this->load->model('sesion/cliente');
	
				$cliente = $this->model_sesion_cliente->isCliente($this->request->get['clientes_id']);
	
				if ($cliente) {
					
					$this->load->model('sesion/cliente');
					
					$data_clientes = array();
					$data_clientes = $this->model_sesion_cliente->getCliente($this->request->get['clientes_id']);
				
					$json['output'] = $data_clientes;

					$numeracion = $this->model_catalog_evento->getTipoNumeracion($this->request->get['eventos_id']);
		
					if($numeracion == 3) { // Tiempos = 3 Mario

						$tiempo_previo = $this->model_catalog_evento->getTiempoPrevio($this->request->get['clientes_id'], $this->request->get['eventos_id']);
						
						if (!$tiempo_previo) {
							$tiempo_previo = 'n/a';
							$json['tiempo'] = $this->model_catalog_evento->getLastIntervalosTiempo($this->request->get['eventos_id']);
						} else {
							$json['tiempo'] = $tiempo_previo;
						}
					
					}
					
					$data_categorias = array();

					$tipo_evento = $this->model_catalog_evento->getTipoByEvento($this->request->get['eventos_id']);
					$historial_circuito = $this->model_catalog_evento->getCircuitoByEvento($this->request->get['eventos_id']);
		
					if($historial_circuito == 1) { // Historial Circuito

						$eventos_anteriores = $this->model_catalog_evento->getLastEventosByTipo($tipo_evento);
						
						foreach ($eventos_anteriores as $evento_anterior) {

							$grupo_previo = $this->model_sesion_cliente->getHistorialCircuito($this->request->get['clientes_id'], $evento_anterior['evento']);

							if ($grupo_previo) {
//								echo 'El grupo del historial es: ' . $grupo_previo;
//								exit(0);	
								break;
							}

						}

						if(!$grupo_previo){
							$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $data_clientes['edad'], $data_clientes['sexo']);
						} else {
							$data_categorias = $this->model_sesion_cliente->getCategoriaCircuito($this->request->get['eventos_id'], $data_clientes['edad'], $data_clientes['sexo'], $grupo_previo);
						}

					} else {

						$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $data_clientes['edad'], $data_clientes['sexo']);
						
					}

					foreach ($data_categorias as $key => $value) {
						$json['categoria_' .$key] = $value;
					}
	
				} else {

					$participante = $this->model_sesion_cliente->isParticipante($this->request->get['clientes_id']);
		
					if($participante) {
		
						$this->load->model('sesion/cliente');
						
						$data_participantes = array();
						$data_participantes = $this->model_sesion_cliente->getParticipante($this->request->get['clientes_id']);
					
						$json['output'] = $data_participantes;
						
						$numeracion = $this->model_catalog_evento->getTipoNumeracion($this->request->get['eventos_id']);
			
						if($numeracion == 3) { // Tiempos = 3 Mario
	
							$tiempo_previo = $this->model_catalog_evento->getTiempoPrevio($this->request->get['clientes_id'], $this->request->get['eventos_id']);
							
							if (!$tiempo_previo) {
								$tiempo_previo = 'n/a';
								$json['tiempo'] = $this->model_catalog_evento->getLastIntervalosTiempo($this->request->get['eventos_id']);
							} else {
								$json['tiempo'] = $tiempo_previo;
							}
						
						}
					
						$data_categorias = array();
	
						$tipo_evento = $this->model_catalog_evento->getTipoByEvento($this->request->get['eventos_id']);
						$historial_circuito = $this->model_catalog_evento->getCircuitoByEvento($this->request->get['eventos_id']);
			
						if($historial_circuito == 1) { // Historial Circuito
	
							$eventos_anteriores = $this->model_catalog_evento->getLastEventosByTipo($tipo_evento);
							
							foreach ($eventos_anteriores as $evento_anterior) {

								$grupo_previo = $this->model_sesion_cliente->getHistorialCircuito($this->request->get['clientes_id'], $evento_anterior['evento']);

								if ($grupo_previo) {
//									echo 'El grupo del historial es: ' . $grupo_previo;
//									exit(0);	
									break;
								}

							}

							if(!$grupo_previo){
								$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $data_participantes['edad'], $data_participantes['sexo']);
							} else {
								$data_categorias = $this->model_sesion_cliente->getCategoriaCircuito($this->request->get['eventos_id'], $data_participantes['edad'], $data_participantes['sexo'], $grupo_previo);
							}

						} else {
	
							$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $data_participantes['edad'], $data_participantes['sexo']);
							
						}
	
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

	public function clienteX() {
		
		$json = array();
		
		if (isset($this->request->get['clientes_id'])) {
			
			$this->load->model('inscripciones/participantes');

			$participante = $this->model_inscripciones_participantes->isParticipante($this->request->get['clientes_id'], $this->request->get['eventos_id']);

			if($participante) {

				$json['error'] = 'Usted ya se encuentra registrado en este evento.';

			} else {

				$this->load->model('sesion/cliente');
				$this->load->model('catalog/evento');
				
				$historial_circuito = $this->model_catalog_evento->getEventoCircuito($this->request->get['eventos_id']);
				
				if ($historial_circuito == 1) {
					$grupo = $this->model_sesion_cliente->getGrupoCircuito($this->request->get['eventos_id'], $this->request->get['clientes_id']);
					if ($grupo) {
						$json['grupo'] = $grupo;
					}
				}
	
				$cliente = $this->model_sesion_cliente->isCliente($this->request->get['clientes_id']);
	
				if($cliente) {
	
					$this->load->model('sesion/cliente');
					
					$data_clientes = array();
					$data_clientes = $this->model_sesion_cliente->getCliente($this->request->get['clientes_id']);
				
					$json['output'] = $data_clientes;
					
					$numeracion = $this->model_catalog_evento->getTipoNumeracion($this->request->get['eventos_id']);
		
					if($numeracion == 3) { // Tiempos = 3

						$tiempo_previo = $this->model_catalog_evento->getTiempoPrevio($this->request->get['clientes_id'], $this->request->get['eventos_id']);
					
						$json['tiempo'] = $tiempo_previo;
					
					}
					
	
				} else {

					$persona = $this->model_sesion_cliente->isPersona($this->request->get['clientes_id']);
		
					if($persona) {
		
						$this->load->model('sesion/cliente');
						
						$data_personas = array();
						$data_personas = $this->model_sesion_cliente->getPersona($this->request->get['clientes_id']);
					
						$json['output'] = $data_personas;
						
						$numeracion = $this->model_catalog_evento->getTipoNumeracion($this->request->get['eventos_id']);
			
						if($numeracion == 3) { // Tiempos = 3
	
							$tiempo_previo = $this->model_catalog_evento->getTiempoPrevio($this->request->get['clientes_id'], $this->request->get['eventos_id']);
						
							$json['tiempo'] = $tiempo_previo;
						
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
		
		if (isset($this->request->get['paises_id'])) {

			$results = $this->model_localidad_estado->getEstadosByPaisId($this->request->get['paises_id']);

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

		}

		$this->response->setOutput($output);

	}  

	public function rango() {
		
		$output = '<option value="">--Rango--</option>';

		$this->load->model('catalog/eventos');
		
		if (isset($this->request->get['tiempo']) && isset($this->request->get['eventos_id'])) {

			$results = $this->model_catalog_eventos->getIntervalosTiempo($this->request->get['eventos_id']);

			foreach ($results as $result) {

				$output .= '<option value="' . $result['eventos_numeros_td'] . '"';

/*
				if (isset($this->request->get['tiempo']) && ($this->request->get['tiempo'] >= $result['eventos_numeros_td'] && $this->request->get['tiempo'] <= $result['eventos_numeros_th'])) {
					$output .= ' selected="selected"';
				}
*/

				$output .= '>De ' . $result['eventos_numeros_td'] . ' a ' . $result['eventos_numeros_th'] . '</option>';
				
			} 

			if (!$results) {
				$output .= '<option value="0">--Rango--</option>';
			}

			$this->response->setOutput($output);
			
		}
	}  

	public function categoria() {
		$json = array();
		
		if (isset($this->request->get['eventos_id']) && isset($this->request->get['edad']) && isset($this->request->get['sexo']) && isset($this->request->get['clientes_id'])) {
			
			$this->load->model('catalog/evento');
			$this->load->model('sesion/cliente');

			$data_categorias = array();

			$tipo_evento = $this->model_catalog_evento->getTipoByEvento($this->request->get['eventos_id']);
			$historial_circuito = $this->model_catalog_evento->getCircuitoByEvento($this->request->get['eventos_id']);

			if($historial_circuito == 1) { // Historial Circuito

				$eventos_anteriores = $this->model_catalog_evento->getLastEventosByTipo($tipo_evento);
				
				foreach ($eventos_anteriores as $evento_anterior) {

					$grupo_previo = $this->model_sesion_cliente->getHistorialCircuito($this->request->get['clientes_id'], $evento_anterior['evento']);

					if ($grupo_previo) {
//									echo 'El grupo del historial es: ' . $grupo_previo;
//									exit(0);	
						break;
					}

				}

				if(!$grupo_previo){
					$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'], $this->request->get['edad'], $this->request->get['sexo']);
				} else {
					$data_categorias = $this->model_sesion_cliente->getCategoriaCircuito($this->request->get['eventos_id'], $this->request->get['edad'],$this->request->get['sexo'], $grupo_previo);
				}

			} else {

				$data_categorias = $this->model_sesion_cliente->getCategoria($this->request->get['eventos_id'],$this->request->get['edad'], $this->request->get['sexo']);
				
			}

			foreach ($data_categorias as $key => $value) {
				$json['categoria_' .$key] = $value;
			}
				
		} else {
			
			$json['error'] = 'Debe colocar la Fecha de su Nacimiento y su Género.';
		
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));

	}

	public function categoriaX() {
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

				if ((($dia_diferencia < 0) && ($mes_diferencia == 0)) || ($mes_diferencia < 0)) {
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
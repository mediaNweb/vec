<?php 
class ControllerSaleCorrecciones extends Controller {
	private $error = array(); 
     
  	public function index() {
		    	
		$this->document->setTitle('Participantes'); 
		
		$this->load->model('inscripciones/participantes');
		$this->load->model('inscripciones/solicitud');
		
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
       		'text'      => 'Participantes',
			'href'      => $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
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
				'text' => 'Liberar Numeros',
				'href' => $this->url->link('sale/correcciones/liberar', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => 'Numeros Duplicados',
				'href' => $this->url->link('sale/correcciones/numeros', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => 'Crear Participantes',
				'href' => $this->url->link('sale/correcciones/participantes', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => 'Confirmar Participantes',
				'href' => $this->url->link('sale/correcciones/asignacion', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => 'Categorias Participantes',
				'href' => $this->url->link('sale/correcciones/edades', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
			
			$action[] = array(
				'text' => 'Validar Correos',
				'href' => $this->url->link('sale/correcciones/validacorreos', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);

			$action[] = array(
				'text' => 'Correos',
				'href' => $this->url->link('sale/correcciones/correos', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);

/*
			$action[] = array(
				'text' => 'Listado',
				'href' => $this->url->link('sale/correcciones/listado', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
*/

			$action[] = array(
				'text' => 'Celulares',
				'href' => $this->url->link('sale/correcciones/celulares', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);

/*
			$action[] = array(
				'text' => 'Status TDC',
				'href' => $this->url->link('sale/correcciones/solicitudesTDC', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);
*/			
			if ($result['eventos_logo'] && file_exists(DIR_IMAGE . $result['eventos_logo'])) {
				$image = $this->model_tool_image->resize($result['eventos_logo'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

      		$this->data['eventos'][] = array(
				'eventos_id' 				=> $result['eventos_id'],
				'eventos_titulo'       		=> $result['eventos_titulo'],
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

		$currentTimeoutInSecs = ini_get('session.gc_maxlifetime');		
		$this->data['tiempo_sesion'] = $currentTimeoutInSecs;
		
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
					
		$this->data['sort_eventos_titulo'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_titulo' . $url, 'SSL');
		$this->data['sort_eventos_privado'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_privado' . $url, 'SSL');
		$this->data['sort_eventos_tipos_nombre'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_tipos_nombre' . $url, 'SSL');
		$this->data['sort_eventos_precio'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_precio' . $url, 'SSL');
		$this->data['sort_eventos_cupos_internet'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_cupos_internet' . $url, 'SSL');
		$this->data['sort_eventos_status'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_eventos_status' . $url, 'SSL');
		$this->data['sort_eventos_orden'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . '&sort=e.eventos_orden' . $url, 'SSL');
		
		$url = '';

		$pagination = new Pagination();
		$pagination->total = $evento_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
		$pagination->url = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/correcciones_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}

	public function datos() {
		
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		
		$id_evento = $this->request->get['eventos_id'];

		$participantes_total = $this->model_inscripciones_participantes->getTotalParticipantesByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $participantes_total . ' registros.<br />';

		$participantes = 0;

		$datos_participantes = $this->model_inscripciones_participantes->getParticipantesByEvento($id_evento);

    	foreach ($datos_participantes as $participante) {

			if ($participante['eventos_participantes_apellidos'] == '') {			

				$registros = $this->model_inscripciones_participantes->getOpcionesParticipante($participante['eventos_participantes_datos'], $id_evento);
				
				foreach ($registros as $registro) {
				
					if ($registro['name'] == 'Cédula') {
						$this->model_inscripciones_participantes->updateCedulaParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Apellido') {
						$this->model_inscripciones_participantes->updateApellidosParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Nombre') {
						$this->model_inscripciones_participantes->updateNombresParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Género') {
						$this->model_inscripciones_participantes->updateGéneroParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Fecha de Nacimiento') {
						$this->model_inscripciones_participantes->updateFdNParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Correo Electrónico') {
						$this->model_inscripciones_participantes->updateEmailParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Celular') {
						$this->model_inscripciones_participantes->updateCelParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'País') {
						$this->model_inscripciones_participantes->updatePaisParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Estado') {
						$this->model_inscripciones_participantes->updateEstadoParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Edad') {
						$this->model_inscripciones_participantes->updateEdadParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Categoría') {
						$this->model_inscripciones_participantes->updateCategoriaParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
					if ($registro['name'] == 'Grupo') {
						$this->model_inscripciones_participantes->updateGrupoParticipante($participante['eventos_participantes_id'], $registro['value']);
					}
	
				}
			
				$participantes++;

			}
			
		}

		echo 'Se actualizaron: ' . $participantes . ' participantes.<br />';
		
	}

  	public function categorias() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		
		$id_evento = $this->request->get['eventos_id'];

		$participantes_total = $this->model_inscripciones_participantes->getTotalParticipantesByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $participantes_total . ' registros.<br />';

		$participantes = $this->model_inscripciones_participantes->getParticipantesByEvento($id_evento);
		
		$edades = 0;
		$categorias = 0;

/*
    	foreach ($participantes as $participante) {

			$categoria_original = $participante['eventos_participantes_categoria'];

			if($categoria_original == 'Discapacidad Motriz con Silla') {

				if ($participante['eventos_participantes_genero'] == 'M') {
					$genero = 'Masculino';
				} else {
					$genero = 'Femenino';
				}
				echo 'El genero del participante es: ' . $genero . '<br />';
				
				$grupo = $participante['eventos_participantes_grupo'];
				echo 'El grupo del participante es: ' . $grupo . '<br />';
				$categoria_original = $participante['eventos_participantes_categoria'];
				echo 'La categoria del participante es: ' . $categoria_original . '<br />';
			

				$participante_id = $participante['eventos_participantes_id'];
	
				echo 'El codigo del participante es: ' . $participante_id . '<br />';
				
				if (!$participante['eventos_participantes_edad']) {
	
					if ($participante['eventos_participantes_fdn']) {
						$fdn = $participante['eventos_participantes_fdn'];
						list($anio_fdn,$mes_fdn,$dia_fdn) = explode("-",$fdn);
						$anio_actual = (int)date('Y');
						$edad = $anio_actual - $anio_fdn;
						echo 'La edad calculada es: ' . $edad . '<br />';
						$this->model_inscripciones_participantes->corregirEdad($participante_id, $edad);
						$edades++;
					}
	
				} else {
				
					$edad = $participante['eventos_participantes_edad'];
					
				}
				
				$this->load->model('sesion/cliente');
	
				$categoria_correcta = $this->model_sesion_cliente->getCategoriaCorrecta($id_evento, $edad, $genero);
				echo 'La categoria adecuada es: ' . $categoria_correcta . '<br />';
				
				if ($categoria_original != $categoria_correcta) {
					$this->model_inscripciones_participantes->corregirCategoria($participante_id, $categoria_correcta);
					$categorias++;
					echo 'La categoria: ' . $categoria_original . ' se actualizo a: ' . $categoria_correcta . '<br />';
				}
	
	/*
				$this->data['participantes'][] = array(
					'eventos_participantes_id_pedido'   => $result['eventos_participantes_id_pedido'],
					'payment_method'					=> ($result['payment_method'] == '') ? 'Transcrita' : $result['payment_method'],
					'eventos_participantes_numero'      => $result['eventos_participantes_numero'],
					'eventos_participantes_cedula'      => $result['eventos_participantes_cedula'],
					'eventos_participantes_apellidos'   => $result['eventos_participantes_apellidos'],
					'eventos_participantes_nombres'		=> $result['eventos_participantes_nombres'],
					'eventos_participantes_genero'		=> ,
					'eventos_participantes_fdn'			=> ,
					'eventos_participantes_email'       => $result['eventos_participantes_email'],
					'eventos_participantes_cel'      	=> $result['eventos_participantes_cel'],
					'eventos_participantes_id_pais'     => $result['eventos_participantes_id_pais'],
					'eventos_participantes_id_estado'   => $result['eventos_participantes_id_estado'],
					'eventos_participantes_grupo'     	=> $result[''],
					'eventos_participantes_edad'     	=> $result['eventos_participantes_edad'],
					'eventos_participantes_categoria'   => ,
				);
*/
/*			}
			
		}
*/
		echo 'Se actualizaron: ' . $edades . ' edaes y: ' . $categorias . ' categorias.<br />';

  	} 

  	public function edades() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		$this->load->model('catalog/evento');
		
		$id_evento = $this->request->get['eventos_id'];

		$participantes_total = $this->model_inscripciones_participantes->getTotalParticipantesEdadByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $participantes_total . ' registros.<br />';

		$participantes = $this->model_inscripciones_participantes->getParticipantesEdadByEvento($id_evento);
		
		$edades = 0;
		$categorias = 0;

    	foreach ($participantes as $participante) {

			$categoria_original = $participante['eventos_participantes_categoria'];

			if ($participante['eventos_participantes_genero'] == 'M') {
				$genero = 'Masculino';
			} else {
				$genero = 'Femenino';
			}

			$historial_circuito = $this->model_catalog_evento->getCircuitoByEvento($id_evento);

			if($historial_circuito == 1) { // Historial Circuito

				$grupo = $this->model_catalog_evento->getHistorialCircuito($participante['eventos_participantes_id_cliente'], $id_evento);

			} else {

				$grupo = $participante['eventos_participantes_grupo'];
				
			}

//			$grupo = $participante['eventos_participantes_grupo'];
			$categoria_original = $participante['eventos_participantes_categoria'];
			$participante_id = $participante['eventos_participantes_id'];
			$edad = $participante['eventos_participantes_edad'];
			$fdn = $participante['eventos_participantes_fdn'];
			
			if (($categoria_original != '100 Kg o más') && ($categoria_original != 'Elite')) {
			
				if ($edad == 0) {
					if ($fdn) {
						list($anio_fdn,$mes_fdn,$dia_fdn) = explode("-",$fdn);
						$anio_diferencia  = date("Y") - $anio_fdn;
						$mes_diferencia = date("m") - $mes_fdn;
						$dia_diferencia   = date("d") - $dia_fdn;
		
						if ((($dia_diferencia < 0) && ($mes_diferencia == 0)) || ($mes_diferencia < 0)) {
							$anio_diferencia--;
						}
	
						$edad = $anio_diferencia;
						echo 'La edad es: ' . $edad . '<br />';
						$this->model_inscripciones_participantes->corregirEdad($participante_id, $edad);
						$edades++;
					}
					
				} else if (($fdn == '0000-00-00' || !$fdn)) {
	
					$anio_nuevo = date("Y") - $edad;
					$fdn_nueva = $anio_nuevo . '-01-01';
					echo 'La fecha de nacimiento es: ' . $fdn_nueva . '<br />';
					$this->model_inscripciones_participantes->corregirFdn($participante_id, $fdn_nueva);
					$edades++;
	
				}
				
				$this->load->model('sesion/cliente');
	
				$categoria_correcta = $this->model_sesion_cliente->getCategoriaCorrecta($id_evento, $edad, $genero, $grupo);
				
				if (isset($categoria_correcta) && $categoria_correcta != '') {

					if (($categoria_original == '') || ($categoria_original != $categoria_correcta)) {
						echo 'La categoria: ' . $categoria_original . ' se actualizo a: ' . $categoria_correcta . '<br />';
//						$this->model_inscripciones_participantes->corregirCategoria($participante_id, $categoria_correcta);
						$categorias++;
						echo 'La categoria: ' . $categoria_original . ' se actualizo a: ' . $categoria_correcta . '<br />';
					}
					
				}

			}

		}

		echo 'Se actualizaron: ' . $edades . ' edades y: ' . $categorias . ' categorias.<br />';

  	} 

  	public function mtb() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		
		$id_evento = $this->request->get['eventos_id'];

		$participantes_total = $this->model_inscripciones_participantes->getTotalParticipantesByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $participantes_total . ' registros.<br />';

		$participantes = $this->model_inscripciones_participantes->getParticipantesByEvento($id_evento);
		
		$edades = 0;
		$categorias = 0;
		$grupos = 0;

    	foreach ($participantes as $participante) {

			$grupo_original = $participante['eventos_participantes_grupo'];
			echo 'El grupo del participante es: ' . $grupo_original . '<br />';

			if ($participante['eventos_participantes_genero'] == 'M') {
				$genero = 'Masculino';
			} else {
				$genero = 'Femenino';
			}
//			echo 'El genero del participante es: ' . $genero . '<br />';
			
			$categoria_original = $participante['eventos_participantes_categoria'];
//			echo 'La categoria del participante es: ' . $categoria_original . '<br />';
		
			$participante_id = $participante['eventos_participantes_id'];

//			echo 'El codigo del participante es: ' . $participante_id . '<br />';
			
			if ($participante['eventos_participantes_edad'] == 0) {

				if ($participante['eventos_participantes_fdn']) {
					$fdn = $participante['eventos_participantes_fdn'];
					list($anio_fdn,$mes_fdn,$dia_fdn) = explode("-",$fdn);
					$anio_actual = (int)date('Y');
					$edad = $anio_actual - $anio_fdn;
					echo 'La edad calculada es: ' . $edad . '<br />';
					$this->model_inscripciones_participantes->corregirEdad($participante_id, $edad);
					$edades++;
				}

			} else {
			
				$edad = $participante['eventos_participantes_edad'];
				
			}
			
			$cedula = $participante['eventos_participantes_cedula'];

			$this->load->model('sesion/cliente');

			$grupo_correcto = $this->model_sesion_cliente->getGrupoCircuito($id_evento, $cedula);
			
			if ($grupo_correcto) {
				echo 'El grupo adecuado es: ' . $grupo_correcto . '<br />';
			} else {
				$grupo_correcto = $grupo_original;
				echo 'El grupo adecuado es: ' . $grupo_correcto . '<br />';
			}
			
			$categoria_correcta = $this->model_sesion_cliente->getCategoriaCorrecta($id_evento, $edad, $genero, $grupo_correcto);
			echo 'La categoria adecuada es: ' . $categoria_correcta . '<br />';
			
			if ($grupo_original != $grupo_correcto) {
				echo 'La cedula del participante es: ' . $cedula . '<br />';
				$this->model_inscripciones_participantes->corregirGrupo($participante_id, $grupo_correcto);
				$grupos++;
				echo 'El grupo: ' . $grupo_original . ' se actualizo a: ' . $grupo_correcto . '<br />';
				$this->model_inscripciones_participantes->corregirCategoria($participante_id, $categoria_correcta);
				$categorias++;
				echo 'La categoria: ' . $categoria_original . ' se actualizo a: ' . $categoria_correcta . '<br />';
			}

		}

		echo 'Se actualizaron: ' . $edades . ' edaes, ' . $grupos . ' grupos y: ' . $categorias . ' categorias.<br />';

  	} 

  	public function cantidades() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/solicitud');

		$id_evento = $this->request->get['eventos_id'];

		$solicitudes_total = $this->model_inscripciones_solicitud->getTotalSolicitudesByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $solicitudes_total . ' registros.<br />';

		$solicitudes_duplicadas = $this->model_inscripciones_solicitud->getSolicitudesByEvento($id_evento);

		$solicitudes = 0;

    	foreach ($solicitudes_duplicadas as $solicitud_duplicada) {

			$solicitud_id = $solicitud_duplicada['order_id'];
			$cantidad = 1;
			$monto = $solicitud_duplicada['price'];
			$monto_txt = 'Bs. ' . (int)$monto . ',00';

			echo 'El codigo de la solicitud es: ' . $solicitud_id . '<br />';
			echo 'El monto en texto es: ' . $monto_txt . '<br />';

			$this->model_inscripciones_solicitud->corregirSolicitud($solicitud_id, $monto);
			$this->model_inscripciones_solicitud->corregirSolicitudEvento($solicitud_id, $cantidad, $monto);
			$this->model_inscripciones_solicitud->corregirSolicitudTotal($solicitud_id, $monto, $monto_txt);

			$solicitudes++;
			
		}

		echo 'Se actualizaron: ' . $solicitudes . ' solicitudes.<br />';

  	} 

  	public function participantes() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		$this->load->model('inscripciones/solicitud');

		$id_evento = $this->request->get['eventos_id'];

		$registros_total = $this->model_inscripciones_participantes->getTotalCedulasNumerosByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $registros_total . ' registros.<br />';

		$participantes_nuevos = $this->model_inscripciones_participantes->getCedulasNumerosByEvento($id_evento);

		$participantes = 0;

    	foreach ($participantes_nuevos as $participante_nuevo) {

			$cedula = $participante_nuevo['eventos_numeros_id_cliente'];
			$numero = $participante_nuevo['eventos_numeros_numero'];

			echo 'El numero de cedula: ' . $cedula . ' tiene el numero de participacion: ' . $numero . '.<br />';

			$solicitud_opcion = $this->model_inscripciones_solicitud->getSolicitudOpcionByCedula($cedula, $id_evento);
			
			if ($solicitud_opcion) {

				$solicitud = $solicitud_opcion['order_id'];
				$opcion = $solicitud_opcion['order_product_id'];
	
				$apellidos = $this->model_inscripciones_participantes->getParticipanteApellido($solicitud, $opcion, $id_evento);
				$nombres = $this->model_inscripciones_participantes->getParticipanteNombre($solicitud, $opcion, $id_evento);
				$genero = $this->model_inscripciones_participantes->getParticipanteGenero($solicitud, $opcion, $id_evento);
				$fdn = $this->model_inscripciones_participantes->getParticipanteFdn($solicitud, $opcion, $id_evento);
				$email = $this->model_inscripciones_participantes->getParticipanteEmail($solicitud, $opcion, $id_evento);
				$cel = $this->model_inscripciones_participantes->getParticipanteCelular($solicitud, $opcion, $id_evento);
				$id_pais = $this->model_inscripciones_participantes->getParticipantePais($solicitud, $opcion, $id_evento);
				$id_estado = $this->model_inscripciones_participantes->getParticipanteEstado($solicitud, $opcion, $id_evento);
				$grupo = $this->model_inscripciones_participantes->getParticipanteGrupo($solicitud, $opcion, $id_evento);
				$edad = $this->model_inscripciones_participantes->getParticipanteEdad($solicitud, $opcion, $id_evento);
				$categoria = $this->model_inscripciones_participantes->getParticipanteCategoria($solicitud, $opcion, $id_evento);
				$byscript = 'Website';
				$inscripcion = 'Internet';
				$planilla = '';
				$datos = $opcion;
				$fdc = $this->model_inscripciones_solicitud->getFechaSolicitud($solicitud);
	
				$data_participante = array();
				
				$data_participante = array(
					'eventos_participantes_id_evento' 	=> $id_evento,
					'eventos_participantes_id_pedido' 	=> $solicitud,
					'eventos_participantes_id_cliente'	=> $cedula,
					'eventos_participantes_numero'		=> $numero,
					'eventos_participantes_cedula'		=> $cedula,
					'eventos_participantes_apellidos'	=> $apellidos,
					'eventos_participantes_nombres'		=> $nombres,
					'eventos_participantes_genero'		=> $genero,
					'eventos_participantes_fdn'			=> $fdn,
					'eventos_participantes_email'		=> $email,
					'eventos_participantes_cel'			=> $cel,
					'eventos_participantes_id_pais'		=> $id_pais,
					'eventos_participantes_id_estado'	=> $id_estado,
					'eventos_participantes_grupo'		=> $grupo,
					'eventos_participantes_edad'		=> $edad,
					'eventos_participantes_categoria'	=> $categoria,
					'eventos_participantes_byscript'	=> $byscript,
					'eventos_participantes_inscripcion'	=> $inscripcion,
					'eventos_participantes_planilla'	=> $planilla,
					'eventos_participantes_datos'		=> $datos,
					'eventos_participantes_fdc'			=> $fdc,
				);
	
				$this->model_inscripciones_participantes->agregaParticipante($id_evento, $cedula, $data_participante);
	
				echo 'Se creo el registro de participantes.<br />';
	
				$participantes++;

			}
			
		}

		echo 'Se crearon: ' . $participantes . ' participantes.<br />';

  	} 

  	public function liberar() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');

		$id_evento = $this->request->get['eventos_id'];

		$cedulas_total = $this->model_inscripciones_participantes->getTotalCedulasDuplicadasByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $cedulas_total . ' registros.<br />';

		$cedulas_duplicadas = $this->model_inscripciones_participantes->getCedulasDuplicadasByEvento($id_evento);

		$cedulas = 0;

    	foreach ($cedulas_duplicadas as $cedula_duplicada) {

			$cedula = $cedula_duplicada['eventos_numeros_id_cliente'];

			$numero = $this->model_inscripciones_participantes->getNumerosByCedula($cedula, $id_evento);

			if ($numero) {

				echo 'El numero es: ' . $numero . '<br />';

				$this->model_inscripciones_participantes->liberarNumeros($cedula, $id_evento, $numero);

				$cedulas++;

			} else {
			
				echo 'La cedula: ' . $cedula . ' no tiene registro en Participantes.<br />';
				
			}
			
		}

		echo 'Se actualizaron: ' . $cedulas . ' solicitudes.<br />';

  	} 

  	public function numeros() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/numeros');
		$this->load->model('inscripciones/participantes');

		$id_evento = $this->request->get['eventos_id'];

		$numeros_total = $this->model_inscripciones_participantes->getTotalNumerosDuplicadosByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $numeros_total . ' registros.<br />';

		$numeros_duplicados = $this->model_inscripciones_participantes->getNumerosDuplicadosByEvento($id_evento);

		$numeros = 0;

    	foreach ($numeros_duplicados as $numero_duplicado) {

			$numero_ant = $numero_duplicado['eventos_participantes_numero'];
			$cedula_dup = $this->model_inscripciones_participantes->getCedulaByNumero($numero_ant, $id_evento);

			echo 'El numero anterior del participante es: ' . $numero_ant . '<br />';

			if ($cedula_dup) {

				$participante_data = $this->model_inscripciones_participantes->getDatosParticipanteND($cedula_dup, $id_evento);

				foreach ($participante_data as $dato) {
	
					$codigo_evento = $id_evento;
					$codigo_opcion = $dato['eventos_participantes_datos'];
					$cedula = $cedula_dup;
					$categoria = $dato['eventos_participantes_categoria'];
					$tiempo = '';
					$grupo = $dato['eventos_participantes_grupo'];
					
					$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);
					echo 'El numero para el participante es: ' . $numero . '<br />';
		
					$this->model_inscripciones_participantes->corregirNumeroParticipanteND($codigo_evento, $cedula, $numero);
					
					echo 'Se corrigio el participante: ' . $cedula . ' con el numero: ' . $numero . '<br />';
	
				}

				$numeros++;

			}
			
		}

		echo 'Se actualizaron: ' . $numeros . ' registros.<br />';

  	} 

  	public function tdc() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');

		$id_evento = $this->request->get['eventos_id'];

		$solicitudes_total = $this->model_inscripciones_participantes->getTotalSolicitudesTDCByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $solicitudes_total . ' registros.<br />';

		$solicitudes_tdc = $this->model_inscripciones_participantes->getSolicitudesTDCByEvento($id_evento);

		$solicitudes = 0;

    	foreach ($solicitudes_tdc as $solicitud_tdc) {

			$participante_id = $solicitud_tdc['eventos_participantes_id'];
			$solicitud_mala = $solicitud_tdc['eventos_participantes_id_pedido'];
			$cedula_pago = $this->model_inscripciones_participantes->getCedulaBySolicitud($solicitud_mala);
			$datos_buenos = $this->model_inscripciones_participantes->getSolicitudOpcionByTDC($id_evento, $cedula_pago);

			if ($datos_buenos) {
//				print_r($datos_buenos);
				$solicitud_buena = $datos_buenos['solicitud'];
				$solicitud_datos = $datos_buenos['datos'];

				echo 'La solicitud correcta del participante: ' . $participante_id . ' es: ' . $solicitud_buena . ' y datos: ' . $solicitud_datos . '<br />';

//				$this->model_inscripciones_participantes->corrigeParticipantes($solicitud_buena, $id_evento, $solicitud_datos, $participante_id);

//				$this->model_inscripciones_participantes->reconfirmarSolicitud($solicitud_buena);

				$solicitudes++;

			} else {
			
				echo 'No existe solicitud correcta.<br />';
				
			}
			
		}

		echo 'Se actualizaron: ' . $solicitudes . ' solicitudes.<br />';

  	} 

  	public function transcritos() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/numeros');
		$this->load->model('inscripciones/participantes');

		$id_evento = $this->request->get['eventos_id'];

		$transcripciones_total = $this->model_inscripciones_participantes->getTotalTranscritosByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $transcripciones_total . ' registros.<br />';

		$transcripciones = $this->model_inscripciones_participantes->getTranscritosByEvento($id_evento);

		$participantes = 0;

    	foreach ($transcripciones as $transcripcion) {
			
/*
			$solicitud = $transcripcion['eventos_participantes_id_pedido'];
			$datos = $transcripcion['eventos_participantes_datos'];
			$cedula = $transcripcion['eventos_participantes_cedula'];
			$categoria = $transcripcion['eventos_participantes_categoria'];
			$tiempo = '';
			$numero = $this->model_inscripciones_numeros->getNumero($id_evento, $cedula, $categoria, $tiempo, $grupo);
	
//			$this->model_inscripciones_participantes->confirmaTranscritos($cedula, $solicitud, $id_evento, $numero, $datos);
*/
			echo 'El participante tiene el numero: ' . $transcripcion['eventos_participantes_id'] . '<br />';

			$participantes++;
			
		}

		echo 'Se actualizaron: ' . $participantes . ' solicitudes.<br />';

  	} 

  	public function reconfirmar() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		$this->load->model('inscripciones/numeros');

		$id_evento = $this->request->get['eventos_id'];

		$solicitudes_total = $this->model_inscripciones_participantes->getTotalSolicitudesConfirmadasByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $solicitudes_total . ' registros.<br />';

		$solicitudes_confirmadas = $this->model_inscripciones_participantes->getSolicitudesConfirmadasByEvento($id_evento);

		$solicitudes = 0;

    	foreach ($solicitudes_confirmadas as $solicitud_confirmada) {

			$solicitud_confirmada = $solicitud_confirmada['eventos_participantes_id_pedido'];

			$solicitudes_sin_confirmar = $this->model_inscripciones_participantes->getDatosSCByEvento($id_evento, $solicitud_confirmada);

			foreach ($solicitudes_sin_confirmar as $solicitud_sin_confirmar) {

				$codigo_evento = $id_evento;
				$codigo_opcion = $solicitud_sin_confirmar['eventos_participantes_datos'];
				$cedula = $solicitud_sin_confirmar['eventos_participantes_cedula'];
				$categoria = $solicitud_sin_confirmar['eventos_participantes_categoria'];
				$tiempo = '';
				$grupo = $solicitud_sin_confirmar['eventos_participantes_grupo'];
				
				$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);
	
//				$this->model_inscripciones_participantes->confirm($cedula, $solicitud_confirmada, $codigo_evento, $numero, $codigo_opcion);
			
				echo 'Se confirmo el participante: ' . $cedula . ' con el numero: ' . $numero . '<br />';

			}

			$solicitudes++;

		}

		echo 'Se actualizaron: ' . $solicitudes . ' solicitudes.<br />';

  	} 

  	public function solicitudesTDC() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/solicitud');

		$id_evento = $this->request->get['eventos_id'];

		$solicitudes_total = $this->model_inscripciones_solicitud->getTotalSolicitudesTDC();
		
		echo 'Se van a verificar: ' . $solicitudes_total . ' registros.<br />';

		$solicitudes_TDC = $this->model_inscripciones_solicitud->getSolicitudesTDC();

		$solicitudes = 0;

    	foreach ($solicitudes_TDC as $solicitud_TDC) {

			$solicitud_id = $solicitud_TDC['solicitud'];

			$this->model_inscripciones_solicitud->actualizaStatusSolicitudTDC($solicitud_id);

			echo 'El Status de la Solicitud: ' . $solicitud_id . ' fue modificado.<br />';

			$solicitudes++;
			
		}

		echo 'Se actualizaron: ' . $solicitudes . ' solicitudes.<br />';

  	} 

  	public function asignacion() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		$this->load->model('inscripciones/numeros');

		$id_evento = $this->request->get['eventos_id'];

		$participantes_total = $this->model_inscripciones_participantes->getTotalParticipantesSinConfirmarByEvento($id_evento);
		
		echo 'Se van a verificar: ' . $participantes_total . ' registros.<br />';

		$participantes_sin_confirmar = $this->model_inscripciones_participantes->getParticipantesSinConfirmarByEvento($id_evento);

		$participantes = 0;

    	foreach ($participantes_sin_confirmar as $participante_sin_confirmar) {

			$codigo_evento = $id_evento;
			$solicitud = $participante_sin_confirmar['eventos_participantes_id_pedido'];
			$codigo_opcion = $participante_sin_confirmar['eventos_participantes_datos'];
			$cedula = $participante_sin_confirmar['eventos_participantes_cedula'];
			$categoria = $participante_sin_confirmar['eventos_participantes_categoria'];
			$tiempo = $participante_sin_confirmar['eventos_participantes_tiempo'];
			$grupo = $participante_sin_confirmar['eventos_participantes_grupo'];
			
			$numero = $this->model_inscripciones_numeros->getNumero($codigo_evento, $cedula, $categoria, $tiempo, $grupo);

			$this->model_inscripciones_participantes->confirm($cedula, $solicitud, $codigo_evento, $numero, $codigo_opcion);
		
			echo 'Se confirmo el participante: ' . $cedula . ' con el numero: ' . $numero . '<br />';


			$participantes++;

		}

		echo 'Se actualizaron: ' . $participantes . ' registros.<br />';

  	} 

  	public function progreso() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('inscripciones/participantes');
		$this->load->model('inscripciones/numeros');

		$id_evento = $this->request->get['eventos_id'];

		$participantes_total = $this->model_inscripciones_participantes->getTotalParticipantesSinConfirmarByEvento($id_evento);
		
		$participantes_sin_confirmar = $this->model_inscripciones_participantes->getParticipantesSinConfirmarByEvento($id_evento);

		$participantes = 0;

    	foreach ($participantes_sin_confirmar as $participante_sin_confirmar) {

			$participantes++;
			$porcentaje = $participantes * 100 / $participantes_total;
			echo $porcentaje . '<br />';

		}

  	} 

  	public function validacorreos() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$id_evento = $this->request->get['eventos_id'];

		$this->load->model('correos/correos');
		$this->load->model('inscripciones/participantes');

		$correos_total = $this->model_correos_correos->getTotalCorreosParticipantes($id_evento);
		
		$correos_revision = $this->model_correos_correos->getCorreosParticipantes($id_evento);

		$correos = 0;

		if (ob_get_level() == 0) ob_start();

    	foreach ($correos_revision as $correo_revision) {

			$valido = $this->validaEmail($correo_revision['eventos_participantes_email']);
			
			if (!$valido) {
				
				echo 'El correo: ' . $correo_revision['eventos_participantes_email'] . 'es inválido.<br />';
				$this->model_inscripciones_participantes->corregirEmail($correo_revision['eventos_participantes_id'], '');
				$correos++;

			}

			ob_flush();
			flush();

		}

		ob_end_flush();		

		echo 'Se modificaron ' . $correos . ' correos';

  	} 

  	public function correos() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('correos/correos');

		$correos_total = $this->model_correos_correos->getTotalCorreos();
		
		$correos_revision = $this->model_correos_correos->getCorreos();

		$correos = 0;

		if (ob_get_level() == 0) ob_start();

    	foreach ($correos_revision as $correo_revision) {

			$valido = $this->validaEmail($correo_revision['correo']);
			
			if (!$valido) {
				
				echo 'El correo: ' . $correo_revision['correo'] . 'es inválido.<br />';
				$this->model_correos_correos->errorCorreos($correo_revision['id']);
				$correos++;

			}

			ob_flush();
			flush();

		}

		ob_end_flush();		

		echo 'Se modificaron ' . $correos . ' correos';

  	} 

  	public function listado() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('correos/correos');

		$correos_personas = $this->model_correos_correos->getCorreosPersonas();
		$correos_clientes = $this->model_correos_correos->getCorreosClientes();
		$correos_participantes = $this->model_correos_correos->getCorreosParticipantes();

		if (ob_get_level() == 0) ob_start();

		$correos = 0;

    	foreach ($correos_personas as $correo_personas) {

			$valido = $this->validaEmail($correo_personas['mail']);
			
			if (!$valido) {
				
				echo 'El correo: ' . $correo_personas['mail'] . 'es inválido.<br />';

			} else {
				
				$cadena = $this->limpiarEmail($correo_personas['mail']);
				$existente = $this->model_correos_correos->ExisteCorreo($correo_personas['mail']);

				if (!$existente) {

					$this->model_correos_correos->AgregaCorreos($correo_personas['nombre'], $cadena);
					$correos++;
				
				}
			}

			ob_flush();
			flush();

		}

    	foreach ($correos_clientes as $correo_clientes) {

			$valido = $this->validaEmail($correo_clientes['mail']);
			
			if (!$valido) {
				
				echo 'El correo: ' . $correo_clientes['mail'] . 'es inválido.<br />';

			} else {
				
				$cadena = $this->limpiarEmail($correo_clientes['mail']);
				$existente = $this->model_correos_correos->ExisteCorreo($cadena);

				if (!$existente) {

					$this->model_correos_correos->AgregaCorreos($correo_clientes['nombre'], $cadena);
					$correos++;
					
				}

			}

			ob_flush();
			flush();

		}

    	foreach ($correos_participantes as $correo_participantes) {

			$valido = $this->validaEmail($correo_participantes['mail']);
			
			if (!$valido) {
				
				echo 'El correo: ' . $correo_participantes['mail'] . 'es inválido.<br />';

			} else {
				
				$cadena = $this->limpiarEmail($correo_participantes['mail']);
				$existente = $this->model_correos_correos->ExisteCorreo($correo_participantes['mail']);

				if (!$existente) {

					$this->model_correos_correos->AgregaCorreos($correo_participantes['nombre'], $cadena);
					$correos++;
				
				}
			}

			ob_flush();
			flush();

		}

		ob_end_flush();		

		echo 'Se agregaron ' . $correos . ' correos';

  	} 

  	public function celulares() {
    	
		$this->load->idioma('sale/correcciones');

		$this->document->setTitle($this->idioma->get('heading_title'));

		$this->load->model('celulares/celulares');

		$celulares_personas = $this->model_celulares_celulares->getCelularesPersonas();
		$celulares_clientes = $this->model_celulares_celulares->getCelularesClientes();
		$celulares_participantes = $this->model_celulares_celulares->getCelularesParticipantes();

		if (ob_get_level() == 0) ob_start();

		$celulares = 0;

    	foreach ($celulares_clientes as $celular_clientes) {

			$existente = $this->model_celulares_celulares->ExisteCelular($celular_clientes['cedula'], $celular_clientes['celular']);

			if (!$existente) {

//				$this->model_celulares_celulares->AgregaCelulares($celular_clientes['cedula'], $celular_clientes['nombre'], $celular_clientes['email'], $celular_clientes['celular'], $celular_clientes['pin'], $celular_clientes['twitter']);

				$this->model_celulares_celulares->AgregaCelulares($celular_clientes['cedula'], $celular_clientes['nombre'], $celular_clientes['celular']);

				$celulares++;
			
			}

			ob_flush();
			flush();

		}

    	foreach ($celulares_personas as $celular_personas) {

			$existente = $this->model_celulares_celulares->ExisteCelular($celular_personas['cedula'], $celular_personas['celular']);

			if (!$existente) {

//				$this->model_celulares_celulares->AgregaCelulares($celular_personas['cedula'], $celular_personas['nombre'], $celular_personas['email'], $celular_personas['celular'], '', $celular_personas['twitter']);

				$this->model_celulares_celulares->AgregaCelulares($celular_personas['cedula'], $celular_personas['nombre'], $celular_personas['celular']);

				$celulares++;
			
			}

			ob_flush();
			flush();

		}

    	foreach ($celulares_participantes as $celular_participantes) {

			$existente = $this->model_celulares_celulares->ExisteCelular($celular_participantes['cedula'], $celular_participantes['celular']);

			if (!$existente) {

//				$this->model_celulares_celulares->AgregaCelulares($celular_participantes['cedula'], $celular_participantes['nombre'], $celular_participantes['email'], $celular_participantes['celular'], '', '');

				$this->model_celulares_celulares->AgregaCelulares($celular_participantes['cedula'], $celular_participantes['nombre'], $celular_participantes['celular']);

				$celulares++;
			
			}

			ob_flush();
			flush();

		}

		ob_end_flush();		

		echo 'Se agregaron ' . $celulares . ' celulares';

  	} 

	public function limpiarEmail($email) { 

		$email = str_replace('á', 'a', $email); 
		$email = str_replace('Á', 'A', $email); 
		$email = str_replace('é', 'e', $email); 
		$email = str_replace('É', 'E', $email); 
		$email = str_replace('í', 'i', $email); 
		$email = str_replace('Í', 'I', $email); 
		$email = str_replace('ó', 'o', $email); 
		$email = str_replace('Ó', 'O', $email); 
		$email = str_replace('Ú', 'U', $email); 
		$email= str_replace('ú', 'u', $email); 
	
		//Quitando Caracteres Especiales 
		$email= str_replace('"', '', $email); 
		$email= str_replace('\'', '', $email); 
		$email= str_replace(':', '', $email); 
//		$email= str_replace('.', '', $email); 
		$email= str_replace(',', '', $email); 
		$email= str_replace(';', '', $email); 

		return $email; 

	}

	public function limpiarCellar($celular) { 

		$celular = str_replace('á', 'a', $celular); 
		$celular = str_replace('Á', 'A', $celular); 
		$celular = str_replace('é', 'e', $celular); 
		$celular = str_replace('É', 'E', $celular); 
		$celular = str_replace('í', 'i', $celular); 
		$celular = str_replace('Í', 'I', $celular); 
		$celular = str_replace('ó', 'o', $celular); 
		$celular = str_replace('Ó', 'O', $celular); 
		$celular = str_replace('Ú', 'U', $celular); 
		$celular= str_replace('ú', 'u', $celular); 
	
		//Quitando Caracteres Especiales 
		$celular= str_replace('"', '', $celular); 
		$celular= str_replace('\'', '', $celular); 
		$celular= str_replace(':', '', $celular); 
//		$celular= str_replace('.', '', $celular); 
		$celular= str_replace(',', '', $celular); 
		$celular= str_replace(';', '', $celular); 

		return $celular; 

	}

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
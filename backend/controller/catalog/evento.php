<?php
class ControllerCatalogEvento extends Controller
{
	private $error = array();

	public function index()
	{

		$this->document->setTitle('Evenementen');

		$this->load->model('catalog/evento');

		$this->getList();
	}

	public function insert()
	{

		$this->document->setTitle('Evenementen');

		$this->load->model('catalog/evento');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_evento->addEvento($this->request->post);

			$this->session->data['success'] = 'U heeft een nieuw evenement aangemaakt!';

			$url = '';

			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}

			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
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

	public function update()
	{


		//		ini_set('error_reporting', E_ALL);

		$this->document->setTitle('Evenementen');

		$this->load->model('catalog/evento');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$id_evento = $this->request->get['eventos_id'];

			$this->model_catalog_evento->editEvento($this->request->get['eventos_id'], $this->request->post);

			/*
			if (!empty($this->request->files['eventos_imagen_home']['name'])) {
				$logo_evento = new Cloudfiles();
				$logo_evento->upload($this->request->files['eventos_imagen_home']['tmp_name'], $this->request->files['eventos_imagen_home']['name']);
				$this->model_catalog_evento->updateHomeEvento($id_evento, $logo_evento->getPath());
			}

			if (!empty($this->request->files['eventos_imagen_header']['name'])) {
				$logo_evento = new Cloudfiles();
				$logo_evento->upload($this->request->files['eventos_imagen_header']['tmp_name'], $this->request->files['eventos_imagen_header']['name']);
				$this->model_catalog_evento->updateHeaderEvento($id_evento, $logo_evento->getPath());
			}
*/
			if (isset($this->request->files['resultados_carga']['tmp_name'])) {

				//				if (is_uploaded_file($this->request->files['resultados_carga']['tmp_name'])) {

				$filename = 'resultados_' . $id_evento . '.csv';

				//					if(!move_uploaded_file($this->request->files['resultados_carga']['tmp_name'], DIR_UPLOAD . $filename)) {
				if (move_uploaded_file($this->request->files['resultados_carga']['tmp_name'], DIR_UPLOAD . $filename)) {

					//						echo 'Het bestand kon niet worden geladen De bijzonderheden:' . print_r($_FILES);

					//					} else {

					//						echo 'Het bestand is correct geladen!';

					if (file_exists(DIR_UPLOAD . $filename)) {
						$contenido = DIR_UPLOAD . $filename;
						//							echo $contenido;
						//							exit(0);
						$this->model_catalog_evento->importarResultadosEvento($this->request->get['eventos_id'], $contenido);
					}
				}
				//				}
			}

			$this->session->data['success'] = 'Je hebt het evenement informatie gewijzigd!';

			$url = '';

			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}

			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
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

	public function delete()
	{


		$this->document->setTitle('Evenementen');

		$this->load->model('catalog/evento');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $eventos_id) {
				$this->model_catalog_evento->deleteEvento($eventos_id);
			}

			$this->session->data['success'] = 'Je hebt gewijzigd gebeurtenissen!';

			$url = '';

			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}

			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
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

	public function copy()
	{


		$this->document->setTitle('Evenementen');

		$this->load->model('catalog/evento');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $eventos_id) {
				$this->model_catalog_evento->copyEvento($eventos_id);
			}

			$this->session->data['success'] = 'Je hebt gewijzigd gebeurtenissen!';

			$url = '';

			if (isset($this->request->get['filter_eventos_titulo'])) {
				$url .= '&filter_eventos_titulo=' . $this->request->get['filter_eventos_titulo'];
			}

			if (isset($this->request->get['filter_eventos_tipos_nombre'])) {
				$url .= '&filter_eventos_tipos_nombre=' . $this->request->get['filter_eventos_tipos_nombre'];
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

	private function getList()
	{
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

		if (isset($this->request->get['filter_eventos_year'])) {
			$filter_eventos_year = $this->request->get['filter_eventos_year'];
		} else {
			$filter_eventos_year = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'e.eventos_status';
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

		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}

		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
		}

		if (isset($this->request->get['filter_eventos_year'])) {
			$url .= '&filter_eventos_year=' . $this->request->get['filter_eventos_year'];
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
			'text'      => 'Huis',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => 'Evenementen',
			'href'      => $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/evento/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('catalog/evento/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/evento/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['years'] = $this->model_catalog_evento->getEventosYears();

		$this->data['eventos'] = array();

		$data = array(
			'filter_eventos_titulo'	  		=> $filter_eventos_titulo,
			'filter_eventos_tipos_nombre'	=> $filter_eventos_tipos_nombre,
			'filter_eventos_cupos_internet'	=> $filter_eventos_cupos_internet,
			'filter_eventos_status'   		=> $filter_eventos_status,
			'filter_eventos_year'   		=> $filter_eventos_year,
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
				'text' => 'Uitgeven',
				'href' => $this->url->link('catalog/evento/update', 'token=' . $this->session->data['token'] . '&eventos_id=' . $result['eventos_id'] . $url, 'SSL')
			);

			if ($result['eventos_imagen_home'] && file_exists(DIR_IMAGE . $result['eventos_imagen_home'])) {
				$image = $this->model_tool_image->resize($result['eventos_imagen_home'], 100, 100);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			}

			$this->data['eventos'][] = array(
				'eventos_id' 				=> $result['eventos_id'],
				'eventos_titulo'       		=> $result['eventos_titulo'],
				'eventos_tipo_nombre'      	=> $this->model_catalog_evento->getTipo($result['eventos_id']),
				'eventos_logo'      		=> $image,
				'eventos_cupos_apertura'	=> $result['eventos_cupos_apertura'],
				'eventos_cupos_internet'	=> $result['eventos_cupos_internet'],
				'eventos_status'     		=> ($result['eventos_status'] ? 'Enabled' : 'Disabled'),
				'eventos_inscripciones'     => ($result['eventos_inscripciones'] ? 'Enabled' : 'Disabled'),
				'selected'   				=> isset($this->request->post['selected']) && in_array($result['eventos_id'], $this->request->post['selected']),
				'action'     				=> $action
			);
		}

		$this->data['heading_title'] = 'Evenementen';

		$this->data['text_all'] = ' --- Alle --- ';
		$this->data['text_enabled'] = 'Enabled';
		$this->data['text_disabled'] = 'Disabled';
		$this->data['text_no_results'] = 'Geen resultaat';
		$this->data['text_image_manager'] = 'Afbeelding Manager';

		$this->data['column_image'] = 'Afbeelding';
		$this->data['column_eventos_titulo'] = 'Evenement naam';
		$this->data['column_eventos_tipos_nombre'] = 'Type';
		$this->data['column_eventos_cupos_internet'] = 'Het openen van de quota';
		$this->data['column_eventos_cupos_internet'] = 'Quota voor Internet';
		$this->data['column_eventos_status'] = 'Staat';
		$this->data['column_action'] = 'Actie';

		$this->data['button_copy'] = 'Exemplaar';
		$this->data['button_insert'] = 'Toevoegen';
		$this->data['button_delete'] = 'Verwijderen';
		$this->data['button_filter'] = 'Filter';

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

		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}

		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
		}

		if (isset($this->request->get['filter_eventos_year'])) {
			$url .= '&filter_eventos_year=' . $this->request->get['filter_eventos_year'];
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
		$this->data['sort_eventos_tipos_nombre'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . '&sort=e.eventos_tipos_nombre' . $url, 'SSL');
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

		if (isset($this->request->get['filter_eventos_cupos_internet'])) {
			$url .= '&filter_eventos_cupos_internet=' . $this->request->get['filter_eventos_cupos_internet'];
		}

		if (isset($this->request->get['filter_eventos_status'])) {
			$url .= '&filter_eventos_status=' . $this->request->get['filter_eventos_status'];
		}

		if (isset($this->request->get['filter_eventos_year'])) {
			$url .= '&filter_eventos_year=' . $this->request->get['filter_eventos_year'];
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
		$pagination->text = 'Resultaat {start} te {end} van {total} ({pages} Pages)';
		$pagination->url = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_eventos_titulo'] = $filter_eventos_titulo;
		$this->data['filter_eventos_tipos_nombre'] = $filter_eventos_tipos_nombre;
		$this->data['filter_eventos_cupos_internet'] = $filter_eventos_cupos_internet;
		$this->data['filter_eventos_status'] = $filter_eventos_status;
		$this->data['filter_eventos_year'] = $filter_eventos_year;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/evento_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function getForm()
	{
		$this->data['heading_title'] = 'Evenementen';

		$this->data['text_enabled'] = 'Enabled';
		$this->data['text_disabled'] = 'Disabled';
		$this->data['text_none'] = ' --- Geen --- ';
		$this->data['text_yes'] = 'Als';
		$this->data['text_no'] = 'Niet';
		$this->data['text_select_all'] = 'Kiezen Alle';
		$this->data['text_unselect_all'] = 'Kiezen Geen';
		$this->data['text_plus'] = '+';
		$this->data['text_minus'] = '-';
		$this->data['text_default'] = ' <b>(Standaard)</b>';
		$this->data['text_image_manager'] = 'Afbeelding Manager';
		$this->data['text_opcion'] = 'Optie';
		$this->data['text_opcion_valor'] = 'Waarde  Optie';
		$this->data['text_select'] = ' --- Kiezen --- ';
		$this->data['text_none'] = ' --- Geen --- ';
		$this->data['text_percent'] = 'Percentage';
		$this->data['text_amount'] = 'Vast Bedraga';

		$this->data['entry_eventos_status'] = 'Staat:';
		$this->data['entry_eventos_home'] = 'Show in huis:';
		$this->data['entry_eventos_revista'] = 'Show magazine:';
		$this->data['entry_eventos_certificado'] = 'Show certificate:';
		$this->data['entry_eventos_certificado_foto'] = 'Show pictures in certificate:';
		$this->data['entry_eventos_inscripciones'] = 'Registratie:';
		$this->data['entry_eventos_fecha_disponible'] = 'Datum Beschikbaar:';
		$this->data['entry_eventos_tipo'] = 'Event Type:';
		$this->data['entry_eventos_orden'] = 'Order:';
		$this->data['entry_eventos_titulo'] = 'Evenement naam:';
		$this->data['entry_eventos_fecha'] = 'Date Event:';
		$this->data['entry_eventos_hora'] = 'Time Event:';
		$this->data['entry_eventos_lugar'] = 'Evenementenlocatie:';
		$this->data['entry_eventos_impuesto'] = 'Belasting:';
		$this->data['entry_eventos_cupos_apertura'] = 'Het openen van de quota:';
		$this->data['entry_eventos_cupos'] = 'Quota voor Internet:';
		$this->data['entry_eventos_afiche'] = 'Show Poster:';
		$this->data['entry_eventos_redireccion'] = 'Resultaat redirect URL:';
		$this->data['entry_eventos_controles'] = 'Controlepunten Bericht:';
		$this->data['entry_eventos_redireccion_url'] = 'URL Resultaat:';
		$this->data['entry_meta_description'] = 'Meta Tag Description:';
		$this->data['entry_meta_keyword'] = 'Meta Tag Keywords:';
		$this->data['entry_eventos_descripcion_resultados_url'] = 'URL Resultaat:';
		$this->data['entry_eventos_logo'] = 'Logotipo del Evento:';
		$this->data['entry_eventos_imagen_home'] = 'Image Event (Home):<br /><span class="help">400 x 400 pixeles</span>';
		$this->data['entry_eventos_imagen_header'] = 'Image Certificaat:<br /><span class="help">1156 x 897 pixeles</span>';
		$this->data['entry_eventos_imagen_afiche'] = 'Image Bib nummer:<br /><span class="help">1156 x 897 pixeles</span>';
		$this->data['entry_eventos_patrocinantes'] = 'Patrocinantes del Evento:';
		$this->data['entry_eventos_categorias'] = 'Attribute:';
		$this->data['entry_eventos_categorias_titulo'] = 'Titulo';
		$this->data['entry_eventos_categorias_edad_desde'] = 'Edad Inicial';
		$this->data['entry_eventos_categorias_edad_hasta'] = 'Edad Final';
		$this->data['entry_eventos_categorias_genero'] = 'G&eacute;nero';
		$this->data['entry_eventos_categorias_tipo'] = 'Type';
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
		$this->data['entry_eventos_numeracion_datos_cupos_no_confirmados'] = 'Cupos Internet Alsn Confirmar';
		$this->data['entry_eventos_numeracion_datos_cupos_disponibles'] = 'Cupos Internet Disponibles';
		$this->data['entry_eventos_numeracion_datos_cupos_tiendas'] = 'Cupos Utilizados por Tiendas';
		$this->data['entry_eventos_numeracion_tiempos_carga_titulo'] = 'Importar Tiempos Previos';
		$this->data['entry_eventos_numeracion_tiempos_carga_descripcion'] = 'Kiezen el archivo que contiene los datos de tiempos';
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

		$this->data['entry_eventos_resultados_carga_titulo'] = 'Import Resultaten';
		$this->data['entry_eventos_resultados_carga_descripcion'] = 'Kiezen el archivo que contiene los resultados. <br /><span class="help">Het bestand moet CSV zijn. En het aantal kolommen in strikte volgorde van <a href="' . HTTP_DOWNLOAD . 'download.php" target="_blank">sjabloon modelresultaten</a></span>';
		$this->data['entry_opcion'] = 'Optie';
		$this->data['entry_opcion_valor'] = 'Waarde  de Optie';
		$this->data['entry_quantity'] = 'Cantidad de Optie';
		$this->data['entry_subtract'] = 'Restar Stock de Optie';
		$this->data['entry_price'] = 'Precio de Optie';
		$this->data['entry_option_points'] = 'Puntos de Optie';
		$this->data['entry_weight'] = 'Peso de Optie';


		$this->data['entry_text'] = 'Texto:';
		$this->data['entry_required'] = 'Requerido:';

		$this->data['button_save'] = 'Besparen';
		$this->data['button_cancel'] = 'Annuleren';
		$this->data['button_add_categoria'] = 'Toevoegen Categor&iacute;a';
		$this->data['button_add_numeracion'] = 'Toevoegen Numeraci&oacute;n';
		$this->data['button_add_opcion'] = 'Toevoegen Optie';
		$this->data['button_add_opcion_valor'] = 'Toevoegen Waarde  de Optie';
		$this->data['button_add_discount'] = 'Add Discount';
		$this->data['button_add_special'] = 'Add Special';
		$this->data['button_add_image'] = 'Toevoegen Afbeelding';
		$this->data['button_remove'] = 'Verwijderen';

		$this->data['tab_general'] = 'Algemeen';
		$this->data['tab_datos'] = 'Datos';
		$this->data['tab_imagenes'] = 'Afbeeldinges';
		$this->data['tab_patrocinantes'] = 'Patrocinantes';
		$this->data['tab_categorias'] = 'Categor&iacute;as';
		$this->data['tab_numeracion'] = 'Numeraci&oacute;n';
		$this->data['tab_opcion'] = 'Datos para Inscripci&oacute;n';
		$this->data['tab_resultados'] = 'Uitslagen';
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
			'text'      => 'Huis',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => 'Evenementen',
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

		if (isset($this->request->post['eventos_home'])) {
			$this->data['eventos_home'] = $this->request->post['eventos_home'];
		} else if (isset($evento_info)) {
			$this->data['eventos_home'] = $evento_info['eventos_home'];
		} else {
			$this->data['eventos_home'] = 0;
		}

		if (isset($this->request->post['eventos_revista'])) {
			$this->data['eventos_revista'] = $this->request->post['eventos_revista'];
		} else if (isset($evento_info)) {
			$this->data['eventos_revista'] = $evento_info['eventos_revista'];
		} else {
			$this->data['eventos_revista'] = 1;
		}

		if (isset($this->request->post['eventos_certificado'])) {
			$this->data['eventos_certificado'] = $this->request->post['eventos_certificado'];
		} else if (isset($evento_info)) {
			$this->data['eventos_certificado'] = $evento_info['eventos_certificado'];
		} else {
			$this->data['eventos_certificado'] = 1;
		}

		if (isset($this->request->post['eventos_certificado_foto'])) {
			$this->data['eventos_certificado_foto'] = $this->request->post['eventos_certificado_foto'];
			$eventos_certificado_foto = $this->request->post['eventos_certificado_foto'];
		} else if (isset($evento_info)) {
			$this->data['eventos_certificado_foto'] = $evento_info['eventos_certificado_foto'];
			$eventos_certificado_foto = $evento_info['eventos_certificado_foto'];
		} else {
			$this->data['eventos_certificado_foto'] = 0;
			$eventos_certificado_foto = 0;
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

		if (isset($this->request->post['eventos_edad_calendario'])) {
			$this->data['eventos_edad_calendario'] = $this->request->post['eventos_edad_calendario'];
		} else if (isset($evento_info)) {
			$this->data['eventos_edad_calendario'] = $evento_info['eventos_edad_calendario'];
		} else {
			$this->data['eventos_edad_calendario'] = 0;
		}

		if (isset($this->request->post['eventos_controles'])) {
			$this->data['eventos_controles'] = $this->request->post['eventos_controles'];
		} else if (isset($evento_info)) {
			$this->data['eventos_controles'] = $evento_info['eventos_puntos_control'];
		} else {
			$this->data['eventos_controles'] = 0;
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

		if (isset($evento_info) && $evento_info['eventos_imagen_home'] && file_exists(DIR_IMAGE . $evento_info['eventos_imagen_home'])) {
			$this->data['preview_eventos_imagen_home'] = $this->model_tool_image->resize($evento_info['eventos_imagen_home'], 400, 400);
		} else {
			$this->data['preview_eventos_imagen_home'] = $this->model_tool_image->resize('no_image.jpg', 400, 400);
		}

		if (isset($evento_info) && $evento_info['eventos_imagen_header'] && file_exists(DIR_IMAGE . $evento_info['eventos_imagen_header'])) {
			$this->data['preview_eventos_imagen_header'] = $this->model_tool_image->resize($evento_info['eventos_imagen_header'], 1156, 897);
		} else {
			if ($eventos_certificado_foto != 0) {
				$this->data['preview_eventos_imagen_header'] = $this->model_tool_image->resize('racetimer_certificate_foto_mockup.jpg', 1156, 897);
			} else {
				$this->data['preview_eventos_imagen_header'] = $this->model_tool_image->resize('racetimer_certificate_mockup.jpg', 1156, 897);
			}
		}

		if (isset($evento_info) && $evento_info['eventos_imagen_afiche'] && file_exists(DIR_IMAGE . $evento_info['eventos_imagen_afiche'])) {
			$this->data['preview_eventos_imagen_afiche'] = $this->model_tool_image->resize($evento_info['eventos_imagen_afiche'], 1156, 897);
		} else {
			$this->data['preview_eventos_imagen_afiche'] = $this->model_tool_image->resize('racetimer_certificate_mockup.jpg', 1156, 897);
		}

		$this->template = 'catalog/evento_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function validateForm()
	{
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

	private function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'catalog/evento')) {
			$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los eventos!';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateCopy()
	{
		if (!$this->user->hasPermission('modify', 'catalog/evento')) {
			$this->error['warning'] = 'Advertencia: ¡Usted no tiene permisos para modificar los eventos!';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function autocomplete()
	{
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
								'evento_opcion_valor_id' => $evento_opcion_valor['evento_opcion_valor_id'],
								'opcion_valor_id'         => $evento_opcion_valor['opcion_valor_id'],
								'eventos_titulo'                    => $evento_opcion_valor['eventos_titulo'],
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
				);
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}

	public function deletecloudfile()
	{

		$this->load->model('catalog/evento');

		$json = array();

		if (!empty($this->request->post['item']) && !empty($this->request->post['eventos_id']) && !empty($this->request->post['imagen'])) {
			$image = $this->request->post['imagen'];
			$item = $this->request->post['item'];
			$id_evento = $this->request->post['eventos_id'];
			switch ($image) {
				case 'eventos_logo':
					$this->model_catalog_evento->updateLogoEvento($id_evento, '');
					break;
				case 'eventos_imagen_home':
					$this->model_catalog_evento->updateHomeEvento($id_evento, '');
					break;
				case 'eventos_imagen_header':
					$this->model_catalog_evento->updateHeaderEvento($id_evento, '');
					break;
				case 'eventos_imagen_afiche':
					$this->model_catalog_evento->updateAficheEvento($id_evento, '');
					break;
			}
			$object = new Cloudfiles();
			$object->delete($item);
			$json['output'] = 'Se elimino el item: ' . $this->request->post['item'] . ' del Cloud Server';
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}

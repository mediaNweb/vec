<?php   
    class ControllerCommonEvents extends Controller {
        protected function index($setting) {
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}

			$url = '';
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

            $this->load->model('catalog/tipos');
            $this->load->model('catalog/eventos');
            $this->load->model('tool/image');

            $this->data['text_events_section_title']		= $this->language->get('text_events_section_title');
            $this->data['text_events_section_description']	= $this->language->get('text_events_section_description');
            $this->data['button_load_more_events']  		= $this->language->get('button_load_more_events');

			$eventos_total = $this->model_catalog_eventos->getTotalEventos();

            $this->data['eventos'] = array();

            $eventos = $this->model_catalog_eventos->getEventos();

            foreach ($eventos as $evento) {
                $setting['width'] = 400;
                $setting['height'] = 400;

                if (file_exists(DIR_IMAGE . $evento['eventos_imagen_home'])) {
                    $img_evento = $this->model_tool_image->resize($evento['eventos_imagen_home'], $setting['width'], $setting['height']);
/*
                If (!empty($evento['eventos_imagen_home'])) {
					$img_evento = CLOUD_IMAGE . $evento['eventos_imagen_home'];
*/
                } else {
                    $img_evento = $this->model_tool_image->resize('no_image.jpg', $setting['width'], $setting['height']);
                }

                $inscripcion = $evento['eventos_precio'];
                $fecha = $evento['eventos_fecha'];
				$hora = $evento['eventos_hora'];
                setlocale(LC_ALL, $this->language->get('lc_monetary'));
				
				$tipos_filtro = $this->model_catalog_tipos->getTipo($evento['eventos_id']);
				
				if (!$evento['eventos_redireccion']) {
// ORIGINAL
					$href = $this->url->link('evento/evento', 'eventos_id=' . $evento['eventos_id']);
//					$href = HTTP_SERVER . 'consulta.php?evento=' . $evento['eventos_id'];
				} else {
					$href = $evento['eventos_redireccion_url'];
				}

				$cert_href = $this->url->link('evento/evento', 'eventos_id=' . $evento['eventos_id']);

				if (strlen(utf8_decode($evento['eventos_titulo'])) > 38) {
					$nombre_evento = substr($evento['eventos_titulo'], 0, 38) . '...';
				} else {
					$nombre_evento = $evento['eventos_titulo'];
				}

                $this->data['eventos'][] = array(
                'eventos_id'                => $evento['eventos_id'],
                'eventos_tipo'              => $tipos_filtro,
                'eventos_titulo'            => $nombre_evento,
                'eventos_fecha'             => utf8_encode(ucfirst(strftime("%A %d %B %Y",strtotime($fecha)))),
                'eventos_date'              => $evento['eventos_fecha'],
                'eventos_hora'              => date("h:i a",strtotime($hora)),
                'eventos_lugar'             => $evento['eventos_lugar'],
                'eventos_logo'              => $evento['eventos_logo'],
                'eventos_imagen_home'       => $img_evento,
                'eventos_orden'             => $evento['eventos_orden'],
                'eventos_cupos_internet'    => $evento['eventos_cupos_internet'],
                'eventos_precio'            => number_format($inscripcion, 2, ',', '.'),
                'eventos_fdc'               => $evento['eventos_fdc'],
                'eventos_fdum'              => $evento['eventos_fdum'],
                'eventos_fecha_disponible'  => $evento['eventos_fecha_disponible'],
                'eventos_status'            => $evento['eventos_status'],
                'eventos_inscripciones'     => $evento['eventos_inscripciones'],
                'eventos_id_impuesto'       => $evento['eventos_id_impuesto'],
                'eventos_visitado'          => $evento['eventos_visitado'],
                'eventos_href'              => $href,
                'eventos_cert_href'         => $cert_href,
                );
            }

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$pagination = new Pagination();
			$pagination->total = $eventos_total;
			$pagination->page = $page;
			$pagination->limit = 10;
			$pagination->text = 'Mostrando {start} al {end} de {total} ({pages} P&aacute;ginas)';
			$pagination->url = $this->url->link('comun/home', $url . '&page={page}', 'SSL');
				
			$this->data['pagination'] = $pagination->render();

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/events.php')) {
                $this->template = $this->config->get('config_template') . '/common/events.php';
            } else {
                $this->template = 'common/events.php';
            }

            $this->render();
        }

		public function loadmore() {
			
			$output = '';
			
			if (isset($this->request->post['last_event_id'])) {
	
				$this->load->model('catalog/tipos');
				$this->load->model('catalog/eventos');
				$this->load->model('tool/image');
	
				$eventos = $this->model_catalog_eventos->getEventosMore($this->request->post['last_event_id']);
				
				if ($eventos != false) {
					foreach ($eventos as $evento) {
						$setting['width'] = 400;
						$setting['height'] = 400;
		
						if (file_exists(DIR_IMAGE . $evento['eventos_imagen_home'])) {
							$img_evento = $this->model_tool_image->resize($evento['eventos_imagen_home'], $setting['width'], $setting['height']);
		/*
						If (!empty($evento['eventos_imagen_home'])) {
							$img_evento = CLOUD_IMAGE . $evento['eventos_imagen_home'];
		*/
						} else {
							$img_evento = $this->model_tool_image->resize('no_image.jpg', $setting['width'], $setting['height']);
						}
		
						$fecha = $evento['eventos_fecha'];
						$fecha_format = utf8_encode(ucfirst(strftime("%A %d %B %Y",strtotime($fecha))));
						$hora = $evento['eventos_hora'];
						setlocale(LC_ALL, $this->language->get('lc_monetary'));
						
	//					$tipos_filtro = $this->model_catalog_tipos->getTipo($evento['eventos_id']);
						
						if (!$evento['eventos_redireccion']) {
		// ORIGINAL
							$href = $this->url->link('evento/evento', 'eventos_id=' . $evento['eventos_id']);
		//					$href = HTTP_SERVER . 'consulta.php?evento=' . $evento['eventos_id'];
						} else {
							$href = $evento['eventos_redireccion_url'];
						}
		
						$cert_href = $this->url->link('evento/evento', 'eventos_id=' . $evento['eventos_id']);
		
						if (strlen(utf8_decode($evento['eventos_titulo'])) > 38) {
							$nombre_evento = substr($evento['eventos_titulo'], 0, 38) . '...';
						} else {
							$nombre_evento = $evento['eventos_titulo'];
						}
		
						$eventos_id = $evento["eventos_id"];
						$output .= '<li data-type="events" data-id="' . $eventos_id . '"><figure> <a href="' . $href . '" class="Xswipebox" title="' . $evento['eventos_titulo'] . '"><img src="' . $img_evento . '" alt="' . $evento['eventos_titulo'] . '"/><figcaption><div class="caption-content"> <small><em>' . $fecha_format . '</em></small><p>' . $evento['eventos_titulo'] . '</p></div></figcaption></a></figure></li>';
	
					}

				}
				
			}
			
			$this->response->setOutput($output);

		}
		
    }
?>
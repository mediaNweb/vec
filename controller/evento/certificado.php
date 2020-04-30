<?php  
    class ControllerEventoCertificado extends Controller {
        private $error = array(); 

        public function index() { 

            $this->load->model('catalog/eventos');
            $this->load->model('tool/image');
            $this->load->model('catalog/tipos');

            if (isset($this->request->get['eventos_id'])) {
                $eventos_id = $this->request->get['eventos_id'];
            }

            if (isset($this->request->get['numero'])) {
                $numero = $this->request->get['numero'];
				$resultado = $this->model_catalog_eventos->getResultadoParticipanteByNumero($numero, $eventos_id);
            }
			
			if ($resultado) {
			
				$cedula 		= $resultado['cedula'];
				$nombre 		= ($resultado['nombre'] != '') ? $resultado['nombre'] : $this->language->get('text_participant');
				$numero 		= $resultado['numero'];
				$categoria 		= $resultado['categoria'] . ' (' . $resultado['carrera'] . ')';
				$pos_general 	= $resultado['pos_general'];
				$pos_genero 	= $resultado['pos_genero'];
				$pos_categoria 	= $resultado['pos_categoria'];
				$time_tag 		= $resultado['time_tag'];
				$time_oficial 	= $resultado['time_oficial'];
				$ritmo 			= $resultado['ritmo'];
				$jpg 			= $resultado['jpg_url'];
	
				
				$this->data['cedula'] = $cedula;
				$this->data['nombre'] = $nombre;
				$this->data['numero'] = $numero;
				$this->data['foto'] = $jpg;
				$this->data['categoria'] = ($categoria != '') ? $categoria : 'n/a';
				$this->data['pos_general'] = ($pos_general != '') ? $pos_general : 'n/a';
				$this->data['pos_genero'] = ($pos_genero != '') ? $pos_genero : 'n/a';
				$this->data['pos_categoria'] = ($pos_categoria != '') ? $pos_categoria : 'n/a';
				$this->data['time_tag'] = ($time_tag != '') ? $time_tag : 'n/a';
				$this->data['time_oficial'] = ($time_oficial != '') ? $time_oficial : 'n/a';
				$this->data['ritmo'] = ($ritmo != '') ? $ritmo : 'n/a';

				$evento_info = $this->model_catalog_eventos->getEventoDescripcion($eventos_id);
	
				$this->data['evento_info'] = $evento_info;
	
				if ($evento_info) {
	
					$this->document->setTitle($this->config->get('config_title') . ' ' . $evento_info['eventos_titulo']);
					$this->document->setDescription($evento_info['eventos_meta_description']);
					$this->document->setKeywords($evento_info['eventos_meta_keywords']);

					$fecha = $evento_info['eventos_fecha'];
					setlocale(LC_ALL,$this->language->get('lc_monetary'));
					$eventos_certificado_foto = $evento_info['eventos_certificado_foto'];

	
					$setting['width'] = 400;
					$setting['height'] = 400;
	
					if (file_exists(DIR_IMAGE . $evento_info['eventos_imagen_home'])) {
						$img_evento = $this->model_tool_image->resize($evento_info['eventos_imagen_home'], $setting['width'], $setting['height']);
					} else {
						$img_evento = $this->model_tool_image->resize('no_image.jpg', $setting['width'], $setting['height']);
					}
	
					$setting['width'] = 867;
					$setting['height'] = 673;
					
					$design = 0;
	
					if (!empty($evento_info['eventos_imagen_header']) && (file_exists(DIR_IMAGE . $evento_info['eventos_imagen_header']))) {
						$img_certificado = $this->model_tool_image->resize($evento_info['eventos_imagen_header'], $setting['width'], $setting['height']);
						$design = 1;
					} else {
						if ( $eventos_certificado_foto != 0 ) {
							$img_certificado = $this->model_tool_image->resize('racetimer_certificate_foto_mockup.jpg', $setting['width'], $setting['height']);
							$design = 0;
						} else { 
							$img_certificado = $this->model_tool_image->resize('racetimer_certificate_mockup.jpg', $setting['width'], $setting['height']);
							$design = 0;
						}
					}
	
//					echo $img_certificado;
//					exit(0);

					$this->data['title']                                    = $evento_info['eventos_titulo'];
					$this->data['eventos_id']                               = $evento_info['eventos_id'];
					$this->data['eventos_tipo']                             = $this->model_catalog_tipos->getTipo($evento_info['eventos_id']);
					$this->data['eventos_titulo']                           = $evento_info['eventos_titulo'];
					$this->data['eventos_fecha']                            = utf8_encode(ucfirst(strftime("%A %d %B %Y",strtotime($fecha))));
					$this->data['eventos_hora']                             = $evento_info['eventos_hora'];
					$this->data['eventos_lugar']                            = $evento_info['eventos_lugar'];
					$this->data['eventos_imagen']                    		= $img_evento;
					$this->data['eventos_certificado']                    	= $img_certificado;
					$this->data['certificado_default']                    	= $design;
					$this->data['eventos_edad_calendario']                  = $evento_info['eventos_edad_calendario'];
					$this->data['eventos_fdc']                              = $evento_info['eventos_fdc'];
					$this->data['eventos_fdum']                             = $evento_info['eventos_fdum'];
					$this->data['eventos_imagen_header']                    = $evento_info['eventos_imagen_header'];
					$this->data['eventos_href']                             = $this->url->link('evento/evento', 'eventos_id=' . $evento_info['eventos_id']);
	
					$this->data['text_result_cell_bracket_title']	= $this->language->get('text_result_cell_bracket_title');
					$this->data['text_certificate_bib']				= $this->language->get('text_certificate_bib');
					$this->data['text_result_cell_net']				= $this->language->get('text_result_cell_net');
					$this->data['text_result_cell_gun']				= $this->language->get('text_result_cell_gun');
					$this->data['text_certificate_pace']			= $this->language->get('text_certificate_pace');
					$this->data['text_certificate_footer']			= $this->language->get('text_certificate_footer');
					$this->data['text_certificate_overall']			= $this->language->get('text_certificate_overall');
					$this->data['text_certificate_gender']			= $this->language->get('text_certificate_gender');
					$this->data['text_certificate_bracket']			= $this->language->get('text_certificate_bracket');
					$this->data['text_certificate']					= $this->language->get('text_certificate');
	
				}    

				if ( $eventos_certificado_foto != 0 ) {
					if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/evento/certificado_new.php' ) ) {
						$this->template = $this->config->get( 'config_template' ) . '/evento/certificado_new.php';
					} else {
						$this->template = 'evento/certificado_new.php';
					}
				} else {
					if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/evento/certificado.php' ) ) {
						$this->template = $this->config->get( 'config_template' ) . '/evento/certificado.php';
					} else {
						$this->template = 'evento/certificado.php';
					}
				}	

//				$this->response->setOutput($this->render());

	        }

/*
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/evento/certificado.php')) {
				$this->template = $this->config->get('config_template') . '/evento/certificado.php';
			} else {
				$this->template = 'evento/certificado.php';
			}
*/
            $this->response->setOutput($this->render());
						
		}
	}
?>
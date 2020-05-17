<?php
class ControllerEventoEvento extends Controller
{
	private $error = array();

	public function index()
	{

		$this->data['button_results']			= $this->language->get('button_results');
		$this->data['input_results_form_bib']	= $this->language->get('input_results_form_bib');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => 'Inicio',
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];

			unset($this->session->data['warning']);
		} else {
			$this->data['warning'] = '';
		}

		if (isset($this->request->get['eventos_id'])) {
			$eventos_id = $this->request->get['eventos_id'];
		} else {
			$eventos_id = 0;
		}

		$this->data['home'] = $this->url->link('common/home');

		$this->load->model('catalog/tipos');
		$this->load->model('catalog/eventos');
		$this->load->model('tool/image');

		$tiempo_min = $this->model_catalog_eventos->getEventoResultadosTiempoMin($eventos_id);
		$tiempo_max = $this->model_catalog_eventos->getEventoResultadosTiempoMax($eventos_id);
		$tiempo_avg = $this->model_catalog_eventos->getEventoResultadosTiempoAvg($eventos_id);

		$porcentaje_min = $this->model_catalog_eventos->getEventoResultadosPorcentajeMin($eventos_id);

		$this->data['tiempo_min'] = $tiempo_min;
		$this->data['tiempo_max'] = $tiempo_max;
		$this->data['tiempo_avg'] = $tiempo_avg;
		$this->data['porcentaje_min'] = $porcentaje_min;
		$this->data['porcentaje_avg'] = ((int) $porcentaje_min + 100) / 2;

		$evento_info = $this->model_catalog_eventos->getEventoDescripcion($eventos_id);

		$this->data['evento_info'] = $evento_info;

		if ($evento_info) {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			$this->data['breadcrumbs'][] = array(
				'text'      => $evento_info['eventos_titulo'],
				'href'      => $this->url->link('evento/evento', $url . '&eventos_id=' . $this->request->get['eventos_id']),
				'separator' => ' <b>&#187;</b> '
			);

			$this->document->setTitle($this->config->get('config_title') . ' ' . $evento_info['eventos_titulo']);
			$this->document->setDescription($evento_info['eventos_meta_description']);
			$this->document->setKeywords($evento_info['eventos_meta_keywords']);

			$setting['width'] = 270;
			$setting['height'] = 187;

			if (file_exists(DIR_IMAGE . $evento_info['eventos_imagen_home'])) {
				$img_evento = $this->model_tool_image->resize($evento_info['eventos_imagen_home'], $setting['width'], $setting['height']);
				/*
                If (!empty($evento_info['eventos_imagen_home'])) {
					$img_evento = CLOUD_IMAGE . $evento_info['eventos_imagen_home'];
*/
			} else {
				$img_evento = $this->model_tool_image->resize('no_image.jpg', $setting['width'], $setting['height']);
			}

			$this->data['title']                                    = $evento_info['eventos_titulo'];
			$this->data['eventos_id']                               = $evento_info['eventos_id'];
			$this->data['eventos_tipo']                             = $this->model_catalog_tipos->getTipo($evento_info['eventos_id']);
			$this->data['eventos_titulo']                           = $evento_info['eventos_titulo'];
			$this->data['eventos_fecha']                            = $evento_info['eventos_fecha'];
			$this->data['eventos_hora']                             = $evento_info['eventos_hora'];
			$this->data['eventos_lugar']                            = $evento_info['eventos_lugar'];
			$this->data['eventos_imagen']                    		= $img_evento;
			$this->data['eventos_edad_calendario']                  = $evento_info['eventos_edad_calendario'];
			$this->data['eventos_fdc']                              = $evento_info['eventos_fdc'];
			$this->data['eventos_fdum']                             = $evento_info['eventos_fdum'];
			$this->data['eventos_href']                             = $this->url->link('evento/evento', 'eventos_id=' . $evento_info['eventos_id']);

			$this->model_catalog_eventos->updateViewed($this->request->get['eventos_id']);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/evento/evento.php')) {
			$this->template = $this->config->get('config_template') . '/evento/evento.php';
		} else {
			$this->template = 'evento/evento.php';
		}

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function resultado()
	{

		$json = array();

		$eventos_id = $this->request->get['eventos_id'];
		$this->data['eventos_id'] = $eventos_id;

		$this->load->model('catalog/eventos');

		$evento_info = $this->model_catalog_eventos->getEventoDescripcion($eventos_id);

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$json) {

				if (!empty($this->request->post['numero'])) {
					$numero = $this->request->post['numero'];
					$resultado = $this->model_catalog_eventos->getResultadoParticipanteByNumero($numero, $eventos_id);
				}

				if ($resultado) {
					$time_format	= 'i:s';
					$cedula 		= $resultado['cedula'];
					$nombre 		= ($resultado['nombre'] != '') ? $resultado['nombre'] : $this->language->get('text_participant');
					$apellido 		= ($resultado['apellido'] != '') ? $resultado['apellido'] : '';
					$numero 		= $resultado['numero'];
					$genero 		= $resultado['genero'];
					$categoria 		= $resultado['categoria'];
					$carrera 		= $resultado['carrera'];
					$pais 			= $resultado['pais'];
					$estado 		= $resultado['estado'];
					$pos_general 	= $resultado['pos_general'];
					$pos_genero 	= $resultado['pos_genero'];
					$pos_categoria 	= $resultado['pos_categoria'];
					$time_tag 		= $resultado['time_tag'];
					$time_cp1 		= $resultado['time_cp1'];
					$time_oficial 	= $resultado['time_oficial'];
					$ritmo 			= $resultado['ritmo'];
					$jpg 			= $resultado['jpg_url'];
					$chronotrack 	= $resultado['result_link'];
					//						$equipo 		= $resultado['equipo'];
					//						$vueltas 		= $resultado['vueltas'];

					//					echo date(, strtotime($ritmo));


					$genero_descripcion = ($genero == 'M') ? $this->language->get('text_male') : $this->language->get('text_female');
					$total_absolutos = $this->model_catalog_eventos->getTotalAbsolutos($eventos_id, $carrera);
					$total_genero = $this->model_catalog_eventos->getTotalGenero($eventos_id, $carrera, $genero);
					$total_categoria = $this->model_catalog_eventos->getTotalCategoria($eventos_id, $carrera, $categoria);

					$this->data['cedula'] = $cedula;
					$this->data['nombre'] = $nombre;
					$this->data['apellido'] = $apellido;
					$this->data['numero'] = $numero;
					$this->data['genero'] = $genero;
					$this->data['categoria'] = ($categoria != '') ? $categoria : '-';
					$this->data['carrera'] = ($carrera != '') ? $carrera : '-';
					$this->data['pais'] = ($pais != '') ? $pais : '-';
					$this->data['estado'] = ($estado != '') ? $estado : '-';
					$this->data['pos_general'] = ($pos_general != '') ? $pos_general : '-';
					$this->data['pos_genero'] = ($pos_genero != '') ? $pos_genero : '-';
					$this->data['pos_categoria'] = ($pos_categoria != '') ? $pos_categoria : '-';
					$this->data['time_tag'] = ($time_tag != '') ? $time_tag : '-';
					$this->data['time_oficial'] = ($time_oficial != '') ? $time_oficial : '-';
					$this->data['time_cp1'] = ($time_cp1 != '') ? $time_cp1 : '-';
					$this->data['ritmo'] = ($ritmo != '') ? date($time_format, strtotime($ritmo)) : '-';
					//						$this->data['laps'] = ($vueltas != '') ? $vueltas : '-';

					$resultado_general = $this->model_catalog_eventos->getResultadoGanadorGeneral($eventos_id, $carrera);
					if ($resultado_general) {
						$this->data['general_cedula'] = $resultado_general['cedula'];
						$this->data['general_nombre'] = $resultado_general['nombre'];
						$this->data['general_numero'] = $resultado_general['numero'];
						$this->data['general_genero'] = $resultado_general['genero'];
						$this->data['general_categoria'] = ($resultado_general['categoria'] != '') ? $resultado_general['categoria'] : '-';
						$this->data['general_carrera'] = ($resultado_general['carrera'] != '') ? $resultado_general['carrera'] : '-';
						$this->data['general_pais'] = ($resultado_general['pais'] != '') ? $resultado_general['pais'] : '-';
						$this->data['general_estado'] = ($resultado_general['estado'] != '') ? $resultado_general['estado'] : '-';
						$this->data['general_pos_general'] = ($resultado_general['pos_general'] != '') ? $resultado_general['pos_general'] : '-';
						$this->data['general_pos_genero'] = ($resultado_general['pos_genero'] != '') ? $resultado_general['pos_genero'] : '-';
						$this->data['general_pos_categoria'] = ($resultado_general['pos_categoria'] != '') ? $resultado_general['pos_categoria'] : '-';
						$this->data['general_time_tag'] = ($resultado_general['time_tag'] != '') ? $resultado_general['time_tag'] : '-';
						$this->data['general_time_oficial'] = ($resultado_general['time_oficial'] != '') ? $resultado_general['time_oficial'] : '-';
						$this->data['general_time_cp1'] = ($resultado_general['time_cp1'] != '') ? $resultado_general['time_cp1'] : '-';
						$this->data['general_ritmo'] = ($resultado_general['ritmo'] != '') ? date($time_format, strtotime($resultado_general['ritmo'])) : '-';
						//						$this->data['laps'] = ($vueltas != '') ? $vueltas : '-';
					}

					$resultado_genero = $this->model_catalog_eventos->getResultadoGanadorGenero($eventos_id, $carrera, $genero);

					if ($resultado_genero) {
						$this->data['genero_cedula'] = $resultado_genero['cedula'];
						$this->data['genero_nombre'] = $resultado_genero['nombre'];
						$this->data['genero_genero'] = $resultado_genero['genero'];
						$this->data['genero_numero'] = $resultado_genero['numero'];
						$this->data['genero_categoria'] = ($resultado_genero['categoria'] != '') ? $resultado_genero['categoria'] : '-';
						$this->data['genero_carrera'] = ($resultado_genero['carrera'] != '') ? $resultado_genero['carrera'] : '-';
						$this->data['genero_pais'] = ($resultado_genero['pais'] != '') ? $resultado_genero['pais'] : '-';
						$this->data['genero_estado'] = ($resultado_genero['estado'] != '') ? $resultado_genero['estado'] : '-';
						$this->data['genero_pos_general'] = ($resultado_genero['pos_general'] != '') ? $resultado_genero['pos_general'] : '-';
						$this->data['genero_pos_genero'] = ($resultado_genero['pos_genero'] != '') ? $resultado_genero['pos_genero'] : '-';
						$this->data['genero_pos_categoria'] = ($resultado_genero['pos_categoria'] != '') ? $resultado_genero['pos_categoria'] : '-';
						$this->data['genero_time_tag'] = ($resultado_genero['time_tag'] != '') ? $resultado_genero['time_tag'] : '-';
						$this->data['genero_time_oficial'] = ($resultado_genero['time_oficial'] != '') ? $resultado_genero['time_oficial'] : '-';
						$this->data['genero_time_cp1'] = ($resultado_genero['time_cp1'] != '') ? $resultado_genero['time_cp1'] : '-';
						$this->data['genero_ritmo'] = ($resultado_genero['ritmo'] != '') ? date($time_format, strtotime($resultado_genero['ritmo'])) : '-';
						//						$this->data['laps'] = ($vueltas != '') ? $vueltas : '-';
					}

					$resultado_categoria = $this->model_catalog_eventos->getResultadoGanadorCategoria($eventos_id, $carrera, $categoria);

					if ($resultado_categoria) {
						$this->data['categoria_cedula'] = $resultado_categoria['cedula'];
						$this->data['categoria_nombre'] = $resultado_categoria['nombre'];
						$this->data['categoria_genero'] = $resultado_categoria['genero'];
						$this->data['categoria_numero'] = $resultado_categoria['numero'];
						$this->data['categoria_categoria'] = ($resultado_categoria['categoria'] != '') ? $resultado_categoria['categoria'] : '-';
						$this->data['categoria_carrera'] = ($resultado_categoria['carrera'] != '') ? $resultado_categoria['carrera'] : '-';
						$this->data['categoria_pais'] = ($resultado_categoria['pais'] != '') ? $resultado_categoria['pais'] : '-';
						$this->data['categoria_estado'] = ($resultado_categoria['estado'] != '') ? $resultado_categoria['estado'] : '-';
						$this->data['categoria_pos_general'] = ($resultado_categoria['pos_general'] != '') ? $resultado_categoria['pos_general'] : '-';
						$this->data['categoria_pos_genero'] = ($resultado_categoria['pos_genero'] != '') ? $resultado_categoria['pos_genero'] : '-';
						$this->data['categoria_pos_categoria'] = ($resultado_categoria['pos_categoria'] != '') ? $resultado_categoria['pos_categoria'] : '-';
						$this->data['categoria_time_tag'] = ($resultado_categoria['time_tag'] != '') ? $resultado_categoria['time_tag'] : '-';
						$this->data['categoria_time_oficial'] = ($resultado_categoria['time_oficial'] != '') ? $resultado_categoria['time_oficial'] : '-';
						$this->data['categoria_time_cp1'] = ($resultado_categoria['time_cp1'] != '') ? $resultado_categoria['time_cp1'] : '-';
						$this->data['categoria_ritmo'] = ($resultado_categoria['ritmo'] != '') ? date($time_format, strtotime($resultado_categoria['ritmo'])) : '-';
						//						$this->data['laps'] = ($vueltas != '') ? $vueltas : '-';
					}

					$this->data['text_result_instamagazine']		= sprintf($this->language->get('text_result_instamagazine'), $nombre);
					$this->data['text_result_instamagazine_link']	= $this->language->get('text_result_instamagazine_link');
					$this->data['text_result_section_heading']		= $this->language->get('text_result_section_heading');
					$this->data['text_result_col_athlete']			= $this->language->get('text_result_col_athlete');
					$this->data['text_result_col_overall']			= $this->language->get('text_result_col_overall');
					$this->data['text_result_col_gender']			= $this->language->get('text_result_col_gender');
					$this->data['text_result_col_bracket']			= $this->language->get('text_result_col_bracket');
					$this->data['text_result_cell_race_title']		= $this->language->get('text_result_cell_race_title');
					$this->data['text_result_cell_bracket_title']	= $this->language->get('text_result_cell_bracket_title');
					$this->data['text_result_cell_net']				= $this->language->get('text_result_cell_net');
					$this->data['text_result_cell_gun']				= $this->language->get('text_result_cell_gun');
					$this->data['text_athlete_result_cell_bracket']	= sprintf($this->language->get('text_result_cell_bracket'), $pos_categoria, $total_categoria, $categoria);
					$this->data['text_athlete_result_cell_gender']	= sprintf($this->language->get('text_result_cell_gender'), $pos_genero, $total_genero, $genero_descripcion);
					$this->data['text_athlete_result_cell_overall']	= sprintf($this->language->get('text_result_cell_overall'), $pos_general, $total_absolutos);

					if ($resultado_general) {
						$this->data['text_overall_result_cell_bracket']	= sprintf($this->language->get('text_result_cell_bracket'), $resultado_general['pos_categoria'], $total_categoria, $categoria);
						$this->data['text_overall_result_cell_gender']	= sprintf($this->language->get('text_result_cell_gender'), $resultado_general['pos_genero'], $total_genero, $genero_descripcion);
						$this->data['text_overall_result_cell_overall']	= sprintf($this->language->get('text_result_cell_overall'), $resultado_general['pos_general'], $total_absolutos);
					}

					if ($resultado_genero) {
						$this->data['text_gender_result_cell_bracket']	= sprintf($this->language->get('text_result_cell_bracket'), $resultado_genero['pos_categoria'], $total_categoria, $categoria);
						$this->data['text_gender_result_cell_gender']	= sprintf($this->language->get('text_result_cell_gender'), $resultado_genero['pos_genero'], $total_genero, $genero_descripcion);
						$this->data['text_gender_result_cell_overall']	= sprintf($this->language->get('text_result_cell_overall'), $resultado_genero['pos_general'], $total_absolutos);
					}

					if ($resultado_categoria) {
						$this->data['text_bracket_result_cell_bracket']	= sprintf($this->language->get('text_result_cell_bracket'), $resultado_categoria['pos_categoria'], $total_categoria, $categoria);
						$this->data['text_bracket_result_cell_gender']	= sprintf($this->language->get('text_result_cell_gender'), $resultado_categoria['pos_genero'], $total_genero, $genero_descripcion);
						$this->data['text_bracket_result_cell_overall']	= sprintf($this->language->get('text_result_cell_overall'), $resultado_categoria['pos_general'], $total_absolutos);
					}

					$this->data['speed_unit']						= $this->language->get('speed_unit');
					$this->data['text_result_certificate']			= $this->language->get('text_result_certificate');
					$this->data['text_result_certificate_link']		= $this->language->get('text_result_certificate_link');
					$this->data['text_result_bib_link']				= $this->language->get('text_result_bib_link');
					$this->data['text_result_widget_link']			= $this->language->get('text_result_widget_link');

					$this->data['certificado'] = $this->url->link('evento/certificado', 'eventos_id=' . $eventos_id . '&numero=' . $numero);
					$this->data['bib'] = $this->url->link('evento/bib', 'eventos_id=' . $eventos_id . '&numero=' . $numero);
					$this->data['eventos_revista'] = $evento_info['eventos_revista'];
					$this->data['eventos_certificado'] = $evento_info['eventos_certificado'];
					$eventos_certificado_foto = $evento_info['eventos_certificado_foto'];
					$this->data['instamagazine_url'] = 'http://racetimer.instantmagazine.com/m/' . strtolower(str_replace(' ', '', $evento_info['eventos_titulo'])) . '-' . date('Y', strtotime($evento_info['eventos_fecha'])) . '?bib=' . $numero . '&firstname=' . strtolower($nombre) . '&time=' . $time_tag . '&foto=' . $jpg;
					$this->data['chronotrack'] = $chronotrack;

					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/evento/resultados.php')) {
						$this->template = $this->config->get('config_template') . '/evento/resultados.php';
					} else {
						$this->template = 'evento/resultados.php';
					}

					$json['output'] = $this->render();
				} else {

					$json['error'] = $this->language->get('error_no_data');
				}
			}
		}

		$this->load->library('json');

		$this->response->setOutput(Json::encode($json));
	}
}

<?php
class ModelCatalogEvento extends Model
{
	public function addEvento($data)
	{

		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos SET eventos_titulo = '" . $this->db->escape($data['eventos_titulo']) . "', eventos_fecha = '" . $this->db->escape($data['eventos_fecha']) . "', eventos_hora = '" . $this->db->escape($data['eventos_hora']) . "', eventos_lugar = '" . $this->db->escape($data['eventos_lugar']) . "', eventos_orden = '" . (int) $data['eventos_orden'] . "', eventos_redireccion = '" . (int) $data['eventos_redireccion'] . "', eventos_redireccion_url = '" . $data['eventos_redireccion_url'] . "', eventos_puntos_control = '" . (int) $data['eventos_controles'] . "', eventos_fecha_disponible = '" . $this->db->escape($data['eventos_fecha_disponible']) . "', eventos_status = '" . (int) $data['eventos_status'] . "', eventos_home = '" . (int) $data['eventos_home'] . "', eventos_revista = '" . (int) $data['eventos_revista'] . "', eventos_certificado = '" . (int) $data['eventos_certificado'] . "', eventos_certificado_foto = '" . (int) $data['eventos_certificado_foto'] . "', eventos_meta_keywords = '" . $this->db->escape($data['eventos_meta_keywords']) . "', eventos_meta_description = '" . $this->db->escape($data['eventos_meta_description']) . "', eventos_fdc = NOW() , eventos_fdum = NOW()");

		$eventos_id = $this->db->getLastId();

		if (isset($data['eventos_logo'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_logo = '" . $this->db->escape($data['eventos_logo']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}

		if (isset($data['eventos_imagen_home'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_home = '" . $this->db->escape($data['eventos_imagen_home']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}

		if (isset($data['eventos_imagen_header'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_header = '" . $this->db->escape($data['eventos_imagen_header']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}

		if (isset($data['eventos_imagen_afiche'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_afiche = '" . $this->db->escape($data['eventos_imagen_afiche']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int) $eventos_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");

		if (isset($data['eventos_tipos_id'])) {
			foreach ($data['eventos_tipos_id'] as $tipo) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_a_tipos SET eventos_a_tipos_id_evento = '" . (int) $eventos_id . "', eventos_a_tipos_id_tipo = '" . (int) $tipo . "'");
			}
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'eventos_id=" . (int) $eventos_id . "'");

		$this->cache->delete('evento');
	}

	public function editEvento($eventos_id, $data)
	{
		$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_titulo = '" . $this->db->escape($data['eventos_titulo']) . "', eventos_fecha = '" . $this->db->escape($data['eventos_fecha']) . "', eventos_hora = '" . $this->db->escape($data['eventos_hora']) . "', eventos_lugar = '" . $this->db->escape($data['eventos_lugar']) . "', eventos_orden = '" . (int) $data['eventos_orden'] . "', eventos_redireccion = '" . (int) $data['eventos_redireccion'] . "', eventos_redireccion_url = '" . $data['eventos_redireccion_url'] . "', eventos_puntos_control = '" . (int) $data['eventos_controles'] . "', eventos_fecha_disponible = '" . $this->db->escape($data['eventos_fecha_disponible']) . "', eventos_status = '" . (int) $data['eventos_status'] . "', eventos_home = '" . (int) $data['eventos_home'] . "', eventos_revista = '" . (int) $data['eventos_revista'] . "', eventos_certificado = '" . (int) $data['eventos_certificado'] . "', eventos_certificado_foto = '" . (int) $data['eventos_certificado_foto'] . "', eventos_meta_keywords = '" . $this->db->escape($data['eventos_meta_keywords']) . "', eventos_meta_description = '" . $this->db->escape($data['eventos_meta_description']) . "', eventos_fdum = NOW() WHERE eventos_id = '" . (int) $eventos_id . "'");

		/*
		if (isset($data['eventos_logo'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_logo = '" . $this->db->escape($data['eventos_logo']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}
*/

		if (isset($data['file_eventos_imagen_home'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_home = '" . $this->db->escape($data['file_eventos_imagen_home']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}

		if (isset($data['file_eventos_imagen_header'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_header = '" . $this->db->escape($data['file_eventos_imagen_header']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}


		if (isset($data['file_eventos_imagen_afiche'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_afiche = '" . $this->db->escape($data['file_eventos_imagen_afiche']) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int) $eventos_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");

		if (isset($data['eventos_tipos_id'])) {
			foreach ($data['eventos_tipos_id'] as $tipo_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_a_tipos SET eventos_a_tipos_id_evento = '" . (int) $eventos_id . "', eventos_a_tipos_id_tipo = '" . (int) $tipo_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_id=" . (int) $eventos_id . "'");

		$this->cache->delete('evento');
	}

	public function updateHomeEvento($eventos_id, $path)
	{

		$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_home = '" . $this->db->escape($path) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
	}

	public function updateHeaderEvento($eventos_id, $path)
	{

		$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_header = '" . $this->db->escape($path) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
	}

	public function updateAficheEvento($eventos_id, $path)
	{

		$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_afiche = '" . $this->db->escape($path) . "' WHERE eventos_id = '" . (int) $eventos_id . "'");
	}

	public function copyEvento($eventos_id)
	{
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE e.eventos_id  = '" . (int) $eventos_id . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['keyword'] = '';

			$data['eventos_status'] = '0';

			$data = array_merge($data, array('evento_categoria' => $this->getEventoAttributes($eventos_id)));
			$data = array_merge($data, array('evento_description' => $this->getEventoDescripcion($eventos_id)));
			$data = array_merge($data, array('evento_discount' => $this->getEventoDiscounts($eventos_id)));
			$data = array_merge($data, array('evento_image' => $this->getEventoImages($eventos_id)));

			$data['evento_image'] = array();

			$results = $this->getEventoImages($eventos_id);

			foreach ($results as $result) {
				$data['evento_image'][] = $result['eventos_logo'];
			}

			$data = array_merge($data, array('evento_opcion' => $this->getEventoOpciones($eventos_id)));
			$data = array_merge($data, array('evento_related' => $this->getEventoRelated($eventos_id)));
			$data = array_merge($data, array('evento_reward' => $this->getEventoRewards($eventos_id)));
			$data = array_merge($data, array('evento_special' => $this->getEventoSpecials($eventos_id)));
			$data = array_merge($data, array('evento_tag' => $this->getEventoTags($eventos_id)));
			$data = array_merge($data, array('evento_category' => $this->getEventoCategories($eventos_id)));
			$data = array_merge($data, array('evento_download' => $this->getEventoDownloads($eventos_id)));
			$data = array_merge($data, array('evento_layout' => $this->getEventoLayouts($eventos_id)));
			$data = array_merge($data, array('evento_store' => $this->getEventoStores($eventos_id)));

			$this->addEvento($data);
		}
	}

	public function deleteEvento($eventos_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos WHERE eventos_id = '" . (int) $eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int) $eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_id=" . (int) $eventos_id . "'");

		$this->cache->delete('evento');
	}

	public function getEvento($eventos_id)
	{
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_id=" . (int) $eventos_id . "') AS keyword FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE e.eventos_id  = '" . (int) $eventos_id . "'");

		return $query->row;
	}

	public function getEventos($data = array())
	{
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE 1 = 1";

			if (isset($data['filter_eventos_titulo']) && !is_null($data['filter_eventos_titulo'])) {
				$sql .= " AND LCASE(e.eventos_titulo) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_eventos_titulo'], 'UTF-8')) . "%'";
			}

			if (isset($data['filter_eventos_status']) && !is_null($data['filter_eventos_status'])) {
				$sql .= " AND e.eventos_status = '" . (int) $data['filter_eventos_status'] . "'";
			}

			if (isset($data['filter_eventos_year']) && !is_null($data['filter_eventos_year'])) {
				$sql .= " AND YEAR(e.eventos_fecha) = '" . (int) $data['filter_eventos_year'] . "'";
			}


			$sort_data = array(
				'e.eventos_titulo',
				'e.eventos_status',
				'e.eventos_orden'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY e.eventos_status DESC, e.eventos_fecha DESC, " . $data['sort'];
			} else {
				$sql .= " ORDER BY e.eventos_status DESC, e.eventos_fecha DESC";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$evento_data = $this->cache->get('evento.');

			if (!$evento_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) ORDER BY e.eventos_status DESC, e.eventos_fecha DESC");

				$evento_data = $query->rows;

				$this->cache->set('evento.', $evento_data);
			}

			return $evento_data;
		}
	}

	public function getTipo($eventos_id)
	{
		$query = $this->db->query("SELECT et.eventos_tipos_nombre FROM " . DB_PREFIX . "eventos_tipos et LEFT JOIN " . DB_PREFIX . "eventos_a_tipos eat ON (et.eventos_tipos_id = eat.eventos_a_tipos_id_tipo) WHERE eat.eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");

		return $query->row['eventos_tipos_nombre'];
	}

	public function getTipoID_X($eventos_id)
	{
		$query = $this->db->query("SELECT et.eventos_tipos_id FROM " . DB_PREFIX . "eventos_tipos et LEFT JOIN " . DB_PREFIX . "eventos_a_tipos eat ON (et.eventos_tipos_id = eat.eventos_a_tipos_id_tipo) WHERE eat.eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");

		return $query->row['eventos_tipos_id'];
	}


	public function getTipoID($eventos_id)
	{

		$evento_tipo_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");

		foreach ($query->rows as $result) {
			$evento_tipo_data[] = $result['eventos_a_tipos_id_tipo'];
		}

		return $evento_tipo_data;
	}



	public function getEventosByCategoryId($eventos_a_tipos_id_tipo)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) LEFT JOIN " . DB_PREFIX . "eventos_a_tipos e2t ON (e.eventos_id  = e2t.eventos_a_tipos_id_evento) WHERE e2t.eventos_a_tipos_id_tipo = '" . (int) $eventos_a_tipos_id_tipo . "' ORDER BY e.eventos_titulo ASC");

		return $query->rows;
	}

	public function getEventoDescripcion($eventos_id)
	{
		$evento_description_data = array();
		$query = $this->db->query("SELECT e.*, ed.* FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE e.eventos_id= '" . (int) $eventos_id . "'");

		foreach ($query->rows as $result) {
			$evento_description_data = array(
				'eventos_id'                            	=> $result['eventos_id'],
				'eventos_titulo'                        	=> $result['eventos_titulo'],
				'eventos_fecha'                         	=> $result['eventos_fecha'],
				'eventos_hora'                          	=> $result['eventos_hora'],
				'eventos_lugar'                         	=> $result['eventos_lugar'],
				'eventos_logo'                          	=> $result['eventos_logo'],
				'eventos_imagen_home'                       => $result['eventos_imagen_home'],
				'eventos_imagen_header'                     => $result['eventos_imagen_header'],
				'eventos_imagen_afiche'						=> $result['eventos_imagen_afiche'],
				'eventos_orden'                         	=> $result['eventos_orden'],
				'eventos_redireccion'						=> $result['eventos_redireccion'],
				'eventos_redireccion'						=> $result['eventos_redireccion'],
				'eventos_redireccion_url'					=> $result['eventos_redireccion_url'],
				'eventos_puntos_control'					=> $result['eventos_puntos_control'],
				'eventos_edad_calendario'             		=> $result['eventos_edad_calendario'],
				'eventos_fdc'                           	=> $result['eventos_fdc'],
				'eventos_fdum'                          	=> $result['eventos_fdum'],
				'eventos_fecha_disponible'              	=> $result['eventos_fecha_disponible'],
				'eventos_status'                        	=> $result['eventos_status'],
				'eventos_home'                        		=> $result['eventos_home'],
				'eventos_revista'                        	=> $result['eventos_revista'],
				'eventos_certificado'                       => $result['eventos_certificado'],
				'eventos_certificado_foto'                  => $result['eventos_certificado_foto'],
				'eventos_visitado'                      	=> $result['eventos_visitado'],
				'eventos_meta_keywords'          			=> $result['eventos_meta_keywords'],
				'eventos_meta_description'         			=> $result['eventos_meta_description'],
			);
		}

		return $evento_description_data;
	}

	public function getEventoPatrocinantes($eventos_id)
	{

		$evento_patrocinante_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id_evento = '" . (int) $eventos_id . "'");

		foreach ($query->rows as $result) {
			$evento_patrocinante_data[] = $result['eventos_patrocinantes_id'];
		}

		return $evento_patrocinante_data;
	}

	public function getEventoCategorias($eventos_id)
	{
		$evento_categoria_data = array();

		$evento_categoria_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int) $eventos_id . "'");

		foreach ($evento_categoria_query->rows as $evento_categoria) {
			$evento_categoria_data[] = array(
				'eventos_categorias_id'			=> $evento_categoria['eventos_categorias_id'],
				'eventos_categorias_nombre'     => $evento_categoria['eventos_categorias_nombre'],
				'eventos_categorias_edad_desde' => $evento_categoria['eventos_categorias_edad_desde'],
				'eventos_categorias_edad_hasta' => $evento_categoria['eventos_categorias_edad_hasta'],
				'eventos_categorias_genero'     => $evento_categoria['eventos_categorias_genero'],
				'eventos_categorias_tipo'       => $evento_categoria['eventos_categorias_tipo'],
				'eventos_categorias_grupo'      => $evento_categoria['eventos_categorias_grupo'],
			);
		}

		return $evento_categoria_data;
	}

	public function getEventoImages($eventos_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_galerias WHERE eventos_galerias_id_evento = '" . (int) $eventos_id . "'");

		return $query->rows;
	}

	public function getEventoCategories($eventos_id)
	{
		$evento_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int) $eventos_id . "'");

		foreach ($query->rows as $result) {
			$evento_category_data[] = $result['eventos_a_tipos_id_tipo'];
		}

		return $evento_category_data;
	}

	public function getTotalEventos($data = array())
	{
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE 1 = 1";

		if (isset($data['filter_eventos_titulo']) && !is_null($data['filter_eventos_titulo'])) {
			$sql .= " AND LCASE(e.eventos_titulo) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_eventos_titulo'], 'UTF-8')) . "%'";
		}

		if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
			$sql .= " AND LCASE(e.model) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%'";
		}

		if (isset($data['filter_eventos_status']) && !is_null($data['filter_eventos_status'])) {
			$sql .= " AND e.eventos_status = '" . (int) $data['filter_eventos_status'] . "'";
		}

		if (isset($data['filter_eventos_year']) && !is_null($data['filter_eventos_year'])) {
			$sql .= " AND YEAR(e.eventos_fecha) = '" . (int) $data['filter_eventos_year'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getEventosYears()
	{
		$sql = "SELECT DISTINCT YEAR(e.eventos_fecha) AS year FROM " . DB_PREFIX . "eventos e";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalEventosByStockStatusId($stock_status_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos WHERE stock_status_id = '" . (int) $stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalEventosByImpuestoClassId($impuestos_clase_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos WHERE impuestos_clase_id = '" . (int) $impuestos_clase_id . "'");

		return $query->row['total'];
	}

	public function getTotalEventosByPatrocinanteId($patrocinantes_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id = '" . (int) $patrocinantes_id . "'");

		return $query->row['total'];
	}

	public function getTotalEventosByAttributeId($eventos_categorias_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id = '" . (int) $eventos_categorias_id . "'");

		return $query->row['total'];
	}

	public function getTotalEventosByOpcionId($opcion_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_opcion WHERE opcion_id = '" . (int) $opcion_id . "'");

		return $query->row['total'];
	}

	public function getTotalParticipantesConfirmadosByEvento($eventos_id)
	{

		//		$query = $this->db->query("SELECT COUNT(DISTINCT eventos_participantes_numero) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_numero > 0 AND eventos_participantes_inscripcion = 'Internet'");

		$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int) $eventos_id . "' AND eventos_participantes_numero > 0 AND eventos_participantes_inscripcion = 'Internet'");

		return $query->row['total'];
	}

	public function getTotalParticipantesNoConfirmadosByEvento($eventos_id)
	{

		//		$query = $this->db->query("SELECT COUNT(DISTINCT ep.eventos_participantes_id_cliente) as total FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN solicitud s ON (ep.eventos_participantes_id_pedido = s.order_id) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND ep.eventos_participantes_numero = 0 AND ep.eventos_participantes_inscripcion = 'Internet' AND ep.eventos_participantes_id_pedido IN (SELECT order_id FROM solicitud WHERE (order_status_id = 0 OR order_status_id = 1 OR order_status_id = 2) AND payment_number <> '')");

		$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "eventos_participantes` ep WHERE ep.eventos_participantes_id_evento  = '" . (int) $eventos_id . "' AND ep.eventos_participantes_numero = 0 AND ep.eventos_participantes_inscripcion = 'Internet'");

		return $query->row['total'];
	}

	public function getTotalParticipantesTiendasByEvento($eventos_id)
	{

		$query = $this->db->query("SELECT COUNT(DISTINCT eventos_participantes_numero) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int) $eventos_id . "' AND eventos_participantes_numero > 0 AND eventos_participantes_inscripcion <> 'Internet'");

		return $query->row['total'];
	}

	public function getEventoCuposUtilizados($evento_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_evento = '" . (int) $evento_id . "' AND eventos_participantes_inscripcion = 'Internet'");

		return $query->row['total'];
	}

	public function getEventoTotalTiemposPrevios($evento_id)
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_tiempos WHERE eventos_tiempos_id_evento = '" . (int) $evento_id . "'");

		return $query->row['total'];
	}

	public function getTipoByEvento($eventos_id)
	{
		$query = $this->db->query("SELECT eventos_a_tipos_id_tipo AS tipo FROM " . DB_PREFIX . "eventos_a_tipos eat WHERE eat.eventos_a_tipos_id_evento = '" . (int) $eventos_id . "' AND (eat.eventos_a_tipos_id_tipo = 2 OR eat.eventos_a_tipos_id_tipo = 3)");

		return $query->row['tipo'];
	}

	public function getLastEventosByTipo($tipo_id)
	{
		$query = $this->db->query("SELECT eventos_a_tipos_id_evento AS evento FROM " . DB_PREFIX . "eventos_a_tipos eat WHERE eat.eventos_a_tipos_id_tipo = '" . (int) $tipo_id . "' ORDER BY eventos_a_tipos_id_evento DESC LIMIT 100 OFFSET 1");

		return $query->rows;
	}

	public function importarNumeracionEvento($eventos_id, $contenido)
	{


		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_tiempos WHERE eventos_tiempos_id_evento = '" . (int) $eventos_id . "'");

		//	        $handle = fopen($_FILES['prev_times']['tmp_name'], 'r');
		$handle = fopen($contenido, 'r');
		while (($data_csv = fgetcsv($handle, 1000, ';')) !== FALSE) {
			/* Var cleaning */
			$data_csv[0] = trim(chop(mysqli_real_escape_string($data_csv[0])));
			$data_csv[1] = trim(chop(mysqli_real_escape_string($data_csv[1])));

			if ((preg_match("/^([0-9]+)$/", $data_csv[0])) and (preg_match("/^(0?\d|1[0-2]):([0-5]\d):([0-5]\d)$/", $data_csv[1]))) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_tiempos SET eventos_tiempos_id_evento = '" . (int) $eventos_id . "', eventos_tiempos_id_cliente = '" . $data_csv[0] . "', eventos_tiempos_tiempo = '" . $data_csv[1] . "'");
			}
		}
		fclose($handle);
	}

	public function importarResultadosEvento($eventos_id, $contenido)
	{

		/*
		$table = 'import_resultados_' . $eventos_id;
		$handle = fopen($contenido, 'r');
		$frow = fgetcsv($handle, 30000, ";");

		foreach ($frow as $column) {
			if (isset($columns) && !empty($columns)) {
				$columns .= ', ';
			} else {
				$columns = '';
			}
			$columns .= '`' . $column . '` varchar(128)';
		}

		/*
		$this->db->query("CREATE TABLE IF NOT EXISTS " . $table . " (" . $columns . ")");
*/

		$this->db->query("DELETE FROM " . DB_PREFIX . "participantes WHERE id_evento = '" . (int) $eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "resultados WHERE id_evento = '" . (int) $eventos_id . "'");
		/*
		[0] => EXTERNAL_ID
		[1] => FIRST_NAME
		[2] => LAST_NAME
		[3] => BIB
		[4] => GENDER
		[5] => PRIMARY_BRACKET
		[6] => REG_CHOICE
		[7] => COUNTRY_CODE
		[8] => REGION_NAME
		[9] => RACE_AGE
		[10] => DOB
		[11] => TEAM_NAME
		[12] => OVERALL_RANK
		[13] => GENDER_RANK
		[14] => PRIMARY_BRACKET_RANK
		[15] => GUN_FINISH_TIME
		[16] => FINISH_NET_TIME
		[17] => FINISH_NET_PACE
		[18] => LAPS
		[19] => JPG_URL
		[20] => DIRECT_RESULT_LINK
		[21] => SPLIT 1 NET TIME
		[22] => SPLIT 2 NET TIME
		[23] => SPLIT 3 NET TIME
		[24] => SPLIT 4 NET TIME
		[25] => SPLIT 5 NET TIME
		[26] => SPLIT 6 NET TIME
		[27] => SPLIT 7 NET TIME
		[28] => SPLIT 8 NET TIME
		[29] => SPLIT 9 NET TIME
		[30] => SPLIT 10 NET TIME
		[31] => SPLIT 11 NET TIME
		[32] => SPLIT 12 NET TIME
		[33] => SPLIT 13 NET TIME
		[34] => SPLIT 14 NET TIME
		[35] => SPLIT 15 NET TIME
*/

		/* Participantes */
		/*
0 = Cedula
1 = Nombre
2 = Apellido
3 = Numero
4 = Genero
5 = Categoria
+ = Carrera
7 = Pais
9 = Estado
9 = Edad
10 = Nacimiento
11 = Equipo
*/

		$handle = fopen($contenido, 'r');
		fgetcsv($handle, 30000, ";");
		while (($data_csv = fgetcsv($handle, 30000, ';')) !== FALSE) {
			/* Var cleaning */
			$data_csv[0] = trim(chop($this->db->escape($data_csv[0])));
			$data_csv[1] = trim(chop($this->db->escape($data_csv[1])));
			$data_csv[2] = trim(chop($this->db->escape($data_csv[2])));
			$data_csv[3] = trim(chop($this->db->escape($data_csv[3])));
			$data_csv[4] = trim(chop($this->db->escape($data_csv[4])));
			$data_csv[5] = trim(chop($this->db->escape($data_csv[5])));
			$data_csv[6] = trim(chop($this->db->escape($data_csv[6])));
			$data_csv[7] = trim(chop($this->db->escape($data_csv[7])));
			$data_csv[8] = trim(chop($this->db->escape($data_csv[8])));
			$data_csv[9] = trim(chop($this->db->escape($data_csv[9])));
			$data_csv[10] = trim(chop($this->db->escape($data_csv[10])));
			$data_csv[11] = trim(chop($this->db->escape($data_csv[11])));
			$data_csv[12] = trim(chop($this->db->escape($data_csv[12])));
			$data_csv[13] = trim(chop($this->db->escape($data_csv[13])));
			$data_csv[14] = trim(chop($this->db->escape($data_csv[14])));
			$data_csv[15] = trim(chop($this->db->escape($data_csv[15])));
			$data_csv[16] = trim(chop($this->db->escape($data_csv[16])));
			$data_csv[17] = trim(chop($this->db->escape($data_csv[17])));
			$data_csv[18] = trim(chop($this->db->escape($data_csv[18])));
			$data_csv[19] = trim(chop($this->db->escape($data_csv[19])));
			$data_csv[20] = trim(chop($this->db->escape($data_csv[20])));
			$data_csv[21] = trim(chop($this->db->escape($data_csv[21])));
			$data_csv[22] = trim(chop($this->db->escape($data_csv[22])));
			$data_csv[23] = trim(chop($this->db->escape($data_csv[23])));
			$data_csv[24] = trim(chop($this->db->escape($data_csv[24])));
			$data_csv[25] = trim(chop($this->db->escape($data_csv[25])));
			$data_csv[26] = trim(chop($this->db->escape($data_csv[26])));
			$data_csv[27] = trim(chop($this->db->escape($data_csv[27])));
			$data_csv[28] = trim(chop($this->db->escape($data_csv[28])));
			$data_csv[29] = trim(chop($this->db->escape($data_csv[29])));
			$data_csv[30] = trim(chop($this->db->escape($data_csv[30])));
			$data_csv[31] = trim(chop($this->db->escape($data_csv[31])));
			$data_csv[32] = trim(chop($this->db->escape($data_csv[32])));
			$data_csv[33] = trim(chop($this->db->escape($data_csv[33])));
			$data_csv[34] = trim(chop($this->db->escape($data_csv[34])));
			$data_csv[35] = trim(chop($this->db->escape($data_csv[35])));

			$sql_participantes = "INSERT INTO " . DB_PREFIX . "participantes SET id_evento = '" . (int) $eventos_id . "', cedula = '" . $data_csv[0] . "', nombre = '" . $data_csv[1] . "', apellido = '" . $data_csv[2] . "', numero = '" . $data_csv[3] . "', genero = '" . $data_csv[4] . "', categoria = '" . $data_csv[5] . "', carrera = '" . $data_csv[6] . "', fdum = NOW()";

			if (!empty($data_csv[7])) {
				$sql_participantes .= ", pais = '" . $data_csv[6] . "'";
			}

			if (!empty($data_csv[8])) {
				$sql_participantes .= ", estado = '" . $data_csv[7] . "'";
			}

			if (!empty($data_csv[9])) {
				$sql_participantes .= ", edad = '" . $data_csv[8] . "'";
			}

			if (!empty($data_csv[10])) {
				$sql_participantes .= ", fdn = '" . $data_csv[9] . "'";
			}

			if (!empty($data_csv[11])) {
				$sql_participantes .= ", equipo = '" . $data_csv[10] . "'";
			}

			$query = $this->db->query($sql_participantes);

			/* Resultados */
			/*
3 = Numero
12 = Posicion General
13 = Posicion por Genero
14 = Posicion por Categoria
15 = Tiempo Oficial
16 = Tiempo Tag
17 = Ritmo
18 = Vueltas
19 = URL Foto
20 = URL Resultado
21 = Punto Control 1
22 = Punto Control 2
23 = Punto Control 3
24 = Punto Control 4
25 = Punto Control 5
26 = Punto Control 6
27 = Punto Control 7
28 = Punto Control 8
29 = Punto Control 9
30 = Punto Control 10
31 = Punto Control 11
32 = Punto Control 12
33 = Punto Control 13
34 = Punto Control 14
35 = Punto Control 15
*/

			$sql_resultados = "INSERT INTO " . DB_PREFIX . "resultados SET id_evento = '" . (int) $eventos_id . "', numero = '" . $data_csv[3] . "', pos_general = '" . $data_csv[12] . "', pos_genero = '" . $data_csv[13] . "', pos_categoria = '" . $data_csv[14] . "', time_oficial = '" . $data_csv[15] . "', time_tag = '" . $data_csv[16] . "', fdum = NOW()";

			if (!empty($data_csv[17])) {
				$sql_resultados .= ", ritmo = '" . $data_csv[17] . "'";
			}

			if (!empty($data_csv[18])) {
				$sql_resultados .= ", vueltas = '" . $data_csv[18] . "'";
			}

			if (!empty($data_csv[19])) {
				$sql_resultados .= ", jpg_url = '" . $data_csv[19] . "'";
			}

			if (!empty($data_csv[20])) {
				$sql_resultados .= ", result_link = '" . $data_csv[20] . "'";
			}

			if (!empty($data_csv[21])) {
				$sql_resultados .= ", time_cp1 = '" . $data_csv[21] . "'";
			}

			if (!empty($data_csv[22])) {
				$sql_resultados .= ", time_cp2 = '" . $data_csv[22] . "'";
			}

			if (!empty($data_csv[23])) {
				$sql_resultados .= ", time_cp3 = '" . $data_csv[23] . "'";
			}

			if (!empty($data_csv[24])) {
				$sql_resultados .= ", time_cp4 = '" . $data_csv[24] . "'";
			}

			if (!empty($data_csv[25])) {
				$sql_resultados .= ", time_cp5 = '" . $data_csv[25] . "'";
			}

			if (!empty($data_csv[26])) {
				$sql_resultados .= ", time_cp6 = '" . $data_csv[26] . "'";
			}

			if (!empty($data_csv[27])) {
				$sql_resultados .= ", time_cp7 = '" . $data_csv[27] . "'";
			}

			if (!empty($data_csv[28])) {
				$sql_resultados .= ", time_cp8 = '" . $data_csv[28] . "'";
			}

			if (!empty($data_csv[29])) {
				$sql_resultados .= ", time_cp9 = '" . $data_csv[29] . "'";
			}

			if (!empty($data_csv[30])) {
				$sql_resultados .= ", time_cp10 = '" . $data_csv[30] . "'";
			}

			if (!empty($data_csv[31])) {
				$sql_resultados .= ", time_cp11 = '" . $data_csv[31] . "'";
			}

			if (!empty($data_csv[32])) {
				$sql_resultados .= ", time_cp12 = '" . $data_csv[32] . "'";
			}

			if (!empty($data_csv[33])) {
				$sql_resultados .= ", time_cp13 = '" . $data_csv[33] . "'";
			}

			if (!empty($data_csv[34])) {
				$sql_resultados .= ", time_cp14 = '" . $data_csv[34] . "'";
			}

			if (!empty($data_csv[35])) {
				$sql_resultados .= ", time_cp15 = '" . $data_csv[35] . "'";
			}

			$query = $this->db->query($sql_resultados);
		}

		fclose($handle);
	}

	public function importarResultadosEventoFAST($eventos_id, $contenido)
	{

		$table = 'import_resultados_' . $eventos_id;
		$handle = fopen($contenido, 'r');
		$frow = fgetcsv($handle, 30000, ";");

		foreach ($frow as $column) {
			if (isset($columns) && !empty($columns)) {
				$columns .= ', ';
			} else {
				$columns = '';
			}
			$columns .= '`' . $column . '` varchar(128)';
		}

		$this->db->query("CREATE TABLE IF NOT EXISTS " . $table . " (" . $columns . ")");

		echo "LOAD DATA LOCAL INFILE '" . addslashes($contenido) . "' INTO TABLE " . $table . " FIELDS TERMINATED BY ';' IGNORE 1 LINES";
		exit(0);

		$this->db->query("LOAD DATA LOCAL INFILE '" . addslashes($contenido) . "' INTO TABLE " . $table . " FIELDS TERMINATED BY ';' IGNORE 1 LINES");

		$this->db->query("DELETE FROM " . DB_PREFIX . "participantes WHERE id_evento = '" . (int) $eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "resultados WHERE id_evento = '" . (int) $eventos_id . "'");

		//		echo "INSERT INTO resultados (id_evento, numero, pos_general, pos_genero, pos_categoria, time_oficial, time_tag, fdum, ritmo, vueltas, jpg_url, result_link, time_cp1, time_cp2, time_cp3, time_cp4, time_cp5, time_cp6, time_cp7, time_cp8, time_cp9, time_cp10, time_cp11, time_cp12, time_cp13, time_cp14, time_cp15)  SELECT '" . (int)$eventos_id . "', `BIB`, `OVERALL_RANK`, `GENDER_RANK`, `PRIMARY_BRACKET_RANK`, `GUN_FINISH_TIME`, `FINISH_NET_TIME`, NOW(), `FINISH_NET_PACE`, `LAPS`, `JPG_URL`, `DIRECT_RESULT_LINK`, `SPLIT 1 NET TIME`, `SPLIT 2 NET TIME`, `SPLIT 3 NET TIME`, `SPLIT 4 NET TIME`, `SPLIT 5 NET TIME`, `SPLIT 6 NET TIME`, `SPLIT 7 NET TIME`, `SPLIT 8 NET TIME`, `SPLIT 9 NET TIME`, `SPLIT 10 NET TIME`, `SPLIT 11 NET TIME`, `SPLIT 12 NET TIME`, `SPLIT 13 NET TIME`, `SPLIT 14 NET TIME`, `SPLIT 15 NET TIME` FROM " . $table . " <br />";
		$this->db->query("INSERT INTO resultados (id_evento, numero, pos_general, pos_genero, pos_categoria, time_oficial, time_tag, fdum, ritmo, vueltas, jpg_url, result_link, time_cp1, time_cp2, time_cp3, time_cp4, time_cp5, time_cp6, time_cp7, time_cp8, time_cp9, time_cp10, time_cp11, time_cp12, time_cp13, time_cp14, time_cp15)  SELECT '" . (int) $eventos_id . "', `BIB`, `OVERALL_RANK`, `GENDER_RANK`, `PRIMARY_BRACKET_RANK`, `GUN_FINISH_TIME`, `FINISH_NET_TIME`, NOW(), `FINISH_NET_PACE`, `LAPS`, `JPG_URL`, `DIRECT_RESULT_LINK`, `SPLIT 1 NET TIME`, `SPLIT 2 NET TIME`, `SPLIT 3 NET TIME`, `SPLIT 4 NET TIME`, `SPLIT 5 NET TIME`, `SPLIT 6 NET TIME`, `SPLIT 7 NET TIME`, `SPLIT 8 NET TIME`, `SPLIT 9 NET TIME`, `SPLIT 10 NET TIME`, `SPLIT 11 NET TIME`, `SPLIT 12 NET TIME`, `SPLIT 13 NET TIME`, `SPLIT 14 NET TIME`, `SPLIT 15 NET TIME` FROM " . $table . "");

		//		echo "INSERT INTO participantes (id_evento, cedula, nombre, apellido, numero, genero, categoria, fdum, pais, estado, edad, fdn, equipo) SELECT '" . (int)$eventos_id . "', '', `FIRST_NAME`, `LAST_NAME`, `BIB`, `GENDER`, `PRIMARY_BRACKET`, NOW(), `COUNTRY_CODE`, `REGION_NAME`, `RACE_AGE`, `DOB`, `TEAM_NAME` FROM " . $table . " <br />";
		$this->db->query("INSERT INTO participantes (id_evento, cedula, nombre, apellido, numero, genero, categoria, carrera, fdum, pais, estado, edad, fdn, equipo) SELECT '" . (int) $eventos_id . "', '', `FIRST_NAME`, `LAST_NAME`, `BIB`, `GENDER`, `PRIMARY_BRACKET`, `REG_CHOICE`, NOW(), `COUNTRY_CODE`, `REGION_NAME`, `RACE_AGE`, `DOB`, `TEAM_NAME` FROM " . $table . "");

		/*
		$result = $this->db->query("SHOW COLUMNS FROM " . $table . "");
		echo '<pre>';
		print_r($result);
		echo '</pre>';
*/
		//		exit(0);

		fclose($handle);

		$this->db->query("DROP TABLE " . $table . "");
		//		exit(0);

	}

	public function getEventoFecha($eventos_id)
	{
		$query = $this->db->query("SELECT eventos_fecha AS fecha FROM " . DB_PREFIX . "eventos e WHERE e.eventos_id = '" . (int) $eventos_id . "'");

		return $query->row['fecha'];
	}

	public function getEventoStatus($eventos_id)
	{
		$query = $this->db->query("SELECT eventos_status AS status FROM " . DB_PREFIX . "eventos e WHERE e.eventos_id = '" . (int) $eventos_id . "'");

		return $query->row['status'];
	}
}

<?php
class ModelCatalogEvento extends Model {
	public function addEvento($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos SET eventos_titulo = '" . $this->db->escape($data['eventos_titulo']) . "', eventos_fecha = '" . $this->db->escape($data['eventos_fecha']) . "', eventos_hora = '" . $this->db->escape($data['eventos_hora']) . "', eventos_lugar = '" . $this->db->escape($data['eventos_lugar']) . "', eventos_orden = '" . (int)$data['eventos_orden'] . "', eventos_privado = '" . (int)$data['eventos_privado'] . "', eventos_afiche = '" . (int)$data['eventos_afiche'] . "', eventos_redireccion = '" . (int)$data['eventos_redireccion'] . "', eventos_redireccion_url = '" . $data['eventos_redireccion_url'] . "', eventos_cupos_apertura = '" . (int)$data['eventos_cupos_apertura'] . "', eventos_cupos_internet = '" . (int)$data['eventos_cupos_internet'] . "', eventos_restar_cupos = 1, eventos_restar = 1, eventos_edad_calendario = '" . (int)$data['eventos_edad_calendario'] . "', eventos_precio = '" . (float)$data['eventos_precio'] . "', eventos_fecha_disponible = '" . $this->db->escape($data['eventos_fecha_disponible']) . "', eventos_status = '" . (int)$data['eventos_status'] . "', eventos_home = '" . (int)$data['eventos_home'] . "', eventos_inscripciones = '" . (int)$data['eventos_inscripciones'] . "', eventos_id_impuesto = '" . (int)$data['eventos_id_impuesto'] . "', eventos_meta_keywords = '" . $this->db->escape($data['eventos_meta_keywords']) . "', eventos_meta_description = '" . $this->db->escape($data['eventos_meta_description']) . "', eventos_fdc = NOW() , eventos_fdum = NOW()");

		$eventos_id = $this->db->getLastId();

		$this->db->query("CREATE TABLE IF NOT EXISTS `solicitud_opcion_" . $eventos_id . "` (`order_option_id` INT(11) NOT NULL AUTO_INCREMENT, `order_id` int(11) NOT NULL, `order_product_id` int(11) NOT NULL, `product_option_id` int(11) NOT NULL, `product_option_value_id` int(11) NOT NULL DEFAULT '0', `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL, `value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL, `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL, PRIMARY KEY (`order_option_id`), KEY `order_id` (`order_id`), KEY `order_product_id` (`order_product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1");

		if (isset($data['eventos_logo'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_logo = '" . $this->db->escape($data['eventos_logo']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}

		if (isset($data['eventos_imagen_home'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_home = '" . $this->db->escape($data['eventos_imagen_home']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}

		if (isset($data['eventos_imagen_header'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_header = '" . $this->db->escape($data['eventos_imagen_header']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}

		if (isset($data['eventos_imagen_afiche'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_afiche = '" . $this->db->escape($data['eventos_imagen_afiche']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_descripcion SET eventos_descripcion_id_evento = '" . (int)$eventos_id . "', eventos_descripcion_info = '" . $this->db->escape($data['eventos_descripcion_info']) . "', eventos_descripcion_reglamento = '" . $this->db->escape($data['eventos_descripcion_reglamento']) . "', eventos_descripcion_premiacion = '" . $this->db->escape($data['eventos_descripcion_premiacion']) . "', eventos_descripcion_ruta = '" . $this->db->escape($data['eventos_descripcion_ruta']) . "', eventos_descripcion_tips = '" . $this->db->escape($data['eventos_descripcion_tips']) . "', eventos_descripcion_concurso = '" . $this->db->escape($data['eventos_descripcion_concurso']) . "', eventos_descripcion_inscripciones_online = '" . $this->db->escape($data['eventos_descripcion_inscripciones_online']) . "', eventos_descripcion_inscripciones_tiendas = '" . $this->db->escape($data['eventos_descripcion_inscripciones_tiendas']) . "', eventos_descripcion_materiales = '" . $this->db->escape($data['eventos_descripcion_materiales']) . "', eventos_descripcion_resultados_url = '" . $this->db->escape($data['eventos_descripcion_resultados_url']) . "', eventos_descripcion_responsabilidad = '" . $this->db->escape($data['eventos_descripcion_responsabilidad']) . "', eventos_descripcion_cedula = '" . $this->db->escape($data['eventos_descripcion_cedula']) . "', eventos_descripcion_club = '" . $this->db->escape($data['eventos_descripcion_club']) . "', eventos_descripcion_tallas = '" . $this->db->escape($data['eventos_descripcion_tallas']) . "', eventos_descripcion_circuito = '" . $this->db->escape($data['eventos_descripcion_circuito']) . "', eventos_descripcion_numeracion_id_tipo = '" . $this->db->escape($data['eventos_descripcion_numeracion_id_tipo']) . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

		if (isset($data['eventos_tipos_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_a_tipos SET eventos_a_tipos_id_evento = '" . (int)$eventos_id . "', eventos_a_tipos_id_tipo = '" . (int)$this->db->escape($data['eventos_tipos_id']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "'");

		if (isset($data['evento_patrocinante'])) {
			foreach ($data['evento_patrocinante'] as $patrocinante_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_a_patrocinantes SET eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "', eventos_patrocinantes_id = '" . (int)$patrocinante_id . "'");
			}
		}
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$eventos_id . "'");

		if (isset($data['evento_categoria'])) {
			foreach ($data['evento_categoria'] as $evento_categoria) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_categorias SET eventos_categorias_id_evento = '" . (int)$eventos_id . "', eventos_categorias_nombre = '" .  $this->db->escape($evento_categoria['eventos_categorias_nombre']) . "', eventos_categorias_edad_desde = '" .  $this->db->escape($evento_categoria['eventos_categorias_edad_desde']) . "', eventos_categorias_edad_hasta = '" .  $this->db->escape($evento_categoria['eventos_categorias_edad_hasta']) . "', eventos_categorias_genero = '" .  $this->db->escape($evento_categoria['eventos_categorias_genero']) . "', eventos_categorias_tipo = '" .  $this->db->escape($evento_categoria['eventos_categorias_tipo']) . "', eventos_categorias_grupo = '" .  $this->db->escape($evento_categoria['eventos_categorias_grupo']) . "'");
			}
		}

		// $this->db->query("DELETE FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "'");
		if (isset($data['evento_numeracion'])) {
			foreach ($data['evento_numeracion'] as $evento_numeracion) {
				switch($this->db->escape($data['eventos_descripcion_numeracion_id_tipo'])){
					case 1: //Grupos
						$numeros_totales = $this->db->escape($evento_numeracion['eventos_numeros_numero_hasta']);
						$numero_inicial = $this->db->escape($evento_numeracion['eventos_numeros_numero_desde']);
		
						for($i=$numero_inicial; $i<($numero_inicial + $numeros_totales); $i++){
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_evento = '" . (int)$eventos_id . "', eventos_numeros_numero = '" . (int)$i . "', eventos_numeros_reservados = 'N', eventos_numeros_grupo = '" . $this->db->escape($evento_numeracion['grupo']) . "'");
						}
						break;
		
					case 3: //Tiempos
						$numeros_totales	= $this->db->escape($evento_numeracion['eventos_numeros_numero_hasta']);
						$numero_inicial		= $this->db->escape($evento_numeracion['eventos_numeros_numero_desde']);
		
						for($i=$numero_inicial; $i<($numero_inicial + $numeros_totales); $i++){
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_evento = '" . (int)$eventos_id . "', eventos_numeros_numero = '" . (int)$i . "', eventos_numeros_reservados = 'N', eventos_numeros_td = '" .  $this->db->escape($evento_numeracion['eventos_numeros_td']) . "', eventos_numeros_th = '" .  $this->db->escape($evento_numeracion['eventos_numeros_th']) . "'");
						}
						break;
		
					case 2: //Estandar
						$numeros_totales	= $this->db->escape($evento_numeracion['eventos_numeros_numero_hasta']);
						$numero_inicial		= $this->db->escape($evento_numeracion['eventos_numeros_numero_desde']);
		
						for($i=$numero_inicial; $i<($numero_inicial + $numeros_totales); $i++){
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_evento = '" . (int)$eventos_id . "', eventos_numeros_numero = '" . (int)$i . "', eventos_numeros_reservados = 'N'");
						}
						break;
				}
			}
		}

		if (isset($data['eventos_numeros_reserva_nd']) && $data['eventos_numeros_reserva_nh']) {
			$reserva_nd = $this->db->escape($data['eventos_numeros_reserva_nd']);
			$reserva_nh = $this->db->escape($data['eventos_numeros_reserva_nh']);
	
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_reservados = 'Y' WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND (eventos_numeros_numero >= '" . $reserva_nd . "' AND eventos_numeros_numero <= '" . $reserva_nh . "')");
		}

		if (isset($data['eventos_numeros_libera_nd']) && $data['eventos_numeros_libera_nh']) {
			$libera_nd = $this->db->escape($data['eventos_numeros_libera_nd']);
			$libera_nh = $this->db->escape($data['eventos_numeros_libera_nh']);
	
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_reservados = 'N' WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND (eventos_numeros_numero >= '" . $libera_nd . "' AND eventos_numeros_numero <= '" . $libera_nh . "')");
		}

		if (isset($data['evento_opcion'])) {
			foreach ($data['evento_opcion'] as $evento_opcion) {
				if ($evento_opcion['opcion_tipo'] == 'select' || $evento_opcion['opcion_tipo'] == 'radio' || $evento_opcion['opcion_tipo'] == 'checkbox') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion SET eventos_opcion_id = '" . (int)$evento_opcion['eventos_opcion_id'] . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', eventos_opcion_requerido = '" . (int)$evento_opcion['eventos_opcion_requerido'] . "'");
				
					$eventos_opcion_id = $this->db->getLastId();
				
					if (isset($evento_opcion['eventos_opcion_valor'])) {
						foreach ($evento_opcion['eventos_opcion_valor'] as $evento_opcion_valor) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion_valor SET eventos_opcion_valor_id = '" . (int)$evento_opcion_valor['eventos_opcion_valor_id'] . "', eventos_opcion_id = '" . (int)$eventos_opcion_id . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', opcion_valor_id = '" . $this->db->escape($evento_opcion_valor['opcion_valor_id']) . "'");
						}
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion SET eventos_opcion_id = '" . (int)$evento_opcion['eventos_opcion_id'] . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', opcion_valor = '" . $this->db->escape($evento_opcion['opcion_valor']) . "', eventos_opcion_requerido = '" . (int)$evento_opcion['eventos_opcion_requerido'] . "'");
				}					
			}
		}

/*
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_galerias WHERE eventos_galerias_id_evento = '" . (int)$eventos_id . "'");
		
		if (isset($data['evento_image'])) {
			foreach ($data['evento_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_galerias SET eventos_galerias_id_evento = '" . (int)$eventos_id . "', eventos_galerias_imagen = '" . $this->db->escape($image) . "'");
			}
		}
*/		
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'eventos_id=" . (int)$eventos_id. "'");
		
		$this->cache->delete('evento');

	}
	
	public function editEvento($eventos_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_titulo = '" . $this->db->escape($data['eventos_titulo']) . "', eventos_fecha = '" . $this->db->escape($data['eventos_fecha']) . "', eventos_hora = '" . $this->db->escape($data['eventos_hora']) . "', eventos_lugar = '" . $this->db->escape($data['eventos_lugar']) . "', eventos_orden = '" . (int)$data['eventos_orden'] . "', eventos_privado = '" . (int)$data['eventos_privado'] . "', eventos_afiche = '" . (int)$data['eventos_afiche'] . "', eventos_redireccion = '" . (int)$data['eventos_redireccion'] . "', eventos_redireccion_url = '" . $data['eventos_redireccion_url'] . "', eventos_cupos_apertura = '" . (int)$data['eventos_cupos_apertura'] . "', eventos_cupos_internet = '" . (int)$data['eventos_cupos_internet'] . "', eventos_restar_cupos = 1, eventos_restar = 1, eventos_edad_calendario = '" . (int)$data['eventos_edad_calendario'] . "', eventos_precio = '" . (float)$data['eventos_precio'] . "', eventos_fecha_disponible = '" . $this->db->escape($data['eventos_fecha_disponible']) . "', eventos_status = '" . (int)$data['eventos_status'] . "', eventos_home = '" . (int)$data['eventos_home'] . "', eventos_inscripciones = '" . (int)$data['eventos_inscripciones'] . "', eventos_id_impuesto = '" . (int)$data['eventos_id_impuesto'] . "', eventos_meta_keywords = '" . $this->db->escape($data['eventos_meta_keywords']) . "', eventos_meta_description = '" . $this->db->escape($data['eventos_meta_description']) . "', eventos_fdum = NOW() WHERE eventos_id = '" . (int)$eventos_id . "'");

		if (isset($data['eventos_logo'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_logo = '" . $this->db->escape($data['eventos_logo']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}

		if (isset($data['eventos_imagen_home'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_home = '" . $this->db->escape($data['eventos_imagen_home']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}

		if (isset($data['eventos_imagen_header'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_header = '" . $this->db->escape($data['eventos_imagen_header']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}

		if (isset($data['eventos_imagen_afiche'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_imagen_afiche = '" . $this->db->escape($data['eventos_imagen_afiche']) . "' WHERE eventos_id = '" . (int)$eventos_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_descripcion SET eventos_descripcion_id_evento = '" . (int)$eventos_id . "', eventos_descripcion_info = '" . $this->db->escape($data['eventos_descripcion_info']) . "', eventos_descripcion_reglamento = '" . $this->db->escape($data['eventos_descripcion_reglamento']) . "', eventos_descripcion_premiacion = '" . $this->db->escape($data['eventos_descripcion_premiacion']) . "', eventos_descripcion_ruta = '" . $this->db->escape($data['eventos_descripcion_ruta']) . "', eventos_descripcion_tips = '" . $this->db->escape($data['eventos_descripcion_tips']) . "', eventos_descripcion_concurso = '" . $this->db->escape($data['eventos_descripcion_concurso']) . "', eventos_descripcion_inscripciones_online = '" . $this->db->escape($data['eventos_descripcion_inscripciones_online']) . "', eventos_descripcion_inscripciones_tiendas = '" . $this->db->escape($data['eventos_descripcion_inscripciones_tiendas']) . "', eventos_descripcion_materiales = '" . $this->db->escape($data['eventos_descripcion_materiales']) . "', eventos_descripcion_resultados_url = '" . $this->db->escape($data['eventos_descripcion_resultados_url']) . "', eventos_descripcion_responsabilidad = '" . $this->db->escape($data['eventos_descripcion_responsabilidad']) . "', eventos_descripcion_cedula = '" . $this->db->escape($data['eventos_descripcion_cedula']) . "', eventos_descripcion_club = '" . $this->db->escape($data['eventos_descripcion_club']) . "', eventos_descripcion_tallas = '" . $this->db->escape($data['eventos_descripcion_tallas']) . "', eventos_descripcion_circuito = '" . $this->db->escape($data['eventos_descripcion_circuito']) . "', eventos_descripcion_numeracion_id_tipo = '" . $this->db->escape($data['eventos_descripcion_numeracion_id_tipo']) . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

		if (isset($data['eventos_tipos_id'])) {
			foreach ($data['eventos_tipos_id'] as $tipo_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_a_tipos SET eventos_a_tipos_id_evento = '" . (int)$eventos_id . "', eventos_a_tipos_id_tipo = '" . (int)$tipo_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "'");

		if (isset($data['evento_patrocinante'])) {
			foreach ($data['evento_patrocinante'] as $patrocinante_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_a_patrocinantes SET eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "', eventos_patrocinantes_id = '" . (int)$patrocinante_id . "'");
			}
		}
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$eventos_id . "'");

		if (isset($data['evento_categoria'])) {
			foreach ($data['evento_categoria'] as $evento_categoria) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_categorias SET eventos_categorias_id_evento = '" . (int)$eventos_id . "', eventos_categorias_nombre = '" .  $this->db->escape($evento_categoria['eventos_categorias_nombre']) . "', eventos_categorias_edad_desde = '" .  $this->db->escape($evento_categoria['eventos_categorias_edad_desde']) . "', eventos_categorias_edad_hasta = '" .  $this->db->escape($evento_categoria['eventos_categorias_edad_hasta']) . "', eventos_categorias_genero = '" .  $this->db->escape($evento_categoria['eventos_categorias_genero']) . "', eventos_categorias_tipo = '" .  $this->db->escape($evento_categoria['eventos_categorias_tipo']) . "', eventos_categorias_grupo = '" .  $this->db->escape($evento_categoria['eventos_categorias_grupo']) . "'");
			}
		}

		// $this->db->query("DELETE FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "'");
		if (isset($data['evento_numeracion'])) {
			foreach ($data['evento_numeracion'] as $evento_numeracion) {
				switch($this->db->escape($data['eventos_descripcion_numeracion_id_tipo'])){
					case 1: //Grupos
						$numeros_totales = $this->db->escape($evento_numeracion['eventos_numeros_numero_hasta']);
						$numero_inicial = $this->db->escape($evento_numeracion['eventos_numeros_numero_desde']);
		
						for($i=$numero_inicial; $i<($numero_inicial + $numeros_totales); $i++){
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_evento = '" . (int)$eventos_id . "', eventos_numeros_numero = '" . (int)$i . "', eventos_numeros_reservados = 'N', eventos_numeros_grupo = '" . $this->db->escape($evento_numeracion['grupo']) . "'");
						}
						break;
		
					case 3: //Tiempos
						$numeros_totales	= $this->db->escape($evento_numeracion['eventos_numeros_numero_hasta']);
						$numero_inicial		= $this->db->escape($evento_numeracion['eventos_numeros_numero_desde']);
		
						for($i=$numero_inicial; $i<($numero_inicial + $numeros_totales); $i++){
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_evento = '" . (int)$eventos_id . "', eventos_numeros_numero = '" . (int)$i . "', eventos_numeros_reservados = 'N', eventos_numeros_td = '" .  $this->db->escape($evento_numeracion['eventos_numeros_td']) . "', eventos_numeros_th = '" .  $this->db->escape($evento_numeracion['eventos_numeros_th']) . "'");
						}
						break;
		
					case 2: //Estandar
						$numeros_totales	= $this->db->escape($evento_numeracion['eventos_numeros_numero_hasta']);
						$numero_inicial		= $this->db->escape($evento_numeracion['eventos_numeros_numero_desde']);
		
						for($i=$numero_inicial; $i<($numero_inicial + $numeros_totales); $i++){
							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_evento = '" . (int)$eventos_id . "', eventos_numeros_numero = '" . (int)$i . "', eventos_numeros_reservados = 'N'");
						}
						break;
				}
			}
		}


		if (isset($data['eventos_numeros_reserva_nd']) && $data['eventos_numeros_reserva_nh']) {
			$reserva_nd = $this->db->escape($data['eventos_numeros_reserva_nd']);
			$reserva_nh = $this->db->escape($data['eventos_numeros_reserva_nh']);
	
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_reservados = 'Y' WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND (eventos_numeros_numero >= '" . $reserva_nd . "' AND eventos_numeros_numero <= '" . $reserva_nh . "')");
		}

		if (isset($data['eventos_numeros_libera_nd']) && $data['eventos_numeros_libera_nh']) {
			$libera_nd = $this->db->escape($data['eventos_numeros_libera_nd']);
			$libera_nh = $this->db->escape($data['eventos_numeros_libera_nh']);
	
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_reservados = 'N' WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND (eventos_numeros_numero >= '" . $libera_nd . "' AND eventos_numeros_numero <= '" . $libera_nh . "')");
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_opcion WHERE eventos_id = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_opcion_valor WHERE eventos_id = '" . (int)$eventos_id . "'");
		
		if (isset($data['evento_opcion'])) {
			foreach ($data['evento_opcion'] as $evento_opcion) {
				if ($evento_opcion['opcion_tipo'] == 'select' || $evento_opcion['opcion_tipo'] == 'radio' || $evento_opcion['opcion_tipo'] == 'checkbox') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion SET eventos_opcion_id = '" . (int)$evento_opcion['eventos_opcion_id'] . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', eventos_opcion_requerido = '" . (int)$evento_opcion['eventos_opcion_requerido'] . "'");
				
					$eventos_opcion_id = $this->db->getLastId();
				
					if (isset($evento_opcion['eventos_opcion_valor'])) {
						foreach ($evento_opcion['eventos_opcion_valor'] as $evento_opcion_valor) {

//							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion_valor SET eventos_opcion_valor_id = '" . (int)$evento_opcion_valor['eventos_opcion_valor_id'] . "', eventos_opcion_id = '" . (int)$eventos_opcion_id . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', opcion_valor_id = '" . $this->db->escape($evento_opcion_valor['opcion_valor_id']) . "'");

//							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion_valor SET eventos_opcion_valor_id = '" . (int)$evento_opcion_valor['eventos_opcion_valor_id'] . "', eventos_opcion_id = '" . (int)$eventos_opcion_id . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', opcion_valor_id = '" . $this->db->escape($evento_opcion_valor['opcion_valor_id']) . "', cantidad = '" . (int)$evento_opcion_valor['cantidad'] . "', restar = '" . (int)$evento_opcion_valor['restar'] . "', precio = '" . (float)$evento_opcion_valor['precio'] . "', precio_prefijo = '" . $this->db->escape($evento_opcion_valor['precio_prefijo']) . "', puntos = '" . (int)$evento_opcion_valor['points'] . "', puntos_prefijo = '" . $this->db->escape($evento_opcion_valor['points_prefix']) . "', peso = '" . (float)$evento_opcion_valor['weight'] . "', peso_prefijo = '" . $this->db->escape($evento_opcion_valor['weight_prefix']) . "'");

							$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion_valor SET eventos_opcion_valor_id = '" . (int)$evento_opcion_valor['eventos_opcion_valor_id'] . "', eventos_opcion_id = '" . (int)$eventos_opcion_id . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', opcion_valor_id = '" . $this->db->escape($evento_opcion_valor['opcion_valor_id']) . "', cantidad = '" . (int)$evento_opcion_valor['cantidad'] . "', restar = '" . (int)$evento_opcion_valor['restar'] . "', precio = '" . (float)$evento_opcion_valor['precio'] . "', precio_prefijo = '" . $this->db->escape($evento_opcion_valor['precio_prefijo']) . "'");

						}
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_opcion SET eventos_opcion_id = '" . (int)$evento_opcion['eventos_opcion_id'] . "', eventos_id = '" . (int)$eventos_id . "', opcion_id = '" . (int)$evento_opcion['opcion_id'] . "', opcion_valor = '" . $this->db->escape($evento_opcion['opcion_valor']) . "', eventos_opcion_requerido = '" . (int)$evento_opcion['eventos_opcion_requerido'] . "'");
				}					
			}
		}

/*
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_galerias WHERE eventos_galerias_id_evento = '" . (int)$eventos_id . "'");
		
		if (isset($data['evento_image'])) {
			foreach ($data['evento_image'] as $image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_galerias SET eventos_galerias_id_evento = '" . (int)$eventos_id . "', eventos_galerias_imagen = '" . $this->db->escape($image) . "'");
			}
		}
*/		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_id=" . (int)$eventos_id. "'");
		
		$this->cache->delete('evento');
	}
	
	public function copyEvento($eventos_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE e.eventos_id  = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['keyword'] = '';

			$data['eventos_status'] = '0';
			$data['eventos_inscripciones'] = '0';
						
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
	
	public function deleteEvento($eventos_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos WHERE eventos_id = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_id=" . (int)$eventos_id. "'");
		
		$this->cache->delete('evento');
	}
	
	public function getEvento($eventos_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_id=" . (int)$eventos_id . "') AS keyword FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE e.eventos_id  = '" . (int)$eventos_id . "'");
				
		return $query->row;
	}
	
	public function getEventos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE 1 = 1"; 
		
			if (isset($data['filter_eventos_titulo']) && !is_null($data['filter_eventos_titulo'])) {
				$sql .= " AND LCASE(e.eventos_titulo) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_eventos_titulo'], 'UTF-8')) . "%'";
			}

			if (isset($data['filter_eventos_precio']) && !is_null($data['filter_eventos_precio'])) {
				$sql .= " AND e.eventos_precio LIKE '%" . $this->db->escape($data['filter_eventos_precio']) . "%'";
			}
			
			if (isset($data['filter_eventos_cupos_internet']) && !is_null($data['filter_eventos_cupos_internet'])) {
				$sql .= " AND e.eventos_cupos_internet = '" . $this->db->escape($data['filter_eventos_cupos_internet']) . "'";
			}
			
			if (isset($data['filter_eventos_status']) && !is_null($data['filter_eventos_status'])) {
				$sql .= " AND e.eventos_status = '" . (int)$data['filter_eventos_status'] . "'";
			}

			if (isset($data['filter_eventos_year']) && !is_null($data['filter_eventos_year'])) {
				$sql .= " AND YEAR(e.eventos_fecha) = '" . (int)$data['filter_eventos_year'] . "'";
			}


			$sort_data = array(
				'e.eventos_titulo',
				'e.eventos_privado',
				'e.eventos_precio',
				'e.eventos_restar_cupos',
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
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
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
	
	public function getTipo($eventos_id) {
		$query = $this->db->query("SELECT et.eventos_tipos_nombre FROM " . DB_PREFIX . "eventos_tipos et LEFT JOIN " . DB_PREFIX . "eventos_a_tipos eat ON (et.eventos_tipos_id = eat.eventos_a_tipos_id_tipo) WHERE eat.eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

		return $query->row['eventos_tipos_nombre'];
	}	

	public function getTipoID_X($eventos_id) {
		$query = $this->db->query("SELECT et.eventos_tipos_id FROM " . DB_PREFIX . "eventos_tipos et LEFT JOIN " . DB_PREFIX . "eventos_a_tipos eat ON (et.eventos_tipos_id = eat.eventos_a_tipos_id_tipo) WHERE eat.eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

		return $query->row['eventos_tipos_id'];
	}	


	public function getTipoID($eventos_id) {

		$evento_tipo_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");
		
		foreach ($query->rows as $result) {
			$evento_tipo_data[] = $result['eventos_a_tipos_id_tipo'];
		}

		return $evento_tipo_data;

	}



	public function getEventosByCategoryId($eventos_a_tipos_id_tipo) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) LEFT JOIN " . DB_PREFIX . "eventos_a_tipos e2t ON (e.eventos_id  = e2t.eventos_a_tipos_id_evento) WHERE e2t.eventos_a_tipos_id_tipo = '" . (int)$eventos_a_tipos_id_tipo . "' ORDER BY e.eventos_titulo ASC");
								  
		return $query->rows;
	} 
	
	public function getEventoDescripcion($eventos_id) {
		$evento_description_data = array();
		$query = $this->db->query("SELECT e.*, ed.* FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE e.eventos_id= '" . (int)$eventos_id . "'");

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
                'eventos_privado'                         	=> $result['eventos_privado'],
                'eventos_redireccion'						=> $result['eventos_redireccion'],
                'eventos_redireccion_url'					=> $result['eventos_redireccion_url'],
                'eventos_afiche'							=> $result['eventos_afiche'],
                'eventos_cupos_apertura'                	=> $result['eventos_cupos_apertura'],
                'eventos_cupos_internet'                	=> $result['eventos_cupos_internet'],
                'eventos_restar_cupos'             			=> $result['eventos_restar_cupos'],
                'eventos_restar'             				=> $result['eventos_restar'],
                'eventos_edad_calendario'             		=> $result['eventos_edad_calendario'],
                'eventos_precio'                        	=> $result['eventos_precio'],
                'eventos_fdc'                           	=> $result['eventos_fdc'],
                'eventos_fdum'                          	=> $result['eventos_fdum'],
                'eventos_fecha_disponible'              	=> $result['eventos_fecha_disponible'],
                'eventos_status'                        	=> $result['eventos_status'],
                'eventos_home'                        		=> $result['eventos_home'],
                'eventos_inscripciones'                     => $result['eventos_inscripciones'],
                'eventos_id_impuesto'                   	=> $result['eventos_id_impuesto'],
                'eventos_visitado'                      	=> $result['eventos_visitado'],
                'eventos_meta_keywords'          			=> $result['eventos_meta_keywords'],
                'eventos_meta_description'         			=> $result['eventos_meta_description'],

                'eventos_descripcion_info'					=> $result['eventos_descripcion_info'],
                'eventos_descripcion_reglamento'			=> $result['eventos_descripcion_reglamento'],
                'eventos_descripcion_premiacion'			=> $result['eventos_descripcion_premiacion'],
                'eventos_descripcion_ruta'					=> $result['eventos_descripcion_ruta'],
                'eventos_descripcion_tips'					=> $result['eventos_descripcion_tips'],
                'eventos_descripcion_concurso'				=> $result['eventos_descripcion_concurso'],
                'eventos_descripcion_inscripciones_online'	=> $result['eventos_descripcion_inscripciones_online'],
                'eventos_descripcion_inscripciones_tiendas'	=> $result['eventos_descripcion_inscripciones_tiendas'],
                'eventos_descripcion_materiales'			=> $result['eventos_descripcion_materiales'],
                'eventos_descripcion_mapa'					=> $result['eventos_descripcion_mapa'],
                'eventos_descripcion_resultados_url'		=> $result['eventos_descripcion_resultados_url'],
                'eventos_descripcion_responsabilidad'		=> $result['eventos_descripcion_responsabilidad'],
                'eventos_descripcion_ranking'       		=> $result['eventos_descripcion_ranking'],
                'eventos_descripcion_cuenta'				=> $result['eventos_descripcion_cuenta'],
                'eventos_descripcion_cedula'				=> $result['eventos_descripcion_cedula'],
                'eventos_descripcion_comentario'			=> $result['eventos_descripcion_comentario'],
                'eventos_descripcion_club'					=> $result['eventos_descripcion_club'],
                'eventos_descripcion_tallas'				=> $result['eventos_descripcion_tallas'],
                'eventos_descripcion_circuito'				=> $result['eventos_descripcion_circuito'],
                'eventos_descripcion_numeracion_id_tipo'	=> $result['eventos_descripcion_numeracion_id_tipo'],
                'eventos_descripcion_preguntas'				=> $result['eventos_descripcion_preguntas']
			);
		}
		
		return $evento_description_data;
	}

	public function getEventoPatrocinantes($eventos_id) {

		$evento_patrocinante_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "'");
		
		foreach ($query->rows as $result) {
			$evento_patrocinante_data[] = $result['eventos_patrocinantes_id'];
		}

		return $evento_patrocinante_data;

	}

	public function getEventoCategorias($eventos_id) {
		$evento_categoria_data = array();
		
		$evento_categoria_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$eventos_id . "'");
		
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

	public function getEventoNumeracion($eventos_id) {
		$evento_numeracion_data = array();
		
		$evento_numeracion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "'");
		
		foreach ($evento_numeracion_query->rows as $evento_numeracion) {
			$evento_numeracion_data[] = array(
				'eventos_numeros_id'			=> $evento_numeracion['eventos_numeros_id'],
				'eventos_numeros_td'     		=> $evento_numeracion['eventos_numeros_td'],
				'eventos_numeros_th' 			=> $evento_numeracion['eventos_numeros_th'],
				'eventos_numeros_numero_desde'	=> $evento_numeracion['eventos_numeros_numero_desde'],
				'eventos_numeros_numero_hasta'  => $evento_numeracion['eventos_numeros_numero_hasta'],
			);
		}
		
		return $evento_numeracion_data;
	}
	
	public function getEventoOpciones($evento_id) {
		$evento_opcion_data = array();
		
		$evento_opcion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_opcion eo LEFT JOIN " . DB_PREFIX . "opcion o ON (eo.opcion_id = o.opcion_id) LEFT JOIN " . DB_PREFIX . "opcion_descripcion od ON (o.opcion_id = od.opcion_id) WHERE eo.eventos_id = '" . (int)$evento_id . "'");
		
		foreach ($evento_opcion_query->rows as $evento_opcion) {
			if ($evento_opcion['opcion_tipo'] == 'select' || $evento_opcion['opcion_tipo'] == 'radio' || $evento_opcion['opcion_tipo'] == 'checkbox') {
				$evento_opcion_valor_data = array();	
				
				$evento_opcion_valor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_opcion_valor eov LEFT JOIN " . DB_PREFIX . "opcion_valor ov ON (eov.opcion_valor_id = ov.opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (ov.opcion_valor_id = ovd.opcion_valor_id) WHERE eov.eventos_opcion_id = '" . (int)$evento_opcion['eventos_opcion_id'] . "'");
				
				foreach ($evento_opcion_valor_query->rows as $evento_opcion_valor) {
					$evento_opcion_valor_data[] = array(
						'eventos_opcion_valor_id' 			=> $evento_opcion_valor['eventos_opcion_valor_id'],
						'opcion_valor_id'         			=> $evento_opcion_valor['opcion_valor_id'],
						'opcion_valor_decripcion_nombre'    => $evento_opcion_valor['opcion_valor_decripcion_nombre'],
						'cantidad'                			=> $evento_opcion_valor['cantidad'],
						'restar'                			=> $evento_opcion_valor['restar'],
						'precio'                   			=> $evento_opcion_valor['precio'],
						'precio_prefijo'           			=> $evento_opcion_valor['precio_prefijo'],
						'puntos'                  			=> $evento_opcion_valor['puntos'],
						'puntos_prefijo'           			=> $evento_opcion_valor['puntos_prefijo'],						
						'peso'                  			=> $evento_opcion_valor['peso'],
						'peso_prefijo'           			=> $evento_opcion_valor['peso_prefijo']					
					);
				}
				
				$evento_opcion_data[] = array(
					'eventos_opcion_id'    		=> $evento_opcion['eventos_opcion_id'],
					'opcion_id'            		=> $evento_opcion['opcion_id'],
					'opcion_nombre'        		=> $evento_opcion['opcion_nombre'],
					'opcion_tipo'          		=> $evento_opcion['opcion_tipo'],
					'eventos_opcion_valor' 		=> $evento_opcion_valor_data,
					'eventos_opcion_requerido'	=> $evento_opcion['eventos_opcion_requerido']
				);				
			} else {
				$evento_opcion_data[] = array(
					'eventos_opcion_id' 		=> $evento_opcion['eventos_opcion_id'],
					'opcion_id'         		=> $evento_opcion['opcion_id'],
					'opcion_nombre'     		=> $evento_opcion['opcion_nombre'],
					'opcion_tipo'       		=> $evento_opcion['opcion_tipo'],
					'opcion_valor'      		=> $evento_opcion['opcion_valor'],
					'eventos_opcion_requerido'	=> $evento_opcion['eventos_opcion_requerido']
				);				
			}
		}	
		
		return $evento_opcion_data;
	}

	public function getEventoImages($eventos_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_galerias WHERE eventos_galerias_id_evento = '" . (int)$eventos_id . "'");
		
		return $query->rows;
	}
	
	public function getEventoCategories($eventos_id) {
		$evento_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");
		
		foreach ($query->rows as $result) {
			$evento_category_data[] = $result['eventos_a_tipos_id_tipo'];
		}

		return $evento_category_data;
	}

	public function getTotalEventos($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE 1 = 1";
		
		if (isset($data['filter_eventos_titulo']) && !is_null($data['filter_eventos_titulo'])) {
			$sql .= " AND LCASE(e.eventos_titulo) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_eventos_titulo'], 'UTF-8')) . "%'";
		}

		if (isset($data['filter_model']) && !is_null($data['filter_model'])) {
			$sql .= " AND LCASE(e.model) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%'";
		}
		
		if (isset($data['filter_eventos_precio']) && !is_null($data['filter_eventos_precio'])) {
			$sql .= " AND e.eventos_precio LIKE '" . $this->db->escape($data['filter_eventos_precio']) . "%'";
		}
		
		if (isset($data['filter_eventos_cupos_internet']) && !is_null($data['filter_eventos_cupos_internet'])) {
			$sql .= " AND e.eventos_cupos_internet = '" . $this->db->escape($data['filter_eventos_cupos_internet']) . "'";
		}
		
		if (isset($data['filter_eventos_status']) && !is_null($data['filter_eventos_status'])) {
			$sql .= " AND e.eventos_status = '" . (int)$data['filter_eventos_status'] . "'";
		}

		if (isset($data['filter_eventos_year']) && !is_null($data['filter_eventos_year'])) {
			$sql .= " AND YEAR(e.eventos_fecha) = '" . (int)$data['filter_eventos_year'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	

	public function getEventosYears() {
		$sql = "SELECT DISTINCT YEAR(e.eventos_fecha) AS year FROM " . DB_PREFIX . "eventos e";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
		
	}	

	public function getTotalEventosByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalEventosByImpuestoClassId($impuestos_clase_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos WHERE impuestos_clase_id = '" . (int)$impuestos_clase_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalEventosByPatrocinanteId($patrocinantes_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_a_patrocinantes WHERE eventos_patrocinantes_id = '" . (int)$patrocinantes_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalEventosByAttributeId($eventos_categorias_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id = '" . (int)$eventos_categorias_id . "'");

		return $query->row['total'];
	}	

	public function getTotalEventosByOpcionId($opcion_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_opcion WHERE opcion_id = '" . (int)$opcion_id . "'");

		return $query->row['total'];
	}	

	public function getTotalParticipantesConfirmadosByEvento($eventos_id) {

//		$query = $this->db->query("SELECT COUNT(DISTINCT eventos_participantes_numero) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_numero > 0 AND eventos_participantes_inscripcion = 'Internet'");
		
		$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_numero > 0 AND eventos_participantes_inscripcion = 'Internet'");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesNoConfirmadosByEvento($eventos_id) {

//		$query = $this->db->query("SELECT COUNT(DISTINCT ep.eventos_participantes_id_cliente) as total FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN solicitud s ON (ep.eventos_participantes_id_pedido = s.order_id) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND ep.eventos_participantes_numero = 0 AND ep.eventos_participantes_inscripcion = 'Internet' AND ep.eventos_participantes_id_pedido IN (SELECT order_id FROM solicitud WHERE (order_status_id = 0 OR order_status_id = 1 OR order_status_id = 2) AND payment_number <> '')");
		
		$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "eventos_participantes` ep WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND ep.eventos_participantes_numero = 0 AND ep.eventos_participantes_inscripcion = 'Internet'");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesTiendasByEvento($eventos_id) {

		$query = $this->db->query("SELECT COUNT(DISTINCT eventos_participantes_numero) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_numero > 0 AND eventos_participantes_inscripcion <> 'Internet'");
		
		return $query->row['total'];
		
	}

	public function getEventoCuposUtilizados($evento_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_inscripcion = 'Internet'");

		return $query->row['total'];
	}	
	
	public function getEventoNumeracionTiempos($evento_id) {
		$evento_numeracion_tiempos_data = array();

		$evento_numeracion_tiempos_query = $this->db->query("SELECT eventos_numeros_td, eventos_numeros_th FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' GROUP BY eventos_numeros_td ORDER BY eventos_numeros_td ASC");

		foreach ($evento_numeracion_tiempos_query->rows as $result) {
			$tiempo_desde = $result['eventos_numeros_td'];
			$tiempo_hasta = $result['eventos_numeros_th'];

			$numero_minimo_query = $this->db->query("SELECT eventos_numeros_numero FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_td = '" . $tiempo_desde . "' AND eventos_numeros_th = '" . $tiempo_hasta . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");
			$numero_minimo = $numero_minimo_query->row['eventos_numeros_numero'];

			$numero_maximo_query = $this->db->query("SELECT eventos_numeros_numero FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_td = '" . $tiempo_desde . "' AND eventos_numeros_th = '" . $tiempo_hasta . "' ORDER BY eventos_numeros_numero DESC LIMIT 1");
			$numero_maximo = $numero_maximo_query->row['eventos_numeros_numero'];

			/* Store the highest time to suggest a time to the user */
			/* this will be updated till the last cycle of the while leave it as the highest */
			$tiempo_sugerido = date('H:i:s', strtotime($result['eventos_numeros_th'])+1);

			/* Total numbers just to display them */
			$numeros_totales_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_td = '" . $tiempo_desde . "' AND eventos_numeros_th = '" . $tiempo_hasta . "'");
			$numeros_totales = $numeros_totales_query->row['total'];

			/* Total available numbers just to display them */
			$numeros_disponibles_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_td = '" . $tiempo_desde . "' AND eventos_numeros_th = '" . $tiempo_hasta . "' AND eventos_numeros_id_cliente = ''");
			$numeros_disponibles = $numeros_disponibles_query->row['total'];

			/* Total reserved numbers just to display them */
			$numeros_reservados_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_td = '" . $tiempo_desde . "' AND eventos_numeros_th = '" . $tiempo_hasta . "' AND eventos_numeros_reservados = 'Y'");
			$numeros_reservados = $numeros_reservados_query->row['total'];

			$evento_numeracion_tiempos_data[] = array(
				'td'			=> $tiempo_desde,
				'th'			=> $tiempo_hasta,
				'intervalo'		=> $numero_minimo.' - '.$numero_maximo,
				'total'     	=> $numeros_totales,
				'disponible' 	=> $numeros_disponibles,
				'reservado'		=> $numeros_reservados,
			);
		}

		return $evento_numeracion_tiempos_data;
	}	

	public function getEventoNumeracionGrupos($evento_id) {
		$evento_numeracion_grupos_data = array();

		$evento_numeracion_grupos_query = $this->db->query("SELECT eventos_categorias_grupo FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$evento_id . "' GROUP BY eventos_categorias_grupo ORDER BY eventos_categorias_grupo");

		foreach ($evento_numeracion_grupos_query->rows as $result) {
			$grupo = $result['eventos_categorias_grupo'];

			$numero_inicial_query = $this->db->query("SELECT eventos_numeros_numero FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_grupo = '" . $grupo . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");

			if ($this->db->countAffected() != 0) {
				$numero_inicial = $numero_inicial_query->row['eventos_numeros_numero'];
			} else {
				$numero_inicial = 0;
			}

			$numero_final_query = $this->db->query("SELECT eventos_numeros_numero FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_grupo = '" . $grupo . "' ORDER BY eventos_numeros_numero DESC LIMIT 1");

			if ($this->db->countAffected() != 0) {
				$numero_final = $numero_final_query->row['eventos_numeros_numero'];
			} else {
				$numero_final = 0;
			}
	
			/* Total numbers just to display them */
			$numeros_totales_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_grupo = '" . $grupo . "'");
			$numeros_totales = $numeros_totales_query->row['total'];

			/* Total available numbers just to display them */
			$numeros_disponibles_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_grupo = '" . $grupo . "' AND eventos_numeros_id_cliente = ''");
			$numeros_disponibles = $numeros_disponibles_query->row['total'];

			/* Total reserved numbers just to display them */
			$numeros_reservados_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_grupo = '" . $grupo . "' AND eventos_numeros_reservados = 'Y'");
			$numeros_reservados = $numeros_reservados_query->row['total'];

			$evento_numeracion_grupos_data[] = array(
				'grupo'			=> $grupo,
				'intervalo'		=> $numero_inicial.' - '.$numero_final,
				'total'     	=> $numeros_totales,
				'disponible' 	=> $numeros_disponibles,
				'reservado'		=> $numeros_reservados,
			);
		}

		return $evento_numeracion_grupos_data;
	}	

	public function getEventoNumeracionEstandar($evento_id) {
		$evento_numeracion_estandar_data = array();

		$numero_inicial_query = $this->db->query("SELECT eventos_numeros_numero FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");
		
		if ($this->db->countAffected() != 0) {
			$numero_inicial = $numero_inicial_query->row['eventos_numeros_numero'];
		} else {
			$numero_inicial = 0;
		}
		

		$numero_final_query = $this->db->query("SELECT eventos_numeros_numero FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' ORDER BY eventos_numeros_numero DESC LIMIT 1");

		if ($this->db->countAffected() != 0) {
			$numero_final = $numero_final_query->row['eventos_numeros_numero'];
		} else {
			$numero_final = 0;
		}

		/* Total numbers just to display them */
		$numeros_totales_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "'");
		$numeros_totales = $numeros_totales_query->row['total'];

		/* Total available numbers just to display them */
		$numeros_disponibles_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente = ''");
		$numeros_disponibles = $numeros_disponibles_query->row['total'];

		/* Total reserved numbers just to display them */
		$numeros_reservados_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_reservados = 'Y'");
		$numeros_reservados = $numeros_reservados_query->row['total'];

		$evento_numeracion_estandar_data[] = array(
			'intervalo'		=> $numero_inicial.' - '.$numero_final,
			'total'     	=> $numeros_totales,
			'disponible' 	=> $numeros_disponibles,
			'reservado'		=> $numeros_reservados,
		);

		return $evento_numeracion_estandar_data;
	}	

	public function getEventoTotalTiemposPrevios($evento_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_tiempos WHERE eventos_tiempos_id_evento = '" . (int)$evento_id . "'");

		return $query->row['total'];
	}	

	public function getEventoTotalNumeros($evento_id) {
		$query = $this->db->query("SELECT COUNT(eventos_numeros_numero) AS total FROM " . DB_PREFIX . "eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' LIMIT 1");

		return $query->row['total'];
	}	
	
	public function importarNumeracionEvento($eventos_id, $contenido) {


		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_tiempos WHERE eventos_tiempos_id_evento = '" . (int)$eventos_id . "'");

//	        $handle = fopen($_FILES['prev_times']['tmp_name'], 'r');
		$handle = fopen($contenido, 'r');
		while(($data_csv = fgetcsv($handle, 1000, ';')) !== FALSE){
			/* Var cleaning */
			$data_csv[0] = trim(chop(mysql_real_escape_string($data_csv[0])));
			$data_csv[1] = trim(chop(mysql_real_escape_string($data_csv[1])));

			if((preg_match("/^([0-9]+)$/", $data_csv[0])) and (preg_match("/^(0?\d|1[0-2]):([0-5]\d):([0-5]\d)$/", $data_csv[1]))){
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_tiempos SET eventos_tiempos_id_evento = '" . (int)$eventos_id . "', eventos_tiempos_id_cliente = '" . $data_csv[0] . "', eventos_tiempos_tiempo = '" . $data_csv[1] . "'");
			}
		}
		fclose($handle);
		
	}

	public function importarResultadosEvento($eventos_id, $contenido) {


		$this->db->query("DELETE FROM " . DB_PREFIX . "resultados WHERE id_evento = '" . (int)$eventos_id . "'");

//	        $handle = fopen($_FILES['prev_times']['tmp_name'], 'r');
		$handle = fopen($contenido, 'r');
		while(($data_csv = fgetcsv($handle, 1000, ';')) !== FALSE){
			/* Var cleaning */
			$data_csv[0] = trim(chop(mysql_real_escape_string($data_csv[0])));
			$data_csv[1] = trim(chop(mysql_real_escape_string($data_csv[1])));
			$data_csv[2] = trim(chop(mysql_real_escape_string($data_csv[2])));
			$data_csv[3] = trim(chop(mysql_real_escape_string($data_csv[3])));
			$data_csv[4] = trim(chop(mysql_real_escape_string($data_csv[4])));
			$data_csv[5] = trim(chop(mysql_real_escape_string($data_csv[5])));
			$data_csv[6] = trim(chop(mysql_real_escape_string($data_csv[6])));
			$data_csv[7] = trim(chop(mysql_real_escape_string($data_csv[7])));
			$data_csv[8] = trim(chop(mysql_real_escape_string($data_csv[8])));

//			if((preg_match("/^([0-9]+)$/", $data_csv[0])) and (preg_match("/^(0?\d|1[0-2]):([0-5]\d):([0-5]\d)$/", $data_csv[1]))){
			if(preg_match("/^([0-9]+)$/", $data_csv[0])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "resultados SET id_evento = '" . (int)$eventos_id . "', cedula = '" . $data_csv[0] . "', nombre = '" . $data_csv[1] . "', numero = '" . $data_csv[2] . "', categoria = '" . $data_csv[3] . "', pos_general = '" . $data_csv[4] . "', pos_genero = '" . $data_csv[5] . "', pos_categoria = '" . $data_csv[6] . "', time_tag = '" . $data_csv[7] . "', time_oficial = '" . $data_csv[8] . "'");
			}
		}
		fclose($handle);
		
	}

	public function importarCircuitoEvento($eventos_id, $contenido) {


		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_circuitos WHERE eventos_circuitos_id_evento = '" . (int)$eventos_id . "'");

		$handle = fopen($contenido, 'r');
		while(($data_csv = fgetcsv($handle, 1000, ';')) !== FALSE){
			/* Var cleaning */
			$data_csv[0] = trim(chop(mysql_real_escape_string($data_csv[0])));
			$data_csv[1] = trim(chop(mysql_real_escape_string($data_csv[1])));
			
			$cadena = $data_csv[1];
			$maximo = strlen($cadena);
			$grupo_sport = "SPORT";
			$grupo_experto = "EXPERTOS";
			$total1 = strpos($cadena,$grupo_sport);
			$total2 = strpos($cadena,$grupo_experto);
			
			if ($total1 === 0) {
				$final = substr ($cadena, 0, 5);
			} else if ($total2 === 0) {
				$final = substr ($cadena, 0, 8);	
			}

			if (preg_match("/^([0-9]+)$/", $data_csv[0])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_circuitos SET eventos_circuitos_id_evento = '" . (int)$eventos_id . "', eventos_circuitos_id_cliente = '" . $data_csv[0] . "', eventos_circuitos_grupo = '" . ucfirst(strtolower($final)) . "'");
			}

		}
		fclose($handle);
		
	}

	public function updateRankingEvento($eventos_id, $contenido) {


		$this->db->query("UPDATE " . DB_PREFIX . "eventos_descripcion SET eventos_descripcion_ranking = '" . $contenido . "' WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

	}

	public function getEventoCircuito($eventos_id) {

		$query = $this->db->query("SELECT eventos_descripcion_circuito FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->row['eventos_descripcion_circuito'] == 1) {
			return true;
		} else {
			return false;
		}

	}

	public function getEventoEdadCalendario($eventos_id) {

		$query = $this->db->query("SELECT eventos_edad_calendario FROM " . DB_PREFIX . "eventos WHERE eventos_id = '" . (int)$eventos_id . "'");
		
		return $query->row['eventos_edad_calendario'];

	}

	public function getEventoTipoNumeracion($eventos_id) {

		$query = $this->db->query("SELECT eventos_descripcion_numeracion_id_tipo FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
		
		return $query->row['eventos_descripcion_numeracion_id_tipo'];

	}

	public function getIntervalosTiempo($eventos_id) {

		$query = $this->db->query("SELECT eventos_numeros_td, eventos_numeros_th FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' GROUP BY eventos_numeros_td ORDER BY eventos_numeros_td ASC");
//             $query = $this->db->query("SELECT eventos_descripcion_numeracion_id_tipo AS tipo FROM " . DB_PREFIX . "eventos_descripcion ed WHERE ed.eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

		return $query->rows;
	}

        public function getTiempoPrevio($cedula, $eventos_id) {
            $query = $this->db->query("SELECT eventos_tiempos_tiempo AS tiempo FROM " . DB_PREFIX . "eventos_tiempos et WHERE et.eventos_tiempos_id_cliente = '" . $cedula . "' AND et.eventos_tiempos_id_evento = '" . (int)$eventos_id . "' ORDER BY eventos_tiempos_tiempo ASC LIMIT 1");

            if ($query->num_rows) {
				return $query->row['tiempo'];
			} else {
				return false;
			}
        }

        public function getTipoNumeracion($eventos_id) {
            $query = $this->db->query("SELECT eventos_descripcion_numeracion_id_tipo AS tipo FROM " . DB_PREFIX . "eventos_descripcion ed WHERE ed.eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

            return $query->row['tipo'];
        }

}
?>
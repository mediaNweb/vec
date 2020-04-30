<?php
    class ModelCatalogEventos extends Model {
        public function updateViewed($eventos_id) {
            $this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_visitado = (eventos_visitado + 1) WHERE eventos_id = '" . (int)$eventos_id . "'");
        }

	public function getEvento($eventos_id) {

		$query = $this->db->query("SELECT DISTINCT e.* FROM " . DB_PREFIX . "eventos e WHERE e.eventos_id = '" . (int)$eventos_id . "' AND e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW()");
		
		if ($query->num_rows) {
			return array(
				'eventos_id' 				=> $query->row['eventos_id'],
				'eventos_titulo'			=> $query->row['eventos_titulo'],
				'eventos_fecha'				=> $query->row['eventos_fecha'],
				'eventos_hora'				=> $query->row['eventos_hora'],
				'eventos_lugar'				=> $query->row['eventos_lugar'],
				'eventos_logo'				=> $query->row['eventos_logo'],
				'eventos_imagen_home'		=> $query->row['eventos_imagen_home'],
				'eventos_imagen_header'		=> $query->row['eventos_imagen_header'],
				'eventos_imagen_afiche'		=> $query->row['eventos_imagen_afiche'],
				'eventos_orden'				=> $query->row['eventos_orden'],
				'eventos_privado'			=> $query->row['eventos_privado'],
				'eventos_afiche'			=> $query->row['eventos_afiche'],
				'eventos_redireccion'		=> $query->row['eventos_redireccion'],
				'eventos_redireccion_url'	=> $query->row['eventos_redireccion_url'],
				'eventos_cupos_internet'	=> $query->row['eventos_cupos_internet'],
				'eventos_restar_cupos'		=> $query->row['eventos_restar_cupos'],
				'eventos_restar'			=> $query->row['eventos_restar'],
				'eventos_edad_calendario'	=> $query->row['eventos_edad_calendario'],
				'eventos_precio'			=> $query->row['eventos_precio'],
				'eventos_fdc'				=> $query->row['eventos_fdc'],
				'eventos_fdum'				=> $query->row['eventos_fdum'],
				'eventos_fecha_disponible'	=> $query->row['eventos_fecha_disponible'],
				'eventos_inscripciones'		=> $query->row['eventos_inscripciones'],
				'eventos_status'			=> $query->row['eventos_status'],
				'eventos_id_impuesto'		=> $query->row['eventos_id_impuesto'],
				'eventos_visitado'			=> $query->row['eventos_visitado'],
				'eventos_meta_keywords'		=> $query->row['eventos_meta_keywords'],
				'eventos_meta_description'	=> $query->row['eventos_meta_description'],
			);
		} else {
			return false;
		}
	}

        public function getEventos() {

            $query = $this->db->query("SELECT e.* FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW() ORDER BY e.eventos_orden ASC");

            return $query->rows;            
        }

        public function getEventosCart() {

//          $query = $this->db->query("SELECT e.* FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE e.eventos_fecha_disponible <= NOW() AND e.eventos_cupos_internet > '0' AND e.eventos_status = '1'");
            $query = $this->db->query("SELECT e.* FROM " . DB_PREFIX . "eventos e WHERE e.eventos_fecha_disponible <= NOW() AND e.eventos_cupos_internet > '0' AND e.eventos_status = '1' ORDER BY e.eventos_orden ASC");

            return $query->rows;            
        }
        
        public function getEventoPatrocinantes($eventos_id) {

            $query = $this->db->query("SELECT ep.* FROM " . DB_PREFIX . "eventos_a_patrocinantes ep WHERE ep.eventos_patrocinantes_id_evento = '" . (int)$eventos_id . "' ORDER BY ep.eventos_patrocinantes_id ASC");

            return $query->rows;            
        }

        public function getEventoDescripcion($eventos_id) {

			$query = $this->db->query("SELECT e.*, ed.* FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE e.eventos_id= '" . (int)$eventos_id . "'");

            if ($query->num_rows) {
                return array(
                'eventos_id'                            	=> $query->row['eventos_id'],
                'eventos_titulo'                        	=> $query->row['eventos_titulo'],
                'eventos_fecha'                         	=> $query->row['eventos_fecha'],
                'eventos_hora'                          	=> $query->row['eventos_hora'],
                'eventos_lugar'                         	=> $query->row['eventos_lugar'],
                'eventos_logo'                          	=> $query->row['eventos_logo'],
                'eventos_imagen_home'                   	=> $query->row['eventos_imagen_home'],
                'eventos_imagen_header'                 	=> $query->row['eventos_imagen_header'],
                'eventos_imagen_afiche'                 	=> $query->row['eventos_imagen_afiche'],
                'eventos_orden'                         	=> $query->row['eventos_orden'],
                'eventos_redireccion'						=> $query->row['eventos_redireccion'],
                'eventos_redireccion_url'					=> $query->row['eventos_redireccion_url'],
                'eventos_afiche'							=> $query->row['eventos_afiche'],
                'eventos_cupos_internet'                	=> $query->row['eventos_cupos_internet'],
                'eventos_restar_cupos'             			=> $query->row['eventos_restar_cupos'],
                'eventos_restar'             				=> $query->row['eventos_restar'],
                'eventos_edad_calendario'             		=> $query->row['eventos_edad_calendario'],
                'eventos_precio'                        	=> $query->row['eventos_precio'],
                'eventos_fdc'                           	=> $query->row['eventos_fdc'],
                'eventos_fdum'                          	=> $query->row['eventos_fdum'],
                'eventos_fecha_disponible'              	=> $query->row['eventos_fecha_disponible'],
				'eventos_inscripciones'						=> $query->row['eventos_inscripciones'],
                'eventos_status'                        	=> $query->row['eventos_status'],
                'eventos_id_impuesto'                   	=> $query->row['eventos_id_impuesto'],
                'eventos_visitado'                      	=> $query->row['eventos_visitado'],
                'eventos_meta_keywords'          			=> $query->row['eventos_meta_keywords'],
                'eventos_meta_description'         			=> $query->row['eventos_meta_description'],

                'eventos_descripcion_info'					=> $query->row['eventos_descripcion_info'],
                'eventos_descripcion_reglamento'			=> $query->row['eventos_descripcion_reglamento'],
                'eventos_descripcion_premiacion'			=> $query->row['eventos_descripcion_premiacion'],
                'eventos_descripcion_ruta'					=> $query->row['eventos_descripcion_ruta'],
                'eventos_descripcion_inscripciones_online'	=> $query->row['eventos_descripcion_inscripciones_online'],
                'eventos_descripcion_inscripciones_tiendas'	=> $query->row['eventos_descripcion_inscripciones_tiendas'],
                'eventos_descripcion_materiales'			=> $query->row['eventos_descripcion_materiales'],
                'eventos_descripcion_mapa'					=> $query->row['eventos_descripcion_mapa'],
                'eventos_descripcion_resultados_url'		=> $query->row['eventos_descripcion_resultados_url'],
                'eventos_descripcion_responsabilidad'		=> $query->row['eventos_descripcion_responsabilidad'],
                'eventos_descripcion_ranking'       		=> $query->row['eventos_descripcion_ranking'],
                'eventos_descripcion_cuenta'				=> $query->row['eventos_descripcion_cuenta'],
                'eventos_descripcion_cedula'				=> $query->row['eventos_descripcion_cedula'],
                'eventos_descripcion_comentario'			=> $query->row['eventos_descripcion_comentario'],
                'eventos_descripcion_club'					=> $query->row['eventos_descripcion_club'],
                'eventos_descripcion_tallas'				=> $query->row['eventos_descripcion_tallas'],
                'eventos_descripcion_circuito'				=> $query->row['eventos_descripcion_circuito'],
                'eventos_descripcion_numeracion_id_tipo'	=> $query->row['eventos_descripcion_numeracion_id_tipo'],
                'eventos_descripcion_preguntas'				=> $query->row['eventos_descripcion_preguntas'],
                );
                
            } else {
                return false;
            }
        }

        public function getLatestEventos($limit) {
            $eventos_data = $this->cache->get('eventos.latest.' . '.' . $limit);

            if (!$eventos_data) { 
                $query = $this->db->query("SELECT e.eventos_id FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW() ORDER BY e.eventos_fdc DESC LIMIT " . (int)$limit);

                foreach ($query->rows as $result) {
                    $eventos_data[$result['eventos_id']] = $this->getEvento($result['eventos_id']);
                }

                $this->cache->set('eventos.latest.' . '.' . $limit, $eventos_data);
            }

            return $eventos_data;
        }

        public function getPopularEventos($limit) {
            $eventos_data = array();

            $query = $this->db->query("SELECT e.eventos_id FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW() ORDER BY e.eventos_visitado, e.eventos_fdc DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) { 		
                $eventos_data[$result['eventos_id']] = $this->getEvento($result['eventos_id']);
            }

            return $eventos_data;
        }

        public function getBestSellerEventos($limit) {
            $eventos_data = $this->cache->get('eventos.bestseller.' . '.' . $limit);

            if (!$eventos_data) { 
                $eventos_data = array();

                $query = $this->db->query("SELECT pe.pedidos_eventos_id_evento, COUNT(*) AS total FROM " . DB_PREFIX . "pedidos_eventos pe LEFT JOIN `" . DB_PREFIX . "pedidos p ON (pe.pedidos_eventos_id_pedido = p.pedidos_id) LEFT JOIN `" . DB_PREFIX . "eventos e ON (pe.pedidos_eventos_id_evento = e.eventos_id) WHERE p.pedidos_id_status > '0' AND e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW() GROUP BY pe.eventos_id ORDER BY total DESC LIMIT " . (int)$limit);

                foreach ($query->rows as $result) { 		
                    $eventos_data[$result['eventos_id']] = $this->getEvento($result['eventos_id']);
                }

                $this->cache->set('eventos.bestseller.' . '.' . $limit, $eventos_data);
            }

            return $eventos_data;
        }

        public function getEventoImages($eventos_id) {
            $query = $this->db->query("SELECT eventos_imagen FROM " . DB_PREFIX . "eventos WHERE eventos_id = '" . (int)$eventos_id . "'");

            return $query->rows;
        }

        public function getEventoLogo($eventos_id) {
            $query = $this->db->query("SELECT eventos_logo FROM " . DB_PREFIX . "eventos WHERE eventos_id = '" . (int)$eventos_id . "'");

            return $query->rows;
        }

        public function getResponsabilidad($eventos_id) {
            $query = $this->db->query("SELECT eventos_descripcion_responsabilidad FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

            return $query->row;
        }

        public function getCategories($eventos_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

            return $query->rows;
        }	

        public function getTotalEventos() {
            $query = $this->db->query("SELECT COUNT(DISTINCT e.eventos_id) AS total FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW()");

            return $query->row['total'];
        }


	public function getEventoOpciones($eventos_id) {
		$eventos_opcion_data = array();

		$eventos_opcion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_opcion eo LEFT JOIN " . DB_PREFIX . "opcion o ON (eo.opcion_id = o.opcion_id) LEFT JOIN " . DB_PREFIX . "opcion_descripcion od ON (o.opcion_id = od.opcion_id) WHERE eo.eventos_id = '" . (int)$eventos_id . "' ORDER BY o.opcion_orden");
		
		foreach ($eventos_opcion_query->rows as $eventos_opcion) {
			if ($eventos_opcion['opcion_tipo'] == 'select' || $eventos_opcion['opcion_tipo'] == 'radio' || $eventos_opcion['opcion_tipo'] == 'checkbox') {
				$eventos_opcion_valor_data = array();
			
				$eventos_opcion_valor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_opcion_valor eov LEFT JOIN " . DB_PREFIX . "opcion_valor ov ON (eov.opcion_valor_id = ov.opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (ov.opcion_valor_id = ovd.opcion_valor_id) WHERE eov.eventos_id = '" . (int)$eventos_id . "' AND eov.eventos_opcion_id = '" . (int)$eventos_opcion['eventos_opcion_id'] . "' ORDER BY ov.opcion_valor_orden");
				
				foreach ($eventos_opcion_valor_query->rows as $eventos_opcion_valor) {
					$eventos_opcion_valor_data[] = array(
						'eventos_opcion_valor_id' 			=> $eventos_opcion_valor['eventos_opcion_valor_id'],
						'opcion_valor_id'         			=> $eventos_opcion_valor['opcion_valor_id'],
						'opcion_valor_decripcion_nombre'	=> $eventos_opcion_valor['opcion_valor_decripcion_nombre'],
					);
				}
									
				$eventos_opcion_data[] = array(
					'eventos_opcion_id' 		=> $eventos_opcion['eventos_opcion_id'],
					'opcion_id'         		=> $eventos_opcion['opcion_id'],
					'opcion_nombre'     		=> $eventos_opcion['opcion_nombre'],
					'opcion_dato'     			=> $eventos_opcion['opcion_dato'],
					'opcion_tipo'       		=> $eventos_opcion['opcion_tipo'],
					'opcion_valor'      		=> $eventos_opcion_valor_data,
					'eventos_opcion_requerido'	=> $eventos_opcion['eventos_opcion_requerido']
				);
			} else {
				$eventos_opcion_data[] = array(
					'eventos_opcion_id' 		=> $eventos_opcion['eventos_opcion_id'],
					'opcion_id'         		=> $eventos_opcion['opcion_id'],
					'opcion_nombre'     		=> $eventos_opcion['opcion_nombre'],
					'opcion_dato'     			=> $eventos_opcion['opcion_dato'],
					'opcion_tipo'       		=> $eventos_opcion['opcion_tipo'],
					'opcion_valor'      		=> $eventos_opcion['opcion_valor'],
					'eventos_opcion_requerido'	=> $eventos_opcion['eventos_opcion_requerido']
				);				
			}
      	}
		
		return $eventos_opcion_data;
	}
    }
?>
<?php
    class ModelCatalogEventos extends Model {
        public function updateViewed($eventos_id) {
            $this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_visitado = (eventos_visitado + 1) WHERE eventos_id = '" . (int)$eventos_id . "'");
        }

	public function getEventoCupos($eventos_id) {

		$query = $this->db->query("SELECT e.eventos_cupos_internet FROM " . DB_PREFIX . "eventos e WHERE e.eventos_id = '" . (int)$eventos_id . "' AND e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW()");
		
		return $query->row['eventos_cupos_internet'];
		
	}

	public function getFechaEvento($eventos_id) {

		$query = $this->db->query("SELECT e.eventos_fecha FROM " . DB_PREFIX . "eventos e WHERE e.eventos_id = '" . (int)$eventos_id . "'");
		
		return $query->row['eventos_fecha'];
		
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
				'eventos_precio'			=> $query->row['eventos_precio'],
				'eventos_fdc'				=> $query->row['eventos_fdc'],
				'eventos_fdum'				=> $query->row['eventos_fdum'],
				'eventos_fecha_disponible'	=> $query->row['eventos_fecha_disponible'],
				'eventos_inscripciones'		=> $query->row['eventos_inscripciones'],
				'eventos_status'			=> $query->row['eventos_status'],
				'eventos_revista'			=> $query->row['eventos_revista'],
				'eventos_certificado'		=> $query->row['eventos_certificado'],
				'eventos_certificado_foto'	=> $query->row['eventos_certificado_foto'],
				'eventos_id_impuesto'		=> $query->row['eventos_id_impuesto'],
				'eventos_visitado'			=> $query->row['eventos_visitado'],
				'eventos_meta_keywords'		=> $query->row['eventos_meta_keywords'],
				'eventos_meta_description'	=> $query->row['eventos_meta_description'],
			);
		} else {
			return false;
		}
	}

	public function getEventoResultados($eventos_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "resultados r WHERE r.id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function getEventoResultadosTiempoMin($eventos_id) {

		$query = $this->db->query("SELECT MIN(time_oficial) AS tiempo FROM " . DB_PREFIX . "resultados r WHERE r.id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			return $query->row['tiempo'];
		} else {
			return false;
		}
	}

	public function getEventoResultadosTiempoMax($eventos_id) {

		$query = $this->db->query("SELECT MAX(time_oficial) AS tiempo FROM " . DB_PREFIX . "resultados r WHERE r.id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			return $query->row['tiempo'];
		} else {
			return false;
		}
	}

	public function getEventoResultadosTiempoAvg($eventos_id) {

		$query = $this->db->query("SELECT TIME(ADDTIME(MIN(time_oficial), MAX(time_oficial)) / 2) AS tiempo FROM " . DB_PREFIX . "resultados r WHERE r.id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			return $query->row['tiempo'];
		} else {
			return false;
		}
	}

	public function getEventoResultadosPorcentajeMin($eventos_id) {

		$query = $this->db->query("SELECT FLOOR(((TIME_TO_SEC(MIN(time_oficial)) * 100) / TIME_TO_SEC(MAX(time_oficial)))) AS porcentaje FROM " . DB_PREFIX . "resultados r WHERE r.id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			return $query->row['porcentaje'];
		} else {
			return false;
		}
	}

	public function getResultadosAbsolutos($eventos_id) {

		$query = $this->db->query("SELECT r.*, p.cedula, p.nombre, p.genero, p.categoria FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' ORDER BY pos_general LIMIT 10");
		
		if ($query->num_rows) {
			return $query->rows;
		} else {
			return false;
		}
	}
	
	public function getTotalAbsolutos($eventos_id, $carrera) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND p.carrera = '" . $carrera . "'");
		
		if ($query->num_rows) {
			return $query->row['total'];
		} else {
			return false;
		}
	}
	
	public function getResultadosGenero($eventos_id) {

		$query_generos = $this->db->query("SELECT DISTINCT p.genero FROM " . DB_PREFIX . "participantes p WHERE p.id_evento = '" . (int)$eventos_id . "' ORDER BY p.genero");

		foreach ($query_generos->rows as $result) {
			
			$genero = $result['genero'];
			
			$query = $this->db->query("SELECT r.*, p.cedula, p.nombre, p.genero, p.categoria FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND p.genero = '" . $genero . "' ORDER BY pos_genero LIMIT 10");
			
			$resultados_data[] = array(
				'genero' 		=> $genero,
				'resultados'	=> $query->rows,
			);				

		}
		
		return $resultados_data;

	}
	
	public function getTotalGenero($eventos_id, $carrera, $genero) {

		$query_generos = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "participantes p WHERE p.id_evento = '" . (int)$eventos_id . "' AND p.carrera = '" . $carrera . "' AND p.genero = '" . $genero . "'");

		if ($query_generos->num_rows) {
			return $query_generos->row['total'];
		} else {
			return false;
		}

	}
	
	public function getResultadosCategoria($eventos_id) {

		$query_categorias = $this->db->query("SELECT DISTINCT p.categoria FROM " . DB_PREFIX . "participantes p WHERE p.id_evento = '" . (int)$eventos_id . "' ORDER BY p.categoria");

		foreach ($query_categorias->rows as $result) {
			
			$categoria = $result['categoria'];

			$query = $this->db->query("SELECT r.*, p.cedula, p.nombre, p.genero, p.categoria FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND p.categoria = '" . $result['categoria'] . "' ORDER BY pos_categoria LIMIT 10");
			
			$resultados_data[] = array(
				'categoria' 	=> $categoria,
				'resultados'	=> $query->rows,
			);				

		}
		
		return $resultados_data;

	}
	
	public function getTotalCategoria($eventos_id, $carrera, $categoria) {

		$query_categorias = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "participantes p WHERE p.id_evento = '" . (int)$eventos_id . "' AND p.carrera = '" . $carrera . "' AND p.categoria = '" . $categoria . "'");

		if ($query_categorias->num_rows) {
			return $query_categorias->row['total'];
		} else {
			return false;
		}

	}
	
	public function getResultadoParticipanteByNumero($numero, $eventos_id) {

		$query = $this->db->query("SELECT r.*, p.* FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND r.numero = '" . (int)$numero . "' LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
	
	public function getResultadoParticipanteByCedula($cedula, $eventos_id) {

		$query = $this->db->query("SELECT r.*, p.cedula, p.nombre, p.genero, p.categoria FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND p.cedula = '" . $cedula . "' LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
	
	public function getResultadoGanadorGeneral($eventos_id, $carrera) {

		$query = $this->db->query("SELECT r.*, p.* FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND p.carrera = '" . $carrera . "' AND r.pos_general = 1 LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
	
	public function getResultadoGanadorGenero($eventos_id, $carrera, $genero) {

		$query = $this->db->query("SELECT r.*, p.* FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND r.pos_genero = 1 AND p.carrera = '" . $carrera . "' AND p.genero = '" . $genero . "' LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
	
	public function getResultadoGanadorCategoria($eventos_id, $carrera, $categoria) {

		$query = $this->db->query("SELECT r.*, p.* FROM resultados r LEFT JOIN participantes p ON(r.id_evento = p.id_evento AND r.numero = p.numero) WHERE r.id_evento = '" . (int)$eventos_id . "' AND p.carrera = '" . $carrera . "' AND r.pos_categoria = 1 AND p.categoria = '" . $categoria . "' LIMIT 1");
		
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
	

        public function getEventosMore($id_evento, $start = 0, $limit = 5) {

            $query = $this->db->query("SELECT e.* FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW() AND e.eventos_privado = 0 AND e.eventos_home = 1 AND e.eventos_id < " . (int)$id_evento ." ORDER BY e.eventos_id DESC LIMIT " . (int)$start . "," . (int)$limit);

			if ($query->num_rows) {
				return $query->rows;
			} else {
				return false;
			}
        }

        public function getEventos($start = 0, $limit = 5) {

			if ($start < 0) {
				$start = 0;
			}

            $query = $this->db->query("SELECT e.* FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_fecha_disponible <= NOW() AND e.eventos_privado = 0 AND e.eventos_home = 1 ORDER BY e.eventos_id DESC LIMIT " . (int)$start . "," . (int)$limit);

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
                'eventos_privado'                         	=> $query->row['eventos_privado'],
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
                'eventos_revista'                        	=> $query->row['eventos_revista'],
                'eventos_certificado'                       => $query->row['eventos_certificado'],
                'eventos_certificado_foto'                  => $query->row['eventos_certificado_foto'],
                'eventos_id_impuesto'                   	=> $query->row['eventos_id_impuesto'],
                'eventos_visitado'                      	=> $query->row['eventos_visitado'],
                'eventos_meta_keywords'          			=> $query->row['eventos_meta_keywords'],
                'eventos_meta_description'         			=> $query->row['eventos_meta_description'],

                'eventos_descripcion_info'					=> $query->row['eventos_descripcion_info'],
                'eventos_descripcion_reglamento'			=> $query->row['eventos_descripcion_reglamento'],
                'eventos_descripcion_premiacion'			=> $query->row['eventos_descripcion_premiacion'],
                'eventos_descripcion_ruta'					=> $query->row['eventos_descripcion_ruta'],
                'eventos_descripcion_tips'					=> $query->row['eventos_descripcion_tips'],
                'eventos_descripcion_concurso'				=> $query->row['eventos_descripcion_concurso'],
                'eventos_descripcion_inscripciones_online'			=> $query->row['eventos_descripcion_inscripciones_online'],
                'eventos_descripcion_inscripciones_tiendas'			=> $query->row['eventos_descripcion_inscripciones_tiendas'],
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

        public function getMandamientos($eventos_id = 86) {
            $query = $this->db->query("SELECT eventos_descripcion_reglamento FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

            return $query->row['eventos_descripcion_reglamento'];
        }

        public function getInformacionRuta($eventos_id) {
            $query = $this->db->query("SELECT eventos_descripcion_ruta FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
			
            return $query->row['eventos_descripcion_ruta'];
        }

        public function getCategories($eventos_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_a_tipos WHERE eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

            return $query->rows;
        }	

        public function getTotalEventos() {
            $query = $this->db->query("SELECT COUNT(DISTINCT e.eventos_id) AS total FROM " . DB_PREFIX . "eventos e WHERE e.eventos_status = '1' AND e.eventos_home = '1' AND e.eventos_fecha_disponible <= NOW()");

            return $query->row['total'];
        }

        public function getTiempoPrevio($cedula, $eventos_id) {
            $query = $this->db->query("SELECT eventos_tiempos_tiempo AS tiempo FROM " . DB_PREFIX . "eventos_tiempos et WHERE et.eventos_tiempos_id_cliente = '" . $cedula . "' AND et.eventos_tiempos_id_evento = '" . (int)$eventos_id . "' ORDER BY eventos_tiempos_tiempo ASC LIMIT 1");

            if ($query->num_rows) {
				return $query->row['tiempo'];
			} else {
				return false;
			}
        }

        public function getHistorialCircuito($cedula, $eventos_id) {
            $query = $this->db->query("SELECT eventos_circuitos_grupo AS grupo FROM " . DB_PREFIX . "eventos_circuitos ec WHERE ec.eventos_circuitos_id_cliente = '" . $cedula . "' AND ec.eventos_circuitos_id_evento = '" . (int)$eventos_id . "' ORDER BY eventos_circuitos_id ASC LIMIT 1");

            if ($query->num_rows) {
				return $query->row['grupo'];
			} else {
				return false;
			}
        }

        public function getTipoNumeracion($eventos_id) {
            $query = $this->db->query("SELECT eventos_descripcion_numeracion_id_tipo AS tipo FROM " . DB_PREFIX . "eventos_descripcion ed WHERE ed.eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

            return $query->row['tipo'];
        }

        public function getCircuitoByEvento($eventos_id) {
            $query = $this->db->query("SELECT eventos_descripcion_circuito AS circuito FROM " . DB_PREFIX . "eventos_descripcion ed WHERE ed.eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

            return $query->row['circuito'];
        }

        public function getTipoByEvento($eventos_id) {
            $query = $this->db->query("SELECT eventos_a_tipos_id_tipo AS tipo FROM " . DB_PREFIX . "eventos_a_tipos eat WHERE eat.eventos_a_tipos_id_evento = '" . (int)$eventos_id . "' AND (eat.eventos_a_tipos_id_tipo = 2 OR eat.eventos_a_tipos_id_tipo = 3)");

            return $query->row['tipo'];
        }

        public function getLastEventosByTipo($tipo_id) {
            $query = $this->db->query("SELECT eventos_a_tipos_id_evento AS evento FROM " . DB_PREFIX . "eventos_a_tipos eat WHERE eat.eventos_a_tipos_id_tipo = '" . (int)$tipo_id . "' ORDER BY eventos_a_tipos_id_evento DESC LIMIT 100 OFFSET 1");

            return $query->rows;
        }

        public function getIntervalosTiempo($eventos_id) {

            $query = $this->db->query("SELECT eventos_numeros_td, eventos_numeros_th FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' GROUP BY eventos_numeros_td ORDER BY eventos_numeros_td ASC");
//             $query = $this->db->query("SELECT eventos_descripcion_numeracion_id_tipo AS tipo FROM " . DB_PREFIX . "eventos_descripcion ed WHERE ed.eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");

            return $query->rows;
        }

        public function getLastIntervalosTiempo($eventos_id) {
            $query = $this->db->query("SELECT MAX(eventos_numeros_th) AS tiempo FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "'");

            return $query->row['tiempo'];
        }

	public function getEventoOpciones($eventos_id) {
		$eventos_opcion_data = array();

		$eventos_opcion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_opcion eo LEFT JOIN " . DB_PREFIX . "opcion o ON (eo.opcion_id = o.opcion_id) LEFT JOIN " . DB_PREFIX . "opcion_descripcion od ON (o.opcion_id = od.opcion_id) WHERE eo.eventos_id = '" . (int)$eventos_id . "' ORDER BY o.opcion_orden");
		
		foreach ($eventos_opcion_query->rows as $eventos_opcion) {
			if ($eventos_opcion['opcion_tipo'] == 'select' || $eventos_opcion['opcion_tipo'] == 'radio' || $eventos_opcion['opcion_tipo'] == 'checkbox') {
				$eventos_opcion_valor_data = array();
			
				$eventos_opcion_valor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_opcion_valor eov LEFT JOIN " . DB_PREFIX . "opcion_valor ov ON (eov.opcion_valor_id = ov.opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (ov.opcion_valor_id = ovd.opcion_valor_id) WHERE eov.eventos_id = '" . (int)$eventos_id . "' AND eov.eventos_opcion_id = '" . (int)$eventos_opcion['eventos_opcion_id'] . "' AND eov.cantidad > 0 ORDER BY ov.opcion_valor_orden");
				
				foreach ($eventos_opcion_valor_query->rows as $eventos_opcion_valor) {
					$eventos_opcion_valor_data[] = array(
						'eventos_opcion_valor_id' 			=> $eventos_opcion_valor['eventos_opcion_valor_id'],
						'opcion_valor_id'         			=> $eventos_opcion_valor['opcion_valor_id'],
						'opcion_valor_decripcion_nombre'	=> $eventos_opcion_valor['opcion_valor_decripcion_nombre'],
						'cantidad'                			=> $eventos_opcion_valor['cantidad'],
						'restar'                			=> $eventos_opcion_valor['restar'],
						'precio'                   			=> $eventos_opcion_valor['precio'],
						'precio_prefijo'            		=> $eventos_opcion_valor['precio_prefijo'],
						'peso'                  			=> $eventos_opcion_valor['peso'],
						'peso_prefijo'           			=> $eventos_opcion_valor['peso_prefijo']			
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
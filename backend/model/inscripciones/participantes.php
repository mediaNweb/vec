<?php
class ModelInscripcionesParticipantes extends Model {	

	public function create($solicitud, $planilla = '', $tipo_inscripcion = 'Tienda', $byscript = 'Backdoor', $empleado = '', $restar = false) {
		
		$this->load->model('inscripciones/solicitud');

		$eventos_opciones = $this->model_inscripciones_solicitud->getEventosBySolicitudOpcion($solicitud);

		foreach ($eventos_opciones as $evento_opcion) {

			$codigo_evento = $this->model_inscripciones_solicitud->getEventoIdByOpcion($solicitud, $evento_opcion['codigo_opcion']);
			$cedula = $this->getParticipanteCedula($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$apellidos = $this->getParticipanteApellido($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$nombres = $this->getParticipanteNombre($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$genero = $this->getParticipanteGenero($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$fdn = $this->getParticipanteFdn($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$email = $this->getParticipanteEmail($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$cel = $this->getParticipanteCelular($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$id_pais = $this->getParticipantePais($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$id_estado = $this->getParticipanteEstado($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$tiempo = $this->getParticipanteTiempo($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$grupo = $this->getParticipanteGrupo($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$edad = $this->getParticipanteEdad($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$categoria = $this->getParticipanteCategoria($solicitud, $evento_opcion['codigo_opcion'], $codigo_evento);
			$participante = $this->isParticipante($cedula, $codigo_evento);

			if(!$participante) {

				$this->db->query("INSERT INTO `" . DB_PREFIX . "eventos_participantes` SET eventos_participantes_id_evento = '" . (int)$codigo_evento . "', eventos_participantes_id_pedido = '" . $solicitud . "', eventos_participantes_id_cliente = '" . $cedula . "', eventos_participantes_id_empleado = '" . $empleado . "', eventos_participantes_cedula = '" . $cedula . "', eventos_participantes_apellidos = '" . $this->db->escape($apellidos) . "', eventos_participantes_nombres = '" . $this->db->escape($nombres) . "', eventos_participantes_genero = '" . $genero . "', eventos_participantes_fdn = '" . $fdn . "', eventos_participantes_email = '" . $email . "', eventos_participantes_cel = '" . $cel . "', eventos_participantes_id_pais = '" . $id_pais . "', eventos_participantes_id_estado = '" . $id_estado . "', eventos_participantes_tiempo = '" . $tiempo . "', eventos_participantes_grupo = '" . $this->db->escape($grupo) . "', eventos_participantes_edad = '" . $edad . "', eventos_participantes_categoria = '" . $this->db->escape($categoria) . "', eventos_participantes_byscript = '" . $byscript . "', eventos_participantes_planilla = '" . $this->db->escape($planilla) . "', eventos_participantes_inscripcion = '" . $this->db->escape($tipo_inscripcion) . "', eventos_participantes_datos = '" . (int)$evento_opcion['codigo_opcion'] . "', eventos_participantes_fdc = NOW(), eventos_participantes_fdum = NOW()");
				
				if($restar) {

					$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_cupos_internet = (eventos_cupos_internet - 1) WHERE eventos_id = '" . (int)$codigo_evento . "' AND eventos_restar = '1'");
				
				}

			} 
			
		}

	}

	public function deleteParticipante($participante_id) {
		
		$inscripcion = $this->getInscripcionByParticipante($participante_id);
		$numero = $this->getNumeroByParticipante($participante_id);
		$evento_id = $this->getEventoByParticipante($participante_id);
		$solicitud_id = $this->getSolicitudByParticipante($participante_id);
		$solicitud_opcion = $this->getSolicitudOpcionByParticipante($participante_id);
		
		if ($numero) {
			$this->liberaNumero($numero, $evento_id);
		}

		if ($inscripcion == 'Internet') {
			$this->devolverCupo($evento_id);
		}

		$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_evento WHERE order_id = '" . (int)$solicitud_id . "'");
		
		foreach ($order_product_query->rows as $order_product) {

			$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$order_product['product_id'] . " WHERE order_id = '" . (int)$solicitud_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");
		
			foreach ($order_option_query->rows as $option) {
				$this->db->query("UPDATE " . DB_PREFIX . "eventos_opcion_valor SET cantidad = (cantidad + " . (int)$order_product['quantity'] . ") WHERE eventos_opcion_valor_id = '" . (int)$option['product_option_value_id'] . "' AND restar = '1'");
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id = '" . (int)$participante_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$evento_id . " WHERE order_id = '" . (int)$solicitud_id . "' AND order_product_id = '" . (int)$solicitud_opcion . "'");

		$this->load->model('inscripciones/solicitud');
		$this->model_inscripciones_solicitud->update($solicitud_id, 8, $comment = '', $notify = false);
		
	}

	public function editParticipante($participante_id, $data) {
		
		$tiempo = (isset($data['eventos_participantes_tiempo'])) ? $this->db->escape($data['eventos_participantes_tiempo']) : '';
		$grupo = (isset($data['eventos_participantes_grupo'])) ? $this->db->escape($data['eventos_participantes_grupo']) : '';
		
		$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_id_cliente = '" . $this->db->escape($data['eventos_participantes_cedula']) . "', eventos_participantes_cedula = '" . $this->db->escape($data['eventos_participantes_cedula']) . "', eventos_participantes_apellidos = '" . $this->db->escape($data['eventos_participantes_apellidos']) . "', eventos_participantes_nombres = '" . $this->db->escape($data['eventos_participantes_nombres']) . "', eventos_participantes_genero = '" . $this->db->escape($data['eventos_participantes_genero']) . "', eventos_participantes_fdn = '" . $data['eventos_participantes_fdn'] . "', eventos_participantes_email = '" . $this->db->escape($data['eventos_participantes_email']) . "', 	eventos_participantes_cel = '" . $data['eventos_participantes_cel'] . "', eventos_participantes_id_pais = '" . (int)$data['eventos_participantes_id_pais'] . "', eventos_participantes_id_estado = '" . (int)$data['eventos_participantes_id_estado'] . "', eventos_participantes_tiempo = '" . $tiempo . "', eventos_participantes_grupo = '" . $grupo . "', eventos_participantes_edad = '" . (int)$data['eventos_participantes_edad'] . "', eventos_participantes_categoria = '" . $this->db->escape($data['eventos_participantes_categoria']) . "', eventos_participantes_fdum = NOW() WHERE eventos_participantes_id = '" . (int)$participante_id . "'");

	}

	public function getParticipantesIdDatos($eventos_id, $order_id, $cliente_id) {

		$datos_query = $this->db->query("SELECT eventos_participantes_datos FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_evento = '" . (int)$eventos_id . "' AND eventos_participantes_id_pedido = '" . (int)$order_id . "' AND eventos_participantes_cedula = '" . $cliente_id . "'");

		return $datos_query->row['eventos_participantes_datos'];

	}

	public function getParticipanteComboByOpcion($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Inscripcion en Caracas Rock 2012'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteCedula($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Cédula'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteApellido($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Apellido'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteNombre($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Nombre'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteGenero($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Género'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteFdn($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Fecha de Nacimiento'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteEmail($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Correo Electrónico'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteCelular($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Celular'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipantePais($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'País'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteEstado($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Estado'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteEdad($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Edad'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteCategoria($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Categoría'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteGrupo($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Grupo'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteModalidad($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Modalidad'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteTiempo($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Tiempo'");

		if ($datos_query->num_rows) {
			
			if ($datos_query->row['value'] != 'n/a' ) {

				return $datos_query->row['value'];
				
			} else {

				$datos_query2 = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Rango'");
		
				if ($datos_query2->num_rows) {
	
					return $datos_query2->row['value'];
	
				} else {
	
					return false;	
	
				}
			
			}

		}

	}

	public function getParticipanteTiempoX($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Tiempo'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getCorreoNumeroCAF($order_id, $order_product_id, $id_evento) {
		
		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "' AND name = 'Número de corredor'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}

	public function getParticipanteNumero($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_numero AS numero FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['numero'];

	}

	public function getCedulaParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_cedula AS cedula FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['cedula'];

	}

	public function getApellidoParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_apellidos AS apellido FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['apellido'];

	}

	public function getNombreParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_nombres AS nombre FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['nombre'];

	}

	public function getGeneroParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_genero AS genero FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['genero'];

	}

	public function getFdnParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_fdn AS fdn FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['fdn'];

	}

	public function getEmailParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_email AS email FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['email'];

	}

	public function getCelularParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_cel AS cel FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['cel'];

	}

	public function getPaisParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_id_pais AS pais FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['pais'];

	}

	public function getEstadoParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_id_estado AS estado FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['estado'];

	}

	public function getEdadParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_edad AS edad FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['edad'];

	}

	public function getCategoriaParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_categoria AS categoria FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['categoria'];

	}

	public function getGrupoParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_grupo AS grupo FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['grupo'];

	}

	public function getTiempoParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_tiempo AS tiempo FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['tiempo'];

	}

	public function getNumeroParticipante($cliente, $evento) {
		
		$datos_query = $this->db->query("SELECT eventos_participantes_numero AS numero FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
			
		return $datos_query->row['numero'];

	}

	public function updateGrupo($order_id, $order_product_id, $categoria) {
		
		if ($categoria == 'Caminata') {
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_opcion (`order_option_id`, `order_id`, `order_product_id`, `product_option_id`, `product_option_value_id`, `name`, `value`, `type`) VALUES (NULL, '" . (int)$order_id . "', '" . (int)$order_product_id . "', '0', '0', 'Grupo', 'Caminata', '')");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_opcion (`order_option_id`, `order_id`, `order_product_id`, `product_option_id`, `product_option_value_id`, `name`, `value`, `type`) VALUES (NULL, '" . (int)$order_id . "', '" . (int)$order_product_id . "', '0', '0', 'Grupo', 'Carrera', '')");
			
		}

	}

	public function getParticipante($eventos_id) {
		$participante_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eventos_participantes` ep WHERE ep.eventos_participantes_id_evento = '" . (int)$eventos_id . "'");
			
		if ($participante_query->num_rows) {
			
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paises` WHERE paises_id = '" . (int)$participante_query->row['payment_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['paises_iso_code_2'];
				$payment_iso_code_3 = $country_query->row['paises_iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "estados` WHERE estados_id = '" . (int)$participante_query->row['payment_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['estados_codigo'];
			} else {
				$payment_zone_code = '';
			}

			$this->load->model('localidad/idioma');
			
			$idioma_info = $this->model_localidad_idioma->getIdioma($participante_query->row['language_id']);
			
			if ($idioma_info) {
				$idioma_code = $idioma_info['code'];
				$idioma_filename = $idioma_info['filename'];
				$idioma_directory = $idioma_info['directory'];
			} else {
				$idioma_code = '';
				$idioma_filename = '';
				$idioma_directory = '';
			}
		 			
			return array(
				'eventos_participantes_id'			=> $participante_query->row['eventos_participantes_id'],
				'eventos_participantes_id_evento'   => $participante_query->row['eventos_participantes_id_evento'],
				'eventos_participantes_id_pedido'   => $participante_query->row['eventos_participantes_id_pedido'],
				'eventos_participantes_id_cliente'  => $participante_query->row['eventos_participantes_id_cliente'],
				'eventos_participantes_numero'      => $participante_query->row['eventos_participantes_numero'],
				'eventos_participantes_byscript'    => $participante_query->row['eventos_participantes_byscript'],				
				'eventos_participantes_inscripcion' => $participante_query->row['eventos_participantes_inscripcion'],
				'eventos_participantes_datos'       => $participante_query->row['eventos_participantes_datos'],
				'eventos_participantes_fdc'         => $participante_query->row['eventos_participantes_fdc'],
				'eventos_participantes_fdum'        => $participante_query->row['eventos_participantes_fdum'],
			);
		} else {
			return false;	
		}
	}	

	public function getDatosParticipante($participantes_id) {

		$participante_query = $this->db->query("SELECT s.order_id AS Solicitud, s.payment_method AS Pago, s.payment_number AS Deposito, ep.eventos_participantes_id_evento AS Evento, ep.eventos_participantes_numero AS Numero, ep.eventos_participantes_cedula AS Cedula, ep.eventos_participantes_apellidos AS Apellidos, ep.eventos_participantes_nombres AS Nombres, ep.eventos_participantes_genero AS Genero, ep.eventos_participantes_fdn AS Nacimiento, ep.eventos_participantes_email AS Email, ep.eventos_participantes_cel AS Celular, ep.eventos_participantes_id_pais AS Pais, ep.eventos_participantes_id_estado AS Estado, ep.eventos_participantes_tiempo AS Tiempo, ep.eventos_participantes_grupo AS Grupo, ep.eventos_participantes_edad AS Edad, ep.eventos_participantes_categoria AS Categoria, ep.eventos_participantes_datos FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN `" . DB_PREFIX . "solicitud` s ON (ep.eventos_participantes_id_pedido = s.order_id) LEFT JOIN `" . DB_PREFIX . "paises` pai ON (ep.eventos_participantes_id_pais = pai.paises_id) LEFT JOIN `" . DB_PREFIX . "estados` est ON (ep.eventos_participantes_id_estado = est.estados_id) WHERE ep.eventos_participantes_id = '" . (int)$participantes_id . "'");
//		$participante_query = $this->db->query("SELECT s.order_id AS Solicitud, s.payment_method AS Pago, s.payment_number AS Deposito, ep.eventos_participantes_numero AS Numero, ep.eventos_participantes_cedula AS Cedula, ep.eventos_participantes_apellidos AS Apellidos, ep.eventos_participantes_nombres AS Nombres, ep.eventos_participantes_genero AS Genero, ep.eventos_participantes_fdn AS Nacimiento, ep.eventos_participantes_email AS Email, ep.eventos_participantes_cel AS Celular, pai.paises_nombre AS Pais, est.estados_nombre AS Estado, ep.eventos_participantes_grupo AS Grupo, ep.eventos_participantes_edad AS Edad, ep.eventos_participantes_categoria AS Categoria, ep.eventos_participantes_datos FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN `" . DB_PREFIX . "solicitud` s ON (ep.eventos_participantes_id_pedido = s.order_id) LEFT JOIN `" . DB_PREFIX . "paises` pai ON (ep.eventos_participantes_id_pais = pai.paises_id) LEFT JOIN `" . DB_PREFIX . "estados` est ON (ep.eventos_participantes_id_estado = est.estados_id) WHERE ep.eventos_participantes_id = '" . (int)$participantes_id . "'");
			
		if ($participante_query->num_rows) {
			
			$participantes_data = array();
			
			$participantes_data = array(
				'Solicitud'		=> $participante_query->row['Solicitud'],
				'Pago'   		=> $participante_query->row['Pago'],
				'Deposito'   	=> $participante_query->row['Deposito'],
				'Evento'  		=> $participante_query->row['Evento'],
				'Numero'  		=> $participante_query->row['Numero'],
				'Cedula'      	=> $participante_query->row['Cedula'],
				'Apellidos'    	=> $participante_query->row['Apellidos'],				
				'Nombres' 		=> $participante_query->row['Nombres'],
				'Genero'       	=> $participante_query->row['Genero'],
				'Nacimiento'	=> $participante_query->row['Nacimiento'],
				'Email'        	=> $participante_query->row['Email'],
				'Celular'       => $participante_query->row['Celular'],
				'Pais'        	=> $participante_query->row['Pais'],
				'Estado'        => $participante_query->row['Estado'],
				'Tiempo'        => $participante_query->row['Tiempo'],
				'Grupo'        	=> $participante_query->row['Grupo'],
				'Edad'        	=> $participante_query->row['Edad'],
				'Categoria'     => $participante_query->row['Categoria'],
				'Datos'     	=> $participante_query->row['eventos_participantes_datos'],
			);

			$datos = $participante_query->row['eventos_participantes_datos'];
			
			$opciones_query = $this->db->query("SELECT so.name, so.value FROM `" . DB_PREFIX . "solicitud_opcion_" . (int)$participante_query->row['Evento'] . "` so WHERE order_product_id = '" . (int)$datos . "' AND so.name IN (SELECT od.opcion_nombre FROM `" . DB_PREFIX . "opcion_descripcion` od)");
			
			foreach($opciones_query->rows as $opciones => $opcion) {
				$participantes_data[$opcion['name']] = $opcion['value'];
			}
			
			return $participantes_data;

		} else {

			return false;	

		}

	}	

	public function getRespuestaTalla($datos) {

		$datos_query = $this->db->query("SELECT ovd.opcion_valor_decripcion_nombre AS value FROM " . DB_PREFIX . "solicitud_opcion_21 so LEFT JOIN " . DB_PREFIX . "eventos_opcion_valor eov ON (so.value = eov.eventos_opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (eov.opcion_valor_id = ovd.opcion_valor_id) WHERE so.order_product_id = '" . (int)$datos . "' AND so.name = 82");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaTipoInscripcion($datos, $eventos_id) {

		$datos_query = $this->db->query("SELECT ovd.opcion_valor_decripcion_nombre AS value FROM " . DB_PREFIX . "solicitud_opcion_" . $eventos_id . " so LEFT JOIN " . DB_PREFIX . "eventos_opcion_valor eov ON (so.product_option_value_id = eov.eventos_opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (eov.opcion_valor_id = ovd.opcion_valor_id) WHERE so.order_product_id = '" . (int)$datos . "' AND so.product_option_id = 90");

		if ($datos_query->num_rows) {

			return $datos_query->row['value'];

		} else {

			$datos_query = $this->db->query("SELECT ovd.opcion_valor_decripcion_nombre AS value FROM " . DB_PREFIX . "solicitud_opcion_" . $eventos_id . " so LEFT JOIN " . DB_PREFIX . "eventos_opcion_valor eov ON (so.value = eov.eventos_opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (eov.opcion_valor_id = ovd.opcion_valor_id) WHERE so.order_product_id = '" . (int)$datos . "' AND so.name = '90'");
	
			if ($datos_query->num_rows) {
				return $datos_query->row['value'];
			} else {
				return false;	
			}
		
		}

	}	

	public function getRespuestaTipoInscripcionMTB($datos, $eventos_id) {

		$datos_query = $this->db->query("SELECT ovd.opcion_valor_decripcion_nombre AS value FROM " . DB_PREFIX . "solicitud_opcion_" . $eventos_id . " so LEFT JOIN " . DB_PREFIX . "eventos_opcion_valor eov ON (so.product_option_value_id = eov.eventos_opcion_valor_id) LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (eov.opcion_valor_id = ovd.opcion_valor_id) WHERE so.order_product_id = '" . (int)$datos . "' AND so.product_option_id = 92");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaAcompañante($datos) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_114 WHERE order_product_id = '" . (int)$datos . "' AND name = 'Acompañante'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaTransporte($datos) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_114 WHERE order_product_id = '" . (int)$datos . "' AND name = 'Transporte'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaCiudad($datos) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_114 WHERE order_product_id = '" . (int)$datos . "' AND name = 'Ciudad'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaAcompañante74($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Acompañante'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaEmpleadoTipo($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Tipo'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaMaillot($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Maillot'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaMaterial($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Retirará material en'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaTipoInscripcion132($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Seleccione si usted es'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaFoto($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Número de corredor'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaNombreEquipo($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Nombre Equipo'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaTipo($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Seleccione si es'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaParticipantesEquipo($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Cantidad Participantes'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getRespuestaMiembroEquipo($datos, $id_evento) {

		$datos_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "solicitud_opcion_" . $id_evento . " WHERE order_product_id = '" . (int)$datos . "' AND name = 'Miembro'");

		if ($datos_query->num_rows) {
			return $datos_query->row['value'];
		} else {
			return false;	
		}

	}	

	public function getOpcionesParticipantesExport($datos, $eventos_id) {

		$opciones_query = $this->db->query("SELECT so.name, so.value FROM `" . DB_PREFIX . "solicitud_opcion_" . $eventos_id . "` so WHERE order_product_id = '" . (int)$datos . "'");

//		$opciones_query = $this->db->query("SELECT so.name, so.value FROM `" . DB_PREFIX . "solicitud_opcion` so WHERE order_product_id = '" . (int)$datos . "' AND so.name IN (SELECT od.opcion_nombre FROM `" . DB_PREFIX . "opcion_descripcion` od)");
		
		return $opciones_query->rows;

	}	

	public function getOpcionesParticipantesExportNEW($datos) {

		$opciones_query = $this->db->query("SELECT od.opcion_nombre AS name, ovd.opcion_valor_decripcion_nombre AS value FROM `" . DB_PREFIX . "solicitud_opcion` so LEFT JOIN `" . DB_PREFIX . "eventos_opcion_valor` eov ON (so.product_option_id = eov.eventos_opcion_id AND so.product_option_value_id = eov.eventos_opcion_valor_id) LEFT JOIN `" . DB_PREFIX . "opcion_descripcion` od ON (eov.opcion_id = od.opcion_id) LEFT JOIN `" . DB_PREFIX . "opcion_valor_descripcion` ovd ON (eov.opcion_valor_id = ovd.opcion_valor_id) WHERE so.order_product_id = '" . (int)$datos . "' AND so.product_option_id <> 0 AND product_option_value_id <> 0");
		
		return $opciones_query->rows;

	}	

	public function confirm($cliente, $solicitud, $evento, $numero, $order_product_id) {
			
			$confirmado = $this->isParticipanteConfirmado($cliente, $evento);

			if(!$confirmado) {
				
				// Update Historial a Procesando
				$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_historial SET order_id = '" . (int)$solicitud . "', order_status_id = 4, notify = '1', date_added = NOW()");
	
				// Update Numero
				$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_cliente = '" . $cliente . "' WHERE eventos_numeros_numero = '" . (int)$numero . "' AND eventos_numeros_id_evento = '" . (int)$evento . "'");
	
				// Update Participante
				$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_numero = '" . (int)$numero . "', eventos_participantes_fdum = NOW() WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");
	
				// Update Historial a Completada
				$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_historial SET order_id = '" . (int)$solicitud . "', order_status_id = 5, notify = '1', date_added = NOW()");
	
				$apellido_part = $this->getParticipanteApellido($solicitud, $order_product_id, $evento);
				$nombre_part = $this->getParticipanteNombre($solicitud, $order_product_id, $evento);
				$grupo_part = $this->getParticipanteGrupo($solicitud, $order_product_id, $evento);
				$categoria_part = $this->getParticipanteCategoria($solicitud, $order_product_id, $evento);
				$email_part = $this->getParticipanteEmail($solicitud, $order_product_id, $evento);
	
				$this->load->model('catalog/eventos');
				
				$evento_info = $this->model_catalog_eventos->getEventoDescripcion($evento);
				
				if ($evento_info) {
					$evento_fecha = $evento_info['eventos_fecha'];
					$evento_nombre = $evento_info['eventos_titulo'];
					$evento_material = $evento_info['eventos_descripcion_materiales'];
				} else {
					$evento_fecha = '';
					$evento_nombre = '';
					$evento_material = '';
				}
	
				$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "solicitud` o WHERE o.order_id = '" . (int)$solicitud . "'");
				
				$this->load->model('localidad/idioma');
				
				$idioma_info = $this->model_localidad_idioma->getIdioma($order_query->row['language_id']);
				
				if ($idioma_info) {
					$idioma_code = $idioma_info['code'];
					$idioma_filename = $idioma_info['filename'];
					$idioma_directory = $idioma_info['directory'];
				} else {
					$idioma_code = '';
					$idioma_filename = '';
					$idioma_directory = '';
				}
	
				$participante_info = array(
					'language_code'			=> $idioma_code,
					'language_filename'     => $idioma_filename,
					'language_directory'    => $idioma_directory,
					'store_name'            => $order_query->row['store_name'],
					'store_url'             => $order_query->row['store_url'],
					'date_added'            => $order_query->row['date_added'],
					'payment_method'        => $order_query->row['payment_method'],
				);
	
				if ($email_part != '') {

					// Send out order confirmation mail
					$idioma = new Idioma($participante_info['language_directory']);
					$idioma->load($participante_info['language_filename']);
					$idioma->load('mail/eventos_participantes');
					
					$nombre = $nombre_part . ' ' . $apellido_part;
		
					if ($evento == 86) {
						$subject = sprintf($idioma->get('text_new_subject'), 'Maratón CAF 2014', $nombre);
					} else {
						$subject = sprintf($idioma->get('text_new_subject'), $participante_info['store_name'], $nombre);
					}
				
					// HTML Mail
					$template = new Template();
					
					$template->data['title'] = sprintf($idioma->get('text_new_subject'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'), $nombre);

					if ($evento == 78) {
						$template->data['text_greeting'] = sprintf($idioma->get('text_new_greeting_caf'), html_entity_decode($nombre, ENT_QUOTES, 'UTF-8'));
					} else { 
						$template->data['text_greeting'] = sprintf($idioma->get('text_new_greeting'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'));
					}

					$template->data['text_link'] = $idioma->get('text_new_link');
					$template->data['text_customer_detail'] = $idioma->get('text_customer_detail');
					$template->data['text_order_detail'] = $idioma->get('text_new_order_detail');
					$template->data['text_customer_id'] = $idioma->get('text_customer_id');
					$template->data['text_order_id'] = $idioma->get('text_new_order_id');
					$template->data['text_date_added'] = $idioma->get('text_new_date_added');
					$template->data['text_payment_method'] = $idioma->get('text_new_payment_method');	
					$template->data['text_email'] = $idioma->get('text_new_email');
					$template->data['text_name'] = $idioma->get('text_new_name');
					$template->data['text_event'] = $idioma->get('text_new_event');
					if ($evento == 78) {
						$template->data['text_number'] = 'Número del Corredor';
					} else { 
						$template->data['text_number'] = $idioma->get('text_new_number');
					}
					$template->data['text_group'] = $idioma->get('text_new_group');
					$template->data['text_category'] = $idioma->get('text_new_category');
					$template->data['text_event_date'] = $idioma->get('text_new_event_date');
					$template->data['text_materials'] = $idioma->get('text_new_materials');
					$template->data['text_footer'] = $idioma->get('text_new_footer');
					
					$template->data['logo'] = 'cid:' . md5(basename($this->config->get('config_logo')));		
					$template->data['store_name'] = $participante_info['store_name'];
					$template->data['store_url'] = $participante_info['store_url'];
					$template->data['customer_id'] = $cliente;
					$template->data['link'] = $participante_info['store_url'] . 'index.php?route=sesion/solicitud/info&order_id=' . $solicitud;
					$template->data['name'] = $nombre;
					$template->data['event'] = $evento_nombre;
					if ($evento == 78) {
						$template->data['number'] = $this->getCorreoNumeroCAF($solicitud, $order_product_id, $evento);
					} else { 
						$template->data['number'] = $numero;
					}
					$template->data['group'] = $grupo_part;
					$template->data['category'] = $categoria_part;
					$template->data['event_date'] = date($idioma->get('date_format_short'), strtotime($evento_fecha));
					$template->data['materials'] = $evento_material;
					$template->data['order_id'] = $solicitud;
					$template->data['date_added'] = date($idioma->get('date_format_short'), strtotime($participante_info['date_added']));    	
					$template->data['payment_method'] = $participante_info['payment_method'];
					$template->data['email'] = $email_part;
					
					if ($evento == 86) {

/*
						$participantes_mercantil_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "participantes_mercantil WHERE cedula = '" . $cliente . "'");
				
						if ($participantes_mercantil_query->num_rows) {

							if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/eventos_participantes_mercantil.tpl')) {
								$html = $template->fetch($this->config->get('config_template') . '/template/mail/eventos_participantes_mercantil.tpl');
							} else {
								$html = $template->fetch('mail/eventos_participantes_mercantil.tpl');
							}

						} else {
*/
							
							if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/eventos_participantes_caf.tpl')) {
								$html = $template->fetch($this->config->get('config_template') . '/template/mail/eventos_participantes_caf.tpl');
							} else {
								$html = $template->fetch('mail/eventos_participantes_caf.tpl');
							}
//						}
						
					} else {

						if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/eventos_participantes.tpl')) {
							$html = $template->fetch($this->config->get('config_template') . '/template/mail/eventos_participantes.tpl');
						} else {
							$html = $template->fetch('mail/eventos_participantes.tpl');
						}
					
					}
					
					// Text Mail
					$text = sprintf($idioma->get('text_new_greeting'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
					$text.= 'Estimado '.htmlentities($nombre_part).' '.htmlentities($apellido_part).'' . "\n\n";
					$text.= 'Le contactamos para informarle que su inscripci&oacute;n al evento <strong>'.htmlentities($evento_nombre).'</strong> ha sido aprobada. A continuaci&oacute;n encontrar&aacute; los datos de su participaci&oacute;n:\n\n';
					$text.= '<b>N&uacute;mero de participaci&oacute;n:</b> '.$numero.'\n';
					$text.= $grupo_part ? '<b>Grupo:</b> '.$grupo_part.'\n' : '';
					$text.= '<b>Categor&iacute;a:</b> '.$categoria_part.'\n';
					$text.= '<b>Fecha del evento:</b> '.$evento_fecha.'\n';
					$text.= '<b>Entrega de materiales:</b> '.nl2br(htmlentities($evento_material)).'\n\n';
					$text.= '<b>ESTE COMPROBANTE DEBE SER PRESENTADO EL DIA DE LA ENTREGA DE MATERIALES</b>\n\n';
					$text.= 'Gracias,' . "\n";
					$text.= $this->config->get('config_name');
					
					$text.= $idioma->get('text_new_footer') . "\n\n";
				
					// MODIFICACION 3px
					/*
					function mail($asunto,$mensaje,$noHTML,$toDir,$toName,$fromDir,$fromName);
					$asunto = Asunto del Correo
					$mensaje = Contenido HTML del correo
					$noHTML = Contenido NO HTML del correo <--- usado en caso de que el cliente no soporte HTML
					$toDir = Dirección del Destinatario.
					$toName = Nombre del destinatario. 
					$fromDir = Dirección del Remitente
					$fromName = Nombre del Remitente
					*/
					
					$m3px = new M3PX;
					$mail = $m3px->mail($subject, $html, html_entity_decode($text, ENT_QUOTES, 'UTF-8'), $email_part, '', $this->config->get('config_email'), $participante_info['store_name']);

/*
					$mail = new Mail(); 
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->hostname = $this->config->get('config_smtp_host');
					$mail->username = $this->config->get('config_smtp_username');
					$mail->password = $this->config->get('config_smtp_password');
					$mail->port = $this->config->get('config_smtp_port');
					$mail->timeout = $this->config->get('config_smtp_timeout');			
					$mail->setTo($email_part);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($participante_info['store_name']);
					$mail->setSubject($subject);
					$mail->setHtml($html);
					$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
					$mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'), md5(basename($this->config->get('config_logo'))));
					$mail->send();
*/
					
				}
				
			}

	}
	
	public function updateXX($eventos_id, $participante_status_id, $comment = '', $notify = false) {
		$participante_info = $this->getParticipante($eventos_id);

		if ($participante_info && $participante_info['order_status_id']) {
			$this->db->query("UPDATE `" . DB_PREFIX . "eventos_participantes` SET order_status_id = '" . (int)$participante_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$eventos_id . "'");
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_historial SET order_id = '" . (int)$eventos_id . "', order_status_id = '" . (int)$participante_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	
			// Send out any gift voucher mails
			if ($this->config->get('config_complete_status_id') == $participante_status_id) {
				$this->load->model('checkout/voucher');
	
				$this->model_checkout_voucher->confirm($eventos_id);
			}	
	
			if ($notify) {
				$idioma = new Idioma($participante_info['language_directory']);
				$idioma->load($participante_info['language_filename']);
				$idioma->load('mail/eventos_participantes');
			
				$subject = sprintf($idioma->get('text_update_subject'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'), $eventos_id);
	
				$message  = $idioma->get('text_update_order') . ' ' . $eventos_id . "\n";
				$message .= $idioma->get('text_update_date_added') . ' ' . date($idioma->get('date_format_short'), strtotime($participante_info['date_added'])) . "\n\n";
				
				$participante_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_status WHERE order_status_id = '" . (int)$participante_status_id . "' AND language_id = '" . (int)$participante_info['language_id'] . "'");
				
				if ($participante_status_query->num_rows) {
					$message .= $idioma->get('text_update_order_status') . "\n\n";
					$message .= $participante_status_query->row['name'] . "\n\n";					
				}
				
				if ($participante_info['customer_id']) {
					$message .= $idioma->get('text_update_link') . "\n";
					$message .= $participante_info['store_url'] . 'index.php?route=sesion/order/info&order_id=' . $eventos_id . "\n\n";
				}
				
				if ($comment) { 
					$message .= $idioma->get('text_update_comment') . "\n\n";
					$message .= $comment . "\n\n";
				}
					
				$message .= $idioma->get('text_update_footer');

				// MODIFICACION 3px
				/*
				function mail($asunto,$mensaje,$noHTML,$toDir,$toName,$fromDir,$fromName);
				$asunto = Asunto del Correo
				$mensaje = Contenido HTML del correo
				$noHTML = Contenido NO HTML del correo <--- usado en caso de que el cliente no soporte HTML
				$toDir = Dirección del Destinatario.
				$toName = Nombre del destinatario. 
				$fromDir = Dirección del Remitente
				$fromName = Nombre del Remitente
				*/
				
				$m3px = new M3PX;
				$mail = $m3px->mail($subject, '', html_entity_decode($message, ENT_QUOTES, 'UTF-8'), $participante_info['email'], '', $this->config->get('config_email'), $participante_info['store_name']);

/*
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');				
				$mail->setTo($participante_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($participante_info['store_name']);
				$mail->setSubject($subject);
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
*/
			}
		}
	}

	public function update($cliente, $solicitud, $evento, $numero, $order_product_id) {
			
		// Update Numero
		$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_cliente = '" . $cliente . "' WHERE eventos_numeros_numero = '" . (int)$numero . "' AND eventos_numeros_id_evento = '" . (int)$evento . "'");

		// Update Participante
		$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_numero = '" . (int)$numero . "', eventos_participantes_fdum = NOW() WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");

		$apellido_part = $this->getApellidoParticipante($cliente, $evento);
		$nombre_part = $this->getNombreParticipante($cliente, $evento);
		$grupo_part = $this->getGrupoParticipante($cliente, $evento);
		$categoria_part = $this->getCategoriaParticipante($cliente, $evento);
		$email_part = $this->getEmailParticipante($cliente, $evento);

		$this->load->model('catalog/eventos');
		
		$evento_info = $this->model_catalog_eventos->getEventoDescripcion($evento);
		
		if ($evento_info) {
			$evento_fecha = $evento_info['eventos_fecha'];
			$evento_nombre = $evento_info['eventos_titulo'];
			$evento_material = $evento_info['eventos_descripcion_materiales'];
		} else {
			$evento_fecha = '';
			$evento_nombre = '';
			$evento_material = '';
		}

		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "solicitud` o WHERE o.order_id = '" . (int)$solicitud . "'");
		
		$this->load->model('localidad/idioma');
		
		$idioma_info = $this->model_localidad_idioma->getIdioma($order_query->row['language_id']);
		
		if ($idioma_info) {
			$idioma_code = $idioma_info['code'];
			$idioma_filename = $idioma_info['filename'];
			$idioma_directory = $idioma_info['directory'];
		} else {
			$idioma_code = '';
			$idioma_filename = '';
			$idioma_directory = '';
		}

		$participante_info = array(
			'language_code'			=> $idioma_code,
			'language_filename'     => $idioma_filename,
			'language_directory'    => $idioma_directory,
			'store_name'            => $order_query->row['store_name'],
			'store_url'             => $order_query->row['store_url'],
			'date_added'            => $order_query->row['date_added'],
			'payment_method'        => $order_query->row['payment_method'],
		);

		// Send out order confirmation mail
		$idioma = new Idioma($participante_info['language_directory']);
		$idioma->load($participante_info['language_filename']);
		$idioma->load('mail/eventos_participantes');
		
		$nombre = $nombre_part . ' ' . $apellido_part;

		$subject = sprintf($idioma->get('text_update_subject'), $participante_info['store_name'], $nombre);
	
		// HTML Mail
		$template = new Template();
		
		$template->data['title'] = sprintf($idioma->get('text_update_subject'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'), $nombre);
		
		if ($evento == 78) {
			$template->data['text_greeting'] = sprintf($idioma->get('text_update_greeting_caf'), html_entity_decode($nombre, ENT_QUOTES, 'UTF-8'));
		} else { 
			$template->data['text_greeting'] = sprintf($idioma->get('text_update_greeting'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'));
		}

		$template->data['text_link'] = $idioma->get('text_new_link');
		$template->data['text_customer_detail'] = $idioma->get('text_customer_detail');
		$template->data['text_order_detail'] = $idioma->get('text_new_order_detail');
		$template->data['text_customer_id'] = $idioma->get('text_customer_id');
		$template->data['text_order_id'] = $idioma->get('text_new_order_id');
		$template->data['text_date_added'] = $idioma->get('text_new_date_added');
		$template->data['text_payment_method'] = $idioma->get('text_new_payment_method');	
		$template->data['text_email'] = $idioma->get('text_new_email');
		$template->data['text_name'] = $idioma->get('text_new_name');
		$template->data['text_event'] = $idioma->get('text_new_event');
		if ($evento == 78) {
			$template->data['text_number'] = 'Número del Corredor';
		} else { 
			$template->data['text_number'] = $idioma->get('text_new_number');
		}
		$template->data['text_group'] = $idioma->get('text_new_group');
		$template->data['text_category'] = $idioma->get('text_new_category');
		$template->data['text_event_date'] = $idioma->get('text_new_event_date');
		$template->data['text_materials'] = $idioma->get('text_new_materials');
		$template->data['text_footer'] = $idioma->get('text_new_footer');
		
		$template->data['logo'] = 'cid:' . md5(basename($this->config->get('config_logo')));		
		$template->data['store_name'] = $participante_info['store_name'];
		$template->data['store_url'] = $participante_info['store_url'];
		$template->data['customer_id'] = $cliente;
		$template->data['link'] = $participante_info['store_url'] . 'index.php?route=sesion/solicitud/info&order_id=' . $solicitud;
		$template->data['name'] = $nombre;
		$template->data['event'] = $evento_nombre;
		if ($evento == 78) {
			$template->data['number'] = $this->getCorreoNumeroCAF($solicitud, $order_product_id, $evento);
		} else { 
			$template->data['number'] = $numero;
		}
		$template->data['group'] = $grupo_part;
		$template->data['category'] = $categoria_part;
		$template->data['event_date'] = date($idioma->get('date_format_short'), strtotime($evento_fecha));
		$template->data['materials'] = $evento_material;
		$template->data['order_id'] = $solicitud;
		$template->data['date_added'] = date($idioma->get('date_format_short'), strtotime($participante_info['date_added']));    	
		$template->data['payment_method'] = $participante_info['payment_method'];
		$template->data['email'] = $email_part;
								
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/eventos_participantes.tpl')) {
			$html = $template->fetch($this->config->get('config_template') . '/template/mail/eventos_participantes.tpl');
		} else {
			$html = $template->fetch('mail/eventos_participantes.tpl');
		}

		// Text Mail
		$text = sprintf($idioma->get('text_new_greeting'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
		$text.= 'Estimado '.htmlentities($nombre_part).' '.htmlentities($apellido_part).'' . "\n\n";
		$text.= 'Le contactamos para informarle que su inscripci&oacute;n al evento <strong>'.htmlentities($evento_nombre).'</strong> ha sido modificada. A continuaci&oacute;n encontrar&aacute; los datos de su participaci&oacute;n:\n\n';
		$text.= '<b>N&uacute;mero de participaci&oacute;n:</b> '.$numero.'\n';
		$text.= $grupo_part ? '<b>Grupo:</b> '.$grupo_part.'\n' : '';
		$text.= '<b>Categor&iacute;a:</b> '.$categoria_part.'\n';
		$text.= '<b>Fecha del evento:</b> '.$evento_fecha.'\n';
		$text.= '<b>Entrega de materiales:</b> '.nl2br(htmlentities($evento_material)).'\n\n';
		$text.= '<b>ESTE COMPROBANTE DEBE SER PRESENTADO EL DIA DE LA ENTREGA DE MATERIALES</b>\n\n';
		$text.= 'Gracias,' . "\n";
		$text.= $this->config->get('config_name');
		
		$text.= $idioma->get('text_new_footer') . "\n\n";
	
		// MODIFICACION 3px
		/*
		function mail($asunto,$mensaje,$noHTML,$toDir,$toName,$fromDir,$fromName);
		$asunto = Asunto del Correo
		$mensaje = Contenido HTML del correo
		$noHTML = Contenido NO HTML del correo <--- usado en caso de que el cliente no soporte HTML
		$toDir = Dirección del Destinatario.
		$toName = Nombre del destinatario. 
		$fromDir = Dirección del Remitente
		$fromName = Nombre del Remitente
		*/
		
		$m3px = new M3PX;
		$mail = $m3px->mail($subject, $html, html_entity_decode($text, ENT_QUOTES, 'UTF-8'), $email_part, '', $this->config->get('config_email'), $participante_info['store_name']);


/*
		$mail = new Mail(); 
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');			
		$mail->setTo($email_part);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($participante_info['store_name']);
		$mail->setSubject($subject);
		$mail->setHtml($html);
		$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
		$mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'), md5(basename($this->config->get('config_logo'))));
		$mail->send();
*/
				
	}
	
	public function isParticipante($clientes_id, $eventos_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_cliente = '" . $clientes_id . "' AND eventos_participantes_id_evento = '" . (int)$eventos_id . "'");
		
		if ($query->num_rows) {
			return true;
		} else {
			return false;
		}
		
	}

	public function isParticipanteConfirmado($clientes_id, $eventos_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_cliente = '" . $clientes_id . "' AND eventos_participantes_id_evento = '" . (int)$eventos_id . "' AND eventos_participantes_numero <> 0");
		
		if ($query->num_rows) {
			return true;
		} else {
			return false;
		}
		
	}

	public function getTotalParticipantesByEvento($eventos_id) {

		$query = $this->db->query("SELECT COUNT(eventos_participantes_numero) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "'");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesEdadByEvento($eventos_id, $edad = 0) {

		$query = $this->db->query("SELECT COUNT(eventos_participantes_numero) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_edad >= '" . (int)$edad. "'");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesConfirmadosByEvento($eventos_id) {

		$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_numero > 0");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesCorreosByEvento($eventos_id) {

		$query = $this->db->query("SELECT COUNT(DISTINCT eventos_participantes_email) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "'");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesNoConfirmadosByEvento($eventos_id) {

//		$query = $this->db->query("SELECT COUNT(DISTINCT eventos_participantes_id_cliente) as total FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_numero = 0");
//		$query = $this->db->query("SELECT COUNT(DISTINCT ep.eventos_participantes_id_cliente) as total FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN solicitud s ON (ep.eventos_participantes_id_pedido = s.order_id) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND ep.eventos_participantes_numero = 0 AND ep.eventos_participantes_inscripcion = 'Internet' AND ep.eventos_participantes_id_pedido IN (SELECT order_id FROM solicitud WHERE (order_status_id = 0 OR order_status_id = 1 OR order_status_id = 2) AND payment_number <> '')");
		
		$query = $this->db->query("SELECT COUNT(*) as total FROM `" . DB_PREFIX . "eventos_participantes` ep WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND ep.eventos_participantes_numero = 0");
		
		return $query->row['total'];
		
	}

	public function getTotalParticipantesCelularesByEvento($eventos_id) {

		$query = $this->db->query("SELECT COUNT(DISTINCT ep.eventos_participantes_cel) as total FROM `" . DB_PREFIX . "eventos_participantes` ep WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "'");
		
		return $query->row['total'];
		
	}

	public function getOpcionParticipanteConsulta($order_product_id) {
		
		$consulta = "SELECT name, value FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = " . (int)$order_product_id . "";

		return $consulta;

	}

	public function existeDatosParticipacion($order_product_id, $dato) {
		
		$datos_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = '" . (int)$order_product_id . "' AND name = '" . $dato . "'");

		if ($datos_query->num_rows) {
			return true;
		} else {
			return false;
		}
		
		
	}

	public function getOpcionParticipanteT($order_product_id, $eventos_id) {
		
		$datos_evento = $this->getDatosParticipacionByEvento($eventos_id);
		
		foreach ($datos_evento as $dato) {
			
//			for($i=0;$i<count($datos_evento);$i++)
			
			$dato_existe = $this->existeDatosParticipacion($order_product_id, $dato['name']);

			if(!$dato_existe) {

				$solicitud_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = '" . (int)$order_product_id . "'");
				
				$solicitud = $solicitud_query->row['order_id'];

				$this->db->query("INSERT INTO `" . DB_PREFIX . "solicitud_opcion` SET order_id = '" . (int)$solicitud . "', order_product_id = '" . (int)$order_product_id . "', name = '" .  $dato['name'] . "', value = ''");

			}

		}
		
		$datos_query = $this->db->query("SELECT name, value FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = '" . (int)$order_product_id . "'");

		return $datos_query->rows;

	}

	public function getOpcionesParticipante($order_product_id, $id_evento) {
		
/*
		$datos_evento = $this->getDatosParticipacionByEvento($eventos_id);
		
		foreach ($datos_evento as $dato) {
			
//			for($i=0;$i<count($datos_evento);$i++)
			
			$dato_existe = $this->existeDatosParticipacion($order_product_id, $dato['name']);

			if(!$dato_existe) {

				$solicitud_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = '" . (int)$order_product_id . "'");
				
				$solicitud = $solicitud_query->row['order_id'];

				$this->db->query("INSERT INTO `" . DB_PREFIX . "solicitud_opcion` SET order_id = '" . (int)$solicitud . "', order_product_id = '" . (int)$order_product_id . "', name = '" .  $dato['name'] . "', value = ''");

			}

		}
*/
/*
		$datos_query = $this->db->query("SELECT name, value FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = '" . (int)$order_product_id . "' ORDER BY name");

		return $datos_query->rows;
*/
		$datos_query = $this->db->query("SELECT name, value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$id_evento . " WHERE order_product_id = '" . (int)$order_product_id . "'");

		return $datos_query->rows;

	}

	public function getOpcionParticipante($order_product_id, $eventos_id) {
		
/*
		$datos_evento = $this->getDatosParticipacionByEvento($eventos_id);
		
		foreach ($datos_evento as $dato) {
			
//			for($i=0;$i<count($datos_evento);$i++)
			
			$dato_existe = $this->existeDatosParticipacion($order_product_id, $dato['name']);

			if(!$dato_existe) {

				$solicitud_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "solicitud_opcion WHERE order_product_id = '" . (int)$order_product_id . "'");
				
				$solicitud = $solicitud_query->row['order_id'];

				$this->db->query("INSERT INTO `" . DB_PREFIX . "solicitud_opcion` SET order_id = '" . (int)$solicitud . "', order_product_id = '" . (int)$order_product_id . "', name = '" .  $dato['name'] . "', value = ''");

			}

		}
*/
		$datos_query = $this->db->query("SELECT name, value FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$eventos_id . " WHERE order_product_id = '" . (int)$order_product_id . "'");

		return $datos_query->rows;

	}

	public function getParticipantesByEvento($eventos_id, $data = array()) {

		$sql = "SELECT ep.*, o.* FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN solicitud o ON (ep.eventos_participantes_id_pedido = o.order_id) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "'";

		if (isset($data['filter_eventos_participantes_id_pedido']) && !is_null($data['filter_eventos_participantes_id_pedido'])) {
			$sql .= " AND ep.eventos_participantes_id_pedido = '" . (int)$data['filter_eventos_participantes_id_pedido'] . "'";
		}

		if (isset($data['filter_payment_method']) && !is_null($data['filter_payment_method'])) {
			$sql .= " AND o.payment_method = '" . (int)$data['filter_payment_method'] . "'";
		}

		if (isset($data['filter_eventos_participantes_numero']) && !is_null($data['filter_eventos_participantes_numero'])) {
			$sql .= " AND ep.eventos_participantes_numero = '" . (int)$data['filter_eventos_participantes_numero'] . "'";
		}

		if (isset($data['filter_eventos_participantes_cedula']) && !is_null($data['filter_eventos_participantes_cedula'])) {
			$sql .= " AND ep.eventos_participantes_cedula LIKE '%" . $data['filter_eventos_participantes_cedula'] . "%'";
		}

		if (isset($data['filter_eventos_participantes_apellidos']) && !is_null($data['filter_eventos_participantes_apellidos'])) {
			$sql .= " AND ep.eventos_participantes_apellidos LIKE '%" . $this->db->escape($data['filter_eventos_participantes_apellidos']) . "%'";
		}

		if (isset($data['filter_eventos_participantes_nombres']) && !is_null($data['filter_eventos_participantes_nombres'])) {
			$sql .= " AND ep.eventos_participantes_nombres LIKE '%" . $this->db->escape($data['filter_eventos_participantes_nombres']) . "%'";
		}

		if (isset($data['filter_eventos_participantes_genero']) && !is_null($data['filter_eventos_participantes_genero'])) {
			$sql .= " AND ep.eventos_participantes_genero = '" . $this->db->escape($data['filter_eventos_participantes_genero']) . "'";
		}

		if (isset($data['filter_eventos_participantes_fdn']) && !is_null($data['filter_eventos_participantes_fdn'])) {
			$sql .= " AND DATE(ep.eventos_participantes_fdn) = DATE('" . $this->db->escape($data['filter_eventos_participantes_fdn']) . "')";
		}

		if (isset($data['filter_eventos_participantes_email']) && !is_null($data['filter_eventos_participantes_email'])) {
			$sql .= " AND ep.eventos_participantes_email LIKE '%" . $this->db->escape($data['filter_eventos_participantes_email']) . "%'";
		}

		if (isset($data['filter_eventos_participantes_cel']) && !is_null($data['filter_eventos_participantes_cel'])) {
			$sql .= " AND ep.eventos_participantes_cel LIKE '%" . $this->db->escape($data['filter_eventos_participantes_cel']) . "%'";
		}

		if (isset($data['filter_eventos_participantes_id_pais']) && !is_null($data['filter_eventos_participantes_id_pais'])) {
			$sql .= " AND ep.eventos_participantes_id_pais = '" . (int)$data['filter_eventos_participantes_id_pais'] . "'";
		}

		if (isset($data['filter_eventos_participantes_id_estado']) && !is_null($data['filter_eventos_participantes_id_estado'])) {
			$sql .= " AND ep.eventos_participantes_id_estado = '" . (int)$data['filter_eventos_participantes_id_estado'] . "'";
		}

		if (isset($data['filter_eventos_participantes_grupo']) && !is_null($data['filter_eventos_participantes_grupo'])) {
			$sql .= " AND ep.eventos_participantes_grupo LIKE '%" . $this->db->escape($data['filter_eventos_participantes_grupo']) . "%'";
		}

		if (isset($data['filter_eventos_participantes_edad']) && !is_null($data['filter_eventos_participantes_edad'])) {
			$sql .= " AND ep.eventos_participantes_edad = '" . (int)$data['filter_eventos_participantes_edad'] . "'";
		}

		if (isset($data['filter_eventos_participantes_categoria']) && !is_null($data['filter_eventos_participantes_categoria'])) {
			$sql .= " AND ep.eventos_participantes_categoria LIKE '%" . $this->db->escape($data['filter_eventos_participantes_categoria']) . "%'";
		}


		$sort_data = array(
			'ep.eventos_participantes_id_pedido',
			'o.payment_method',
			'ep.eventos_participantes_numero',
			'ep.eventos_participantes_cedula',
			'ep.eventos_participantes_apellidos',
			'ep.eventos_participantes_nombres',
			'ep.eventos_participantes_genero',
			'ep.eventos_participantes_fdn',
			'ep.eventos_participantes_email',
			'ep.eventos_participantes_cel',
			'ep.eventos_participantes_id_pais',
			'ep.eventos_participantes_id_estado',
			'ep.eventos_participantes_grupo',
			'ep.eventos_participantes_edad',
			'ep.eventos_participantes_categoria',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ep.eventos_participantes_numero";
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

	}

	public function getParticipantesEdadByEvento($eventos_id, $edad = 0) {

		$sql = "SELECT * FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND eventos_participantes_edad >= '" . (int)$edad . "'";

		$query = $this->db->query($sql);

		return $query->rows;

	}

	public function getParticipantesExport($eventos_id) {

		$sql = "SELECT s.order_id AS Solicitud, s.payment_method AS Pago, s.total AS Monto, ep.eventos_participantes_planilla AS Planilla, s.payment_number AS Deposito, s.payment_date AS Fecha, ep.eventos_participantes_numero AS Numero, ep.eventos_participantes_cedula AS Cedula, ep.eventos_participantes_id_empleado AS Empleado, ep.eventos_participantes_apellidos AS Apellidos, ep.eventos_participantes_nombres AS Nombres, ep.eventos_participantes_genero AS Genero, ep.eventos_participantes_fdn AS Nacimiento, ep.eventos_participantes_email AS Email, ep.eventos_participantes_cel AS Celular, pai.paises_nombre AS Pais, est.estados_nombre AS Estado, ep.eventos_participantes_grupo AS Grupo, ep.eventos_participantes_tiempo AS Tiempo, ep.eventos_participantes_edad AS Edad, ep.eventos_participantes_categoria AS Categoria, ep.eventos_participantes_datos FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN `" . DB_PREFIX . "solicitud` s ON (ep.eventos_participantes_id_pedido = s.order_id) LEFT JOIN `" . DB_PREFIX . "paises` pai ON (ep.eventos_participantes_id_pais = pai.paises_id) LEFT JOIN `" . DB_PREFIX . "estados` est ON (ep.eventos_participantes_id_estado = est.estados_id) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' ORDER BY eventos_participantes_numero";

		$participante_query = $this->db->query($sql);

		return $participante_query->rows;

/*
		if ($participante_query->num_rows) {
			
			$participantes_data = array();
			
			$participantes_data = array(
				'Solicitud'		=> $participante_query->row['Solicitud'],
				'Pago'   		=> $participante_query->row['Pago'],
				'Deposito'   	=> $participante_query->row['Deposito'],
				'Numero'  		=> $participante_query->row['Numero'],
				'Cedula'      	=> $participante_query->row['Cedula'],
				'Apellidos'    	=> $participante_query->row['Apellidos'],				
				'Nombres' 		=> $participante_query->row['Nombres'],
				'Genero'       	=> $participante_query->row['Genero'],
				'Nacimiento'	=> $participante_query->row['Nacimiento'],
				'Email'        	=> $participante_query->row['Email'],
				'Celular'       => $participante_query->row['Celular'],
				'Pais'        	=> $participante_query->row['Pais'],
				'Estado'        => $participante_query->row['Estado'],
				'Grupo'        	=> $participante_query->row['Grupo'],
				'Edad'        	=> $participante_query->row['Edad'],
				'Categoria'     => $participante_query->row['Categoria'],
			);

			$datos = $participante_query->row['eventos_participantes_datos'];
			
			$opciones_query = $this->db->query("SELECT so.name, so.value FROM `" . DB_PREFIX . "solicitud_opcion_". $eventos_id . "` so WHERE order_product_id = '" . (int)$datos . "' AND so.name IN (SELECT od.opcion_nombre FROM `" . DB_PREFIX . "opcion_descripcion` od)");
			
			foreach($opciones_query->rows as $opciones => $opcion) {
				$participantes_data[$opcion['name']] = $opcion['value'];
			}
			
			return $participantes_data;

		} else {

			return false;	

		}
*/

	}

	public function getParticipantesContactosExport($eventos_id) {

		$sql = "SELECT CONCAT(ep.eventos_participantes_nombres, ' ', ep.eventos_participantes_apellidos) AS Nombre, ep.eventos_participantes_genero AS Genero, ep.eventos_participantes_email AS Email, ep.eventos_participantes_cel AS Celular FROM `" . DB_PREFIX . "eventos_participantes` ep WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' AND (ep.eventos_participantes_email <> '' OR ep.eventos_participantes_cel <> '') ORDER BY eventos_participantes_id";

		$participante_query = $this->db->query($sql);

		return $participante_query->rows;

	}

	public function getTodosParticipantes() {

		$datos_participantes_query = $this->db->query("SELECT eventos_participantes_id, eventos_participantes_datos FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id > 2500 ORDER BY eventos_participantes_id");
		
		return $datos_participantes_query->rows;
		
	}

	public function getDatosParticipacionByEvento($eventos_id) {

//		$query = $this->db->query("SELECT DISTINCT so.name FROM `" . DB_PREFIX . "solicitud_opcion` so LEFT JOIN " . DB_PREFIX . "eventos_participantes ep ON (so.order_product_id = ep.eventos_participantes_datos) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "' ORDER BY so.name");
		$query = $this->db->query("SELECT DISTINCT so.name FROM `" . DB_PREFIX . "solicitud_opcion_" . (int)$eventos_id . "` so LEFT JOIN " . DB_PREFIX . "eventos_participantes ep ON (so.order_product_id = ep.eventos_participantes_datos) WHERE ep.eventos_participantes_id_evento  = '" . (int)$eventos_id . "'");
		
		return $query->rows;
		
	}

	public function getTotalEventosActivos($data = array()) {
//		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE eventos_status = 1";
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE 1 = 1";
		
		if (isset($data['filter_eventos_year']) && !is_null($data['filter_eventos_year'])) {
			$sql .= " AND YEAR(e.eventos_fecha) = '" . (int)$data['filter_eventos_year'] . "'";
		}

		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	

	public function getEventosActivos($data = array()) {
		if ($data) {
//			$sql = "SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) WHERE eventos_status = 1"; 
			$sql = "SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id = ed.eventos_descripcion_id_evento) WHERE 1 = 1"; 
		
			if (isset($data['filter_eventos_year']) && !is_null($data['filter_eventos_year'])) {
				$sql .= " AND YEAR(e.eventos_fecha) = '" . (int)$data['filter_eventos_year'] . "'";
			}

			$sort_data = array(
				'e.eventos_status',
				'e.eventos_fecha',
				'e.eventos_titulo',
//				'e.eventos_precio',
//				'e.eventos_restar_cupos',
//				'e.eventos_orden'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY e.eventos_titulo";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " DESC";
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
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos e LEFT JOIN " . DB_PREFIX . "eventos_descripcion ed ON (e.eventos_id  = ed.eventos_descripcion_id_evento) ORDER BY e.eventos_titulo ASC");
	
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
	
	public function updateCedulaParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_cedula = '" . $dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateApellidosParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_apellidos = '" . $this->db->escape($dato) . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateNombresParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_nombres = '" . $this->db->escape($dato) . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateGéneroParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_genero = '" . $dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateFdNParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_fdn = '" . $dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateEmailParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_email = '" . $this->db->escape($dato) . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateCelParticipante($id_participante, $dato) {
		
				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_cel = '" . $dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updatePaisParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_id_pais = '" . (int)$dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateEstadoParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_id_estado = '" . (int)$dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateEdadParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_edad = '" . (int)$dato . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateCategoriaParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_categoria = '" . $this->db->escape($dato) . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function updateGrupoParticipante($id_participante, $dato) {

				// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_grupo = '" . $this->db->escape($dato) . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function corregirEdad($id_participante, $edad) {

			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_edad = '" . (int)$edad . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function corregirEmail($id_participante, $email = '') {

			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_email = '" . $email . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function corregirFdn($id_participante, $fdn) {

			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_fdn = '" . $fdn . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function corregirCategoria($id_participante, $categoria) {

			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_categoria = '" . $categoria . "' WHERE eventos_participantes_id = '" . $id_participante . "'");

	}	

	public function getTotalCedulasNumerosByEvento($evento_id) {
		
/*
		if ($evento_id == 38) {
	
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "eventos_numeros` WHERE (eventos_numeros_id_evento = '" . (int)$evento_id . "' OR eventos_numeros_id_evento = 31) AND eventos_numeros_id_cliente <> '' AND eventos_numeros_id_cliente NOT IN (SELECT eventos_participantes_id_cliente FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' OR eventos_participantes_id_evento = 31) ORDER BY eventos_numeros_numero");
			
		} else {
*/

			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "eventos_numeros` WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente <> '' AND eventos_numeros_id_cliente NOT IN (SELECT eventos_participantes_id_cliente FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' ) ORDER BY eventos_numeros_numero");
			
//		}

		return $query->row['total'];
		
	}

	public function getCedulasNumerosByEvento($evento_id) {

/*
		if ($evento_id == 38) {

			$query = $this->db->query("SELECT eventos_numeros_id_cliente, eventos_numeros_numero FROM `" . DB_PREFIX . "eventos_numeros` WHERE (eventos_numeros_id_evento = '" . (int)$evento_id . "' OR eventos_numeros_id_evento = 31) AND eventos_numeros_id_cliente <> '' AND eventos_numeros_id_cliente NOT IN (SELECT eventos_participantes_id_cliente FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' OR eventos_participantes_id_evento = 31) ORDER BY eventos_numeros_numero");

		} else {
*/
			$query = $this->db->query("SELECT eventos_numeros_id_cliente, eventos_numeros_numero FROM `" . DB_PREFIX . "eventos_numeros` WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente <> '' AND eventos_numeros_id_cliente NOT IN (SELECT eventos_participantes_id_cliente FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' ) ORDER BY eventos_numeros_numero");

//		}
		
//		$query = $this->db->query("SELECT en.eventos_numeros_id_cliente, en.eventos_numeros_numero FROM `" . DB_PREFIX . "eventos_numeros` en WHERE en.eventos_numeros_id_evento = '" . (int)$evento_id . "' AND en.eventos_numeros_id_cliente <> '' AND eventos_numeros_id_cliente NOT IN (SELECT eventos_participantes_id_cliente FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' ) ORDER BY eventos_numeros_numero");
		
		return $query->rows;
		
	}

	public function agregaParticipante($evento_id, $cedula, $data = array()) {

		$participante = $this->isParticipante($cedula, $evento_id);

		if(!$participante) {

			$this->db->query("INSERT INTO `" . DB_PREFIX . "eventos_participantes` SET eventos_participantes_id_evento = '" . (int)$data['eventos_participantes_id_evento'] . "', eventos_participantes_id_pedido = '" . (int)$data['eventos_participantes_id_pedido'] . "', eventos_participantes_id_cliente = '" . $data['eventos_participantes_id_cliente'] . "', eventos_participantes_numero = '" . (int)$data['eventos_participantes_numero'] . "', eventos_participantes_cedula = '" . $data['eventos_participantes_cedula'] . "', eventos_participantes_apellidos = '" . $this->db->escape($data['eventos_participantes_apellidos']) . "', eventos_participantes_nombres = '" . $this->db->escape($data['eventos_participantes_nombres']) . "', eventos_participantes_genero = '" . $data['eventos_participantes_genero'] . "', eventos_participantes_fdn = '" . $data['eventos_participantes_fdn'] . "', eventos_participantes_email = '" . $this->db->escape($data['eventos_participantes_email']) . "', eventos_participantes_cel = '" . $data['eventos_participantes_cel'] . "', eventos_participantes_id_pais = '" . (int)$data['eventos_participantes_id_pais'] . "', eventos_participantes_id_estado = '" . (int)$data['eventos_participantes_id_estado'] . "', eventos_participantes_grupo = '" . $this->db->escape($data['eventos_participantes_grupo']) . "', eventos_participantes_edad = '" . (int)$data['eventos_participantes_edad'] . "', eventos_participantes_categoria = '" . $this->db->escape($data['eventos_participantes_categoria']) . "', eventos_participantes_byscript = '" . $this->db->escape($data['eventos_participantes_byscript']) . "', eventos_participantes_inscripcion = '" . $this->db->escape($data['eventos_participantes_inscripcion']) . "', eventos_participantes_datos = '" . (int)$data['eventos_participantes_datos'] . "', eventos_participantes_fdc = '" . $data['eventos_participantes_fdc']. "', eventos_participantes_fdum = NOW()");
			
		}

	}

	public function getTotalCedulasDuplicadasByEvento($evento_id) {

		$query = $this->db->query("SELECT eventos_numeros_id_cliente FROM `" . DB_PREFIX . "eventos_numeros` WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente <> '' GROUP BY eventos_numeros_id_cliente HAVING COUNT(*) > 1 ORDER BY eventos_numeros_id_cliente");

		return $query->num_rows;

	}

	public function getCedulasDuplicadasByEvento($evento_id) {

		$query = $this->db->query("SELECT eventos_numeros_id_cliente FROM `" . DB_PREFIX . "eventos_numeros` WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente <> '' GROUP BY eventos_numeros_id_cliente HAVING COUNT(*) > 1 ORDER BY eventos_numeros_id_cliente");
		
		return $query->rows;

	}

	public function getTotalSolicitudesTDCByEvento($evento_id) {

		$query = $this->db->query("SELECT `eventos_participantes_id_pedido` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = 0 AND eventos_participantes_id_pedido IN (SELECT order_id FROM `" . DB_PREFIX . "solicitud` WHERE payment_method LIKE '%Tar%')");
		
		return $query->num_rows;

	}

	public function getSolicitudesTDCByEvento($evento_id) {

		$query = $this->db->query("SELECT eventos_participantes_id, `eventos_participantes_id_pedido` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = 0 AND eventos_participantes_id_pedido IN (SELECT order_id FROM `" . DB_PREFIX . "solicitud` WHERE payment_method LIKE '%Tar%')");
		
		return $query->rows;

	}

	public function getTotalSolicitudesConfirmadasByEvento($evento_id) {

		$query = $this->db->query("SELECT `eventos_participantes_id_pedido` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero > 0");
		
		return $query->num_rows;

	}

	public function getSolicitudesConfirmadasByEvento($evento_id) {

		$query = $this->db->query("SELECT `eventos_participantes_id_pedido` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero > 0");
		
		return $query->rows;

	}

	public function getTotalParticipantesSinConfirmarByEvento($evento_id) {

		$query = $this->db->query("SELECT ep.* FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN `" . DB_PREFIX . "solicitud` s ON (ep.eventos_participantes_id_pedido = s.order_id) WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = 0 AND (s.order_status_id = 3 OR s.order_status_id = 11)");
		
		return $query->num_rows;

	}

	public function getParticipantesSinConfirmarByEvento($evento_id) {

//		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = 0");

		$query = $this->db->query("SELECT ep.* FROM `" . DB_PREFIX . "eventos_participantes` ep LEFT JOIN `" . DB_PREFIX . "solicitud` s ON (ep.eventos_participantes_id_pedido = s.order_id) WHERE ep.eventos_participantes_id_evento = '" . (int)$evento_id . "' AND ep.eventos_participantes_numero = 0 AND (s.order_status_id = 3 OR s.order_status_id = 11) ORDER BY eventos_participantes_email DESC");
		
		return $query->rows;

	}

	public function getDatosSCByEvento($evento_id, $solicitud) {

		$query = $this->db->query("SELECT `eventos_participantes_cedula`, `eventos_participantes_categoria`, `eventos_participantes_grupo`, `eventos_participantes_datos` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_id_pedido = '" . (int)$solicitud . "' AND eventos_participantes_numero = 0");
		
		return $query->rows;

	}

	public function getTotalNumerosDuplicadosByEvento($evento_id) {

		$query = $this->db->query("SELECT eventos_participantes_numero FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero <> 0 GROUP BY eventos_participantes_numero HAVING COUNT(*) > 1 ORDER BY eventos_participantes_numero");

		return $query->num_rows;

	}

	public function getNumerosDuplicadosByEvento($evento_id) {

		$query = $this->db->query("SELECT eventos_participantes_numero FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero <> 0 GROUP BY eventos_participantes_numero HAVING COUNT(*) > 1 ORDER BY eventos_participantes_numero");

		return $query->rows;

	}

	public function getTotalTranscritosByEvento($evento_id) {

		$query = $this->db->query("SELECT `eventos_participantes_id` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = 0 AND eventos_participantes_id_pedido IN (SELECT order_id FROM `" . DB_PREFIX . "solicitud` WHERE payment_method = '')");
		
		return $query->num_rows;

	}

	public function getTranscritosByEvento($evento_id) {

		$query = $this->db->query("SELECT `eventos_participantes_id`, `eventos_participantes_id_pedido`, `eventos_participantes_cedula`, `eventos_participantes_categoria`, `eventos_participantes_datos` FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = 0 AND eventos_participantes_id_pedido IN (SELECT order_id FROM `" . DB_PREFIX . "solicitud` WHERE payment_method = '')");
		
		if ($query->num_rows) {
			return array(
				'eventos_participantes_id' => $query->row['eventos_participantes_id'],
				'eventos_participantes_id_pedido' => $query->row['eventos_participantes_id_pedido'],
				'eventos_participantes_cedula' => $query->row['eventos_participantes_cedula'],
				'eventos_participantes_categoria' => $query->row['eventos_participantes_categoria'],
				'eventos_participantes_datos' => $query->row['eventos_participantes_datos'],
			);
		} else {
			return false;
		}
//		return $query->rows;

	}

	public function getCedulaBySolicitud($solicitud) {

		$query = $this->db->query("SELECT customer_id FROM `" . DB_PREFIX . "solicitud` WHERE `order_id` = '" . (int)$solicitud . "'");
		
		return $query->row['customer_id'];

	}

	public function getSolicitudOpcionByTDC($evento_id, $cedula) {

		$query = $this->db->query("SELECT DISTINCT s.order_id AS solicitud, so.order_product_id AS datos FROM `" . DB_PREFIX . "solicitud` s LEFT JOIN `" . DB_PREFIX . "solicitud_evento` se ON (s.order_id = se.order_id) LEFT JOIN `" . DB_PREFIX . "solicitud_opcion_" . (int)$evento_id . "` so ON (s.order_id = so.order_id) WHERE s.customer_id = '" . $cedula . "' AND s.payment_method LIKE '%Tar%' AND s.payment_number <> '' AND se.product_id = '" . (int)$evento_id . "' ORDER BY s.order_id LIMIT 1");
		
		if ($query->num_rows) {
			return array(
				'solicitud' => $query->row['solicitud'],
				'datos' => $query->row['datos'],
			);
		} else {
			return false;
		}

	}

	public function corrigeParticipantes($solicitud, $evento_id, $datos, $participante_id) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos_participantes` SET eventos_participantes_id_pedido = '" . (int)$solicitud . "', eventos_participantes_datos = '" . (int)$datos . "' WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_id = '" . (int)$participante_id . "'");
		
	}

	public function corregirNumeroParticipanteND($evento_id, $cedula, $numero) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos_numeros` SET eventos_numeros_id_cliente = '" . $cedula . "' WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_numero = '" . (int)$numero . "'");

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos_participantes` SET eventos_participantes_numero = '" . (int)$numero . "' WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_cedula = '" . $cedula . "'");
		
	}

	public function reconfirmarSolicitud($solicitud) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "solicitud` SET order_status_id = 0 WHERE order_id = '" . (int)$solicitud . "'");
		
	}

	public function getNumerosByCedula($cedula, $evento_id) {

		$query = $this->db->query("SELECT eventos_participantes_numero FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_id_cliente = '" . $cedula . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_numero'];
		} else {
			return false;
		}

	}

	public function getNumeroByParticipante($participante_id) {

		$query = $this->db->query("SELECT eventos_participantes_numero FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id = '" . (int)$participante_id . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_numero'];
		} else {
			return false;
		}

	}

	public function getCedulaByNumero($numero, $evento_id) {

		$query = $this->db->query("SELECT eventos_participantes_cedula FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_numero = '" . $numero . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_cedula'];
		} else {
			return false;
		}

	}

	public function getDatosParticipanteND($cedula, $evento_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id_evento = '" . (int)$evento_id . "' AND eventos_participantes_cedula = '" . $cedula . "'");
		
		return $query->rows;

	}

	public function getInscripcionByParticipante($participante_id) {

		$query = $this->db->query("SELECT eventos_participantes_inscripcion FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id = '" . (int)$participante_id . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_inscripcion'];
		} else {
			return false;
		}

	}

	public function getEventoByParticipante($participante_id) {

		$query = $this->db->query("SELECT eventos_participantes_id_evento FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id = '" . (int)$participante_id . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_id_evento'];
		} else {
			return false;
		}

	}

	public function getSolicitudByParticipante($participante_id) {

		$query = $this->db->query("SELECT eventos_participantes_id_pedido FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id = '" . (int)$participante_id . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_id_pedido'];
		} else {
			return false;
		}

	}

	public function getSolicitudOpcionByParticipante($participante_id) {

		$query = $this->db->query("SELECT eventos_participantes_datos FROM `" . DB_PREFIX . "eventos_participantes` WHERE eventos_participantes_id = '" . (int)$participante_id . "'");
		
		if ($query->num_rows) {
			return $query->row['eventos_participantes_datos'];
		} else {
			return false;
		}

	}

	public function liberarNumeros($cedula, $evento_id, $numero) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos_numeros` SET eventos_numeros_id_cliente = '' WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente = '" . $cedula . "' AND eventos_numeros_numero <> '" . (int)$numero . "'");
		
	}

	public function liberarNumero($cedula, $evento_id, $numero) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos_numeros` SET eventos_numeros_id_cliente = '' WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_id_cliente = '" . $cedula . "' AND eventos_numeros_numero = '" . (int)$numero . "'");
		
	}

	public function liberaNumero($numero, $evento_id) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos_numeros` SET eventos_numeros_id_cliente = '' WHERE eventos_numeros_id_evento = '" . (int)$evento_id . "' AND eventos_numeros_numero = '" . (int)$numero . "'");
		
	}

	public function devolverCupo($evento_id) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "eventos` SET eventos_cupos_internet = (eventos_cupos_internet + 1) WHERE eventos_id = '" . (int)$evento_id . "'");
		
	}

	public function confirmaTranscritos($cliente, $solicitud, $evento, $numero, $order_product_id) {
			
			// Update Numero
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_numeros SET eventos_numeros_id_cliente = '" . $cliente . "' WHERE eventos_numeros_numero = '" . (int)$numero . "' AND eventos_numeros_id_evento = '" . (int)$evento . "'");

			// Update Participante
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_participantes SET eventos_participantes_numero = '" . (int)$numero . "', eventos_participantes_byscript = 'Backdoor', eventos_participantes_fdum = NOW() WHERE eventos_participantes_id_cliente = '" . $cliente . "' AND eventos_participantes_id_evento = '" . (int)$evento . "'");

	}
	
}
?>
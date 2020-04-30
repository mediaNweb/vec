<?php
class ModelCorreosCorreos extends Model {	

	public function getTotalCorreos() {

		$datos_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "listado_correos");

		return $datos_query->row['total'];

	}

	public function getCorreos() {

		$datos_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "listado_correos");

		return $datos_query->rows;

	}

	public function getTotalCorreosParticipantes($eventos_id) {

		$datos_query = $this->db->query("SELECT COUNT(eventos_participantes_email) AS total FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "'");

		return $datos_query->row['total'];

	}

	public function getCorreosParticipantes($eventos_id) {

		$datos_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_participantes WHERE eventos_participantes_id_evento  = '" . (int)$eventos_id . "'");

		return $datos_query->rows;

	}

	public function getCorreosPersonas() {

		$datos_query = $this->db->query("SELECT CONCAT(UPPER(pe.nombre), ' ', UPPER(pe.apellido)) AS nombre, UPPER(pe.mail) as mail FROM " . DB_PREFIX . "personas pe WHERE pe.mail <> '' GROUP BY pe.cedula");

		return $datos_query->rows;

	}

	public function getCorreosClientes() {

		$datos_query = $this->db->query("SELECT CONCAT(UPPER(c.clientes_nombre), ' ', UPPER(c.clientes_apellido)) AS nombre, UPPER(c.clientes_email) as mail FROM " . DB_PREFIX . "clientes c WHERE c.clientes_email <> '' GROUP BY c.clientes_id");

		return $datos_query->rows;

	}

	public function getCorreosParticipantesX() {

		$datos_query = $this->db->query("SELECT CONCAT(UPPER(ep.eventos_participantes_nombres), ' ', UPPER(ep.eventos_participantes_apellidos)) AS nombre, UPPER(ep.eventos_participantes_email) as mail FROM " . DB_PREFIX . "eventos_participantes ep WHERE ep.eventos_participantes_email <> '' GROUP BY ep.eventos_participantes_id_cliente");

		return $datos_query->rows;

	}

	public function ExisteCorreo($email) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "listado_correos` WHERE correo = '" . $this->db->escape($email) . "'");
		
		if ($query->num_rows) {
			return true;
		} else {
			return false;
		}
		
	}

	public function AgregaCorreos($nombre, $email) {

		$this->db->query("INSERT INTO `" . DB_PREFIX . "listado_correos` SET nombre = '" . $this->db->escape($nombre) . "', correo = '" . $this->db->escape($email) . "'");

	}

	public function errorCorreos($id) {

		$datos_query = $this->db->query("UPDATE " . DB_PREFIX . "listado_correos SET error = 1 WHERE id = '" . (int)$id . "'");

	}

}
?>
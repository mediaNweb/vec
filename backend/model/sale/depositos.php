<?php
class ModelSaleDepositos extends Model {
	public function importarDepositos($contenido) {

		/* Enabling Mac compatibility when reading files */
		ini_set('auto_detect_line_endings', true);

		$handle = fopen($contenido, 'r');
		while(($data_csv = fgetcsv($handle, 1000, ';')) !== FALSE){
			/* Var cleaning */
			$data_csv[0] = trim(chop(mysql_real_escape_string($data_csv[0])));
			$data_csv[1] = trim(chop(mysql_real_escape_string($data_csv[1])));
			$data_csv[2] = trim(chop(mysql_real_escape_string($data_csv[2])));

			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_deposito SET solicitud_deposito_referencia = '" . $data_csv[0] . "', solicitud_deposito_descripcion = '" . $data_csv[1] . "', solicitud_deposito_monto = '" . $data_csv[2] . "'");

		}

		fclose($handle);
		
	}
	
	public function getDeposito($subcadena, $monto) {
		
//		$descripcion_query = $this->db->query("SELECT solicitud_deposito_id, solicitud_deposito_monto FROM " . DB_PREFIX . "solicitud_deposito WHERE INSTR(solicitud_deposito_descripcion, '" . $subcadena . "') > 0 OR INSTR(solicitud_deposito_referencia, '" . $subcadena . "') > 0 LIMIT 1");
		$descripcion_query = $this->db->query("SELECT solicitud_deposito_id, solicitud_deposito_monto FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_descripcion LIKE '%" . $subcadena . "%' OR solicitud_deposito_referencia LIKE '%" . $subcadena . "%' ORDER BY solicitud_deposito_id LIMIT 1");
		
		if ($descripcion_query->num_rows) {
			
			$monto_deposito = $descripcion_query->row['solicitud_deposito_monto'];
	
			if (fmod($monto_deposito, $monto) == 0) {
				
				return $descripcion_query->row['solicitud_deposito_id'];

			}

		}

	}

	public function getMontoBySolicitud($solicitud) {

		$descripcion_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "solicitud_evento WHERE order_id = '" . (int)$solicitud . "'");
		
		return $descripcion_query->rows;

	}

	public function updateDepositoMOD($deposito_id, $monto) {

		$depositos_query = $this->db->query("SELECT solicitud_deposito_monto FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_id = '" . (int)$deposito_id . "'");
		
		return $depositos_query->row['solicitud_deposito_monto'];
		
	}

	public function updateDeposito($deposito_id, $monto) {

		$depositos_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		
		$monto_deposito = $depositos_query->row['solicitud_deposito_monto'];
		$monto_actualizado = $monto_deposito - $monto;

		if ($monto_actualizado == 0) {
			$this->db->query("UPDATE " . DB_PREFIX . "solicitud_deposito SET solicitud_deposito_monto = '" . $monto_actualizado . "', solicitud_deposito_confirmado = 1 WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "solicitud_deposito SET solicitud_deposito_monto = '" . $monto_actualizado . "' WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		}
		
	}

	public function processDeposito($deposito_id) {

		$this->db->query("UPDATE " . DB_PREFIX . "solicitud_deposito SET solicitud_deposito_procesado = 1 WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		
/*
		$depositos_query = $this->db->query("SELECT solicitud_deposito_monto FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		
		$monto_deposito = $depositos_query->row['solicitud_deposito_monto'];
		$monto_actualizado = $monto_deposito - $monto;

		if ($monto_actualizado == 0) {
			$this->db->query("UPDATE " . DB_PREFIX . "solicitud_deposito SET solicitud_deposito_monto = '" . $monto_actualizado . "', solicitud_deposito_confirmado = 1 WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "solicitud_deposito SET solicitud_deposito_monto = '" . $monto_actualizado . "' WHERE solicitud_deposito_id = '" . $deposito_id . "'");
		}
*/

	}

	public function getDepositosTotal() {

		$depositos_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "solicitud_deposito");
		
		return $depositos_query->row['total'];
		
	}

	public function getDepositos() {

		$depositos_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_deposito");
		
		return $depositos_query->rows;
		
	}

	public function getDepositosProcesados() {

		$depositos_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_procesado = 1");
		
		return $depositos_query->row['total'];
		
	}

	public function getDepositosConfirmados() {

		$depositos_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_confirmado = 1");
		
		return $depositos_query->row['total'];
		
	}

	public function getDepositosDepurados() {

		$this->db->query("DELETE FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_monto <= 0 AND solicitud_deposito_confirmado = 1");
//		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "solicitud_deposito");
//		$depositos_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "solicitud_deposito WHERE solicitud_deposito_monto <= 0");
		
		return $this->db->countAffected();
		
	}

}
?>
<?php
class ModelCatalogNumeracion extends Model {
	public function addNumeracion($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "numeracion_tipos SET numeracion_tipos_titulo = '" . $this->db->escape($value['numeracion_tipos_titulo']) . "', numeracion_tipos_fdum = NOW(), numeracion_tipos_fdc = NOW()");
	}
	
	public function editNumeracion($numeracion_tipos_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "numeracion_tipos SET numeracion_tipos_titulo = '" . $this->db->escape($value['numeracion_tipos_titulo']) . "', numeracion_tipos_fdum = NOW() WHERE numeracion_tipos_id = '" . (int)$numeracion_tipos_id . "'");
	}
	
	public function deleteNumeracion($numeracion_tipos_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "numeracion_tipos WHERE numeracion_tipos_id = '" . (int)$numeracion_tipos_id . "'");
	} 

	public function getNumeracion($numeracion_tipos_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "numeracion_tipos WHERE numeracion_tipos_id = '" . (int)$numeracion_tipos_id . "'");
		
		return $query->row;
	} 

	public function getNumeraciones() {
			$tipos_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "numeracion_tipos nt ORDER BY nt.numeracion_tipos_id ASC");
		
			foreach ($query->rows as $result) {
				$tipos_data[] = array(
					'numeracion_tipos_id' 		=> $result['numeracion_tipos_id'],
					'numeracion_tipos_titulo'  => $result['numeracion_tipos_titulo']
				);
			}	
		return $tipos_data;
	}
	
	public function getTotalNumeraciones() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "numeracion_tipos");
		
		return $query->row['total'];
	}	
}
?>
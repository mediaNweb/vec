<?php
class ModelCatalogTipos extends Model {
	public function addTipo($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_tipos SET eventos_tipos_nombre = '" . $this->db->escape($value['name']) . "', eventos_tipos_orden = '" . (int)$data['sort_order'] . "', eventos_tipos_fdum = NOW(), eventos_tipos_fdc = NOW()");
	
		$eventos_tipos_id = $this->db->getLastId();
		
		if (isset($data['eventos_tipos_imagen'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_tipos SET eventos_tipos_imagen = '" . $this->db->escape($data['eventos_tipos_imagen']) . "' WHERE eventos_tipos_id = '" . (int)$eventos_tipos_id . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'eventos_tipos_id=" . (int)$eventos_tipos_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('tipos');
	}
	
	public function editTipo($eventos_tipos_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "eventos_tipos SET eventos_tipos_nombre = '" . $this->db->escape($data['eventos_tipos_nombre']) . "', eventos_tipos_orden = '" . (int)$data['eventos_tipos_orden'] . "', eventos_tipos_fdum = NOW() WHERE eventos_tipos_id = '" . (int)$eventos_tipos_id . "'");

		if (isset($data['eventos_tipos_imagen'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_tipos SET eventos_tipos_imagen = '" . $this->db->escape($data['eventos_tipos_imagen']) . "' WHERE eventos_tipos_id = '" . (int)$eventos_tipos_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_tipos_id=" . (int)$eventos_tipos_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'eventos_tipos_id=" . (int)$eventos_tipos_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('tipos');
	}
	
	public function deleteTipo($eventos_tipos_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_tipos WHERE eventos_tipos_id = '" . (int)$eventos_tipos_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_tipos_id=" . (int)$eventos_tipos_id . "'");
		
		$this->cache->delete('tipos');
	} 

	public function getTipo($eventos_tipos_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'eventos_tipos_id=" . (int)$eventos_tipos_id . "') AS keyword FROM " . DB_PREFIX . "eventos_tipos WHERE eventos_tipos_id = '" . (int)$eventos_tipos_id . "'");
		
		return $query->row;
	} 

	public function getTipos() {
			$tipos_data = array();
		
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_tipos et ORDER BY et.eventos_tipos_orden, et.eventos_tipos_nombre ASC");
		
			foreach ($query->rows as $result) {
				$tipos_data[] = array(
					'eventos_tipos_id' 		=> $result['eventos_tipos_id'],
					'eventos_tipos_nombre'  => $result['eventos_tipos_nombre'],
					'eventos_tipos_imagen'  => $result['eventos_tipos_imagen'],
					'eventos_tipos_orden'  	=> $result['eventos_tipos_orden']
				);
			}	
		return $tipos_data;
	}
	
	public function getTotalTipos() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_tipos");
		
		return $query->row['total'];
	}	
}
?>
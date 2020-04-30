<?php
class ModelCatalogPatrocinante extends Model {
	public function addPatrocinante($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "patrocinantes SET patrocinantes_titulo = '" . $this->db->escape($data['patrocinantes_titulo']) . "', patrocinantes_url = '" . $this->db->escape($data['patrocinantes_url']) . "', patrocinantes_fdum = NOW(), patrocinantes_fdc = NOW()");

		$patrocinantes_id = $this->db->getLastId();

		if (isset($data['patrocinantes_imagen'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "patrocinantes SET patrocinantes_imagen = '" . $this->db->escape($data['patrocinantes_imagen']) . "' WHERE patrocinantes_id = '" . (int)$patrocinantes_id . "'");
		}
		
		$this->cache->delete('patrocinantes');
		
	}
	
	public function editPatrocinante($patrocinantes_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "patrocinantes SET patrocinantes_titulo = '" . $this->db->escape($data['patrocinantes_titulo']) . "', patrocinantes_imagen = '" . $this->db->escape($data['patrocinantes_imagen']) . "', patrocinantes_url = '" . $this->db->escape($data['patrocinantes_url']) . "', patrocinantes_fdum = NOW() WHERE patrocinantes_id = '" . (int)$patrocinantes_id . "'");
	}
	
	public function deletePatrocinante($patrocinantes_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "patrocinantes WHERE patrocinantes_id = '" . (int)$patrocinantes_id . "'");
	} 

	public function getPatrocinante($patrocinantes_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "patrocinantes WHERE patrocinantes_id = '" . (int)$patrocinantes_id . "'");
		
		return $query->row;
	} 

	public function getPatrocinantes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "patrocinantes";
			
			$sort_data = array(
				'patrocinantes_titulo'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY patrocinantes_titulo";	
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
			$patrocinante_data = $this->cache->get('patrocinantes');
		
			if (!$patrocinante_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "patrocinantes ORDER BY patrocinantes_titulo");
	
				$patrocinante_data = $query->rows;
			
				$this->cache->set('patrocinantes', $patrocinante_data);
			}
		 
			return $patrocinante_data;
		}
	}

	public function getTotalPatrocinantes() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "patrocinantes");
		
		return $query->row['total'];
	}	
}
?>
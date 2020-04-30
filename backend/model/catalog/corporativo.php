<?php
class ModelCatalogCorporativo extends Model {
	public function addCorporativo($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "corporativos SET corporativos_titulo = '" . $this->db->escape($data['corporativos_titulo']) . "', corporativos_url = '" . $this->db->escape($data['corporativos_url']) . "', corporativos_fdum = NOW(), corporativos_fdc = NOW()");

		$corporativos_id = $this->db->getLastId();

		if (isset($data['corporativos_imagen'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "corporativos SET corporativos_imagen = '" . $this->db->escape($data['corporativos_imagen']) . "' WHERE corporativos_id = '" . (int)$corporativos_id . "'");
		}
		
		$this->cache->delete('corporativos');
		
	}
	
	public function editCorporativo($corporativos_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "corporativos SET corporativos_titulo = '" . $this->db->escape($data['corporativos_titulo']) . "', corporativos_imagen = '" . $this->db->escape($data['corporativos_imagen']) . "', corporativos_url = '" . $this->db->escape($data['corporativos_url']) . "', corporativos_fdum = NOW() WHERE corporativos_id = '" . (int)$corporativos_id . "'");
	}
	
	public function deleteCorporativo($corporativos_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "corporativos WHERE corporativos_id = '" . (int)$corporativos_id . "'");
	} 

	public function getCorporativo($corporativos_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "corporativos WHERE corporativos_id = '" . (int)$corporativos_id . "'");
		
		return $query->row;
	} 

	public function getCorporativos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "corporativos";
			
			$sort_data = array(
				'corporativos_titulo'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY corporativos_titulo";	
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
			$corporativo_data = $this->cache->get('corporativos');
		
			if (!$corporativo_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "corporativos ORDER BY corporativos_titulo");
	
				$corporativo_data = $query->rows;
			
				$this->cache->set('corporativos', $corporativo_data);
			}
		 
			return $corporativo_data;
		}
	}

	public function getTotalCorporativos() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "corporativos");
		
		return $query->row['total'];
	}	
}
?>
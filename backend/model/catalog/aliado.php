<?php
class ModelCatalogAliado extends Model {
	public function addAliado($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliados SET aliados_titulo = '" . $this->db->escape($data['aliados_titulo']) . "', aliados_url = '" . $this->db->escape($data['aliados_url']) . "', aliados_fdum = NOW(), aliados_fdc = NOW()");

		$aliados_id = $this->db->getLastId();

		if (isset($data['aliados_imagen'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "aliados SET aliados_imagen = '" . $this->db->escape($data['aliados_imagen']) . "' WHERE aliados_id = '" . (int)$aliados_id . "'");
		}
		
		$this->cache->delete('aliados');
		
	}
	
	public function editAliado($aliados_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "aliados SET aliados_titulo = '" . $this->db->escape($data['aliados_titulo']) . "', aliados_imagen = '" . $this->db->escape($data['aliados_imagen']) . "', aliados_url = '" . $this->db->escape($data['aliados_url']) . "', aliados_fdum = NOW() WHERE aliados_id = '" . (int)$aliados_id . "'");
	}
	
	public function deleteAliado($aliados_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "aliados WHERE aliados_id = '" . (int)$aliados_id . "'");
	} 

	public function getAliado($aliados_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aliados WHERE aliados_id = '" . (int)$aliados_id . "'");
		
		return $query->row;
	} 

	public function getAliados($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "aliados";
			
			$sort_data = array(
				'aliados_titulo'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY aliados_titulo";	
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
			$aliado_data = $this->cache->get('aliados');
		
			if (!$aliado_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aliados ORDER BY aliados_titulo");
	
				$aliado_data = $query->rows;
			
				$this->cache->set('aliados', $aliado_data);
			}
		 
			return $aliado_data;
		}
	}

	public function getTotalAliados() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "aliados");
		
		return $query->row['total'];
	}	
}
?>
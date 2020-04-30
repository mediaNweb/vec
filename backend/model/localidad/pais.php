<?php
class ModelLocalidadPais extends Model {
	public function addPais($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "paises SET paises_nombre = '" . $this->db->escape($data['paises_nombre']) . "', paises_iso_code_2 = '" . $this->db->escape($data['paises_iso_code_2']) . "', paises_iso_code_3 = '" . $this->db->escape($data['paises_iso_code_3']) . "', paises_formato_direccion = '" . $this->db->escape($data['paises_formato_direccion']) . "', postcode_required = '" . (int)$data['postcode_required'] . "', paises_status = '" . (int)$data['paises_status'] . "'");
	
		$this->cache->delete('paises');
	}
	
	public function editPais($paises_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "paises SET paises_nombre = '" . $this->db->escape($data['paises_nombre']) . "', paises_iso_code_2 = '" . $this->db->escape($data['paises_iso_code_2']) . "', paises_iso_code_3 = '" . $this->db->escape($data['paises_iso_code_3']) . "', paises_formato_direccion = '" . $this->db->escape($data['paises_formato_direccion']) . "', postcode_required = '" . (int)$data['postcode_required'] . "', paises_status = '" . (int)$data['paises_status'] . "' WHERE paises_id = '" . (int)$paises_id . "'");
	
		$this->cache->delete('paises');
	}
	
	public function deletePais($paises_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "paises WHERE paises_id = '" . (int)$paises_id . "'");
		
		$this->cache->delete('paises');
	}
	
	public function getPais($paises_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "paises WHERE paises_id = '" . (int)$paises_id . "'");
		
		return $query->row;
	}
		
	public function getPaises($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "paises";
			
			$sort_data = array(
				'paises_nombre',
				'paises_iso_code_2',
				'paises_iso_code_3'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY paises_nombre";	
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
			$paises_data = $this->cache->get('paises');
		
			if (!$paises_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "paises ORDER BY paises_nombre ASC");
	
				$paises_data = $query->rows;
			
				$this->cache->set('paises', $paises_data);
			}

			return $paises_data;			
		}	
	}
	
	public function getTotalCountries() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "paises");
		
		return $query->row['total'];
	}	

	public function getPaisByCodigo($paises_id) {
		$query = $this->db->query("SELECT paises_nombre FROM " . DB_PREFIX . "paises WHERE paises_id = '" . (int)$paises_id . "'");
		
		return $query->row['paises_nombre'];
	}

}
?>
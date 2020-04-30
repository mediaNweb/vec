<?php 
class ModelLocalidadImpuestoClass extends Model {
	public function addImpuestoClass($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "impuestos_clase SET impuestos_clase_titulo = '" . $this->db->escape($data['impuestos_clase_titulo']) . "', impuestos_clase_descripcion = '" . $this->db->escape($data['impuestos_clase_descripcion']) . "', impuestos_clase_fdc = NOW()");
		
		$impuestos_clase_id = $this->db->getLastId();
		
		if (isset($data['impuestos_tasa'])) {
			foreach ($data['impuestos_tasa'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "impuestos_tasa SET impuestos_tasa_id_zona = '" . (int)$value['impuestos_tasa_id_zona'] . "', impuestos_tasa_id_impuestos_clase = '" . (int)$impuestos_clase_id . "', impuestos_tasa_prioridad = '" . (int)$value['impuestos_tasa_prioridad'] . "', impuestos_tasa = '" . (float)$value['impuestos_tasa'] . "', impuestos_tasa_descripcion = '" . $this->db->escape($value['impuestos_tasa_descripcion']) . "', impuestos_tasa_fdc = NOW()");
			}
		}
		
		$this->cache->delete('impuestos_clase');
	}
	
	public function editImpuestoClass($impuestos_clase_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "impuestos_clase SET impuestos_clase_titulo = '" . $this->db->escape($data['impuestos_clase_titulo']) . "', impuestos_clase_descripcion = '" . $this->db->escape($data['impuestos_clase_descripcion']) . "', impuestos_clase_fdum = NOW() WHERE impuestos_clase_id = '" . (int)$impuestos_clase_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "impuestos_tasa WHERE impuestos_tasa_id_impuestos_clase = '" . (int)$impuestos_clase_id . "'");

		if (isset($data['impuestos_tasa'])) {
			foreach ($data['impuestos_tasa'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "impuestos_tasa SET impuestos_tasa_id_zona = '" . (int)$value['impuestos_tasa_id_zona'] . "', impuestos_tasa_id_impuestos_clase = '" . (int)$impuestos_clase_id . "', impuestos_tasa_prioridad = '" . (int)$value['impuestos_tasa_prioridad'] . "', impuestos_tasa = '" . (float)$value['impuestos_tasa'] . "', impuestos_tasa_descripcion = '" . $this->db->escape($value['impuestos_tasa_descripcion']) . "', impuestos_tasa_fdc = NOW()");
			}
		}
		
		$this->cache->delete('impuestos_clase');
	}
	
	public function deleteImpuestoClass($impuestos_clase_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "impuestos_clase WHERE impuestos_clase_id = '" . (int)$impuestos_clase_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "impuestos_tasa WHERE impuestos_tasa_id_impuestos_clase = '" . (int)$impuestos_clase_id . "'");
		
		$this->cache->delete('impuestos_clase');
	}
	
	public function getImpuestoClass($impuestos_clase_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "impuestos_clase WHERE impuestos_clase_id = '" . (int)$impuestos_clase_id . "'");
		
		return $query->row;
	}

	public function getImpuestos($data = array()) {
    	if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "impuestos_clase";

			$sql .= " ORDER BY impuestos_clase_titulo";	
			
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
			$impuestos_clase_data = $this->cache->get('impuestos_clase');

			if (!$impuestos_clase_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "impuestos_clase");
	
				$impuestos_clase_data = $query->rows;
			
				$this->cache->set('impuestos_clase', $impuestos_clase_data);
			}
			
			return $impuestos_clase_data;			
		}
	}
	
	public function getImpuestoRates($impuestos_clase_id) {
      	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "impuestos_tasa WHERE impuestos_tasa_id_impuestos_clase = '" . (int)$impuestos_clase_id . "'");
		
		return $query->rows;
	}
			
	public function getTotalImpuestoClasses() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "impuestos_clase");
		
		return $query->row['total'];
	}	
	
	public function getTotalImpuestoRatesByGeoZoneId($impuestos_tasa_id_zona) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "impuestos_tasa WHERE impuestos_tasa_id_zona = '" . (int)$impuestos_tasa_id_zona . "'");
		
		return $query->row['total'];
	}		
}
?>
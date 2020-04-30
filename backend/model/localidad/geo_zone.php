<?php
class ModelLocalidadGeoZone extends Model {
	public function addGeoZone($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "geo_zona SET name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', date_added = NOW()");

		$geo_zone_id = $this->db->getLastId();
		
		if (isset($data['zone_to_geo_zone'])) {
			foreach ($data['zone_to_geo_zone'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "estados_a_zonas SET estados_a_zonas_id_pais = '"  . (int)$value['paises_id'] . "', estados_a_zonas_id_estado = '"  . (int)$value['zone_id'] . "', estados_a_zonas_id_zona = '"  .(int)$geo_zone_id . "', estados_a_zonas_fdc = NOW()");
			}
		}
		
		$this->cache->delete('geo_zone');
	}
	
	public function editGeoZone($geo_zone_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "geo_zona SET name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', date_modified = NOW() WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "estados_a_zonas WHERE estados_a_zonas_id_zona = '" . (int)$geo_zone_id . "'");
		
		if (isset($data['zone_to_geo_zone'])) {
			foreach ($data['zone_to_geo_zone'] as $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "estados_a_zonas SET estados_a_zonas_id_pais = '"  . (int)$value['paises_id'] . "', estados_a_zonas_id_estado = '"  . (int)$value['zone_id'] . "', estados_a_zonas_id_zona = '"  .(int)$geo_zone_id . "', estados_a_zonas_fdc = NOW()");
			}
		}
		
		$this->cache->delete('geo_zone');
	}
	
	public function deleteGeoZone($geo_zone_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "geo_zona WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "estados_a_zonas WHERE estados_a_zonas_id_zona = '" . (int)$geo_zone_id . "'");

		$this->cache->delete('geo_zone');
	}
	
	public function getGeoZone($geo_zone_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "geo_zona WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
		
		return $query->row;
	}

	public function getGeoZones($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "geo_zona";
	
			$sort_data = array(
				'name',
				'description'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY name";	
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
			$geo_zone_data = $this->cache->get('geo_zone');

			if (!$geo_zone_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zona ORDER BY name ASC");
	
				$geo_zone_data = $query->rows;
			
				$this->cache->set('geo_zone', $geo_zone_data);
			}
			
			return $geo_zone_data;				
		}
	}
	
	public function getTotalGeoZones() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "geo_zona");
		
		return $query->row['total'];
	}	
	
	public function getZoneToGeoZones($geo_zone_id) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "estados_a_zonas WHERE estados_a_zonas_id_zona = '" . (int)$geo_zone_id . "'");
		
		return $query->rows;	
	}		

	public function getTotalZoneToGeoZoneByGeoZoneId($geo_zone_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "estados_a_zonas WHERE estados_a_zonas_id_zona = '" . (int)$geo_zone_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalZoneToGeoZoneByPaisId($paises_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "estados_a_zonas WHERE estados_a_zonas_id_pais = '" . (int)$paises_id . "'");
		
		return $query->row['total'];
	}	
	
	public function getTotalZoneToGeoZoneByZoneId($zone_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "estados_a_zonas WHERE estados_a_zonas_id_estado = '" . (int)$zone_id . "'");
		
		return $query->row['total'];
	}		
}
?>
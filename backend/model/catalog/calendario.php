<?php
class ModelCatalogCalendario extends Model {
	public function addCalendario($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_calendario SET eventos_calendario_titulo = '" . $this->request->post['eventos_calendario_titulo'] . "', eventos_calendario_fecha = '" . $this->request->post['eventos_calendario_fecha'] . "'");

		$this->cache->delete('calendario');
	}
	
	public function editCalendario($eventos_calendario_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "eventos_calendario SET eventos_calendario_titulo = '" . $this->request->post['eventos_calendario_titulo'] . "', eventos_calendario_fecha = '" . $this->request->post['eventos_calendario_fecha'] . "' WHERE eventos_calendario_id = '" . (int)$eventos_calendario_id . "'");
		
		$this->cache->delete('calendario');
	}
	
	public function deleteCalendario($eventos_calendario_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_calendario WHERE eventos_calendario_id = '" . (int)$eventos_calendario_id . "'");

		$this->cache->delete('calendario');
	}	

	public function getCalendario($eventos_calendario_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "eventos_calendario WHERE eventos_calendario_id = '" . (int)$eventos_calendario_id . "'");
		
		return $query->row;
	}
		
	public function getCalendarios($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "eventos_calendario ec";
		
			$sort_data = array(
				'ec.eventos_calendario_titulo',
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY ec.eventos_calendario_titulo";	
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
			$calendario_data = $this->cache->get('calendario.' . $this->config->get('config_idioma_id'));
		
			if (!$calendario_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_calendario ec ORDER BY ec.eventos_calendario_titulo");
	
				$calendario_data = $query->rows;
			
				$this->cache->set('calendario.' . $this->config->get('config_idioma_id'), $calendario_data);
			}	
	
			return $calendario_data;			
		}
	}
	
	public function getCalendarioDetalle($eventos_calendario_id) {
		$calendario_detalle_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_calendario WHERE eventos_calendario_id = '" . (int)$eventos_calendario_id . "'");

		$calendario_detalle_data = $query->rows;
		
		return $calendario_detalle_data;
	}
	
	public function getTotalCalendarios() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_calendario");
		
		return $query->row['total'];
	}	
	
}
?>
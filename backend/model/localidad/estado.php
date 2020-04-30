<?php
class ModelLocalidadEstado extends Model {
	public function addEstado($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "estados SET estados_status = '" . (int)$data['estados_status'] . "', estados_nombre = '" . $this->db->escape($data['estados_nombre']) . "', estados_codigo = '" . $this->db->escape($data['estados_codigo']) . "', estados_id_pais = '" . (int)$data['paises_id'] . "'");
			
		$this->cache->delete('estados');
	}
	
	public function editEstado($estados_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "estados SET estados_status = '" . (int)$data['estados_status'] . "', estados_nombre = '" . $this->db->escape($data['estados_nombre']) . "', estados_codigo = '" . $this->db->escape($data['estados_codigo']) . "', estados_id_pais = '" . (int)$data['paises_id'] . "' WHERE estados_id = '" . (int)$estados_id . "'");

		$this->cache->delete('estados');
	}
	
	public function deleteEstado($estados_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "estados WHERE estados_id = '" . (int)$estados_id . "'");

		$this->cache->delete('estados');	
	}
	
	public function getEstado($estados_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "estados WHERE estados_id = '" . (int)$estados_id . "'");
		
		return $query->row;
	}
	
	public function getEstados($data = array()) {
		$sql = "SELECT *, e.estados_nombre, p.paises_nombre AS paises FROM " . DB_PREFIX . "estados e LEFT JOIN " . DB_PREFIX . "paises p ON (e.estados_id_pais = p.paises_id)";
			
		$sort_data = array(
			'p.paises_nombre',
			'e.estados_nombre',
			'e.estados_codigo'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY p.paises_nombre";	
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
	}
	
	public function getEstadosByPaisId($paises_id) {
		$estados_data = $this->cache->get('estados.' . $paises_id);
	
		if (!$estados_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "estados WHERE estados_id_pais = '" . (int)$paises_id . "' ORDER BY estados_nombre");
	
			$estados_data = $query->rows;
			
			$this->cache->set('estados.' . $paises_id, $estados_data);
		}
	
		return $estados_data;
	}
	
	public function getTotalEstados() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "estados");
		
		return $query->row['total'];
	}
				
	public function getTotalEstadosByPaisId($paises_id) {
		$query = $this->db->query("SELECT count(*) AS total FROM " . DB_PREFIX . "estados WHERE estados_id_pais = '" . (int)$paises_id . "'");
	
		return $query->row['total'];
	}

	public function getEstadoByCodigo($estados_id) {
		$query = $this->db->query("SELECT estados_nombre FROM " . DB_PREFIX . "estados WHERE estados_id = '" . (int)$estados_id . "'");
		
		return $query->row['estados_nombre'];
	}

}
?>
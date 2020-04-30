<?php
class ModelCatalogGaleria extends Model {
	public function addGaleria($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "eventos_galeria SET eventos_galeria_titulo = '" . $this->request->post['eventos_galeria_titulo'] . "', eventos_galeria_fdc = NOW()");

		$galeria_id = $this->db->getLastId();

		if (isset($data['eventos_galeria_imagen'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "eventos_galeria SET eventos_galeria_imagen = '" . $this->db->escape($data['eventos_galeria_imagen']) . "', eventos_galeria_fdum = NOW() WHERE eventos_galeria_id = '" . (int)$galeria_id . "'");
		}

		$this->cache->delete('galeria');
	}
	
	public function editGaleria($eventos_galeria_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "eventos_galeria SET eventos_galeria_titulo = '" . $this->request->post['eventos_galeria_titulo'] . "', eventos_galeria_imagen = '" . $this->db->escape($data['eventos_galeria_imagen']) . "', eventos_galeria_fdum = NOW() WHERE eventos_galeria_id = '" . (int)$eventos_galeria_id . "'");
		
		$this->cache->delete('galeria');
	}
	
	public function deleteGaleria($eventos_galeria_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "eventos_galeria WHERE eventos_galeria_id = '" . (int)$eventos_galeria_id . "'");

		$this->cache->delete('galeria');
	}	

	public function getGaleria($eventos_galeria_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "eventos_galeria WHERE eventos_galeria_id = '" . (int)$eventos_galeria_id . "'");
		
		return $query->row;
	}

	public function getLastGaleriaId() {
		$query = $this->db->query("SELECT eventos_galeria_id FROM " . DB_PREFIX . "eventos_galeria ORDER BY eventos_galeria_id DESC");
		
		return $query->row['eventos_galeria_id'];
	}
		
	public function getGalerias($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "eventos_galeria ec";
		
			$sort_data = array(
				'ec.eventos_galeria_titulo',
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY ec.eventos_galeria_titulo";	
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
			$galeria_data = $this->cache->get('galeria.' . $this->config->get('config_idioma_id'));
		
			if (!$galeria_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_galeria ec ORDER BY ec.eventos_galeria_titulo");
	
				$galeria_data = $query->rows;
			
				$this->cache->set('galeria.' . $this->config->get('config_idioma_id'), $galeria_data);
			}	
	
			return $galeria_data;			
		}
	}
	
	public function getGaleriaDetalle($eventos_galeria_id) {
		$galeria_detalle_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_galeria WHERE eventos_galeria_id = '" . (int)$eventos_galeria_id . "'");

		$galeria_detalle_data = $query->rows;
		
		return $galeria_detalle_data;
	}
	
	public function getTotalGalerias() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "eventos_galeria");
		
		return $query->row['total'];
	}	
	
}
?>
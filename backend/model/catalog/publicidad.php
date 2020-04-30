<?php
class ModelCatalogPublicidad extends Model {
	public function addPublicidad($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "publicidad SET publicidad_titulo = '" . $this->request->post['publicidad_titulo'] . "', publicidad_layout_id = '" . $this->request->post['publicidad_layout_id'] . "', publicidad_imagen = '" . $this->request->post['publicidad_imagen'] . "', publicidad_url = '" . $this->request->post['publicidad_url'] . "', publicidad_fdi = '" . $this->request->post['publicidad_fdi'] . "', publicidad_fdf = '" . $this->request->post['publicidad_fdf'] . "', publicidad_orden = '" . $this->request->post['publicidad_orden'] . "', publicidad_status = '" . $this->request->post['publicidad_status'] . "', publicidad_fdc = NOW(), publicidad_fdum = NOW()");

		$this->cache->delete('publicidad');
	}
	
	public function editPublicidad($publicidad_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "publicidad SET publicidad_titulo = '" . $this->request->post['publicidad_titulo'] . "', publicidad_layout_id = '" . $this->request->post['publicidad_layout_id'] . "', publicidad_imagen = '" . $this->request->post['publicidad_imagen'] . "', publicidad_url = '" . $this->request->post['publicidad_url'] . "', publicidad_fdi = '" . $this->request->post['publicidad_fdi'] . "', publicidad_fdf = '" . $this->request->post['publicidad_fdf'] . "', publicidad_orden = '" . $this->request->post['publicidad_orden'] . "', publicidad_status = '" . $this->request->post['publicidad_status'] . "', publicidad_fdum = NOW() WHERE publicidad_id = '" . (int)$publicidad_id . "'");
		
		$this->cache->delete('publicidad');
	}
	
	public function deletePublicidad($publicidad_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "publicidad WHERE publicidad_id = '" . (int)$publicidad_id . "'");

		$this->cache->delete('publicidad');
	}	

	public function getPublicidad($publicidad_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "publicidad WHERE publicidad_id = '" . (int)$publicidad_id . "'");
		
		foreach ($query->rows as $result) {
			$publicidad_data = array(
                'publicidad_id'         => $result['publicidad_id'],
                'publicidad_titulo'     => $result['publicidad_titulo'],
                'publicidad_layout_id'  => $result['publicidad_layout_id'],
                'publicidad_imagen'     => $result['publicidad_imagen'],
                'publicidad_url'        => $result['publicidad_url'],
                'publicidad_fdi'        => $result['publicidad_fdi'],
                'publicidad_fdf'		=> $result['publicidad_fdf'],
                'publicidad_orden'      => $result['publicidad_orden'],
                'publicidad_status'		=> $result['publicidad_status'],
                'publicidad_fdc'        => $result['publicidad_fdc'],
                'publicidad_fdum'       => $result['publicidad_fdum'],
			);
		}
		
		return $publicidad_data;

	}
		
	public function getPublicidades($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "publicidad p";
		
			$sort_data = array(
				'p.publicidad_titulo',
				'p.publicidad_orden'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY p.publicidad_titulo";	
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
			$publicidad_data = $this->cache->get('publicidad.' . $this->config->get('config_idioma_id'));
		
			if (!$publicidad_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "publicidad p ORDER BY p.publicidad_titulo");
	
				$publicidad_data = $query->rows;
			
				$this->cache->set('publicidad.' . $this->config->get('config_idioma_id'), $publicidad_data);
			}	
	
			return $publicidad_data;			
		}
	}
	
	public function getPublicidadDetalle($publicidad_id) {
		$publicidad_detalle_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "publicidad WHERE publicidad_id = '" . (int)$publicidad_id . "'");

		$publicidad_detalle_data = $query->rows;
		
		return $publicidad_detalle_data;
	}
	
	public function getTotalPublicidad() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "publicidad");
		
		return $query->row['total'];
	}	
	
	public function getLayouts() {
      	$query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "publicidad_layout");
		
		return $query->rows;
	}	
	
}
?>
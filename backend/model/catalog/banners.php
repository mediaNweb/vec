<?php
class ModelCatalogBanners extends Model {
	public function addBanners($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "banners SET banner_titulo = '" . $this->request->post['banner_titulo'] . "', banner_imagen = '" . $this->request->post['banner_imagen'] . "', banner_url = '" . $this->request->post['banner_url'] . "', banner_texto = '" . $this->request->post['banner_texto'] . "', banner_orden = '" . $this->request->post['banner_orden'] . "', banner_status = '" . $this->request->post['banner_status'] . "'");

/*
		$banner_id = $this->db->getLastId(); 
			
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'banner_id=" . (int)$banner_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
*/		
		$this->cache->delete('banner');
	}
	
	public function editBanners($banner_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "banners SET banner_titulo = '" . $this->request->post['banner_titulo'] . "', banner_imagen = '" . $this->request->post['banner_imagen'] . "', banner_url = '" . $this->request->post['banner_url'] . "', banner_texto = '" . $this->request->post['banner_texto'] . "', banner_orden = '" . $this->request->post['banner_orden'] . "', banner_status = '" . $this->request->post['banner_status'] . "' WHERE banner_id = '" . (int)$banner_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'banner_id=" . (int)$banner_id. "'");
		
/*
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'banner_id=" . (int)$banner_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
*/		
		$this->cache->delete('banner');
	}
	
	public function deleteBanners($banner_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "banners WHERE banner_id = '" . (int)$banner_id . "'");
//		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'banner_id=" . (int)$banner_id . "'");

		$this->cache->delete('banner');
	}	

	public function getBanner($banner_id) {
//		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'banner_id=" . (int)$banner_id . "') AS keyword FROM " . DB_PREFIX . "banners WHERE banner_id = '" . (int)$banner_id . "'");
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "banners WHERE banner_id = '" . (int)$banner_id . "'");
		
		return $query->row;
	}
		
	public function getBanners($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "banners b";
		
			$sort_data = array(
				'b.banner_titulo',
				'b.banner_orden'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY b.banner_titulo";	
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
			$banner_data = $this->cache->get('banner.' . $this->config->get('config_idioma_id'));
		
			if (!$banner_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banners b ORDER BY b.banner_titulo");
	
				$banner_data = $query->rows;
			
				$this->cache->set('banner.' . $this->config->get('config_idioma_id'), $banner_data);
			}	
	
			return $banner_data;			
		}
	}
	
	public function getBannersDetalle($banner_id) {
		$banner_detalle_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banners WHERE banner_id = '" . (int)$banner_id . "'");

		$banner_detalle_data = $query->rows;
		
		return $banner_detalle_data;
	}
	
	public function getTotalBanners() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "banners");
		
		return $query->row['total'];
	}	
	
}
?>
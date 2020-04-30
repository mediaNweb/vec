<?php
class ModelCatalogNoticia extends Model {
	public function addNoticia($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "noticias SET noticia_titulo = '" . $this->request->post['noticia_titulo'] . "', noticia_titular = '" . $this->request->post['noticia_titular'] . "', noticia_imagen = '" . $this->request->post['noticia_imagen'] . "', noticia_video = '" . $this->request->post['noticia_video'] . "', noticia_texto = '" . $this->request->post['noticia_texto'] . "', noticia_fdp = '" . $this->request->post['noticia_fdp'] . "', noticia_posicion = '" . $this->request->post['noticia_posicion'] . "', noticia_orden = '" . $this->request->post['noticia_orden'] . "', noticia_status = '" . $this->request->post['noticia_status'] . "'");

/*
		$noticia_id = $this->db->getLastId(); 
			
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'noticia_id=" . (int)$noticia_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
*/		
		$this->cache->delete('noticia');
	}
	
	public function editNoticia($noticia_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "noticias SET noticia_titulo = '" . $this->request->post['noticia_titulo'] . "', noticia_titular = '" . $this->request->post['noticia_titular'] . "', noticia_imagen = '" . $this->request->post['noticia_imagen'] . "', noticia_video = '" . $this->request->post['noticia_video'] . "', noticia_texto = '" . $this->request->post['noticia_texto'] . "', noticia_fdp = '" . $this->request->post['noticia_fdp'] . "', noticia_posicion = '" . $this->request->post['noticia_posicion'] . "', noticia_orden = '" . $this->request->post['noticia_orden'] . "', noticia_status = '" . $this->request->post['noticia_status'] . "' WHERE noticia_id = '" . (int)$noticia_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'noticia_id=" . (int)$noticia_id. "'");
		
/*
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'noticia_id=" . (int)$noticia_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
*/		
		$this->cache->delete('noticia');
	}
	
	public function deleteNoticia($noticia_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "noticias WHERE noticia_id = '" . (int)$noticia_id . "'");
//		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'noticia_id=" . (int)$noticia_id . "'");

		$this->cache->delete('noticia');
	}	

	public function getNoticia($noticia_id) {
//		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'noticia_id=" . (int)$noticia_id . "') AS keyword FROM " . DB_PREFIX . "noticias WHERE noticia_id = '" . (int)$noticia_id . "'");
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "noticias WHERE noticia_id = '" . (int)$noticia_id . "'");
		
		return $query->row;
	}
		
	public function getNoticias($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "noticias n";
		
			$sort_data = array(
				'n.noticia_titulo',
				'n.noticia_orden'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY n.noticia_titulo";	
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
			$noticia_data = $this->cache->get('noticia.' . $this->config->get('config_idioma_id'));
		
			if (!$noticia_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "noticias n ORDER BY n.noticia_titulo");
	
				$noticia_data = $query->rows;
			
				$this->cache->set('noticia.' . $this->config->get('config_idioma_id'), $noticia_data);
			}	
	
			return $noticia_data;			
		}
	}
	
	public function getNoticiaDetalle($noticia_id) {
		$noticia_detalle_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "noticias WHERE noticia_id = '" . (int)$noticia_id . "'");

		$noticia_detalle_data = $query->rows;
		
		return $noticia_detalle_data;
	}
	
	public function getTotalNoticias() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "noticias");
		
		return $query->row['total'];
	}	
	
}
?>
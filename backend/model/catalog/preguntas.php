<?php
class ModelCatalogPreguntas extends Model {
	public function addPregunta($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "preguntas_frecuentes SET preguntas_frecuentes_pregunta = '" . $this->request->post['preguntas_frecuentes_pregunta'] . "', preguntas_frecuentes_respuesta = '" . $this->request->post['preguntas_frecuentes_respuesta'] . "'");

		$this->cache->delete('pregunta');
	}
	
	public function editPregunta($preguntas_frecuentes_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "preguntas_frecuentes SET preguntas_frecuentes_pregunta = '" . $this->request->post['preguntas_frecuentes_pregunta'] . "', preguntas_frecuentes_respuesta = '" . $this->request->post['preguntas_frecuentes_respuesta'] . "' WHERE preguntas_frecuentes_id = '" . (int)$preguntas_frecuentes_id . "'");
		
		$this->cache->delete('pregunta');
	}
	
	public function deletePregunta($preguntas_frecuentes_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "preguntas_frecuentes WHERE preguntas_frecuentes_id = '" . (int)$preguntas_frecuentes_id . "'");

		$this->cache->delete('pregunta');
	}	

	public function getPregunta($preguntas_frecuentes_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "preguntas_frecuentes WHERE preguntas_frecuentes_id = '" . (int)$preguntas_frecuentes_id . "'");
		
		return $query->row;
	}
		
	public function getPreguntas($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "preguntas_frecuentes ec";
		
			$sort_data = array(
				'ec.preguntas_frecuentes_pregunta',
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY ec.preguntas_frecuentes_pregunta";	
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
			$pregunta_data = $this->cache->get('pregunta.' . $this->config->get('config_idioma_id'));
		
			if (!$pregunta_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "preguntas_frecuentes ec ORDER BY ec.preguntas_frecuentes_pregunta");
	
				$pregunta_data = $query->rows;
			
				$this->cache->set('pregunta.' . $this->config->get('config_idioma_id'), $pregunta_data);
			}	
	
			return $pregunta_data;			
		}
	}
	
	public function getPreguntaDetalle($preguntas_frecuentes_id) {
		$pregunta_detalle_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "preguntas_frecuentes WHERE preguntas_frecuentes_id = '" . (int)$preguntas_frecuentes_id . "'");

		$pregunta_detalle_data = $query->rows;
		
		return $pregunta_detalle_data;
	}
	
	public function getTotalPreguntas() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "preguntas_frecuentes");
		
		return $query->row['total'];
	}	
	
}
?>
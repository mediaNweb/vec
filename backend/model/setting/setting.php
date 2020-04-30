<?php 
class ModelSettingSetting extends Model {
	public function getSetting($group, $store_id = 0) {
		$data = array(); 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "configuraciones WHERE configuracion_sitio_id = '" . (int)$store_id . "' AND `configuracion_grupo` = '" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			$data[$result['configuracion_clave']] = $result['configuracion_valor'];
		}

		return $data;
	}
	
	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "configuraciones WHERE configuracion_sitio_id = '" . (int)$store_id . "' AND `configuracion_grupo` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "configuraciones SET configuracion_sitio_id = '" . (int)$store_id . "', `configuracion_grupo` = '" . $this->db->escape($group) . "', `configuracion_clave` = '" . $this->db->escape($key) . "', `configuracion_valor` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "configuraciones SET configuracion_sitio_id = '" . (int)$store_id . "', `configuracion_grupo` = '" . $this->db->escape($group) . "', `configuracion_clave` = '" . $this->db->escape($key) . "', `configuracion_valor` = '" . $this->db->escape(serialize($value)) . "', configuracion_serializada = '1'");
			}
		}
	}
	
	public function deleteSetting($group, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "configuraciones WHERE configuracion_sitio_id = '" . (int)$store_id . "' AND `configuracion_grupo` = '" . $this->db->escape($group) . "'");
	}
}
?>
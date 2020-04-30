<?php
class ModelSettingExtension extends Model {
	public function getInstalled($type) {
		$extensiones_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extensiones WHERE extension_tipo = '" . $this->db->escape($type) . "'");
		
		foreach ($query->rows as $result) {
			$extensiones_data[] = $result['extension_codigo'];
		}
		
		return $extensiones_data;
	}
	
	public function install($type, $code) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "extensiones SET extension_tipo = '" . $this->db->escape($type) . "', extension_codigo = '" . $this->db->escape($code) . "'");
	}
	
	public function uninstall($type, $code) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "extensiones WHERE extension_tipo = '" . $this->db->escape($type) . "' AND 'extension_codigo' = '" . $this->db->escape($code) . "'");
	}
}
?>
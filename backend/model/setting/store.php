<?php
class ModelSettingStore extends Model {
	public function addStore($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "hipereventos SET hipereventos_nombre = '" . $this->db->escape($data['config_name']) . "', `hipereventos_url` = '" . $this->db->escape($data['config_url']) . "', `hipereventos_ssl` = '" . $this->db->escape($data['config_ssl']) . "'");
		
		$this->cache->delete('store');
		
		return $this->db->getLastId();
	}
	
	public function editStore($store_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "hipereventos SET hipereventos_nombre = '" . $this->db->escape($data['config_name']) . "', `hipereventos_url` = '" . $this->db->escape($data['config_url']) . "', `hipereventos_ssl` = '" . $this->db->escape($data['config_ssl']) . "' WHERE configuracion_sitio_id = '" . (int)$store_id . "'");
						
		$this->cache->delete('store');
	}
	
	public function deleteStore($store_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "hipereventos WHERE configuracion_sitio_id = '" . (int)$store_id . "'");
			
		$this->cache->delete('store');
	}	
	
	public function getStore($store_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "hipereventos WHERE configuracion_sitio_id = '" . (int)$store_id . "'");
		
		return $query->row;
	}
	
	public function getStores($data = array()) {
		$store_data = $this->cache->get('store');
	
		if (!$store_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hipereventos ORDER BY hipereventos_url");

			$store_data = $query->rows;
		
			$this->cache->set('store', $store_data);
		}
	 
		return $store_data;
	}

	public function getTotalStores() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hipereventos");
		
		return $query->row['total'];
	}	
	
	public function getTotalStoresByLayoutId($layout_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_layout_id' AND `configuracion_valor` = '" . (int)$layout_id . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}
	
	public function getTotalStoresByLanguage($language) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_language' AND `configuracion_valor` = '" . $this->db->escape($language) . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}
	
	public function getTotalStoresByCurrency($currency) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_currency' AND `configuracion_valor` = '" . $this->db->escape($currency) . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}
	
	public function getTotalStoresByPaisId($paises_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_paises_id' AND `configuracion_valor` = '" . (int)$paises_id . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}
	
	public function getTotalStoresByZoneId($zone_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_zone_id' AND `configuracion_valor` = '" . (int)$zone_id . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}
	
	public function getTotalStoresByClienteGroupId($cliente_group_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_cliente_group_id' AND `configuracion_valor` = '" . (int)$cliente_group_id . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}	
	
	public function getTotalStoresByInformationId($information_id) {
      	$account_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_account_id' AND `configuracion_valor` = '" . (int)$information_id . "' AND configuracion_sitio_id != '0'");
      	
		$checkout_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_checkout_id' AND `configuracion_valor` = '" . (int)$information_id . "' AND configuracion_sitio_id != '0'");
		
		return ($account_query->row['total'] + $checkout_query->row['total']);
	}
	
	public function getTotalStoresByOrderStatusId($order_status_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "configuraciones WHERE `configuracion_clave` = 'config_order_status_id' AND `configuracion_valor` = '" . (int)$order_status_id . "' AND configuracion_sitio_id != '0'");
		
		return $query->row['total'];		
	}	
}
?>
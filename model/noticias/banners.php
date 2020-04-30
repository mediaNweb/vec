<?php
class ModelNoticiasBanners extends Model {	
    public function getBanners() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banners b WHERE b.banner_status = 1 ORDER BY b.banner_orden ASC");
        
        return $query->rows;
    }

	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banners b WHERE b.banner_id = '" . (int)$banner_id . "'");
		
		return $query->rows;
	}
}
?>
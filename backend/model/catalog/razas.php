<?php
    class ModelCatalogRazas extends Model {
        public function getRazas() {
            $query = $this->db->query("SELECT rc.* FROM " . DB_PREFIX . "razas_caninas rc ORDER BY rc.razas_nombre ASC");

            return $query->rows;            
        }
    }
?>
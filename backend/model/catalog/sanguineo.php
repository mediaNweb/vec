<?php
    class ModelCatalogSanguineo extends Model {
        public function getGrupo($grupo_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "grupo_sanguineo WHERE grupo_sanguineo_id = '" . (int)$grupo_id . "'");

            return $query->row;
        }    

        public function getGrupos() {
            $grupo_data = $this->cache->get('grupo');

            if (!$grupo_data) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "grupo_sanguineo ORDER BY grupo_sanguineo_nombre ASC");

                $grupo_data = $query->rows;

                $this->cache->set('grupo', $grupo_data);
            }

            return $grupo_data;
        }
    }
?>
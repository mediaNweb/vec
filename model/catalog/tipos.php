<?php
    class ModelCatalogTipos extends Model {
        public function getTipos() {
            $query = $this->db->query("SELECT et.* FROM " . DB_PREFIX . "eventos_tipos et ORDER BY et.eventos_tipos_orden ASC");

            return $query->rows;            
        }

        public function getTiposActivos() {

            $tipos_data = array();

            $query = $this->db->query("SELECT DISTINCT eat.eventos_a_tipos_id_tipo FROM " . DB_PREFIX . "eventos_a_tipos eat LEFT JOIN " . DB_PREFIX . "eventos e ON (eat.eventos_a_tipos_id_evento = e.eventos_id) WHERE e.eventos_status = 1 ORDER BY eat.eventos_a_tipos_id_tipo");

            foreach ($query->rows as $result) { 		
				$tipos_data[] = array(
					'eventos_tipos_id'		=> $result['eventos_a_tipos_id_tipo'],
					'eventos_tipos_nombre'	=> $this->getTipoNombre($result['eventos_a_tipos_id_tipo']),
				);
            }

            return $tipos_data;

        }

        public function getTipoNombre($tipo_id) {

            $query = $this->db->query("SELECT et.eventos_tipos_nombre FROM " . DB_PREFIX . "eventos_tipos et WHERE et.eventos_tipos_id = '" . (int)$tipo_id . "'");

            return $query->row['eventos_tipos_nombre'];

        }	

        public function getTipo($eventos_id) {

            $query = $this->db->query("SELECT COUNT(*) as Total, et.eventos_tipos_nombre FROM " . DB_PREFIX . "eventos_tipos et LEFT JOIN " . DB_PREFIX . "eventos_a_tipos eat ON (et.eventos_tipos_id = eat.eventos_a_tipos_id_tipo) WHERE eat.eventos_a_tipos_id_evento = '" . (int)$eventos_id . "'");

            if ($query->row['Total'] > 1) {
				$tipos_filtro = 'Multiples';
			} else {
				$tipos_filtro = $query->row['eventos_tipos_nombre'];
            }

            return $tipos_filtro;
        }	
    }
?>
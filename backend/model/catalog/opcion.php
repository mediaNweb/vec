<?php
class ModelCatalogOpcion extends Model {
	public function addOpcion($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "opcion SET opcion_tipo = '" . $this->db->escape($data['opcion_tipo']) . "', opcion_orden = '" . (int)$data['opcion_orden'] . "'");
		
		$opcion_id = $this->db->getLastId();
		
		foreach ($data['opcion_descripcion'] as $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_descripcion SET opcion_id = '" . (int)$opcion_id . "', opcion_nombre = '" . $this->db->escape($value['opcion_nombre']) . "'");
		}

		if (isset($data['valor_opcion'])) {
			foreach ($data['valor_opcion'] as $valor_opcion) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_valor SET opcion_id = '" . (int)$opcion_id . "', opcion_valor_orden = '" . (int)$valor_opcion['opcion_orden'] . "'");
				
				$opcion_valor_id = $this->db->getLastId();
				
				foreach ($valor_opcion['opcion_valor_descripcion'] as $valor_opcion_descripcion) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_valor_descripcion SET opcion_valor_id = '" . (int)$opcion_valor_id . "', opcion_id = '" . (int)$opcion_id . "', opcion_valor_decripcion_nombre = '" . $this->db->escape($valor_opcion_descripcion['opcion_nombre']) . "'");
				}
			}
		}
	}
	
	public function editOpcion($opcion_id, $data) {
		$this->db->query("UPDATE opcion SET opcion_tipo = '" . $this->db->escape($data['opcion_tipo']) . "', opcion_orden = '" . (int)$data['opcion_orden'] . "' WHERE opcion_id = '" . (int)$opcion_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion_descripcion WHERE opcion_id = '" . (int)$opcion_id . "'");

		foreach ($data['opcion_descripcion'] as $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_descripcion SET opcion_id = '" . (int)$opcion_id . "', opcion_nombre = '" . $this->db->escape($value['opcion_nombre']) . "'");
		}
				
		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion_valor WHERE opcion_id = '" . (int)$opcion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion_valor_descripcion WHERE opcion_id = '" . (int)$opcion_id . "'");
		
		if (isset($data['valor_opcion'])) {
			foreach ($data['valor_opcion'] as $valor_opcion) {
				if ($valor_opcion['opcion_valor_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_valor SET opcion_valor_id = '" . (int)$valor_opcion['opcion_valor_id'] . "', opcion_id = '" . (int)$opcion_id . "', opcion_valor_orden = '" . (int)$valor_opcion['opcion_orden'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_valor SET opcion_id = '" . (int)$opcion_id . "', opcion_valor_orden = '" . (int)$valor_opcion['opcion_orden'] . "'");
				}
				
				$opcion_valor_id = $this->db->getLastId();
				
				foreach ($valor_opcion['opcion_valor_descripcion'] as $valor_opcion_descripcion) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "opcion_valor_descripcion SET opcion_valor_id = '" . (int)$opcion_valor_id . "', opcion_id = '" . (int)$opcion_id . "', opcion_valor_decripcion_nombre = '" . $this->db->escape($valor_opcion_descripcion['opcion_nombre']) . "'");
				}
			}
		}
	}
	
	public function deleteOpcion($opcion_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion WHERE opcion_id = '" . (int)$opcion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion_descripcion WHERE opcion_id = '" . (int)$opcion_id . "'");	
		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion_valor WHERE opcion_id = '" . (int)$opcion_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "opcion_valor_descripcion WHERE opcion_id = '" . (int)$opcion_id . "'");
	}
	
	public function getOpcion($opcion_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "opcion o LEFT JOIN opcion_descripcion od ON (o.opcion_id = od.opcion_id) WHERE o.opcion_id = '" . (int)$opcion_id . "'");
		
		return $query->row;
	}
		
	public function getOpciones($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "opcion o LEFT JOIN opcion_descripcion od ON (o.opcion_id = od.opcion_id)";
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " WHERE LCASE(od.opcion_nombre) LIKE '" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%'";
		}

		$sort_data = array(
			'od.opcion_nombre',
			'o.opcion_tipo',
			'o.opcion_orden'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY od.opcion_nombre";	
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
	}

	public function getOpcionDescripciones($opcion_id) {
		$option_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "opcion_descripcion WHERE opcion_id = '" . (int)$opcion_id . "'");
				
		foreach ($query->rows as $result) {
			$option_data[0] = array('opcion_nombre' => $result['opcion_nombre']);
		}
		
		return $option_data;
	}
	
	public function getOpcionValores($opcion_id) {
		$opcion_valor_data = array();
		
		$opcion_valor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "opcion_valor ov LEFT JOIN " . DB_PREFIX . "opcion_valor_descripcion ovd ON (ov.opcion_valor_id = ovd.opcion_valor_id) WHERE ov.opcion_id = '" . (int)$opcion_id . "' ORDER BY ov.opcion_valor_orden ASC");
				
		foreach ($opcion_valor_query->rows as $opcion_valor) {
			$opcion_valor_data[] = array(
				'opcion_valor_id'					=> $opcion_valor['opcion_valor_id'],
				'opcion_valor_decripcion_nombre'	=> $opcion_valor['opcion_valor_decripcion_nombre'],
				'opcion_valor_orden'    			=> $opcion_valor['opcion_valor_orden']
			);
		}
		
		return $opcion_valor_data;
	}

	public function getOpcionValorDescripciones($opcion_id) {
		$valor_opcion_data = array();
		
		$valor_opcion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "opcion_valor WHERE opcion_id = '" . (int)$opcion_id . "'");
				
		foreach ($valor_opcion_query->rows as $valor_opcion) {
			$valor_opcion_descripcion_data = array();
			
			$valor_opcion_descripcion_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "opcion_valor_descripcion WHERE opcion_valor_id = '" . (int)$valor_opcion['opcion_valor_id'] . "'");			
			
			foreach ($valor_opcion_descripcion_query->rows as $valor_opcion_descripcion) {
				$valor_opcion_descripcion_data[0] = array('opcion_valor_decripcion_nombre' => $valor_opcion_descripcion['opcion_valor_decripcion_nombre']);
			}
			
			$valor_opcion_data[] = array(
				'opcion_valor_id'          => $valor_opcion['opcion_valor_id'],
				'opcion_valor_descripcion' => $valor_opcion_descripcion_data,
				'opcion_orden'               => $valor_opcion['opcion_valor_orden']
			);
		}
		
		return $valor_opcion_data;
	}

	public function getTotalOpciones() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "opcion"); 
		
		return $query->row['total'];
	}		
}
?>
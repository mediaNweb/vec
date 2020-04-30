<?php
class ModelReportCliente extends Model {
	public function getOrders($data = array()) { 
		$sql = "SELECT tmp.cliente_id, tmp.cliente, tmp.email, tmp.cliente_group, tmp.status, COUNT(tmp.order_id) AS orders, SUM(tmp.products) AS products, SUM(tmp.total) AS total FROM (SELECT o.order_id, c.cliente_id, CONCAT(o.firstname, ' ', o.lastname) AS cliente, o.email, cg.name AS cliente_group, c.status, (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "solicitud_evento` op WHERE op.order_id = o.order_id GROUP BY op.order_id) AS products, o.total FROM `" . DB_PREFIX . "inscripciones` o LEFT JOIN `" . DB_PREFIX . "clientes` c ON (o.cliente_id > '0' AND o.cliente_id = c.cliente_id) LEFT JOIN " . DB_PREFIX . "cliente_group cg ON (c.cliente_group_id = cg.cliente_group_id)";
		
		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id']) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
				
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= ") tmp GROUP BY tmp.cliente_id ORDER BY total DESC";
				
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

	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(DISTINCT o.cliente_id) AS total FROM `" . DB_PREFIX . "inscripciones` o WHERE o.cliente_id > '0'";
		
		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id']) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
						
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
						
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getRewardPoints($data = array()) { 
		$sql = "SELECT cr.cliente_id, CONCAT(c.firstname, ' ', c.lastname) AS cliente, c.email, cg.name AS cliente_group, c.status, SUM(cr.points) AS points, COUNT(o.order_id) AS orders, SUM(o.total) AS total FROM " . DB_PREFIX . "cliente_reward cr LEFT JOIN `" . DB_PREFIX . "clientes` c ON (cr.cliente_id = c.cliente_id) LEFT JOIN " . DB_PREFIX . "cliente_group cg ON (c.cliente_group_id = cg.cliente_group_id) LEFT JOIN `" . DB_PREFIX . "inscripciones` o ON (cr.order_id = o.order_id)";
		
		$implode = array();
		
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$implode[] = "DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$implode[] = "DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$sql .= " GROUP BY cr.cliente_id ORDER BY points DESC";
				
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

	public function getTotalRewardPoints() {
		$sql = "SELECT COUNT(DISTINCT cliente_id) AS total FROM `" . DB_PREFIX . "cliente_reward`";
		
		$implode = array();
		
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$implode[] = "DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$implode[] = "DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
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
		
		return $query->row['total'];
	}
	
	public function getCredit($data = array()) { 
		$sql = "SELECT ct.cliente_id, CONCAT(c.firstname, ' ', c.lastname) AS cliente, c.email, cg.name AS cliente_group, c.status, SUM(ct.amount) AS total FROM " . DB_PREFIX . "cliente_transaction ct LEFT JOIN `" . DB_PREFIX . "clientes` c ON (ct.cliente_id = c.cliente_id) LEFT JOIN " . DB_PREFIX . "cliente_group cg ON (c.cliente_group_id = cg.cliente_group_id)";
		
		$implode = array();
		
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$implode[] = "DATE(ct.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$implode[] = "DATE(ct.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$sql .= " GROUP BY ct.cliente_id ORDER BY total DESC";
				
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

	public function getTotalCredit() {
		$sql = "SELECT COUNT(DISTINCT cliente_id) AS total FROM `" . DB_PREFIX . "cliente_transaction`";
		
		$implode = array();
		
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$implode[] = "DATE(cr.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$implode[] = "DATE(cr.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
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
		
		return $query->row['total'];
	}
}
?>
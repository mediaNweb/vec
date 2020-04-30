<?php
class ModelSaleCliente extends Model {
	public function addCliente($data) {
//      	$this->db->query("INSERT INTO " . DB_PREFIX . "clientes SET clientes_nombre = '" . $this->db->escape($data['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($data['clientes_apellido']) . "', clientes_email = '" . $this->db->escape($data['clientes_email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', cliente_group_id = '" . (int)$data['cliente_group_id'] . "', password = '" . $this->db->escape(md5($data['password'])) . "', clientes_status = '" . (int)$data['clientes_status'] . "', clientes_fdc = NOW()");

      	$this->db->query("INSERT INTO " . DB_PREFIX . "clientes SET clientes_id = '" . $this->db->escape($data['clientes_id']) . "', clientes_nombre = '" . $this->db->escape($data['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($data['clientes_apellido']) . "', clientes_genero = '" . $this->db->escape($data['clientes_genero']) . "', clientes_fdn = '" . $this->db->escape($data['clientes_fdn']) . "', clientes_email = '" . $this->db->escape($data['clientes_email']) . "', clientes_tel = '" . $this->db->escape($data['clientes_tel']) . "', clientes_cel = '" . $this->db->escape($data['clientes_cel']) . "', clientes_pin = '" . $this->db->escape($data['clientes_pin']) . "', clientes_twitter = '" . $this->db->escape($data['clientes_twitter']) . "', clientes_talla = '" . $this->db->escape($data['clientes_talla']) . "', clientes_id_sanguineo = '" . $this->db->escape($data['clientes_id_sanguineo']) . "', clientes_boletin = '" . (int)$data['clientes_boletin'] . "', clientes_clave = '" . $this->db->escape(md5($data['password'])) . "', clientes_status = '" . (int)$data['clientes_status'] . "', clientes_fdc = NOW()");
      	
      	$clientes_id = $this->db->getLastId();
      	
      	if (isset($data['address'])) {		
      		foreach ($data['address'] as $address) {	
      			$this->db->query("INSERT INTO " . DB_PREFIX . "clientes_direcciones SET clientes_id = '" . $clientes_id . "', clientes_direcciones_calle = '" . $this->db->escape($address['clientes_direcciones_calle']) . "', clientes_direcciones_urbanizacion = '" . $this->db->escape($address['clientes_direcciones_urbanizacion']) . "', clientes_direcciones_casa = '" . $this->db->escape($address['clientes_direcciones_casa']) . "', clientes_direcciones_municipio = '" . $this->db->escape($address['clientes_direcciones_municipio']) . "', clientes_direcciones_ciudad = '" . $this->db->escape($address['clientes_direcciones_ciudad']) . "', clientes_direcciones_postal = '" . $this->db->escape($address['clientes_direcciones_postal']) . "', paises_id = '" . (int)$address['paises_id'] . "', estados_id = '" . (int)$address['estados_id'] . "'");
				if (isset($address['default'])) {
					$clientes_direcciones_id = $this->db->getLastId();
					
					$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_id_direccion = '" . $clientes_direcciones_id . "' WHERE clientes_id = '" . $clientes_id . "'");
				}
			}
		}
	}
	
	public function editCliente($clientes_id, $data) {
//		$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_nombre = '" . $this->db->escape($data['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($data['clientes_apellido']) . "', clientes_email = '" . $this->db->escape($data['clientes_email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', cliente_group_id = '" . (int)$data['cliente_group_id'] . "', clientes_status = '" . (int)$data['clientes_status'] . "' WHERE clientes_id = '" . $clientes_id . "'");

		$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_id = '" . $this->db->escape($data['clientes_id']) . "', clientes_nombre = '" . $this->db->escape($data['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($data['clientes_apellido']) . "', clientes_genero = '" . $this->db->escape($data['clientes_genero']) . "', clientes_fdn = '" . $this->db->escape($data['clientes_fdn']) . "', clientes_email = '" . $this->db->escape($data['clientes_email']) . "', clientes_tel = '" . $this->db->escape($data['clientes_tel']) . "', clientes_cel = '" . $this->db->escape($data['clientes_cel']) . "', clientes_pin = '" . $this->db->escape($data['clientes_pin']) . "', clientes_tel = '" . $this->db->escape($data['clientes_tel']) . "', clientes_twitter = '" . $this->db->escape($data['clientes_twitter']) . "', clientes_talla = '" . $this->db->escape($data['clientes_talla']) . "', clientes_id_sanguineo = '" . $this->db->escape($data['clientes_id_sanguineo']) . "', clientes_boletin = '" . (int)$data['clientes_boletin'] . "', clientes_status = '" . (int)$data['clientes_status'] . "' WHERE clientes_id = '" . $clientes_id . "'");
	
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_clave = '" . $this->db->escape(md5($data['password'])) . "' WHERE clientes_id = '" . $clientes_id . "'");
      	}
      	
      	$this->db->query("DELETE FROM " . DB_PREFIX . "clientes_direcciones WHERE clientes_id = '" . $clientes_id . "'");
      	
      	if (isset($data['address'])) {
      		foreach ($data['address'] as $address) {
				if ($address['clientes_direcciones_id']) {
//					$this->db->query("INSERT INTO " . DB_PREFIX . "clientes_direcciones SET clientes_direcciones_id = '" . $this->db->escape($address['clientes_direcciones_id']) . "', clientes_id = '" . $clientes_id . "', clientes_nombre = '" . $this->db->escape($address['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($address['clientes_apellido']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', clientes_direcciones_ciudad = '" . $this->db->escape($address['clientes_direcciones_ciudad']) . "', clientes_direcciones_postal = '" . $this->db->escape($address['clientes_direcciones_postal']) . "', paises_id = '" . (int)$address['paises_id'] . "', estados_id = '" . (int)$address['estados_id'] . "'");

					$this->db->query("INSERT INTO " . DB_PREFIX . "clientes_direcciones SET clientes_direcciones_id = '" . $this->db->escape($address['clientes_direcciones_id']) . "', clientes_id = '" . $clientes_id . "', clientes_direcciones_calle = '" . $this->db->escape($address['clientes_direcciones_calle']) . "', clientes_direcciones_urbanizacion = '" . $this->db->escape($address['clientes_direcciones_urbanizacion']) . "', clientes_direcciones_casa = '" . $this->db->escape($address['clientes_direcciones_casa']) . "', clientes_direcciones_municipio = '" . $this->db->escape($address['clientes_direcciones_municipio']) . "', clientes_direcciones_ciudad = '" . $this->db->escape($address['clientes_direcciones_ciudad']) . "', clientes_direcciones_postal = '" . $this->db->escape($address['clientes_direcciones_postal']) . "', paises_id = '" . (int)$address['paises_id'] . "', estados_id = '" . (int)$address['estados_id'] . "'");
					
					if (isset($address['default'])) {
						$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_id_direccion = '" . (int)$address['clientes_direcciones_id'] . "' WHERE clientes_id = '" . $clientes_id . "'");
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "clientes_direcciones SET clientes_id = '" . $clientes_id . "', clientes_direcciones_calle = '" . $this->db->escape($address['clientes_direcciones_calle']) . "', clientes_direcciones_urbanizacion = '" . $this->db->escape($address['clientes_direcciones_urbanizacion']) . "', clientes_direcciones_casa = '" . $this->db->escape($address['clientes_direcciones_casa']) . "', clientes_direcciones_municipio = '" . $this->db->escape($address['clientes_direcciones_municipio']) . "', clientes_direcciones_ciudad = '" . $this->db->escape($address['clientes_direcciones_ciudad']) . "', clientes_direcciones_postal = '" . $this->db->escape($address['clientes_direcciones_postal']) . "', paises_id = '" . (int)$address['paises_id'] . "', estados_id = '" . (int)$address['estados_id'] . "'");
					
					if (isset($address['default'])) {
						$clientes_direcciones_id = $this->db->getLastId();
						
						$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_id_direccion = '" . (int)$clientes_direcciones_id . "' WHERE clientes_id = '" . $clientes_id . "'");
					}
				}
			}
		}
	}
	
	public function deleteCliente($clientes_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . $clientes_id . "'");
//		$this->db->query("DELETE FROM " . DB_PREFIX . "cliente_reward WHERE clientes_id = '" . $clientes_id . "'");
//		$this->db->query("DELETE FROM " . DB_PREFIX . "cliente_transaction WHERE clientes_id = '" . $clientes_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "clientes_ip WHERE clientes_id = '" . $clientes_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "clientes_direcciones WHERE clientes_id = '" . $clientes_id . "'");
	}
	
	public function getCliente($clientes_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . $clientes_id . "'");
	
		return $query->row;
	}
		
	public function getClientes($data = array()) {
		$sql = "SELECT *, CONCAT(c.clientes_nombre, ' ', c.clientes_apellido) AS name FROM " . DB_PREFIX . "clientes c";

		$implode = array();
		
		if (isset($data['filter_id']) && !is_null($data['filter_id'])) {
			$implode[] = "c.clientes_id LIKE '" . $this->db->escape($data['filter_id']) . "%'";
		}

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.clientes_nombre, ' ', c.clientes_apellido)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "c.clientes_email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}
		
/*
		if (isset($data['filter_cliente_group_id']) && !is_null($data['filter_cliente_group_id'])) {
			$implode[] = "cg.cliente_group_id = '" . $this->db->escape($data['filter_cliente_group_id']) . "'";
		}	
*/		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.clientes_status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "c.clientes_id IN (SELECT clientes_id FROM " . DB_PREFIX . "clientes_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.clientes_fdc) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'c.clientes_id',
			'name',
			'c.clientes_email',
//			'cliente_group',
			'c.clientes_status',
			'c.ip',
			'c.clientes_fdc'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
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
	
	public function getClientesByNewsletter() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE clientes_boletin = '1' ORDER BY clientes_nombre, clientes_apellido, clientes_email");
	
		return $query->rows;
	}
	
	public function getClientesByClienteGroupId($cliente_group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE cliente_group_id = '" . (int)$cliente_group_id . "' ORDER BY clientes_nombre, clientes_apellido, clientes_email");
	
		return $query->rows;
	}
		
	public function getClientesByProduct($product_id) {
		if ($product_id) {
			$query = $this->db->query("SELECT DISTINCT `clientes_email` FROM `" . DB_PREFIX . "inscripciones` o LEFT JOIN " . DB_PREFIX . "solicitud_evento op ON (o.order_id = op.order_id) WHERE op.product_id = '" . (int)$product_id . "' AND o.order_status_id <> '0'");
	
			return $query->rows;
		} else {
			return array();	
		}
	}
	
	public function getAddress($clientes_direcciones_id) {
		$address_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes_direcciones WHERE clientes_direcciones_id = '" . (int)$clientes_direcciones_id . "'");

		$default_query = $this->db->query("SELECT clientes_id_direccion FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . $address_query->row['clientes_id'] . "'");
				
		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paises` WHERE paises_id = '" . (int)$address_query->row['paises_id'] . "'");
			
			if ($country_query->num_rows) {
				$country = $country_query->row['paises_nombre'];
				$iso_code_2 = $country_query->row['paises_iso_code_2'];
				$iso_code_3 = $country_query->row['paises_iso_code_3'];
				$address_format = $country_query->row['paises_formato_direccion'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';	
				$address_format = '';
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "estados` WHERE estados_id = '" . (int)$address_query->row['estados_id'] . "'");
			
			if ($zone_query->num_rows) {
				$zone = $zone_query->row['estados_nombre'];
				$code = $zone_query->row['estados_codigo'];
			} else {
				$zone = '';
				$code = '';
			}		
		
			return array(
				'clientes_direcciones_id'     		=> $address_query->row['clientes_direcciones_id'],
				'clientes_id'    					=> $address_query->row['clientes_id'],
				'clientes_direcciones_calle'        => $address_query->row['clientes_direcciones_calle'],
				'clientes_direcciones_urbanizacion'	=> $address_query->row['clientes_direcciones_urbanizacion'],
				'clientes_direcciones_casa'      	=> $address_query->row['clientes_direcciones_casa'],
				'clientes_direcciones_municipio'    => $address_query->row['clientes_direcciones_municipio'],
				'clientes_direcciones_postal'       => $address_query->row['clientes_direcciones_postal'],
				'clientes_direcciones_ciudad'       => $address_query->row['clientes_direcciones_ciudad'],
				'estados_id'        				=> $address_query->row['estados_id'],
				'zone'           					=> $zone,
				'zone_code'      					=> $code,
				'paises_id'     					=> $address_query->row['paises_id'],
				'country'        					=> $country,	
				'iso_code_2'     					=> $iso_code_2,
				'iso_code_3'     					=> $iso_code_3,
				'address_format' 					=> $address_format,
				'default'		 					=> ($default_query->row['clientes_id_direccion'] == $address_query->row['clientes_direcciones_id']) ? true : false,
			);
		}
	}
		
	public function getAddresses($clientes_id) {
		$address_data = array();
		
		$query = $this->db->query("SELECT clientes_direcciones_id FROM " . DB_PREFIX . "clientes_direcciones WHERE clientes_id = '" . $clientes_id . "'");
	
		foreach ($query->rows as $result) {
			$address_info = $this->getAddress($result['clientes_direcciones_id']);
		
			if ($address_info) {
				$address_data[] = $address_info;
			}
		}		
		
		return $address_data;
	}	
			
	public function getTotalClientes($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes";
		
		$implode = array();
		
		if (isset($data['filter_id']) && !is_null($data['filter_id'])) {
			$implode[] = "clientes_id LIKE '" . $this->db->escape($data['filter_id']) . "%'";
		}

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "CONCAT(clientes_nombre, ' ', clientes_apellido) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "LCASE(clientes_email) LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "clientes_status = '" . (int)$data['filter_status'] . "'";
		}			
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(clientes_fdc) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}
		
	public function getTotalClientesAwaitingApproval() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes WHERE clientes_status = '0'");

		return $query->row['total'];
	}
	
	public function getTotalAddressesByClienteId($clientes_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes_direcciones WHERE clientes_id = '" . $clientes_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalAddressesByPaisId($paises_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes_direcciones WHERE paises_id = '" . (int)$paises_id . "'");
		
		return $query->row['total'];
	}	
	
	public function getTotalAddressesByZoneId($estados_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes_direcciones WHERE estados_id = '" . (int)$estados_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalClientesByClienteGroupId($cliente_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes WHERE cliente_group_id = '" . (int)$cliente_group_id . "'");
		
		return $query->row['total'];
	}
			
	public function addTransaction($clientes_id, $description = '', $amount = '', $order_id = 0) {
		$cliente_info = $this->getCliente($clientes_id);
		
		if ($cliente_info) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "cliente_transaction SET clientes_id = '" . $clientes_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', clientes_fdc = NOW()");

			$this->language->load('mail/cliente');
			
			if ($cliente_info['store_id']) {
				$this->load->model('setting/store');
		
				$store_info = $this->model_setting_store->getStore($cliente_info['store_id']);
				
				if ($store_info) {
					$store_name = $store_info['store_name'];
				} else {
					$store_name = $this->config->get('config_name');
				}	
			} else {
				$store_name = $this->config->get('config_name');
			}	
						
			$message  = sprintf($this->language->get('text_transaction_received'), $this->moneda->format($amount, $this->config->get('config_currency'))) . "\n\n";
			$message .= sprintf($this->language->get('text_transaction_total'), $this->moneda->format($this->getTransactionTotal($clientes_id)));
								
			// MODIFICACION 3px
			/*
			function mail($asunto,$mensaje,$noHTML,$toDir,$toName,$fromDir,$fromName);
			$asunto = Asunto del Correo
			$mensaje = Contenido HTML del correo
			$noHTML = Contenido NO HTML del correo <--- usado en caso de que el cliente no soporte HTML
			$toDir = Dirección del Destinatario.
			$toName = Nombre del destinatario. 
			$fromDir = Dirección del Remitente
			$fromName = Nombre del Remitente
			*/
			
			$m3px = new M3PX;
			$mail = $m3px->mail(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')), '', $message, $cliente_info['clientes_email'], '', $this->config->get('config_email'), $store_name);

/*
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setTo($cliente_info['clientes_email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($store_name);
			$mail->setSubject(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')));
			$mail->setText($message);
			$mail->send();
*/
		}
	}
	
	public function deleteTransaction($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cliente_transaction WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function getTransactions($clientes_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cliente_transaction WHERE clientes_id = '" . $clientes_id . "' ORDER BY clientes_fdc DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}

	public function getTotalTransactions($clientes_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "cliente_transaction WHERE clientes_id = '" . $clientes_id . "'");
	
		return $query->row['total'];
	}
			
	public function getTransactionTotal($clientes_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "cliente_transaction WHERE clientes_id = '" . $clientes_id . "'");
	
		return $query->row['total'];
	}
	
	public function getTotalClienteTransactionsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cliente_transaction WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->row['total'];
	}	
				
	public function addReward($clientes_id, $description = '', $points = '', $order_id = 0) {
		$cliente_info = $this->getCliente($clientes_id);
			
		if ($cliente_info) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "cliente_reward SET clientes_id = '" . $clientes_id . "', order_id = '" . (int)$order_id . "', points = '" . (int)$points . "', description = '" . $this->db->escape($description) . "', clientes_fdc = NOW()");

			$this->language->load('mail/cliente');
			
			if ($order_id) {
				$this->load->model('sale/order');
		
				$order_info = $this->model_sale_order->getOrder($order_id);
				
				if ($order_info) {
					$store_name = $order_info['store_name'];
				} else {
					$store_name = $this->config->get('config_name');
				}	
			} else {
				$store_name = $this->config->get('config_name');
			}		
				
			$message  = sprintf($this->language->get('text_reward_received'), $points) . "\n\n";
			$message .= sprintf($this->language->get('text_reward_total'), $this->getRewardTotal($clientes_id));
				
			// MODIFICACION 3px
			/*
			function mail($asunto,$mensaje,$noHTML,$toDir,$toName,$fromDir,$fromName);
			$asunto = Asunto del Correo
			$mensaje = Contenido HTML del correo
			$noHTML = Contenido NO HTML del correo <--- usado en caso de que el cliente no soporte HTML
			$toDir = Dirección del Destinatario.
			$toName = Nombre del destinatario. 
			$fromDir = Dirección del Remitente
			$fromName = Nombre del Remitente
			*/
			
			$m3px = new M3PX;
			$mail = $m3px->mail(sprintf($this->language->get('text_reward_subject'), $store_name), '', $message, $cliente_info['clientes_email'], '', $this->config->get('config_email'), $store_name);

/*
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setTo($cliente_info['clientes_email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($store_name);
			$mail->setSubject(sprintf($this->language->get('text_reward_subject'), $store_name));
			$mail->setText($message);
			$mail->send();
*/
		}
	}

	public function deleteReward($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cliente_reward WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function getRewards($clientes_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cliente_reward WHERE clientes_id = '" . $clientes_id . "' ORDER BY clientes_fdc DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}
	
	public function getTotalRewards($clientes_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cliente_reward WHERE clientes_id = '" . $clientes_id . "'");
	
		return $query->row['total'];
	}
			
	public function getRewardTotal($clientes_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "cliente_reward WHERE clientes_id = '" . $clientes_id . "'");
	
		return $query->row['total'];
	}		
	
	public function getTotalClienteRewardsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cliente_reward WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->row['total'];
	}
	
	
	public function getIpsByClienteId($clientes_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes_ip WHERE clientes_id = '" . $clientes_id . "'");

		return $query->rows;
	}	
	
	public function getTotalClientesByIp($ip) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes_ip WHERE ip = '" . $this->db->escape($ip) . "'");

		return $query->row['total'];
	}				
}
?>
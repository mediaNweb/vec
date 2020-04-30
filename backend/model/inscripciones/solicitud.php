<?php
class ModelInscripcionesSolicitud extends Model {	
	public function create($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "solicitud` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();

		foreach ($data['products'] as $product) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_evento SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "'");
 
			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_opcion_" . (int)$product['product_id'] . " SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}
		}
		
		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', text = '" . $this->db->escape($total['text']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}	

		return $order_id;
	}

	public function getSolicitud($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "solicitud_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "solicitud` o WHERE o.order_id = '" . (int)$order_id . "'");
			
		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paises` WHERE paises_id = '" . (int)$order_query->row['shipping_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['paises_iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['paises_iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "estados` WHERE estados_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['estados_codigo'];
			} else {
				$shipping_zone_code = '';
			}
			
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "paises` WHERE paises_id = '" . (int)$order_query->row['payment_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['paises_iso_code_2'];
				$payment_iso_code_3 = $country_query->row['paises_iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "estados` WHERE estados_id = '" . (int)$order_query->row['payment_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['estados_codigo'];
			} else {
				$payment_zone_code = '';
			}

			$this->load->model('localidad/idioma');
			
			$idioma_info = $this->model_localidad_idioma->getIdioma($order_query->row['language_id']);
			
			if ($idioma_info) {
				$idioma_code = $idioma_info['code'];
				$idioma_filename = $idioma_info['filename'];
				$idioma_directory = $idioma_info['directory'];
			} else {
				$idioma_code = '';
				$idioma_filename = '';
				$idioma_directory = '';
			}
		 			
			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],				
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],				
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],	
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_method'         => $order_query->row['shipping_method'],
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],				
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],	
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_method'          => $order_query->row['payment_method'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $idioma_code,
				'language_filename'       => $idioma_filename,
				'language_directory'      => $idioma_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip']
			);
		} else {
			return false;	
		}
	}	

	public function getSaldoSolicitud($order_id, $monto) {
		$order_query = $this->db->query("SELECT st.value AS total FROM `" . DB_PREFIX . "solicitud_total` st WHERE st.order_id = '" . (int)$order_id . "' AND st.value = '" . (float)$monto . "' AND st.code = 'total'");
			
		if ($order_query->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function getEventosBySolicitudId($order_id) {
		$order_query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "solicitud_evento` se WHERE se.order_id = '" . (int)$order_id . "'");
			
		return $order_query->rows;
	}

	public function getSolicitudIdByCliente($cedula, $evento_id) {
		$order_query = $this->db->query("SELECT s.order_id FROM `" . DB_PREFIX . "solicitud` s LEFT JOIN `" . DB_PREFIX . "solicitud_evento` se ON (se.order_id = s.order_id) WHERE s.customer_id = '" . (int)$cedula . "' AND se.product_id = '" . (int)$evento_id . "'");
			
		return $order_query->row['order_id'];
	}

	public function getSolicitudIdOpcionByEvento($evento_id, $order_id) {
		$order_query = $this->db->query("SELECT se.order_product_id FROM `" . DB_PREFIX . "solicitud_evento` se LEFT JOIN `" . DB_PREFIX . "solicitud` s ON (s.order_id = se.order_id) WHERE se.product_id = '" . (int)$evento_id . "' AND s.order_id = '" . (int)$order_id . "'");
			
		return $order_query->row['order_product_id'];
	}

	public function getEventosBySolicitudOpcion($order_id) {
//		$order_query = $this->db->query("SELECT DISTINCT order_product_id AS codigo_opcion FROM `" . DB_PREFIX . "solicitud_opcion` se WHERE se.order_id = '" . (int)$order_id . "'");

		$order_query = $this->db->query("SELECT se.order_product_id AS codigo_opcion FROM `" . DB_PREFIX . "solicitud_evento` se WHERE se.order_id = '" . (int)$order_id . "'");
			
		return $order_query->rows;
	}

	public function getEventosBySolicitudOpcionD($order_id) {
		$order_query = $this->db->query("SELECT se.order_product_id AS codigo_opcion FROM `" . DB_PREFIX . "solicitud_evento` se WHERE se.order_id = '" . (int)$order_id . "'");
			
		return $order_query->rows;
	}

	public function getEventoIdByOpcion($order_id, $order_product_id) {
		$order_query = $this->db->query("SELECT se.product_id FROM `" . DB_PREFIX . "solicitud_evento` se WHERE se.order_id = '" . (int)$order_id . "' AND se.order_product_id = '" . (int)$order_product_id . "'");

		return $order_query->row['product_id'];
	}

	public function getCodigo($order_id) {

			$query = $this->db->query("SELECT payment_number FROM `" . DB_PREFIX . "solicitud` WHERE order_id = '" . (int)$order_id . "'");
			
			if ($query->row['payment_number']) {
				return true;	
			} else {
				return false;	
			}
		
	}

	public function confirm($order_id, $order_status_id, $comment = '', $order_payment_number = '', $order_payment_date = '', $notify = true) {
		$order_info = $this->getSolicitud($order_id);
		 
//		if ($order_info && !$order_info['order_status_id']) {
		if ($order_info) {
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "solicitud` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");
	
			if ($query->row['invoice_no']) {
				$invoice_no = (int)$query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}
			
			$this->db->query("UPDATE `" . DB_PREFIX . "solicitud` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "', order_status_id = '" . (int)$order_status_id . "', payment_number = '" . $order_payment_number . "', payment_date = '" . $order_payment_date . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_historial SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '1', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_evento WHERE order_id = '" . (int)$order_id . "'");
			
			foreach ($order_product_query->rows as $order_product) {
//				$this->db->query("UPDATE " . DB_PREFIX . "eventos SET eventos_cupos_internet = (eventos_cupos_internet - " . (int)$order_product['quantity'] . ") WHERE eventos_id = '" . (int)$order_product['product_id'] . "' AND eventos_restar = '1'");
				
				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$order_product['product_id'] . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");
			
				foreach ($order_option_query->rows as $option) {
					$this->db->query("UPDATE " . DB_PREFIX . "eventos_opcion_valor SET cantidad = (cantidad - " . (int)$order_product['quantity'] . ") WHERE eventos_opcion_valor_id = '" . (int)$option['product_option_value_id'] . "' AND restar = '1'");
				}
			}
			
			$this->cache->delete('product');
			
			$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "solicitud_total` WHERE order_id = '" . (int)$order_id . "'");
			
			foreach ($order_total_query->rows as $order_total) {
				$this->load->model('total/' . $order_total['code']);
				
				if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
					$this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
				}
			}
			
			// Send out any gift voucher mails
			if ($this->config->get('config_complete_status_id') == $order_status_id) {
				$this->load->model('checkout/voucher');

				$this->model_checkout_voucher->confirm($order_id);
			}
			
			if ($notify) { 
			
				// Send out order confirmation mail
				$idioma = new Idioma($order_info['language_directory']);
				$idioma->load($order_info['language_filename']);
				$idioma->load('mail/solicitud');
			 
				$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
				
				if ($order_status_query->num_rows) {
					$order_status = $order_status_query->row['name'];	
				} else {
					$order_status = '';
				}
								
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_evento WHERE order_id = '" . (int)$order_id . "'");
				$order_total_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
				$order_download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_descarga WHERE order_id = '" . (int)$order_id . "'");
				
				$subject = sprintf($idioma->get('text_new_subject'), $order_info['store_name'], $order_id);
			
				// HTML Mail
				$template = new Template();
				
				$template->data['title'] = sprintf($idioma->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
				
				$template->data['text_greeting'] = sprintf($idioma->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$template->data['text_link'] = $idioma->get('text_new_link');
				$template->data['text_download'] = $idioma->get('text_new_download');
				$template->data['text_order_detail'] = $idioma->get('text_new_order_detail');
				$template->data['text_invoice_no'] = $idioma->get('text_new_invoice_no');
				$template->data['text_order_id'] = $idioma->get('text_new_order_id');
				$template->data['text_date_added'] = $idioma->get('text_new_date_added');
				$template->data['text_payment_method'] = $idioma->get('text_new_payment_method');	
				$template->data['text_shipping_method'] = $idioma->get('text_new_shipping_method');
				$template->data['text_email'] = $idioma->get('text_new_email');
				$template->data['text_telephone'] = $idioma->get('text_new_telephone');
				$template->data['text_ip'] = $idioma->get('text_new_ip');
				$template->data['text_payment_address'] = $idioma->get('text_new_payment_address');
				$template->data['text_shipping_address'] = $idioma->get('text_new_shipping_address');
				$template->data['text_product'] = $idioma->get('text_new_product');
				$template->data['text_model'] = $idioma->get('text_new_model');
				$template->data['text_quantity'] = $idioma->get('text_new_quantity');
				$template->data['text_price'] = $idioma->get('text_new_price');
				$template->data['text_total'] = $idioma->get('text_new_total');
				$template->data['text_footer'] = $idioma->get('text_new_footer');
				$template->data['text_powered'] = $idioma->get('text_new_powered');
				
				$template->data['logo'] = 'cid:' . md5(basename($this->config->get('config_logo')));		
				$template->data['store_name'] = $order_info['store_name'];
				$template->data['store_url'] = $order_info['store_url'];
				$template->data['customer_id'] = $order_info['customer_id'];
				$template->data['link'] = $order_info['store_url'] . 'index.php?route=sesion/solicitud/info&order_id=' . $order_id;
				
				if ($order_download_query->num_rows) {
					$template->data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
				} else {
					$template->data['download'] = '';
				}
				
				$template->data['invoice_no'] = $invoice_no;
				$template->data['order_id'] = $order_id;
				$template->data['date_added'] = date($idioma->get('date_format_short'), strtotime($order_info['date_added']));    	
				$template->data['payment_method'] = $order_info['payment_method'];
				$template->data['shipping_method'] = $order_info['shipping_method'];
				$template->data['email'] = $order_info['email'];
				$template->data['telephone'] = $order_info['telephone'];
				$template->data['ip'] = $order_info['ip'];
										
				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}
				
				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);
			
				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']  
				);
			
				$template->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
	
				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}
				
				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);
			
				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']  
				);
			
				$template->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				
				$this->load->model('localidad/pais');
				$this->load->model('localidad/estado');

				$template->data['products'] = array();
					
				foreach ($order_product_query->rows as $product) {
					$option_data = array();
					
					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$product['product_id'] . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
					
					foreach ($order_option_query->rows as $option) {
						if ($option['type'] != 'file') {
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value'])
							);
						} else {
							$filename = substr($option['value'], 0, strrpos($option['value'], '.'));
							
							$option_data[] = array(
								'name'  => $option['name'],
								'value' => (strlen($filename) > 20 ? substr($filename, 0, 20) . '..' : $filename)
							);	
						}
					}
				  
					$template->data['products'][] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->moneda->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->moneda->format($product['total'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}
		
				$template->data['totals'] = $order_total_query->rows;
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/solicitud.tpl')) {
					$html = $template->fetch($this->config->get('config_template') . '/template/mail/solicitud.tpl');
				} else {
					$html = $template->fetch('mail/solicitud.tpl');
				}
				
				// Text Mail
				$text  = sprintf($idioma->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
				$text .= $idioma->get('text_new_order_id') . ' ' . $order_id . "\n";
				$text .= $idioma->get('text_new_date_added') . ' ' . date($idioma->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
				$text .= $idioma->get('text_new_order_status') . ' ' . $order_status . "\n\n";
				$text .= $idioma->get('text_new_products') . "\n";
				
				foreach ($order_product_query->rows as $result) {
					$text .= $result['quantity'] . 'x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->moneda->format($result['total'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					
					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$result['product_id'] . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");
					
					foreach ($order_option_query->rows as $option) {
						$text .= chr(9) . '-' . $option['name'] . ' ' . (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
					}
				}
				
				$text .= "\n";
				
				$text .= $idioma->get('text_new_order_total') . "\n";
				
				foreach ($order_total_query->rows as $result) {
					$text .= $result['title'] . ' ' . html_entity_decode($result['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
				}			
				
				$order_total = $result['text'];
				
				$text .= "\n";
				
				if ($order_info['customer_id']) {
					$text .= $idioma->get('text_new_link') . "\n";
					$text .= $order_info['store_url'] . 'index.php?route=account/invoice&order_id=' . $order_id . "\n\n";
				}
			
				if ($order_download_query->num_rows) {
					$text .= $idioma->get('text_new_download') . "\n";
					$text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
				}
				
				if ($order_info['comment']) {
					$text .= $idioma->get('text_new_comment') . "\n\n";
					$text .= $order_info['comment'] . "\n\n";
				}
				
				$text .= $idioma->get('text_new_footer') . "\n\n";
			
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
				$mail = $m3px->mail($subject, $html, html_entity_decode($text, ENT_QUOTES, 'UTF-8'), $order_info['email'], '', $this->config->get('config_email'), $order_info['store_name']);

/*
				$mail = new Mail(); 
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');			
				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($order_info['store_name']);
				$mail->setSubject($subject);
				$mail->setHtml($html);
				$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
				$mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'), md5(basename($this->config->get('config_logo'))));
				$mail->send();
*/
	
				// Admin Alert Mail
				if ($this->config->get('config_alert_mail')) {
					$subject = sprintf($idioma->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);
					
					// Text 
					$text  = $idioma->get('text_new_received') . "\n\n";
					$text .= $idioma->get('text_new_order_id') . ' ' . $order_id . "\n";
					$text .= $idioma->get('text_new_date_added') . ' ' . date($idioma->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
					$text .= $idioma->get('text_new_order_status') . ' ' . $order_status . "\n\n";
					$text .= $idioma->get('text_new_products') . "\n";
					
					foreach ($order_product_query->rows as $result) {
						$text .= $result['quantity'] . 'x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->moneda->format($result['total'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
						
						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion_" . (int)$result['product_id'] . " WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");
						
						foreach ($order_option_query->rows as $option) {
							$text .= chr(9) . '-' . $option['name'] . (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
						}
					}
					
					$text .= "\n";
	
					$text.= $idioma->get('text_new_order_total') . "\n";
					
					foreach ($order_total_query->rows as $result) {
						$text .= $result['title'] . ' ' . html_entity_decode($result['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
					}			
					
					$text .= "\n";
					
					if ($order_info['comment'] != '') {
						$comment = ($order_info['comment'] .  "\n\n" . $comment);
					}
					
					if ($comment) {
						$text .= $idioma->get('text_new_comment') . "\n\n";
						$text .= $comment . "\n\n";
					}
				
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
					$mail = $m3px->mail($subject, '', $text, $this->config->get('config_email'), '', $this->config->get('config_email'), $order_info['store_name']);

/*
					$mail = new Mail(); 
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->hostname = $this->config->get('config_smtp_host');
					$mail->username = $this->config->get('config_smtp_username');
					$mail->password = $this->config->get('config_smtp_password');
					$mail->port = $this->config->get('config_smtp_port');
					$mail->timeout = $this->config->get('config_smtp_timeout');
					$mail->setTo($this->config->get('config_email'));
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($order_info['store_name']);
					$mail->setSubject($subject);
					$mail->setText($text);
					$mail->send();
*/
					
					// Send to additional alert emails
					$emails = explode(',', $this->config->get('config_alert_emails'));
					
					foreach ($emails as $email) {
						if ($email && preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $email)) {
							$mail->setTo($email);
							$mail->send();
						}
					}				
				}
			}
		}
	}
	
	public function update($order_id, $order_status_id, $comment = '', $notify = false) {
		$order_info = $this->getSolicitud($order_id);

		if ($order_info && $order_info['order_status_id']) {
			$this->db->query("UPDATE `" . DB_PREFIX . "solicitud` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_historial SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
	
			// Send out any gift voucher mails
			if ($this->config->get('config_complete_status_id') == $order_status_id) {
				$this->load->model('checkout/voucher');
	
				$this->model_checkout_voucher->confirm($order_id);
			}	
	
			if ($notify) {
				$idioma = new Idioma($order_info['language_directory']);
				$idioma->load($order_info['language_filename']);
				$idioma->load('mail/solicitud');
			
				$subject = sprintf($idioma->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
	
				$message  = $idioma->get('text_update_order') . ' ' . $order_id . "\n";
				$message .= $idioma->get('text_update_date_added') . ' ' . date($idioma->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
				
				$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
				
				if ($order_status_query->num_rows) {
					$message .= $idioma->get('text_update_order_status') . "\n\n";
					$message .= $order_status_query->row['name'] . "\n\n";					
				}
				
				if ($order_info['customer_id']) {
					$message .= $idioma->get('text_update_link') . "\n";
					$message .= $order_info['store_url'] . 'index.php?route=sesion/order/info&order_id=' . $order_id . "\n\n";
				}
				
				if ($comment) { 
					$message .= $idioma->get('text_update_comment') . "\n\n";
					$message .= $comment . "\n\n";
				}
					
				$message .= $idioma->get('text_update_footer');

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
				$mail = $m3px->mail($subject, '', html_entity_decode($message, ENT_QUOTES, 'UTF-8'), $order_info['email'], '', $this->config->get('config_email'), $order_info['store_name']);

/*
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');				
				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($order_info['store_name']);
				$mail->setSubject($subject);
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
*/
			}
		}
	}
	
	public function getTotalSolicitudesByEvento($evento_id) {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "solicitud_evento` WHERE quantity > 1 AND product_id = '" . (int)$evento_id . "' ORDER BY order_id");
		
		return $query->row['total'];
		
	}

	public function getSolicitudesByEvento($evento_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "solicitud_evento` WHERE quantity > 1 AND product_id = '" . (int)$evento_id . "' ORDER BY order_id");
		
		return $query->rows;
		
	}

	public function getTotalSolicitudesTDC() {

		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "solicitudes_tdc` ORDER BY solicitud");
		
		return $query->row['total'];
		
	}

	public function getSolicitudesTDC() {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "solicitudes_tdc` ORDER BY solicitud");
		
		return $query->rows;
		
	}

	public function actualizaStatusSolicitudTDC($solicitud_id) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "solicitud` SET payment_method = 'Tarjeta de Cr&eacute;dito', payment_number = '" . (int)$solicitud_id . "_00', order_status_id = 0 WHERE order_id = '" . (int)$solicitud_id . "'");
			
	}
	
	public function corregirSolicitud($solicitud_id, $monto) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "solicitud` SET total = '" . $monto . "'  WHERE order_id = '" . (int)$solicitud_id . "'");
			
	}
	
	public function corregirSolicitudEvento($solicitud_id, $cantidad, $monto) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "solicitud_evento` SET quantity = '" . (int)$cantidad . "', total = '" . $monto . "'  WHERE order_id = '" . (int)$solicitud_id . "'");
			
	}
	
	public function corregirSolicitudTotal($solicitud_id, $monto, $monto_txt) {

		$query = $this->db->query("UPDATE `" . DB_PREFIX . "solicitud_total` SET text = '" . $monto_txt . "', value = '" . $monto . "'  WHERE order_id = '" . (int)$solicitud_id . "'");
			
	}
	
	public function getSolicitudOpcionByCedula($cedula, $evento_id) {

		$query = $this->db->query("SELECT so.order_id, so.order_product_id FROM `" . DB_PREFIX . "solicitud_opcion_" . (int)$evento_id . "` so WHERE so.value = '" . $cedula . "' AND so.order_id IN (SELECT s.order_id FROM `" . DB_PREFIX . "solicitud` s LEFT JOIN `" . DB_PREFIX . "solicitud_evento` se ON (s.order_id = se.order_id) WHERE s.order_status_id > 0 AND se.product_id = '" . (int)$evento_id . "') ORDER BY so.order_id DESC LIMIT 1");
		
		if ($query->num_rows) {
			return array(
				'order_id'          => $query->row['order_id'],
				'order_product_id'	=> $query->row['order_product_id'],
			);
		} else {
			return false;	
		}
		
	}

	public function getFechaSolicitud($order_id) {

		$query = $this->db->query("SELECT payment_date FROM `" . DB_PREFIX . "solicitud` WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->row['payment_date'];
		
	}

}
?>
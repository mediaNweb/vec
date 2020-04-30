<?php
class ModelImportParticipantes extends Model {	

	public function getDatos($tabla) {

		$query_import = $this->db->query("SELECT pt.*, p.* FROM " . DB_PREFIX . $tabla . " pt LEFT JOIN " . DB_PREFIX . "personas p ON (pt.cedula = p.cedula) ORDER BY pt.id_participante");
		
		return $query_import->rows;

	}
	
	public function getEstadoByCodigoOld($codigo_estado) {

		$query_import = $this->db->query("SELECT provincia FROM " . DB_PREFIX . "estados_old WHERE id_provincia = " . $codigo_estado);
		
		return $query_import->row['provincia'];

	}

	public function getPaisByCodigoOld($codigo_pais) {

		$query_import = $this->db->query("SELECT pais FROM " . DB_PREFIX . "paises_old WHERE id_pais = " . $codigo_pais);
		
		return $query_import->row['pais'];

	}

	public function getEstadoCodigoNewByOld($estado) {

		$query_import = $this->db->query("SELECT estados_id FROM " . DB_PREFIX . "estados WHERE estados_nombre = '" . $estado . "'");
		
		return $query_import->row['estados_id'];

	}

	public function getPaisCodigoNewByOld($pais) {

		$query_import = $this->db->query("SELECT paises_id FROM " . DB_PREFIX . "paises WHERE paises_nombre = '" . $pais . "'");
		
		return $query_import->row['paises_id'];

	}

	public function getDatosParticipante($tabla, $cedula) {

		$query_import = $this->db->query("SELECT p.cedula AS `Cédula`, p.apellido AS `Apellido`, p.nombre AS `Nombre`, LEFT(p.sexo, 1) AS `Género`, p.nacimiento AS `Fecha de Nacimiento`, p.mail AS `Correo Electrónico`, p.celular AS `Celular`, p.pas AS `País`, p.estado AS `Estado`, pt.edad AS `Edad`, pt.categoria AS `Categoría`, pt.nacionalidad AS `Nacionalidad`, p.twitter AS `Twitter` FROM " . DB_PREFIX . $tabla . " pt LEFT JOIN " . DB_PREFIX . "personas p ON (pt.cedula = p.cedula) WHERE pt.cedula = '" . $cedula . "'");
		
		return $query_import->rows;

	}

	function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extensiones WHERE `extension_tipo` = '" . $this->db->escape($type) . "'");

		return $query->rows;
	}

	public function getTotalTotal(&$total_data, &$total, &$impuestos) {
		$this->load->idioma('total/total');
	 
		$total_data[] = array(
			'code'       => 'total',
			'title'      => $this->idioma->get('text_total'),
			'text'       => $this->moneda->format(max(0, $total)),
			'value'      => max(0, $total),
			'sort_order' => $this->config->get('total_sort_order')
		);
	}

	public function getTotalSubTotal(&$total_data, &$total, &$impuestos) {
		$this->load->idioma('total/sub_total');
		
		$sub_total = $this->solicitud->getSubTotal();
		
		$total_data[] = array( 
			'code'       => 'sub_total',
			'title'      => 'Sub-Total',
			'text'       => $this->moneda->format($sub_total),
			'value'      => $sub_total,
			'sort_order' => $this->config->get('sub_total_sort_order')
		);
		
		$total += $sub_total;
	}

	public function getTotalImpuesto(&$total_data, &$total, &$impuestos) {
		foreach ($impuestos as $key => $value) {
			if ($value > 0) {
				$impuesto_classes = $this->impuesto->getDescription($key);
				
				foreach ($impuesto_classes as $impuesto_class) {
					$rate = $this->impuesto->getRate($key);
					
					$impuesto = $value * ($impuesto_class['impuestos_tasa'] / $rate);
					
					$total_data[] = array(
						'code'       => 'impuesto',
						'title'      => $impuesto_class['impuestos_tasa_descripcion'], 
						'text'       => $this->moneda->format($impuesto),
						'value'      => $impuesto,
						'sort_order' => $this->config->get('impuesto_sort_order')
					);
		
					$total += $impuesto;
				}
			}
		}
	}

	public function create($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "solicitud` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();

		foreach ($data['products'] as $product) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_evento SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "'");
 
			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_opcion SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}
		}
		
		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "solicitud_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', text = '" . $this->db->escape($total['text']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}	

		return $order_id;
	}
}
?>
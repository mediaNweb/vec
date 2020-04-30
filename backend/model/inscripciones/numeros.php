<?php
    class ModelInscripcionesNumeros extends Model {	
	
		public function getTipoNumeracion($eventos_id) {
			$query = $this->db->query("SELECT eventos_descripcion_numeracion_id_tipo AS numeracion FROM " . DB_PREFIX . "eventos_descripcion WHERE eventos_descripcion_id_evento = '" . (int)$eventos_id . "'");
	
			return $query->row['numeracion'];
			
		}

        public function getNumero($eventos_id, $clientes_id, $categoria, $tiempo = '', $grupo){

			$evento_numeracion = $this->getTipoNumeracion($eventos_id);
			
            /* We search for a participation number to assign */
            switch($evento_numeracion){
                case '0': // Ninguna
                    $numero = '0';
                    break;

                case '1': // Grupos
                    $query_grupos = $this->db->query("SELECT eventos_numeros_numero FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND eventos_numeros_reservados = 'N' AND eventos_numeros_id_cliente = '' AND eventos_numeros_grupo = '" . $grupo . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");
                    $numero = $query_grupos->row['eventos_numeros_numero'];
                    break;

                case '2': // Estandar
                    $query_estandar = $this->db->query("SELECT eventos_numeros_numero FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND eventos_numeros_reservados = 'N' AND eventos_numeros_id_cliente = '' ORDER BY eventos_numeros_numero ASC LIMIT 1");

                    $numero = $query_estandar->row['eventos_numeros_numero'];
                    break;

                case '3': // Tiempos
                    $query_tiempos = $this->db->query("SELECT eventos_numeros_numero FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND eventos_numeros_reservados = 'N' AND eventos_numeros_id_cliente = '' AND eventos_numeros_th >= '" . $tiempo . "' AND eventos_numeros_td <= '" . $tiempo . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");

					if ($query_tiempos->num_rows) {

						$numero = $query_tiempos->row['eventos_numeros_numero'];
						break;
						
					} else {
						
						$query_tiempos_sup = $this->db->query("SELECT eventos_numeros_numero FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND eventos_numeros_reservados = 'N' AND eventos_numeros_id_cliente = '' AND eventos_numeros_th >= '" . $tiempo . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");
					
						if ($query_tiempos_sup->num_rows) {
	
							$numero = $query_tiempos_sup->row['eventos_numeros_numero'];
							break;
							
						} else {
							
							$query_tiempos_inf = $this->db->query("SELECT eventos_numeros_numero FROM eventos_numeros WHERE eventos_numeros_id_evento = '" . (int)$eventos_id . "' AND eventos_numeros_reservados = 'N' AND eventos_numeros_id_cliente = '' AND eventos_numeros_td <= '" . $tiempo . "' ORDER BY eventos_numeros_numero ASC LIMIT 1");
						
							if ($query_tiempos_inf->num_rows) {
		
								$numero = $query_tiempos_inf->row['eventos_numeros_numero'];
								break;
								
							}

						}

					}
/*
                    $rs_num1 = $sql->doquery("SELECT * FROM numeros WHERE eventos_ido = '$event->eventos_ido' AND reservado = 'N' AND cedula = '' AND tiempos_desde >= '$search_from' ORDER BY tiempos_desde ASC, numero ASC LIMIT 1");
                    $numero = $sql->fetch($rs_num1);
                    break;
*/
            }

            return $numero;
        }

        /*			
        // Send out order confirmation mail
        $idioma = new Idioma($participante_info['language_directory']);
        $idioma->load($participante_info['language_filename']);
        $idioma->load('mail/eventos_participantes');

        $participante_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_status WHERE order_status_id = '" . (int)$participante_status_id . "' AND language_id = '" . (int)$participante_info['language_id'] . "'");

        if ($participante_status_query->num_rows) {
        $participante_status = $participante_status_query->row['name'];	
        } else {
        $participante_status = '';
        }

        $participante_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_evento WHERE order_id = '" . (int)$eventos_id . "'");
        $participante_total_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_total WHERE order_id = '" . (int)$eventos_id . "' ORDER BY sort_order ASC");
        $participante_download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_descarga WHERE order_id = '" . (int)$eventos_id . "'");

        $subject = sprintf($idioma->get('text_new_subject'), $participante_info['store_name'], $eventos_id);

        // HTML Mail
        $template = new Template();

        $template->data['title'] = sprintf($idioma->get('text_new_subject'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'), $eventos_id);

        $template->data['text_greeting'] = sprintf($idioma->get('text_new_greeting'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8'));
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
        $template->data['store_name'] = $participante_info['store_name'];
        $template->data['store_url'] = $participante_info['store_url'];
        $template->data['customer_id'] = $participante_info['customer_id'];
        $template->data['link'] = $participante_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $eventos_id;

        if ($participante_download_query->num_rows) {
        $template->data['download'] = $participante_info['store_url'] . 'index.php?route=account/download';
        } else {
        $template->data['download'] = '';
        }

        $template->data['invoice_no'] = $invoice_no;
        $template->data['order_id'] = $eventos_id;
        $template->data['date_added'] = date($idioma->get('date_format_short'), strtotime($participante_info['date_added']));    	
        $template->data['payment_method'] = $participante_info['payment_method'];
        $template->data['shipping_method'] = $participante_info['shipping_method'];
        $template->data['email'] = $participante_info['email'];
        $template->data['telephone'] = $participante_info['telephone'];
        $template->data['ip'] = $participante_info['ip'];

        if ($participante_info['shipping_address_format']) {
        $format = $participante_info['shipping_address_format'];
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
        'firstname' => $participante_info['shipping_firstname'],
        'lastname'  => $participante_info['shipping_lastname'],
        'company'   => $participante_info['shipping_company'],
        'address_1' => $participante_info['shipping_address_1'],
        'address_2' => $participante_info['shipping_address_2'],
        'city'      => $participante_info['shipping_city'],
        'postcode'  => $participante_info['shipping_postcode'],
        'zone'      => $participante_info['shipping_zone'],
        'zone_code' => $participante_info['shipping_zone_code'],
        'country'   => $participante_info['shipping_country']  
        );

        $template->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

        if ($participante_info['payment_address_format']) {
        $format = $participante_info['payment_address_format'];
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
        'firstname' => $participante_info['payment_firstname'],
        'lastname'  => $participante_info['payment_lastname'],
        'company'   => $participante_info['payment_company'],
        'address_1' => $participante_info['payment_address_1'],
        'address_2' => $participante_info['payment_address_2'],
        'city'      => $participante_info['payment_city'],
        'postcode'  => $participante_info['payment_postcode'],
        'zone'      => $participante_info['payment_zone'],
        'zone_code' => $participante_info['payment_zone_code'],
        'country'   => $participante_info['payment_country']  
        );

        $template->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

        $template->data['products'] = array();

        foreach ($participante_product_query->rows as $product) {
        $option_data = array();

        $participante_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion WHERE order_id = '" . (int)$eventos_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

        foreach ($participante_option_query->rows as $option) {
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
        'price'    => $this->moneda->format($product['price'], $participante_info['currency_code'], $participante_info['currency_value']),
        'total'    => $this->moneda->format($product['total'], $participante_info['currency_code'], $participante_info['currency_value'])
        );
        }

        $template->data['totals'] = $participante_total_query->rows;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/eventos_participantes.tpl')) {
        $html = $template->fetch($this->config->get('config_template') . '/template/mail/eventos_participantes.tpl');
        } else {
        $html = $template->fetch('mail/eventos_participantes.php');
        }

        // Text Mail
        $text  = sprintf($idioma->get('text_new_greeting'), html_entity_decode($participante_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
        $text .= $idioma->get('text_new_order_id') . ' ' . $eventos_id . "\n";
        $text .= $idioma->get('text_new_date_added') . ' ' . date($idioma->get('date_format_short'), strtotime($participante_info['date_added'])) . "\n";
        $text .= $idioma->get('text_new_order_status') . ' ' . $participante_status . "\n\n";
        $text .= $idioma->get('text_new_products') . "\n";

        foreach ($participante_product_query->rows as $result) {
        $text .= $result['quantity'] . 'x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->moneda->format($result['total'], $participante_info['currency_code'], $participante_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

        $participante_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion WHERE order_id = '" . (int)$eventos_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");

        foreach ($participante_option_query->rows as $option) {
        $text .= chr(9) . '-' . $option['name'] . ' ' . (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
        }
        }

        $text .= "\n";

        $text .= $idioma->get('text_new_order_total') . "\n";

        foreach ($participante_total_query->rows as $result) {
        $text .= $result['title'] . ' ' . html_entity_decode($result['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
        }			

        $participante_total = $result['text'];

        $text .= "\n";

        if ($participante_info['customer_id']) {
        $text .= $idioma->get('text_new_link') . "\n";
        $text .= $participante_info['store_url'] . 'index.php?route=account/invoice&order_id=' . $eventos_id . "\n\n";
        }

        if ($participante_download_query->num_rows) {
        $text .= $idioma->get('text_new_download') . "\n";
        $text .= $participante_info['store_url'] . 'index.php?route=account/download' . "\n\n";
        }

        if ($participante_info['comment']) {
        $text .= $idioma->get('text_new_comment') . "\n\n";
        $text .= $participante_info['comment'] . "\n\n";
        }

        $text .= $idioma->get('text_new_footer') . "\n\n";

        $mail = new Mail(); 
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');			
        $mail->setTo($participante_info['email']);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($participante_info['store_name']);
        $mail->setSubject($subject);
        $mail->setHtml($html);
        $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
        $mail->addAttachment(DIR_IMAGE . $this->config->get('config_logo'), md5(basename($this->config->get('config_logo'))));
        $mail->send();

        // Admin Alert Mail
        if ($this->config->get('config_alert_mail')) {
        $subject = sprintf($idioma->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $eventos_id);

        // Text 
        $text  = $idioma->get('text_new_received') . "\n\n";
        $text .= $idioma->get('text_new_order_id') . ' ' . $eventos_id . "\n";
        $text .= $idioma->get('text_new_date_added') . ' ' . date($idioma->get('date_format_short'), strtotime($participante_info['date_added'])) . "\n";
        $text .= $idioma->get('text_new_order_status') . ' ' . $participante_status . "\n\n";
        $text .= $idioma->get('text_new_products') . "\n";

        foreach ($participante_product_query->rows as $result) {
        $text .= $result['quantity'] . 'x ' . $result['name'] . ' (' . $result['model'] . ') ' . html_entity_decode($this->moneda->format($result['total'], $participante_info['currency_code'], $participante_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";

        $participante_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "solicitud_opcion WHERE order_id = '" . (int)$eventos_id . "' AND order_product_id = '" . $result['order_product_id'] . "'");

        foreach ($participante_option_query->rows as $option) {
        $text .= chr(9) . '-' . $option['name'] . (strlen($option['value']) > 20 ? substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
        }
        }

        $text .= "\n";

        $text.= $idioma->get('text_new_order_total') . "\n";

        foreach ($participante_total_query->rows as $result) {
        $text .= $result['title'] . ' ' . html_entity_decode($result['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
        }			

        $text .= "\n";

        if ($participante_info['comment'] != '') {
        $comment = ($participante_info['comment'] .  "\n\n" . $comment);
        }

        if ($comment) {
        $text .= $idioma->get('text_new_comment') . "\n\n";
        $text .= $comment . "\n\n";
        }

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
        $mail->setSender($participante_info['store_name']);
        $mail->setSubject($subject);
        $mail->setText($text);
        $mail->send();

        // Send to additional alert emails
        $emails = explode(',', $this->config->get('config_alert_emails'));

        foreach ($emails as $email) {
        if ($email && preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $email)) {
        $mail->setTo($email);
        $mail->send();
        }
        }				

        */

    }
?>
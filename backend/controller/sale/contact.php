<?php 
class ControllerSaleContact extends Controller {
	private $error = array();
	 
	public function index() {
		$this->load->idioma('sale/contact');
 
		$this->document->setTitle($this->idioma->get('heading_title'));
		
		$this->load->model('sale/cliente');
		
		$this->load->model('sale/cliente_group');
		
		$this->load->model('sale/affiliate');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/store');
		
			$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);			
			
			if ($store_info) {
				$store_name = $store_info['name'];
			} else {
				$store_name = $this->config->get('config_name');
			}
			
			$emails = array();
			
			switch ($this->request->post['to']) {
				case 'newsletter':
					$results = $this->model_sale_cliente->getClientesByNewsletter();
				
					foreach ($results as $result) {
						$emails[] = $result['email'];
					}
					break;
				case 'cliente_all':
					$results = $this->model_sale_cliente->getClientes();
			
					foreach ($results as $result) {
						$emails[] = $result['email'];
					}						
					break;
				case 'cliente_group':
					$results = $this->model_sale_cliente->getClientesByClienteGroupId($this->request->post['cliente_group_id']);
			
					foreach ($results as $result) {
						$emails[$result['cliente_id']] = $result['email'];
					}						
					break;
				case 'cliente':
					if (isset($this->request->post['cliente'])) {					
						foreach ($this->request->post['cliente'] as $cliente_id) {
							$cliente_info = $this->model_sale_cliente->getCliente($cliente_id);
							
							if ($cliente_info) {
								$emails[] = $cliente_info['email'];
							}
						}
					}
					break;	
				case 'affiliate_all':
					$results = $this->model_sale_affiliate->getAffiliates();
			
					foreach ($results as $result) {
						$emails[] = $result['email'];
					}						
					break;	
				case 'affiliate':
					if (isset($this->request->post['affiliate'])) {					
						foreach ($this->request->post['affiliate'] as $affiliate_id) {
							$affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);
							
							if ($affiliate_info) {
								$emails[] = $affiliate_info['email'];
							}
						}
					}
					break;											
				case 'product':
					if (isset($this->request->post['product'])) {
						foreach ($this->request->post['product'] as $product_id) {
							$results = $this->model_sale_cliente->getClientesByProduct($product_id);
							
							foreach ($results as $result) {
								$emails[] = $result['email'];
							}
						}
					}
					break;												
			}
			
			$emails = array_unique($emails);
			
			if ($emails) {
				$message  = '<html dir="ltr" lang="en">' . "\n";
				$message .= '<head>' . "\n";
				$message .= '<title>' . $this->request->post['subject'] . '</title>' . "\n";
				$message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
				$message .= '</head>' . "\n";
				$message .= '<body>' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
				$message .= '</html>' . "\n";

				$attachments = array();

				if (preg_match_all('#(src="([^"]*)")#mis', $message, $matches)) {
					foreach ($matches[2] as $key => $value) {
						$filename = md5(basename($value)) . strrchr($value, '.');
						$path = rtrim($this->request->server['DOCUMENT_ROOT'], '/') . parse_url($value, PHP_URL_PATH);
						
						$attachments[] = array(
							'filename' => $filename,
							'path'     => $path
						);
						
						$message = str_replace($value, 'cid:' . $filename, $message);
					}
				}	
				
				foreach ($emails as $email) {

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
					$mail = $m3px->mail($this->request->post['subject'], $message, '', $email, '', $this->config->get('config_email'), $store_name);

/*
					$mail = new Mail();	
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->hostname = $this->config->get('config_smtp_host');
					$mail->username = $this->config->get('config_smtp_username');
					$mail->password = $this->config->get('config_smtp_password');
					$mail->port = $this->config->get('config_smtp_port');
					$mail->timeout = $this->config->get('config_smtp_timeout');				
					$mail->setTo($email);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($store_name);
					$mail->setSubject($this->request->post['subject']);					
					
					foreach ($attachments as $attachment) {
						$mail->addAttachment($attachment['path'], $attachment['filename']);
					}
					
					$mail->setHtml($message);
					$mail->send();
*/
				}
			}
			
			$this->session->data['success'] = $this->idioma->get('text_success');
		}

		$this->data['heading_title'] = $this->idioma->get('heading_title');
		
		$this->data['text_default'] = ' <b>(Predeterminado)</b>';
		$this->data['text_newsletter'] = $this->idioma->get('text_newsletter');
		$this->data['text_cliente_all'] = $this->idioma->get('text_cliente_all');	
		$this->data['text_cliente'] = $this->idioma->get('text_cliente');	
		$this->data['text_cliente_group'] = $this->idioma->get('text_cliente_group');
		$this->data['text_affiliate_all'] = $this->idioma->get('text_affiliate_all');	
		$this->data['text_affiliate'] = $this->idioma->get('text_affiliate');	
		$this->data['text_product'] = $this->idioma->get('text_product');	

		$this->data['entry_store'] = $this->idioma->get('entry_store');
		$this->data['entry_to'] = $this->idioma->get('entry_to');
		$this->data['entry_cliente_group'] = $this->idioma->get('entry_cliente_group');
		$this->data['entry_cliente'] = $this->idioma->get('entry_cliente');
		$this->data['entry_affiliate'] = $this->idioma->get('entry_affiliate');
		$this->data['entry_product'] = $this->idioma->get('entry_product');
		$this->data['entry_subject'] = $this->idioma->get('entry_subject');
		$this->data['entry_message'] = $this->idioma->get('entry_message');
		
		$this->data['button_send'] = $this->idioma->get('button_send');
		$this->data['button_cancel'] = 'Cancelar';
		
		$this->data['tab_general'] = 'General';
		
		$this->data['token'] = $this->session->data['token'];
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['subject'])) {
			$this->data['error_subject'] = $this->error['subject'];
		} else {
			$this->data['error_subject'] = '';
		}
	 	
		if (isset($this->error['message'])) {
			$this->data['error_message'] = $this->error['message'];
		} else {
			$this->data['error_message'] = '';
		}	

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->idioma->get('heading_title'),
			'href'      => $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
				
		$this->data['action'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
    	$this->data['cancel'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['store_id'])) {
			$this->data['store_id'] = $this->request->post['store_id'];
		} else {
			$this->data['store_id'] = '';
		}
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['to'])) {
			$this->data['to'] = $this->request->post['to'];
		} else {
			$this->data['to'] = '';
		}
				
		if (isset($this->request->post['cliente_group_id'])) {
			$this->data['cliente_group_id'] = $this->request->post['cliente_group_id'];
		} else {
			$this->data['cliente_group_id'] = '';
		}
				
		$this->data['cliente_groups'] = $this->model_sale_cliente_group->getClienteGroups(0);
				
		$this->data['clientes'] = array();
		
		if (isset($this->request->post['cliente'])) {					
			foreach ($this->request->post['cliente'] as $cliente_id) {
				$cliente_info = $this->model_sale_cliente->getCliente($cliente_id);
					
				if ($cliente_info) {
					$this->data['clientes'][] = array(
						'cliente_id' => $cliente_info['cliente_id'],
						'name'        => $cliente_info['firstname'] . ' ' . $cliente_info['lastname']
					);
				}
			}
		}

		$this->data['affiliates'] = array();
		
		if (isset($this->request->post['affiliate'])) {					
			foreach ($this->request->post['affiliate'] as $affiliate_id) {
				$affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);
					
				if ($affiliate_info) {
					$this->data['affiliates'][] = array(
						'affiliate_id' => $affiliate_info['affiliate_id'],
						'name'         => $affiliate_info['firstname'] . ' ' . $affiliate_info['lastname']
					);
				}
			}
		}
		
		$this->load->model('catalog/evento');

		$this->data['products'] = array();
		
		if (isset($this->request->post['product'])) {					
			foreach ($this->request->post['product'] as $product_id) {
				$product_info = $this->model_catalog_evento->getProduct($product_id);
					
				if ($product_info) {
					$this->data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
		}
				
		if (isset($this->request->post['subject'])) {
			$this->data['subject'] = $this->request->post['subject'];
		} else {
			$this->data['subject'] = '';
		}
		
		if (isset($this->request->post['message'])) {
			$this->data['message'] = $this->request->post['message'];
		} else {
			$this->data['message'] = '';
		}

		$this->template = 'sale/contact.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'sale/contact')) {
			$this->error['warning'] = $this->idioma->get('error_permission');
		}
				
		if (!$this->request->post['subject']) {
			$this->error['subject'] = $this->idioma->get('error_subject');
		}

		if (!$this->request->post['message']) {
			$this->error['message'] = $this->idioma->get('error_message');
		}
						
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
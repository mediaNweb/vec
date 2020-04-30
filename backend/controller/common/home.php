<?php   
class ControllerCommonHome extends Controller {   
	public function index() {

		$this->document->setTitle('Huis');
		
    	$this->data['heading_title'] = 'Huis';
		
		$this->data['text_overview'] = 'Algemeen';
		$this->data['text_statistics'] = 'Estad&iacute;sticas';
		$this->data['text_latest_10_orders'] = '&Uacute;ltimas 10 Inscripciones';
		$this->data['text_total_sale'] = 'Total Ventas:';
		$this->data['text_total_sale_year'] = 'Total Ventas Este A&ntilde;o:';
		$this->data['text_total_order'] = 'Total Inscripciones:';
		$this->data['text_total_cliente'] = 'No. de Clientes:';
		$this->data['text_total_cliente_approval'] = 'Clientes Awaiting Approval:';
		$this->data['text_total_review_approval'] = 'Reviews Awaiting Approval:';
		$this->data['text_total_affiliate'] = 'No. of Affiliates:';
		$this->data['text_total_affiliate_approval'] = 'Affiliates Awaiting Approval:';
		$this->data['text_day'] = 'Hoy';
		$this->data['text_week'] = 'Esta Semana';
		$this->data['text_month'] = 'Este Mes';
		$this->data['text_year'] = 'Este A&ntilde;o';
		$this->data['text_no_results'] = 'Sin resultados';

		$this->data['column_order'] = 'Orden ID';
		$this->data['column_cliente'] = 'Cliente';
		$this->data['column_status'] = 'Status';
		$this->data['column_date_added'] = 'Fecha de Creaci&oacute;n';
		$this->data['column_total'] = 'Total';
		$this->data['column_firstname'] = 'Nombre';
		$this->data['column_lastname'] = 'Apellido';
		$this->data['column_action'] = 'Acci&oacute;n';
		
		$this->data['entry_range'] = 'Seleccione Rango:';
		
		// Check install directory exists
 		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->data['error_install'] = 'Advertencia: ¡La carpeta de instalaci&oacute;n no ha sido eliminada!';
		} else {
			$this->data['error_install'] = '';
		}

		// Check image directory is writable
		$file = DIR_IMAGE . 'test';
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, '');
			
		fclose($handle); 		
		
		if (!file_exists($file)) {
			$this->data['error_image'] = sprintf('Advertencia: ¡La carpeta de imagenes %s no tiene permisos de escritura!'. DIR_IMAGE);
		} else {
			$this->data['error_image'] = '';
			
			unlink($file);
		}
		
		// Check image cache directory is writable
		$file = DIR_IMAGE . 'cache/test';
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, '');
			
		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_image_cache'] = sprintf('Advertencia: ¡La carpeta de cache %s no tiene permisos de escritura!'. DIR_IMAGE . 'cache/');
		} else {
			$this->data['error_image_cache'] = '';
			
			unlink($file);
		}
		
		// Check cache directory is writable
		$file = DIR_CACHE . 'test';
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, '');
			
		fclose($handle); 		
		
		if (!file_exists($file)) {
			$this->data['error_cache'] = sprintf('Advertencia: ¡La carpeta de cache %s no tiene permisos de escritura!'. DIR_CACHE);
		} else {
			$this->data['error_cache'] = '';
			
			unlink($file);
		}
		
		// Check logs directory is writable
		$file = DIR_LOGS . 'test';
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, '');
			
		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['errorlogs'] = sprintf('Advertencia: ¡La carpeta de registros de errores %s no tiene permisos de escritura!'. DIR_LOGS);
		} else {
			$this->data['error_logs'] = '';
			
			unlink($file);
		}
										
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Huis',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

		$this->data['token'] = $this->session->data['token'];
		
/*
		$this->load->model('sale/order');

		$this->data['total_sale'] = $this->model_sale_order->getTotalSales();
		$this->data['total_sale_year'] = $this->model_sale_order->getTotalSalesByYear(date('Y'));
		$this->data['total_order'] = $this->model_sale_order->getTotalOrders();
		
		$this->load->model('sale/cliente');
		
		$this->data['total_cliente'] = $this->model_sale_cliente->getTotalClientes();
		
		$this->data['orders'] = array(); 
		
		$data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);
		
		$results = $this->model_sale_order->getOrders($data);
    	
    	foreach ($results as $result) {
			$action = array();
			 
			$action[] = array(
				'text' => 'Ver',
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);
					
			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'cliente'    => $result['cliente'],
				'status'     => $result['status'],
				'date_added' => date('d/m/Y', strtotime($result['date_added'])),
				'total'      => $result['total'],
				'action'     => $action
			);
		}
*/

		$this->template = 'common/home.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
  	}
	
	public function chart() {
		
		$data = array();
		
		$data['order'] = array();
		$data['cliente'] = array();
		$data['xaxis'] = array();
		
		$data['order']['label'] = 'Total Insripciones';
		$data['cliente']['label'] = 'Total Clientes';
		
		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}
		
		switch ($range) {
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "solicitud` WHERE order_status_id > '0' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");
					
					if ($query->num_rows) {
						$data['order']['data'][]  = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][]  = array($i, 0);
					}
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes WHERE DATE(clientes_fdc) = DATE(NOW()) AND HOUR(clientes_fdc) = '" . (int)$i . "' GROUP BY HOUR(clientes_fdc) ORDER BY clientes_fdc ASC");
					
					if ($query->num_rows) {
						$data['cliente']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cliente']['data'][] = array($i, 0);
					}
			
					$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days'); 
				
				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "solicitud` WHERE order_status_id > '0' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");
			
					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}
				
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "clientes` WHERE DATE(clientes_fdc) = '" . $this->db->escape($date) . "' GROUP BY DATE(clientes_fdc)");
			
					if ($query->num_rows) {
						$data['cliente']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cliente']['data'][] = array($i, 0);
					}
		
					$data['xaxis'][] = array($i, date('D', strtotime($date)));
				}
				
				break;
			default:
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "solicitud` WHERE order_status_id > '0' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");
					
					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}	
				
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes WHERE DATE(clientes_fdc) = '" . $this->db->escape($date) . "' GROUP BY DAY(clientes_fdc)");
			
					if ($query->num_rows) {
						$data['cliente']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cliente']['data'][] = array($i, 0);
					}	
					
					$data['xaxis'][] = array($i, date('j', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "solicitud` WHERE order_status_id > '0' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
					
					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes WHERE YEAR(clientes_fdc) = '" . date('Y') . "' AND MONTH(clientes_fdc) = '" . $i . "' GROUP BY MONTH(clientes_fdc)");
					
					if ($query->num_rows) { 
						$data['cliente']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['cliente']['data'][] = array($i, 0);
					}
					
					$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
		} 
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($data));
	}
	
	public function login() {
		$route = '';
		
		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);
			
			if (isset($part[0])) {
				$route .= $part[0];
			}
			
			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
		}
		
		$ignore = array(
			'common/login',
			'common/forgotten',
			'common/reset'
		);	
					
		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
			return $this->forward('common/login');
		}
		
		if (isset($this->request->get['route'])) {
			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission'
			);
						
			$config_ignore = array();
			
			if ($this->config->get('config_token_ignore')) {
				$config_ignore = unserialize($this->config->get('config_token_ignore'));
			}
				
			$ignore = array_merge($ignore, $config_ignore);
						
			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
				return $this->forward('common/login');
			}
		} else {
			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
				return $this->forward('common/login');
			}
		}
	}
	
	public function permission() {
		if (isset($this->request->get['route'])) {
			$route = '';
			
			$part = explode('/', $this->request->get['route']);
			
			if (isset($part[0])) {
				$route .= $part[0];
			}
			
			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
			
			$ignore = array(
				'common/home',
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission'		
			);			
						
			if (!in_array($route, $ignore) && !$this->user->hasPermission('access', $route)) {
				return $this->forward('error/permission');
			}
		}
	}	
}
?>
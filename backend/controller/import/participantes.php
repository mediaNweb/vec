<?php
class ControllerImportParticipantes extends Controller {   
	private $error = array();
	
	public function index() {		

		$this->document->setTitle('Importar Datos');
		
		$this->data['heading_title'] = 'Importar Datos';
		 
		$this->data['button_import'] = 'Importar';
		
		$this->data['tab_general'] = 'General';

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Inicio',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Importar Datos',
			'href'      => $this->url->link('import/participantes', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['import'] = $this->url->link('import/participantes/import', 'token=' . $this->session->data['token'], 'SSL');

		$tabla = 'participantes_csq';
		
		$this->load->model('import/participantes');
		
		$datos_import = $this->model_import_participantes->getDatos($tabla);
		
		$this->data['datos_importados'] = $this->array2table($datos_import, true, true);

		$this->template = 'import/participantes.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());

	}


	public function import() {		

		$this->load->model('import/participantes');

		$tabla = 'participantes_csq';
		
		$datos_import = $this->model_import_participantes->getDatos($tabla);

		foreach ($datos_import as $dato_importado) {
			
			$data = array();
			
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
			
			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTP_SERVER;	
			}
			
			$data['customer_id'] = $dato_importado['cedula'];
			$data['firstname'] = $dato_importado['nombre'];
			$data['lastname'] = $dato_importado['apellido'];
			$data['email'] = $dato_importado['mail'];
			$data['telephone'] = $dato_importado['cedula'];
			
			$data['payment_firstname'] = $dato_importado['nombre'];
			$data['payment_lastname'] = $dato_importado['apellido'];
			$data['payment_company'] = '';
			$data['payment_address_1'] = $dato_importado['direccion'];
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_zone'] = $this->model_import_participantes->getEstadoByCodigoOld($dato_importado['estado']);
			$data['payment_zone_id'] = $this->model_import_participantes->getEstadoCodigoNewByOld($this->model_import_participantes->getEstadoByCodigoOld($dato_importado['estado']));
			$data['payment_country'] = $this->model_import_participantes->getPaisByCodigoOld($dato_importado['pais']);
			$data['payment_country_id'] = $this->model_import_participantes->getPaisCodigoNewByOld($this->model_import_participantes->getPaisByCodigoOld($dato_importado['pais']));
			$data['payment_address_format'] = '';
		
			$data['payment_method'] = 'Dep&amp;oacute;sito / Transferencia';
			
			$this->impuesto->setZone($this->model_import_participantes->getPaisCodigoNewByOld($this->model_import_participantes->getPaisByCodigoOld($dato_importado['pais'])), $this->model_import_participantes->getEstadoCodigoNewByOld($this->model_import_participantes->getEstadoByCodigoOld($dato_importado['estado'])));
			
			$tabla = 'participantes_csq';

			$datos_inscripcion = $this->model_import_participantes->getDatosParticipante($tabla, $dato_importado['cedula']);

			$option_data = '12:' . base64_encode(serialize($datos_inscripcion));
			
			$product_data = array();

			$product_data[] = array(
				'product_id' => 12,
				'name'       => '1era. Carrera 10k Seguros Qualitas',
				'option'     => $option_data,
				'datos'      => $datos_inscripcion,
				'quantity'   => 1,
				'subtract'   => 1,
				'price'      => '200.00',
				'total'      => '200.00',
				'tax'        => 0
			); 
			
			$total_data = array();
			$total = 0;
			$taxes = $this->solicitud->getImpuestos(true, 'bank_transfer');
	
			if ($this->session->data['payment_method']['code'] == 'bank_transfer') {
				if (isset($taxes[1])) {
					unset($taxes[1]);	
				}
			}
			 
			$this->load->model('import/participantes');
//			$this->load->model('setting/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_import_participantes->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['extension_codigo'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['extension_codigo'] . '_status')) {
					$this->load->model('import/participantes');
//					$this->load->model('total/' . $result['extension_codigo']);
		
					$this->{model_import_participantes}->getTotal . $result['extension_codigo']($total_data, $total, $taxes);
				}
			}
			
			$sort_order = array(); 
		  
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $total_data);
						
			$data['products'] = $product_data;
			$data['totals'] = $total_data;
			$data['comment'] = '';
			$data['total'] = $total;
			
			$data['affiliate_id'] = 0;
			$data['commission'] = 0;
			
			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->moneda->getId();
			$data['currency_code'] = $this->moneda->getCode();
			$data['currency_value'] = $this->moneda->getValue($this->moneda->getCode());
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			$this->load->model('import/participantes');
//			$this->load->model('inscripciones/solicitud');
			
			$this->session->data['order_id'] = $this->model_import_participantes->create($data);
	
			$this->load->model('import/participantes');
//			$this->load->model('inscripciones/participantes');
	
			$this->model_import_participantes->create($this->session->data['order_id'],  $data, 'Internet');
	
		}

  	}

	public function array2table($array, $recursive = false, $return = false, $null = '&nbsp;'){
		// Sanity check
		if(empty($array) || !is_array($array)){ return false; }
		if(!isset($array[0]) || !is_array($array[0])){ $array = array($array); }
	 
		// Start the table
		$table = "<table>\n";
		// The header
		$table .= "\t<tr>";
		// Take the keys from the first row as the headings
		foreach (array_keys($array[0]) as $heading) {
			$table .= '<th>' . $heading . '</th>';
		}
		$table .= "</tr>\n";
	 
		// The body
		foreach ($array as $row) {
			$table .= "\t<tr>" ;
			foreach ($row as $cell) {
				$table .= '<td>';
			   
				// Cast objects
				if (is_object($cell)) { $cell = (array) $cell; }
				if ($recursive === true && is_array($cell) && !empty($cell)) {
					// Recursive mode
					$table .= "\n" . array2table($cell, true, true) . "\n";
				} else {
					$table .= (strlen($cell)> 0) ?
						htmlspecialchars((string) $cell) :
						$null;
				}
				$table .= '</td>';
			}
			$table .= "</tr>\n";
		}
		// End the table
		$table .= '</table>';
		// Method of output
		if ($return === false) {
			echo $table;
		} else {
			return $table;
		}
	}
	
}
?>
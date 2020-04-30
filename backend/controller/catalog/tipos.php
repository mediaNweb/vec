<?php 
class ControllerCatalogTipos extends Controller { 
	private $error = array();
 
	public function index() {
		$this->document->setTitle('Types Event');
		
		$this->load->model('catalog/tipos');
		 
		$this->getList();
	}

	public function insert() {
		

		$this->document->setTitle('Types Event');
		
		$this->load->model('catalog/tipos');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tipos->addTipo($this->request->post);

			$this->session->data['success'] = 'Succes: U hebt de soorten gebeurtenissen veranderd!';
			
			$this->redirect($this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		

		$this->document->setTitle('Types Event');
		
		$this->load->model('catalog/tipos');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tipos->editTipo($this->request->get['eventos_tipos_id'], $this->request->post);
			
			$this->session->data['success'] = 'Succes: U hebt de soorten gebeurtenissen veranderd!';
			
			$this->redirect($this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		

		$this->document->setTitle('Types Event');
		
		$this->load->model('catalog/tipos');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $eventos_tipos_id) {
				$this->model_catalog_tipos->deleteTipo($eventos_tipos_id);
			}

			$this->session->data['success'] = 'Succes: U hebt de soorten gebeurtenissen veranderd!';

			$this->redirect($this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Huis',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Types Event',
			'href'      => $this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('catalog/tipos/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('catalog/tipos/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['tipos'] = array();
		
		$results = $this->model_catalog_tipos->getTipos();

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Uitgeven',
				'href' => $this->url->link('catalog/tipos/update', 'token=' . $this->session->data['token'] . '&eventos_tipos_id=' . $result['eventos_tipos_id'], 'SSL')
			);
					
			$this->data['tipos'][] = array(
				'eventos_tipos_id' 		=> $result['eventos_tipos_id'],
				'eventos_tipos_nombre'  => $result['eventos_tipos_nombre'],
				'eventos_tipos_orden'  	=> $result['eventos_tipos_orden'],
				'selected'    			=> isset($this->request->post['selected']) && in_array($result['eventos_tipos_id'], $this->request->post['selected']),
				'action'      			=> $action
			);
		}
		
		$this->data['heading_title'] = 'Types Event';

		$this->data['text_no_results'] = 'Geen Resultaat';

		$this->data['column_name'] = 'Naam Event Type';
		$this->data['column_sort_order'] = 'Bestellen';
		$this->data['column_action'] = 'Actie';

		$this->data['button_insert'] = 'Toevoegen';
		$this->data['button_delete'] = 'Verwijderen';
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->template = 'catalog/tipos_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = 'Types Event';

		$this->data['text_none'] = ' --- Geen --- ';
		$this->data['text_default'] = ' <b>(Standaard)</b>';
		$this->data['text_image_manager'] = 'Afbeelding Manager';
		$this->data['text_enabled'] = 'Enabled';
    	$this->data['text_disabled'] = 'Disabled';
		$this->data['text_percent'] = 'Percentage';
		$this->data['text_amount'] = 'Kwantiteit';
				
		$this->data['entry_name'] = 'Naam Event Type:';
		$this->data['entry_meta_keyword'] = 'Meta Tag Keywords:';
		$this->data['entry_meta_description'] = 'Meta Tag Beschrijving:';
		$this->data['entry_description'] = 'Beschrijving:';
		$this->data['entry_store'] = 'Winkel:';
		$this->data['entry_keyword'] = 'SEO Keyword:<br /><span class="help">Dit moet wereldwijd uniek zijn.</span>';
		$this->data['entry_parent'] = 'Hoofdcategorie:';
		$this->data['entry_image'] = 'Afbeelding:';
		$this->data['entry_top'] = 'Hoger:<br /><span class="help">Toon op de menubalk. Alleen werkt voor de top ouder categorieën.</span>';
		$this->data['entry_column'] = 'Columns:<br /><span class="help">Aantal kolommen te gebruiken voor de onderste 3 categorieën. Alleen werkt voor de top ouder categorieën.</span>';		
		$this->data['entry_sort_order'] = 'Bestellen:';
		$this->data['entry_status'] = 'Staat:';
		$this->data['entry_layout'] = 'Layout Override:';
		
		$this->data['button_save'] = 'Besparen';
		$this->data['button_cancel'] = 'Annuleren';

    	$this->data['tab_general'] = 'Algemeen';
    	$this->data['tab_data'] = 'Gegevens';
		$this->data['tab_design'] = 'Ontwerp';
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['eventos_tipos_nombre'])) {
			$this->data['error_name'] = $this->error['eventos_tipos_nombre'];
		} else {
			$this->data['error_name'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Huis',
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Types Event',
			'href'      => $this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['eventos_tipos_id'])) {
			$this->data['action'] = $this->url->link('catalog/tipos/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/tipos/update', 'token=' . $this->session->data['token'] . '&eventos_tipos_id=' . $this->request->get['eventos_tipos_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['eventos_tipos_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$tipo_info = $this->model_catalog_tipos->getTipo($this->request->get['eventos_tipos_id']);
    	}

    	if (isset($this->request->post['eventos_tipos_nombre'])) {
      		$this->data['eventos_tipos_nombre'] = $this->request->post['eventos_tipos_nombre'];
    	} elseif (isset($tipo_info)) {
			$this->data['eventos_tipos_nombre'] = $tipo_info['eventos_tipos_nombre'];
		} else {	
      		$this->data['eventos_tipos_nombre'] = '';
    	}
		
		if (isset($this->request->post['eventos_tipos_imagen'])) {
			$this->data['eventos_tipos_imagen'] = $this->request->post['eventos_tipos_imagen'];
		} elseif (isset($tipo_info)) {
			$this->data['eventos_tipos_imagen'] = $tipo_info['eventos_tipos_imagen'];
		} else {
			$this->data['eventos_tipos_imagen'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($tipo_info) && $tipo_info['eventos_tipos_imagen'] && file_exists(DIR_IMAGE . $tipo_info['eventos_tipos_imagen'])) {
			$this->data['preview_eventos_tipos_imagen'] = $this->model_tool_image->resize($tipo_info['eventos_tipos_imagen'], 100, 100);
		} else {
			$this->data['preview_eventos_tipos_imagen'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['eventos_tipos_orden'])) {
			$this->data['eventos_tipos_orden'] = $this->request->post['eventos_tipos_orden'];
		} elseif (isset($tipo_info)) {
			$this->data['eventos_tipos_orden'] = $tipo_info['eventos_tipos_orden'];
		} else {
			$this->data['eventos_tipos_orden'] = '';
		}

		$this->template = 'catalog/tipos_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/tipos')) {
			$this->error['warning'] = 'Waarschuwing: U heeft geen toestemming om de types event te wijzigen!';
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = 'Waarschuwing: Controleer het formulier op fouten!';
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/tipos')) {
			$this->error['warning'] = 'Waarschuwing: U heeft geen toestemming om de types event te wijzigen!';
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}
?>
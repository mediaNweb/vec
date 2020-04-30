<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		
		$this->data['action'] = $this->url->link('common/home');

		$this->data['text_copyright']	= sprintf($this->language->get('text_copyright'), $this->config->get('config_name'), date('Y', time()));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['language_code'])) {
			$this->session->data['language'] = $this->request->post['language_code'];

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect($this->url->link('common/home'));
			}
		}		

		$this->data['language_code'] = $this->session->data['language'];

		$this->data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$this->data['languages'][] = array(
				'name'  => $result['name'],
				'code'  => $result['code'],
				'image' => $result['image']
				);	
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/footer.php')) {
			$this->template = $this->config->get('config_template') . '/common/footer.php';
		} else {
			$this->template = 'common/footer.php';
		}
		
		$this->children = array(
			'common/contact',
		);

		$this->response->setOutput($this->render());
	}
}
?>
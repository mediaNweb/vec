<?php   
    class ControllerCommonHeader extends Controller {
        protected function index() {

            $this->load->model('localisation/language');
            $this->load->model('catalog/tipos');

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$this->data['base'] = $this->config->get('config_ssl');
			} else {
				$this->data['base'] = $this->config->get('config_url');
			}
			
			$this->data['name'] = $this->config->get('config_name');
			$this->data['title'] = $this->document->getTitle();
			$this->data['description'] = $this->document->getDescription();
			$this->data['keywords'] = $this->document->getKeywords();
			$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$server = HTTPS_IMAGE;
			} else {
				$server = HTTP_IMAGE;
			}	
					
			if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
				$this->data['icon'] = $server . $this->config->get('config_icon');
			} else {
				$this->data['icon'] = '';
			}
			
            $this->data['action'] = $this->url->link('common/home');
            $this->data['home'] = $this->url->link('common/home');

            $this->data['text_heading_title']	= $this->language->get('text_heading_title');
            $this->data['text_menu_title']		= $this->language->get('text_menu_title');
            $this->data['button_home']    		= $this->language->get('button_home');
            $this->data['button_events']    	= $this->language->get('button_events');
            $this->data['button_contact']    	= $this->language->get('button_contact');

            if (!isset($this->request->get['route'])) {
                $this->data['redirect'] = $this->url->link('common/home');
            } else {
                $data = $this->request->get;

                unset($data['_route_']);

                $route = $data['route'];

                unset($data['route']);

                $url = '';

                if ($data) {
                    $url = '&' . urldecode(http_build_query($data));
                }			

                $this->data['redirect'] = $this->url->link($route, $url);
            }

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

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.php')) {
                $this->template = $this->config->get('config_template') . '/common/header.php';
            } else {
                $this->template = 'common/header.php';
            }

            $this->render();
        } 	
    }
?>
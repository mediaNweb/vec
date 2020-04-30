<?php  
    class ControllerCommonHome extends Controller {
        public function index() {

            $this->data['heading_title'] = $this->language->get('text_heading_title');

            $this->document->setTitle($this->config->get('config_title') . ' ' . $this->data['heading_title']);
            $this->document->setDescription($this->config->get('config_meta_description'));

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/home.php')) {
                $this->template = $this->config->get('config_template') . '/common/home.php';
            } else {
                $this->template = 'common/home.php';
            }

            $this->children = array(
				'common/header',
				'common/content',
				'common/footer'
            );

            $this->response->setOutput($this->render());
        }
    }
?>
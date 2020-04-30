<?php   
    class ControllerCommonContent extends Controller {
        protected function index($setting) {

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/content.php')) {
                $this->template = $this->config->get('config_template') . '/common/content.php';
            } else {
                $this->template = 'common/content.php';
            }

            $this->children = array(
				'common/slider',
	            'common/events',
            );

            $this->response->setOutput($this->render());
        }
    }
?>
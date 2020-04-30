<?php   
    class ControllerComunContentBottom extends Controller {
        protected function index($setting) {

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/comun/content_bottom.php')) {
                $this->template = $this->config->get('config_template') . '/comun/content_bottom.php';
            } else {
                $this->template = 'comun/content_bottom.php';
            }

/*
            $this->children = array(
	            'comun/calendario',
	            'comun/column_left',
	            'evento/eventos',
	            'publicidad/inferior',
            );
*/
            $this->response->setOutput($this->render());
        }
    }
?>
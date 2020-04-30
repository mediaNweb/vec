<?php   
class ControllerCommonSlider extends Controller {
    private $error = array(); 
    
    protected function index($setting) {

		$this->load->model('tool/image');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}	
					
		$this->data['text_tag_line_1']		= $this->language->get('text_tag_line_1');
		$this->data['text_tag_line_2']		= $this->language->get('text_tag_line_2');
		$this->data['text_tag_line_word_1']	= $this->language->get('text_tag_line_word_1');
		$this->data['text_tag_line_word_2']	= $this->language->get('text_tag_line_word_2');
		$this->data['text_tag_line_word_3']	= $this->language->get('text_tag_line_word_3');

		$this->data['button_get_in_touch']    	= $this->language->get('button_get_in_touch');
		$this->data['button_go_to_events']    	= $this->language->get('button_go_to_events');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/slider.php')) {
            $this->template = $this->config->get('config_template') . '/common/slider.php';
        } else {
            $this->template = 'common/slider.php';
        }
        
		$this->response->setOutput($this->render());
    }
}
?>
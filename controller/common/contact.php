<?php   
    class ControllerCommonContact extends Controller {
        protected function index($setting) {

            $this->data['text_contact_section_description']	= $this->language->get('text_contact_section_description');
            $this->data['text_contact_section_title']		= $this->language->get('text_contact_section_title');
            $this->data['button_close']    					= $this->language->get('button_close');
            $this->data['button_submit']    				= $this->language->get('button_submit');
            $this->data['input_contact_form_email_address']	= $this->language->get('input_contact_form_email_address');
            $this->data['input_contact_form_first_name']    = $this->language->get('input_contact_form_first_name');
            $this->data['input_contact_form_last_name']    	= $this->language->get('input_contact_form_last_name');
            $this->data['input_contact_form_message']    	= $this->language->get('input_contact_form_message');
            $this->data['input_contact_form_subject']    	= $this->language->get('input_contact_form_subject');
            $this->data['error_contact_form_message'] 		= $this->language->get('error_contact_form_message');
            $this->data['error_contact_form_success'] 		= $this->language->get('error_contact_form_success');
			
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/contact.php')) {
                $this->template = $this->config->get('config_template') . '/common/contact.php';
            } else {
                $this->template = 'common/contact.php';
            }

            $this->response->setOutput($this->render());
        }
    }
?>
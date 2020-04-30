<?php
class ControllerCommonFooter extends Controller {   
	protected function index() {

		$this->data['text_footer'] = sprintf('<a href="http://www.median.web.ve">mediaNweb</a> &copy; 2011-' . date('Y') . ' Alle rechten voorbehouden.<br />Versi&oacute;n %s', VERSION);
		
		$this->template = 'common/footer.tpl';
	
    	$this->render();
  	}
}
?>
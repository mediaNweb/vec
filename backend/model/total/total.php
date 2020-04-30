<?php
class ModelTotalTotal extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		$this->load->idioma('total/total');
	 
		$total_data[] = array(
			'code'       => 'total',
			'title'      => $this->idioma->get('text_total'),
			'text'       => $this->moneda->format(max(0, $total)),
			'value'      => max(0, $total),
			'sort_order' => $this->config->get('total_sort_order')
		);
	}
}
?>
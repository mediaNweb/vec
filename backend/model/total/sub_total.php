<?php
class ModelTotalSubTotal extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		$this->load->idioma('total/sub_total');
		
		$sub_total = $this->solicitud->getSubTotal();
		
		$total_data[] = array( 
			'code'       => 'sub_total',
			'title'      => 'Sub-Total',
			'text'       => $this->moneda->format($sub_total),
			'value'      => $sub_total,
			'sort_order' => $this->config->get('sub_total_sort_order')
		);
		
		$total += $sub_total;
	}
}
?>
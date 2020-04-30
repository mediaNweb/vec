<?php
class ModelTotalLowOrderFee extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		if ($this->solicitud->getSubTotal() && ($this->solicitud->getSubTotal() < $this->config->get('low_order_fee_total'))) {
			$this->load->idioma('total/low_order_fee');
		 	
			$total_data[] = array( 
				'code'       => 'low_order_fee',
        		'title'      => $this->idioma->get('text_low_order_fee'),
        		'text'       => $this->moneda->format($this->config->get('low_order_fee_fee')),
        		'value'      => $this->config->get('low_order_fee_fee'),
				'sort_order' => $this->config->get('low_order_fee_sort_order')
			);
			
			if ($this->config->get('low_order_fee_impuestos_clase_id')) {
				if (!isset($impuestos[$this->config->get('low_order_fee_impuestos_clase_id')])) {
					$impuestos[$this->config->get('low_order_fee_impuestos_clase_id')] = $this->config->get('low_order_fee_fee') / 100 * $this->impuesto->getRate($this->config->get('low_order_fee_impuestos_clase_id'));
				} else {
					$impuestos[$this->config->get('low_order_fee_impuestos_clase_id')] += $this->config->get('low_order_fee_fee') / 100 * $this->impuesto->getRate($this->config->get('low_order_fee_impuestos_clase_id'));
				}
			}
			
			$total += $this->config->get('low_order_fee_fee');
		}
	}
}
?>
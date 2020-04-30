<?php
class ModelTotalHandling extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		if ($this->solicitud->getSubTotal() < $this->config->get('handling_total')) {
			$this->load->idioma('total/handling');
		 	
			$total_data[] = array( 
				'code'       => 'handling',
        		'title'      => $this->idioma->get('text_handling'),
        		'text'       => $this->moneda->format($this->config->get('handling_fee')),
        		'value'      => $this->config->get('handling_fee'),
				'sort_order' => $this->config->get('handling_sort_order')
			);

			if ($this->config->get('handling_impuestos_clase_id')) {
				if (!isset($impuestos[$this->config->get('handling_impuestos_clase_id')])) {
					$impuestos[$this->config->get('handling_impuestos_clase_id')] = $this->config->get('handling_fee') / 100 * $this->impuesto->getRate($this->config->get('handling_impuestos_clase_id'));
				} else {
					$impuestos[$this->config->get('handling_impuestos_clase_id')] += $this->config->get('handling_fee') / 100 * $this->impuesto->getRate($this->config->get('handling_impuestos_clase_id'));
				}
			}
			
			$total += $this->config->get('handling_fee');
		}
	}
}
?>
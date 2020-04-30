<?php
class ModelTotalShipping extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		if ($this->solicitud->hasShipping() && isset($this->session->data['shipping_method'])) {
			$total_data[] = array( 
				'code'       => 'shipping',
        		'title'      => $this->session->data['shipping_method']['title'],
        		'text'       => $this->moneda->format($this->session->data['shipping_method']['cost']),
        		'value'      => $this->session->data['shipping_method']['cost'],
				'sort_order' => $this->config->get('shipping_sort_order')
			);

			if ($this->session->data['shipping_method']['impuestos_clase_id']) {
				if (!isset($impuestos[$this->session->data['shipping_method']['impuestos_clase_id']])) {
					$impuestos[$this->session->data['shipping_method']['impuestos_clase_id']] = $this->session->data['shipping_method']['cost'] / 100 * $this->impuesto->getRate($this->session->data['shipping_method']['impuestos_clase_id']);
				} else {
					$impuestos[$this->session->data['shipping_method']['impuestos_clase_id']] += $this->session->data['shipping_method']['cost'] / 100 * $this->impuesto->getRate($this->session->data['shipping_method']['impuestos_clase_id']);
				}
			}
			
			$total += $this->session->data['shipping_method']['cost'];
		}			
	}
}
?>
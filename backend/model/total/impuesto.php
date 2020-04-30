<?php
class ModelTotalImpuesto extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		foreach ($impuestos as $key => $value) {
			if ($value > 0) {
				$impuesto_classes = $this->impuesto->getDescription($key);
				
				foreach ($impuesto_classes as $impuesto_class) {
					$rate = $this->impuesto->getRate($key);
					
					$impuesto = $value * ($impuesto_class['impuestos_tasa'] / $rate);
					
					$total_data[] = array(
						'code'       => 'impuesto',
						'title'      => $impuesto_class['impuestos_tasa_descripcion'], 
						'text'       => $this->moneda->format($impuesto),
						'value'      => $impuesto,
						'sort_order' => $this->config->get('impuesto_sort_order')
					);
		
					$total += $impuesto;
				}
			}
		}
	}
}
?>
<?php
class ModelTotalReward extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		if (isset($this->session->data['reward'])) {
			$this->load->idioma('total/reward');
			
			$points = $this->cliente->getRewardPoints();
			
			if ($this->session->data['reward'] <= $points) {
				$discount_total = 0;
				
				$points_total = 0;
				
				foreach ($this->solicitud->getProducts() as $product) {
					if ($product['points']) {
						$points_total += $product['points'];
					}
				}	
				
				$points = min($points, $points_total);
		
				foreach ($this->solicitud->getProducts() as $product) {
					$discount = 0;
					
					if ($product['points']) {
						$discount = $product['total'] * ($this->session->data['reward'] / $points_total);

						if ($product['impuestos_clase_id']) {
							$impuestos[$product['impuestos_clase_id']] -= ($product['total'] / 100 * $this->impuesto->getRate($product['impuestos_clase_id'])) - (($product['total'] - $discount) / 100 * $this->impuesto->getRate($product['impuestos_clase_id']));
						}
					}
					
					$discount_total += $discount;
				}
			
				$total_data[] = array(
					'code'       => 'reward',
        			'title'      => sprintf($this->idioma->get('text_reward'), $this->session->data['reward']),
	    			'text'       => $this->moneda->format(-$discount_total),
        			'value'      => -$discount_total,
					'sort_order' => $this->config->get('reward_sort_order')
      			);

				$total -= $discount_total;
			} 
		}
	}
	
	public function confirm($order_info, $order_total) {
		$this->load->idioma('total/reward');
		
		$points = 0;
		
		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');
		
		if ($start && $end) {  
			$points = substr($order_total['title'], $start, $end - $start);
		}	
		
		if ($points) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$order_info['customer_id'] . "', order_id = '" . (int)$order_info['order_id'] . "', description = '" . $this->db->escape(sprintf($this->idioma->get('text_order_id'), (int)$order_info['order_id'])) . "', points = '" . (float)-$points . "', date_added = NOW()");				
		}
	}		
}
?>
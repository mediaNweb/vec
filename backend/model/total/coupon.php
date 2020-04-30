<?php
class ModelTotalCoupon extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		if (isset($this->session->data['coupon'])) {
			$this->load->idioma('total/coupon');
			
			$this->load->model('checkout/coupon');
			 
			$coupon_info = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);
			
			if ($coupon_info) {
				$discount_total = 0;
				
				if (!$coupon_info['product']) {
					$sub_total = $this->solicitud->getSubTotal();
				} else {
					$sub_total = 0;
				
					foreach ($this->solicitud->getProducts() as $product) {
						if (in_array($product['product_id'], $coupon_info['product'])) {
							$sub_total += $product['total'];
						}
					}					
				}
				
				if ($coupon_info['type'] == 'F') {
					$coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
				}
				
				foreach ($this->solicitud->getProducts() as $product) {
					$discount = 0;
					
					if (!$coupon_info['product']) {
						$status = true;
					} else {
						if (in_array($product['product_id'], $coupon_info['product'])) {
							$status = true;
						} else {
							$status = false;
						}
					}
					
					if ($status) {
						if ($coupon_info['type'] == 'F') {
							$discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
						} elseif ($coupon_info['type'] == 'P') {
							$discount = $product['total'] / 100 * $coupon_info['discount'];
						}
				
						if ($product['impuestos_clase_id']) {
							$impuestos[$product['impuestos_clase_id']] -= ($product['total'] / 100 * $this->impuesto->getRate($product['impuestos_clase_id'])) - (($product['total'] - $discount) / 100 * $this->impuesto->getRate($product['impuestos_clase_id']));
						}
					}
					
					$discount_total += $discount;
				}
				
				if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					if (isset($this->session->data['shipping_method']['impuestos_clase_id']) && $this->session->data['shipping_method']['impuestos_clase_id']) {
						$impuestos[$this->session->data['shipping_method']['impuestos_clase_id']] -= $this->session->data['shipping_method']['cost'] / 100 * $this->impuesto->getRate($this->session->data['shipping_method']['impuestos_clase_id']);
					}
					
					$discount_total += $this->session->data['shipping_method']['cost'];				
				}				
      			
				$total_data[] = array(
					'code'       => 'coupon',
        			'title'      => sprintf($this->idioma->get('text_coupon'), $this->session->data['coupon']),
	    			'text'       => $this->moneda->format(-$discount_total),
        			'value'      => -$discount_total,
					'sort_order' => $this->config->get('coupon_sort_order')
      			);

				$total -= $discount_total;
			} 
		}
	}
	
	public function confirm($order_info, $order_total) {
		$code = '';
		
		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');
		
		if ($start && $end) {  
			$code = substr($order_total['title'], $start, $end - $start);
		}	
		
		$this->load->model('checkout/coupon');
		
		$coupon_info = $this->model_checkout_coupon->getCoupon($code);
			
		if ($coupon_info) {
			$this->model_checkout_coupon->redeem($coupon_info['coupon_id'], $order_info['order_id'], $order_info['customer_id'], $order_total['value']);	
		}						
	}
}
?>
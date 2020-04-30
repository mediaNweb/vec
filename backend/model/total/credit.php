<?php
class ModelTotalCredit extends Model {
	public function getTotal(&$total_data, &$total, &$impuestos) {
		if ($this->config->get('credit_status')) {
			$this->load->idioma('total/credit');
		 
			$balance = $this->cliente->getBalance();
			
			if ((float)$balance) {
				if ($balance > $total) {
					$credit = $total;	
				} else {
					$credit = $balance;	
				}
				
				if ($credit > 0) {
					$total_data[] = array(
						'code'       => 'credit',
						'title'      => $this->idioma->get('text_credit'),
						'text'       => $this->moneda->format(-$credit),
						'value'      => -$credit,
						'sort_order' => $this->config->get('credit_sort_order')
					);
					
					$total -= $credit;
				}
			}
		}
	}
	
	public function confirm($order_info, $order_total) {
		$this->load->idioma('total/credit');
		
		if ($order_info['customer_id']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$order_info['customer_id'] . "', order_id = '" . (int)$order_info['order_id'] . "', description = '" . $this->db->escape(sprintf($this->idioma->get('text_order_id'), (int)$order_info['order_id'])) . "', amount = '" . (float)$order_total['value'] . "', date_added = NOW()");				
		}
	}	
}
?>
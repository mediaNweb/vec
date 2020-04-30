<?php
    class ModelTotalImpuesto extends Model {
        public function getTotal(&$total_data, &$total, &$impuestos) {
            foreach ($impuestos as $key => $value) {
                if ($value > 0) {
                    $impuestos_clasees = $this->impuesto->getDescription($key);

                    foreach ($impuestos_clasees as $impuestos_clase) {
                        $rate = $this->impuesto->getRate($key);

                        $impuesto = $value * ($impuestos_clase['rate'] / $rate);

                        $total_data[] = array(
                        'code'       => 'impuesto',
                        'title'      => $impuestos_clase['description'], 
                        'text'       => $this->moneda->format($impuesto),
                        'value'      => $impuesto,
                        'sort_order' => $this->config->get('impuesto_sort_order')
                        );

                        $total += $impuesto;
                    }
                }
            }
        }

        public function getImpuesto() {

            $query = $this->db->query("SELECT it.* FROM " . DB_PREFIX . "impuestos_tasa it LEFT JOIN " . DB_PREFIX . "impuestos_clase ic ON (it.impuestos_tasa_id_impuestos_clase = ic.impuestos_clase_id)");

            if ($query->num_rows) {
                return array(
                'impuestos_tasa'                => $query->row['impuestos_tasa'],
                'impuestos_tasa_descripcion'    => $query->row['impuestos_tasa_descripcion'],
                );
            }
        }

    }
?>
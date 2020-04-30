<?php
    class ModelSesionCliente extends Model {

        public function addCliente($data) {
            $telefono   = $this->db->escape($data['cod_area']).$this->db->escape($data['tel']);
            $celular    = $this->db->escape($data['cod_oper']).$this->db->escape($data['cel']);

            $this->db->query("INSERT INTO " . DB_PREFIX . "clientes SET clientes_id = '" . $this->db->escape($data['clientes_id']) . "', clientes_nombre = '" . $this->db->escape($data['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($data['clientes_apellido']) . "', clientes_genero = '" . $this->db->escape($data['clientes_genero']) . "', clientes_fdn = '" . $this->db->escape($data['clientes_fdn']) . "', clientes_email = '" . $this->db->escape($data['clientes_email']) . "', clientes_tel = '" . $telefono . "', clientes_cel = '" . $celular . "', clientes_pin = '" . $this->db->escape($data['clientes_pin']) . "', paises_id = '" . $this->db->escape($data['paises_id']) . "', estados_id = '" . $this->db->escape($data['estados_id']) . "', clientes_twitter = '" . $this->db->escape($data['clientes_twitter']) . "', clientes_talla = '" . $this->db->escape($data['clientes_talla']) . "', clientes_id_sanguineo = '" . $this->db->escape($data['grupo_id']) . "', clientes_clave = '" . $this->db->escape(md5($data['password'])) . "', clientes_boletin = '" . (isset($data['clientes_boletin']) ? (int)$data['clientes_boletin'] : 0) . "', clientes_status = '1', clientes_fdc = NOW()");

            $clientes_id = $this->db->escape($data['clientes_id']);

            $this->db->query("INSERT INTO " . DB_PREFIX . "clientes_direcciones SET clientes_id = '" . (int)$clientes_id . "', clientes_direcciones_calle = '" . $this->db->escape($data['clientes_direcciones_calle']) . "', clientes_direcciones_urbanizacion = '" . $this->db->escape($data['clientes_direcciones_urbanizacion']) . "', clientes_direcciones_casa = '" . $this->db->escape($data['clientes_direcciones_casa']) . "', clientes_direcciones_municipio = '" . $this->db->escape($data['clientes_direcciones_municipio']) . "', clientes_direcciones_postal = '" . $this->db->escape($data['clientes_direcciones_postal']) . "', clientes_direcciones_ciudad = '" . $this->db->escape($data['clientes_direcciones_ciudad']) . "', paises_id = '" . (int)$data['paises_id'] . "', estados_id = '" . (int)$data['estados_id'] . "'");

            $address_id = $this->db->getLastId();

            $this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_id_direccion  = '" . (int)$address_id . "' WHERE clientes_id = '" . (int)$clientes_id . "'");

            $subject = utf8_encode(sprintf('%s, - Registro completado', $this->config->get('config_name')));

            $message = sprintf('¡Bienvenido! Gracias por registrarte en %s', $this->config->get('config_name')) . "\n\n";

            $message .= 'Tu cuenta ha sido creada y puedes iniciar sesión colocando tu dirección de correo electrónico y contraseña en nuestro sitio web o a través del siguiente enlace URL:' . "\n";

            $message .= $this->url->link('sesion/autenticar', '', 'SSL') . "\n\n";
            $message .= 'Una vez ingresado, serás capaz de editar la información de tu cuenta.' . "\n\n";
            $message .= 'Gracias,' . "\n";
            $message .= $this->config->get('config_name');

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');				
            $mail->setTo($this->request->post['clientes_email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($subject);
            $mail->setText(utf8_encode($message));
            $mail->send();

            // Send to main admin email if new account email is enabled
            if ($this->config->get('config_account_mail')) {
                $mail->setTo($this->config->get('config_email'));
                $mail->send();

                // Send to additional alert emails if new account email is enabled
                $emails = explode(',', $this->config->get('config_alert_emails'));

                foreach ($emails as $email) {
                    if (strlen($email) > 0 && preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $email)) {
                        $mail->setTo($email);
                        $mail->send();
                    }
                }
            }
        }

        public function editCliente($data) {
            $telefono   = $this->db->escape($data['cod_area']).$this->db->escape($data['tel']);
            $celular    = $this->db->escape($data['cod_oper']).$this->db->escape($data['cel']);

            $this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_nombre = '" . $this->db->escape($data['clientes_nombre']) . "', clientes_apellido = '" . $this->db->escape($data['clientes_apellido']) . "', clientes_genero = '" . $this->db->escape($data['clientes_genero']) . "', clientes_fdn = '" . $this->db->escape($data['clientes_fdn']) . "', clientes_tel = '" . $telefono . "', clientes_cel = '" . $celular . "', clientes_pin = '" . $this->db->escape($data['clientes_pin']) . "', paises_id = '" . $this->db->escape($data['paises_id']) . "', estados_id = '" . $this->db->escape($data['estados_id']) . "', clientes_twitter = '" . $this->db->escape($data['clientes_twitter']) . "', clientes_talla = '" . $this->db->escape($data['clientes_talla']) . "', clientes_id_sanguineo = '" . $this->db->escape($data['grupo_id']) . "' WHERE clientes_id = '" . (int)$this->cliente->getId() . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "clientes_direcciones WHERE clientes_id = '" . (int)$this->cliente->getId() . "'");

            $this->db->query("INSERT INTO " . DB_PREFIX . "clientes_direcciones SET clientes_id = '" . (int)$this->cliente->getId() . "', clientes_direcciones_calle = '" . $this->db->escape($data['clientes_direcciones_calle']) . "', clientes_direcciones_urbanizacion = '" . $this->db->escape($data['clientes_direcciones_urbanizacion']) . "', clientes_direcciones_casa = '" . $this->db->escape($data['clientes_direcciones_casa']) . "', clientes_direcciones_municipio = '" . $this->db->escape($data['clientes_direcciones_municipio']) . "', clientes_direcciones_postal = '" . $this->db->escape($data['clientes_direcciones_postal']) . "', clientes_direcciones_ciudad = '" . $this->db->escape($data['clientes_direcciones_ciudad']) . "', paises_id = '" . (int)$data['paises_id'] . "', estados_id = '" . (int)$data['estados_id'] . "'");

            $address_id = $this->db->getLastId();

            $this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_id_direccion  = '" . (int)$address_id . "' WHERE clientes_id = '" . (int)$this->cliente->getId() . "'");
			
        }

        public function editPassword($email, $password) {
            $this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_clave = '" . $this->db->escape(md5($password)) . "' WHERE clientes_email = '" . $this->db->escape($email) . "'");
        }

        public function editNewsletter($newsletter) {
            $this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_boletin = '" . (int)$newsletter . "' WHERE clientes_id = '" . (int)$this->cliente->getId() . "'");
        }

        public function getClienteX($clientes_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . (int)$clientes_id . "'");

            return $query->row;
        }

        public function getClientes($data = array()) {
            $sql = "SELECT *, CONCAT(c.clientes_nombre, ' ', c.clientes_apellido) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "clientes c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

            $implode = array();

            if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
                $implode[] = "LCASE(CONCAT(c.clientes_nombre, ' ', c.clientes_apellido)) LIKE '" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%'";
            }

            if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
                $implode[] = "c.clientes_email = '" . $this->db->escape($data['filter_email']) . "'";
            }

            if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
                $implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
            }	

            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "c.clientes_status = '" . (int)$data['filter_status'] . "'";
            }	

            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
            }	

            if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
                $implode[] = "c.clientes_id IN (SELECT clientes_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
            }	

            if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
                $implode[] = "DATE(c.clientes_fdc) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }

            if ($implode) {
                $sql .= " WHERE " . implode(" AND ", $implode);
            }

            $sort_data = array(
            'name',
            'c.clientes_email',
            'customer_group',
            'c.clientes_status',
            'c.ip',
            'c.clientes_fdc'
            );	

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];	
            } else {
                $sql .= " ORDER BY name";	
            }

            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }			

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }	

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }		

            $query = $this->db->query($sql);

            return $query->rows;	
        }

        public function getTotalClientesByEmail($email) {
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clientes WHERE clientes_email = '" . $this->db->escape($email) . "'");

            return $query->row['total'];
        }

		public function isCliente($clientes_id) {
	
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . (int)$clientes_id . "'");
			
			if ($query->num_rows) {
				return true;
			} else {
				return false;
			}
			
		}

		public function isPersona($clientes_id) {
	
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "personas WHERE cedula = '" . (int)$clientes_id . "'");
			
			if ($query->num_rows) {
				return true;
			} else {
				return false;
			}
			
		}

        public function getCliente($clientes_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . (int)$clientes_id . "' LIMIT 1");

            if ($query->num_rows) {
				$edad = $this->getEdad($query->row['clientes_fdn']);
                $datos = array(
                'nombre'            => $query->row['clientes_nombre'],
                'apellido'          => $query->row['clientes_apellido'],
                'cedula'            => $query->row['clientes_id'],
                'nacimiento'        => $query->row['clientes_fdn'],
				'edad'				=> $edad,
                'nacionalidad'      => $query->row['clientes_nacionalidad'],
                'sexo'              => $query->row['clientes_genero'],
                'sangre'            => $query->row['clientes_id_sanguineo'],
                'direccion'         => $query->row['clientes_id_direccion'],
                'pais'              => $query->row['paises_id'],
                'estado'            => $query->row['estados_id'],
                'tlf_habitacion'	=> $query->row['clientes_tel'],
                'celular'			=> $query->row['clientes_cel'],
                'mail'				=> $query->row['clientes_email'],
                'twitter'           => $query->row['clientes_twitter'],
                );
                return $datos;
            } else {
                return false;
            }
        }

        public function getPersona($clientes_id) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "personas WHERE cedula = '" . (int)$clientes_id . "' LIMIT 1");

            if ($query->num_rows) {
				$edad = $this->getEdad($query->row['nacimiento']);
                $datos = array(
                'nombre'            => $query->row['nombre'],
                'apellido'          => $query->row['apellido'],
                'cedula'            => $query->row['cedula'],
                'nacimiento'        => $query->row['nacimiento'],
				'edad'				=> $edad,
                'nacionalidad'      => $query->row['nacionalidad'],
                'sexo'              => $query->row['sexo'],
                'sangre'            => $query->row['sangre'],
                'direccion'         => $query->row['direccion'],
                'pais'              => $query->row['pais'],
                'estado'            => $query->row['estado'],
                'tlf_habitacion'	=> $query->row['tlf_habitacion'],
                'celular'			=> $query->row['celular'],
                'mail'				=> $query->row['mail'],
                'twitter'           => $query->row['twitter'],
                );
                return $datos;
            } else {
                return false;
            }
        }

        public function getEdad($nacimiento) {
			list($Y,$m,$d) = explode("-",$nacimiento);
			return( date("md") < $m.$d ? date("Y")-$Y : date("Y")-$Y );
		}

        public function getCategoria($eventos_id, $edad, $genero) {
			$categoria_data = array();
			
            $categoria_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$eventos_id . "' AND (eventos_categorias_edad_desde <= " . $edad . " AND eventos_categorias_edad_hasta >= " . $edad . ") AND (eventos_categorias_genero = 'Ambos' OR eventos_categorias_genero = '" . $genero . "') AND eventos_categorias_tipo <> 'Opcional'");
			
			foreach ($categoria_query->rows as $categoria_opcion) {
//			foreach ($categoria_query->rows as $key => $value) {
				$categoria_data[] = array(
//					'categoria_' . $key	=> $value,
					'eventos_categorias_id' 		=> $categoria_opcion['eventos_categorias_id'],
					'eventos_categorias_nombre'     => $categoria_opcion['eventos_categorias_nombre'],
					'eventos_categorias_genero'     => $categoria_opcion['eventos_categorias_genero'],
					'eventos_categorias_grupo'		=> $categoria_opcion['eventos_categorias_grupo']
				);				
			}

            return $categoria_data;
		}

        public function getCategoriaCorrecta($eventos_id, $edad, $genero, $grupo = '') {

            $categoria_query = $this->db->query("SELECT eventos_categorias_nombre FROM " . DB_PREFIX . "eventos_categorias WHERE eventos_categorias_id_evento = '" . (int)$eventos_id . "' AND eventos_categorias_edad_desde <= " . $edad . " AND eventos_categorias_edad_hasta >= " . $edad . " AND (eventos_categorias_genero = 'Ambos' OR eventos_categorias_genero = '" . $genero . "') AND eventos_categorias_grupo = '" . $grupo . "' AND eventos_categorias_tipo <> 'Opcional'");

            return $categoria_query->row['eventos_categorias_nombre'];

		}

        public function getGrupoCircuito($eventos_id, $cedula) {

            $categoria_query = $this->db->query("SELECT eventos_circuitos_grupo FROM " . DB_PREFIX . "eventos_circuitos WHERE eventos_circuitos_id_evento = '" . (int)$eventos_id . "' AND eventos_circuitos_id_cliente = '" . $cedula . "'");

            if ($categoria_query->num_rows) {
	            return $categoria_query->row['eventos_circuitos_grupo'];
            } else {
                return false;
            }

		}

    }
?>
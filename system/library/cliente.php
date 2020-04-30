<?php
final class Cliente {
	private $clientes_id;
	private $clientes_nombre;
	private $clientes_apellido;
	private $clientes_genero;
	private $clientes_fdn;
	private $clientes_email;
	private $clientes_twitter;
	private $clientes_tel;
	private $clientes_cel;
	private $clientes_pin;
	private $clientes_nacionalidad;
	private $clientes_boletin;
	private $clientes_id_direccion;
	private $paises_id;
	private $estados_id;
	private $clientes_id_sanguineo;
	
  	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
				
		if (isset($this->session->data['clientes_id'])) { 
			$cliente_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE clientes_id = '" . (int)$this->session->data['clientes_id'] . "' AND clientes_status = '1'");
			
			if ($cliente_query->num_rows) {
				$this->clientes_id = $cliente_query->row['clientes_id'];
				$this->clientes_nombre = $cliente_query->row['clientes_nombre'];
				$this->clientes_apellido = $cliente_query->row['clientes_apellido'];
				$this->clientes_genero = $cliente_query->row['clientes_genero'];
				$this->clientes_fdn = $cliente_query->row['clientes_fdn'];
				$this->clientes_email = $cliente_query->row['clientes_email'];
				$this->clientes_twitter = $cliente_query->row['clientes_twitter'];
				$this->clientes_tel = $cliente_query->row['clientes_tel'];
				$this->clientes_cel = $cliente_query->row['clientes_cel'];
				$this->clientes_pin = $cliente_query->row['clientes_pin'];
				$this->clientes_nacionalidad = $cliente_query->row['clientes_nacionalidad'];
				$this->clientes_boletin = $cliente_query->row['clientes_boletin'];
				$this->clientes_id_direccion = $cliente_query->row['clientes_id_direccion'];
				$this->paises_id = $cliente_query->row['paises_id'];
				$this->estados_id = $cliente_query->row['estados_id'];
				$this->clientes_id_sanguineo = $cliente_query->row['clientes_id_sanguineo'];
				
//      		$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_solicitudes = '" . $this->db->escape(isset($this->session->data['solicitud']) ? serialize($this->session->data['solicitud']) : '') . "', clientes_ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE clientes_id = '" . (int)$this->session->data['clientes_id'] . "'");
                			
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes_ip WHERE clientes_id = '" . (int)$this->session->data['clientes_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
				
				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "clientes_ip SET clientes_id = '" . (int)$this->session->data['clientes_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', fdc = NOW()");
				}

			} else {
				$this->logout();
			}
  		}
	}
		
  	public function login($clientes_email, $password) {
		if (!$this->config->get('config_customer_approval')) {
			$cliente_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE LOWER(clientes_email) = '" . $this->db->escape(strtolower($clientes_email)) . "' AND clientes_clave = '" . $this->db->escape(md5($password)) . "' AND clientes_status = '1'");
		} else {
			$cliente_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clientes WHERE LOWER(clientes_email) = '" . $this->db->escape(strtolower($clientes_email)) . "' AND clientes_clave = '" . $this->db->escape(md5($password)) . "' AND clientes_status = '1' AND approved = '1'");
		}
		
		if ($cliente_query->num_rows) {
			$this->session->data['clientes_id'] = $cliente_query->row['clientes_id'];	
		    
/*
			if (($cliente_query->row['clientes_solicitudes']) && (is_string($cliente_query->row['clientes_solicitudes']))) {
				$solicitud = unserialize($cliente_query->row['clientes_solicitudes']);
				
				foreach ($solicitud as $key => $value) {
					if (!array_key_exists($key, $this->session->data['solicitud'])) {
						$this->session->data['solicitud'][$key] = $value;
					} else {
						$this->session->data['solicitud'][$key] += $value;
					}
				}			
			}
*/

			$this->clientes_id = $cliente_query->row['clientes_id'];
			$this->clientes_nombre = $cliente_query->row['clientes_nombre'];
			$this->clientes_apellido = $cliente_query->row['clientes_apellido'];
			$this->clientes_genero = $cliente_query->row['clientes_genero'];
			$this->clientes_fdn = $cliente_query->row['clientes_fdn'];
			$this->clientes_email = $cliente_query->row['clientes_email'];
			$this->clientes_twitter = $cliente_query->row['clientes_twitter'];
			$this->clientes_tel = $cliente_query->row['clientes_tel'];
			$this->clientes_cel = $cliente_query->row['clientes_cel'];
			$this->clientes_pin = $cliente_query->row['clientes_pin'];
			$this->clientes_nacionalidad = $cliente_query->row['clientes_nacionalidad'];
			$this->clientes_boletin = $cliente_query->row['clientes_boletin'];
			$this->clientes_id_direccion = $cliente_query->row['clientes_id_direccion'];
			$this->paises_id = $cliente_query->row['paises_id'];
			$this->estados_id = $cliente_query->row['estados_id'];
			$this->clientes_id_sanguineo = $cliente_query->row['clientes_id_sanguineo'];
          	
			$this->db->query("UPDATE " . DB_PREFIX . "clientes SET clientes_ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE clientes_id = '" . (int)$cliente_query->row['clientes_id'] . "'");
            
			$this->db->query("UPDATE " . DB_PREFIX . "clientes_ip SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE clientes_id = '" . (int)$cliente_query->row['clientes_id'] . "'");
			
	  		return true;
    	} else {
      		return false;
    	}
  	}
  
  	public function logout() {
		unset($this->session->data['clientes_id']);

		$this->clientes_id = '';
		$this->clientes_nombre = '';
		$this->clientes_apellido = '';
		$this->clientes_genero = '';
		$this->clientes_fdn = '';
		$this->clientes_email = '';
		$this->clientes_twitter = '';
		$this->clientes_tel = '';
		$this->clientes_cel = '';
		$this->clientes_pin = '';
		$this->clientes_nacionalidad = '';
		$this->clientes_boletin = '';
		$this->clientes_id_direccion = '';
		$this->paises_id = '';
		$this->estados_id = '';
		$this->clientes_id_sanguineo = '';
		
		session_destroy();
  	}

    public function fecha_a_normal($fecha){ 
           ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); 
           $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
           return $lafecha; 
    } 

    public function fecha_a_mysql($fecha){ 
           ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); 
           $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
           return $lafecha; 
    }     
  
  	public function isLogged() {
    	return $this->clientes_id;
  	}

  	public function getId() {
    	return $this->clientes_id;
  	}
      
  	public function getFirstName() {
		return $this->clientes_nombre;
  	}
  
  	public function getLastName() {
		return $this->clientes_apellido;
  	}

  	public function getGender() {
		return $this->clientes_genero;
  	}

  	public function getDOB() {
		return fecha_a_normal($this->clientes_fdn);
  	}
  
  	public function getEmail() {
		return $this->clientes_email;
  	}

  	public function getTwitter() {
		return $this->clientes_twitter;
  	}
  
  	public function getTelephone() {
		return $this->clientes_tel;
  	}
  
  	public function getCellphone() {
		return $this->clientes_cel;
  	}

  	public function getBlackberry() {
		return $this->clientes_pin;
  	}

  	public function getNationality() {
		return $this->clientes_nacionalidad;
  	}
	
  	public function getNewsletter() {
		return $this->clientes_boletin;	
  	}
	
  	public function getDireccionId() {
		return $this->clientes_id_direccion;	
  	}

  	public function getCountryId() {
		return $this->paises_id;	
  	}

  	public function getStateId() {
		return $this->estados_id;	
  	}

  	public function getBloodId() {
		return $this->clientes_id_sanguineo;	
  	}
	
}
?>
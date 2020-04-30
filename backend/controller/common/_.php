<?php
class ControllerCommonFileManager extends Controller {
	private $error = array();
	
	public function index() {
		
		$this->data['title'] = 'Administrador de Im&aacute;genes';
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}
		
		$this->data['entry_folder'] = 'Nueva Carpeta:';
		$this->data['entry_move'] = 'Mover:';
		$this->data['entry_copy'] = 'Copiar:';
		$this->data['entry_rename'] = 'Renombrar:';
		
		$this->data['button_folder'] = 'Nueva Carpeta';
		$this->data['button_delete'] = 'Eliminar';
		$this->data['button_move'] = 'Mover';
		$this->data['button_copy'] = 'Copiar';
		$this->data['button_rename'] = 'Renombrar';
		$this->data['button_upload'] = 'Subir';
		$this->data['button_refresh'] = 'Actualizar'; 
		
		$this->data['error_select'] = 'Advertencia: Por favor seleccione una carpeta o archivo';
		$this->data['error_directory'] = 'Advertencia: Por favor seleccione una carpeta';
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['directory'] = HTTP_IMAGE . 'data/';
		
		if (isset($this->request->get['field'])) {
			$this->data['field'] = $this->request->get['field'];
		} else {
			$this->data['field'] = '';
		}
		
		if (isset($this->request->get['CKEditorFuncNum'])) {
			$this->data['fckeditor'] = $this->request->get['CKEditorFuncNum'];
		} else {
			$this->data['fckeditor'] = false;
		}
		
		$this->template = 'common/filemanager.tpl';
		
		$this->response->setOutput($this->render());
	}	
	
	public function image() {
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image'])) {

			$extension = substr(strrchr($this->request->post['image'], '.'), 1);
			 
			if ($extension == 'pdf' || $extension == 'PDF') {
				
				$this->response->setOutput($this->model_tool_image->resize('icono_pdf.jpg', 100, 100));
				
			} else if ($extension == 'swf' || $extension == 'SWF') {
				
				$this->response->setOutput($this->model_tool_image->resize('icono_swf.jpg', 100, 100));
			
			} else { 
			
				$this->response->setOutput($this->model_tool_image->resize($this->request->post['image'], 100, 100));
									
			}
		}
	}
	
	public function directory() {	
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			$directories = glob(rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']), '/') . '/*', GLOB_ONLYDIR); 
			
			if ($directories) {
				$i = 0;
			
				foreach ($directories as $directory) {
					$json[$i]['data'] = basename($directory);
					$json[$i]['attributes']['directory'] = substr($directory, strlen(DIR_IMAGE . 'data/'));
					
					$children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);
					
					if ($children)  {
						$json[$i]['children'] = ' ';
					}
					
					$i++;
				}
			}		
		}

		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));		
	}
	
	public function files() {
		$json = array();
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['directory']) && $this->request->post['directory']) {
			$directory = DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']);
		} else {
			$directory = DIR_IMAGE . 'data/';
		}
		
		$allowed = array(
			'.jpg',
			'.jpeg',
			'.png',
			'.gif',
			'.swf',
			'.pdf',
			'.csv',
			'.xls',
		);
		
		$files = glob(rtrim($directory, '/') . '/*');
		
		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					$ext = strrchr($file, '.');
				} else {
					$ext = '';
				}	
				
				if (in_array(strtolower($ext), $allowed)) {
					$size = filesize($file);
		
					$i = 0;
		
					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);
		
					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
						
					$extension = substr(strrchr($file, '.'), 1);
					 
					if ($extension == 'pdf' || $extension == 'PDF') {
						
						$thumb = $this->model_tool_image->resize('icono_pdf.jpg', 100, 100);
						
					} else if ($extension == 'swf' || $extension == 'SWF') {
						
						$thumb = $this->model_tool_image->resize('icono_swf.jpg', 100, 100);
					
					} else { 
					
						$thumb = $this->model_tool_image->resize(substr($file, strlen(DIR_IMAGE)), 100, 100);
											
					}
					
					$json[] = array(
						'file'     => substr($file, strlen(DIR_IMAGE . 'data/')),
						'filename' => basename($file),
						'size'     => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'thumb'    => $thumb,
					);
				}
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));	
	}	
	
	public function create() {
		
				
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->post['name']) || $this->request->post['name']) {
				$directory = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = 'Advertencia: Por favor seleccione una carpeta';
				}
				
				if (file_exists($directory . '/' . str_replace('../', '', $this->request->post['name']))) {
					$json['error'] = 'Advertencia: Ya existe una carpeta con el mismo nombre';
				}
			} else {
				$json['error'] = 'Advertencia: Por favor coloque un nuevo nombre';
			}
		} else {
			$json['error'] = 'Advertencia: Por favor seleccione una carpeta';
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = 'Advertencia: Permiso denegado';  
    	}
		
		if (!isset($json['error'])) {	
			mkdir($directory . '/' . str_replace('../', '', $this->request->post['name']), 0777);
			
			$json['success'] = 'Carpeta creada';
		}	
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function delete() {
		
		
		$json = array();
		
		if (isset($this->request->post['path'])) {
			$path = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['path']), '/');
			 
			if (!file_exists($path)) {
				$json['error'] = 'Advertencia: Por favor seleccione una carpeta o archivo';
			}
			
			if ($path == rtrim(DIR_IMAGE . 'data/', '/')) {
				$json['error'] = 'Advertencia: Usted no puede eliminar esta carpeta';
			}
		} else {
			$json['error'] = 'Advertencia: Por favor seleccione una carpeta o archivo';
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = 'Advertencia: Permiso denegado';  
    	}
		
		if (!isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}
			
			$json['success'] = 'Su carpeta o archivo ha sido eliminado';
		}				
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		
		if (!$handle) {
			return false;
		}
		
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		
		closedir($handle);
		
		rmdir($directory);
		
		return true;
	}

	public function move() {
		
		
		$json = array();
		
		if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
			$from = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['from']), '/');
			
			if (!file_exists($from)) {
				$json['error'] = 'Advertencia: La carpeta o archivo no existe';
			}
			
			if ($from == DIR_IMAGE . 'data') {
				$json['error'] = 'Advertencia: No se puede modificar la carpeta predeterminada';
			}
			
			$to = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['to']), '/');

			if (!file_exists($to)) {
				$json['error'] = 'Advertencia: No se puede mover a una carpeta que no existe';
			}	
			
			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = 'Advertencia: Ya existe una carpeta con el mismo nombre';
			}
		} else {
			$json['error'] = 'Advertencia: Por favor seleccione una carpeta';
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = 'Advertencia: Permiso denegado';  
    	}
		
		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));
			
			$json['success'] = 'Su carpeta o archivo ha sido movido';
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}	
	
	public function copy() {
		
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
				$json['error'] = 'Advertencia: El nombre debe contener entre 3 y 255 caracteres';
			}
				
			$old_name = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['path']), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
				$json['error'] = 'Advertencia: No se puede copiar esta carpeta o archivo';
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', $this->request->post['name'] . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = 'Advertencia: Ya existe una carpeta con el mismo nombre';
			}			
		} else {
			$json['error'] = 'Advertencia: Por favor seleccione una carpeta o archivo';
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = 'Advertencia: Permiso denegado';  
    	}	
		
		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}
			
			$json['success'] = 'Su carpeta o archivo ha sido copiado';
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));	
	}

	function recursiveCopy($source, $destination) { 
		$directory = opendir($source); 
		
		@mkdir($destination); 
		
		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		} 
		
		closedir($directory); 
	} 

	public function folders() {
		$this->response->setOutput($this->recursiveFolders(DIR_IMAGE . 'data/'));	
	}
	
	protected function recursiveFolders($directory) {
		$output = '';
		
		$output .= '<option value="' . substr($directory, strlen(DIR_IMAGE . 'data/')) . '">' . substr($directory, strlen(DIR_IMAGE . 'data/')) . '</option>';
		
		$directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);
		
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		
		return $output;
	}
	
	public function rename() {
		
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
				$json['error'] = 'Advertencia: El nombre debe contener entre 3 y 255 caracteres';
			}
				
			$old_name = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['path']), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
				$json['error'] = 'Advertencia: No se puede renombrar esta carpeta';
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . str_replace('../', '', $this->request->post['name'] . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = 'Advertencia: Ya existe una carpeta con el mismo nombre';
			}			
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = 'Advertencia: Permiso denegado';  
    	}
		
		if (!isset($json['error'])) {
			rename($old_name, $new_name);
			
			$json['success'] = 'Su carpeta o archivo ha sido renombrado';
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	public function upload() {
		
		
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {
				if ((strlen(utf8_decode($this->request->files['image']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image']['name'])) > 255)) {
					$json['error'] = 'Advertencia: El nombre debe contener entre 3 y 255 caracteres';
				}
					
				$directory = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');
				
				if (!is_dir($directory)) {
					$json['error'] = 'Advertencia: Por favor seleccione una carpeta';
				}
				
				if ($this->request->files['image']['size'] > 614400) {
					$json['error'] = 'Advertencia: El archivo es muy pesado por favor mantenga un minimo de 600 Kb';
				}
				
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
					'application/x-shockwave-flash',
					'application/pdf',
					'application/vnd.ms-excel',
					
				);
						
				if (!in_array($this->request->files['image']['type'], $allowed)) {
					$json['error'] = 'Advertencia: Tipo de archivo incorrecto';
				}
				
				$allowed = array(
					'.jpg',
					'.jpeg',
					'.gif',
					'.png',
					'.flv',
					'.swf',
					'.csv',
					'.xls',
					'.pdf',
				);
						
				if (!in_array(strtolower(strrchr($this->request->files['image']['name'], '.')), $allowed)) {
					$json['error'] = 'Advertencia: Tipo de archivo incorrecto';
				}

				
				if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $this->request->files['image']['error'];
				}			
			} else {
				$json['error'] = 'Advertencia: Por favor selecione un archivo';
			}
		} else {
			$json['error'] = 'Advertencia: Por favor seleccione una carpeta';
		}
		
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = 'Advertencia: Permiso denegado';  
    	}
		
		if (!isset($json['error'])) {	
			if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . basename($this->request->files['image']['name']))) {		
				$json['success'] = 'Su archivo ha sido cargado';
			} else {
				$json['error'] = 'Advertencia: El archivo no pudo ser cargado por una raz&oacute;n desconocida';
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
} 
?>
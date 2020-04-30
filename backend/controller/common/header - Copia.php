<?php 
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle(); 
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->idioma->get('code');
//		$this->data['direction'] = $this->idioma->get('direction');
				
		$this->data['heading_title'] = 'Panel Administrativo';
		
		$this->data['text_import'] = 'Importar';
		$this->data['text_backup'] = 'Respaldar / Restaurar';
		$this->data['text_banner'] = 'Banners';
		$this->data['text_catalog'] = 'Catalogo';
		$this->data['text_contents'] = 'Contenidos';
		$this->data['text_category'] = 'Tipos de Evento';
		$this->data['text_confirm'] = '¡Eliminar/Quitar no se puede deshacer! ¿Est&aacute; seguro que desea continuar?';
		$this->data['text_country'] = 'Paises';
		$this->data['text_cliente'] = 'Clientes Registrados';
		$this->data['text_sale'] = 'Inscripciones';
		$this->data['text_transcripcion'] = 'Transcripciones';
		$this->data['text_documentation'] = 'Documentaci&oacute;n';
		$this->data['text_error_log'] = 'Registros de Error';
		$this->data['text_extension'] = 'Extensiones';
		$this->data['text_front'] = 'Hipereventos';
		$this->data['text_geo_zone'] = 'Geo Zonas';
		$this->data['text_home'] = 'Inicio';
		$this->data['text_dashboard'] = 'Indicadores';
		$this->data['text_help'] = 'Ayuda';
		$this->data['text_layout'] = 'Layouts';
      	$this->data['text_localisation'] = 'Ubicaci&oacute;n';
		$this->data['text_logout'] = 'Cerrar Sesi&oacute;n';
		$this->data['text_contact'] = 'Correo Electr&oacute;nico';
		$this->data['text_manufacturer'] = 'Patrocinantes';
		$this->data['text_corporativo'] = 'Clientes Corporativos';
		$this->data['text_aliado'] = 'Aliados';
		$this->data['text_module'] = 'Modulos';
		$this->data['text_banners'] = 'Banners';
		$this->data['text_noticias'] = 'Noticias';
		$this->data['text_calendario'] = 'Calendario';
		$this->data['text_fotos'] = 'Fotos';
		$this->data['text_videos'] = 'Videos';
		$this->data['text_preguntas'] = 'Preguntas Frecuentes';
		$this->data['text_opcion'] = 'Datos para Inscripci&oacute;n';
		$this->data['text_order'] = 'Solicitudes';
		$this->data['text_confirmacion'] = 'Confirmaciones';
		$this->data['text_order_tdc'] = 'Tarjeta de Cr&eacute;dito';
		$this->data['text_order_dt'] = 'Dep&oacute;sito / Transferencia';
		$this->data['text_depositos'] = 'Dep&oacute;sitos';
		$this->data['text_participantes'] = 'Participantes';
		$this->data['text_correos'] = 'Correos Electr&oacute;nicos';
		$this->data['text_order_status'] = 'Status de Inscripciones';
		$this->data['text_opencart'] = 'Inicio';
		$this->data['text_payment'] = 'M&eacute;todos de Pago';
		$this->data['text_product'] = 'Eventos';
		$this->data['text_reports'] = 'Reportes';
		$this->data['text_report_sale_order'] = 'Inscripciones';
		$this->data['text_report_sale_impuesto'] = 'Impuesto';
		$this->data['text_report_sale_shipping'] = 'Shipping';
		$this->data['text_report_sale_return'] = 'Returns';
		$this->data['text_report_sale_coupon'] = 'Coupons';
		$this->data['text_report_product_viewed'] = 'Eventos Visitados';
		$this->data['text_report_product_purchased'] = 'Eventos Inscritos';
		$this->data['text_report_cliente_order'] = 'Inscripciones de Clientes';
		$this->data['text_report_cliente_reward'] = 'Reward Points';
		$this->data['text_report_cliente_credit'] = 'Credit';
		$this->data['text_report_affiliate_commission'] = 'Commision';
		$this->data['text_report_sale_return'] = 'Returns';
		$this->data['text_report_product_purchased'] = 'Eventos Inscritos';
		$this->data['text_report_product_viewed'] = 'Eventos Visitados';
		$this->data['text_report_cliente_order'] = 'Inscripciones de Clientes';
		$this->data['text_review'] = 'Reviews';
		$this->data['text_return'] = 'Returns';
		$this->data['text_return_action'] = 'Return Actions';
		$this->data['text_return_reason'] = 'Return Reasons';
		$this->data['text_return_status'] = 'Return Statuses';
		$this->data['text_support'] = 'Support Forum';
		$this->data['text_shipping'] = 'Shipping';	
     	$this->data['text_setting'] = 'Configuraci&oacute;n';
		$this->data['text_stock_status'] = 'Status de Cupos';
		$this->data['text_system'] = 'Sistema';
		$this->data['text_impuestos_clase'] = 'Clases de Impuesto';
		$this->data['text_tools'] = 'Herramientas';
		$this->data['text_total'] = 'Totales en Solicitudes';
		$this->data['text_correcciones'] = 'Correcciones';
		$this->data['text_user'] = 'Usuarios';
		$this->data['text_user_group'] = 'Grupos de Usuario';
		$this->data['text_users'] = 'Usuarios';
		$this->data['text_voucher'] = 'Gift Vouchers';
		$this->data['text_voucher_theme'] = 'Voucher Themes';
      	$this->data['text_weight_class'] = 'Weight Classes';
		$this->data['text_length_class'] = 'Length Classes';
      	$this->data['text_zone'] = 'Estados';
		
		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = '';
			
			$this->data['home'] = $this->url->link('common/login', '', 'SSL');
		} else {			

			$this->data['logged'] = sprintf('Sesi&oacute;n iniciada como <span>%s</span>', $this->user->getUserName());

			$this->data['home'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['dashboard'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			
			$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
//			$this->data['import'] = $this->url->link('import/participantes', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['banner'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category'] = $this->url->link('catalog/tipos', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['country'] = $this->url->link('localidad/country', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['coupon'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['currency'] = $this->url->link('localidad/currency', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['cliente'] = $this->url->link('sale/cliente', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['cliente_group'] = $this->url->link('sale/cliente_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['download'] = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['feed'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');			
			$this->data['banners'] = $this->url->link('catalog/banners', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['noticias'] = $this->url->link('catalog/noticia', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['calendario'] = $this->url->link('catalog/calendario', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['fotos'] = $this->url->link('catalog/galeria', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['videos'] = $this->url->link('catalog/videos', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['preguntas'] = $this->url->link('catalog/preguntas', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['stores'] = array();
			
			$this->load->model('setting/store');
			
			$results = $this->model_setting_store->getStores();
			
			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}
			
			$this->data['geo_zone'] = $this->url->link('localidad/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['language'] = $this->url->link('localidad/idioma', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['contact'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['patrocinante'] = $this->url->link('catalog/patrocinante', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['corporativo'] = $this->url->link('catalog/corporativo', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['aliado'] = $this->url->link('catalog/aliado', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['opcion'] = $this->url->link('catalog/opcion', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['transcripcion'] = $this->url->link('catalog/transcripcion', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_tdc'] = $this->url->link('confirm/tdc', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_dt'] = $this->url->link('confirm/eventos', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['depositos'] = $this->url->link('sale/depositos', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['participantes'] = $this->url->link('sale/participantes', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['correos'] = $this->url->link('sale/correos', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_status'] = $this->url->link('localidad/order_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['payment'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['product'] = $this->url->link('catalog/evento', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_order'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_impuesto'] = $this->url->link('report/sale_impuesto', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_shipping'] = $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_return'] = $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_coupon'] = $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_viewed'] = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_purchased'] = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_cliente_order'] = $this->url->link('report/cliente_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_cliente_reward'] = $this->url->link('report/cliente_reward', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_cliente_credit'] = $this->url->link('report/cliente_credit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_affiliate_commission'] = $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_action'] = $this->url->link('localidad/return_action', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_reason'] = $this->url->link('localidad/return_reason', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_status'] = $this->url->link('localidad/return_status', 'token=' . $this->session->data['token'], 'SSL');			
			$this->data['shipping'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['store'] = HTTP_CATALOG;
			$this->data['stock_status'] = $this->url->link('localidad/stock_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['impuestos_clase'] = $this->url->link('localidad/impuesto_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['total'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['correcciones'] = $this->url->link('sale/correcciones', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher_theme'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['weight_class'] = $this->url->link('localidad/weight_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['length_class'] = $this->url->link('localidad/length_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['zone'] = $this->url->link('localidad/zone', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->template = 'common/header.tpl';
		
		$this->render();
	}
}
?>
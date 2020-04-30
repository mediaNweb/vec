<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="ISO-8859-1"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> -->
<!-- <html xmlns="http://www.w3.org/1999/xhtml" lang="<?php // echo $lang; ?>" xml:lang="<?php // echo $lang; ?>"> -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="layout/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="layout/stylesheet/multiupload/css/bootstrap.min.css">
<!-- Generic page styles -->
<!-- <link rel="stylesheet" href="css/multiupload/style.css"> -->
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<!-- <link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css"> -- >
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<!-- <link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css"> -->
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="layout/stylesheet/multiupload/css/multiupload/jquery.fileupload-ui.css">



<script type="text/javascript" src="layout/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="layout/javascript/jquery/ui/jquery-ui-1.8.9.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="layout/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.9.custom.css" />
<script type="text/javascript" src="layout/javascript/jquery/ui/external/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="layout/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="layout/javascript/jquery/superfish/js/superfish.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){
	
    // Confirm Delete
    $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm ('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
    	
    // Confirm Uninstall
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall',1) != -1) {
            if (!confirm ('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
});
</script>
</head>
<body>
<div id="container">
<div id="header">
  <div class="div1">
    <div class="div2"><img src="layout/image/logo.png" title="<?php echo $heading_title; ?>" onclick="location = '<?php echo $home; ?>'" /></div>
    <?php if ($logged) { ?>
    <div class="div3"><img src="layout/image/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;<?php echo $logged; ?></div>
    <?php } ?>
  </div>
  <?php if ($logged) { ?>
  <div id="menu">
    <ul class="left" style="display: none;">
      <li id="home"><a href="<?php echo $home; ?>" class="top"><?php echo $text_home; ?></a></li>
      <li id="dashboard"><a href="<?php echo $dashboard; ?>" class="top"><?php echo $text_dashboard; ?></a></li>
      <li id="catalog"><a class="top"><?php echo $text_catalog; ?></a>
        <ul>
          <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
          <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
          <li><a href="<?php echo $opcion; ?>"><?php echo $text_opcion; ?></a></li>
        </ul>
      </li>
      <li id="contents"><a class="top"><?php echo $text_contents; ?></a>
        <ul>
          <li><a href="<?php echo $patrocinante; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $corporativo; ?>"><?php echo $text_corporativo; ?></a></li>
          <li><a href="<?php echo $aliado; ?>"><?php echo $text_aliado; ?></a></li>
          <li><a href="<?php echo $banners; ?>"><?php echo $text_banners; ?></a></li>
          <li><a href="<?php echo $noticias; ?>"><?php echo $text_noticias; ?></a></li>
          <li><a href="<?php echo $calendario; ?>"><?php echo $text_calendario; ?></a></li>
          <li><a href="<?php echo $fotos; ?>"><?php echo $text_fotos; ?></a></li>
          <li><a href="<?php echo $videos; ?>"><?php echo $text_videos; ?></a></li>
          <li><a href="<?php echo $preguntas; ?>"><?php echo $text_preguntas; ?></a></li>
        </ul>
      </li>
      <li id="sale"><a class="top"><?php echo $text_sale; ?></a>
        <ul>
		  <li><a href="<?php echo $cliente; ?>"><?php echo $text_cliente; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $depositos; ?>"><?php echo $text_depositos; ?></a></li>
          <li><a class="parent"><?php echo $text_confirmacion; ?></a>
            <ul>
              <li><a href="<?php echo $order_tdc; ?>"><?php echo $text_order_tdc; ?></a></li>
              <li><a href="<?php echo $order_dt; ?>"><?php echo $text_order_dt; ?></a></li>
            </ul>
          </li>
		  <li><a href="<?php echo $participantes; ?>"><?php echo $text_participantes; ?></a></li>
		  <li><a href="<?php echo $correos; ?>"><?php echo $text_correos; ?></a></li>
        </ul>
      </li>
      <li id="transcripcion"><a href="<?php echo $transcripcion; ?>" class="top"><?php echo $text_transcripcion; ?></a></li>
      <li id="extension"><a class="top"><?php echo $text_extension; ?></a>
        <ul>
          <li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
          <li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
        </ul>
      </li>
      <li id="system"><a class="top"><?php echo $text_system; ?></a>
        <ul>
          <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
          <li><a class="parent"><?php echo $text_users; ?></a>
            <ul>
              <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
              <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_localisation; ?></a>
            <ul>
              <li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
              <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
              <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
              <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
              <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
              <li><a href="<?php echo $impuestos_clase; ?>"><?php echo $text_impuestos_clase; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_tools; ?></a>
            <ul>
              <li><a href="<?php echo $correcciones; ?>"><?php echo $text_correcciones; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
          <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
        </ul>
      </li>
      <li id="reports"><a class="top"><?php echo $text_reports; ?></a>
        <ul>
          <li><a class="parent"><?php echo $text_sale; ?></a>
            <ul>
              <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
              <li><a href="<?php echo $report_sale_impuesto; ?>"><?php echo $text_report_sale_impuesto; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_product; ?></a>
            <ul>
              <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
              <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_cliente; ?></a>
            <ul>
              <li><a href="<?php echo $report_cliente_order; ?>"><?php echo $text_report_cliente_order; ?></a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
    <ul class="right">
      <li id="store"><a onclick="window.open('<?php echo $store; ?>');" class="top"><?php echo $text_front; ?></a>
        <ul>
          <?php foreach ($stores as $stores) { ?>
          <li><a onclick="window.open('<?php echo $stores['href']; ?>');"><?php echo $stores['name']; ?></a></li>
          <?php } ?>
        </ul>
      </li>
      <li id="store"><a class="top" href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
    </ul>
    <script type="text/javascript"><!--
$(document).ready(function() {
	$('#menu > ul').superfish({
		hoverClass	 : 'sfHover',
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false, 
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});
	
	$('#menu > ul').css('display', 'block');
});
 
function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';
	
	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');
				
				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}
	
	return urlVarValue;
} 

$(document).ready(function() {
	route = getURLVar('route');
	
	if (!route) {
		$('#dashboard').addClass('selected');
	} else {
		part = route.split('/');
		
		url = part[0];
		
		if (part[1]) {
			url += '/' + part[1];
		}
		
		$('a[href*=\'' + url + '\']').parents('li[id]').addClass('selected');
	}
});
//--></script> 
  </div>
  <?php } ?>
</div>

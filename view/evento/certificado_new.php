<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="css/certificado_foto_style.css" rel="stylesheet" type="text/css">
	<title>
		<?php echo $eventos_titulo; ?> -
		<?php echo $text_certificate; ?> -
		<?php echo $nombre; ?>
	</title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();">
	<div class="container">
		<div class="page1">
			<div class="bg-img">
				<img src="<?php echo $eventos_certificado; ?>" width="867" height="673" />
			</div>
			<div class="col-1">
				<div class="row-1">
					<div class="foto-container">
						<img src="<?php echo $foto; ?>" width="437" height="296" />
					</div>
				</div>
				<div class="row-2">
					<div class="column-left">
						<?php echo $text_result_cell_gun; ?> <br />
						<span style="font-size:18px; font-weight: bold;">
							<?php echo $time_oficial; ?>
						</span>
					</div>
					<div class="column-center">
						<?php echo $text_result_cell_net; ?> <br />
						<span style="font-size:18px; font-weight: bold;">
							<?php echo $time_tag; ?>
						</span>
					</div>
					<div class="column-right">
						<?php echo $text_certificate_pace; ?> <br />
						<span style="font-size:18px; font-weight: bold;">
							<?php echo $ritmo; ?>
						</span>
					</div>
				</div>
				<div class="divider-space"></div>
				<div class="divider-space"></div>
				<div class="row-3">
					<div class="column-left">
						<?php echo $text_certificate_overall; ?>
						<span style="font-size:18px; font-weight: bold;">
							<?php echo $pos_general; ?>
						</span>
					</div>
					<div class="column-center">
						<?php echo $text_certificate_gender; ?>
						<span style="font-size:18px; font-weight: bold;">
							<?php echo $pos_genero; ?>
						</span>
					</div>
					<div class="column-right">
						<?php echo $text_certificate_bracket; ?>
						<span style="font-size:18px; font-weight: bold;">
							<?php echo $pos_categoria; ?>
						</span>
					</div>
				</div>
				<div class="divider-space"></div>
			</div>
			<div class="col-2">
				<div class="row-1">
					<div class="txt-name">
						<?php echo $nombre; ?>
					</div>
					<div class="txt-event">
						<?php echo $eventos_titulo; ?>
					</div>
					<div class="txt-date">
						<?php echo $eventos_fecha; ?>
					</div>
					<div class="txt-bracket">
						<span style="font-weight:normal;">
							<?php echo $text_result_cell_bracket_title; ?> </span>
						<?php echo $categoria; ?>
					</div>
					<div class="txt-bib">
						<span style="font-weight:normal;">
							<?php echo $text_certificate_bib; ?> </span>
						<?php echo $numero; ?>
					</div>
				</div>
				<div class="divider-space"></div>
			</div>

			<div class="row-4">
				<div style="margin:auto; padding: 0px; width:100%; text-align: center;">
					<span style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
						<?php echo $text_certificate_footer; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!-- AddToAny BEGIN -->
	<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
		<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
		<a class="a2a_button_facebook"></a>
		<a class="a2a_button_twitter"></a>
		<a class="a2a_button_google_plus"></a>
		<a class="a2a_button_email"></a>
		<a class="a2a_button_whatsapp"></a>
		<a class="a2a_button_pinterest"></a>
	</div>
	<script>
		var a2a_config = a2a_config || {};
		a2a_config.linkurl = "https://virtualworldruns.com/index.php?route=evento/certificado&eventos_id=<?php echo $eventos_id; ?>&numero=<?php echo $numero; ?>";
		a2a_config.onclick = 1;
		a2a_config.locale = "nl";
		a2a_config.color_main = "ba2626";
		a2a_config.color_border = "ba2626";
		a2a_config.color_link_text = "000000";
		a2a_config.color_link_text_hover = "FFFFFF";
		a2a_config.color_arrow_hover = "fff";
	</script>
	<script async src="https://static.addtoany.com/menu/page.js"></script>
	<!-- AddToAny END -->
</body>

</html>
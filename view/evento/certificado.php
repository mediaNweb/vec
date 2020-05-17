<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="css/certificado_general_style.css" rel="stylesheet" type="text/css">
	<title>
		<?php echo $eventos_titulo; ?> -
		<?php echo $text_certificate; ?> -
		<?php echo $nombre; ?>
	</title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<div class="container">
		<div class="row-1">
			<div class="txt-name">
				<?php echo $nombre . ' ' . $apellido; ?>
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
		<div class="row-2">
			<div class="column-left">
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
		<div class="row-4">
			<div style="margin:auto; padding: 0px; width:100%; text-align: center;">
				<span style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
					<?php echo $text_certificate_footer; ?>
				</span>
			</div>
		</div>
	</div>
</body>

</html>
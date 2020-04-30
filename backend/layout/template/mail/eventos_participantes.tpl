<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style type="text/css">
body {
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}

body, td, th, input, textarea, select, a {
	font-size: 12px;
}

p {
	margin-top: 0px;
	margin-bottom: 20px;
}

a, a:visited, a b {
	color: #378DC1;
	text-decoration: underline;
	cursor: pointer;
}

a:hover {
	text-decoration: none;
}

a img {
	border: none;
}

#container {
	width: 680px;
}

#logo {
	margin-bottom: 20px;
}

table.list {
	border-collapse: collapse;
	width: 100%;
	border-top: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;
	margin-bottom: 20px;
}

table.list td {
	border-right: 1px solid #DDDDDD;
	border-bottom: 1px solid #DDDDDD;
}

table.list thead td {
	background-color: #EFEFEF;
	padding: 0px 5px;
}

table.list thead td a, .list thead td {
	text-decoration: none;
	color: #222222;
	font-weight: bold;
}

table.list tbody td a {
	text-decoration: underline;
}

table.list tbody td {
	vertical-align: top;
	padding: 0px 5px;
}

table.list .left {
	text-align: left;
	padding: 7px;
}

table.list .right {
	text-align: right;
	padding: 7px;
}

table.list .center {
	text-align: center;
	padding: 7px;
}
</style>
</head>
<body>
<div id="container"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" id="logo" /></a> <br />
	<br />
	<p><?php echo $text_greeting; ?></p>
	<table class="list">
		<thead>
			<tr>
				<td class="left"><?php echo $text_customer_detail; ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">
				<b><?php echo $text_number; ?></b> <?php echo $number; ?><br />
				<b><?php echo $text_customer_id; ?></b> <?php echo $customer_id; ?><br />
				<b><?php echo $text_name; ?></b> <?php echo $name; ?><br />
				<b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
				<?php if ($group) { ?>
					<b><?php echo $text_group; ?></b> <?php echo $group; ?><br />
				<?php } ?>
				<?php if ($category) { ?>
					<b><?php echo $text_category; ?></b> <?php echo $category; ?><br />
				<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
	<table class="list">
		<thead>
			<tr>
				<td class="left"><?php echo $text_order_detail; ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">
				<b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
				<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
				<?php if ($payment_method) { ?>
					<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
				<?php } ?>
				<b><?php echo $text_event; ?></b> <?php echo $event; ?><br />
				<b><?php echo $text_event_date; ?></b> <?php echo $event_date; ?><br />
				</td>
			</tr>
		</tbody>
	</table>
	<table class="list">
		<thead>
			<tr>
				<td class="left"><?php echo $text_materials; ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="left">
					<?php echo html_entity_decode($materials);?><br />
				</td>
			</tr>
		</tbody>
	</table>
	<p><?php echo $text_footer; ?></p>
</div>
</body>
</html>

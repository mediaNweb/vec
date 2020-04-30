<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['layout/template/confirm/href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="layout/template/confirm/layout/image/order.png" alt="" /> <?php echo $heading_title; ?> - <?php echo $to_confirm; ?></h1>
		<div class="buttons">
			<a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
			<a onclick="$('#form').attr('action', '<?php echo $confirm; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_confirm; ?></span></a>
		</div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list" style="table-layout: fixed; width: 100%;">
          <thead>
            <tr>
              <td width="15" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'o.order_id') { ?>
                <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'cliente') { ?>
                <a href="<?php echo $sort_cliente; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_cliente; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_cliente; ?>"><?php echo $column_cliente; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'o.payment_number') { ?>
                <a href="<?php echo $sort_payment_number; ?>" class="<?php echo strtolower($payment_number); ?>"><?php echo $column_payment_number; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_payment_number; ?>"><?php echo $column_payment_number; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'o.payment_date') { ?>
                <a href="<?php echo $sort_payment_date; ?>" class="<?php echo strtolower($payment_date); ?>"><?php echo $column_payment_date; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_payment_date; ?>"><?php echo $column_payment_date; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'evento') { ?>
                <a href="<?php echo $sort_evento; ?>" class="<?php echo strtolower($evento); ?>"><?php echo $column_evento; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_evento; ?>"><?php echo $column_evento; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'o.total') { ?>
                <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($total); ?>"><?php echo $column_total; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="8" style="width: 95%;" /></td>
              <td><input type="text" name="filter_cliente" value="<?php echo $filter_cliente; ?>" style="width: 95%;" /></td>
              <td><input type="text" name="filter_payment_number" value="<?php echo $filter_payment_number; ?>" style="width: 95%;" /></td>
              <td><input type="text" name="filter_payment_date" value="<?php echo $filter_payment_date; ?>" size="12" class="date" style="width: 95%;" /></td>
              <td align="left"><input type="text" name="filter_evento" value="<?php echo $filter_evento; ?>" size="4" style="width: 95%;" /></td>
              <td align="right"><input type="text" name="filter_total" value="<?php echo $filter_total; ?>" size="4" style="text-align: right; width: 95%;" /></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
            <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($order['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $order['order_id']; ?></td>
              <td class="left"><?php echo $order['cliente']; ?></td>
              <td class="left" style="overflow: hidden;"><?php echo $order['payment_number']; ?></td>
              <td class="left"><?php echo $order['payment_date']; ?></td>
              <td class="left"><?php echo $order['evento']; ?></td>
              <td class="right"><?php echo $order['total']; ?></td>
              <td class="right"><?php foreach ($order['action'] as $action) { ?>
                [ <a href="<?php echo $action['layout/template/confirm/href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=confirm/dt&token=<?php echo $token; ?>&eventos_id=<?php echo $eventos_id; ?>';
	
	var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
	
	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}
	
	var filter_cliente = $('input[name=\'filter_cliente\']').attr('value');
	
	if (filter_cliente) {
		url += '&filter_cliente=' + encodeURIComponent(filter_cliente);
	}
	
	var filter_payment_number = $('input[name=\'filter_payment_number\']').attr('value');
	
	if (filter_payment_number) {
		url += '&filter_payment_number=' + encodeURIComponent(filter_payment_number);
	}

	var filter_payment_date = $('input[name=\'filter_payment_date\']').attr('value');
	
	if (filter_payment_date) {
		url += '&filter_payment_date=' + encodeURIComponent(filter_payment_date);
	}

	var filter_evento = $('input[name=\'filter_evento\']').attr('value');

	if (filter_evento) {
		url += '&filter_evento=' + encodeURIComponent(filter_evento);
	}	

	var filter_total = $('input[name=\'filter_total\']').attr('value');

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}	
	
	location = url;
}
//--></script>  
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<?php echo $footer; ?>
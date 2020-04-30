<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['layout/template/sale/href']; ?>"><?php echo $breadcrumb['text']; ?></a>
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
      <h1><img src="layout/template/sale/layout/image/cliente.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
<!--	  	<a onclick="$('form').attr('action', '<?php // echo $approve; ?>'); $('form').submit();" class="button"><span><?php // echo $button_approve; ?></span></a> -->
		<a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a>
		<a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
	</div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'c.clientes_id') { ?>
                <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.clientes_nombre') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.clientes_email') { ?>
                <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_clientes_email; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_email; ?>"><?php echo $column_clientes_email; ?></a>
                <?php } ?></td>
<!--
              <td class="left"><?php if ($sort == 'cliente_group') { ?>
                <a href="<?php // echo $sort_cliente_group; ?>" class="<?php // echo strtolower($order); ?>"><?php // echo $column_cliente_group; ?></a>
                <?php } else { ?>
                <a href="<?php // echo $sort_cliente_group; ?>"><?php // echo $column_cliente_group; ?></a>
                <?php } ?></td>
-->				
              <td class="left"><?php if ($sort == 'c.clientes_status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_clientes_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_clientes_status; ?></a>
                <?php } ?></td>
<!--
              <td class="left"><?php if ($sort == 'c.approved') { ?>
                <a href="<?php // echo $sort_approved; ?>" class="<?php // echo strtolower($order); ?>"><?php // echo $column_approved; ?></a>
                <?php } else { ?>
                <a href="<?php // echo $sort_approved; ?>"><?php // echo $column_approved; ?></a>
                <?php } ?></td>
-->				
              <td class="left"><?php if ($sort == 'c.clientes_ip') { ?>
                <a href="<?php echo $sort_ip; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ip; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_ip; ?>"><?php echo $column_ip; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.clientes_fdc') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_id" value="<?php echo $filter_id; ?>" /></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
<!--
              <td><select name="filter_cliente_group_id">
                  <option value="*"></option>
                  <?php // foreach ($cliente_groups as $cliente_group) { ?>
                  <?php // if ($cliente_group['cliente_group_id'] == $filter_cliente_group_id) { ?>
                  <option value="<?php // echo $cliente_group['cliente_group_id']; ?>" selected="selected"><?php // echo $cliente_group['name']; ?></option>
                  <?php // } else { ?>
                  <option value="<?php // echo $cliente_group['cliente_group_id']; ?>"><?php // echo $cliente_group['name']; ?></option>
                  <?php // } ?>
                  <?php // } ?>
                </select></td>
-->				
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
<!--
              <td><select name="filter_approved">
                  <option value="*"></option>
                  <?php // if ($filter_approved) { ?>
                  <option value="1" selected="selected"><?php // echo $text_yes; ?></option>
                  <?php // } else { ?>
                  <option value="1"><?php // echo $text_yes; ?></option>
                  <?php // } ?>
                  <?php // if (!is_null($filter_approved) && !$filter_approved) { ?>
                  <option value="0" selected="selected"><?php // echo $text_no; ?></option>
                  <?php // } else { ?>
                  <option value="0"><?php // echo $text_no; ?></option>
                  <?php // } ?>
                </select></td>
-->				
              <td><input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" /></td>
              <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
            <?php if ($clientes) { ?>
            <?php foreach ($clientes as $cliente) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($cliente['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $cliente['clientes_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $cliente['clientes_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $cliente['clientes_id']; ?></td>
              <td class="left"><?php echo $cliente['name']; ?></td>
              <td class="left"><?php echo $cliente['clientes_email']; ?></td>
<!--              <td class="left"><?php // echo $cliente['cliente_group']; ?></td> -->
              <td class="left"><?php echo $cliente['clientes_status']; ?></td>
<!--              <td class="left"><?php // echo $cliente['approved']; ?></td> -->
              <td class="left"><?php echo $cliente['ip']; ?></td>
              <td class="left"><?php echo $cliente['date_added']; ?></td>
              <td class="right">[ <a href="<?php echo $cliente['layout/template/sale/login']; ?>" target="_blank"><?php echo $text_login; ?></a> ]
                <?php foreach ($cliente['action'] as $action) { ?>
                [ <a href="<?php echo $action['layout/template/sale/href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=sale/cliente&token=<?php echo $token; ?>';
	
	var filter_id = $('input[name=\'filter_id\']').attr('value');
	
	if (filter_id) {
		url += '&filter_id=' + encodeURIComponent(filter_id);
	}

	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
/*
	var filter_cliente_group_id = $('select[name=\'filter_cliente_group_id\']').attr('value');
	
	if (filter_cliente_group_id != '*') {
		url += '&filter_cliente_group_id=' + encodeURIComponent(filter_cliente_group_id);
	}	
*/
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	
/*
	var filter_approved = $('select[name=\'filter_approved\']').attr('value');
	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}	
*/
	
	var filter_ip = $('input[name=\'filter_ip\']').attr('value');
	
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
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
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
  <div class="box">
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
      <h1><img src="layout/template/sale/layout/image/cliente.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
		  <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
		  <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
	  </div>
    </div>
    <div class="content">
      <div id="htabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a>
<!--
        <?php if ($clientes_id) { ?>
        <a href="#tab-transaction"><?php echo $tab_transaction; ?></a><a href="#tab-reward"><?php echo $tab_reward; ?></a>
        <?php } ?>
-->
        <a href="#tab-ip"><?php echo $tab_ip; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="vtabs" class="vtabs"><a href="#tab-cliente"><?php echo $tab_general; ?></a>
            <?php $address_row = 1; ?>
            <?php foreach ($addresses as $address) { ?>
            <a href="#tab-address-<?php echo $address_row; ?>" id="address-<?php echo $address_row; ?>"><?php echo $tab_address . ' ' . $address_row; ?>&nbsp;<img src="layout/template/sale/layout/image/delete.png" alt="" onclick="$('#vtabs a:first').trigger('click'); $('#address-<?php echo $address_row; ?>').remove(); $('#tab-address-<?php echo $address_row; ?>').remove(); return false;" /></a>
            <?php $address_row++; ?>
            <?php } ?>
            <span id="address-add"><?php echo $button_add_address; ?>&nbsp;<img src="layout/template/sale/layout/image/add.png" alt="" onclick="addAddress();" /></span></div>
          <div id="tab-cliente" class="vtabs-content">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_id; ?></td>
                <td><input type="text" name="clientes_id" value="<?php echo $clientes_id; ?>" />
                  <?php if ($error_clientes_id) { ?>
                  <span class="error"><?php echo $error_clientes_id; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_nombre; ?></td>
                <td><input type="text" name="clientes_nombre" value="<?php echo $clientes_nombre; ?>" />
                  <?php if ($error_clientes_nombre) { ?>
                  <span class="error"><?php echo $error_clientes_nombre; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_apellido; ?></td>
                <td><input type="text" name="clientes_apellido" value="<?php echo $clientes_apellido; ?>" />
                  <?php if ($error_clientes_apellido) { ?>
                  <span class="error"><?php echo $error_clientes_apellido; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_genero; ?></td>
                <td>
					<select name="clientes_genero">
						<option <?php echo ($clientes_genero == '') ? 'selected=\"selected\"' : '' ; ?> value="" >--G&eacute;nero--</option>
						<option <?php echo ($clientes_genero == 'M') ? 'selected=\"selected\"' : '' ; ?> value="M">Masculino</option>
						<option <?php echo ($clientes_genero == 'F') ? 'selected=\"selected\"' : '' ; ?> value="F">Femenino</option>
					</select>
			    </td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_fdn; ?></td>
                <td><input type="text" name="clientes_fdn" value="<?php echo $clientes_fdn; ?>" class="date" /></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_tel; ?></td>
                <td><input type="text" name="clientes_tel" value="<?php echo $clientes_tel; ?>" />
                  <?php if ($error_clientes_tel) { ?>
                  <span class="error"><?php echo $error_clientes_tel; ?></span>
                  <?php  } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_cel; ?></td>
                <td><input type="text" name="clientes_cel" value="<?php echo $clientes_cel; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_pin; ?></td>
                <td><input type="text" name="clientes_pin" value="<?php echo $clientes_pin; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_twitter; ?></td>
                <td><input type="text" name="clientes_twitter" value="<?php echo $clientes_twitter; ?>" /></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_email; ?></td>
                <td><input type="text" name="clientes_email" value="<?php echo $clientes_email; ?>" />
                  <?php if ($error_clientes_email) { ?>
                  <span class="error"><?php echo $error_clientes_email; ?></span>
                  <?php  } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_password; ?></td>
                <td><input type="password" name="password" value="<?php echo $password; ?>"  />
                  <br />
                  <?php if ($error_password) { ?>
                  <span class="error"><?php echo $error_password; ?></span>
                  <?php  } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_confirm; ?></td>
                <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
                  <?php if ($error_confirm) { ?>
                  <span class="error"><?php echo $error_confirm; ?></span>
                  <?php  } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_id_sanguineo; ?></td>
                <td><select name="clientes_id_sanguineo" id="clientes_id_sanguineo" tabindex="20">
						<option value="" selected="selected">--Grupo sanguineo--</option>
						<?php 
							foreach ($grupos as $grupo) { 
							?>
							<?php if ($grupo['grupo_sanguineo_id'] == $clientes_id_sanguineo) { ?>
								<option selected="selected" value="<?php echo $grupo['grupo_sanguineo_id']; ?>"><?php echo $grupo['grupo_sanguineo_nombre']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $grupo['grupo_sanguineo_id']; ?>"><?php echo $grupo['grupo_sanguineo_nombre']; ?></option>
								<?php } ?>
							<?php } ?>
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_talla; ?></td>
				<td><select id="clientes_talla" name="clientes_talla" tabindex="22">
					<option selected="selected" value="">--Talla--</option>
					<option <?php echo ($clientes_talla == 'XS') ? 'selected=\"selected\"' : '' ; ?> value="XS">XS (Extra Peque&ntilde;a)</option>
					<option <?php echo ($clientes_talla == 'S') ? 'selected=\"selected\"' : '' ; ?> value="S">S (Peque&ntilde;a)</option>
					<option <?php echo ($clientes_talla == 'M') ? 'selected=\"selected\"' : '' ; ?> value="M">M (Mediana)</option>
					<option <?php echo ($clientes_talla == 'L') ? 'selected=\"selected\"' : '' ; ?> value="L">L (Grande)</option>
					<option <?php echo ($clientes_talla == 'XL') ? 'selected=\"selected\"' : '' ; ?> value="XL">XL (Extra Grande)</option>
				</select></td>
              </tr>
			  <tr>
                <td><?php echo $entry_clientes_boletin; ?></td>
                <td><select name="clientes_boletin">
                    <?php if ($clientes_boletin) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
<!--
              <tr>
                <td><?php // echo $entry_cliente_group; ?></td>
                <td><select name="cliente_group_id">
                    <?php // foreach ($cliente_groups as $cliente_group) { ?>
                    <?php // if ($cliente_group['cliente_group_id'] == $cliente_group_id) { ?>
                    <option value="<?php // echo $cliente_group['cliente_group_id']; ?>" selected="selected"><?php // echo $cliente_group['name']; ?></option>
                    <?php // } else { ?>
                    <option value="<?php // echo $cliente_group['cliente_group_id']; ?>"><?php // echo $cliente_group['name']; ?></option>
                    <?php // } ?>
                    <?php // } ?>
                  </select></td>
              </tr>
-->			  
              <tr>
                <td><?php echo $entry_clientes_status; ?></td>
                <td><select name="clientes_status">
                    <?php if ($clientes_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
            </table>
          </div>
          <?php $address_row = 1; ?>
          <?php foreach ($addresses as $address) { ?>
          <div id="tab-address-<?php echo $address_row; ?>" class="vtabs-content">
            <input type="hidden" name="address[<?php echo $address_row; ?>][clientes_direcciones_id]" value="<?php echo $address['clientes_direcciones_id']; ?>" />
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_direcciones_calle; ?></td>
                <td><input type="text" name="address[<?php echo $address_row; ?>][clientes_direcciones_calle]" value="<?php echo $address['clientes_direcciones_calle']; ?>" />
                  <?php if (isset($error_address_clientes_direcciones_calle[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_clientes_direcciones_calle[$address_row]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_direcciones_urbanizacion; ?></td>
                <td><input type="text" name="address[<?php echo $address_row; ?>][clientes_direcciones_urbanizacion]" value="<?php echo $address['clientes_direcciones_urbanizacion']; ?>" />
                  <?php if (isset($error_address_clientes_direcciones_urbanizacion[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_clientes_direcciones_urbanizacion[$address_row]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_clientes_direcciones_casa; ?></td>
                <td>
					<input type="text" name="address[<?php echo $address_row; ?>][clientes_direcciones_casa]" value="<?php echo $address['clientes_direcciones_casa']; ?>" />
				</td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_direcciones_municipio; ?></td>
                <td><input type="text" name="address[<?php echo $address_row; ?>][clientes_direcciones_municipio]" value="<?php echo $address['clientes_direcciones_municipio']; ?>" />
                  <?php if (isset($error_address_clientes_direcciones_municipio[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_clientes_direcciones_municipio[$address_row]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_direcciones_ciudad; ?></td>
                <td><input type="text" name="address[<?php echo $address_row; ?>][clientes_direcciones_ciudad]" value="<?php echo $address['clientes_direcciones_ciudad']; ?>" />
                  <?php if (isset($error_address_clientes_direcciones_ciudad[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_clientes_direcciones_ciudad[$address_row]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_clientes_direcciones_postal; ?></td>
                <td><input type="text" name="address[<?php echo $address_row; ?>][clientes_direcciones_postal]" value="<?php echo $address['clientes_direcciones_postal']; ?>" /></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_country; ?></td>
                <td><select name="address[<?php echo $address_row; ?>][paises_id]" id="address[<?php echo $address_row; ?>][paises_id]" onchange="$('select[name=\'address[<?php echo $address_row; ?>][estados_id]\']').load('index.php?route=sale/cliente/estado&token=<?php echo $token; ?>&paises_id=' + this.value + '&estados_id=<?php echo $address['estados_id']; ?>');">
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($paises as $country) { ?>
                    <?php if ($country['paises_id'] == $address['paises_id']) { ?>
                    <option value="<?php echo $country['paises_id']; ?>" selected="selected"><?php echo $country['paises_nombre']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $country['paises_id']; ?>"><?php echo $country['paises_nombre']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if (isset($error_address_country[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_country[$address_row]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
                <td><select name="address[<?php echo $address_row; ?>][estados_id]">
                  </select>
                  <?php if (isset($error_address_zone[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_zone[$address_row]; ?></span>
                  <?php } ?></td>
              </tr>
			  <tr>
                <td><?php echo $entry_default; ?></td>
                <td>
                <?php if ((isset($address['default']) && $address['default']) || count($addresses) == 1) { ?>
                <input type="radio" name="address[<?php echo $address_row; ?>][default]" value="<?php echo $address_row; ?>" checked="checked" /></td>
                <?php } else { ?>
                <input type="radio" name="address[<?php echo $address_row; ?>][default]" value="<?php echo $address_row; ?>" />
				</td>
                <?php } ?>
              </tr>
            </table>
            <script type="text/javascript"><!--
		    $('select[name=\'address[<?php echo $address_row; ?>][estados_id]\']').load('index.php?route=sale/cliente/estado&token=<?php echo $token; ?>&paises_id=<?php echo $address['paises_id']; ?>&estados_id=<?php echo $address['estados_id']; ?>');
		    //--></script> 
          </div>
          <?php $address_row++; ?>
          <?php } ?>
        </div>
<!--
        <?php if ($clientes_id) { ?>
        <div id="tab-transaction">
          <table class="form">
            <tr>
              <td><?php echo $entry_description; ?></td>
              <td><input type="text" name="description" value="" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_amount; ?></td>
              <td><input type="text" name="amount" value="" /></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right;"><a id="button-reward" class="button" onclick="addTransaction();"><span><?php echo $button_add_transaction; ?></span></a></td>
            </tr>
          </table>
          <div id="transaction"></div>
        </div>
        <div id="tab-reward">
          <table class="form">
            <tr>
              <td><?php echo $entry_description; ?></td>
              <td><input type="text" name="description" value="" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_points; ?></td>
              <td><input type="text" name="points" value="" /></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right;"><a id="button-reward" class="button" onclick="addRewardPoints();"><span><?php echo $button_add_reward; ?></span></a></td>
            </tr>
          </table>
          <div id="reward"></div>
        </div>
        <?php } ?>
-->
        <div id="tab-ip">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $column_ip; ?></td>
                <td class="right"><?php echo $column_total; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($ips) { ?>
              <?php foreach ($ips as $ip) { ?>
              <tr>
                <td class="left"><a onclick="window.open('http://www.geoiptool.com/en/?IP=<?php echo $ip['ip']; ?>');"><?php echo $ip['ip']; ?></a></td>
                <td class="right"><a onclick="window.open('<?php echo $ip['filter_ip']; ?>');"><?php echo $ip['total']; ?></a></td>
                <td class="left"><?php echo $ip['date_added']; ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var address_row = <?php echo $address_row; ?>;

function addAddress() {	
	html  = '<div id="tab-address-' + address_row + '" class="vtabs-content" style="display: none;">';
	html += '  <input type="hidden" name="address[' + address_row + '][clientes_direcciones_id]" value="" />';
	html += '  <table class="form">'; 
	html += '    <tr>';
    html += '	   <td><?php echo $entry_clientes_direcciones_calle; ?></td>';
    html += '	   <td><input type="text" name="address[' + address_row + '][clientes_direcciones_calle]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_clientes_direcciones_urbanizacion; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][clientes_direcciones_urbanizacion]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_clientes_direcciones_casa; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][clientes_direcciones_casa]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_clientes_direcciones_municipio; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][clientes_direcciones_municipio]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_clientes_direcciones_ciudad; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][clientes_direcciones_ciudad]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_clientes_direcciones_postal; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][clientes_direcciones_postal]" value="" /></td>';
    html += '    </tr>';
    html += '      <td><?php echo $entry_country; ?></td>';
    html += '      <td><select name="address[' + address_row + '][paises_id]" onchange="$(\'select[name=\\\'address[' + address_row + '][estados_id]\\\']\').load(\'index.php?route=sale/cliente/estado&token=<?php echo $token; ?>&paises_id=\' + this.value + \'&estados_id=0\');">';
    html += '         <option value=""><?php echo $text_select; ?></option>';
    <?php foreach ($paises as $country) { ?>
    html += '         <option value="<?php echo $country['paises_id']; ?>"><?php echo addslashes($country['paises_nombre']); ?></option>';
    <?php } ?>
    html += '      </select></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_zone; ?></td>';
    html += '      <td><select name="address[' + address_row + '][estados_id]"><option value="false"><?php echo ' --- Ninguno --- '; ?></option></select></td>';
    html += '    </tr>';
	html += '    <tr>';
    html += '      <td><?php echo $entry_default; ?></td>';
    html += '      <td><input type="radio" name="address[' + address_row + '][default]" value="1" /></td>';
    html += '    </tr>';
    html += '  </table>';
    html += '</div>';
	
	$('#tab-general').append(html);
	
	$('#address-add').before('<a href="#tab-address-' + address_row + '" id="address-' + address_row + '"><?php echo $tab_address; ?> ' + address_row + '&nbsp;<img src="layout/image/delete.png" alt="" onclick="$(\'#vtabs a:first\').trigger(\'click\'); $(\'#address-' + address_row + '\').remove(); $(\'#tab-address-' + address_row + '\').remove(); return false;" /></a>');
		 
	$('.vtabs a').tabs();
	
	$('#address-' + address_row).trigger('click');
	
	address_row++;
}
//--></script> 
<script type="text/javascript"><!--
$('#transaction .pagination a').live('click', function() {
	$('#transaction').load(this.href);
	
	return false;
});			

$('#transaction').load('index.php?route=sale/cliente/transaction&token=<?php echo $token; ?>&clientes_id=<?php echo $clientes_id; ?>');

function addTransaction() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=sale/cliente/transaction&token=<?php echo $token; ?>&clientes_id=<?php echo $clientes_id; ?>',
		dataType: 'html',
		data: 'description=' + encodeURIComponent($('#tab-transaction input[name=\'description\']').val()) + '&amount=' + encodeURIComponent($('#tab-transaction input[name=\'amount\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-transaction').attr('disabled', true);
			$('#transaction').before('<div class="attention"><img src="layout/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-transaction').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#transaction').html(html);
			
			$('#tab-transaction input[name=\'amount\']').val('');
			$('#tab-transaction input[name=\'description\']').val('');
		}
	});
}
//--></script> 
<script type="text/javascript"><!--
$('#reward .pagination a').live('click', function() {
	$('#reward').load(this.href);
	
	return false;
});			

$('#reward').load('index.php?route=sale/cliente/reward&token=<?php echo $token; ?>&clientes_id=<?php echo $clientes_id; ?>');

function addRewardPoints() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=sale/cliente/reward&token=<?php echo $token; ?>&clientes_id=<?php echo $clientes_id; ?>',
		dataType: 'html',
		data: 'description=' + encodeURIComponent($('#tab-reward input[name=\'description\']').val()) + '&points=' + encodeURIComponent($('#tab-reward input[name=\'points\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-reward').attr('disabled', true);
			$('#reward').before('<div class="attention"><img src="layout/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-reward').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#reward').html(html);
								
			$('#tab-reward input[name=\'points\']').val('');
			$('#tab-reward input[name=\'description\']').val('');
		}
	});
}
//--></script> 
<script type="text/javascript" src="layout/template/sale/layout/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
    $('.date').datepicker({
		yearRange: "-100:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
    $('.datetime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'h:m'
    });
    $('.time').timepicker({timeFormat: 'h:m'});
    //--></script> 
<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script>
<script type="text/javascript"><!--
$('form input[type=radio]').live('click', function () {
	$('form input[type=radio]').attr('checked', false);
	$(this).attr('checked', true);
});
//--></script> 
<?php echo $footer; ?>
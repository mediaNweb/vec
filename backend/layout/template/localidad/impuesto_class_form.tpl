<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['layout/template/localidad/href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="layout/template/localidad/layout/image/impuesto.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?></td>
            <td><input type="text" name="impuestos_clase_titulo" value="<?php echo $impuestos_clase_titulo; ?>" />
              <?php if ($error_title) { ?>
              <span class="error"><?php echo $error_title; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_description; ?></td>
            <td><input type="text" name="impuestos_clase_descripcion" value="<?php echo $impuestos_clase_descripcion; ?>" />
              <?php if ($error_description) { ?>
              <br />
              <span class="error"><?php echo $error_description; ?></span>
              <?php } ?></td>
          </tr>
        </table>
        <br />
        <table id="impuesto-rate" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_geo_zone; ?></td>
              <td class="left"><span class="required">*</span> <?php echo $entry_description; ?></td>
              <td class="left"><span class="required">*</span> <?php echo $entry_rate; ?></td>
              <td class="left"><span class="required">*</span> <?php echo $entry_priority; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $impuesto_rate_row = 0; ?>
          <?php foreach ($impuestos_tasas as $impuestos_tasa) { ?>
          <tbody id="impuesto-rate-row<?php echo $impuesto_rate_row; ?>">
            <tr>
              <td class="left"><select name="impuestos_tasa[<?php echo $impuesto_rate_row; ?>][impuestos_tasa_id_zona]" id="geo-zone-id<?php echo $impuesto_rate_row; ?>">
                  <?php foreach ($geo_zones as $geo_zone) { ?>
                  <?php  if ($geo_zone['geo_zone_id'] == $impuestos_tasa['geo_zone_id']) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><input type="text" name="impuestos_tasa[<?php echo $impuesto_rate_row; ?>][impuestos_tasa_descripcion]" value="<?php echo $impuestos_tasa['impuestos_tasa_descripcion']; ?>" /></td>
              <td class="left"><input type="text" name="impuestos_tasa[<?php echo $impuesto_rate_row; ?>][impuestos_tasa]" value="<?php echo $impuestos_tasa['impuestos_tasa']; ?>" /></td>
              <td class="left"><input type="text" name="impuestos_tasa[<?php echo $impuesto_rate_row; ?>][impuestos_tasa_prioridad]" value="<?php echo $impuestos_tasa['impuestos_tasa_prioridad']; ?>" size="1" /></td>
              <td class="left"><a onclick="$('#impuesto-rate-row<?php echo $impuesto_rate_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
            </tr>
          </tbody>
          <?php $impuesto_rate_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="left"><a onclick="addRate();" class="button"><span><?php echo $button_add_rate; ?></span></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var impuesto_rate_row = <?php echo $impuesto_rate_row; ?>;

function addRate() {
	html  = '<tbody id="impuesto-rate-row' + impuesto_rate_row + '">';
	html += '<tr>';
	html += '<td class="left"><select name="impuestos_tasa[' + impuesto_rate_row + '][impuestos_tasa_id_zona]">';
    <?php foreach ($geo_zones as $geo_zone) { ?>
    html += '<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
    <?php } ?>
	html += '</select></td>';
	html += '<td class="left"><input type="text" name="impuestos_tasa[' + impuesto_rate_row + '][impuestos_tasa_descripcion]" value="" /></td>';
	html += '<td class="left"><input type="text" name="impuestos_tasa[' + impuesto_rate_row + '][impuestos_tasa]" value="" /></td>';
	html += '<td class="left"><input type="text" name="impuestos_tasa[' + impuesto_rate_row + '][impuestos_tasa_prioridad]" value="" size="1" /></td>';
	html += '<td class="left"><a onclick="$(\'#impuesto-rate-row' + impuesto_rate_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</tbody>';
	
	$('#impuesto-rate > tfoot').before(html);
	
	impuesto_rate_row++;
}
//--></script> 
<?php echo $footer; ?>
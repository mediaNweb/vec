<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
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
      <h1><img src="layout/image/product.png" alt="" /> <?php echo $heading_title; ?> - </h1>
        &nbsp;
        <span style="position:relative; display:inline; top: 6px;">
        <select name="filter_eventos_year" onchange="filter();" style="width:105px;">
            <option value="0"><?php echo $text_all; ?></option>
            <?php foreach ($years as $year) { ?>
                <?php if ($year['year'] == $filter_eventos_year) { ?>
                    <option value="<?php echo $year['year']; ?>" selected="selected"><?php echo $year['year']; ?></option>
                <?php } else { ?>
                    <option value="<?php echo $year['year']; ?>"><?php echo $year['year']; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
      </span>
      <div class="buttons">
      	<a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a>
<!--
        <a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><span><?php echo $button_copy; ?></span></a>
-->        
        <a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'e.eventos_titulo') { ?>
                <a href="<?php echo $sort_eventos_titulo; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_titulo; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_titulo; ?>"><?php echo $column_eventos_titulo; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'e.eventos_precio') { ?>
                <a href="<?php echo $sort_eventos_tipos_nombre; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_tipos_nombre; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_tipos_nombre; ?>"><?php echo $column_eventos_tipos_nombre; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'e.eventos_status') { ?>
                <a href="<?php echo $sort_eventos_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_status; ?>"><?php echo $column_eventos_status; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td></td>
              <td><input type="text" name="filter_eventos_titulo" value="<?php echo $filter_eventos_titulo; ?>" /></td>
              <td><input type="text" name="filter_eventos_tipos_nombre" value="<?php echo $filter_eventos_tipos_nombre; ?>" /></td>
              <td><select name="filter_eventos_status">
                  <option value="*"></option>
                  <?php if ($filter_eventos_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_eventos_status) && !$filter_eventos_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
            <?php if ($eventos) { ?>
            <?php foreach ($eventos as $evento) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($evento['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $evento['eventos_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $evento['eventos_id']; ?>" />
                <?php } ?></td>
              <td class="center"><img src="<?php echo $evento['eventos_logo']; ?>" alt="<?php echo $evento['eventos_titulo']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><?php echo $evento['eventos_titulo']; ?></td>
              <td class="left"><?php echo $evento['eventos_tipo_nombre']; ?></td>
              <td class="left"><?php echo $evento['eventos_status']; ?></td>
              <td class="right"><?php foreach ($evento['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=catalog/evento&token=<?php echo $token; ?>';
	
	var filter_eventos_titulo = $('input[name=\'filter_eventos_titulo\']').attr('value');
	
	if (filter_eventos_titulo) {
		url += '&filter_eventos_titulo=' + encodeURIComponent(filter_eventos_titulo);
	}
	
	var filter_eventos_tipos_nombre = $('input[name=\'filter_eventos_tipos_nombre\']').attr('value');
	
	if (filter_eventos_tipos_nombre) {
		url += '&filter_eventos_tipos_nombre=' + encodeURIComponent(filter_eventos_tipos_nombre);
	}
	
	var filter_eventos_precio = $('input[name=\'filter_eventos_precio\']').attr('value');
	
	if (filter_eventos_precio) {
		url += '&filter_eventos_precio=' + encodeURIComponent(filter_eventos_precio);
	}
	
	var filter_eventos_cupos_internet = $('input[name=\'filter_eventos_cupos_internet\']').attr('value');
	
	if (filter_eventos_cupos_internet) {
		url += '&filter_eventos_cupos_internet=' + encodeURIComponent(filter_eventos_cupos_internet);
	}
	
	var filter_eventos_status = $('select[name=\'filter_eventos_status\']').attr('value');
	
	if (filter_eventos_status != '*') {
		url += '&filter_eventos_status=' + encodeURIComponent(filter_eventos_status);
	}	

	var filter_eventos_year = $('select[name=\'filter_eventos_year\']').attr('value');
	
	if (filter_eventos_year != '0') {
		url += '&filter_eventos_year=' + encodeURIComponent(filter_eventos_year);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<?php echo $footer; ?>
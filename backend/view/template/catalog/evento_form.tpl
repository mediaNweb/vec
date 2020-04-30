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
      <h1><img src="layout/image/product.png" alt="" /> <?php echo $heading_title; ?> - <?php echo isset($eventos_titulo) ? $eventos_titulo : ''; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"> <a href="#tab-general"><?php echo $tab_general; ?></a> <a href="#tab-imagenes"><?php echo $tab_imagenes; ?></a> <a href="#tab-resultados"><?php echo $tab_resultados; ?></a> </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><?php echo $entry_eventos_fecha_disponible; ?></td>
              <td><input type="text" name="eventos_fecha_disponible" value="<?php echo isset($eventos_fecha_disponible) ? $eventos_fecha_disponible : ''; ?>" size="12" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_status; ?></td>
              <td><select name="eventos_status">
                  <?php if ($eventos_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_home; ?></td>
              <td><select name="eventos_home">
                  <?php if ($eventos_home) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_revista; ?></td>
              <td><select name="eventos_revista">
                  <?php if ($eventos_revista) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_certificado; ?></td>
              <td><select name="eventos_certificado">
                  <?php if ($eventos_certificado) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_certificado_foto; ?></td>
              <td><select name="eventos_certificado_foto">
                  <?php if ($eventos_certificado_foto) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_tipo; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($tipos as $tipo) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($tipo['eventos_tipos_id'], $eventos_tipos_id)) { ?>
                    <input type="checkbox" name="eventos_tipos_id[]" value="<?php echo $tipo['eventos_tipos_id']; ?>" checked="checked" />
                    <?php echo $tipo['eventos_tipos_nombre']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="eventos_tipos_id[]" value="<?php echo $tipo['eventos_tipos_id']; ?>" />
                    <?php echo $tipo['eventos_tipos_nombre']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_orden; ?></td>
              <td><input type="text" name="eventos_orden" value="<?php echo isset($eventos_orden) ? $eventos_orden : ''; ?>" size="2" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_eventos_titulo; ?></td>
              <td><input type="text" name="eventos_titulo" size="125" value="<?php echo isset($eventos_titulo) ? $eventos_titulo : ''; ?>" />
                <?php if ($error_eventos_titulo) { ?>
                <span class="error"><?php echo $error_eventos_titulo; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_fecha; ?></td>
              <td><input type="text" name="eventos_fecha" value="<?php echo isset($eventos_fecha) ? $eventos_fecha : ''; ?>" size="12" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_hora; ?></td>
              <td><input type="text" name="eventos_hora" value="<?php echo isset($eventos_hora) ? $eventos_hora : ''; ?>" size="12" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_lugar; ?></td>
              <td><input type="text" name="eventos_lugar" size="100" value="<?php echo isset($eventos_lugar) ? $eventos_lugar : ''; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_controles; ?></td>
              <td><select name="eventos_controles">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php for ($x = 0; $x <= 15; $x++) { ?>
                      <?php if ($eventos_controles == $x) { ?>
                          <option value="<?php echo $x; ?>" selected="selected"><?php echo $x; ?></option>
                      <?php } else { ?>
                          <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                      <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_redireccion; ?></td>
              <td><select name="eventos_redireccion">
                  <?php if ($eventos_redireccion) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_redireccion_url; ?></td>
              <td><input type="text" name="eventos_redireccion_url" size="100" value="<?php echo isset($eventos_redireccion_url) ? $eventos_redireccion_url : ''; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_description; ?></td>
              <td><textarea name="eventos_meta_description" cols="40" rows="5"><?php echo isset($eventos_meta_description) ? $eventos_meta_description : ''; ?></textarea></td>
            </tr>
            <tr>
              <td><?php echo $entry_meta_keyword; ?></td>
              <td><textarea name="eventos_meta_keywords" cols="40" rows="5"><?php echo isset($eventos_meta_keywords) ? $eventos_meta_keywords : ''; ?></textarea></td>
            </tr>
          </table>
        </div>
        <div id="tab-imagenes">
          <table class="form">
            <tr>
              <td><?php echo $entry_eventos_imagen_home; ?></td>
              <td>
                <input type="hidden" name="file_eventos_imagen_home" value="<?php echo $eventos_imagen_home; ?>" id="file_eventos_imagen_home" />
                <img src="<?php echo $preview_eventos_imagen_home; ?>" alt="" id="preview_eventos_imagen_home" class="image" onclick="image_upload('file_eventos_imagen_home', 'preview_eventos_imagen_home');" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_imagen_header; ?></td>
              <td>
                <input type="hidden" name="file_eventos_imagen_header" value="<?php echo $eventos_imagen_header; ?>" id="file_eventos_imagen_header" />
                <img src="<?php echo $preview_eventos_imagen_header; ?>" alt="" id="preview_eventos_imagen_header" class="image" onclick="image_upload('file_eventos_imagen_header', 'preview_eventos_imagen_header');" />	
              </td>
            </tr>
          </table>
        </div>
        <div id="tab-resultados">
          <table id="resultados_carga" class="list">
            <thead>
              <tr>
                <td class="left" colspan="2"><?php echo $entry_eventos_resultados_carga_titulo; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $entry_eventos_resultados_carga_descripcion; ?></td>
                <td class="left"><input name="resultados_carga" type="file" class="text" id="numeracion_tiempos_carga" /></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- FIN NUMERACION ACTUAL -->
        
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript" src="layout/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    $('.datetime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'h:m'
    });
    $('.time').timepicker({timeFormat: 'h:m'});
    //--></script> 
<script type="text/javascript"><!--
    $('#tabs a').tabs(); 
    $('#languages a').tabs(); 
    $('#vtab-option a').tabs();
    //--></script> 
<?php echo $footer; ?>
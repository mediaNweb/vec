<?php
echo 'beep';
exit(0);
?>
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
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span>Salir
        <?php // echo $button_cancel; ?>
        </span></a></div>
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
              <td><?php echo $entry_eventos_edad_calendario; ?></td>
              <td><select name="eventos_edad_calendario">
                  <?php if ($eventos_edad_calendario) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
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
                <img src="<?php echo $preview_eventos_imagen_home; ?>" alt="" id="preview_eventos_imagen_home" />
                <br />
                <input type="hidden" name="file_eventos_logo" value="<?php echo $eventos_imagen_home; ?>" id="file_eventos_logo" />
                <input name="eventos_imagen_home" type="file" id="eventos_imagen_home" />
                <br />
                <a onclick="image_delete('eventos_imagen_home', 'file_eventos_imagen_home', 'preview_eventos_imagen_home');" id="delete_cloudfile">Borrar Imágen</a>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_imagen_header; ?></td>
              <td>
                <img src="<?php echo $preview_eventos_imagen_header; ?>" alt="" id="preview_eventos_imagen_header" />
                <br />
                <input type="hidden" name="file_eventos_imagen_header" value="<?php echo $eventos_imagen_header; ?>" id="file_eventos_imagen_header" />
                <input name="eventos_imagen_header" type="file" id="eventos_imagen_header" />
                <br />
                <a onclick="image_delete('eventos_imagen_header', 'file_eventos_imagen_header', 'preview_eventos_imagen_header');" id="delete_cloudfile">Borrar Imágen</a>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_eventos_imagen_afiche; ?></td>
              <td>
                <img src="<?php echo $preview_eventos_imagen_afiche; ?>" alt="" id="preview_eventos_imagen_afiche" />
                <br />
                <input type="hidden" name="file_eventos_imagen_afiche" value="<?php echo $eventos_imagen_afiche; ?>" id="file_eventos_imagen_afiche" />
                <input name="eventos_imagen_afiche" type="file" id="eventos_imagen_afiche" />
                <br />
                <a onclick="image_delete('eventos_imagen_afiche', 'file_eventos_imagen_afiche', 'preview_eventos_imagen_afiche');" id="delete_cloudfile">Borrar Imágen</a>
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
<script type="text/javascript">
<!--
	// Borrar CloudFile
    function image_delete(field, file, preview) {
		var archivo = $('#' + file).val();
//		alert("El archivo es: " + archivo);
		$.ajax({
			url: 'index.php?route=catalog/evento/deletecloudfile&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: 'imagen=' + field + '&item=' + archivo + '&eventos_id=<?php echo $eventos_id; ?>',
			beforeSend: function() {
				$('#delete_cloudfile').attr('disabled', true);
				$('#delete_cloudfile').after('<span class="wait">&nbsp;<img src="../imagenes/loading.gif" alt="" /></span>');
			},
			complete: function() {
				$('#delete_cloudfile').attr('disabled', false);
				$('.wait').remove();
			},
			success: function(json) {
				if (json['output']) {
					alert(json['output']);
					$('#' + preview).attr('src', '<?php echo $no_image; ?>');
					$('#' + field).attr('value', '');
					$('#' + file).attr('value', '');
				}
			}
		});
    };
//-->
</script>
<!--
<script type="text/javascript">
    var image_row = <?php // echo $image_row; ?>;

    function addImage() {
        html  = '<tbody id="image-row' + image_row + '">';
        html += '  <tr>';
        html += '    <td class="left"><input type="hidden" name="evento_image[' + image_row + ']" value="" id="image' + image_row + '" /><img src="<?php // echo $no_image; ?>" alt="" id="preview' + image_row + '" class="image" onclick="image_upload(\'image' + image_row + '\', \'preview' + image_row + '\');" /></td>';
        html += '    <td class="left"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="button"><span><?php // echo $button_remove; ?></span></a></td>';
        html += '  </tr>';
        html += '</tbody>';

        $('#images tfoot').before(html);

        image_row++;
    }
    </script>
-->
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
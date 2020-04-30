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
  <div class="box">
    <div class="heading">
      <h1><img src="layout/image/publicidad.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                <td><input type="text" name="publicidad_titulo" size="100" value="<?php echo isset($publicidad_titulo) ? $publicidad_titulo : ''; ?>" />
                  <?php if ($error_title) { ?>
                  <span class="error"><?php echo $error_title; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_layout; ?></td>
                <td>
                	<select name="publicidad_layout_id" >
                        <option value="0"><?php echo $text_none; ?></option>
                        <?php foreach ($layouts as $layout) { ?>
                            <?php if ($layout['layout_id'] == $publicidad_layout_id) { ?>
                                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['layout_descripcion']; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['layout_descripcion']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td>
              </tr>
            <tr>
              <td><?php echo $entry_imagen; ?></td>
              <td><input type="hidden" name="publicidad_imagen" value="<?php echo $publicidad_imagen; ?>" id="publicidad_imagen" />
                <img src="<?php echo $preview_publicidad_imagen; ?>" alt="" id="preview_publicidad_imagen" class="image" onclick="image_upload('publicidad_imagen', 'preview_publicidad_imagen');" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="publicidad_url" size="100" value="<?php echo $publicidad_url; ?>" /></td>
            </tr>
            <tr>
                <td><?php echo $entry_publicidad_fdi; ?></td>
                <td><input type="text" name="publicidad_fdi" value="<?php echo isset($publicidad_fdi) ? $publicidad_fdi : ''; ?>" size="12" class="date" /></td>
            </tr>
            <tr>
                <td><?php echo $entry_publicidad_fdf; ?></td>
                <td><input type="text" name="publicidad_fdf" value="<?php echo isset($publicidad_fdf) ? $publicidad_fdf : ''; ?>" size="12" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_publicidad_orden; ?></td>
              <td><input type="text" name="publicidad_orden" value="<?php echo $publicidad_orden; ?>" size="1" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="publicidad_status">
                  <?php if ($publicidad_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
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
					data: 'image=' + encodeURIComponent($('#' + field).val()),
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
<script type="text/javascript" src="layout/template/catalog/layout/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
</script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
//--></script> 
<?php echo $footer; ?>
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
      <h1><img src="layout/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                <td><input type="text" name="noticia_titulo" size="100" value="<?php echo isset($noticia_titulo) ? $noticia_titulo : ''; ?>" />
                  <?php if ($error_title) { ?>
                  <span class="error"><?php echo $error_title; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_titular; ?></td>
                <td><textarea name="noticia_titular" id="noticia_titular"><?php echo isset($noticia_titular) ? $noticia_titular : ''; ?></textarea>
                  <?php if ($error_titular) { ?>
                  <span class="error"><?php echo $error_titular; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                <td><textarea name="noticia_texto" id="noticia_texto"><?php echo isset($noticia_texto) ? $noticia_texto : ''; ?></textarea>
                  <?php if ($error_description) { ?>
                  <span class="error"><?php echo $error_description; ?></span>
                  <?php } ?></td>
              </tr>
			<tr>
				<td><?php echo $entry_noticia_fdp; ?></td>
				<td><input type="text" name="noticia_fdp" value="<?php echo isset($noticia_fdp) ? $noticia_fdp : ''; ?>" size="12" class="date" /></td>
			</tr>
			<tr>
				<td><?php echo $entry_video; ?></td>
				<td><textarea name="noticia_video" id="noticia_video"><?php echo isset($noticia_video) ? $noticia_video : ''; ?></textarea></td>
			</tr>
            <tr>
              <td><?php echo $entry_imagen; ?></td>
              <td><input type="hidden" name="noticia_imagen" value="<?php echo $noticia_imagen; ?>" id="noticia_imagen" />
                <img src="<?php echo $preview_noticia_imagen; ?>" alt="" id="preview_noticia_imagen" class="image" onclick="image_upload('noticia_imagen', 'preview_noticia_imagen');" /></td>
            </tr>
			<tr>
				<td><?php echo $entry_posicion; ?></td>
				<td><select name="noticia_posicion">
						<option value="0" selected="selected"><?php echo $text_none; ?></option>
						<?php foreach ($posiciones as $posicion) { ?>
							<?php if ($posicion['valor'] == $noticia_posicion) { ?>
								<option value="<?php echo $posicion['valor']; ?>" selected="selected"><?php echo $posicion['descripcion']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $posicion['valor']; ?>"><?php echo $posicion['descripcion']; ?></option>
								<?php } ?>
							<?php } ?>
					</select></td>
			</tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="noticia_status">
                  <?php if ($noticia_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_noticia_orden; ?></td>
              <td><input type="text" name="noticia_orden" value="<?php echo $noticia_orden; ?>" size="1" /></td>
            </tr>
          </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="layout/template/catalog/layout/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('noticia_texto', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 
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
    $('.datetime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'h:m'
    });
    $('.time').timepicker({timeFormat: 'h:m'});
    //--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
//--></script> 
<?php echo $footer; ?>
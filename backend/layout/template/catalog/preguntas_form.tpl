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
                <td><input type="text" name="preguntas_frecuentes_pregunta" size="255" value="<?php echo isset($preguntas_frecuentes_pregunta) ? $preguntas_frecuentes_pregunta : ''; ?>" style="width: 100%" />
                  <?php if ($error_title) { ?>
                  <span class="error"><?php echo $error_title; ?></span>
                  <?php } ?></td>
              </tr>
				<tr>
					<td><?php echo $entry_preguntas_frecuentes_respuesta; ?></td>
					<td><textarea name="preguntas_frecuentes_respuesta" id="preguntas_frecuentes_respuesta"><?php echo isset($preguntas_frecuentes_respuesta) ? $preguntas_frecuentes_respuesta : ''; ?></textarea></td>
				</tr>
			  
          </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="layout/template/catalog/layout/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('preguntas_frecuentes_respuesta', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 
<?php echo $footer; ?>
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
                <td><input type="text" name="eventos_galeria_titulo" size="100" value="<?php echo isset($eventos_galeria_titulo) ? $eventos_galeria_titulo : ''; ?>" />
                  <?php if ($error_title) { ?>
                  <span class="error"><?php echo $error_title; ?></span>
                  <?php } ?></td>
              </tr>
				<tr>
					<td><?php echo $entry_eventos_galeria_imagen; ?></td>
					<td><input type="hidden" name="eventos_galeria_imagen" value="<?php echo $eventos_galeria_imagen; ?>" id="eventos_galeria_imagen" />
						<img src="<?php echo $preview_eventos_galeria_imagen; ?>" alt="" id="preview_eventos_galeria_imagen" class="image" onclick="image_upload('eventos_galeria_imagen', 'preview_eventos_galeria_imagen');" /></td>
				</tr>
			  
          </table>
      </form>



		<!-- The file upload form used as target for the file upload widget -->
		<form id="fileupload" action="<?php echo $galeria_url; ?>" method="POST" enctype="multipart/form-data">
            <table class="list">
				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				<div class="row fileupload-buttonbar">
					<div class="span8">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="icon-plus icon-white"></i>
							<span>Agregar Im&aacute;genes</span>
							<input type="file" name="files[]" multiple>
						</span>
						<button type="submit" class="btn btn-primary start">
							<i class="icon-upload icon-white"></i>
							<span>Comenzar Carga de Archivos</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="icon-ban-circle icon-white"></i>
							<span>Cancelar Carga</span>
						</button>
						<button type="button" class="btn btn-danger delete">
							<i class="icon-trash icon-white"></i>
							<span>Eliminar</span>
						</button>
						<input type="checkbox" class="toggle">
					</div>
					<div class="span5">
						<!-- The global progress bar -->
						<div class="progress progress-success progress-striped active fade">
							<div class="bar" style="width:0%;"></div>
						</div>
					</div>
				</div>
				<!-- The loading indicator is shown during image processing -->
				<div class="fileupload-loading"></div>
			</table>
			<!-- The table listing the files available for upload/download -->
			<table class="table table-striped">
				<tbody class="files"></tbody>
			</table>
		</form>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="layout/template/catalog/layout/javascript/multiupload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="layout/template/catalog/layout/javascript/multiupload/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="layout/template/catalog/layout/javascript/multiupload/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="layout/template/catalog/layout/javascript/multiupload/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="layout/template/catalog/layout/javascript/multiupload/bootstrap.min.js"></script>
<script src="layout/template/catalog/layout/javascript/multiupload/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="layout/template/catalog/layout/javascript/multiupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="layout/template/catalog/layout/javascript/multiupload/jquery.fileupload.js"></script>
<!-- The File Upload image processing plugin -->
<script src="layout/template/catalog/layout/javascript/multiupload/jquery.fileupload-ip.js"></script>
<!-- The File Upload user interface plugin -->
<script src="layout/template/catalog/layout/javascript/multiupload/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="layout/template/catalog/layout/javascript/multiupload/locale.js"></script>
<!-- The main application script -->
<script src="layout/template/catalog/layout/javascript/multiupload/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->





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

<?php echo $footer; ?>
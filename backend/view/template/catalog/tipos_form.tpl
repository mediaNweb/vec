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
            <h1><img src="layout/image/tipo.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <div id="tabs" class="htabs">
				<a href="#tab-general"><?php echo $tab_general; ?></a>
			</div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="tab-general">
                    <table class="form">
                        <tr>
                            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
							<td><input type="text" name="eventos_tipos_nombre" value="<?php echo $eventos_tipos_nombre; ?>" size="100" />
                                <?php if (isset($error_name)) { ?>
                                    <span class="error"><?php echo $error_name; ?></span>
                                <?php } ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sort_order; ?></td>
                            <td><input type="text" name="eventos_tipos_orden" value="<?php echo $eventos_tipos_orden; ?>" size="1" /></td>
                        </tr>
                    </table>
                </div>
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
<script type="text/javascript"><!--
    $('#tabs a').tabs(); 
    $('#languages a').tabs();
    //--></script> 
<?php echo $footer; ?>
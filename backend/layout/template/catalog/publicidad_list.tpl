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
      <h1><img src="layout/image/publicidad.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'n.publicidad_titulo') { ?>
                <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                <?php } ?></td>
              <td class="center"><?php echo $column_publicidad_imagen; ?></td>
              <td class="left"><?php echo $column_publicidad_url; ?></td>
              <td class="right"><?php if ($sort == 'i.publicidad_orden') { ?>
                <a href="<?php echo $sort_publicidad_orden; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_publicidad_orden; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_publicidad_orden; ?>"><?php echo $column_publicidad_orden; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($publicidad) { ?>
            <?php foreach ($publicidad as $publicidad) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($publicidad['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $publicidad['publicidad_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $publicidad['publicidad_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $publicidad['publicidad_titulo']; ?></td>
              <td class="center"><img src="<?php echo $publicidad['layout/template/catalog/publicidad_imagen']; ?>" alt="<?php echo $publicidad['publicidad_titulo']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><a href="<?php echo $publicidad['layout/template/catalog/publicidad_url']; ?>" target="_blank"><?php echo $publicidad['publicidad_url']; ?></a></td>
              <td class="right"><?php echo $publicidad['publicidad_orden']; ?></td>
              <td class="right"><?php foreach ($publicidad['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
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
      <h1><img src="layout/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left">
			  	<?php if ($sort == 'ec.eventos_galeria_titulo') { ?>
                	<a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                <?php } else { ?>
	                <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                <?php } ?>
			  </td>
              <td class="center"><?php echo $column_galeria_imagen; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($galerias) { ?>
            <?php foreach ($galerias as $galeria) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($galeria['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $galeria['eventos_galeria_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $galeria['eventos_galeria_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $galeria['eventos_galeria_titulo']; ?></td>
              <td class="center"><img src="<?php echo $galeria['layout/template/catalog/eventos_galeria_imagen']; ?>" alt="<?php echo $galeria['eventos_titulo']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="right"><?php foreach ($galeria['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
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
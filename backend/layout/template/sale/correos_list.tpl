<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['layout/template/sale/href']; ?>"><?php echo $breadcrumb['text']; ?></a>
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
      <h1><img src="layout/template/sale/layout/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'e.eventos_titulo') { ?>
                <a href="<?php echo $sort_eventos_titulo; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_titulo; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_titulo; ?>"><?php echo $column_eventos_titulo; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_correos; ?></td>
              <td class="right"><?php echo $column_celulares; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($eventos) { ?>
            <?php foreach ($eventos as $evento) { ?>
            <tr>
              <td class="center"><img src="<?php echo $evento['layout/template/sale/eventos_logo']; ?>" alt="<?php echo $evento['eventos_titulo']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><?php echo $evento['eventos_titulo']; ?></td>
              <td class="right"><?php echo $evento['correos']; ?></td>
              <td class="right"><?php echo $evento['celulares']; ?></td>
              <td class="right"><?php foreach ($evento['action'] as $action) { ?>
                [ <a href="<?php echo $action['layout/template/sale/href']; ?>"><?php echo $action['text']; ?></a> ]
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
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<?php echo $footer; ?>
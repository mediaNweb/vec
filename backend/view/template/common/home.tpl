<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_install) { ?>
  <div class="warning"><?php echo $error_install; ?></div>
  <?php } ?>
  <?php if ($error_image) { ?>
  <div class="warning"><?php echo $error_image; ?></div>
  <?php } ?>
  <?php if ($error_image_cache) { ?>
  <div class="warning"><?php echo $error_image_cache; ?></div>
  <?php } ?>
  <?php if ($error_cache) { ?>
  <div class="warning"><?php echo $error_cache; ?></div>
  <?php } ?>
  <?php if ($error_logs) { ?>
  <div class="warning"><?php echo $error_logs; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="layout/image/home.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
    </div>
  </div>
</div>
<?php echo $footer; ?>
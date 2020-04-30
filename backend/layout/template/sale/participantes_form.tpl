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
<?php // print_r($results); ?>
    <div class="box">
        <div class="heading">
            <h1><img src="layout/template/sale/layout/image/product.png" alt="" /> <?php echo $heading_title; ?> - <?php echo isset($eventos_titulo) ? $eventos_titulo : ''; ?> - <?php echo $text_totales; ?> - <?php echo $text_confirmados; ?> - <?php echo $text_no_confirmados; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button" id="submit"><span><?php echo $button_download; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
        </div>
        <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_id_pedido') { ?>
                <a href="<?php echo $sort_eventos_participantes_id_pedido; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_id_pedido; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_id_pedido; ?>"><?php echo $column_eventos_participantes_id_pedido; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'o.payment_method') { ?>
                <a href="<?php echo $sort_payment_method; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_payment_method; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_payment_method; ?>"><?php echo $column_payment_method; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_numero') { ?>
                <a href="<?php echo $sort_eventos_participantes_numero; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_numero; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_numero; ?>"><?php echo $column_eventos_participantes_numero; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_cedula') { ?>
                <a href="<?php echo $sort_eventos_participantes_cedula; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_cedula; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_cedula; ?>"><?php echo $column_eventos_participantes_cedula; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_apellidos') { ?>
                <a href="<?php echo $sort_eventos_participantes_apellidos; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_apellidos; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_apellidos; ?>"><?php echo $column_eventos_participantes_apellidos; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_nombres') { ?>
                <a href="<?php echo $sort_eventos_participantes_nombres; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_nombres; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_nombres; ?>"><?php echo $column_eventos_participantes_nombres; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_eventos_participantes_id_pedido" value="<?php echo $filter_eventos_participantes_id_pedido; ?>" style="width: 120px;" /></td>
              <td><input type="text" name="filter_payment_method" value="<?php echo $filter_payment_method; ?>" style="width: 160px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_numero" value="<?php echo $filter_eventos_participantes_numero; ?>" style="width: 150px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_cedula" value="<?php echo $filter_eventos_participantes_cedula; ?>" style="width: 60px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_apellidos" value="<?php echo $filter_eventos_participantes_apellidos; ?>" style="width: 160px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_nombres" value="<?php echo $filter_eventos_participantes_nombres; ?>" style="width: 160px;" /></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
            <?php if ($participantes) { ?>
            <?php foreach ($participantes as $participante) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($participante['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $participante['eventos_participantes_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $participante['eventos_participantes_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_id_pedido']; ?></td>
              <td class="left"><?php echo $participante['payment_method']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_numero']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_cedula']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_apellidos']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_nombres']; ?></td>
              <td class="right"><?php foreach ($participante['action'] as $action) { ?>
                [ <a href="<?php echo $action['layout/template/sale/href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
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
function filter() {
	url = 'index.php?route=sale/participantes/consulta&token=<?php echo $token; ?>&eventos_id=<?php echo $eventos_id; ?>';
	
	var filter_eventos_participantes_id_pedido = $('input[name=\'filter_eventos_participantes_id_pedido\']').attr('value');
	
	if (filter_eventos_participantes_id_pedido) {
		url += '&filter_eventos_participantes_id_pedido=' + encodeURIComponent(filter_eventos_participantes_id_pedido);
	}
	
	var filter_payment_method = $('input[name=\'filter_payment_method\']').attr('value');
	
	if (filter_payment_method) {
		url += '&filter_payment_method=' + encodeURIComponent(filter_payment_method);
	}

	var filter_eventos_participantes_numero = $('input[name=\'filter_eventos_participantes_numero\']').attr('value');
	
	if (filter_eventos_participantes_numero) {
		url += '&filter_eventos_participantes_numero=' + encodeURIComponent(filter_eventos_participantes_numero);
	}
	
	var filter_eventos_participantes_cedula = $('input[name=\'filter_eventos_participantes_cedula\']').attr('value');
	
	if (filter_eventos_participantes_cedula) {
		url += '&filter_eventos_participantes_cedula=' + encodeURIComponent(filter_eventos_participantes_cedula);
	}
	
	var filter_eventos_participantes_apellidos = $('input[name=\'filter_eventos_participantes_apellidos\']').attr('value');
	
	if (filter_eventos_participantes_apellidos) {
		url += '&filter_eventos_participantes_apellidos=' + encodeURIComponent(filter_eventos_participantes_apellidos);
	}

	var filter_eventos_participantes_nombres = $('input[name=\'filter_eventos_participantes_nombres\']').attr('value');
	
	if (filter_eventos_participantes_nombres) {
		url += '&filter_eventos_participantes_nombres=' + encodeURIComponent(filter_eventos_participantes_nombres);
	}

	location = url;
}
//--></script>  
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<?php echo $footer; ?>
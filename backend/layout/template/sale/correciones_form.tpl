<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['layout/template/sale/href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
    </div>
    <div class="box">
        <div class="heading">
            <h1><img src="layout/template/sale/layout/image/product.png" alt="" /> <?php echo $heading_title; ?> - <?php echo isset($eventos_titulo) ? $eventos_titulo : ''; ?> - <?php echo $text_totales; ?> - <?php echo $text_confirmados; ?> - <?php echo $text_no_confirmados; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button" id="submit"><span><?php echo $button_download; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
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
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_genero') { ?>
                <a href="<?php echo $sort_eventos_participantes_genero; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_genero; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_genero; ?>"><?php echo $column_eventos_participantes_genero; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_fdn') { ?>
                <a href="<?php echo $sort_eventos_participantes_fdn; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_fdn; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_fdn; ?>"><?php echo $column_eventos_participantes_fdn; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_email') { ?>
                <a href="<?php echo $sort_eventos_participantes_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_email; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_email; ?>"><?php echo $column_eventos_participantes_email; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_cel') { ?>
                <a href="<?php echo $sort_eventos_participantes_cel; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_cel; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_cel; ?>"><?php echo $column_eventos_participantes_cel; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_id_pais') { ?>
                <a href="<?php echo $sort_eventos_participantes_id_pais; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_id_pais; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_id_pais; ?>"><?php echo $column_eventos_participantes_id_pais; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_id_estado') { ?>
                <a href="<?php echo $sort_eventos_participantes_id_estado; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_id_estado; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_id_estado; ?>"><?php echo $column_eventos_participantes_id_estado; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_grupo') { ?>
                <a href="<?php echo $sort_eventos_participantes_grupo; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_grupo; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_grupo; ?>"><?php echo $column_eventos_participantes_grupo; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_edad') { ?>
                <a href="<?php echo $sort_eventos_participantes_edad; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_edad; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_edad; ?>"><?php echo $column_eventos_participantes_edad; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'ep.eventos_participantes_categoria') { ?>
                <a href="<?php echo $sort_eventos_participantes_categoria; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_eventos_participantes_categoria; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_eventos_participantes_categoria; ?>"><?php echo $column_eventos_participantes_categoria; ?></a>
                <?php } ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_eventos_participantes_id_pedido" value="<?php echo $filter_eventos_participantes_id_pedido; ?>" style="width: 120px;" /></td>
              <td><input type="text" name="filter_payment_method" value="<?php echo $filter_payment_method; ?>" style="width: 160px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_numero" value="<?php echo $filter_eventos_participantes_numero; ?>" style="width: 150px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_cedula" value="<?php echo $filter_eventos_participantes_cedula; ?>" style="width: 60px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_apellidos" value="<?php echo $filter_eventos_participantes_apellidos; ?>" style="width: 160px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_nombres" value="<?php echo $filter_eventos_participantes_nombres; ?>" style="width: 160px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_genero" value="<?php echo $filter_eventos_participantes_genero; ?>" style="width: 40px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_fdn" value="<?php echo $filter_eventos_participantes_fdn; ?>" style="width: 120px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_email" value="<?php echo $filter_eventos_participantes_email; ?>" style="width: 160px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_cel" value="<?php echo $filter_eventos_participantes_cel; ?>" style="width: 90px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_id_pais" value="<?php echo $filter_eventos_participantes_id_pais; ?>" style="width: 30px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_id_estado" value="<?php echo $filter_eventos_participantes_id_estado; ?>" style="width: 30px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_grupo" value="<?php echo $filter_eventos_participantes_grupo; ?>" style="width: 70px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_edad" value="<?php echo $filter_eventos_participantes_edad; ?>" style="width: 20px;" /></td>
              <td><input type="text" name="filter_eventos_participantes_categoria" value="<?php echo $filter_eventos_participantes_categoria; ?>" style="width: 80px;" /></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
            <?php if ($participantes) { ?>
            <?php foreach ($participantes as $participante) { ?>
            <tr>
              <td class="left"><?php echo $participante['eventos_participantes_id_pedido']; ?></td>
              <td class="left"><?php echo $participante['payment_method']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_numero']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_cedula']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_apellidos']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_nombres']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_genero']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_fdn']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_email']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_cel']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_id_pais']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_id_estado']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_grupo']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_edad']; ?></td>
              <td class="left"><?php echo $participante['eventos_participantes_categoria']; ?></td>
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
	url = 'index.php?route=sale/correcciones/corregir&token=<?php echo $token; ?>&eventos_id=<?php echo $eventos_id; ?>';
	
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

	var filter_eventos_participantes_genero = $('input[name=\'filter_eventos_participantes_genero\']').attr('value');

	if (filter_eventos_participantes_genero) {
		url += '&filter_eventos_participantes_genero=' + encodeURIComponent(filter_eventos_participantes_genero);
	}	

	var filter_eventos_participantes_fdn = $('input[name=\'filter_eventos_participantes_fdn\']').attr('value');

	if (filter_eventos_participantes_fdn) {
		url += '&filter_eventos_participantes_fdn=' + encodeURIComponent(filter_eventos_participantes_fdn);
	}	
	
	var filter_eventos_participantes_email = $('input[name=\'filter_eventos_participantes_email\']').attr('value');
	
	if (filter_eventos_participantes_email) {
		url += '&filter_eventos_participantes_email=' + encodeURIComponent(filter_eventos_participantes_email);
	}

	var filter_eventos_participantes_cel = $('input[name=\'filter_eventos_participantes_cel\']').attr('value');
	
	if (filter_eventos_participantes_cel) {
		url += '&filter_eventos_participantes_cel=' + encodeURIComponent(filter_eventos_participantes_cel);
	}
	
	var filter_eventos_participantes_id_pais = $('input[name=\'filter_eventos_participantes_id_pais\']').attr('value');
	
	if (filter_eventos_participantes_id_pais) {
		url += '&filter_eventos_participantes_id_pais=' + encodeURIComponent(filter_eventos_participantes_id_pais);
	}

	var filter_eventos_participantes_id_estado = $('input[name=\'filter_eventos_participantes_id_estado\']').attr('value');
	
	if (filter_eventos_participantes_id_estado) {
		url += '&filter_eventos_participantes_id_estado=' + encodeURIComponent(filter_eventos_participantes_id_estado);
	}

	var filter_eventos_participantes_grupo = $('input[name=\'filter_eventos_participantes_grupo\']').attr('value');

	if (filter_eventos_participantes_grupo) {
		url += '&filter_eventos_participantes_grupo=' + encodeURIComponent(filter_eventos_participantes_grupo);
	}	

	var filter_eventos_participantes_edad = $('input[name=\'filter_eventos_participantes_edad\']').attr('value');

	if (filter_eventos_participantes_edad) {
		url += '&filter_eventos_participantes_edad=' + encodeURIComponent(filter_eventos_participantes_edad);
	}	
	
	var filter_eventos_participantes_categoria = $('input[name=\'filter_eventos_participantes_categoria\']').attr('value');

	if (filter_eventos_participantes_categoria) {
		url += '&filter_eventos_participantes_categoria=' + encodeURIComponent(filter_eventos_participantes_categoria);
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
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
    <div class="box">
        <div class="heading">
            <h1><img src="layout/template/sale/layout/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="tab-numeracion">
                    <table id="depositos_datos" class="list">
                        <thead>
                            <tr>
                                <td class="left" colspan="2"><?php echo $entry_depositos_titulo; ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left"><?php echo $entry_depositos_archivo; ?></td>
                                <td class="left"><?php echo isset($depositos_archivo) ? $depositos_archivo : 0; ?></td>
                            </tr>
                            <tr>
                                <td class="left"><?php echo $entry_depositos_procesados; ?></td>
                                <td class="left"><?php echo isset($depositos_procesados) ? $depositos_procesados : 0; ?></td>
                            </tr>
                            <tr>
                                <td class="left"><?php echo $entry_depositos_confirmados; ?></td>
                                <td class="left"><?php echo isset($depositos_confirmados) ? $depositos_confirmados : 0; ?></td>
                            </tr>
                            <tr>
                                <td class="left"><?php echo $entry_depositos_depurados; ?></td>
                                <td class="left"><?php echo isset($depositos_depurados) ? $depositos_depurados : 0; ?></td>
                            </tr>
                        </tbody>
                    </table>
					<table id="archivo_depositos_carga" class="list">
						<thead>
							<tr>
								<td class="left" colspan="2"><?php echo $entry_depositos_carga_titulo; ?></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="left"><?php echo $entry_depositos_carga_descripcion; ?></td>
								<td class="left">
									<input name="archivo_depositos_carga" type="file" class="text" id="archivo_depositos_carga" />
								</td>
							</tr>
						</tbody>
					</table>

                </div>
				<!-- FIN NUMERACION ACTUAL -->
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>
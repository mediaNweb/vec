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
                        <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                        <td>
                            <input type="text" name="opcion_descripcion[0][opcion_nombre]" value="<?php echo isset($opcion_descripcion[0]) ? $opcion_descripcion[0]['opcion_nombre'] : ''; ?>" />
                            <br />
                            <?php if (isset($error_name[0])) { ?>
                                <span class="error"><?php echo $error_name[0]; ?></span><br />
                                <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_type; ?></td>
                        <td><select name="opcion_tipo">
                                <optgroup label="<?php echo $text_choose; ?>">
                                    <?php if ($opcion_tipo == 'select') { ?>
                                        <option value="select" selected><?php echo $text_select; ?></option>
                                        <?php } else { ?>
                                        <option value="select"><?php echo $text_select; ?></option>
                                        <?php } ?>
                                    <?php if ($opcion_tipo == 'radio') { ?>
                                        <option value="radio" selected><?php echo $text_radio; ?></option>
                                        <?php } else { ?>
                                        <option value="radio"><?php echo $text_radio; ?></option>
                                        <?php } ?>
                                    <?php if ($opcion_tipo == 'checkbox') { ?>
                                        <option value="checkbox" selected><?php echo $text_checkbox; ?></option>
                                        <?php } else { ?>
                                        <option value="checkbox"><?php echo $text_checkbox; ?></option>
                                        <?php } ?>
                                </optgroup>
                                <optgroup label="<?php echo $text_input; ?>">
                                    <?php if ($opcion_tipo == 'text') { ?>
                                        <option value="text" selected><?php echo $text_text; ?></option>
                                        <?php } else { ?>
                                        <option value="text"><?php echo $text_text; ?></option>
                                        <?php } ?>
                                    <?php if ($opcion_tipo == 'textarea') { ?>
                                        <option value="textarea" selected><?php echo $text_textarea; ?></option>
                                        <?php } else { ?>
                                        <option value="textarea"><?php echo $text_textarea; ?></option>
                                        <?php } ?>
                                </optgroup>
                                <optgroup label="<?php echo $text_file; ?>">
                                    <?php if ($opcion_tipo == 'file') { ?>
                                        <option value="file" selected><?php echo $text_file; ?></option>
                                        <?php } else { ?>
                                        <option value="file"><?php echo $text_file; ?></option>
                                        <?php } ?>
                                </optgroup>
                                <optgroup label="<?php echo $text_date; ?>">
                                    <?php if ($opcion_tipo == 'date') { ?>
                                        <option value="date" selected><?php echo $text_date; ?></option>
                                        <?php } else { ?>
                                        <option value="date"><?php echo $text_date; ?></option>
                                        <?php } ?>
                                    <?php if ($opcion_tipo == 'time') { ?>
                                        <option value="time" selected><?php echo $text_time; ?></option>
                                        <?php } else { ?>
                                        <option value="time"><?php echo $text_time; ?></option>
                                        <?php } ?>
                                    <?php if ($opcion_tipo == 'datetime') { ?>
                                        <option value="datetime" selected><?php echo $text_datetime; ?></option>
                                        <?php } else { ?>
                                        <option value="datetime"><?php echo $text_datetime; ?></option>
                                        <?php } ?>
                                </optgroup>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td><input type="text" name="opcion_orden" value="<?php echo $opcion_orden; ?>" size="1" /></td>
                    </tr>
                </table>
                <table id="option-value" class="list">
                    <thead>
                        <tr>
                            <td class="left"><span class="required">*</span> <?php echo $entry_value; ?></td>
                            <td class="right"><?php echo $entry_sort_order; ?></td>
                            <td></td>
                        </tr>
                    </thead>
                    <?php $valor_opcion_row = 0; ?>
                    <?php foreach ($valor_opciones as $valor_opcion) { ?>
                        <tbody id="valor-opcion-row<?php echo $valor_opcion_row; ?>">
                            <tr>
                                <td class="left"><input type="hidden" name="valor_opcion[<?php echo $valor_opcion_row; ?>][opcion_valor_id]" value="<?php echo $valor_opcion['opcion_valor_id']; ?>" />
                                        <input type="text" name="valor_opcion[<?php echo $valor_opcion_row; ?>][opcion_valor_descripcion][0][opcion_nombre]" value="<?php echo isset($valor_opcion['opcion_valor_descripcion'][0]) ? $valor_opcion['opcion_valor_descripcion'][0]['opcion_valor_decripcion_nombre'] : ''; ?>" />
                                    <br />
                                        <?php if (isset($error_option_value[$valor_opcion_row][0])) { ?>
                                            <span class="error"><?php echo $error_option_value[$valor_opcion_row][0]; ?></span>
                                            <?php } ?>
                                    </td>
                                <td class="right"><input type="text" name="valor_opcion[<?php echo $valor_opcion_row; ?>][opcion_orden]" value="<?php echo $valor_opcion['opcion_orden']; ?>" size="1" /></td>
                                <td class="left"><a onclick="$('#valor-opcion-row<?php echo $valor_opcion_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
                            </tr>
                        </tbody>
                        <?php $valor_opcion_row++; ?>
                        <?php } ?>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td class="left"><a onclick="addValorOpcion();" class="button"><span><?php echo $button_add_option_value; ?></span></a></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('select[name=\'opcion_tipo\']').bind('change', function() {
        if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox') {
            $('#option-value').show();
        } else {
            $('#option-value').hide();	
        }
    });

    var valor_opcion_row = <?php echo $valor_opcion_row; ?>;

    function addValorOpcion() {
        html  = '<tbody id="valor-opcion-row' + valor_opcion_row + '">';
        html += '<tr>';	
        html += '<td class="left"><input type="hidden" name="valor_opcion[' + valor_opcion_row + '][opcion_valor_id]" value="" />';
		html += '<input type="text" name="valor_opcion[<?php echo $valor_opcion_row; ?>][opcion_valor_descripcion][0][opcion_nombre]" value="<?php echo isset($valor_opcion['opcion_valor_descripcion'][0]) ? $valor_opcion['opcion_valor_descripcion'][0]['opcion_valor_decripcion_nombre'] : ''; ?>" /><br />';
        html += '</td>';
        html += '<td class="right"><input type="text" name="valor_opcion[' + valor_opcion_row + '][opcion_orden]" value="" size="1" /></td>';
        html += '<td class="left"><a onclick="$(\'#valor-opcion-row' + valor_opcion_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
        html += '</tr>';	
        html += '</tbody>';

        $('#option-value tfoot').before(html);

        valor_opcion_row++;
    }
    //--></script> 
<?php echo $footer; ?>
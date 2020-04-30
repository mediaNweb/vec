<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['layout/template/sale/href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php // print_r($order_info); ?>
  <div class="box">
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
      <h1><img src="layout/template/sale/layout/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
            <tr>
              <td><?php echo $text_order_id; ?><span class="required">*</span></td>
              <td><input type="text" name="eventos_participantes_id_pedido" value="<?php echo $eventos_participantes_id_pedido; ?>" readonly="readonly" />
                <input type="hidden" name="eventos_participantes_id" value="<?php echo $eventos_participantes_id; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $text_customer_id; ?><span class="required">*</span></td>
              <td><input type="text" name="eventos_participantes_cedula" value="<?php echo $eventos_participantes_cedula; ?>" readonlyXX="readonly" /></td>
            </tr>
            <tr>
              <td><?php echo $text_number; ?><span class="required">*</span></td>
              <td><input type="text" name="eventos_participantes_numero" value="<?php echo $eventos_participantes_numero; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
              <td><?php echo $text_firstname; ?><span class="required">*</span></td>
              <td>
			  	<input type="text" name="eventos_participantes_nombres" value="<?php echo $eventos_participantes_nombres; ?>" />
				<?php if ($error_nombre) { ?>
					<span class="error"><?php echo $error_nombre; ?></span>
				<?php } ?>									
			  </td>
            </tr>
            <tr>
              <td><?php echo $text_lastname; ?><span class="required">*</span></td>
              <td>
			  	<input type="text" name="eventos_participantes_apellidos" value="<?php echo $eventos_participantes_apellidos; ?>" />
				<?php if ($error_apellido) { ?>
					<span class="error"><?php echo $error_apellido; ?></span>
				<?php } ?>									
			  </td>
            </tr>
            <tr>
              <td><?php echo $text_gender; ?><span class="required">*</span></td>
              <td>
			  <select id="clientes_genero" name="eventos_participantes_genero">
                  <?php if ($eventos_participantes_genero == 'M') { ?>
					  <option value="">--G&eacute;nero--</option>
 					  <option value="M" selected="selected">Masculino</option>
					  <option value="F">Femenino</option>
                  <?php } elseif ($eventos_participantes_genero == 'F') { ?>
					  <option value="">--G&eacute;nero--</option>
 					  <option value="M">Masculino</option>
					  <option value="F"selected="selected">Femenino</option>
                  <?php } else { ?>
					  <option selected="selected" value="" >--G&eacute;nero--</option>
 					  <option value="M">Masculino</option>
					  <option value="F">Femenino</option>
                  <?php } ?>
			</select>
			<?php if ($error_genero) { ?>
				<span class="error"><?php echo $error_genero; ?></span>
			<?php } ?>									
			
			</td>
            </tr>
            <tr>
				<td><?php echo $text_date_birth; ?><span class="required">*</span></td>
				<td>
					<input class="date TabOnEnter" id="clientes_fdn" name="eventos_participantes_fdn" onchangexx="calcula_edad(this.value)" tabindex="7" type="text" value="<?php echo $eventos_participantes_fdn; ?>" />
					<?php if ($error_fdn) { ?>
						<span class="error"><?php echo $error_fdn; ?></span>
					<?php } ?>									
				</td>
            </tr>
            <tr>
              <td><?php echo $text_email; ?></td>
              <td>
			  	<input type="text" name="eventos_participantes_email" value="<?php echo $eventos_participantes_email; ?>" />
				<?php // if ($error_email) { ?>
					<span class="error"><?php // echo $error_email; ?></span>
				<?php // } ?>									
			  </td>
            </tr>
            <tr>
              <td><?php echo $text_cel; ?></td>
              <td>
			  	<input type="text" name="eventos_participantes_cel" value="<?php echo $eventos_participantes_cel; ?>" />
				<?php // if ($error_cel) { ?>
					<span class="error"><?php // echo $error_cel; ?></span>
				<?php // } ?>									
			  </td>
            </tr>
            <tr>
              <td><?php echo $text_country; ?><span class="required">*</span></td>
              <td>
				<select class="TabOnEnter" id="paises_id" name="eventos_participantes_id_pais" tabindex="10" >
					<option selected="selected" value="">--Pa&iacute;s--</option>
					<?php foreach ($paises as $pais) { ?>
						<?php if ($pais['paises_id'] == $eventos_participantes_id_pais) { ?>
							<option selected="selected" value="<?php echo $pais['paises_id']; ?>"><?php echo $pais['paises_nombre']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $pais['paises_id']; ?>"><?php echo $pais['paises_nombre']; ?></option>
							<?php } ?>
						<?php } ?>
				</select>
				<?php if ($error_pais) { ?>
					<span class="error"><?php echo $error_pais; ?></span>
				<?php } ?>									
			  </td>
            </tr>
            <tr>
              <td><?php echo $text_zone; ?><span class="required">*</span></td>
              <td>
				<select class="TabOnEnter" id="estados_id" name="eventos_participantes_id_estado" tabindex="11">
					<option selected="selected" value="">--Estado--</option>
					<?php foreach ($estados as $estado) { ?>
						<?php if ($estado['estados_id'] == $eventos_participantes_id_estado) { ?>
							<option selected="selected" value="<?php echo $estado['estados_id']; ?>"><?php echo $estado['estados_nombre']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $estado['estados_id']; ?>"><?php echo $estado['estados_nombre']; ?></option>
							<?php } ?>
						<?php } ?>
				</select>
				<?php if ($error_estado) { ?>
					<span class="error"><?php echo $error_estado; ?></span>
				<?php } ?>									
			  </td>
            </tr>
			<?php if ($eventos_descripcion_numeracion_id_tipo == 1) { // 1 = Grupos ?>
				<tr>
				  <td><?php echo $text_group; ?><span class="required">*</span></td>
				  <td>
					<select class="validate[required] TabOnEnter" id="grupo" name="eventos_participantes_grupo" onchange="cambia_categoria(this.value);" tabindex="12" >
						<option selected="selected" value="--Grupo--">--Grupo--</option>
						<?php foreach ($grupos_categorias as $grupo) { ?>
							<?php if ($grupo['eventos_categorias_grupo'] == $eventos_participantes_grupo) { ?>
								<option selected="selected" value="<?php echo $grupo['eventos_categorias_grupo']; ?>"><?php echo $grupo['eventos_categorias_grupo']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $grupo['eventos_categorias_grupo']; ?>"><?php echo $grupo['eventos_categorias_grupo']; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
					<?php if ($error_grupo) { ?>
						<span class="error"><?php echo $error_grupo; ?></span>
					<?php } ?>									
					</td>
				</tr>
			<?php } ?>
			<?php if ($eventos_descripcion_numeracion_id_tipo == 3) { // 3 = Tiempos ?>
				<tr>
					<td><?php echo $text_time; ?><span class="required">*</span></td>
					<td>
						<input type="text" id="eventos_participantes_tiempo" name="eventos_participantes_tiempo" readonly="readonly" value="<?php echo $eventos_participantes_tiempo; ?>" />
					</td>
				</tr>
				<tr>
					<td><?php echo $text_range; ?><span class="required">*</span></td>
					<td>
						<select class="validate[required] TabOnEnter" id="eventos_participantes_rango" name="eventos_participantes_rango" tabindex="10" onchange="cambia_valor_rango(this.value)" >
							<option selected="selected" value="">--Rangos--</option>
							<?php foreach ($rangos as $rango) { ?>
								<option value="<?php echo $rango['eventos_numeros_th']; ?>">De <?php echo $rango['eventos_numeros_td']; ?> a <?php echo $rango['eventos_numeros_th']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
			<?php } ?>
            <tr>
              <td><?php echo $text_age; ?><span class="required">*</span></td>
              <td>
			  	<input type="text" id="clientes_edad" name="eventos_participantes_edad" value="<?php echo $eventos_participantes_edad; ?>" readonly="readonly" />
				<?php if ($error_edad) { ?>
					<span class="error"><?php echo $error_edad; ?></span>
				<?php } ?>									
			  </td>
            </tr>
            <tr>
              <td><?php echo $text_category; ?><span class="required">*</span></td>
              <td>
			  	<input type="text" id="categoria" name="eventos_participantes_categoria" value="<?php echo $eventos_participantes_categoria; ?>" readonly="readonly" />
				<?php if ($error_categoria) { ?>
					<span class="error"><?php echo $error_categoria; ?></span>
				<?php } ?>									
			  </td>
            </tr>

			<?php if ($categorias_opcionales) { ?>
				<div id="dato-cat_opc">
					<tr>
						<td>Categor&iacute;a(s) Opcional(es):</td>
						<td>
							<div class="inputContainer">
								<?php foreach ($categorias_opcionales as $opcional) { ?>
									<label><?php echo $opcional['eventos_categorias_nombre']; ?></label>
									<input type="checkbox" id="<?php echo $opcional['eventos_categorias_nombre']; ?>" name="cat_opc" onclick="cambia_categoria_opcional(this.id, this.value)" value="<?php echo $opcional['eventos_categorias_nombre']; ?>" />
								<?php } ?>
							</div>
						</td>
					</tr>
				</div>
			<?php } ?>
			<div class="cart">
				<input type="hidden" id="eventos_id" name="eventos_id" size="2" value="<?php echo $eventos_id; ?>" />
				<input type="hidden" id="participante_datos" name="participante_datos" size="2" value="<?php echo $eventos_participantes_datos; ?>" />
				<input type="hidden" id="grupo_prev" name="grupo_prev" size="20" value="<?php echo $eventos_participantes_grupo; ?>" />
				<input type="hidden" id="tiempo_prev" name="tiempo_prev" size="20" value="<?php echo $eventos_participantes_tiempo; ?>" />
				<div class="clear"></div>
				<div class="divider_space"></div>
			</div>
			<div id="hidden">
				<input type="hidden" id="cat_prev" name="cat_prev" size="45" value="" />
				<input type="hidden" id="cod_cedula" name="cod_cedula" size="10" value="<?php echo $sin_cedula; ?>" />
			</div>
			<div id="hid_cat">
				<input type="hidden" id="categoria_0" name="categoria_0" size="45" value="" />
			</div>
          </table>
      </form>
    </div>
  </div>
<code id="test"></code>
</div>
<script type="text/javascript">
	function calcula_edad(nacimiento){
		if ($('#clientes_fdn').val() != '') {
			var fdn_part = $('#clientes_fdn').val();
		} else { 
			return;
		}
		$.ajax({
			type: 'get',
			url: 'index.php?route=sale/participantes/edad&token=<?php echo $token; ?>',
			data: 'fdn=' + fdn_part + '&anio_calendario=' + <?php echo $eventos_edad_calendario; ?>,
			//doc.select.options[doc.select.selectedIndex].text;
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			beforeSend: function() {
				$('#clientes_fdn').attr('disabled', true);
				$('#clientes_fdn').after('<span class="wait">&nbsp;<img src="layout/image/loading.gif" alt="" /></span>');
			},		
			complete: function() {
				$('#clientes_fdn').attr('disabled', false);
				$('.wait').remove();
			},			
			success: function(json) {
				$('.warning').remove();

				if (json['error']) {
					alert(json['error']);
				};

				if (json['edad']) {
					if (json['edad'] == undefined) {
						alert('No se pudo calcular su edad');	
					} else {
						$('#clientes_edad').val(json['edad']);
						$("#clientes_edad").attr('readonly','readonly');
						<?php if ($categorias) { ?>
//							limpia_categorias();
							busca_categoria();
						<?php } ?>
					}
				} else {
					alert('No se pudo calcular su edad');	
				};
			}
		});
	}

    function cambia_categoria(grupo) {
        if (document.getElementById('grupo').selectedIndex == 0) {
            document.getElementById('categoria').value = '';
        } else {
            if (document.getElementById(grupo)) {
                document.getElementById('cat_prev').value = document.getElementById('categoria').value;
                document.getElementById('categoria').value = document.getElementById(grupo).value;
            }
        }
    }  	

	function cambia_valor_rango(tiempo) {
		document.getElementById('eventos_participantes_tiempo').value = tiempo;
	}  	

    function cambia_categoria_opcional(chk_id, opcion) {
        if(document.getElementById(chk_id).checked) {
            document.getElementById('cat_prev').value = document.getElementById('categoria').value;
            document.getElementById('categoria').value = document.getElementById(chk_id).value;
        } else {
            document.getElementById('categoria').value = document.getElementById('cat_prev').value 
        }
    }

	function cambia_sin_cedula(chk_id) {
		if(document.getElementById(chk_id).checked) {
			document.getElementById('clientes_id').value = document.getElementById('cod_cedula').value;
		} else {
			document.getElementById('clientes_id').value = '' 
		}
	}

    $("#clientes_genero").change(function() {
        <?php if ($categorias) { ?>
            busca_categoria();
		<?php } ?>
    });

/*
    $("#grupo").change(function() {
        <?php if ($categorias) { ?>
            busca_categoria();
		<?php } ?>
    });
*/

    function limpia_categorias() {
		var div = document.getElementById("hid_cat");
		var input_del = div.getElementsByTagName("input");
		for (var i = 0; i < input_del.length; i++) {
			div.removeChild(input_del[i]);
		}
		$("#categoria").val('');
//		document.getElementById('clientes_genero').options[0].selected = true;
		<?php if ($grupos_totales > 1) { ?>
			document.getElementById('grupo').options[0].selected = true;
		<?php } ?>
		$("#cat_prev").val('');		
    }

    function busca_categoria() {
		limpia_categorias();
        if ($('#clientes_edad').val() > 0 || $('#clientes_edad').val() != '') {
            var edad_part = $('#clientes_edad').val();
        } else { 
			// alert('Debe colocar su fecha de nacimiento para poder calcular la edad de su catergoría');			
            return;
        }
        if (document.getElementById('clientes_genero').options[document.getElementById('clientes_genero').selectedIndex].text != '') {
            var sexo_part = document.getElementById('clientes_genero').options[document.getElementById('clientes_genero').selectedIndex].text;
        } else { 
			alert('Debe colocar su género para poder ubicar su catergoría');			
            return;
        }
        $.ajax({
            type: 'get',
            url: 'index.php?route=sale/participantes/categoria&token=<?php echo $token; ?>',
            data: 'eventos_id=' + <?php echo $eventos_id; ?> + '&edad=' + edad_part + '&sexo=' + sexo_part,
            //doc.select.options[doc.select.selectedIndex].text;
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            beforeSend: function() {
                $('#clientes_fdn').attr('readonly', true);
                $('#clientes_fdn').after('<span class="wait">&nbsp;<img src="layout/image/loading.gif" alt="" /></span>');
				var div = document.getElementById("hid_cat");
				var input_del = div.getElementsByTagName("input");
				for (var i = 0; i < input_del.length; i++) {
					div.removeChild(input_del[i]);
				}
            },		
            complete: function() {
                $('#clientes_fdn').attr('readonly', false);
                $('.wait').remove();
            },			
            success: function(json) {
                $('.warning').remove();

                if (json['error']) {
                    alert(json['error']);
                };

                var grupos = <?php echo $grupos_totales; ?>;
                var i = 1;
                for (i = 0; i <= grupos - 1; i++) {
                    if (json['categoria_' + i]) {
//						alert('Categoria: ' + json['categoria_' + i].eventos_categorias_nombre);
                        if (json['categoria_' + i].eventos_categorias_nombre == undefined) {
                            // alert('No existe Categorías dispopnibles para su edad o género');	
                        } else {
                            if (json['categoria_' + i].eventos_categorias_grupo == '') {
                                if (json['categoria_' + i].eventos_categorias_nombre == '') {
                                    // alert('No existe Categorías dispopnibles para su edad');	
                                } else {
                                    $("#categoria").val(json['categoria_' + i].eventos_categorias_nombre);
                                    $("#cat_prev").val(json['categoria_' + i].eventos_categorias_nombre);
                                }
                            } else {
                                var input = document.createElement("input");
                                input.setAttribute("type", "hidden");
                                input.setAttribute("name", json['categoria_' + i].eventos_categorias_grupo);
                                input.setAttribute("id",json['categoria_' + i].eventos_categorias_grupo);
                                input.setAttribute("value", json['categoria_' + i].eventos_categorias_nombre);
								document.getElementById("hid_cat").appendChild(input);
                            }
                        }
//                    } else {
//                        alert('No existe Categorías dispopnibles para su edad o género');	
                    };
                }
				
				var inputs = document.getElementById("hid_cat").getElementsByTagName("input"); // inputs contiene la coleccion				
//				alert('Categoria Conseguidas: ' + inputs.length);
				
				if (inputs.length == 1) {

//					for(a=0; a<=inputs.length; a++) {	
						var grupo_econtrado = inputs[0].id;
						var categoria_econtrada = inputs[0].value;
//						alert('Grupo: ' + grupo_econtrado);
//					}
										
				}

				var i = 0;

				for (i = 0; i < document.getElementById('grupo').options.length; i++) {
					if (document.getElementById('grupo').options[i].text == grupo_econtrado) {
						document.getElementById('grupo').selectedIndex = i;
//						document.getElementById('grupo').disabled = true;
//						$("#grupo").attr("disabled", "disbled");
						$("#categoria").val(categoria_econtrada);
					} else {
						$("#grupo").removeAttr('disabled');
					};
				};

            }
        });
    }

/*
    function buscar_participante(cedula) {
        if (cedula == '') {
            alert('Debe colocar su número de cedula para completar la busqueda');
            return;
        }
        $.ajax({
            url: 'index.php?route=evento/participantes/consulta',
            type: 'post',
            data: 'eventos_id=' + <?php echo $eventos_id; ?> + '&cedula=' + cedula,
            dataType: 'json',

            beforeSend: function() {
                $('#cedula').attr('disabled', true);
                $('#cedula').after('<span class="wait">&nbsp;<img src="layout/image/loading.gif" alt="" /></span>');
            },		
            complete: function() {
                $('#cedula').attr('disabled', false);
                $('.wait').remove();
            },			
            success: function(json) {
                $('.warning').remove();

                if (json['error']) {
                    alert(json['error']);
                };

                if (json['output']) {
                    $('#datos-participacion .participante-content').html(json['output']);
                }
            }
        });	
    }
*/	
</script>

<script type="text/javascript" src="layout/template/sale/layout/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
//    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    $('.datetime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'h:m'
    });
    $('.time').timepicker({timeFormat: 'h:m'});
    //--></script> 
<script type="text/javascript"><!--
    $('#tabs a').tabs(); 
    $('#languages a').tabs(); 
    $('#vtab-option a').tabs();
    //--></script> 

<script>
    $(document).ready(function(){

        $("#paises_id").unbind().change(function(){
            var pais_id = $(this).val();
            // var token = <?php echo $token; ?>;
            $.ajax({
                url:'index.php?route=sale/participantes/estado&token=<?php echo $token; ?>',
                data: 'pais_id=' + pais_id,
                type: 'get',
                dataType: 'json', 
                success:function(json){

                }, 
                error: function(err){

                    $("#estados_id").html(err.responseText);
                }
            });
        })

    });
</script>

<script type="text/javascript">
    //            $('select[name=\'estados_id\']').load('index.php?route=evento/evento/estado&amp;pais_id=<?php echo $paises_id; ?>&amp;estados_id=<?php echo $estados_id; ?>');
    //            $('select[name=\'estados_id\']').load('index.php?route=evento/evento/estado&amp;pais_id=<?php // echo $paises_id; ?>&amp;estados_id=<?php // echo $estados_id; ?>');

    if ($.browser.msie && $.browser.version == 6) {
        $('.date, .datetime, .time').bgIframe();
    }

    $('.date').datepicker({
        yearRange: "-100:+0",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        onClose: function(dateText, inst) {
			calcula_edad(dateText);
/*
            var nacimiento = new Date(dateText);
            var y_nacimiento = nacimiento.getFullYear()
            var y_actual = new Date(<?php echo date('Y'); ?>)

            // If for some weird reason the year is coming as 2 format, make it 4
            if(y_actual <= 99) y_actual += 1900; 

            var edad = y_actual - y_nacimiento;

            if (edad <= 0) {
                $("#clientes_edad").removeAttr('disabled');
            } else {
                $("#clientes_edad").val(edad);
                $("#clientes_edad").attr('disabled','disabled');
            }
            <?php // if ($categorias) { ?>
                limpia_categorias();
                busca_categoria();
			<?php // } ?>
*/				
        }
    });
</script>

<script type="text/javascript">
/*
    $('#clientes_id').blur(function() {
        $.ajax({
            type: 'get',
            url: 'index.php?route=sale/participantes/cliente&token=<?php echo $token; ?>',
            data: 'eventos_id=' + <?php echo $eventos_id; ?> + '&clientes_id=' + this.value,
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            beforeSend: function() {
                $('#clientes_id').attr('disabled', true);
                $('#clientes_id').after('<span class="wait">&nbsp;<img src="layout/image/loading.gif" alt="" /></span>');
            },		
            complete: function() {
                $('#clientes_id').attr('disabled', false);
                $('.wait').remove();
            },			
            success: function(json) {
                $('.warning').remove();

                if (json['error']) {
                    $('#clientes_id').val('');
                    $('#clientes_id').focus();
                    alert(json['error']);
                };

                if (json['redirect']) {
                    location = json['redirect'];
                };

                if (json['output']) {

                    if (json['output'].apellido == undefined) {
                        $("#clientes_apellido").removeAttr('disabled');
                    } else {
                        $("#clientes_apellido").val(json['output'].apellido);
                    }

                    if (json['output'].nombre == undefined) {
                        $("#clientes_nombre").removeAttr('disabled');
                    } else {
                        $("#clientes_nombre").val(json['output'].nombre);
                    }

                    if (json['output'].sexo == 'M') {
                        valGenero = 'Masculino';
                    } else {
                        valGenero = 'Femenino';
                    };

                    var i = 0;
                    for (i = 0; i < document.getElementById('clientes_genero').options.length; i++) {
                        if (document.getElementById('clientes_genero').options[i].text == valGenero) {
                            document.getElementById('clientes_genero').selectedIndex = i;
                        } else {
                            $("#clientes_genero").removeAttr('disabled');
                        };
                    };

                    if (json['output'].nacimiento == undefined) {
                        $("#clientes_fdn").removeAttr('readonly');
                    } else {
                        $("#clientes_fdn").val(json['output'].nacimiento);
                        $("#clientes_fdn").attr('readonly', 'readonly');
                    }

                    if (json['output'].edad == undefined) {
                        $("#clientes_edad").removeAttr('disabled');
                    } else {
                        $("#clientes_edad").val(json['output'].edad);
                    }

//					limpia_categorias();
//					busca_categoria();

                    if (json['output'].mail == undefined) {
                        $("#clientes_email").removeAttr('disabled');
                    } else {
                        $("#clientes_email").val(json['output'].mail);
                    }

                    if (json['output'].celular == undefined) {
                        $("#cel").removeAttr('disabled');
                    } else {
                        $("#cel").val(json['output'].celular);
                    }

                } else {

                    $("#clientes_apellido").val('');
                    $("#clientes_apellido").removeAttr('disabled');
                    $("#clientes_nombre").val('');
                    $("#clientes_nombre").removeAttr('disabled');
                    document.getElementById('clientes_genero').selectedIndex = 0;
                    $("#clientes_genero").removeAttr('disabled');
                    $("#clientes_fdn").val('');
                    $("#clientes_fdn").removeAttr('readonly');
                    $("#clientes_edad").val('');
                    $("#categoria").val('');
                    $("#cat_prev").val('');
                    $("#clientes_email").val('');
                    $("#clientes_email").removeAttr('disabled');
                    $("#cel").val('');
                    $("#cel").removeAttr('disabled');

                };

//				limpia_categorias();
				busca_categoria();

                //							alert('PAUSA')


/*
                <?php // if ($categorias) { ?>
                    var grupos = <?php // echo $grupos_totales; ?>;
                    var i = 1;
                    for (i = 0; i <= grupos - 1; i++) {
                        if (json['categoria_' + i]) {
                            if (json['categoria_' + i].eventos_categorias_nombre == undefined) {
                                //								$("#categoria").removeAttr('disabled');
                            } else {
                                if (json['categoria_' + i].eventos_categorias_grupo == '') {
                                    $("#categoria").val(json['categoria_' + i].eventos_categorias_nombre);
                                } else {
                                    var input = document.createElement("input");
                                    input.setAttribute("type", "hidden");
                                    input.setAttribute("name", json['categoria_' + i].eventos_categorias_grupo);
                                    input.setAttribute("id",json['categoria_' + i].eventos_categorias_grupo);
                                    input.setAttribute("value", json['categoria_' + i].eventos_categorias_nombre);
                                    document.getElementById("hidden").appendChild(input);
                                }
                            }
                        };
                    }
				<?php // } ?>
*/
/*
            }
        });
    });
*/	
		</script>
<script language="javascript">
$(document).on("keypress", ".TabOnEnter" , function(e) {
    //Only do something when the user presses enter
    if( e.keyCode ==  13 )
    {
       var nextElement = $('input[tabindex="' + (this.tabIndex+1)  + '"]');

       if(nextElement.length )
        nextElement.focus();
       else
         $('input[tabindex="1"]').focus();  
    }   
})
/*
function enter2tab(e) {
    if (e.keyCode == 13) {
        cb = parseInt($(this).attr('tabindex'));
 
        if ($(':input[tabindex='' + (cb + 1) + '']') != null) {
            $(':input[tabindex='' + (cb + 1) + '']').focus();
            $(':input[tabindex='' + (cb + 1) + '']').select();
            e.preventDefault();
 
            return false;
        }
    }
}
*/
</script>
<?php echo $footer; ?>
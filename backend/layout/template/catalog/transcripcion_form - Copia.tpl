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
            <h1><img src="layout/image/product.png" alt="" /> <?php echo $heading_title; ?> - <?php echo isset($eventos_titulo) ? $eventos_titulo : ''; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <div class="dato">
                        <div id="dato-cupos">
                            <tr>
                                <td>
                                    <span class="required">*</span>
                                    <b>Restar Cupo Internet:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <select class="validate[required] TabOnEnter" id="cupo" name="cupo" tabindex="1">
<!--                                            <option selected="selected" value="" >--Cupo--</option> -->
                                            <option selected="selected" value="0">No</option>
                                            <option value="1">Si</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-reservados">
                            <tr>
								<td>
									<b>N&uacute;meros Reservados:</b><br />
								</td>
								<td>
									<div class="inputContainer">
										<select class="validate[required] TabOnEnter" id="numero_reservado" name="numero_reservado" tabindex="2" >
											<option selected="selected" value="">--N&uacute;meros--</option>
											<?php foreach ($numeros_reservados as $numero_reservado) { ?>
												<option value="<?php echo $numero_reservado['eventos_numeros_numero']; ?>"><?php echo $numero_reservado['eventos_numeros_numero']; ?></option>
											<?php } ?>
										</select>
									</div>
								</td>
							</tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-clientes_id">
                            <tr>
                                <td>
                                    <b>Planilla de Inscripci&oacute;n:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <input class="validate[required,maxSize[8],minSize[6],custom[onlyNumberSp]] text-input inputtext input_middle TabOnEnter" id="planilla_id" maxlength="12" name="planilla_id" size="12" tabindex="3" type="text" value="" />
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>

                    <?php if ($eventos_id == 96) { ?>
                        <div class="dato">
                            <div id="dato-equipo_nombre">
                                <tr>
                                    <td>
                                        <span class="required">*</span>
                                        <b>Nombre del Equipo:</b>
                                    </td>
                                    <td>
                                        <div class="inputContainer">
                                            <input class="validate[required,maxSize[10],minSize[5],custom[onlyLetterNumber]] text-input inputtext input_middle TabOnEnter" id="equipo_nombre" maxlength="24" name="opcion[Nombre Equipo]" size="24" tabindex="4" type="text" value="" />
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        </div>
                        <div class="dato">
                            <div id="dato-participantes_cantidad">
                                <tr>
                                    <td>
                                        <span class="required">*</span>
                                        <b>Cantidad de Participantes:</b><br />
                                    </td>
                                    <td>
                                        <div class="inputContainer">
                                            <select class="validate[required] TabOnEnter" id="participantes_cantidad" name="opcion[Cantidad Participantes]" onchange="cambia_equipo_cantidad();" tabindex="5">
                                                <option selected="selected" value="0" >--N&uacute;mero--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="4">4</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        </div>
                        <input type="hidden" id="cupos_equipo" name="cupos_equipo" value="0" />
                    <?php } ?>
                    
                    <div class="dato">
                        <div id="dato-clientes_id">
                            <tr>
                                <td>
                                    <span class="required">*</span>
                                    <b>C&eacute;dula o Pasaporte:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <input class="validate[required,maxSize[10],minSize[5],custom[onlyNumberSp]] text-input inputtext input_middle TabOnEnter" id="clientes_id" maxlength="10" name="opcion[C&eacute;dula]" size="10" tabindex="5" type="text" value="" />
										<?php if ($error_cedula) { ?>
											<span class="error"><?php echo $error_cedula; ?></span>
										<?php } ?>									
                                    </div>
									<?php if ($eventos_descripcion_cedula == 1) { ?>
										<label>El ni&ntilde;o no tiene n&uacute;mero de c&eacute;dula</label>
										<input type="checkbox" id="sin_cedula" name="sin_cedula" onclick="cambia_sin_cedula(this.id)" value="" />
									<?php } ?>
                                </td>
							</tr>
							<?php if ($eventos_privado) { ?>
								<tr>
									<?php if ($eventos_id == 21) { ?>
										<div class="dato">
											<div id="dato-empleado_id">
												<td>
													<span class="required">*</span>
													<b>N&uacute;mero de Carnet (BC):</b><br />
												</td>
												<td>
													<div class="inputContainer">
														<input class="validate[required,maxSize[12],minSize[5],custom[onlyNumberSp]] text-input inputtext input_middle TabOnEnter" id="empleados_id" maxlength="12" name="opcion[Carnet]" size="12" tabindex="6"  type="text" value="" />
													</div>
												</td>
											</div>
										</div>
									<?php } ?>
								</tr>
							<?php } ?>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-clientes_apellido">
                            <tr>
                                <td>
                                    <span class="required">*</span>
                                    <b>Apellido:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <input class="validate[required,maxSize[20],minSize[2],custom[onlyLetterSp]] TabOnEnter" id="clientes_apellido" name="opcion[Apellido]" size="20" tabindex="7" type="text" value="" />
										<?php if ($error_apellido) { ?>
											<span class="error"><?php echo $error_apellido; ?></span>
										<?php } ?>									
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-clientes_nombre">
                            <tr>
                                <td>
                                    <span class="required">*</span>
                                    <b>Nombre:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <input class="validate[required,maxSize[20],minSize[2],custom[onlyLetterSp]] TabOnEnter" id="clientes_nombre" name="opcion[Nombre]" size="20" tabindex="8" type="text" value="" />
										<?php if ($error_nombre) { ?>
											<span class="error"><?php echo $error_nombre; ?></span>
										<?php } ?>									
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-clientes_genero">
                            <tr>
                                <td>
                                    <span class="required">*</span>
                                    <b>G&eacute;nero:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <select class="validate[required] TabOnEnter" id="clientes_genero" name="opcion[G&eacute;nero]" tabindex="8">
                                            <option selected="selected" value="" >--G&eacute;nero--</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
										<?php if ($error_genero) { ?>
											<span class="error"><?php echo $error_genero; ?></span>
										<?php } ?>									
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-clientes_fdn">
                            <tr>
                                <td>
                                    <span class="required">*</span>
                                    <b>Fecha de Nacimiento:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer ">
                                        <input class="validate[required,custom[dateISO]] text-input date TabOnEnter" id="clientes_fdn" name="opcion[Fecha de Nacimiento]" onchangexx="window.setTimeout('calcula_edad(this.value)', 1000)" tabindex="9" type="text" value="" />
										<?php if ($error_fdn) { ?>
											<span class="error"><?php echo $error_fdn; ?></span>
										<?php } ?>									
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-clientes_email">
                            <tr>
                                <td>
                                    <b>Correo Electr&oacute;nico:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <input class="validate[required,custom[email]] text-input TabOnEnter" id="clientes_email" name="opcion[Correo Electr&oacute;nico]" size="30" tabindex="10" type="text" value="" />
										<?php // if ($error_email) { ?>
											<span class="error"><?php // echo $error_email; ?></span>
										<?php // } ?>									
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-cel">
                            <tr>
                                <td>
                                    <b>Tel&eacute;fono Celular:</b><br />
                                </td>
                                <td>
                                    <div class="inputContainer">
                                        <input class="validate[required],maxSize[11],minSize[11],custom[onlyNumberSp] TabOnEnter" id="cel" maxlength="11" name="opcion[Celular]" size="11" tabindex="11" type="text" value="" />
										<?php // if ($error_cel) { ?>
											<span class="error"><?php // echo $error_cel; ?></span>
										<?php // } ?>									
                                    </div>
                                </td>
                            </tr>
                        </div>
                    </div>
                    <div class="dato">
                        <div id="dato-paises_id">
                            <tr>
								<td>
									<span class="required">*</span>
									<b>Pa&iacute;s:</b><br />
								</td>
								<td>
									<div class="inputContainer">
										<select class="validate[required] TabOnEnter" id="paises_id" name="opcion[Pa&iacute;s]" tabindex="12" >
											<!--										<select class="validate[required]" id="paises_id" name="opcion[Pa&iacute;s]" onchange="$('select[name=\'opcion[estados_id]\']').load('index.php?route=evento/evento/estado&amp;pais_id=' + this.value + '&amp;estados_id=<?php // echo $estados_id; ?>');" tabindex="11" >-->
											<option selected="selected" value="">--Pa&iacute;s--</option>
											<?php foreach ($paises as $pais) { ?>
												<?php if ($pais['paises_id'] == $paises_id) { ?>
													<option selected="selected" value="<?php echo $pais['paises_id']; ?>"><?php echo $pais['paises_nombre']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $pais['paises_id']; ?>"><?php echo $pais['paises_nombre']; ?></option>
													<?php } ?>
												<?php } ?>
										</select>
										<?php if ($error_pais) { ?>
											<span class="error"><?php echo $error_pais; ?></span>
										<?php } ?>									
									</div>
								</td>
							</tr>
                        </div>	
                    </div>
                    <div class="dato">
                        <div id="dato-estados_id">
                            <tr>
								<td>
									<span class="required">*</span>
									<b>Estado:</b><br />
								</td>
								<td>
									<div class="inputContainer">
										<select class="validate[required] TabOnEnter" id="estados_id" name="opcion[Estado]" tabindex="13">
										</select>
										<?php if ($error_estado) { ?>
											<span class="error"><?php echo $error_estado; ?></span>
										<?php } ?>									
									</div>
								</td>
							</tr>
                        </div>
                    </div>
                    <?php if ($grupos_totales > 1) { ?>
                        <div class="dato">
                            <div id="dato-grupo">
                                <tr>
									<td>
										<span class="required">*</span>
										<b>Grupo:</b><br />
									</td>
									<td>
										<div class="inputContainer">
											<select class="validate[required] TabOnEnter" id="grupo" name="opcion[Grupo]" onchange="cambia_categoria(this.value);" tabindex="14">
												<!--										<select class="validate[required]" id="paises_id" name="opcion[Pa&iacute;s]" onchange="$('select[name=\'opcion[estados_id]\']').load('index.php?route=evento/evento/estado&amp;pais_id=' + this.value + '&amp;estados_id=<?php // echo $estados_id; ?>');" tabindex="11" >-->
												<option selected="selected" value="">--Grupo--</option>
												<?php foreach ($grupos_categorias as $grupo) { ?>
													<option value="<?php echo $grupo['eventos_categorias_grupo']; ?>"><?php echo $grupo['eventos_categorias_grupo']; ?></option>
													<?php } ?>
											</select>
											<?php if ($error_grupo) { ?>
												<span class="error"><?php echo $error_grupo; ?></span>
											<?php } ?>									
											<?php if ($eventos_descripcion_circuito == 1) { ?>
												<br  />
												<input type="text" id="circuito" name="circuito" value="" readonly="readonly"/> <span>Aqu&iacute; se muestra el grupo del Historial de Circuito</span>
											<?php } ?>									
										</div>
									</td>
								</tr>
                            </div>	
                        </div>
					<?php } ?>
					<?php if ($eventos_descripcion_numeracion_id_tipo == 3) { // 3 = Tiempos ?>
						<div class="dato">
							<div id="dato-tiempo">
                                <tr>
									<td>
										<span class="required">*</span>
										<b>Tiempo:</b><br />
									</td>
									<td>
										<div class="inputContainer">
											<input type="text" id="tiempo" name="opcion[Tiempo]" readonly="readonly" value="" />
										</div>
									</td>
								</tr>
							</div>
						</div>
						<div class="dato">
							<div id="dato-rango">
                                <tr>
									<td>
										<span class="required">*</span>
										<b>Rango:</b><br />
									</td>
									<td>
										<div class="inputContainer">
											<select class="validate[required] TabOnEnter" id="rango" name="opcion[Rango]" tabindex="10" >
												<option selected="selected" value="">--Rangos--</option>
												<?php foreach ($rangos as $rango) { ?>
													<option value="<?php echo $rango['eventos_numeros_th']; ?>">De <?php echo $rango['eventos_numeros_td']; ?> a <?php echo $rango['eventos_numeros_th']; ?></option>
												<?php } ?>
											</select>
										</div>
									</td>
								</tr>
							</div>	
						</div>
					<?php } ?>
                    <?php if ($categorias) { ?>
                        <div class="dato">
                            <div id="dato-edad">
                                <tr>
									<td>
										<span class="required">*</span>
										<b>Edad:</b><br />
									</td>
									<td>
										<div class="inputContainer">
											<input type="text" id="clientes_edad" name="opcion[Edad]" value="" />
											<?php if ($error_edad) { ?>
												<span class="error"><?php echo $error_edad; ?></span>
											<?php } ?>									
										</div>
									</td>
								</tr>
                            </div>
                        </div>
                        <div class="dato">
                            <div id="dato-categoria">
                                <tr>
									<td>
										<span class="required">*</span>
										<b>Categor&iacute;a:</b><br />
									</td>
									<td>
										<div class="inputContainer">
											<input type="text" readonly="readonly" id="categoria" name="opcion[Categor&iacute;a]" size="45" value="" />
											<?php if ($error_categoria) { ?>
												<span class="error"><?php echo $error_categoria; ?></span>
											<?php } ?>									
										</div>
									</td>
								</tr>
                            </div>
                        </div>
                        <?php if ($categorias_opcionales) { ?>
                            <div id="dato-cat_opc">
                                <tr>
									<td>
										<b>Categor&iacute;a(s) Opcional(es):</b><br />
									</td>
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
                        <?php } ?>

                        <?php if ($eventos_id == 96) { ?>
                            <div id="opcion-capitan">
                                <tr>
                                    <td>
                                        <b>&iquest;Es el capitan del equipo?:</b>
                                    </td>
                                    <td>
                                        <div class="inputContainer">
                                            <input class="validate[required] radio" type="radio" name="opcion[Miembro]" value="Capit&aacute;n" id="participante_capitan" />
                                            <label for="participante_capitan">Capit&aacute;n</label>
                                        </div>
                                        <div class="inputContainer">
                                            <input class="validate[required] radio" type="radio" name="opcion[Miembro]" value="Participante" id="participante_capitan" />
                                            <label for="participante_capitan">Participante</label>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        <?php } ?>


                    <?php if ($opciones) { ?>
                        <div class="options">
                            <?php foreach ($opciones as $opcion) { ?>
                                <?php if ($opcion['opcion_tipo'] == 'select') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
													<td>
														<div class="inputContainer">
															<select id="<?php echo $opcion['opcion_dato']; ?>" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]">
																<option value=""><?php echo $text_select; ?></option>
																<?php foreach ($opcion['opcion_valor'] as $opcion_valor) { ?>
																	<option value="<?php echo $opcion_valor['eventos_opcion_valor_id']; ?>"><?php echo $opcion_valor['opcion_valor_decripcion_nombre']; ?> </option>
																	<?php } ?>
															</select>
														</div>
													</td>
												</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'radio') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
												
                                            <?php foreach ($opcion['opcion_valor'] as $opcion_valor) { ?>
													<td>
														<label><?php echo $opcion_valor['opcion_valor_decripcion_nombre']; ?> </label>
														<input type="radio" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]" value="<?php echo $opcion_valor['eventos_opcion_valor_id']; ?>" id="opcion-valor-<?php echo $opcion_valor['eventos_opcion_valor_id']; ?>" />
													</td>
                                                <?php } ?>
											</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'checkbox') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
                                            <?php foreach ($opcion['opcion_valor'] as $opcion_valor) { ?>
													<td>
														<label><?php echo $opcion_valor['opcion_valor_decripcion_nombre']; ?></label>
														<input type="checkbox" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>][]" value="<?php echo $opcion_valor['eventos_opcion_valor_id']; ?>" id="opcion-valor-<?php echo $opcion_valor['eventos_opcion_valor_id']; ?>" />
													</td>
                                                <?php } ?>
											</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'text') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
											<tr>
												<td>
													<?php if ($opcion['eventos_opcion_requerido']) { ?>
														<span class="required">*</span>
													<?php } ?>
													<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
												</td>
												<td>
													<div class="inputContainer">
														<input id="<?php echo $opcion['opcion_dato']; ?>" type="text" name="opcion[<?php echo $opcion['opcion_nombre']; ?>]" value="<?php echo $opcion['opcion_valor']; ?>" />
													</div>
												</td>
											</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'textarea') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
													<td>
														<textarea id="<?php echo $opcion['opcion_dato']; ?>" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]" cols="40" rows="5"><?php echo $opcion['opcion_valor']; ?></textarea>
													</td>
												</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'file') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
													<td>
														<a id="button-option-<?php echo $opcion['eventos_opcion_id']; ?>" class="button_link"><span><?php echo $button_upload; ?></span></a>
														<input type="hidden" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]" value="" />
													</td>
												</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'date') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
													<td>
														<div class="inputContainer">
															<input id="<?php echo $opcion['opcion_dato']; ?>" type="text" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]" value="<?php echo $opcion['opcion_valor']; ?>" class="date" />
														</div>
													</td>
												</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'datetime') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
													<td>
														<div class="inputContainer">
															<input id="<?php echo $opcion['opcion_dato']; ?>" type="text" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]" value="<?php echo $opcion['opcion_valor']; ?>" class="datetime" />
														</div>
													</td>
												</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php if ($opcion['opcion_tipo'] == 'time') { ?>
                                    <div class="option">
                                        <div id="opcion-<?php echo $opcion['eventos_opcion_id']; ?>">
                                            <?php if ($opcion['eventos_opcion_requerido']) { ?>
                                                <tr>
													<td>
														<span class="required">*</span>
														<?php } ?>
														<b><?php echo $opcion['opcion_nombre']; ?>:</b><br />
													</td>
													<td>
														<div class="inputContainer">
															<input id="<?php echo $opcion['opcion_dato']; ?>" type="text" name="opcion[<?php echo $opcion['eventos_opcion_id']; ?>]" value="<?php echo $opcion['opcion_valor']; ?>" class="time" />
														</div>
													</td>
												</tr>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                        	</div>
                        <?php } ?>

						<?php if ($eventos_privado) { ?>
							<?php if ($eventos_id == 21) { ?>
								<div class="options">
									<div class="option">
										<div id="opcion-acompaniante">
											<tr>
												<td>
													<b>&iquest;Llevar&aacute; usted un acompa&ntilde;ante a la carrera-caminata?:</b>
												</td>
												<td>
													<div class="inputContainer">
														<input class="validate[required] radio" type="radio" name="opcion[Acompañante]" value="Si" id="opcion-valor-acompaniante" onclick="show_alert()"/>
														<label for="opcion-valor-acompaniante">Si</label>
													</div>
													<div class="inputContainer">
														<input class="validate[required] radio" type="radio" name="opcion[Acompañante]" value="No" id="opcion-valor-acompaniante" />
														<label for="opcion-valor-acompaniante">No</label>
													</div>
												</td>
											</tr>
										</div>
										<div id="opcion-transporte">
											<tr>
												<td>
													<b>&iquest;Utilizar&aacute; el transporte para llegar al evento?:</b><br />
												</td>
												<td>
													<div class="inputContainer">
														<input class="validate[required] radio" type="radio" name="opcion[Transporte]" value="Si" id="opcion-valor-transporte" onclick="EnableCiudad()"/>
														<label for="opcion-valor-transporte">Si</label>
													</div>
													<br />
													<div class="inputContainer">
														<input class="validate[required] radio" type="radio" name="opcion[Transporte]" value="No" id="opcion-valor-transporte" onclick="DisableCiudad()" />
														<label for="opcion-valor-transporte">No</label>
													</div>
												</td>
											</tr>
										</div>
										<div id="opcion-ciudad">
											<tr>
												<td>
													<b>&iquest;Desde qu&eacute; ciudad necesita traslado?:</b><br />
												</td>
												<td>
													<input type="radio" name="opcion[Ciudad]" value="Caracas" id="opcion-valor-ciudad" />
													<label for="opcion-valor-ciudad">Caracas</label>
													<br />
													<input type="radio" name="opcion[Ciudad]" value="Maracay" id="opcion-valor-ciudad" />
													<label for="opcion-valor-ciudad">Maracay</label>
													<br />
													<input type="radio" name="opcion[Ciudad]" value="Valencia" id="opcion-valor-ciudad" />
													<label for="opcion-valor-ciudad">Barquisimeto</label>
												</td>
											</tr>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } ?>

                        <?php if ($eventos_id == 57) { ?>
                            <div class="options">
                                    <div class="option">
                                        <div id="opcion-mascota-nombre">
											<tr>
												<td>
                                                    <span class="required">*</span>
		                                            <b>Nombre:</b>
												</td>
												<td>
                                                    <div class="inputContainer">
                                                        <input class="validate[required] TabOnEnter" type="text" name="opcion[Nombre de la Mascota]" value="" id="opcion-valor-mascota-nombre" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </div>
                                        <div id="opcion-mascota-edad">
											<tr>
												<td>
                                                    <span class="required">*</span>
                                                    <b>Edad:</b>
												</td>
												<td>
                                                    <div class="inputContainer">
                                                        <input class="validate[required] TabOnEnter" type="text" name="opcion[Edad de la Mascota]" value="" id="opcion-valor-mascota-edad" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </div>
                                        <div id="opcion-mascota-raza">
											<tr>
												<td>
                                                    <span class="required">*</span>
                                                    <b>Raza:</b>
												</td>
												<td>
                                                    <div class="inputContainer">
                                                        <select class="validate[required] TabOnEnter" id="razas_id" name="opcion[Raza]" tabindex="8" >
                <!--										<select class="validate[required]" id="paises_id" name="opcion[Pa&iacute;s]" onchange="$('select[name=\'opcion[estados_id]\']').load('index.php?route=evento/evento/estado&amp;pais_id=' + this.value + '&amp;estados_id=<?php // echo $estados_id; ?>');" tabindex="11" >-->
                                                            <option selected="selected" value="">--Razas--</option>
                                                            <?php foreach ($razas as $raza) { ?>
                                                                <?php if ($raza['razas_id'] == $razas_id) { ?>
                                                                    <option selected="selected" value="<?php echo $raza['razas_id']; ?>"><?php echo $raza['razas_nombre']; ?></option>
                                                                    <?php } else { ?>
                                                                    <option value="<?php echo $raza['razas_id']; ?>"><?php echo $raza['razas_nombre']; ?></option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </div>	
                                        <div id="opcion-mascota-genero">
											<tr>
												<td>
		                                            <b>G&eacute;nero:</b>
												</td>
												<td>
                                                    <div class="inputContainer">
                                                        <input class="validate[required] radio" type="radio" name="opcion[Género de la Mascota]" value="Macho" id="opcion-valor-mascota-genero" />
                                                        <label for="opcion-valor-mascota-genero">Macho</label>
                                                    </div>
                                                    <div class="inputContainer">
                                                        <input class="validate[required] radio" type="radio" name="opcion[Género de la Mascota]" value="Hembra" id="opcion-valor-mascota-genero" />
                                                        <label for="opcion-valor-mascota-genero">Hembra</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </div>
                                    </div>
                            </div>
                        <?php } ?>

                    <div class="divider"></div>
                    <div class="cart">
                        <input type="hidden" name="quantity" size="2" value="1" />
                        <input type="hidden" id="eventos_id" name="eventos_id" size="2" value="<?php echo $eventos_id; ?>" />
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
</div>
<script type="text/javascript">
/*
    function calcula_edad(nacimiento){
        var nacimiento = new Date(nacimiento);
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
        <?php if ($categorias) { ?>
            limpia_categorias();
            busca_categoria();
            <?php } ?>
    }
*/
	function calcula_edad(nacimiento){
		if ($('#clientes_fdn').val() != '') {
			var fdn_part = $('#clientes_fdn').val();
		} else { 
			return;
		}
		$.ajax({
			type: 'get',
			url: 'index.php?route=catalog/transcripcion/edad&token=<?php echo $token; ?>',
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
//            limpia_categorias();
            busca_categoria();
		<?php } ?>
    });

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
		<?php if ($eventos_id != 96) { ?>
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
				url: 'index.php?route=catalog/transcripcion/categoria&token=<?php echo $token; ?>',
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
		<?php } ?>
    }


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
	
	function buscar_rango(tiempo) {
		$.ajax({
			url:"index.php?route=evento/evento/rango",
			type: 'post',
			data: 'eventos_id=' + <?php echo $eventos_id; ?> + '&tiempo=' + tiempo,
			dataType: 'json',
			success:function(json){
			}, 
			error: function(out){
				$("#rango").html(out.responseText);
			}
/*
			beforeSend: function() {
				$('#rango').attr('disabled', true);
				$('#rango').after('<span class="wait">&nbsp;<img src="imagenes/loading.gif" alt="" /></span>');
			},		
			complete: function() {
				$('#rango').attr('disabled', false);
				$('.wait').remove();
			},			
			success: function(json) {
				$('.warning').remove();
*/
/*
				if (json['error']) {
					alert(json['error']);
				};
*/
/*
				if (json['output']) {
					$('#datos-rango .participante-content').html(json['output']);
				}
			}
*/			
		});	
	}
	
	function cambia_equipo_cantidad() {
		var cantidad_participantes = document.getElementById('participantes_cantidad').options[document.getElementById('participantes_cantidad').selectedIndex].text;

		$('#Solo').attr("disabled", true);
		$('#Duo').attr("disabled", true);
		$('#Race').attr("disabled", true);
		$('#Maratón').attr("disabled", true);

		$('#cupos_equipo').val(cantidad_participantes);
		
		if (cantidad_participantes == '1') {
			$('#categoria').val('Solo');
			$('#Solo').prop('checked', true);
			$('#Duo').prop('checked', false);
			$('#Race').prop('checked', false);
			$('#Maratón').prop('checked', false);
			$('#Solo').attr("disabled", false);
			$('#Duo').attr("disabled", true);
			$('#Race').attr("disabled", true);
			$('#Maratón').attr("disabled", true);
		} else if (cantidad_participantes == '2') {
			$('#categoria').val('Duo');
			$('#Solo').prop('checked', false);
			$('#Duo').prop('checked', true);
			$('#Race').prop('checked', false);
			$('#Maratón').prop('checked', false);
			$('#Solo').attr("disabled", true);
			$('#Duo').attr("disabled", false);
			$('#Race').attr("disabled", true);
			$('#Maratón').attr("disabled", true);
		} else if (cantidad_participantes == '4') {
			$('#categoria').val('Race');
			$('#Solo').prop('checked', false);
			$('#Duo').prop('checked', false);
			$('#Race').prop('checked', true);
			$('#Maratón').prop('checked', false);
			$('#Solo').attr("disabled", true);
			$('#Duo').attr("disabled", true);
			$('#Race').attr("disabled", false);
			$('#Maratón').attr("disabled", true);
		} else if (cantidad_participantes == '6') {
			$('#categoria').val('Maratón');
			$('#Solo').prop('checked', false);
			$('#Duo').prop('checked', false);
			$('#Race').prop('checked', false);
			$('#Maratón').prop('checked', true);
			$('#Solo').attr("disabled", true);
			$('#Duo').attr("disabled", true);
			$('#Race').attr("disabled", true);
			$('#Maratón').attr("disabled", false);
		}
		
	}  	

</script>

<script type="text/javascript" src="layout/template/catalog/layout/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
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
                url:'index.php?route=catalog/transcripcion/estado&token=<?php echo $token; ?>',
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
    $('#clientes_id').blur(function() {
        $.ajax({
            type: 'get',
            url: 'index.php?route=catalog/transcripcion/cliente&token=<?php echo $token; ?>',
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
						calcula_edad($("#clientes_fdn").val);
                    }

/*
                    if (json['output'].edad == undefined) {
                        $("#clientes_edad").removeAttr('disabled');
                    } else {
                        $("#clientes_edad").val(json['output'].edad);
                    }
*/

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

					if (json['tiempo'] == undefined || json['tiempo'] == false) {
						$("#tiempo").val('n/a');
					} else {
						$("#tiempo").val(json['tiempo']);
						$("#rango").attr('disabled','disabled');

						valTiempo = json['tiempo'];
						var t = 0;
						for (t = 0; t < document.getElementById('rango').options.length; t++) {
//									alert('El valor del tiempo de la opcion es: ' + document.getElementById('rango').options[t].value);
//									CompararHoras(valTiempo, document.getElementById('rango').options[t].value);
							if (document.getElementById('rango').options[t].value >= valTiempo) {
								document.getElementById('rango').selectedIndex = t;
								return;
							};
						};
						
					}
					

                    if (json['grupo'] != undefined) {
						$("#circuito").val(json['grupo']);
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
					$("#tiempo").val('n/a');
					$("#rango").removeAttr('disabled');
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
            }
        });
    });
		</script>
		<script type="text/javascript">
			$('#empleados_id').blur(function() {
				$.ajax({
					type: 'get',
		            url: 'index.php?route=catalog/transcripcion/cliente&token=<?php echo $token; ?>',
//					url: 'index.php?route=evento/evento/empleado',
					data: 'eventos_id=' + <?php echo $eventos_id; ?> + '&empleados_id=' + this.value,
					contentType: "application/json; charset=utf-8",
					dataType: 'json',
					beforeSend: function() {
						$('#empleados_id').attr('disabled', true);
						$('#empleados_id').after('<span class="wait">&nbsp;<img src="imagenes/loading.gif" alt="" /></span>');
					},		
					complete: function() {
						$('#empleados_id').attr('disabled', false);
						$('.wait').remove();
					},			
					success: function(json) {
						$('.warning').remove();
	
						if (json['cupos'] == 2) {
//							alert(json['cupos']);
							alert('Usted ya superó la cantidad de inscritos permitidos.');
							$('#empleados_id').val('');
							$('#empleados_id').focus();
						} else {
							if (json['cupos'] + 1 >= 2) {
								$('#opcion-acompaniante :input').attr('checked', false);
								$('#opcion-acompaniante :input').attr('disabled', true);
								$('#opcion-acompaniante :input').removeAttr('class');
							} else {
	//							alert(json['cupos']);
								$('#opcion-acompaniante :input').removeAttr('disabled');
							}
						};

					}
				});
			});
		</script>
<script language="javascript">
function EnableCiudad()
{
	//enable Ciudad options
	$('#opcion-ciudad :input').removeAttr('disabled');
}

function DisableCiudad()
{
	//disable Virginia options
	$('#opcion-ciudad :input').attr('checked', false);
	$('#opcion-ciudad :input').attr('disabled', true);
}

function show_alert()
{
	alert("Una vez terminada tu inscripción, para formalizar el registro de tu acompañante regresa a \"inscripciones on-line\" y llena sus datos colocando tu número de carné (BC)");
//	alert("Hello! I am an alert box!");
}
function deshabilita(valor) {
  for (i=0; rad = $('#opcion-valor-ciudad')[i]; i++)
    rad.disabled = valor;
/*
	$('#opcion-valor-caracas').disabled = valor;
	$('#opcion-valor-maracay').disabled = valor;
	$('#opcion-valor-valencia').disabled = valor;
*/
//  if (valor) document.$('#opcion-valor-ciudad')[1].checked = true;
}
/*
function radios(obj){ 
	if(obj.value=="No"){ 
		for(i=0; i<document.getElementById('opcion-valor-ciudad').length; i++){ 
			document.getElementById('opcion-valor-ciudad').checked=false; 
			document.getElementById('opcion-valor-ciudad').disabled=true; 
		} 
	} else{ 
		for(i=0; i<document.getElementById('opcion-valor-ciudad').length; i++){ 
			document.getElementById('opcion-valor-ciudad').disabled=false; 
		} 
	} 
} 
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
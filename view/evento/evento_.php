<?php echo $header; ?>
<div class="container clearfix">
    <div class="sixteen columns bottom">
        <!-- breadcrumbs -->
        <ul class="breadcrumbs gray">
            <li><a href="<?php echo $home; ?>"><span class="icon home gray"></span></a></li>
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
        </ul>

        <!-- Page Title -->
        <h1 class="page-title">Evento: <?php echo $eventos_titulo; ?><span class="line"></span></h1> 

    </div>

    <div class="eleven columns bottom">

        <h2 class="title">Resumen: <?php echo $eventos_titulo; ?><span class="line"></span></h2>

        <ul class="progress-bar">
          <li>
            <h5>Tiempo del Primer Participante (<?php echo $tiempo_min; ?>)</h5>
            <div class="meter"><span style="width: <?php echo $porcentaje_min; ?>%"></span></div><!-- Edite width here -->
          </li>
          <li>
            <h5>Tiempo del Último Participante (<?php echo $tiempo_max; ?>)</h5>
            <div class="meter"><span style="width: 100%"></span></div><!-- Edite width here -->
          </li>
          <li>
            <h5>Tiempo Promedio (<?php echo $tiempo_avg; ?>)</h5>
            <div class="meter"><span style="width: <?php echo $porcentaje_avg; ?>%"></span></div><!-- Edite width here -->
          </li>
        </ul>

    </div>
      
    <div class="five columns bottom">

        <h2 class="title">Imágen del evento<span class="line"></span></h2>

        <img src="<?php echo $eventos_imagen; ?>" alt="<?php echo $eventos_titulo; ?>" class="pic" /> 

    </div>

    <div class="sixteen columns bottom">

        <h2 class="title">Resultados: <?php echo $eventos_titulo; ?><span class="line"></span></h2>
        
        <ul id="toggle-view">
            <li>
                <h3 class="color">Absolutos</h3>
                <span class="link">+</span>
                <div class="panel">
		            <h5>Ranking General</h5>
                    <table>
                      <tbody>
                        <tr>
                          <th>Posición</th>
                          <th>Nombre</th>
                          <th>Número</th>
                          <th>Género</th>
                          <th>Categoría</th>
                          <th>Tiempo Oficial</th>
                          <th>Tiempo Chip</th>
                          <?php if ($eventos_id == 287) { ?> 
	                          <th>Punto de Control</th>
                          <?php } ?> 
                        </tr>
						<?php foreach ($resultados_absolutos as $resultado) { ?>
                        <tr>
                          <td><?php echo $resultado['pos_general']; ?></td>
                          <td><?php echo $resultado['nombre']; ?></td>
                          <td><?php echo $resultado['numero']; ?></td>
                          <td><?php echo $resultado['genero']; ?></td>
                          <td><?php echo $resultado['categoria']; ?></td>
                          <td><?php echo $resultado['time_oficial']; ?></td>
                          <td><?php echo $resultado['time_tag']; ?></td>
                          <?php if ($eventos_id == 287) { ?> 
	                          <td><?php echo $resultado['time_cp1']; ?></td>
                          <?php } ?> 
                        </tr>
						<?php } ?>
                      </tbody>
                    </table>
                </div>
            </li>
        
            <li>
                <h3 class="color">Por Género</h3>
                <span class="link">+</span>
                <div class="panel">
					<?php foreach ($resultados_genero as $genero) { ?>
                        <h5>Ranking Género: <?php echo $genero['genero']; ?></h5>
                        <table>
                          <tbody>
                            <tr>
                              <th>Posición</th>
                              <th>Nombre</th>
                              <th>Número</th>
                              <th>Género</th>
                              <th>Categoría</th>
                              <th>Tiempo Oficial</th>
                              <th>Tiempo Chip</th>
							  <?php if ($eventos_id == 287) { ?> 
                                  <th>Punto de Control</th>
                              <?php } ?> 
                            </tr>
                            <?php foreach ($genero['resultados'] as $resultado) { ?>
                            <tr>
                              <td><?php echo $resultado['pos_genero']; ?></td>
                              <td><?php echo $resultado['nombre']; ?></td>
                              <td><?php echo $resultado['numero']; ?></td>
                              <td><?php echo $resultado['genero']; ?></td>
                              <td><?php echo $resultado['categoria']; ?></td>
                              <td><?php echo $resultado['time_oficial']; ?></td>
                              <td><?php echo $resultado['time_tag']; ?></td>
							  <?php if ($eventos_id == 287) { ?> 
                                  <td><?php echo $resultado['time_cp1']; ?></td>
                              <?php } ?> 
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
					<?php } ?>
                </div>
            </li>
        
            <li>
                <h3 class="color">Por Categorías</h3>
                <span class="link">+</span>
                <div class="panel">
					<?php foreach ($resultados_categoria as $categoria) { ?>
                        <h5>Ranking Categoría: <?php echo $categoria['categoria']; ?></h5>
                        <table>
                          <tbody>
                            <tr>
                              <th>Posición</th>
                              <th>Nombre</th>
                              <th>Número</th>
                              <th>Género</th>
                              <th>Categoría</th>
                              <th>Tiempo Oficial</th>
                              <th>Tiempo Chip</th>
							  <?php if ($eventos_id == 287) { ?> 
                                  <th>Punto de Control</th>
                              <?php } ?> 
                            </tr>
                            <?php foreach ($categoria['resultados'] as $resultado) { ?>
                            <tr>
                              <td><?php echo $resultado['pos_categoria']; ?></td>
                              <td><?php echo $resultado['nombre']; ?></td>
                              <td><?php echo $resultado['numero']; ?></td>
                              <td><?php echo $resultado['genero']; ?></td>
                              <td><?php echo $resultado['categoria']; ?></td>
                              <td><?php echo $resultado['time_oficial']; ?></td>
                              <td><?php echo $resultado['time_tag']; ?></td>
							  <?php if ($eventos_id == 287) { ?> 
                                  <td><?php echo $resultado['time_cp1']; ?></td>
                              <?php } ?> 
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
					<?php } ?>
                </div>
            </li>
        </ul>

	</div>

    <div class="sixteen columns bottom">
    
        <h2 class="title">B&uacute;squeda de resultados<span class="line"></span></h2>
        
        <div class="form">
            <div id="fields">
                <form id="form_consulta" action=""/>
                    <div class="form-box">
                        <label>N&uacute;mero</label>
                        <input type="text" id="numero" name="numero" class="text" />
                    </div><!-- End Box -->
        
                    <div class="form-box">
                        <label>C&eacute;dula</label>
                        <input type="text" id="cedula" name="cedula" class="text" />
                    </div><!-- End Box -->

                    <a id="submit" class="button large color" style="margin-top: 30px;">Buscar resultados</a>
<!--				<input type="submit" name="submit" value="Buscar resultados" class="button medium color" /> -->
                </form>
            </div><!-- End fields -->
        </div>

    	<div id="notify"></div>

<!--
        <div class="alert success hideit">
            <p></p>
            <span class="close"></span>
        </div>
        <div class="alert notice hideit">
            <p></p>
            <span class="close"></span>
        </div>
-->
	    <div id="resultados"></div>     
        
	</div>
</div>    
	
<script type="text/javascript">

	$('#submit').live('click', function() {
		
		var cedula = '';
		var numero = '';
		var cedula = $('#cedula').val();
		var numero = $('#numero').val();

/*
		if ($('#form_consulta').validationEngine('validate') == false) {
			return;
		}
*/
		$.ajax({
			url: 'index.php?route=evento/evento/resultado&eventos_id=' + <?php echo $eventos_id; ?>,
			type: 'post',
			data: 'cedula=' + cedula + '&numero=' + numero,
			dataType: 'json',

			beforeSend: function() {
				$('#submit').attr('disabled', true);
				$('#submit').after('<span class="wait">&nbsp;<img src="imagenes/loading.gif" alt="" /></span>');
				$('#resultados').fadeOut(680);
			},		
			complete: function() {
				$('#submit').attr('disabled', false);
				$('.wait').remove();
			},			
			success: function(data) {
				$('.notice').remove();

				if (data['error']) {
					$('#notify').html('<div class="alert notice hideit"><p>' + data['error'] + '</p><span class="close"></span></div>');
					$('#notify').fadeIn(680);
					$(".hideit").click(function() {$(this).fadeOut(600);});
				};

				if (data['output']) {
					$('#resultados').html(data['output']);
					$('#resultados').fadeIn('fast');
				}
			}
		});	
	});
</script>

<script>
$(document).ready(function() {

	$("#resultados").hide();
//	$("#form_consulta").validationEngine();	
	
});
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
</script>
<script type="text/javascript">
<!--
$('#form_consulta').keydown(function(e) {
	if (e.keyCode == 13) {
		buscar_participante($('#cedula').val());
	}
});
//-->
</script> 
<!-- footer --> 
<?php echo $footer; ?> 
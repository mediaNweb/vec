<div class="sixteen columns">
  <h1 class="page-title">Resultados: <?php echo $nombre; ?> (<?php echo $categoria; ?>)<span class="line"></span></h1>
</div>
<div class="sixteen columns bottom"> 
  
  <!-- Pricing Tables 2 -->
  <div class="pricing-tables-2">
    <div class="tables-column data-title">
      <div class="header gray"></div>
      <!-- End header -->
      
      <ul class="list">
        <li class="even" data="Género">Género</li>
        <li class="odd" data="Categoría">Categoría</li>
        <li class="even" data="Tiempo Oficial">Tiempo Oficial</li>
        <li class="odd" data="Tiempo Chip">Tiempo Chip</li>
		<?php if ($eventos_id == 287) { ?> 
            <li class="even" data="Punto de Control">Punto de Control</li>
		<?php } ?> 
        <li class="odd" data="Posición General">Posición General</li>
        <li class="even" data="Posición por Género">Posición por Género</li>
        <li class="odd" data="Posición por Categoría">Posición por Categoría</li>
        <li class="even" data="Ritmo">Ritmo</li>
      </ul>
    </div>
    <!-- End column -->
    
    <div class="tables-column featured">
      <div class="header gray">
        <h3><span>Número: <?php echo $numero; ?></span><?php echo $nombre; ?></h3>
      </div>
      <!-- End header -->
      <ul class="list">
        <li class="even" data-title="Género"><?php echo $genero; ?></li>
        <li class="odd" data-title="Categoría"><?php echo $categoria; ?></li>
        <li class="even" data-title="Tiempo Oficial"><?php echo $time_oficial; ?></li>
        <li class="odd" data-title="Tiempo Chip"><?php echo $time_tag; ?></li>
		<?php if ($eventos_id == 287) { ?> 
	        <li class="even" data-title="Punto de Control"><?php echo $time_cp1; ?></li>
		<?php } ?> 
        <li class="odd" data-title="Posición General"><?php echo $pos_general; ?></li>
        <li class="even" data-title="Posición por Género"><?php echo $pos_genero; ?></li>
        <li class="odd" data-title="Posición por Categoría"><?php echo $pos_categoria; ?></li>
        <li class="even" data-title="Ritmo"><?php echo $ritmo; ?></li>
      </ul>
      <div class="footer gray">
      </div>
      <!-- End footer --> 
      
    </div>
    <!-- End column -->
    
    <div class="tables-column">
      <div class="header black">
        <h3><span>Número: <?php echo $general_numero; ?></span><?php echo $general_nombre; ?></h3>
      </div>
      <!-- End header -->
      <ul class="list">
        <li class="even" data-title="Género"><?php echo $general_genero; ?></li>
        <li class="odd" data-title="Categoría"><?php echo $general_categoria; ?></li>
        <li class="even" data-title="Tiempo Oficial"><?php echo $general_time_oficial; ?></li>
        <li class="odd" data-title="Tiempo Chip"><?php echo $general_time_tag; ?></li>
		<?php if ($eventos_id == 287) { ?> 
	        <li class="even" data-title="Punto de Control"><?php echo $general_time_cp1; ?></li>
		<?php } ?> 
        <li class="odd" data-title="Posición General"><?php echo $general_pos_general; ?></li>
        <li class="even" data-title="Posición por Género"><?php echo $general_pos_genero; ?></li>
        <li class="odd" data-title="Posición por Categoría"><?php echo $general_pos_categoria; ?></li>
        <li class="even" data-title="Ritmo"><?php echo $general_ritmo; ?></li>
      </ul>
      <div class="footer black">
      </div>
      <!-- End footer --> 
    </div>
    <!-- End column --> 
    
    <!-- ================ Featured Column ================ -->
    
    <div class="tables-column">
      <div class="header black">
        <h3><span>Número: <?php echo $genero_numero; ?></span><?php echo $genero_nombre; ?></h3>
      </div>
      <!-- End header -->
      <ul class="list">
        <li class="even" data-title="Género"><?php echo $genero_genero; ?></li>
        <li class="odd" data-title="Categoría"><?php echo $genero_categoria; ?></li>
        <li class="even" data-title="Tiempo Oficial"><?php echo $genero_time_oficial; ?></li>
        <li class="odd" data-title="Tiempo Chip"><?php echo $genero_time_tag; ?></li>
		<?php if ($eventos_id == 287) { ?> 
	        <li class="even" data-title="Punto de Control"><?php echo $genero_time_cp1; ?></li>
		<?php } ?> 
        <li class="odd" data-title="Posición General"><?php echo $genero_pos_general; ?></li>
        <li class="even" data-title="Posición por Género"><?php echo $genero_pos_genero; ?></li>
        <li class="odd" data-title="Posición por Categoría"><?php echo $genero_pos_categoria; ?></li>
        <li class="even" data-title="Ritmo"><?php echo $genero_ritmo; ?></li>
      </ul>
      <div class="footer">
      </div>
      <!-- End footer --> 
    </div>
    <!-- End column --> 
    
    <!-- ================ End Featured Column ================ -->
    
    <div class="tables-column">
      <div class="header black">
        <h3><span>Número: <?php echo $categoria_numero; ?></span><?php echo $categoria_nombre; ?></h3>
      </div>
      <!-- End header -->
      <ul class="list">
        <li class="even" data-title="Género"><?php echo $categoria_genero; ?></li>
        <li class="odd" data-title="Categoría"><?php echo $categoria_categoria; ?></li>
        <li class="even" data-title="Tiempo Oficial"><?php echo $categoria_time_oficial; ?></li>
        <li class="odd" data-title="Tiempo Chip"><?php echo $categoria_time_tag; ?></li>
		<?php if ($eventos_id == 287) { ?> 
	        <li class="even" data-title="Punto de Control"><?php echo $categoria_time_cp1; ?></li>
		<?php } ?> 
        <li class="odd" data-title="Posición General"><?php echo $categoria_pos_general; ?></li>
        <li class="even" data-title="Posición por Género"><?php echo $categoria_pos_genero; ?></li>
        <li class="odd" data-title="Posición por Categoría"><?php echo $categoria_pos_categoria; ?></li>
        <li class="even" data-title="Ritmo"><?php echo $categoria_ritmo; ?></li>
      </ul>
      <div class="footer black">
      </div>
      <!-- End footer --> 
    </div>
    <!-- End column --> 
    
  </div>
  <!-- End --> 

       <div class="clearfix"></div>
       
       <div id="welcome">
       <div class="sixteen columns">
        <div class="qoute">
          <div class="eleven columns omega">
            <h2>¿Quieres imprimir tu certificado de participación?</h2>
            <p>Haz clic en el boton para verlo</p>
          </div>
          <div class="four columns alpha"><a href="<?php echo $certificado; ?>" target="_blank" class="link">Ver Certificado</a></div>
        </div>
       </div>
       </div><!-- End Welcome -->
  
</div>
<!-- End column  --> 


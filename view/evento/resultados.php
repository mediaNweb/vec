<!--
===========================
== BEGIN RESULTS SECTION ==
===========================
-->

<section id="pricing" class="centered">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <!-- BEGIN Attention Box -->
        <?php if ($eventos_revista == '1') { ?>
          <div class="attention-box">
            <p><?php echo $text_result_instamagazine; ?></p>
            <a href="<?php echo $instamagazine_url; ?>" target="_blank" class="more"><?php echo $text_result_instamagazine_link; ?></a>
          </div>
          <!--/ .attention-box -->
          <!--/ END Attention Box -->
      </div>
    <?php } ?>
    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 centered">
      <p class="section-title"><?php echo $nombre; ?></p>
      <h2 class="section-heading"><?php echo $text_result_section_heading; ?></h2>
    </div>
    <!--/ .col-lg-8 -->

    <div class="clearfix"></div>

    <!-- BEGIN Pricing Table -->
    <ul class="pricing">
      <div class="col-lg-3 col-md-3 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2">
        <li class="price best-value" Xdata-sr="enter bottom over 1s and move 80px wait 0.2s">
          <h5 class="price-title"><?php echo $nombre; ?> <span class="price-label"><?php echo $pais; ?></span></h5>
          <span class="best-value-label"><?php echo $text_result_col_athlete; ?></span>
          <div class="price-amount"><?php echo $numero; ?></div>
          <ul class="price-feature">
            <li><?php echo $text_result_cell_race_title; ?> <strong><?php echo $carrera; ?></strong></li>
            <li><?php echo $text_result_cell_bracket_title; ?> <strong><?php echo $categoria; ?></strong></li>
            <li><?php echo $text_result_cell_net; ?> <strong><?php echo $time_tag; ?></strong></li>
            <li><?php echo $text_athlete_result_cell_bracket; ?></li>
            <li><?php echo $text_athlete_result_cell_gender; ?></li>
            <li><?php echo $text_athlete_result_cell_overall; ?></li>
          </ul>
          <!--/ .price-feature -->
          <a href="#0" class="price-button all-caps"><?php echo $ritmo; ?> <?php echo $speed_unit; ?></a>
        </li>
        <!--/ .price -->
      </div>
      <!--/ .col-lg-3 -->

      <div class="col-lg-3 col-md-3 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2">
        <li class="price" Xdata-sr="enter bottom over 1s and move 80px wait 0.3s">
          <h5 class="price-title"><?php echo $general_nombre; ?> <span class="price-label"><?php echo $general_pais; ?></span></h5>
          <span class="best-value-label"><?php echo $text_result_col_overall; ?></span>
          <div class="price-amount"><?php echo $general_numero; ?></div>
          <ul class="price-feature">
            <li><?php echo $text_result_cell_race_title; ?> <strong><?php echo $general_carrera; ?></strong></li>
            <li><?php echo $text_result_cell_bracket_title; ?> <strong><?php echo $general_categoria; ?></strong></li>
            <li><?php echo $text_result_cell_net; ?> <strong><?php echo $general_time_tag; ?></strong></li>
            <li><?php echo $text_overall_result_cell_bracket; ?></li>
            <li><?php echo $text_overall_result_cell_gender; ?></li>
            <li><?php echo $text_overall_result_cell_overall; ?></li>
          </ul>
          <!--/ .price-feature -->
          <a href="#0" class="price-button all-caps"><?php echo $general_ritmo; ?> <?php echo $speed_unit; ?></a>
        </li>
        <!--/ .price -->
      </div>
      <!--/ .col-lg-3 -->

      <div class="col-lg-3 col-md-3 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2">
        <li class="price" Xdata-sr="enter bottom over 1s and move 80px wait 0.4s">
          <h5 class="price-title"><?php echo $genero_nombre; ?> <span class="price-label"><?php echo $genero_pais; ?></span></h5>
          <span class="best-value-label"><?php echo $text_result_col_gender; ?></span>
          <div class="price-amount"><?php echo $genero_numero; ?></div>
          <ul class="price-feature">
            <li><?php echo $text_result_cell_race_title; ?> <strong><?php echo $genero_carrera; ?></strong></li>
            <li><?php echo $text_result_cell_bracket_title; ?> <strong><?php echo $genero_categoria; ?></strong></li>
            <li><?php echo $text_result_cell_net; ?> <strong><?php echo $genero_time_tag; ?></strong></li>
            <li><?php echo $text_gender_result_cell_bracket; ?></li>
            <li><?php echo $text_gender_result_cell_gender; ?></li>
            <li><?php echo $text_gender_result_cell_overall; ?></li>
          </ul>
          <!--/ .price-feature -->
          <a href="#0" class="price-button all-caps"><?php echo $genero_ritmo; ?> <?php echo $speed_unit; ?></a>
        </li>
        <!--/ .price -->
      </div>
      <!--/ .col-lg-3 -->

      <div class="col-lg-3 col-md-3 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2">
        <li class="price" Xdata-sr="enter bottom over 1s and move 80px wait 0.5s">
          <h5 class="price-title"><?php echo $categoria_nombre; ?> <span class="price-label"><?php echo $categoria_pais; ?></span></h5>
          <span class="best-value-label"><?php echo $text_result_col_bracket; ?></span>
          <div class="price-amount"><?php echo $categoria_numero; ?></div>
          <ul class="price-feature">
            <li><?php echo $text_result_cell_race_title; ?> <strong><?php echo $categoria_carrera; ?></strong></li>
            <li><?php echo $text_result_cell_bracket_title; ?> <strong><?php echo $categoria_categoria; ?></strong></li>
            <li><?php echo $text_result_cell_net; ?> <strong><?php echo $categoria_time_tag; ?></strong></li>
            <li><?php echo $text_bracket_result_cell_bracket; ?></li>
            <li><?php echo $text_bracket_result_cell_gender; ?></li>
            <li><?php echo $text_bracket_result_cell_overall; ?></li>
          </ul>
          <!--/ .price-feature -->
          <a href="#0" class="price-button all-caps"><?php echo $categoria_ritmo; ?> <?php echo $speed_unit; ?></a>
        </li>
        <!--/ .price -->
      </div>
      <!--/ .col-lg-3 -->

    </ul>
    <!--/ .pricing -->
    <!--/ END Pricing Table -->

    </div>
    <!--/ .row -->
  </div>
  <!--/ .container -->
</section>
<!--
==========================
==/ END RESULTS SECTION ==
==========================
-->

<!--
===============================
== BEGIN CERTIFICATE SECTION ==
===============================
-->
<?php if ($eventos_certificado == '1') { ?>
  <section id="breakout" class="breaking centered">
    <div class="color-overlay">
      <div class="breaking-content">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 centered">
              <h4></h4>
              <p class="sub-lead"><?php echo $text_result_certificate; ?></p>
              <a href="<?php echo $certificado; ?>" target="_blank" class="cta cta-default all-caps clearfix" Xdata-sr="enter bottom over 1s and move 75px"><?php echo $text_result_certificate_link; ?></a>
              <div class="clearfix"></div>
              <small Xdata-sr="enter bottom over 1s and move 75px wait 0.2s"><a href="<?php echo $chronotrack; ?>" target="_blank"><?php echo $text_result_widget_link; ?></a></small>
            </div>
            <!--/ .col-lg-12 -->

          </div>
          <!--/ .row -->
        </div>
        <!--/ .container -->

      </div>
      <!--/ .breaking-content -->

    </div>
    <!--/ .color-overlay -->
  </section>
<?php } ?>
<!--
==============================
==/ END CERTIFICATE SECTION ==
==============================
-->
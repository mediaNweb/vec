<!--
=============================
== BEGIN EVENTS SECTION ==
=============================
-->

<section id="events" class="gray-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 centered">
        <p class="section-title"><?php echo $text_events_section_title; ?></p>
        <h2 class="section-heading margin-top-min-13"><?php echo $text_events_section_description; ?></h2>
      </div>
      <!--/ .col-lg-8 --> 
      
    </div>
    <!--/ .row --> 
  </div>
  <!--/ .container -->
  
  <div class="container-full">
    <div class="row"> <a href="#0" id="mobile-portfolio-filter" class="mobile-filter-select visible-xs"> 
      <!--
        <h4 class="all-caps">Select Category<span class="icon-chevron-thin-down"></span></h4>
        </a>
        <ul class="portfolio-filter">
          <li class="current all"><a href="#0">All</a></li>
          <li class="branding"><a href="#0">Branding</a></li>
          <li class="photography"><a href="#0">Photography</a></li>
          <li class="website"><a href="#0">Website</a></li>
        </ul>
--> 
      <!--/ .portfolio-filter --> 
      
      <!-- BEGIN Portfolio Content -->
      <ul class="portfolio-list" id="portfolio_grid">
        <?php foreach ($eventos as $evento) { ?>
        <?php $eventos_id = $evento["eventos_id"]; ?>
        <li data-type="events" data-id="<?php echo $eventos_id; ?>">
          <figure> 
          	<a href="<?php echo $evento['eventos_href']; ?>" class="Xswipebox" title="<?php echo $evento['eventos_titulo']; ?>"> <!-- large/Lightbox Image --> 
                <img src="<?php echo $evento['eventos_imagen_home']; ?>" alt="<?php echo $evento['eventos_titulo']; ?>"/>
                <figcaption>
                  <div class="caption-content">
                  	<small><em><?php echo $evento['eventos_fecha']; ?></em></small>
                    <p><?php echo $evento['eventos_titulo']; ?></p>
                  </div>
                </figcaption>
            </a> <!--/ swipebox gallery --> 
          </figure>
        </li>
        <?php } ?>
      </ul>
      <!--/ .portfolio-list --> 
      <!--/ END Portfolio Content -->
      
      <div class="clearfix"></div>
      <div class="col-lg-12 centered margin-top-20"> <a href="#0" name="btn_more" data-event="<?php echo $eventos_id; ?>" id="btn_more" class="cta cta-default all-caps"><?php echo $button_load_more_events; ?></a> </div>
    </div>
    <!--/ .row --> 
    
  </div>
  <!--/ .container-full --> 
  
</section>
<!--
============================
==/ END PORTFOLIO SECTION ==
============================
--> 
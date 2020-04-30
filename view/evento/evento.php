<?php echo $header; ?>
<!--
========================
== BEGIN MAIN CONTENT ==
========================
-->

<main id="main-content" class="blog-layout" style="margin-bottom: 234px;"> 
  <!-- margin value is the height of your footer --> 
  
  <!--
  ========================
  == BEGIN HERO SECTION ==
  ========================
  -->
  <section id="hero">
    <div class="container">
      <div class="vertical-center-wrapper">
        <div class="vertical-center-table">
          <div class="vertical-center-content"> 
            
            <!-- BEGIN Hero Content -->
            <div class="hero-content row centered">
              <div class="col-lg-12">
                <h1 class="all-caps text-shadow-medium" data-sr="enter top over 1s and move 50px wait 0.3s"><?php echo $eventos_titulo; ?></h1>
                <p class="lead all-caps text-shadow-small" data-sr="enter top over 1s and move 50px wait 0.4s"><?php echo $eventos_lugar; ?> - <?php echo $eventos_fecha; ?></p>
                
                <!-- BEGIN Hero Subscribe -->
                <div class="row">
                  <div class="hero-subscribe-wrapper col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <form id="hero-results" class="the-subscribe-form" data-sr="enter bottom over .5s and move 10px wait 0.3s">
                      <div class="input-group">
                        <input id="numero" type="text" class="form-control" placeholder="<?php echo $input_results_form_bib; ?>">
                        <span class="input-group-btn">
                        <button class="btn btn-subscribe" id="search_submit" type="button"><?php echo $button_results; ?></button>
                        </span> </div>
                      <!--/ .input-group -->
                    </form>
                    <!--/ #hero-subscribe --> 
                  </div>
                  <!--/ .hero-subscribe-wrapper --> 
                </div>
                <!--/ .row --> 
                <!--/ End Hero Subscribe --> 
              </div>
              <!--/ .col-lg-12 --> 
            </div>
            <!--/ .row --> 
            <!-- END Hero Content --> 
            
          </div>
          <!--/ .vertical-center-content --> 
        </div>
        <!--/ .vertical-center-table --> 
      </div>
      <!-- / .vertical-center-wrapper --> 
      
    </div>
    <!--/ .container --> 
    
  </section>
  <!--
=======================
==/ END HERO SECTION ==
=======================
-->
  <div id="resultados"></div>
</main>
<!--/ #main-content --> 
<!--
=======================
==/ END MAIN CONTENT ==
=======================
--> 

<!-- footer --> 
<?php echo $footer; ?> 
<script type="text/javascript">

	$('#search_submit').on('click', function() {
		var numero = '';
		var numero = $('#numero').val();
		$('#error-notification').removeClass('show-up');
		$('#resultados').fadeOut(680);

		$.ajax({
			url: 'index.php?route=evento/evento/resultado&eventos_id=' + <?php echo $eventos_id; ?>,
			type: 'post',
			data: '&numero=' + numero,
			dataType: 'json',

			beforeSend: function() {
				$('#search_submit').attr('disabled', true);
			},		
			complete: function() {
				$('#search_submit').attr('disabled', false);
			},			
			success: function(data) {
				if (data['error']) {
					$('#error-notification p').html(data['error']);
					$('#error-notification').addClass('show-up');
				}
		
				if (data['output']) {
					$('#error-notification').removeClass('show-up');
					$('#resultados').html(data['output']);
					$('#resultados').fadeIn('fast');
				}
			}
		});	
	});
</script> 
<!--
=================================
== BEGIN CONTACT MODAL CONTENT ==
=================================
-->
<div class="contact-overlay overlay-scale"> <a class="overlay-close"><?php echo $button_close; ?></a>
  <div class="container">
    <div class="row">
      <div class="contact-content col-lg-10 col-lg-offset-1 centered">
        <h2 class="all-caps"><?php echo $text_contact_section_title; ?></h2>
        <p><?php echo $text_contact_section_description; ?></p>
        
        <!-- BEGIN Contact Form -->
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3">
          <form class="contact-form" id="contact-form" method="post">
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="required-field">
                  <input name="fname" id="fname" class="contact-input"  type="text" placeholder="<?php echo $input_contact_form_first_name; ?>">
                </div>
                <!--/ .required-field --> 
                
              </div>
              <!--/ .col-lg-6 -->
              
              <div class="col-lg-6 col-md-6">
                <input name="lname" id="lname" class="contact-input" type="text" placeholder="<?php echo $input_contact_form_last_name; ?>">
              </div>
              <!--/ .col-lg-6 -->
              
              <div class="col-lg-12 col-md-12">
                <div class="required-field">
                  <input name="email" id="email" class="contact-input" type="email" placeholder="<?php echo $input_contact_form_email_address; ?>">
                </div>
                <!--/ .required-field --> 
                
              </div>
              <!--/ .col-lg-12 -->
              
              <div class="col-lg-12 col-md-12">
                <input name="subject" id="subject" class="contact-input" type="text" placeholder="<?php echo $input_contact_form_subject; ?>">
              </div>
              <!--/ .col-lg-12 -->
              
              <div class="col-lg-12 col-md-12">
                <div class="required-field">
                  <textarea name="message" id="message" rows="9" placeholder="<?php echo $input_contact_form_message; ?>"></textarea>
                </div>
                <!--/ .required-field --> 
                
              </div>
              <!--/ .col-lg-12 -->
              
              <div class="col-lg-12 col-md-12 all-caps centered">
                <button id="submit" type="submit" class="submit-btn"><?php echo $button_submit; ?></button>
              </div>
              <!--/ .col-lg-12 --> 
              
            </div>
          </form>
          <!--/ .contact-form --> 
          
        </div>
        <!--/ .col-lg-6 --> 
        <!--/ END Contact Form --> 
        
      </div>
      <!--/ .contact-content --> 
      
    </div>
    <!--/ .row --> 
    
  </div>
  <!--/ .container --> 
  
</div>
<!--/ .contact-overlay --> 

<!--
================================
==/ END CONTACT MODAL CONTENT ==
================================
--> 

<!--
======================================
== BEGIN FORM NOTIFICATIONS CONTENT ==
======================================
--> 

<!-- BEGIN Contact Form Alert/Notifications -->
<div id="error-notification" class="notif-box"> <span class="icon-bullhorn notif-icon"></span>
  <p><?php echo $error_contact_form_message; ?></p>
  <a class="notification-close"><?php echo $button_close; ?></a> </div>
<!--/ #error-notification -->

<div id="success-notification" class="notif-box"> <span class="icon-checkmark notif-icon"></span>
  <p><?php echo $error_contact_form_success; ?></p>
  <a class="notification-close"><?php echo $button_close; ?></a> </div>
<!--/ #success-notification --> 
<!-- END Contact Form Alert/Notifications --> 
<!--
=====================================
==/ END FORM NOTIFICATIONS CONTENT ==
=====================================
--> 
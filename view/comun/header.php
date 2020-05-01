<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
  <?php } ?>
  <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
  <?php } ?>
  <meta name="author" content="mediaNweb">
  <title><?php echo $title; ?></title>

  <!-- CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic|Montserrat:700,400|Varela+Round">

  <!-- Font Icon -->
  <link rel="stylesheet" href="fonts/icomoon/icomoon.css">

  <!-- Swipebox -->
  <link rel="stylesheet" href="css/swipebox.css">

  <!-- Animate CSS -->
  <link rel="stylesheet" href="css/animate.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style-responsive.css">
  <link rel="stylesheet" href="css/expandableGallery.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
  <script src="js/modernizr.js"></script><!-- Modernizr -->

  <!-- FAV AND TOUCH ICONS -->
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="images/favicon/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/favicon/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favicon/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/favicon/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="60x60" href="images/favicon/apple-touch-icon-60x60.png" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="images/favicon/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon-precomposed" sizes="76x76" href="images/favicon/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="images/favicon/apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-196x196.png" sizes="196x196" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-16x16.png" sizes="16x16" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-128.png" sizes="128x128" />
  <meta name="application-name" content="Racetimer Europe" />
  <meta name="msapplication-TileColor" content="#BA2626" />
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png" />
  <meta name="msapplication-square70x70logo" content="images/favicon/mstile-70x70.png" />
  <meta name="msapplication-square150x150logo" content="images/favicon/mstile-150x150.png" />
  <meta name="msapplication-wide310x150logo" content="images/favicon/mstile-310x150.png" />
  <meta name="msapplication-square310x310logo" content="images/favicon/mstile-310x310.png" />

  <?php echo $google_analytics; ?>

</head>

<body>
  <!--
==========================
== BEGIN HEADER CONTENT ==
==========================
-->
  <header id="main-header" class="the-header the-origin-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-12"> <a href="index.html" class="logo"><img src="images/logo.png" alt="Logo"></a> <!-- Your Logo -->

          <a href="#0" id="nav-menu-trigger" class="menu-toggle flip pull-right all-caps"><?php echo $text_menu; ?><span class="icon-menu5"></span></a> <!-- Menu Toggle -->

        </div>
        <!--/ .col-lg-12 -->

      </div>
      <!--/ .row -->
    </div>
    <!--/ .container -->

  </header>
  <!--
=========================
==/ END HEADER CONTENT ==
=========================
-->

  <!--
============================
== BEGIN NAV MENU CONTENT ==
============================
-->
  <nav id="nav-wrapper"> <a class="nav-close" href="#0"><span class="icon-cross2"></span></a>
    <ul id="main-nav" class="main-nav all-caps">
      <li class="current"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
      <li><a href="#events"><?php echo $text_events; ?></a></li>
      <li><a href="#0" class="contact-trigger"><?php echo $text_contact; ?></a></li>
    </ul>
    <!--/ .main-nav -->

    <ul class="secondary-nav">
      <li><a href="#0"><?php echo $text_dutch; ?></a></li>
      <li><a href="#0"><?php echo $text_french; ?></a></li>
      <li><a href="#0"><?php echo $text_english; ?></a></li>
      <li><a href="#0"><?php echo $text_swedish; ?></a></li>
    </ul>
    <!--/ .secondary-nav -->

  </nav>
  <!--
===========================
==/ END NAV MENU CONTENT ==
===========================
-->
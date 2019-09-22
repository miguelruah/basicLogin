<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php if ( isset($headTitle) && $headTitle!="" ) {print $headTitle;} else {print "Simple Responsive Template";} ?></title>
    <meta name="description" content="Simple Responsive Template is a template for responsive web design. Mobile first, responsive grid layout, toggle menu, navigation bar with unlimited drop downs, responsive slideshow">
    <meta name="keywords" content="">

    <!-- Mobile viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">

    <link rel="shortcut icon" href="images/favicon.ico"  type="image/x-icon">

    <!-- CSS-->
    <!-- Google web fonts. You can get your own bundle at http://www.google.com/fonts. Don't forget to update the CSS accordingly!-->
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif|Ubuntu' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="js/flexslider/flexslider.css">
    <link rel="stylesheet" href="css/basic-style.css">
<?php
if ( isset($includeLoginFormStyles) && $includeLoginFormStyles ) print "    <link rel=\"stylesheet\" href=\"css/styles.css\">\n";
?>

    <!-- end CSS-->

    <!-- JS-->
    <script src="js/libs/modernizr-2.6.2.min.js"></script>
    <!-- end JS-->

</head>

<body id="home">
  
    <header class="wrapper clearfix">
		       
    <div id="banner">        
            <div id="logo"><a href="/"><img src="images/basic-logo.svg" alt="logo"></a></div> 
    </div>

    <!-- main navigation -->
    <nav id="topnav" role="navigation">
      <div class="menu-toggle">Menu</div>  
      <ul class="srt-menu" id="menu-main-navigation">
          <li class="current"><a href="/">Home page</a></li>
          <li><a href="/page2">Inner Page Sample</a></li>
          <li><a href="#">menu item 3</a>
              <ul>
                  <li>
                      <a href="#">menu item 3.1</a>
                  </li>
                  <li>
                      <a href="#">menu item 3.2</a>
                      <ul>
                          <li><a href="#">menu item 3.2.1</a></li>
                          <li><a href="#">menu item 3.2.2 with longer link name</a></li>
                          <li><a href="#">menu item 3.2.3</a></li>
                          <li><a href="#">menu item 3.2.4</a></li>
                          <li><a href="#">menu item 3.2.5</a></li>
                      </ul>
                  </li>
                  <li><a href="#">menu item 3.3</a></li>
                  <li><a href="#">menu item 3.4</a></li>
              </ul>
          </li>
          <li>
              <a href="#">menu item 4</a>
              <ul>
                  <li><a href="#">menu item 4.1</a></li>
                  <li><a href="#">menu item 4.2</a></li>
              </ul>
          </li>
          <li>
              
              <?php if ( isset($_SESSION['email']) && $_SESSION['email'] != '' ) { // session exists => display full menu ?><a href="/dashboard">Private</a>
              <ul>
                  <li><a href="/dashboard">Dashboard</a></li>
                  <li><a href="/logout">Logout</a></li>
              </ul>
              <?php } else { ?>
              <a href="/login">Login</a>
              <?php } ?>
          </li>
      </ul>     
            </nav><!-- end main navigation -->
  
    </header><!-- end header -->

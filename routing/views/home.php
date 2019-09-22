<?php
$headTitle = "Home Page";
include '../routing/views/header.php';
?>
<!-- hero area (the grey one with a slider -->
    <section id="hero" class="clearfix">    
    <!-- responsive FlexSlider image slideshow -->
    <div class="wrapper">
       <div class="row"> 
        <div class="grid_5">
            <h1>Basic Login Demo</h1>
            <p>...is a template for responsive web design. A small set of tools and best practices that allows web designers to build responsive websites faster. Websites built with Simple Responsive Template will be optimized for screen widths between 320px and anything. Resize your browser to check it out.
            </p>
            <p><a href="#" class="buttonlink">CALL TO ACTION</a> <a href="#" class="buttonlink">ONE MORE</a></p>
        </div>
        <div class="grid_7 rightfloat">
              <div class="flexslider">
                  <ul class="slides">
                      <li>
                          <img src="images/basic-pic1.jpg" />
                          <p class="flex-caption">Love Brazil !!! Sea view from Rio de Janeiro fort.</p>
                      </li>
                      <li>
                          <a href="http://www.prowebdesign.ro"><img src="images/basic-pic2.jpg" /></a>
                          <p class="flex-caption">El Arco Cabo Mexico. This image is wrapped in a link.</p>
                      </li>
                      <li>
                          <img src="images/basic-pic3.jpg" />
                          <p class="flex-caption">Arches National Park, Utah, Usa.</p>
                      </li>
                      <li>
                          <img src="images/basic-pic4.jpg" />
                          <p class="flex-caption">Morocco desert.</p>
                      </li>
                  </ul>
                </div><!-- FlexSlider -->
              </div><!-- end grid_7 -->
        </div><!-- end row -->
       </div><!-- end wrapper -->
    </section><!-- end hero area -->





<!-- main content area -->   
<div id="main" class="wrapper">
    
    
<!-- content area -->    
	<section id="content" class="wide-content">
      <div class="row">	
        <div class="grid_4">
        	<h1 class="first-header">Brazil!</h1>
            <img src="images/basic-pic1.jpg" />
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        </div>
        
        <div class="grid_4">
        	<h1 class="first-header">Mexico!</h1>
            <img src="images/basic-pic2.jpg" />
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        </div>
        
        <div class="grid_4">
        	<h1 class="first-header">US!</h1>
            <img src="images/basic-pic3.jpg" />
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        </div>
	  </div><!-- end row -->
	</section><!-- end content area -->   
      
      
    <!-- columns demo, delete it!-->
    <section id="columnsdemo" style="margin-bottom:60px; width:100%" class="clearfix">
        <h2 style="width:100%; clear:both">Columns demo</h2>
        <div class="grid_12">12</div>
        
        <div class="grid_1">1</div>
        <div class="grid_11">11</div>
        
        <div class="grid_2">2</div>
        <div class="grid_10">10</div>
        
        <div class="grid_3">3</div>
        <div class="grid_9">9</div>
        
        <div class="grid_4">4</div>
        <div class="grid_8">8</div>
        
        <div class="grid_5">5</div>
        <div class="grid_7">7</div>
        
        <div class="grid_6">6</div>
        <div class="grid_6">6</div>
                
        <div class="grid_4">4</div>
        <div class="grid_4">4</div>
        <div class="grid_4">4</div>
        
        <div class="grid_1">1</div>
        <div class="grid_2">2</div>
        <div class="grid_3">3</div>
        <div class="grid_3">3</div>
        <div class="grid_3">3</div>   
    </section>
    <!-- end columns demo -->  
    
      
  </div><!-- #end div #main .wrapper -->


<?php
include '../routing/views/footer.php';
?>


<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.9.0.min.js">\x3C/script>')</script>

<script defer src="js/flexslider/jquery.flexslider-min.js"></script>

<!-- fire ups - read this file!  -->   
<script src="js/main.js"></script>

</body>
</html>
<?php
$headTitle = "404 - Page Not Found";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper" id="main"> 

        <h1>Oops !!... Page not found</h1>

        <!-- content area -->    
        <section id="content" class="wide-content">
        </section><!-- #end content area -->
    </div><!-- #end div #main .wrapper -->



<?php
include '../routing/views/footer.php';
print "    <script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>\n";
print "    <script type=\"text/javascript\" src=\"js/script.js\"></script>\n";

?>

    <script type="text/javascript" defer src="js/flexslider/jquery.flexslider-min.js"></script>

    <!-- fire ups - read this file!  -->
    <script type="text/javascript" src="js/main.js"></script>


</body>
</html>
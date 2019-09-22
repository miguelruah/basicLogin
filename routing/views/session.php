<?php

// start the session so we can have access to the session token and email
session_start();

$headTitle = "Session Info";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper pumpDaHeight" id="main"> 

        <!-- content area -->    
        <section id="content" class="wide-content">
            <p>$_SESSION['email']: '<?php if (isset($_SESSION['email'])) print $_SESSION['email']; ?>'</p>
        </section><!-- #end content area -->
    </div><!-- #end div #main .wrapper -->


<?php
include '../routing/views/footer.php';
print "    <script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>\n";
print "    <script type=\"text/javascript\" src=\"js/script.js\"></script>\n";

?>

    <script defer src="js/flexslider/jquery.flexslider-min.js"></script>

    <!-- fire ups - read this file!  -->
    <script src="js/main.js"></script>

</body>
</html>
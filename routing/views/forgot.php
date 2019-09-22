<?php

session_start();

$headTitle = "Password Reset";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper pumpDaHeight" id="main"> 

        <!-- content area -->    
        <section id="content" class="wide-content">
            <h1>Password Reset</h1>
            <p>If we found your email in our database, we sent you an email with instructions to reset your password.</p>
            <p>Should you not receive it within the next minutes, be sure to check your SPAM box.</p>
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
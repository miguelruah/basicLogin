<?php
$includeLoginFormStyles = true;
$headTitle = "Registration Successful";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper" id="main"> 

        <!-- content area -->    
        <section id="content" class="wide-content">
            <h1>Registration Successful</h1>
            <p>Congratulations !! You successfully registered as a user.</p>
            <p>You may now <a href="/login">login</a> and have access to all our restricted menu options.</p>
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
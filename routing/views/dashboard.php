<?php

// start the session so we can have access to the session token and email
session_start();

// create new instance of login class and verify timeout
$login = new loginclass();

// include the following block at the beginning of each private page
// *** START BLOCK ***
if ( isset($_SESSION['email']) && $_SESSION['email'] != '' ) {
    $result = $login->verifyTimeout($_SESSION['email'], session_id(), true);
} else {
    // no email set in $_SESSION[] => simulate result unsuccessful to force timeout and login
    $result = [1, 0]; // simulate timeout detected
}
    
if ( $result[0] ) { // timeout detected
    // always set this route without a leading slash
    $oldRoute = 'dashboard';
    
    // this block ends with a exit command
    include('../src/gototimeout.php');
}
// *** END BLOCK ***

$headTitle = "Dashboard";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper pumpDaHeight" id="main"> 

        <!-- content area -->    
        <section id="content" class="wide-content">
            <h1>Dashboard</h1>
            <p>What would you like to do now ?</p>
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
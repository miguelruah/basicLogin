<?php
// although we have a timeout, we need to regain access to S_SESSION[]
// so we need to restart the session
session_start();

$errorMsg = '';

if ( isset($_POST['login-email']) && isset($_POST['login-password'])) {
    $email    = $_POST['login-email'];
    $password = $_POST['login-password'];
    
    // the login form was submitted and we have POSTed login credentials

    // create new instance of login class and verify login
    $login = new loginclass();


    
    // if the email that is trying to login is different from the email that was previously logged in
    //      => play safe and logout the previous user

    // redirect to the logout page
    header('Location: logout');
    exit;
        
    
    
    // check if login is valid
        $result = $login->verifyCredentials($email, $password);
        if ( $result[0] ) { // login is valid
        
        // 1. set session_last_operation = NOW in the database (reset the timeout)
        $login->updateLastOperation($email);

        // 2. prepare a form with all the POSTed values (except the login credentials, of course)
        // 3. force submit of this form to the route that originally called the timeout login form
        //          => take this calling route from $_SESSION['oldRoute']
        $includeLoginFormStyles = true;
        $headTitle = "Return from Timeout";
        include '../routing/views/header.php';

        print "    <!-- main content area -->\n
    <div class=\"wrapper\" id=\"main\">\n\n
        <h1>Timeout - please login again</h1>\n\n
        <!-- content area -->\n
        <section id=\"content\" class=\"wide-content\">\n
            <div class=\"login-page\">\n
                <div class=\"form\">\n
                    <form id=\"login-form\" class=\"login-form\" method=\"post\" action=\"".$_SESSION['oldRoute']."\">\n
                        <input id=\"login-email\" name=\"login-email\" type=\"text\" placeholder=\"email address\"/>\n
                        <input id=\"login-password\" name=\"login-password\" type=\"password\" placeholder=\"password\"/>\n
                        <a id=\"login-submit\" href=\"#\" class=\"buttonlink\">LOGIN</a>\n
                        <p class=\"error-message\">&nbsp;</p>\n\n";

    // if there were POSTed values and we know the original route that detected timeout
    //      => we need to save the original inputs as hidden inputs so the user doesn't have to retype again
    if ( isset( $_SESSION['jsonPOST'] ) ) {
        $posted = json_decode($_SESSION['jsonPOST']);
        foreach( $posted AS $key=>$value ) {
            if ( $key != 'login-email' && $key != 'login-password' ) {
                print "                        <input name=\"".$key."\" value=\"".$value."\" type=\"hidden\">\n";
            }
        }
    }
    
    print "                    </form>\n
                </div>\n
            </div>\n
        </section><!-- #end content area -->\n
    </div><!-- #end div #main .wrapper -->\n";


include '../routing/views/footer.php';
print "    <script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>\n";
print "    <script type=\"text/javascript\" src=\"js/script.js\"></script>\n";

print "    <script type=\"text/javascript\" defer src=\"js/flexslider/jquery.flexslider-min.js\"></script>\n

    <!-- fire ups - read this file!  -->\n
    <script type=\"text/javascript\" src=\"js/main.js\"></script>\n

// force submit\n
<script type=\"text/javascript\">\n
    $(document).ready(function(){\n
        $(\"#login-form\").submit();\n\n
    });
</script>\n\n
</body>\n
</html>";

// now reset $_SESSION['oldRoute'] and $_SESSION['jsonPOST'] so they won't be reused by mistake
$_SESSION['oldRoute'] = '';
$_SESSION['jsonPOST'] = '';

exit;
        

    } else {

        // if login is invalid => set $errorMsg and let the user type the credentials again
        // number of trials can be controlled by setting and incrementing $_SESSION('counter'), for example
        $errorMsg = "Login failed, please retry";
        
    }
    
}



// no POSTed login credentials => we just got here from a route that detected timeout
//      => we show the login form and let the user type the login credentials
//      => we print hidden inputs with all the previous POSTed values

$includeLoginFormStyles = true;
$headTitle = "Timeout";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper" id="main"> 

        <h1>Timeout - please login</h1>

        <!-- content area -->    
        <section id="content" class="wide-content">
            <div class="login-page">
                <div class="form">
                    <form id="login-form" class="login-form" method="post">
                        <input id="login-email" name="login-email" type="text" placeholder="email address"/>
                        <input id="login-password" name="login-password" type="password" placeholder="password"/>
                        <a id="login-submit" href="#" class="buttonlink">LOGIN</a>
                        <p>&nbsp;</p>
<?php
    // if there were POSTed values, we need to save them as hidden inputs so the user doesn't have to retype again
    if ( isset( $_SESSION['jsonPOST'] ) ) {
        $posted = json_decode($_SESSION['jsonPOST']);
        foreach( $posted AS $key=>$value ) {
            print "                        <input name=\"".$key."\" value=\"".$value."\" type=\"hidden\">\n";
        }
    }
?>
                    </form>
                    <div class="error-message-wrapper">
                        <p class="error-message"><?php if ( isset($errorMsg) && $errorMsg != '' ) {print $errorMsg;} ?></p>
                    </div>
                </div>
            </div>
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

// form validations
<script type="text/javascript">
    $(document).ready(function(){
        // $('.error-message').text("");
        $("#login-form").submit(function(event){ // validate login fields on submit

            // validate email
            if ( $("#login-email").val()=='' ) {
                event.preventDefault();
                $('.error-message').text("Empty email");
                $("#login-email").focus();
                return false;
            }

            // validate password
            if ( $("#login-password").val() == '' ) {
                event.preventDefault();
                $('.error-message').text("Empty password");
                $("#login-password").focus();
                return false;
            }
        })

    });
    
</script>

</body>
</html>

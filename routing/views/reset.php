<?php

// create a new instance of the login class
$login = new loginclass();

$errorMsg = '';
$userMsg = '';

if ( isset($_POST['reset-password']) ) {
    // user submitted the form => catch POSTed values and update database
    
    $result = $login->changePassword($_POST['reset-email'], $_POST['reset-password']);
    if ( $result[0] ) { // password was changed successfully
        $userMsg = "Your password was changed successfully.";
    } else {
        $userMsg = "Sorry, we could not change the password. Please contact the administrator.";
    }
    

} else if ( !isset($_GET['e']) || !isset($_GET['t']) ) {
    // URL doesn't include email or token or both => display error message
    $userMsg = "Sorry, we could not complete the password reset. Please contact the administrator.";
    
} else {
    // retrieve email and token from URL
    $email = $_GET['e'];
    $token = $_GET['t'];

    // now verify them in the database
    $result = $login->verifyPasswordResetToken($email, $token);
    
    if ( !$result[0] ) { // token mismatch or not valid => display error message
        $userMsg = "Sorry, we could not complete the password reset (error ".$result[1]."). If your token is too old, please click again on the \"Forgot Password\" link.";
    }
    
}

$includeLoginFormStyles = true;
$headTitle = "Change your password";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper" id="main"> 

        <h1>Change Your Password</h1>

        <!-- content area -->    
        <section id="content" class="wide-content pumpDaHeight">

                
<?php
if ( $userMsg != '' ) { // can't proceed with password change => display the reason
?>
            <div class="grid_12"><?php print $userMsg; ?></div>
<?php
} else {
?>
            <div class="login-page">
                <div class="form">
                    <form id="login-form" class="login-form" method="post" action="/reset">
                        <input id="reset-password" name="reset-password" type="password" placeholder="password"/>
                        <input id="reset-confirm" name="reset-confirm" type="password" placeholder="confirm password"/>
                        <input id="reset-email" name="reset-email" type="hidden" value="<?php print $email; ?>"/>
                        <a id="login-submit" href="#" class="buttonlink">CHANGE</a>
                        <p class="message">&nbsp;</p>
                        <p class="message">&nbsp;</p>
                    </form>
                    <div class="error-message-wrapper">
                        <p class="error-message"><?php if ( isset($errorMsg) && $errorMsg != '' ) {print $errorMsg;} ?></p>
                    </div>
                </div>
            </div>
<?php
}
?>
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

<!--form validations-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#login-form #reset-password').focus();
        $("#login-form").submit(function(event){ // validate fields on submit
            // validate password
            // result is an array with 1st element boolean and 2nd element the error message
            var result = validatePassword($("#reset-password").val());
            if ( ! result[0] ) {
                event.preventDefault();
                console.log("Error msg for password = "+result[1]);
                $('.error-message').text(result[1]);
                $("#reset-password").focus();
                return false;
            }
        
            // password and confirmed password must be equal
            if ( ! validateConfirm($("#reset-password").val(), $("#reset-confirm").val()) ) {
                event.preventDefault();
                console.log("Error msg for confirm = "+result[1]);
                $('.error-message').text("Password not confirmed");
                $("#reset-confirm").focus();
                return false;
            }
            return true;
        })

    });
    
    function validatePassword(value) {
        // password cannot be empty string
        if ( value=='' ) {console.log('password empty'); return [false,"Password is empty"];}
        
        // password is restricted to these chars
        if ( ! /^[A-Za-z0-9\d=!?\=-_|@$£€<>#%&]*$/.test(value) ) {console.log('character restriction'); return [false,"Illegal characters"];}
        
        // at least one lowercase letter
        if ( ! /[a-z]/.test(value) ) {console.log('one lowercase'); return [false,"Must have 1 lowercase"];}
        
        // at least one uppercase letter
        if ( ! /[A-Z]/.test(value) ) {console.log('one uppercase'); return [false,"Must have 1 uppercase"];}
        
        // at least one digit
        if ( ! /[0-9]/.test(value) ) {console.log('one digit'); return [false,"Must have 1 digit"];}
        
        // at least 8 characters
        if ( value.length < 8 ) {console.log('pwd length'); return [false,"Must be >= 8 chars"];}
        
        return [true, ''];
    }
    function validateConfirm(value1, value2) {
        // check they are equal
        if ( value1 != value2 ) {console.log('confirm mismatch'); return false;}
        
        return true;
    }
</script>

</body>
</html>
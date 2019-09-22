<?php
if ( isset($_POST['register-email']) || isset($_POST['login-email']) || isset($_POST['forgot-email']) ) {

    // create a new instance of the login class
    $login = new loginclass();

    // $result is an array
    // 1st element = boolean - true = success, false = errors
    // 2nd element = in case of error, this is the error code
    // 3rd element = if operation=login, this is the session token

    if ( isset($_POST['login-email']) ) {
        $result = $login->verifyCredentials($_POST['login-email'], $_POST['login-password']);
        if ( $result[0] ) { // login credentials were verified

            // create a new session in the database
            $result = $login->createSession($_POST['login-email']);

            if ( $result[0] ) { // session was created in the database
            
                // start a session using token created in loginclass->login()
                session_id($result[2]);
                session_start();

                // we need to save email to check timeout
                $_SESSION['email'] = $_POST['login-email'];

                header('Location: dashboard');
                exit;
                
            } else {
                $errorMsg = "Login failed, please retry";
            }
        } else {
            $errorMsg = "Login failed, please retry";
        }
    } else if ( isset($_POST['register-email']) ) {
        $result = $login->register($_POST['register-email'], $_POST['register-password']);
        print_r($result);
        if ( $result[0] ) { // registration was successful
            header('Location: register');
            exit;
        } else {
            $errorMsg = "Email exists, login or reset pwd";
        }
    } else if ( isset($_POST['forgot-email']) ) {
        $result = $login->forgot($_POST['forgot-email']);
        if ( !$result[0] ) fileLog(1, "Could not request password reset for: ".$_POST['forgot-email']." (error=".$result[1].")", 1, 1);
        header('Location: forgot'); // display feedback message
        exit;
    }


}

$includeLoginFormStyles = true;
$headTitle = "Register";
include '../routing/views/header.php';

?>
    <!-- main content area -->   
    <div class="wrapper" id="main"> 

        <h1>Login or Register</h1>

        <!-- content area -->    
        <section id="content" class="wide-content">
            <div class="login-page">
                <div class="form">
                    <form id="login-form" class="login-form" method="post" action="/login">
                        <input id="login-email" name="login-email" type="text" placeholder="email address"/>
                        <input id="login-password" name="login-password" type="password" placeholder="password"/>
                        <a id="login-submit" href="#" class="buttonlink">LOGIN</a>
                        <p class="message">Not registered? <a id="register" href="#">Create an account</a></p>
                        <p class="message">Forgot your password? <a id="forgot" href="#">Reset it</a></p>
                    </form>
                    <form id="register-form" class="register-form" method="post" action="/login" style="display:none;">
                        <input id="register-email" name="register-email" type="text" placeholder="email address"/>
                        <input id="register-password" name="register-password" type="password" placeholder="password"/>
                        <input id="register-confirm" name="register-confirm" type="password" placeholder="confirm password"/>
                        <a id="register-submit" href="#" class="buttonlink">REGISTER</a>
                        <p class="message">Already registered? <a id="login" href="#">Login</a></p>
                        <p class="message">Forgot your password? <a id="forgot" href="#">Reset it</a></p>
                    </form>
                    <form id="forgot-form" class="forgot-form" method="post" action="/login" style="display:none;">
                        <input id="forgot-email" name="forgot-email" type="text" placeholder="email address"/>
                        <a id="forgot-submit" href="#" class="buttonlink">RESET</a>
                        <p class="message">Already registered? <a id="login" href="#">Login</a></p>
                        <p class="message">Not registered? <a id="register" href="#">Create an account</a></p>
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
    $('#login-form #login-email').focus();
    $(document).ready(function(){
        // $('.error-message').text("");
        $("#register-form").submit(function(event){ // validate registration fields on submit

            // validate email
            if ( ! validateEmail($("#register-email").val()) ) {
                event.preventDefault();
                $('.error-message').text("Invalid email");
                $("#register-email").focus();
                return false;
            }

            // validate password
            // result is an array with 1st element boolean and 2nd element the error message
            var result = validatePassword($("#register-password").val());
            if ( ! result[0] ) {
                event.preventDefault();
                $('.error-message').text(result[1]);
                $("#register-password").focus();
                return false;
            }
        
            // password and confirmed password must be equal
            if ( ! validateConfirm($("#register-password").val(), $("#register-confirm").val()) ) {
                event.preventDefault();
                $('.error-message').text("Password not confirmed");
                $("#register-confirm").focus();
                return false;
            }
            return true;

        })

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
            return true;
        })

        $("#forgot-form").submit(function(event){ // validate forgot fields on submit

            // validate email
            if ( $("#forgot-email").val()=='' ) {
                event.preventDefault();
                $('.error-message').text("Empty email");
                $("#forgot-email").focus();
                return false;
            }
            return true;
        })
    });
    
    function validateEmail(value) {
        // email cannot be empty string
        if ( value=='' ) {console.log('email empty'); return false;}
        
        // check syntax is legal
        if ( ! /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/.test(value) ) {console.log('illegal syntax'); return false;}
        
        return true;
    }
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
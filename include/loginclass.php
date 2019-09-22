<?php
/**
 * This class manages everything pertaining login, passwords and sessions
 *
 * @author Miguel Ruah https://github.com/miguelruah
 */
class loginclass{
    // define pdo object
    private $pdo;

/**
 * This method initiates a database connection
 *
 * @author Miguel Ruah https://github.com/miguelruah
 */
    function __construct(){
        try {
            $this->pdo = new PDO( 'mysql:host='.$GLOBALS['host'].';dbname='.$GLOBALS['dbname'], $GLOBALS['dbuser'], $GLOBALS['dbpass'] );
        }
        catch(PDOException $e) {
            die("Error connecting to DB\nError: ".$e);
        }
    }


/**
 * This method verifies login credentials
 *
 * @param string    $email      email that identifies the user
 * @param string    $password   password (non-hashed)
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function verifyCredentials($email, $password){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT email, password FROM users WHERE email=? AND status=1");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['email']) ) { // email exists => check password

            if ( $this->verifyPassword( $password, $dbrow['password'] ) ) { // password matches the database

                $result = [1, 0]; // email found and login credentials are correct

            } else {

                $result = [0, 1]; // password mismatch

            }

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;
    }


/**
 * This method creates a session for a user
 *
 * @param string    $email      email that identifies the user
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function createSession($email){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT email, password FROM users WHERE email=? AND status=1");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['email']) ) { // email exists => create session

            // use session_create_id() to create session token
            $token = session_create_id();

            $stmt = $this->pdo->prepare("UPDATE users set dt_updated=?, session_token=?, session_last_operation=? WHERE email=?");
            $stmt->execute([date('Y-m-d H:i:s'), $token, date('Y-m-d H:i:s'), $email]);

            $result = [1, 0, $token];

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;
    }


/**
 * This method checks if the session is still valid (timeout)
 *
 * @param string    $email              email that identifies the user
 * @param string    $token              session token to be verified against the database
 * @param bool      $updateLastOperTime if true and there is no timeout => update session_last_operation to time()
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function verifyTimeout($email, $token, $updateLastOperTime = false){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT session_token, session_last_operation FROM users WHERE email=? AND status=1");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['session_token']) ) { // email exists => check token and timeout

            if ( $dbrow['session_token'] == $token ) { // session token matches the database
                
                // calculate time elapsed since last operation and convert from miliseconds to seconds
                $time = time();
                $dbtime = strtotime($dbrow['session_last_operation']);
                $timeElapsed = ( $time - $dbtime );
                
                if ( $timeElapsed > $GLOBALS['sessiontimeout'] ) { // check timout

                    $result = [1, 0]; // timeout => return true
    
                } else {
                    
                    $result = [0, 0]; // no timeout and no error code

                }

                // if requested, update session's last operation time
                $stmt = $this->pdo->prepare("UPDATE users set dt_updated=?, session_last_operation=? WHERE email=?");
                $stmt->execute([date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $email]);

            } else {

                $result = [0, 1]; // session token mismatch or user mismatch

            }

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;
    }


/**
 * prepares a password reset token in the database and sets it's validity
 *
 * @param string    $email              email that identifies the user
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function forgot($email){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT email, password FROM users WHERE email=? AND status=1");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['email']) ) { // email exists => create reset token and update database record

            // create token and update the database record
            $token = randomString( 20 );
            $stmt = $this->pdo->prepare("UPDATE users set dt_updated=?, reset_token=?, reset_token_validity=? WHERE email=?");
            $stmt->execute([date('Y-m-d H:i:s'), $token, date('Y-m-d H:i:s', time()+$GLOBALS['resetvalidity']*24*60*60), $email]);

            // prepare the reset link
            $stringURL = $GLOBALS['selfurl']."/reset?e=".$email."&t=".$token;
            
            // call mailer API and send the reset email
            $subject = 'Your request to reset your password at BasicLogin';
            $body  = "Someone requested a password reset by using your email.</br></br>";
            $body .= "If it was not you, simply ignore this email and nothing further will happen.</br></br>";
            $body .= "Otherwise, to complete the password reset process, please click on the link below and follow the instructions on the screen:</br></br>";
            $body .= "<a href=\"".$stringURL."\">".$stringURL."</a></br></br>";
            $body .= "Thank you, </br></br>The Basic Login team";
            $result = $this->callMailer($email, $subject, $body);
            
        } else { // email not found
            
            $result = [0, 1]; // email not found

        }
        return $result;
    }


/**
 * update session_last_operation to time()
 *
 * @param string    $email              email that identifies the user
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function updateLastOperation($email){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT email, password FROM users WHERE email=? AND status=1");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['email']) ) { // email exists => update session_last_operation

            // update the database record
            $stmt = $this->pdo->prepare("UPDATE users set dt_updated=?, session_last_operation=? WHERE email=?");
            $stmt->execute([date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), $email]);

            $result = [1, 0]; // email found and session_last_operation was updated

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;
    }


/**
 * delete session information in the database
 *
 * @param string    $email              email that identifies the user
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function logout($email){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT email, password FROM users WHERE email=? AND status=1");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['email']) ) { // email exists => logout

            // update the database record
            $stmt = $this->pdo->prepare("UPDATE users set dt_updated=?, session_token=NULL, session_last_operation=NULL WHERE email=?");
            $stmt->execute([date('Y-m-d H:i:s'), $email]);
            $stmt = $this->pdo->prepare("SELECT session_token, session_last_operation FROM users WHERE email=? AND status=1");
            $stmt->execute([$email]);
            $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);

            $result = [1, 0]; // session data was replaced with NULL in the database

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;
    }


/**
 * replace password in the database
 *
 * @param string    $email      email that identifies the user
 * @param string    $password   password (non-hashed)
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function changePassword($email, $password){
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email=?");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( isset($dbrow['email']) ) { // email exists

            // update the database record
            $stmt = $this->pdo->prepare("UPDATE users set dt_updated=?, password=?, reset_token=NULL, reset_token_validity=NULL WHERE email=?");
            $stmt->execute([date('Y-m-d H:i:s'), $this->hashPassword($password), $email]);

            $result = [1, 0]; // password was replaced

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;

    }


/**
 * verify password reset token and its validity in the database
 *
 * @param string    $email      email that identifies the user
 * @param string    $token      password reset token 
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function verifyPasswordResetToken($email, $token){
        // checks that the token is correct and valid

        $stmt = $this->pdo->prepare("SELECT email, reset_token, reset_token_validity FROM users WHERE email=?");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( isset($dbrow['email']) ) { // email exists

            $resetToken = $dbrow['reset_token'];
            $resetTokenValidity = strtotime($dbrow['reset_token_validity']);

            // verify token and validity
            if ( $resetToken==$token && $resetTokenValidity>time() ) {
                $result = [1, 0];
            } else {
                if ( $resetToken!=$token ) {
                    $result = [0, 3]; // token mismatch
                } else {
                    $result = [0, 4]; // token is too old
                }
            }

        } else { // email not found

            $result = [0, 2]; // email not found

        }
        return $result;

    }


/**
 * processes registration of a new user
 *
 * @param string    $email      email that identifies the user
 * @param string    $password   password (non-hashed)
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    public function register($email, $password){
        // check if email exists in database
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email=?");
        $stmt->execute([$email]);
        $dbrow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( isset($dbrow['email']) ) { // email exists => error
            $result = [0, 1]; // duplicate email
        } else { // ok to register
            // insert user into database
            $stmt = $this->pdo->prepare("INSERT INTO users (dt_updated, email, status, password) VALUES (?,?,?,?)");
            $outcome = $stmt->execute([date('Y-m-d H:i:s'), $email, 1, $this->hashPassword($password)]);
            if ( $outcome ) { // insert was successful
                $result = [1, 0];
            } else {
                $result = [0, $stmt->errorCode()]; // unknown error => pass on the error code (may be a text)
            }
        }
        return $result;
    }

/**
 * sends an email
 *
 * @param string    $email      email that identifies the user
 * @param string    $subject    email subject
 * @param string    $body       email body (html)
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    private function callMailer($email, $subject, $body) {
        $mailer = new mailerclass();
        $result = $mailer->sendMail($email, $subject, $body);
        return $result;
    }


/**
 * hashes a string
 *
 * @param string    $string     string to be hashed
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    private function hashPassword($string) {
        $result = password_hash($string, PASSWORD_BCRYPT);
        return $result;
    }


/**
 * verifies if a string corresponds to a hash
 *
 * @param string    $password  password from login form (non-hashed)
 * @param string    $hash      password from database (hashed)
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
    private function verifyPassword($password, $hash) {
        $result = password_verify($password, $hash);
        return $result;
    }
}
?>
<?php
    // restart the session
    session_start();

    // create a new instance of the login class
    $login = new loginclass();

    $result = $login->logout($_SESSION['email']);

    if ( ! $result[0] ) { // logout failed in the database - log error code and move on
        // 1st param is true to force the log even if config.php->verbose is set to false
        fileLog(true, 'There was an error logging out - error code was '.$result[1], true, true);
    }

    // destroy all sessions
    session_destroy();
    session_unset();
    $_SESSION = [];
    
    // redirect to the login page
    header('Location: login');
    exit;
    

?>
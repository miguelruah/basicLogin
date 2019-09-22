<?php
/**
 * Logs messages to a private log file => PHP must have write permission to that directory
 *
 * @param bool      $forceVerbose   when true => log message even if config.php=>verbose is false
 * @param string    $message        string to be written to log file
 * @param bool      $stampStart     when true => write intro header before message
 * @param bool      $stampEnd       when true => write suffix after message
 * 
 * @author Miguel Ruah <miguelruah@gmail.com>
 */
    function fileLog($forceVerbose, $message, $stampStart, $stampEnd) { // $stampStart + $stampEnd = booleans requiring to print prefix and suffix to the log (see below)
        // if forceVerbose is not forcing verbose and 
        // config.php->verbose is not true => don't allow debug logs
        if (! $forceVerbose && ! $GLOBALS['verbose']) {return;}

        $fh = fopen("../logs/log.txt", "a");

        // if required by $stampStart => print a prefix with date and time
        if ($stampStart) {fwrite($fh, date("Y/m/d H:i:s\n"));}

        fwrite($fh, $message);

        // if required by $stampEnd => print a suffix with 2 new lines
        if ($stampEnd) {fwrite($fh, "\n\n");}

        fclose($fh);
    }

    
    
/**
 * Creates a random string based on a set of characters
 *
 * @param  int       $length         desired length of output string
 * 
 * @return string    $randomString   random string
 * 
 * @author Miguel Ruah <miguelruah@gmail.com>
 */
    function randomString( $length=20 ) {
        $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?!#$%&=';
        $allowedCharsQuant = strlen($allowedChars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $allowedChars[rand(0, $allowedCharsQuant - 1)];
        }
        return $randomString;
    }

    
    
/**
 * encrypts a string with method AES-256-CBC
 *
 * @param  string    $string   string to be encrypted
 * 
 * @return string    $output   encrypted string
 * 
 * @author Miguel Ruah <miguelruah@gmail.com>
 */
    function stringEncrypt( $string ) {

        $output = false;

        $encrypt_method = "AES-256-CBC";

        $key = hash( 'sha256', $GLOBALS['cryptKey'] );
        $iv = substr( hash( 'sha256', $GLOBALS['cryptIv'] ), 0, 16 );

        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );

        return $output;
    }

    
    
/**
 * decrypts a string with method AES-256-CBC
 *
 * @param  string    $string   encrypted string
 * 
 * @return string    $output   decrypted string
 * 
 * @author Miguel Ruah <miguelruah@gmail.com>
 */
    function stringDecrypt( $string ) {
        $output = false;

        $encrypt_method = "AES-256-CBC";

        $key = hash( 'sha256', $GLOBALS['cryptKey'] );
        $iv = substr( hash( 'sha256', $GLOBALS['cryptIv'] ), 0, 16 );

        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );

        return $output;
    }
?>
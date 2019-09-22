<?php
// allow functions.php->fileLog() to write log data into \logs\log.txt
$GLOBALS['verbose'] = true;

// configure database access
$GLOBALS['host']   = '';    // example: 127.0.0.1
$GLOBALS['dbname'] = '';    // example: basiclogin
$GLOBALS['dbuser'] = '';    // example: admin
$GLOBALS['dbpass'] = '';    // example: V9xkVDpLBulN5365

// mail configuration
$GLOBALS['smtpserver'] = ''; // example: mail.company.com
$GLOBALS['user']       = ''; // example: johnsmith1234@company.com
$GLOBALS['username']   = ''; // example: John Smith
$GLOBALS['password']   = ''; // example: h9i7_t9&Bt8
$GLOBALS['port']       = ''; // example: 25
$GLOBALS['from']       = ''; // example: no-reply@company.com
$GLOBALS['fromname']   = ''; // example: The Company

// when sending a reset password email, it includes a link that points to this website
// => configure the URL
$GLOBALS['selfurl'] = ''; // example: https://company.com

// configure session timeout in seconds
$GLOBALS['sessiontimeout'] = 600; // example: 600 seconds = 10 minutes

// configure password reset token validity in days
$GLOBALS['resetvalidity'] = 2; // example: 2 days

// configure encrypt/decrypt key+iv (random strings for functions.php->stringEncrypt() and functions.php->stringDecrypt()
$GLOBALS['cryptKey'] = ''; // example: d98_yngmo87_4tncy84r
$GLOBALS['cryptIv']  = ''; // example: 8y74b3ty_984uv_98yuz

?>
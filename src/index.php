<?php

/**
 * This file requires the configuration (config.php), autoloader() and then processes the routes
 *
 * @author Miguel Ruah https://github.com/miguelruah
 */
require_once('./autoloader.php'); // include autoloader function
autoload();

// Grab the URI and break it apart
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

// Route it up!
switch ($request_uri[0]) {
    // home page
    case '':
    case '/':
    case '/home':
    case '/home/':
        require '../routing/views/home.php';
        break;
    // dashboard page
    case '/dashboard':
        require '../routing/views/dashboard.php';
        break;
    // reset password page
    case '/forgot':
        require '../routing/views/forgot.php';
        break;
    // login page
    case '/login':
        require '../routing/views/login.php';
        break;
    // logout page
    case '/logout':
        require '../routing/views/logout.php';
        break;
    // sample inner page
    case '/page2':
        require '../routing/views/sampleinnerpage.php';
        break;
    // register page
    case '/register':
        require '../routing/views/register.php';
        break;
    // reset password
    case '/reset':
        require '../routing/views/reset.php';
        break;
    // session info
    case '/session':
        require '../routing/views/session.php';
        break;
    // timeout login page
    case '/timeout':
        require '../routing/views/timeout.php';
        break;
    // anything else
    default:
        header('HTTP/1.0 404 Not Found');
        require '../routing/views/404.php';
        break;
}
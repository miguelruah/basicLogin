This file contains some quick notes, by topic.
To improve readability, please find separate installation instructions in install.txt (same folder as this one).



1) database and PHP versions
This project was generated in XAMPP 7.2.7, which includes 10.1.34-MariaDB and PHP 7.2.7.



2) frontend
I used the Simple Responsive Template from ProWebDesign.ro and added some forms and validations.
You can find it here: http://www.prowebdesign.ro/simple-responsive-template/



3) backend
Project includes:
    - a simple routing system in /src/index.php (confirm .htaccess is in the root folder);
    - the respective views (/routing/views/);
    - PHPmailer (already included for your comfort in /vendor;
    - the main class loginclass.php
    - phpDoc comments for each loginclass.php method


4) database
only includes the user table



5) special notes on loginclass.php
I tried as much as possible to respect SOLID principles (without being overly religious about it), so each method is very specific
You can change most settings in /config/config.php
On timeout, a form is displayed. For safety reasons, if the user logs in with a different email, the session is destroyed and the original login form is displayed.
On "Forgot my Password", an email is sent synchronously. So please wait 15-20 seconds before the result is displayed. To fix this, add a 2nd table for email requests and a cron job to process these requests.

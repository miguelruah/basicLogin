<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    /* Exception class. */
    require '../vendor/PHPMailer/src/Exception.php';

    /* The main PHPMailer class. */
    require '../vendor/PHPMailer/src/PHPMailer.php';

    /* SMTP class, needed if you want to use SMTP. */
    require '../vendor/PHPMailer/src/SMTP.php';

/**
 * This class uses mail setup in config.php and uses PHPMailer to send an email
 *
 * @author Miguel Ruah https://github.com/miguelruah
 */
    class mailerclass {
        
/**
 * This method sends a basic email (can be expanded to manage attachments and custom headers)
 *
 * @param string    $recipient   destination email 
 * @param string    $subject     mail subject
 * @param string    $body        html string to be used as the body of the email
 * 
 * @return array    $result     1st element is boolean success or failure, 2nd element is an error code
 * 
 * @author Miguel Ruah https://github.com/miguelruah
 */
        public function sendMail( $recipient, $subject, $body ) {

            // send email
            $mailer = new PHPMailer(true);
            try {
                $mailer->SMTPDebug = 0; // 0=mute, 1=echo errors and messages, 2=echo messages
                $mailer->isSMTP();

                $mailer->Host = $GLOBALS['smtpserver'];
                $mailer->SMTPAuth = true;
                $mailer->Username = $GLOBALS['user'];
                $mailer->Password = $GLOBALS['password'];
                $mailer->SMTPSecure = 'tls';
                $mailer->Port = $GLOBALS['port'];

                $mailer->setFrom($GLOBALS['from'], $GLOBALS['fromname']);
                $mailer->addAddress($recipient, $recipient);

                $mailer->isHTML(true);
                $mailer->Subject = $subject;
                $mailer->Body = $body;

                $mailer->send();
                $mailer->ClearAllRecipients();
                $result = [1, 0]; // success

            } catch (Exception $e) {
                $result = [0, $mailer->ErrorInfo]; // error
            }
            
            return $result;

        }
        
    }
    
?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';



//Create a new PHPMailer instance
$mail = new PHPMailer();


//Server settings
$mail->SMTPDebug = //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host = 'smtp.gmail.com';                             //Set the SMTP server to send through
$mail->SMTPAuth = true;                                     //Enable SMTP authentication
$mail->Username = 'emailAddress';               //SMTP username
$mail->Password = 'password';                             //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;//'ssl';//PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port = 587;                                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients

$mail->setFrom('fromEmail', 'Contact Us');
$mail->addAddress('toEmail');//, 'John Doe2);  //Add a recipient

//Content
$mail->isHTML(true);                                        //Set email format to HTML
/*
$mail->Subject = 'Here is the subject2';
$mail->Body = 'This is the HTML message body <b>in bold!</b>2';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients2';



//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
*/


//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
/*function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}*/
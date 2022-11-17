<?php include 'header.php'; ?>

<?php
require_once 'mail.php';

$emailStatus = "";

if(isset($_POST['submit']))
{
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail->Subject = $subject;
    $mail->Body = "<b>Name:</b> $name<br>"
            . "<b>Email:</b> $email <br><br>"
            . "<b>Message:</b> $message";


    //send the message, check for errors
    if (!$mail->send()) {
        $emailStatus = "Message failed to send";
    } else {
        $emailStatus = "Message sent!";
    }
}
?>



<div class="contactform">
    <center>
        <h2>Contact Us Form</h2>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="contactForm" method="post">
            
            <?php if($emailStatus != "") echo "$emailStatus<br><br>"; ?>
            <label>Name: </label> <input <input type="text" name="name" id="name" size="30" placeholder="enter name"><br><br>
            <label>Email: </label> <input <input type="email" name="email" id="email" size="30" placeholder="enter email"><br><br>
            <label>Subject: </label> <input <input type="text" name="subject" id="subject" size="30" placeholder="enter subject"><br><br>
            <label>Message: </label><textarea name="message" id="message" rows="3" cols="30" placeholder="type message here..."></textarea><br><br>
            <input type="SUBMIT" name="submit" value="Submit">
        </form>
    </center>
</div>

<?php include 'footer.php'; ?>
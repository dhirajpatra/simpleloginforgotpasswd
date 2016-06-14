<?php
//ini_set("SMTP", "aspmx.l.google.com");
//ini_set("sendmail_from", "dhiraj.patra@gmail.com");
require_once "dbconn.php";
require_once "class.phpmailer.php";

$email = $_POST['email'];

$sql = "select * from users where user_email='".$email."'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $size = 8;
        $password_to_send = chunk_split(substr(md5(time().rand(10000,99999)), 0, $size), 6, '');
        $password_to_save = md5($password_to_send);
    //echo $row['user_id'] . '<br />';
       $result->free();
        $sql = "update users set user_password = '".$password_to_save."' where user_id=".$row['user_id']."";
        $conn->query($sql);
    }
    
    // mail sending
    $mailsettings = array();
    
    $mailsettings['SMTP_HOST'] = 'mail.google.com';// AWS SMTP HOST
    $mailsettings['SMTP_USERNAME'] = 'username';//AWS SMTP USERNAME
    $mailsettings['SMTP_PASSWORD'] = 'password';//AWS SMTP PASSWORD
    $mailsettings['SMTP_PORT'] = 465;// AWS SMTP PORT

    $mailsettings['SES_FROM_EMAIL'] = 'noreply@closrr.com';
	
    $mailsettings = array("to_address" => $to, "from_address" => $mailsettings['SES_FROM_EMAIL'], "subject" => $subject, "body" => $body, "host" => $mailsettings['SMTP_HOST'], "port" => $mailsettings['SMTP_PORT'], "username" => $mailsettings['SMTP_USERNAME'], "password" => $mailsettings['SMTP_PASSWORD']);
	    
    $mail = new PHPMailer();
    $mail -> IsSMTP(true);
    // SMTP
    $mail -> SMTPAuth = true;
    // SMTP authentication
    $mail -> Mailer = "smtp";
    $mail -> Host = $mailsettings['host'];
    // Amazon SES
    $mail -> Port = $mailsettings['port'];
    // SMTP Port
    $mail -> Username = $mailsettings['username'];
    // SMTP  Username
    $mail -> Password = $mailsettings['password'];
    // SMTP Password
    $mail -> SetFrom($from, '');
    //$mail -> AddReplyTo($from, '');
    $mail -> Subject = $mailsettings['subject'];
    $mail -> MsgHTML($mailsettings['body']);
    $address = $mailsettings['to_address'];
    $mail -> AddAddress($address, $address);

    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
        // send ordinary mail
        mail($address, $subject, $body);
    } else {
      echo "Message sent!";
    }
    
    echo "Password updated and email sent"; exit;
}else{
    echo 'No user found <a href="index.html">Go back</a>';
}




?>
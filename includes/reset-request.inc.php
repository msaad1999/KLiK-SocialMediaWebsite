<?php

include 'email-server.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

if (isset($_POST['reset-request-submit']))
{
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    
    $url = $Domain . "/klik/create-new-pwd.php?selector=" . $selector . "&validator=" . bin2hex($token);
    
    $expires = date("U") + 1800;
    
    require 'dbh.inc.php';
    
    $userEmail = $_POST['email'];
    
    $sql = "delete from pwdReset where pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "sql error";
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }
    
    $sql = "insert into pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) "
            . "values (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "sql error";
        exit();
    }
    else
    {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    
    
        
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';  
    require '../PHPMailer/src/SMTP.php';
    
    // send the email (used PHPMailer since mail() does not send email on localhost in WIINDOWS
    
    $to = $userEmail;
    $subject = 'Reset Your Password';
    $message = '<p>We received a password reset request. The link to your password is below.'
            . 'if you did not make this request, you can ignore this email.</p></br>'
            . '<p>Here is your password reset link: </br>'
            . '<a href=""' . $url . '">' .  $url . '</a></p>';
    
            $mail = new PHPMailer(true);            
            
            try {
                $mail->isSMTP();                                      
                $mail->Host = 'smtp.gmail.com';                      
                $mail->SMTPAuth = true;                               
                $mail->Username = $SMTPuser;            
                $mail->Password = $SMTPpwd;  
                $mail->SMTPSecure = 'tls';                            
                $mail->Port = 587;                                   
                
                //Recipients
                $mail->setFrom($SMTPuser, $SMTPtitle);
                $mail->addAddress($to, $SMTPtitle);     

                //Content
                $mail->isHTML(true);                                  
                $mail->Subject = $subject;
                $mail->Body    = $message;
 
                $mail->send();
            } 
            catch (Exception $e) {
                echo '<h4 class="error">Message could not be sent. Mailer Error: '. $mail->ErrorInfo
                        .'</h4>';
            }
            
            header('Location: ../reset-pwd.php?reset=success');
}
else
{
    header("Location: ../index.php");
    exit();
}


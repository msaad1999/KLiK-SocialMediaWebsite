<?php

    session_start();
    define('TITLE',"Contact Us | KLiK");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    include 'includes/navbar.php';
?>  

<!DOCTYPE html>
<head>
	<title><?php echo TITLE; ?></title>
        
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/contact-util.css">
	<link rel="stylesheet" type="text/css" href="css/contact-main.css">
        
        <link rel="shortcut icon" href="img/logo.ico">
</head>
<body>

    
    <?php
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception; 
        
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';  
        require 'PHPMailer/src/SMTP.php';
        
        
        // check for header injection
        function has_header_injection($str){
            return preg_match('/[\r\n]/',$str);
        }
    
        if (isset($_POST['contact_submit'])){
            
            $name = trim($_POST['first-name']).' '.trim($_POST['last-name']);
            $email = trim($_POST['email']);
            $msg = $_POST['message'];
            
            
            // check if name / mail (fields) have header injection
            if (has_header_injection($name) || has_header_injection($email)){
                die(); // kill the script immediately
            }
            
            if (! $name || ! $email || ! $msg){
                echo '<h4 class="error">All Fields Required.</h4>'
                . '<a href="contact.php" class="button block">go back and try again</a>';
                exit;
            }
            
            
            
            // add the recipient email to a variable
            $to = "saad01.1999@gmail.com";
            
            // create a subject
            $subject = "$name sent you a message via your contact form";
            
            // create message
            $message = "<strong>Name:</strong> $name<br>" # \r\n is a line break
                    . "<strong>Email:</strong> <i>$email</i><br><br>"
                    . "<strong>Message:</strong><br><br>$msg";
            
            // check if subscribe checkbox was checked
            if (isset($_POST['subscribe'])){
                
                // add new line to message variable
                $message .= "<br><br><br>"
                        . "<strong>IMPORTANT:</strong> Please add <i>$email</i> "
                        . "to your mailing list.<br>";
            }
            
            // send the email (used PHPMailer since mail() does not send email on localhost in WIINDOWS
            $mail = new PHPMailer(true);            
            
            try {
                //Server settings
                //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
                
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'saad01.1999@gmail.com';                                // SMTP username
                $mail->Password = 'eldererajin Menji99';              // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                
                //Recipients
                $mail->setFrom($to, "Franklin's Fine Dining");
                $mail->addAddress('muhammadsaad.crytek@gmail.com', "Franklin's Fine Dining");     // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
 
                $mail->send();
            } 
            catch (Exception $e) {
                echo '<h4 class="error">Message could not be sent. Mailer Error: '. $mail->ErrorInfo
                        .'</h4>';
            }
        }
    ?>

	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="post" action="">
				<span class="contact100-form-title">
					Send Us A Message
				</span>

				<label class="label-input100" for="first-name">Tell us your name *</label>
				<div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="Type first name">
					<input id="first-name" class="input100" type="text" name="first-name" placeholder="First name">
					<span class="focus-input100"></span>
				</div>
				<div class="wrap-input100 rs2-wrap-input100 validate-input" data-validate="Type last name">
					<input class="input100" type="text" name="last-name" placeholder="Last name">
					<span class="focus-input100"></span>
				</div>

				<label class="label-input100" for="email">Enter your email *</label>
				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input id="email" class="input100" type="text" name="email" placeholder="Eg. example@email.com">
					<span class="focus-input100"></span>
				</div>
                                
                                <div class="checkbox-animated">
                                    <input id="checkbox_animated_1" type="checkbox" name="subscribe" value="subscribe">
                                    <label for="checkbox_animated_1">
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        Subscribe to Newsletter
                                    </label>
                                </div>

				<label class="label-input100" for="message">Message *</label>
				<div class="wrap-input100 validate-input" data-validate = "Message is required">
                                    <textarea id="message" class="input100" name="message" rows="8"
                                                  placeholder="Write us a message"></textarea>
					<span class="focus-input100"></span>
				</div>
                                
				<div class="container-contact100-form-btn">
                                    
                                    <input type="submit" class="contact100-form-btn" 
                                           name="contact_submit" value="Send Message">
                                    
				</div>
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('img/banner.png');">
				<div class="flex-w size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-map-marker"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							Address
						</span>

						<span class="txt2">
							Mada Center 8th floor, 379 Hudson St, New York, NY 10018 US
						</span>
					</div>
				</div>

				<div class="dis-flex size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-phone-handset"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							Lets Talk
						</span>

						<span class="txt3">
							+1 800 1236879
						</span>
					</div>
				</div>

				<div class="dis-flex size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-envelope"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							General Support
						</span>

						<span class="txt3">
							contact@example.com
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>

        
        
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/contact-main.js"></script>
    </body>
</html>

<?php

    session_start();
    define('TITLE',"Contact Us | KLiK");
    
    include 'includes/HTML-head.php';
    include 'includes/email-server.php';
?>  

	<link rel="stylesheet" type="text/css" href="css/contact-util.css">
	<link rel="stylesheet" type="text/css" href="css/contact-main.css">
</head>
    
<body>

    
    <?php
    
        if(isset($_SESSION['userId']))
        {
            include 'includes/navbar.php';
        }
        
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
            
            
            
            if(!isset($_SESSION['userId']))
            {
                $email = trim($_POST['email']);
                $name = trim($_POST['first-name']).' '.trim($_POST['last-name']);
            }
            else
            {
                $email = trim($_SESSION['emailUsers']);
                $name = 'User: '.$_SESSION['userUid'];
            }
            
            $msg = $_POST['message'];
            
            
            if (has_header_injection($name) || has_header_injection($email)){
                die(); 
            }
            
            if (! $name || ! $email || ! $msg){
                echo '<h4 class="error">All Fields Required.</h4>'
                . '<a href="contact.php" class="button block">go back and try again</a>';
                exit;
            }
            
            
            $to = $email;
            
            $subject = "$name sent you a message via your contact form";
            
            $message = "<strong>Name:</strong> $name<br>" 
                    . "<strong>Email:</strong> <i>$email</i><br><br>"
                    . "<strong>Message:</strong><br><br>$msg";
            
            if (isset($_POST['subscribe']))
            {
                $message .= "<br><br><br>"
                            . "<strong>IMPORTANT:</strong> Please add <i>$email</i> "
                            . "to your mailing list.<br>";
            }
            
            
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
                $mail->setFrom($to, $SMTPtitle);
                $mail->addAddress($SMTPuser, $SMTPtitle);     

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
        }
    ?>

	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="post" action="">
				<span class="contact100-form-title">
					Send Us A Message
				</span>

                                <?php 
                                    if(!isset($_SESSION['userId']))
                                    {
                                ?>
                            
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
                                
                                <?php
                                    }
                                ?>
				
                                
                                <div class="checkbox-animated my-4">
                                    <input id="checkbox_animated_1" type="checkbox" name="subscribe" value="subscribe">
                                    <label for="checkbox_animated_1">
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        Subscribe for Updates
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

			<div class="contact100-more flex-col-c-m" style="background-image: url('img/contact.jpg');">
				<div class="flex-w size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-map-marker"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							About Us
						</span>

						<span class="txt2">
                                                    University Students stumbling onto new ambitions<br>
                                                    NUST, Islamabad Pakistan
						</span>
					</div>
				</div>

				<div class="dis-flex size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-phone-handset"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							Star Our Work
						</span>

						<span class="txt3">
							github.com/msaad1999/KLiK--PHP-coded-Social-Media-Website
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
							klik.official.website@gmail.com
						</span>
					</div>
				</div>
                            <?php
                                if(!isset($_SESSION['userId']))
                                {
                                    echo '<a class="contact100-form-btn" href="login.php">Login Page</a>';
                                }
                            ?>
			</div>
		</div>
	</div>

        
        <?php include 'includes/footer.php'; ?>
        <script src="js/contact-main.js"></script>
	
<?php include 'includes/HTML-footer.php' ?>
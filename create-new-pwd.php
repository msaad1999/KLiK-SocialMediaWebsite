<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Reset Password | KLiK");
    
    include 'includes/HTML-head.php';
?>  

            <link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>
    
    <body style="background: url('img/cover2.png');">

   

        <main role="main" class="container mt-5">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
          <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
        <div class="lh-100">
          <h1 class="mb-0 text-white lh-100">Password Reset</h1>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm text-center">
        
        <h1 class="text-primary">Reset Your Password</h1>
        <p class="text-secondary">Create a new password to access your account</p>
        <br>
                    
        <?php
            $selector = $_GET['selector'];
            $validator = $_GET['validator'];

            if (empty($selector) || empty($validator))
            {
                echo "<h5 class='text-danger'>Could not validate your request!</h5>";
            }
            else
            {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator))
                {
        ?>

                    <form action="includes/reset-password.inc.php" method="post" id="contact-form">

                        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                        
                        <div class="form-row">
                            <div class="col">
                              <input class="form-control" type="password" name="pwd" placeholder="Enter a new password">
                            </div>
                            <div class="col">
                              <input class="form-control" type="password" name="pwd-repeat" placeholder="Confirm new password">
                            </div>
                        </div>
                        <br><br>
                        <div class="form-row">
                            <input class="btn btn-secondary btn-lg btn-block" type="submit" class="button next" name="reset-password-submit" 
                               value="Reset Password">
                        </div>
                        
                    </form>

        <?php
                }
            }
        ?>
        </div>
            
            <br><br>
            <div class="position-absolute login-icons text-center">
                <a  href="login.php">
                    <i class="fa fa-sign-in fa-2x social-icon" aria-hidden="true"></i>
                </a> 
                <a href="contact.php">
                    <i class="fa fa-envelope fa-2x social-icon" aria-hidden="true"></i>
                </a>
                <a href="contact.php">
                    <i class="fa fa-github fa-2x social-icon" aria-hidden="true"></i>
                </a>
            </div>
            
    </main>
        
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>

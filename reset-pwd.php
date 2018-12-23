<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Reset Password | KLiK");
    
    include 'includes/HTML-head.php';
?>  

	<link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>
    
    <body style="background: #f1f1f1">

        <?php include 'includes/navbar.php'; ?>
   

        <main role="main" class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
          <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
        <div class="lh-100">
          <h1 class="mb-0 text-white lh-100">Password Reset</h1>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded shadow-sm text-center">
        
        <h1 class="text-primary">Reset Your Password</h1>
        <p class="text-secondary">An email will be send to you with instructions on how to reset your password</p>
        <br>
          
        <?php
            if(isset($_GET['reset']))
            {
                if ($_GET['reset'] == 'success')
                {
                    echo '<h4 class="text-success">Check your email!</h4>';
                }
            }
        ?>
          
        <br><br><br>
        <form action="includes/reset-request.inc.php" method="post">
            
            <div class="form-row">
                <div class="col">
                  <input class="form-control" type="email" name="email" placeholder="Your Account Email">
                </div>
                <div class="col">
                  <input class="btn btn-secondary btn-block" type="submit" class="button next" name="reset-request-submit" 
                   value="Receive new password by email">
                </div>
            </div>

        </form>
        
        
      </div>
    </main>
        
        <?php include 'includes/footer.php'; ?>
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>

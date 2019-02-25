<?php

    session_start();
    define('TITLE',"KLiK"); 
    
    function strip_bad_chars( $input ){
        $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
        return $output;
    }
    
    if(isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
    
    include 'includes/HTML-head.php';
?>  
    </head>
    
    <body>


    <section id="cover">
        <div id="cover-caption">
            <div class="container">
                <div class="col-sm-10 offset-sm-1">
                    <img src='img/200.png'>
                    <h5 class="text-white">Spreading Ideas</h5>
                    <br>
                    <?php
                    
                        if(isset($_GET['error']))
                        {
                            if($_GET['error'] == 'emptyfields')
                            {
                                echo '<div class="alert alert-danger" role="alert">
                                        <strong>Error: </strong>Fill In All The Fields
                                      </div>';
                            }
                            else if($_GET['error'] == 'nouser')
                            {
                                echo '<div class="alert alert-danger" role="alert">
                                        <strong>Error: </strong>Username does not exist
                                      </div>';
                            }
                            else if ($_GET['error'] == 'wrongpwd')
                            {;
                                echo '<div class="alert alert-danger" role="alert">
                                        <strong>Error: </strong>Wrong password - 
                                         <a href="reset-pwd.php" class="alert-link">Forgot Password?</a>
                                      </div>';
                            }
                            else if ($_GET['error'] == 'sqlerror')
                            {
                                echo '<div class="alert alert-danger" role="alert">
                                        <strong>Error: </strong>Website error. Contact admin to have it fixed
                                      </div>';
                            }
                            
                        }
                        else if(isset($_GET['newpwd']))
                        {
                            if($_GET['newpwd'] == 'passwordupdated')
                            {
                                echo '<div class="alert alert-success" role="alert">
                                        <strong>Password Updated </strong>Login with your new password
                                      </div>';
                            }
                        }
                    ?>
                    <form method="post" action="includes/login.inc.php" class="form-inline justify-content-center">
                        <div class="form-group">
                            <label class="sr-only">Name</label>
                            <input type="text" id="name" name="mailuid"
                                   class="form-control form-control-lg mr-1" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label class="sr-only">Email</label>
                            <input type="password" id="password" name="pwd"
                                   class="form-control form-control-lg mr-1" placeholder="Password">
                        </div>
                        <input type="submit" class="btn btn-dark btn-lg mr-1" name="login-submit" value="Login">
                    </form>
                    <br><a href="signup.php" class="btn btn-light btn-lg mr-1">Signup</a>
                    
                    <br><br>
                    <div class="position-absolute login-icons">
                        <a href="contact.php">
                            <i class="fa fa-envelope fa-2x social-icon" aria-hidden="true"></i>
                        </a>
                        <a href="contact.php">
                            <i class="fa fa-github fa-2x social-icon" aria-hidden="true"></i>
                        </a>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>

        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>
    </body>
</html>
<?php

    session_start();
    include_once 'dbh.inc.php';
    define('TITLE',"KLiK");

    $companyName = "Franklin's Fine Dining";
    include 'includes/arrays.php';
    
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


    <section id="cover">
        <div id="cover-caption">
            <div class="container">
                <div class="col-sm-10 offset-sm-1">
                    <h1 class="display-3">KLiK</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio quibusdam quis, repudiandae reprehenderit doloremque fugiat molestias, corporis voluptas.</p>
                    
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
                        <input type="submit" class="btn btn-success btn-lg mr-1" name="login-submit" value="Login">
                    </form>
                    <br><a href="signup.php" class="btn btn-success btn-lg mr-1">Signup</a>
                </div>
            </div>
        </div>
    </section>


<?php include include 'includes/HTML-footer.php'; ?>

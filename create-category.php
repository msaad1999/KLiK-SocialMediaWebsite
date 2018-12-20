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
        <link rel="stylesheet" type="text/css" href="css/comp-creation.css">
        
        <link rel="shortcut icon" href="img/logo.ico">
</head>
<body>

    
    
    
    <div class="bg-contact2" style="background-image: url('img/banner.png');">
		<div class="container-contact2">
			<div class="wrap-contact2">
				<form class="contact2-form" method="post" action="includes/create-category.inc.php">
					<span class="contact2-form-title">
						Create Category
					</span>

                                        <span class="text-center">
                                        <?php
                                            if(isset($_GET['error']))
                                            {
                                                if($_GET['error'] == 'emptyfields')
                                                {
                                                    echo '<h5 class="text-danger">*Fill In All The Fields</h5>';
                                                }
                                                else if ($_GET['error'] == 'catnametaken')
                                                {
                                                    echo '<h5 class="text-danger">*A category with the given name already exists</h5>';
                                                }
                                                else if ($_GET['error'] == 'sqlerror')
                                                {
                                                    echo '<h5 class="text-danger">*Website Error: Contact admin to have the issue fixed</h5>';
                                                }
                                            }
                                            else if (isset($_GET['catcreation']) == 'success')
                                            {
                                                echo '<h5 class="text-success">*Category successfully created</h5>';
                                            }
                                        ?>
                                        </span>
                                    
					<div class="wrap-input2 validate-input" data-validate="Name is required">
						<input class="input2" type="text" name="cat_name">
						<span class="focus-input2" data-placeholder="Category Name"></span>
					</div>

					<div class="wrap-input2 validate-input" data-validate = "Description is required">
						<textarea class="input2" name="cat_description"></textarea>
						<span class="focus-input2" data-placeholder="Category Description"></span>
					</div>

					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn">
							<div class="contact2-form-bgbtn"></div>
                                                        <button class="contact2-form-btn" type="submit" name="create-cat">
								Add Category
                                                        </button>
                                                        
						</div>
					</div>
                                    <div class="text-center">
                                        <br><br><a class="btn btn-light btn-lg btn-block" href="categories.php">
                                            View Categories</a>
                                    </div>
				</form>
			</div>
		</div>
	</div>
    
    
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
        <script src="js/creation-main.js"></script>
    </body>
</html>

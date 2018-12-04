<?php 
    define('TITLE',"Home | Franklin's Fine Dining");
    include 'includes/header.php';
?>


<h1>Reset your password</h1>
<p>An email will be send to you with instructions on how to reset your password</p>

<?php

        if(isset($_GET['reset']))
        {
            if ($_GET['reset'] == 'success')
            {
                echo '<p class="open">Check your email!</p>';
            }
        }
    ?>

<form action="includes/reset-request.inc.php" method="post" id="contact-form">
   
    <input type="email" name="email" placeholder="your account email">
    <input type="submit" class="button next" name="reset-request-submit" 
           value="Receive new password by email">
    
</form>


<?php 
    include 'includes/footer.php';
?>
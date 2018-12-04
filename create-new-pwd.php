<?php 
    define('TITLE',"Home | Franklin's Fine Dining");
    include 'includes/header.php';
?>


<h1>Reset your password</h1>
<p>An email will be send to you with instructions on how to reset your password</p>

<?php
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
    
    if (empty($selector) || empty($validator))
    {
        echo "Could not validate your request!";
    }
    else
    {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator))
        {
            ?>

            <form action="includes/reset-password.inc.php" method="post" id="contact-form">
                
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                <input type="password" name="pwd" placeholder="Enter a new password">
                <input type="password" name="pwd-repeat" placeholder="Confirm new password">
                
                <input type="submit" class="button next" name="reset-password-submit" 
                       value="Reset password">
            </form>

<?php
        }
    }
?>


<?php 
    include 'includes/footer.php';
?>
SIGNUP PAGE:


<?php
    define('TITLE',"Signup | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id="contact">
    
    <hr>
    <h1>Signup</h1>
    <?php
    
        $userName = '';
        $email = '';
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
                $userName = $_GET['uid'];
                $email = $_GET['mail'];
            }
            else if ($_GET['error'] == 'invalidmailuid')
            {
                echo '<p class="closed">*Please enter a valid email and user name</p>';
            }
            else if ($_GET['error'] == 'invalidmail')
            {
                echo '<p class="closed">*Please enter a valid email</p>';
            }
            else if ($_GET['error'] == 'invaliduid')
            {
                echo '<p class="closed">*Please enter a valid user name</p>';
            }
            else if ($_GET['error'] == 'passwordcheck')
            {
                echo '<p class="closed">*Passwords donot match</p>';
            }
            else if ($_GET['error'] == 'usertaken')
            {
                echo '<p class="closed">*This User name is already taken</p>';
            }
            else if ($_GET['error'] == 'invalidimagetype')
            {
                echo '<p class="closed">*Invalid image type. Profile image must be a .jpg or .png file</p>';
            }
            else if ($_GET['error'] == 'imguploaderror')
            {
                echo '<p class="closed">*Image upload error</p>';
            }
            else if ($_GET['error'] == 'imgsizeexceeded')
            {
                echo '<p class="closed">*Image too large</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['signup']) == 'success')
        {
            echo '<p class="open">*Signup Successful. Please login from the Login menu on the right</p>';
        }
    ?>
    <form action="includes/signup.inc.php" method='post' id="contact-form" enctype="multipart/form-data">

        <em style="color: blue;">NOTE: Username cannot be changed later</em>
        <input type="text" id="name" name="uid" placeholder="Username" value=<?php echo $userName; ?>>
        <input type="email" id="email" name="mail" placeholder="email" value=<?php echo $email; ?>>
        <input type="password" id="pwd" name="pwd" placeholder="password">
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="repeat password">
        
        <h5>Profile Picture</h5>
        <div class="upload-btn-wrapper">
            <button class="btn">Upload a file</button>
            <input type="file" name='dp'>
        </div>
        
        <h5>Gender</h5>
        <label class="container" for="gender-m">Male
          <input type="radio" checked="checked" name="gender" value="m" id="gender-m">
          <span class="checkmark"></span>
        </label>
        <label class="container" for="gender-f">Female
          <input type="radio" name="gender" value="f" id="gender-f">
          <span class="checkmark"></span>
        </label>

        <h5>Optional</h5>
        <input type="text" id="f-name" name="f-name" placeholder="First Name" >
        <input type="text" id="l-name" name="l-name" placeholder="Last Name" >
        <input type="text" id="headline" name="headline" placeholder="Your Profile Headline">
        <textarea id="bio" name="bio" placeholder="What you want to tell people about yourself"></textarea>
        
        <input type="submit" class="button next" name="signup-submit" value="signup">
        
    </form>
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?> 









INBOX PAGE:

<?php

    define('TITLE',"Inbox | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: index.php");
    }
?>

    <center>
        <strong>Welcome <?php echo $_SESSION['userUid']; ?>  <a href="includes/logout.inc.php">logout</a></strong>
    </center>
     
    <div class="message-body">
        <div class="message-left">
            <ul>
                <?php
                
                $sql = "select * from users where idUsers != " . $_SESSION['userId'];
                $stmt = mysqli_stmt_init($conn);    

                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../categories.php?error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    echo "<table>"
                            . "<thead>"
                                . "<tr>"
                                    . "<th style='text-align: center'>User</th>"
                                    . "<th style='text-align: center'>Gender</th>"
                                    . "<th style='text-align: center'>Full Name</th>"
                                    . "<th style='text-align: center'>Email</th>";
                    if ($_SESSION['userLevel'] == 1)
                    {
                        echo '<th></th>';
                    }
                    echo         "</tr>"
                            . "</thead>"
                            . "<tbody>";

                    while ($row = mysqli_fetch_assoc($result))
                    {

                        echo "<tr>"
                                . "<td>"
                                . "<img id='userTh' id='userDp' src='./uploads/".$row['userImg']."'>"
                                    . "<a href='./message.php?id=".$row['idUsers']."'>".strtoupper($row['uidUsers'])."</a><br>";
                                if ($row['userLevel'] === 1)
                                {
                                    echo ' <b>[Admin]</b> ';
                                }
                        echo          '<br>'.$row['f_name'].' '.$row['l_name']."<br>"
                                    . $row['emailUsers']   
                                . "</td>"
                                . "<td>"
                                    . "<p style='text-align: center'>".strtoupper($row['gender'])."</p>"
                                . "</td>"
                                . "<td>"

                                . "</td>";
                        if ($_SESSION['userLevel'] == 1)
                        {
                            echo "<td>"
                                . "<a href='includes/delete-user.inc.php?user=".$row['idUsers']."' class='button previous'>Delete</a>"
                                . "</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</tbody> </table>";
                }
                
                ?>
            </ul>
        </div>
 
        <div class="message-right">
            <!-- display message -->
            <div class="display-message">
            <?php
            
                if(isset($_GET['id'])){
                    
                    $user_two = trim(mysqli_real_escape_string($conn, $_GET['id']));
                    
                    $sql = "select idUsers from users where idUsers = ? and idUsers != ?";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die("SQL error");
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "ss", $user_two, $_SESSION['userId']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);

                        $resultCheck = mysqli_stmt_num_rows($stmt);

                        if ($resultCheck === 0)
                        {
                            die("Invalid $_GET ID.");
                        }
                        else
                        {
                            $sql = "select * from conversation "
                                    . "where (user_one = ? AND user_two = ?) "
                                    . "or (user_one = ? AND user_two = ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql))
                            {
                                die("SQL error");
                            }
                            else
                            {
                                mysqli_stmt_bind_param($stmt, "ssss", $user_two, $_SESSION['userId'],
                                        $_SESSION['userId'], $user_two);
                                
                                mysqli_stmt_execute($stmt);
                                $conver = mysqli_stmt_get_result($stmt);
                                mysqli_stmt_store_result($stmt);

                                if (mysqli_num_rows($conver) > 0)
                                {
                                    $fetch = mysqli_fetch_assoc($conver);
                                    $conversation_id = $fetch['id'];
                                }
                                else
                                {
                                    $sql = "insert into conversation(user_one, user_two) "
                                            . "values (?,?)";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql))
                                    {
                                        die("SQL error");
                                    }
                                    else
                                    {
                                        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userId'], $user_two);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_store_result($stmt);

                                        $conversation_id = mysqli_insert_id($conn);
                                        
                                    }
                                }
                            }
                        }
                    }
                }else {
                    die("Click On the Person to start Chating.");
                }
            ?>
            </div>
            <!-- /display message -->
 
            <!-- send message -->
            <div class="send-message">
                <!-- store conversation_id, user_from, user_to so that we can send send this values to post_message_ajax.php -->
                <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                <input type="hidden" id="user_form" value="<?php echo base64_encode($_SESSION['userId']); ?>">
                <input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>">
                <div class="form-group">
                    <textarea class="form-control" id="message" placeholder="Enter Your Message"></textarea>
                </div>
                <button class=" btn-primary" id="reply">Reply</button> 
                <span id="error"></span>
            </div>
            <!-- / send message -->
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script> 

<?php include 'includes/footer.php'; ?> 
    
    
    
PROFILE.php:

<?php 
    define('TITLE',"My Profile | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
?>


<div style="text-align: center">
    <img id="userDp" src=<?php echo "./uploads/".$_SESSION['userImg']; ?> >
 
    <h1><?php echo strtoupper($_SESSION['userUid']); ?></h1>
    <hr>
</div>


<h3><?php echo strtoupper($_SESSION['f_name']) . " " . strtoupper($_SESSION['l_name']); ?></h3>                
<p>
<?php 
    if ($_SESSION['gender'] == 'm')
    {
        echo 'Male';
    }
    else if ($_SESSION['gender'] == 'f')
    {
        echo 'Female';
    }
?>
</p>

<h3><?php echo $_SESSION['headline']; ?></h3>
<p><?php echo $_SESSION['bio'];?></p> 



                
                
<?php include 'includes/footer.php'; ?> 



EDIT-PROFILE.PHP

<?php

    define(TITLE, "Edit Profile | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
    
?>
<div style="text-align: center">
    <img id="userDp" src=<?php echo "./uploads/".$_SESSION['userImg']; ?> >
 
    <h1><?php echo strtoupper($_SESSION['userUid']); ?></h1>
</div>


<?php
    
        $userName = '';
        $email = '';
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyemail')
            {
                echo '<p class="closed">*Profile email cannot be empty</p>';
                $email = $_GET['mail'];
            }
            else if ($_GET['error'] == 'invalidmail')
            {
                echo '<p class="closed">*Please enter a valid email</p>';
            }
            else if ($_GET['error'] == 'emptyoldpwd')
            {
                echo '<p class="closed">*You must enter the current password to change it</p>';
            }
            else if ($_GET['error'] == 'emptynewpwd')
            {
                echo '<p class="closed">*Please enter the new password</p>';
            }
            else if ($_GET['error'] == 'emptyreppwd')
            {
                echo '<p class="closed">*Please confirm new password</p>';
            }
            else if ($_GET['error'] == 'wrongpwd')
            {
                echo '<p class="closed">*Current password is wrong</p>';
            }
            else if ($_GET['error'] == 'samepwd')
            {
                echo '<p class="closed">*New password cannot be same as old password</p>';
            }
            else if ($_GET['error'] == 'passwordcheck')
            {
                echo '<p class="closed">*Confirmation password is not the same as the new password</p>';
            }
        }
        else if (isset($_GET['edit']) == 'success')
        {
            echo '<p class="open">*Profile Updated Successfully</p>';
        }
?>


<form action="includes/profileUpdate.inc.php" method='post' id="contact-form" enctype="multipart/form-data">

        <h5>Personal Information</h5>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="email" 
               value=<?php echo $_SESSION['emailUsers']; ?>><br>
        
        
        <label>Full Name</label>
        <input type="text" id="f-name" name="f-name" placeholder="First Name" 
               value=<?php echo $_SESSION['f_name']; ?>>
        <input type="text" id="l-name" name="l-name" placeholder="Last Name" 
               value=<?php echo $_SESSION['l_name']; ?>>
        
        <label class="container" for="gender-m">Male
          <input type="radio" name="gender" value="m" id="gender-m"
                 <?php if ($_SESSION['gender'] == 'm'){ ?> 
                 checked="checked"
                 <?php } ?>>
          <span class="checkmark"></span>
        </label>
        <label class="container" for="gender-f">Female
          <input type="radio" name="gender" value="f" id="gender-f"
                 <?php if ($_SESSION['gender'] == 'f'){ ?> 
                 checked="checked"
                 <?php } ?>>
          <span class="checkmark"></span>
        </label>
       
        <label for="headline">Profile Headline</label>
        <input type="text" id="headline" name="headline" placeholder="Your Profile Headline"
               value='<?php echo $_SESSION['headline']; ?>'><br>
        
        <label for="bio">Profile Bio</label>
        <textarea id="bio" name="bio" maxlength="5000"
            placeholder="What you want to tell people about yourself" 
            ><?php echo $_SESSION['bio']; ?></textarea>
        
        <h5>Change Password</h5>
        <input type="password" id="old-pwd" name="old-pwd" placeholder="current password"><br>
        <input type="password" id="pwd" name="pwd" placeholder="new password">
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="repeat new password">
        
        <h5>Profile Picture</h5>
        <div class="upload-btn-wrapper">
            <button class="btn">Upload a file</button>
            <input type="file" name='dp' value=<?php echo $_SESSION['userImg']; ?>>
        </div>
        
        <input type="submit" class="button next" name="update-profile" value="Update Profile">
        
    </form>

<hr>




<?php include 'includes/footer.php'; ?> 








CONTACT.PHP



<?php
    define('TITLE',"Menu | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id="contact">
    
    <hr>
    <h1>Contact Us!</h1>
    
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
            
            $name = trim($_POST['name']);
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
        
    ?>
    
    <!-- Show success message after email is sent -->
    <h5> Thanks for contacting Franklin's!</h5>
    <p>Please Allow 24 hours for a response</p>
    <p><a href='index.php' class='button block'>&laquo; Go To Home Page</a></p>
    
    
    <?php } else{ ?>
     
  
    
    <form method="post" action="" id="contact-form">
        
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
        
        <label for="message">Message</label>
        <textarea id="message" name="message"></textarea>
        
        <input type="checkbox" id="subscribe" name="subscribe" value="subscribe">
        <label for="subscribe">Subscribe to newsletter</label>
        
        <input type="submit" class="button next" name="contact_submit" value="Send Message">
        
    </form>
    
    <?php } ?>   
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?> 



    






POSTS.PHP


<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['topic']))
    {
        $topic = strip_bad_chars($_GET['topic']);
    }
?>

<?php

    if (isset($_POST['submit-reply']))
    {
        $content = $_POST['reply-content'];
        
        if (!empty($content))
        {
            $sql = "insert into posts(post_content, post_date, post_topic, post_by) "
                    . "values (?,now(),?,?)";
            $stmt = mysqli_stmt_init($conn);
            
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ".$_SERVER['REQUEST_URI']."&error=sqlerror");
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt, "sss", $content, $topic, $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
            }
        }
    }

?>


<hr>

<?php

    $sql = "select * from topics where topic_id=?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "sql error";
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $topic);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (!($row = mysqli_fetch_assoc($result)))
        {
            echo 'You need to re-submit your reset request';
            exit();
        }
        else 
        {
            $title = strtoupper($row['topic_subject']);
        }
    }

    $sql = "select * from posts p, users u "
            . "where p.post_topic=? "
            . "and p.post_by=u.idUsers "
            . "order by p.post_id;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../forum.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $topic);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                ."<col width='25%'>"
                ."<col width='75%'>"
                . "<thead>"
                    . "<tr>"
                        . "<th colspan='4' style='text-align: center'>".$title."</th>"
                    . "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            
        $voted_u = false;
        $voted_d = false;
        
        $sql = "select votePost, voteBy, vote from postvotes "
            . "where votePost=? "
            . "and voteBy=? "
            . "and vote=1";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ss", $row['post_id'], $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck == 0)
            {
                $voted_u = true;
            }
        }
        
        $sql = "select votePost, voteBy, vote from postvotes "
            . "where votePost=? "
            . "and voteBy=? "
            . "and vote=-1";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ss", $row['post_id'], $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck == 0)
            {
                $voted_d = true;
            }
        }
            
            echo "<tr>"
                    . "<td>"
                        . "<img id='userTh' src=./uploads/".$row['userImg'].">"
                        . "<p>".$row['uidUsers']."<br>"
                        . "<p>".$row['post_date']."</p>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['post_content']."</p>"
                    . "</td><td>"
                    . "<a ";
            
            if ($voted_u)
            {
                echo "href='includes/post-vote.inc.php?topic=".$topic."&post=".$row['post_id'].""
                    . "&vote=1' ";
            }
            
            echo "class='button previous'>Upvote</a><br>"
                    . $row['post_votes'] . "<br>"
                    . "<a ";
            
            if ($voted_d)
            {
                echo "href='includes/post-vote.inc.php?topic=".$topic."&post=".$row['post_id'].""
                    . "&vote=-1' ";
            }
            
            echo "class='button previous'>Downvote</a><br>";
            
            if ( ($row['post_by']==$_SESSION['userId']) || ($_SESSION['userLevel'] == 1))
            {
                echo "<a href='includes/delete-post.php?topic=".$topic."&post=".$row['post_id']."&by=".$row['post_by']."'"
                        . " class='button next'>Delete</a>";
            }
            echo "</td></tr>";
        }
        
        echo "</tbody> </table>";
    }
?>



<div id="contact">
    
    <?php
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
    ?>
    
    <h5>Reply</h5>
    <form method="post" id="contact-form"
          action="">

        <textarea name="reply-content" id="reply-content"></textarea>
        <input type="submit" value="Submit reply" class="button next" name="submit-reply">

    </form>
</div>


<hr>

<?php include 'includes/footer.php'; ?>






CREATE-CATEGORY.PHP


<?php
    define('TITLE',"Create Category | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
?>


<div id="contact">
    
    <h1>Create Category</h1>
    
    <?php
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
            }
            else if ($_GET['error'] == 'catnametaken')
            {
                echo '<p class="closed">*A category with the given name already exists</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['catcreation']) == 'success')
        {
            echo '<p class="open">*Category successfully created</p>';
        }
    ?>
    
    <form method="post" action="includes/create-category.inc.php" id="contact-form">
    
        <label for="cat_name">Category Name</label>
        <input type="text" name="cat_name" />

        <label for="cat_description">Category Description</label>
        <textarea name="cat_description" /></textarea>

        <input type="submit" value="Add category" class="button next" name="create-cat">
    
    </form>
    
    <a href="./categories.php" class="button previous">View Categories</a>
    
</div>




<?php include 'includes/footer.php'; ?>




CREATE-TOPIC.PHP



<?php
    define('TITLE',"Create Topic | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
?>


<div id="contact">
    <hr>

<?php
    $sql = "select cat_id, cat_name from categories;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../forum.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0)
        {
            echo "<p class='closed'>You cannot create a topic before the admin creates "
            . "some categories</p>";
        }
        else
        {
?>

    <h1>Create Topic</h1>
    
    <?php
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">*Fill In All The Fields</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">*Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['operation']) == 'success')
        {
            echo '<p class="open">*Topic successfully created</p>';
        }
    ?>

    <form method="post" action="includes/create-topic.inc.php" id="contact-form">
    
    <label for="topic-subject">Subject</label>
    <input type="text" id="topic-subject" name="topic-subject">
    
    <label>Category</label>
    <select name="topic-cat" id="topic-cat">
    <?php 
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<option value='.$row['cat_id'].'>' . $row['cat_name'] . '</option>';
        }
    ?>
    </select>
    
    <label for="post-content">Message:</label>
    <textarea id="post-content" name="post-content"></textarea>
    
    <input type="submit" value="Create Topic" class="button next" name="create-topic">
    
</form>
<a href="./topics.php" class="button previous">View Topics</a>

    
<?php
        }
    }
?>


    <hr>
</div>
<?php include 'includes/footer.php'; ?>




create-poll.php


<?php 
    define('TITLE',"Home | Franklin's Fine Dining");
    include 'includes/header.php';
?>


<h1>Create a Poll</h1>

<form id="contact-form" action="includes/create-poll.inc.php" method="post">
    
    <label for="title">Poll Title</label>
    <input type="text" name="title" id="title" placeholder="Add poll title"><br>
    
    <textarea id="desc" name="desc" placeholder="Optional Poll Description"></textarea>
    
    <label for="option">Poll Options</label>
    <div class="input_fields_wrap">
        <button class="add_field_button">Add More Fields</button>
        <div><input type="text" name="option[]" id="option" placeholder="poll option"><br>
        <input type="text" name="option[]" id="option" placeholder="poll option"></div>
    </div>
    
    <input type="checkbox" id="subscribe" name="is-locked" value="is-locked">
    <label for="subscribe">Make the Poll locked</label>
    <p>*The users will not be able to change their vote after casting it</p>
    
    <input type="submit" class="button next" name="poll-submit" value="Create Poll">
    
</form>

<a href="./poll-view.php" class="button previous">View Polls</a>


    <script>
        $(document).ready(function() {
            var max_fields      = 6; //maximum input boxes allowed
            var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                            x++; //text box increment
                            $(wrapper).append('<div><input type="text" name="option[]"\n\
                placeholder="poll option" id="option"><a href="#" class="remove_field">\n\Remove</a></div>'); //add input box
                    }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });
    </script>


<?php 
    include 'includes/footer.php';
?>

    
    
    
    
    
CATEGORIES.PHP



<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<hr>
<h1>Categories</h1>

<?php

    $sql = "select * from categories;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../categories.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th style='text-align: center'>Name</th>"
                        . "<th style='text-align: center'>Forums</th>"
                        . "<th style='text-align: center'>Description</th>";
        if ($_SESSION['userLevel'] == 1)
        {
            echo '<th></th>';
        }
        echo         "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            $sql2 = 'select * from topics where topic_cat=?';
            mysqli_stmt_prepare($stmt, $sql2);
            mysqli_stmt_bind_param($stmt, "s", $row['cat_id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            
            echo "<tr>"
                    . "<td>"
                        . "<a href='./topics.php?cat=".$row['cat_id']."'><p>".$row['cat_name']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p style='text-align: center'>".$num."</p>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['cat_description']."</p>"
                    . "</td>";
            if ($_SESSION['userLevel'] == 1)
            {
                echo "<td>"
                    . "<a href='includes/delete-category.php?id=".$row['cat_id']."' class='button previous'>Delete</a>"
                    . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody> </table>";
    }
    if ($_SESSION['userLevel'] == 1)
    {
        echo '<a href="./create-category.php" class="button previous">Create Category</a>';
    }
?>


<hr>

<?php include 'includes/footer.php'; ?>         



TOPICS.PHP



<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['cat']))
    {
        $cat = strip_bad_chars($_GET['cat']);
    }
?>

<hr>
<h1>Forums</h1>

<?php

    
    

    $sql = "select * from topics where topic_cat=?;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../forum.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $cat);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th>Forum</th>"
                        . "<th>Time Created</th>"
                    . "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>"
                    . "<td>"
                        . "<a href='posts.php?topic=".$row['topic_id']."'>"
                        . "<p>".$row['topic_subject']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['topic_date']."</p>"
                    . "</td>"
                . "</tr>";;
        }
        
        echo "</tbody> </table>";
    }

?>

<a href="./create-topic.php" class="button previous">Create a Forum</a><br>   
<a href="./categories.php" class="button previous">View Forum Categories</a>
<hr>

<?php include 'includes/footer.php'; ?>



POLL-VIEW.PHP



<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<hr>
<h1>Polls</h1>

<?php

    $sql = "select * from polls;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../poll-view.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th style='text-align: center'>Title</th>"
                        . "<th style='text-align: center'>Status</th>";
        if ($_SESSION['userLevel'] == 1)
        {
            echo '<th></th>';
        }
        echo         "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            $sql2 = 'select * from poll_votes where poll_id=?';
            mysqli_stmt_prepare($stmt, $sql2);
            mysqli_stmt_bind_param($stmt, "s", $row['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            
            echo "<tr>"
                    . "<td>"
                        . "<a href='./poll.php?poll=".$row['id']."'><p>".$row['subject']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p style='text-align: center'>".$num." user(s) have voted</p>"
                    . "</td>";
            if ($_SESSION['userLevel'] == 1)
            {
                echo "<td>"
                    . "<a href='includes/delete-poll.inc.php?pollid=".$row['id']
                        . "' class='button previous'>Delete</a>"
                    . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</tbody> </table>";
    }
    if ($_SESSION['userLevel'] == 1)
    {
        echo '<a href="./create-poll.php" class="button previous">Create a Poll</a>';
    }
?>


<hr>

<?php include 'includes/footer.php'; ?>




RESET-PWD.PHP


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




CREATE-NEW-PWD.php




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




CREATE-BLOG.PHP



<?php
    define('TITLE',"Create Blog | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id="contact">
    
    <hr>
    <h1>Create Blog</h1>
    <form action="includes/create-blog.inc.php" method='post' enctype="multipart/form-data">

        <input type="text" id="title" name="btitle" placeholder="Blog Title">
        <textarea id="content" name="bcontent" placeholder="Blog Content"></textarea>
        <h5>Blog Cover Image</h5>
        <div class="upload-btn-wrapper">
            <button class="btn">Upload a file</button>
            <input type="file" name='dp'>
        </div>
        <input type="submit" class="button next" name="create-blog-submit" value="Create Blog">
        
    </form>
    
    <a href="blogs.php" class="button previous">View all Blogs</a>
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?>




CREATE-EVENT.PHP    


<?php
    define('TITLE',"Add Event | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id="addevent">
    
    <hr>
    <h1>Add Event</h1>
    <form action="includes/create-event.inc.php" method='post' enctype="multipart/form-data">

        <input type="text" id="title" name="etitle" placeholder="Title">
        <input type="date" id="date" name="edate" placeholder="Date">
        <input type="text" id="headline" name="ehead" placeholder="Headline">
        <h5>Event Picture</h5>
        <div class="upload-btn-wrapper">
            <button class="btn">Upload a file</button>
            <input type="file" name='dp'>
        </div>
        <textarea id="description" name="edescription" placeholder="Description"></textarea>
        
        <input type="submit" class="button next" name="add-event-submit" value="Add Event">
        
    </form>
    
    <a href="./events.php" class="button previous">View Events</a>
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?> 


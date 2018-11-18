<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['topic']) && isset($_GET['title']))
    {
        $topic = strip_bad_chars($_GET['topic']);
        $title = $_GET['title'];
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
<h1>Post</h1>

<?php

    $sql = "select * from posts where post_topic=?;";
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
                . "<thead>"
                    . "<tr>"
                        . "<th colspan='2' style='text-align: center'>".$title."</th>"
                    . "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>"
                    . "<td>"
                        //. "<img id='userDp' src=./uploads/".$_SESSION['userImg'].">"
                        . "<p>".$row['post_date']."</p>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['post_content']."</p>"
                    . "</td>"
                . "</tr>";;
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

<!-- <a href="./create-topic.php" class="button previous">Create Topic</a><br>   
<a href="./categories.php" class="button previous">View Categories</a> -->
<hr>

<?php include 'includes/footer.php'; ?>
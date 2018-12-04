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
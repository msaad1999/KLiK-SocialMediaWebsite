<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['poll']))
    {
        $pollid = strip_bad_chars($_GET['poll']);
    }
?>

<hr>
<h1>Polls Votes</h1>

<?php

    $sql = "select * from poll_options where poll_id=?";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../poll-view.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $pollid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<h2>".$row['name']."</h2>";
            $sql2 = 'select u.uidUsers '
                    . 'from poll_votes v join users u '
                    . 'on v.vote_by = u.idUsers '
                    . 'where poll_id = ? '
                    . 'and poll_option_id = ?';
            $stmt = mysqli_stmt_init($conn); 
            mysqli_stmt_prepare($stmt, $sql2);
            mysqli_stmt_bind_param($stmt, "ss", $pollid, $row['id']);
            mysqli_stmt_execute($stmt);
            $result2 = mysqli_stmt_get_result($stmt);
            
            echo "<table>";
            while ($row2 = mysqli_fetch_assoc($result2))
            {
                echo "<tr><td><a href=''>".$row2['uidUsers']."<a></td></tr>";
            }
            echo "</table><br><br>";
        }
        echo '<a href="results.php?pollID=' . $pollid . '" class="button previous">Results</a><br>';
        echo '<a class="button previous" href="poll.php?poll=' . $pollid . '">Back To Poll</a> ';
        echo '<a href="./poll-view.php" class="button previous">View All Polls</a>';
    }
?>


<hr>

<?php include 'includes/footer.php'; ?>
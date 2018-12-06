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
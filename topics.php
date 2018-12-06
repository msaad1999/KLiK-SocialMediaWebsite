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
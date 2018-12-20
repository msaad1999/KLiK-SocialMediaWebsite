<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<hr>
<h1>Events</h1>

<?php

    $sql = "select * from events;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../events.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        echo "<table>"
                . "<thead>"
                    . "<tr>"
                        . "<th>Title</th>"
                        . "<th>Date</th>"
                    . "</tr>"
                . "</thead>"
                . "<tbody>";
        
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>"
                    . "<td>"
                        . "<a href='./event.php?event=".$row['event_id']."'><p>".$row['title']."</p></a>"
                    . "</td>"
                    . "<td>"
                        . "<p>".$row['event_date']."</p>"
                    . "</td>"
                . "</tr>";;
        }
        
        echo "</tbody> </table>";
    }

?>

<a href="./add_event.php" class="button previous">Add Event</a>
<hr>

<?php include 'includes/footer.php'; ?>
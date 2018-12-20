<?php
    define('TITLE',"Forum | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (isset($_GET['event']))
    {
        $event = strip_bad_chars($_GET['event']);
    }
?>

<hr>


<?php

    
    

    $sql = "select * from event_info where event=?;";
    $stmt = mysqli_stmt_init($conn);    
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../events.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $event);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $row = mysqli_fetch_assoc($result);
        echo "<h1>".$row['title']."</h1>";
        echo "<h2>".$row['headline']."</h2>"
           . "<h5>".$row['description']."</h5>";
    }

?>

<a href="./events.php" class="button previous">View Events</a>
<br>
<a href="./add_event.php" class="button previous">Add Another Event</a>
<hr>

<?php include 'includes/footer.php'; ?>
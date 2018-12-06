<?php

session_start();

if (isset($_GET['pollid']) && isset($_SESSION['userId']) && ($_SESSION['userLevel'] == 1))
{
    
    require 'dbh.inc.php';
    
    $poll = $_GET['pollid'];
    
    $sql = "delete from polls where id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../poll-view.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $poll);
        mysqli_stmt_execute($stmt);
        header("Location: ../poll-view.php");
        exit();
    }
    
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../poll-view.php");
    exit();
}
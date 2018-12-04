<?php

session_start();

if (isset($_GET['topic']) && isset($_GET['post']) && ($_GET['by'] == $_SESSION['userId']) 
        && isset($_SESSION['userId']))
{
    
    require 'dbh.inc.php';
    
    $post = $_GET['post'];
    $topic = $_GET['topic'];
    
    $sql = "delete from posts where post_id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $post);
        mysqli_stmt_execute($stmt);
        header("Location: ../posts.php?topic=".$topic);
        exit();
    }
    
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../posts.php?topic=".$topic);
    exit();
}
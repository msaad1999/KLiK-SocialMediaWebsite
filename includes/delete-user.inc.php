<?php

session_start();

if (isset($_GET['user']) && isset($_SESSION['userId']) && ($_SESSION['userLevel'] == 1))
{
    
    require 'dbh.inc.php';
    
    $user = $_GET['user'];
    
    $sql = "delete from users where idUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../users-view.php?error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        header("Location: ../users-view.php?deletion=success");
        exit();
    }
    
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../users-view.php");
    exit();
}
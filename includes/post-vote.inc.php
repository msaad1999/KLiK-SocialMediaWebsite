<?php

session_start();

if (isset($_GET['topic']) && isset($_GET['post']) && isset($_GET['vote']) 
        && isset($_SESSION['userId']))
{
    require 'dbh.inc.php';
    
    $post = $_GET['post'];
    $topic = $_GET['topic'];
    $vote = $_GET['vote'];
    
        $sql = "select votePost, voteBy, vote from postvotes "
            . "where votePost=? "
            . "and voteBy=? "
            . "and vote=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "sss", $post, $_SESSION['userId'], $vote);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                header("Location: ../posts.php?topic=".$topic."&error=voteexists");
                exit();
            }
        }
        
        $sql = "select votePost, voteBy from postvotes "
            . "where votePost=? "
            . "and voteBy=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ss", $post, $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                $sql = "update postvotes "
                        . "set vote=?, "
                        . "voteDate = now() "
                        . "where votePost=? "
                        . "and voteBy=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "sss", $vote, $post, $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    
                    header("Location: ../posts.php?topic=".$topic."&vote=".$vote."&votepost=".$post."&voteby=".$_SESSION['userId']);
                    
                    exit();
                }
            }
        }
    
    $sql = "insert into postvotes (votePost, voteBy, voteDate, vote) "
            . "values (?,?,now(),?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "sss", $post, $_SESSION['userId'], $vote);
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
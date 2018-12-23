<?php

session_start();

if (isset($_GET['blog']) && isset($_SESSION['userId']))
{
        require 'dbh.inc.php';
    
        $blog = $_GET['blog'];
    
        $sql = "select * from blogvotes  
                where voteBlog = ? 
                and voteBy = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../blog-page.php?id=".$blog."&error=sqlerror1");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ss", $blog, $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                $sql = "delete from blogvotes
                        where voteBlog = ?
                        and voteBy = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../blog-page.php?id=".$blog."&error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ss", $blog, $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    
                    header("Location: ../blog-page.php?id=".$blog);
                    exit();
                }
            }
            else
            {
                $sql = "insert into blogvotes (voteBlog, voteBy, voteDate, vote)
                        values (?,?,now(),1)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../blog-page.php?id=".$blog."&error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ss", $blog, $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    
                    header("Location: ../blog-page.php?id=".$blog);
                    exit();
                }
            }
        }
}

else
{
    header("Location: ../blog-page.php?id=".$blog."&error");
    exit();
}
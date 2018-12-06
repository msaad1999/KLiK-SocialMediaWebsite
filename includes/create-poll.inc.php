<?php

session_start();

if (isset($_POST['poll-submit']) && isset($_SESSION['userId']) && ($_SESSION['userLevel'] == 1))
{
    
    require 'dbh.inc.php';
    
    
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $options = $_POST["option"];
    if (isset($_POST['is-locked']))
    {
        $locked = 1;
    }
    else
    {
        $locked = 0;
    }
    
    if (empty($title) || empty($options[0]) || empty($options[1]))
    {
        header("Location: ../create-poll.php?error=emptyfields");
        exit();
    }
    else
    {
        $sql = "select subject from polls where subject=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $title);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                header("Location: ../create-poll.php?error=titletaken");
                exit();
            }
            else
            { 
                $sql = "insert into polls(subject, created, modified, status, created_by, "
                        . "poll_desc, locked) "
                        . "values (?,now(),now(),1,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../create-poll.php?error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ssss", $title, $_SESSION['userId'], $desc, $locked);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    
                    $id = mysqli_insert_id($conn);
                    
                    for ($i=0; $i < sizeof($options); $i++)
                    {
                        $sql = "insert into poll_options (poll_id, name, created, modified, status) "
                                . "values (?,?,now(),now(),1)";
                        $stmt = mysqli_stmt_init($conn);
                        
                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            header("Location: ../create-poll.php?error=sqlerror&");
                            exit();
                        }
                        else
                        {
                            mysqli_stmt_bind_param($stmt, "ss", $id, $options[$i]);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                        }
                    }
                    header("Location: ../create-poll.php?creation=success");
                    exit();
                }
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../create-poll.php");
    exit();
}
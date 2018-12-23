<?php


if (isset($_POST['add-event-submit']))
{
    
    require 'dbh.inc.php';
    session_start();
    
    $title = $_POST['etitle'];
    $date = $_POST['edate'];
    $headline = $_POST['ehead'];
    $description  = $_POST['edescription'];
    
    if (empty($title) || empty($date) || empty($headline) || empty($description))
    {
        header("Location: ../create-event.php?error=emptyfields");
        exit();
    }
    else
    {
        // checking if a user already exists with the given username
        $sql = "select title from events where title=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../create-event.php?error=sqlerror");
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
                header("Location: ../create-event.php?error=eventtaken");
                exit();
            }
            else
            {         
                $FileNameNew = 'event-cover.png';
                require 'upload.inc.php';
                
                $sql = "insert into events(event_by, title, event_date, date_created, event_image) "
                        . "values (?,?,?,now(),?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../create-event.php?error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['userId'], $title, $date, $FileNameNew);
                    
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    $id = mysqli_insert_id($conn);
                         //echo $description . ' ' . $title . ' ' . $headline . ' ' . $id;
                    //exit();               
                    $sql = "insert into event_info(event, title, headline, description)"
                        . "values (?,?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    
                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        header("Location: ../create-event.php?error=sqlerror");
                        exit();
                    }
                    else
                    {                   
                        mysqli_stmt_bind_param($stmt, "ssss", $id, $title, $headline, $description);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        
                        header("Location: ../create-event.php?creation=success");
                        exit();
                    }                          
                }
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../create-event.php");
    exit();
}
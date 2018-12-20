<?php

if (isset($_POST['reset-password-submit']))
{
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];
    
    if (empty($selector) || empty($validator) || empty($password) || empty($passwordRepeat))
    {
        header("Location: ../create-new-pwd.php?newpwd=empty");
        exit();
    }
    else if ($password != $passwordRepeat)
    {
        header("Location: ../create-new-pwd.php?newpwd=pwdnotsame");
        exit();
    }
    
    $currentDate = date("U");
    
    require 'dbh.inc.php';
    
    $sql = 'select * from pwdReset where pwdResetSelector=? and pwdResetExpires>='.$currentDate;
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "sql error";
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        
        
        if (!($row = mysqli_fetch_assoc($results)))
        {
            echo 'You need to re-submit your reset request';
            exit();
        }
        else 
        {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);
            
            if ($tokenCheck === false)
            {
                echo 'You need to re-submit your reset request';
                exit();
            }
            else if ($tokenCheck === true)
            {
                $tokenEmail = $row['pwdResetEmail'];
                
                $sql = 'select * from users where emailUsers=?;';
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    echo "sql error";
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($results))
                    {
                        echo 'There was an error';
                        exit();
                    }
                    else
                    {
                        $sql = 'update users set pwdUsers=? where emailUsers=?';
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            echo "sql error";
                            exit();
                        }
                        else
                        {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);
                            
                            $sql = 'delete from pwdReset where pwdResetEmail=?';
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql))
                            {
                                echo "sql error";
                                exit();
                            }
                            else
                            {
                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                
                                //update the index page to show a msg for this 
                                header ('Location: ../login.php?newpwd=passwordupdated');
                            }
                        }
                    }
                }
            }
        }
    }
    
    
}
else
{
    header("Location: ../index.php");
    exit();
}
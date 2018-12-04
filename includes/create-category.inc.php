<?php

session_start();

if (isset($_POST['create-cat']) && ($_SESSION['userLevel'] == 1))
{
    
    require 'dbh.inc.php';
    
    
    $catName = $_POST['cat_name'];
    $catDesc = $_POST['cat_description'];
    
    if (empty($catName) || empty($catDesc))
    {
        header("Location: ../create-category.php?error=emptyfields");
        exit();
    }
    else
    {
        // checking if a category already exists with the given name
        $sql = "select cat_name from categories where cat_name=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../create-category.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $catName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                header("Location: ../create-category.php?error=catnametaken");
                exit();
            }
            else
            {  
                $sql = "insert into categories(cat_name, cat_description) "
                        . "values (?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../create-category.php?error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ss", $catName, $catDesc);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    
                    header("Location: ../create-category.php?catcreation=success");
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
    header("Location: ../create-category.php?");
    exit();
}